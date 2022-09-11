<div class="content-wrapper" style="min-height: 348px;">  
    <section class="content-header">
        <h1>
            <i class="fa fa-ioxhost"></i> <?php echo $this->lang->line('front_office'); ?></h1> 
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">

                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title"><i class="fa fa-search"></i> <?php echo $this->lang->line('select_criteria'); ?></h3>
                    </div>
                    <div class="col-md-12">
                        <?php echo $this->session->flashdata('msg') ?>
                    </div>
                    <form role="form" action="<?php echo site_url('admin/enquiry') ?>" method="post" class="">
                        <div class="box-body row">

                            <?php echo $this->customlib->getCSRF(); ?>

                            <div class="col-sm-4 col-md-4">
                                <div class="form-group">
                                    <label><?php echo $this->lang->line('enquiry'); ?> <?php echo $this->lang->line('date'); ?></label>
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        <input type="text" autocomplete="off" name="enquiry_date" class="form-control pull-right date" id="enquiry_date">
                                    </div>
                                                      <!-- <input type="text" class="form-control" autocomplete="off"  name="enquiry_date" id="enquiry_date">
                                    -->  <span class="text-danger"><?php echo form_error('enquiry_date'); ?></span>
                                </div>
                            </div> 

                            <div class="col-sm-4 col-md-4">
                                <div class="form-group">  
                                    <label><?php echo $this->lang->line('source'); ?></label>
                                    <select  id="source" name="source" class="form-control" >
                                        <option value=""><?php echo $this->lang->line('select') ?></option>

                                        <?php foreach ($sourcelist as $key => $value) { ?>
                                            <option <?php
                                            if ($value["source"] == $source_select) {
                                                echo "selected";
                                            }
                                            ?> value="<?php echo $value["source"] ?>"><?php echo $value["source"] ?></option>
<?php } ?>
                                    </select>
                                    <span class="text-danger"><?php echo form_error('source'); ?></span>
                                </div>  
                            </div>
                            <div class="col-sm-4 col-md-4">
                                <div class="form-group">  
                                    <label><?php echo $this->lang->line('status'); ?></label>
                                    <select  id="status" name="status" class="form-control" >
                                        <option value=""><?php echo $this->lang->line('select') ?></option>
                                        <option value="all" <?php
                                                if ($status == "all") {
                                                    echo "selected";
                                                }
                                                ?>><?php echo $this->lang->line('all') ?></option>
                                            <?php foreach ($enquiry_status as $enkey => $envalue) {
                                                ?>
                                            <option <?php
                                                if ($enkey == $status) {
                                                    echo "selected";
                                                }
                                                ?> value="<?php echo $enkey ?>"><?php echo $envalue ?></option>

<?php } ?>
                                    </select>
                                    <span class="text-danger"><?php echo form_error('status'); ?></span>
                                </div>  
                            </div>

                            <div class="form-group">
                                <div class="col-sm-12">
                                    <button type="submit" name="search" value="search_filter" class="btn btn-primary btn-sm checkbox-toggle pull-right"><i class="fa fa-search"></i> <?php echo $this->lang->line('search'); ?></button>
                                </div>
                            </div>
                       </div>     
                    </form>
                    <div class="row ">
                        <div class=" col-md-7">

                        </div>

                        <div class="col-sm-4 col-md-4" style="left: 100px;">
                            <form action="<?=base_url('admin/enquiry/searchByVoucher')?>" method="post">
                            <div class="form-group">
<!--                                <label>--><?php //echo $this->lang->line('status'); ?><!--</label>-->
                                <input type="text"  name="voucher_no" class="form-control pull-right" placeholder="Voucher Number" id="voucher_no">
                                <span class="text-danger"><?php echo form_error('voucher_no'); ?></span>
                            </div>
                            <div style="padding-top: 35px" >
                                <div class="col-sm-12">
                                    <button type="submit" name="search" value="search_by_voucher" class="btn btn-primary btn-sm checkbox-toggle pull-right "><i class="fa fa-search"></i> <?php echo $this->lang->line('search'); ?></button>
                                </div>
                            </div>
                            </form>
                        </div>

                    </div>
            <div class="ptt10">

                <div class="bordertop">
                    <div class="box-header with-border">
                        <h3 class="box-title titlefix"> <?php echo $this->lang->line('admission_enquiry'); ?></h3>
                        <div class="box-tools pull-right">
<?php if ($this->rbac->hasPrivilege('admission_enquiry', 'can_add')) { ?>
                                <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus"></i> <?php echo $this->lang->line('add'); ?></button> 
<?php } ?>      
                        </div><!-- /.box-tools -->
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <div class="download_label"><?php echo $this->lang->line('admission_enquiry'); ?> <?php echo $this->lang->line('list'); ?></div>
                        <div class="mailbox-messages">
                          <div class="table-responsive">  
                            <table class="table table-hover table-striped table-bordered" id="enquirytable">
                                <thead>
                                    <tr>

                                        <th><?php echo $this->lang->line('name'); ?>
                                        </th>
                                        <th><?php echo $this->lang->line('phone'); ?>
                                        </th>
                                        <th><?php echo $this->lang->line('source'); ?>
                                        </th>

                                        <th><?php echo $this->lang->line('enquiry'); ?> <?php echo $this->lang->line('date'); ?></th>
                                        <th><?php echo $this->lang->line('last_follow_up_date'); ?></th>
                                        <th><?php echo $this->lang->line('next_follow_up_date'); ?>
                                        </th>
                                        <th><?php echo $this->lang->line('status'); ?>
                                        </th>
                                        <th class="text-right"><?php echo $this->lang->line('action'); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    //echo "<pre>"; print_r($enquiry_list); echo "<pre>";die;
                                    if (empty($enquiry_list)) {
                                        ?>
                                        <?php
                                    } else {
                                        foreach ($enquiry_list as $key => $value) {
                                            $current_date = date("Y-m-d");
                                            $next_date = $value["next_date"];
                                            if (empty($next_date)) {

                                                $next_date = $value["follow_up_date"];
                                            }

                                            if ($next_date < $current_date) {
                                                $class = "class='danger'";
                                            } else {
                                                $class = "";
                                            }
                                            ?>
                                            <tr <?php echo $class ?>>

                                                <td class="mailbox-name"><?php echo $value['name']; ?></td>
                                                <td class="mailbox-name"><?php echo $value['contact']; ?> </td>
                                                <td class="mailbox-name"><?php echo $value['source']; ?></td>

                                                <td class="mailbox-name"> <?php
                                            if (!empty($value["date"])) {
                                                echo date($this->customlib->getSchoolDateFormat(), $this->customlib->dateyyyymmddTodateformat($value['date']));
                                            }
                                            ?></td>

                                                <td class="mailbox-name"> <?php
                                                    if (!empty($value["followupdate"])) {
                                                        echo date($this->customlib->getSchoolDateFormat(), $this->customlib->dateyyyymmddTodateformat($value['followupdate']));
                                                    }
                                                    ?></td>
                                                <td class="mailbox-name"> <?php
                                                    if (!empty($next_date)) {
                                                        echo date($this->customlib->getSchoolDateFormat(), $this->customlib->dateyyyymmddTodateformat($next_date));
                                                    }
                                                    ?></td>

                                                <td> <?php echo $enquiry_status[$value["status"]] ?></td>              
                                                <td class="mailbox-date text-right">
        <?php if ($this->rbac->hasPrivilege('follow_up_admission_enquiry', 'can_view')) { ?>
                                                        <a class="btn btn-default btn-xs" onclick="follow_up('<?php echo $value['id']; ?>','<?php echo $value['status']; ?>');"  data-target="#follow_up" data-toggle="modal"  title="<?php echo $this->lang->line('follow_up_admission_enquiry'); ?>">
                                                            <i class="fa fa-phone"></i>
                                                        </a>
                                                    <?php }
                                                    ?>
        <?php if ($this->rbac->hasPrivilege('admission_enquiry', 'can_edit')) { ?>
                                                        <a  onclick="getRecord('<?php echo $value['id']; ?>','<?php echo $value['status']; ?>')" class="btn btn-default btn-xs" data-target="#myModaledit" data-toggle="modal"   title="<?php echo $this->lang->line('edit'); ?>"><i class="fa fa-pencil"></i>
                                                        </a> 
                                            <?php }
                                            ?><?php if ($this->rbac->hasPrivilege('admission_enquiry', 'can_edit')) {

                                                if($value['feestatus']==0)
                                                {
                                                    ?>
                                                    <a  onclick="generateFee('<?php echo $value['id']; ?>')" class="btn btn-default btn-xs" data-target="#genrateFeeModal" data-toggle="modal"   title="Print Voucher"><i class="fa fa-print"></i>
                                                    </a>

                                                    <?php
                                                }elseif($value['feestatus']==1)
                                                {
                                                    ?>
                                                    <a   href="<?=base_url('studentfee/generateFeeVoucher/').$value['feeDetailId']?>" class="btn btn-default btn-xs"    title="Print Voucher"><i class="fa fa-print"></i>
                                                    </a>

                                                    <?php
                                                }

                                                ?>
                                            <?php }
                                            ?>
                                            <?php if ($this->rbac->hasPrivilege('admission_enquiry', 'can_delete')) { ?>
                                                        <a data-placement="left" href="#" class="btn btn-default btn-xs" data-toggle="tooltip" title="" onclick="delete_enquiry('<?php echo $value["id"] ?>')" data-original-title="<?php echo $this->lang->line('delete'); ?>">
                                                            <i class="fa fa-remove"></i>
                                                        </a>
        <?php }
        ?>

                                                </td>


                                            </tr>
        <?php
    }
}
?>
                                </tbody>
                            </table><!-- /.table -->
                          </div>  
                        </div><!-- /.mail-box-messages -->
                    </div><!-- /.box-body -->
                </div>
            </div>
          </div>  
        </div>

    </section>
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content modal-media-content">
                <div class="modal-header modal-media-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="box-title"> <?php echo $this->lang->line('admission_enquiry'); ?></h4> 
                </div>

                <div class="modal-body pt0 pb0">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <form id="formadd" method="post" class="ptt10">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="pwd"><?php echo $this->lang->line('name'); ?></label><small class="req"> *</small>  
                                            <input type="text" id="name_add" autocomplete="off" class="form-control" value="<?php echo set_value('name'); ?>" name="name">
                                            <span id="name_add_error" class="text-danger"></span>
                                        </div>

                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="pwd"><?php echo $this->lang->line('phone'); ?></label><small class="req"> *</small> 
                                            <input id="number" autocomplete="off" name="contact" placeholder="" type="text" class="form-control"  value="<?php echo set_value('contact'); ?>" />

                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label><?php echo $this->lang->line('email'); ?></label>
                                            <input type="text" value="<?php echo set_value('email'); ?>" name="email" class="form-control">
                                        </div>
                                    </div>   
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="email"><?php echo $this->lang->line('address'); ?></label> 
                                            <textarea name="address" class="form-control" ><?php echo set_value('address'); ?></textarea>
                                        </div> 
                                    </div>

                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="email"><?php echo $this->lang->line('description'); ?></label>
                                            <textarea name="description" class="form-control" ><?php echo set_value('description'); ?></textarea>
                                        </div>
                                    </div>


                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="pwd"><?php echo $this->lang->line('note'); ?></label> 
                                            <textarea name="note" class="form-control" ><?php echo set_value('note'); ?></textarea>
                                        </div>
                                    </div>


                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="pwd"><?php echo $this->lang->line('date'); ?></label>
                                            <input type="text" id="date" name="date" class="form-control date" value="<?php echo set_value('date', date($this->customlib->getSchoolDateFormat())); ?>" readonly="">
                                            <span id="date_add_error" class="text-danger"></span>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="pwd"><?php echo $this->lang->line('next_follow_up_date'); ?></label>
                                            <input type="text" id="date_of_call" name="follow_up_date"class="form-control date" value="<?php echo set_value('follow_up_date', date($this->customlib->getSchoolDateFormat())); ?>" readonly="">
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label><?php echo $this->lang->line('assigned'); ?></label>
                                            <input type="text" value="<?php echo set_value('assigned'); ?>" name="assigned" class="form-control">
                                        </div><!--./form-group-->
                                    </div>



                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="pwd"><?php echo $this->lang->line('reference'); ?></label>   
                                            <select name="reference" class="form-control">
                                                <option value=""><?php echo $this->lang->line('select') ?></option>  
                                                <?php foreach ($Reference as $key => $value) { ?>
                                                    <option value="<?php echo $value['reference']; ?>" <?php if (set_value('reference') == $value['reference']) { ?>selected=""<?php } ?>><?php echo $value['reference']; ?></option>    
                                                <?php }
                                                ?>
                                            </select>
                                        </div><!--./form-group-->
                                    </div>
                                    <div class="col-sm-3">    
                                        <div class="form-group">
                                            <label for="pwd"><?php echo $this->lang->line('source'); ?></label> <small class="req"> *</small> 
                                            <select name="source" class="form-control">
                                                <option value=""><?php echo $this->lang->line('select') ?></option>  
                                                <?php foreach ($sourcelist as $key => $value) { ?>
                                                    <option value="<?php echo $value['source']; ?>"><?php echo $value['source']; ?></option>
                                                <?php }
                                                ?> 
                                            </select>
                                        </div><!--./form-group-->
                                    </div>    

                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="pwd"><?php echo $this->lang->line('class'); ?></label> 
                                            <select name="class" class="form-control"  >
                                                <option value=""><?php echo $this->lang->line('select') ?></option>
<?php
foreach ($class_list as $key => $value) {
    ?>
                                                    <option value="<?php echo $value['id'] ?>" <?php if (set_value('class') == $value['id']) { ?> selected="" <?php } ?>><?php echo $value['class'] ?></option>
    <?php
}
?>
                                            </select>                                            
                                        </div><!--./form-group-->
                                    </div>    

                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="pwd"><?php echo $this->lang->line('number_of_child'); ?></label> 
                                            <input type="number" class="form-control" min="1" value="<?php echo set_value('no_of_child'); ?>" name="no_of_child">
                                        </div><!--./form-group--> 
                                    </div>    
                                </div><!--./row-->    
                            </form>                       
                        </div><!--./col-md-12-->       

                    </div><!--./row--> 

                
                 <div class="row">    
                    <div class="box-footer col-md-12">

                        <a  onclick="saveEnquiry()" class="btn btn-info pull-right"><?php echo $this->lang->line('save'); ?></a>
                    </div>
                </div>
            </div>
            </div>
        </div>    
    </div>
    <div class="modal fade" id="myModaledit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content modal-media-content">
                <div class="modal-header modal-media-header">
                    <button type="button" class="close" data-dismiss="modal">×</button>
                    <h4 class="box-title"><?php echo $this->lang->line('edit_admission_enquiry'); ?></h4>

                </div>
                <div class="modal-body pt0 pb0" id="getdetails">
                    <div id="alert_message">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="follow_up" tabindex="-1" role="dialog" aria-labelledby="follow_up">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content modal-media-content">
                <div class="modal-header modal-media-header">
                    <button type="button" class="close" onclick="update()" data-dismiss="modal">&times;</button>
                    <h4 class="box-title"><?php echo $this->lang->line('follow_up_admission_enquiry'); ?></h4>
                </div>
                <div class="modal-body pt0 pb0" id="getdetails_follow_up">
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="genrateFeeModal" tabindex="-1" role="dialog" aria-labelledby="getFeeDatails">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content modal-media-content">
                <div class="modal-header modal-media-header">
                    <button type="button" class="close"   data-dismiss="modal" autocomplete="off">×</button>
                    <h4 class="pagetitleh2">Fee Detail's</h4>
                </div>
                <form action="<?=base_url('studentfee/generateFeeVoucher')?>" method="post">
                <div class="modal-body pt0 pb0"  >
                    <div class="around10">
                        <div class="row">
                            <div class="col-md-3">
<!--                                <div class="form-group">-->
<!--                                    <label for="exampleInputFile">Fee Case</label><small class="req"> *</small>-->
<!--                                    <select class="form-control" name="fee_case">-->
<!--                                        <option value="1">Monthly</option>-->
<!--                                        <option value="2">Bi-Monthly</option>-->
<!---->
<!--                                    </select>-->
<!--                                    <span class="text-danger">--><?php //echo form_error('fee_case'); ?><!--</span>-->
<!--                                </div>-->
                            </div>
                            <div class="col-md-3 col-xs-12">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Issue Date</label>

                                    <input type="text" id="issue_date" value="<?php echo set_value('issue_date', date($this->customlib->getSchoolDateFormat())); ?>" name="issue_date" class="form-control date">
                                    <span class="text-danger"><?php echo form_error('issue_date'); ?></span>
                                </div>
                            </div>
                            <div class="col-md-3 col-xs-12">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Due Date</label>

                                    <input type="text" id="due_date" value="<?php echo set_value('due_date', date($this->customlib->getSchoolDateFormat())); ?>" name="due_date" class="form-control date">
                                    <span class="text-danger"><?php echo form_error('due_date'); ?></span>
                                </div>
                            </div>
                            <div class="col-md-3 col-xs-12">
                                <!--                                        <div class="form-group">-->
                                <!--                                            <label for="exampleInputEmail1">Stuck Off Date</label>-->
                                <!---->
                                <!--                                            <input type="text" id="stuck_off_date" value="--><?php //echo set_value('stuck_off_date', date($this->customlib->getSchoolDateFormat())); ?><!--" name="stuck_off_date" class="form-control date">-->
                                <!--                                            <span class="text-danger">--><?php //echo form_error('stuck_off_date'); ?><!--</span>-->
                                <!--                                        </div>-->
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="exampleInputFile">Select Fee Type</label><small class="req"> *</small>
                                    <br>
                                    <?php
                                    if(!empty($feeTypeList))
                                    {

                                        foreach ($feeTypeList as $value)
                                        {
                                            ?>

                                            <div id="mainFeeID<?=$value['id']?>" style="margin-top: 0px">
                                                <input onclick="countTotalFee('<?=$value['id']?>')" class="checked_feeType" id="feeTypeCheckBox<?=$value['id']?>"  type="checkbox" name="feeType[]" value="<?=$value['id']?>">
                                                <label style="    width: 130px;" for="exampleInputFile"><?=ucfirst($value['type'])?><small class="req"> *</small></label>

                                                <input readonly type="number" id="feeamount<?=$value['id']?>" name="feeamount<?=$value['id']?>" placeholder="" class="form-control" style="width: 50%;display: inline"   value="<?=$value['amount']?>" >
                                            </div>
                                            <br>
                                            <?php
                                        }
                                    }
                                    ?>
                                    <span class="text-danger"><?php echo form_error('fee_case'); ?></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="exampleInputFile">Discount</label>
                                    <label for="exampleInputFile" style="margin-left: 40%">Balance</label>
                                    <br>

                                    <?php
                                    if(!empty($feeTypeList))
                                    {
                                        $count=0;

                                        $flag=true;
                                        $marginValue=11;
                                        foreach ($feeTypeList as $value)
                                        {
                                            $count++;

                                            if($flag!=true)
                                            {
                                                $style="margin-top:".$marginValue.'px';
                                                $marginValue--;
                                            }
                                            $flag=false;

                                            ?>
                                            <select class="form-control" onchange="discountType('<?=$value['id']?>')" name="dicsType<?=$value['id']?>" id="dicsType<?=$value['id']?>" style="display: initial;width: 49%;<?=$style?>">
                                                <option value="">Select Discount Type</option>
                                                <option value="custom">Special DISC (PKR)</option>
                                                <option value="sibling">Sibling DISC (%)</option>
                                                <!--                                                    <div>-->
                                                <!--                                                         <input   type="text" id="feedisocunt--><?//=$value['id']?><!--" name="feedisocunt--><?//=$value['id']?><!--" placeholder="" class="form-control" style="width: 50%;display: inline"   value="--><?php //echo set_value('feedisocunt', 0); ?><!--" >-->
                                                <!--                                                     </div>-->
                                            </select>
                                            <!--                                                    <label   for="exampleInputFile" id="balanceLabel--><?//=$value['id']?><!--" style="display: inline-block">Balance </label>-->
                                            <input   type="text"   id="balance<?=$value['id']?>" name="balance<?=$value['id']?>" placeholder="" class="form-control" style="width: 25%;display: inline-block;margin-bottom: 10px;"   value="<?php echo set_value('balance', 0); ?>" >

                                            <input   type="number" step="0.01"  min="0"   onkeyup="calcDiscount(<?=$value['id']?>)" id="discountRate<?=$value['id']?>" name="discountRate<?=$value['id']?>" placeholder="" class="form-control" style="width: 50%;display: none;margin-bottom: 10px;"   value="<?php echo set_value('discountRate', 0); ?>" >

                                            <!--                                                    <label   for="exampleInputFile" id="balanceLabel--><?//=$value['id']?><!--" style="display: none">Balance </label>-->
                                            <!--                                                    <input   type="text"   id="balance--><?//=$value['id']?><!--" name="balance--><?//=$value['id']?><!--" placeholder="" class="form-control" style="width: 50%;display: none;margin-bottom: 10px;"   value="--><?php //echo set_value('balance', 0); ?><!--" >-->

                                            <br>
                                            <?php
                                        }
                                        ?>
                                        <input type="hidden" id="totalCount" value="<?=$count?>">
                                        <?php
                                    }
                                    ?>

                                </div>
                            </div>

                            <div class="col-md-12">

                            </div>
                            <div class="col-md-3"  >
                                <div class="form-group" style="display: none;">
                                    <label for="exampleInputEmail1"><?php echo $this->lang->line('fees_discount'); ?></label>
                                    <input   name="fees_discount" placeholder="" type="text" class="form-control"  value="<?php echo set_value('fees_discount', 0); ?>"  />
                                    <span class="text-danger"><?php echo form_error('fees_discount'); ?></span>
                                </div>
                            </div>
                            <br>
                            <div class="col-md-3">

                            </div>
                            <div class="col-md-3"  >
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Total Fee</label>
                                    <input readonly id="total_fee"  name="total_fee" placeholder="" type="text" class="form-control"  value="<?php echo set_value('total_fee', 0); ?>"  />
                                    <span class="text-danger"><?php echo form_error('total_fee'); ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="box-footer">
                        <input type="hidden" id="enquiryID" name="enquiryID">
                         <button type="submit" value="generate" name="btn_save" class="btn btn-info pull-right" style="margin-right: 10px">Generate Voucher</button>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        // $('#enquiry_date').daterangepicker();
        var date_format = '<?php echo $result = strtr($this->customlib->getSchoolDateFormat(), ['d' => 'dd', 'm' => 'mm', 'Y' => 'yyyy',]) ?>';

       

        $('#enquiry_date').daterangepicker({
            autoUpdateInput: false,
            format: date_format,
            autoclose: true,
            locale: {
                cancelLabel: 'Clear'
            }
        });

        $('#enquiry_date').on('apply.daterangepicker', function (ev, picker) {
            $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
        });

        $('#enquiry_date').on('cancel.daterangepicker', function (ev, picker) {
            $(this).val('');
        });

        $('#genrateFeeModal').on('show.bs.modal', function (e) {

        });

    });

    function discountType(index) {

        var dicsType=  $('#dicsType'+index).val();
        if(dicsType=="custom")
        {

            $('#mainFeeID'+index).css('margin-top','40px');
            $('#discountRate'+index).css('display','inline');
//          $('#balance'+index).css('display','block');
//          $('#balanceLabel'+index).css('display','block');
        }else if(dicsType=="sibling")
        {
            $('#mainFeeID'+index).css('margin-top','40px');
            $('#discountRate'+index).css('display','inline');
//          $('#balance'+index).css('display','block');
//          $('#balanceLabel'+index).css('display','block');

        }else
        {
            $('#mainFeeID'+index).css('margin-top','0px');
            $('#discountRate'+index).css('display','none');
            $('#discountRate'+index).val(0)
//           $('#balance'+index).css('display','none');
//           $('#balanceLabel'+index).css('display','none');
        }

    }
    function calcDiscount(index) {


        if($("#feeTypeCheckBox"+index).prop('checked') == true)
        {
            var currentIndexValue= parseInt($('#feeamount'+index).val());
            var discountRatevalue=$('#discountRate'+index).val();
            var discountType=$('#dicsType'+index).val();
            if(discountRatevalue.length ===0)
            {
                discountRatevalue=0;
            }
            if(isNaN(currentIndexValue))
            {
                currentIndexValue=0;
            }
            if(discountType=="sibling")
            {
                var discountRate=parseFloat(parseFloat(discountRatevalue)/100);
                var discountPrice=parseFloat(currentIndexValue* discountRate);
                var discountedPrice=parseInt(currentIndexValue - discountPrice);
                $('#balance'+index).val(discountedPrice);

            }else if(discountType=="custom")
            {
                var discountedPrice=parseInt(currentIndexValue - discountRatevalue);
                $('#balance'+index).val(discountedPrice);

            }
            calculateTotalFee();
        }else
        {
            alert("Please Select a Fee Type First");
        }



    }
    function calculateTotalFee() {
        var totalfee=0;
        var inps = document.getElementsByName('feeType[]');
        for (var i = 0; i <inps.length; i++) {
            var inp=inps[i];
            var index= inp.value;
            var currentIndexValue= parseInt($('#balance'+index).val());
            totalfee=totalfee+currentIndexValue;
        }
        $('#total_fee').val(totalfee);
    }
    function countTotalFee(para1=null) {
        var totalfee=0;

        $.each($(".checked_feeType:checked"), function(){
            var index =  ($(this).val());
            var currentIndexFee=parseInt($('#feeamount'+index).val());
            totalfee=totalfee+currentIndexFee;
            $('#balance'+index).val(currentIndexFee);
        });
        $.each($(".checked_feeType:not(:checked)"), function(){
            var index =  ($(this).val());


            $('#balance'+index).val(0);
        });

//        var totalfee=parseInt(totalfee);
//        var discountRate=parseFloat( parseInt($('#fees_discount').val())/100);
//        var discountPrice=parseFloat(totalfee* discountRate);
//        var discountedPrice=parseInt(totalfee - discountPrice);
////        $('#total_fee').val(discountedPrice);
//        var currentIndexFee= parseInt($('#feeamount'+para1).val());
//        $('#balance'+para1).val(currentIndexFee);
        calculateTotalFee();
        calcDiscount(para1);
//        $('#total_fee').val(totalfee);


    }
    function generateFee(enquiryID) {
        $('#enquiryID').val(enquiryID);
    }

    function getRecord(id,status) {
        $.ajax({
            url: '<?php echo base_url(); ?>admin/enquiry/details/' + id+'/'+status,
            success: function (result) {
                $('#getdetails').html(result);
            }
        });
    }
    function postRecord(id) {

        $.ajax({
            url: '<?php echo base_url(); ?>admin/enquiry/editpost/' + id,
            type: 'POST',
            data: $("#myForm1").serialize(),
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
            },
            error: function () {
                alert("Fail")
            }
        });

    }

    function saveEnquiry() {


        $.ajax({
            url: '<?php echo base_url(); ?>admin/enquiry/add/',
            type: 'POST',
            dataType: 'json',
            data: $("#formadd").serialize(),
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

            },
            error: function () {
                alert("Fail")
            }
        });


    }


    function delete_enquiry(id) {

        if (confirm('<?php echo $this->lang->line('delete_confirm') ?>')) {
            $.ajax({
                url: '<?php echo base_url(); ?>admin/enquiry/delete/' + id,
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


    

function follow_up(id, status) {
         
            $.ajax({
                url: '<?php echo base_url(); ?>admin/enquiry/follow_up/' + id + '/' + status,
                success: function (data) {
                    $('#getdetails_follow_up').html(data);
                    $.ajax({
                        url: '<?php echo base_url(); ?>admin/enquiry/follow_up_list/' + id,
                        success: function (data) {
                            $('#timeline').html(data);
                        },
                        error: function () {
                            alert("Fail")
                        }
                    });
                },
                error: function () {
                    alert("Fail")
                }
            });
        }

    function update() {

        window.location.reload(true);
    }
</script>

<script type="text/javascript">
    $(document).ready(function () {


        $("#enquirytable").DataTable({
            searching: true,

            paging: true,
            bSort: true,
            info: false,
            dom: "Bfrtip",
            buttons: [

                {
                    extend: 'copyHtml5',
                    text: '<i class="fa fa-files-o"></i>',
                    titleAttr: 'Copy',
                    title: $('.download_label').html(),
                    exportOptions: {
                        columns: ':visible'
                    }
                },

                {
                    extend: 'excelHtml5',
                    text: '<i class="fa fa-file-excel-o"></i>',
                    titleAttr: 'Excel',

                    title: $('.download_label').html(),
                    exportOptions: {
                        columns: ':visible'
                    }
                },

                {
                    extend: 'csvHtml5',
                    text: '<i class="fa fa-file-text-o"></i>',
                    titleAttr: 'CSV',
                    title: $('.download_label').html(),
                    exportOptions: {
                        columns: ':visible'
                    }
                },

                {
                    extend: 'pdfHtml5',
                    text: '<i class="fa fa-file-pdf-o"></i>',
                    titleAttr: 'PDF',
                    title: $('.download_label').html(),
                    exportOptions: {
                        columns: ':visible'

                    }
                },

                {
                    extend: 'print',
                    text: '<i class="fa fa-print"></i>',
                    titleAttr: 'Print',
                    title: $('.download_label').html(),
                    customize: function (win) {
                        $(win.document.body)
                                .css('font-size', '10pt');

                        $(win.document.body).find('table')
                                .addClass('compact')
                                .css('font-size', 'inherit');
                    },
                    exportOptions: {
                        columns: ':visible'
                    }
                },

                {
                    extend: 'colvis',
                    text: '<i class="fa fa-columns"></i>',
                    titleAttr: 'Columns',
                    title: $('.download_label').html(),
                    postfixButtons: ['colvisRestore']
                },
            ]
        });
    });




</script>