<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Occurrences_model extends App_Model
{
  public function __construct()
  {
    parent::__construct();
  }

  /**
   * Get all occurrences
   * @return array
   */
  public function get_all_occurrences()
  {
    $this->db->select('o.*, p.name as post_name, s.firstname, s.lastname');
    $this->db->from(db_prefix() . 'regulation_occurrences o');
    $this->db->join(db_prefix() . 'regulation_posts p', 'p.id = o.post_id', 'left');
    $this->db->join(db_prefix() . 'staff s', 's.staffid = o.created_by', 'left');
    $this->db->order_by('o.occurrence_datetime', 'desc');

    return $this->db->get()->result_array();
  }

  /**
   * Get occurrence by ID
   * @param  integer $id
   * @return array
   */
  public function get_occurrence($id)
  {
    $this->db->select('o.*, p.name as post_name');
    $this->db->from(db_prefix() . 'regulation_occurrences o');
    $this->db->join(db_prefix() . 'regulation_posts p', 'p.id = o.post_id', 'left');
    $this->db->where('o.id', $id);
    return $this->db->get()->row_array();
  }

  /**
   * Add new occurrence
   * @param array $data occurrence data
   */
  public function add($data)
  {
    // Validate post_id exists
    $this->db->where('id', $data['post_id']);
    $post = $this->db->get(db_prefix() . 'regulation_posts')->row();
    if (!$post) {
      throw new Exception("Invalid post selected");
    }

    $data['created_by'] = get_staff_user_id();
    $data['created_at'] = date('Y-m-d H:i:s');

    // Convert arrays to JSON if they exist
    if (isset($data['involved_staff']) && is_array($data['involved_staff'])) {
      $data['involved_staff'] = json_encode($data['involved_staff']);
    }
    if (isset($data['involved_equipment']) && is_array($data['involved_equipment'])) {
      $data['involved_equipment'] = json_encode($data['involved_equipment']);
    }

    $this->db->insert(db_prefix() . 'regulation_occurrences', $data);
    $insert_id = $this->db->insert_id();

    if ($insert_id) {
      log_activity('New Occurrence Added [ID: ' . $insert_id . ']');
      return $insert_id;
    }

    return false;
  }

  /**
   * Update occurrence
   * @param  array $data occurrence data
   * @param  mixed $id   occurrence id
   * @return boolean
   */
  public function update($data, $id)
  {
    // Convert involved staff and equipment arrays to JSON if present
    if (isset($data['involved_staff']) && is_array($data['involved_staff'])) {
      $data['involved_staff'] = json_encode($data['involved_staff']);
    }
    if (isset($data['involved_equipment']) && is_array($data['involved_equipment'])) {
      $data['involved_equipment'] = json_encode($data['involved_equipment']);
    }

    $this->db->where('id', $id);
    $this->db->update(db_prefix() . 'regulation_occurrences', $data);

    if ($this->db->affected_rows() > 0) {
      // Handle file uploads if any
      $this->handle_attachments($id);
      log_activity('Occurrence Updated [ID: ' . $id . ']');
      return true;
    }

    return false;
  }

  /**
   * Delete occurrence
   * @param  mixed $id occurrence id
   * @return boolean
   */
  public function delete($id)
  {
    // Delete attachments first
    $this->delete_attachments($id);

    $this->db->where('id', $id);
    $this->db->delete(db_prefix() . 'regulation_occurrences');

    if ($this->db->affected_rows() > 0) {
      log_activity('Occurrence Deleted [ID: ' . $id . ']');
      return true;
    }

    return false;
  }

  /**
   * Get all posts for dropdown
   * @return array
   */
  public function get_posts()
  {
    $this->db->where('status', 'active');
    return $this->db->get(db_prefix() . 'regulation_posts')->result_array();
  }

  /**
   * Get all staff members for dropdown
   * @return array
   */
  public function get_staff_members()
  {
    $this->db->select('staffid, CONCAT(firstname, " ", lastname) as full_name');
    $this->db->from(db_prefix() . 'staff');
    $this->db->where('active', 1);
    return $this->db->get()->result_array();
  }

  private function handle_attachments($occurrence_id)
  {
    if (isset($_FILES['attachments']) && !empty($_FILES['attachments']['name'])) {
      $path = get_upload_path_by_type('occurrences') . $occurrence_id . '/';

      // Create directory if it doesn't exist
      if (!is_dir($path)) {
        mkdir($path, 0755, true);
      }

      for ($i = 0; $i < count($_FILES['attachments']['name']); $i++) {
        if ($_FILES['attachments']['error'][$i] == 0) {
          $filename = unique_filename($path, $_FILES['attachments']['name'][$i]);
          $newFilePath = $path . $filename;

          if (move_uploaded_file($_FILES['attachments']['tmp_name'][$i], $newFilePath)) {
            $attachment_data = [
              'occurrence_id' => $occurrence_id,
              'file_name' => $filename,
              'filetype' => $_FILES['attachments']['type'][$i],
              'dateadded' => date('Y-m-d H:i:s'),
              'added_by' => get_staff_user_id()
            ];
            $this->db->insert(db_prefix() . 'regulation_occurrence_attachments', $attachment_data);
          }
        }
      }
    }
  }

  public function get_attachments($occurrence_id)
  {
    $this->db->where('occurrence_id', $occurrence_id);
    return $this->db->get(db_prefix() . 'regulation_occurrence_attachments')->result_array();
  }

  private function delete_attachments($occurrence_id)
  {
    $attachments = $this->get_attachments($occurrence_id);
    $path = get_upload_path_by_type('occurrences') . $occurrence_id . '/';

    foreach ($attachments as $attachment) {
      if (file_exists($path . $attachment['file_name'])) {
        unlink($path . $attachment['file_name']);
      }
    }

    if (is_dir($path)) {
      rmdir($path);
    }

    $this->db->where('occurrence_id', $occurrence_id);
    $this->db->delete(db_prefix() . 'regulation_occurrence_attachments');
  }
}