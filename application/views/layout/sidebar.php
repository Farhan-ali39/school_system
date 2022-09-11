<style>
    .dropdown-menu[x-placement^=bottom], .dropdown-menu[x-placement^=left], .dropdown-menu[x-placement^=right], .dropdown-menu[x-placement^=top] {
        right: auto;
        bottom: auto;
    }
    .dropdown-menu-right {
        /*right: 0;*/
        /*left: auto;*/
    }
    .dropdown-menu {
        /*position: absolute;*/
        /*top: 100%;*/
        /*left: 0;*/
        z-index: 1000;
        display: none;
        float: left;
        min-width: 11.25rem;
        padding: .5rem 0;
        margin: .125rem 0 0;
        font-size: 12px;
        color: #333;
        text-align: left;
        list-style: none;
        background-color: #fff;
        background-clip: padding-box;
        border: 1px solid rgba(0,0,0,.15);
        border-radius: .1875rem;
        box-shadow: 0 0.25rem 0.5rem rgba(0,0,0,.1);
    }
    .dropdown-item {
        /*display: -ms-flexbox;*/
        display: flex;
        /*-ms-flex-align: center;*/
        align-items: center;
        position: relative;
        outline: 0;
        overflow: hidden;
        text-overflow: ellipsis;
        cursor: pointer;
        margin-bottom: 0;
        transition: background-color ease-in-out .15s,color ease-in-out .15s;
    }

    .dropdown-item {
        /*display: block;*/
        width: 100%;
        padding: .5rem 1rem;
        clear: both;
        font-weight: 400;
        color: #333;
        text-align: inherit;
        white-space: nowrap;
        background-color: transparent;
        border: 0;
    }
    .treeview-menu1 {
        /*display: none;*/
        list-style: none;
        padding: 0;
        margin: 0;
        padding-left: 0px;
    }
    .treeview-menu1>li>a {
        color: #404040;
    }

    .treeview-menu1>li>a {
        padding: 5px 5px 5px 15px;
        display: block;
        font-size: 10pt;
        font-family: 'Roboto';
    }
    /*.treeview-menu1>li.active>a,   .treeview-menu1>li>a:hover {*/
    /*color: #f7f7f7;*/
    /*background-color: #3b4e9c;*/
    /*text-decoration: none;*/
    /*}*/
    .modal-body
    {
        min-height: 100px;
    }
    .treeview-menu1 .info-box
    {
        min-height: 0px;
    }

    .verttop {
        padding-top: 11px ;
    }
</style>

<aside class="main-sidebar" id="alert2">
    <?php if ($this->rbac->hasPrivilege('student', 'can_view')) { ?>
        <form class="navbar-form navbar-left search-form2" role="search"  action="<?php echo site_url('admin/admin/search'); ?>" method="POST">
            <?php echo $this->customlib->getCSRF(); ?>
            <div class="input-group ">

                <input type="text"  name="search_text" class="form-control search-form" placeholder="<?php echo $this->lang->line('search_by_student_name'); ?>">
                <span class="input-group-btn">
                    <button type="submit" name="search" id="search-btn" style="padding: 3px 12px !important;border-radius: 0px 30px 30px 0px; background: #fff;" class="btn btn-flat"><i class="fa fa-search"></i></button>
                </span>
            </div>
        </form>
    <?php } ?>
    <section class="sidebar" id="sibe-box">
<!--        --><?php //$this->load->view('layout/top_sidemenu'); ?>
        <ul class="sidebar-menu verttop ">
            <?php
            if ($this->module_lib->hasActive('front_office')) {
                if (($this->rbac->hasPrivilege('admission_enquiry', 'can_view') ||
                        $this->rbac->hasPrivilege('visitor_book', 'can_view') ||
                        $this->rbac->hasPrivilege('phon_call_log', 'can_view') ||
                        $this->rbac->hasPrivilege('postal_dispatch', 'can_view') ||
                        $this->rbac->hasPrivilege('postal_receive', 'can_view') ||
                        $this->rbac->hasPrivilege('complaint', 'can_view') ||
                        $this->rbac->hasPrivilege('setup_font_office', 'can_view'))) {
                    ?>

                    <li class="treeview <?php echo set_Topmenu('front_office'); ?>  ">
                        <a href="#" class="list-icons-item"    data-toggle="modal" data-target="#receptionDesk" >
                            <i class="fa fa-ioxhost ftlayer"></i> <span><?php echo $this->lang->line('front_office'); ?></span>
                        </a>
<!--                        <div class="dropdown-menu dropdown-menu-right" x-placement="top-end" style="position: fixed; will-change: transform; top: 72px; left: 176px; transform: translate3d(22px, 1px, 0px);">-->



<!--                        </div>-->
                    </li>

                    <?php
                }
            }

            if ($this->module_lib->hasActive('student_information')) {
                if (($this->rbac->hasPrivilege('student', 'can_view') ||
                        $this->rbac->hasPrivilege('student', 'can_add') ||
                        $this->rbac->hasPrivilege('student_history', 'can_view') ||
                        $this->rbac->hasPrivilege('student_categories', 'can_view') ||
                        $this->rbac->hasPrivilege('student_houses', 'can_view') ||
                        $this->rbac->hasPrivilege('disable_student', 'can_view') || $this->rbac->hasPrivilege('disable_reason','can_view') || $this->rbac->hasPrivilege('online_admission', 'can_view') || $this->rbac->hasPrivilege('multiclass_student','can_view') || $this->rbac->hasPrivilege('disable_reason','can_view'))) {
                    ?>


                    <li class="treeview <?php echo set_Topmenu('Student Information'); ?>  ">
                        <a href="#" class="list-icons-item" data-toggle="modal" data-target="#student_information"">
                            <i class="fa fa-user-plus ftlayer"></i> <span><?php echo $this->lang->line('student_information'); ?></span>
                        </a>


                    </li>
                    <?php
                }
            }

            if ($this->module_lib->hasActive('fees_collection')) {
                if (($this->rbac->hasPrivilege('collect_fees', 'can_view') ||
                        $this->rbac->hasPrivilege('search_fees_payment', 'can_view') ||
                        $this->rbac->hasPrivilege('search_due_fees', 'can_view') ||
                        $this->rbac->hasPrivilege('fees_statement', 'can_view')  ||
                        $this->rbac->hasPrivilege('fees_carry_forward', 'can_view') ||
                        $this->rbac->hasPrivilege('fees_master', 'can_view') ||
                        $this->rbac->hasPrivilege('fees_group', 'can_view') ||
                        $this->rbac->hasPrivilege('fees_type', 'can_view') ||
                        $this->rbac->hasPrivilege('fees_discount', 'can_view') ||
                        $this->rbac->hasPrivilege('accountants', 'can_view'))) {
                    ?>
                    <li class="treeview <?php echo set_Topmenu('Fees Collection'); ?>">
                        <a href="#" data-target="#fees_collection" data-toggle="modal">
                            <i class="fa fa-money ftlayer"></i> <span> <?php echo $this->lang->line('fees_collection'); ?></span>
                        </a>
                    </li>
                    <?php
                }
            }
            if ($this->module_lib->hasActive('income')) {
                if (($this->rbac->hasPrivilege('income', 'can_view') ||
                        $this->rbac->hasPrivilege('search_income', 'can_view') ||
                        $this->rbac->hasPrivilege('income_head', 'can_view'))) {
                    ?>

                    <li class="treeview <?php echo set_Topmenu('Income'); ?>">
                        <a href="#" data-target="#income" data-toggle="modal">
                            <i class="fa fa-usd ftlayer"></i> <span><?php echo $this->lang->line('income'); ?></span>
                        </a>
                     </li>
                    <?php
                }
            }
            if ($this->module_lib->hasActive('expense')) {
                if (($this->rbac->hasPrivilege('expense', 'can_view') ||
                        $this->rbac->hasPrivilege('search_expense', 'can_view') ||
                        $this->rbac->hasPrivilege('expense_head', 'can_view'))) {
                    ?>
                    <li class="treeview <?php echo set_Topmenu('Expenses'); ?>">
                        <a href="#" data-target="#expenses" data-toggle="modal">
                            <i class="fa fa-credit-card ftlayer"></i> <span><?php echo $this->lang->line('expenses'); ?></span>
                        </a>
                    </li>
                    <?php
                }
            }

            if ($this->module_lib->hasActive('student_attendance')) {
                if (($this->rbac->hasPrivilege('student_attendance', 'can_view') ||
                        $this->rbac->hasPrivilege('student_attendance_report', 'can_view') ||
                        $this->rbac->hasPrivilege('attendance_report', 'can_view'))) {
                    ?>
                    <li class="treeview <?php echo set_Topmenu('Attendance'); ?>">
                        <a href="#" data-target="#attendance" data-toggle="modal">
                            <i class="fa fa-calendar-check-o ftlayer"></i> <span><?php echo $this->lang->line('attendance'); ?></span>
                        </a>
                    </li>
                    <?php
                }
                ?>

                <?php
            }
            if ($this->module_lib->hasActive('examination')) {
                if (($this->rbac->hasPrivilege('exam_group', 'can_view') ||
                        $this->rbac->hasPrivilege('exam_result', 'can_view') ||
                        $this->rbac->hasPrivilege('design_admit_card','can_view') ||
                        $this->rbac->hasPrivilege('print_admit_card','can_view') ||
                        $this->rbac->hasPrivilege('design_marksheet','can_view') ||
                        $this->rbac->hasPrivilege('print_marksheet','can_view') ||
                        $this->rbac->hasPrivilege('marks_grade', 'can_view')
                    )) {
                    ?>
                    <li class="treeview <?php echo set_Topmenu('Examinations'); ?>">
                        <a href="#" data-target="#examinations" data-toggle="modal">
                            <i class="fa fa-map-o ftlayer"></i> <span><?php echo $this->lang->line('examinations'); ?></span>
                        </a>
                    </li>
                    <?php
                } }
                  if ($this->module_lib->hasActive('online_examination')) {
                    if(($this->rbac->hasPrivilege('online_examination','can_view') || $this->rbac->hasPrivilege('question_bank','can_view'))){
                 ?>
 <li class="treeview <?php echo set_Topmenu('Online_Examinations'); ?>">
                        <a href="#" data-target="#Online_Examinations" data-toggle="modal">
                            <i class="fa fa-rss ftlayer"></i> <span><?php echo $this->lang->line('online')." ".$this->lang->line('examinations'); ?></span>
                        </a>
                    </li>
                <?php
            }}
            if ($this->module_lib->hasActive('academics')) {
                if (($this->rbac->hasPrivilege('class_timetable', 'can_view') ||
                        $this->rbac->hasPrivilege('teachers_timetable', 'can_view') ||
                        $this->rbac->hasPrivilege('assign_class_teacher', 'can_view') ||
                        $this->rbac->hasPrivilege('promote_student', 'can_view') ||
                        $this->rbac->hasPrivilege('subject_group', 'can_view') ||
                        $this->rbac->hasPrivilege('section', 'can_view') || 
                        $this->rbac->hasPrivilege('subject', 'can_view') ||
                        $this->rbac->hasPrivilege('class', 'can_view') || 
                        $this->rbac->hasPrivilege('section', 'can_view')
                        )) {
                    ?>
                    <li class="treeview <?php echo set_Topmenu('Academics'); ?>">
                        <a href="#" data-target="#academics" data-toggle="modal">
                            <i class="fa fa-mortar-board ftlayer"></i> <span><?php echo $this->lang->line('academics'); ?></span>
                        </a>
                    </li>
                    <?php
                }
            }
            if ($this->module_lib->hasActive('human_resource')) {
                if (($this->rbac->hasPrivilege('staff', 'can_view') ||
                        
                        $this->rbac->hasPrivilege('approve_leave_request', 'can_view') ||
                        $this->rbac->hasPrivilege('apply_leave', 'can_view') ||
                        $this->rbac->hasPrivilege('leave_types', 'can_view') ||
                        $this->rbac->hasPrivilege('teachers_rating','can_view') ||
                        $this->rbac->hasPrivilege('department', 'can_view') ||
                        $this->rbac->hasPrivilege('designation', 'can_view') ||
                        $this->rbac->hasPrivilege('disable_staff', 'can_view'))) {
                    ?>
                    <li class="treeview <?php echo set_Topmenu('HR'); ?>">
                        <a href="#" data-target="#human_resource" data-toggle="modal">
                            <i class="fa fa-sitemap ftlayer"></i> <span><?php echo $this->lang->line('human_resource'); ?></span>
                        </a>
                    </li>
                    <?php
                }
            }

            if ($this->module_lib->hasActive('communicate')) {
                if (($this->rbac->hasPrivilege('notice_board', 'can_view') ||
                        $this->rbac->hasPrivilege('email', 'can_view') ||
                        $this->rbac->hasPrivilege('sms', 'can_view') ||
                        $this->rbac->hasPrivilege('email_sms_log', 'can_view'))) {
                    ?>
                    <li class = "treeview <?php echo set_Topmenu('Communicate'); ?>">
                        <a href = "#" data-target="#communicate" data-toggle="modal">
                            <i class="fa fa-bullhorn ftlayer"></i> <span><?php echo $this->lang->line('communicate');
                    ?></span>
                        </a>
                    </li>
                    <?php
                }
            }
            if ($this->module_lib->hasActive('download_center')) {
                if (($this->rbac->hasPrivilege('upload_content', 'can_view'))) {
                    ?>
                    <li class="treeview <?php echo set_Topmenu('Download Center'); ?>">
                        <a href="#" data-target="#download_center" data-toggle="modal">
                            <i class="fa fa-download ftlayer"></i> <span><?php echo $this->lang->line('download_center'); ?></span>
                        </a>
                    </li>
                    <?php
                }
            }

            if ($this->module_lib->hasActive('homework')) {
                if (($this->rbac->hasPrivilege('homework', 'can_view'))) {
                    ?>
                    <li class="treeview <?php echo set_Topmenu('Homework'); ?>">
                        <a href="#" data-target="#homework" data-toggle="modal">
                            <i class="fa fa-flask ftlayer"></i> <span><?php echo $this->lang->line('homework'); ?></span>
                        </a>
                    </li>
                    <?php
                }
            }
            if ($this->module_lib->hasActive('library')) {
                if (($this->rbac->hasPrivilege('books', 'can_view') ||
                       
                        $this->rbac->hasPrivilege('issue_return', 'can_view') ||
                        $this->rbac->hasPrivilege('add_staff_member', 'can_view') ||
                        $this->rbac->hasPrivilege('add_student', 'can_view')
                        )) {
                    ?>
                    <li class="treeview <?php echo set_Topmenu('Library'); ?>">
                        <a href="#" data-target="#library" data-toggle="modal">
                            <i class="fa fa-book ftlayer"></i> <span><?php echo $this->lang->line('library'); ?></span>
                        </a>
                    </li>
                    <?php
                } 
            }

            if ($this->module_lib->hasActive('inventory')) {
                if (($this->rbac->hasPrivilege('issue_item', 'can_view') ||
                        $this->rbac->hasPrivilege('item_stock', 'can_view') ||
                        $this->rbac->hasPrivilege('item', 'can_view') ||
                        $this->rbac->hasPrivilege('item_category', 'can_view') ||
                        $this->rbac->hasPrivilege('item_category', 'can_view') ||
                        $this->rbac->hasPrivilege('store', 'can_view') ||
                        $this->rbac->hasPrivilege('supplier', 'can_view'))) {
                    ?>
                    <li class="treeview <?php echo set_Topmenu('Inventory'); ?>">
                        <a href="#" data-target="#inventory" data-toggle="modal">
                            <i class="fa fa-object-group ftlayer"></i> <span><?php echo $this->lang->line('inventory'); ?></span>
                        </a>
                    </li>
                    <?php
                }
            }
            if ($this->module_lib->hasActive('transport')) {
                if (($this->rbac->hasPrivilege('routes', 'can_view') ||
                        $this->rbac->hasPrivilege('vehicle', 'can_view') ||
                        $this->rbac->hasPrivilege('assign_vehicle', 'can_view') ||
                        $this->rbac->hasPrivilege('assign_vehicle', 'can_view'))) {
                    ?>
                    <li class="treeview <?php echo set_Topmenu('Transport'); ?>">
                        <a href="#" data-target="#transport" data-toggle="modal">
                            <i class="fa fa-bus ftlayer"></i> <span><?php echo $this->lang->line('transport'); ?></span>
                        </a>
                    </li>


                    <?php
                }
            }
            if ($this->module_lib->hasActive('hostel')) {
                if (($this->rbac->hasPrivilege('hostel_rooms', 'can_view') ||
                        $this->rbac->hasPrivilege('room_type', 'can_view') ||
                        $this->rbac->hasPrivilege('hostel', 'can_view'))) {
                    ?>

                    <li class="treeview <?php echo set_Topmenu('Hostel'); ?>">
                        <a href="#" data-target="#hostel" data-toggle="modal" >
                            <i class="fa fa-building-o ftlayer"></i> <span><?php echo $this->lang->line('hostel'); ?></span>
                        </a>
                    </li>

                    <?php
                }
            }
            if ($this->module_lib->hasActive('certificate')) {
                if (($this->rbac->hasPrivilege('student_certificate', 'can_view') ||
                        $this->rbac->hasPrivilege('generate_certificate', 'can_view') ||
                        $this->rbac->hasPrivilege('student_id_card', 'can_view') ||
                        $this->rbac->hasPrivilege('generate_id_card', 'can_view'))) {
                    ?>


                    <li class="treeview <?php echo set_Topmenu('Certificate'); ?>">
                        <a href="#" data-target="#certificate" data-toggle="modal">
                            <i class="fa fa-newspaper-o ftlayer"></i> <span><?php echo $this->lang->line('certificate'); ?></span>
                        </a>
                    </li>
                    <?php
                }
            }
            if ($this->module_lib->hasActive('front_cms')) {
                if (($this->rbac->hasPrivilege('event', 'can_view') ||
                        $this->rbac->hasPrivilege('gallery', 'can_view') ||
                        $this->rbac->hasPrivilege('notice', 'can_view') ||
                        $this->rbac->hasPrivilege('media_manager', 'can_view') ||
                        $this->rbac->hasPrivilege('pages', 'can_view') ||
                        $this->rbac->hasPrivilege('menus', 'can_view') ||
                        $this->rbac->hasPrivilege('banner_images', 'can_view'))) {
                    ?>
                    <li class="treeview <?php echo set_Topmenu('Front CMS'); ?>">
                        <a href="#" data-target="#front_cms" data-toggle="modal">
                            <i class="fa fa-empire ftlayer"></i> <span><?php echo $this->lang->line('front_cms'); ?></span>
                        </a>
                    </li>
                    <?php
                }
            }
            ?>

            <?php
            if ($this->module_lib->hasActive('reports')) {
                if (($this->rbac->hasPrivilege('student_report', 'can_view') ||
                        $this->rbac->hasPrivilege('guardian_report', 'can_view') ||
                        $this->rbac->hasPrivilege('student_history', 'can_view') ||
                        $this->rbac->hasPrivilege('student_login_credential_report', 'can_view') ||
                        $this->rbac->hasPrivilege('class_subject_report', 'can_view') ||
                        $this->rbac->hasPrivilege('admission_report', 'can_view') ||
                        $this->rbac->hasPrivilege('sibling_report', 'can_view') ||
                        $this->rbac->hasPrivilege('evaluation_report', 'can_view') ||
                        $this->rbac->hasPrivilege('student_profile', 'can_view') ||
                        $this->rbac->hasPrivilege('fees_statement', 'can_view') ||
                        $this->rbac->hasPrivilege('balance_fees_report', 'can_view') ||
                        $this->rbac->hasPrivilege('fees_collection_report', 'can_view') ||
                        $this->rbac->hasPrivilege('online_fees_collection_report', 'can_view') ||
                        $this->rbac->hasPrivilege('income_report', 'can_view') ||
                        $this->rbac->hasPrivilege('expense_report', 'can_view') ||
                        $this->rbac->hasPrivilege('payroll_report', 'can_view') ||
                        $this->rbac->hasPrivilege('income_group_report', 'can_view') ||
                        $this->rbac->hasPrivilege('expense_group_report', 'can_view') ||
                        $this->rbac->hasPrivilege('attendance_report', 'can_view') ||
                        $this->rbac->hasPrivilege('staff_attendance_report', 'can_view') ||
                        $this->rbac->hasPrivilege('exam_marks_report', 'can_view') ||
                        $this->rbac->hasPrivilege('online_exam_wise_report', 'can_view') ||
                        $this->rbac->hasPrivilege('online_exams_report', 'can_view') ||
                        $this->rbac->hasPrivilege('online_exams_attempt_report', 'can_view') ||
                        $this->rbac->hasPrivilege('online_exams_rank_report', 'can_view') ||
                        $this->rbac->hasPrivilege('payroll_report', 'can_view') ||
                        $this->rbac->hasPrivilege('transport_report', 'can_view') ||
                        $this->rbac->hasPrivilege('hostel_report', 'can_view') ||
                        $this->rbac->hasPrivilege('audit_trail_report', 'can_view') ||
                        $this->rbac->hasPrivilege('user_log', 'can_view') ||
                        $this->rbac->hasPrivilege('book_issue_report', 'can_view') ||
                        $this->rbac->hasPrivilege('book_due_report', 'can_view') ||
                        $this->rbac->hasPrivilege('book_inventory_report', 'can_view') ||
                        $this->rbac->hasPrivilege('stock_report', 'can_view') ||
                        $this->rbac->hasPrivilege('add_item_report', 'can_view') ||
                        $this->rbac->hasPrivilege('issue_inventory_report', 'can_view'))) {
                    ?>
                    <li class="treeview <?php echo set_Topmenu('Reports'); ?>">
                        <a href="#" data-target="#reports" data-toggle="modal">
                            <i class="fa fa-line-chart ftlayer"></i> <span><?php echo $this->lang->line('reports'); ?></span>
                        </a>
                    </li>
                    <?php
                }
            }
            if ($this->module_lib->hasActive('system_settings')) {
                if (($this->rbac->hasPrivilege('general_setting', 'can_edit') ||
                        $this->rbac->hasPrivilege('session_setting', 'can_view') ||
                        $this->rbac->hasPrivilege('notification_setting', 'can_edit') ||
                        $this->rbac->hasPrivilege('sms_setting', 'can_edit') ||
                        $this->rbac->hasPrivilege('email_setting', 'can_edit') ||
                        $this->rbac->hasPrivilege('payment_methods', 'can_edit') ||
                        $this->rbac->hasPrivilege('languages', 'can_view') ||
                        $this->rbac->hasPrivilege('languages', 'can_add') ||
                        $this->rbac->hasPrivilege('backup_restore', 'can_view') ||
                        $this->rbac->hasPrivilege('front_cms_setting', 'can_edit'))) {
                    ?>

                    <li class="treeview <?php echo set_Topmenu('System Settings'); ?>">
                        <a href="#" data-target="#system_settings" data-toggle="modal" >
                            <i class="fa fa-gears ftlayer"></i> <span><?php echo $this->lang->line('system_settings'); ?></span>
                        </a>
                    </li>
                    <?php
                }
            }
            ?>
        </ul>
    </section>
</aside>
<style>
    .treeview-menu1 {
        /*display: none;*/
        list-style: none;
        padding: 0;
        margin: 0;
        padding-left: 0px;
    }
      .treeview-menu1>li>a {
        color: #404040;
    }

      .treeview-menu1>li>a {
        padding: 5px 5px 5px 15px;
        display: block;
        font-size: 10pt;
        font-family: 'Roboto';
    }
      /*.treeview-menu1>li.active>a,   .treeview-menu1>li>a:hover {*/
        /*color: #f7f7f7;*/
        /*background-color: #3b4e9c;*/
        /*text-decoration: none;*/
    /*}*/
    .modal-body
    {
        min-height: 100px;
    }
   .treeview-menu1 .info-box
    {
        min-height: 0px;
    }
</style>

<div class="norecord modal fade" id="receptionDesk" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog  ">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" align="center" > <?php echo $this->lang->line('front_office'); ?> </h4>
            </div>
            <div class="modal-body">

                <ul class="col-md-3 treeview-menu1 ">
                    <?php if ($this->rbac->hasPrivilege('admission_enquiry', 'can_view')) { ?>

                        <li class="info-box <?php echo set_Submenu('admin/enquiry'); ?>"><a href="<?php echo base_url(); ?>admin/enquiry"> <?php echo $this->lang->line('admission_enquiry'); ?> </a></li>

                        <?php
                    }
                    if ($this->rbac->hasPrivilege('visitor_book', 'can_view')) {
                        ?>
                        <li class="info-box <?php echo set_Submenu('admin/visitors'); ?>"><a href="<?php echo base_url(); ?>admin/visitors"> <?php echo $this->lang->line('visitor_book'); ?></a></li>

                        <?php
                    }
                    ?>
                </ul>
                <ul class="col-md-3 treeview-menu1 ">
                    <?php
                    if ($this->rbac->hasPrivilege('phone_call_log', 'can_view')) {
                        ?>

                        <li class="info-box <?php echo set_Submenu('admin/generalcall'); ?>"><a href="<?php echo base_url(); ?>admin/generalcall"> <?php echo $this->lang->line('phone_call_log'); ?></a></li>

                        <?php
                    }
                    if ($this->rbac->hasPrivilege('postal_dispatch', 'can_view')) {
                        ?>

                        <li class="info-box <?php echo set_Submenu('admin/dispatch'); ?>"><a href="<?php echo base_url(); ?>admin/dispatch"> <?php echo $this->lang->line('postal_dispatch'); ?></a></li>

                        <?php
                    }
                    ?>
                </ul>
                <ul class="col-md-3 treeview-menu1 ">
                    <?php
                    if ($this->rbac->hasPrivilege('postal_receive', 'can_view')) {
                        ?>

                        <li class="info-box <?php echo set_Submenu('admin/receive'); ?>"><a href="<?php echo base_url(); ?>admin/receive"> <?php echo $this->lang->line('postal_receive'); ?></a></li>

                        <?php
                    }
                    if ($this->rbac->hasPrivilege('complaint', 'can_view')) {
                        ?>

                        <li class="info-box <?php echo set_Submenu('admin/complaint'); ?>"><a href="<?php echo base_url(); ?>admin/complaint"> <?php echo $this->lang->line('complain'); ?></a></li>

                        <?php
                    }
                    ?>
                </ul>
                <ul class="col-md-3 treeview-menu1 ">
                    <?php
                    if ($this->rbac->hasPrivilege('setup_font_office', 'can_view')) {
                        ?>

                        <li class="info-box <?php echo set_Submenu('admin/visitorspurpose'); ?>"><a href="<?php echo base_url(); ?>admin/visitorspurpose"> <?php echo $this->lang->line('setup_front_office'); ?></a></li>

                    <?php } ?>
                </ul>

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line('close'); ?></button>
            </div>
        </div>
    </div>
</div>
<div class="norecord modal fade" id="student_information" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog  ">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" align="center" > <?php echo $this->lang->line('student_information'); ?> </h4>
            </div>
            <div class="modal-body">

                <ul class="col-md-4 treeview-menu1  ">
                    <?php
                    if ($this->rbac->hasPrivilege('student', 'can_view')) {
                        ?>

                        <li class="info-box <?php echo set_Submenu('student/search'); ?>"><a href="<?php echo base_url(); ?>student/search"> <?php echo $this->lang->line('student_details'); ?></a></li>

                        <?php
                    }

                    if ($this->rbac->hasPrivilege('student', 'can_add')) {
                        ?>

                        <li class="info-box <?php echo set_Submenu('student/create'); ?>"><a href="<?php echo base_url(); ?>student/create"> <?php echo $this->lang->line('student_admission'); ?></a></li>
                    <?php } ?><?php
                    if ($this->module_lib->hasActive('online_admission')) {
                        if ($this->rbac->hasPrivilege('online_admission', 'can_view')) { ?>

                            <li class="info-box <?php echo set_Submenu('onlinestudent'); ?>"><a href="<?php echo site_url('admin/onlinestudent'); ?>"> <?php echo $this->lang->line('online') . " " . $this->lang->line('admission'); ?></a></li>

                            <?php
                        } }

                        ?>
                </ul>
                <ul class="col-md-4 treeview-menu1  " >
                    <?php

                    if ($this->rbac->hasPrivilege('disable_student', 'can_view')) {
                        ?>
                        <li class="info-box <?php echo set_Submenu('student/disablestudentslist'); ?>"><a href="<?php echo base_url(); ?>student/disablestudentslist"> <?php echo $this->lang->line('disabled_students'); ?></a></li>
                        <?php
                    }
                    if ($this->module_lib->hasActive('multi_class')) {
                        if($this->rbac->hasPrivilege('multi_class_student','can_view')){
                            ?>
                            <li class="info-box <?php echo set_Submenu('student/multiclass'); ?>"><a href="<?php echo base_url(); ?>student/multiclass"> <?php echo $this->lang->line('multiclass') . " " . $this->lang->line('student'); ?></a></li>
                            <?php
                        } }
                    if($this->rbac->hasPrivilege('student','can_delete')){
                        ?>
                        <li class="info-box <?php echo set_Submenu('bulkdelete'); ?>"><a href="<?php echo site_url('student/bulkdelete'); ?>"> <?php echo $this->lang->line('bulk') . " " . $this->lang->line('delete'); ?></a>
                        </li>
                        <?php
                    }

                    ?>
                </ul>
                <ul class="col-md-4 treeview-menu1  " >
                    <?php
                    if ($this->rbac->hasPrivilege('student_categories', 'can_view')) {
                        ?>

                        <li class=" info-box <?php echo set_Submenu('category/index'); ?>"><a href="<?php echo base_url(); ?>category"> <?php echo $this->lang->line('student_categories'); ?></a></li>

                    <?php }
                    ?>
                    <?php
                    if ($this->rbac->hasPrivilege('student_houses', 'can_view')) {
                        ?>
                        <li class="info-box <?php echo set_Submenu('admin/schoolhouse'); ?>"><a href="<?php echo base_url(); ?>admin/schoolhouse"> <?php echo $this->lang->line('house'); ?></a></li>
                        <?php
                    }

                    if($this->rbac->hasPrivilege('disable_reason','can_view')){
                        ?>
                        <li class="info-box <?php echo set_Submenu('student/disable_reason'); ?>"><a href="<?php echo base_url(); ?>admin/disable_reason"> <?php echo $this->lang->line('disable') . " " . $this->lang->line('reason'); ?></a></li>
                        <?php
                    }
                    ?>



                </ul>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line('close'); ?></button>
            </div>
        </div>
    </div>
</div>
<div class="norecord modal fade" id="fees_collection" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog  ">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" align="center" > <?php echo $this->lang->line('fees_collection'); ?> </h4>
            </div>
            <div class="modal-body">
                <ul class="col-md-4 treeview-menu1">
                    <?php
                    if ($this->rbac->hasPrivilege('collect_fees', 'can_view')) { ?>
                        <li class="info-box <?php echo set_Submenu('studentfee/assignFee'); ?>"><a href="<?php echo base_url(); ?>studentfee/assignFee"> Assign Fee</a></li>
                        <?php
                    }
                    if ($this->rbac->hasPrivilege('collect_fees', 'can_view')) { ?>
                        <li class="info-box <?php echo set_Submenu('studentfee/check_assignFee'); ?>"><a href="<?php echo base_url(); ?>studentfee/check_assignFee">Check Assign Fee</a></li>
                        <?php
                    }
                    //                            if ($this->rbac->hasPrivilege('collect_fees', 'can_view')) { ?>
                    <!--                                <li class="info-box --><?php //echo set_Submenu('studentfee/index'); ?><!--"><a href="--><?php //echo base_url(); ?><!--studentfee"> --><?php //echo $this->lang->line('collect_fees'); ?><!--</a></li>-->
                    <!--                                --><?php
                    //                            }
                    if ($this->rbac->hasPrivilege('collect_fees', 'can_view')) { ?>
                        <li class="info-box <?php echo set_Submenu('studentfee/FeeVouchers'); ?>"><a href="<?php echo base_url(); ?>studentfee/FeeVouchers">Print Voucher</a></li>
                        <?php
                    }
                    if ($this->rbac->hasPrivilege('collect_fees', 'can_view')) { ?>
                        <li class="info-box <?php echo set_Submenu('studentfee/feeType'); ?>"><a href="<?php echo base_url(); ?>studentfee/feeType"> <?php echo $this->lang->line('fees_type'); ?></a></li>
                        <?php
                    }


                    if ($this->rbac->hasPrivilege('collect_fees', 'can_view')) { ?>
                        <li class="info-box <?php echo set_Submenu('studentfee/feeCollectionSearch'); ?>"><a href="<?php echo base_url(); ?>studentfee/feeCollectionSearch"><?php echo $this->lang->line('collect_fees'); ?></a></li>
                        <?php
                    }
                    if ($this->rbac->hasPrivilege('collect_fees', 'can_view')) { ?>
                        <li class="info-box <?php echo set_Submenu('studentfee/feeCollectionSearch'); ?>"><a href="<?php echo base_url(); ?>studentfee/stdDiscountsearch">Search Fee Discount</a></li>
                        <?php
                    }
                    if ($this->rbac->hasPrivilege('collect_fees', 'can_view')) { ?>
                        <li class="info-box <?php echo set_Submenu('studentfee/bank_transfer'); ?>"><a href="<?php echo base_url(); ?>studentfee/bank_transfer">Bank Transfer  </a></li>
                        <?php
                    }

                     ?>
                </ul>
                <ul class="col-md-4 treeview-menu1">
                    <?php


                    if ($this->rbac->hasPrivilege('search_fees_payment', 'can_view')) {
                        ?>
                        <li class="info-box <?php echo set_Submenu('studentfee/searchpayment'); ?>"><a href="<?php echo base_url(); ?>studentfee/searchpayment"> <?php echo $this->lang->line('search_fees_payment'); ?></a></li>
                        <?php
                    }
                    if ($this->rbac->hasPrivilege('search_due_fees', 'can_view')) {
                        ?>
                        <li class="info-box <?php echo set_Submenu('studentfee/feesearch'); ?>"><a href="<?php echo base_url(); ?>studentfee/feesearch"> <?php echo $this->lang->line('search_due_fees'); ?> </a></li>
                        <?php
                    }

                    if ($this->rbac->hasPrivilege('fees_master', 'can_view')) {
                        ?>
                        <li class="info-box <?php echo set_Submenu('admin/feemaster'); ?>"><a href="<?php echo base_url(); ?>admin/feemaster"> <?php echo $this->lang->line('fees_master'); ?></a></li>
                        <?php
                    }

                    if ($this->rbac->hasPrivilege('fees_group', 'can_view')) {
                        ?>
                        <li class="info-box <?php echo set_Submenu('admin/feegroup'); ?>"><a href="<?php echo base_url(); ?>admin/feegroup"> <?php echo $this->lang->line('fees_group'); ?></a></li>
                        <?php
                    }

                    if ($this->rbac->hasPrivilege('collect_fees', 'can_view')) { ?>
                        <li class="info-box <?php echo set_Submenu('studentfee/feeCollectionSearch'); ?>"><a href="<?php echo base_url(); ?>studentfee/stdInstallmentSearch">Search Fee Installment</a></li>
                        <?php
                    }
                    if ($this->rbac->hasPrivilege('collect_fees', 'can_view')) { ?>
                        <li class="info-box <?php echo set_Submenu('studentfee/withdraw'); ?>"><a href="<?php echo base_url(); ?>studentfee/withdraw">Withdraw/Investment </a></li>
                        <?php
                    }
                    if ($this->rbac->hasPrivilege('collect_fees', 'can_view')) { ?>
                        <li class="info-box <?php echo set_Submenu('studentfee/cash_addon'); ?>"><a href="<?php echo base_url(); ?>studentfee/cash_addon">Cash Addon  </a></li>
                        <?php
                    }

                    //                            if ($this->rbac->hasPrivilege('fees_type', 'can_view')) {
                    //                                ?>
                    <!--                                <li class="info-box --><?php //echo set_Submenu('feetype/index'); ?><!--"><a href="--><?php //echo base_url(); ?><!--admin/feetype"> --><?php //echo $this->lang->line('fees_type'); ?><!--</a></li>-->
                    <!--                                --><?php
                    //                            }

                    ?>
                </ul>
                <ul class="col-md-4 treeview-menu1">
                    <?php
//                    if ($this->rbac->hasPrivilege('fees_discount', 'can_view')) {
//                        ?>
<!--                        <li class="info-box --><?php //echo set_Submenu('admin/feediscount'); ?><!--"><a href="--><?php //echo base_url(); ?><!--admin/feediscount"> --><?php //echo $this->lang->line('fees_discount'); ?><!--</a></li>-->
<!--                        --><?php
//                    }
                    if ($this->rbac->hasPrivilege('fees_discount', 'can_view')) {
                        ?>
                        <li class="info-box <?php echo set_Submenu('admin/feediscount'); ?>"><a href="<?php echo base_url(); ?>admin/feediscount/feediscounts"> <?php echo $this->lang->line('fees_discount'); ?></a></li>
                        <?php
                    }
                    if ($this->rbac->hasPrivilege('fees_carry_forward', 'can_view')) {
                        ?>
                        <li class="info-box <?php echo set_Submenu('feesforward/index'); ?>"><a href="<?php echo base_url('admin/feesforward'); ?>"> <?php echo $this->lang->line('fees_carry_forward'); ?></a></li>
                        <?php
                    }

                    if($this->rbac->hasPrivilege('fees_reminder','can_view')){
                        ?>
                        <li class="info-box <?php echo set_Submenu('feereminder/setting'); ?>"><a href="<?php echo site_url('admin/feereminder/setting'); ?>"> <?php echo $this->lang->line('fees') . " " . $this->lang->line('reminder'); ?></a></li>
                        <?php
                    }
                    if($this->rbac->hasPrivilege('feefine','can_view')){
                        ?>
                        <li class="info-box <?php echo set_Submenu('studentfee/feefine'); ?>"><a href="<?php echo site_url('studentfee/feefine'); ?>">Fee Fine</a></li>
                        <?php
                    }
                    if ($this->rbac->hasPrivilege('collect_fees', 'can_view')) { ?>
                        <li class="info-box <?php echo set_Submenu('studentfee/bank_amount'); ?>"><a href="<?php echo base_url(); ?>studentfee/bank_amount"><?php echo $this->lang->line('bank'). " " .$this->lang->line('amount'); ?>  </a></li>
                        <?php
                    }
                    if ($this->rbac->hasPrivilege('collect_fees', 'can_view')) { ?>
                        <li class="info-box <?php echo set_Submenu('studentfee/cash_deposit'); ?>"><a href="<?php echo base_url(); ?>studentfee/cash_deposit"><?php echo $this->lang->line('cash'). " " .$this->lang->line('deposit'); ?>  </a></li>
                        <?php
                    }
                    if ($this->rbac->hasPrivilege('collect_fees', 'can_view')) { ?>
                        <li class="info-box <?php echo set_Submenu('studentfee/feeRegister'); ?>"><a href="<?php echo base_url(); ?>studentfee/feeRegister">Fee Register </a></li>
                        <?php
                    }

                    ?>

                </ul>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line('close'); ?></button>
            </div>
        </div>
    </div>
</div>
<div class="norecord modal fade" id="income" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog  ">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" align="center" > <?php echo $this->lang->line('income'); ?> </h4>
            </div>
            <div class="modal-body">
                <ul class="col-md-4 treeview-menu1">
                    <?php if ($this->rbac->hasPrivilege('income', 'can_view')) { ?>
                        <li class="info-box <?php echo set_Submenu('income/index'); ?>"><a href="<?php echo base_url(); ?>admin/income"><?php echo $this->lang->line('add_income'); ?></a></li>
                        <?php
                    }
                    ?>
                </ul>
                <ul class="col-md-4 treeview-menu1">
                    <?php
                    if ($this->rbac->hasPrivilege('search_income', 'can_view')) {
                        ?>
                        <li class="info-box <?php echo set_Submenu('income/incomesearch'); ?>"><a href="<?php echo base_url(); ?>admin/income/incomesearch"><?php echo $this->lang->line('search_income'); ?></a></li>
                        <?php
                    }
                    ?>
                </ul>
                <ul class="col-md-4 treeview-menu1">
                    <?php
                    if ($this->rbac->hasPrivilege('income_head', 'can_view')) {
                        ?>
                        <li class="info-box <?php echo set_Submenu('incomeshead/index'); ?>"><a href="<?php echo base_url(); ?>admin/incomehead"><?php echo $this->lang->line('income_head'); ?></a></li>
                    <?php } ?>
                </ul>
             </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line('close'); ?></button>
            </div>
        </div>
    </div>
</div>
<div class="norecord modal fade" id="attendance" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog  ">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" align="center" > <?php echo $this->lang->line('attendance'); ?> </h4>
            </div>
            <div class="modal-body">
                <ul class="ol-md-4 treeview-menu1">
                    <?php
                    if (!is_subAttendence()) {
                    if ($this->rbac->hasPrivilege('student_attendance', 'can_view')) {
                        ?>
                        <li class=" info-box <?php echo set_Submenu('stuattendence/index'); ?>"><a href="<?php echo base_url(); ?>admin/stuattendence"> <?php echo $this->lang->line('student_attendance'); ?></a></li>
                        <?php
                    }
                    if ($this->rbac->hasPrivilege('attendance_by_date', 'can_view')) {
                        ?>
                        <li class=" info-box <?php echo set_Submenu('stuattendence/attendenceReport'); ?>"><a href="<?php echo base_url(); ?>admin/stuattendence/attendencereport"> <?php echo $this->lang->line('attendance_by_date'); ?></a></li>
                        <?php
                    }
                    ?>
                </ul>
                <ul class="col-md-4 treeview-menu1">
                    <?php
                    } else {
                        if ($this->rbac->hasPrivilege('student_attendance', 'can_view')) {
                            ?>
                            <li class=" info-box <?php echo set_Submenu('subjectattendence/index'); ?>"><a href="<?php echo base_url(); ?>admin/subjectattendence"> <?php echo $this->lang->line('period') . " " . $this->lang->line('attendance'); ?></a></li>
                            <?php
                        }
                        if ($this->rbac->hasPrivilege('attendance_by_date', 'can_view')) {
                            ?>


                            <li class=" info-box <?php echo set_Submenu('subjectattendence/reportbydate'); ?>"><a href="<?php echo site_url('admin/subjectattendence/reportbydate'); ?>"> <?php echo $this->lang->line('period') . " " . $this->lang->line('attendance') . " " . $this->lang->line('by') . " " . $this->lang->line('date'); ?></a></li>

                            <?php
                        } }
                    ?>
                </ul>
                <ul class="col-md-4 treeview-menu1">
                    <?php
                    if($this->rbac->hasPrivilege('approve_leave','can_view')){
                        ?>


                        <li class=" info-box <?php echo set_Submenu('Attendance/approve_leave'); ?>"><a href="<?php echo base_url(); ?>admin/approve_leave"> <?php echo $this->lang->line('approve') . " " . $this->lang->line('leave'); ?></a></li>
                    <?php } ?>
                </ul>



            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line('close'); ?></button>
            </div>
        </div>
    </div>
</div>
<div class="norecord modal fade" id="expenses" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog  ">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" align="center" > <?php echo $this->lang->line('expenses'); ?> </h4>
            </div>
            <div class="modal-body">
                <ul class="col-md-4 treeview-menu1">
                    <?php if ($this->rbac->hasPrivilege('expense', 'can_view')) { ?>
                        <li class="info-box <?php echo set_Submenu('expense/index'); ?>"><a href="<?php echo base_url(); ?>admin/expense"> <?php echo $this->lang->line('add_expense'); ?></a></li>
                        <?php
                    }
                    ?>
                </ul>
                <ul class="col-md-4 treeview-menu1">
                    <?php
                    if ($this->rbac->hasPrivilege('search_expense', 'can_view')) {
                        ?>
                        <li class="info-box <?php echo set_Submenu('expense/expensesearch'); ?>"><a href="<?php echo base_url(); ?>admin/expense/expensesearch"> <?php echo $this->lang->line('search_expense'); ?></a></li>
                        <?php
                    }
                    ?>
                </ul>
                <ul class="col-md-4 treeview-menu1">
                    <?php
                    if ($this->rbac->hasPrivilege('expense_head', 'can_view')) {
                        ?>
                        <li class="info-box <?php echo set_Submenu('expenseshead/index'); ?>"><a href="<?php echo base_url(); ?>admin/expensehead"> <?php echo $this->lang->line('expense_head'); ?></a></li>
                    <?php } ?>
                </ul>

              </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line('close'); ?></button>
            </div>
        </div>
    </div>
</div>
<div class="norecord modal fade" id="examinations" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog  ">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" align="center" > <?php echo $this->lang->line('examinations'); ?> </h4>
            </div>
            <div class="modal-body">
                <ul class="col-md-4 treeview-menu1">
                    <?php if ($this->rbac->hasPrivilege('exam', 'can_view')) { ?>
                        <li class="info-box <?php echo set_Submenu('exam/index'); ?>"><a href="<?php echo base_url(); ?>admin/exam"> <?php echo $this->lang->line('exam_list'); ?></a></li>
                        <?php
                    }
                    //                              if ($this->rbac->hasPrivilege('exam_group', 'can_view')) { ?>
                    <!--                                <li class="info-box --><?php //echo set_Submenu('Examinations/examgroup'); ?><!--"><a href="--><?php //echo site_url('admin/examgroup'); ?><!--"> --><?php //echo $this->lang->line('exam') . " " . $this->lang->line('group') ?><!--</a></li>-->
                    <!--                                --><?php
                    //                            } ?>
                    <!-- <li class="info-box --><?php //echo set_Submenu('Examinations/Examschedule'); ?><!--"><a href="--><?php //echo site_url('admin/exam_schedule'); ?><!--"> --><?php //echo $this->lang->line('exam_schedule'); ?><!--</a></li>-->
                    <li class="info-box <?php echo set_Submenu('Examinations/Examschedule'); ?>"><a href="<?php echo site_url('admin/examschedule'); ?>"> <?php echo $this->lang->line('exam_schedule'); ?></a></li>
                    <?php
                    //                          if ($this->rbac->hasPrivilege('exam_result', 'can_view')) {
                    //                                ?>
                    <!--                                <li class="info-box --><?php //echo set_Submenu('Examinations/Examresult'); ?><!--"><a href="--><?php //echo site_url('admin/examresult'); ?><!--"> --><?php //echo $this->lang->line('exam') . " " . $this->lang->line('result'); ?><!--</a></li>-->
                    <!--                                --><?php
                    //                            }
                    if ($this->rbac->hasPrivilege('exam_result', 'can_view')) {
                        ?>
                        <?php
                    }
                    ?>
                    <li class="info-box <?php echo set_Submenu('mark/index'); ?>"><a href="<?php echo base_url(); ?>admin/mark"> <?php echo $this->lang->line('marks_register'); ?></a></li>

                </ul>
                <ul class="col-md-4 treeview-menu1">
                    <?php
                    if($this->rbac->hasPrivilege('design_admit_card','can_view')){
                        ?>
                        <li class="info-box <?php echo set_Submenu('Examinations/admitcard'); ?>"><a href="<?php echo base_url(); ?>admin/admitcard"> <?php echo $this->lang->line('design') . " " . $this->lang->line('admit') . " " . $this->lang->line('card'); ?></a></li>
                        <?php
                    }
                    if($this->rbac->hasPrivilege('print_admit_card','can_view')){
                        ?>
                        <li class="info-box <?php echo set_Submenu('Examinations/examresult/admitcard'); ?>"><a href="<?php echo base_url(); ?>admin/examresult/admitcard"> <?php echo $this->lang->line('print') . " " . $this->lang->line('admit') . " " . $this->lang->line('card'); ?></a></li>
                        <?php
                    }
                    //                            if($this->rbac->hasPrivilege('design_marksheet','can_view')){
                    //                                ?>
                    <!--                                <li class="info-box --><?php //echo set_Submenu('Examinations/marksheet'); ?><!--"><a href="--><?php //echo site_url('admin/marksheet'); ?><!--"> --><?php //echo $this->lang->line('design') . " " . $this->lang->line('marksheet') ?><!--</a></li>-->
                    <!--                                --><?php
                    //                            }
                    //                            if($this->rbac->hasPrivilege('print_marksheet','can_view')){
                    //                                ?>
                    <!--                                <li class="info-box --><?php //echo set_Submenu('Examinations/examresult/marksheet'); ?><!--"><a href="--><?php //echo base_url(); ?><!--admin/examresult/marksheet"> --><?php //echo $this->lang->line('print') . " " . $this->lang->line('marksheet'); ?><!--</a></li>-->
                    <!--                                --><?php
                    //                            }

                    if ($this->rbac->hasPrivilege('marks_grade', 'can_view')) {
                        ?>
                        <li class="info-box <?php echo set_Submenu('Examinations/grade'); ?>"><a href="<?php echo base_url(); ?>admin/grade"> <?php echo $this->lang->line('marks_grade'); ?></a></li>
                    <?php }
                    ?>
                </ul>
                <ul class="col-md-4 treeview-menu1">
                    <?php
                    if ($this->rbac->hasPrivilege('exam_result', 'can_view'))
                    {
                        ?>
                        <li class="info-box <?php echo set_Submenu('report/index'); ?>"><a href="<?php echo base_url(); ?>admin/mark/reports">Exam Report</a></li>
                        <?php
                    }
                    ?>



                </ul>



              </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line('close'); ?></button>
            </div>
        </div>
    </div>
</div>
<div class="norecord modal fade" id="Online_Examinations" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog  ">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" align="center" > <?php echo $this->lang->line('online')." ".$this->lang->line('examinations'); ?> </h4>
            </div>
            <div class="modal-body">
                <ul class="col-md-4 treeview-menu1">
                    <?php

                    if($this->rbac->hasPrivilege('online_examination','can_view')){
                        ?>
                        <li class="info-box <?php echo set_Submenu('Online_Examinations/Onlineexam'); ?>"><a href="<?php echo base_url(); ?>admin/onlineexam"> <?php echo $this->lang->line('online') . " " . $this->lang->line('exam'); ?></a></li>
                        <?php
                    }
                    if($this->rbac->hasPrivilege('question_bank','can_view')){
                        ?>
                        <li class="info-box <?php echo set_Submenu('Online_Examinations/question'); ?>"><a href="<?php echo base_url(); ?>admin/question"> <?php echo $this->lang->line('question')." ".$this->lang->line('bank'); ?></a></li>
                        <?php
                    }
                    ?>



                </ul>


              </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line('close'); ?></button>
            </div>
        </div>
    </div>
</div>
<div class="norecord modal fade" id="academics" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog  ">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" align="center" > <?php echo $this->lang->line('academics') ; ?> </h4>
            </div>
            <div class="modal-body">

                <ul class="col-md-4 treeview-menu1">

                    <?php if ($this->rbac->hasPrivilege('class_timetable', 'can_view')) { ?>
                        <li class="info-box <?php echo set_Submenu('Academics/timetable'); ?>"><a href="<?php echo base_url(); ?>admin/timetable/classreport"> <?php echo $this->lang->line('class_timetable'); ?></a></li>
                        <?php
                    }

                    if ($this->rbac->hasPrivilege('teachers_time_table', 'can_view')) {
                        ?>
                        <li class="info-box <?php echo set_Submenu('Academics/timetable/mytimetable'); ?>"><a href="<?php echo base_url(); ?>admin/timetable/mytimetable"> <?php echo $this->lang->line('teachers')." ".$this->lang->line('timetable')?></a></li>
                        <?php
                    }

                    if ($this->rbac->hasPrivilege('assign_class_teacher', 'can_view')) {
                        ?>
                        <li class="info-box <?php echo set_Submenu('admin/teacher/assign_class_teacher'); ?>"><a href="<?php echo base_url(); ?>admin/teacher/assign_class_teacher"> <?php echo $this->lang->line('assign_class_teacher'); ?></a></li>
                        <?php
                    }
                    ?>

                </ul>


                <ul class="col-md-4 treeview-menu1">
                    <?php

                    if ($this->rbac->hasPrivilege('assign_subject', 'can_view')) {
                        ?>
                        <li class="info-box <?php echo set_Submenu('admin/teacher/viewassignteacher'); ?>"><a href="<?php echo base_url(); ?>admin/teacher/viewassignteacher"> <?php echo $this->lang->line('assign_subjects'); ?></a></li>
                        <?php
                    }
                    if ($this->rbac->hasPrivilege('promote_student', 'can_view')) {
                        ?>

                        <li class="info-box <?php echo set_Submenu('stdtransfer/index'); ?>"><a href="<?php echo base_url(); ?>admin/stdtransfer"> <?php echo $this->lang->line('promote_students'); ?></a></li>
                        <?php
                    }
                    if ($this->rbac->hasPrivilege('subject_group', 'can_view')) {
                        ?>
                        <li class="info-box <?php echo set_Submenu('subjectgroup/index'); ?>"><a href="<?php echo base_url('admin/subjectgroup'); ?>"> <?php echo $this->lang->line('subject') . " " . $this->lang->line('group') ?></a></li>
                        <?php
                    }
                    ?>

                </ul>


                <ul class="col-md-4 treeview-menu1">
                    <?php

                    if ($this->rbac->hasPrivilege('subject', 'can_view')) {
                        ?>
                        <li class="info-box <?php echo set_Submenu('Academics/subject'); ?>"><a href="<?php echo base_url(); ?>admin/subject"> <?php echo $this->lang->line('subjects'); ?></a></li>
                        <?php
                    }



                    if ($this->rbac->hasPrivilege('class', 'can_view')) {
                        ?>
                        <li class="info-box <?php echo set_Submenu('classes/index'); ?>"><a href="<?php echo base_url(); ?>classes"> <?php echo $this->lang->line('class'); ?></a></li>
                        <?php
                    }

                    if ($this->rbac->hasPrivilege('section', 'can_view')) {
                        ?>
                        <li class="info-box <?php echo set_Submenu('sections/index'); ?>"><a href="<?php echo base_url(); ?>sections"> <?php echo $this->lang->line('sections'); ?></a></li>
                        <?php
                    }
                    ?>

                </ul>




              </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line('close'); ?></button>
            </div>
        </div>
    </div>
</div>
<div class="norecord modal fade" id="human_resource" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog  ">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" align="center" > <?php echo $this->lang->line('human_resource') ; ?> </h4>
            </div>
            <div class="modal-body">

                <ul class="col-md-4 treeview-menu1">
                    <?php if ($this->rbac->hasPrivilege('staff', 'can_view')) { ?>
                        <li class="info-box <?php echo set_Submenu('HR/staff'); ?>"><a href="<?php echo base_url(); ?>admin/staff"> <?php echo $this->lang->line('staff_directory'); ?></a></li>

                        <?php
                    } ?>

                    <?php
                    if ($this->rbac->hasPrivilege('staff_attendance', 'can_view')) {
                        ?>
                        <li class="info-box <?php echo set_Submenu('admin/staffattendance'); ?>"><a href="<?php echo base_url(); ?>admin/staffattendance"> <?php echo $this->lang->line('staff_attendance'); ?></a></li>
                        <?php
                    }

                    if ($this->rbac->hasPrivilege('staff_payroll', 'can_view')) {
                        ?>


                        <li class="info-box <?php echo set_Submenu('admin/payroll'); ?>"><a href="<?php echo base_url(); ?>admin/payroll"> <?php echo $this->lang->line('payroll'); ?></a></li>
                        <?php
                    }
                    ?>
                </ul>


                <ul class="col-md-4 treeview-menu1">
                    <?php
                    //                            if ($this->rbac->hasPrivilege('staff_payroll', 'can_view')) {
                    //                                ?>
                    <!---->
                    <!---->
                    <!--                                <li class="info-box --><?php //echo set_Submenu('admin/AbsentDeduction'); ?><!--"><a href="--><?php //echo base_url(); ?><!--admin/payroll/AbsentDeduction"> Absent Deduction</a></li>-->
                    <!--                                --><?php
                    //                            }

                    if ($this->rbac->hasPrivilege('approve_leave_request', 'can_view')) {
                        ?>
                        <li class="info-box <?php echo set_Submenu('admin/leaverequest/leaverequest'); ?>"><a href="<?php echo base_url(); ?>admin/leaverequest/leaverequest"> <?php echo $this->lang->line('approve_leave_request'); ?></a></li>

                        <?php
                    }
                    if ($this->rbac->hasPrivilege('apply_leave', 'can_view')) {
                        ?>
                        <li class="info-box <?php echo set_Submenu('admin/staff/leaverequest'); ?>"><a href="<?php echo base_url(); ?>admin/staff/leaverequest"> <?php echo $this->lang->line('apply_leave'); ?></a></li>
                        <?php
                    }
                    if ($this->rbac->hasPrivilege('leave_types', 'can_view')) {
                        ?>

                        <li class="info-box <?php echo set_Submenu('admin/leavetypes'); ?>"><a href="<?php echo base_url(); ?>admin/leavetypes"> <?php echo $this->lang->line('leave_type'); ?></a></li>

                    <?php }
                    ?>
                </ul>


                <ul class="col-md-4 treeview-menu1">
                    <?php
                    if($this->rbac->hasPrivilege('teachers_rating','can_view')){
                        ?>
                        <li class="info-box <?php echo set_Submenu('HR/rating'); ?>"><a href="<?php echo base_url(); ?>admin/staff/rating"> <?php echo $this->lang->line('teachers') . " " . $this->lang->line('rating'); ?></a></li>
                        <?php
                    }

                    if ($this->rbac->hasPrivilege('department', 'can_view')) {
                        ?>
                        <li class="info-box <?php echo set_Submenu('admin/department/department'); ?>"><a href="<?php echo base_url(); ?>admin/department/department"> <?php echo $this->lang->line('department'); ?></a></li>

                        <?php
                    }
                    if ($this->rbac->hasPrivilege('designation', 'can_view')) {
                        ?>
                        <li class="info-box <?php echo set_Submenu('admin/designation/designation'); ?>"><a href="<?php echo base_url(); ?>admin/designation/designation"> <?php echo $this->lang->line('designation'); ?></a></li>
                        <?php
                    }
                    ?>
                </ul>


                <ul class="col-md-4 treeview-menu1">
                    <?php
                    if ($this->rbac->hasPrivilege('disable_staff', 'can_view')) {
                        ?>

                        <li class="info-box <?php echo set_Submenu('HR/staff/disablestafflist'); ?>"><a href="<?php echo base_url(); ?>admin/staff/disablestafflist"> <?php echo $this->lang->line('disabled_staff'); ?></a></li>
                    <?php }
                    ?>
                </ul>




            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line('close'); ?></button>
            </div>
        </div>
    </div>
</div>
<div class="norecord modal fade" id="communicate" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog  ">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" align="center" > <?php echo $this->lang->line('communicate') ; ?> </h4>
            </div>
            <div class="modal-body">

                <ul class="col-md-4 treeview-menu1">

                    <?php
                    if ($this->rbac->hasPrivilege('notice_board', 'can_view')) {
                        ?>
                        <li class="info-box <?php echo set_Submenu('notification/index'); ?>"><a href="<?php echo base_url(); ?>admin/notification"> <?php echo $this->lang->line('notice_board'); ?></a></li>
                        <?php
                    }

                    if ($this->rbac->hasPrivilege('email', 'can_view')) {
                        ?>
                        <li class="info-box <?php echo set_Submenu('Communicate/mailsms/compose'); ?>"><a href="<?php echo base_url(); ?>admin/mailsms/compose"> <?php echo $this->lang->line('send') . " " . $this->lang->line('email') ?></a></li>
                        <?php
                    }
                    ?>
                </ul>


                <ul class="col-md-4 treeview-menu1">
                    <?php

                    if ($this->rbac->hasPrivilege('sms', 'can_view')) {
                        ?>
                        <li class="info-box <?php echo set_Submenu('mailsms/compose_sms'); ?>"><a href="<?php echo base_url(); ?>admin/mailsms/compose_sms"> <?php echo $this->lang->line('send') . " " . $this->lang->line('sms') ?></a></li>
                        <?php
                    }
                    if ($this->rbac->hasPrivilege('email_sms_log', 'can_view')) {
                        ?>
                        <li class="info-box <?php echo set_Submenu('mailsms/index'); ?>"><a href="<?php echo base_url(); ?>admin/mailsms/index"> <?php echo $this->lang->line('email_/_sms_log'); ?></a></li>
                    <?php } ?>
                </ul>

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line('close'); ?></button>
            </div>
        </div>
    </div>
</div>
<div class="norecord modal fade" id="download_center" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog  ">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" align="center" > <?php echo $this->lang->line('download_center') ; ?> </h4>
            </div>
            <div class="modal-body">

                <ul class="col-md-4 treeview-menu1">
                    <?php if ($this->rbac->hasPrivilege('upload_content', 'can_view')) { ?>
                        <li class="info-box <?php echo set_Submenu('admin/content'); ?>"><a href="<?php echo base_url(); ?>admin/content"> <?php echo $this->lang->line('upload_content'); ?></a></li>
                    <?php } ?>
                    <li class="info-box <?php echo set_Submenu('content/assignment'); ?>"><a href="<?php echo base_url(); ?>admin/content/assignment"> <?php echo $this->lang->line('assignments'); ?></a></li>
                    <li class="info-box <?php echo set_Submenu('content/studymaterial'); ?>"><a href="<?php echo base_url(); ?>admin/content/studymaterial"> <?php echo $this->lang->line('study_material'); ?></a></li>
                </ul>
                <ul class="col-md-4 treeview-menu1">
                    <li class="info-box <?php echo set_Submenu('content/syllabus'); ?>"><a href="<?php echo base_url(); ?>admin/content/syllabus"> <?php echo $this->lang->line('syllabus'); ?></a></li>
                    <li class="info-box <?php echo set_Submenu('content/other'); ?>"><a href="<?php echo base_url(); ?>admin/content/other"> <?php echo $this->lang->line('other_downloads'); ?></a></li>
                </ul>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line('close'); ?></button>
            </div>
        </div>
    </div>
</div>
<div class="norecord modal fade" id="homework" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog  ">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" align="center" > <?php echo $this->lang->line('homework') ; ?> </h4>
            </div>
            <div class="modal-body">
                <ul class="col-md-4 treeview-menu1">
                    <?php if ($this->rbac->hasPrivilege('homework', 'can_view')) { ?>
                        <li class="info-box  <?php echo set_Submenu('homework'); ?>"><a href="<?php echo base_url(); ?>homework"> <?php echo $this->lang->line('add_homework'); ?></a></li>
                    <?php } ?>
                </ul>
             </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line('close'); ?></button>
            </div>
        </div>
    </div>
</div>
<div class="norecord modal fade" id="library" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog  ">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" align="center" > <?php echo $this->lang->line('library') ; ?> </h4>
            </div>
            <div class="modal-body">


                <ul class="col-md-4 treeview-menu1">


                    <?php if ($this->rbac->hasPrivilege('books', 'can_view')) { ?>
                        <li class="info-box <?php echo set_Submenu('book/getall'); ?>">
                            <a href="<?php echo base_url(); ?>admin/book/getall"><?php echo $this->lang->line('book_list'); ?></a></li>
                    <?php }if ($this->rbac->hasPrivilege('issue_return', 'can_view')) { ?>
                        <li class="info-box <?php echo set_Submenu('member/index'); ?>"><a href="<?php echo base_url(); ?>admin/member"><?php echo $this->lang->line('issue_return'); ?></a></li>
                    <?php } ?>
                </ul>


                <ul class="col-md-4 treeview-menu1">

                <?php if ($this->rbac->hasPrivilege('add_student', 'can_view')) { ?>
                        <li class="info-box <?php echo set_Submenu('member/student'); ?>"><a href="<?php echo base_url(); ?>admin/member/student"><?php echo $this->lang->line('add_student'); ?></a></li>
                    <?php } ?>
                    <?php if ($this->rbac->hasPrivilege('add_staff_member', 'can_view')) { ?>
                        <li class="info-box <?php echo set_Submenu('Library/member/teacher'); ?>"><a href="<?php echo base_url(); ?>admin/member/teacher"><?php echo $this->lang->line('add_staff_member'); ?></a></li>
                    <?php } ?>



                </ul>

             </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line('close'); ?></button>
            </div>
        </div>
    </div>
</div>
<div class="norecord modal fade" id="inventory" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog  ">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" align="center" > <?php echo $this->lang->line('inventory') ; ?> </h4>
            </div>
            <div class="modal-body">
                <ul class="col-md-4 treeview-menu1">
                    <?php if ($this->rbac->hasPrivilege('issue_item', 'can_view')) { ?>
                        <li class="info-box <?php echo set_Submenu('issueitem/index'); ?>"><a href="<?php echo base_url(); ?>admin/issueitem"><?php echo $this->lang->line('issue_item'); ?></a></li>
                        <?php
                    }
                    if ($this->rbac->hasPrivilege('item_stock', 'can_view')) {
                        ?>
                        <li class="info-box <?php echo set_Submenu('Itemstock/index'); ?>"><a href="<?php echo base_url(); ?>admin/itemstock"><?php echo $this->lang->line('add_item_stock'); ?></a></li>
                        <?php
                    }
                    if ($this->rbac->hasPrivilege('item', 'can_view')) {
                        ?>
                        <li class="info-box <?php echo set_Submenu('Item/index'); ?>"><a href="<?php echo base_url(); ?>admin/item"><?php echo $this->lang->line('add_item'); ?></a></li>
                        <?php
                    }
                    ?>
                </ul>


                <ul class="col-md-4 treeview-menu1">
                    <?php
                    if ($this->rbac->hasPrivilege('item_category', 'can_view')) {
                        ?>
                        <li class="info-box <?php echo set_Submenu('itemcategory/index'); ?>"><a href="<?php echo base_url(); ?>admin/itemcategory"><?php echo $this->lang->line('item_category'); ?></a></li>
                        <?php
                    }
                    if ($this->rbac->hasPrivilege('store', 'can_view')) {
                        ?>
                        <li class="info-box <?php echo set_Submenu('itemstore/index'); ?>"><a href="<?php echo base_url(); ?>admin/itemstore"><?php echo $this->lang->line('item_store'); ?></a></li>
                        <?php
                    }
                    if ($this->rbac->hasPrivilege('supplier', 'can_view')) {
                        ?>
                        <li class="info-box <?php echo set_Submenu('itemsupplier/index'); ?>"><a href="<?php echo base_url(); ?>admin/itemsupplier"><?php echo $this->lang->line('item_supplier'); ?></a></li>
                    <?php } ?>
                </ul>

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line('close'); ?></button>
            </div>
        </div>
    </div>
</div>
<div class="norecord modal fade" id="transport" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog  ">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" align="center" > <?php echo $this->lang->line('transport') ; ?> </h4>
            </div>
            <div class="modal-body">
                <ul class="col-md-4 treeview-menu1">
                    <?php
                    if ($this->rbac->hasPrivilege('routes', 'can_view')) {
                        ?>
                        <li class="info-box <?php echo set_Submenu('route/index'); ?>"><a href="<?php echo base_url(); ?>admin/route"> <?php echo $this->lang->line('routes'); ?></a></li>
                        <?php
                    }
                    if ($this->rbac->hasPrivilege('vehicle', 'can_view')) {
                        ?>
                        <li class="info-box <?php echo set_Submenu('vehicle/index'); ?>"><a href="<?php echo base_url(); ?>admin/vehicle"> <?php echo $this->lang->line('vehicles'); ?></a></li>
                        <?php
                    }
                    ?>


                </ul>

                <ul class="col-md-4 treeview-menu1">

                    <?php
                    if ($this->rbac->hasPrivilege('assign_vehicle', 'can_view')) {
                        ?>
                        <li class="info-box <?php echo set_Submenu('vehroute/index'); ?>"><a href="<?php echo base_url(); ?>admin/vehroute"> <?php echo $this->lang->line('assign_vehicle'); ?></a></li>
                        <?php
                    }
                    ?>
                </ul>
             </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line('close'); ?></button>
            </div>
        </div>
    </div>
</div>
<div class="norecord modal fade" id="hostel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog  ">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" align="center" > <?php echo $this->lang->line('hostel') ; ?> </h4>
            </div>
            <div class="modal-body">

                <ul class="col-md-4 treeview-menu1">
                    <?php
                    if ($this->rbac->hasPrivilege('hostel_rooms', 'can_view')) {
                        ?>
                        <li class=" info-box <?php echo set_Submenu('hostelroom/index'); ?>"><a href="<?php echo base_url(); ?>admin/hostelroom"> <?php echo $this->lang->line('hostel_rooms'); ?></a></li>
                        <?php
                    }
                    if ($this->rbac->hasPrivilege('room_type', 'can_view')) {
                        ?>
                        <li class=" info-box <?php echo set_Submenu('roomtype/index'); ?>"><a href="<?php echo base_url(); ?>admin/roomtype"> <?php echo $this->lang->line('room_type'); ?></a></li>
                        <?php
                    } ?>
                </ul>


                <ul class="col-md-4 treeview-menu1">
                    <?php

                    if ($this->rbac->hasPrivilege('hostel', 'can_view')) {
                        ?>
                        <li class=" info-box <?php echo set_Submenu('hostel/index'); ?>"><a href="<?php echo base_url(); ?>admin/hostel"> <?php echo $this->lang->line('hostel'); ?></a></li>
                        <?php
                    }
                    ?>
                </ul>

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line('close'); ?></button>
            </div>
        </div>
    </div>
</div>
<div class="norecord modal fade" id="certificate" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog  ">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" align="center" > <?php echo $this->lang->line('certificate') ; ?> </h4>
            </div>
            <div class="modal-body">
                <ul class="col-md-4 treeview-menu1">
                    <?php
                    if ($this->rbac->hasPrivilege('student_certificate', 'can_view')) {
                        ?>
                        <li class="info-box <?php echo set_Submenu('admin/certificate'); ?>"><a href="<?php echo base_url(); ?>admin/certificate/"><?php echo $this->lang->line('student'); ?> <?php echo $this->lang->line('certificate'); ?></a></li>
                        <?php
                    }

                    if ($this->rbac->hasPrivilege('generate_certificate', 'can_view')) {
                        ?>
                        <li class="info-box <?php echo set_Submenu('admin/generatecertificate'); ?>"><a href="<?php echo base_url(); ?>admin/generatecertificate/"><?php echo $this->lang->line('generate'); ?> <?php echo $this->lang->line('certificate'); ?></a></li>
                        <?php
                    }
                    ?>
                </ul>


                <ul class="col-md-4 treeview-menu1">
                    <?php
                    if ($this->rbac->hasPrivilege('student_id_card', 'can_view')) {
                        ?>
                        <li class="info-box <?php echo set_Submenu('admin/studentidcard'); ?>"><a href="<?php echo base_url('admin/studentidcard/'); ?>"><?php echo $this->lang->line('student'); ?> <?php echo $this->lang->line('icard'); ?></a></li>
                        <?php
                    }

                    if ($this->rbac->hasPrivilege('generate_id_card', 'can_view')) {
                        ?>
                        <li class="info-box <?php echo set_Submenu('admin/generateidcard'); ?>"><a href="<?php echo base_url('admin/generateidcard/'); ?>"><?php echo $this->lang->line('generate'); ?> <?php echo $this->lang->line('icard'); ?></a></li>
                    <?php } ?>
                </ul>

             </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line('close'); ?></button>
            </div>
        </div>
    </div>
</div>
<div class="norecord modal fade" id="front_cms" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog  ">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" align="center" > <?php echo $this->lang->line('front_cms') ; ?> </h4>
            </div>
            <div class="modal-body">
                <ul class="col-md-4 treeview-menu1">
                    <?php if ($this->rbac->hasPrivilege('event', 'can_view')) { ?>
                        <li class="info-box <?php echo set_Submenu('admin/front/events'); ?>"><a href="<?php echo base_url(); ?>admin/front/events"> <?php echo $this->lang->line('event'); ?></a></li>
                        <?php
                    }
                    if ($this->rbac->hasPrivilege('gallery', 'can_view')) {
                        ?>
                        <li class="info-box <?php echo set_Submenu('admin/front/gallery'); ?>"><a href="<?php echo base_url(); ?>admin/front/gallery"> <?php echo $this->lang->line('gallery'); ?></a></li>
                        <?php
                    }
                    if ($this->rbac->hasPrivilege('notice', 'can_view')) {
                        ?>
                        <li class="info-box <?php echo set_Submenu('admin/front/notice'); ?>"><a href="<?php echo base_url(); ?>admin/front/notice"> <?php echo $this->lang->line('notice'); ?></a></li>
                        <?php
                    }
                    ?>
                </ul>


                <ul class="col-md-4 treeview-menu1">
                    <?php

                    if ($this->rbac->hasPrivilege('media_manager', 'can_view')) {
                        ?>
                        <li class="info-box <?php echo set_Submenu('admin/front/media'); ?>"><a href="<?php echo base_url(); ?>admin/front/media"> <?php echo $this->lang->line('media_manager'); ?></a></li>
                        <?php
                    }
                    if ($this->rbac->hasPrivilege('pages', 'can_view')) {
                        ?>
                        <li class="info-box <?php echo set_Submenu('admin/front/page'); ?>"><a href="<?php echo base_url(); ?>admin/front/page"> <?php echo $this->lang->line('page'); ?></a></li>
                        <?php
                    }
                    if ($this->rbac->hasPrivilege('menus', 'can_view')) {
                        ?>
                        <li class="info-box <?php echo set_Submenu('admin/front/menus'); ?>"><a href="<?php echo base_url(); ?>admin/front/menus"> <?php echo $this->lang->line('menus'); ?></a></li>
                        <?php
                    }
                    ?>
                </ul>


                <ul class="col-md-4 treeview-menu1">
                    <?php

                    if ($this->rbac->hasPrivilege('banner_images', 'can_view')) {
                        ?>
                        <li class="info-box <?php echo set_Submenu('admin/front/banner'); ?>"><a href="<?php echo base_url(); ?>admin/front/banner"> <?php echo $this->lang->line('banner_images'); ?></a></li>
                    <?php } ?>
                </ul>


            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line('close'); ?></button>
            </div>
        </div>
    </div>
</div>
<div class="norecord modal fade" id="reports" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog  ">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" align="center" > <?php echo $this->lang->line('reports') ; ?> </h4>
            </div>
            <div class="modal-body">

                <ul class="col-md-4 treeview-menu1">
                    <?php
                    if (($this->rbac->hasPrivilege('student_report', 'can_view') ||
                        $this->rbac->hasPrivilege('guardian_report', 'can_view') ||
                        $this->rbac->hasPrivilege('student_history', 'can_view') ||
                        $this->rbac->hasPrivilege('student_login_credential_report', 'can_view') ||
                        $this->rbac->hasPrivilege('class_subject_report', 'can_view') ||
                        $this->rbac->hasPrivilege('admission_report', 'can_view') ||
                        $this->rbac->hasPrivilege('sibling_report', 'can_view') ||
                        $this->rbac->hasPrivilege('evaluation_report', 'can_view') ||
                        $this->rbac->hasPrivilege('student_profile', 'can_view'))) {
                        ?>
                        <li class="info-box  <?php echo set_Submenu('Reports/student_information'); ?>"><a href="<?php echo base_url(); ?>report/studentinformation"> <?php echo $this->lang->line('student_information'); ?></a></li>
                        <?php
                    }
                    if (($this->rbac->hasPrivilege('fees_statement', 'can_view') ||
                        $this->rbac->hasPrivilege('balance_fees_report', 'can_view') ||
                        $this->rbac->hasPrivilege('fees_collection_report', 'can_view') ||
                        $this->rbac->hasPrivilege('online_fees_collection_report', 'can_view') ||
                        $this->rbac->hasPrivilege('income_report', 'can_view') ||
                        $this->rbac->hasPrivilege('expense_report', 'can_view') ||
                        $this->rbac->hasPrivilege('payroll_report', 'can_view') ||
                        $this->rbac->hasPrivilege('income_group_report', 'can_view') ||
                        $this->rbac->hasPrivilege('expense_group_report', 'can_view'))) {
                        ?>
                        <li class="info-box  <?php echo set_Submenu('Reports/finance'); ?>"><a href="<?php echo base_url(); ?>report/finance"> <?php echo $this->lang->line('finance'); ?></a></li>
                        <?php
                    }if (($this->rbac->hasPrivilege('attendance_report', 'can_view') ||
                        $this->rbac->hasPrivilege('staff_attendance_report', 'can_view'))) {
                        ?>

                        <li class="info-box  <?php echo set_Submenu('Reports/attendance'); ?>"><a href="<?php echo base_url(); ?>report/attendance"> <?php echo $this->lang->line('attendance'); ?></a></li>
                        <?php
                    }if (($this->rbac->hasPrivilege('rank_report', 'can_view'))) {
                        ?>
                        <li class="info-box  <?php echo set_Submenu('Reports/examinations'); ?>"><a href="<?php echo base_url(); ?>report/examinations"> <?php echo $this->lang->line('examinations'); ?></a></li>
                    <?php }
                    ?>
                </ul>


                <ul class="col-md-4 treeview-menu1">
                    <?php
                    if($this->module_lib->hasActive('online_examination')){
                        if(($this->rbac->hasPrivilege('online_exam_wise_report','can_view') ||
                            $this->rbac->hasPrivilege('online_exams_report','can_view') ||
                            $this->rbac->hasPrivilege('online_exams_attempt_report','can_view') ||
                            $this->rbac->hasPrivilege('online_exams_rank_report','can_view')
                        )){

                            ?>
                            <li class="info-box  <?php echo set_Submenu('Reports/online_examinations'); ?>"><a href="<?php echo base_url(); ?>admin/onlineexam/report"> <?php echo $this->lang->line('online')." ".$this->lang->line('examinations'); ?></a></li>
                            <?php
                        }}
                    if($this->module_lib->hasActive('human_resource')){
                        if(($this->rbac->hasPrivilege('staff_report','can_view') || $this->rbac->hasPrivilege('payroll_report','can_view'))){
                            ?>

                            <li class="info-box  <?php echo set_Submenu('Reports/human_resource'); ?>"><a href="<?php echo base_url(); ?>report/staff_report"> <?php echo $this->lang->line('human_resource'); ?></a></li>

                        <?php } }
                    if($this->module_lib->hasActive('library')){
                        if (($this->rbac->hasPrivilege('book_issue_report', 'can_view') ||
                            $this->rbac->hasPrivilege('book_due_report', 'can_view') ||
                            $this->rbac->hasPrivilege('book_inventory_report', 'can_view'))) {
                            ?>
                            <li class="info-box  <?php echo set_Submenu('Reports/library'); ?>"><a href="<?php echo base_url(); ?>report/library"> <?php echo $this->lang->line('library'); ?></a></li>
                            <?php
                        } }
                    if($this->module_lib->hasActive('inventory')){
                        if ((
                            $this->rbac->hasPrivilege('stock_report', 'can_view') ||
                            $this->rbac->hasPrivilege('add_item_report', 'can_view') ||
                            $this->rbac->hasPrivilege('issue_inventory_report', 'can_view'))) {
                            ?>
                            <li class="info-box  <?php echo set_Submenu('Reports/inventory'); ?>"><a href="<?php echo base_url(); ?>report/inventory"> <?php echo $this->lang->line('inventory'); ?></a></li>
                        <?php } }
                    ?>
                </ul>


                <ul class="col-md-4 treeview-menu1">
                    <?php
                    if($this->module_lib->hasActive('transport')){
                        if ($this->rbac->hasPrivilege('transport_report', 'can_view')) {
                            ?>
                            <li class="info-box  <?php echo set_Submenu('reports/studenttransportdetails'); ?>"><a href="<?php echo base_url(); ?>admin/route/studenttransportdetails"> <?php echo $this->lang->line('transport'); ?></a></li>
                            <?php
                        } }
                    if($this->module_lib->hasActive('hostel')){
                        if ($this->rbac->hasPrivilege('hostel_report', 'can_view')) {
                            ?>
                            <li class="info-box  <?php echo set_Submenu('reports/studenthosteldetails'); ?>"><a href="<?php echo base_url(); ?>admin/hostelroom/studenthosteldetails"> <?php echo $this->lang->line('hostel'); ?></a></li>
                            <?php
                        } }
                    if ($this->rbac->hasPrivilege('user_log', 'can_view')) {
                        ?>
                        <li class="info-box  <?php echo set_Submenu('Reports/userlog'); ?>"><a href="<?php echo base_url(); ?>admin/userlog"> <?php echo $this->lang->line('user_log'); ?></a></li>
                        <?php
                    }
                    if ($this->rbac->hasPrivilege('audit_trail_report', 'can_view')) {
                        ?>
                        <li class="info-box  <?php echo set_Submenu('audit/index'); ?>"><a href="<?php echo base_url(); ?>admin/audit">
                                <?php echo $this->lang->line('audit') . " " . $this->lang->line('trail') . " " . $this->lang->line('report'); ?></a></li>
                        <?php
                    }

                    ?>


                </ul>


            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line('close'); ?></button>
            </div>
        </div>
    </div>
</div>
<div class="norecord modal fade" id="system_settings" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog  ">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" align="center" > <?php echo $this->lang->line('system_settings') ; ?> </h4>
            </div>
            <div class="modal-body">

                <ul class="col-md-4 treeview-menu1">
                    <?php
                    if ($this->rbac->hasPrivilege('general_setting', 'can_view')) {
                        ?>
                        <li class="info-box <?php echo set_Submenu('schsettings/index'); ?>"><a href="<?php echo base_url(); ?>schsettings"> <?php echo $this->lang->line('general_settings'); ?></a></li>
                        <?php
                    }
                    if ($this->rbac->hasPrivilege('session_setting', 'can_view')) {
                        ?>
                        <li class="info-box <?php echo set_Submenu('sessions/index'); ?>"><a href="<?php echo base_url(); ?>sessions"> <?php echo $this->lang->line('session_setting'); ?></a></li>
                        <?php
                    }
                    if ($this->rbac->hasPrivilege('notification_setting', 'can_view')) {
                        ?>
                        <li class="info-box <?php echo set_Submenu('notification/setting'); ?>"><a href="<?php echo base_url(); ?>admin/notification/setting"> <?php echo $this->lang->line('notification_setting'); ?></a></li>
                        <?php
                    }



                    if ($this->rbac->hasPrivilege('sms_setting', 'can_view')) {
                        ?>
                        <li class="info-box <?php echo set_Submenu('smsconfig/index'); ?>"><a href="<?php echo base_url(); ?>smsconfig"> <?php echo $this->lang->line('sms_setting'); ?></a></li>
                        <?php
                    }
                    if ($this->rbac->hasPrivilege('email_setting', 'can_view')) {
                        ?>
                        <li class="info-box <?php echo set_Submenu('emailconfig/index'); ?>"><a href="<?php echo base_url(); ?>emailconfig"> <?php echo $this->lang->line('email_setting'); ?></a></li>
                        <?php
                    }
                    ?>
                </ul>


                <ul class="col-md-4 treeview-menu1">
                    <?php
                    if ($this->rbac->hasPrivilege('payment_methods', 'can_view')) {
                        ?>
                        <li class="info-box <?php echo set_Submenu('admin/paymentsettings'); ?>"><a href="<?php echo base_url(); ?>admin/paymentsettings"> <?php echo $this->lang->line('payment_methods'); ?></a></li>
                        <?php
                    }
                    if ($this->rbac->hasPrivilege('print_header_footer', 'can_view')) {
                        ?>
                        <li class="info-box <?php echo set_Submenu('admin/print_headerfooter'); ?>"><a href="<?php echo base_url(); ?>admin/print_headerfooter"> <?php echo $this->lang->line('print_headerfooter'); ?></a></li>
                    <?php }
                    if ($this->module_lib->hasActive('front_cms')) {
                        if ($this->rbac->hasPrivilege('front_cms_setting', 'can_view')) {
                            ?>
                            <li class="info-box <?php echo set_Submenu('admin/frontcms/index'); ?>"><a href="<?php echo base_url(); ?>admin/frontcms"> <?php echo $this->lang->line('front_cms_setting'); ?></a></li>
                            <?php
                        }
                    }
                    ?>
                    <?php if ($this->rbac->hasPrivilege('superadmin')) { ?>
                        <li class="info-box <?php echo set_Submenu('admin/roles'); ?>"><a href="<?php echo base_url(); ?>admin/roles"> <?php echo $this->lang->line('roles_permissions'); ?></a></li>
                        <?php
                    }
                    if ($this->rbac->hasPrivilege('backup', 'can_view')) {
                        ?>
                        <li class="info-box <?php echo set_Submenu('admin/backup'); ?>"><a href="<?php echo base_url(); ?>admin/admin/backup"> <?php echo $this->lang->line('backup / restore'); ?></a></li>
                        <?php
                    }
                    ?>
                </ul>


                <ul class="col-md-4 treeview-menu1">
                    <?php
                    if ($this->rbac->hasPrivilege('languages', 'can_add')) {
                        ?>
                        <li class="info-box <?php echo set_Submenu('language/index'); ?>"><a href="<?php echo base_url(); ?>admin/language"> <?php echo $this->lang->line('languages'); ?></a></li>
                        <?php
                    }
                    if ($this->rbac->hasPrivilege('user_status')) {
                        ?>
                        <li class="info-box <?php echo set_Submenu('users/index'); ?>"><a href="<?php echo base_url(); ?>admin/users"> <?php echo $this->lang->line('users'); ?></a></li>
                        <?php
                    }
                    if ($this->rbac->hasPrivilege('superadmin')) {
                        ?>
                        <li class="info-box <?php echo set_Submenu('System Settings/module'); ?>"><a href="<?php echo base_url(); ?>admin/module"> <?php echo $this->lang->line('modules'); ?></a></li>
                    <?php }
                    if ($this->rbac->hasPrivilege('custom_fields','can_view')) {
                        ?>
                        <li class="info-box <?php echo set_Submenu('System Settings/customfield'); ?>"><a href="<?php echo base_url(); ?>admin/customfield"> <?php echo $this->lang->line('custom') . " " . $this->lang->line('fields'); ?></a></li>
                    <?php } if($this->rbac->hasPrivilege('system_fields','can_view')){
                        ?>
                        <li class="info-box <?php echo set_Submenu('System Settings/systemfield'); ?>"><a href="<?php echo base_url(); ?>admin/systemfield"> <?php echo $this->lang->line('system') . " " . $this->lang->line('fields'); ?></a></li>
                        <?php
                    }?>

                </ul>

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line('close'); ?></button>
            </div>
        </div>
    </div>
</div>
<div class="norecord modal fade" id="smart_edu" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog  ">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" align="center" >Smart Education </h4>
            </div>
            <div class="modal-body">

                <ul class="col-md-4 treeview-menu1">


                        <li class="info-box  "><a  href="<?=base_url('Student/digital_learning')?>" > Digital Learning </a></li>
                         <li class="info-box  "><a   href="<?=base_url('Student/youtubeVideos')?>" >  Poem / Rhymes  </a></li>

                </ul>
                <ul class="col-md-4 treeview-menu1">



                        <li class="info-box  "><a href="<?=base_url('Student/games')?>">    Games</a></li>
                         <li class="info-box  "><a href="<?=base_url('admin/teacher/scheduledClasses')?>">Schedule Online Class</a></li>
                </ul>
                <ul class="col-md-4 treeview-menu1">


                         <li class="info-box  "><a href=" ">    Short Course</a></li>
                    <li class="info-box  "><a href="<?=base_url('admin/teacher/online_class')?>">Online Class</a></li>

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









