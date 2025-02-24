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

            <div class="_buttons">
              <?php if (has_permission('regulation', '', 'create')) { ?>
                <a href="#" onclick="new_occurrence(); return false;" class="btn btn-primary pull-left display-block">
                  <i class="fa fa-plus"></i> <?php echo _l('new_occurrence'); ?>
                </a>
              <?php } ?>
            </div>
            <div class="clearfix"></div>
            <hr class="hr-panel-heading" />
            <div class="clearfix"></div>

            <table class="table table-striped table-occurrences">
              <thead>
                <tr>
                  <th><?php echo _l('occurrence_datetime'); ?></th>
                  <th><?php echo _l('occurrence_post'); ?></th>
                  <th><?php echo _l('occurrence_description'); ?></th>
                  <th><?php echo _l('status'); ?></th>
                  <th><?php echo _l('created_by'); ?></th>
                  <th><?php echo _l('options'); ?></th>
                </tr>
              </thead>
              <tbody></tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php init_tail(); ?>
<div id="modal_wrapper"></div>

<script>
  $(function () {
    // Initialize DataTable
    initDataTable('.table-occurrences', admin_url + 'regulation/occurrences_list', [0, 1, 2, 3, 4], [5], undefined, [0, 'desc']);
  });

  function new_occurrence() {
    $.ajax({
      url: admin_url + 'regulation/occurrence',
      type: 'GET',
      success: function (response) {
        $('#modal_wrapper').html(response);
        $('#occurrence_modal').modal({
          show: true,
          backdrop: 'static'
        });
        init_selectpicker();
        $('.datetimepicker').datetimepicker({
          format: app.options.datetime_format,
          stepping: 30,
          minDate: new Date(),
          icons: {
            time: "fa fa-clock-o",
            date: "fa fa-calendar",
            up: "fa fa-chevron-up",
            down: "fa fa-chevron-down"
          }
        });
      },
      error: function (xhr, status, error) {
        alert_float('danger', 'Error loading form: ' + error);
        console.error(xhr.responseText);
      }
    });
  }

  function edit_occurrence(id) {
    $.ajax({
      url: admin_url + 'regulation/occurrence/' + id,
      type: 'GET',
      success: function (response) {
        $('#modal_wrapper').html(response);
        $('#occurrence_modal').modal({
          show: true,
          backdrop: 'static'
        });
        init_selectpicker();
        $('.datetimepicker').datetimepicker({
          format: app.options.datetime_format,
          stepping: 30,
          icons: {
            time: "fa fa-clock-o",
            date: "fa fa-calendar",
            up: "fa fa-chevron-up",
            down: "fa fa-chevron-down"
          }
        });
      },
      error: function (xhr, status, error) {
        alert_float('danger', 'Error loading form: ' + error);
        console.error(xhr.responseText);
      }
    });
  }

  function delete_occurrence(id) {
    if (confirm(_l('confirm_action_prompt'))) {
      window.location.href = admin_url + 'regulation/delete_occurrence/' + id;
    }
  }
</script>
</body>

</html>