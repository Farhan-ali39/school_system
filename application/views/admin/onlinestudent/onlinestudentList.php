<?php $currency_symbol = $this->customlib->getSchoolCurrencyFormat(); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">



    <!-- Main content -->
    <section class="content">
        <div class="row">

            <!-- left column -->
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title"><?php echo $this->lang->line('student')." ".$this->lang->line('list')?></h3>
                        <?php if ($this->session->flashdata('msg')) { ?>
                            <?php echo $this->session->flashdata('msg') ?>
                        <?php } ?>
                        <?php
                        if (isset($error_message)) {
                            echo "<div class='alert alert-danger'>" . $error_message . "</div>";
                        }
                        ?>

                        <div class="box-tools pull-right">
                        </div><!-- /.box-tools -->
                    </div><!-- /.box-header -->
                    <div class="box-body table-responsive">
                        <div class="mailbox-messages">
                            <table class="table table-striped table-bordered table-hover example" cellspacing="0" width="100%">
                                <thead>
                                <tr>

                                    <th><?php echo $this->lang->line('student_name'); ?></th>
                                    <th><?php echo $this->lang->line('class'); ?></th>
                                    <th>Parent Name</th>
                                     <th><?php echo $this->lang->line('gender'); ?></th>
                                    <th>Parent Email</th>
                                    <th><?php echo $this->lang->line('mobile_no'); ?></th>
                                    <th>Campus</th>
                                    <th>Remarks</th>
                                    <th>Action</th>
                                 </tr>
                                </thead>
                                <tbody>
                                <?php

                                foreach ($studentlist as $student) {

                                    ?>
                                    <tr class="<?=($student['follow_up']==0)?"bg-danger":""?>">

                                        <td>

                                            <?php
                                            echo $student['student_name'];
                                             ?>
                                        </td>
                                        <td><?php echo $student['class']  ?></td>
                                        <td><?php echo $student['parent_name']; ?></td>
                                         <td><?php echo ($student['gender']=="M")? "Male" : "Female"; ?></td>
                                         <td><?php echo $student['parent_email']; ?></td>
                                         <td><?php echo $student['parent_contact']; ?></td>
                                         <td><?php echo strtoupper($student['campus']). " Campus"; ?></td>
                                         <td><?php echo ($student['remarks']=="")?"Need to follow up":$student['remarks']; ?></td>
                                         <td>
                                             <?php
                                             if($student['follow_up']==0)
                                             {
                                                 ?>
                                                 <a class="btn btn-default btn-xs" onclick="follow_up(<?=$student['main_id']?>);" data-target="#follow_up" data-toggle="modal" title="Follow Up Admission Enquiry">
                                                     <i class="fa fa-phone"></i>
                                                 </a>

                                                 <?php
                                             }
                                             ?>
                                             <a data-placement="left" href="#" class="btn btn-default btn-xs" data-toggle="tooltip" title="" onclick="delete_enquiry(<?=$student['main_id']?>)" data-original-title="Delete">
                                                 <i class="fa fa-remove"></i>
                                             </a>
                                         </td>


                                     </tr>
                                    <?php
                                }

                                ?>

                                </tbody>
                            </table><!-- /.table -->



                        </div><!-- /.mail-box-messages -->
                    </div><!-- /.box-body -->

                </div>
            </div><!--/.col (left) -->
            <!-- right column -->

        </div>

    </section><!-- /.content -->
</div><!-- /.content-wrapper -->
<div class="modal fade" id="follow_up" tabindex="-1" role="dialog" aria-labelledby="follow_up">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content modal-media-content">
            <div class="modal-header modal-media-header">
                <button type="button" class="close" onclick="update()" data-dismiss="modal">&times;</button>
                <h4 class="box-title"><?php echo $this->lang->line('follow_up_admission_enquiry'); ?></h4>
            </div>
            <form method="post" action="<?=base_url('admin/Onlinestudent/followUp')?>">


            <div class="modal-body pt0 " >
                <div class="form-group">
<!--                    <label for="">Remarks:</label>-->
                    <textarea class="form-control" rows="10"  name="remarks" placeholder="Remarks" ></textarea>

                </div>
                <div class="form-group  ">
                    <input type="hidden" id="request_id" name="request_id">
                     <button class="btn btn-info float-right" type="submit">Follow up</button>

                </div>
            </div>
            </form>
        </div>
    </div>
</div>


<script>
    function follow_up(id) {
        $("#request_id").val(id);
    }
    function delete_enquiry(id) {

        if (confirm('<?php echo $this->lang->line('delete_confirm') ?>')) {
            $.ajax({
                url: '<?php echo base_url(); ?>admin/Onlinestudent/deleteRequest/' + id,
                type: 'POST',
                dataType: 'json',

                success: function (data) {
                    if (data.status == "fail") {

                        var message = "";
                        $.each(data.error, function (index, value) {

                            message += value;
                        });
                        errorMsg(message);
                    } else {

                        successMsg(data.message);
                        window.location.reload(true);
                    }

                }
            })

        }

    }

</script>