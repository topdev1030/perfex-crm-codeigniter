<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Service_stations extends AdminController
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model('service_station_model');
  }

  public function index()
  {
    $data['stations'] = $this->service_station_model->get_all_stations();
    $data['title'] = _l('service_stations');
    $this->load->view('admin/service_stations/list', $data);
  }

  public function station($id = '')
  {
    if ($this->input->post()) {
      $data = $this->input->post();
      $data['items'] = implode(',', $data['items']); // Convert items array to string

      if ($id == '') {
        $id = $this->service_station_model->add_station($data);
        if ($id) {
          set_alert('success', _l('added_successfully', _l('service_station')));
        } else {
          set_alert('danger', _l('problem_adding', _l('service_station')));
        }
      } else {
        $success = $this->service_station_model->update_station($data, $id);
        if ($success) {
          set_alert('success', _l('updated_successfully', _l('service_station')));
        } else {
          set_alert('danger', _l('problem_updating', _l('service_station')));
        }
      }
      redirect(admin_url('service_stations'));
    }

    if ($id != '') {
      $data['station'] = $this->service_station_model->get_station($id);
    }

    $data['contracts'] = $this->service_station_model->get_contracts();
    $data['items'] = $this->service_station_model->get_items();
    $data['title'] = $id == '' ? _l('add_new_station') : _l('edit_station');
    $this->load->view('admin/service_stations/station', $data);
  }
}