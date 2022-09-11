<style type="text/css">
    @media print
    {
        .no-print, .no-print *
        {
            display: none !important;
        }
    }
</style>

<div class="content-wrapper" style="min-height: 946px;"> 
    <section class="content-header">
        <h1>
            <i class="fa fa-mortar-board"></i> <?php echo $this->lang->line('academics'); ?></h1>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">  
            <?php
            if ($this->rbac->hasPrivilege('subject', 'can_add') || $this->rbac->hasPrivilege('subject', 'can_edit')) {
                ?>         
                <div class="col-md-4">            
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title"><?php echo $this->lang->line('edit_subject'); ?></h3>
                        </div>
                        <form action="<?php echo site_url("admin/subject/edit/" . $id) ?>"  id="employeeform" name="employeeform" method="post" accept-charset="utf-8">
                            <div class="box-body">
                                <?php if ($this->session->flashdata('msg')) { ?>
                                    <?php echo $this->session->flashdata('msg') ?>
                                <?php } ?>   
                                <?php echo $this->customlib->getCSRF(); ?>
                                <div class="form-group">
                                    <label for="exampleInputEmail1"><?php echo $this->lang->line('subject_name'); ?></label> <small class="req"> *</small>
                                    <input autofocus="" id="category" name="name" placeholder="" type="text" class="form-control"  value="<?php echo set_value('name', $subject['name']); ?>" />
                                    <span class="text-danger"><?php echo form_error('name'); ?></span>
                                </div>
                                <?php
                                foreach ($subject_types as $subject_type_key => $subject_type_value) {
                                    ?>

                                    <label class="radio-inline">
                                        <input type="radio" value="<?php echo $subject_type_key ?>" name="type" <?php echo set_radio('type', $subject_type_key, (set_value('type', $subject['type']) == $subject_type_key) ? TRUE : FALSE ); ?> ><?php echo $subject_type_value; ?> 
                                    </label>
                                    <?php
                                }
                                ?>
                                <br>
                                <label class="radio-inline">
                                    <input type="radio" value="2" name="school_type" onclick="btn_css()" <?php if($subject['school_id']==2){echo "checked";} ?>  > Primary & Secondary
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="school_type" onclick="btn_css()" <?php if($subject['school_id']==1){echo "checked";} ?> value="1"> Pre-Primary
                                </label>
                                <div class="form-group"><br>
                                    <label for="exampleInputEmail1"><?php echo $this->lang->line('subject_code'); ?></label>
                                    <input id="category" name="code" placeholder="" type="text" class="form-control"  value="<?php echo set_value('code', $subject['code']); ?>" />
                                    <span class="text-danger"><?php echo form_error('code'); ?></span>
                                </div>
                                <div class="box-tools pull-right">
                                    <button id="btnAdd" style="display: none"  class="btn btn-primary btn-sm checkbox-toggle pull-right" type="button"><i class="fa fa-plus"></i>Add Extra</button>
                                </div>

                                <div id="TextBoxContainer" role="form">
                                </div>
                            </div>
                            <div class="box-footer">
                                <input type="hidden" name="total_extra" id="total_extra">
                                <button type="submit" class="btn btn-info pull-right"><?php echo $this->lang->line('save'); ?></button>
                            </div>
                        </form>
                    </div>
                </div>
            <?php } ?>
            <div class="col-md-<?php
            if ($this->rbac->hasPrivilege('subject', 'can_add') || $this->rbac->hasPrivilege('subject', 'can_edit')) {
                echo "8";
            } else {
                echo "12";
            }
            ?>">            
                <div class="box box-primary" id="sublist">
                    <div class="box-header ptbnull">
                        <h3 class="box-title titlefix"><?php echo $this->lang->line('subject_list'); ?></h3>
                    </div>
                    <div class="box-body">
                        <div class="table-responsive mailbox-messages">
                            <div class="download_label"><?php echo $this->lang->line('subject_list'); ?></div>
                            <table class="table table-striped table-bordered table-hover example">
                                <thead>
                                    <tr>
                                        <th><?php echo $this->lang->line('subject'); ?></th>
                                        <th><?php echo $this->lang->line('subject_code'); ?></th>
                                        <th><?php echo $this->lang->line('subject'); ?>
                                            <?php echo $this->lang->line('type'); ?>
                                        </th>
                                        <th>
                                            <?php echo $this->lang->line('school'); ?>
                                        </th>
                                        <th>
                                            Extra Subjects
                                        </th>
                                        <th class="text-right no-print"><?php echo $this->lang->line('action'); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $count = 1;
                                    foreach ($subjectlist as $subject) {
                                        ?>
                                        <tr>
                                            <td class="mailbox-name"> <?php echo $subject['name'] ?></td>
                                            <td class="mailbox-name"><?php echo $subject['code'] ?></td>
                                            <td class="mailbox-name"><?php echo ucfirst($subject['type']) ?></td>
                                            <td class="mailbox-name"><?php echo ($subject['school_id']== 2) ? "Primary & Secondary" : "Pre-Primary";  ?></td>
                                            <td class="mailbox-name">
                                                <?php
                                                if(isset($subject['extra_assessment']))
                                                {
                                                    $decoded=json_decode($subject['extra_assessment']);
                                                    $index=1;
                                                    foreach ($decoded as $value)
                                                    {
                                                        echo $index.":".$value."<br>";
                                                        $index++;
                                                    }
                                                }
                                                ?>
                                            </td>
                                            <td class="mailbox-date pull-right no-print">
                                                <?php
                                                if ($this->rbac->hasPrivilege('subject', 'can_edit')) {
                                                    ?>
                                                    <a data-placement="left" href="<?php echo base_url(); ?>admin/subject/edit/<?php echo $subject['id'] ?>" class="btn btn-default btn-xs"  data-toggle="tooltip" title="<?php echo $this->lang->line('edit'); ?>">
                                                        <i class="fa fa-pencil"></i>
                                                    </a>
                                                    <?php
                                                }
                                                if ($this->rbac->hasPrivilege('subject', 'can_delete')) {
                                                    ?>
                                                    <a data-placement="left" href="<?php echo base_url(); ?>admin/subject/delete/<?php echo $subject['id'] ?>"class="btn btn-default btn-xs"  data-toggle="tooltip" title="<?php echo $this->lang->line('delete'); ?>" onclick="return confirm('<?php echo $this->lang->line('delete_confirm') ?>');">
                                                        <i class="fa fa-remove"></i>
                                                    </a>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                    $count++;
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div> 

        </div>
    </section>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $("#btnreset").click(function () {
            $("#form1")[0].reset();
        });
        var school_type= $("input[name='school_type']:checked"). val();
        if(school_type==1)
        {
            $("#btnAdd").css('display','block');

        }
        $(document).on("click", "#btnAdd", function () {
            var lenght_div = $('#TextBoxContainer .app').length;

            $("#total_extra").val(lenght_div+1);
            var div = GetDynamicTextBox(lenght_div);
            $("#TextBoxContainer").append(div);
        });
        $(document).on('click', '#btnRemove', function () {
            $(this).parents('.form-group').remove();
            var total= $("#total_extra").val();
            $("#total_extra").val(total-1);

        });
    });
</script>

<script type="text/javascript">
    var base_url = '<?php echo base_url() ?>';
    function printDiv(elem) {
        Popup(jQuery(elem).html());
    }

    function Popup(data) {
        var mywindow = window.open('', 'my div', 'height=400,width=600');
        mywindow.document.write('<html><head><title></title>');
        mywindow.document.write('<link rel="stylesheet" href="' + base_url + 'backend/bootstrap/css/bootstrap.min.css">');
        mywindow.document.write('<link rel="stylesheet" href="' + base_url + 'backend/dist/css/font-awesome.min.css">');
        mywindow.document.write('<link rel="stylesheet" href="' + base_url + 'backend/dist/css/ionicons.min.css">');
        mywindow.document.write('<link rel="stylesheet" href="' + base_url + 'backend/dist/css/AdminLTE.min.css">');
        mywindow.document.write('<link rel="stylesheet" href="' + base_url + 'backend/dist/css/skins/_all-skins.min.css">');
        mywindow.document.write('<link rel="stylesheet" href="' + base_url + 'backend/plugins/iCheck/flat/blue.css">');
        mywindow.document.write('<link rel="stylesheet" href="' + base_url + 'backend/plugins/morris/morris.css">');
        mywindow.document.write('<link rel="stylesheet" href="' + base_url + 'backend/plugins/jvectormap/jquery-jvectormap-1.2.2.css">');
        mywindow.document.write('<link rel="stylesheet" href="' + base_url + 'backend/plugins/datepicker/datepicker3.css">');
        mywindow.document.write('<link rel="stylesheet" href="' + base_url + 'backend/plugins/daterangepicker/daterangepicker-bs3.css">');
        mywindow.document.write('<style type="text/css">.test { color:red; } </style></head><body>');
        mywindow.document.write(data);
        mywindow.document.write('</body></html>');
        mywindow.document.close();
        mywindow.print();
    }
    function btn_css() {
        var school_type= $("input[name='school_type']:checked"). val();
        if(school_type==1)
        {
            $("#btnAdd").css('display','block');

        }else if(school_type==2)
        {
            $("#btnAdd").css('display','none');
            $("#TextBoxContainer").html("");
            $("#total_extra").val("");



        }

    }
    function GetDynamicTextBox(value) {
        var row = "";
        row += '<div class="form-group app">';
        row += '<input type="text" name="extra_assessment_' + value + '" />';
        row += '<div class="col-md-2"><button id="btnRemove" style="" class="btn btn-sm btn-danger" type="button"><i class="fa fa-trash"></i></button></div>';
        row += '</div>';
        row += '</div>';

        return row;


    }
</script>