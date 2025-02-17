<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Vests_model extends App_Model
{
  public function __construct()
  {
    parent::__construct();
  }

  /**
   * Get all vests
   * @return array
   */
  public function get_all_vests()
  {
    return $this->db->get('tblregulation_vests')->result_array();
  }

  /**
   * Get vest by ID
   * @param  integer $id
   * @return array
   */
  public function get_vest($id)
  {
    $this->db->where('id', $id);
    return $this->db->get('tblregulation_vests')->row_array();
  }

  /**
   * Add new vest
   * @param array $data vest data
   */
  public function add($data)
  {
    $data['created_by'] = get_staff_user_id();

    $this->db->insert('tblregulation_vests', $data);
    $insert_id = $this->db->insert_id();

    if ($insert_id) {
      log_activity('New Vest Created [ID: ' . $insert_id . ']');
      return $insert_id;
    }
    return false;
  }

  /**
   * Update vest
   * @param  array $data vest data
   * @param  mixed $id   vest id
   * @return boolean
   */
  public function update($data, $id)
  {
    $this->db->where('id', $id);
    $this->db->update('tblregulation_vests', $data);

    if ($this->db->affected_rows() > 0) {
      log_activity('Vest Updated [ID: ' . $id . ']');
      return true;
    }
    return false;
  }

  /**
   * Delete vest
   * @param  mixed $id vest id
   * @return boolean
   */
  public function delete($id)
  {
    $this->db->where('id', $id);
    $this->db->delete('tblregulation_vests');

    if ($this->db->affected_rows() > 0) {
      log_activity('Vest Deleted [ID: ' . $id . ']');
      return true;
    }
    return false;
  }
}