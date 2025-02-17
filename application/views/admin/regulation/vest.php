<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="modal fade" id="vest_modal" tabindex="-1" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
            aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><?php echo $title; ?></h4>
      </div>
      <?php echo form_open(admin_url('regulation/vest/' . (isset($vest) ? $vest['id'] : '')), ['id' => 'vest-form']); ?>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <label for="serial_number"><?php echo _l('vest_serial_number'); ?></label>
              <input type="text" class="form-control" name="serial_number" required
                value="<?php echo (isset($vest) ? $vest['serial_number'] : ''); ?>">
            </div>
            <div class="form-group">
              <label for="manufacturer"><?php echo _l('vest_manufacturer'); ?></label>
              <input type="text" class="form-control" name="manufacturer" required
                value="<?php echo (isset($vest) ? $vest['manufacturer'] : ''); ?>">
            </div>
            <div class="form-group">
              <label for="protection_level"><?php echo _l('vest_protection_level'); ?></label>
              <input type="text" class="form-control" name="protection_level" required
                value="<?php echo (isset($vest) ? $vest['protection_level'] : ''); ?>">
            </div>
            <div class="form-group">
              <label for="manufacturing_date"><?php echo _l('vest_manufacturing_date'); ?></label>
              <input type="text" class="form-control datepicker" name="manufacturing_date" required
                value="<?php echo (isset($vest) ? _d($vest['manufacturing_date']) : ''); ?>">
            </div>
            <div class="form-group">
              <label for="expiry_date"><?php echo _l('vest_expiry_date'); ?></label>
              <input type="text" class="form-control datepicker" name="expiry_date" required
                value="<?php echo (isset($vest) ? _d($vest['expiry_date']) : ''); ?>">
            </div>
            <div class="form-group">
              <label for="status"><?php echo _l('vest_status'); ?></label>
              <select class="form-control selectpicker" name="status" required>
                <option value="active" <?php echo (isset($vest) && $vest['status'] == 'active' ? 'selected' : ''); ?>>
                  <?php echo _l('vest_status_active'); ?>
                </option>
                <option value="inactive" <?php echo (isset($vest) && $vest['status'] == 'inactive' ? 'selected' : ''); ?>>
                  <?php echo _l('vest_status_inactive'); ?>
                </option>
                <option value="maintenance" <?php echo (isset($vest) && $vest['status'] == 'maintenance' ? 'selected' : ''); ?>><?php echo _l('vest_status_maintenance'); ?></option>
              </select>
            </div>
            <div class="form-group">
              <label for="notes"><?php echo _l('vest_notes'); ?></label>
              <textarea class="form-control" name="notes"
                rows="4"><?php echo (isset($vest) ? $vest['notes'] : ''); ?></textarea>
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
    appValidateForm($('#vest-form'), {
      serial_number: 'required',
      manufacturer: 'required',
      protection_level: 'required',
      manufacturing_date: 'required',
      expiry_date: 'required',
      status: 'required'
    });

    $('.datepicker').datetimepicker({
      format: app.options.date_format,
      date: new Date(),
      icons: {
        time: "fa fa-clock-o",
        date: "fa fa-calendar",
        up: "fa fa-chevron-up",
        down: "fa fa-chevron-down"
      }
    });
  });
</script>