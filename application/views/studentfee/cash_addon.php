<?php $currency_symbol = $this->customlib->getSchoolCurrencyFormat(); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

    <section class="content-header">
        <h1>
            <i class="fa fa-money"></i> <?php echo $this->lang->line('fees_collection'); ?></h1>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <?php
            if ($this->rbac->hasPrivilege('collect_fees', 'can_add')) {
                ?>
                <div class="col-md-4">
                    <!-- Horizontal Form -->
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Add Cash Addon</h3>
                        </div><!-- /.box-header -->
                        <form   action="<?php echo site_url('Studentfee/cash_addon') ?>"  id="cash_addonform" name="cash_addonform" method="post" accept-charset="utf-8">
                            <div class="box-body">
                                <?php if ($this->session->flashdata('msg')) { ?>
                                    <?php echo $this->session->flashdata('msg') ?>
                                <?php } ?>

                                <?php echo $this->customlib->getCSRF(); ?>
                                <div class="form-group">
                                    <label class="control-label col-sm-3" for="email"><?php echo $this->lang->line('session'); ?></label>


                                    <select class="form-control" name="session_id">
                                        <?php
                                        foreach ($sessionList as $session_key => $session_value) {
                                            ?>
                                            <option value="<?php echo $session_value['id']; ?>" <?php
                                            if ($this->setting_model->getCurrentSession() == $session_value['id']) {
                                                echo "selected='selected'";
                                            }
                                            ?>><?php echo $session_value['session']; ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>

                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1"><?php echo $this->lang->line('bank')." ".$this->lang->line('name'); ?></label> <small class="req">*</small>
                                    <select   id="bank_name" name="bank_name" class="form-control"  >
                                        <option value="" disabled><?php echo $this->lang->line('select'); ?></option>
                                        <option value="HBL">HBL</option>
                                        <option value="Soneri">Soneri</option>
                                    </select>


                                    <span class="text-danger"><?php echo form_error('bank_name'); ?></span>
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1"><?php echo $this->lang->line('date'); ?></label> <small class="req">*</small>
                                    <input id="date" name="date" type="date" class="form-control"  value="<?php echo set_value('date'); ?>" />
                                    <span class="text-danger"><?php echo form_error('date'); ?></span>
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1"><?php echo $this->lang->line('amount'); ?></label> <small class="req">*</small>
                                    <input id="amount" name="amount" type="number" min="0" step="0.1" class="form-control"  value="<?php echo set_value('amount'); ?>" />
                                    <span class="text-danger"><?php echo form_error('amount'); ?></span>
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1"><?php echo $this->lang->line('description'); ?></label>
                                    <textarea class="form-control" id="description" name="description" rows="3"><?php echo set_value('description'); ?></textarea>
                                    <span class="text-danger"></span>
                                </div>

                            </div><!-- /.box-body -->

                            <div class="box-footer">
                                <button type="submit" class="btn btn-info pull-right"><?php echo $this->lang->line('save'); ?></button>
                            </div>
                        </form>
                    </div>

                </div><!--/.col (right) -->
                <!-- left column -->
            <?php } ?>
            <div class="col-md-<?php
            if ($this->rbac->hasPrivilege('collect_fees', 'can_add')) {
                echo "8";
            } else {
                echo "12";
            }
            ?>">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header ptbnull">
                        <h3 class="box-title titlefix">Cash AddonDetails</h3>
                        <div class="box-tools pull-right">
                        </div><!-- /.box-tools -->
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <div class="mailbox-messages table-responsive">
                            <div class="download_label">Cash Addon Details</div>
                            <table class="table table-striped table-bordered table-hover example">
                                <thead>
                                <tr>

                                    <th><?php echo $this->lang->line('bank')." ".$this->lang->line('name'); ?>
                                    <th><?php echo $this->lang->line('date'); ?>

                                    <th><?php echo $this->lang->line('amount'); ?>
                                    </th>

                                    <th class="text text-right"><?php echo $this->lang->line('action'); ?></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                foreach ($cashAddonLists as $amountList) {
                                    ?>
                                    <tr>
                                        <td class="mailbox-name">
                                            <a href="#" data-toggle="popover" class="detail_popover"><?php echo $amountList->bank_name ?></a>

                                            <div class="fee_detail_popover" style="display: none">
                                                <?php
                                                if ($amountList->description == "") {
                                                    ?>
                                                    <p class="text text-danger"><?php echo $this->lang->line('no_description'); ?></p>
                                                    <?php
                                                } else {
                                                    ?>
                                                    <p class="text text-info"><?php echo $amountList->description; ?></p>
                                                    <?php
                                                }
                                                ?>
                                            </div>
                                        </td>

                                        <td class="mailbox-name">
                                            <?php echo date('d-M-Y',$amountList->date) ?>
                                        </td>
                                        <td class="mailbox-name">
                                            <?php echo $amountList->amount ?>
                                        </td>


                                        <td class="mailbox-date pull-right">
                                            <?php
                                             if ($this->rbac->hasPrivilege('collect_fees', 'can_delete')) {
                                                ?>
                                                <a data-placement="left" href="<?php echo base_url(); ?>Studentfee/delete_cash_addon/<?php echo $amountList->cash_addon_id ?>" class="btn btn-default btn-xs"  data-toggle="tooltip" title="<?php echo $this->lang->line('delete'); ?>" onclick="return confirm('<?php echo $this->lang->line('delete_confirm') ?>');">
                                                    <i class="fa fa-remove"></i>
                                                </a>
                                            <?php } ?>
                                        </td>
                                    </tr>
                                    <?php
                                }
                                ?>

                                </tbody>
                            </table><!-- /.table -->



                        </div><!-- /.mail-box-messages -->
                    </div><!-- /.box-body -->

                </div>
            </div><!--/.col (left) -->
            <!-- right column -->

        </div>
        <div class="row">
            <!-- left column -->

            <!-- right column -->
            <div class="col-md-12">

            </div><!--/.col (right) -->
        </div>   <!-- /.row -->
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->


