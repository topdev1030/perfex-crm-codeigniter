<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Diagnostics extends AdminController
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model('diagnostics_model');
  }

  public function index()
  {
    if (!staff_can('view', 'diagnostics')) {
      access_denied('diagnostics');
    }

    $data['title'] = _l('diagnostics');
    $data['expired_items'] = $this->diagnostics_model->get_expired_items();
    $data['pending_processes'] = $this->diagnostics_model->get_pending_processes();

    $this->load->view('admin/diagnostics/index', $data);
  }
}