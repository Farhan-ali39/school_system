<?php
$currency_symbol = $this->customlib->getSchoolCurrencyFormat();
?>
<div class="content-wrapper" style="min-height: 1126px;">
    <section class="content-header">
        <h1>
            <i class="fa fa-money"></i> <?php echo $this->lang->line('fees_collection'); ?> <small><?php echo $this->lang->line('student1'); ?></small>  </h1>
    </section>


    <!-- Main content -->
    <section class="content">
         <?php $this->load->view('reports/_finance'); ?>
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
              <div class="box removeboxmius">
                    <div class="box-header ptbnull"></div>
                    <div class="box-header with-border">
                        <h3 class="box-title"><i class="fa fa-search"></i> <?php echo $this->lang->line('select_criteria'); ?></h3>
                    </div>
                    <form action="<?php echo site_url('studentfee/reportbyname') ?>"  method="post" accept-charset="utf-8">
                        <div class="box-body">
                            <?php echo $this->customlib->getCSRF(); ?>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1"><?php echo $this->lang->line('class'); ?></label><small class="req"> *</small>
                                        <select autofocus="" id="class_id" name="class_id" class="form-control" >
                                            <option value=""><?php echo $this->lang->line('select'); ?></option>
                                            <?php
                                            foreach ($classlist as $class) {
                                                ?>
                                                <option value="<?php echo $class['id'] ?>" <?php if (set_value('class_id') == $class['id']) echo "selected=selected" ?>><?php echo $class['class'] ?></option>
                                                <?php
                                                $count++;
                                            }
                                            ?>
                                        </select>
                                        <span class="text-danger"><?php echo form_error('class_id'); ?></span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1"><?php echo $this->lang->line('section'); ?></label><small class="req"> *</small>
                                        <select  id="section_id" name="section_id" class="form-control" >
                                            <option value=""><?php echo $this->lang->line('select'); ?></option>
                                        </select>
                                        <span class="text-danger"><?php echo form_error('section_id'); ?></span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1"><?php echo $this->lang->line('student'); ?></label><small class="req"> *</small>
                                        <select  id="student_id" name="student_id" class="form-control" >
                                            <option value=""><?php echo $this->lang->line('select'); ?></option>
                                        </select>
                                        <span class="text-danger"><?php echo form_error('student_id'); ?></span>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                  <div class="form-group">  
                                    <button type="submit" class="btn btn-primary btn-sm pull-right"><i class="fa fa-search"></i> <?php echo $this->lang->line('search'); ?></button>
                                  </div>  
                                </div>
                            </div>
                        </div>

                    </form>
                 
                


                <?php
                if (isset($student_fee)) {
                    ?>

                    <div class="">
                       <div class="box-header ptbnull"></div>    
                        <div class="box-header">
                            <h3 class="box-title">

                                <i class="fa fa-file-text-o"></i> <?php echo $this->lang->line('fees_statement'); ?>
                            </h3>
                        </div>
                        <div class="box-body" style="padding-top:0;">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="sfborder">  
                                        <div class="col-md-2">
                                            <img width="115" height="115" class="round5" src="<?php echo base_url() . $student['image'] ?>" alt="No Image">
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
                                    </div>
                                </div> 
                                <div class="col-md-12">
                                    <div style="background: #dadada; height: 1px; width: 100%; clear: both; margin-bottom: 10px;"></div>
                                    <p class="dates"><?php echo $this->lang->line('date'); ?>: <?php echo date($this->customlib->getSchoolDateFormat()); ?></p></div>
                            </div>    

                            <div class="table-responsive">
                                <div class="download_label"> <?php echo $this->lang->line('fees_statement')."<br>";
                                $this->customlib->get_postmessage();
                                 ?></div>
                                <table class="table table-striped table-bordered table-hover example table-fixed-header">

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
                                            <th class="text text-right">Extra <span><?php echo "(" . $currency_symbol . ")"; ?></span></th>
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
                                            $grandTotal=$grandTotal+$value['total_amount']+$value['arrears'];
                                            $grandExtra= $value['std_total_arrears'];
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
                                            $grandPayableBalance=$grandPayableBalance+$payable_balance+$value['fine'];
                                            $grandDiscBalance=$grandDiscBalance+$value['total_discount'];
                                            $grandFineBalance=$grandFineBalance+$value['fine'];
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
<!--                                            <td>-->
<!--                                                <input class="checkbox checkedFeeIds" type="checkbox" name="fee_checkbox[]"  value="--><?//=$value['fee_detail_id']?><!--">-->
<!--                                            </td>-->
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
                                                <?=$value['total_amount']+$value['arrears']?>
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

                                                echo (number_format($value['std_total_arrears'], 2, '.', ''));
                                                ?></td>
                                            <td class="text text-right"><?php
                                                $display_none = "ss-none";

                                                if ($payable_balance >= 0) {
                                                    $display_none = "";

                                                    echo (number_format($payable_balance+$value['fine'], 2, '.', ''));
                                                }else{
                                                    $display_none = "";
                                                    echo (number_format(0, 2, '.', ''));

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
                                                            <?php echo $feeDepositDetail->date; ?>
                                                        </td>
                                                        <td class="text text-right"><?php echo (number_format(0, 2, '.', '')); ?></td>
                                                        <td class="text text-right"><?php echo (number_format($feeDepositDetail->fine, 2, '.', '')); ?></td>
                                                        <td class="text text-right"><?php echo (number_format($feeDepositDetail->paid_amount, 2, '.', '')); ?></td>
                                                        <td align="left"></td>
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
                                                        <td class="text-right"> <img src="<?php echo base_url(); ?>backend/images/table-arrow.png" alt="" /></td>
                                                        <td align="left" style="display: flex;">
                                                            <input class="checkbox checkedInstallmentIds" type="checkbox" name="installment_checkbox[]"  value="<?=$detail->installment_detail_id?>">
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
                                                        <td class="text text-left"> </td>
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
                                            <td align="left" ></td>

                                            <td align="left" class="text text-left" ><?php echo $this->lang->line('grand_total'); ?></td>
                                            <td class="text text-right"><?php
                                                echo ($currency_symbol . number_format($grandTotal, 2, '.', ''));
                                                ?></td>
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

                                        </tr>
                                        <?php
                                    }
                                    ?>
                                    </tbody>

                                </table>
                            </div> 
                        </div>

                    </div>
                  </div>  
                    <?php
                } else {
                    
                }
                ?>

            </div>
        </div>
        <!-- /.row -->
    </section>

    <!-- /.content -->
    <div class="clearfix"></div>
</div>


<script type="text/javascript">
    function getSectionByClass(class_id, section_id) {
        if (class_id !== "" && section_id !== "") {
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
                        if (section_id === obj.section_id) {
                            sel = "selected";
                        }
                        div_data += "<option value=" + obj.section_id + " " + sel + ">" + obj.section + "</option>";
                    });
                    $('#section_id').append(div_data);
                }
            });
        }
    }

    $(document).ready(function () {
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
        $(document).on('change', '#section_id', function (e) {

            getStudentsByClassAndSection();

        });
        var class_id = $('#class_id').val();
        var section_id = '<?php echo set_value('section_id') ?>';
        getSectionByClass(class_id, section_id);
        if (class_id != "" || section_id != "") {
            postbackStudentsByClassAndSection(class_id, section_id);
        }
    });
    function getStudentsByClassAndSection() {

        $('#student_id').html("");
        var class_id = $('#class_id').val();
        var section_id = $('#section_id').val();
        var student_id = '<?php echo set_value('student_id') ?>';
        var base_url = '<?php echo base_url() ?>';
        var div_data = '<option value=""><?php echo $this->lang->line('select'); ?></option>';
        $.ajax({
            type: "GET",
            url: base_url + "student/getByClassAndSection",
            data: {'class_id': class_id, 'section_id': section_id},
            dataType: "json",
            success: function (data) {
                $.each(data, function (i, obj)
                {
                    var sel = "";
                    if (section_id == obj.section_id) {
                        sel = "selected=selected";
                    }
                    div_data += "<option value=" + obj.id + ">" + obj.firstname + " " + obj.lastname +" ("+ obj.admission_no + ") </option>";
                });
                $('#student_id').append(div_data);
            }
        });
    }

    function postbackStudentsByClassAndSection(class_id, section_id) {
        $('#student_id').html("");
        var student_id = '<?php echo set_value('student_id') ?>';
        var base_url = '<?php echo base_url() ?>';
        var div_data = '<option value=""><?php echo $this->lang->line('select'); ?></option>';
        $.ajax({
            type: "GET",
            url: base_url + "student/getByClassAndSection",
            data: {'class_id': class_id, 'section_id': section_id},
            dataType: "json",
            success: function (data) {
                $.each(data, function (i, obj)
                {
                    var sel = "";
                    if (student_id == obj.id) {
                        sel = "selected=selected";
                    }
                    div_data += "<option value=" + obj.id + " " + sel + ">" + obj.firstname + " " + obj.lastname +" ("+ obj.admission_no + ") </option>";
                });
                $('#student_id').append(div_data);
            }
        });
    }
</script>

<script type="text/javascript">

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
    $(document).ready(function () {
        $.extend($.fn.dataTable.defaults, {
            ordering: false,
            paging: false,
            bSort: false,
            info: false
        });
    });
</script>
