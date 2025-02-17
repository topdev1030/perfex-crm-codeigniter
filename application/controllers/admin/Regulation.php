<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Regulation extends AdminController
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model('vests_model');
    $this->load->model('controlled_equipment_model');
  }

  /* List all vests */
  public function vests_list()
  {
    // Check if user has permission
    if (!has_permission('regulation', '', 'view')) {
      access_denied('regulation');
    }

    $data['title'] = _l('als_vests_list_submenu'); // This will be translated
    $data['vests'] = $this->vests_model->get_all_vests();

    $this->load->view('admin/regulation/vests_list', $data);
  }

  /* Add & update vest */
  public function vest($id = '')
  {
    if (!has_permission('regulation', '', $id ? 'edit' : 'create')) {
      ajax_access_denied();
    }

    if ($this->input->post()) {
      $data = $this->input->post();

      if ($id == '') {
        $id = $this->vests_model->add($data);
        if ($id) {
          set_alert('success', _l('added_successfully', _l('vest')));
          echo json_encode([
            'success' => true,
            'message' => _l('added_successfully', _l('vest')),
          ]);
        }
      } else {
        $success = $this->vests_model->update($data, $id);
        if ($success) {
          set_alert('success', _l('updated_successfully', _l('vest')));
          echo json_encode([
            'success' => true,
            'message' => _l('updated_successfully', _l('vest')),
          ]);
        }
      }
      die;
    }

    if ($id == '') {
      $title = _l('add_new', _l('vest_lowercase'));
    } else {
      $data['vest'] = $this->vests_model->get_vest($id);
      $title = _l('edit', _l('vest_lowercase'));
    }

    $data['title'] = $title;
    $this->load->view('admin/regulation/vest', $data);
  }

  /* Delete vest */
  public function delete_vest($id)
  {
    if (!has_permission('regulation', '', 'delete')) {
      access_denied('regulation');
    }

    if (!$id) {
      redirect(admin_url('regulation/vests_list'));
    }

    $response = $this->vests_model->delete($id);
    if ($response) {
      set_alert('success', _l('deleted', _l('vest')));
    } else {
      set_alert('warning', _l('problem_deleting', _l('vest_lowercase')));
    }

    redirect(admin_url('regulation/vests_list'));
  }

  public function controlled_equipment_list()
  {
    if (!has_permission('regulation', '', 'view')) {
      access_denied('regulation');
    }

    $data['title'] = _l('als_controlled_equipment_list');
    $data['equipment'] = $this->controlled_equipment_model->get_all_equipment();

    $this->load->view('admin/regulation/controlled_equipment_list', $data);
  }

  public function equipment($id = '')
  {
    if (!has_permission('regulation', '', $id ? 'edit' : 'create')) {
      ajax_access_denied();
    }

    if ($this->input->post()) {
      $data = $this->input->post();

      if ($id == '') {
        $id = $this->controlled_equipment_model->add($data);
        if ($id) {
          set_alert('success', _l('added_successfully', _l('equipment')));
          echo json_encode([
            'success' => true,
            'message' => _l('added_successfully', _l('equipment')),
          ]);
        }
      } else {
        $success = $this->controlled_equipment_model->update($data, $id);
        if ($success) {
          set_alert('success', _l('updated_successfully', _l('equipment')));
          echo json_encode([
            'success' => true,
            'message' => _l('updated_successfully', _l('equipment')),
          ]);
        }
      }
      die;
    }

    if ($id == '') {
      $title = _l('add_new', _l('equipment_lowercase'));
    } else {
      $data['equipment'] = $this->controlled_equipment_model->get_equipment($id);
      $title = _l('edit', _l('equipment_lowercase'));
    }

    $data['title'] = $title;
    $this->load->view('admin/regulation/equipment', $data);
  }

  public function delete_equipment($id)
  {
    if (!has_permission('regulation', '', 'delete')) {
      access_denied('regulation');
    }

    if (!$id) {
      redirect(admin_url('regulation/controlled_equipment_list'));
    }

    $response = $this->controlled_equipment_model->delete($id);
    if ($response) {
      set_alert('success', _l('deleted', _l('equipment')));
    } else {
      set_alert('warning', _l('problem_deleting', _l('equipment_lowercase')));
    }

    redirect(admin_url('regulation/controlled_equipment_list'));
  }

  public function processes_list()
  {
    if (!has_permission('regulation', '', 'view')) {
      access_denied('regulation');
    }

    $this->load->model('processes_model');
    $data['title'] = _l('als_processes_list');
    $data['processes'] = $this->processes_model->get_all_processes();

    $this->load->view('admin/regulation/processes_list', $data);
  }

  public function process($id = '')
  {
    if (!has_permission('regulation', '', $id ? 'edit' : 'create')) {
      ajax_access_denied();
    }

    $this->load->model('processes_model');

    if ($this->input->post()) {
      $data = $this->input->post();

      if ($id == '') {
        $id = $this->processes_model->add($data);
        if ($id) {
          set_alert('success', _l('added_successfully', _l('process')));
          echo json_encode([
            'success' => true,
            'message' => _l('added_successfully', _l('process')),
          ]);
        }
      } else {
        $success = $this->processes_model->update($data, $id);
        if ($success) {
          set_alert('success', _l('updated_successfully', _l('process')));
          echo json_encode([
            'success' => true,
            'message' => _l('updated_successfully', _l('process')),
          ]);
        }
      }
      die;
    }

    if ($id == '') {
      $title = _l('add_new', _l('process_lowercase'));
    } else {
      $data['process'] = $this->processes_model->get_process($id);
      $title = _l('edit', _l('process_lowercase'));
    }

    $data['title'] = $title;
    $data['staff_members'] = $this->processes_model->get_staff_members();
    $this->load->view('admin/regulation/process', $data);
  }

  public function delete_process($id)
  {
    if (!has_permission('regulation', '', 'delete')) {
      access_denied('regulation');
    }

    $this->load->model('processes_model');

    if (!$id) {
      redirect(admin_url('regulation/processes_list'));
    }

    $response = $this->processes_model->delete($id);
    if ($response) {
      set_alert('success', _l('deleted', _l('process')));
    } else {
      set_alert('warning', _l('problem_deleting', _l('process_lowercase')));
    }

    redirect(admin_url('regulation/processes_list'));
  }

  public function occurrences_list()
  {
    if (!has_permission('regulation', '', 'view')) {
      access_denied('regulation');
    }

    $this->load->model('occurrences_model');
    $data['title'] = _l('als_occurrences_list');
    $data['occurrences'] = $this->occurrences_model->get_all_occurrences();

    $this->load->view('admin/regulation/occurrences_list', $data);
  }

  public function occurrence($id = '')
  {
    if (!has_permission('regulation', '', $id ? 'edit' : 'create')) {
      ajax_access_denied();
    }

    $this->load->model('occurrences_model');

    if ($this->input->post()) {
      $data = $this->input->post();

      if ($id == '') {
        $id = $this->occurrences_model->add($data);
        if ($id) {
          set_alert('success', _l('added_successfully', _l('occurrence')));
          echo json_encode([
            'success' => true,
            'message' => _l('added_successfully', _l('occurrence')),
          ]);
        }
      } else {
        $success = $this->occurrences_model->update($data, $id);
        if ($success) {
          set_alert('success', _l('updated_successfully', _l('occurrence')));
          echo json_encode([
            'success' => true,
            'message' => _l('updated_successfully', _l('occurrence')),
          ]);
        }
      }
      die;
    }

    if ($id == '') {
      $title = _l('add_new', _l('occurrence_lowercase'));
    } else {
      $data['occurrence'] = $this->occurrences_model->get_occurrence($id);
      $title = _l('edit', _l('occurrence_lowercase'));
    }

    $data['title'] = $title;
    $data['staff_members'] = $this->occurrences_model->get_staff_members();
    $data['stations'] = $this->occurrences_model->get_stations();
    $data['equipment'] = $this->occurrences_model->get_equipment();
    $this->load->view('admin/regulation/occurrence', $data);
  }

  public function delete_occurrence($id)
  {
    if (!has_permission('regulation', '', 'delete')) {
      access_denied('regulation');
    }

    $this->load->model('occurrences_model');

    if (!$id) {
      redirect(admin_url('regulation/occurrences_list'));
    }

    $response = $this->occurrences_model->delete($id);
    if ($response) {
      set_alert('success', _l('deleted', _l('occurrence')));
    } else {
      set_alert('warning', _l('problem_deleting', _l('occurrence_lowercase')));
    }

    redirect(admin_url('regulation/occurrences_list'));
  }
}