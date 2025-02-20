<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
  <div class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="panel_s">
          <div class="panel-body">
            <h4 class="no-margin"><?php echo $title; ?></h4>
            <hr class="hr-panel-heading" />

            <?php if ($is_fleet_active) { ?>
              <!-- Fleet Module Integration -->
              <div class="alert alert-info">
                <?php echo _l('using_fleet_module'); ?>
                <a href="<?php echo admin_url('fleet/vehicles'); ?>" class="alert-link">
                  <?php echo _l('go_to_fleet_module'); ?>
                </a>
              </div>
              <table class="table dt-table">
                <thead>
                  <tr>
                    <th><?php echo _l('plate_number'); ?></th>
                    <th><?php echo _l('model'); ?></th>
                    <th><?php echo _l('type'); ?></th>
                    <th><?php echo _l('status'); ?></th>
                    <th><?php echo _l('assigned_to'); ?></th>
                    <th><?php echo _l('options'); ?></th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($fleet_vehicles as $vehicle) { ?>
                    <tr>
                      <td><?php echo $vehicle->plate_number; ?></td>
                      <td><?php echo $vehicle->model; ?></td>
                      <td><?php echo $vehicle->type; ?></td>
                      <td>
                        <span class="label label-<?php echo $vehicle->status == 'active' ? 'success' : 'warning'; ?>">
                          <?php echo _l($vehicle->status); ?>
                        </span>
                      </td>
                      <td><?php echo $vehicle->assigned_to_name; ?></td>
                      <td>
                        <a href="<?php echo admin_url('fleet/vehicle/' . $vehicle->id); ?>"
                          class="btn btn-default btn-icon">
                          <i class="fa fa-pencil-square-o"></i>
                        </a>
                      </td>
                    </tr>
                  <?php } ?>
                </tbody>
              </table>
            <?php } else { ?>
              <!-- Simple Vehicle List -->
              <?php if (staff_can('create', 'regulation')) { ?>
                <div class="_buttons">
                  <a href="#" onclick="new_vehicle(); return false;" class="btn btn-primary pull-left display-block">
                    <?php echo _l('new_vehicle'); ?>
                  </a>
                </div>
                <div class="clearfix"></div>
                <hr class="hr-panel-heading" />
              <?php } ?>
              <table class="table dt-table table-vehicles" data-order-col="1" data-order-type="asc">
                <thead>
                  <tr>
                    <th><?php echo _l('plate_number'); ?></th>
                    <th><?php echo _l('model'); ?></th>
                    <th><?php echo _l('type'); ?></th>
                    <th><?php echo _l('registration_expiry'); ?></th>
                    <th><?php echo _l('status'); ?></th>
                    <th><?php echo _l('assigned_to'); ?></th>
                    <th><?php echo _l('options'); ?></th>
                  </tr>
                </thead>
                <tbody></tbody>
              </table>
            <?php } ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php if (!$is_fleet_active) { ?>
  <!-- Vehicle Modal -->
  <div class="modal fade" id="vehicle_modal" tabindex="-1" role="dialog">
    <div class="modal-dialog">
      <?php echo form_open(admin_url('regulation/vehicle'), ['id' => 'vehicle-form']); ?>
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          <h4 class="modal-title">
            <span class="edit-title"><?php echo _l('edit_vehicle'); ?></span>
            <span class="add-title"><?php echo _l('new_vehicle'); ?></span>
          </h4>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-12">
              <div id="additional"></div>
              <?php echo render_input('plate_number', 'plate_number'); ?>
              <?php echo render_input('registration_number', 'registration_number'); ?>
              <?php echo render_input('model', 'model'); ?>
              <?php echo render_input('type', 'type'); ?>
              <?php echo render_date_input('registration_expiry', 'registration_expiry'); ?>
              <?php echo render_select('status', [
                ['id' => 'active', 'name' => _l('active')],
                ['id' => 'inactive', 'name' => _l('inactive')],
                ['id' => 'maintenance', 'name' => _l('maintenance')],
                ['id' => 'assigned', 'name' => _l('assigned')]
              ], 'id', 'name', '', [], [], 'status'); ?>
              <?php echo render_select('assigned_to', $staff_members, ['staffid', ['firstname', 'lastname']], 'assigned_to'); ?>
              <?php echo render_textarea('notes', 'notes'); ?>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo _l('close'); ?></button>
          <button type="submit" class="btn btn-primary"><?php echo _l('submit'); ?></button>
        </div>
      </div>
      <?php echo form_close(); ?>
    </div>
  </div>
<?php } ?>

<?php init_tail(); ?>
<script>
  function new_vehicle() {
    $('#vehicle_modal').modal('show');
    $('.edit-title').addClass('hide');
    $('.add-title').removeClass('hide');
    $('#vehicle-form').attr('action', admin_url + 'regulation/vehicle');
    $('#vehicle-form')[0].reset();
    $('#additional').html('');
  }

  function edit_vehicle(id) {
    $('#additional').html('<input type="hidden" name="id" value="' + id + '">');
    $('#vehicle_modal').modal('show');
    $('.add-title').addClass('hide');
    $('.edit-title').removeClass('hide');
    $('#vehicle-form').attr('action', admin_url + 'regulation/vehicle/' + id);
    $('#vehicle-form')[0].reset();

    // Load vehicle data
    requestGet('regulation/vehicle/' + id).done(function (response) {
      response = JSON.parse(response);
      $('#vehicle-form').find('[name="plate_number"]').val(response.plate_number);
      $('#vehicle-form').find('[name="model"]').val(response.model);
      $('#vehicle-form').find('[name="type"]').val(response.type);
      $('#vehicle-form').find('[name="registration_expiry"]').val(response.registration_expiry);
      $('#vehicle-form').find('[name="status"]').val(response.status).change();
      $('#vehicle-form').find('[name="assigned_to"]').val(response.assigned_to).change();
      $('#vehicle-form').find('[name="notes"]').val(response.notes);
    });
  }

  // Form validation and submission
  $(function () {
    // Form validation and submission
    appValidateForm($('#vehicle-form'), {
      plate_number: 'required',
      registration_number: 'required',
      model: 'required',
      type: 'required',
      registration_expiry: 'required'
    }, function (form) {
      var data = $(form).serialize();
      var url = form.action;

      // Show loading indicator
      var submitBtn = $(form).find('[type="submit"]');
      submitBtn.prop('disabled', true);

      $.ajax({
        url: url,
        type: 'POST',
        data: data,
        dataType: 'json',  // Expect JSON response
        success: function (response) {
          if (response.success) {
            alert_float('success', response.message);
            $('#vehicle_modal').modal('hide');
            $('.table-vehicles').DataTable().ajax.reload();
          } else {
            alert_float('danger', response.message || 'Error occurred');
          }
        },
        error: function (xhr, textStatus, errorThrown) {
          alert_float('danger', 'Request failed: ' + errorThrown);
          console.error(xhr.responseText);
        },
        complete: function () {
          submitBtn.prop('disabled', false);
        }
      });

      return false;
    });

    // Initialize DataTable
    initDataTable('.table-vehicles',
      '<?php echo admin_url("regulation/get_vehicles_table"); ?>',
      [6], // not sortable
      [6], // not searchable
      undefined,
      [0, 'asc']
    );
  });
</script>
</body>

</html>