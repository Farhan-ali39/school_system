<style type="text/css">
    @media print
    {
        .no-print, .no-print *
        {
            display: none !important;
        }
    }
</style>

<div class="content-wrapper" style="min-height: 946px;">
    <section class="content-header">
        <h1><i class="fa fa-sitemap"></i> <?php echo $this->lang->line('fees_collection'); ?></h1>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">


            <div class="col-md-6">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title"><?php echo $title; ?></h3>
                    </div>
                    <form id="form1" action="<?php echo site_url('studentfee/feefine') ?>"    method="post" accept-charset="utf-8"  enctype="multipart/form-data">
                        <div class="box-body">
                            <?php if ($this->session->flashdata('msg')) { ?>
                                <?php echo $this->session->flashdata('msg') ?>
                            <?php } ?>
                            <?php echo $this->customlib->getCSRF(); ?>
                            <div class="form-group  ">
                                <label for="exampleInputEmail1">Late Fee Fine</label><small class="req"> *</small>
                                <input autofocus="" id="fine_amount"  name="fine_amount" placeholder="" type="number" min="0" class="form-control"  value="<?php
                                if (isset($fee_fine)) {

                                    echo $fee_fine->fine_amount;
                                }else
                                {
                                    echo 0;
                                }
                                ?>" />
                                <span class="text-danger"><?php echo form_error('type'); ?></span>
                            </div>


                        </div>
                        <div class="box-footer">
                            <button type="submit" class="btn btn-info pull-right"><?php echo $this->lang->line('update'); ?></button>
                        </div>
                    </form>
                </div>
            </div>



        </div>
    </section>
</div>

