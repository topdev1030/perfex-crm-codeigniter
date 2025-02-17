<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body">
                        <h4 class="no-margin">
                            <?php echo $title; ?>
                            <a href="<?php echo admin_url('regulation/vigilantes'); ?>" class="btn btn-default pull-right">
                                <i class="fa fa-arrow-left"></i> <?php echo _l('back_to_list'); ?>
                            </a>
                        </h4>
                        <hr class="hr-panel-heading" />

                        <?php echo form_open(admin_url('regulation/vigilante/' . $vigilante['staffid'])); ?>
                        <div class="row">
                            <div class="col-md-6">
                                <h4 class="bold"><?php echo _l('vigilante_cnv_details'); ?></h4>
                                <div class="form-group">
                                    <label for="cnv_number"><?php echo _l('vigilante_cnv_number'); ?></label>
                                    <input type="text" class="form-control" name="cnv_number" 
                                           value="<?php echo $vigilante['cnv_number']; ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="cnv_expiry"><?php echo _l('vigilante_cnv_expiry'); ?></label>
                                    <input type="text" class="form-control datepicker" name="cnv_expiry" 
                                           value="<?php echo _d($vigilante['cnv_expiry']); ?>" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <h4 class="bold"><?php echo _l('vigilante_post_assignment'); ?></h4>
                                <div class="form-group">
                                    <label for="post_id"><?php echo _l('vigilante_current_post'); ?></label>
                                    <select class="form-control selectpicker" name="post_id" data-live-search="true">
                                        <option value=""><?php echo _l('dropdown_non_selected_tex'); ?></option>
                                        <?php foreach($posts as $post) { ?>
                                        <option value="<?php echo $post['id']; ?>" 
                                            <?php echo ($vigilante['post_id'] == $post['id'] ? 'selected' : ''); ?>>
                                            <!--  // expected error -->
                                            <?php echo $post['name']; ?>
                                        </option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-info pull-right"><?php echo _l('submit'); ?></button>
                            </div>
                        </div>
                        <?php echo form_close(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php init_tail(); ?>
<script>
$(function() {
    appValidateForm($('form'), {
        cnv_number: 'required',
        cnv_expiry: 'required'
    });
});
</script>
</body>
</html> 