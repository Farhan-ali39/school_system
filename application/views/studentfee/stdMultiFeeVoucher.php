<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
<style>

    /*@page {*/
    /*size:  landscape;*/
    /*}*/
    @media print {
        .content-wrapper {
            margin: 0;
            /*border: initial;*/
            border-radius: initial;
            width: initial;
            min-height: initial;
            /*box-shadow: initial;*/
            /*background: initial;*/
            /*page-break-after: always;*/
        }
    }
    @media print
    {
        @page
        {
            size: 8.5in 5.5in;
            size: landscape;
        }
    }
    table, th, td {
        border: 1px solid black!important;
        border-collapse: collapse;
        margin-top: 10px;
    }
    th, td {
        padding: 5px;
        text-align: left;

    }

    * {
        box-sizing: border-box;
    }
    p{
        float: left;
        text-decoration: solid;
    }
    button
    {
        color: transparent;
    }
    /* Create three equal columns that floats next to each other */
    .column {
        float: left;
        width: 33.33%;
        padding: 10px;
        height: 300px; /* Should be removed. Only for demonstration */
    }

    .print-button{
        -webkit-text-fill-color:BLACK;
        padding : 5px;
        border : 1px solid black;
        font-size: 8px;
        font-weight: 600;
    }

    /* Clear floats after the columns */
    .row:after {
        content: "";
        display: table;
        clear: both;
    }
    .container {
        padding-top : 30px;
        /*margin-top : 50px;*/
        background:white!important;
        /*width : 1200px;*/
        display: inline-flex;
    }
    .bold {
        font-weight : 600;
    }
    .btn-light {
        background : white;
        border : 1px solid black;
    }
    .top-campus-name
    {
        width: 66%;
        /*margin-top: 11px;*/
        float: left;
    }
    .line_height_1
    {
        line-height: 1px;
    }
    .line_height_10
    {
        line-height: 10px;
    }
    .text-center-last
    {
        margin-left: 40px;
    }
</style>

<?php
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

foreach ($feeDetailIDs as $ID)
{


    $feeDetails= $this->Shared_model->selectDataWhereSingle("tbl_student_fee_detail",array('fee_detail_id'=>$ID));
    $stdFeeDetails=$this->Shared_model->selectDataWhereSingle("tbl_student_fee",array('std_fee_id'=>$feeDetails->std_fee_id));
    $voucherDetail= $this->Shared_model->selectDataWhereSingle("tbl_vouchers",array('fee_detail_id'=>$ID));
    $stdDetail= $this->student_model->get($stdFeeDetails->std_id);
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
    $stdFeeDetails=$this->Shared_model->selectDataWhereSingle("tbl_student_fee",array('std_id'=>$stdDetail['id']));
    $AllfeeDetails=$this->Shared_model->selectDataWhereMultiple("tbl_student_fee_detail",array('std_fee_id'=>$stdFeeDetails->std_fee_id));
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
                    $feeDepositDetails=$this->Shared_model->selectDataWhereMultiple("tbl_student_fee_deposit",['std_fee_detail_id'=>$allfeeDetail->fee_detail_id]);
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
            $feeInstallments=$this->Shared_model->selectDataWhereSingle("tbl_fee_installments",array('fee_detail_id'=>$allfeeDetail->fee_detail_id));
            $feeInstallmentDetails=$this->Shared_model->selectDataWhereMultiple("tbl_installment_details",array('installment_id'=>$feeInstallments->installment_id));
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
            $feeDepositDetails=$this->Shared_model->selectDataWhereMultiple("tbl_student_fee_deposit",['std_fee_detail_id'=>$allfeeDetail->fee_detail_id]);
            foreach ($feeDepositDetails as $feeDepositDetail)
            {
                $ExtraAmount+=$feeDepositDetail->extra_amount;
            }



        }
    }
    $feeInstallments=$this->Shared_model->selectDataWhereMultiple("tbl_fee_installments",array('std_id'=>$stdDetail['id']));
    foreach ($feeInstallments as $feeInstallment)
    {
        $feeInstallmentDetails=$this->Shared_model->selectDataWhereMultiple("tbl_installment_details",array('installment_id'=>$feeInstallment->installment_id));
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
                    $feeInstallmentDepositDetails=$this->Shared_model->selectDataWhereMultiple("tbl_student_fee_deposit",array('is_installment'=>1,'installment_detail_id'=>$feeInstallmentDetail->installment_detail_id));
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
            $discTypeDetails=$this->Shared_model->selectDataWhereSingle("tbl_fee_discount",array('discount_id'=>$discType));

            $discArray[$discTypeDetails->name]=$appliedDiscountArray[$discIndex];

            $discIndex++;

        }

    }
//    var_dump($ExtraAmount);
//    die();
    if($feeDetail->is_advanced==1)
    {
        $Arrears=0;
    }
    $Arrears=$Arrears+$feeDetail->arrears;
    $Arrears=$Arrears-$ExtraAmount;

    ?>

    <div class="content-wrapper">
        <!--    <div style="padding-top : 10px; padding-left : 80x;" class="pull-left p-4">-->
        <!--        <button class="btn btn-primary" onclick="printThis()" id="print">-->
        <!--            Print-->
        <!--        </button>-->
        <!--    </div>-->
        <div class="container">
            <div class="col-md-4" style="padding-left: 20px;margin: 5px">

                <div class="row text-center">
                    <img class="img-responsive text-center" style="width: 330px;height: 70px;"   src="<?php echo base_url(); ?>backend/images/s_logo.png" alt="<?php echo $this->customlib->getAppName() ?>" />
                </div>

                <div class="row" style="padding-top : 10px; font-size : 12px">
                    <div class="col-md-8 top-campus-name">
                        <span class="bold">A Project of Leadership  College</span>
                    </div>
                    <div class="col-md-4">
                        <p class="print-button" style="-webkit-text-fill-color:BLACK; padding : 5px; border : 1px solid black;">SCHOOL COPY</p>
                    </div>

                </div>

                <div class="row" style="margin-top: 20px;font-size: 10px;display: flex">
                    <div class="col-md-5" style="padding-left: 0px">
                        <span class="bold">Challan No: </span> <?=$voucherDetails->challan_no?>
                    </div>
                    <div class="col-md-7">
                        <span class="bold">Issue Date: </span><span><?php echo date('d-F-y',strtotime($voucherDetails->issue_date)); ?>
                    </div>
                </div>

                <div class="row" style="border-bottom: 2px solid black;margin-top: 8px;margin-bottom: 12px;">
                </div>

                <div class="row line_height_1" style="font-size: 11px;">
                    <span class="bold" > Campus: </span> &nbsp; PECHS Campus
                </div>

                <div class="row" style="border-bottom: 2px solid black;margin-top: 8px;margin-bottom: 12px;">
                </div>

                <div class="row line_height_1" style="font-size: 11px">
                    <span class="bold" > Account Title:</span> &nbsp; Leadership School PECHS Campus
                </div>

                <div class="row" style="margin-top: 10px;  padding-bottom : 5px;">

                    <div class="col-md-5" style="padding: 0px">
                        <div style="width: 17px;height: 15px;border: 2px solid black;float: left; position: absolute;">
                        </div>
                        <div style="margin-left: 21px;font-size: 8px;padding-top: 2px">
                            <span class="bold">HBL# 008917900493303 </span>
                        </div>
                    </div>
                    <div class="col-md-7" style="padding: 0px">
                        <div style="width: 17px;height: 15px;border: 2px solid black;float: right; position: absolute;">
                        </div>
                        <div style="margin-left: 21px;font-size: 8px;padding-top: 2px">
                            <span class="bold">Soneri Bank# 0010420006876537  </span>
                        </div>
                    </div>

                </div>

                <div class="row" style="border-bottom: 2px solid black;margin-top: 8px;margin-bottom: 12px;">
                </div>

                <div class="row" style="border-bottom: 2px solid black;margin-top: 8px; padding-bottom : 5px; margin-bottom: 12px;">
                    <div style="font-size: 10px;">
                        <span class="bold"> Student Name:  </span><?php echo $stdDetail['firstname'].' '.$stdDetail['lastname']; ?>
                    </div>
                </div>

                <div class="row" style="display: flex;font-size: 11px; border-bottom: 2px solid black;margin-top: 8px; padding-bottom : 5px; margin-bottom: 12px;">
                    <?php
                    if($withAdmission=="yes")
                    {
                        ?>
                        <div class="col-md-6" style="padding-left: 0px">
                            <span class="bold"> Roll#: </span><?php echo $stdDetail['roll_no']; ?>
                        </div>
                        <?php
                    }
                    ?>

                    <div class="col-md-6" >
                        <span class="bold"> Class: <?php echo $stdDetail['class']; ?>  </span>
                    </div>
                </div>
                <div class="row" style="border-bottom: 2px solid black;margin-top: 8px;margin-bottom: 12px; padding-bottom : 5px;">
                    <div style="font-size: 9px;">
                        <?php
                        if($feeCase==1)
                        {
                            ?>
                            <span class="bold"> Billing Period :   </span> <?php echo date("F", strtotime(date("d-$voucherDetails->month-y"))) . ' ' . date('Y',strtotime($voucherDetails->created_at)); ?>

                            <?php
                        }else
                        {
                            ?>
                            <span class="bold"> Billing Period :   </span> <?php echo getMonthName($voucherDetails->month) . ' ' . date('Y',strtotime($voucherDetails->created_at)); ?>

                            <?php
                        }
                        ?>                    </div>
                </div>



                <div class="row" style="display: flex; font-size: 9px; margin-top: 8px; padding-bottom : 5px;">
                    <div class="col-md-5" style="padding-left: 0px">
                        <span class="bold"> Due Date: </span> <?php echo date('d-F-y',strtotime($voucherDetails->due_date)); ?>
                    </div>


                    <div class="col-md-7" >
                        <span class="bold"> Struck Off Date: </span> <?php echo date('d-F-y',strtotime($voucherDetails->stuck_off_date)); ?>
                    </div>
                </div>

                <div class="row">
                    <table style="width:100%; border : 1px solid black; padding : 10px; padding-left : 20px!important;">


                        <?php
                        $discountApply=$this->Shared_model->selectDataWhereSingle("tbl_fee_discounts",array('fee_detail_id'=>$feeDetailID));
                        if(!empty($discountApply))
                        {

                            $decodedFeeDetails=json_decode($discountApply->discount_rate);
                            foreach ($decodedFeeDetails as $decodedFeeDetail)
                            {
                                $feeType=$this->Shared_model->selectDataWhereSingle("tbl_feetype",array('id'=>$decodedFeeDetail->fee_type));
                                ?>
                                <tr>
                                    <th><?=$feeType->type?></th>
                                    <td><?=$decodedFeeDetail->balance?></td>
                                </tr>
                                <?php
                            }

                        }else
                        {
                            $totalFee=0;
                            if($feeDetail->is_installment==0)
                            {
                                foreach ($decodedFeeDetails as $decodedFeeDetail)
                                {
                                    if(!empty($decodedFeeDetail))
                                    {
                                        $feeType=$this->Shared_model->selectDataWhereSingle("tbl_feetype",array('id'=>$decodedFeeDetail->feeTypeID));
                                        ?>
                                        <tr>
                                            <th><?=$feeType->type?></th>
                                            <td><?=$decodedFeeDetail->fee_amount?></td>
                                        </tr>
                                        <?php
                                        $totalFee=$totalFee+$decodedFeeDetail->fee_amount;
                                    }
                                }
                            }
                        }
                        if($Arrears>0)
                        {
                        ?>
                        <tr>
                            <th>Arrears</th>
                            <td><?=$Arrears?></td>
                        </tr>
                        <?php
                        }

                        $totalDiscAmount=0;
                        if(!empty($discArray))
                        {

                            foreach ($discArray as $key=>$discAmount)
                            {
                                $totalDiscAmount=$totalDiscAmount+$discAmount;
                                ?>
                                <tr>
                                    <th><?=$key?></th>
                                    <td><?=$discAmount?></td>
                                </tr>
                                <?php
                            }
                        }

                        ?>
                    </table>
                </div>

                <div   class="row bold" style="padding-left: 0px;line-height: 0px">
                    <div class="col-md-12">
                        <p style="margin-top: 20px;float: left">Total: </p>
                        <p style="float: right; margin-top: 20px; text-decoration:underline;  padding-bottom : 1px;">Rs.<?=($totalFee+$Arrears)-$totalDiscAmount?></p>
                    </div>
                    <?php
                    if($feeDetail->fine_wavier==1)
                    {

                        ?>
                        <div class="col-md-12">
                            <p style="margin-top: 20px;float: left">After Due: </p>
                            <p style="float: right; margin-top: 20px; text-decoration:underline;   padding-bottom : 1px;">Rs.<?=($totalFee+$Arrears+$fee_fine->fine_amount)-$totalDiscAmount?></p>

                        </div>

                        <?php
                    }
                    ?>
                </div>


                <div class="clearfix"></div>

                <div class="row line_height_10" style="display: inline-block; font-size : 9px; margin-top : 20px; margin-left : 0;">
                    <p><b>Note for Parents/Guardians:</b> To claim credit for online payments (through ATM, direct debit, etc), please WhatsApp payment evidence with student details to <b>0336-3281840</b></p>
                    <p class="bold">Payment Terms </p>
                    <p> 1-This Fee Challan shall be deposited in the prescribed bank within the due date mentioned above.</p>
                    <p> 2- - Fine will be charged after the due date</p>
                    <p> 3: If the fee along with late fee fine is not deposited by the struck off date, a re-admission fee of Rs. 2500 including the late fee fine will be charged.</p>
                    <p class="text-center text-center-last">This receipt is computer generated and no signature is required.</p>
                </div>

            </div>
            <div class="col-md-4" style="padding-left: 20px;margin: 5px">

                <div class="row text-center">
                    <img class="img-responsive text-center"  style="width: 330px;height: 70px;" src="<?php echo base_url(); ?>backend/images/s_logo.png" alt="<?php echo $this->customlib->getAppName() ?>" />
                </div>

                <div class="row" style="padding-top : 10px; font-size : 12px">
                    <div class="col-md-8 top-campus-name">
                        <span class="bold">A Project of Leadership College</span>
                    </div>
                    <div class="col-md-4">
                        <p class="print-button" style="-webkit-text-fill-color:BLACK; padding : 5px; border : 1px solid black;">STUDENT COPY</p>
                    </div>

                </div>

                <div class="row" style="margin-top: 20px;font-size: 10px;display: flex">
                    <div class="col-md-5" style="padding-left: 0px">
                        <span class="bold">Challan No: </span> <?=$voucherDetails->challan_no?>
                    </div>
                    <div class="col-md-7"  >
                        <span class="bold">Issue Date: </span><span><?php echo date('d-F-y',strtotime($voucherDetails->issue_date)); ?>
                    </div>
                </div>

                <div class="row" style="border-bottom: 2px solid black;margin-top: 8px;margin-bottom: 12px;">
                </div>

                <div class="row line_height_1" style="font-size: 11px;">
                    <span class="bold" > Campus: </span> &nbsp; PECHS Campus
                </div>

                <div class="row" style="border-bottom: 2px solid black;margin-top: 8px;margin-bottom: 12px;">
                </div>

                <div class="row line_height_1" style="font-size: 11px">
                    <span class="bold" > Account Title:</span>&nbsp;  Leadership School PECHS Campus
                </div>

                <div class="row" style="margin-top: 10px;  padding-bottom : 5px;">

                    <div class="col-md-5" style="padding: 0px">
                        <div style="width: 17px;height: 15px;border: 2px solid black;float: left; position: absolute;">
                        </div>
                        <div style="margin-left: 21px;font-size: 8px;padding-top: 2px">
                            <span class="bold">HBL# 008917900493303 </span>
                        </div>
                    </div>
                    <div class="col-md-7" style="padding: 0px">
                        <div style="width: 17px;height: 15px;border: 2px solid black;float: right; position: absolute;">
                        </div>
                        <div style="margin-left: 21px;font-size: 8px;padding-top: 2px">
                            <span class="bold">Soneri Bank# 0010420006876537 </span>
                        </div>
                    </div>

                </div>


                <div class="row" style="border-bottom: 2px solid black;margin-top: 8px;margin-bottom: 12px;">
                </div>

                <div class="row" style="border-bottom: 2px solid black;margin-top: 8px; padding-bottom : 5px; margin-bottom: 12px;">
                    <div style="font-size: 10px;">
                        <span class="bold"> Student Name:  </span><?php echo $stdDetail['firstname'].' '.$stdDetail['lastname']; ?>
                    </div>
                </div>

                <div class="row" style="display: flex;font-size: 11px; border-bottom: 2px solid black;margin-top: 8px; padding-bottom : 5px; margin-bottom: 12px;">

                    <?php
                    if($withAdmission=="yes")
                    {
                        ?>
                        <div class="col-md-6" style="padding-left: 0px">
                            <span class="bold"> Roll#: </span><?php echo $stdDetail['roll_no']; ?>
                        </div>
                        <?php

                    }
                    ?>

                    <div class="col-md-6"  >
                        <span class="bold"> Class: <?php echo $stdDetail['class']; ?>  </span>
                    </div>
                </div>

                <div class="row" style="border-bottom: 2px solid black;margin-top: 8px;margin-bottom: 12px; padding-bottom : 5px;">
                    <div style="font-size: 9px;">
                        <?php
                        if($feeCase==1)
                        {
                            ?>
                            <span class="bold"> Billing Period :   </span> <?php echo date("F", strtotime(date("d-$voucherDetails->month-y"))) . ' ' . date('Y',strtotime($voucherDetails->created_at)); ?>

                            <?php
                        }else
                        {
                            ?>
                            <span class="bold"> Billing Period :   </span> <?php echo getMonthName($voucherDetails->month) . ' ' . date('Y',strtotime($voucherDetails->created_at)); ?>

                            <?php
                        }
                        ?>                    </div>
                </div>

                <div class="row" style="display: flex; font-size: 9px; margin-top: 8px; padding-bottom : 5px;">
                    <div class="col-md-5" style="padding-left: 0px">
                        <span class="bold"> Due Date: </span> <?php echo date('d-F-y',strtotime($voucherDetails->due_date)); ?>
                    </div>

                    <!--                --><?php
                    //                if($withAdmission=="yes")
                    //                {
                    //                    ?>
                    <div class="col-md-7"  >
                        <span class="bold"> Struck Off Date: </span> <?php echo date('d-F-y',strtotime($voucherDetails->stuck_off_date)); ?>
                    </div>
                    <!--                    --><?php
                    //                }
                    //                ?>

                </div>

                <div class="row">
                    <table style="width:100%; border : 1px solid black; padding : 10px; padding-left : 20px!important;">

                        <?php
                        $discountApply=$this->Shared_model->selectDataWhereSingle("tbl_fee_discounts",array('fee_detail_id'=>$feeDetailID));
                        if(!empty($discountApply))
                        {
                            $decodedFeeDetails=json_decode($discountApply->discount_rate);
                            foreach ($decodedFeeDetails as $decodedFeeDetail)
                            {
                                $feeType=$this->Shared_model->selectDataWhereSingle("tbl_feetype",array('id'=>$decodedFeeDetail->fee_type));
                                ?>
                                <tr>
                                    <th><?=$feeType->type?></th>
                                    <td><?=$decodedFeeDetail->balance?></td>
                                </tr>
                                <?php
                            }

                        }else
                        {
                            $totalFee=0;
                            if($feeDetail->is_installment==0)
                            {
                                foreach ($decodedFeeDetails as $decodedFeeDetail)
                                {
                                    if(!empty($decodedFeeDetail))
                                    {
                                        $feeType=$this->Shared_model->selectDataWhereSingle("tbl_feetype",array('id'=>$decodedFeeDetail->feeTypeID));
                                        ?>
                                        <tr>
                                            <th><?=$feeType->type?></th>
                                            <td><?=$decodedFeeDetail->fee_amount?></td>
                                        </tr>
                                        <?php
                                        $totalFee=$totalFee+$decodedFeeDetail->fee_amount;
                                    }
                                }
                            }
                        }

                                                if($Arrears>0)
                                                {
                        ?>
                        <tr>
                            <th>Arrears</th>
                            <td><?=$Arrears?></td>
                        </tr>
                        <?php
                                                }
                        $totalDiscAmount=0;
                        if(!empty($discArray))
                        {

                            foreach ($discArray as $key=>$discAmount)
                            {
                                $totalDiscAmount=$totalDiscAmount+$discAmount;
                                ?>
                                <tr>
                                    <th><?=$key?></th>
                                    <td><?=$discAmount?></td>
                                </tr>
                                <?php
                            }
                        }

                        ?>
                    </table>
                </div>

                <div   class="row bold" style="padding-left: 0px;line-height: 0px">
                    <div class="col-md-12">
                        <p style="margin-top: 20px;float: left">Total: </p>
                        <p style="float: right; margin-top: 20px; text-decoration:underline;  padding-bottom : 1px;">Rs.<?=($totalFee+$Arrears)-$totalDiscAmount?></p>
                    </div>
                    <?php
                    if($feeDetail->fine_wavier==1)
                    {

                        ?>
                        <div class="col-md-12">
                            <p style="margin-top: 20px;float: left">After Due: </p>
                            <p style="float: right; margin-top: 20px; text-decoration:underline;   padding-bottom : 1px;">Rs.<?=($totalFee+$Arrears+$fee_fine->fine_amount)-$totalDiscAmount?></p>

                        </div>

                        <?php
                    }
                    ?>
                </div>


                <div class="clearfix"></div>

                <div class="row line_height_10" style="display: inline-block; font-size : 9px; margin-top : 20px; margin-left : 0;">
                    <p><b>Note for Parents/Guardians:</b> To claim credit for online payments (through ATM, direct debit, etc), please WhatsApp payment evidence with student details to <b>0336-3281840</b></p>
                    <p class="bold">Payment Terms </p>
                    <p> 1-This Fee Challan shall be deposited in the prescribed bank within the due date mentioned above.</p>
                    <p> 2- - Fine will be charged after the due date</p>
                    <p> 3: If the fee along with late fee fine is not deposited by the struck off date, a re-admission fee of Rs. 2500 including the late fee fine will be charged.</p>
                    <p class="text-center text-center-last">This receipt is computer generated and no signature is required.</p>
                </div>
            </div>
            <div class="col-md-4" style="padding-left: 20px;padding-right: 10px;margin: 5px">

                <div class="row text-center">
                    <img class="img-responsive text-center"  style="width: 330px;height: 70px;" src="<?php echo base_url(); ?>backend/images/s_logo.png" alt="<?php echo $this->customlib->getAppName() ?>" />
                </div>

                <div class="row" style="padding-top : 10px; font-size : 12px!important;">
                    <div class="col-md-8 top-campus-name">
                        <span class="bold">A Project of Leadership  College</span>
                    </div>
                    <div class="col-md-4">
                        <p class="print-button" style="-webkit-text-fill-color:BLACK; padding : 5px; text-align : center; border : 1px solid black;">BANK COPY</p>
                    </div>

                </div>

                <div class="row" style="margin-top: 20px;font-size: 10px;display: flex">
                    <div class="col-md-5" style="padding-left: 0px">
                        <span class="bold">Challan No: </span> <?=$voucherDetails->challan_no?>
                    </div>
                    <div class="col-md-7"  >
                        <span class="bold">Issue Date: </span><span><?php echo date('d-F-y',strtotime($voucherDetails->issue_date)); ?>
                    </div>
                </div>

                <div class="row" style="border-bottom: 2px solid black;margin-top: 8px;margin-bottom: 12px;">
                </div>

                <div class="row line_height_1" style="font-size: 11px;">
                    <span class="bold" > Campus: </span>&nbsp; PECHS Campus
                </div>

                <div class="row" style="border-bottom: 2px solid black;margin-top: 8px;margin-bottom: 12px;">
                </div>

                <div class="row line_height_1" style="font-size: 11px">
                    <span class="bold" > Account Title:</span> &nbsp; Leadership School PECHS Campus
                </div>

                <div class="row" style="margin-top: 10px;  padding-bottom : 5px;">

                    <div class="col-md-5" style="padding: 0px">
                        <div style="width: 17px;height: 15px;border: 2px solid black;float: left; position: absolute;">
                        </div>
                        <div style="margin-left: 21px;font-size: 8px;padding-top: 2px">
                            <span class="bold">HBL# 008917900493303 </span>
                        </div>
                    </div>
                    <div class="col-md-7" style="padding: 0px">
                        <div style="width: 17px;height: 15px;border: 2px solid black;float: right; position: absolute;">
                        </div>
                        <div style="margin-left: 21px;font-size: 8px;padding-top: 2px">
                            <span class="bold">Soneri Bank# 0010420006876537 </span>
                        </div>
                    </div>

                </div>


                <div class="row" style="border-bottom: 2px solid black;margin-top: 8px;margin-bottom: 12px;">
                </div>

                <div class="row" style="border-bottom: 2px solid black;margin-top: 8px; padding-bottom : 5px; margin-bottom: 12px;">
                    <div style="font-size: 10px;">
                        <span class="bold"> Student Name:  </span><?php echo $stdDetail['firstname'].' '.$stdDetail['lastname']; ?>
                    </div>
                </div>

                <div class="row" style="display: flex;font-size: 11px; border-bottom: 2px solid black;margin-top: 8px; padding-bottom : 5px; margin-bottom: 12px;">
                    <?php
                    if($withAdmission=="yes")
                    {
                        ?>
                        <div class="col-md-6" style="padding-left: 0px">
                            <span class="bold"> Roll#: </span><?php echo $stdDetail['roll_no']; ?>
                        </div>
                        <?php
                    }
                    ?>

                    <div class="col-md-6"  >
                        <span class="bold"> Class: <?php echo $stdDetail['class']; ?>  </span>
                    </div>
                </div>

                <div class="row" style="border-bottom: 2px solid black;margin-top: 8px;margin-bottom: 12px; padding-bottom : 5px;display: flex;">
                    <div style="font-size: 9px;">
                        <?php
                        if($feeCase==1)
                        {
                            ?>
                            <span class="bold"> Billing Period :   </span> <?php echo date("F", strtotime(date("d-$voucherDetails->month-y"))) . ' ' . date('Y',strtotime($voucherDetails->created_at)); ?>

                            <?php
                        }else
                        {
                            ?>
                            <span class="bold"> Billing Period :   </span> <?php echo getMonthName($voucherDetails->month) . ' ' . date('Y',strtotime($voucherDetails->created_at)); ?>

                            <?php
                        }
                        ?>
                    </div>
                </div>

                <div class="row" style="display: flex; font-size: 9px; margin-top: 8px; padding-bottom : 5px;">
                    <div class="col-md-5" style="padding-left: 0px">
                        <span class="bold"> Due Date: </span> <?php echo date('d-F-y',strtotime($voucherDetails->due_date)); ?>
                    </div>

                    <!--                --><?php
                    //                if($withAdmission=="yes")
                    //                {
                    //                    ?>
                    <div class="col-md-7" >
                        <span class="bold"> Struck Off Date: </span> <?php echo date('d-F-y',strtotime($voucherDetails->stuck_off_date)); ?>
                    </div>
                    <!--                    --><?php
                    //                }
                    //                ?>

                </div>

                <div class="row">
                    <table style="width:100%; border : 1px solid black; padding : 10px; padding-left : 20px!important;">
                        <?php
                        $discountApply=$this->Shared_model->selectDataWhereSingle("tbl_fee_discounts",array('fee_detail_id'=>$feeDetailID));
                        if(!empty($discountApply))
                        {
                            $decodedFeeDetails=json_decode($discountApply->discount_rate);
                            foreach ($decodedFeeDetails as $decodedFeeDetail)
                            {
                                $feeType=$this->Shared_model->selectDataWhereSingle("tbl_feetype",array('id'=>$decodedFeeDetail->fee_type));
                                ?>
                                <tr>
                                    <th><?=$feeType->type?></th>
                                    <td><?=$decodedFeeDetail->balance?></td>
                                </tr>
                                <?php
                            }

                        }else
                        {
                            $totalFee=0;
                            if($feeDetail->is_installment==0)
                            {
                                foreach ($decodedFeeDetails as $decodedFeeDetail)
                                {
                                    if(!empty($decodedFeeDetail))
                                    {
                                        $feeType=$this->Shared_model->selectDataWhereSingle("tbl_feetype",array('id'=>$decodedFeeDetail->feeTypeID));
                                        ?>
                                        <tr>
                                            <th><?=$feeType->type?> </th>
                                            <td><?=$decodedFeeDetail->fee_amount?></td>
                                        </tr>
                                        <?php
                                        $totalFee=$totalFee+$decodedFeeDetail->fee_amount;
                                    }
                                }
                            }
                        }

                                                if($Arrears>0)
                                                {
                        ?>
                        <tr>
                            <th>Arrears</th>
                            <td><?=$Arrears?></td>
                        </tr>
                        <?php
                                                }
                        $totalDiscAmount=0;
                        if(!empty($discArray))
                        {

                            foreach ($discArray as $key=>$discAmount)
                            {
                                $totalDiscAmount=$totalDiscAmount+$discAmount;
                                ?>
                                <tr>
                                    <th><?=$key?></th>
                                    <td><?=$discAmount?></td>
                                </tr>
                                <?php
                            }
                        }

                        ?>
                    </table>
                </div>

                <div   class="row bold" style="padding-left: 0px;line-height: 0px">
                    <div class="col-md-12">
                        <p style="margin-top: 20px;float: left">Total: </p>
                        <p style="float: right; margin-top: 20px; text-decoration:underline;  padding-bottom : 1px;">Rs.<?=($totalFee+$Arrears)-$totalDiscAmount?></p>
                    </div>
                    <?php
                    if($feeDetail->fine_wavier==1)
                    {

                        ?>
                        <div class="col-md-12">
                            <p style="margin-top: 20px;float: left">After Due: </p>
                            <p style="float: right; margin-top: 20px; text-decoration:underline;   padding-bottom : 1px;">Rs.<?=($totalFee+$Arrears+$fee_fine->fine_amount)-$totalDiscAmount?></p>

                        </div>

                        <?php
                    }
                    ?>
                </div>


                <div class="clearfix"></div>

                <div class="row line_height_10" style="display: inline-block; font-size : 9px; margin-top : 20px; margin-left : 0;">
                    <p><b>Note for Parents/Guardians:</b> To claim credit for online payments (through ATM, direct debit, etc), please WhatsApp payment evidence with student details to <b>0336-3281840</b></p>
                    <p class="bold">Payment Terms </p>
                    <p> 1-This Fee Challan shall be deposited in the prescribed bank within the due date mentioned above.</p>
                    <p> 2- - Fine will be charged after the due date</p>
                    <p> 3: If the fee along with late fee fine is not deposited by the struck off date, a re-admission fee of Rs. 2500 including the late fee fine will be charged.</p>
                    <p class="text-center text-center-last">This receipt is computer generated and no signature is required.</p>
                </div>
            </div>
        </div>
    </div>
    <!--nprogress-->
    <?php


}


?>



<script>

    function printThis() {
        $('.container').printThis();
    }
    $(window).load(function() {
        // Run code
        window.print()

    });
    $(window).on('load', function () {
        alert("Window Loaded");
    });
</script>
<script type="text/javascript">
    $(window).ready(function () {
        window.print()
    });
</script>