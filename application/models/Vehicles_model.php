<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Vehicles_model extends App_Model
{
  public function __construct()
  {
    parent::__construct();
  }

  /**
   * Get all security vehicles
   * @return array
   */
  public function get_all_vehicles()
  {
    $this->db->select('tblfixedassets.*, tblregulation_item_post_links.post_id, tblregulation_posts.name as post_name');
    $this->db->from('tblfixedassets');
    $this->db->join('tblregulation_item_post_links', 'tblfixedassets.id = tblregulation_item_post_links.item_id AND tblregulation_item_post_links.item_type = "vehicle" AND tblregulation_item_post_links.status = "active"', 'left');
    $this->db->join('tblregulation_posts', 'tblregulation_posts.id = tblregulation_item_post_links.post_id', 'left');
    $this->db->where('tblfixedassets.category', 'vehicle'); // Assuming you have a category field
    return $this->db->get()->result_array();
  }

  /**
   * Get vehicle by ID
   * @param  integer $id
   * @return array
   */
  public function get_vehicle($id)
  {
    $this->db->where('id', $id);
    $this->db->where('category', 'vehicle');
    return $this->db->get('tblfixedassets')->row_array();
  }

  /**
   * Assign vehicle to post
   * @param  array $data assignment data
   * @return boolean
   */
  public function assign_to_post($data)
  {
    // First, deactivate any existing active assignments
    $this->db->where('item_type', 'vehicle');
    $this->db->where('item_id', $data['item_id']);
    $this->db->where('status', 'active');
    $this->db->update('tblregulation_item_post_links', ['status' => 'inactive', 'removed_date' => date('Y-m-d H:i:s')]);

    // Then create new assignment
    $data['created_by'] = get_staff_user_id();
    $data['assigned_date'] = date('Y-m-d H:i:s');
    $data['status'] = 'active';
    $data['item_type'] = 'vehicle';

    $this->db->insert('tblregulation_item_post_links', $data);

    if ($this->db->affected_rows() > 0) {
      log_activity('Vehicle Assigned to Post [Vehicle ID: ' . $data['item_id'] . ']');
      return true;
    }
    return false;
  }

  /**
   * Get all active posts for dropdown
   * @return array
   */
  public function get_active_posts()
  {
    $this->db->where('status', 'active');
    return $this->db->get('tblregulation_posts')->result_array();
  }

  public function add($data)
  {
    // Debug log
    log_activity('Adding vehicle: ' . json_encode($data));

    // Remove id if exists
    unset($data['id']);

    // Handle null values
    if (empty($data['assigned_to'])) {
      $data['assigned_to'] = null;
    }

    // Validate registration number
    if (empty($data['registration_number'])) {
      log_activity('Vehicle creation failed: Registration number is required');
      return false;
    }

    // Check for duplicate registration number
    $this->db->where('registration_number', $data['registration_number']);
    $existing = $this->db->get(db_prefix() . 'regulation_vehicles')->row();
    if ($existing) {
      log_activity('Vehicle creation failed: Registration number already exists');
      return false;
    }

    // Add created info
    $data['created_by'] = get_staff_user_id();
    $data['created_at'] = date('Y-m-d H:i:s');

    // Insert data
    $this->db->insert(db_prefix() . 'regulation_vehicles', $data);
    $insert_id = $this->db->insert_id();

    if ($insert_id) {
      log_activity('Vehicle added successfully [ID: ' . $insert_id . ']');
      return $insert_id;
    }

    // Log error if insert fails
    log_activity('Failed to add vehicle. DB Error: ' . $this->db->error()['message']);
    return false;
  }

  public function update($data, $id)
  {
    // Remove id from data array
    unset($data['id']);

    // Handle null values for foreign keys
    if (empty($data['assigned_to'])) {
      $data['assigned_to'] = null;
    }

    // Update timestamp
    $data['updated_at'] = date('Y-m-d H:i:s');

    $this->db->where('id', $id);
    $this->db->update(db_prefix() . 'regulation_vehicles', $data);

    if ($this->db->affected_rows() > 0) {
      log_activity('Vehicle Updated [ID: ' . $id . ']');
      return true;
    }

    return false;
  }
}