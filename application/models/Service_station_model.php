<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Service_station_model extends App_Model
{
  public function __construct()
  {
    parent::__construct();
  }

  public function get_all_stations()
  {
    return $this->db->get('tblservice_stations')->result_array();
  }

  public function get_station($id)
  {
    $this->db->where('id', $id);
    return $this->db->get('tblservice_stations')->row_array();
  }

  public function add_station($data)
  {
    $this->db->insert('tblservice_stations', $data);
    return $this->db->insert_id();
  }

  public function update_station($data, $id)
  {
    $this->db->where('id', $id);
    $this->db->update('tblservice_stations', $data);
    return $this->db->affected_rows() > 0;
  }

  public function get_contracts()
  {
    return $this->db->get('tblcontracts')->result_array();
  }

  public function get_items()
  {
    // Example query to get items (vests, weapons, etc.)
    return $this->db->get('tblitems')->result_array();
  }
}