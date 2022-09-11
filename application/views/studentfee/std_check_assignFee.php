<?php
$currency_symbol = $this->customlib->getSchoolCurrencyFormat();
$ci =& get_instance();
$ci->load->model('Shared_model');


?>
<style>
    .badge-danger
    {
        background-color: #c31d1d;
    }
    .badge-success
    {
        background-color: #409a4f;
    }
</style>
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
                            <div class="col-md-12 col-sm-12">
                                <div class="row">
                                    <form role="form" action="<?php echo site_url('studentfee/search_assigned_fee') ?>" method="post" class="">
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

                                                <select class="form-control" id="one_month"  name="fee_month" style="display: block;"  >
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

                                                <select autofocus="" id="multi_month" name="fee_month2" class="form-control" style="display: none;"  >
                                                    <option value=""><?php echo $this->lang->line('select'); ?></option>
                                                    <option value="8-9">August  - September</option>
                                                    <option value="10-11">October - November</option>
                                                    <option value="12-1">December - January</option>
                                                    <option value="2-3">February - March</option>
                                                    <option value="4-5">April - May</option>
                                                    <option value="6-7">June - July</option>
                                                </select>

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
                                                        $feeYear=$i;
                                                        $feeYear--;
                                                        echo '<option value="'.$i.'">'.$feeYear.'-'.$i.'</option>';
                                                    }
                                                    ?>
                                                </select>

                                                <span class="text-danger"><?php echo form_error('month'); ?></span>
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
                         </div>
                    </div>

                    <?php
                    if (isset($std_results)) {
                    ?>
                    <div class="">
                        <div class="box-header ptbnull"></div>
                        <div class="box-header ptbnull">
                            <h3 class="box-title"><i class="fa fa-users"></i> Fee assigned students
                                </i> <?php echo form_error('student'); ?></h3>
                            <div class="box-tools pull-right"></div>
                        </div>
                        <form action="<?=base_url('studentfee/assign_student_fee')?>" method="post" id="assign_form">
                            <div class="box-body table-responsive">
                                 <div class="download_label"><?php echo $this->lang->line('student'); ?> <?php echo $this->lang->line('list'); ?></div>
                                <div class="">Total students :<?php echo $total_count=count($std_results); ?>  </div>
                                <table class="table table-striped table-bordered table-hover ">
                                    <thead>

                                    <tr>
                                         <th><?php echo $this->lang->line('class'); ?></th>
                                        <th><?php echo $this->lang->line('section'); ?></th>

                                        <th><?php echo $this->lang->line('roll_no'); ?></th>

                                        <th><?php echo $this->lang->line('student'); ?> <?php echo $this->lang->line('name'); ?></th>
                                        <?php if ($sch_setting->father_name) {  ?>
                                            <th><?php echo $this->lang->line('father_name'); ?></th>
                                        <?php } ?>
                                        <th>
                                            Fee Assigned
                                        </th>

                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $count = 1;

                                    foreach ($std_results as $student) {
                                        ?>
                                        <tr>
                                        <td><?php echo $student['class']; ?></td>
                                        <td><?php echo $student['section']; ?></td>

                                        <td><?php echo $student['roll_no']; ?></td>

                                        <td><?php echo $student['firstname'] . " " . $student['lastname']; ?></td>
                                        <?php if ($sch_setting->father_name) {  ?>
                                            <td><?php echo $student['father_name']; ?></td>
                                        <?php } ?>
                                        <td>
                                        <?php
                                        $stdExists = $this->Shared_model->selectDataWhereSingle("tbl_student_fee", array('std_id' => $student['student_main_id']));
                                        if (!empty($stdExists))
                                        {
                                            $STDFeeID = $stdExists->std_fee_id;
                                            $stdFeeDetailExits = $this->Shared_model->selectDataWhereSingle("tbl_student_fee_detail", array('std_fee_id' =>$STDFeeID,'fee_month'=>$month,'fee_year'=>$fee_year));

                                            if(!empty($stdFeeDetailExits))
                                            {
                                                echo "<span class='badge badge-success'>  Assigned  </span>";
                                            }else{
                                                echo "<span class='badge badge-danger'>No Assigned </span>";
                                            }

                                        }else{
                                            echo "<span class='badge badge-danger'>No Assigned </span>";
                                        };
                                            ?>

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
</script>