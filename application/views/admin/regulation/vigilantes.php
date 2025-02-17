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

                        <table class="table dt-table">
                            <thead>
                                <tr>
                                    <th><?php echo _l('staff_dt_name'); ?></th>
                                    <th><?php echo _l('staff_dt_email'); ?></th>
                                    <th><?php echo _l('vigilante_cnv_number'); ?></th>
                                    <th><?php echo _l('vigilante_cnv_expiry'); ?></th>
                                    <th><?php echo _l('vigilante_current_post'); ?></th>
                                    <th><?php echo _l('staff_dt_active'); ?></th>
                                    <th><?php echo _l('options'); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($vigilantes as $vigilante) { 
                                    $cnv_status = '';
                                    if (!empty($vigilante['cnv_expiry'])) {
                                        $days_to_expiry = round((strtotime($vigilante['cnv_expiry']) - time()) / (60 * 60 * 24));
                                        if ($days_to_expiry < 0) {
                                            $cnv_status = 'text-danger';
                                        } elseif ($days_to_expiry <= 30) {
                                            $cnv_status = 'text-warning';
                                        }
                                    }
                                ?>
                                <tr>
                                    <td>
                                        <a href="<?php echo admin_url('regulation/vigilante/'.$vigilante['staffid']); ?>">
                                            <?php echo $vigilante['firstname'] . ' ' . $vigilante['lastname']; ?>
                                        </a>
                                    </td>
                                    <td><?php echo $vigilante['email']; ?></td>
                                    <td><?php echo $vigilante['cnv_number']; ?></td>
                                    <td class="<?php echo $cnv_status; ?>">
                                        <?php echo !empty($vigilante['cnv_expiry']) ? _d($vigilante['cnv_expiry']) : ''; ?>
                                    </td>
                                    <td><?php echo $vigilante['post_name']; ?></td>
                                    <td>
                                        <div class="onoffswitch">
                                            <input type="checkbox" data-switch-url="<?php echo admin_url('staff/change_staff_status'); ?>" 
                                                   name="onoffswitch" class="onoffswitch-checkbox" id="c_<?php echo $vigilante['staffid']; ?>" 
                                                   data-id="<?php echo $vigilante['staffid']; ?>" 
                                                   <?php echo ($vigilante['active'] == 1 ? 'checked' : ''); ?>>
                                            <label class="onoffswitch-label" for="c_<?php echo $vigilante['staffid']; ?>"></label>
                                        </div>
                                    </td>
                                    <td>
                                        <a href="<?php echo admin_url('regulation/vigilante/'.$vigilante['staffid']); ?>" 
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
<?php init_tail(); ?>
</body>
</html> 