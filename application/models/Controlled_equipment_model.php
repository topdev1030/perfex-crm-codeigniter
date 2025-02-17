<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Controlled_equipment_model extends App_Model
{
  public function __construct()
  {
    parent::__construct();
  }

  /**
   * Get all equipment
   * @return array
   */
  public function get_all_equipment()
  {
    return $this->db->get('tblregulation_controlled_equipment')->result_array();
  }

  /**
   * Get equipment by ID
   * @param  integer $id
   * @return array
   */
  public function get_equipment($id)
  {
    $this->db->where('id', $id);
    return $this->db->get('tblregulation_controlled_equipment')->row_array();
  }

  /**
   * Add new equipment
   * @param array $data equipment data
   */
  public function add($data)
  {
    $data['created_by'] = get_staff_user_id();

    $this->db->insert('tblregulation_controlled_equipment', $data);
    $insert_id = $this->db->insert_id();

    if ($insert_id) {
      log_activity('New Controlled Equipment Created [ID: ' . $insert_id . ']');
      return $insert_id;
    }
    return false;
  }

  /**
   * Update equipment
   * @param  array $data equipment data
   * @param  mixed $id   equipment id
   * @return boolean
   */
  public function update($data, $id)
  {
    $this->db->where('id', $id);
    $this->db->update('tblregulation_controlled_equipment', $data);

    if ($this->db->affected_rows() > 0) {
      log_activity('Controlled Equipment Updated [ID: ' . $id . ']');
      return true;
    }
    return false;
  }

  /**
   * Delete equipment
   * @param  mixed $id equipment id
   * @return boolean
   */
  public function delete($id)
  {
    $this->db->where('id', $id);
    $this->db->delete('tblregulation_controlled_equipment');

    if ($this->db->affected_rows() > 0) {
      log_activity('Controlled Equipment Deleted [ID: ' . $id . ']');
      return true;
    }
    return false;
  }
}