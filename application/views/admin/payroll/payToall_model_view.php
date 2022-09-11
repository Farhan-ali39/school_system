<?php
$ci =& get_instance();
$ci->load->model('Payroll_model');
?>


<div class="form-group  col-xs-12 col-sm-12 col-md-12 col-lg-5">
    <label for="exampleInputEmail1">
        <?php echo $this->lang->line("month") ?> <?php echo $this->lang->line('year'); ?></label>
    <input id="monthid_all" name="month" readonly placeholder="" value="<?=$month."-".$year?>" type="text" class="form-control" />
    <input  name="paymentmonth_all" value="<?=$month?>" placeholder="" type="hidden" class="form-control" />
    <input name="paymentyear_all" value="<?=$year?>" placeholder="" type="hidden" class="form-control" />

</div>
<!--<div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-4">-->
<!--    <label for="exampleInputEmail1">--><?php //echo $this->lang->line('payment'); ?><!-- --><?php //echo $this->lang->line('mode'); ?><!--</label><br/><span id="remark">-->
<!--                            </span>-->
<!--    <select name="payment_mode_all" id="payment_mode_all"  class="form-control">-->
<!--        <option value="">--><?php //echo $this->lang->line('select'); ?><!--</option>-->
<!--        --><?php
//        foreach ($payment_mode as $pkey => $pvalue) {
//            ?>
<!--            <option value="--><?php //echo $pkey ?><!--">--><?php //echo $pvalue ?><!--</option>-->
<!--            --><?php
//        }
//        ?>
<!---->
<!--    </select>-->
<!--    <span class="text-danger">--><?php //echo form_error('payment_mode'); ?><!--</span>-->
<!--</div>-->

<div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-5">
    <label for="exampleInputEmail1"><?php echo $this->lang->line('payment'); ?> <?php echo $this->lang->line('date'); ?></label><br/><span id="remark"> </span>
    <input type="text" name="payment_date_all" id="payment_date_all" class="form-control" value="<?php echo date("m/d/Y") ?>">
</div>

<?php
$i=1;
foreach ($staffIds as  $staffId)
{
    $id= $staffId['value'];
    $searchEmployee = $this->payroll_model->searchPayment($id, $month, $year);
    if(!empty($searchEmployee))
    {
    ?>
    <div class="form-group  col-xs-12 col-sm-12 col-md-12 col-lg-4">
        <?php
        if($i==1)
        {
            ?>
            <label for="exampleInputEmail1">
                <?php echo $this->lang->line('staff'); ?> <?php echo $this->lang->line('Name'); ?></label>
        <?php

        }
        ?>

        <input type="text" name="emp_name" value="<?=$searchEmployee['name'].$searchEmployee['surname']."(".$searchEmployee['employee_id']?>)" readonly class="form-control" id="emp_name">
        <input name="paymentids[]" placeholder="" value="<?=$searchEmployee['id']?>" type="hidden" class="form-control" />
    </div>
    <div class="form-group  col-xs-12 col-sm-12 col-md-12 col-lg-4">
        <?php
        if($i==1)
        {
            ?>
            <label for="exampleInputEmail1"><?php echo $this->lang->line('payment'); ?> <?php echo $this->lang->line('amount'); ?></label>
            <?php

        }
        ?>
        <input type="text" name="amount" readonly class="form-control" value="<?=$searchEmployee['net_salary']?>" id="amount">
    </div>
    <div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-4">
        <?php
        if($i==1)
        {
            ?>
            <label for="exampleInputEmail1"><?php echo $this->lang->line('note'); ?></label><br/><span id="remark"> </span>
            <?php

        }
        ?>
        <textarea name="remarks_<?=$id?>" class="form-control" ></textarea>
    </div>


    <?php
    }
    $i++;
}
?>


<div class="clearfix"></div>



<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
    <button type="button" class="btn btn-primary  paytoAllBtn  pull-right" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Processing"> <?php echo $this->lang->line('save'); ?></button>
</div>
