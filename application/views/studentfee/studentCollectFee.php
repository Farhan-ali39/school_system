<?php
$currency_symbol = $this->customlib->getSchoolCurrencyFormat();
$language = $this->customlib->getLanguage();
$language_name = $language["short_code"];
$ci =& get_instance();
$ci->load->model('Shared_model');

?>
<div class="content-wrapper" xmlns="http://www.w3.org/1999/html">
    <div class="row">
        <div class="col-md-12">
            <section class="content-header">
                <h1>
                    <i class="fa fa-money"></i> <?php echo $this->lang->line('fees_collection'); ?><small><?php echo $this->lang->line('student_fee'); ?></small></h1>
            </section>
        </div>
        <div>
            <a id="sidebarCollapse" class="studentsideopen"><i class="fa fa-navicon"></i></a>
            <aside class="studentsidebar">
                <div class="stutop" id="">
                    <!-- Create the tabs -->
                    <div class="studentsidetopfixed">
                        <p class="classtap"><?php echo $student["class"]; ?> <a href="#" data-toggle="control-sidebar" class="studentsideclose"><i class="fa fa-times"></i></a></p>
                        <ul class="nav nav-justified studenttaps">
                            <?php foreach ($class_section as $skey => $svalue) {
                                ?>
                                <li <?php
                                if ($student["section_id"] == $svalue["section_id"]) {
                                    echo "class='active'";
                                }
                                ?> ><a href="#section<?php echo $svalue["section_id"] ?>" data-toggle="tab"><?php print_r($svalue["section"]); ?></a></li>
                            <?php } ?>
                        </ul>
                    </div>
                    <!-- Tab panes -->
                    <div class="tab-content">
                        <?php foreach ($class_section as $skey => $snvalue) {
                            ?>
                            <div class="tab-pane <?php
                            if ($student["section_id"] == $snvalue["section_id"]) {
                                echo "active";
                            }
                            ?>" id="section<?php echo $snvalue["section_id"]; ?>">
                                <?php
                                foreach ($studentlistbysection as $stkey => $stvalue) {
                                    if ($stvalue['section_id'] == $snvalue["section_id"]) {
                                        ?>
                                        <div class="studentname">
                                            <a class="" href="<?php echo base_url() . "studentfee/CollectFee/" . $stvalue["id"] ?>">
                                                <div class="icon"><img src="<?php echo base_url() . (!empty($stvalue["image"])?$stvalue["image"]:"uploads/student_images/no_image.png"); ?>" alt="User Image"></div>
                                                <div class="student-tittle"><?php echo $stvalue["firstname"] . " " . $stvalue["lastname"]; ?></div></a>
                                        </div>
                                        <?php
                                    }
                                }
                                ?>
                            </div>
                        <?php } ?>
                        <div class="tab-pane" id="sectionB">
                            <h3 class="control-sidebar-heading">Recent Activity 2</h3>
                        </div>

                        <div class="tab-pane" id="sectionC">
                            <h3 class="control-sidebar-heading">Recent Activity 3</h3>
                        </div>
                        <div class="tab-pane" id="sectionD">
                            <h3 class="control-sidebar-heading">Recent Activity 3</h3>
                        </div>
                        <!-- /.tab-pane -->
                    </div>
                </div>
            </aside>
        </div></div>
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
                            <div class="col-md-8">
                                <div class="btn-group pull-right">
                                    <a href="<?php echo base_url() ?>studentfee/feeCollectionSearch" type="button" class="btn btn-primary btn-xs">
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
                                        <img width="115" height="115" class="round5" src="<?php
                                        if (!empty($student['image'])) {
                                            echo base_url() . $student['image'];
                                        } else {
                                            echo base_url() . "uploads/student_images/no_image.png";
                                        }
                                        ?>" alt="No Image">
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
                        <div class="row no-print">
                            <div class="col-md-12 mDMb10">
<!--                                <a href="#" class="btn btn-sm btn-info printSelected"><i class="fa fa-print"></i> --><?php //echo $this->lang->line('print_selected'); ?><!-- </a>-->
                                <form action="<?=base_url('studentfee/genrateMultiFeeVoucher')?>" id="printVoucherForm" method="post">
                                    <!--                                    <button type="button" class="btn btn-sm btn-info" id="genrateVoucherbtn"><i class="fa fa-print" data-target="#voucherDates"></i> Print Voucher</button>-->


                                    <!-- Modal -->
                                    <input type="hidden" name="stdId" id="voucherstdId" value="<?= $student['id']?>">
                                    <input type="hidden" name="voucherIssueDate" id="voucherIssueDateInput" value="">
                                    <input type="hidden" name="voucherStuckOffDate" id="voucherStuckOffDateInput" value="">
                                    <input type="hidden" name="voucherDueDate" id="voucherDueDateInput" value="">
                                    <input type="hidden" name="voucherBillingPeriod" id="voucherBillingPeriod" value="">
                                    <div id="feeDetailArraydiv">

                                    </div>
                                    <div id="InstallmentDetailArraydiv">

                                    </div>

                                </form>
                                <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#myModal"  ><i class="fa fa-print"></i> Print Voucher</button>

                                <!-- Trigger the modal with a button -->
                                <button type="button" class="btn btn-sm btn-info  "  onclick="setInstallmentModal()"  >Individual Installment</button>

<!--                                <button type="button" class="btn btn-sm btn-warning collectSelected" id="load" data-loading-text="<i class='fa fa-spinner fa-spin '></i> Please Wait.."><i class="fa fa-money"></i> --><?php //echo $this->lang->line('collect')." ".$this->lang->line('selected')?><!--</button>-->
<!--                                <button type="button" class="btn btn-sm btn-success addInstallment" onclick="setInstallmentModal()"  id="installments" data-loading-text="<i class='fa fa-spinner fa-spin '></i> Please Wait.."><i class="fa fa-money"></i> Add Installment</button>-->
<!--                                <button type="button" class="btn btn-sm btn-success addInstallment" data-toggle="modal" data-target="#listCollectionModal"   id="installments" data-loading-text="<i class='fa fa-spinner fa-spin '></i> Please Wait.."><i class="fa fa-money"></i> Add Installment</button>-->
                                <button type="button" class="btn btn-sm btn-success addInstallment" data-toggle="modal" data-target="#myInstallmentModal"   id="installments" data-loading-text="<i class='fa fa-spinner fa-spin '></i> Please Wait.."><i class="fa fa-money"></i> Add Installment</button>
<!--                                <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#listCollectionModal"  ><i class="fa fa-print"></i> Individual Installment</button>-->

<!--                                <button type="button" class="btn btn-sm btn-success createIndividualInstallments" data-toggle="modal" data-target="#listCollectionModal"   id="installmentsIndividual" data-loading-text="<i class='fa fa-spinner fa-spin '></i> Please Wait.."><i class="fa fa-money"></i> </button>-->
<!--                                <a href="#" class="btn btn-sm btn-info genrateVoucher"><i class="fa fa-print"></i> Print Voucher</a>-->
                                <span class="pull-right"><?php echo $this->lang->line('date'); ?>: <?php echo date($this->customlib->getSchoolDateFormat()); ?></span>
                            </div>
                            <div id="myModal1" class="modal fade" role="dialog">
                                <div class="modal-dialog">

                                    <!-- Modal content-->
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            <h4 class="modal-title">Add Installments</h4>
                                        </div>
                                        <div class="modal-body">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="exampleInputFile">Select fee</label><small class="req"> *</small>
                                                    <select class="form-control" name="fee_installments_select" id="fee_installments_select" onchange="generateDateInputs('_in')">
                                                    </select>
                                                    <span class="text-danger"><?php echo form_error('fee_case'); ?></span>
                                                </div>

                                                <div class="form-group">
                                                    <label for="exampleInputFile">Number of Installments</label><small class="req"> *</small>
                                                    <select class="form-control" name="num_installments" id="num_installments_in" onchange="generateDateInputs('_in')">
                                                        <option value=""><?php echo $this->lang->line('select'); ?></option>
                                                        <option value="2">Two</option>
                                                        <option value="3">Three</option>
                                                        <option value="4">Four</option>
                                                        <option value="5">Five</option>
                                                        <option value="6">Six</option>
                                                    </select>
                                                    <span class="text-danger"><?php echo form_error('fee_case'); ?></span>
                                                </div>
                                                <div id="dynamicDateInputs_in">

                                                </div>

                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line('cancel'); ?></button>
                                            <input type="hidden" id="stdId" value="<?=$student['id']?>">
                                            <button type="button" class="btn btn-primary" id="addInstallmentBtn" onclick="addInstallmentIndvidual()" >Add</button>
                                        </div>
                                    </div>

                                </div>
                            </div>

                        </div>
                        <div class="table-responsive">
                            <div class="download_label"><?php echo $this->lang->line('student_fees') . ": " . $student['firstname'] . " " . $student['lastname'] ?> </div>
                            <table class="table table-striped table-bordered table-hover example table-fixed-header">
                                <thead class="header">
                                <tr>
                                    <th style="width: 10px"><input type="checkbox" id="select_all"/></th>
                                    <th align="left"><?php echo $this->lang->line('fees_type'); ?></th>
                                    <th align="left">Billing Period</th>
                                    <th align="left" class="text text-left"><?php echo $this->lang->line('due_date'); ?></th>
                                    <th align="left" class="text text-left"><?php echo $this->lang->line('status'); ?></th>
                                    <th class="text text-right"><?php echo $this->lang->line('amount') ?> <span><?php echo "(" . $currency_symbol . ")"; ?></span></th>
                                    <th class="text text-left"><?php echo $this->lang->line('payment_id'); ?></th>
                                    <th class="text text-left"><?php echo $this->lang->line('mode'); ?></th>
                                    <th  class="text text-left"><?php echo $this->lang->line('date'); ?></th>
                                    <th class="text text-right" ><?php echo $this->lang->line('discount'); ?> <span><?php echo "(" . $currency_symbol . ")"; ?></span></th>
                                    <th class="text text-right"><?php echo $this->lang->line('fine'); ?> <span><?php echo "(" . $currency_symbol . ")"; ?></span></th>
                                    <th class="text text-right"><?php echo $this->lang->line('paid'); ?> <span><?php echo "(" . $currency_symbol . ")"; ?></span></th>
                                    <th class="text text-right">Extra Amount<span><?php echo "(" . $currency_symbol . ")"; ?></span></th>
                                    <th class="text text-right"><?php echo $this->lang->line('balance'); ?> <span><?php echo "(" . $currency_symbol . ")"; ?></span></th>
                                    <th class="text text-right"><?php echo $this->lang->line('action'); ?></th>

                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $roles = $this->customlib->getStaffRole();
                                $logged_user_role = json_decode($roles)->name;


                                if(isset($student_fee))
                                {
                                    $grandTotal=0;
                                    $grandPaid=0;
                                    $grandPayableBalance=0;
                                    $grandDiscBalance=0;
                                    $grandFineBalance=0;
                                    $grandExtra=0;
 //                                    echo "<pre>";
//                                var_dump($student_fee);
//                                die();
                                    foreach ($student_fee as $value)
                                    {


                                        $rem_balance=0;
                                        $paid_balance=0;
                                        $payable_balance=0;
                                        $decodedFeeDetails=json_decode($value['fee_type'] );

//                                        $grandExtra= $value['std_total_arrears'];
                                        $feeDiscounts=$this->Shared_model->selectDataWhereSingle("tbl_fee_discounts",array('fee_detail_id'=>$value['fee_detail_id']));
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
                                        $grandPayableBalance=$grandPayableBalance+$payable_balance-$value['fine'];
                                        $totalAppliedDiscounts=0;
                                        $decodedFeediscounts=json_decode($value['applied_discounts']);
                                        foreach ($decodedFeediscounts as $decodedFeediscount)if(!empty($decodedFeediscount))
                                        {
                                            $totalAppliedDiscounts+=$decodedFeediscount;
                                        }

                                        $grandDiscBalance=$grandDiscBalance+$value['total_discount'];
                                        $grandFineBalance=$grandFineBalance+$value['fine'];

                                        $discountedFeeAmount=0;
                                        $totalAmount= $value['total_amount'];
                                        if(!empty($feeDiscounts))
                                        {
                                            $discountRates=json_decode($feeDiscounts->discount_rate);
                                            foreach ($discountRates as $discountRateValue)
                                            {
                                                 $CheckfeeType=$this->Shared_model->selectDataWhereSingle("tbl_feetype",array('id'=>$discountRateValue->fee_type));
                                                if($CheckfeeType->fee_type!="tuition")
                                                {
                                                    $discountedFeeAmount+=$discountRateValue->balance;
//                                                    if($discountRate->discount_type=="sibling")
//                                                    {
//
//                                                    }elseif($discountRate->discount_type=="custom")
//                                                    {
//
//                                                    }
                                                }

                                            }
                                            $totalAmount=$discountedFeeAmount;

                                        }
//                                        $grandTotal=$grandTotal+$totalAmount+$value['arrears'];
                                        $grandTotal=$grandTotal+$totalAmount;

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
                                         <td>
                                             <input class="checkbox checkedFeeIds" type="checkbox" name="fee_checkbox[]"  value="<?=$value['fee_detail_id']?>">
                                         </td>
                                        <td align="left">
                                            <?php
                                            foreach ($decodedFeeDetails as $feeDetail)
                                            {
                                                $feeType=$this->Shared_model->selectDataWhereSingle("tbl_feetype",array('id'=>$feeDetail->feeTypeID));
                                                echo $feeType->type." (".$feeDetail->fee_amount.")<br>";

                                            }
                                            if($value['arrears']!=0)
                                            {
                                                echo "Previous Balance"."(".$value['arrears'].")";
                                            }
                                            ?>

                                        </td>
                                        <td align="left" class="text text-left">
                                            <?=$value['fee_month']?>
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
<!--                                            --><?//=$totalAmount+$value['arrears']?>
                                            <?=$totalAmount?>
                                         </td>
                                        <td class="text text-left"></td>
                                        <td class="text text-left"></td>
                                        <td class="text text-left"></td>
                                        <td class="text text-right"><?php
                                            echo (number_format($value['total_discount'], 2, '.', ''));
                                            ?></td>
                                        <td class="text text-right"><?php
                                            echo (number_format($value['fine'], 2, '.', ''));
                                            ?></td>
                                        <td class="text text-right"><?php

                                            echo (number_format($paid_balance, 2, '.', ''));
                                            ?></td>
                                        <td class="text text-right"><?php

                                            echo (number_format(0, 2, '.', ''));
                                            ?></td>
                                        <td class="text text-right"><?php
                                            $display_none = "ss-none";

                                            if ($payable_balance >= 0) {
                                                $display_none = "";

//                                                echo (number_format($payable_balance+$value['fine'], 2, '.', ''));
                                                echo (number_format($payable_balance, 2, '.', ''));
                                            }else{
                                                $display_none = "";
                                                echo (number_format(0, 2, '.', ''));

                                            }
//                                            if(!empty($feeInstallment))
//                                            {
//                                                $display_none = "ss-none";
//                                            }
                                            ?>
                                        </td>
                                          <td>
                                              <div class="btn-group pull-right" style="width: 40px;">
                                              <?php
                                              if($payable_balance>0)
                                              {
                                                  ?>
                                                  <button type="button" class="btn btn-xs btn-default myCollectFeeBtn <?php echo $display_none; ?>"
                                                          data-type="<?php echo $feeType->type; ?>"
                                                          data-amount="<?php echo $payable_balance; ?>"
                                                          data-fee_detail_id="<?php echo $value['fee_detail_id']; ?>"
                                                          title="<?php echo $this->lang->line('add_fees'); ?>" data-toggle="modal" data-target="#myFeesModal">
                                                      <i class="fa fa-plus"></i></button>
                                                  <?php
                                              }else
                                              {
                                                  ?>
                                                  <?php
                                              }
                                              ?>
                                              <button  class="btn btn-xs btn-default printInv"
                                                       data-fee_detail_id="<?php echo $value['fee_detail_id']; ?>"
                                                       title="<?php echo $this->lang->line('print'); ?>">
                                                  <i class="fa fa-print"></i> </button>

                                              <?php
                                              if($paid_balance==0)
                                              {

                                                  ?>
                                                  <?php if ($logged_user_role == 'Super Admin') { ?>
                                                  <button class="btn btn-xs btn-default deleteAssignedFee"
                                                          data-fee_detail_id="<?php echo $value['fee_detail_id']; ?>"
                                                          title="<?php echo $this->lang->line('delete'); ?>">
                                                      <i class="fa fa-minus"></i></button>

                                                  <?php
                                              }
                                              }
                                              ?>
                                              </div>
                                          </td>
                                        </tr>

                                <?php
                                        if(!empty($feeDepositDetails))
                                        {
                                            foreach ($feeDepositDetails as $feeDepositDetail)
                                            {
                                                $grandExtra+=$feeDepositDetail->extra_amount;
                                                ?>
                                                <tr class="white-td">
                                                    <td align="left"></td>
                                                    <td align="left"></td>
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
                                                    <td class="text text-left">
                                                        <?php
                                                        if($feeDepositDetail->mode=="DD")
                                                        {
                                                            echo "HBL";

                                                        }elseif($feeDepositDetail->mode=="Cheque")
                                                        {
                                                            echo "SONERI";
                                                        }else
                                                        {
                                                            echo "Cash";
                                                        }
                                                        ?>


                                                    <td class="text text-left">
                                                        <?php echo $feeDepositDetail->date; ?>
                                                    </td>
                                                    <td class="text text-right"><?php echo (number_format(0, 2, '.', '')); ?></td>
                                                    <td class="text text-right"><?php echo (number_format($feeDepositDetail->fine, 2, '.', '')); ?></td>
                                                    <td class="text text-right"><?php echo (number_format($feeDepositDetail->paid_amount, 2, '.', '')); ?></td>
                                                    <td class="text text-right"><?php echo (number_format($feeDepositDetail->extra_amount, 2, '.', '')); ?></td>
                                                    <td align="left"></td>
                                                    <td class="text text-right">
                                                        <div class="btn-group pull-right" style="width: 41px;">

                                                            <?php if ($this->rbac->hasPrivilege('collect_fees', 'can_delete')) { ?>
                                                                <button class="btn btn-default btn-xs" data-invoiceno="<?php echo $feeDepositDetail->std_deposit_id . "/" . $feeDepositDetail->std_fee_detail_id; ?>" data-std_deposit_id="<?=$feeDepositDetail->std_deposit_id?>"  data-toggle="modal" data-target="#confirm-delete" title="<?php echo $this->lang->line('revert'); ?>">
                                                                    <i class="fa fa-undo"> </i>
                                                                </button>
                                                            <?php } ?>
                                                            <button  class="btn btn-xs btn-default printDoc" data-invoiceno="<?php echo $feeDepositDetail->std_deposit_id . "/" . $feeDepositDetail->std_fee_detail_id; ?>"  title="<?php echo $this->lang->line('print'); ?>"><i class="fa fa-print"></i> </button>
                                                        </div>
                                                    </td>
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
                                                <td class="text-right"> <img src="<?php echo base_url(); ?>backend/images/table-arrow.png" alt="" /></td>
                                                <td align="left" style="display: flex;">
                                                    <input class="checkbox checkedInstallmentIds" type="checkbox" name="installment_checkbox[]"  value="<?=$detail->installment_detail_id?>">
                                                    Installment # <?=$installmentIndex?></td>
                                                <td align="left">

                                                </td>
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
                                                <td class="text text-right"><?php echo (number_format(0, 2, '.', '')); ?></td>
                                                <td class="text text-right"><?php echo (number_format($installmentPayable_baln, 2, '.', '')); ?></td>
                                                <td class="text text-left"> </td>
                                                <td class="text text-right">
                                                    <?php
                                                    $display_none = "ss-none";
                                                    if($installmentPayable_baln>0)
                                                    {
                                                        $display_none="";
                                                    }
                                                    ?>
                                                    <button type="button" class="btn btn-xs btn-default   installmentCollectbtn <?=$display_none?> "
                                                            data-type="<?php echo 'Installment #'. $installmentIndex ?>"
                                                            data-amount="<?php echo $installmentPayable_baln; ?>"
                                                            data-installment_detail_id="<?php echo $detail->installment_detail_id; ?>"
                                                            data-fee_detail_id="<?php echo $feeInstallment->fee_detail_id; ?>"
                                                            title="<?php echo $this->lang->line('add_fees'); ?>" data-toggle="modal" data-target="#myInsatllmentCollectModel">
                                                        <i class="fa fa-plus"></i></button>
<!--                                                    <button  class="btn btn-xs btn-default printDoc"   title="--><?php //echo $this->lang->line('print'); ?><!--"><i class="fa fa-print"></i> </button>-->

                                                </td>
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
                                                            <?php echo $installmentDepositDetail->date?>
                                                        </td>
                                                        <td class="text text-right"><?php echo (number_format(0, 2, '.', '')); ?></td>
                                                        <td class="text text-right"><?php echo (number_format(0, 2, '.', '')); ?></td>
                                                        <td class="text text-right"><?php echo (number_format($installmentDepositDetail->paid_amount, 2, '.', '')); ?></td>
                                                        <td align="left"></td>
                                                        <td align="left"></td>
                                                        <td class="text text-right">
                                                            <div class="btn-group pull-right" style="width: 41px;">

                                                                <?php if ($this->rbac->hasPrivilege('collect_fees', 'can_delete')) { ?>
                                                                    <button class="btn btn-default btn-xs" data-invoiceno="<?php echo $installmentDepositDetail->std_deposit_id . "/" . $installmentDepositDetail->std_fee_detail_id; ?>" data-std_deposit_id="<?=$installmentDepositDetail->std_deposit_id?>"  data-toggle="modal" data-target="#installment_confirm-delete" title="<?php echo $this->lang->line('revert'); ?>">
                                                                        <i class="fa fa-undo"> </i>
                                                                    </button>
                                                                <?php } ?>
                                                                <button  class="btn btn-xs btn-default printDoc" data-invoiceno="<?php echo $installmentDepositDetail->std_deposit_id . "/" . $installmentDepositDetail->std_fee_detail_id; ?>"  title="<?php echo $this->lang->line('print'); ?>"><i class="fa fa-print"></i> </button>
                                                            </div>
                                                        </td>
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
                                        <td align="left" ></td>
                                        <td align="left" ></td>

                                        <td align="left" class="text text-left" ><?php echo $this->lang->line('grand_total'); ?></td>
                                        <td class="text text-right"><?php
                                            echo ($currency_symbol . number_format($grandTotal, 2, '.', ','));
                                            ?></td>
                                        <td class="text text-left"></td>
                                        <td class="text text-left"></td>
                                        <td class="text text-left"></td>

                                        <td class="text text-right"><?php
                                            echo ($currency_symbol . number_format($grandDiscBalance, 2, '.', ''));
                                            ?></td>
                                        <td class="text text-right"><?php
                                            echo ($currency_symbol . number_format($grandFineBalance, 2, '.', ''));
                                            ?></td>
                                        <td class="text text-right"><?php
                                            echo ($currency_symbol . number_format($grandPaid, 2, '.', ''));
                                            ?></td>
                                        <td class="text text-right"><?php
                                            echo ($currency_symbol . number_format($grandExtra, 2, '.', ''));
                                            ?></td>

                                        <td class="text text-right"><?php
                                            echo ($currency_symbol . number_format($grandPayableBalance, 2, '.', ''));
                                            ?></td>
                                        <td class="text text-right"></td>
                                        <td align="left" ></td>
                                    </tr>
                                    <?php
                                }
                                ?>
                                </tbody>

                            </table>
                        </div>
                    </div>
                    <!-- /.box-body -->
                </div>


            </div>
            <!--/.col (left) -->

        </div>

    </section>

</div>
<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Voucher dates</h4>
            </div>
            <div class="modal-body">
                <div class="col-md-12 voucherDates">

                    <div class="form-group">
                        <label for="exampleInputFile">Issue date</label><small class="req"> *</small>
                        <input type="date" id="issueDateModal" class="form-control" name="issueDate">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputFile">Due date</label><small class="req"> *</small>
                        <input type="date" id="dueDateModal" class="form-control" name="dueDate">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputFile">Stuck Off date</label><small class="req"> *</small>
                        <input type="date" id="stuckoffDateModal" class="form-control" name="stuckoffDate">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputFile">Billing Period</label><small class="req"> *</small>
                        <input type="text" id="billiongPeriodModal" class="form-control" name="billiongPeriodModal">
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="genrateVoucherbtn" data-dismiss="modal">Generate</button>
            </div>
        </div>

    </div>
</div>


<div class="modal fade" id="myFeesModal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title title text-center fees_title"></h4>
            </div>
            <div class="modal-body pb0">
                <div class="form-horizontal balanceformpopup">
                    <div class="box-body">
                        <span class="text-danger" id="error_error"></span>
                        <input  type="hidden" class="form-control" id="parent_app_key" value="<?php echo $student['parent_app_key'] ?>" readonly="readonly"/>
                        <input  type="hidden" class="form-control" id="guardian_phone" value="<?php echo $student['guardian_phone'] ?>" readonly="readonly"/>
                        <input  type="hidden" class="form-control" id="guardian_email" value="<?php echo $student['guardian_email'] ?>" readonly="readonly"/>
                        <input  type="hidden" class="form-control" id="fee_detail_id" value="0" readonly="readonly"/>
                        <input  type="hidden" class="form-control" id="fee_groups_feetype_id" value="0" readonly="readonly"/>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-3 control-label"><?php echo $this->lang->line('date'); ?></label>
                            <div class="col-sm-9">
                                <input  id="collection_date" name="admission_date" placeholder="" type="text" class="form-control date"  value="<?php echo date($this->customlib->getSchoolDateFormat()); ?>" readonly="readonly"/>
                            </div>
                        </div>
                        <div class="form-group" style="display: none;">
                            <label for="inputPassword3" class="col-sm-3 control-label"><?php echo $this->lang->line('amount'); ?><small class="req"> *</small></label>
                            <div class="col-sm-9">

                                <input type="text" autofocus="" class="form-control modal_amount" id="amount" value="0"  >

                                <span class="text-danger" id="amount_error"></span>
                            </div>
                        </div>
                        <div id="dynamicFees">

                        </div>
                        <div class="form-group">
                            <label for="inputPassword3" class="col-sm-3 control-label">Extra <?php echo $this->lang->line('amount'); ?><small class="req"> *</small></label>
                            <div class="col-sm-9">

                                <input type="number" min="0" required autofocus="" class="form-control  " id="extra_amount" value="0"  >

                                <span class="text-danger" id="extra_amount_error"></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="inputPassword3" class="col-sm-3 control-label"><?php echo $this->lang->line('fine'); ?><small class="req"> *</small></label>

                             <div class="col-sm-9">

                                <input type="text"  class="form-control modal_amount" id="amount_fine" value="0">

                                <span class="text-danger" id="amount_fine_error"></span>
                            </div>
                        </div>
<!--                        <div class="form-group">-->
<!--                            <label for="inputPassword3" class="col-sm-3 control-label"> --><?php //echo $this->lang->line('discount'); ?><!-- --><?php //echo $this->lang->line('group'); ?><!--</label>-->
<!--                            <div class="col-sm-9">-->
<!--                                <select class="form-control modal_discount_group" id="discount_group">-->
<!--                                    <option value="">--><?php //echo $this->lang->line('select'); ?><!--</option>-->
<!--                                </select>-->
<!---->
<!--                                <span class="text-danger" id="amount_error"></span>-->
<!--                            </div>-->
<!--                        </div>-->


<!--                        <div class="form-group">-->
<!--                            <label for="inputPassword3" class="col-sm-3 control-label">--><?php //echo $this->lang->line('discount'); ?><!--<small class="req"> *</small></label>-->
<!--                            <div class="col-sm-9">-->
<!--                                <div class="row">-->
<!--                                    <div class="col-md-5 col-sm-5">-->
<!--                                        <div class="">-->
<!--                                            <input type="text" class="form-control" id="amount_discount" value="0">-->
<!---->
<!--                                            <span class="text-danger" id="amount_error"></span></div>-->
<!--                                    </div>-->
<!--                                    <div class="col-md-2 col-sm-2 ltextright">-->
<!---->
<!--                                        <label for="inputPassword3" class="control-label">--><?php //echo $this->lang->line('fine'); ?><!--<small class="req">*</small></label>-->
<!--                                    </div>-->
<!--                                    <div class="col-md-5 col-sm-5">-->
<!--                                        <div class="">-->
<!--                                            <input type="text" class="form-control" id="amount_fine" value="0">-->
<!---->
<!--                                            <span class="text-danger" id="amount_fine_error"></span>-->
<!--                                        </div>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                            </div><!--./col-sm-9-->
<!--                        </div>-->




                        <div class="form-group">
                            <label for="inputPassword3" class="col-sm-3 control-label"><?php echo $this->lang->line('payment'); ?> <?php echo $this->lang->line('mode'); ?></label>
                            <div class="col-sm-9">
                                <label class="radio-inline">
                                    <input type="radio" name="payment_mode_fee" value="Cash" checked="checked"><?php echo $this->lang->line('cash'); ?>
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="payment_mode_fee" value="Cheque">Soneri
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="payment_mode_fee" value="DD">HBL
                                </label>
                                <span class="text-danger" id="payment_mode_error"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputPassword3" class="col-sm-3 control-label"><?php echo $this->lang->line('note'); ?></label>

                            <div class="col-sm-9">
                                <textarea class="form-control" rows="3" id="description" placeholder=""></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">

                <button type="button" class="btn btn-default pull-left" data-dismiss="modal"><?php echo $this->lang->line('cancel'); ?></button>
                <button type="button" class="btn cfees save_button" id="load" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Processing"> <?php echo $currency_symbol; ?> <?php echo $this->lang->line('collect_fees'); ?> </button>

            </div>
        </div>

    </div>
</div>
<div class="modal fade" id="myInsatllmentCollectModel" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title title text-center installment_fees_title"></h4>
            </div>
            <div class="modal-body pb0">
                <div class="form-horizontal balanceformpopup">
                    <div class="box-body">
                        <span class="text-danger" id="error_error"></span>
                        <input  type="hidden" class="form-control" id="parent_app_key" value="<?php echo $student['parent_app_key'] ?>" readonly="readonly"/>
                        <input  type="hidden" class="form-control" id="guardian_phone" value="<?php echo $student['guardian_phone'] ?>" readonly="readonly"/>
                        <input  type="hidden" class="form-control" id="guardian_email" value="<?php echo $student['guardian_email'] ?>" readonly="readonly"/>
                        <input  type="hidden" class="form-control" id="installment_detail_id" value="0" readonly="readonly"/>
                        <input  type="hidden" class="form-control" id="inatllment_fee_detail_id" value="0" readonly="readonly"/>
                          <div class="form-group">
                            <label for="inputPassword3" class="col-sm-3 control-label"><?php echo $this->lang->line('amount'); ?><small class="req"> *</small></label>
                            <div class="col-sm-9">

                                <input type="text" autofocus="" class="form-control modal_amount" id="installment_amount" value="0"  >

                                <span class="text-danger" id="installment_amount_error"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-3 control-label"><?php echo $this->lang->line('date'); ?></label>
                            <div class="col-sm-9">
                                <input  id="instalment_collection_date" name="admission_date" placeholder="" type="text" class="form-control date"  value="<?php echo date($this->customlib->getSchoolDateFormat()); ?>" readonly="readonly"/>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="inputPassword3" class="col-sm-3 control-label"><?php echo $this->lang->line('payment'); ?> <?php echo $this->lang->line('mode'); ?></label>
                            <div class="col-sm-9">
                                <label class="radio-inline">
                                    <input type="radio" name="insatllment_payment_mode_fee" value="Cash" checked="checked"><?php echo $this->lang->line('cash'); ?>
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="insatllment_payment_mode_fee" value="Cheque">Soneri
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="insatllment_payment_mode_fee" value="DD">HBL
                                </label>
                                <span class="text-danger" id="insatllment_payment_mode_error"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputPassword3" class="col-sm-3 control-label"><?php echo $this->lang->line('note'); ?></label>

                            <div class="col-sm-9">
                                <textarea class="form-control" rows="3" id="installment_description" placeholder=""></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">

                <button type="button" class="btn btn-default pull-left" data-dismiss="modal"><?php echo $this->lang->line('cancel'); ?></button>
                <button type="button" class="btn cfees installment_saveBtn" id="load" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Processing"> <?php echo $currency_symbol; ?> <?php echo $this->lang->line('collect_fees'); ?> </button>

            </div>
        </div>

    </div>
</div>


<!-- Modal -->

<div class="modal fade" id="myDisApplyModal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title title text-center discount_title"></h4>
            </div>
            <div class="modal-body pb0">
                <div class="form-horizontal">
                    <div class="box-body">
                        <input  type="hidden" class="form-control" id="student_fees_discount_id"  value=""/>
                        <div class="form-group">
                            <label for="inputPassword3" class="col-sm-3 control-label"><?php echo $this->lang->line('payment_id'); ?> </label><small class="req">*</small>
                            <div class="col-sm-9">

                                <input type="text" class="form-control" id="discount_payment_id" >

                                <span class="text-danger" id="discount_payment_id_error"></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="inputPassword3" class="col-sm-3 control-label"><?php echo $this->lang->line('description'); ?></label>

                            <div class="col-sm-9">
                                <textarea class="form-control" rows="3" id="dis_description" placeholder=""></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="box-body">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal"><?php echo $this->lang->line('cancel'); ?></button>
                    <button type="button" class="btn cfees dis_apply_button" id="load" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Processing"> <?php echo $this->lang->line('apply_discount'); ?></button>
                </div>
            </div>
        </div>

    </div>
</div>


<div class="delmodal modal fade" id="confirm-discountdelete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel"><?php echo $this->lang->line('confirmation'); ?></h4>
            </div>

            <div class="modal-body">

                <p>Are you sure want to revert <b class="discount_title"></b> discount, this action is irreversible.</p>
                <p>Do you want to proceed?</p>
                <p class="debug-url"></p>
                <input type="hidden" name="discount_id"  id="discount_id" value="">

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line('cancel'); ?></button>
                <a class="btn btn-danger btn-discountdel"><?php echo $this->lang->line('revert'); ?></a>
            </div>
        </div>
    </div>
</div>


<div class="delmodal modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel"><?php echo $this->lang->line('confirmation'); ?></h4>
            </div>

            <div class="modal-body">

                <p>Are you sure want to delete <b class="invoice_no"></b> invoice, this action is irreversible.</p>
                <p>Do you want to proceed?</p>
                <p class="debug-url"></p>
                <input type="hidden" name="main_invoice"  id="main_invoice" value="">
                <input type="hidden" name="std_deposit_id" id="std_deposit_id"  value="">
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line('cancel'); ?></button>
                <a class="btn btn-danger btn-ok"><?php echo $this->lang->line('revert'); ?></a>
            </div>
        </div>
    </div>
</div>
<div class="delmodal modal fade" id="installment_confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel"><?php echo $this->lang->line('confirmation'); ?></h4>
            </div>

            <div class="modal-body">

                <p>Are you sure want to delete <b class="invoice_no"></b> invoice, this action is irreversible.</p>
                <p>Do you want to proceed?</p>
                <p class="debug-url"></p>
                <input type="hidden" name="main_invoice"  id="main_invoice" value="">
                <input type="hidden" name="std_deposit_id" id="installment_std_deposit_id"  value="">
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line('cancel'); ?></button>
                <a class="btn btn-danger installment_btn-ok"><?php echo $this->lang->line('revert'); ?></a>
            </div>
        </div>
    </div>
</div>


<div class="norecord modal fade" id="confirm-norecord" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-body">


                <p>No Record Found --r</p>

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line('cancel'); ?></button>

            </div>
        </div>
    </div>
</div>

<div class="norecord modal fade" id="myInstallmentModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Add Installments</h4>
            </div>
            <form  action="<?=base_url('studentfee/')?>" method="post" id="installmentForm">
            <div class="modal-body">
                <div class="col-md-12">
<!--                    <div class="form-group">-->
<!--                        <label for="exampleInputFile">Select fee</label><small class="req"> *</small>-->
<!--                        <select class="form-control" name="fee_installments_select" id="fee_installments_select" onchange="generateDateInputs()">-->
<!--                        </select>-->
<!--                        <span class="text-danger">--><?php //echo form_error('fee_case'); ?><!--</span>-->
<!--                    </div>-->

                    <div class="form-group">
                        <label for="exampleInputFile">Number of Installments</label><small class="req"> *</small>
                        <select class="form-control" name="num_installments" id="num_installments_all" onchange="generateDateInputs('_all')">
                            <option value=""><?php echo $this->lang->line('select'); ?></option>
                            <option value="2">Two</option>
                            <option value="3">Three</option>
                            <option value="4">Four</option>
                            <option value="5">Five</option>
                            <option value="6">Six</option>
                         </select>
                        <span class="text-danger"><?php echo form_error('fee_case'); ?></span>
                    </div>
                    <div id="dynamicDateInputs_all">

                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line('cancel'); ?></button>
                <input type="hidden" id="stdId" value="<?=$student['id']?>">
                <button type="button" class="btn btn-primary" id="addInstallmentBtn" onclick="addInstallment()" >Add</button>
            </div>
        </form
        </div>
    </div>
</div>


<div id="individualInstallment1" class="modal fade">

<!--<div class="norecord1 modal fade" id="individualInstallment"   role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">-->
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Add Installments</h4>
            </div>
            <form  action="<?=base_url('studentfee/')?>" method="post" id="installmentForm">
            <div class="modal-body">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="exampleInputFile">Select fee</label><small class="req"> *</small>
                        <select class="form-control" name="fee_installments_select" id="fee_installments_select" onchange="generateDateInputs()">
                        </select>
                        <span class="text-danger"><?php echo form_error('fee_case'); ?></span>
                    </div>

                    <div class="form-group">
                        <label for="exampleInputFile">Number of Installments</label><small class="req"> *</small>
                        <select class="form-control" name="num_installments" id="num_installments" onchange="generateDateInputs()">
                            <option value=""><?php echo $this->lang->line('select'); ?></option>
                            <option value="2">Two</option>
                            <option value="3">Three</option>
                            <option value="4">Four</option>
                            <option value="5">Five</option>
                            <option value="6">Six</option>
                         </select>
                        <span class="text-danger"><?php echo form_error('fee_case'); ?></span>
                    </div>
                    <div id="dynamicDateInputs">

                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line('cancel'); ?></button>
                <input type="hidden" id="stdId" value="<?=$student['id']?>">
                <button type="button" class="btn btn-primary" id="addInstallmentBtn" onclick="addInstallmentIndvidual_()" >Add</button>
            </div>
        </form
        </div>
    </div>
</div>



<!--<div id="listCollectionModal" class="modal fade">-->
<div id="listCollectionModal" class="modal fade">
    <div class="modal-dialog">
        <form action="<?php echo site_url('studentfee/addfeegrp'); ?>" method="POST" id="collect_fee_group">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title"><?php echo $this->lang->line('collect')." ".$this->lang->line('fees');?></h4>
                </div>
                <div class="modal-body">

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary payment_collect" data-loading-text="<i class='fa fa-spinner fa-spin '></i> Processing"><i class="fa fa-money"></i> <?php echo $this->lang->line('pay');?></button>
                </div>
            </div>
        </form>
    </div>
</div>




<script type="text/javascript">

    function setInstallmentModal() {
        var count=0;
        var fee_id="";
        $.each($(".checkedFeeIds:checked"), function () {
              fee_id=$(this).val();
            count++;
         });

        if(count==1)
        {

            $.ajax({
                url: '<?php echo site_url("studentfee/getFeeTypes") ?>',
                type: 'post',
                data: {
                    'fee_id': fee_id

                },
                dataType:'JSON',
                success: function (response) {


                        $("#fee_installments_select").html("").html(response.html);

                }
            });


            $("#myModal1").modal('show');

        }else
        {
            alert("Please select only one fee for installment");
        }

    }

    $(document).ready(function () {
        //select all checkboxes
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


        $(document).on('click', '.printDoc', function () {
            var main_invoice = $(this).data('main_invoice');
            var sub_invoice = $(this).data('sub_invoice');
            var student_session_id = '<?php echo $student['student_session_id'] ?>';
            $.ajax({
                url: '<?php echo site_url("studentfee/printFeesByName") ?>',
                type: 'post',
                data: {'student_session_id': student_session_id, 'main_invoice': main_invoice, 'sub_invoice': sub_invoice},
                success: function (response) {
                    Popup(response);
                }
            });
        });
        $(document).on('click', '.printInv', function () {
            var feeDetailArray = [];
            var fee_detail_id = $(this).data('fee_detail_id');
            feeDetailArray.push(fee_detail_id);
            var stdId = $('#stdId').val();
            $.ajax({
                url: '<?php echo site_url("studentfee/printSelectedFee") ?>',
                type: 'post',
                data: {
                    feeDetailArray  :  feeDetailArray,
                    stdId  :  stdId,
                },
                success: function (response) {
                    Popup(response);
                }
            });
        });
        $(document).on('click', '.deleteAssignedFee', function () {

            var fee_detail_id = $(this).data('fee_detail_id');

            var stdId = $('#stdId').val();
            $.ajax({
                url: '<?php echo site_url("studentfee/deleteAssignedFee") ?>',
                type: 'post',
                dataType: 'json',
                data: {
                    fee_detail_id  :  fee_detail_id,
                    stdId  :  stdId
                },
                success: function (response) {
                    if(response.status)
                    {
                        successMsg("Assigned fee removed successfully");

                    }else
                    {
                        errorMsg("Something went wrong Please try again.");
                    }
                    setTimeout(function () {
                        location.reload();
                     }, 1000);

                }
            });
        });
    });
</script>


<script type="text/javascript">
    $(document).on('click', '.save_button', function (e) {
        var $this = $(this);
//        $this.button('loading');
//        var form = $(this).attr('frm');
//        var feetype = $('#feetype_').val();
        var date = $('#collection_date').val();
        var amount = $('#amount').val();

        var enteredFeeAmountObj={};



        $( ".collect_fee_modal_amount" ).each(function( index ) {
            var feeTypeId=$(this).attr("feeTypeId");
            var enteredFeeAmount=$("#entered_amount_"+feeTypeId).val();
            enteredFeeAmountObj[feeTypeId]=enteredFeeAmount;
        });

        var extra_amount = $('#extra_amount').val();
        var amount_fine = $('#amount_fine').val();
        var description = $('#description').val();
         if($('#entered_amount_p_arrears').length)
        {
            var p_arrears = $('#entered_amount_p_arrears').val();
        }else
        {
            var p_arrears = 0;
        }
//        var parent_app_key = $('#parent_app_key').val();
//        var guardian_phone = $('#guardian_phone').val();
//        var guardian_email = $('#guardian_email').val();
//        var student_fees_master_id = $('#student_fees_master_id').val();
//        var fee_groups_feetype_id = $('#fee_groups_feetype_id').val();
        var fee_detail_id = $('#fee_detail_id').val();
        var payment_mode = $('input[name="payment_mode_fee"]:checked').val();
//        var student_fees_discount_id = $('#discount_group').val();
        $.ajax({
            url: '<?php echo site_url("studentfee/addstudentdepositfee") ?>',
            type: 'post',
//            data: {date: date, type: feetype, amount: amount, amount_discount: amount_discount, amount_fine: amount_fine, description: description, student_fees_master_id: student_fees_master_id, fee_groups_feetype_id: fee_groups_feetype_id, payment_mode: payment_mode, guardian_phone: guardian_phone, guardian_email: guardian_email, student_fees_discount_id: student_fees_discount_id,parent_app_key:parent_app_key},
            data:{
                amount:amount,
                description:description,
                payment_mode:payment_mode,
                fee_detail_id:fee_detail_id,
                date:date,
                amount_fine:amount_fine,
                extra_amount:extra_amount,
                p_arrears:p_arrears,
                enteredFeeAmountObj:enteredFeeAmountObj,

            },
            dataType: 'json',
            success: function (response) {
                // console.log(response);
                $this.button('reset');
                if (response.status === "success") {
                    location.reload(true);
                } else if (response.status === "fail") {
                    $.each(response.error, function (index, value) {
                        var errorDiv = '#' + index + '_error';
                        $(errorDiv).empty().append(value);
                    });
                }
            }
        });

    });

    $(document).on('click', '.installment_saveBtn', function (e) {
        var $this = $(this);
        $this.button('loading');
         var date = $('#instalment_collection_date').val();
         var amount = $('#installment_amount').val();
         var description = $('#installment_description').val();
         var installment_detail_id = $('#installment_detail_id').val();
         var fee_detail_id = $('#inatllment_fee_detail_id').val();
        var payment_mode = $('input[name="insatllment_payment_mode_fee"]:checked').val();
         $.ajax({
            url: '<?php echo site_url("studentfee/installmentDeposit") ?>',
            type: 'post',
             data:{
                 date:date,
                amount:amount,
                description:description,
                payment_mode:payment_mode,
                 fee_detail_id:fee_detail_id,
                installment_detail_id:installment_detail_id,

            },
            dataType: 'json',
            success: function (response) {
                // console.log(response);
                $this.button('reset');
                if (response.status === "success") {
                    location.reload(true);
                } else if (response.status === "fail") {
                    $.each(response.error, function (index, value) {
                        var errorDiv = '#' + index + '_error';
                        $(errorDiv).empty().append(value);
                    });
                }
            }
        });
    });
</script>


<script>
    function addInstallmentIndvidual() {
        var stdId = $('#stdId').val();
        var num_installments = $('#num_installments_in').val();
        var fee_installments_select = $('#fee_installments_select').val();
        var feeDetailIds=[];
//        var formData=  $('#installmentForm').serialize();
        $.each($(".checkedFeeIds:checked"), function(){
            var index =  ($(this).val());
            feeDetailIds.push(index);
        });
        if(feeDetailIds.length === 0)
        {
            alert("Please select fee and try again");
        }else {

               var i;
               var formData={};
               for(i=1;i<=num_installments;i++)
               {

                   formData['stuckoff_date_'+i]=$('#stuckoff_date_'+i).val();
                   formData['due_date'+i]=$('#due_date_'+i).val();
               }

            $.ajax({
                type: "post",
//                url: '<?php //echo site_url("studentfee/addInstallments") ?>//',
                url: '<?php echo site_url("studentfee/IndividualaddInstallments") ?>',
                dataType: 'JSON',
                data: {
                    stdId: stdId,
                    num_installments:num_installments,
                    formData:formData,
                    fee_installments_select:fee_installments_select,
                    feeDetailIds:feeDetailIds
                },
                beforeSend: function () {
                },
                success: function (data) {

                    if (data.status === "success") {
                        window.location.reload();
                    }
                },
                error: function (xhr) { // if error occured
                    alert("Error occured.please try again");

                },
                complete: function () {
                }
            });
        }

    }


    function addInstallment() {
        var stdId = $('#stdId').val();
        var num_installments = $('#num_installments_all').val();
//        var fee_installments_select = $('#fee_installments_select').val();
        var feeDetailIds=[];
//        var formData=  $('#installmentForm').serialize();
        $.each($(".checkedFeeIds:checked"), function(){
            var index =  ($(this).val());
            feeDetailIds.push(index);
        });
        if(feeDetailIds.length === 0)
        {
            alert("Please select fee and try again");
        }else {

            var i;
            var formData={};
            for(i=1;i<=num_installments;i++)
            {

                formData['stuckoff_date_'+i]=$('#stuckoff_date_'+i).val();
                formData['due_date'+i]=$('#due_date_'+i).val();
            }

            $.ajax({
                type: "post",
                url: '<?php echo site_url("studentfee/addInstallments") ?>',
//                url: '<?php //echo site_url("studentfee/IndividualaddInstallments") ?>//',
                dataType: 'JSON',
                data: {
                    stdId: stdId,
                    num_installments:num_installments,
                    formData:formData,
//                    fee_installments_select:fee_installments_select,
                    feeDetailIds:feeDetailIds
                },
                beforeSend: function () {
                },
                success: function (data) {

                    if (data.status === "success") {
                        window.location.reload();
                    }
                },
                error: function (xhr) { // if error occured
                    alert("Error occured.please try again");

                },
                complete: function () {
                }
            });
        }

    }
    var base_url = '<?php echo base_url() ?>';
    function Popup(data)
    {
        var frame1 = $('<iframe />');
        frame1[0].name = "frame1";
        frame1.css({"position": "absolute", "top": "-1000000px"});
        $("body").append(frame1);
        var frameDoc = frame1[0].contentWindow ? frame1[0].contentWindow : frame1[0].contentDocument.document ? frame1[0].contentDocument.document : frame1[0].contentDocument;
        frameDoc.document.open();
        //Create a new HTML document.
        frameDoc.document.write('<html>');
        frameDoc.document.write('<head>');
        frameDoc.document.write('<title></title>');
        frameDoc.document.write('<link rel="stylesheet" href="' + base_url + 'backend/bootstrap/css/bootstrap.min.css">');
        frameDoc.document.write('<link rel="stylesheet" href="' + base_url + 'backend/dist/css/font-awesome.min.css">');
        frameDoc.document.write('<link rel="stylesheet" href="' + base_url + 'backend/dist/css/ionicons.min.css">');
        frameDoc.document.write('<link rel="stylesheet" href="' + base_url + 'backend/dist/css/AdminLTE.min.css">');
        frameDoc.document.write('<link rel="stylesheet" href="' + base_url + 'backend/dist/css/skins/_all-skins.min.css">');
        frameDoc.document.write('<link rel="stylesheet" href="' + base_url + 'backend/plugins/iCheck/flat/blue.css">');
        frameDoc.document.write('<link rel="stylesheet" href="' + base_url + 'backend/plugins/morris/morris.css">');
        frameDoc.document.write('<link rel="stylesheet" href="' + base_url + 'backend/plugins/jvectormap/jquery-jvectormap-1.2.2.css">');
        frameDoc.document.write('<link rel="stylesheet" href="' + base_url + 'backend/plugins/datepicker/datepicker3.css">');
        frameDoc.document.write('<link rel="stylesheet" href="' + base_url + 'backend/plugins/daterangepicker/daterangepicker-bs3.css">');
        frameDoc.document.write('</head>');
        frameDoc.document.write('<body>');
        frameDoc.document.write(data);
        frameDoc.document.write('</body>');
        frameDoc.document.write('</html>');
        frameDoc.document.close();
        setTimeout(function () {
            window.frames["frame1"].focus();
            window.frames["frame1"].print();
            frame1.remove();
        }, 500);


        return true;
    }
    $(document).ready(function () {
        $('.delmodal').modal({
            backdrop: 'static',
            keyboard: false,
            show: false
        });
        $('#listCollectionModal').modal({
            backdrop: 'static',
            keyboard: false,
            show: false
        });

        $('#confirm-delete').on('show.bs.modal', function (e) {
            $('.invoice_no', this).text("");
//            $('#main_invoice', this).val("");
            $('#std_deposit_id', this).val("");

            $('.invoice_no', this).text($(e.relatedTarget).data('invoiceno'));
//            $('#main_invoice', this).val($(e.relatedTarget).data('main_invoice'));
            $('#std_deposit_id', this).val($(e.relatedTarget).data('std_deposit_id'));


        });
         $('#installment_confirm-delete').on('show.bs.modal', function (e) {
            $('.invoice_no', this).text("");
//            $('#main_invoice', this).val("");
            $('#std_deposit_id', this).val("");

            $('.invoice_no', this).text($(e.relatedTarget).data('invoiceno'));
//            $('#main_invoice', this).val($(e.relatedTarget).data('main_invoice'));
            $('#installment_std_deposit_id', this).val($(e.relatedTarget).data('std_deposit_id'));


        });

        $('#confirm-discountdelete').on('show.bs.modal', function (e) {
            $('.discount_title', this).text("");
            $('#discount_id', this).val("");
            $('.discount_title', this).text($(e.relatedTarget).data('discounttitle'));
            $('#discount_id', this).val($(e.relatedTarget).data('discountid'));
        });

        $('#confirm-delete').on('click', '.btn-ok', function (e) {
            var $modalDiv = $(e.delegateTarget);
//            var main_invoice = $('#main_invoice').val();
            var std_deposit_id = $('#std_deposit_id').val();

            $modalDiv.addClass('modalloading');
            $.ajax({
                type: "post",
                url: '<?php echo site_url("studentfee/revertDepositFee") ?>',
                dataType: 'JSON',
                data: {'std_deposit_id': std_deposit_id},
                success: function (data) {
                    $modalDiv.modal('hide').removeClass('modalloading');
                    location.reload(true);
                }
            });


        });
        $('#installment_confirm-delete').on('click', '.installment_btn-ok', function (e) {
            var $modalDiv = $(e.delegateTarget);
//            var main_invoice = $('#main_invoice').val();
            var std_deposit_id = $('#installment_std_deposit_id').val();

            $modalDiv.addClass('modalloading');
            $.ajax({
                type: "post",
                url: '<?php echo site_url("studentfee/revertInstallmentDepositFee") ?>',
                dataType: 'JSON',
                data: {'std_deposit_id': std_deposit_id},
                success: function (data) {
                    $modalDiv.modal('hide').removeClass('modalloading');
                    location.reload(true);
                }
            });


        });

        $('#confirm-discountdelete').on('click', '.btn-discountdel', function (e) {
            var $modalDiv = $(e.delegateTarget);
            var discount_id = $('#discount_id').val();


            $modalDiv.addClass('modalloading');
            $.ajax({
                type: "post",
                url: '<?php echo site_url("studentfee/deleteStudentDiscount") ?>',
                dataType: 'JSON',
                data: {'discount_id': discount_id},
                success: function (data) {
                    $modalDiv.modal('hide').removeClass('modalloading');
                    location.reload(true);
                }
            });


        });


//        $(document).on('click', '.btn-ok', function (e) {
//            var $modalDiv = $(e.delegateTarget);
//            var main_invoice = $('#main_invoice').val();
//            var sub_invoice = $('#sub_invoice').val();
//
//            $modalDiv.addClass('modalloading');
//            $.ajax({
//                type: "post",
//                url: '<?php //echo site_url("studentfee/deleteFee") ?>//',
//                dataType: 'JSON',
//                data: {'main_invoice': main_invoice, 'sub_invoice': sub_invoice},
//                success: function (data) {
//                    $modalDiv.modal('hide').removeClass('modalloading');
//                    location.reload(true);
//                }
//            });
//
//
//        });
        $('.detail_popover').popover({
            placement: 'right',
            title: '',
            trigger: 'hover',
            container: 'body',
            html: true,
            content: function () {
                return $(this).closest('td').find('.fee_detail_popover').html();
            }
        });
    });
    var fee_amount = 0;
    var date_format = '<?php echo $result = strtr($this->customlib->getSchoolDateFormat(), ['d' => 'dd', 'm' => 'mm', 'Y' => 'yyyy']) ?>';

</script>
<script type="text/javascript">
    $("#myFeesModal").on('shown.bs.modal', function (e) {
        e.stopPropagation();
        var discount_group_dropdown = '<option value=""><?php echo $this->lang->line('select'); ?></option>';
            var data = $(e.relatedTarget).data();
        var modal = $(this);
        var type = data.type;
        var amount = data.amount;
//        var group = data.group;
        var fee_detail_id = data.fee_detail_id;
//        var student_fees_master_id = data.student_fees_master_id;
//        var student_session_id = data.student_session_id;

        $('.fees_title').html("");
        $('.fees_title').html("<b>" + type + "</b> ");
        $('#fee_detail_id').val(fee_detail_id);
//        $('#student_fees_master_id').val(student_fees_master_id);



        $.ajax({
            type: "post",
            url: '<?php echo site_url("studentfee/getFeeDetails") ?>',
            dataType: 'JSON',
            data: {'fee_detail_id': fee_detail_id,
//                'student_fees_master_id': student_fees_master_id,
//                'student_session_id': student_session_id
            },
            beforeSend: function () {
//                $('#discount_group').html("");
                $("#dynamicFees").html("");
                $('#amount').val("");
//                $('#amount_discount').val("0");
//                $('#amount_fine').val("0");
                modal.addClass('modal_loading');
            },
            success: function (data) {

                if (data.status === "success") {
//                    fee_amount = data.balance;

                    $('#amount').val(data.balance);
                    $('#amount_fine').val(data.fine);
                    $("#dynamicFees").html(data.html);

//                    $.each(data.discount_not_applied, function (i, obj)
//                    {
//                        discount_group_dropdown += "<option value=" + obj.student_fees_discount_id + " data-disamount=" + obj.amount + ">" + obj.code + "</option>";
//                    });
//                    $('#discount_group').append(discount_group_dropdown);




                }
            },
            error: function (xhr) { // if error occured
                alert("Error occured.please try again");

            },
            complete: function () {
                modal.removeClass('modal_loading');
            }
        });


    });
    $("#myInsatllmentCollectModel").on('shown.bs.modal', function (e) {
        e.stopPropagation();
        var discount_group_dropdown = '<option value=""><?php echo $this->lang->line('select'); ?></option>';
        var data = $(e.relatedTarget).data();
        var modal = $(this);
        var type = data.type;
        var amount = data.amount;
         var installment_detail_id = data.installment_detail_id;
         var fee_detail_id = data.fee_detail_id;
        $('.installment_fees_title').html("");
        $('.installment_fees_title').html("<b>" + type + "</b> ");
        $('#installment_detail_id').val(installment_detail_id);
        $('#inatllment_fee_detail_id').val(fee_detail_id);
        $('#installment_amount').val(amount);
    });

</script>

<script type="text/javascript">
    $(document).ready(function () {
        $.extend($.fn.dataTable.defaults, {
            searching: false,
            ordering: false,
            paging: false,
            bSort: false,
            info: false
        });
    });
    $(document).ready(function () {
        $('.table-fixed-header').fixedHeader();
    });

    //  $(window).on('resize', function () {
    //    $('.header-copy').width($('.table-fixed-header').width())
    //});

    (function ($) {

        $.fn.fixedHeader = function (options) {
            var config = {
                topOffset: 50
                //bgColor: 'white'
            };
            if (options) {
                $.extend(config, options);
            }

            return this.each(function () {
                var o = $(this);

                var $win = $(window);
                var $head = $('thead.header', o);
                var isFixed = 0;
                var headTop = $head.length && $head.offset().top - config.topOffset;

                function processScroll() {
                    if (!o.is(':visible')) {
                        return;
                    }
                    if ($('thead.header-copy').size()) {
                        $('thead.header-copy').width($('thead.header').width());
                    }
                    var i;
                    var scrollTop = $win.scrollTop();
                    var t = $head.length && $head.offset().top - config.topOffset;
                    if (!isFixed && headTop !== t) {
                        headTop = t;
                    }
                    if (scrollTop >= headTop && !isFixed) {
                        isFixed = 1;
                    } else if (scrollTop <= headTop && isFixed) {
                        isFixed = 0;
                    }
                    isFixed ? $('thead.header-copy', o).offset({
                        left: $head.offset().left
                    }).removeClass('hide') : $('thead.header-copy', o).addClass('hide');
                }
                $win.on('scroll', processScroll);

                // hack sad times - holdover until rewrite for 2.1
                $head.on('click', function () {
                    if (!isFixed) {
                        setTimeout(function () {
                            $win.scrollTop($win.scrollTop() - 47);
                        }, 10);
                    }
                });

                $head.clone().removeClass('header').addClass('header-copy header-fixed').appendTo(o);
                var header_width = $head.width();
                o.find('thead.header-copy').width(header_width);
                o.find('thead.header > tr:first > th').each(function (i, h) {
                    var w = $(h).width();
                    o.find('thead.header-copy> tr > th:eq(' + i + ')').width(w);
                });
                $head.css({
                    margin: '0 auto',
                    width: o.width(),
                    'background-color': config.bgColor
                });
                processScroll();
            });
        };

    })(jQuery);


    $(".applydiscount").click(function () {
        $("span[id$='_error']").html("");
        $('.discount_title').html("");
        $('#student_fees_discount_id').val("");
        var student_fees_discount_id = $(this).data("student_fees_discount_id");
        var modal_title = $(this).data("modal_title");


        $('.discount_title').html("<b>" + modal_title + "</b>");

        $('#student_fees_discount_id').val(student_fees_discount_id);
        $('#myDisApplyModal').modal({
            backdrop: 'static',
            keyboard: false,
            show: true
        });
    });




    $(document).on('click', '.dis_apply_button', function (e) {
        var $this = $(this);
        $this.button('loading');

        var discount_payment_id = $('#discount_payment_id').val();
        var student_fees_discount_id = $('#student_fees_discount_id').val();
        var dis_description = $('#dis_description').val();

        $.ajax({
            url: '<?php echo site_url("admin/feediscount/applydiscount") ?>',
            type: 'post',
            data: {
                discount_payment_id: discount_payment_id,
                student_fees_discount_id: student_fees_discount_id,
                dis_description: dis_description
            },
            dataType: 'json',
            success: function (response) {
                $this.button('reset');
                if (response.status === "success") {
                    location.reload(true);
                } else if (response.status === "fail") {
                    $.each(response.error, function (index, value) {
                        var errorDiv = '#' + index + '_error';
                        $(errorDiv).empty().append(value);
                    });
                }
            }
        });
    });

</script>

<script type="text/javascript">
    $(document).ready(function () {
        $(document).on('click', '.printSelected', function () {
            var feeDetailArray = [];
            var stdId = $('#stdId').val();
            $.each($(".checkedFeeIds:checked"), function(){
                var index =  ($(this).val());
                feeDetailArray.push(index);
            });
            if (feeDetailArray.length === 0) {
                alert("<?php echo $this->lang->line('no_record_selected');?>");
            } else {
                $.ajax({
                    url: '<?php echo site_url("studentfee/printSelectedFee") ?>',
                    type: 'post',
                    data: {
                        feeDetailArray  :  feeDetailArray,
                        stdId  :  stdId,
                    },
                    success: function (response) {
                        Popup(response);
                    }
                });
            }
        });
        $(document).on('click', '.genrateVoucher', function () {
            var feeDetailArray = [];
            var InstallmentDetailArray = [];
            var stdId = $('#stdId').val();
            $.each($(".checkedFeeIds:checked"), function(){
                var index =  ($(this).val());
                feeDetailArray.push(index);
            });
            $.each($(".checkedInstallmentIds:checked"), function(){
                var index =  ($(this).val());
                InstallmentDetailArray.push(index);
            });
            if (feeDetailArray.length === 0  && InstallmentDetailArray.length === 0) {
                alert("<?php echo $this->lang->line('no_record_selected');?>");
            } else {
                $.ajax({
                    url: '<?php echo site_url("studentfee/genrateMultiFeeVoucher") ?>',
                    type: 'post',
                    data: {
                        feeDetailArray  :  feeDetailArray,
                        InstallmentDetailArray  :  InstallmentDetailArray,
                        stdId  :  stdId,
                    },
                    success: function (response) {
//                        $('.skin-blue').html("");
//                        $('.skin-blue').html(response);
//                        $('body').html(response);


                    }
                });
            }
        });


        $(document).on('click', '.collectSelected', function () {
            var $this = $(this);
            var array_to_collect_fees = [];
            $.each($("input[name='fee_checkbox']:checked"), function () {
                var fee_session_group_id = $(this).data('fee_session_group_id');
                var fee_master_id = $(this).data('fee_master_id');
                var fee_groups_feetype_id = $(this).data('fee_groups_feetype_id');
                item = {};
                item ["fee_session_group_id"] = fee_session_group_id;
                item ["fee_master_id"] = fee_master_id;
                item ["fee_groups_feetype_id"] = fee_groups_feetype_id;

                array_to_collect_fees.push(item);
            });

            $.ajax({
                type: 'POST',
                url: base_url + "studentfee/getcollectfee",
                data: {'data': JSON.stringify(array_to_collect_fees)},
                dataType: "JSON",
                beforeSend: function () {
                    $this.button('loading');
                },
                success: function (data) {

                    $("#listCollectionModal .modal-body").html(data.view);
                    $(".date").datepicker({
                        format: date_format,
                        autoclose: true,

                        language: '<?php echo $language_name; ?>',
                        endDate: '+0d',
                        todayHighlight: true
                    });
                    $("#listCollectionModal").modal('show');
                    $this.button('reset');
                },
                error: function (xhr) { // if error occured
                    alert("Error occured.please try again");

                },
                complete: function () {
                    $this.button('reset');
                }
            });

        });

        $(document).on('click', '.collectSelected', function () {
            var $this = $(this);
            var array_to_collect_fees = [];
            $.each($("input[name='fee_checkbox']:checked"), function () {
                var fee_session_group_id = $(this).data('fee_session_group_id');
                var fee_master_id = $(this).data('fee_master_id');
                var fee_groups_feetype_id = $(this).data('fee_groups_feetype_id');
                item = {};
                item ["fee_session_group_id"] = fee_session_group_id;
                item ["fee_master_id"] = fee_master_id;
                item ["fee_groups_feetype_id"] = fee_groups_feetype_id;

                array_to_collect_fees.push(item);
            });

            $.ajax({
                type: 'POST',
                url: base_url + "studentfee/getcollectfee",
                data: {'data': JSON.stringify(array_to_collect_fees)},
                dataType: "JSON",
                beforeSend: function () {
                    $this.button('loading');
                },
                success: function (data) {

                    $("#listCollectionModal .modal-body").html(data.view);
                    $(".date").datepicker({
                        format: date_format,
                        autoclose: true,

                        language: '<?php echo $language_name; ?>',
                        endDate: '+0d',
                        todayHighlight: true
                    });
                    $("#listCollectionModal").modal('show');
                    $this.button('reset');
                },
                error: function (xhr) { // if error occured
                    alert("Error occured.please try again");

                },
                complete: function () {
                    $this.button('reset');
                }
            });

        });


        $("#genrateVoucherbtn").click(function(){
            var feeDetailArray = [];
            var InstallmentDetailArray = [];
            var stdId = $('#stdId').val();
            var i;
            var FeeDeatilsrow = "";
            var InstallmentDeatilsrow = "";
            $.each($(".checkedFeeIds:checked"), function(){
                var index =  ($(this).val());
                feeDetailArray.push(index);
                FeeDeatilsrow += ' <input   name="feeDetailArray[]"   type="hidden"  value="'+index+'"  >';

            });
            $.each($(".checkedInstallmentIds:checked"), function(){
                var index =  ($(this).val());
                InstallmentDetailArray.push(index);
                InstallmentDeatilsrow += ' <input   name="InstallmentDetailArray[]"   type="hidden"  value="'+index+'"  >';

            });
            var issueDate=$('#issueDateModal').val();
            var dueDate=$('#dueDateModal').val();
            var stuckoffDateModal=$('#stuckoffDateModal').val();
            var billiongPeriodModal=$('#billiongPeriodModal').val();
            $("#voucherIssueDateInput").val(issueDate);
            $("#voucherStuckOffDateInput").val(stuckoffDateModal);
            $("#voucherDueDateInput").val(dueDate);
            $("#voucherBillingPeriod").val(billiongPeriodModal);




            $("#feeDetailArraydiv").html("");
            $("#feeDetailArraydiv").html(FeeDeatilsrow);
            $("#InstallmentDetailArraydiv").html("");
            $("#InstallmentDetailArraydiv").html(InstallmentDeatilsrow);
            if (feeDetailArray.length === 0  && InstallmentDetailArray.length === 0) {
                alert("<?php echo $this->lang->line('no_record_selected');?>");
            }else
            {
                var validated=true;
                $('.voucherDates input').each(function(){

                    if ($(this).val().trim()=='') {
                        $(this).removeClass("border-primary").addClass("is-invalid").addClass("border-danger");
                        validated=false;
                    }
                });
                if(validated==true)
                {
                    $("#printVoucherForm").submit();
                }else
                {
                    alert("Please enter dates");
                }

//                $("#printVoucherForm").submit();

            }

        });
    });


    $(function () {
        $(document).on('change', "#discount_group", function () {
            var amount = $('option:selected', this).data('disamount');

            var balance_amount = (parseFloat(fee_amount) - parseFloat(amount)).toFixed(2);
            if (typeof amount !== typeof undefined && amount !== false) {
                $('div#myFeesModal').find('input#amount_discount').prop('readonly', true).val(amount);
                $('div#myFeesModal').find('input#amount').val(balance_amount);

            } else {
                $('div#myFeesModal').find('input#amount').val(fee_amount);
                $('div#myFeesModal').find('input#amount_discount').prop('readonly', false).val(0);
            }

        });
    });

    $("#collect_fee_group").submit(function (e) {
        var form = $(this);
        var url = form.attr('action');
        var smt_btn = $(this).find("button[type=submit]");
        $.ajax({
            type: "POST",
            url: url,
            dataType: 'JSON',
            data: form.serialize(), // serializes the form's elements.
            beforeSend: function () {
                smt_btn.button('loading');
            },
            success: function (response) {

                if (response.status === 1) {

                    location.reload(true);
                } else if (response.status === 0) {
                    $.each(response.error, function (index, value) {
                        var errorDiv = '#form_collection_' + index + '_error';
                        $(errorDiv).empty().append(value);
                    });
                }
            },
            error: function (xhr) { // if error occured

                alert("Error occured.please try again");

            },
            complete: function () {
                smt_btn.button('reset');
            }
        });

        e.preventDefault(); // avoid to execute the actual submit of the form.
    });

    $("#select_all").change(function () {  //"select all" change
        $('input:checkbox').not(this).prop('checked', this.checked);
        // $(".checkbox").prop('checked', $(this).prop("checked")); //change all ".checkbox" checked status
    });

    function generateDateInputs(index) {
        var number= $("#num_installments"+index).val();
        var div =getDynamicInpust(number);
        
        $("#dynamicDateInputs"+index).html("");
        $("#dynamicDateInputs"+index).html(div);

    }

    function getDynamicInpust(lenght_div) {

        var i;
        var row = "";

        for (i = 1; i <= lenght_div; i++) {
            row += '<h4>Installment # '+i+' Dates </h4>';
            row += '<div class="form-group " style="display: flex;">';
            row += '<label for="exampleInputFile">Due Date</label><small class="req"> *</small>';
            row += ' <input style="width:30%"  name="due_date_'+i+'" id="due_date_'+i+'" placeholder="" type="text" class="form-control date" value="<?=date($this->customlib->getSchoolDateFormat())?>"  >';
            row += '<label for="exampleInputFile">Stuck of Date</label><small class="req"> *</small>';
            row += ' <input style="width:30%"  name="stuckoff_date_'+i+'" id="stuckoff_date_'+i+'" placeholder="stuckoff_date_'+i+'" type="text" class="form-control date" value="<?=date($this->customlib->getSchoolDateFormat())?>"  >';
             row += '</div>';


        }

        return row;
    }

</script>
