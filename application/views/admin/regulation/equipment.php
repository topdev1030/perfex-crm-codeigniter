<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="modal fade" id="equipment_modal" tabindex="-1" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
            aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><?php echo $title; ?></h4>
      </div>
      <?php echo form_open(admin_url('regulation/equipment/' . (isset($equipment) ? $equipment['id'] : '')), ['id' => 'equipment-form']); ?>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <label for="type"><?php echo _l('equipment_type'); ?></label>
              <input type="text" class="form-control" name="type" required
                value="<?php echo (isset($equipment) ? $equipment['type'] : ''); ?>">
            </div>
            <div class="form-group">
              <label for="serial_number"><?php echo _l('equipment_serial_number'); ?></label>
              <input type="text" class="form-control" name="serial_number" required
                value="<?php echo (isset($equipment) ? $equipment['serial_number'] : ''); ?>">
            </div>
            <div class="form-group">
              <label for="model"><?php echo _l('equipment_model'); ?></label>
              <input type="text" class="form-control" name="model" required
                value="<?php echo (isset($equipment) ? $equipment['model'] : ''); ?>">
            </div>
            <div class="form-group">
              <label for="acquisition_date"><?php echo _l('equipment_acquisition_date'); ?></label>
              <input type="text" class="form-control datepicker" name="acquisition_date" required
                value="<?php echo (isset($equipment) ? _d($equipment['acquisition_date']) : ''); ?>">
            </div>
            <div class="form-group">
              <label for="expiry_date"><?php echo _l('equipment_expiry_date'); ?></label>
              <input type="text" class="form-control datepicker" name="expiry_date"
                value="<?php echo (isset($equipment) && $equipment['expiry_date'] ? _d($equipment['expiry_date']) : ''); ?>">
            </div>
            <div class="form-group">
              <label for="status"><?php echo _l('equipment_status'); ?></label>
              <select class="form-control selectpicker" name="status" required>
                <option value="active" <?php echo (isset($equipment) && $equipment['status'] == 'active' ? 'selected' : ''); ?>><?php echo _l('equipment_status_active'); ?></option>
                <option value="inactive" <?php echo (isset($equipment) && $equipment['status'] == 'inactive' ? 'selected' : ''); ?>><?php echo _l('equipment_status_inactive'); ?></option>
                <option value="maintenance" <?php echo (isset($equipment) && $equipment['status'] == 'maintenance' ? 'selected' : ''); ?>><?php echo _l('equipment_status_maintenance'); ?></option>
              </select>
            </div>
            <div class="form-group">
              <label for="notes"><?php echo _l('equipment_notes'); ?></label>
              <textarea class="form-control" name="notes"
                rows="4"><?php echo (isset($equipment) ? $equipment['notes'] : ''); ?></textarea>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo _l('close'); ?></button>
        <button type="submit" class="btn btn-primary"><?php echo _l('submit'); ?></button>
      </div>
      <?php echo form_close(); ?>
    </div>
  </div>
</div>

<script>
  $(function () {
    appValidateForm($('#equipment-form'), {
      type: 'required',
      serial_number: 'required',
      model: 'required',
      acquisition_date: 'required',
      status: 'required'
    }, function (form) {
      $.post(form.action, $(form).serialize())
        .done(function (response) {
          response = JSON.parse(response);
          if (response.success) {
            if (response.redirect_url) {
              window.location.href = response.redirect_url;
            }
          }
        });
      return false;
    });

    $('.datepicker').datetimepicker({
      format: app.options.date_format,
      timepicker: false,
      ignoreReadonly: true,
      showClose: true,
      icons: {
        date: "fa fa-calendar",
        up: "fa fa-chevron-up",
        down: "fa fa-chevron-down"
      }
    });
  });
</script>