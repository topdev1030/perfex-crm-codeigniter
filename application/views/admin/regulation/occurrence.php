<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="modal fade" id="occurrence_modal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
            aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><?php echo $title; ?></h4>
      </div>
      <?php echo form_open_multipart(admin_url('regulation/occurrence/' . (isset($occurrence) ? $occurrence['id'] : '')), ['id' => 'occurrence-form']); ?>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="post_id"><?php echo _l('service_post'); ?></label>
              <select name="post_id" class="selectpicker" data-width="100%" data-live-search="true">
                <option value=""><?php echo _l('select_post'); ?></option>
                <?php foreach ($posts as $post) { ?>
                  <option value="<?php echo $post['id']; ?>" <?php if (isset($occurrence) && $occurrence['post_id'] == $post['id'])
                       echo 'selected'; ?>>
                    <?php echo $post['name']; ?>
                  </option>
                <?php } ?>
              </select>
            </div>
            <div class="form-group">
              <label for="occurrence_datetime"><?php echo _l('occurrence_datetime'); ?></label>
              <input type="text" class="form-control datetimepicker" name="occurrence_datetime" required
                value="<?php echo (isset($occurrence) ? _dt($occurrence['occurrence_datetime']) : ''); ?>">
            </div>
            <div class="form-group">
              <label for="status"><?php echo _l('status'); ?></label>
              <select name="status" class="selectpicker" data-width="100%" required>
                <option value="registered" <?php if (isset($occurrence) && $occurrence['status'] == 'registered')
                  echo 'selected'; ?>>
                  <?php echo _l('registered'); ?>
                </option>
                <option value="under_investigation" <?php if (isset($occurrence) && $occurrence['status'] == 'under_investigation')
                  echo 'selected'; ?>>
                  <?php echo _l('under_investigation'); ?>
                </option>
                <option value="completed" <?php if (isset($occurrence) && $occurrence['status'] == 'completed')
                  echo 'selected'; ?>>
                  <?php echo _l('completed'); ?>
                </option>
              </select>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="involved_staff"><?php echo _l('involved_staff'); ?></label>
              <select name="involved_staff[]" class="selectpicker" data-width="100%" data-live-search="true" multiple>
                <?php foreach ($staff_members as $staff) { ?>
                  <option value="<?php echo $staff['staffid']; ?>" <?php if (isset($occurrence) && in_array($staff['staffid'], json_decode($occurrence['involved_staff'])))
                       echo 'selected'; ?>>
                    <?php echo $staff['full_name']; ?>
                  </option>
                <?php } ?>
              </select>
            </div>
            <div class="form-group">
              <label for="involved_equipment"><?php echo _l('involved_equipment'); ?></label>
              <select name="involved_equipment[]" class="selectpicker" data-width="100%" data-live-search="true"
                multiple>
                <?php foreach ($equipment as $item) { ?>
                  <option value="<?php echo $item['id']; ?>" <?php if (isset($occurrence) && in_array($item['id'], json_decode($occurrence['involved_equipment'])))
                       echo 'selected'; ?>>
                    <?php echo $item['type'] . ' - ' . $item['serial_number']; ?>
                  </option>
                <?php } ?>
              </select>
            </div>
            <div class="form-group">
              <label for="attachments"><?php echo _l('attachments'); ?></label>
              <input type="file" class="form-control" name="attachments[]" multiple>
            </div>
          </div>
          <div class="col-md-12">
            <div class="form-group">
              <label for="description"><?php echo _l('description'); ?></label>
              <textarea name="description" class="form-control" rows="6"
                required><?php echo (isset($occurrence) ? $occurrence['description'] : ''); ?></textarea>
            </div>
          </div>
          <?php if (isset($attachments) && count($attachments) > 0) { ?>
            <div class="col-md-12">
              <hr />
              <h5><?php echo _l('existing_attachments'); ?></h5>
              <div class="row">
                <?php foreach ($attachments as $attachment) { ?>
                  <div class="col-md-4">
                    <div class="attachment-item">
                      <a href="<?php echo base_url('uploads/occurrences/' . $occurrence['id'] . '/' . $attachment['file_name']); ?>"
                        target="_blank">
                        <?php echo $attachment['file_name']; ?>
                      </a>
                    </div>
                  </div>
                <?php } ?>
              </div>
            </div>
          <?php } ?>
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
      // post_id: 'required',
      occurrence_datetime: 'required',
      description: 'required',
      status: 'required'
    }, function (form) {
      var formData = new FormData(form);
      $.ajax({
        url: form.action,
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
          response = JSON.parse(response);
          if (response.success) {
            alert_float('success', response.message);
            if (response.redirect_url) {
              window.location.href = response.redirect_url;
            }
          }
        }
      });
      return false;
    });

    $('.datetimepicker').datetimepicker({
      format: app.options.datetime_format,
      showClose: true,
      icons: {
        time: "fa fa-clock-o",
        date: "fa fa-calendar",
        up: "fa fa-chevron-up",
        down: "fa fa-chevron-down"
      }
    });
  });
</script>