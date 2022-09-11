<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>

<?php
$ci =& get_instance();
$ci->load->model('Shared_model');
function getMonthName($month)
{
    $month=ltrim(date('m'),'0');

    if($month=='8-9' ||$month=='9' || $month=='8')
    {
        $returnMonth='August  - September';

    }elseif ($month=='10-11' ||$month=='10' || $month=='11')
    {
        $returnMonth='October - November';
    }elseif ($month=='12-1'||$month=='12' || $month=='1' )
    {
        $returnMonth='December - January';
    }elseif ($month=='2-3' ||$month=='2' || $month=='3')
    {
        $returnMonth='February - March';
    }elseif ($month=='4-5'||$month=='4' || $month=='5')
    {
        $returnMonth='April - May';
    }elseif ($month=='6-7' ||$month=='6' || $month=='7')
    {
        $returnMonth='June - July';
    }
    return $returnMonth;
}
if(isset($feeDetailArray) && !empty($feeDetailArray)) {

    $feeTypeArray=[];
    $feeTypeIDs=[];
    $Arreres=0;

    foreach ($feeDetailArray as $feeDetailID) {
        $rem_balance = 0;
        $paid_balance = 0;
        $payable_balance = 0;
        $feeDetails = $this->Shared_model->selectDataWhereSingle("tbl_student_fee_detail", array('fee_detail_id' => $feeDetailID));
        $voucherDetails= $this->Shared_model->selectDataWhereSingle("tbl_vouchers",array('fee_detail_id'=>$feeDetailID));
        if($feeDetails->is_installment==0)
        {
            if($feeDetails->fee_status==0)
            {
                $decodedFeeDetails = json_decode($feeDetails->fee_type);
                $decodedFeeDiscounts = json_decode($feeDetails->discount_type);
                $countFeeType = count($decodedFeeDetails);
                foreach ($decodedFeeDetails as $decodedFeeDetail) {
                    if(!empty($decodedFeeDiscounts))
                    {
                        $total_discounts=0;
                        foreach ($decodedFeeDiscounts as $disc_id)
                        {
                            $DiscountDetails= $this->Shared_model->selectDataWhereSingle("tbl_fee_discount",array('discount_id'=>$disc_id));

                            if($DiscountDetails->fee_type_id==$decodedFeeDetail->feeTypeID)
                            {
                                $total_discounts+=$DiscountDetails->discount_rate;
                            }
                        }
                        $disc_rate=$total_discounts;
                        $disc_factor=$disc_rate/100;
                        $discount_price=$decodedFeeDetail->fee_amount*$disc_factor;
                        $discounted_fee=$decodedFeeDetail->fee_amount-$discount_price;

                        $fee_amount=$discounted_fee;

                    }else{
                        $fee_amount=$decodedFeeDetail->fee_amount;
                    }




                    if (in_array($decodedFeeDetail->feeTypeID, $feeTypeIDs)) {
                        $previousAmount=$feeTypeArray[$decodedFeeDetail->feeTypeID];

//                    $feeTypeArray[$decodedFeeDetail->feeTypeID]=  0;
//                    $feeTypeArray[$decodedFeeDetail->feeTypeID]= $previousAmount+($payable_balance/$countFeeType);
                        $feeTypeArray[$decodedFeeDetail->feeTypeID]= $previousAmount+$fee_amount;

                    }else{
                        $feeTypeArray[$decodedFeeDetail->feeTypeID] = $fee_amount;
//                    $feeTypeArray[$decodedFeeDetail->feeTypeID] = $payable_balance/$countFeeType;
                        $feeTypeIDs[]=$decodedFeeDetail->feeTypeID;
                    }
                }

            }else{
                $feeDepositDetails = $this->Shared_model->selectDataWhereMultiple("tbl_student_fee_deposit", array('std_fee_detail_id' => $feeDetailID));
                if (!empty($feeDepositDetails)) {
                    foreach ($feeDepositDetails as $depositDetail) {
                        $rem_balance = $rem_balance + $depositDetail->remaining_amount;
                        $paid_balance = $paid_balance + $depositDetail->paid_amount;
                    }
//                $payable_balance = $feeDetails->last_amount-$paid_balance;
                    $Arreres=$Arreres+($feeDetails->last_amount-$paid_balance);

                }

            }

        }
        else{
            $feeInstallment=$this->Shared_model->selectDataWhereSingle("tbl_fee_installments",array('fee_detail_id'=>$feeDetailID,'std_id'=>$stdId));
            $feeInstallmentDetails=$this->Shared_model->selectDataWhereMultiple("tbl_installment_details",array('installment_id'=>$feeInstallment->installment_id));
            foreach ($feeInstallmentDetails as $feeInstallmentDetail)
            {
                if(in_array($feeInstallmentDetail->installment_detail_id,$InstallmentDetailArray))
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

                    $Arreres=$Arreres+$installmentPayable_baln;
                }
            }

        }


    }
}
  ?>
<style>

    @page {
        size: A4 landscape;
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
        font-weight : 800;
    }
    .btn-light {
        background : white;
        border : 1px solid black;
    }
    .top-campus-name
    {
        width: 66%;
        margin-top: 11px;
        float: left;
    }
</style>

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
                <div class="col-md-7 top-campus-name">
                    <span class="bold">A Project of Leadership  College PECHS Campus</span>
                </div>
                <div class="col-md-5">
                    <p class="print-button" style="-webkit-text-fill-color:BLACK; padding : 5px; border : 1px solid black;">SCHOOL COPY</p>
                </div>

            </div>

            <div class="row" style="margin-top: 20px;font-size: 10px;display: flex">
                <div class="col-md-5" style="padding-left: 0px">
                    <span class="bold">Challan No: </span> <?=$voucherDetails->challan_no?>
                </div>
                <div class="col-md-7">
                    <span class="bold">Issue Date: </span><span><?php echo date('d-F-Y',strtotime($voucherIssueDate)); ?>
                </div>
            </div>

            <div class="row" style="border-bottom: 2px solid black;margin-top: 8px;margin-bottom: 12px;">
            </div>

            <div class="row" style="font-size: 11px;">
                <span class="bold" > Campus: </span>  PECHS Campus
            </div>

            <div class="row" style="border-bottom: 2px solid black;margin-top: 8px;margin-bottom: 12px;">
            </div>

            <div class="row" style="font-size: 11px">
                <span class="bold" > Account Title:</span>  Leadership School PECHS Campus
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
                        <span class="bold">Soneri Bank# 011402080445149 </span>
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
<!--                        <span class="bold"> Billing Period :   </span> --><?php //echo date("F", strtotime(date("d-$voucherDetails->month-y"))) . ' ' . date('Y',strtotime($voucherDetails->created_at)); ?>
                        <span class="bold"> Billing Period :   </span> <?php echo $voucherBillingPeriod; ?>

                        <?php
                    }else
                    {
                        ?>
                        <span class="bold"> Billing Period :   </span> <?php echo $voucherBillingPeriod; ?>

                        <?php
                    }
                    ?>
                </div>
            </div>



            <div class="row" style="display: flex; font-size: 9px; margin-top: 8px; padding-bottom : 5px;">
                <div class="col-md-5" style="padding-left: 0px">
                    <span class="bold"> Due Date: </span> <?php echo date('d-F-Y',strtotime($voucherDueDate)); ?>
                </div>


                <div class="col-md-7" style="">
                    <span class="bold"> Struck Off Date: </span> <?php echo date('d-F-Y',strtotime($voucherStuckOffDate)); ?>
                </div>
            </div>

            <div class="row">
                <table style="width:100%; border : 1px solid black; padding : 10px; padding-left : 20px!important;">
                    <?php
                    $totalFee=0;
                    if(!empty($feeTypeArray))
                    {
                        foreach ($feeTypeArray as $key=>$value)
                        {
                            if($value!=0)
                            {
                                $totalFee=$totalFee+$value;
                                $feeType=$this->Shared_model->selectDataWhereSingle("tbl_feetype",array('id'=>$key));
                                ?>
                                <tr>
                                    <td><?=$feeType->type?></td>
                                    <td><?=intval($value)?></td>
                                </tr>
                    <?php
                            }
                        }
                    }
                    if($Arreres!=0)
                    {
                        ?>
                        <tr>
                            <td>Arreres</td>
                            <td><?=$Arreres?></td>
                        </tr>
                    <?php
                    }
                    ?>
                </table>
            </div>

            <div class="bold" class="row" style="padding-left: 0px">
                <p style="margin-top: 20px;float: left">Total: </p>
                <p style="float: right; margin-top: 20px; border-bottom : 1px double black; padding-bottom : 1px;">Rs.<?=number_format($Arreres+$totalFee)?></p>
            </div>

            <div class="clearfix"></div>

            <div class="row" style="display: inline-block; font-size : 9px; margin-top : 20px; margin-left : 0;">
                <p class="bold">Payment Terms </p>
                <p> 1-This Fee Challan shall be deposited in the prescribed bank within the due date mentioned above.</p>
                <p> 2- A fine of Rs. 25/- per day will be charged after the due date.</p>
                <p> 3: If the fee along with late fee fine is not deposited by the struck off date, a re-admission fee of Rs. 2000 including the late fee fine will be charged.</p>
                <p class="text-center">This receipt is computer generated and no signature is required.</p>
            </div>

        </div>
        <div class="col-md-4" style="padding-left: 20px;margin: 5px">

            <div class="row text-center">
                <img class="img-responsive text-center"  style="width: 330px;height: 70px;" src="<?php echo base_url(); ?>backend/images/s_logo.png" alt="<?php echo $this->customlib->getAppName() ?>" />
            </div>

            <div class="row" style="padding-top : 10px; font-size : 12px">
                <div class="col-md-7 top-campus-name">
                    <span class="bold">A Project of Leadership College PECHS Campus</span>
                </div>
                <div class="col-md-5">
                    <p class="print-button" style="-webkit-text-fill-color:BLACK; padding : 5px; border : 1px solid black;">STUDENT COPY</p>
                </div>

            </div>

            <div class="row" style="margin-top: 20px;font-size: 10px;display: flex">
                <div class="col-md-5" style="padding-left: 0px">
                    <span class="bold">Challan No: </span> <?=$voucherDetails->challan_no?>
                </div>
                <div class="col-md-7"  >
                    <span class="bold">Issue Date: </span><span><?php echo date('d-F-Y',strtotime($voucherIssueDate)); ?>
                </div>
            </div>

            <div class="row" style="border-bottom: 2px solid black;margin-top: 8px;margin-bottom: 12px;">
            </div>

            <div class="row" style="font-size: 11px;">
                <span class="bold" > Campus: </span>  PECHS Campus
            </div>

            <div class="row" style="border-bottom: 2px solid black;margin-top: 8px;margin-bottom: 12px;">
            </div>

            <div class="row" style="font-size: 11px">
                <span class="bold" > Account Title:</span>  Leadership School PECHS Campus
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
                        <span class="bold">Soneri Bank# 011402080445149 </span>
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
                        <!--                        <span class="bold"> Billing Period :   </span> --><?php //echo date("F", strtotime(date("d-$voucherDetails->month-y"))) . ' ' . date('Y',strtotime($voucherDetails->created_at)); ?>
                        <span class="bold"> Billing Period :   </span> <?php echo $voucherBillingPeriod; ?>

                        <?php
                    }else
                    {
                        ?>
                        <span class="bold"> Billing Period :   </span> <?php echo $voucherBillingPeriod; ?>

                        <?php
                    }
                    ?>
                </div>
            </div>

            <div class="row" style="display: flex; font-size: 9px; margin-top: 8px; padding-bottom : 5px;">
                <div class="col-md-5" style="padding-left: 0px">
                    <span class="bold"> Due Date: </span> <?php echo date('d-F-Y',strtotime($voucherDueDate)); ?>
                </div>

                <!--                --><?php
                //                if($withAdmission=="yes")
                //                {
                //                    ?>
                <div class="col-md-7" style="">
                    <span class="bold"> Struck Off Date: </span> <?php echo date('d-F-Y',strtotime($voucherStuckOffDate)); ?>
                </div>
                <!--                    --><?php
                //                }
                //                ?>

            </div>

            <div class="row">
                <table style="width:100%; border : 1px solid black; padding : 10px; padding-left : 20px!important;">

                    <?php
                    $totalFee=0;
                    if(!empty($feeTypeArray))
                    {
                        foreach ($feeTypeArray as $key=>$value)
                        {
                            if($value!=0)
                            {
                                $totalFee=$totalFee+$value;
                                $feeType=$this->Shared_model->selectDataWhereSingle("tbl_feetype",array('id'=>$key));
                                ?>
                                <tr>
                                    <td><?=$feeType->type?></td>
                                    <td><?=intval($value)?></td>
                                </tr>
                                <?php
                            }
                        }
                    }
                    if($Arreres!=0)
                    {
                        ?>
                        <tr>
                            <td>Arreres</td>
                            <td><?=$Arreres?></td>
                        </tr>
                        <?php
                    }
                    ?>
                </table>
            </div>


            <div class="bold" class="row" style="padding-left: 0px">
                <p style="margin-top: 20px;float: left">Total:</p>
                <p style="float: right; margin-top: 20px; border-bottom : 1px double black; padding-bottom : 1px;">Rs.<?=number_format($Arreres+$totalFee)?></p>
            </div>

            <div class="clearfix"></div>

            <div class="row" style="display: inline-block; font-size : 9px; margin-top : 20px; margin-left : 0;">
                <p class="bold">Payment Terms </p>
                <p> 1-This Fee Challan shall be deposited in the prescribed bank within the due date mentioned above.</p>
                <p> 2- A fine of Rs. 25/- per day will be charged after the due date.</p>
                <p> 3: If the fee along with late fee fine is not deposited by the struck off date, a re-admission fee of Rs. 2000 including the late fee fine will be charged.</p>
                <p class="text-center">This receipt is computer generated and no signature is required.</p>
            </div>
        </div>
        <div class="col-md-4" style="padding-left: 20px;padding-right: 10px;margin: 5px">

            <div class="row text-center">
                <img class="img-responsive text-center"  style="width: 330px;height: 70px;" src="<?php echo base_url(); ?>backend/images/s_logo.png" alt="<?php echo $this->customlib->getAppName() ?>" />
            </div>

            <div class="row" style="padding-top : 10px; font-size : 12px!important;">
                <div class="col-md-7 top-campus-name">
                    <span class="bold">A Project of Leadership  College PECHS Campus</span>
                </div>
                <div class="col-md-5">
                    <p class="print-button" style="-webkit-text-fill-color:BLACK; padding : 5px; text-align : center; border : 1px solid black;">BANK COPY</p>
                </div>

            </div>

            <div class="row" style="margin-top: 20px;font-size: 10px;display: flex">
                <div class="col-md-5" style="padding-left: 0px">
                    <span class="bold">Challan No: </span> <?=$voucherDetails->challan_no?>
                </div>
                <div class="col-md-7"  >
                    <span class="bold">Issue Date: </span><span><?php echo date('d-F-Y',strtotime($voucherIssueDate)); ?>
                </div>
            </div>

            <div class="row" style="border-bottom: 2px solid black;margin-top: 8px;margin-bottom: 12px;">
            </div>

            <div class="row" style="font-size: 11px;">
                <span class="bold" > Campus: </span>  PECHS Campus
            </div>

            <div class="row" style="border-bottom: 2px solid black;margin-top: 8px;margin-bottom: 12px;">
            </div>

            <div class="row" style="font-size: 11px">
                <span class="bold" > Account Title:</span>  Leadership School PECHS Campus
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
                        <span class="bold">Soneri Bank# 011402080445149 </span>
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
                        <!--                        <span class="bold"> Billing Period :   </span> --><?php //echo date("F", strtotime(date("d-$voucherDetails->month-y"))) . ' ' . date('Y',strtotime($voucherDetails->created_at)); ?>
                        <span class="bold"> Billing Period :   </span> <?php echo $voucherBillingPeriod; ?>

                        <?php
                    }else
                    {
                        ?>
                        <span class="bold"> Billing Period :   </span> <?php echo $voucherBillingPeriod; ?>

                        <?php
                    }
                    ?>
                </div>
            </div>

            <div class="row" style="display: flex; font-size: 9px; margin-top: 8px; padding-bottom : 5px;">
                <div class="col-md-5" style="padding-left: 0px">
                    <span class="bold"> Due Date: </span> <?php echo date('d-F-Y',strtotime($voucherDueDate)); ?>
                </div>

                <!--                --><?php
                //                if($withAdmission=="yes")
                //                {
                //                    ?>
                <div class="col-md-7" style="">
                    <span class="bold"> Struck Off Date: </span> <?php echo date('d-F-Y',strtotime($voucherStuckOffDate)); ?>
                </div>
                <!--                    --><?php
                //                }
                //                ?>

            </div>

            <div class="row">
                <table style="width:100%; border : 1px solid black; padding : 10px; padding-left : 20px!important;">
                    <?php
                    $totalFee=0;
                    if(!empty($feeTypeArray))
                    {
                        foreach ($feeTypeArray as $key=>$value)
                        {
                            if($value!=0)
                            {
                                $totalFee=$totalFee+$value;
                                $feeType=$this->Shared_model->selectDataWhereSingle("tbl_feetype",array('id'=>$key));
                                ?>
                                <tr>
                                    <td><?=$feeType->type?></td>
                                    <td><?=intval($value)?></td>
                                </tr>
                                <?php
                            }
                        }
                    }
                    if($Arreres!=0)
                    {
                        ?>
                        <tr>
                            <td>Arreres</td>
                            <td><?=$Arreres?></td>
                        </tr>
                        <?php
                    }
                    ?>
                </table>
            </div>

            <div class="bold" class="row" style="padding-left: 0px">
                <p style="margin-top: 20px;float: left">Total:</p>
                <p style="float: right; margin-top: 20px; border-bottom : 1px double black; padding-bottom : 1px;">Rs.<?=number_format($Arreres+$totalFee)?></p>
            </div>

            <div class="clearfix"></div>

            <div class="row" style="display: inline-block; font-size : 9px; margin-top : 20px; margin-left : 0;">
                <p class="bold">Payment Terms </p>
                <p> 1-This Fee Challan shall be deposited in the prescribed bank within the due date mentioned above.</p>
                <p> 2- A fine of Rs. 25/- per day will be charged after the due date.</p>
                <p> 3: If the fee along with late fee fine is not deposited by the struck off date, a re-admission fee of Rs. 2000 including the late fee fine will be charged.</p>
                <p class="text-center">This receipt is computer generated and no signature is required.</p>
            </div>
        </div>
    </div>
</div>
<!--nprogress-->



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
        // window.print()
    });
</script>