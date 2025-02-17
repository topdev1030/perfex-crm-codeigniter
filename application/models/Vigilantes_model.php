<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Vigilantes_model extends App_Model
{
  public function __construct()
  {
    parent::__construct();
  }

  /**
   * Get all vigilantes with their details
   */
  public function get_all_vigilantes()
  {
    $this->db->select('tblstaff.*, tblstaff_cnv.cnv_number, tblstaff_cnv.expiry_date as cnv_expiry, tblregulation_posts.name as post_name');
    $this->db->from('tblstaff');
    $this->db->join('tblstaff_cnv', 'tblstaff_cnv.staff_id = tblstaff.staffid', 'left');
    $this->db->join('tblregulation_item_post_links', 'tblregulation_item_post_links.item_id = tblstaff.staffid 
            AND tblregulation_item_post_links.item_type = "vigilante" AND tblregulation_item_post_links.status = "active"', 'left');
    $this->db->join('tblregulation_posts', 'tblregulation_posts.id = tblregulation_item_post_links.post_id', 'left');
    $this->db->where('tblstaff.role', 'vigilante'); // Assuming you have a role field
    return $this->db->get()->result_array();
  }

  /**
   * Get vigilante details by ID
   */
  public function get_vigilante($id)
  {
    $this->db->select('tblstaff.*, tblstaff_cnv.cnv_number, tblstaff_cnv.expiry_date as cnv_expiry,
            tblregulation_posts.id as post_id, tblregulation_posts.name as post_name');
    $this->db->from('tblstaff');
    $this->db->join('tblstaff_cnv', 'tblstaff_cnv.staff_id = tblstaff.staffid', 'left');
    $this->db->join('tblregulation_item_post_links', 'tblregulation_item_post_links.item_id = tblstaff.staffid 
            AND tblregulation_item_post_links.item_type = "vigilante" AND tblregulation_item_post_links.status = "active"', 'left');
    $this->db->join('tblregulation_posts', 'tblregulation_posts.id = tblregulation_item_post_links.post_id', 'left');
    $this->db->where('tblstaff.staffid', $id);
    return $this->db->get()->row_array();
  }

  /**
   * Update vigilante CNV details
   */
  public function update_cnv($staff_id, $data)
  {
    $this->db->where('staff_id', $staff_id);
    $exists = $this->db->get('tblstaff_cnv')->row();

    if ($exists) {
      $this->db->where('staff_id', $staff_id);
      $this->db->update('tblstaff_cnv', $data);
    } else {
      $data['staff_id'] = $staff_id;
      $this->db->insert('tblstaff_cnv', $data);
    }

    if ($this->db->affected_rows() > 0) {
      log_activity('Vigilante CNV Updated [Staff ID: ' . $staff_id . ']');
      return true;
    }
    return false;
  }

  /**
   * Update vigilante post assignment
   */
  public function update_post_assignment($staff_id, $post_id)
  {
    // First, deactivate any existing assignments
    $this->db->where('item_type', 'vigilante');
    $this->db->where('item_id', $staff_id);
    $this->db->where('status', 'active');
    $this->db->update('tblregulation_item_post_links', ['status' => 'inactive', 'removed_date' => date('Y-m-d H:i:s')]);

    // Create new assignment
    $data = [
      'item_type' => 'vigilante',
      'item_id' => $staff_id,
      'post_id' => $post_id,
      'assigned_date' => date('Y-m-d H:i:s'),
      'status' => 'active',
      'created_by' => get_staff_user_id()
    ];

    $this->db->insert('tblregulation_item_post_links', $data);

    if ($this->db->affected_rows() > 0) {
      log_activity('Vigilante Post Assignment Updated [Staff ID: ' . $staff_id . ']');
      return true;
    }
    return false;
  }

  /**
   * Get all active posts for dropdown
   */
  public function get_active_posts()
  {
    $this->db->where('status', 'active');
    return $this->db->get('tblregulation_posts')->result_array();
  }
}