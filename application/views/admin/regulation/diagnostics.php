<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
  <div class="content">
    <div class="row">
      <!-- Expired Items -->
      <div class="col-md-12">
        <div class="panel_s">
          <div class="panel-body">
            <h4 class="no-margin"><?php echo _l('expiring_items'); ?></h4>
            <hr class="hr-panel-heading" />

            <!-- Vests -->
            <div class="col-md-4">
              <h4><?php echo _l('expiring_vests'); ?></h4>
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th><?php echo _l('serial_number'); ?></th>
                    <th><?php echo _l('expiry_date'); ?></th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($expired_vests as $vest) { ?>
                    <tr>
                      <td><?php echo $vest['serial_number']; ?></td>
                      <td><?php echo _d($vest['expiry_date']); ?></td>
                    </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>

            <!-- Weapons -->
            <div class="col-md-4">
              <h4><?php echo _l('expiring_weapons'); ?></h4>
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th><?php echo _l('serial_number'); ?></th>
                    <th><?php echo _l('license_expiry'); ?></th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($expired_weapons as $weapon) { ?>
                    <tr>
                      <td><?php echo $weapon['serial_number']; ?></td>
                      <td><?php echo _d($weapon['license_expiry']); ?></td>
                    </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>

            <!-- CNVs -->
            <div class="col-md-4">
              <h4><?php echo _l('expiring_cnvs'); ?></h4>
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th><?php echo _l('document_number'); ?></th>
                    <th><?php echo _l('expiry_date'); ?></th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($expired_cnvs as $cnv) { ?>
                    <tr>
                      <td><?php echo $cnv['document_number']; ?></td>
                      <td><?php echo _d($cnv['expiry_date']); ?></td>
                    </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>

      <!-- Processes -->
      <div class="col-md-12">
        <div class="panel_s">
          <div class="panel-body">
            <div class="row">
              <!-- Pending Processes -->
              <div class="col-md-6">
                <h4><?php echo _l('pending_processes'); ?></h4>
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th><?php echo _l('title'); ?></th>
                      <th><?php echo _l('date_created'); ?></th>
                      <th><?php echo _l('due_date'); ?></th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($pending_processes as $process) { ?>
                      <tr>
                        <td><?php echo $process['title']; ?></td>
                        <td><?php echo _d($process['date_created']); ?></td>
                        <td><?php echo _d($process['due_date']); ?></td>
                      </tr>
                    <?php } ?>
                  </tbody>
                </table>
              </div>

              <!-- Delayed Processes -->
              <div class="col-md-6">
                <h4><?php echo _l('delayed_processes'); ?></h4>
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th><?php echo _l('title'); ?></th>
                      <th><?php echo _l('due_date'); ?></th>
                      <th><?php echo _l('days_overdue'); ?></th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($delayed_processes as $process) {
                      $days_overdue = round((strtotime('now') - strtotime($process['due_date'])) / (60 * 60 * 24));
                      ?>
                      <tr>
                        <td><?php echo $process['title']; ?></td>
                        <td><?php echo _d($process['due_date']); ?></td>
                        <td><?php echo $days_overdue; ?></td>
                      </tr>
                    <?php } ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Recent Occurrences -->
      <div class="col-md-12">
        <div class="panel_s">
          <div class="panel-body">
            <h4><?php echo _l('recent_occurrences'); ?></h4>
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th><?php echo _l('date'); ?></th>
                  <th><?php echo _l('title'); ?></th>
                  <th><?php echo _l('status'); ?></th>
                  <th><?php echo _l('location'); ?></th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($recent_occurrences as $occurrence) { ?>
                  <tr>
                    <td><?php echo _dt($occurrence['occurrence_datetime']); ?></td>
                    <td><?php echo $occurrence['title']; ?></td>
                    <td><?php echo _l($occurrence['status']); ?></td>
                    <td><?php echo $occurrence['location']; ?></td>
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