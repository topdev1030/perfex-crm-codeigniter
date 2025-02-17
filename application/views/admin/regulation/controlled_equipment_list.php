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

            <?php if (has_permission('regulation', '', 'create')) { ?>
              <a href="#" onclick="new_equipment(); return false;" class="btn btn-primary pull-left display-block">
                <i class="fa fa-plus"></i> <?php echo _l('new_equipment'); ?>
              </a>
              <div class="clearfix"></div>
              <hr class="hr-panel-heading" />
            <?php } ?>

            <table class="table dt-table">
              <thead>
                <tr>
                  <th><?php echo _l('equipment_type'); ?></th>
                  <th><?php echo _l('equipment_serial_number'); ?></th>
                  <th><?php echo _l('equipment_model'); ?></th>
                  <th><?php echo _l('equipment_acquisition_date'); ?></th>
                  <th><?php echo _l('equipment_expiry_date'); ?></th>
                  <th><?php echo _l('equipment_status'); ?></th>
                  <th><?php echo _l('options'); ?></th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($equipment as $item) { ?>
                  <tr>
                    <td><?php echo $item['type']; ?></td>
                    <td><?php echo $item['serial_number']; ?></td>
                    <td><?php echo $item['model']; ?></td>
                    <td><?php echo _d($item['acquisition_date']); ?></td>
                    <td><?php echo $item['expiry_date'] ? _d($item['expiry_date']) : ''; ?></td>
                    <td><?php echo _l('equipment_status_' . $item['status']); ?></td>
                    <td>
                      <div class="btn-group">
                        <?php if (has_permission('regulation', '', 'edit')) { ?>
                          <a href="#" onclick="edit_equipment(<?php echo $item['id']; ?>); return false;"
                            class="btn btn-default btn-icon"><i class="fa fa-pencil"></i></a>
                        <?php } ?>
                        <?php if (has_permission('regulation', '', 'delete')) { ?>
                          <a href="<?php echo admin_url('regulation/delete_equipment/' . $item['id']); ?>"
                            class="btn btn-danger btn-icon _delete"><i class="fa fa-remove"></i></a>
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
  function new_equipment() {
    var url = admin_url + 'regulation/equipment';
    $.get(url, function (response) {
      $('#modal_wrapper').html(response);
      $('#equipment_modal').modal('show');
      init_selectpicker();
    });
  }

  function edit_equipment(id) {
    var url = admin_url + 'regulation/equipment/' + id;
    $.get(url, function (response) {
      $('#modal_wrapper').html(response);
      $('#equipment_modal').modal('show');
      init_selectpicker();
    });
  }

  $('body').append('<div id="modal_wrapper"></div>');
</script>
</body>

</html>