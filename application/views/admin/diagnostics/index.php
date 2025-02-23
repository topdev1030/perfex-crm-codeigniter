<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>

<div id="wrapper">
  <div class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="panel_s">
          <div class="panel-body">
            <h4 class="no-margin"><?php echo _l('diagnostics'); ?></h4>
            <hr class="hr-panel-heading" />

            <!-- Expired Items -->
            <h5><?php echo _l('expired_items'); ?></h5>
            <table class="table dt-table">
              <thead>
                <tr>
                  <th><?php echo _l('item_name'); ?></th>
                  <th><?php echo _l('expiration_date'); ?></th>
                  <th><?php echo _l('item_type'); ?></th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($expired_items as $type => $items): ?>
                  <?php foreach ($items as $item): ?>
                    <tr>
                      <td><?php echo $item['item_name']; ?></td>
                      <td><?php echo _d($item['expiration_date']); ?></td>
                      <td><?php echo ucfirst($item['item_type']); ?></td>
                    </tr>
                  <?php endforeach; ?>
                <?php endforeach; ?>
              </tbody>
            </table>

            <!-- Pending Processes -->
            <h5><?php echo _l('pending_processes'); ?></h5>
            <table class="table dt-table">
              <thead>
                <tr>
                  <th><?php echo _l('process_type'); ?></th>
                  <th><?php echo _l('start_date'); ?></th>
                  <th><?php echo _l('expected_date'); ?></th>
                  <th><?php echo _l('status'); ?></th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($pending_processes as $process): ?>
                  <tr>
                    <td><?php echo $process['process_type']; ?></td>
                    <td><?php echo _d($process['start_date']); ?></td>
                    <td><?php echo _d($process['expected_date']); ?></td>
                    <td><?php echo ucfirst($process['status']); ?></td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>

          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php init_tail(); ?>
</body>

</html>