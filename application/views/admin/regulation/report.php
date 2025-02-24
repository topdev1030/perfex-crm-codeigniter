<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>

<div id="wrapper">
  <div class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="panel_s">
          <div class="panel-body">
            <h4 class="no-margin"><?php echo _l('regulation_report'); ?></h4>
            <hr class="hr-panel-heading" />

            <form method="post" id="filter-form">
              <div class="row">
                <div class="col-md-4">
                  <?php echo render_date_input('filter_service_post', 'service_post'); ?>
                </div>
                <div class="col-md-4">
                  <?php echo render_date_input('filter_expiration_date', 'expiration_date'); ?>
                </div>
                <div class="col-md-4">
                  <?php echo render_select('filter_item_type', [
                    ['id' => 'weapons', 'name' => 'Weapons'],
                    ['id' => 'vests', 'name' => 'Vests'],
                    ['id' => 'occurrences', 'name' => 'Occurrences'],
                    ['id' => 'processes', 'name' => 'Processes']
                  ], ['id', 'name'], 'item_type'); ?>
                </div>
              </div>
            </form>

            <div id="chart-container" style="height: 400px; margin-top: 30px; margin-bottom: 30px;">
              <canvas id="itemsGraph"></canvas>
            </div>

            <!-- Table -->
            <table class="table dt-table" id="report_table">
              <thead>
                <tr>
                  <th><?php echo _l(line: 'item_name'); ?></th>
                  <th><?php echo _l('service_post'); ?></th>
                  <th><?php echo _l('expiration_date'); ?></th>
                  <th><?php echo _l('item_type'); ?></th>
                </tr>
              </thead>
              <tbody>
                <!-- Data will be populated via AJAX -->
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php init_tail(); ?>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
  $(function () {
    // Initialize DataTable
    // var reportTable = $('#report_table').DataTable({
    //   "processing": true,
    //   "serverSide": true,
    //   "ajax": {
    //     "url": admin_url + 'regulation/get_report_data',
    //     "type": "POST",
    //     "data": function (d) {
    //       d.service_post = $('#filter_service_post').val();
    //       d.expiration_date = $('#filter_expiration_date').val();
    //       d.item_type = $('#filter_item_type').val();
    //     }
    //   },
    //   "columns": [
    //     { "data": "item_name" },
    //     { "data": "service_post" },
    //     { "data": "expiration_date" },
    //     { "data": "item_type" }
    //   ]
    // });

    // Initialize Chart.js
    $(document).ready(function () {
      var ctx = document.getElementById('itemsGraph').getContext('2d');
      var chart = new Chart(ctx, {
        type: 'bar',
        data: {
          labels: ['Weapons', 'CNVs', 'Other'],
          datasets: [{
            label: 'Expiring Items',
            data: [12, 19, 3], // Example dummy data
            backgroundColor: ['rgba(255, 99, 132, 0.2)', 'rgba(54, 162, 235, 0.2)', 'rgba(255, 206, 86, 0.2)'],
            borderColor: ['rgba(255, 99, 132, 1)', 'rgba(54, 162, 235, 1)', 'rgba(255, 206, 86, 1)'],
            borderWidth: 1
          }]
        },
        options: {
          responsive: true,
          scales: {
            y: {
              beginAtZero: true
            }
          }
        }
      });
    });
  });
</script>

</body>

</html>