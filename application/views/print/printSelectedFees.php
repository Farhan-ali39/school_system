<?php $currency_symbol = $this->customlib->getSchoolCurrencyFormat(); ?>
<style type="text/css">
    @media print {
        .page-break	{ display: block; page-break-before: always; }
    }
    @media print {
        .page-break	{ display: block; page-break-before: always; }
        .col-sm-1, .col-sm-2, .col-sm-3, .col-sm-4, .col-sm-5, .col-sm-6, .col-sm-7, .col-sm-8, .col-sm-9, .col-sm-10, .col-sm-11, .col-sm-12 {
            float: left;
        }
        .col-sm-12 {
            width: 100%;
        }
        .col-sm-11 {
            width: 91.66666667%;
        }
        .col-sm-10 {
            width: 83.33333333%;
        }
        .col-sm-9 {
            width: 75%;
        }
        .col-sm-8 {
            width: 66.66666667%;
        }
        .col-sm-7 {
            width: 58.33333333%;
        }
        .col-sm-6 {
            width: 50%;
        }
        .col-sm-5 {
            width: 41.66666667%;
        }
        .col-sm-4 {
            width: 33.33333333%;
        }
        .col-sm-3 {
            width: 25%;
        }
        .col-sm-2 {
            width: 16.66666667%;
        }
        .col-sm-1 {
            width: 8.33333333%;
        }
        .col-sm-pull-12 {
            right: 100%;
        }
        .col-sm-pull-11 {
            right: 91.66666667%;
        }
        .col-sm-pull-10 {
            right: 83.33333333%;
        }
        .col-sm-pull-9 {
            right: 75%;
        }
        .col-sm-pull-8 {
            right: 66.66666667%;
        }
        .col-sm-pull-7 {
            right: 58.33333333%;
        }
        .col-sm-pull-6 {
            right: 50%;
        }
        .col-sm-pull-5 {
            right: 41.66666667%;
        }
        .col-sm-pull-4 {
            right: 33.33333333%;
        }
        .col-sm-pull-3 {
            right: 25%;
        }
        .col-sm-pull-2 {
            right: 16.66666667%;
        }
        .col-sm-pull-1 {
            right: 8.33333333%;
        }
        .col-sm-pull-0 {
            right: auto;
        }
        .col-sm-push-12 {
            left: 100%;
        }
        .col-sm-push-11 {
            left: 91.66666667%;
        }
        .col-sm-push-10 {
            left: 83.33333333%;
        }
        .col-sm-push-9 {
            left: 75%;
        }
        .col-sm-push-8 {
            left: 66.66666667%;
        }
        .col-sm-push-7 {
            left: 58.33333333%;
        }
        .col-sm-push-6 {
            left: 50%;
        }
        .col-sm-push-5 {
            left: 41.66666667%;
        }
        .col-sm-push-4 {
            left: 33.33333333%;
        }
        .col-sm-push-3 {
            left: 25%;
        }
        .col-sm-push-2 {
            left: 16.66666667%;
        }
        .col-sm-push-1 {
            left: 8.33333333%;
        }
        .col-sm-push-0 {
            left: auto;
        }
        .col-sm-offset-12 {
            margin-left: 100%;
        }
        .col-sm-offset-11 {
            margin-left: 91.66666667%;
        }
        .col-sm-offset-10 {
            margin-left: 83.33333333%;
        }
        .col-sm-offset-9 {
            margin-left: 75%;
        }
        .col-sm-offset-8 {
            margin-left: 66.66666667%;
        }
        .col-sm-offset-7 {
            margin-left: 58.33333333%;
        }
        .col-sm-offset-6 {
            margin-left: 50%;
        }
        .col-sm-offset-5 {
            margin-left: 41.66666667%;
        }
        .col-sm-offset-4 {
            margin-left: 33.33333333%;
        }
        .col-sm-offset-3 {
            margin-left: 25%;
        }
        .col-sm-offset-2 {
            margin-left: 16.66666667%;
        }
        .col-sm-offset-1 {
            margin-left: 8.33333333%;
        }
        .col-sm-offset-0 {
            margin-left: 0%;
        }
        .visible-xs {
            display: none !important;
        }
        .hidden-xs {
            display: block !important;
        }
        table.hidden-xs {
            display: table;
        }
        tr.hidden-xs {
            display: table-row !important;
        }
        th.hidden-xs,
        td.hidden-xs {
            display: table-cell !important;
        }
        .hidden-xs.hidden-print {
            display: none !important;
        }
        .hidden-sm {
            display: none !important;
        }
        .visible-sm {
            display: block !important;
        }
        table.visible-sm {
            display: table;
        }
        tr.visible-sm {
            display: table-row !important;
        }
        th.visible-sm,
        td.visible-sm {
            display: table-cell !important;
        }
    }
</style>

<html lang="en">
<head>
    <title><?php echo $this->lang->line('fees_receipt'); ?></title>
    <link rel="stylesheet" href="<?php echo base_url(); ?>backend/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>backend/dist/css/AdminLTE.min.css">
</head>
<body>
<div class="container">

    <div class="row">
        <div id="content" class="col-lg-12 col-sm-12 ">
            <div class="invoice">
                <div class="row header text-center">
                    <div class="col-sm-12">
                        <?php

                        ?>

                        <img  src="<?php echo base_url(); ?>/uploads/print_headerfooter/student_receipt/<?php $this->setting_model->get_receiptheader(); ?>" style="height: 100px;width: 100%;">
                        <?php

                        ?>
                    </div>
                    <?php
                    if ($settinglist[0]['is_duplicate_fees_invoice']) {
                        ?>
                        <div class="row">
                            <div class="col-md-12 text text-center">
                                <?php echo $this->lang->line('office_copy'); ?>
                            </div>
                        </div>
                        <?php
                    }
                    ?>

                    <div class="row">
                        <div class="col-xs-6">
                            <br/>
                            <address>
                                <strong><?php echo $stdDetail['firstname'] . " " . $stdDetail['lastname'] . " (" . $stdDetail['admission_no'] . ")"; ?></strong><br>

                                <?php echo $this->lang->line('father_name'); ?>: <?php echo $stdDetail['father_name']; ?><br>
                                <?php echo $this->lang->line('class'); ?>: <?php echo $stdDetail['class'] . " (" . $stdDetail['section'] . ")"; ?>
                            </address>
                        </div>
                        <div class="col-xs-6 text-right">
                            <br/>
                            <address>
                                <strong>Date: <?php
                                    $date = date('d-m-Y');

                                    echo date($this->customlib->getSchoolDateFormat(), $this->customlib->dateyyyymmddTodateformat($date));
                                    ?></strong><br/>

                            </address>
                        </div>
                    </div>
                    <hr style="margin-top: 0px;margin-bottom: 0px;" />
                    <div class="row">
                        <?php
                        if(!empty($student_fee))
                        {
                            ?>
                            <table class="table table-striped  table-hover example table-fixed-header">
                                <thead class="header">
                                <tr>
                                    <th align="left"><?php echo $this->lang->line('fees_type'); ?></th>
                                    <!--                                    <th align="left">--><?php //echo $this->lang->line('fees_code'); ?><!--</th>-->
                                    <th align="left" class="text text-left"><?php echo $this->lang->line('due_date'); ?></th>
                                    <th align="left" class="text text-left"><?php echo $this->lang->line('status'); ?></th>
                                    <th class="text text-right"><?php echo $this->lang->line('amount') ?> <span><?php echo "(" . $currency_symbol . ")"; ?></span></th>
                                    <th class="text text-left"><?php echo $this->lang->line('payment_id'); ?></th>
                                    <th class="text text-left"><?php echo $this->lang->line('mode'); ?></th>
                                    <th  class="text text-left"><?php echo $this->lang->line('date'); ?></th>
                                    <th class="text text-right" ><?php echo $this->lang->line('discount'); ?> <span><?php echo "(" . $currency_symbol . ")"; ?></span></th>
                                    <th class="text text-right"><?php echo $this->lang->line('fine'); ?> <span><?php echo "(" . $currency_symbol . ")"; ?></span></th>
                                    <th class="text text-right"><?php echo $this->lang->line('paid'); ?> <span><?php echo "(" . $currency_symbol . ")"; ?></span></th>
                                    <th class="text text-right"><?php echo $this->lang->line('balance'); ?> <span><?php echo "(" . $currency_symbol . ")"; ?></span></th>

                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                if(isset($student_fee))
                                {
                                    $grandTotal=0;
                                    $grandPaid=0;
                                    $grandPayableBalance=0;
//                                    echo "<pre>";
//                                var_dump($student_fee);
//                                die();
                                    foreach ($student_fee as $value) {

                                        if (in_array($value['fee_detail_id'], $feeDetailArray)) {


                                            $rem_balance = 0;
                                            $paid_balance = 0;
                                            $payable_balance = 0;
                                            $decodedFeeDetails = json_decode($value['fee_type']);
                                            $grandTotal = $grandTotal + $value['total_amount'];
                                            $feeInstallment = $this->Shared_model->selectDataWhereSingle("tbl_fee_installments", array('fee_detail_id' => $value['fee_detail_id'], 'std_id' => $stdDetail['id']));
                                            $feeType = $this->Shared_model->selectDataWhereSingle("tbl_feetype", array('id' => $decodedFeeDetails[0]->feeTypeID));
                                            $feeDepositDetails = $this->Shared_model->selectDataWhereMultiple("tbl_student_fee_deposit", array('std_fee_detail_id' => $value['fee_detail_id'], 'is_installment' => 0));
                                            $feeDepositDetailsforCal = $this->Shared_model->selectDataWhereMultiple("tbl_student_fee_deposit", array('std_fee_detail_id' => $value['fee_detail_id']));

                                            if (!empty($feeDepositDetailsforCal)) {
                                                foreach ($feeDepositDetailsforCal as $depositDetail) {
                                                    $rem_balance = $rem_balance + $depositDetail->remaining_amount;
                                                    $paid_balance = $paid_balance + $depositDetail->paid_amount;
                                                }
                                                $payable_balance = $value['last_amount'] - $paid_balance;
                                            } else {
                                                $payable_balance = $value['last_amount'];
                                            }
                                            $grandPaid = $grandPaid + $paid_balance;
                                            $grandPayableBalance = $grandPayableBalance + $payable_balance;
                                            if ($rem_balance >= 0 && strtotime($value['due_date']) < strtotime(date('Y-m-d'))) {
                                                ?>
                                                <tr class="danger font12">
                                                <?php
                                            } else {
                                                ?>
                                                <tr class="dark-gray">
                                                <?php
                                            }
                                            ?>
                                            <td align="left">
                                                <?php
                                                foreach ($decodedFeeDetails as $feeDetail) {
                                                    $feeType = $this->Shared_model->selectDataWhereSingle("tbl_feetype", array('id' => $feeDetail->feeTypeID));
                                                    echo $feeType->type . " (" . $feeDetail->fee_amount . ")<br>";

                                                }
                                                ?>

                                            </td>
                                            <td align="left" class="text text-left">
                                                <?= $value['due_date'] ?>
                                            </td>
                                            <td align="left" class="text text-left width85">
                                                <?php
                                                if ($value['fee_status'] == 1) {
                                                    ?><?php echo $this->lang->line('paid'); ?><?php
                                                } else if ($value['fee_status'] == 2) {
                                                    ?><?php echo $this->lang->line('partial'); ?><?php
                                                } else {
                                                    ?><?php echo $this->lang->line('unpaid'); ?><?php
                                                }
                                                ?>
                                            </td>
                                            <td class="text text-right">
                                                <?= $value['total_amount'] ?>
                                            </td>
                                            <td class="text text-left"></td>
                                            <td class="text text-left"></td>
                                            <td class="text text-left"></td>
                                            <td class="text text-right"><?php
                                                echo(number_format($value['total_amount'] - $value['last_amount'], 2, '.', ''));
                                                ?></td>
                                            <td class="text text-right"><?php
                                                echo(number_format($value['total_discount'], 2, '.', ''));
                                                ?></td>
                                            <td class="text text-right"><?php
                                                echo(number_format($paid_balance, 2, '.', ''));
                                                ?></td>
                                            <td class="text text-right"><?php
                                                $display_none = "ss-none";

                                                if ($payable_balance > 0) {
                                                    $display_none = "";

                                                    echo(number_format($payable_balance, 2, '.', ''));
                                                }
                                                if (!empty($feeInstallment)) {
                                                    $display_none = "ss-none";
                                                }
                                                ?>
                                            </td>
                                            </tr>

                                            <?php
                                            if (!empty($feeDepositDetails)) {
                                                foreach ($feeDepositDetails as $feeDepositDetail) {
                                                    ?>
                                                    <tr class="white-td">
                                                        <td align="left"></td>
                                                        <td align="left"></td>
                                                        <td align="left"></td>

                                                        <td class="text-right"><img
                                                                src="<?php echo base_url(); ?>backend/images/table-arrow.png"
                                                                alt=""/></td>
                                                        <td class="text text-left" style="display: flex;">

                                                            <a href="#" data-toggle="popover"
                                                               class="detail_popover"> <?php echo $feeDepositDetail->std_deposit_id . "/" . $feeDepositDetail->std_fee_detail_id; ?></a>
                                                            <div class="fee_detail_popover" style="display: none">
                                                                <?php
                                                                if ($feeDepositDetail->description == "") {
                                                                    ?>
                                                                    <p class="text text-danger"><?php echo $this->lang->line('no_description'); ?></p>
                                                                    <?php
                                                                } else {
                                                                    ?>
                                                                    <p class="text text-info"><?php echo $feeDepositDetail->description; ?></p>
                                                                    <?php
                                                                }
                                                                ?>
                                                            </div>
                                                        </td>
                                                        <td class="text text-left"><?php echo $feeDepositDetail->mode; ?></td>
                                                        <td class="text text-left">
                                                            <?php echo date($this->customlib->getSchoolDateFormat(), $this->customlib->dateyyyymmddTodateformat($feeDepositDetail->date)); ?>
                                                        </td>
                                                        <td class="text text-right"><?php echo(number_format(0, 2, '.', '')); ?></td>
                                                        <td class="text text-right"><?php echo(number_format(0, 2, '.', '')); ?></td>
                                                        <td class="text text-right"><?php echo(number_format($feeDepositDetail->paid_amount, 2, '.', '')); ?></td>
                                                        <td align="left"></td>
                                                    </tr>
                                                    <?php
                                                }
                                            }
                                            ?>
                                            <?php
                                            if (!empty($feeInstallment)) {

                                                $installmentIndex = 1;
                                                $feeInstallmentDetails = $this->Shared_model->selectDataWhereMultiple("tbl_installment_details", array('installment_id' => $feeInstallment->installment_id));
                                                foreach ($feeInstallmentDetails as $detail) {
                                                    $installmentpaid_balance = 0;
                                                    $installmentPayable_baln = 0;
                                                    $feeInstallmentDepositDetails = $this->Shared_model->selectDataWhereMultiple("tbl_student_fee_deposit", array('is_installment' => 1, 'installment_detail_id' => $detail->installment_detail_id));

                                                    if (!empty($feeInstallmentDepositDetails)) {
                                                        foreach ($feeInstallmentDepositDetails as $feeInstallmentDepositDetail) {
                                                            $installmentpaid_balance = $installmentpaid_balance + $feeInstallmentDepositDetail->paid_amount;
                                                        }
                                                        $installmentPayable_baln = $detail->amount - $installmentpaid_balance;
                                                    } else {
                                                        $installmentPayable_baln = $detail->amount;
                                                    }
                                                    ?>
                                                    <tr class="success white-td">
                                                        <td class="text-right"><img
                                                                src="<?php echo base_url(); ?>backend/images/table-arrow.png"
                                                                alt=""/>
                                                            Installment # <?= $installmentIndex ?>
                                                        </td>

                                                        <td align="left">
                                                            <?php echo $detail->due_date; ?>
                                                        </td>
                                                        <td align="left">
                                                            <?php
                                                            if ($detail->status == 1) {
                                                                ?>
                                                                <?php echo $this->lang->line('paid'); ?><?php
                                                            } else if ($detail->status == 2) {
                                                                ?>
                                                                <?php echo $this->lang->line('partial'); ?><?php
                                                            } else {
                                                                ?>
                                                                <?php echo $this->lang->line('unpaid'); ?><?php
                                                            }
                                                            ?>
                                                        </td>

                                                        <td class="text-right"><?= $detail->amount ?> </td>
                                                        <td class="text text-left">
                                                        </td>
                                                        <td class="text text-left"></td>
                                                        <td class="text text-left">

                                                        </td>
                                                        <td class="text text-right"><?php echo(number_format(0, 2, '.', '')); ?></td>
                                                        <td class="text text-right"><?php echo(number_format(0, 2, '.', '')); ?></td>
                                                        <td class="text text-right"><?php echo(number_format($installmentpaid_balance, 2, '.', '')); ?></td>
                                                        <td class="text text-right"><?php
                                                            if($installmentPayable_baln>0)
                                                            {
                                                                echo(number_format($installmentPayable_baln, 2, '.', ''));

                                                            }
                                                            ?>
                                                        </td>                                                    </tr>
                                                    <?php
                                                    $installmentIndex++;
                                                    if (!empty($feeInstallmentDepositDetails)) {
                                                        foreach ($feeInstallmentDepositDetails as $installmentDepositDetail) {
                                                            ?>
                                                            <tr class="white-td">
                                                                <td align="left"></td>
                                                                <td align="left"></td>
                                                                <td align="left"></td>

                                                                <td class="text-right"><img
                                                                        src="<?php echo base_url(); ?>backend/images/table-arrow.png"
                                                                        alt=""/></td>
                                                                <td class="text text-left" style="display: flex;">

                                                                    <a href="#" data-toggle="popover"
                                                                       class="detail_popover"> <?php echo $installmentDepositDetail->std_deposit_id . "/" . $installmentDepositDetail->std_fee_detail_id; ?></a>
                                                                    <div class="fee_detail_popover"
                                                                         style="display: none">
                                                                        <?php
                                                                        if ($installmentDepositDetail->description == "") {
                                                                            ?>
                                                                            <p class="text text-danger"><?php echo $this->lang->line('no_description'); ?></p>
                                                                            <?php
                                                                        } else {
                                                                            ?>
                                                                            <p class="text text-info"><?php echo $installmentDepositDetail->description; ?></p>
                                                                            <?php
                                                                        }
                                                                        ?>
                                                                    </div>
                                                                </td>
                                                                <td class="text text-left"><?php echo $installmentDepositDetail->mode; ?></td>
                                                                <td class="text text-left">
                                                                    <?php echo date($this->customlib->getSchoolDateFormat(), $this->customlib->dateyyyymmddTodateformat($installmentDepositDetail->date)); ?>
                                                                </td>
                                                                <td class="text text-right"><?php echo(number_format(0, 2, '.', '')); ?></td>
                                                                <td class="text text-right"><?php echo(number_format(0, 2, '.', '')); ?></td>
                                                                <td class="text text-right"><?php echo(number_format($installmentDepositDetail->paid_amount, 2, '.', '')); ?></td>
                                                                <td align="left"></td>
                                                            </tr>
                                                            <?php
                                                        }
                                                    }

                                                }
                                            }
                                        }
                                    }
                                    ?>
                                    <tr class="box box-solid total-bg">

                                        <td align="left" ></td>
                                        <td align="left" ></td>

                                        <th align="left" class="text text-left" ><?php echo $this->lang->line('grand_total'); ?></th>
                                        <th class="text text-right"><?php
                                            echo ($currency_symbol . number_format($grandTotal, 2, '.', ''));
                                            ?></th>

                                        <td class="text text-left"></td>
                                        <td class="text text-left"></td>
                                        <td class="text text-left"></td>

                                        <th class="text text-right"><?php
                                            echo ($currency_symbol . number_format(0, 2, '.', ''));
                                            ?></th>
                                        <th class="text text-right"><?php
                                            echo ($currency_symbol . number_format(0, 2, '.', ''));
                                            ?></th>
                                        <th class="text text-right"><?php
                                            echo ($currency_symbol . number_format($grandPaid, 2, '.', ''));
                                            ?></th>
                                        <th class="text text-right"><?php
                                            echo ($currency_symbol . number_format($grandPayableBalance, 2, '.', ''));
                                            ?></th>

                                    </tr>
                                    <?php
                                }
                                ?>
                                </tbody>

                            </table>
                            <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
            <div class="row header ">
                <div class="col-sm-12">
                    <?php $this->setting_model->get_receiptfooter(); ?>

                </div>

            </div>
        </div>

        <?php
        if ($settinglist[0]['is_duplicate_fees_invoice']) {
            ?>
            <div class="page-break"></div>
            <div class="row">
                <div id="content" class="col-lg-12 col-sm-12 ">
                    <div class="invoice">
                        <div class="col-sm-12">
                            <?php

                            ?>

                            <img  src="<?php echo base_url(); ?>/uploads/print_headerfooter/student_receipt/<?php $this->setting_model->get_receiptheader(); ?>" style="height: 100px;width: 100%;">
                            <?php

                            ?>
                        </div>
                        <div class="row">
                            <div class="col-md-12 text text-center">
                                <?php echo $this->lang->line('student_copy'); ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-6">
                                <br/>
                                <address>
                                    <strong><?php echo $stdDetail['firstname'] . " " . $stdDetail['lastname'] . " (" . $stdDetail['admission_no'] . ")"; ?></strong><br>

                                    <?php echo $this->lang->line('father_name'); ?>: <?php echo $stdDetail['father_name']; ?><br>
                                    <?php echo $this->lang->line('class'); ?>: <?php echo $stdDetail['class'] . " (" . $stdDetail['section'] . ")"; ?>
                                </address>
                            </div>
                            <div class="col-xs-6 text-right">
                                <br/>
                                <address>
                                    <strong>Date: <?php
                                        $date = date('d-m-Y');

                                        echo date($this->customlib->getSchoolDateFormat(), $this->customlib->dateyyyymmddTodateformat($date));
                                        ?></strong><br/>

                                </address>
                            </div>
                        </div>
                        <hr style="margin-top: 0px;margin-bottom: 0px;" />
                        <div class="row">
                            <?php
                            if(!empty($student_fee))
                            {
                                ?>
                                <table class="table table-striped  table-hover example table-fixed-header">
                                    <thead class="header">
                                    <tr>
                                        <th align="left"><?php echo $this->lang->line('fees_type'); ?></th>
                                        <!--                                    <th align="left">--><?php //echo $this->lang->line('fees_code'); ?><!--</th>-->
                                        <th align="left" class="text text-left"><?php echo $this->lang->line('due_date'); ?></th>
                                        <th align="left" class="text text-left"><?php echo $this->lang->line('status'); ?></th>
                                        <th class="text text-right"><?php echo $this->lang->line('amount') ?> <span><?php echo "(" . $currency_symbol . ")"; ?></span></th>
                                        <th class="text text-left"><?php echo $this->lang->line('payment_id'); ?></th>
                                        <th class="text text-left"><?php echo $this->lang->line('mode'); ?></th>
                                        <th  class="text text-left"><?php echo $this->lang->line('date'); ?></th>
                                        <th class="text text-right" ><?php echo $this->lang->line('discount'); ?> <span><?php echo "(" . $currency_symbol . ")"; ?></span></th>
                                        <th class="text text-right"><?php echo $this->lang->line('fine'); ?> <span><?php echo "(" . $currency_symbol . ")"; ?></span></th>
                                        <th class="text text-right"><?php echo $this->lang->line('paid'); ?> <span><?php echo "(" . $currency_symbol . ")"; ?></span></th>
                                        <th class="text text-right"><?php echo $this->lang->line('balance'); ?> <span><?php echo "(" . $currency_symbol . ")"; ?></span></th>

                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    if(isset($student_fee))
                                    {
                                        $grandTotal=0;
                                        $grandPaid=0;
                                        $grandPayableBalance=0;
//                                    echo "<pre>";
//                                var_dump($student_fee);
//                                die();
                                        foreach ($student_fee as $value) {

                                            if (in_array($value['fee_detail_id'], $feeDetailArray)) {


                                                $rem_balance = 0;
                                                $paid_balance = 0;
                                                $payable_balance = 0;
                                                $decodedFeeDetails = json_decode($value['fee_type']);
                                                $grandTotal = $grandTotal + $value['total_amount'];
                                                $feeInstallment = $this->Shared_model->selectDataWhereSingle("tbl_fee_installments", array('fee_detail_id' => $value['fee_detail_id'], 'std_id' => $stdDetail['id']));
                                                $feeType = $this->Shared_model->selectDataWhereSingle("tbl_feetype", array('id' => $decodedFeeDetails[0]->feeTypeID));
                                                $feeDepositDetails = $this->Shared_model->selectDataWhereMultiple("tbl_student_fee_deposit", array('std_fee_detail_id' => $value['fee_detail_id'], 'is_installment' => 0));
                                                $feeDepositDetailsforCal = $this->Shared_model->selectDataWhereMultiple("tbl_student_fee_deposit", array('std_fee_detail_id' => $value['fee_detail_id']));

                                                if (!empty($feeDepositDetailsforCal)) {
                                                    foreach ($feeDepositDetailsforCal as $depositDetail) {
                                                        $rem_balance = $rem_balance + $depositDetail->remaining_amount;
                                                        $paid_balance = $paid_balance + $depositDetail->paid_amount;
                                                    }
                                                    $payable_balance = $value['last_amount'] - $paid_balance;
                                                } else {
                                                    $payable_balance = $value['last_amount'];
                                                }
                                                $grandPaid = $grandPaid + $paid_balance;
                                                $grandPayableBalance = $grandPayableBalance + $payable_balance;
                                                if ($rem_balance >= 0 && strtotime($value['due_date']) < strtotime(date('Y-m-d'))) {
                                                    ?>
                                                    <tr class="danger font12">
                                                    <?php
                                                } else {
                                                    ?>
                                                    <tr class="dark-gray">
                                                    <?php
                                                }
                                                ?>
                                                <td align="left">
                                                    <?php
                                                    foreach ($decodedFeeDetails as $feeDetail) {
                                                        $feeType = $this->Shared_model->selectDataWhereSingle("tbl_feetype", array('id' => $feeDetail->feeTypeID));
                                                        echo $feeType->type . " (" . $feeDetail->fee_amount . ")<br>";

                                                    }
                                                    ?>

                                                </td>
                                                <td align="left" class="text text-left">
                                                    <?= $value['due_date'] ?>
                                                </td>
                                                <td align="left" class="text text-left width85">
                                                    <?php
                                                    if ($value['fee_status'] == 1) {
                                                        ?><?php echo $this->lang->line('paid'); ?><?php
                                                    } else if ($value['fee_status'] == 2) {
                                                        ?><?php echo $this->lang->line('partial'); ?><?php
                                                    } else {
                                                        ?><?php echo $this->lang->line('unpaid'); ?><?php
                                                    }
                                                    ?>
                                                </td>
                                                <td class="text text-right">
                                                    <?= $value['total_amount'] ?>
                                                </td>
                                                <td class="text text-left"></td>
                                                <td class="text text-left"></td>
                                                <td class="text text-left"></td>
                                                <td class="text text-right"><?php
                                                    echo(number_format($value['total_amount'] - $value['last_amount'], 2, '.', ''));
                                                    ?></td>
                                                <td class="text text-right"><?php
                                                    echo(number_format($value['total_discount'], 2, '.', ''));
                                                    ?></td>
                                                <td class="text text-right"><?php
                                                    echo(number_format($paid_balance, 2, '.', ''));
                                                    ?></td>
                                                <td class="text text-right"><?php
                                                    $display_none = "ss-none";

                                                    if ($payable_balance > 0) {
                                                        $display_none = "";

                                                        echo(number_format($payable_balance, 2, '.', ''));
                                                    }
                                                    if (!empty($feeInstallment)) {
                                                        $display_none = "ss-none";
                                                    }
                                                    ?>
                                                </td>
                                                </tr>

                                                <?php
                                                if (!empty($feeDepositDetails)) {
                                                    foreach ($feeDepositDetails as $feeDepositDetail) {
                                                        ?>
                                                        <tr class="white-td">
                                                            <td align="left"></td>
                                                            <td align="left"></td>
                                                            <td align="left"></td>

                                                            <td class="text-right"><img
                                                                    src="<?php echo base_url(); ?>backend/images/table-arrow.png"
                                                                    alt=""/></td>
                                                            <td class="text text-left" style="display: flex;">

                                                                <a href="#" data-toggle="popover"
                                                                   class="detail_popover"> <?php echo $feeDepositDetail->std_deposit_id . "/" . $feeDepositDetail->std_fee_detail_id; ?></a>
                                                                <div class="fee_detail_popover" style="display: none">
                                                                    <?php
                                                                    if ($feeDepositDetail->description == "") {
                                                                        ?>
                                                                        <p class="text text-danger"><?php echo $this->lang->line('no_description'); ?></p>
                                                                        <?php
                                                                    } else {
                                                                        ?>
                                                                        <p class="text text-info"><?php echo $feeDepositDetail->description; ?></p>
                                                                        <?php
                                                                    }
                                                                    ?>
                                                                </div>
                                                            </td>
                                                            <td class="text text-left"><?php echo $feeDepositDetail->mode; ?></td>
                                                            <td class="text text-left">
                                                                <?php echo date($this->customlib->getSchoolDateFormat(), $this->customlib->dateyyyymmddTodateformat($feeDepositDetail->date)); ?>
                                                            </td>
                                                            <td class="text text-right"><?php echo(number_format(0, 2, '.', '')); ?></td>
                                                            <td class="text text-right"><?php echo(number_format(0, 2, '.', '')); ?></td>
                                                            <td class="text text-right"><?php echo(number_format($feeDepositDetail->paid_amount, 2, '.', '')); ?></td>
                                                            <td align="left"></td>
                                                        </tr>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                                <?php
                                                if (!empty($feeInstallment)) {

                                                    $installmentIndex = 1;
                                                    $feeInstallmentDetails = $this->Shared_model->selectDataWhereMultiple("tbl_installment_details", array('installment_id' => $feeInstallment->installment_id));
                                                    foreach ($feeInstallmentDetails as $detail) {
                                                        $installmentpaid_balance = 0;
                                                        $installmentPayable_baln = 0;
                                                        $feeInstallmentDepositDetails = $this->Shared_model->selectDataWhereMultiple("tbl_student_fee_deposit", array('is_installment' => 1, 'installment_detail_id' => $detail->installment_detail_id));

                                                        if (!empty($feeInstallmentDepositDetails)) {
                                                            foreach ($feeInstallmentDepositDetails as $feeInstallmentDepositDetail) {
                                                                $installmentpaid_balance = $installmentpaid_balance + $feeInstallmentDepositDetail->paid_amount;
                                                            }
                                                            $installmentPayable_baln = $detail->amount - $installmentpaid_balance;
                                                        } else {
                                                            $installmentPayable_baln = $detail->amount;
                                                        }
                                                        ?>
                                                        <tr class="success white-td">
                                                            <td class="text-right"><img
                                                                    src="<?php echo base_url(); ?>backend/images/table-arrow.png"
                                                                    alt=""/>
                                                                Installment # <?= $installmentIndex ?>
                                                            </td>

                                                            <td align="left">
                                                                <?php echo $detail->due_date; ?>
                                                            </td>
                                                            <td align="left">
                                                                <?php
                                                                if ($detail->status == 1) {
                                                                    ?>
                                                                    <?php echo $this->lang->line('paid'); ?><?php
                                                                } else if ($detail->status == 2) {
                                                                    ?>
                                                                    <?php echo $this->lang->line('partial'); ?><?php
                                                                } else {
                                                                    ?>
                                                                    <?php echo $this->lang->line('unpaid'); ?><?php
                                                                }
                                                                ?>
                                                            </td>

                                                            <td class="text-right"><?= $detail->amount ?> </td>
                                                            <td class="text text-left">
                                                            </td>
                                                            <td class="text text-left"></td>
                                                            <td class="text text-left">

                                                            </td>
                                                            <td class="text text-right"><?php echo(number_format(0, 2, '.', '')); ?></td>
                                                            <td class="text text-right"><?php echo(number_format(0, 2, '.', '')); ?></td>
                                                            <td class="text text-right"><?php echo(number_format($installmentpaid_balance, 2, '.', '')); ?></td>
                                                            <td class="text text-right"><?php
                                                                if($installmentPayable_baln>0)
                                                                {
                                                                    echo(number_format($installmentPayable_baln, 2, '.', ''));

                                                                }
                                                                ?>
                                                            </td>
                                                        </tr>
                                                        <?php
                                                        $installmentIndex++;
                                                        if (!empty($feeInstallmentDepositDetails)) {
                                                            foreach ($feeInstallmentDepositDetails as $installmentDepositDetail) {
                                                                ?>
                                                                <tr class="white-td">
                                                                    <td align="left"></td>
                                                                    <td align="left"></td>
                                                                    <td align="left"></td>

                                                                    <td class="text-right"><img
                                                                            src="<?php echo base_url(); ?>backend/images/table-arrow.png"
                                                                            alt=""/></td>
                                                                    <td class="text text-left" style="display: flex;">

                                                                        <a href="#" data-toggle="popover"
                                                                           class="detail_popover"> <?php echo $installmentDepositDetail->std_deposit_id . "/" . $installmentDepositDetail->std_fee_detail_id; ?></a>
                                                                        <div class="fee_detail_popover"
                                                                             style="display: none">
                                                                            <?php
                                                                            if ($installmentDepositDetail->description == "") {
                                                                                ?>
                                                                                <p class="text text-danger"><?php echo $this->lang->line('no_description'); ?></p>
                                                                                <?php
                                                                            } else {
                                                                                ?>
                                                                                <p class="text text-info"><?php echo $installmentDepositDetail->description; ?></p>
                                                                                <?php
                                                                            }
                                                                            ?>
                                                                        </div>
                                                                    </td>
                                                                    <td class="text text-left"><?php echo $installmentDepositDetail->mode; ?></td>
                                                                    <td class="text text-left">
                                                                        <?php echo date($this->customlib->getSchoolDateFormat(), $this->customlib->dateyyyymmddTodateformat($installmentDepositDetail->date)); ?>
                                                                    </td>
                                                                    <td class="text text-right"><?php echo(number_format(0, 2, '.', '')); ?></td>
                                                                    <td class="text text-right"><?php echo(number_format(0, 2, '.', '')); ?></td>
                                                                    <td class="text text-right"><?php echo(number_format($installmentDepositDetail->paid_amount, 2, '.', '')); ?></td>
                                                                    <td align="left"></td>
                                                                </tr>
                                                                <?php
                                                            }
                                                        }

                                                    }
                                                }
                                            }
                                        }
                                        ?>
                                        <tr class="box box-solid total-bg">

                                            <td align="left" ></td>
                                            <td align="left" ></td>

                                            <th align="left" class="text text-left" ><?php echo $this->lang->line('grand_total'); ?></th>
                                            <th class="text text-right"><?php
                                                echo ($currency_symbol . number_format($grandTotal, 2, '.', ''));
                                                ?></th>

                                            <td class="text text-left"></td>
                                            <td class="text text-left"></td>
                                            <td class="text text-left"></td>

                                            <th class="text text-right"><?php
                                                echo ($currency_symbol . number_format(0, 2, '.', ''));
                                                ?></th>
                                            <th class="text text-right"><?php
                                                echo ($currency_symbol . number_format(0, 2, '.', ''));
                                                ?></th>
                                            <th class="text text-right"><?php
                                                echo ($currency_symbol . number_format($grandPaid, 2, '.', ''));
                                                ?></th>
                                            <th class="text text-right"><?php
                                                echo ($currency_symbol . number_format($grandPayableBalance, 2, '.', ''));
                                                ?></th>

                                        </tr>
                                        <?php
                                    }
                                    ?>
                                    </tbody>

                                </table>
                                <?php
                            }
                            ?>



                        </div>
                    </div>
                </div>
                <div class="row header ">
                    <div class="col-sm-12">
                        <?php $this->setting_model->get_receiptfooter(); ?>

                    </div>

                </div>
            </div>
            <?php
        }
        ?>

    </div>

    <div class="clearfix"></div>

</body>
</html>
