<?php

class Regulation_model extends App_Model
{
  public function __construct()
  {
    parent::__construct();
  }

  public function get_expired_items($type, $days_threshold = 30)
  {
    try {
      $today = date('Y-m-d');
      $threshold_date = date('Y-m-d', strtotime("+{$days_threshold} days"));

      switch ($type) {
        case 'vests':
          $table = 'regulation_vests';
          $fields = 'id, serial_number, expiry_date';
          break;
        // case 'weapons':
        //   $table = 'regulation_weapons';
        //   $fields = 'id, serial_number, license_expiry as expiry_date';
        //   break;
        // case 'cnvs':
        //   $table = 'regulation_cnvs';
        //   $fields = 'id, document_number as serial_number, expiry_date';
        //   break;
        default:
          return [];
      }

      // Check if table exists
      if (!$this->db->table_exists(db_prefix() . $table)) {
        return [];
      }

      $this->db->select($fields);
      $this->db->from(db_prefix() . $table);
      $this->db->where('expiry_date <=', $threshold_date);
      $this->db->where('expiry_date >=', $today);
      $this->db->order_by('expiry_date', 'ASC');

      return $this->db->get()->result_array();
    } catch (Exception $e) {
      log_activity('Error in get_expired_items: ' . $e->getMessage());
      return [];
    }
  }

  public function get_pending_processes()
  {
    try {
      if (!$this->db->table_exists(db_prefix() . 'regulation_processes')) {
        return [];
      }

      $this->db->select('*');
      $this->db->from(db_prefix() . 'regulation_processes');
      $this->db->where('status', 'pending');
      $this->db->order_by('date_created', 'DESC');
      return $this->db->get()->result_array();
    } catch (Exception $e) {
      log_activity('Error in get_pending_processes: ' . $e->getMessage());
      return [];
    }
  }

  public function get_delayed_processes()
  {
    try {
      if (!$this->db->table_exists(db_prefix() . 'regulation_processes')) {
        return [];
      }

      $today = date('Y-m-d');
      $this->db->select('*');
      $this->db->from(db_prefix() . 'regulation_processes');
      $this->db->where('due_date <', $today);
      $this->db->where('status !=', 'completed');
      $this->db->order_by('due_date', 'ASC');
      return $this->db->get()->result_array();
    } catch (Exception $e) {
      log_activity('Error in get_delayed_processes: ' . $e->getMessage());
      return [];
    }
  }

  public function get_recent_occurrences()
  {
    try {
      if (!$this->db->table_exists(db_prefix() . 'regulation_occurrences')) {
        return [];
      }

      $this->db->select('*');
      $this->db->from(db_prefix() . 'regulation_occurrences');
      $this->db->order_by('occurrence_datetime', 'DESC');
      $this->db->limit(5);
      return $this->db->get()->result_array();
    } catch (Exception $e) {
      log_activity('Error in get_recent_occurrences: ' . $e->getMessage());
      return [];
    }
  }
}