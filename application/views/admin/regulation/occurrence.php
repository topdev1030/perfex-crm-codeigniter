<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="modal fade" id="occurrence_modal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
            aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><?php echo $title; ?></h4>
      </div>
      <?php echo form_open(admin_url('regulation/occurrence/' . (isset($occurrence) ? $occurrence['id'] : '')), ['id' => 'occurrence-form']); ?>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="post_id"><?php echo _l('occurrence_station'); ?></label>
              <select class="form-control selectpicker" name="post_id" required data-live-search="true">
                <?php foreach ($stations as $station) { ?>
                  <option value="<?php echo $station['id']; ?>" <?php echo (isset($occurrence) && $occurrence['post_id'] == $station['id'] ? 'selected' : ''); ?>>
                    <?php echo $station['name']; ?>
                  </option>
                <?php } ?>
              </select>
            </div>
            <div class="form-group">
              <label for="occurrence_date"><?php echo _l('occurrence_date'); ?></label>
              <input type="text" class="form-control datetimepicker" name="occurrence_date" required
                value="<?php echo (isset($occurrence) ? _dt($occurrence['occurrence_date']) : ''); ?>">
            </div>
            <div class="form-group">
              <label for="occurrence_type"><?php echo _l('occurrence_type'); ?></label>
              <input type="text" class="form-control" name="occurrence_type" required
                value="<?php echo (isset($occurrence) ? $occurrence['occurrence_type'] : ''); ?>">
            </div>
            <div class="form-group">
              <label for="status"><?php echo _l('occurrence_status'); ?></label>
              <select class="form-control selectpicker" name="status" required>
                <option value="registered" <?php echo (isset($occurrence) && $occurrence['status'] == 'registered' ? 'selected' : ''); ?>><?php echo _l('occurrence_status_registered'); ?></option>
                <option value="under_investigation" <?php echo (isset($occurrence) && $occurrence['status'] == 'under_investigation' ? 'selected' : ''); ?>>
                  <?php echo _l('occurrence_status_under_investigation'); ?>
                </option>
                <option value="completed" <?php echo (isset($occurrence) && $occurrence['status'] == 'completed' ? 'selected' : ''); ?>><?php echo _l('occurrence_status_completed'); ?></option>
              </select>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="involved_guards"><?php echo _l('occurrence_involved_guards'); ?></label>
              <select class="form-control selectpicker" name="involved_guards[]" multiple data-live-search="true">
                <?php foreach ($staff_members as $staff) { ?>
                  <option value="<?php echo $staff['staffid']; ?>" <?php echo (isset($occurrence) && in_array($staff['staffid'], json_decode($occurrence['involved_guards'])) ? 'selected' : ''); ?>>
                    <?php echo $staff['full_name']; ?>
                  </option>
                <?php } ?>
              </select>
            </div>
            <div class="form-group">
              <label for="involved_equipment"><?php echo _l('occurrence_involved_equipment'); ?></label>
              <select class="form-control selectpicker" name="involved_equipment[]" multiple data-live-search="true">
                <?php foreach ($equipment as $item) { ?>
                  <option value="<?php echo $item['id']; ?>" <?php echo (isset($occurrence) && in_array($item['id'], json_decode($occurrence['involved_equipment'])) ? 'selected' : ''); ?>>
                    <?php echo $item['serial_number']; ?>
                  </option>
                <?php } ?>
              </select>
            </div>
          </div>
          <div class="col-md-12">
            <div class="form-group">
              <label for="description"><?php echo _l('occurrence_description'); ?></label>
              <textarea class="form-control" name="description" rows="6"
                required><?php echo (isset($occurrence) ? $occurrence['description'] : ''); ?></textarea>
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
    appValidateForm($('#occurrence-form'), {
      post_id: 'required',
      occurrence_date: 'required',
      occurrence_type: 'required',
      status: 'required',
      description: 'required'
    });

    init_datepicker();
    $('.datetimepicker').datetimepicker({
      format: app.options.datetime_format,
      date: new Date()
    });
  });
</script>