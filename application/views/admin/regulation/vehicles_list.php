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

            <?php if (has_permission('fixed_assets', '', 'create')) { ?>
              <a href="<?php echo admin_url('fixed_assets/asset?category=vehicle'); ?>"
                class="btn btn-info pull-left display-block">
                <i class="fa fa-plus"></i> <?php echo _l('new_vehicle'); ?>
              </a>
              <div class="clearfix"></div>
              <hr class="hr-panel-heading" />
            <?php } ?>

            <table class="table dt-table">
              <thead>
                <tr>
                  <th><?php echo _l('vehicle_name'); ?></th>
                  <th><?php echo _l('vehicle_model'); ?></th>
                  <th><?php echo _l('vehicle_plate'); ?></th>
                  <th><?php echo _l('vehicle_registration_expiry'); ?></th>
                  <th><?php echo _l('current_post'); ?></th>
                  <th><?php echo _l('vehicle_status'); ?></th>
                  <th><?php echo _l('options'); ?></th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($vehicles as $vehicle) { ?>
                  <tr>
                    <td><?php echo $vehicle['name']; ?></td>
                    <td><?php echo $vehicle['model']; ?></td>
                    <td><?php echo $vehicle['custom_field_plate'] ?? ''; ?></td>
                    <td><?php echo _d($vehicle['custom_field_registration_expiry'] ?? ''); ?></td>
                    <td><?php echo $vehicle['post_name'] ?? _l('not_assigned'); ?></td>
                    <td><?php echo _l('vehicle_status_' . $vehicle['status']); ?></td>
                    <td>
                      <div class="btn-group">
                        <?php if (has_permission('fixed_assets', '', 'edit')) { ?>
                          <a href="<?php echo admin_url('fixed_assets/asset/' . $vehicle['id']); ?>"
                            class="btn btn-default btn-icon"><i class="fa fa-pencil"></i></a>
                        <?php } ?>
                        <?php if (has_permission('regulation', '', 'edit')) { ?>
                          <a href="#" onclick="assign_vehicle(<?php echo $vehicle['id']; ?>); return false;"
                            class="btn btn-info btn-icon"><i class="fa fa-link"></i></a>
                        <?php } ?>
                      </div>
                    </td>
                  </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php init_tail(); ?>

<script>
  function assign_vehicle(id) {
    var url = admin_url + 'regulation/assign_vehicle/' + id;
    $.get(url, function (response) {
      $('#modal_wrapper').html(response);
      $('#assign_vehicle_modal').modal('show');
      init_selectpicker();
    });
  }

  $('body').append('<div id="modal_wrapper"></div>');
</script>
</body>

</html>