<!DOCTYPE html>
<html <?php echo $this->customlib->getRTL(); ?>>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo $this->customlib->getAppName(); ?></title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta name="theme-color" content="#424242" />
    <link href="<?php echo base_url(); ?>uploads/school_content/admin_small_logo/<?php $this->setting_model->getAdminsmalllogo(); ?>" rel="shortcut icon" type="image/x-icon">
    <link rel="stylesheet" href="<?php echo base_url(); ?>backend/bootstrap/css/bootstrap.min.css">
    <!-- <link rel="stylesheet" href="<?php echo base_url(); ?>backend/dist/css/style-main.css"> -->


    <?php
    $this->load->view('layout/theme');
    ?>
    <?php
    if ($this->customlib->getRTL() != "") {
        ?>
        <!-- Bootstrap 3.3.5 RTL -->
        <link rel="stylesheet" href="<?php echo base_url(); ?>backend/rtl/bootstrap-rtl/css/bootstrap-rtl.min.css"/>
        <!-- Theme RTL style -->
        <link rel="stylesheet" href="<?php echo base_url(); ?>backend/rtl/dist/css/AdminLTE-rtl.min.css" />
        <link rel="stylesheet" href="<?php echo base_url(); ?>backend/rtl/dist/css/ss-rtlmain.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>backend/rtl/dist/css/skins/_all-skins-rtl.min.css" />

        <?php
    } else {

    }
    ?>
    <link rel="stylesheet" href="<?php echo base_url(); ?>backend/dist/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>backend/dist/css/ionicons.min.css">

    <link rel="stylesheet" href="<?php echo base_url(); ?>backend/plugins/iCheck/flat/blue.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>backend/plugins/morris/morris.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>backend/plugins/jvectormap/jquery-jvectormap-1.2.2.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>backend/plugins/datepicker/datepicker3.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>backend/plugins/daterangepicker/daterangepicker-bs3.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>backend/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>backend/sweet-alert/sweetalert2.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>backend/dist/css/custom_style.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>backend/datepicker/css/bootstrap-datetimepicker.css">
    <!--file dropify-->
    <link rel="stylesheet" href="<?php echo base_url(); ?>backend/dist/css/dropify.min.css">
    <!--file nprogress-->
    <link href="<?php echo base_url(); ?>backend/dist/css/nprogress.css" rel="stylesheet">
    <!--print table-->
    <link href="<?php echo base_url(); ?>backend/dist/datatables/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>backend/dist/datatables/css/buttons.dataTables.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>backend/dist/datatables/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <!--print table mobile support-->
    <link href="<?php echo base_url(); ?>backend/dist/datatables/css/responsive.dataTables.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>backend/dist/datatables/css/rowReorder.dataTables.min.css" rel="stylesheet">

    <!--language css-->
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/0.8.2/css/flag-icon.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>backend/dist/css/bootstrap-select.min.css">
    <script src="<?php echo base_url(); ?>backend/custom/jquery.min.js"></script>
    <script src="<?php echo base_url(); ?>backend/dist/js/moment.min.js"></script>
    <script src="<?php echo base_url(); ?>backend/datepicker/js/bootstrap-datetimepicker.js"></script>
    <script src="<?php echo base_url(); ?>backend/datepicker/date.js"></script>
    <script src="<?php echo base_url(); ?>backend/dist/js/jquery-ui.min.js"></script>
    <script src="<?php echo base_url(); ?>backend/js/sstoast.js"></script>

    <!-- fullCalendar -->
    <link rel="stylesheet" href="<?php echo base_url() ?>backend/fullcalendar/dist/fullcalendar.min.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>backend/fullcalendar/dist/fullcalendar.print.min.css" media="print">


    <script type="text/javascript">
        var baseurl = "<?php echo base_url(); ?>";
    </script>
    <style type="text/css">
        span.flag-icon.flag-icon-us{text-orientation: mixed;}
        .progress-container {
            width: 100%;
            height: 8px;
            background: #ccc;
        }
        .info-box
        {
            min-height: 30px;
        }
        .progress-bar {
            height: 8px;
            background: #4755AB;
            width: 0%;
        }
        #search_div:focus {
            opacity: 1;
            border: 1px solid  #4755ab;
            background-color: #fff;
        }
        /*#search-btn:focus {*/
        /*opacity: 1;*/
        /*border-top: 1px solid  #4755ab;*/
        /*border-right: 1px solid  #4755ab;*/
        /*border-bottom: 1px solid  #4755ab;*/
        /*!*border: 1px solid  #4755ab;*!*/
        /*background-color: #fff;*/
        /*}*/
        /* width */
        ::-webkit-scrollbar {
            width: 10px;
        }

        /* Track */
        ::-webkit-scrollbar-track {
            box-shadow: inset 0 0 5px grey;
            border-radius: 10px;
        }

        /* Handle */
        ::-webkit-scrollbar-thumb {
            background: #4755AB;
            border-radius: 10px;
        }

        /* Handle on hover */
        ::-webkit-scrollbar-thumb:hover {
            background: #4755AB ;
        }
        .skin-blue .main-header .navbar .nav>li>a:hover,
        {
            background: none !important;
            color: transparent !important;
        }
        @media only screen and (max-width: 762px) {
            #collapsedOutIcon {
                display: block  ;
            }
            #collapsedInIcon {
                display: none  ;
            }


        }
        #mydiv{
            overflow: auto;

        }
        #collapsedOutIcon {
            display: none  ;
        }
        #collapsedInIcon {
            display: block  ;
        }
        @media only screen and (max-width: 300px) {
            #loginUserName {
                display: none;
            }

        }@media only screen and (max-width: 350px) {
            #mydiv {
                display: none  ;
            }

        }
        .main-header .sidebar-toggle-icon {
            float: left;
            background-color: transparent;
            background-image: none;
            padding: 15px 15px 13px;
            font-family: fontAwesome;
        }

        .sidebar-toggle-icon {
            position: absolute;
            z-index: 1;
        }
    </style>

</head>
<body class="hold-transition skin-blue fixed sidebar-mini">
<script>

    function collapseSidebar() {

        if (Boolean(sessionStorage.getItem('sidebar-toggle-collapsed1'))) {

            $('#collapsedOutIcon').css('display','none');
            $('#collapsedInIcon').css('display','block');
            sessionStorage.setItem('sidebar-toggle-collapsed1', '');

        } else {
            $('#collapsedOutIcon').css('display','block');
            $('#collapsedInIcon').css('display','none');
            sessionStorage.setItem('sidebar-toggle-collapsed1', '1');

        }

    }

    function checksidebar() {

        if (Boolean(sessionStorage.getItem('sidebar-toggle-collapsed1'))) {

            var body = document.getElementsByTagName('body')[0];

            body.className = body.className + ' sidebar-collapse';

        }
    }

    checksidebar();

</script>
<div class="wrapper">
    <header class="main-header" id="alert">
        <a href="<?php echo base_url(); ?>parent/parents/dashboard" class="logo">
            <span class="logo-mini"><img src="<?php echo base_url(); ?>uploads/school_content/admin_small_logo/<?php $this->setting_model->getAdminsmalllogo(); ?>" alt="<?php echo $this->customlib->getAppName() ?>" /></span>
            <span class="logo-lg"><img src="<?php echo base_url(); ?>uploads/school_content/admin_logo/<?php $this->setting_model->getAdminlogo(); ?>" alt="<?php echo $this->customlib->getAppName() ?>" /></span>
        </a>
        <nav class="navbar navbar-static-top" role="navigation">
            <a onclick="collapseSidebar()"  class="sidebar-toggle-icon" data-toggle="offcanvas" role="button">
                <!--                        <span class="sr-only">Toggle navigation</span>-->
                <i class="fa fa-angle-double-left" id="collapsedInIcon" style=" font-size: 25px;font-weight: bold"></i>
                <i class="fa fa-angle-double-right" id="collapsedOutIcon" style=" font-size: 25px;font-weight: bold"></i>
                <!--                        <span class="icon-bar"></span>-->
                <!--                        <span class="icon-bar"></span>-->
                <!--                        <span class="icon-bar"></span>-->
            </a>
            <div class="col-lg-5 col-md-3 col-sm-2 col-xs-5">
<!--                        <span href="#" class="sidebar-session">-->
<!--                            --><?php //echo $this->setting_model->getCurrentSchoolName(); ?>
<!--                        </span>-->
            </div>
            <div class="col-lg-7 col-md-9 col-sm-10 col-xs-7">
                <div class="pull-right">

                    <div class="navbar-custom-menu">
                        <div class="langdiv">
                            <select class="languageselectpicker" onchange="set_languages(this.value)"  type="text" id="languageSwitcher" class="form-control search-form search-form3 langselect"  >

                                <?php $this->load->view('parent/language/languageSwitcher') ?>

                            </select>

                        </div>

                        <ul class="nav navbar-nav headertopmenu">

                            <?php if ($this->parentmodule_lib->hasActive('calendar_to_do_list')) { ?>
                                <li class="cal15"><a href="<?php echo base_url() ?>parent/calendar/"><i class="fa fa fa-calendar"></i></a></li>
                                <?php //} ?>
                                <li class="dropdown">
                                <a href="#" class="dropdown-toggle todoicon" data-toggle="dropdown">
                                    <i class="fa fa-check-square-o"></i>
                                    <?php
                                    $userdata = $this->customlib->getLoggedInUserData();
                                    $count = $this->customlib->countincompleteTask($userdata["id"]);
                                    if ($count > 0) {
                                        ?>

                                        <span class="todo-indicator"><?php echo $count ?></span>
                                    <?php } ?>
                                </a>
                                <ul class="dropdown-menu menuboxshadow">

                                    <li class="todoview plr10 ssnoti"><?php echo $this->lang->line('today_you_have') . " " . $count . " " . $this->lang->line('pending_task'); ?><a href="<?php echo base_url() ?>parent/calendar/" class="pull-right pt0">View all</a></li>
                                    <li>
                                        <ul class="todolist">
                                            <?php
                                            $tasklist = $this->customlib->getincompleteTask($userdata["id"]);
                                            foreach ($tasklist as $key => $value) {
                                                ?>
                                                <li><div class="checkbox">
                                                        <label><input type="checkbox" id="newcheck<?php echo $value["id"] ?>" onclick="markc('<?php echo $value["id"] ?>')" name="eventcheck"  value="<?php echo $value["id"]; ?>"><?php echo $value["event_title"] ?></label>
                                                    </div></li>
                                            <?php } ?>

                                        </ul>
                                    </li>
                                </ul>
                                </li><?php
                            }
                            $parent_data = $this->customlib->getLoggedInUserData();
                            //                                    echo "<pre>";
                            //                                    var_dump($parent_data);
                            //                                    die();
                            $file = $parent_data["image"];
                            $image = $parent_data["image"];
                            if (!empty($image)) {

                                $file = $image;
                            } else {

                                $file = "uploads/student_images/no_image.png";
                            }
                            ?>
                            <li class="dropdown user-menu">
                                <a class="dropdown-toggle" style="padding: 15px 13px;" data-toggle="dropdown" href="#" aria-expanded="false">
                                    <img src="<?php echo base_url() . $file; ?>" class="topuser-image" alt="User Image">
                                </a>
                                <ul class="dropdown-menu dropdown-user menuboxshadow">
                                    <li>
                                        <div class="sstopuser">
                                            <div class="ssuserleft">
                                                <img src="<?php echo base_url() . $file; ?>" alt="User Image">
                                            </div>

                                            <div class="sstopuser-test">
                                                <h4 style="text-transform: capitalize;"><?php echo $this->customlib->getStudentSessionUserName(); ?></h4>
                                                <h5><?php echo $this->lang->line("parent"); ?></h5>
                                                <!--p>demo</p-->
                                            </div>
                                            <div class="divider"></div>
                                            <div class="sspass">
                                                <a class="" href="<?php echo base_url(); ?>parent/parents/changepass"><i class="fa fa-key"></i> <?php echo $this->lang->line('change_password'); ?></a> <a class="pull-right" href="<?php echo base_url(); ?>site/logout"><i class="fa fa-sign-out fa-fw"></i> <?php echo $this->lang->line('logout'); ?></a>
                                            </div>
                                        </div><!--./sstopuser--></li>
                                </ul>
                            </li>
                            <li class="dropdown user-menu">
                                <a class="dropdown-toggle" style="padding: 15px 13px;" data-toggle="dropdown" href="#" aria-expanded="false"> <span class="glyphicon glyphicon-option-vertical"></span></a>

                                <ul class="dropdown-menu dropdown-user menuboxshadow">
                                    <li class=" ">
                                        <span><?php echo $this->lang->line('current_session') . ": " . $this->setting_model->getCurrentSessionName(); ?></span>


                                    </li>
                                </ul>
                            </li>

                        </ul>
                    </div>

                </div>
            </div>
        </nav>
        <div class="progress-container">
            <div class="progress-bar" id="myBar"></div>
        </div>
    </header>
    <aside class="main-sidebar" id="alert2">
        <section class="sidebar" id="sibe-box">
            <!--            <ul class="sessionul fixedmenu">-->
            <!--                <li class="parentremovehover">-->
            <!--                    <span>--><?php //echo $this->lang->line('current_session') . ": " . $this->setting_model->getCurrentSessionName(); ?><!--</span><i class="fa fa-clock-o pull-right"></i>-->
            <!--                </li>-->
            <!--            </ul>-->
            <ul class="sidebar-menu verttop38" style="padding-top: 15px">

                <li class="treeview <?php echo set_Topmenu('My Children'); ?>">
                    <a href="#">
                        <i class="fa fa-users ftlayer"></i> <span>
                                    <?php echo $this->lang->line('my_children'); ?></span> <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu ">
                        <?php
                        $ch = $this->session->userdata('parent_childs');
                        foreach ($ch as $key_ch => $value_ch) {
                            ?>
                            <li class="<?php echo set_Submenu('parent/parents/getStudent'); ?>" ><a href="<?php echo base_url(); ?>parent/parents/getstudent/<?php echo $value_ch['student_id'] ?>"><i class="fa fa-angle-double-right"></i> <?php echo $value_ch['name'] ?></a></li>
                            <?php
                        }
                        ?>
                    </ul>
                </li>

                <?php
                if ($this->parentmodule_lib->hasActive('fees')) {
                    ?>
                    <li class="treeview <?php echo set_Topmenu('Fees'); ?>">
                        <a href="#">
                            <i class="fa fa-money ftlayer"></i> <span><?php echo $this->lang->line('fees'); ?></span> <i class="fa fa-angle-left pull-right"></i>
                        </a>
                        <ul class="treeview-menu">
                            <?php
                            $ch = $this->session->userdata('parent_childs');
                            foreach ($ch as $key_ch => $value_ch) {
                                ?>
                                <li class="<?php echo set_Submenu('parent/parents/getFees'); ?>" ><a href="<?php echo base_url(); ?>parent/parents/getfees/<?php echo $value_ch['student_id'] ?>"><i class="fa fa-angle-double-right"></i> <?php echo $value_ch['name'] ?></a></li>
                                <?php
                            }
                            ?>
                        </ul>
                    </li>
                    <?php
                }

                if ($this->parentmodule_lib->hasActive('class_timetable')) {
                    ?>
                    <li class="treeview <?php echo set_Topmenu('Time Table'); ?>">
                        <a href="#">
                            <i class="fa fa-calendar-times-o ftlayer"></i> <span><?php echo $this->lang->line('class_timetable'); ?></span> <i class="fa fa-angle-left pull-right"></i>
                        </a>
                        <ul class="treeview-menu">
                            <?php
                            $ch = $this->session->userdata('parent_childs');
                            foreach ($ch as $key_ch => $value_ch) {
                                ?>
                                <li class="<?php echo set_Submenu('parent/parents/gettimetable'); ?>"><a href="<?php echo base_url(); ?>parent/parents/gettimetable/<?php echo $value_ch['student_id'] ?>"><i class="fa fa-angle-double-right"></i> <?php echo $value_ch['name'] ?></a></li>
                                <?php
                            }
                            ?>
                        </ul>
                    </li>
                    <?php
                } if ($this->parentmodule_lib->hasActive('homework')) {
                    ?>





                    <li class="treeview <?php echo set_Topmenu('Homework'); ?>">
                        <a href="#">
                            <i class="fa fa-calendar-times-o ftlayer"></i> <span><?php echo $this->lang->line('homework'); ?></span> <i class="fa fa-angle-left pull-right"></i>
                        </a>
                        <ul class="treeview-menu">
                            <?php
                            $ch = $this->session->userdata('parent_childs');
                            foreach ($ch as $key_ch => $value_ch) {
                                ?>
                                <li class="<?php echo set_Submenu('parent/homework/student_homework/' . $value_ch["student_id"]); ?>"><a href="<?php echo base_url(); ?>parent/homework/student_homework/<?php echo $value_ch['student_id'] ?>"><i class="fa fa-angle-double-right"></i> <?php echo $value_ch['name'] ?></a></li>
                                <?php
                            }
                            ?>
                        </ul>
                    </li>
                    <?php
                }

                if ($this->parentmodule_lib->hasActive('download_center')) {
                    ?>
                    <li class="treeview <?php echo set_Topmenu('Downloads'); ?>">
                        <a href="#">
                            <i class="fa fa-download ftlayer"></i> <span><?php echo $this->lang->line('download_center'); ?></span> <i class="fa fa-angle-left pull-right"></i>
                        </a>
                        <ul class="treeview-menu">
                            <?php
                            $ch = $this->session->userdata('parent_childs');
                            foreach ($ch as $key_ch => $value_ch) {
                                ?>
                                <li class="<?php echo set_Submenu('parent/parents/getStudent' . $value_ch['student_id']); ?>" ><a href="<?php echo base_url(); ?>parent/parents/download_docs/<?php echo $value_ch['student_id'] ?>"><i class="fa fa-angle-double-right"></i> <?php echo $value_ch['name'] ?></a></li>
                                <?php
                            }
                            ?>

                        </ul>
                    </li>
                    <?php
                }
                ?>

                <?php
                if ($this->parentmodule_lib->hasActive('attendance')) {
                    ?>

                    <li class="treeview <?php echo set_Topmenu('Attendance'); ?>">
                        <a href="#">
                            <i class="fa fa-calendar-check-o ftlayer"></i> <span><?php echo $this->lang->line('attendance'); ?></span> <i class="fa fa-angle-left pull-right"></i>
                        </a>
                        <ul class="treeview-menu">
                            <?php
                            $ch = $this->session->userdata('parent_childs');
                            $main_student_id= $ch[0]['student_id'];


                            foreach ($ch as $key_ch => $value_ch) {
                                ?>
                                <li class="<?php echo set_Submenu('parent/parents/getattendence'); ?>"><a href="<?php echo base_url(); ?>parent/parents/getattendence/<?php echo $value_ch['student_id'] ?>"><i class="fa fa-angle-double-right"></i> <?php echo $value_ch['name'] ?></a></li>
                                <?php
                            }
                            ?>
                        </ul>
                    </li>
                    <?php
                }
                if ($this->parentmodule_lib->hasActive('examinations')) {
                    ?>
                    <li class="treeview <?php echo set_Topmenu('Examination'); ?>">
                        <a href="#">
                            <i class="fa fa-map-o ftlayer"></i> <span><?php echo $this->lang->line('examinations'); ?></span> <i class="fa fa-angle-left pull-right"></i>
                        </a>
                        <ul class="treeview-menu ">
                            <?php
                            $ch = $this->session->userdata('parent_childs');
                            foreach ($ch as $key_ch => $value_ch) {
                                ?>
                                <li class="<?php echo set_Submenu('parent/parents/getexams'); ?>"><a href="<?php echo base_url(); ?>parent/parents/getexams/<?php echo $value_ch['student_id'] ?>"><i class="fa fa-angle-double-right"></i> <?php echo $value_ch['name'] ?></a></li>
                                <?php
                            }
                            ?>
                        </ul>
                    </li>
                    <?php
                }
                if ($this->parentmodule_lib->hasActive('notice_board')) {
                    ?>
                    <li class="treeview <?php echo set_Topmenu('Notification'); ?>">
                        <a href="<?php echo base_url(); ?>parent/notification">
                            <i class="fa fa-envelope ftlayer"></i> <span><?php echo $this->lang->line('notice_board'); ?></span>
                            <?php
                            $ntf = $this->customlib->getParentunreadNotification();

                            if ($ntf) {
                                ?>
                                <small class="label pull-right bg-red">
                                    <?php echo $ntf; ?>
                                </small>
                                <?php
                            }
                            ?>
                        </a>
                    </li>
                    <?php
                }


                if ($this->parentmodule_lib->hasActive('teachers_rating')) {
                    ?>
                    <?php
                    ?>
                    <li class="treeview <?php echo set_Topmenu('teacher/index'); ?>">
                        <a href="#">
                            <i class="fa fa-language ftlayer"></i> <span><?php echo $this->lang->line('teachers') . " " . $this->lang->line('reviews'); ?></span> <i class="fa fa-angle-left pull-right"></i>
                        </a>
                        <ul class="treeview-menu">
                            <?php
                            $ch = $this->session->userdata('parent_childs');
                            foreach ($ch as $key_ch => $value_ch) {
                                ?>
                                <li class="<?php echo set_Submenu('parent/parents/get_student_teachers_' . $value_ch['student_id']); ?>"><a href="<?php echo base_url(); ?>parent/parents/get_student_teachers/<?php echo $value_ch['student_id'] ?>"><i class="fa fa-angle-double-right"></i> <?php echo $value_ch['name'] ?></a></li>
                            <?php }
                            ?>
                        </ul>
                    </li>

                    <?php
                }

                if ($this->parentmodule_lib->hasActive('library')) {
                    ?>
                    <li class="<?php echo set_Topmenu('Library'); ?>"><a href="<?php echo base_url(); ?>parent/book"><i class="fa fa-book ftlayer"></i> <span><?php echo $this->lang->line('library_books'); ?></span></a></li>
                    <?php
                }

                if ($this->parentmodule_lib->hasActive('transport_routes')) {
                    ?>
                    <li class="treeview <?php echo set_Topmenu('Transport'); ?>"><a href="<?php echo base_url(); ?>parent/route"><i class="fa fa-bus ftlayer"></i> <span><?php echo $this->lang->line('transport_routes'); ?></span></a></li>
                    <?php
                }

                if ($this->parentmodule_lib->hasActive('hostel_rooms')) {
                    ?>
                    <li class="<?php echo set_Submenu('hostel/index'); ?>"><a href="<?php echo base_url(); ?>parent/hostel"><i class="fa fa-building-o ftlayer"></i> <span><?php echo $this->lang->line('hostel'); ?></span></a></li>
                <?php }
                ?>
            </ul>
        </section>
    </aside>

    <script>
        function set_languages(lang_id) {
            $.ajax({
                type: "POST",
                url: '<?php echo base_url(); ?>parent/parents/user_language/' + lang_id,
                data: {},
                //dataType: "json",
                success: function (data) {
                    successMsg("Status Change Successfully");
                    window.location.reload('true');

                }
            });

        }

    </script>
    <div class="norecord modal fade" id="smart_edu" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog  ">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" align="center" >Smart Education </h4>
                </div>
                <div class="modal-body">

                    <ul class="col-md-4 treeview-menu1">


                        <li class="info-box  "><a  href="<?=base_url('parent/parents/digital_learning')?>" > Digital Learning </a></li>
                        <li class="info-box  "><a   href="<?=base_url('parent/parents/youtubeVideos')?>" >  Poem / Rhymes  </a></li>

                    </ul>
                    <ul class="col-md-4 treeview-menu1">



                        <li class="info-box  "><a href="<?=base_url('parent/parents/games')?>">    Games</a></li>

                    </ul>
                    <ul class="col-md-4 treeview-menu1">


                        <li class="info-box  "><a href=" ">    Short Course</a></li>

                    </ul>



                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line('close'); ?></button>
                </div>
            </div>
        </div>
    </div>
    <div class="norecord modal fade" id="microsoft" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog  ">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" align="center" >Microsoft</h4>
                </div>
                <div class="modal-body">
                    <ul class="col-md-4 treeview-menu1">


                        <li class="info-box  "><a href="https://outlook.office365.com/" target="_blank" > Outlook</a></li>
                        <li class="info-box  "><a  href="https://teams.microsoft.com/" target="_blank"> Microsoft Teams</a></li>


                    </ul>
                    <ul class="col-md-4 treeview-menu1">

                        <li class="info-box  "><a href="https://www.office.com/launch/word" target="_blank"> Word</a></li>
                        <li class="info-box  "><a   href="https://www.office.com/launch/excel?auth=2" target="_blank" > Excel</a></li>


                    </ul>
                    <ul class="col-md-4 treeview-menu1">

                        <li class="info-box  "><a href="https://www.office.com/launch/powerpoint?auth=2" target="_blank"  >    PowerPoint</a></li>
                        <li class="info-box  "><a href="https://www.onenote.com/classnotebook/signin?omkt=en-US" target="_blank" > Class Notebook</a></li>

                    </ul>





                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line('close'); ?></button>
                </div>
            </div>
        </div>
    </div>









