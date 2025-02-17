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
}