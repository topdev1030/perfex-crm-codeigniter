<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
  <div class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="panel_s">
          <div class="panel-body">
            <h4 class="no-margin"><?php echo $title; ?></h4>
            <a href="<?php echo admin_url('service_stations/station'); ?>"
              class="btn btn-primary mtop15"><?php echo _l('new_station'); ?></a>
            <hr class="hr-panel-heading" />
            <div class="table-responsive">
              <table class="table dt-table">
                <thead>
                  <tr>
                    <th><?php echo _l('station_name'); ?></th>
                    <th><?php echo _l('contract'); ?></th>
                    <th><?php echo _l('address'); ?></th>
                    <th><?php echo _l('options'); ?></th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($stations as $station) { ?>
                    <tr>
                      <td><?php echo $station['name']; ?></td>
                      <td><?php echo $station['contract']; ?></td>
                      <td><?php echo $station['address']; ?></td>
                      <td>
                        <a href="<?php echo admin_url('service_stations/station/' . $station['id']); ?>"
                          class="btn btn-default btn-icon"><i class="fa fa-pencil"></i></a>
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
</div>
<?php init_tail(); ?>