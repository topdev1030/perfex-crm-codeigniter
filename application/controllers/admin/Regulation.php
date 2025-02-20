<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Regulation extends AdminController
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model('vests_model');
    $this->load->model('controlled_equipment_model');
    $this->load->model('vehicles_model');
    $this->load->model('weapons_model');
    $this->load->model('staff_model');
    $this->load->helper('modules_helper');
  }

  /* List all vests */
  public function vests_list()
  {
    if (!staff_can('view', 'regulation')) {
      access_denied('regulation');
    }

    $data['title'] = _l('als_vests_list_submenu'); // This will be translated
    $data['vests'] = $this->vests_model->get_all_vests();

    $this->load->view('admin/regulation/vests_list', $data);
  }

  /* Add & update vest */
  public function vest($id = '')
  {
    if (!staff_can($id ? 'edit' : 'create', 'regulation')) {
      ajax_access_denied();
    }

    if ($this->input->post()) {
      $data = $this->input->post();

      // Format dates for database
      if (isset($data['manufacturing_date'])) {
        $data['manufacturing_date'] = to_sql_date($data['manufacturing_date']);
      }
      if (isset($data['expiry_date'])) {
        $data['expiry_date'] = to_sql_date($data['expiry_date']);
      }

      if ($id == '') {
        $id = $this->vests_model->add($data);
        if ($id) {
          set_alert('success', _l('added_successfully', _l('vest')));
          echo json_encode([
            'success' => true,
            'message' => _l('added_successfully', _l('vest')),
            'redirect_url' => admin_url('regulation/vests_list')
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
    if (!staff_can('delete', 'regulation')) {
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
    if (!staff_can('view', 'regulation')) {
      access_denied('regulation');
    }

    $data['title'] = _l('als_controlled_equipment_list');
    $data['equipment'] = $this->controlled_equipment_model->get_all_equipment();

    $this->load->view('admin/regulation/controlled_equipment_list', $data);
  }

  public function equipment($id = '')
  {
    if (!staff_can($id ? 'edit' : 'create', 'regulation')) {
      ajax_access_denied();
    }

    if ($this->input->post()) {
      $data = $this->input->post();

      // Format dates for database
      if (isset($data['acquisition_date'])) {
        $data['acquisition_date'] = to_sql_date($data['acquisition_date']);
      }
      if (isset($data['expiry_date'])) {
        $data['expiry_date'] = to_sql_date($data['expiry_date']);
      }

      if ($id == '') {
        $id = $this->controlled_equipment_model->add($data);
        if ($id) {
          set_alert('success', _l('added_successfully', _l('equipment')));
          echo json_encode([
            'success' => true,
            'message' => _l('added_successfully', _l('equipment')),
            'redirect_url' => admin_url('regulation/controlled_equipment_list')
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
    if (!staff_can('delete', 'regulation')) {
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
    if (!staff_can('view', 'regulation')) {
      access_denied('regulation');
    }

    $this->load->model('processes_model');
    $data['title'] = _l('als_processes_list');
    $data['processes'] = $this->processes_model->get_all_processes();

    $this->load->view('admin/regulation/processes_list', $data);
  }

  public function process($id = '')
  {
    if (!staff_can($id ? 'edit' : 'create', 'regulation')) {
      ajax_access_denied();
    }

    $this->load->model('processes_model');

    if ($this->input->post()) {
      $data = $this->input->post();

      dd($data);

      // Format date for database
      if (isset($data['date'])) {
        $data['date'] = to_sql_date($data['date']);
      }

      if ($id == '') {
        $id = $this->processes_model->add($data);
        if ($id) {
          set_alert('success', _l('added_successfully', _l('process')));
          echo json_encode([
            'success' => true,
            'message' => _l('added_successfully', _l('process')),
            'redirect_url' => admin_url('regulation/process_list')
          ]);
        } else {
          echo json_encode([
            'success' => false,
            'message' => _l('something_went_wrong')
          ]);
        }
      } else {
        $success = $this->processes_model->update($data, $id);
        if ($success) {
          set_alert('success', _l('updated_successfully', _l('process')));
          echo json_encode([
            'success' => true,
            'message' => _l('updated_successfully', _l('process'))
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
    if (!staff_can('delete', 'regulation')) {
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
    if (!staff_can('view', 'regulation')) {
      access_denied('regulation');
    }

    if ($this->input->is_ajax_request()) {
      $this->load->model('occurrences_model');
      $occurrences = $this->occurrences_model->get_all_occurrences();

      $data = [];
      foreach ($occurrences as $occurrence) {
        $options = '';
        if (staff_can('edit', 'regulation')) {
          $options .= '<a href="#" onclick="edit_occurrence(' . $occurrence['id'] . '); return false;" class="btn btn-default btn-icon"><i class="fa fa-pencil"></i></a> ';
        }
        if (staff_can('delete', 'regulation')) {
          $options .= '<a href="#" onclick="delete_occurrence(' . $occurrence['id'] . '); return false;" class="btn btn-danger btn-icon"><i class="fa fa-remove"></i></a>';
        }

        $status_class = '';
        $status_label = '';
        switch ($occurrence['status']) {
          case 'registered':
            $status_class = 'info';
            $status_label = _l('registered');
            break;
          case 'under_investigation':
            $status_class = 'warning';
            $status_label = _l('under_investigation');
            break;
          case 'completed':
            $status_class = 'success';
            $status_label = _l('completed');
            break;
        }

        $row = [];
        $row[] = _dt($occurrence['occurrence_datetime']);
        $row[] = $occurrence['post_name'];
        $row[] = $occurrence['description'];
        $row[] = '<span class="label label-' . $status_class . '">' . $status_label . '</span>';
        $row[] = $occurrence['firstname'] . ' ' . $occurrence['lastname'];
        $row[] = $options;

        $data[] = $row;
      }

      echo json_encode([
        'draw' => $this->input->post('draw'),
        'recordsTotal' => count($data),
        'recordsFiltered' => count($data),
        'data' => $data
      ]);
      die;
    }

    $data['title'] = _l('occurrences_list');
    $this->load->view('admin/regulation/occurrences_list', $data);
  }

  public function occurrence($id = '')
  {
    if (!staff_can($id ? 'edit' : 'create', 'regulation')) {
      ajax_access_denied();
    }

    try {
      // Load required models
      $this->load->model('occurrences_model');
      $this->load->model('staff_model');
      $this->load->model('controlled_equipment_model');

      if ($this->input->post()) {
        try {
          $data = $this->input->post();

          // Validate required fields
          if (empty($data['post_id'])) {
            throw new Exception(_l('post_required'));
          }

          // Format datetime for database
          if (isset($data['occurrence_datetime'])) {
            $data['occurrence_datetime'] = to_sql_date($data['occurrence_datetime'], true);
          }

          // Handle arrays for involved staff and equipment
          if (isset($data['involved_staff'])) {
            $data['involved_staff'] = json_encode($data['involved_staff']);
          }
          if (isset($data['involved_equipment'])) {
            $data['involved_equipment'] = json_encode($data['involved_equipment']);
          }

          if ($id == '') {
            $success = $this->occurrences_model->add($data);
            if ($success) {
              echo json_encode([
                'success' => true,
                'message' => _l('added_successfully', _l('occurrence')),
                'redirect_url' => admin_url('regulation/occurrences_list')
              ]);
            }
          } else {
            $success = $this->occurrences_model->update($data, $id);
            if ($success) {
              echo json_encode([
                'success' => true,
                'message' => _l('updated_successfully', _l('occurrence')),
                'redirect_url' => admin_url('regulation/occurrences_list')
              ]);
            }
          }
        } catch (Exception $e) {
          echo json_encode([
            'success' => false,
            'message' => $e->getMessage()
          ]);
        }
        die;
      }

      // Prepare data for the view
      $data = [];
      if ($id) {
        $data['occurrence'] = $this->occurrences_model->get_occurrence($id);
        if (!$data['occurrence']) {
          show_404();
        }
        $title = _l('edit', _l('occurrence_lowercase'));
      } else {
        $title = _l('new_occurrence');
      }

      // Load required data for dropdowns
      $data['title'] = $title;
      $data['posts'] = $this->occurrences_model->get_posts();
      $data['staff_members'] = $this->staff_model->get();
      $data['equipment'] = $this->controlled_equipment_model->get_all_equipment();

      // Load the view
      $this->load->view('admin/regulation/occurrence', $data);

    } catch (Exception $e) {
      // Log the error
      log_activity('Occurrence Error: ' . $e->getMessage());

      // Return error response
      header('HTTP/1.1 500 Internal Server Error');
      echo json_encode([
        'success' => false,
        'message' => 'Internal server error: ' . $e->getMessage()
      ]);
      die;
    }
  }

  public function delete_occurrence($id)
  {
    if (!staff_can('delete', 'regulation')) {
      access_denied('regulation');
    }

    $this->load->model('occurrences_model');
    $success = $this->occurrences_model->delete($id);

    if ($success) {
      set_alert('success', _l('deleted', _l('occurrence')));
    }

    redirect(admin_url('regulation/occurrences_list'));
  }

  public function get_occurrence_attachments($id)
  {
    $this->load->model('occurrences_model');
    $attachments = $this->occurrences_model->get_attachments($id);

    echo json_encode(['data' => $attachments]);
  }

  public function vigilantes()
  {
    if (!staff_can('view', 'regulation')) {
      access_denied('regulation');
    }

    $this->load->model('vigilantes_model');

    $data['title'] = _l('vigilantes');
    $data['vigilantes'] = $this->vigilantes_model->get_all_vigilantes();

    $this->load->view('admin/regulation/vigilantes', $data);
  }

  public function vigilante($id)
  {
    if (!staff_can('edit', 'regulation')) {
      ajax_access_denied();
    }

    $this->load->model('vigilantes_model');

    if ($this->input->post()) {
      $data = $this->input->post();

      // Update CNV details
      $cnv_data = [
        'cnv_number' => $data['cnv_number'],
        'expiry_date' => $data['cnv_expiry']
      ];
      $success = $this->vigilantes_model->update_cnv($id, $cnv_data);

      // Update post assignment if changed
      if (isset($data['post_id']) && $data['post_id'] !== '') {
        $this->vigilantes_model->update_post_assignment($id, $data['post_id']);
      }

      if ($success) {
        set_alert('success', _l('updated_successfully', _l('vigilante')));
      }

      redirect(admin_url('regulation/vigilantes'));
    }

    $data['vigilante'] = $this->vigilantes_model->get_vigilante($id);
    $data['posts'] = $this->vigilantes_model->get_active_posts();
    $data['title'] = $data['vigilante']['firstname'] . ' ' . $data['vigilante']['lastname'];

    $this->load->view('admin/regulation/vigilante', $data);
  }

  public function vehicles_list()
  {
    if (!staff_can('view', 'regulation')) {
      access_denied('regulation');
    }

    $data['title'] = _l('vehicles_list');
    $data['is_fleet_active'] = is_fleet_module_active();

    if ($data['is_fleet_active']) {
      // Load Fleet module data
      $this->load->model('fleet/fleet_model');
      $data['fleet_vehicles'] = $this->fleet_model->get_vehicles();
    }

    $this->load->view('admin/regulation/vehicles_list', $data);
  }

  public function vehicle($id = '')
  {
    if (!staff_can($id ? 'edit' : 'create', 'regulation')) {
      ajax_access_denied();
    }

    if ($this->input->post()) {
      try {
        $data = $this->input->post();

        // Validate required fields
        $required_fields = ['plate_number', 'registration_number', 'model', 'type', 'registration_expiry'];
        foreach ($required_fields as $field) {
          if (empty($data[$field])) {
            throw new Exception($field . ' is required');
          }
        }

        // Format dates for database
        if (!empty($data['registration_expiry'])) {
          $data['registration_expiry'] = to_sql_date($data['registration_expiry']);
        }

        // Handle empty assigned_to
        if (empty($data['assigned_to'])) {
          $data['assigned_to'] = null;
        }

        if ($id == '') {
          // Check for duplicate registration number
          $this->db->where('registration_number', $data['registration_number']);
          $existing = $this->db->get(db_prefix() . 'regulation_vehicles')->row();
          if ($existing) {
            throw new Exception('Registration number already exists');
          }

          $data['created_by'] = get_staff_user_id();
          $id = $this->vehicles_model->add($data);

          if ($id) {
            echo json_encode([
              'success' => true,
              'message' => _l('added_successfully', _l('vehicle')),
              'id' => $id,
              'redirect_url' => admin_url('regulation/vehicles_list')
            ]);
          } else {
            throw new Exception('Failed to create vehicle');
          }
        } else {
          // Update existing vehicle
          $success = $this->vehicles_model->update($data, $id);
          if ($success) {
            echo json_encode([
              'success' => true,
              'message' => _l('updated_successfully', _l('vehicle')),
              'id' => $id,
              'redirect_url' => admin_url('regulation/vehicles_list')
            ]);
          }
        }
      } catch (Exception $e) {
        echo json_encode([
          'success' => false,
          'message' => $e->getMessage()
        ]);
      }
      die;
    }

    if ($id == '') {
      $title = _l('add_new', _l('vehicle_lowercase'));
    } else {
      $data['vehicle'] = $this->vehicles_model->get($id);
      $title = _l('edit', _l('vehicle_lowercase'));
    }

    $data['title'] = $title;
    $data['staff_members'] = $this->staff_model->get();
    $this->load->view('admin/regulation/vehicle', $data);
  }

  public function assign_vehicle($id = '')
  {
    if (!staff_can('edit', 'regulation')) {
      ajax_access_denied();
    }

    if ($this->input->post()) {
      $data = $this->input->post();

      $success = $this->vehicles_model->assign_to_post($data);
      if ($success) {
        set_alert('success', _l('vehicle_assigned_successfully'));
      }

      redirect(admin_url('regulation/vehicles_list'));
    }

    $data['vehicle'] = $this->vehicles_model->get_vehicle($id);
    $data['posts'] = $this->vehicles_model->get_active_posts();
    $data['title'] = _l('assign_vehicle_to_post');

    $this->load->view('admin/regulation/assign_vehicle', $data);
  }

  public function diagnostics()
  {
    try {
      if (!staff_can('view', 'regulation')) {
        access_denied('regulation');
      }

      // Load model
      $this->load->model('regulation_model');

      $data = [
        'title' => _l('regulation_diagnostics'),
        'expired_vests' => [],
        'expired_weapons' => [],
        'expired_cnvs' => [],
        'pending_processes' => [],
        'delayed_processes' => [],
        'recent_occurrences' => []
      ];

      // Get data with error handling
      try {
        $data['expired_vests'] = $this->regulation_model->get_expired_items('vests');
      } catch (Exception $e) {
        log_activity('Error loading vests: ' . $e->getMessage());
      }

      // try {
      //   $data['expired_weapons'] = $this->regulation_model->get_expired_items('weapons');
      // } catch (Exception $e) {
      //   log_activity('Error loading weapons: ' . $e->getMessage());
      // }

      // try {
      //   $data['expired_cnvs'] = $this->regulation_model->get_expired_items('cnvs');
      // } catch (Exception $e) {
      //   log_activity('Error loading cnvs: ' . $e->getMessage());
      // }

      try {
        $data['pending_processes'] = $this->regulation_model->get_pending_processes();
      } catch (Exception $e) {
        log_activity('Error loading pending processes: ' . $e->getMessage());
      }

      try {
        $data['delayed_processes'] = $this->regulation_model->get_delayed_processes();
      } catch (Exception $e) {
        log_activity('Error loading delayed processes: ' . $e->getMessage());
      }

      try {
        $data['recent_occurrences'] = $this->regulation_model->get_recent_occurrences();
      } catch (Exception $e) {
        log_activity('Error loading occurrences: ' . $e->getMessage());
      }

      // Load view
      $this->load->view('admin/regulation/diagnostics', $data);

    } catch (Exception $e) {
      // Log the error
      log_activity('Diagnostics page error: ' . $e->getMessage());

      // Show error page
      show_error($e->getMessage(), 500, 'An error occurred');
    }
  }

  public function weapons_list()
  {
    if (!staff_can('view', 'regulation')) {
      access_denied('regulation');
    }

    $data['title'] = _l('weapons_list');
    $this->load->view('admin/regulation/weapons_list', $data);
  }

  public function weapon($id = '')
  {
    if (!staff_can($id ? 'edit' : 'create', 'regulation')) {
      ajax_access_denied();
    }

    if ($this->input->post()) {
      try {
        $data = $this->input->post();

        // Handle empty assigned_to field
        if (empty($data['assigned_to'])) {
          $data['assigned_to'] = null;
          $data['assigned_date'] = null;
        }

        // Format dates for database
        if (!empty($data['license_expiry'])) {
          $data['license_expiry'] = to_sql_date($data['license_expiry']);
        }
        if (!empty($data['acquisition_date'])) {
          $data['acquisition_date'] = to_sql_date($data['acquisition_date']);
        }
        if (!empty($data['last_maintenance'])) {
          $data['last_maintenance'] = to_sql_date($data['last_maintenance']);
        }
        if (!empty($data['next_maintenance'])) {
          $data['next_maintenance'] = to_sql_date($data['next_maintenance']);
        }
        if (!empty($data['assigned_date'])) {
          $data['assigned_date'] = to_sql_date($data['assigned_date']);
        }

        // Set created_by for new records
        if ($id == '') {
          $data['created_by'] = get_staff_user_id();
        }

        if ($id == '') {
          $id = $this->weapons_model->add($data);
          if ($id) {
            echo json_encode([
              'success' => true,
              'message' => _l('added_successfully', _l('weapon')),
              'id' => $id,
              'redirect_url' => admin_url('regulation/weapons_list')
            ]);
          }
        } else {
          $success = $this->weapons_model->update($data, $id);
          if ($success) {
            echo json_encode([
              'success' => true,
              'message' => _l('updated_successfully', _l('weapon')),
              'id' => $id,
              'redirect_url' => admin_url('regulation/weapons_list')
            ]);
          }
        }
      } catch (Exception $e) {
        // Log the error and return error response
        log_activity('Error in weapon save: ' . $e->getMessage());
        echo json_encode([
          'success' => false,
          'message' => 'Error: ' . $e->getMessage()
        ]);
      }
      die;
    }

    if ($id == '') {
      $title = _l('add_new', _l('weapon_lowercase'));
    } else {
      $data['weapon'] = $this->weapons_model->get($id);
      $title = _l('edit', _l('weapon_lowercase'));
    }

    $data['title'] = $title;
    $data['staff_members'] = $this->staff_model->get();
    $this->load->view('admin/regulation/weapon', $data);
  }

  public function delete_weapon($id)
  {
    if (!staff_can('delete', 'regulation')) {
      access_denied('regulation');
    }

    $response = $this->weapons_model->delete($id);
    if ($response) {
      set_alert('success', _l('deleted', _l('weapon')));
    } else {
      set_alert('warning', _l('problem_deleting', _l('weapon_lowercase')));
    }

    redirect(admin_url('regulation/weapons_list'));
  }

  public function get_weapons_table()
  {
    if (!staff_can('view', 'regulation')) {
      ajax_access_denied();
    }

    $this->load->model('weapons_model');

    $select = [
      'id',
      'serial_number',
      'type',
      'model',
      'caliber',
      'license_expiry',
      'status',
      'assigned_to'
    ];

    $aColumns = $select;
    $sIndexColumn = "id";
    $sTable = db_prefix() . 'regulation_weapons';

    $result = data_tables_init($aColumns, $sIndexColumn, $sTable, [], [], ['id']);
    $output = $result['output'];
    $rResult = $result['rResult'];

    foreach ($rResult as $aRow) {
      $row = [];

      // Serial Number
      $row[] = $aRow['serial_number'];

      // Type
      $row[] = $aRow['type'];

      // Model
      $row[] = $aRow['model'];

      // Caliber
      $row[] = $aRow['caliber'];

      // License Expiry
      $row[] = _d($aRow['license_expiry']);

      // Status
      $row[] = '<span class="label label-' . ($aRow['status'] == 'active' ? 'success' : 'warning') . '">'
        . _l($aRow['status']) . '</span>';

      // Assigned To
      if ($aRow['assigned_to']) {
        $this->db->select('firstname, lastname');
        $this->db->where('staffid', $aRow['assigned_to']);
        $staff = $this->db->get(db_prefix() . 'staff')->row();
        $row[] = $staff ? $staff->firstname . ' ' . $staff->lastname : '';
      } else {
        $row[] = '';
      }

      // Options
      $options = '';
      if (staff_can('edit', 'regulation')) {
        $options .= '<a href="#" onclick="edit_weapon(' . $aRow['id'] . '); return false;" class="btn btn-default btn-icon"><i class="fa fa-pencil-square-o"></i></a> ';
      }
      if (staff_can('delete', 'regulation')) {
        $options .= '<a href="' . admin_url('regulation/delete_weapon/' . $aRow['id']) . '" class="btn btn-danger btn-icon _delete"><i class="fa fa-remove"></i></a>';
      }
      $row[] = $options;

      $output['aaData'][] = $row;
    }

    echo json_encode($output);
    die;
  }
}