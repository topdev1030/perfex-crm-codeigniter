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

            <!-- Update Add New Button to trigger modal -->
            <?php if (has_permission('regulation', '', 'create')) { ?>
              <a href="#" onclick="new_vest(); return false;" class="btn btn-primary pull-left display-block">
                <i class="fa fa-plus"></i> <?php echo _l('new_vest'); ?>
              </a>
              <div class="clearfix"></div>
              <hr class="hr-panel-heading" />
            <?php } ?>

            <!-- Vests Table -->
            <table class="table dt-table">
              <thead>
                <tr>
                  <th><?php echo _l('vest_serial_number'); ?></th>
                  <th><?php echo _l('vest_manufacturer'); ?></th>
                  <th><?php echo _l('vest_protection_level'); ?></th>
                  <th><?php echo _l('vest_manufacturing_date'); ?></th>
                  <th><?php echo _l('vest_expiry_date'); ?></th>
                  <th><?php echo _l('vest_status'); ?></th>
                  <th><?php echo _l('options'); ?></th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($vests as $vest) { ?>
                  <tr>
                    <td><?php echo $vest['serial_number']; ?></td>
                    <td><?php echo $vest['manufacturer']; ?></td>
                    <td><?php echo $vest['protection_level']; ?></td>
                    <td><?php echo $vest['manufacturing_date']; ?></td>
                    <td><?php echo $vest['expiry_date']; ?></td>
                    <td><?php echo $vest['status']; ?></td>
                    <td>
                      <!-- Action buttons will go here -->
                      <div class="btn-group">
                        <a href="#" class="btn btn-default btn-icon"><i class="fa fa-eye"></i></a>
                        <?php if (has_permission('regulation', '', 'edit')) { ?>
                          <a href="#" onclick="edit_vest(<?php echo $vest['id']; ?>); return false;"
                            class="btn btn-default btn-icon"><i class="fa fa-pencil"></i></a>
                        <?php } ?>
                        <?php if (has_permission('regulation', '', 'delete')) { ?>
                          <a href="<?php echo admin_url('regulation/delete_vest/' . $vest['id']); ?>"
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
  // Add this JavaScript code at the bottom of the file
  function new_vest() {
    var url = admin_url + 'regulation/vest';
    $.get(url, function (response) {
      $('#modal_wrapper').html(response);
      $('#vest_modal').modal('show');
      init_selectpicker();
    });
  }

  function edit_vest(id) {
    var url = admin_url + 'regulation/vest/' + id;
    $.get(url, function (response) {
      $('#modal_wrapper').html(response);
      $('#vest_modal').modal('show');
      init_selectpicker();
    });
  }

  // Add modal wrapper div
  $('body').append('<div id="modal_wrapper"></div>');
</script>
</body>

</html>