<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
  <div class="content">
    <div class="row">
      <div class="col-md-12">
        <h4 class="no-margin"><?php echo $title; ?></h4>
        <hr class="hr-panel-heading" />
        <?php echo form_open(); ?>
        <div class="form-group">
          <label for="name"><?php echo _l('station_name'); ?></label>
          <input type="text" class="form-control" name="name"
            value="<?php echo isset($station) ? $station['name'] : ''; ?>" required>
        </div>
        <div class="form-group">
          <label for="contract"><?php echo _l('contract'); ?></label>
          <select class="form-control selectpicker" name="contract" required>
            <?php foreach ($contracts as $contract) { ?>
              <option value="<?php echo $contract['id']; ?>" <?php echo isset($station) && $station['contract'] == $contract['id'] ? 'selected' : ''; ?>>
                <?php echo $contract['client']; ?>
              </option>
            <?php } ?>
          </select>
        </div>
        <div class="form-group">
          <label for="address"><?php echo _l('address'); ?></label>
          <input type="text" class="form-control" name="address"
            value="<?php echo isset($station) ? $station['address'] : ''; ?>" required>
        </div>
        <div class="form-group">
          <label for="items"><?php echo _l('items'); ?></label>
          <select class="form-control selectpicker" name="items[]" multiple>
            <?php foreach ($items as $item) { ?>
              <option value="<?php echo $item['id']; ?>" <?php echo isset($station) && in_array($item['id'], explode(',', $station['items'])) ? 'selected' : ''; ?>>
                <?php echo $item['id']; ?>
              </option>
            <?php } ?>
          </select>
        </div>
        <button type="submit" class="btn btn-primary"><?php echo _l('submit'); ?></button>
        <?php echo form_close(); ?>
      </div>
    </div>
  </div>
</div>
<?php init_tail(); ?>