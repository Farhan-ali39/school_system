<?php
$ci =& get_instance();
$ci->load->model('Shared_model');

$currency_symbol = $this->customlib->getSchoolCurrencyFormat();
?>
<div class="content-wrapper">
    <div class="row">
        <div class="col-md-12">
            <section class="content-header">
                <h1>
                    <i class="fa fa-money"></i> <?php echo $this->lang->line('fees_collection'); ?><small><?php echo $this->lang->line('student_fee'); ?></small></h1>
            </section>
        </div>
        </div>
    <!-- /.control-sidebar -->
    <section class="content">
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header">
                        <div class="row">
                            <div class="col-md-4">
                                <h3 class="box-title"><?php echo $this->lang->line('student_fees'); ?></h3>
                            </div>
                            <div class="col-md-8 ">
                                <div class="btn-group pull-right">
                                    <a href="<?php echo base_url() ?>parent/parents/dashboard" type="button" class="btn btn-primary btn-xs">
                                        <i class="fa fa-arrow-left"></i> <?php echo $this->lang->line('back'); ?></a>
                                </div>
                            </div>
                        </div>
                    </div><!--./box-header-->
                    <div class="box-body" style="padding-top:0;">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="sfborder">
                                    <div class="col-md-2">
                                         <img class="profile-user-img img-responsive img-circle" src="<?php echo base_url() . $student['image'] ?>" alt="User profile picture">
                                    </div>

                                    <div class="col-md-10">
                                        <div class="row">

                                            <table class="table table-striped mb0 font13">
                                                <tbody>
                                                    <tr>
                                                        <th class="bozero"><?php echo $this->lang->line('name'); ?></th>
                                                        <td class="bozero"><?php echo $student['firstname'] . " " . $student['lastname'] ?></td>

                                                        <th class="bozero"><?php echo $this->lang->line('class_section'); ?></th>
                                                        <td class="bozero"><?php echo $student['class'] . " (" . $student['section'] . ")" ?> </td>
                                                    </tr>
                                                    <tr>
                                                        <th><?php echo $this->lang->line('father_name'); ?></th>
                                                        <td><?php echo $student['father_name']; ?></td>
                                                        <th><?php echo $this->lang->line('admission_no'); ?></th>
                                                        <td><?php echo $student['admission_no']; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th><?php echo $this->lang->line('mobile_no'); ?></th>
                                                        <td><?php echo $student['mobileno']; ?></td>
                                                        <th><?php echo $this->lang->line('roll_no'); ?></th>
                                                        <td> <?php echo $student['roll_no']; ?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th><?php echo $this->lang->line('category'); ?></th>
                                                        <td>
                                                            <?php
                                                            foreach ($categorylist as $value) {
                                                                if ($student['category_id'] == $value['id']) {
                                                                    echo $value['category'];
                                                                }
                                                            }
                                                            ?>
                                                        </td>
                                                        <th><?php echo $this->lang->line('rte'); ?></th>
                                                        <td><b class="text-danger"> <?php echo $student['rte']; ?> </b>
                                                        </td>
                                                    </tr>

                                                </tbody>
                                            </table>
                                       
                                        </div>
                                    </div>


                                </div></div>
                            <div class="col-md-12">
                                <div style="background: #dadada; height: 1px; width: 100%; clear: both; margin-bottom: 10px;"></div>
                            </div>
                        </div>
                       
                        <div class="table-responsive">
                            <div class="download_label"><?php echo $this->lang->line('student_fees') . ": " . $student['firstname'] . " " . $student['lastname'] ?> </div>
                              <?php
                        if (empty($student_fee)) {
                            ?>
                            <div class="alert alert-danger">
                                No fees Found.
                            </div>
                            <?php
                        } else {
                            ?>
                            <table class="table table-striped table-bordered table-hover  table-fixed-header">
                                <thead class="header">
                                <tr>
                                    <th><?php echo $this->lang->line('fees_type'); ?></th>
                                    <!--                                            <th>--><?php //echo $this->lang->line('fees_code'); ?><!--</th>-->
                                    <th class="text text-left"><?php echo $this->lang->line('due_date'); ?></th>
                                    <th class="text text-left"><?php echo $this->lang->line('status'); ?></th>
                                    <th class="text text-right"><?php echo $this->lang->line('amount'); ?> <span><?php echo "(" . $currency_symbol . ")"; ?></span></th>
                                    <th class="text text-left"><?php echo $this->lang->line('payment_id'); ?></th>
                                    <th class="text text-left"><?php echo $this->lang->line('mode'); ?></th>
                                    <th class="text text-left"><?php echo $this->lang->line('date'); ?></th>
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
                                    foreach ($student_fee as $value)
                                    {


                                        $rem_balance=0;
                                        $paid_balance=0;
                                        $payable_balance=0;
                                        $decodedFeeDetails=json_decode($value['fee_type'] );
                                        $grandTotal=$grandTotal+$value['total_amount'];
                                        $feeInstallment=$this->Shared_model->selectDataWhereSingle("tbl_fee_installments",array('fee_detail_id'=>$value['fee_detail_id'],'std_id'=>$student['id']));
                                        $feeType=$this->Shared_model->selectDataWhereSingle("tbl_feetype",array('id'=>$decodedFeeDetails[0]->feeTypeID));
                                        $feeDepositDetails=$this->Shared_model->selectDataWhereMultiple("tbl_student_fee_deposit",array('std_fee_detail_id'=>$value['fee_detail_id'],'is_installment'=>0));
                                        $feeDepositDetailsforCal=$this->Shared_model->selectDataWhereMultiple("tbl_student_fee_deposit",array('std_fee_detail_id'=>$value['fee_detail_id']));

                                        if(!empty($feeDepositDetailsforCal))
                                        {
                                            foreach ($feeDepositDetailsforCal as $depositDetail)
                                            {
                                                $rem_balance=$rem_balance+$depositDetail->remaining_amount;
                                                $paid_balance=$paid_balance+$depositDetail->paid_amount;
                                            }
                                            $payable_balance=$value['last_amount']-$paid_balance;
                                        }else{
                                            $payable_balance=$value['last_amount'];
                                        }
                                        $grandPaid=$grandPaid+$paid_balance;
                                        $grandPayableBalance=$grandPayableBalance+$payable_balance;
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
                                            foreach ($decodedFeeDetails as $feeDetail)
                                            {
                                                $feeType=$this->Shared_model->selectDataWhereSingle("tbl_feetype",array('id'=>$feeDetail->feeTypeID));
                                                echo $feeType->type." (".$feeDetail->fee_amount.")<br>";

                                            }
                                            ?>

                                        </td>
                                        <td align="left" class="text text-left">
                                            <?=$value['due_date']?>
                                        </td>
                                        <td align="left" class="text text-left width85">
                                            <?php
                                            if ($value['fee_status'] == 1) {
                                                ?><span class="label label-success"><?php echo $this->lang->line('paid'); ?></span><?php
                                            } else if ($value['fee_status']==2) {
                                                ?><span class="label label-warning"><?php echo $this->lang->line('partial'); ?></span><?php
                                            } else {
                                                ?><span class="label label-danger"><?php echo $this->lang->line('unpaid'); ?></span><?php
                                            }
                                            ?>
                                        </td>
                                        <td class="text text-right">
                                            <?=$value['total_amount']?>
                                        </td>
                                        <td class="text text-left"></td>
                                        <td class="text text-left"></td>
                                        <td class="text text-left"></td>
                                        <td class="text text-right"><?php
                                            echo (number_format($value['total_amount']-$value['last_amount'], 2, '.', ''));
                                            ?></td>
                                        <td class="text text-right"><?php
                                            echo (number_format($value['total_discount'], 2, '.', ''));
                                            ?></td>
                                        <td class="text text-right"><?php
                                            echo (number_format($paid_balance, 2, '.', ''));
                                            ?></td>
                                        <td class="text text-right"><?php
                                            $display_none = "ss-none";

                                            if ($payable_balance >= 0) {
                                                $display_none = "";

                                                echo (number_format($payable_balance, 2, '.', ''));
                                            }
                                            if(!empty($feeInstallment))
                                            {
                                                $display_none = "ss-none";
                                            }
                                            ?>
                                        </td>
                                        </tr>

                                        <?php
                                        if(!empty($feeDepositDetails))
                                        {
                                            foreach ($feeDepositDetails as $feeDepositDetail)
                                            {
                                                ?>
                                                <tr class="white-td">
                                                    <td align="left"></td>
                                                    <td align="left"></td>
                                                    <td align="left"></td>

                                                    <td class="text-right"> <img src="<?php echo base_url(); ?>backend/images/table-arrow.png" alt="" /></td>
                                                    <td class="text text-left" style="display: flex;">

                                                        <a href="#" data-toggle="popover" class="detail_popover" > <?php echo $feeDepositDetail->std_deposit_id . "/" . $feeDepositDetail->std_fee_detail_id; ?></a>
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
                                                    <td class="text text-right"><?php echo (number_format(0, 2, '.', '')); ?></td>
                                                    <td class="text text-right"><?php echo (number_format(0, 2, '.', '')); ?></td>
                                                    <td class="text text-right"><?php echo (number_format($feeDepositDetail->paid_amount, 2, '.', '')); ?></td>
                                                    <td align="left"></td>
                                                </tr>
                                                <?php
                                            }
                                        }
                                        ?>
                                        <?php
                                        if(!empty($feeInstallment))
                                        {

                                            $installmentIndex=1;
                                            $feeInstallmentDetails=$this->Shared_model->selectDataWhereMultiple("tbl_installment_details",array('installment_id'=>$feeInstallment->installment_id));
                                            foreach ($feeInstallmentDetails as $detail)
                                            {
                                                $installmentpaid_balance=0;
                                                $installmentPayable_baln=0;
                                                $feeInstallmentDepositDetails=$this->Shared_model->selectDataWhereMultiple("tbl_student_fee_deposit",array('is_installment'=>1,'installment_detail_id'=>$detail->installment_detail_id));

                                                if(!empty($feeInstallmentDepositDetails))
                                                {
                                                    foreach ($feeInstallmentDepositDetails as $feeInstallmentDepositDetail)
                                                    {
                                                        $installmentpaid_balance=$installmentpaid_balance+$feeInstallmentDepositDetail->paid_amount;
                                                    }
                                                    $installmentPayable_baln=$detail->amount-$installmentpaid_balance;
                                                }else
                                                {
                                                    $installmentPayable_baln=$detail->amount;
                                                }
                                                ?>
                                                <tr class="success white-td">
                                                    <!--                                                        <td class="text-right"></td>-->
                                                    <td align="left" style="display: flex;">
                                                        <img src="<?php echo base_url(); ?>backend/images/table-arrow.png" alt="" />
                                                        Installment # <?=$installmentIndex?></td>
                                                    <td align="left">
                                                        <?php echo $detail->due_date; ?>
                                                    </td>
                                                    <td align="left">
                                                        <?php
                                                        if ($detail->status == 1) {
                                                            ?><span class="label label-success"><?php echo $this->lang->line('paid'); ?></span><?php
                                                        } else if ($detail->status==2) {
                                                            ?><span class="label label-warning"><?php echo $this->lang->line('partial'); ?></span><?php
                                                        } else {
                                                            ?><span class="label label-danger"><?php echo $this->lang->line('unpaid'); ?></span><?php
                                                        }
                                                        ?>
                                                    </td>

                                                    <td class="text-right"><?=$detail->amount?> </td>
                                                    <td class="text text-left"  >
                                                    </td>
                                                    <td class="text text-left"> </td>
                                                    <td class="text text-left">

                                                    </td>
                                                    <td class="text text-right"><?php echo (number_format(0, 2, '.', '')); ?></td>
                                                    <td class="text text-right"><?php echo (number_format(0, 2, '.', '')); ?></td>
                                                    <td class="text text-right"><?php echo (number_format($installmentpaid_balance, 2, '.', '')); ?></td>
                                                    <td class="text text-right"><?php echo (number_format($installmentPayable_baln, 2, '.', '')); ?></td>
                                                </tr>
                                                <?php
                                                $installmentIndex++;
                                                if(!empty($feeInstallmentDepositDetails))
                                                {
                                                    foreach ($feeInstallmentDepositDetails as $installmentDepositDetail)
                                                    {
                                                        ?>
                                                        <tr class="white-td">
                                                            <td align="left"></td>
                                                            <td align="left"></td>
                                                            <td align="left"></td>

                                                            <td class="text-right"> <img src="<?php echo base_url(); ?>backend/images/table-arrow.png" alt="" /></td>
                                                            <td class="text text-left" style="display: flex;">

                                                                <a href="#" data-toggle="popover" class="detail_popover" > <?php echo $installmentDepositDetail->std_deposit_id . "/" . $installmentDepositDetail->std_fee_detail_id; ?></a>
                                                                <div class="fee_detail_popover" style="display: none">
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
                                                            <td class="text text-right"><?php echo (number_format(0, 2, '.', '')); ?></td>
                                                            <td class="text text-right"><?php echo (number_format(0, 2, '.', '')); ?></td>
                                                            <td class="text text-right"><?php echo (number_format($installmentDepositDetail->paid_amount, 2, '.', '')); ?></td>
                                                            <td align="left"></td>
                                                        </tr>
                                                        <?php
                                                    }
                                                }

                                            }
                                        }
                                    }
                                    ?>
                                    <tr class="box box-solid total-bg">
                                        <td align="left" ></td>
                                        <td align="left" ></td>

                                        <td align="left" class="text text-left" ><?php echo $this->lang->line('grand_total'); ?></td>
                                        <td class="text text-right"><?php
                                            echo ($currency_symbol . number_format($grandTotal, 2, '.', ''));
                                            ?></td>
                                        <td class="text text-left"></td>
                                        <td class="text text-left"></td>
                                        <td class="text text-left"></td>

                                        <td class="text text-right"><?php
                                            echo ($currency_symbol . number_format(0, 2, '.', ''));
                                            ?></td>
                                        <td class="text text-right"><?php
                                            echo ($currency_symbol . number_format(0, 2, '.', ''));
                                            ?></td>
                                        <td class="text text-right"><?php
                                            echo ($currency_symbol . number_format($grandPaid, 2, '.', ''));
                                            ?></td>
                                        <td class="text text-right"><?php
                                            echo ($currency_symbol . number_format($grandPayableBalance, 2, '.', ''));
                                            ?></td>
                                        <td class="text text-right"></td>
                                    </tr>
                                    <?php
                                }
                                ?>
                                </tbody>
                            </table>
                        <?php } ?>
                        </div>
                    </div>
                    <!-- /.box-body -->
                </div>


            </div>
            <!--/.col (left) -->

        </div>

    </section>

</div>
