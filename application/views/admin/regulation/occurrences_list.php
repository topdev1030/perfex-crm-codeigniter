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
              <a href="#" onclick="new_occurrence(); return false;" class="btn btn-primary pull-left display-block">
                <i class="fa fa-plus"></i> <?php echo _l('new_occurrence'); ?>
              </a>
              <div class="clearfix"></div>
              <hr class="hr-panel-heading" />
            <?php } ?>

            <table class="table dt-table">
              <thead>
                <tr>
                  <th><?php echo _l('occurrence_date'); ?></th>
                  <th><?php echo _l('occurrence_type'); ?></th>
                  <th><?php echo _l('occurrence_station'); ?></th>
                  <th><?php echo _l('occurrence_status'); ?></th>
                  <th><?php echo _l('occurrence_created_by'); ?></th>
                  <th><?php echo _l('options'); ?></th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($occurrences as $occurrence) { ?>
                  <tr>
                    <td><?php echo _dt($occurrence['occurrence_date']); ?></td>
                    <td><?php echo $occurrence['occurrence_type']; ?></td>
                    <td><?php echo $occurrence['post_id']; ?></td>
                    <td><?php echo _l('occurrence_status_' . $occurrence['status']); ?></td>
                    <td><?php echo $occurrence['firstname'] . ' ' . $occurrence['lastname']; ?></td>
                    <td>
                      <div class="btn-group">
                        <?php if (has_permission('regulation', '', 'edit')) { ?>
                          <a href="#" onclick="edit_occurrence(<?php echo $occurrence['id']; ?>); return false;"
                            class="btn btn-default btn-icon"><i class="fa fa-pencil"></i></a>
                        <?php } ?>
                        <?php if (has_permission('regulation', '', 'delete')) { ?>
                          <a href="<?php echo admin_url('regulation/delete_occurrence/' . $occurrence['id']); ?>"
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
  function new_occurrence() {
    var url = admin_url + 'regulation/occurrence';
    $.get(url, function (response) {
      $('#modal_wrapper').html(response);
      $('#occurrence_modal').modal('show');
      init_selectpicker();
      init_datepicker();
    });
  }

  function edit_occurrence(id) {
    var url = admin_url + 'regulation/occurrence/' + id;
    $.get(url, function (response) {
      $('#modal_wrapper').html(response);
      $('#occurrence_modal').modal('show');
      init_selectpicker();
      init_datepicker();
    });
  }

  $('body').append('<div id="modal_wrapper"></div>');
</script>
</body>

</html>