<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Diagnostics_model extends App_Model
{
  public function get_expired_items()
  {
    $expired_items = [];

    // Weapons
    $this->db->select('serial_number as item_name, license_expiry as expiration_date, "weapons" as item_type');
    $this->db->from('tblregulation_weapons');
    $this->db->where('license_expiry <', date('Y-m-d'));
    $expired_items['weapons'] = $this->db->get()->result_array();

    // Vests
    $this->db->select('serial_number as item_name, expiry_date as expiration_date, "vests" as item_type');
    $this->db->from('tblregulation_vests');
    $this->db->where('expiry_date <', date('Y-m-d'));
    $expired_items['vests'] = $this->db->get()->result_array();

    // Occurrences
    $this->db->select('description as item_name, occurrence_datetime as expiration_date, "occurrences" as item_type');
    $this->db->from('tblregulation_occurrences');
    $this->db->where('occurrence_datetime <', date('Y-m-d'));
    $expired_items['occurrences'] = $this->db->get()->result_array();

    // CNVs
    $this->db->select('cnv_number as item_name, expiry_date as expiration_date, "cnvs" as item_type');
    $this->db->from('tblstaff_cnv');
    $this->db->where('expiry_date <', date('Y-m-d'));
    $expired_items['cnvs'] = $this->db->get()->result_array();

    // Processes
    $this->db->select('process_type as item_name, expected_date as expiration_date, "processes" as item_type');
    $this->db->from('tblregulation_processes');
    $this->db->where('expected_date <', date('Y-m-d'));
    $expired_items['processes'] = $this->db->get()->result_array();

    // Vehicles
    $this->db->select('plate_number as item_name, registration_expiry as expiration_date, "vehicles" as item_type');
    $this->db->from('tblregulation_vehicles');
    $this->db->where('registration_expiry <', date('Y-m-d'));
    $expired_items['vehicles'] = $this->db->get()->result_array();

    // Vigilantes (assuming vigilantes have an expiry date)
    // Add similar query for vigilantes if applicable

    return $expired_items;
  }

  public function get_pending_processes()
  {
    $this->db->select('process_type, start_date, expected_date, status');
    $this->db->from('tblregulation_processes');
    $this->db->where('status', 'pending');
    $this->db->or_where('expected_date <', date('Y-m-d'));
    return $this->db->get()->result_array();
  }
}