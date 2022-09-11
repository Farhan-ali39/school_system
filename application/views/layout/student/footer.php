<style>
    .footer {
        position: fixed;
        left: 0;
        bottom: 0;
        width: 100%;
        background-color: white;
        color: cornflowerblue;
        height: 80px;
    }
    .circle-icon {
        background: #e3e2e2;
        padding:10px;
        border-radius: 50%;
    }

    #mydiv ul li a i:hover, i:active, i:focus
    {
        background-color: #0084B4;
        color: white;
    }
    .hideangle a i:hover, i:active, i:focus
    {
        background-color: transparent !important;
        color: #0084B4 !important;
    }


    .mt5
    {
        margin-left: 5px;
    }
    .mt10
    {
        margin-left: 10px;
    }
    .mt40
    {
        margin-left: 40px;
    }
    .mt30
    {
        margin-left: 30px;
    }
    .mt15
    {
        margin-left: 15px;
    }
    .float{
        z-index: 1;
        position:fixed;
        /*width:60px;*/
        /*height:60px;*/
        bottom: 0px;
        right: 5px;
        /*left: 12%;*/
        /*background-color:#0C9;*/
        color:#0084B4;
        /*border-radius:50px;*/
        text-align:center;
        /*box-shadow: 2px 2px 3px #999;*/
    }

    .my-float{
        margin-top:22px;
        font-size: 40px;
    }
</style>

<?php
if(isset($pageName))
{
    if($pageName=="dashboard")
    {
        ?>
        <style>
            .fixed_footer{

                display: block;
            }
        </style>
        <input type="hidden" id="footerDisplayVal" value="1">
        <?php
    }else{
        ?>
        <style>
            .fixed_footer{
                display: none;
            }
        </style>
        <input type="hidden" id="footerDisplayVal" value="0">
        <?php
    }
}
else{
    ?>
    <style>
        .fixed_footer{
            display: none;
        }
    </style>
    <input type="hidden" id="footerDisplayVal" value="0">
    <?php
}
?>

<!--<footer class="main-footer">-->
<!--    &copy;  --><?php //echo date('Y'); ?><!-- -->
<!--    --><?php //echo $this->customlib->getAppName(); ?><!-- --><?php //echo $this->customlib->getAppVersion(); ?>
<!--</footer>-->
<div class="control-sidebar-bg"></div>
</div>

 <a   class="float" onclick="footerDisp()" >
    <i class="fa fa-angle-double-up my-float"></i>
</a>
<div class="footer fixed_footer " id="mydiv"   style=" z-index: 1" align="center">
    <ul class="list-inline dropdown"  >
        <li class="list-inline-item   "> <a href="#" data-target="#smart_edu" data-toggle="modal" > <i class="fa fa-desktop fa-2x circle-icon  mt10"></i> <br> Smart Edu </a>  </li>
        <li class="list-inline-item   "> <a href="#" data-target="#microsoft" data-toggle="modal" > <i class="fa fa-cloud fa-2x circle-icon  mt10"></i> <br> Microsoft </a>  </li>
        <li class="list-inline-item   "> <a href="<?=base_url('user/user/FacebookProfile')?>" > <i class="fa fa-facebook-official fa-2x circle-icon  mt10"></i> <br> facebook </a>  </li>


        <?php

        if ($this->studentmodule_lib->hasActive('attendance')) {
            ?>
            <li class="list-inline-item   "> <a href="<?php echo base_url('user/attendence'); ?>"> <i class="fa fa-calendar-check-o fa-2x circle-icon mt10 "></i> <br> Attendance   </a>  </li>

            <?php
        }
        if ($this->studentmodule_lib->hasActive('examinations')) {
            ?>
            <li class="list-inline-item   "> <a href="<?=base_url('user/exam/examresult')?>"> <i class="fa fa-map-o ftlayer fa-2x circle-icon   "></i> <br>  <span class="mt5">Result</span>   </a>  </li>

            <?php
        }
        if ($this->studentmodule_lib->hasActive('download_center')) {
            ?>
            <li class="list-inline-item   "> <a href="<?=base_url('user/content/assignment')?>"> <i class="fa fa-file-o fa-2x circle-icon mt15"></i> <br> Assignment</a>  </li>

            <?php
        }
        if ($this->studentmodule_lib->hasActive('homework')) {
            ?>
            <li class="list-inline-item   "> <a href="<?=base_url('user/homework')?>"> <i class="fa fa-flask ftlayer fa-2x circle-icon mt15"></i> <br> Homework</a>  </li>

            <?php
        }
        if ($this->studentmodule_lib->hasActive('notice_board')) {
            ?>
            <li class="list-inline-item   "> <a href="<?=base_url('user/notification')?>"> <i class="fa fa-bullhorn fa-2x circle-icon"></i> <br> <span class="mt5">Notice</span> </a>  </li>

            <?php
        }

        if ($this->studentmodule_lib->hasActive('notice_board')) {
            ?>
            <li class="list-inline-item   "> <a href="<?=base_url('user/notification')?>" > <i class="fa fa-comment-o fa-2x circle-icon mt5"></i> <br>Complain</a>  </li>

            <?php
        }
        ?>
        <li  class="list-inline-item  hideangle " style="float: right;padding-right: 20px;">
            <a onclick="footerDisp()"  class="d-flex">
                <i class="fa fa-angle-double-down fa-3x"> </i>
            </a>
        </li>
    </ul>
</div>


<script>
    $.widget.bridge('uibutton', $.ui.button);
</script>

<link href="<?php echo base_url(); ?>backend/toast-alert/toastr.css" rel="stylesheet"/>
<script src="<?php echo base_url(); ?>backend/toast-alert/toastr.js"></script>

<script src="<?php echo base_url(); ?>backend/bootstrap/js/bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>backend/dist/js/raphael-min.js"></script>
<script src="<?php echo base_url(); ?>backend/plugins/morris/morris.min.js"></script>
<script src="<?php echo base_url(); ?>backend/plugins/sparkline/jquery.sparkline.min.js"></script>
<script src="<?php echo base_url(); ?>backend/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="<?php echo base_url(); ?>backend/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<script src="<?php echo base_url(); ?>backend/plugins/knob/jquery.knob.js"></script>
<script src="<?php echo base_url(); ?>backend/plugins/daterangepicker/daterangepicker.js"></script>
<script src="<?php echo base_url(); ?>backend/plugins/datepicker/bootstrap-datepicker.js"></script>
<script src="<?php echo base_url(); ?>backend/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<script src="<?php echo base_url(); ?>backend/plugins/slimScroll/jquery.slimscroll.min.js"></script>
<script src="<?php echo base_url(); ?>backend/plugins/fastclick/fastclick.min.js"></script>

<!--language js-->
<script type="text/javascript" src="<?php echo base_url(); ?>backend/dist/js/bootstrap-select.min.js"></script>

 <script type="text/javascript">
    $(function(){
      $('.languageselectpicker').selectpicker();
   });
</script>

<script src="<?php echo base_url(); ?>backend/dist/js/app.min.js"></script>
<!--nprogress-->
<script src="<?php echo base_url(); ?>backend/dist/js/nprogress.js"></script>
<!--file dropify-->
<script src="<?php echo base_url(); ?>backend/dist/js/dropify.min.js"></script>
<script src="<?php echo base_url(); ?>backend/dist/js/demo.js"></script>

<!--print table-->
<!--print table-->
<script type="text/javascript" src="<?php echo base_url(); ?>backend/dist/datatables/js/jquery.dataTables.min-stu.par.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>backend/dist/datatables/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>backend/dist/datatables/js/jszip.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>backend/dist/datatables/js/pdfmake.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>backend/dist/datatables/js/vfs_fonts.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>backend/dist/datatables/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>backend/dist/datatables/js/buttons.print.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>backend/dist/datatables/js/buttons.colVis.min.js" ></script>
<script type="text/javascript" src="<?php echo base_url(); ?>backend/dist/datatables/js/dataTables.responsive.min.js" ></script>

<script type="text/javascript" src="<?php echo base_url(); ?>backend/dist/datatables/js/ss.custom.js" ></script>
</body>
</html>


<!-- Modal -->
<div id="classSwitchModal" class="modal fade" role="dialog" data-backdrop="static">
    <div class="modal-dialog">
        <form action="<?php echo site_url('common/getStudentClass') ?>" method="POST" id="frmclschg">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"><?php echo $this->lang->line('switch')." ".$this->lang->line('class');?></h4>
                </div>
                <div class="modal-body classSwitchbody">

                </div>
                <div class="modal-footer">
                    
                    <button type="submit" class="btn btn-primary" data-loading-text="<i class='fa fa-spinner fa-spin '></i> Please wait"><?php echo $this->lang->line('update');?></button>
                </div>
            </div>

        </form>
    </div>
</div>


<script type="text/javascript">
    function openMicrosoftTeam() {
        myWindow = window.open("https://teams.microsoft.com/", "myWindow", "width=1000,height=700");
    }
    function openOutlook() {
        myWindow = window.open("https://outlook.office365.com/", "myWindow", "width=1000,height=700");
    }
    function openExcel() {
        myWindow = window.open("https://www.office.com/launch/excel?auth=2", "myWindow", "width=1000,height=700");
    }
    function openPowerpoint() {
        myWindow = window.open("https://www.office.com/launch/powerpoint?auth=2", "myWindow", "width=1000,height=700");
    }
    function openWord() {
        myWindow = window.open("https://www.office.com/launch/word", "myWindow", "width=1000,height=700");
    }

    function openNoteBook() {
        myWindow = window.open("https://www.onenote.com/classnotebook/signin?omkt=en-US", "myWindow", "width=1000,height=700");
    }

    function footerDisp() {
        var val=parseInt($('#footerDisplayVal').val());
        if(val==1)
        {
            $('#mydiv').css('display','none');
            $('#footerDisplayVal').val(0);
        }else {
            $('#mydiv').css('display','block');
            $('#footerDisplayVal').val(1);
        }

    }

    $("#frmclschg").on('submit', (function (e) {
        e.preventDefault();

         var form = $(this);
        var $this = $(this).find("button[type=submit]:focus");
        $.ajax({
            url: form.attr('action'),
            type: "POST",
            data: form.serialize(), // serializes the form's elements.
            dataType: 'json',
          
            beforeSend: function () {
                $this.button('loading');

            },
            success: function (res)
            {
                    if (res.status) {

                     
                        successMsg(res.message);

                           window.location.href = baseurl + "user/user/dashboard";

                    } else {

                        errorMsg(res.message);

                    }
            },
            error: function (xhr) { // if error occured
                alert("Error occured.please try again");
                $this.button('reset');
            },
            complete: function () {
                $this.button('reset');
            }

        });
    }));



    $(document).on('change', '.clschg', function () {
        if ($(this).is(":checked")) {

            $('input.clschg').not(this).prop('checked', false);
        } else {
            $(this).prop("checked", true);
        }

    });

    $('#classSwitchModal').on('show.bs.modal', function (event) {
        var $modalDiv = $(event.delegateTarget);
        $('.classSwitchbody').html("");
        $.ajax({
            type: "POST",
            url: baseurl + "common/getStudentSessionClasses",
            dataType: 'JSON',
            data: {},
            beforeSend: function () {
                $modalDiv.addClass('modal_loading');
            },
            success: function (data) {
                $('.classSwitchbody').html(data.page);
            },
            error: function (xhr) { // if error occured
                $modalDiv.removeClass('modal_loading');
            },
            complete: function () {
                $modalDiv.removeClass('modal_loading');
            },
        });
    });
</script>

<script type="text/javascript">
    $(document).ready(function () {
        if (window.matchMedia('(max-width: 768px)').matches)
        {
            $('#footerDisplayVal').val(0);
            // do functionality on screens smaller than 768px
        }
<?php
if ($this->session->flashdata('success_msg')) {
    ?>
            successMsg("<?php echo $this->session->flashdata('success_msg'); ?>");
    <?php
} else if ($this->session->flashdata('error_msg')) {
    ?>
            errorMsg("<?php echo $this->session->flashdata('error_msg'); ?>");
    <?php
} else if ($this->session->flashdata('warning_msg')) {
    ?>
            infoMsg("<?php echo $this->session->flashdata('warning_msg'); ?>");
    <?php
} else if ($this->session->flashdata('info_msg')) {
    ?>
            warningMsg("<?php echo $this->session->flashdata('info_msg'); ?>");
    <?php
}
?>
    });
</script>



<script type="text/javascript">


    function complete_event(id, status) {

        $.ajax({
            url: "<?php echo site_url("user/calendar/markcomplete/") ?>" + id,
            type: "POST",
            data: {id: id, active: status},
            dataType: 'json',

            success: function (res)
            {

                if (res.status == "fail") {

                    var message = "";
                    $.each(res.error, function (index, value) {

                        message += value;
                    });
                    errorMsg(message);

                } else {

                    successMsg(res.message);

                    window.location.reload(true);
                }

            }

        });
    }

    function markc(id) {

        $('#newcheck' + id).change(function () {

            if (this.checked) {

                complete_event(id, 'yes');
            } else {

                complete_event(id, 'no');
            }

        });
    }

</script>


<!-- Button trigger modal -->
<!-- Modal -->

<div class="modal fade" id="user_sessionModal" tabindex="-1" role="dialog" aria-labelledby="sessionModalLabel">
    <form action="#" id="form_modal_usersession" class="form-horizontal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="sessionModalLabel"><?php echo $this->lang->line('session'); ?></h4>
                </div>
                <div class="modal-body user_sessionmodal_body pb0">

                </div>
                <div class="modal-footer">

                    <button type="button" class="btn btn-primary submit_usersession" data-loading-text="<i class='fa fa-spinner fa-spin '></i> Please wait.."><?php echo $this->lang->line('save'); ?></button>
                </div>
            </div>
        </div>
    </form>
</div>

