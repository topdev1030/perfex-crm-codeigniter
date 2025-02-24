<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Weapons_model extends App_Model
{
  public function __construct()
  {
    parent::__construct();
  }

  public function get($id = '')
  {
    if ($id) {
      $this->db->where('id', $id);
      $result = $this->db->get(db_prefix() . 'regulation_weapons')->row();
      // print_r($result); // Debugging
      return $result;
    }
    $result = $this->db->get(db_prefix() . 'regulation_weapons')->result_array();
    // print_r($result); // Debugging
    return $result;
  }

  public function add($data)
  {
    // Remove id if it exists in data array
    unset($data['id']);

    // Handle null values for foreign keys
    if (empty($data['assigned_to'])) {
      $data['assigned_to'] = null;
      $data['assigned_date'] = null;
    }

    // Add created info
    $data['created_by'] = get_staff_user_id();
    $data['created_at'] = date('Y-m-d H:i:s');

    // Insert the data
    $this->db->insert(db_prefix() . 'regulation_weapons', $data);
    $insert_id = $this->db->insert_id();

    if ($insert_id) {
      log_activity('New Weapon Added [ID: ' . $insert_id . ']');
      return $insert_id;
    }

    return false;
  }

  public function update($data, $id)
  {
    // Remove id from data array
    unset($data['id']);

    // Handle null values for foreign keys
    if (empty($data['assigned_to'])) {
      $data['assigned_to'] = null;
      $data['assigned_date'] = null;
    }

    // Update timestamp
    $data['updated_at'] = date('Y-m-d H:i:s');

    $this->db->where('id', $id);
    $this->db->update(db_prefix() . 'regulation_weapons', $data);

    if ($this->db->affected_rows() > 0) {
      log_activity('Weapon Updated [ID: ' . $id . ']');
      return true;
    }

    return false;
  }

  public function delete($id)
  {
    $this->db->where('id', $id);
    $this->db->delete(db_prefix() . 'regulation_weapons');

    if ($this->db->affected_rows() > 0) {
      log_activity('Weapon Deleted [ID: ' . $id . ']');
      return true;
    }

    return false;
  }
}