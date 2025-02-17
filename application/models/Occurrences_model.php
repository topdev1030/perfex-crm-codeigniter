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
    $this->db->select('tblregulation_occurrences.*, tblstaff.firstname, tblstaff.lastname');
    $this->db->join('tblstaff', 'tblstaff.staffid = tblregulation_occurrences.created_by');
    return $this->db->get('tblregulation_occurrences')->result_array();
  }

  /**
   * Get occurrence by ID
   * @param  integer $id
   * @return array
   */
  public function get_occurrence($id)
  {
    $this->db->where('id', $id);
    return $this->db->get('tblregulation_occurrences')->row_array();
  }

  /**
   * Add new occurrence
   * @param array $data occurrence data
   */
  public function add($data)
  {
    $data['created_by'] = get_staff_user_id();

    // Convert arrays to JSON for storage
    if (isset($data['involved_guards']) && is_array($data['involved_guards'])) {
      $data['involved_guards'] = json_encode($data['involved_guards']);
    }
    if (isset($data['involved_equipment']) && is_array($data['involved_equipment'])) {
      $data['involved_equipment'] = json_encode($data['involved_equipment']);
    }

    $this->db->insert('tblregulation_occurrences', $data);
    $insert_id = $this->db->insert_id();

    if ($insert_id) {
      log_activity('New Occurrence Created [ID: ' . $insert_id . ']');
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
    // Convert arrays to JSON for storage
    if (isset($data['involved_guards']) && is_array($data['involved_guards'])) {
      $data['involved_guards'] = json_encode($data['involved_guards']);
    }
    if (isset($data['involved_equipment']) && is_array($data['involved_equipment'])) {
      $data['involved_equipment'] = json_encode($data['involved_equipment']);
    }

    $this->db->where('id', $id);
    $this->db->update('tblregulation_occurrences', $data);

    if ($this->db->affected_rows() > 0) {
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
    $this->db->where('id', $id);
    $this->db->delete('tblregulation_occurrences');

    if ($this->db->affected_rows() > 0) {
      log_activity('Occurrence Deleted [ID: ' . $id . ']');
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

  /**
   * Get all stations for dropdown
   * @return array
   */
  public function get_stations()
  {
    return $this->db->get('tblservice_stations')->result_array();
  }

  /**
   * Get all equipment for dropdown
   * @return array
   */
  public function get_equipment()
  {
    return $this->db->get('tblregulation_controlled_equipment')->result_array();
  }
}