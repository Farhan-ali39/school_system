<!doctype html>
<html lang="en">
<head>
     <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#424242" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admission Form</title>
    <script src="<?php echo base_url(); ?>backend/js/plugins/jquery-3.1.1.min.js"></script>
    <script src="<?php echo base_url(); ?>backend/js/plugins/bootstrap.min.js"></script>
<!--    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">-->
<!--    <script src="--><?php //echo base_url(); ?><!--backend/js/bootstrap.bundle.min.js"></script>-->
<!--    <link href="--><?php //echo base_url(); ?><!--backend/js/plugins/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">-->
<!--    <link href="--><?php //echo base_url(); ?><!--backend/js/plugins/assets/css/bootstrap_limitless.min.css" rel="stylesheet" type="text/css">-->
    <link href="<?php echo base_url(); ?>backend/js/plugins/assets/css/layout.min.css" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url(); ?>backend/js/plugins/assets/css/components.min.css" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url(); ?>backend/js/plugins/assets/css/colors.min.css" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url(); ?>backend/js/plugins/icomoon/styles.min.css" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url(); ?>backend/js/plugins/registration.css" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url(); ?>backend/js/plugins/awesome-bootstrap-checkbox.css" rel="stylesheet" type="text/css">
<!--    <link href="--><?php //echo base_url(); ?><!--backend/js/plugins/bootstrap.css" rel="stylesheet" type="text/css">-->
    <link href="<?php echo base_url(); ?>backend/js/plugins/bootstrap.css" rel="stylesheet" type="text/css">

<!--        <link rel="stylesheet" href="--><?php //echo base_url(); ?><!--backend/usertemplate/assets/bootstrap/css/bootstrap.min.css">-->
<!--    <link rel="stylesheet" href="--><?php //echo base_url(); ?><!--backend/usertemplate/assets/font-awesome/css/font-awesome.min.css">-->
<!--    <link rel="stylesheet" href="--><?php //echo base_url(); ?><!--backend/usertemplate/assets/css/form-elements.css">-->
<!--    <link rel="stylesheet" href="--><?php //echo base_url(); ?><!--backend/usertemplate/assets/css/style.css">-->
<!--    <link rel="stylesheet" href="--><?php //echo base_url(); ?><!--backend/usertemplate/assets/css/jquery.mCustomScrollbar.min.css">-->
<!--    <script src="--><?php //echo base_url(); ?><!--backend/js/plugins/forms/wizards/steps.min.js"></script>-->
<!--    <script src="--><?php //echo base_url(); ?><!--backend/js/plugins/forms/selects/select2.min.js"></script>-->
<!--    <script src="--><?php //echo base_url(); ?><!--backend/js/plugins/forms/styling/uniform.min.js"></script>-->
<!--    <script src="--><?php //echo base_url(); ?><!--backend/js/plugins/forms/inputs/inputmask.js"></script>-->
<!--    <script src="--><?php //echo base_url(); ?><!--backend/js/plugins/forms/validation/validate.min.js"></script>-->
<!--     <script src="--><?php //echo base_url(); ?><!--backend/js/form_wizard.js"></script>-->
    <script src="<?php echo base_url(); ?>backend/js/sstoast.js"></script>
    <link href="<?php echo base_url(); ?>backend/toast-alert/toastr.css" rel="stylesheet"/>
    <script src="<?php echo base_url(); ?>backend/toast-alert/toastr.js"></script>

    <style type="text/css">
        .backstretch img
        {
            opacity: 0.7;
        }
        .form-group label
        {
            float: left;
        }
        /*    body{background:linear-gradient(to right,#676767 0,#dadada 100%);}
            /*.loginbg {background: #455a64;}*/
        .top-content{position: relative;}
        .mCSB_scrollTools .mCSB_dragger .mCSB_dragger_bar {
            background: rgb(53, 170, 71);}
        .bgoffsetbgno{background: transparent; border-right:0 !important; box-shadow: 0px 0px 12px rgba(0, 0, 0, 0.29); border-radius: 4px;}

        .bgoffsetbg
        {
            height: 500px;
        }
        .loginradius{border-radius: 4px;}
        .image-layer {
            position: absolute;
            background-color: #999;
            left: 0px;
            top: 0px;
            width: 57%;
            height: 100%;
            background-repeat: no-repeat;
            background-size: cover;
            background-position: center;
        }*/

        .image-layer:after {
            content: '';
            position: absolute;
            top: 0;
            background: rgba(0, 0, 0, 0.20);
            width: 100%;
            height: 100%;
        }*/
        .col-md-offset-3 { margin-left: 29%;}

        @media (max-width: 767px) {
            .col-md-offset-3 {margin-left: 0;}
        }*/
    </style>
    <style type="text/css">
        .disabledTab {
            pointer-events: none;
            cursor: not-allowed
        }
        .disabledSection {
            pointer-events: none;
            cursor: not-allowed;
            opacity: 0.5;
        }
    </style>
</head>
<body>

<div class="topbar">
    <div class="container">
        <div class="row">
            <div class="col-md-9">
                <ul class="contact-info">
                    <li>
                        <a href="tel:02134540162"><i class="fa  fa-phone-alt"></i>(0213)4540162 -2</a>
                    </li>
                    <li>
                        <a href="mailto:hr@leadershipschool.com.pk"><i class="fal fa-envelope"></i>hr@leadershipschool.com.pk</a>
                    </li>
                </ul>
            </div>
<!--            <div class="col-md-3">-->
<!--                <ul class="social-icons">-->
<!--                    <li>-->
<!--                        <a target="_blank" href="//www.facebook.com/BeaconhouseSchoolSystemOfficial/"><i class="fab fa-facebook-f"></i></a>-->
<!--                    </li>-->
<!--                    <li>-->
<!--                        <a target="_blank" href="//twitter.com/BSSWorldwide"><i class="fab fa-twitter"></i></a>-->
<!--                    </li>-->
<!--                    <li>-->
<!--                        <a target="_blank" href="//www.instagram.com/bssworldwide/"><i class="fab fa-instagram"></i></a>-->
<!--                    </li>-->
<!--                </ul>-->
<!--            </div>-->
        </div>
    </div>
</div>
<!--<div class="container mt-15 pl-0 pr-0">-->
<!--    <div class="carousel slide" data-ride="carousel" id="carouselExampleIndicators">-->
<!--        <ol class="carousel-indicators">-->
<!--            <li class="active" data-slide-to="0" data-target="#carouselExampleIndicators"></li>-->
<!--            <li data-slide-to="1" data-target="#carouselExampleIndicators" class=""></li>-->
<!--            <li data-slide-to="2" data-target="#carouselExampleIndicators" class=""></li>-->
<!--            <li data-slide-to="3" data-target="#carouselExampleIndicators" class=""></li>-->
<!--            <li data-slide-to="4" data-target="#carouselExampleIndicators" class=""></li>-->
<!--        </ol>-->
<!--        <div class="carousel-inner">-->
<!--            <div class="carousel-item active"><img alt="First slide" class="d-block w-100" src="https://admissions.beaconhouse.net/img/ey.png"></div>-->
<!--            <div class="carousel-item"><img alt="Second slide" class="d-block w-100" src="https://admissions.beaconhouse.net/img/primary.png"></div>-->
<!--            <div class="carousel-item"><img alt="Second slide" class="d-block w-100" src="https://admissions.beaconhouse.net/img/middle.png"></div>-->
<!--            <div class="carousel-item"><img alt="Second slide" class="d-block w-100" src="https://admissions.beaconhouse.net/img/secondary.png"></div>-->
<!--            <div class="carousel-item"><img alt="Second slide" class="d-block w-100" src="https://admissions.beaconhouse.net/img/a-level.png"></div>-->
<!--        </div>-->
<!--        <a class="carousel-control-prev" data-slide="prev" href="#carouselExampleIndicators" role="button"><i class="fal fa-chevron-left"></i></a>-->
<!--        <a class="carousel-control-next" data-slide="next" href="#carouselExampleIndicators" role="button"><i class="fal fa-chevron-right"></i></a>-->
<!--    </div>-->
<!--</div>-->
<div class="container  content mb-15 text-center border-top-0">
<!--    <img src="https://admissions.beaconhouse.net/img/online_admissions.png" draggable="false">-->
</div>
<form method="post" name="myform" id="form_data">
    <div class="container white-bg mt-15">
        <ul class="nav nav-tabs" role="tablist">
            <li><a class="nav-link tab-color-white active" data-toggle="tab" href="#tab-01" onclick="$('#btn_continue').text(' Continue '); $('#btn_go_back').css('display','none');">Student Info</a></li>
            <li class=""><a class="nav-link tab-color-white parent_info_tab disabledTab" data-toggle="tab" href="#tab-02" onclick="$('#btn_continue').text(' Submit '); $('#btn_go_back').css('display','');">Parent Info</a></li>
        </ul>
    </div>
    <div class="tab-content container mt-4">
        <div role="tabpanel" id="tab-01" class="tab-pane active">
            <div class="panel-body">
                <div class="row ">
                    <div class="col-md-4 white-bg p-15 pt-30">
                        <div class="steps">Step 1</div>
                        <style>
                            .steps {
                                border-radius: 20px;
                                background: #f9f9f9;
                                border: 1px solid #e1e1e1;
                                width: 80px;
                                text-align: center;
                                font-size: 12px;
                                font-weight: 600;
                                text-transform: uppercase;
                                line-height: 25px;
                                position: absolute;
                                top: -12px;
                            }
                        </style>
                        <div class="form-group mb-0 ">
                            <label>Student Name <span class="star-red">*</span></label>
                            <input type="text" class="form-control common-input" name="std_name" id="std_name" maxlength="100" onchange="enable_disable_section()">
                        </div>
                        <div class="form-group mt-15 ">
                            <label>Class Level <span class="star-red">*</span></label>
                            <select class="form-control common-select" name="online_class_id" id="online_class_id" onchange="enable_disable_section();">
                                <option value="">Select Class</option>
                                <?php
                                foreach ($classlist as $class) {
                                    ?>
                                    <option value="<?php echo $class->id ?>"<?php if (set_value('class_id') == $class->id) {
                                        echo "selected=selected";
                                    }
                                    ?>><?php echo $class->class ?></option>
                                    <?php

                                }
                                ?>
                            </select>
                         </div>
                        <div class="form-group mt-15 ">
                            <div>
                                <label>Student Gender <span class="star-red">*</span></label>
                                <div>
                                    <div class="radio float-left ">
                                        <input type="radio" name="gender" id="radio1" value="M"   onclick="enable_disable_section()">
                                        <label for="radio1">
                                            Male
                                        </label>
                                    </div>
                                    <div class="radio float-left ml-15">
                                        <input type="radio" name="gender" id="radio2" value="F"   onclick="enable_disable_section()">
                                        <label for="radio2">
                                            Female
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 white-bg p-15 pt-30 border-right-0 border-left-0 disabledSection" id="section_2">
                        <div class="steps">Step 2</div>
                        <div class="form-group branch_list_container" style="display:none;">
                            <label>Select a campus <span class="star-red">*</span></label>

                                 <div class="radio float-left w-100">
                                     <input type="radio" name="branch_name" checked value="peaches" id="branch_id" >
                                     <label for="branch_name">
                                         PECHS Campus
                                     </label>
                                 </div>

                        </div>
                    </div>
                 </div>
            </div>
        </div>
        <div role="tabpanel" id="tab-02" class="tab-pane ">
            <div class="panel-body">
                <div class="row ">
                    <div class="col-md-4 white-bg p-15 pt-30" style="border-right:0px;">
                        <div class="steps">Step 3</div>
                        <div class="form-group mb-0 ">
                            <label>Parent Name <span class="star-red">*</span></label>
                            <input type="text" class="form-control common-input" id="parent_name" name="parent_name" maxlength="100">
                        </div>
                        <div class="form-group mt-15 ">
                            <label>Parent Contact Number <span class="star-red">*</span></label>
                            <input type="text" class="form-control common-input" id="parent_contact" name="parent_contact" maxlength="11" placeholder="(03xx) xxxxxxx">
                        </div>
                        <div class="form-group mt-15 ">
                            <label>Parent Email Address <span class="star-red">*</span></label>
                            <input type="email" class="form-control common-input" id="parent_email" name="parent_email" maxlength="50" onblur="validate_email(this)" placeholder="example@gmail.com">
                        </div>
                    </div>
                    <div class="col-md-8 white-bg p-15 border-left-0" style="border-left:0px;">
                        <div class="row success_message_container" style="display:none">
                            <div class="col-md-12">
                                <h4 class="font-weight-bold">Admission Form Submitted Successfully</h4>
                                <p>
                                    Thank you for choosing Leadership School  . Your admission request has been forwarded to the concerned school.
                                    The school representative will contact you within 2 working days for assistance with regards to the online admission process.
                                    <br><br>
                                    For further assistance, write to us on <a href="mailto:hr@leadershipschool.com.pk">hr@leadershipschool.com.pk</a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 white-bg mt-15">
                <div class="form-group mt-3 mb-3 mr-0 float-right">
                    <a href="javascript:void(0)" class="common-blue-btn round-btn   back mr-15" id="btn_go_back" style="display:none" onclick="$('.nav-tabs li:eq(0) a').tab('show'); $('#btn_go_back').css('display','none'); $('#btn_continue').text(' Continue ');"> Go Back </a>
                    <a href="javascript:void(0)" class="common-blue-btn round-btn     continue" id="btn_continue" onclick="process_form(this)"> Continue </a>
                    <input type="hidden" name="save_data" value="save_data">
                </div>
            </div>
        </div>
    </div>
</form>
<footer>
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="copyright">
                    <p style="margin-top: 12px; margin-bottom: 0; color: #fff;">© 2020 - <a href="//www.beaconhouse.net" target="_blank">Leadership School</a> - All Rights Reserved</p>
                </div>
            </div>
        </div>
    </div>
</footer>
</body>
</html>
<script language="javascript">
     function process_form(obj){
        $(obj).text(' Continue ');
        $("#btn_go_back").css('display','none');

        if($("#std_name").val() == '') {
            toastr.error('Please enter student name');
            return false;
        }
        if($("#online_class_id").val() == '') {
            toastr.error('Please select a class');
            return false;
        }
        if(document.myform.gender.value == '') {
            toastr.error('Please select a gender');
            return false;
        }


        if(document.myform.branch_name.value == '' ) {
            toastr.error('Please select a campus');
            return false;
        }

        $(obj).text(' Submit ');
        $("#btn_go_back").css('display','');

        if($('.nav-tabs li:eq(0) a').hasClass('active')) {
            $(".parent_info_tab").removeClass("disabledTab");
            $('.nav-tabs li:eq(1) a').tab('show');
            return true;
        }

        if($("#parent_name").val() == '') {
            toastr.error('Please enter parent name');
            return false;
        }

        if($("#parent_contact").val() == '') {
            toastr.error('Please enter parent contact');
            return false;
        }

        if($("#parent_email").val() == '') {
            toastr.error('Please enter parent email');
            return false;
        }

        var validEmail = /^\w+([-+.']\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/;
        if (!validEmail.test($("#parent_email").val())) {
            toastr.error('Please enter a valid parent email');
            return false;
        }

        $(obj).css('visibility', 'hidden');
//        init_blockUI();
//         $.unblockUI();
         $.ajax({
             type: "POST",
             dataType: 'Json',
             url: '<?=base_url('Onlineadmission/saveData')?>',
             data: $("#form_data").serialize(), // serializes the form's elements.
             success: function (data)
             {
//                 $.unblockUI();
                 if (data.status) {
                     successMsg(data.message);
                     $(".success_message_container").css('display','')
                 } else {
                     errorMsg(data.message);

                 }
                 setTimeout(function(){
                     location.reload(true);
                 }, 5000);


             }
         });

     }


    function validate_email(obj) {
        if(obj.value != '') {
            var validEmail = /^\w+([-+.']\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/;
            if (!validEmail.test($("#parent_email").val())) {
                toastr.error('Please enter a valid parent email');
                obj.focus();
                return false;
            }
        }
    }

    function chk_gender() {
        if(document.myform.gender.value == '') {
            toastr.error('Please select a gender');
            return false;
        }
        return true;
    }

    $(document).ready(function() {
//         /*$('#parent_contact').usPhoneFormat({
//         format: '(xxx) xxx-xxxx',
//         });*/
        document.myform.gender[0].checked = false;
        document.myform.gender[1].checked = false;
        $('#parent_contact').mask('(0000) 0000000');

//        $(".blockUI h1").css('font-size', '12px !important')

//        $(document).ajaxStart($.blockUI).ajaxStop($.unblockUI);

        //$("#city_id").on("click", function() { if(!chk_gender()) { $("#city_id").trigger('blur'); } } );
        //$("#town_id").on("click", function() { if(!chk_gender()) { $("#town_id").trigger('blur'); } } )

    });

    function enable_disable_section() {
        if(document.myform.online_class_id.value != '' && document.myform.std_name.value != '' && document.myform.gender.value != '') {//document.myform.std_name.value != '' &&
            $("#section_2").removeClass('disabledSection');
            $(".branch_list_container").css('display', '');
        }

//        if($("#city_id").val() == 1 || $("#city_id").val() == 2 || $("#city_id").val() == 3) {
//            if($("#town_id").val() != '') {
//                $(".branch_list_container").css('display', '');
//                $("#section_3").removeClass('disabledSection');
//            }
//        } else {
//            if($("#city_id").val() != '') {
//                $(".branch_list_container").css('display', '');
//                $("#section_3").removeClass('disabledSection');
//            }
//
//        }

    }

    function init_blockUI() {
        $.blockUI(
            {
                css: {
                    border: 'none',
                    padding: '15px',
                    backgroundColor: '#000',
                    '-webkit-border-radius': '10px',
                    '-moz-border-radius': '10px',
                    opacity: .3,
                    color: '#fff',
                    fontSize:'16px'
                },
                message: 'Please wait'
            });
    }
</script>
<script type="text/javascript">
    $(document).ready(function () {
        var base_url = '<?php echo base_url(); ?>';
        $.backstretch([
            base_url + "backend/usertemplate/assets/img/backgrounds/user15.jpg"
        ], {duration: 3000, fade: 750});
        $('.login-form input[type="text"], .login-form input[type="password"], .login-form textarea').on('focus', function () {
            $(this).removeClass('input-error');
        });
        $('.login-form').on('submit', function (e) {
            $(this).find('input[type="text"], input[type="password"], textarea').each(function () {
                if ($(this).val() == "") {
                    e.preventDefault();
                    $(this).addClass('input-error');
                } else {
                    $(this).removeClass('input-error');
                }
            });
        });
    });
</script>