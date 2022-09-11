<?php
$currency_symbol = $this->customlib->getSchoolCurrencyFormat();
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
                            <div class="col-md-4 col-sm-6">
                                <div class="row">
                                    <form role="form" action="<?php echo site_url('studentfee/assignFeeSearch') ?>" method="post" class="">
                                        <?php echo $this->customlib->getCSRF(); ?>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="exampleInputFile">Fee Case</label><small class="req"> *</small>
                                                <select class="form-control" name="fee_case">
                                                    <option value=""><?php echo $this->lang->line('select'); ?></option>
                                                    <option value="1" <?php if (set_value('fee_case') == 1) echo "selected=selected" ?> <?php echo ($fee_case==1) ? 'selected' : ''?>>Monthly</option>
                                                    <option value="2" <?php if (set_value('fee_case') == 2) echo "selected=selected" ?> <?php echo ($fee_case==2) ? 'selected' : ''?>>Bi-Monthly</option>

                                                </select>
                                                <span class="text-danger"><?php echo form_error('fee_case'); ?></span>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-6">
                                            <div class="form-group">
                                                <label><?php echo $this->lang->line('class'); ?></label><small class="req">  *</small>
                                                <select autofocus="" id="class_id" name="class_id" class="form-control" >
                                                    <option value=""><?php echo $this->lang->line('select'); ?></option>
                                                    <option value="all"><?php echo $this->lang->line('all'); ?></option>
                                                    <?php
                                                    foreach ($classlist as $class) {
                                                        ?>
                                                        <option value="<?php echo $class['id'] ?>" <?php if (set_value('class_id') == $class['id']) echo "selected=selected" ?>><?php echo $class['class'] ?></option>
                                                        <?php
                                                    }
                                                    ?>
                                                </select>
                                                <span class="text-danger"><?php echo form_error('class_id'); ?></span>
                                            </div>
                                        </div>
<!--                                        <div class="col-md-5 col-sm-6">-->
<!--                                            <div class="form-group">-->
<!--                                                <label>--><?php //echo $this->lang->line('section'); ?><!--</label>-->
<!--                                                <select  id="section_id" name="section_id" class="form-control" >-->
<!--                                                    <option value="">--><?php //echo $this->lang->line('select'); ?><!--</option>-->
<!--                                                </select>-->
<!--                                                <span class="text-danger">--><?php //echo form_error('section_id'); ?><!--</span>-->
<!--                                            </div>-->
<!--                                        </div>-->
                                        <div class=" col-md-12 col-sm-11">
                                            <div class="form-group">
                                                <button type="submit" name="search" value="search_filter" class="btn btn-primary pull-right btn-sm checkbox-toggle"><i class="fa fa-search"></i> <?php echo $this->lang->line('search'); ?></button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6">
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
                            <h3 class="box-title"><i class="fa fa-users"></i> <?php echo $this->lang->line('assign_fees_group'); ?>
                                </i> <?php echo form_error('student'); ?></h3>
                            <div class="box-tools pull-right"></div>
                        </div>
                        <form action="<?=base_url('studentfee/assign_student_fee')?>" method="post" id="assign_form">
                        <div class="box-body table-responsive">
                            <div class="col-sm-3">
                                <label>Select Fee Type</label>
                                <select  class="js-example-basic-multiple form-control" name="feeType[]" multiple="multiple">
                                <?php
                                if(!empty($feeTypeList))
                                {

                                    foreach ($feeTypeList as $value)
                                    {
                                        ?>
                                        <option value="<?=$value['id']?>"><?=ucfirst($value['type'])?></option>

<!--                                        <div id="mainFeeID--><?//=$value['id']?><!--" style="margin-top: 0px">-->
<!--                                            <input  class="checked_feeType" id="feeTypeCheckBox--><?//=$value['id']?><!--"  type="checkbox" name="feeType[]" value="--><?//=$value['id']?><!--">-->
<!--                                            <label style="    width: 130px;" for="exampleInputFile">--><?//=ucfirst($value['type'])?><!-- </label>-->
<!---->
<!---->
<!--                                            <input readonly type="number" id="feeamount--><?//=$value['id']?><!--" name="feeamount--><?//=$value['id']?><!--" placeholder="" class="form-control" style="width: 50%;display: inline"   value="--><?//=$value['amount']?><!--" >-->
<!--                                        </div>-->
<!--                                       <br>-->
                                        <?php
                                    }
                                }
                                ?>
                                </select>
                                 <span class="text-danger"></span>
                            </div>
                            <div class="col-sm-3">
                                <label>Month</label>
                                <?php
                                if($fee_case=="1")
                                {
                                    ?>
                                    <select class="form-control" id="one_month" name="month"  >
                                        <option value="" disabled>Select Month</option>
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
                                    <?php
                                }
                                if($fee_case=="2")
                                {
                                    ?>
                                    <select autofocus="" id="multi_month" name="month" class="form-control"  >
                                        <option value="" disabled><?php echo $this->lang->line('select'); ?></option>
                                        <option value="8-9">August  - September</option>
                                        <option value="10-11">October - November</option>
                                        <option value="12-1">December - January</option>
                                        <option value="2-3">February - March</option>
                                        <option value="4-5">April - May</option>
                                        <option value="6-7">June - July</option>
                                    </select>

                                    <?php
                                }
                                ?>
                                <span class="text-danger"></span>
                            </div>

                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Fee Year</label>
                                    <select   id="fee_year" name="fee_year" class="form-control"  >
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
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Issue Date</label>
                                    <input type="text" id="issue_date" value="<?php echo set_value('issue_date', date($this->customlib->getSchoolDateFormat())); ?>" name="issue_date" class="form-control date">
                                    <span class="text-danger"><?php echo form_error('issue_date'); ?></span>
                                </div>
                            </div>

                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="exampleInputEmail1"><?php echo $this->lang->line('due_date'); ?></label>
                                    <input type="text" id="due_date" value="<?php echo set_value('issue_date', date($this->customlib->getSchoolDateFormat())); ?>" name="due_date" class="form-control date">
                                    <span class="text-danger"><?php echo form_error('due_date'); ?></span>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Stuck Off</label>
                                    <input type="text" id="stuck_off" value="<?php echo set_value('stuck_off', date($this->customlib->getSchoolDateFormat())); ?>" name="stuck_off" class="form-control date">
                                    <span class="text-danger"><?php echo form_error('stuck_off'); ?></span>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Is Advanced</label>
                                    <select name="is_advanced" class="form-control" id="is_advanced">
                                        <option value="0">No</option>
                                        <option value="1">Yes</option>
                                    </select>
                                     <span class="text-danger"><?php echo form_error('is_advanced'); ?></span>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Fine Wavier</label>
                                    <select name="fine_wavier" class="form-control" id="fine_wavier">
                                        <option value="0">Yes</option>
                                        <option value="1">No</option>
                                    </select>
                                     <span class="text-danger"><?php echo form_error('is_advanced'); ?></span>
                                </div>
                            </div>
                            <div class="download_label"><?php echo $this->lang->line('student'); ?> <?php echo $this->lang->line('list'); ?></div>
                            <div class="">Total students :<?php echo $total_count=count($resultlist); ?>  </div>
                            <table class="table table-striped table-bordered table-hover ">
                                <thead>

                                <tr>
                                    <th><input type="checkbox" id="select_all"/> <?php echo $this->lang->line('all'); ?></th>
                                    <th><?php echo $this->lang->line('class'); ?></th>
                                    <th><?php echo $this->lang->line('section'); ?></th>

                                    <th><?php echo $this->lang->line('admission_no'); ?></th>

                                    <th><?php echo $this->lang->line('student'); ?> <?php echo $this->lang->line('name'); ?></th>
                                    <?php if ($sch_setting->father_name) {  ?>
                                        <th><?php echo $this->lang->line('father_name'); ?></th>
                                    <?php } ?>
                                    <th>Arrears</th>
<!--                                    <th>--><?php //echo $this->lang->line('phone'); ?><!--</th>-->
<!--                                    <th class="text-right">--><?php //echo $this->lang->line('action'); ?><!--</th>-->

                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $count = 1;

                                foreach ($resultlist as $student) {
                                    ?>
                                    <tr>
                                        <td>

                                            <input class="checkbox" type="checkbox" name="student_ids[]" value="<?=$student['id']?>"    />
                                            <!--                                                                    <input type="hidden" name="student_fees_master_id_--><?php //echo $student->student_session_id; ?><!--" value="--><?php //echo $student->student_fees_master_id; ?><!--">-->
                                         </td>
                                        <td><?php echo $student['class']; ?></td>
                                        <td><?php echo $student['section']; ?></td>

                                        <td><?php echo $student['roll_no']; ?></td>

                                        <td><?php echo $student['firstname'] . " " . $student['lastname']; ?></td>
                                        <?php if ($sch_setting->father_name) {  ?>
                                            <td><?php echo $student['father_name']; ?></td>
                                        <?php } ?>
<!--                                        <td>--><?php
//                                            if (!empty($student['dob'])) {
//                                                echo date($this->customlib->getSchoolDateFormat(), $this->customlib->dateyyyymmddTodateformat($student['dob']));
//                                            }
//                                            ?><!--</td>-->
<!--                                        <td>--><?php //echo $student['guardian_phone']; ?><!--</td>-->
<!--                                        <td class="pull-right">-->
<!--                                            --><?php //if ($this->rbac->hasPrivilege('collect_fees', 'can_add')) { ?>
<!---->
<!--                                                <a  href="--><?php //echo base_url(); ?><!--studentfee/addfee/--><?php //echo $student['student_session_id'] ?><!--" class="btn btn-info btn-xs" data-toggle="tooltip" title="" data-original-title="">-->
<!--                                                    --><?php //echo $currency_symbol; ?><!-- --><?php //echo $this->lang->line('collect_fees'); ?>
<!--                                                </a>-->
<!--                                            --><?php //} ?>
<!--                                        </td>-->
                                        <td>

                                                <div class="form-group">

                                                    <input type="number"   id="arrears" value="<?php  echo set_value('arrears',0)  ?>" name="arrears_<?=$student['id']?>" class="form-control">
                                                    <span class="text-danger"><?php echo form_error('arrears'); ?></span>
                                                </div>

                                        </td>

                                    </tr>
                                    <?php
                                }
                                $count++;
                                ?>
                                </tbody>
                            </table>
                            <input type="hidden" name="fee_case" value="<?=$fee_case?>">
                            <button type="submit" class="allot-fees btn btn-primary btn-sm pull-right" id="load" data-loading-text="<i class='fa fa-spinner fa-spin '></i> Please Wait.."><?php echo $this->lang->line('assign'); ?>
<!--                            <button style="margin-right: 10px;" type="button" onclick="revertFee()" class="allot-fees btn btn-primary btn-sm pull-right" id="load" data-loading-text="<i class='fa fa-spinner fa-spin '></i> Please Wait..">--><?php //echo $this->lang->line('revert'); ?>
                            </button>
                        </div><!--./box-body-->
                        </form>
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



    $(document).ready(function () {
        $('.js-example-basic-multiple').select2();
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
    $("#assign_form").submit(function (e) {
        if (confirm('Are you sure?')) {
            var $this = $('.allot-fees');
            $this.button('loading');
            $.ajax({
                type: "POST",
                dataType: 'Json',
                url: $("#assign_form").attr('action'),
                data: $("#assign_form").serialize(), // serializes the form's elements.
                success: function (data)
                {
                    if (data.status == "fail") {
                        var message = "";
                        $.each(data.error, function (index, value) {

                            message += value;
                        });
                        errorMsg(message);
                    } else {
                        $('#fee_form').removeClass('hidden');
                        $('#fees_ids').val(data.fees);
                        successMsg(data.message);

                    }

                    $this.button('reset');
//                    setTimeout(function(){
//                        location.reload(true);
//                        }, 3000);

                }
            });

        }
        e.preventDefault();
    });

    function revertFee() {
        $.ajax({
            type: "POST",
            dataType: 'Json',
            url: '<?=base_url('studentfee/revert_student_fee')?>',
            data: $("#assign_form").serialize(), // serializes the form's elements.
            success: function (data)
            {
                if (data.status == "fail") {
                    var message = "";
                    $.each(data.error, function (index, value) {

                        message += value;
                    });
                    errorMsg(message);
                } else {
//                    $('#fee_form').removeClass('hidden');
//                    $('#fees_ids').val(data.fees);
//                    successMsg(data.message);

                }

//                $this.button('reset');
//                setTimeout(function(){
//                    location.reload(true);
//                }, 3000);

            }
        });
    }
</script>