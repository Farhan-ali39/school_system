<?php

/**
 * 
 */ 
class Payroll extends Admin_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper('file');
        $this->config->load("mailsms");
        $this->config->load("payroll");
        $this->load->library('mailsmsconf');
        $this->config_attendance = $this->config->item('attendence');
        $this->staff_attendance = $this->config->item('staffattendance');
        $this->payment_mode = $this->config->item('payment_mode');
        $this->load->model("Payroll_model");
        $this->load->model("payroll_model");
        $this->load->model("staff_model");
        $this->load->model('staffattendancemodel');
        $this->load->model('Shared_model');
        $this->payroll_status = $this->config->item('payroll_status');
		$this->sch_setting_detail = $this->setting_model->getSetting();
    }

    function index() {

        if (!$this->rbac->hasPrivilege('staff_payroll', 'can_view')) {
            access_denied();
        }

        $this->session->set_userdata('top_menu', 'HR');
        $this->session->set_userdata('sub_menu', 'admin/payroll');
        $data["staff_id"] = "";
        $data["name"] = "";
        $data["month"] = date("F", strtotime("-1 month"));
        $data["year"] = date("Y");
        $data["present"] = 0;
        $data["absent"] = 0;
        $data["late"] = 0;
        $data["half_day"] = 0;
        $data["holiday"] = 0;
        $data["leave_count"] = 0;
        $data["alloted_leave"] = 0;
        $data["basic"] = 0;
        $data["payment_mode"] = $this->payment_mode;
        $user_type = $this->staff_model->getStaffRole();
        $data['classlist'] = $user_type;
        $data['monthlist'] = $this->customlib->getMonthDropdown();
		$data['sch_setting']        = $this->sch_setting_detail;
		$data['staffid_auto_insert'] = $this->sch_setting_detail->staffid_auto_insert;
        $submit = $this->input->post("search");
        if (isset($submit) && $submit == "search") {

            $month = $this->input->post("month");
            $year = $this->input->post("year");
            $emp_name = $this->input->post("name");
            $role = $this->input->post("role");

            $searchEmployee = $this->payroll_model->searchEmployee($month, $year, $emp_name, $role);

            $data["resultlist"] = $searchEmployee;
            $data["name"] = $emp_name;
            $data["month"] = $month;
            $data["year"] = $year;
        }
        
        $data["payroll_status"] = $this->payroll_status;
        $this->load->view("layout/header", $data);
        $this->load->view("admin/payroll/stafflist", $data);
        $this->load->view("layout/footer", $data);
    }

    function create($month, $year, $id) {

        $data["staff_id"] = "";
        $data["basic"] = "";
        $data["name"] = "";
        $data["month"] = "";
        $data["year"] = "";
        $data["present"] = 0;
        $data["absent"] = 0;
        $data["late"] = 0;
        $data["half_day"] = 0;
        $data["holiday"] = 0;
        $data["leave_count"] = 0;
        $data["alloted_leave"] = 0;
		$data['sch_setting']        = $this->sch_setting_detail;
		$data['staffid_auto_insert'] = $this->sch_setting_detail->staffid_auto_insert;
        $user_type = $this->staff_model->getStaffRole();
        $data['classlist'] = $user_type;

        $date = $year . "-" . $month;


        $searchEmployee = $this->payroll_model->searchEmployeeById($id);

        $data['result'] = $searchEmployee;
        $data["month"] = $month;
        $data["year"] = $year;



        $alloted_leave = $this->staff_model->alloted_leave($id);

        $newdate = date('Y-m-d', strtotime($date . " +1 month"));

        $data['monthAttendance'] = $this->monthAttendance($newdate, 3, $id);
        $data['currentmonthAttendance'] = $this->monthAttendance($newdate, 1, $id);
        $data['monthLeaves'] = $this->monthLeaves($newdate, 3, $id);
        $data["attendanceType"] = $this->staffattendancemodel->getStaffAttendanceType();
        $leavemonth = date('m', strtotime($month));
        $leaves = $this->staff_model->getLeaves($leavemonth, $year, $id);
        $data['leaves'] =$leaves;
        $data["alloted_leave"] = $alloted_leave[0]["alloted_leave"];

        $this->load->view("layout/header", $data);
        $this->load->view("admin/payroll/create", $data);
        $this->load->view("layout/footer", $data);
    }

    function monthAttendance($st_month, $no_of_months, $emp) {
        $record = array();
        for ($i = 1; $i <= $no_of_months; $i++) {

            $r = array();
            $month = date('m', strtotime($st_month . " -$i month"));
            $year = date('Y', strtotime($st_month . " -$i month"));


            foreach ($this->staff_attendance as $att_key => $att_value) {

                $s = $this->payroll_model->count_attendance_obj($month, $year, $emp, $att_value);


                $r[$att_key] = $s;
            }

            $record['01-' . $month . '-' . $year] = $r;
        }
        return $record;
    }

    function monthLeaves($st_month, $no_of_months, $emp) {
        $record = array();
        for ($i = 1; $i <= $no_of_months; $i++) {

            $r = array();
            $month = date('m', strtotime($st_month . " -$i month"));
            $year = date('Y', strtotime($st_month . " -$i month"));
            $leave_count = $this->staff_model->count_leave($month, $year, $emp);
//            $leave_count = $this->staff_model->getLeaves($month, $year, $emp);
            if (!empty($leave_count["tl"])) {
                $l = $leave_count["tl"];
            } else {
                $l = "0";
            }

            $record[$month] = $l;
        }

        return $record;
    }

    function payslip() {
        if (!$this->rbac->hasPrivilege('staff_payroll', 'can_add')) {
            access_denied();
        }
       // print_r($_POST);die;
        $basic = $this->input->post("basic");
        $total_allowance = $this->input->post("total_allowance");
        $total_deduction = $this->input->post("total_deduction");
        $net_salary = $this->input->post("net_salary");
        $status = $this->input->post("status");
        $staff_id = $this->input->post("staff_id");
        $month = $this->input->post("month");
        $name = $this->input->post("name");
        $year = $this->input->post("year");
        $tax = $this->input->post("tax");
        $leave_deduction = $this->input->post("leave_deduction");
        $this->form_validation->set_rules('net_salary', 'Net Salary', 'trim|required|xss_clean');
        if ($this->form_validation->run() == FALSE) {

            $this->create($month, $year, $staff_id);
        } else {

            $date = $year . "-" . $month;
            $newdate = date('Y-m-d', strtotime($date . " +1 month"));
            $monthAttendance = $this->monthAttendance($newdate, 1, $staff_id);
            if($month=="February"){
                $days=cal_days_in_month(CAL_GREGORIAN,2,date('m',strtotime($year)));
            }else{
                $days=cal_days_in_month(CAL_GREGORIAN,date('m',strtotime($month)),date('m',strtotime($year)));
            }
            $leavemonth = date('m', strtotime($month));
            $leaves = $this->staff_model->getLeaves($leavemonth, $year, $staff_id);
            $count_leave = $this->staff_model->count_leave($leavemonth, $year, $staff_id);
            if($basic>0)
            {
                $oneDayAmount= $basic/$days;
                $halfDayAmount= $oneDayAmount/2;
            }
            $totalLeaves=0;
            $WithSalaryLeaves=0;
            $WithoutSalaryLeaves=0;
            if(!empty($monthAttendance))
            {
                foreach ($monthAttendance as $item)
                {
                    $totalLate=$item['late'];
                    $totalPresents=$item['present'];
                    $totalAbsent=$item['absent'];
                    $totalhalfDays=$item['half_day'];
                    $totalholidays=$item['holiday'];
                }
            }
            if($totalLate>=3)
            {
                $lateAbsent= intval($totalLate/3);
                $totalLateFee=$oneDayAmount*$lateAbsent;
            }else{
                $totalLateFee=0;
            }

            foreach ($leaves as $leave)
            {
                if($leave['include_salary']==0)
                {
                    $WithoutSalaryLeaves=$WithoutSalaryLeaves+$leave['leave_days'] ;
                }elseif($leave['include_salary']==1)
                {
                    $WithSalaryLeaves=$WithSalaryLeaves+$leave['leave_days'] ;
                }

            }
            $totalLateamount=($totalLate*$oneDayAmount)-$totalLateFee;
            $totalHalfdayAmount=($totalhalfDays*$oneDayAmount)-($totalhalfDays*$halfDayAmount);
            $totaldeduction =round($totalAbsent*$oneDayAmount +$totalLateFee +$totalhalfDays*$halfDayAmount ) ;
//            $totaldeduction =round($totalAbsent*$oneDayAmount +$totalLateFee +$totalhalfDays*$halfDayAmount+$WithoutSalaryLeaves*$oneDayAmount) ;
//            $netsalary=round($totalPresents*$oneDayAmount+$totalholidays*$oneDayAmount+$totalLateamount+$totalHalfdayAmount+$WithSalaryLeaves*$oneDayAmount);
            $netsalary=round($totalPresents*$oneDayAmount+$totalholidays*$oneDayAmount+$totalLateamount+$totalHalfdayAmount );


//            echo "<pre>";
//            var_dump($monthAttendance);
//            die();
            $data = array('staff_id' => $staff_id,
                'basic' => $basic,
                'total_allowance' => $total_allowance+$netsalary,
                'total_deduction' => $total_deduction+$totaldeduction,
                'net_salary' => $netsalary+$total_allowance-$total_deduction-$tax,
                'payment_date' => date("Y-m-d"),
                'status' => $status,
                'month' => $month,
                'year' => $year,
                'tax' => $tax,
                'leave_deduction' => '0'
            );

            $checkForUpdate = $this->payroll_model->checkPayslip($month, $year, $staff_id);
          
            if ($checkForUpdate == true) {
               // print_r($data);die;
                $insert_id = $this->payroll_model->createPayslip($data);

                $payslipid = $insert_id;
                
                $allowance_type = $this->input->post("allowance_type");
                $deduction_type = $this->input->post("deduction_type");

                $allowance_amount = $this->input->post("allowance_amount");
                $deduction_amount = $this->input->post("deduction_amount");
                if (!empty($allowance_type)) {

                    $i = 0;
                    foreach ($allowance_type as $key => $all) {

                        $all_data = array('payslip_id' => $payslipid,
                            'allowance_type' => $allowance_type[$i],
                            'amount' => $allowance_amount[$i],
                            'staff_id' => $staff_id,
                            'cal_type' => "positive",
                        );

                        $insert_payslip_allowance = $this->payroll_model->add_allowance($all_data);

                        $i++;
                    }
                }

                if (!empty($deduction_type)) {
                    $j = 0;
                    foreach ($deduction_type as $key => $type) {

                        $type_data = array('payslip_id' => $payslipid,
                            'allowance_type' => $deduction_type[$j],
                            'amount' => $deduction_amount[$j],
                            'staff_id' => $staff_id,
                            'cal_type' => "negative",
                        );

                        $insert_payslip_allowance = $this->payroll_model->add_allowance($type_data);

                        $j++;
                    }
                }

                redirect('admin/payroll');
            } else {

                $this->session->set_flashdata("msg", $this->lang->line('payslip_already_generated'));

                redirect('admin/payroll');
            }
        }
    }

   

    function search($month, $year, $role = '') {

        $user_type = $this->staff_model->getStaffRole();
        $data['classlist'] = $user_type;
        $data['monthlist'] = $this->customlib->getMonthDropdown();

        $searchEmployee = $this->payroll_model->searchEmployee($month, $year, $emp_name = '', $role);

        $data["resultlist"] = $searchEmployee;
        $data["name"] = $emp_name;
        $data["month"] = $month;
        $data["year"] = $year;
        $data['sch_setting']        = $this->sch_setting_detail;
        
        $data["payroll_status"] = $this->payroll_status;
        $data["resultlist"] = $searchEmployee;
        $data["payment_mode"] = $this->payment_mode;

        $this->load->view("layout/header", $data);
        $this->load->view("admin/payroll/stafflist", $data);
        $this->load->view("layout/footer", $data);
    }

    function paymentRecord() {

        $month = $this->input->get_post("month");
        $year = $this->input->get_post("year");
        $id = $this->input->get_post("staffid");

        $searchEmployee = $this->payroll_model->searchPayment($id, $month, $year);
        $data['result'] = $searchEmployee;
        $data["month"] = $month;
        $data["year"] = $year;
        echo json_encode($data);
    }

    function paymentStatus($status) {

        $id = $this->input->get('id');

        $updateStaus = $this->payroll_model->updatePaymentStatus($status, $id);

        redirect("admin/payroll");
    }

    function paymentSuccess() {

        $payment_mode = $this->input->post("payment_mode");
        $date = $this->input->post("payment_date");
        $payment_date = date('Y-m-d', strtotime($date));
        $remark = $this->input->post("remarks");
        $status = 'paid';
        $payslipid = $this->input->post("paymentid");
        $this->form_validation->set_rules('payment_mode', $this->lang->line('payment_mode'), 'trim|required|xss_clean');
        if ($this->form_validation->run() == FALSE) {

            $msg = array(
                'payment_mode' => form_error('payment_mode'),
            );
            $array = array('status' => 'fail', 'error' => $msg, 'message' => '');
        } else {

            $data = array('payment_mode' => $payment_mode, 'payment_date' => $payment_date, 'remark' => $remark, 'status' => $status);


            $this->payroll_model->paymentSuccess($data, $payslipid);
            $array = array('status' => 'success', 'error' => '', 'message' => $this->lang->line('success_message'));
        }
        echo json_encode($array);
    }

    function payslipView() {
        if (!$this->rbac->hasPrivilege('staff', 'can_view')) {
            access_denied();
        } 
        $data["payment_mode"] = $this->payment_mode;
        $this->load->model("setting_model");
        $setting_result = $this->setting_model->get();
        $data['settinglist'] = $setting_result[0];
        $id = $this->input->post("payslipid");
        $result = $this->payroll_model->getPayslip($id);
        $data['sch_setting']        = $this->sch_setting_detail;

        $data['staffid_auto_insert'] = $this->sch_setting_detail->staffid_auto_insert;
       if(!empty($result)){ 
        $allowance = $this->payroll_model->getAllowance($result["id"]);
        $data["allowance"] = $allowance;
        $positive_allowance = $this->payroll_model->getAllowance($result["id"], "positive");
        $data["positive_allowance"] = $positive_allowance;
        $negative_allowance = $this->payroll_model->getAllowance($result["id"], "negative");
        $data["negative_allowance"] = $negative_allowance;
        $data["result"] = $result;
         $this->load->view("admin/payroll/payslipview", $data);
        }else{
            echo "<div class='alert alert-info'>No Record Found.</div>";
        }
       
    }

    function payslippdf() {

        $this->load->model("setting_model");
        $setting_result = $this->setting_model->get();
        $data['settinglist'] = $setting_result[0];
        // $id = $this->input->post("payslipid");
        $id = 15;
        $result = $this->payroll_model->getPayslip($id);
        $allowance = $this->payroll_model->getAllowance($result["id"]);
        $data["allowance"] = $allowance;
        $positive_allowance = $this->payroll_model->getAllowance($result["id"], "positive");
        $data["positive_allowance"] = $positive_allowance;
        $negative_allowance = $this->payroll_model->getAllowance($result["id"], "negative");
        $data["negative_allowance"] = $negative_allowance;
        $data["result"] = $result;
        $this->load->view("admin/payroll/payslippdf", $data);
    }

    function payrollreport() {
        if (!$this->rbac->hasPrivilege('payroll_report', 'can_view')) {
            access_denied();
        }
        $this->session->set_userdata('top_menu', 'Reports');
        $this->session->set_userdata('sub_menu', 'Reports/human_resource');
        $this->session->set_userdata('subsub_menu','Reports/attendance/attendance_report');
        $month = $this->input->post("month");
        $year = $this->input->post("year");
        $role = $this->input->post("role");
        $data["month"] = $month;
        $data["year"] = $year;
        $data["role_select"] = $role;
        $data['monthlist'] = $this->customlib->getMonthDropdown();
        $data['yearlist'] = $this->payroll_model->payrollYearCount();
        $staffRole = $this->staff_model->getStaffRole();
        $data["role"] = $staffRole;
        $data["payment_mode"] = $this->payment_mode;

        $this->form_validation->set_rules('year', $this->lang->line('year'), 'trim|required|xss_clean');
        if ($this->form_validation->run() == FALSE) {

            $this->load->view("layout/header", $data);
            $this->load->view("admin/payroll/payrollreport", $data);
            $this->load->view("layout/footer", $data);
            
        }else {

            $result = $this->payroll_model->getpayrollReport($month, $year, $role);
            $data["result"] = $result;

            
            
            $this->load->view("layout/header", $data);
            $this->load->view("admin/payroll/payrollreport", $data);
            $this->load->view("layout/footer", $data);
        }
    }

    function deletepayroll($payslipid, $month, $year, $role = '') {
        if (!$this->rbac->hasPrivilege('staff_payroll', 'can_delete')) {
            access_denied();
        }
        if (!empty($payslipid)) {

            $this->payroll_model->deletePayslip($payslipid);
        }
        //redirect("admin/payroll");
        redirect('admin/payroll/search/' . $month . "/" . $year . "/" . $role);
    }

    function revertpayroll($payslipid, $month, $year, $role = '') {


        if (!$this->rbac->hasPrivilege('staff_payroll', 'can_delete')) {
            access_denied();
        }
        if (!empty($payslipid)) {

            $this->payroll_model->revertPayslipStatus($payslipid);
        }
        redirect('admin/payroll/search/' . $month . "/" . $year . "/" . $role);
        //$this->search($month,$year,$role);
        //redirect("admin/payroll");
    }

    function AbsentDeduction()
    {
        $this->session->set_userdata('top_menu', 'HR');
        $this->session->set_userdata('sub_menu', 'admin/AbsentDeduction');
        $data['title']='Absent Deduction';

        $this->form_validation->set_rules('absent_amount', 'Amount', 'trim|required|xss_clean');
        if ($this->form_validation->run() == true) {
            $this->Shared_model->updateData("sch_settings",array('id'=>1),array('absent_amount'=>$this->input->post("absent_amount")));
            $this->session->set_flashdata('msg', '<div class="alert alert-success">'.$this->lang->line('update_message').'</div>');

        }
        $setting_result         = $this->Shared_model->selectDataWhereSingle("sch_settings",array('id'=>1));
        $data['settinglist']    = $setting_result;
        $this->load->view("layout/header", $data);
        $this->load->view("admin/payroll/AbsentDeduction.php", $data);
        $this->load->view("layout/footer", $data);
    }

    function generatePayroll()
    {

        $totalLate=0;
        $totalPresents=0;
        $totalAbsent=0;
        $totalhalfDays=0;
        $totalholidays=0;
        $staffIdList=  $this->input->post("formData");
        $month=  $this->input->post("month");
        $year=  $this->input->post("year");
        $date = $year . "-" . $month;
        if($month=="February"){
            $days=cal_days_in_month(CAL_GREGORIAN,2,date('m',strtotime($year)));
        }else{
            $days=cal_days_in_month(CAL_GREGORIAN,date('m',strtotime($month)),date('m',strtotime($year)));
        }
        $newdate = date('Y-m-d', strtotime($date . " +1 month"));
        $setting_result         = $this->Shared_model->selectDataWhereSingle("sch_settings",array('id'=>1));

        foreach ($staffIdList as $value)
        {
            $total_allowance=0;
            $id= $value['value'];
            $searchEmployee = $this->payroll_model->searchEmployeeById($id);
            $monthAttendance= $this->monthAttendance($newdate, 1, $id);
            $leavemonth = date('m', strtotime($month  ));
            $leaves = $this->staff_model->getLeaves($leavemonth, $year, $id);
            $count_leave = $this->staff_model->count_leave($leavemonth, $year, $id);
//var_dump($leaves);
//die();

            $totalLeaves=0;
            $WithSalaryLeaves=0;
            $WithoutSalaryLeaves=0;


             if (!empty($searchEmployee["basic_salary"])) {
                $basic_salary= $searchEmployee["basic_salary"];
            } else {
                $basic_salary=0;
            }
            if($basic_salary>0)
            {
                $oneDayAmount= $basic_salary/$days;
                $halfDayAmount= $oneDayAmount/2;
            }
            if(!empty($monthAttendance))
            {
                foreach ($monthAttendance as $item)
                {

                    $totalLate=$item['late'];
                    $totalPresents=$item['present'];
                    $totalAbsent=$item['absent'];
                    $totalhalfDays=$item['half_day'];
                    $totalholidays=$item['holiday'];

                }
            }
            if($totalLate>=3)
            {
                $lateAbsent= intval($totalLate/3);
                $totalLateFee=$oneDayAmount*$lateAbsent;
            }else{
                $totalLateFee=0;
            }



            foreach ($leaves as $leave)
            {
                if($leave['include_salary']==0)
                {
                    $WithoutSalaryLeaves=$WithoutSalaryLeaves+$leave['leave_days'] ;
                }elseif($leave['include_salary']==1)
                {
                    $WithSalaryLeaves=$WithSalaryLeaves+$leave['leave_days'] ;
                }

            }



            $totalLateamount=($totalLate*$oneDayAmount)-$totalLateFee;
            $totalHalfdayAmount=($totalhalfDays*$oneDayAmount)-($totalhalfDays*$halfDayAmount);


            $total_deduction =round($totalAbsent*$oneDayAmount +$totalLateFee +$totalhalfDays*$halfDayAmount ) ;
//            $total_deduction =round($totalAbsent*$oneDayAmount +$totalLateFee +$totalhalfDays*$halfDayAmount+$WithoutSalaryLeaves*$oneDayAmount) ;
//            $net_salary=round($totalPresents*$oneDayAmount+$totalholidays*$oneDayAmount+$totalLateamount+$totalHalfdayAmount+$WithSalaryLeaves*$oneDayAmount);
            $net_salary=round($totalPresents*$oneDayAmount+$totalholidays*$oneDayAmount+$totalLateamount+$totalHalfdayAmount );

            $status='generated';
            $tax=0;
            $data = array(
                'staff_id' => $id,
                'basic' => $basic_salary,
                'total_allowance' => $total_allowance+$net_salary,
                'total_deduction' => $total_deduction,
                'net_salary' => $net_salary-$searchEmployee["tax"],
                'payment_date' => date("Y-m-d"),
                'status' => $status,
                'month' => $month,
                'year' => $year,
                'tax' => $tax,
                'leave_deduction' => '0'
            );
            $checkForUpdate = $this->payroll_model->checkPayslip($month, $year, $id);
            if ($checkForUpdate == true) {
                $insert_id = $this->payroll_model->createPayslip($data);
            }
        }
        echo json_encode(array('success'=>true,'message'=>'Payslip Generated Successfully'));
    }

    function payToAllModel()
    {
        $month = $this->input->post("month");
        $year = $this->input->post("year");
        $staffIds = $this->input->post("formData");
        $data['staffIds'] = $staffIds;
        $data["month"] = $month;
        $data["year"] = $year;
        $data["payment_mode"] = $this->payment_mode;
          $html= $this->load->view("admin/payroll/payToall_model_view", $data,true);
           echo json_encode(array('success'=>true,'html'=>$html));
    }
    function paymentSuccessAll()
    {
//        $payment_mode = $this->input->post("payment_mode_all");
        $date = $this->input->post("payment_date_all");
        $payment_date = date('Y-m-d', strtotime($date));
        $status = 'paid';
        $paymentids = $this->input->post("paymentids");
//        $this->form_validation->set_rules('payment_mode_all', $this->lang->line('payment_mode'), 'trim|required|xss_clean');

            foreach ($paymentids as $payslipid)
            {
               $payslipDetail= $this->Shared_model->selectDataWhereSingle("staff_payslip",array('id'=>$payslipid));
                $searchEmployee = $this->payroll_model->searchEmployeeById($payslipDetail->staff_id);
                $remark = $this->input->post("remarks_".$payslipid);
                $payment_mode=$searchEmployee['payment_mode'];
                if(!empty($payment_mode))
                {
                    $payment_mode='cash';
                }
                $data = array('payment_mode' => $payment_mode, 'payment_date' => $payment_date, 'remark' => $remark, 'status' => $status);
                $this->payroll_model->paymentSuccess($data, $payslipid);

            }

            $array = array('status' => 'success', 'error' => '', 'message' => $this->lang->line('success_message'));

        echo json_encode($array);
    }
    function payslipViewAll() {
        if (!$this->rbac->hasPrivilege('staff', 'can_view')) {
            access_denied();
        }
        $data["payment_mode"] = $this->payment_mode;
        $this->load->model("setting_model");
        $setting_result = $this->setting_model->get();
        $data['settinglist'] = $setting_result[0];
        $id = $this->input->post("payslipid");
        $result = $this->payroll_model->getPayslip($id);
        $data['sch_setting']        = $this->sch_setting_detail;

        $data['staffid_auto_insert'] = $this->sch_setting_detail->staffid_auto_insert;
        if(!empty($result)){
            $allowance = $this->payroll_model->getAllowance($result["id"]);
            $data["allowance"] = $allowance;
            $positive_allowance = $this->payroll_model->getAllowance($result["id"], "positive");
            $data["positive_allowance"] = $positive_allowance;
            $negative_allowance = $this->payroll_model->getAllowance($result["id"], "negative");
            $data["negative_allowance"] = $negative_allowance;
            $data["result"] = $result;
            $this->load->view("admin/payroll/payslipviewAll", $data);
        }else{
            echo "<div class='alert alert-info'>No Record Found.</div>";
        }

    }

}

?>