<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Processes_model extends App_Model
{
  public function __construct()
  {
    parent::__construct();
  }

  /**
   * Get all processes
   * @return array
   */
  public function get_all_processes()
  {
    $this->db->select('tblregulation_processes.*, CONCAT(firstname, " ", lastname) as responsible_name');
    $this->db->join('tblstaff', 'tblstaff.staffid = tblregulation_processes.responsible_id');
    return $this->db->get('tblregulation_processes')->result_array();
  }

  /**
   * Get process by ID
   * @param  integer $id
   * @return array
   */
  public function get_process($id)
  {
    $this->db->where('id', $id);
    return $this->db->get('tblregulation_processes')->row_array();
  }

  /**
   * Add new process
   * @param array $data process data
   */
  public function add($data)
  {
    $this->db->insert('tblregulation_processes', $data);
    $insert_id = $this->db->insert_id();

    if ($insert_id) {
      log_activity('New Process Created [ID: ' . $insert_id . ']');
      return $insert_id;
    }
    return false;
  }

  /**
   * Update process
   * @param  array $data process data
   * @param  mixed $id   process id
   * @return boolean
   */
  public function update($data, $id)
  {
    $this->db->where('id', $id);
    $this->db->update('tblregulation_processes', $data);

    if ($this->db->affected_rows() > 0) {
      log_activity('Process Updated [ID: ' . $id . ']');
      return true;
    }
    return false;
  }

  /**
   * Delete process
   * @param  mixed $id process id
   * @return boolean
   */
  public function delete($id)
  {
    $this->db->where('id', $id);
    $this->db->delete('tblregulation_processes');

    if ($this->db->affected_rows() > 0) {
      log_activity('Process Deleted [ID: ' . $id . ']');
      return true;
    }
    return false;
  }

  /**
   * Get all staff members for dropdown
   * @return array
   */
  public function get_staff_members()
  {
    $this->db->select('staffid, CONCAT(firstname, " ", lastname) as full_name');
    return $this->db->get('tblstaff')->result_array();
  }
}