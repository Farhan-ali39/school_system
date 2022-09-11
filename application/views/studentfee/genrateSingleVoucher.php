<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
<?php
$ci =& get_instance();
$ci->load->model('Shared_model');

 if(isset($feeDetail))
{
    $decodedFeeDetails= json_decode( $feeDetail->fee_details);

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
        font-size: 8px;

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
</style>

<div class="content-wrapper">
<!--    <div style="padding-top : 10px; padding-left : 80x;" class="pull-left p-4">-->
<!--        <button class="btn btn-primary" onclick="printThis()" id="print">-->
<!--            Print-->
<!--        </button>-->
<!--    </div>-->
    <div class="container">
        <div class="col-md-4" style="padding-left: 20px">

            <div class="row text-center">
                <img class="img-responsive text-center" style="width: 330px;height: 70px;"   src="<?php echo base_url(); ?>backend/images/s_logo.png" alt="<?php echo $this->customlib->getAppName() ?>" />
            </div>

            <div class="row" style="padding-top : 10px; font-size : 12px">
                <div class="col-md-8 top-campus-name">
                    <span class="bold">A Project of Leadership  College PECHS Campus</span>
                </div>
                <div class="col-md-4">
                    <p class="print-button" style="-webkit-text-fill-color:BLACK; padding : 5px; border : 1px solid black;">SCHOOL COPY</p>
                </div>

            </div>

            <div class="row" style="margin-top: 20px;font-size: 10px;display: flex">
                <div class="col-md-6">
                    <span class="bold">Challan No: </span> <?=$voucherDetails->challan_no?>
                </div>
                <div class="col-md-6" style="">
                    <span class="bold">Issue Date: </span><span><?php echo date('d-F-y',strtotime($voucherDetails->issue_date)); ?>
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
                    <span class="bold"> Student Name:  </span><?php echo $enquireyDetail->name; ?>
                </div>
            </div>

            <div class="row" style="display: flex;font-size: 11px; border-bottom: 2px solid black;margin-top: 8px; padding-bottom : 5px; margin-bottom: 12px;">
                <?php
                if($withAdmission=="yes")
                {
                    ?>
                    <div class="col-md-6">
                        <span class="bold"> Roll#: </span><?php echo $student['roll_no']; ?>
                    </div>
                <?php
                }
                ?>

                <div class="col-md-6" style="margin-left: 65%;">
                    <span class="bold"> Class: <?php echo $ClassDetail->class; ?>  </span>
                </div>
            </div>
            <?php
            if($withAdmission=="yes")
            {
                ?>
                <div class="row" style="border-bottom: 2px solid black;margin-top: 8px;margin-bottom: 12px; padding-bottom : 5px;">
                    <div style="font-size: 9px;">
                        <span class="bold"> Billing Period :   </span> <?php echo $student_due_fee->month . ' ' . date('Y',strtotime($student_due_fee->created_at)); ?>
                    </div>
                </div>
                <?php
            }
            ?>



            <div class="row" style="display: flex; font-size: 9px; margin-top: 8px; padding-bottom : 5px;">
                <div class="col-md-6">
                    <span class="bold"> Due Date: </span> <?php echo date('d-F-y',strtotime($voucherDetails->due_date)); ?>
                </div>

                <?php
                if($withAdmission=="yes")
                {
                    ?>
                    <div class="col-md-6" style="margin-left: 43%">
                        <span class="bold"> Struck Off Date: </span> <?php echo date('d-F-y',strtotime($student_due_fee->stuck_off_date)); ?>
                    </div>
                    <?php
                }
                ?>

            </div>

            <div class="row">
                <table style="width:100%; border : 1px solid black; padding : 10px; padding-left : 20px!important;">
                    <?php
                    if($withAdmission=="yes")
                    {
                        ?>
                        <tr>
                            <td colspan="4">
                                <span class="bold">Tuition Fee</span>
                                <p style="float: right"><?php echo 'Rs.' . $student_due_fee->amount_due; ?></p>
                            </td>
                        </tr>
                        <!--<tr>-->
                        <!--    <td colspan="4">-->
                        <!--        <span class="bold">Arrears</span>-->
                        <!--        <p style="float: right"><?php echo 'Rs.' . ($total_dues - $student_due_fee->amount); ?></p>-->
                        <!--    </td>-->
                        <!--</tr>-->
                        <?php if($student_due_fee->type == 'Annual Fee') { ?>
                        <tr>
                            <td colspan="4">
                                <span class="bold">Annual Charges</span>
                                <!--                                <p style="float: right">-->
                                <?php //echo 'Rs.' . ($student_due_fee->amount_due +  $total_dues); ?><!--</p>-->
                                <p style="float: right"><?php echo 'Rs.' . '12345'; ?></p>
                            </td>
                        </tr>

                        <?php
                    }
                    }
                    ?>
                    <?php
                    foreach ($decodedFeeDetails as $decodedFeeDetail)
                    {
                        $feeType=$this->Shared_model->selectDataWhereSingle("tbl_feetype",array('id'=>$decodedFeeDetail->fee_type));
                        ?>
                        <tr>
                            <th><?=$feeType->type?>:</th>
                            <td><?=$decodedFeeDetail->balance?></td>
                        </tr>
                        <?php
                    }
                    ?>
                </table>
            </div>

            <div class="bold" class="row">
                <p style="margin-top: 20px;float: left">Total: </p>
                <p style="float: right; margin-top: 20px; text-decoration:underline; border-bottom : 1px double black; padding-bottom : 1px;"><?php echo 'Rs.' . $feeDetail->total_fee;  ?></p>
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
        <div class="col-md-4" style="padding-left: 20px">

            <div class="row text-center">
                <img class="img-responsive text-center"  style="width: 330px;height: 70px;" src="<?php echo base_url(); ?>backend/images/s_logo.png" alt="<?php echo $this->customlib->getAppName() ?>" />
            </div>

            <div class="row" style="padding-top : 10px; font-size : 12px">
                <div class="col-md-8 top-campus-name">
                    <span class="bold">A Project of Leadership College PECHS Campus</span>
                </div>
                <div class="col-md-4">
                    <p class="print-button" style="-webkit-text-fill-color:BLACK; padding : 5px; border : 1px solid black;">BANK COPY</p>
                </div>

            </div>

            <div class="row" style="margin-top: 20px;font-size: 10px;display: flex">
                <div class="col-md-6">
                    <span class="bold">Challan No: </span> <?=$voucherDetails->challan_no?>
                </div>
                <div class="col-md-6" style="">
                    <span class="bold">Issue Date: </span><span><?php echo date('d-F-y',strtotime($voucherDetails->issue_date)); ?>
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
                    <span class="bold"> Student Name:  </span><?php echo $enquireyDetail->name; ?>
                </div>
            </div>

            <div class="row" style="display: flex;font-size: 11px; border-bottom: 2px solid black;margin-top: 8px; padding-bottom : 5px; margin-bottom: 12px;">

                <?php
                if($withAdmission=="yes")
                {
                    ?>
                    <div class="col-md-6">
                        <span class="bold"> Roll#: </span><?php echo $student['roll_no']; ?>
                    </div>
                <?php

                }
                ?>

                <div class="col-md-6" style="margin-left: 65%;">
                    <span class="bold"> Class: <?php echo $ClassDetail->class; ?>  </span>
                </div>
            </div>

            <?php
            if($withAdmission=="yes")
            {
                ?>
                <div class="row" style="border-bottom: 2px solid black;margin-top: 8px;margin-bottom: 12px; padding-bottom : 5px;">
                    <div style="font-size: 9px;">
                        <span class="bold"> Billing Period :   </span> <?php echo $student_due_fee->month . ' ' . date('Y',strtotime($student_due_fee->created_at)); ?>
                    </div>
                </div>
                <?php
            }
            ?>

            <div class="row" style="display: flex; font-size: 9px; margin-top: 8px; padding-bottom : 5px;">
                <div class="col-md-6">
                    <span class="bold"> Due Date: </span> <?php echo date('d-F-y',strtotime($voucherDetails->due_date)); ?>
                </div>

                <?php
                if($withAdmission=="yes")
                {
                    ?>
                    <div class="col-md-6" style="margin-left: 43%">
                        <span class="bold"> Struck Off Date: </span> <?php echo date('d-F-y',strtotime($student_due_fee->stuck_off_date)); ?>
                    </div>
                    <?php
                }
                ?>

            </div>

            <div class="row">
                <table style="width:100%; border : 1px solid black; padding : 10px; padding-left : 20px!important;">
                    <?php
                    if($withAdmission=="yes")
                    {
                        ?>
                        <tr>
                            <td colspan="4">
                                <span class="bold">Tuition Fee</span>
                                <p style="float: right"><?php echo 'Rs.' . $student_due_fee->amount_due; ?></p>
                            </td>
                        </tr>
                        <!--<tr>-->
                        <!--    <td colspan="4">-->
                        <!--        <span class="bold">Arrears</span>-->
                        <!--        <p style="float: right"><?php echo 'Rs.' . ($total_dues - $student_due_fee->amount); ?></p>-->
                        <!--    </td>-->
                        <!--</tr>-->
                        <?php if($student_due_fee->type == 'Annual Fee') { ?>
                        <tr>
                            <td colspan="4">
                                <span class="bold">Annual Charges</span>
                                <!--                                <p style="float: right">-->
                                <?php //echo 'Rs.' . ($student_due_fee->amount_due +  $total_dues); ?><!--</p>-->
                                <p style="float: right"><?php echo 'Rs.' . '12345'; ?></p>
                            </td>
                        </tr>

                        <?php
                    }
                    }
                    ?>
                    <?php
                    foreach ($decodedFeeDetails as $decodedFeeDetail)
                    {
                        $feeType=$this->Shared_model->selectDataWhereSingle("tbl_feetype",array('id'=>$decodedFeeDetail->fee_type));
                        ?>
                        <tr>
                            <th><?=$feeType->type?>:</th>
                            <td><?=$decodedFeeDetail->balance?></td>
                        </tr>
                        <?php
                    }
                    ?>
                </table>
            </div>


            <div class="bold" class="row">
                <p style="margin-top: 20px;float: left">Total:</p>
                <p style="float: right; margin-top: 20px; text-decoration:underline; border-bottom : 1px double black; padding-bottom : 1px;"><?php echo 'Rs.' . $feeDetail->total_fee; ?></p>
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
        <div class="col-md-4" style="padding-left: 20px;padding-right: 10px">

            <div class="row text-center">
                <img class="img-responsive text-center"  style="width: 330px;height: 70px;" src="<?php echo base_url(); ?>backend/images/s_logo.png" alt="<?php echo $this->customlib->getAppName() ?>" />
            </div>

            <div class="row" style="padding-top : 10px; font-size : 12px!important;">
                <div class="col-md-8 top-campus-name">
                    <span class="bold">A Project of Leadership  College PECHS Campus</span>
                </div>
                <div class="col-md-4">
                    <p class="print-button" style="-webkit-text-fill-color:BLACK; padding : 5px; text-align : center; border : 1px solid black;">STUDENT COPY</p>
                </div>

            </div>

            <div class="row" style="margin-top: 20px;font-size: 10px;display: flex">
                <div class="col-md-6">
                    <span class="bold">Challan No: </span> <?=$voucherDetails->challan_no?>
                </div>
                <div class="col-md-6" style="">
                    <span class="bold">Issue Date: </span><span><?php echo date('d-F-y',strtotime($voucherDetails->issue_date)); ?>
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
                    <span class="bold"> Student Name:  </span><?php echo $enquireyDetail->name; ?>
                </div>
            </div>

            <div class="row" style="display: flex;font-size: 11px; border-bottom: 2px solid black;margin-top: 8px; padding-bottom : 5px; margin-bottom: 12px;">
                <?php
                if($withAdmission=="yes")
                {
                    ?>
                    <div class="col-md-6">
                        <span class="bold"> Roll#: </span><?php echo $student['roll_no']; ?>
                    </div>
                <?php
                }
                ?>

                <div class="col-md-6" style="margin-left: 65%;">
                    <span class="bold"> Class: <?php echo $ClassDetail->class; ?>  </span>
                </div>
            </div>

            <?php
            if($withAdmission=="yes")
            {
                ?>
                <div class="row" style="border-bottom: 2px solid black;margin-top: 8px;margin-bottom: 12px; padding-bottom : 5px;">
                    <div style="font-size: 9px;">
                        <span class="bold"> Billing Period :   </span> <?php echo $student_due_fee->month . ' ' . date('Y',strtotime($student_due_fee->created_at)); ?>
                    </div>
                </div>
                <?php
            }
            ?>

            <div class="row" style="display: flex; font-size: 9px; margin-top: 8px; padding-bottom : 5px;">
                <div class="col-md-6">
                    <span class="bold"> Due Date: </span> <?php echo date('d-F-y',strtotime($voucherDetails->due_date)); ?>
                </div>

                <?php
                if($withAdmission=="yes")
                {
                    ?>
                    <div class="col-md-6" style="margin-left: 43%">
                        <span class="bold"> Struck Off Date: </span> <?php echo date('d-F-y',strtotime($student_due_fee->stuck_off_date)); ?>
                    </div>
                    <?php
                }
                ?>

            </div>

            <div class="row">
                <table style="width:100%; border : 1px solid black; padding : 10px; padding-left : 20px!important;">
                    <?php
                    if($withAdmission=="yes")
                    {
                        ?>
                        <tr>
                            <td colspan="4">
                                <span class="bold">Tuition Fee</span>
                                <p style="float: right"><?php echo 'Rs.' . $student_due_fee->amount_due; ?></p>
                            </td>
                        </tr>
                        <!--<tr>-->
                        <!--    <td colspan="4">-->
                        <!--        <span class="bold">Arrears</span>-->
                        <!--        <p style="float: right"><?php echo 'Rs.' . ($total_dues - $student_due_fee->amount); ?></p>-->
                        <!--    </td>-->
                        <!--</tr>-->
                        <?php if($student_due_fee->type == 'Annual Fee') { ?>
                        <tr>
                            <td colspan="4">
                                <span class="bold">Annual Charges</span>
                                <!--                                <p style="float: right">-->
                                <?php //echo 'Rs.' . ($student_due_fee->amount_due +  $total_dues); ?><!--</p>-->
                                <p style="float: right"><?php echo 'Rs.' . '12345'; ?></p>
                            </td>
                        </tr>

                        <?php
                    }
                    }
                    ?>
                    <?php
                    foreach ($decodedFeeDetails as $decodedFeeDetail)
                    {
                        $feeType=$this->Shared_model->selectDataWhereSingle("tbl_feetype",array('id'=>$decodedFeeDetail->fee_type));
                        ?>
                        <tr>
                            <th><?=$feeType->type?>:</th>
                            <td><?=$decodedFeeDetail->balance?></td>
                        </tr>
                    <?php
                    }
                    ?>



                </table>
            </div>

            <div class="bold" class="row">
                <p style="margin-top: 20px;float: left">Total:</p>
                <p style="float: right; margin-top: 20px; text-decoration:underline; border-bottom : 1px double black; padding-bottom : 1px;"><?php echo 'Rs.' .$feeDetail->total_fee; ?></p>
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
        window.print()
    });
</script>