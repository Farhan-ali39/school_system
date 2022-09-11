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
                            <h3 class="box-title">Update Balance</h3>
                        </div><!-- /.box-header -->
                        <form   action="<?php echo site_url('Studentfee/previous_balance') ?>"   method="post" accept-charset="utf-8">
                            <div class="box-body">
                                <?php if ($this->session->flashdata('msg')) { ?>
                                    <?php echo $this->session->flashdata('msg') ?>
                                <?php } ?>

                                <?php echo $this->customlib->getCSRF(); ?>

                                <?php
                                $hbl_p_balance=0;
                                $soneri_p_balance=0;
                                $cash_p_balance=0;
                                foreach ($previous_balance as $value)if(!empty($value))
                                {
                                    if($value->type=="HBL")
                                    {

                                        $hbl_p_balance+=$value->amount;
                                    }elseif ($value->type=="Soneri")
                                    {
                                        $soneri_p_balance+=$value->amount;

                                    }elseif ($value->type=="Cash")
                                    {
                                        $cash_p_balance+=$value->amount;

                                    }
                                }

                                ?>


                                <div class="form-group">
                                    <label for="hbl_amount">HBL amount</label> <small class="req">*</small>
                                    <input id="hbl_amount" name="hbl_amount" type="number" min="0" step="0.1" class="form-control"  value="<?php echo set_value('hbl_amount',$hbl_p_balance); ?>" />
                                    <span class="text-danger"><?php echo form_error('hbl_amount'); ?></span>
                                </div>
                                <div class="form-group">
                                    <label for="soneri_amount">Soneri <?php echo $this->lang->line('amount'); ?></label> <small class="req">*</small>
                                    <input id="soneri_amount" name="soneri_amount" type="number" min="0" step="0.1" class="form-control"  value="<?php echo set_value('soneri_amount',$soneri_p_balance); ?>" />
                                    <span class="text-danger"><?php echo form_error('soneri_amount'); ?></span>
                                </div>
                                <div class="form-group">
                                    <label for="cash_amount">Cash amount </label> <small class="req">*</small>
                                    <input id="cash_amount" name="cash_amount" type="number" min="0" step="0.1" class="form-control"  value="<?php echo set_value('cash_amount',$cash_p_balance); ?>" />
                                    <span class="text-danger"><?php echo form_error('cash_amount'); ?></span>
                                </div>


                            </div><!-- /.box-body -->

                            <div class="box-footer">
                                <button type="submit" class="btn btn-info pull-right"><?php echo $this->lang->line('update'); ?></button>
                            </div>
                        </form>
                    </div>

                </div><!--/.col (right) -->
                <!-- left column -->
            <?php } ?>

        </div>
        <div class="row">
            <!-- left column -->

            <!-- right column -->
            <div class="col-md-12">

            </div><!--/.col (right) -->
        </div>   <!-- /.row -->
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->
<div class=" modal fade" id="minus_amount" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <form action="<?=base_url('Studentfee/edit_bank_amount')?>" method="post">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel"><?php echo $this->lang->line('confirmation'); ?></h4>
                </div>

                <div class="modal-body">
                    <div class="form-group minus_amount_input">
                        <label for="exampleInputEmail1"><?php echo $this->lang->line('amount'); ?></label> <small class="req">*</small>
                        <input id="minus_amount" name="minus_amount" type="number" min="0" max="'+amount+'" step="0.1" class="form-control"  required value="0" >
                        <span class="text-danger"><?php echo form_error('minus_amount'); ?></span>
                        <input type="hidden" name="bank_fee_id" id="bank_fee_id" value="">
                    </div>



                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line('cancel'); ?></button>
                    <button type="submit" class="btn btn-primary"  ><?php echo $this->lang->line('update'); ?></button>

                </div>

            </form>
        </div>
    </div>
</div>
