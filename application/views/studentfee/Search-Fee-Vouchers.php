<?php
$currency_symbol = $this->customlib->getSchoolCurrencyFormat();
$ci =& get_instance();
$ci->load->model('Shared_model');
// in_assoc_array($member_id, 'id', $interest)
function in_assoc_array($value,$index,$array){
    foreach ($array as $row) {
        if($row[$index] == $value){
            return true;
        }
    }
    return false;
}
function getMonthName($month)
{
    if($month=='8-9' )
    {
        $returnMonth='August  - September';

    }elseif ($month=='10-11' )
    {
        $returnMonth='October - November';
    }elseif ($month=='12-1' )
    {
        $returnMonth='December - January';
    }elseif ($month=='2-3' )
    {
        $returnMonth='February - March';
    }elseif ($month=='4-5')
    {
        $returnMonth='April - May';
    }elseif ($month=='6-7' )
    {
        $returnMonth='June - July';
    }
    return $returnMonth;
}
$fee_fine         = $this->Shared_model->selectDataWhereSingle("tbl_finetype",array('finetype_id'=>1));


function get_total_fee($ID)
{
    $ci =& get_instance();
    $ci->load->model('Shared_model');

    $feeDetails= $ci->Shared_model->selectDataWhereSingle("tbl_student_fee_detail",array('fee_detail_id'=>$ID));
    $stdFeeDetails=$ci->Shared_model->selectDataWhereSingle("tbl_student_fee",array('std_fee_id'=>$feeDetails->std_fee_id));
    $voucherDetail= $ci->Shared_model->selectDataWhereSingle("tbl_vouchers",array('fee_detail_id'=>$ID));
    $stdDetail= $ci->student_model->get($stdFeeDetails->std_id);
    $feeDetail=$feeDetails;
    $feeDetailID=$ID;
    $voucherDetails=$voucherDetail;
    $stdDetail=$stdDetail;
    $feeCase=$stdFeeDetails->std_fee_case;

    if(isset($feeDetail))
    {
        $decodedFeeDetails= json_decode( $feeDetail->fee_type);
    }
    $Arrears=0;
    $ExtraAmount=0;
    $stdFeeDetails=$ci->Shared_model->selectDataWhereSingle("tbl_student_fee",array('std_id'=>$stdDetail['id']));
    $AllfeeDetails=$ci->Shared_model->selectDataWhereMultiple("tbl_student_fee_detail",array('std_fee_id'=>$stdFeeDetails->std_fee_id));
    foreach ($AllfeeDetails as $allfeeDetail)
    {
        if($allfeeDetail->fee_status!=1 && $allfeeDetail->is_installment==0 && $allfeeDetail->fee_detail_id!=$feeDetail->fee_detail_id)
        {
//            if($allfeeDetail->fee_status==2)
//            {
//
//
//            }else{
            if($feeCase==1)
            {
                $currentMonth= $voucherDetails->month;
            }else{
                $currentMonth=date(  'm',strtotime($voucherDetails->issue_date));

            }
//                if(date('Y')==$allfeeDetail->fee_year)
//                {
            $currentFeeMonth=strtotime(date('d-m-Y',strtotime($feeDetail->due_date)));
            $otherFeeMonth=strtotime(date('d-m-Y',strtotime($allfeeDetail->due_date)));
// echo "<br>";
// echo "Current Fee".$feeDetail->due_date;
// echo "<br>";
// echo "Other Fee".$allfeeDetail->due_date;

//                    if($feeDetail->fee_month >=$allfeeDetail->fee_month )
            // if($currentFeeMonth >=$otherFeeMonth )
            if($currentFeeMonth >=$otherFeeMonth )
            {
// echo "Other Fee".$allfeeDetail->due_date;
//                        echo $allfeeDetail->last_amount."<br>";
//                        echo $fee_fine->fine_amount."<br>";
                if($allfeeDetail->fee_status==2)
                {
                    $feeDepositDetails=$ci->Shared_model->selectDataWhereMultiple("tbl_student_fee_deposit",['std_fee_detail_id'=>$allfeeDetail->fee_detail_id]);
                    $depositedAmount=0;
                    foreach ($feeDepositDetails as $feeDepositDetail)
                    {
                        $depositedAmount+=$feeDepositDetail->paid_amount;
                    }
                    // echo $Arrears ;echo "<br>"; echo $allfeeDetail->issue_date ;echo "<br>";
                    $Arrears=$Arrears+($allfeeDetail->last_amount-$depositedAmount);
// echo "<br>";
//                            echo $depositedAmount."<br>";
                }else{
                    $Arrears=$Arrears+$allfeeDetail->last_amount;
                }
//                    $Arrears=$Arrears+$allfeeDetail->last_amount+$fee_fine->fine_amount;
//                        $Arrears=$Arrears+$allfeeDetail->last_amount;
            }
//                }

//            }

        }
        elseif ($allfeeDetail->fee_status!=1 && $allfeeDetail->is_installment==1)
        {
            $feeInstallments=$ci->Shared_model->selectDataWhereSingle("tbl_fee_installments",array('fee_detail_id'=>$allfeeDetail->fee_detail_id));
            $feeInstallmentDetails=$ci->Shared_model->selectDataWhereMultiple("tbl_installment_details",array('installment_id'=>$feeInstallments->installment_id));
            foreach ($feeInstallmentDetails as $installmentDetail)
            {
                if($installmentDetail->status!=1)
                {
                    $installmentmonth=ltrim(date(  'm',strtotime($installmentDetail->due_date)),'0') ;
                    $installmentyear=date(  'Y',strtotime($installmentDetail->due_date));
                    if($feeCase==1)
                    {
                        $currentMonth= $voucherDetails->month;
                    }else{
                        $currentMonth=date(  'm',strtotime($voucherDetails->issue_date));

                    }
                    if($installmentyear==$voucherDetails->year && $currentMonth>$installmentmonth)
                    {

                        $Arrears=$Arrears+$installmentDetail->amount;
                    }
                }
            }


        }elseif ($allfeeDetail->fee_status==1)
        {
            $feeDepositDetails=$ci->Shared_model->selectDataWhereMultiple("tbl_student_fee_deposit",['std_fee_detail_id'=>$allfeeDetail->fee_detail_id]);
            foreach ($feeDepositDetails as $feeDepositDetail)
            {
                $ExtraAmount+=$feeDepositDetail->extra_amount;
            }



        }
    }
    $feeInstallments=$ci->Shared_model->selectDataWhereMultiple("tbl_fee_installments",array('std_id'=>$stdDetail['id']));
    foreach ($feeInstallments as $feeInstallment)
    {
        $feeInstallmentDetails=$ci->Shared_model->selectDataWhereMultiple("tbl_installment_details",array('installment_id'=>$feeInstallment->installment_id));
        foreach ($feeInstallmentDetails as $feeInstallmentDetail)
        {
            if($feeInstallmentDetail->status!=1)
            {
                $installmentMonth=ltrim(date(  'm',strtotime($feeInstallmentDetail->due_date)),'0') ;
                if($feeCase==1)
                {
                    $currentMonth= $voucherDetails->month;
                }else{
                    $currentMonth=date(  'm',strtotime($voucherDetails->issue_date));

                }

                $currentFeeMonth=strtotime(date('d-m-Y',strtotime($feeDetail->issue_date)));
                $otherFeeMonth=strtotime(date('d-m-Y',strtotime($feeInstallmentDetail->due_date)));

                if($installmentMonth<= $currentMonth  )

                {
                    $installmentpaid_balance=0;
                    $installmentPayable_baln=0;
                    $feeInstallmentDepositDetails=$ci->Shared_model->selectDataWhereMultiple("tbl_student_fee_deposit",array('is_installment'=>1,'installment_detail_id'=>$feeInstallmentDetail->installment_detail_id));
                    if(!empty($feeInstallmentDepositDetails))
                    {
                        foreach ($feeInstallmentDepositDetails as $feeInstallmentDepositDetail)
                        {
                            $installmentpaid_balance=$installmentpaid_balance+$feeInstallmentDepositDetail->paid_amount;
                        }
                        $installmentPayable_baln=$feeInstallmentDetail->amount-$installmentpaid_balance;
                    }else
                    {
                        $installmentPayable_baln=$feeInstallmentDetail->amount;
                    }
                    $Arrears=$Arrears+$installmentPayable_baln;

                }
            }
        }

    }
    $discArray=[];

    if(!empty($feeDetail->applied_discounts)){
        $appliedDiscountArray=json_decode($feeDetail->applied_discounts);
        $DiscountTypeArray=json_decode($feeDetail->discount_type);
        $discIndex=0;
        foreach ($DiscountTypeArray as $discType)
        {
            $discTypeDetails=$ci->Shared_model->selectDataWhereSingle("tbl_fee_discount",array('discount_id'=>$discType));

            $discArray[$discTypeDetails->name]=$appliedDiscountArray[$discIndex];

            $discIndex++;

        }

    }
     if($feeDetail->is_advanced==1)
    {
        $Arrears=0;
    }
    $Arrears=$Arrears+$feeDetail->arrears;
    $Arrears=$Arrears-$ExtraAmount;
    $totalFee=0;
    if($feeDetail->is_installment==0)
    {
        foreach ($decodedFeeDetails as $decodedFeeDetail)
        {
            if(!empty($decodedFeeDetail))
            {
                $feeType=$ci->Shared_model->selectDataWhereSingle("tbl_feetype",array('id'=>$decodedFeeDetail->feeTypeID));
                 $totalFee=$totalFee+$decodedFeeDetail->fee_amount;
            }
        }
    }
    $totalDiscAmount=0;
    if(!empty($discArray))
    {

        foreach ($discArray as $key=>$discAmount)
        {
            $totalDiscAmount=$totalDiscAmount+$discAmount;
         }
    }
    return ($totalFee+$Arrears)-$totalDiscAmount;
}



?>
<div class="content-wrapper" style="min-height: 946px;">
    <section class="content-header">
        <h1>
            <i class="fa fa-money"></i> <?php echo $this->lang->line('fees_collection'); ?> </h1>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title"><i class="fa fa-search"></i> <?php echo $this->lang->line('select_criteria'); ?></h3>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-8 col-sm-6">
                                <div class="row">
                                    <form role="form" action="<?php echo site_url('studentfee/searchFeeVouchers') ?>" method="post" class="">
                                        <?php echo $this->customlib->getCSRF(); ?>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="exampleInputFile">Fee Case</label><small class="req"> *</small>
                                                <select class="form-control" name="fee_case" onchange="feeCaseType()" id="fee_case">
                                                    <option value=""><?php echo $this->lang->line('select'); ?></option>
                                                    <option value="1" <?php if (set_value('fee_case') == 1) echo "selected=selected" ?> <?php echo ($fee_case==1) ? 'selected' : ''?>>Monthly</option>
                                                    <option value="2" <?php if (set_value('fee_case') == 2) echo "selected=selected" ?> <?php echo ($fee_case==2) ? 'selected' : ''?>>Bi-Monthly</option>

                                                </select>
                                                <span class="text-danger"><?php echo form_error('fee_case'); ?></span>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-6">
                                            <div class="form-group">
                                                <label>Select Month</label><small class="req">  *</small>

                                                <?php
                                                if($fee_case==1)
                                                {
                                                    ?>
                                                    <select class="form-control" id="one_month"  name="month1" style="display: block;"  >
                                                        <option value="">Select Month</option>
                                                        <option value="1" <?php echo ($month==1) ? 'selected' : ''?> >Jan </option>
                                                        <option value="2" <?php echo ($month==2) ? 'selected' : ''?>>Feb</option>
                                                        <option value="3" <?php echo ($month==3) ? 'selected' : ''?>>Mar</option>
                                                        <option value="4" <?php echo ($month==4) ? 'selected' : ''?>> Apr</option>
                                                        <option value="5" <?php echo ($month==5) ? 'selected' : ''?>>May</option>
                                                        <option value="6" <?php echo ($month==6) ? 'selected' : ''?>>Jun</option>
                                                        <option value="7" <?php echo ($month==7) ? 'selected' : ''?>>Jul</option>
                                                        <option value="8" <?php echo ($month==8) ? 'selected' : ''?>>Aug</option>
                                                        <option value="9" <?php echo ($month==9) ? 'selected' : ''?>>Spt</option>
                                                        <option value="10" <?php echo ($month==10) ? 'selected' : ''?>>Oct</option>
                                                        <option value="11" <?php echo ($month==11) ? 'selected' : ''?>>Nov</option>
                                                        <option value="12" <?php echo ($month==12) ? 'selected' : ''?>>Dec</option>
                                                    </select>

                                                    <select autofocus="" id="multi_month" name="month2" class="form-control" style="display: none;"  >
                                                        <option value=""><?php echo $this->lang->line('select'); ?></option>
                                                        <option value="8-9">August  - September</option>
                                                        <option value="10-11">October - November</option>
                                                        <option value="12-1">December - January</option>
                                                        <option value="2-3">February - March</option>
                                                        <option value="4-5">April - May</option>
                                                        <option value="6-7">June - July</option>
                                                    </select>


                                                    <select autofocus="" id="general" style="display: none;" name="month3" class="form-control"  >
                                                        <option value=""><?php echo $this->lang->line('select'); ?></option>
                                                    </select>
                                                    <?php
                                                }elseif($fee_case==2)
                                                {
                                                    ?>
                                                    <select autofocus="" id="multi_month"   name="month2" class="form-control" style="display: block;"  >
                                                        <option value=""><?php echo $this->lang->line('select'); ?></option>
                                                        <option value="8-9" <?php echo ($month=='8-9') ? 'selected' : ''?>>August  - September</option>
                                                        <option value="10-11" <?php echo ($month=='10-11') ? 'selected' : ''?>>October - November</option>
                                                        <option value="12-1" <?php echo ($month=='12-1') ? 'selected' : ''?>>December - January</option>
                                                        <option value="2-3" <?php echo ($month=='2-3') ? 'selected' : ''?>>February - March</option>
                                                        <option value="4-5" <?php echo ($month=='4-5') ? 'selected' : ''?>>April - May</option>
                                                        <option value="6-7" <?php echo ($month=='6-7') ? 'selected' : ''?>>June - July</option>
                                                    </select>
                                                    <select class="form-control" id="one_month" name="month1" style="display: none;"  >
                                                        <option value="">Select Month</option>
                                                        <option value="1" >Jan </option>
                                                        <option value="2">Feb</option>
                                                        <option value="3">Mar</option>
                                                        <option value="4">Apr</option>
                                                        <option value="5">May</option>
                                                        <option value="6">Jun</option>
                                                        <option value="7">Jul</option>
                                                        <option value="8">Aug</option>
                                                        <option value="9">Spt</option>
                                                        <option value="10">Oct</option>
                                                        <option value="11">Nov</option>
                                                        <option value="12">Dec</option>
                                                    </select>



                                                    <select autofocus="" id="general" style="display: none;" name="month3" class="form-control"  >
                                                        <option value=""><?php echo $this->lang->line('select'); ?></option>
                                                    </select>
                                                    <?php
                                                }else
                                                {
                                                    ?>
                                                    <select class="form-control" id="one_month" name="month1" style="display: none;"  >
                                                        <option value="">Select Month</option>
                                                        <option value="1" >Jan </option>
                                                        <option value="2">Feb</option>
                                                        <option value="3">Mar</option>
                                                        <option value="4">Apr</option>
                                                        <option value="5">May</option>
                                                        <option value="6">Jun</option>
                                                        <option value="7">Jul</option>
                                                        <option value="8">Aug</option>
                                                        <option value="9">Spt</option>
                                                        <option value="10">Oct</option>
                                                        <option value="11">Nov</option>
                                                        <option value="12">Dec</option>
                                                    </select>

                                                    <select autofocus="" id="multi_month" name="month2" class="form-control" style="display: none;"  >
                                                        <option value=""><?php echo $this->lang->line('select'); ?></option>
                                                        <option value="8-9">August  - September</option>
                                                        <option value="10-11">October - November</option>
                                                        <option value="12-1">December - January</option>
                                                        <option value="2-3">February - March</option>
                                                        <option value="4-5">April - May</option>
                                                        <option value="6-7">June - July</option>
                                                    </select>


                                                    <select autofocus="" id="general" style="display: block;" name="month3" class="form-control"  >
                                                        <option value=""><?php echo $this->lang->line('select'); ?></option>
                                                    </select>

                                                    <?php
                                                }
                                                ?>
                                                <span class="text-danger"><?php echo form_error('month'); ?></span>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Select Fee Year</label>
                                                <select   id="fee_year" name="fee_year" class="form-control" required >
                                                    <option value="" disabled><?php echo $this->lang->line('select'); ?></option>
                                                    <?php
                                                    $currentYear=date('Y',strtotime('-5 year'));
                                                    for($i=$currentYear;$i<=$currentYear+10;$i++)
                                                    {
                                                        $feeYear=$i;
                                                        $feeYear--;
                                                        echo '<option value="'.$i.'">'.$feeYear.'-'.$i.'</option>';
                                                    }
                                                    ?>
                                                </select>
                                                <span class="text-danger"></span>
                                            </div>
                                        </div>
                                        <div class=" col-md-8 col-sm-11">
                                            <div class="form-group">
                                                <button type="submit" name="search" value="search_filter" class="btn btn-primary pull-right btn-sm checkbox-toggle"><i class="fa fa-search"></i> <?php echo $this->lang->line('search'); ?></button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-6">
                                <div class="row">
                                    <form role="form" action="<?php echo site_url('studentfee/assignFeeSearch') ?>" method="post" class="">
                                        <?php echo $this->customlib->getCSRF(); ?>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label><?php echo $this->lang->line('search_by_keyword'); ?></label>
                                                <input type="text" name="search_text" class="form-control" value="<?php echo set_value('search_text'); ?>" placeholder="<?php echo $this->lang->line('search_by_student_name'); ?>">
                                            </div>
                                        </div>

                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <button type="submit" name="search" value="search_full" class="btn btn-primary btn-sm pull-right checkbox-toggle"><i class="fa fa-search"></i> <?php echo $this->lang->line('search'); ?></button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php
                    if (isset($resultlist)) {
                    ?>
                    <div class="">
                        <div class="box-header ptbnull"></div>
                        <div class="box-header ptbnull">
                            <h3 class="box-title titlefix"><i class="fa fa-users"></i>Fee Vouchers
                                <?php echo form_error('student'); ?></h3>
                            <div class="box-tools pull-right"></div>
                        </div>
                        <div class="box-body table-responsive">
                            <form action="<?=base_url('studentfee/getFeeVoucher/multi')?>" method="post" id="printmultiVoucher">
                            <button type="button" name="printMulti" id="genrateVoucherbtn" value="print_full" class="btn btn-primary btn-sm pull-right checkbox-toggle"><i class="fa fa-print"></i>  <?php echo " ".$this->lang->line('print')." All"; ?></button>
                            <div id="feeDetailIdsdiv">

                            </div>
                            </form>
                            <div class="download_label"><?php echo $this->lang->line('student'); ?> <?php echo $this->lang->line('list'); ?></div>
                            <table class="table table-striped table-bordered table-hover example table-fixed-header">
                                <thead>

                                <tr>
                                    <th style="width: 10px"><input type="checkbox" id="select_all"/></th>
                                    <th><?php echo $this->lang->line('class'); ?></th>
                                    <th><?php echo $this->lang->line('section'); ?></th>

                                    <th>Roll Number</th>

                                    <th><?php echo $this->lang->line('student'); ?> <?php echo $this->lang->line('name'); ?></th>
                                    <?php if ($sch_setting->father_name) {  ?>
                                        <th><?php echo $this->lang->line('father_name'); ?></th>
                                    <?php } ?>
                                    <th><?php echo $this->lang->line('date_of_birth'); ?></th>
                                    <th><?php echo $this->lang->line('phone'); ?></th>
                                    <th>Total Fee</th>
                                    <th class="text-right"><?php echo $this->lang->line('action'); ?></th>

                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $count = 1;

                                foreach ($resultlist as $student) {



                                    $total_fee=  get_total_fee($student['fee_detail_id']);





                                    ?>
                                    <tr>
                                        <td>
                                            <input class="checkbox FeedetailIds" type="checkbox" name="FeedetailIds[]"  value="<?=$student['fee_detail_id']?>">
                                        </td>

                                        <td><?php echo $student['class']; ?></td>
                                        <td><?php echo $student['section']; ?></td>

                                        <td><?php echo $student['roll_no']; ?></td>

                                        <td><?php echo $student['firstname'] . " " . $student['lastname']; ?></td>
                                        <?php if ($sch_setting->father_name) {  ?>
                                            <td><?php echo $student['father_name']; ?></td>
                                        <?php } ?>
                                        <td><?php
                                            if (!empty($student['dob'])) {
                                                echo date($this->customlib->getSchoolDateFormat(), $this->customlib->dateyyyymmddTodateformat($student['dob']));
                                            }
                                            ?></td>
                                        <td><?php echo $student['guardian_phone']; ?></td>
                                        <td><?php echo $total_fee; ?></td>
                                        <td class="pull-right">
                                            <?php if ($this->rbac->hasPrivilege('collect_fees', 'can_add')) { ?>

                                                <a  href="<?php echo base_url(); ?>studentfee/getFeeVoucher/<?php echo $student['fee_detail_id'].'/'.'student' ?> " class="btn btn-info btn-xs" data-toggle="tooltip" title="" data-original-title="">
                                                    Print
                                                </a>
                                            <?php } ?>
                                        </td>

                                    </tr>
                                    <?php
                                }
                                $count++;
                                ?>
                                </tbody>
                            </table>
                        </div><!--./box-body-->
                    </div>
                </div>
                <?php
                }
                ?>
            </div>

        </div>

    </section>
</div>

<script type="text/javascript">
    function getSectionByClass(class_id, section_id) {
        if (class_id != "" && section_id != "") {
            $('#section_id').html("");
            var base_url = '<?php echo base_url() ?>';
            var div_data = '<option value=""><?php echo $this->lang->line('select'); ?></option>';
            $.ajax({
                type: "GET",
                url: base_url + "sections/getByClass",
                data: {'class_id': class_id},
                dataType: "json",
                success: function (data) {
                    $.each(data, function (i, obj)
                    {
                        var sel = "";
                        if (section_id == obj.section_id) {
                            sel = "selected";
                        }
                        div_data += "<option value=" + obj.section_id + " " + sel + ">" + obj.section + "</option>";
                    });
                    $('#section_id').append(div_data);
                }
            });
        }
    }
    function feeCaseType() {
        var feeCaseType=$('#fee_case').val();
        if(feeCaseType==1)
        {
            $('#one_month').css('display','block');
            $('#multi_month').css('display','none');
            $('#general').css('display','none');
            $('#monthRepeat').css('display','none');
        }else if(feeCaseType==2)
        {
            $('#multi_month').css('display','block');
            $('#one_month').css('display','none');
            $('#general').css('display','none');
            $('#monthRepeat').css('display','none');
        }else
        {
            $('#general').css('display','block');
            $('#one_month').css('display','none');
            $('#multi_month').css('display','none');
            $('#monthRepeat').css('display','none');
        }

    }

    $(document).ready(function () {

        $("#select_all").change(function () {  //"select all" change
            $(".checkbox").prop('checked', $(this).prop("checked")); //change all ".checkbox" checked status
        });

        //".checkbox" change
        $('.checkbox').change(function () {
            //uncheck "select all", if one of the listed checkbox item is unchecked
            if (false == $(this).prop("checked")) { //if this item is unchecked
                $("#select_all").prop('checked', false); //change "select all" checked status to false
            }
            //check "select all" if all checkbox items are checked
            if ($('.checkbox:checked').length == $('.checkbox').length) {
                $("#select_all").prop('checked', true);
            }
        });

        $("#genrateVoucherbtn").click(function(){
            var feeDetailArray = [];
            var i;
            var FeeDeatilsrow = "";
            $.each($(".FeedetailIds:checked"), function(){
                var index =  ($(this).val());
                feeDetailArray.push(index);
                FeeDeatilsrow += ' <input   name="feeDetailArray[]"   type="hidden"  value="'+index+'"  >';

            });
            $("#feeDetailIdsdiv").html("");
            $("#feeDetailIdsdiv").html(FeeDeatilsrow);
            if (feeDetailArray.length === 0 ) {
                alert("<?php echo $this->lang->line('no_record_selected');?>");
            }else
            {
//                $("#printVoucherForm").submit();

                $("#printmultiVoucher").submit();

            }

        });


        var class_id = $('#class_id').val();
        var section_id = '<?php echo set_value('section_id') ?>';
        getSectionByClass(class_id, section_id);
        $(document).on('change', '#class_id', function (e) {
            $('#section_id').html("");
            var class_id = $(this).val();
            var base_url = '<?php echo base_url() ?>';
            var div_data = '<option value=""><?php echo $this->lang->line('select'); ?></option>';
            $.ajax({
                type: "GET",
                url: base_url + "sections/getByClass",
                data: {'class_id': class_id},
                dataType: "json",
                success: function (data) {
                    $.each(data, function (i, obj)
                    {
                        div_data += "<option value=" + obj.section_id + ">" + obj.section + "</option>";
                    });
                    $('#section_id').append(div_data);
                }
            });
        });
    });
</script>