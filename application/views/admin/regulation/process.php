<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="modal fade" id="process_modal" tabindex="-1" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
            aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><?php echo $title; ?></h4>
      </div>
      <?php echo form_open(admin_url('regulation/process/' . (isset($process) ? $process['id'] : '')), ['id' => 'process-form']); ?>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <label for="process_type"><?php echo _l('process_type'); ?></label>
              <input type="text" class="form-control" name="process_type" required
                value="<?php echo (isset($process) ? $process['process_type'] : ''); ?>">
            </div>
            <div class="form-group">
              <label for="process_number"><?php echo _l('process_number'); ?></label>
              <input type="text" class="form-control" name="process_number" required
                value="<?php echo (isset($process) ? $process['process_number'] : ''); ?>">
            </div>
            <div class="form-group">
              <label for="status"><?php echo _l('process_status'); ?></label>
              <select class="form-control selectpicker" name="status" required>
                <option value="pending" <?php echo (isset($process) && $process['status'] == 'pending' ? 'selected' : ''); ?>><?php echo _l('process_status_pending'); ?></option>
                <option value="in_progress" <?php echo (isset($process) && $process['status'] == 'in_progress' ? 'selected' : ''); ?>><?php echo _l('process_status_in_progress'); ?></option>
                <option value="completed" <?php echo (isset($process) && $process['status'] == 'completed' ? 'selected' : ''); ?>><?php echo _l('process_status_completed'); ?></option>
                <option value="cancelled" <?php echo (isset($process) && $process['status'] == 'cancelled' ? 'selected' : ''); ?>><?php echo _l('process_status_cancelled'); ?></option>
              </select>
            </div>
            <div class="form-group">
              <label for="date"><?php echo _l('process_date'); ?></label>
              <input type="text" class="form-control datepicker" name="date" required
                value="<?php echo (isset($process) ? _d($process['date']) : ''); ?>">
            </div>
            <div class="form-group">
              <label for="completion_date"><?php echo _l('process_completion_date'); ?></label>
              <input type="text" class="form-control datepicker" name="completion_date"
                value="<?php echo (isset($process) && $process['completion_date'] ? _d($process['completion_date']) : ''); ?>">
            </div>
            <div class="form-group">
              <label for="responsible_id"><?php echo _l('process_responsible'); ?></label>
              <select class="form-control selectpicker" name="responsible_id" required data-live-search="true">
                <?php foreach ($staff_members as $staff) { ?>
                  <option value="<?php echo $staff['staffid']; ?>" <?php echo (isset($process) && $process['responsible_id'] == $staff['staffid'] ? 'selected' : ''); ?>>
                    <?php echo $staff['full_name']; ?>
                  </option>
                <?php } ?>
              </select>
            </div>
            <div class="form-group">
              <label for="description"><?php echo _l('process_description'); ?></label>
              <textarea class="form-control" name="description"
                rows="4"><?php echo (isset($process) ? $process['description'] : ''); ?></textarea>
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
    appValidateForm($('#process-form'), {
      process_type: 'required',
      process_number: 'required',
      status: 'required',
      date: 'required',
      completion_date: 'required',
      responsible_id: 'required'
    }, function (form) {
      $.post(form.action, $(form).serialize())
        .done(function (response) {
          response = JSON.parse(response);
          if (response.success) {
            if (response.redirect_url) {
              window.location.href = response.redirect_url;
            }
          } else {
            alert_float('danger', response.message);
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