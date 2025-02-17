<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="modal fade" id="assign_vehicle_modal" tabindex="-1" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
            aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><?php echo $title; ?></h4>
      </div>
      <?php echo form_open(admin_url('regulation/assign_vehicle/' . $vehicle['id']), ['id' => 'assign-vehicle-form']); ?>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <label for="vehicle_info"><?php echo _l('vehicle'); ?></label>
              <input type="text" class="form-control" readonly
                value="<?php echo $vehicle['name'] . ' - ' . $vehicle['model']; ?>">
              <input type="hidden" name="item_id" value="<?php echo $vehicle['id']; ?>">
            </div>
            <div class="form-group">
              <label for="post_id"><?php echo _l('service_post'); ?></label>
              <select class="form-control selectpicker" name="post_id" required data-live-search="true">
                <option value=""><?php echo _l('select_post'); ?></option>
                <?php foreach ($posts as $post) { ?>
                  <option value="<?php echo $post['id']; ?>"><?php echo $post['name']; ?></option>
                <?php } ?>
              </select>
            </div>
            <div class="form-group">
              <label for="notes"><?php echo _l('notes'); ?></label>
              <textarea class="form-control" name="notes" rows="3"></textarea>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo _l('close'); ?></button>
        <button type="submit" class="btn btn-info"><?php echo _l('submit'); ?></button>
      </div>
      <?php echo form_close(); ?>
    </div>
  </div>
</div>

<script>
  $(function () {
    appValidateForm($('#assign-vehicle-form'), {
      post_id: 'required'
    });
  });
</script>