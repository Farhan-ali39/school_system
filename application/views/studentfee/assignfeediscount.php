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
                            <div class="col-md-12 col-sm-6">
                                <div class="row">
                                    <form role="form" action="<?php echo site_url('admin/feediscount/assignFeeDiscount/').$id ?>" method="post" class="">
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
                                        <div class="col-md-4 col-sm-4">
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
                                                        <option value="">Select Month</option>
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
                                                        <option value="">Select Month</option>
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
                                        <div class="col-md-4 col-sm-6">
                                            <div class="form-group">

                                                <label for="exampleInputEmail1">Fee Year</label>
                                                <select   id="fee_year" name="fee_year" class="form-control"  >
                                                    <option value="" disabled><?php echo $this->lang->line('select'); ?></option>
                                                    <?php
                                                    $currentYear=date('Y',strtotime('-5 year'));

                                                    for($i=$currentYear;$i<=$currentYear+10;$i++)
                                                    {
                                                        $selected="";
                                                        if($fee_year==$i)
                                                            $selected="selected";
                                                        $feeYear=$i;
                                                        $feeYear--;
                                                        echo '<option value="'.$i.'" '.$selected.'>'.$feeYear.'-'.$i.'</option>';
                                                    }
                                                    ?>
                                                </select>

                                                <span class="text-danger"><?php echo form_error('fee_session'); ?></span>
                                            </div>
                                        </div>


                                        <div class=" col-md-12 col-sm-11">
                                            <div class="form-group">
                                                <button type="submit" name="search" value="search_filter" class="btn btn-primary pull-right btn-sm checkbox-toggle"><i class="fa fa-search"></i> <?php echo $this->lang->line('search'); ?></button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
<!--                            <div class="col-md-6 col-sm-6">-->
<!--                                <div class="row">-->
<!--                                    <form role="form" action="--><?php //echo site_url('studentfee/assignFeeSearch') ?><!--" method="post" class="">-->
<!--                                        --><?php //echo $this->customlib->getCSRF(); ?>
<!--                                        <div class="col-sm-12">-->
<!--                                            <div class="form-group">-->
<!--                                                <label>--><?php //echo $this->lang->line('search_by_keyword'); ?><!--</label>-->
<!--                                                <input type="text" name="search_text" class="form-control" value="--><?php //echo set_value('search_text'); ?><!--" placeholder="--><?php //echo $this->lang->line('search_by_student_name'); ?><!--">-->
<!--                                            </div>-->
<!--                                        </div>-->
<!---->
<!--                                        <div class="col-sm-12">-->
<!--                                            <div class="form-group">-->
<!--                                                <button type="submit" name="search" value="search_full" class="btn btn-primary btn-sm pull-right checkbox-toggle"><i class="fa fa-search"></i> --><?php //echo $this->lang->line('search'); ?><!--</button>-->
<!--                                            </div>-->
<!--                                        </div>-->
<!--                                    </form>-->
<!--                                </div>-->
<!--                            </div>-->
                        </div>
                    </div>

                    <?php
                    if (isset($resultlist)) {
                    ?>
                    <div class="">
                        <div class="box-header ptbnull"></div>
                        <div class="box-header ptbnull">
                            <h3 class="box-title"><i class="fa fa-users"></i> Assign Fee Discount
                                </i> <?php echo form_error('student'); ?></h3>
                            <div class="box-tools pull-right"></div>
                        </div>
                        <form action="<?=base_url('admin/feediscount/assignDiscount')?>" method="post" id="assign_form">
                            <div class="box-body table-responsive">
                                 <div class="download_label"><?php echo $this->lang->line('student'); ?> <?php echo $this->lang->line('list'); ?></div>
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
                                        <!--                                    <th>--><?php //echo $this->lang->line('date_of_birth'); ?><!--</th>-->
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

                                                <input class="checkbox" type="checkbox" name="fee_detail_ids[]" value="<?=$student['fee_detail_id']?>"    />
                                                <!--                                                                    <input type="hidden" name="student_fees_master_id_--><?php //echo $student->student_session_id; ?><!--" value="--><?php //echo $student->student_fees_master_id; ?><!--">-->
                                            </td>
                                            <td><?php echo $student['class']; ?></td>
                                            <td><?php echo $student['section']; ?></td>

                                            <td><?php echo $student['admission_no']; ?></td>

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

                                        </tr>
                                        <?php
                                    }
                                    $count++;
                                    ?>
                                    </tbody>
                                </table>
                                <input type="hidden" name="fee_case" value="<?=$fee_case?>">
                                <input type="hidden" name="discount_id" value="<?=$id?>">
                                <button type="submit" class="allot-fees btn btn-primary btn-sm pull-right" id="load" data-loading-text="<i class='fa fa-spinner fa-spin '></i> Please Wait.."><?php echo $this->lang->line('assign'); ?>
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
                    setTimeout(function(){
                        location.reload(true);
                    }, 3000);

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