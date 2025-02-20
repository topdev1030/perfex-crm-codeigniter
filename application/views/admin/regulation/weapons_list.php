<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
  <div class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="panel_s">
          <div class="panel-body">
            <?php if (staff_can('create', 'regulation')) { ?>
              <div class="_buttons">
                <a href="#" onclick="new_weapon(); return false;" class="btn btn-primary pull-left display-block">
                  <?php echo _l('new_weapon'); ?>
                </a>
              </div>
              <div class="clearfix"></div>
              <hr class="hr-panel-heading" />
            <?php } ?>
            <div class="clearfix"></div>
            <table class="table dt-table table-weapons" data-order-col="1" data-order-type="asc">
              <thead>
                <tr>
                  <th><?php echo _l('id'); ?></th>
                  <th><?php echo _l('serial_number'); ?></th>
                  <th><?php echo _l('type'); ?></th>
                  <th><?php echo _l('model'); ?></th>
                  <th><?php echo _l('caliber'); ?></th>
                  <th><?php echo _l('license_expiry'); ?></th>
                  <th><?php echo _l('status'); ?></th>
                  <th><?php echo _l('options'); ?></th>
                </tr>
              </thead>
              <tbody>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="weapon_modal" tabindex="-1" role="dialog">
  <div class="modal-dialog">
    <?php echo form_open(admin_url('regulation/weapon'), ['id' => 'weapon-form']); ?>
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
            aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">
          <span class="edit-title"><?php echo _l('edit_weapon'); ?></span>
          <span class="add-title"><?php echo _l('new_weapon'); ?></span>
        </h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12">
            <div id="additional"></div>
            <?php echo render_input('serial_number', 'serial_number'); ?>
            <?php echo render_input('type', 'type'); ?>
            <?php echo render_input('model', 'model'); ?>
            <?php echo render_input('caliber', 'caliber'); ?>
            <?php echo render_input('manufacturer', 'manufacturer'); ?>
            <?php echo render_input('registration_number', 'registration_number'); ?>
            <?php echo render_input('license_number', 'license_number'); ?>
            <?php echo render_date_input('license_expiry', 'license_expiry'); ?>
            <?php echo render_date_input('acquisition_date', 'acquisition_date'); ?>
            <?php echo render_date_input('last_maintenance', 'last_maintenance'); ?>
            <?php echo render_date_input('next_maintenance', 'next_maintenance'); ?>
            <?php echo render_select('status', [
              ['id' => 'active', 'name' => _l('active')],
              ['id' => 'inactive', 'name' => _l('inactive')],
              ['id' => 'maintenance', 'name' => _l('maintenance')],
              ['id' => 'assigned', 'name' => _l('assigned')]
            ], 'id', 'name', '', [], [], 'status'); ?>
            <?php echo render_select('assigned_to', $staff_members, ['staffid', ['firstname', 'lastname']], 'assigned_to'); ?>
            <?php echo render_date_input('assigned_date', 'assigned_date'); ?>
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
<?php init_tail(); ?>
<script>
  $(function () {
    var tAPI = initDataTable('.table-weapons',
      '<?php echo admin_url("regulation/get_weapons_table"); ?>',
      [7], // not sortable
      [7], // not searchable
      undefined,
      [1, 'asc']
    );

    appValidateForm($('#weapon-form'), {
      serial_number: 'required',
      type: 'required',
      model: 'required',
      caliber: 'required',
      registration_number: 'required',
      license_number: 'required',
      license_expiry: 'required',
      acquisition_date: 'required'
    }, function (form) {
      var data = $(form).serialize();
      var url = form.action;
      $.post(url, data).done(function (response) {
        response = JSON.parse(response);
        if (response.success) {
          alert_float('success', response.message);
          $('#weapon_modal').modal('hide');
          $('.table-weapons').DataTable().ajax.reload();
          if (response.redirect_url) {
            setTimeout(function () {
              window.location.href = response.redirect_url;
            }, 1000);
          }
        }
      });
      return false;
    });
  });

  function new_weapon() {
    $('#weapon_modal').modal('show');
    $('.edit-title').addClass('hide');
    $('.add-title').removeClass('hide');
    $('#weapon-form').attr('action', admin_url + 'regulation/weapon');
    $('#weapon-form')[0].reset();
    $('#additional').html('');
  }

  function edit_weapon(id) {
    $('#additional').html('<input type="hidden" name="id" value="' + id + '">');
    $('#weapon_modal').modal('show');
    $('.add-title').addClass('hide');
    $('.edit-title').removeClass('hide');
    $('#weapon-form').attr('action', admin_url + 'regulation/weapon/' + id);
    $('#weapon-form')[0].reset();

    requestGet('regulation/weapon/' + id).done(function (response) {
      response = JSON.parse(response);
      $('#weapon-form').find('[name="serial_number"]').val(response.serial_number);
      $('#weapon-form').find('[name="type"]').val(response.type);
      $('#weapon-form').find('[name="model"]').val(response.model);
      $('#weapon-form').find('[name="caliber"]').val(response.caliber);
      $('#weapon-form').find('[name="manufacturer"]').val(response.manufacturer);
      $('#weapon-form').find('[name="registration_number"]').val(response.registration_number);
      $('#weapon-form').find('[name="license_number"]').val(response.license_number);
      $('#weapon-form').find('[name="license_expiry"]').val(response.license_expiry);
      $('#weapon-form').find('[name="acquisition_date"]').val(response.acquisition_date);
      $('#weapon-form').find('[name="last_maintenance"]').val(response.last_maintenance);
      $('#weapon-form').find('[name="next_maintenance"]').val(response.next_maintenance);
      $('#weapon-form').find('[name="status"]').val(response.status).change();
      $('#weapon-form').find('[name="assigned_to"]').val(response.assigned_to).change();
      $('#weapon-form').find('[name="assigned_date"]').val(response.assigned_date);
      $('#weapon-form').find('[name="notes"]').val(response.notes);
    });
  }
</script>
</body>

</html>