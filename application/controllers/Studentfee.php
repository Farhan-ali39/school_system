<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Studentfee extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('smsgateway');
        $this->load->library('mailsmsconf');
        $this->load->model("Shared_model");
        $this->load->model("Student_model");
        $this->search_type = $this->config->item('search_type');
        $this->sch_setting_detail = $this->setting_model->getSetting();
        $this->current_session = $this->setting_model->getCurrentSession();

    }

    public function index()
    {
        if (!$this->rbac->hasPrivilege('collect_fees', 'can_view')) {
            access_denied();
        }

        $this->session->set_userdata('top_menu', $this->lang->line('fees_collection'));
        $this->session->set_userdata('sub_menu', 'studentfee/index');
        $data['title'] = 'student fees';
        $class = $this->class_model->get();
        $data['classlist'] = $class;
        $this->load->view('layout/header', $data);
        $this->load->view('studentfee/studentfeeSearch', $data);
        $this->load->view('layout/footer', $data);

    }

    public function collection_report()
    {


        if (!$this->rbac->hasPrivilege('collect_fees', 'can_view')) {
            access_denied();
        }

        $data['collect_by'] = $this->studentfeemaster_model->get_feesreceived_by();

        $data['searchlist'] = $this->customlib->get_searchtype();
        $data['group_by'] = $this->customlib->get_groupby();

        $this->session->set_userdata('top_menu', 'Reports');
        $this->session->set_userdata('sub_menu', 'Reports/finance');
        $this->session->set_userdata('subsub_menu', 'Reports/finance/collection_report');

        if (isset($_POST['search_type']) && $_POST['search_type'] != '') {

            $dates = $this->customlib->get_betweendate($_POST['search_type']);
            $data['search_type'] = $_POST['search_type'];

        } else {

            $dates = $this->customlib->get_betweendate('this_year');
            $data['search_type'] = '';

        }

        if (isset($_POST['collect_by']) && $_POST['collect_by'] != '') {

            $data['received_by'] = $received_by = $_POST['collect_by'];

        } else {

            $data['received_by'] = $received_by = '';

        }

        if (isset($_POST['group']) && $_POST['group'] != '') {

            $data['group_byid'] = $group = $_POST['group'];

        } else {

            $data['group_byid'] = $group = '';
        }

        $collect_by = array();
        $collection = array();
        $start_date = date('Y-m-d', strtotime($dates['from_date']));
        $end_date = date('Y-m-d', strtotime($dates['to_date']));
        $data['collectlist'] = $this->studentfeemaster_model->getFeeCollectionReport($start_date, $end_date);
//        $data['collectlist'] = $this->studentfeemaster_model->fetchFeeCollectionReport($start_date, $end_date);


        $this->form_validation->set_rules('search_type', $this->lang->line('search') . " " . $this->lang->line('type'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('collect_by', $this->lang->line('collect') . " " . $this->lang->line('by'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('group', $this->lang->line('group') . " " . $this->lang->line('by'), 'trim|required|xss_clean');


        if ($this->form_validation->run() == false) {

            $data['results'] = array();


        } else {

            $data['results'] = $this->studentfeemaster_model->getFeeCollectionReport($start_date, $end_date, $received_by, $group);
//            $data['results'] = $this->studentfeemaster_model->fetchFeeCollectionReport($start_date, $end_date, $received_by, $group);

            if ($group != '') {

                if ($group == 'class') {

                    $group_by = 'class_id';

                } elseif ($group == 'collection') {

                    $group_by = 'received_by';

                } elseif ($group == 'mode') {

                    $group_by = 'payment_mode';

                }

                foreach ($data['results'] as $key => $value) {


                    $collection[$value[$group_by]][] = $value;


                }

            } else {

                $s = 0;
                foreach ($data['results'] as $key => $value) {

                    $collection[$s++] = array($value);


                }

            }

            $data['results'] = $collection;


        }


        $this->load->view('layout/header', $data);
        $this->load->view('studentfee/collection_report', $data);
        $this->load->view('layout/footer', $data);
    }

    public function pdf()
    {
        $this->load->helper('pdf_helper');
    }

    public function search()
    {
        if (!$this->rbac->hasPrivilege('collect_fees', 'can_view')) {
            access_denied();
        }
        $data['title'] = 'Student Search';
        $class = $this->class_model->get();
        $data['classlist'] = $class;
        $button = $this->input->post('search');
        $data['adm_auto_insert'] = $this->sch_setting_detail->adm_auto_insert;
        $data['sch_setting'] = $this->sch_setting_detail;
        if ($this->input->server('REQUEST_METHOD') == "GET") {
            $this->load->view('layout/header', $data);
            $this->load->view('studentfee/studentfeeSearch', $data);
            $this->load->view('layout/footer', $data);
        } else {
            $class = $this->input->post('class_id');
            $section = $this->input->post('section_id');
            $search = $this->input->post('search');
            $search_text = $this->input->post('search_text');
            if (isset($search)) {
                if ($search == 'search_filter') {
                    $this->form_validation->set_rules('class_id', $this->lang->line('class'), 'trim|required|xss_clean');
                    if ($this->form_validation->run() == false) {

                    } else {
                        $resultlist = $this->student_model->searchByClassSection($class, $section);
                        $data['resultlist'] = $resultlist;
                    }
                } else if ($search == 'search_full') {
                    $resultlist = $this->student_model->searchFullText($search_text);
                    $data['resultlist'] = $resultlist;
                }
                $this->load->view('layout/header', $data);
                $this->load->view('studentfee/studentfeeSearch', $data);
                $this->load->view('layout/footer', $data);
            }
        }
    }

    public function feesearch()
    {

        if (!$this->rbac->hasPrivilege('search_due_fees', 'can_view')) {
            access_denied();
        }

        $this->session->set_userdata('top_menu', 'Fees Collection');
        $this->session->set_userdata('sub_menu', 'studentfee/feesearch');
        $data['title'] = 'student fees';
        $class = $this->class_model->get();
        $data['classlist'] = $class;
        $feesessiongroup = $this->feesessiongroup_model->getFeesByGroup();
        $months = array( 'Jul', 'Aug', 'Sep','Oct','Nov', 'Dec','Jan', 'Feb', 'Mar', 'Apr','May', 'Jun');
        $data['monthsLists'] = $months;
        $unknownPayments = $this->Shared_model->selectAll("tbl_bank_fee_amounts");

        $data['unknownPayments'] = $unknownPayments;
        $data['feesessiongrouplist'] = $feesessiongroup;
        $data['fees_group'] = "";
        if (isset($_POST['feegroup_id']) && $_POST['feegroup_id'] != '') {
            $data['fees_group'] = $_POST['feegroup_id'];
        }

        $this->form_validation->set_rules('feegroup_id', $this->lang->line('fee_group'), 'trim|required|xss_clean');

//        $this->form_validation->set_rules('class_id', $this->lang->line('class'), 'trim|required|xss_clean');
//        $this->form_validation->set_rules('section_id', $this->lang->line('section'), 'trim|required|xss_clean');
        if ($this->form_validation->run() == false) {
            $this->load->view('layout/header', $data);
            $this->load->view('studentfee/studentSearchFee', $data);
            $this->load->view('layout/footer', $data);
        } else {
            $data['student_due_fee'] = array();
            $feegroup_id = $this->input->post('feegroup_id');
//            $feegroup                = explode("-", $feegroup_id);
//            $feegroup_id             = $feegroup[0];
//            $fee_groups_feetype_id   = $feegroup[1];
            $class_id = $this->input->post('class_id');
            $section_id = $this->input->post('section_id');

            $student_due_fee = $this->studentfee_model->getStudentDueFee($feegroup_id, $class_id, $section_id);
            if (!empty($student_due_fee)) {
                foreach ($student_due_fee as $key => $value) {
                    $student_due_fee[$key]['amount_fine'] = 0;
                    $depositAmount = 0;
                    $discount = 0;
                    $anuualFee = 0;
                    $labFee = 0;
                    $otherFee = 0;
                    $payable = 0;
                    $totalfee = 0;
                    $totalExtraPaid = 0;
                    $grandExtraAmount = 0;
                    $totalArrears = 0;
                    $totalPaidFee = 0;
                    $stdFeeByMonth = [];
                    $stdFeeDetails = $this->Shared_model->selectDataWhereMultiple("tbl_student_fee_detail", array('std_fee_id' => $value['std_fee_id']));
                    $stdArrears = $this->Shared_model->selectDataWhereSingle("tbl_student_fee", array('std_fee_id' => $value['std_fee_id']));
                    $installmentFlag=false;
                    foreach ($stdFeeDetails as $stdFeeDetail) {
//                        $depositAmount = 0;
                        if($value['std_id']==1301||$value['roll_no']=='S-07-0617' )
                        {
//                            echo $stdFeeDetail->fee_month."-".$totalfee."<br>";

                        }
                        if($stdArrears->std_fee_case==1)
                        {
                            $thisFeeMonth=$this->setMonthlyFeeByMonth($stdFeeDetail->fee_month);

                            if(!isset($stdFeeByMonth[$thisFeeMonth]))
                            {
                                $current_month_tution_fee=0;
                            }

                        }else{
                            $thisFeeMonth=$this->setBiMonthlyFeeByMonth($stdFeeDetail->fee_month);

                            if(!isset($stdFeeByMonth[$thisFeeMonth]))
                            {

                                $current_month_tution_fee=0;
                            }

                        }


//                         $current_month_tution_fee=0;

                        $current_date=strtotime(date('m/d/Y'));
                        $due_date=strtotime($stdFeeDetail->due_date);
                        $session_current   = substr($this->setting_model->getCurrentSessionName(),'5');
                        $currentYear=substr(date('Y'),'0','2');

                        $curentFeeYear=$currentYear.$session_current;

                        $previous_session=$currentYear.$session_current-1;

                        $feeDepositDetails = $this->Shared_model->selectDataWhereMultiple("tbl_student_fee_deposit", array('std_fee_detail_id' => $stdFeeDetail->fee_detail_id));

//                        if(!empty($feeDepositDetails))
//                        {
//                            foreach ($feeDepositDetails as $feeDepositDetail) {
//                                $totalExtraPaid = $totalExtraPaid + $feeDepositDetail->extra_amount;
//                            }
//
//                        }
                        // || $stdFeeDetail->fee_year<$curentFeeYear $this->current_session;
//                        ($stdFeeDetail->fee_year==$curentFeeYear )
                        if ($current_date>$due_date && $stdFeeDetail->session_id==$this->current_session ) {
                            if( $stdFeeDetail->fee_status != 1)
                            {

                                $feesLists=json_decode($stdFeeDetail->fee_type);
                                if(!empty($feesLists))
                                {
                                    foreach ($feesLists as $feesList)
                                    {


                                        $appliedFeeDetails= $this->Shared_model->selectDataWhereSingle("tbl_feetype", array('id' => $feesList->feeTypeID));
                                        if ($appliedFeeDetails->fee_type=="anuual")
                                        {
                                            $anuualFee+=$feesList->fee_amount;
                                        }elseif($appliedFeeDetails->fee_type=="lab"){
                                            $labFee+=$feesList->fee_amount;
                                        }elseif($appliedFeeDetails->fee_type!="tuition"){
                                            $otherFee+=$feesList->fee_amount;

                                        }
                                        if ($appliedFeeDetails->fee_type=="tuition")
                                        {
                                            $current_month_tution_fee=$feesList->fee_amount;
                                        }
                                    }

                                }



                                if ($stdFeeDetail->fee_status == 0) {
//                                    $totalfee = $totalfee + $stdFeeDetail->last_amount;
//                                    $payable = $payable + $stdFeeDetail->last_amount;
                                    $totalfee = $totalfee + $stdFeeDetail->total_amount;
                                    $payable = $payable + $stdFeeDetail->total_amount;
                                    if($value['std_id']==1186)
                                    {
//                                        echo $totalfee;

                                    }

                                    if($stdArrears->std_fee_case==1)
                                    {
//                                        if($value['std_id']==989)
//                                            echo $current_month_tution_fee;
                                            $thisFeeMonth=$this->setMonthlyFeeByMonth($stdFeeDetail->fee_month);
                                        $feeofThisMonth=$current_month_tution_fee;
//                                        if($value['std_id']==989)
//                                            echo $feeofThisMonth.$thisFeeMonth;


                                    }else{
                                        $thisFeeMonth=$this->setBiMonthlyFeeByMonth($stdFeeDetail->fee_month);
                                        $feeofThisMonth=$current_month_tution_fee;

                                    }
//                                    $feeofThisMonth=$stdFeeDetail->last_amount;

//                                    if($value['std_id']==1135)
//                                    {
//                                        echo "<pre>";
//                                        print_r($stdFeeDetail->total_amount);echo "<pre>";
//                                        print_r($stdFeeDetail->fee_detail_id);
//
//
//                                    }

                                }
                                elseif ($stdFeeDetail->fee_status == 2) {
                                    if($stdArrears->std_fee_case==1)
                                    {
                                        $thisFeeMonth=$this->setMonthlyFeeByMonth($stdFeeDetail->fee_month);
                                        $feeofThisMonth=$current_month_tution_fee;

                                    }else{
                                        $thisFeeMonth=$this->setBiMonthlyFeeByMonth($stdFeeDetail->fee_month);
                                        $feeofThisMonth=$current_month_tution_fee;

                                    }

                                    $totalPaidFee=0;
                                    $totalExtraPaid=0;
                                    $feeDepositDetails = $this->Shared_model->selectDataWhereMultiple("tbl_student_fee_deposit", array('std_fee_detail_id' => $stdFeeDetail->fee_detail_id));
                                    foreach ($feeDepositDetails as $feeDepositDetail) {
                                        $totalPaidFee = $totalPaidFee + $feeDepositDetail->paid_amount;
                                        $totalExtraPaid = $totalExtraPaid + $feeDepositDetail->extra_amount;
                                        $grandExtraAmount += $feeDepositDetail->extra_amount;

                                    }
//                                    if($value['std_id']==1125)
//                                    {
//                                        echo $totalExtraPaid;
//                                    }
                                    $depositAmount = $depositAmount + $totalPaidFee;
                                    $totalfee = $totalfee + $stdFeeDetail->total_amount;
//                                    $payable = $payable + $stdFeeDetail->last_amount;
                                    $payable = $payable + $stdFeeDetail->total_amount;
//                                    $feeofThisMonth=$stdFeeDetail->last_amount-$totalPaidFee;
                                    if($stdArrears->std_fee_case==1)
                                    {
                                        $thisFeeMonth=$this->setMonthlyFeeByMonth($stdFeeDetail->fee_month);
                                        $feeofThisMonth=$current_month_tution_fee-$totalExtraPaid;

                                    }else{
                                        $thisFeeMonth=$this->setBiMonthlyFeeByMonth($stdFeeDetail->fee_month);
                                        $feeofThisMonth=$current_month_tution_fee-$totalExtraPaid;

                                    }


                                }
//                            $totalArrears=$totalArrears+$stdArrears->arrears;
                                $totalArrears=$totalArrears+$stdFeeDetail->arrears;
                                $discount+=$stdFeeDetail->total_discount;

                            }
                            else{
                                $feeDepositDetails = $this->Shared_model->selectDataWhereMultiple("tbl_student_fee_deposit", array('std_fee_detail_id' => $stdFeeDetail->fee_detail_id));
                                $totalExtraPaid=0;
                                if(!empty($feeDepositDetails))
                                {
                                    foreach ($feeDepositDetails as $feeDepositDetail) {
                                        $totalExtraPaid = $totalExtraPaid + $feeDepositDetail->extra_amount;
                                        $grandExtraAmount+= $feeDepositDetail->extra_amount;
//                                        if($value['std_id']==821)
//                                        {
//                                            echo $feeDepositDetail->extra_amount;
//                                        }

                                    }

                                }
//                                $depositAmount = $depositAmount + $totalExtraPaid;

                                if (strpos($stdFeeDetail->fee_month, '-') !== false) {
                                    $thisFeeMonth=$this->setBiMonthlyFeeByMonth($stdFeeDetail->fee_month);
                                    $feeofThisMonth=0-$totalExtraPaid;
                                }else
                                {
                                    $thisFeeMonth=$this->setMonthlyFeeByMonth($stdFeeDetail->fee_month);
                                    $feeofThisMonth=0-$totalExtraPaid;

                                }
                                if($stdArrears->std_fee_case==1)
                                {

                                }else{

                                }


                            }
                            if(!$installmentFlag)
                            {

                                if($stdFeeDetail->is_installment==1)
                                {
                                    $installmentFlag=true;
                                }
                            }


                            if(!isset($stdFeeByMonth[$thisFeeMonth]))
                            {
                                $stdFeeByMonth[$thisFeeMonth]=$feeofThisMonth;

                            }else{
//                                $stdFeeByMonth[$thisFeeMonth]=$stdFeeByMonth[$thisFeeMonth]+$totalExtraPaid;
                            }


                        }
                        else{

                            $feeDepositDetails = $this->Shared_model->selectDataWhereMultiple("tbl_student_fee_deposit", array('std_fee_detail_id' => $stdFeeDetail->fee_detail_id));
                            $totalPaidFeeLastSession=0;
                            $totalPaidFineLastSession=0;
                            $totalExtraPaid=0;
                            if(!empty($feeDepositDetails))
                            {
                                foreach ($feeDepositDetails as $feeDepositDetail) {
                                    $totalPaidFeeLastSession = $totalPaidFeeLastSession + $feeDepositDetail->paid_amount;
                                    $totalPaidFineLastSession = $totalPaidFineLastSession + $feeDepositDetail->fine;
                                    $totalExtraPaid = $totalExtraPaid + $feeDepositDetail->extra_amount;

                                }

                            }
                            $totalAppliedDiscounts=0;
                            $decodedFeediscounts=json_decode($stdFeeDetail->applied_discounts);
                            foreach ($decodedFeediscounts as $decodedFeediscount)if(!empty($decodedFeediscount))
                            {
                                $totalAppliedDiscounts+=$decodedFeediscount;
                            }
                             if($value['std_id']==1227)
                            {
//                                echo $stdFeeDetail->fee_detail_id;
//                                die();
//                                echo "<pre>";
//                                print_r($stdFeeDetail->last_amount);echo "<pre>";
//                                var_dump($feeDepositDetails);
//                                die();
//                                echo "<pre>";
//                                print_r($stdFeeDetail->total_amount);echo "<pre>";
//                                print_r($stdFeeDetail->last_amount);echo "<pre>";
//                                print_r($stdFeeDetail->arrears);echo "<pre>";
//                                print_r($totalPaidFeeLastSession);
//                                print_r($totalArrears);
//
//                                $totalArrears=(($totalArrears+$stdFeeDetail->last_amount)-$totalPaidFeeLastSession)+$totalPaidFineLastSession;
//                                echo $totalArrears;
//                                die();
//
//                            echo $totalArrears;echo "<pre>";
                                 $totalArrears=((($totalArrears+$stdFeeDetail->last_amount)-$totalPaidFeeLastSession)+$totalPaidFineLastSession)+$totalAppliedDiscounts;
//                                 echo $totalArrears;echo "<pre>";
                            }
                            if($stdArrears->std_fee_case==1)
                            {

                                $thisFeeMonth=$this->setMonthlyFeeByMonth($stdFeeDetail->fee_month);
                                $feeofThisMonth=0;
                            }else{
                                $thisFeeMonth=$this->setBiMonthlyFeeByMonth($stdFeeDetail->fee_month);
                                $feeofThisMonth=0;

                            }

                        }
                    }
//                     if($value['std_id']==989)
//                     {
//                         echo "<pre>";
//                         print_r($totalfee);
//
//
//                     }
//                    if($value['std_id']==1301||$value['roll_no']=='S-07-0617' )
//                    {
//                        echo $totalfee."<br>";
//
//                    }

                    $student_due_fee[$key]['totalExtraPaid'] = $totalExtraPaid;
                    $student_due_fee[$key]['grandExtraAmount'] = $grandExtraAmount;
                    $student_due_fee[$key]['fine_amount'] = $payable;
                    $student_due_fee[$key]['otherFee'] = $otherFee;
                    $student_due_fee[$key]['labFee'] = $labFee;
                    $student_due_fee[$key]['anuualFee'] = $anuualFee;
                    $student_due_fee[$key]['stdInstallment'] = ($installmentFlag)?"Yes":"No";
                    $student_due_fee[$key]['stdTuituionFee'] = $stdArrears->std_tuition_fee;
                    $student_due_fee[$key]['stdMonthFeesLists'] = $stdFeeByMonth;
//                    $student_due_fee[$key]['amount'] = $totalfee+$totalArrears;
//                    $student_due_fee[$key]['amount'] = $totalfee-$totalExtraPaid;
                    $student_due_fee[$key]['amount'] = $totalfee;
//                    $student_due_fee[$key]['amount'] =  $stdArrears->arrears;
                    $student_due_fee[$key]['amount_detail'] = $depositAmount;
                    $student_due_fee[$key]['total_discount'] = $discount;
//                    $student_due_fee[$key]['amount_arrears'] = $stdArrears->std_arrears;
                    $student_due_fee[$key]['amount_arrears'] = $totalArrears;
                }


            }
//            die();
            //            $student_due_fee         = $this->studentfee_model->getDueStudentFees($feegroup_id, $fee_groups_feetype_id, $class_id, $section_id);
//            if (!empty($student_due_fee)) {
//                foreach ($student_due_fee as $student_due_fee_key => $student_due_fee_value) {
//                    $amt_due                                                  = $student_due_fee_value['amount'];
//                    $student_due_fee[$student_due_fee_key]['amount_discount'] = 0;
//                    $student_due_fee[$student_due_fee_key]['amount_fine']     = 0;
//                    $a                                                        = json_decode($student_due_fee_value['amount_detail']);
//                    if (!empty($a)) {
//                        $amount          = 0;
//                        $amount_discount = 0;
//                        $amount_fine     = 0;
//
//                        foreach ($a as $a_key => $a_value) {
//                            $amount          = $amount + $a_value->amount;
//                            $amount_discount = $amount_discount + $a_value->amount_discount;
//                            $amount_fine     = $amount_fine + $a_value->amount_fine;
//                        }
//                        if ($amt_due <= $amount) {
//                            unset($student_due_fee[$student_due_fee_key]);
//                        } else {
//
//                            $student_due_fee[$student_due_fee_key]['amount_detail']   = $amount;
//                            $student_due_fee[$student_due_fee_key]['amount_discount'] = $amount_discount;
//                            $student_due_fee[$student_due_fee_key]['amount_fine']     = $amount_fine;
//                        }
//                    }
//                }
//            }

            // die();
//            foreach ($student_due_fee as $value)
//            {
//                if($value['std_id']==801)
//                {
//                    echo "<pre>";
//                    print_r($value);
//
//                }
//            }
//            die();
            $data['student_due_fee'] = $student_due_fee;
            $this->load->view('layout/header', $data);
            $this->load->view('studentfee/studentSearchFee', $data);
            $this->load->view('layout/footer', $data);
        }


    }
    public function setMonthlyFeeByMonth($feemonth)
    {
        if($feemonth==1)
        {
            $month="Jan";

        }elseif ($feemonth==2)
        {
            $month="Feb";
        }elseif ($feemonth==3)
        {
            $month="Mar";
        }elseif ($feemonth==4)
        {
            $month="Apr";
        }elseif ($feemonth==5)
        {
            $month="May";
        }elseif ($feemonth==6)
        {
            $month="Jun";
        }elseif ($feemonth==7)
        {
            $month="Jul";
        }elseif ($feemonth==8)
        {
            $month="Aug";
        }elseif ($feemonth==9)
        {
            $month="Sep";
        }elseif ($feemonth==10)
        {
            $month="Oct";
        }elseif ($feemonth==11)
        {
            $month="Nov";
        }elseif ($feemonth==12)
        {
            $month="Dec";
        }
        return $month;

    }
    function setBiMonthlyFeeByMonth($month)
    {
//        $month=ltrim(date('m'),'0');

        if($month=='8-9')
        {
            $returnMonth='Aug';

        }elseif ($month=='10-11' )
        {
            $returnMonth='Oct';
        }elseif ($month=='12-1' )
        {
            $returnMonth='Dec';
        }elseif ($month=='2-3' )
        {
            $returnMonth='Feb';
        }elseif ($month=='4-5')
        {
            $returnMonth='Apr';
        }elseif ($month=='6-7' )
        {
            $returnMonth='Jun';
        }
        return $returnMonth;
    }

    public function stdDiscountsearch()
    {
        if (!$this->rbac->hasPrivilege('search_due_fees', 'can_view')) {
            access_denied();
        }

        $this->session->set_userdata('top_menu', 'Fees Collection');
        $this->session->set_userdata('sub_menu', 'studentfee/feesearch');
        $data['title'] = 'student fees';
        $class = $this->class_model->get();
        $data['classlist'] = $class;
        $feesessiongroup = $this->feesessiongroup_model->getFeesByGroup();

        $data['feesessiongrouplist'] = $feesessiongroup;
        $data['fees_group'] = "";
        if (isset($_POST['feegroup_id']) && $_POST['feegroup_id'] != '') {
            $data['fees_group'] = $_POST['feegroup_id'];
        }

        $this->form_validation->set_rules('feegroup_id', $this->lang->line('fee_group'), 'trim|required|xss_clean');

//        $this->form_validation->set_rules('class_id', $this->lang->line('class'), 'trim|required|xss_clean');
//        $this->form_validation->set_rules('section_id', $this->lang->line('section'), 'trim|required|xss_clean');
        if ($this->form_validation->run() == false) {
            $this->load->view('layout/header', $data);
            $this->load->view('studentfee/studentDiscountFee', $data);
            $this->load->view('layout/footer', $data);
        } else {
            $data['student_due_fee'] = array();
            $feegroup_id = $this->input->post('feegroup_id');
//            $feegroup                = explode("-", $feegroup_id);
//            $feegroup_id             = $feegroup[0];
//            $fee_groups_feetype_id   = $feegroup[1];
            $class_id = $this->input->post('class_id');
            $section_id = $this->input->post('section_id');

            $student_due_fee = $this->studentfee_model->getStudentDueFee($feegroup_id, $class_id, $section_id);
            if (!empty($student_due_fee)) {
                foreach ($student_due_fee as $key => $value) {
                    $student_due_fee[$key]['amount_fine'] = 0;
                    $depositAmount = 0;
                    $discount = 0;
                    $payable = 0;
                    $totalfee = 0;
                    $totalArrears = 0;
                    $totalPaidFee = 0;
                    $stdFeeDetails = $this->Shared_model->selectDataWhereMultiple("tbl_student_fee_detail", array('std_fee_id' => $value['std_fee_id']));
                    $stdArrears = $this->Shared_model->selectDataWhereSingle("tbl_student_fee", array('std_fee_id' => $value['std_fee_id']));
                    foreach ($stdFeeDetails as $stdFeeDetail) {
                        $discount+=$stdFeeDetail->total_discount;
                        $discountedFeeAmount=0;
                        $totalfee = $totalfee +$stdFeeDetail->total_amount;
                        $feeDiscounts=$this->Shared_model->selectDataWhereSingle("tbl_fee_discounts",array('fee_detail_id'=>$stdFeeDetail->fee_detail_id));
                        if(!empty($feeDiscounts))
                        {
                            $discountRates=json_decode($feeDiscounts->discount_rate);
                            foreach ($discountRates as $discountRateValue)
                            {
                                $CheckfeeType=$this->Shared_model->selectDataWhereSingle("tbl_feetype",array('id'=>$discountRateValue->fee_type));
                                if($CheckfeeType->fee_type!="tuition")
                                {
                                    $discountedFeeAmount+=$discountRateValue->balance;
//                                                    if($discountRate->discount_type=="sibling")
//                                                    {
//
//                                                    }elseif($discountRate->discount_type=="custom")
//                                                    {
//
//                                                    }
                                }

                            }
                            $totalAmount=$discountedFeeAmount;
                            $sDiscount=$stdFeeDetail->total_amount-$discountedFeeAmount;
                            $discount+=$sDiscount;

                        }

//                        if ($stdFeeDetail->fee_status != 1) {
//                            if ($stdFeeDetail->fee_status == 0) {
//                                $totalfee = $totalfee + $stdFeeDetail->total_amount;
//                                $payable = $payable + $stdFeeDetail->last_amount;
//                            } else {
//                                $feeDepositDetails = $this->Shared_model->selectDataWhereMultiple("tbl_student_fee_deposit", array('std_fee_detail_id' => $stdFeeDetail->fee_detail_id));
//                                foreach ($feeDepositDetails as $feeDepositDetail) {
//                                    $totalPaidFee = $totalPaidFee + $feeDepositDetail->paid_amount;
//                                }
//                                $depositAmount = $depositAmount + $totalPaidFee;
//                                $totalfee = $totalfee + $stdFeeDetail->total_amount;
//                                $payable = $payable + $stdFeeDetail->last_amount;
//
//                            }
//                            $totalArrears=$totalArrears+$stdArrears->arrears;
//                            $totalArrears=$totalArrears+$stdFeeDetail->arrears;
//                            $discount+=$stdFeeDetail->total_discount;
//                        }
                    }
//                    $student_due_fee[$key]['amount'] = $payable;
                    $student_due_fee[$key]['amount'] = $totalfee;
//                    $student_due_fee[$key]['amount'] =  $stdArrears->arrears;
                    $student_due_fee[$key]['amount_detail'] = $totalfee-$discount;
                    $student_due_fee[$key]['total_discount'] = $discount;
//                    $student_due_fee[$key]['amount_arrears'] = $stdArrears->std_arrears;
                    $student_due_fee[$key]['amount_arrears'] = $totalArrears;
                }


            }
//            $student_due_fee         = $this->studentfee_model->getDueStudentFees($feegroup_id, $fee_groups_feetype_id, $class_id, $section_id);
//            if (!empty($student_due_fee)) {
//                foreach ($student_due_fee as $student_due_fee_key => $student_due_fee_value) {
//                    $amt_due                                                  = $student_due_fee_value['amount'];
//                    $student_due_fee[$student_due_fee_key]['amount_discount'] = 0;
//                    $student_due_fee[$student_due_fee_key]['amount_fine']     = 0;
//                    $a                                                        = json_decode($student_due_fee_value['amount_detail']);
//                    if (!empty($a)) {
//                        $amount          = 0;
//                        $amount_discount = 0;
//                        $amount_fine     = 0;
//
//                        foreach ($a as $a_key => $a_value) {
//                            $amount          = $amount + $a_value->amount;
//                            $amount_discount = $amount_discount + $a_value->amount_discount;
//                            $amount_fine     = $amount_fine + $a_value->amount_fine;
//                        }
//                        if ($amt_due <= $amount) {
//                            unset($student_due_fee[$student_due_fee_key]);
//                        } else {
//
//                            $student_due_fee[$student_due_fee_key]['amount_detail']   = $amount;
//                            $student_due_fee[$student_due_fee_key]['amount_discount'] = $amount_discount;
//                            $student_due_fee[$student_due_fee_key]['amount_fine']     = $amount_fine;
//                        }
//                    }
//                }
//            }

//            echo "<pre>";
//            print_r($student_due_fee);
//            die();
            $data['student_due_fee'] = $student_due_fee;
            $this->load->view('layout/header', $data);
            $this->load->view('studentfee/studentDiscountFee', $data);
            $this->load->view('layout/footer', $data);
        }
    }
    public function stdInstallmentSearch()
    {
        if (!$this->rbac->hasPrivilege('search_due_fees', 'can_view')) {
            access_denied();
        }

        $this->session->set_userdata('top_menu', 'Fees Collection');
        $this->session->set_userdata('sub_menu', 'studentfee/feesearch');
        $data['title'] = 'student fees';
        $class = $this->class_model->get();
        $data['classlist'] = $class;
        $feesessiongroup = $this->feesessiongroup_model->getFeesByGroup();
        $months = array( 'Jul', 'Aug', 'Sep','Oct','Nov', 'Dec','Jan', 'Feb', 'Mar', 'Apr','May', 'Jun');
        $data['monthsLists'] = $months;

        $data['feesessiongrouplist'] = $feesessiongroup;
        $data['fees_group'] = "";
        if (isset($_POST['feegroup_id']) && $_POST['feegroup_id'] != '') {
            $data['fees_group'] = $_POST['feegroup_id'];
        }

        $this->form_validation->set_rules('feegroup_id', $this->lang->line('fee_group'), 'trim|required|xss_clean');

//        $this->form_validation->set_rules('class_id', $this->lang->line('class'), 'trim|required|xss_clean');
//        $this->form_validation->set_rules('section_id', $this->lang->line('section'), 'trim|required|xss_clean');
        if ($this->form_validation->run() == false) {
            $this->load->view('layout/header', $data);
            $this->load->view('studentfee/studentInstallmentList', $data);
            $this->load->view('layout/footer', $data);
        } else {
            $data['student_due_fee'] = array();
            $feegroup_id = $this->input->post('feegroup_id');
//            $feegroup                = explode("-", $feegroup_id);
//            $feegroup_id             = $feegroup[0];
//            $fee_groups_feetype_id   = $feegroup[1];
            $class_id = $this->input->post('class_id');
            $section_id = $this->input->post('section_id');

            $student_due_fee = $this->studentfee_model->getStudentDueFee($feegroup_id, $class_id, $section_id);
            if (!empty($student_due_fee)) {
                foreach ($student_due_fee as $key => $value) {
                    $student_due_fee[$key]['amount_fine'] = 0;
                    $depositAmount = 0;
                    $discount = 0;
                    $payable = 0;
                    $totalfee = 0;
                    $totalArrears = 0;
                    $totalPaidFee = 0;
                    $feeArrear = 0;
                    $feeAmount = 0;
                    $totalFeeAmount = 0;
                    $totalPaid=0;
                    $totalPayable=0;
                    $installmentpaid_balance=0;
                    $installmentPayable_baln=0;
                    $installmentAmountOfMonth=0;
                    $stdInstallmentByMonth=[];

                    $stdFeeDetails = $this->Shared_model->selectDataWhereMultiple("tbl_student_fee_detail", array('std_fee_id' => $value['std_fee_id']));
                    foreach ($stdFeeDetails as $stdFeeDetail) {

                        if($stdFeeDetail->is_installment==1)
                        {
                            $totalFeeAmount=$totalFeeAmount+$stdFeeDetail->last_amount;
//                            $feeArrear+=$stdFeeDetail->arrears;
//                            $feeAmount+=$stdFeeDetail->last_amount;
//                            $totalFeeAmount+=$feeArrear+$feeAmount;
                            $isInstallment=$this->Shared_model->selectDataWhereSingle("tbl_fee_installments", array('fee_detail_id' =>$stdFeeDetail->fee_detail_id,'std_id'=>$value['std_id']));
                            if(!empty($isInstallment))
                            {
                                $stdInstallmentDetails = $this->Shared_model->selectDataWhereMultiple("tbl_installment_details", array('installment_id' => $isInstallment->installment_id));
                                $installmentAmountOfMonth=0;
                                foreach ($stdInstallmentDetails as $installmentDetail)
                                {
                                    $feeInstallmentDepositDetails=$this->Shared_model->selectDataWhereMultiple("tbl_student_fee_deposit",array('is_installment'=>1,'installment_detail_id'=>$installmentDetail->installment_detail_id));
                                    $installmentpaid=0;
                                    if(!empty($feeInstallmentDepositDetails))
                                    {
                                        foreach ($feeInstallmentDepositDetails as $feeInstallmentDepositDetail)
                                        {
                                            $installmentpaid=$installmentpaid+$feeInstallmentDepositDetail->paid_amount;
                                        }
                                        $installmentpaid_balance+=$installmentpaid;
                                        $installmentPayable_baln+=$installmentDetail->amount-$installmentpaid;
                                        $InstallmentMonth=$this->setMonthlyFeeByMonth(ltrim(date('m',strtotime($installmentDetail->due_date)),'0'));
                                        $installmentAmountOfMonth=$installmentDetail->amount-$installmentpaid;
                                        if(isset($stdInstallmentByMonth[$InstallmentMonth]))
                                        {
                                            $stdInstallmentByMonth[$InstallmentMonth]=$stdInstallmentByMonth[$InstallmentMonth]+$installmentAmountOfMonth;

                                        }else{
                                            $stdInstallmentByMonth[$InstallmentMonth]=$installmentAmountOfMonth;

                                        }

                                    }else
                                    {
                                        $InstallmentMonth=$this->setMonthlyFeeByMonth(ltrim(date('m',strtotime($installmentDetail->due_date)),'0'));
                                        $installmentAmountOfMonth=$installmentDetail->amount;
                                        $installmentPayable_baln+=$installmentDetail->amount;
                                        if(isset($stdInstallmentByMonth[$InstallmentMonth]))
                                        {
                                            $stdInstallmentByMonth[$InstallmentMonth]=$stdInstallmentByMonth[$InstallmentMonth]+$installmentAmountOfMonth;

                                        }else{
                                            $stdInstallmentByMonth[$InstallmentMonth]=$installmentAmountOfMonth;

                                        }
                                    }
                                }
                            }

                        }

                    }
                     $student_due_fee[$key]['stdInstallmentByMonth'] = $stdInstallmentByMonth;
                    $student_due_fee[$key]['total_amount'] = $totalFeeAmount;
                    $student_due_fee[$key]['deposit'] = $installmentpaid_balance;
                    $student_due_fee[$key]['payable'] = $installmentPayable_baln;
                }


            }
//            echo "<pre>";
//            print_r($student_due_fee);
//            die();
            $data['student_due_fee'] = $student_due_fee;
            $this->load->view('layout/header', $data);
            $this->load->view('studentfee/studentInstallmentList', $data);
            $this->load->view('layout/footer', $data);
        }
    }

    public function reportbyname()
    {
        if (!$this->rbac->hasPrivilege('fees_statement', 'can_view')) {
            access_denied();
        }
        $this->session->set_userdata('top_menu', 'Reports');
        $this->session->set_userdata('sub_menu', 'Reports/finance');
        $this->session->set_userdata('subsub_menu', 'Reports/finance/reportbyname');
        $data['title'] = 'student fees';
        $data['title'] = 'student fees';
        $class = $this->class_model->get();
        $data['classlist'] = $class;

        if ($this->input->server('REQUEST_METHOD') == "GET") {

            $this->load->view('layout/header', $data);
            $this->load->view('studentfee/reportByName', $data);
            $this->load->view('layout/footer', $data);

        } else {

            $this->form_validation->set_rules('section_id', $this->lang->line('section'), 'trim|required|xss_clean');
            $this->form_validation->set_rules('class_id', $this->lang->line('class'), 'trim|required|xss_clean');
            $this->form_validation->set_rules('student_id', $this->lang->line('student'), 'trim|required|xss_clean');

            if ($this->form_validation->run() == false) {

                $this->load->view('layout/header', $data);
                $this->load->view('studentfee/reportByName', $data);
                $this->load->view('layout/footer', $data);

            } else {

                $data['student_due_fee'] = array();
                $class_id = $this->input->post('class_id');
                $section_id = $this->input->post('section_id');
                $student_id = $this->input->post('student_id');
                $student = $this->student_model->get($student_id);
                $data['student'] = $student;
                $student_due_fee = $this->studentfeemaster_model->getStudentFees($student['student_session_id']);
                $student_discount_fee = $this->feediscount_model->getStudentFeesDiscount($student['student_session_id']);
                $student_fee = $this->student_model->getStudentFee($student_id);
                $data['student_discount_fee'] = $student_discount_fee;
                $data['student_due_fee'] = $student_due_fee;
                $data['student_fee'] = $student_fee;
                $data['class_id'] = $class_id;
                $data['section_id'] = $section_id;
                $data['student_id'] = $student_id;
                $category = $this->category_model->get();
                $data['categorylist'] = $category;
                $this->load->view('layout/header', $data);
                $this->load->view('studentfee/reportByName', $data);
                $this->load->view('layout/footer', $data);
            }
        }
    }

    public function reportbyclass()
    {
        $data['title'] = 'student fees';
        $data['title'] = 'student fees';
        $class = $this->class_model->get();
        $data['classlist'] = $class;
        if ($this->input->server('REQUEST_METHOD') == "GET") {
            $this->load->view('layout/header', $data);
            $this->load->view('studentfee/reportByClass', $data);
            $this->load->view('layout/footer', $data);
        } else {
            $student_fees_array = array();
            $class_id = $this->input->post('class_id');
            $section_id = $this->input->post('section_id');
            $student_result = $this->student_model->searchByClassSection($class_id, $section_id);
            $data['student_due_fee'] = array();
            if (!empty($student_result)) {
                foreach ($student_result as $key => $student) {
                    $student_array = array();
                    $student_array['student_detail'] = $student;
                    $student_session_id = $student['student_session_id'];
                    $student_id = $student['id'];
                    $student_due_fee = $this->studentfee_model->getDueFeeBystudentSection($class_id, $section_id, $student_session_id);
                    $student_array['fee_detail'] = $student_due_fee;
                    $student_fees_array[$student['id']] = $student_array;
                }
            }
            $data['class_id'] = $class_id;
            $data['section_id'] = $section_id;
            $data['student_fees_array'] = $student_fees_array;
            $this->load->view('layout/header', $data);
            $this->load->view('studentfee/reportByClass', $data);
            $this->load->view('layout/footer', $data);
        }
    }

    public function view($id)
    {
        if (!$this->rbac->hasPrivilege('collect_fees', 'can_view')) {
            access_denied();
        }
        $data['title'] = 'studentfee List';
        $studentfee = $this->studentfee_model->get($id);
        $data['studentfee'] = $studentfee;
        $this->load->view('layout/header', $data);
        $this->load->view('studentfee/studentfeeShow', $data);
        $this->load->view('layout/footer', $data);
    }

    public function deleteFee()
    {

        if (!$this->rbac->hasPrivilege('collect_fees', 'can_delete')) {
            access_denied();
        }
        $invoice_id = $this->input->post('main_invoice');
        $sub_invoice = $this->input->post('sub_invoice');
        if (!empty($invoice_id)) {
            $this->studentfee_model->remove($invoice_id, $sub_invoice);
        }
        $array = array('status' => 'success', 'result' => 'success');
        echo json_encode($array);
    }

    public function deleteStudentDiscount()
    {

        $discount_id = $this->input->post('discount_id');
        if (!empty($discount_id)) {
            $data = array('id' => $discount_id, 'status' => 'assigned', 'payment_id' => "");
            $this->feediscount_model->updateStudentDiscount($data);
        }
        $array = array('status' => 'success', 'result' => 'success');
        echo json_encode($array);
    }

    public function getcollectfee()
    {
        $setting_result = $this->setting_model->get();
        $data['settinglist'] = $setting_result;
        $record = $this->input->post('data');
        $record_array = json_decode($record);

        $fees_array = array();
        foreach ($record_array as $key => $value) {
            $fee_groups_feetype_id = $value->fee_groups_feetype_id;
            $fee_master_id = $value->fee_master_id;
            $fee_session_group_id = $value->fee_session_group_id;
            $feeList = $this->studentfeemaster_model->getDueFeeByFeeSessionGroupFeetype($fee_session_group_id, $fee_master_id, $fee_groups_feetype_id);
            $fees_array[] = $feeList;
        }
        $data['feearray'] = $fees_array;
        $result = array(
            'view' => $this->load->view('studentfee/getcollectfee', $data, true),
        );

        $this->output->set_output(json_encode($result));

    }

    public function addfee($id)
    {
        if (!$this->rbac->hasPrivilege('collect_fees', 'can_add')) {
            access_denied();
        }
        $data['title'] = 'Student Detail';

        $student = $this->student_model->getByStudentSession($id);
        $data['student'] = $student;

        $student_due_fee = $this->studentfeemaster_model->getStudentFees($id);

        $student_discount_fee = $this->feediscount_model->getStudentFeesDiscount($id);

        $data['student_discount_fee'] = $student_discount_fee;
        $data['student_due_fee'] = $student_due_fee;
        $category = $this->category_model->get();
        $data['categorylist'] = $category;
        $class_section = $this->student_model->getClassSection($student["class_id"]);
        $data["class_section"] = $class_section;
        $session = $this->setting_model->getCurrentSession();
        $studentlistbysection = $this->student_model->getStudentClassSection($student["class_id"], $session);
        $data["studentlistbysection"] = $studentlistbysection;

        $this->load->view('layout/header', $data);
        $this->load->view('studentfee/studentAddfee', $data);
        $this->load->view('layout/footer', $data);
    }

    public function deleteTransportFee()
    {
        $id = $this->input->post('feeid');
        $this->studenttransportfee_model->remove($id);
        $array = array('status' => 'success', 'result' => 'success');
        echo json_encode($array);
    }

    public function delete($id)
    {
        $data['title'] = 'studentfee List';
        $this->studentfee_model->remove($id);
        redirect('studentfee/index');
    }

    public function create()
    {
        if (!$this->rbac->hasPrivilege('collect_fees', 'can_view')) {
            access_denied();
        }
        $data['title'] = 'Add studentfee';
        $this->form_validation->set_rules('category', $this->lang->line('category'), 'trim|required|xss_clean');
        if ($this->form_validation->run() == false) {
            $this->load->view('layout/header', $data);
            $this->load->view('studentfee/studentfeeCreate', $data);
            $this->load->view('layout/footer', $data);
        } else {
            $data = array(
                'category' => $this->input->post('category'),
            );
            $this->studentfee_model->add($data);
            $this->session->set_flashdata('msg', '<div studentfee="alert alert-success text-center">' . $this->lang->line('success_message') . '</div>');
            redirect('studentfee/index');
        }
    }

    public function edit($id)
    {
        if (!$this->rbac->hasPrivilege('collect_fees', 'can_edit')) {
            access_denied();
        }
        $data['title'] = 'Edit studentfees';
        $data['id'] = $id;
        $studentfee = $this->studentfee_model->get($id);
        $data['studentfee'] = $studentfee;
        $this->form_validation->set_rules('category', $this->lang->line('category'), 'trim|required|xss_clean');
        if ($this->form_validation->run() == false) {
            $this->load->view('layout/header', $data);
            $this->load->view('studentfee/studentfeeEdit', $data);
            $this->load->view('layout/footer', $data);
        } else {
            $data = array(
                'id' => $id,
                'category' => $this->input->post('category'),
            );
            $this->studentfee_model->add($data);
            $this->session->set_flashdata('msg', '<div studentfee="alert alert-success text-center">' . $this->lang->line('update_message') . '</div>');
            redirect('studentfee/index');
        }
    }

    public function addstudentfee()
    {

        $this->form_validation->set_rules('student_fees_master_id', $this->lang->line('fee_master'), 'required|trim|xss_clean');
        $this->form_validation->set_rules('fee_groups_feetype_id', $this->lang->line('student'), 'required|trim|xss_clean');
        $this->form_validation->set_rules('amount', $this->lang->line('amount'), 'required|trim|xss_clean|callback_check_deposit');
        $this->form_validation->set_rules('amount_discount', $this->lang->line('discount'), 'required|trim|xss_clean');
        $this->form_validation->set_rules('amount_fine', $this->lang->line('fine'), 'required|trim|xss_clean');
        $this->form_validation->set_rules('payment_mode', $this->lang->line('payment_mode'), 'required|trim|xss_clean');
        if ($this->form_validation->run() == false) {
            $data = array(
                'amount' => form_error('amount'),
                'student_fees_master_id' => form_error('student_fees_master_id'),
                'fee_groups_feetype_id' => form_error('fee_groups_feetype_id'),
                'amount_discount' => form_error('amount_discount'),
                'amount_fine' => form_error('amount_fine'),
                'payment_mode' => form_error('payment_mode'),
            );
            $array = array('status' => 'fail', 'error' => $data);
            echo json_encode($array);
        } else {
            $staff_record = $this->staff_model->get($this->customlib->getStaffID());

            $collected_by = " Collected By: " . $this->customlib->getAdminSessionUserName() . "(" . $staff_record['employee_id'] . ")";
            $student_fees_discount_id = $this->input->post('student_fees_discount_id');
            $json_array = array(
                'amount' => $this->input->post('amount'),
                'date' => date('Y-m-d', $this->customlib->datetostrtotime($this->input->post('date'))),
                'amount_discount' => $this->input->post('amount_discount'),
                'amount_fine' => $this->input->post('amount_fine'),
                'description' => $this->input->post('description') . $collected_by,
                'payment_mode' => $this->input->post('payment_mode'),
                'received_by' => $staff_record['id'],
            );
            $data = array(
                'student_fees_master_id' => $this->input->post('student_fees_master_id'),
                'fee_groups_feetype_id' => $this->input->post('fee_groups_feetype_id'),
                'amount_detail' => $json_array,
            );

            $send_to = $this->input->post('guardian_phone');
            $email = $this->input->post('guardian_email');
            $parent_app_key = $this->input->post('parent_app_key');
            $inserted_id = $this->studentfeemaster_model->fee_deposit($data, $send_to, $student_fees_discount_id);
            $mailsms_array = $this->feegrouptype_model->getFeeGroupByID($this->input->post('fee_groups_feetype_id'));

            $mailsms_array->invoice = $inserted_id;
            $mailsms_array->contact_no = $send_to;
            $mailsms_array->email = $email;
            $mailsms_array->parent_app_key = $parent_app_key;

            $this->mailsmsconf->mailsms('fee_submission', $mailsms_array);

            $array = array('status' => 'success', 'error' => '');
            echo json_encode($array);
        }
    }

    public function printFeesByName()
    {
        $data = array('payment' => "0");
        $record = $this->input->post('data');
        $invoice_id = $this->input->post('main_invoice');
        $sub_invoice_id = $this->input->post('sub_invoice');
        $student_session_id = $this->input->post('student_session_id');
        $setting_result = $this->setting_model->get();
        $data['settinglist'] = $setting_result;
        $student = $this->studentsession_model->searchStudentsBySession($student_session_id);

        $fee_record = $this->studentfeemaster_model->getFeeByInvoice($invoice_id, $sub_invoice_id);
        $data['student'] = $student;
        $data['sub_invoice_id'] = $sub_invoice_id;
        $data['feeList'] = $fee_record;
        $this->load->view('print/printFeesByName', $data);
    }

    public function printFeesByGroup()
    {
        $fee_groups_feetype_id = $this->input->post('fee_groups_feetype_id');
        $fee_master_id = $this->input->post('fee_master_id');
        $fee_session_group_id = $this->input->post('fee_session_group_id');
        $setting_result = $this->setting_model->get();
        $data['settinglist'] = $setting_result;
        $data['feeList'] = $this->studentfeemaster_model->getDueFeeByFeeSessionGroupFeetype($fee_session_group_id, $fee_master_id, $fee_groups_feetype_id);

        $this->load->view('print/printFeesByGroup', $data);
    }

    public function printFeesByGroupArray()
    {
        $setting_result = $this->setting_model->get();

        $data['settinglist'] = $setting_result;
        $record = $this->input->post('data');
        $record_array = json_decode($record);
        $fees_array = array();
        foreach ($record_array as $key => $value) {
            $fee_groups_feetype_id = $value->fee_groups_feetype_id;
            $fee_master_id = $value->fee_master_id;
            $fee_session_group_id = $value->fee_session_group_id;
            $feeList = $this->studentfeemaster_model->getDueFeeByFeeSessionGroupFeetype($fee_session_group_id, $fee_master_id, $fee_groups_feetype_id);
            $fees_array[] = $feeList;
        }
        $data['feearray'] = $fees_array;
        $this->load->view('print/printFeesByGroupArray', $data);
    }

    public function searchpayment()
    {
        if (!$this->rbac->hasPrivilege('search_fees_payment', 'can_view')) {
            access_denied();
        }
        $this->session->set_userdata('top_menu', 'Fees Collection');
        $this->session->set_userdata('sub_menu', 'studentfee/searchpayment');
        $data['title'] = 'Edit studentfees';

        $this->form_validation->set_rules('paymentid', $this->lang->line('payment_id'), 'trim|required|xss_clean');
        if ($this->form_validation->run() == false) {

        } else {
            $paymentid = $this->input->post('paymentid');
            $invoice = explode("/", $paymentid);

            if (array_key_exists(0, $invoice) && array_key_exists(1, $invoice)) {
                $invoice_id = $invoice[0];
                $sub_invoice_id = $invoice[1];
                $feeList = $this->studentfeemaster_model->getFeeByInvoice($invoice_id, $sub_invoice_id);
                $data['feeList'] = $feeList;
                $data['sub_invoice_id'] = $sub_invoice_id;
            } else {
                $data['feeList'] = array();
            }
        }
        $this->load->view('layout/header', $data);
        $this->load->view('studentfee/searchpayment', $data);
        $this->load->view('layout/footer', $data);
    }

    public function addfeegroup()
    {
        $this->form_validation->set_rules('fee_session_groups', $this->lang->line('fee_group'), 'required|trim|xss_clean');

        if ($this->form_validation->run() == false) {
            $data = array(
                'fee_session_groups' => form_error('fee_session_groups'),
            );
            $array = array('status' => 'fail', 'error' => $data);
            echo json_encode($array);
        } else {
            $student_session_id = $this->input->post('student_session_id');
            $fee_session_groups = $this->input->post('fee_session_groups');
            $student_sesssion_array = isset($student_session_id) ? $student_session_id : array();
            $student_ids = $this->input->post('student_ids');
            $delete_student = array_diff($student_ids, $student_sesssion_array);

            $preserve_record = array();
            if (!empty($student_sesssion_array)) {
                foreach ($student_sesssion_array as $key => $value) {
                    $insert_array = array(
                        'student_session_id' => $value,
                        'fee_session_group_id' => $fee_session_groups,
                    );
                    $inserted_id = $this->studentfeemaster_model->add($insert_array);

                    $preserve_record[] = $inserted_id;
                }
            }
            if (!empty($delete_student)) {
                $this->studentfeemaster_model->delete($fee_session_groups, $delete_student);
            }

            $array = array('status' => 'success', 'error' => '', 'message' => $this->lang->line('success_message'));
            echo json_encode($array);
        }
    }

    public function geBalanceFee()
    {
        $this->form_validation->set_rules('fee_groups_feetype_id', $this->lang->line('fee_groups_feetype_id'), 'required|trim|xss_clean');
        $this->form_validation->set_rules('student_fees_master_id', 'student_fees_master_id', 'required|trim|xss_clean');
        $this->form_validation->set_rules('student_session_id', 'student_session_id', 'required|trim|xss_clean');

        if ($this->form_validation->run() == false) {
            $data = array(
                'fee_groups_feetype_id' => form_error('fee_groups_feetype_id'),
                'student_fees_master_id' => form_error('student_fees_master_id'),
            );
            $array = array('status' => 'fail', 'error' => $data);
            echo json_encode($array);
        } else {
            $data = array();
            $student_session_id = $this->input->post('student_session_id');
            $fee_groups_feetype_id = $this->input->post('fee_groups_feetype_id');
            $student_fees_master_id = $this->input->post('student_fees_master_id');
            $remain_amount_object = $this->getStuFeetypeBalance($fee_groups_feetype_id, $student_fees_master_id);
            $discount_not_applied = $this->getNotAppliedDiscount($student_session_id);
            $remain_amount = json_decode($remain_amount_object)->balance;
            $remain_amount_fine = json_decode($remain_amount_object)->fine_amount;

            $array = array('status' => 'success', 'error' => '', 'balance' => $remain_amount, 'discount_not_applied' => $discount_not_applied, 'remain_amount_fine' => $remain_amount_fine);
            echo json_encode($array);
        }
    }

    public function getStuFeetypeBalance($fee_groups_feetype_id, $student_fees_master_id)
    {
        $data = array();
        $data['fee_groups_feetype_id'] = $fee_groups_feetype_id;
        $data['student_fees_master_id'] = $student_fees_master_id;
        $result = $this->studentfeemaster_model->studentDeposit($data);
        $amount_balance = 0;
        $amount = 0;
        $amount_fine = 0;
        $amount_discount = 0;
        $fine_amount = 0;
        $fee_fine_amount = 0;
        $due_amt = $result->amount;
        if (strtotime($result->due_date) < strtotime(date('Y-m-d'))) {
            $fee_fine_amount = $result->fine_amount;
        }

        if ($result->is_system) {
            $due_amt = $result->student_fees_master_amount;
        }

        $amount_detail = json_decode($result->amount_detail);
        if (is_object($amount_detail)) {

            foreach ($amount_detail as $amount_detail_key => $amount_detail_value) {
                $amount = $amount + $amount_detail_value->amount;
                $amount_discount = $amount_discount + $amount_detail_value->amount_discount;
                $amount_fine = $amount_fine + $amount_detail_value->amount_fine;
            }
        }

        $amount_balance = $due_amt - ($amount + $amount_discount);
        $fine_amount = abs($amount_fine - $fee_fine_amount);
        $array = array('status' => 'success', 'error' => '', 'balance' => $amount_balance, 'fine_amount' => $fine_amount);
        return json_encode($array);
    }

    public function check_deposit($amount)
    {
        if ($this->input->post('amount') != "" && $this->input->post('amount_discount') != "") {
            if ($this->input->post('amount') < 0) {
                $this->form_validation->set_message('check_deposit', $this->lang->line('deposit_amount_can_not_be_less_than_zero'));
                return false;
            } else {
                $student_fees_master_id = $this->input->post('student_fees_master_id');
                $fee_groups_feetype_id = $this->input->post('fee_groups_feetype_id');
                $deposit_amount = $this->input->post('amount') + $this->input->post('amount_discount');
                $remain_amount = $this->getStuFeetypeBalance($fee_groups_feetype_id, $student_fees_master_id);
                $remain_amount = json_decode($remain_amount)->balance;
                if ($remain_amount < $deposit_amount) {
                    $this->form_validation->set_message('check_deposit', $this->lang->line('deposit_amount_can_not_be_greater_than_remaining'));
                    return false;
                } else {
                    return true;
                }
            }
            return true;
        }
        return true;
    }

    public function getNotAppliedDiscount($student_session_id)
    {
        return $this->feediscount_model->getDiscountNotApplied($student_session_id);
    }

    public function addfeegrp()
    {

        $staff_record = $this->session->userdata('admin');

        $this->form_validation->set_error_delimiters('', '');
        $this->form_validation->set_rules('row_counter[]', 'Fees List', 'required|trim|xss_clean');
        $this->form_validation->set_rules('collected_date', 'Date', 'required|trim|xss_clean');

        if ($this->form_validation->run() == false) {
            $data = array(
                'row_counter' => form_error('row_counter'),
                'collected_date' => form_error('collected_date'),
            );
            $array = array('status' => 0, 'error' => $data);
            echo json_encode($array);
        } else {
            $collected_array = array();
            $collected_by = " Collected By: " . $this->customlib->getAdminSessionUserName();

            $total_row = $this->input->post('row_counter');
            foreach ($total_row as $total_row_key => $total_row_value) {

                $this->input->post('student_fees_master_id_' . $total_row_value);
                $this->input->post('fee_groups_feetype_id_' . $total_row_value);

                $json_array = array(
                    'amount' => $this->input->post('fee_amount_' . $total_row_value),
                    'date' => date('Y-m-d'),
                    'description' => $this->input->post('fee_gupcollected_note') . $collected_by,
                    'amount_discount' => 0,
                    'amount_fine' => 0,
                    'payment_mode' => $this->input->post('payment_mode_fee'),
                    'received_by' => $staff_record['id'],
                );
                $collected_array[] = array(
                    'student_fees_master_id' => $this->input->post('student_fees_master_id_' . $total_row_value),
                    'fee_groups_feetype_id' => $this->input->post('fee_groups_feetype_id_' . $total_row_value),
                    'amount_detail' => $json_array,
                );

            }

            $inserted_id = $this->studentfeemaster_model->fee_deposit_collections($collected_array);
            $array = array('status' => 1, 'error' => '');
            echo json_encode($array);
        }
    }

    public function feeType()
    {
        if (!$this->rbac->hasPrivilege('fees_type', 'can_view')) {
            access_denied();
        }
        $this->session->set_userdata('top_menu', $this->lang->line('fees_collection'));
        $this->session->set_userdata('sub_menu', 'studentfee/feeType');
        $data['title'] = 'Add Feetype';
        $data['title_list'] = 'Recent FeeType';
        $this->form_validation->set_rules('name', $this->lang->line('name'), 'required');
        $this->form_validation->set_rules('amount', $this->lang->line('amount'), 'required');
        $this->form_validation->set_rules('fee_type', 'Fee Type', 'required');
        if ($this->form_validation->run() == FALSE) {

        } else {
            $data = array(
                'type' => $this->input->post('name'),
                'amount' => $this->input->post('amount'),
                'fee_type' => $this->input->post('fee_type'),
                'description' => $this->input->post('description'),
            );
            $this->studentfee_model->addFeetype($data);
            $this->session->set_flashdata('msg', '<div class="alert alert-success text-left">' . $this->lang->line('success_message') . '</div>');
            redirect('studentfee/feeType');
        }
        $feegroup_result = $this->studentfee_model->getFeeType();
        $data['feetypeList'] = $feegroup_result;

        $this->load->view('layout/header', $data);
        $this->load->view('admin/feetype/feetypeCreate', $data);
        $this->load->view('layout/footer', $data);


    }

    function deleteFeeType($id)
    {
        if (!$this->rbac->hasPrivilege('fees_type', 'can_delete')) {
            access_denied();
        }
        $data['title'] = 'Fees Master List';
        $this->studentfee_model->remove($id);
        redirect('studentfee/feeType');
    }

    function editFeeType($id)
    {
        if (!$this->rbac->hasPrivilege('fees_type', 'can_edit')) {
            access_denied();
        }
        $this->session->set_userdata('top_menu', $this->lang->line('fees_collection'));
        $this->session->set_userdata('sub_menu', 'studentfee/feeType');
        $data['id'] = $id;
        $feetype = $this->studentfee_model->getFeeType($id);
        $data['feetype'] = $feetype;
        $feegroup_result = $this->studentfee_model->getFeeType();
        $data['feetypeList'] = $feegroup_result;
        $this->form_validation->set_rules(
            'name', $this->lang->line('name'), array(
                'required',
                array('check_exists', array($this->studentfee_model, 'check_exists'))
            )
        );
        $this->form_validation->set_rules('fee_type', 'Fee Type', 'required');
        $this->form_validation->set_rules('amount', $this->lang->line('amount'), 'required');
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('layout/header', $data);
            $this->load->view('admin/feetype/new_feeTypeEdit', $data);
            $this->load->view('layout/footer', $data);
        } else {
            $data = array(
                'id' => $id,
                'type' => $this->input->post('name'),
                'amount' => $this->input->post('amount'),
                'fee_type' => $this->input->post('fee_type'),
                'description' => $this->input->post('description'),
            );
            $this->studentfee_model->addFeetype($data);
            $this->session->set_flashdata('msg', '<div class="alert alert-success text-left">' . $this->lang->line('update_message') . '</div>');
            redirect('studentfee/feeType');
        }
    }

    function feeCollection()
    {
        if (!$this->rbac->hasPrivilege('collect_fees', 'can_view')) {
            access_denied();
        }

        $this->session->set_userdata('top_menu', $this->lang->line('fees_collection'));
        $this->session->set_userdata('sub_menu', 'studentfee/collectFee');
        $data['title'] = 'student fees';
        $class = $this->class_model->get();
        $data['classlist'] = $class;
        $this->load->view('layout/header', $data);
        $this->load->view('studentfee/studentfeeSearch', $data);
        $this->load->view('layout/footer', $data);
    }

    function assignFee()
    {
        if (!$this->rbac->hasPrivilege('collect_fees', 'can_view')) {
            access_denied();
        }

        $this->session->set_userdata('top_menu', $this->lang->line('fees_collection'));
        $this->session->set_userdata('sub_menu', 'studentfee/assignFee');
        $data['title'] = 'student fees';
        $class = $this->class_model->get();
        $data['classlist'] = $class;
        $data['fee_case'] = '';
        $this->load->view('layout/header', $data);
        $this->load->view('studentfee/studentfeeAssign', $data);
        $this->load->view('layout/footer', $data);
    }
    function check_assignFee()
    {
        if (!$this->rbac->hasPrivilege('collect_fees', 'can_view')) {
            access_denied();
        }

        $this->session->set_userdata('top_menu', $this->lang->line('fees_collection'));
        $this->session->set_userdata('sub_menu', 'studentfee/check_assignFee');
        $data['title'] = 'student fees';
        $class = $this->class_model->get();
        $data['classlist'] = $class;
        $data['fee_case'] = '';
        $data['month'] = '';
        $this->load->view('layout/header', $data);
        $this->load->view('studentfee/std_check_assignFee', $data);
        $this->load->view('layout/footer', $data);
    }

    function assignFeeSearch()
    {
        if (!$this->rbac->hasPrivilege('collect_fees', 'can_view')) {
            access_denied();
        }
        $data['title'] = 'Student Search';
        $class = $this->class_model->get();
        $data['classlist'] = $class;
        $button = $this->input->post('search');
        $data['adm_auto_insert'] = $this->sch_setting_detail->adm_auto_insert;
        $data['sch_setting'] = $this->sch_setting_detail;
        $feeType_result = $this->studentfee_model->getFeeType();
        $data['feeTypeList'] = $feeType_result;
        if ($this->input->server('REQUEST_METHOD') == "GET") {
            $this->load->view('layout/header', $data);
            $this->load->view('studentfee/studentfeeAssign', $data);
            $this->load->view('layout/footer', $data);
        } else {
           $class       = $this->input->post('class_id');
            $fee_case = $this->input->post('fee_case');
//           $section     = $this->input->post('section_id');
            $data['fee_case'] = (!empty($fee_case))?$fee_case:1;
            $search = $this->input->post('search');
            $search_text = $this->input->post('search_text');
            if (isset($search)) {
                if ($search == 'search_filter') {
//                   $this->form_validation->set_rules('class_id', $this->lang->line('class'), 'trim|required|xss_clean');
                    $this->form_validation->set_rules('fee_case', 'Fee Case', 'trim|required|xss_clean');
                    if ($this->form_validation->run() == false) {

                    } else {
                        $resultlist = $this->student_model->searchByClassAndFeeCase($fee_case,'',$class,true);
                        $data['resultlist'] = $resultlist;
                    }
                } else if ($search == 'search_full') {
                    $resultlist = $this->student_model->searchFullText($search_text);
                    $data['resultlist'] = $resultlist;
                }
                $this->load->view('layout/header', $data);
                $this->load->view('studentfee/studentfeeAssign', $data);
                $this->load->view('layout/footer', $data);
            }
        }
    }
    function search_assigned_fee()
    {
        if (!$this->rbac->hasPrivilege('collect_fees', 'can_view')) {
            access_denied();
        }
        $data['title'] = 'Student Search';
        $class = $this->class_model->get();
        $data['classlist'] = $class;
        $button = $this->input->post('search');
        $data['adm_auto_insert'] = $this->sch_setting_detail->adm_auto_insert;
        $data['sch_setting'] = $this->sch_setting_detail;
        $feeType_result = $this->studentfee_model->getFeeType();
        $data['feeTypeList'] = $feeType_result;
        $std_results = $this->Student_model->getStudents();
//        $std_results = $this->Student_model->searchByClassSectionWithoutCurrent();
        $data['std_results'] = $std_results;
        $data['model_obj'] = $this->Shared_model;
        $data['month'] = '';
        if ($this->input->server('REQUEST_METHOD') == "GET") {
            $this->load->view('layout/header', $data);
            $this->load->view('studentfee/std_check_assignFee', $data);
            $this->load->view('layout/footer', $data);
        } else {
           $month       = $this->input->post('fee_month');
            $fee_case = $this->input->post('fee_case');
            $fee_year = $this->input->post('fee_year');
             $data['fee_case'] = $fee_case;
            $data['fee_year'] = $fee_year;
            $data['month'] = $month;
            $search = $this->input->post('search');
            $search_text = $this->input->post('search_text');

            if (isset($search)) {
                if ($search == 'search_filter') {
                     $this->form_validation->set_rules('fee_case', 'Fee Case', 'trim|required|xss_clean');
                     $this->form_validation->set_rules('fee_month', 'Fee Month', 'trim|required');
                     $this->form_validation->set_rules('fee_year', 'Fee Year', 'trim|required');
                    if ($this->form_validation->run() == false) {

                    } else {
//                        $resultlist = $this->student_model->searchByClassAndFeeCase($fee_case,'',$class);
//                        $data['resultlist'] = $resultlist;
                    }
                } else if ($search == 'search_full') {
                    $resultlist = $this->student_model->searchFullText($search_text);
                    $data['resultlist'] = $resultlist;
                }
                $this->load->view('layout/header', $data);
                $this->load->view('studentfee/std_check_assignFee', $data);
                $this->load->view('layout/footer', $data);
            }
        }
    }

    function assign_student_fee()
    {

//       $this->form_validation->set_rules('feeType', '...', 'callback_accept_feeType');
        if (empty($this->input->post('feeType'))) {
            $this->form_validation->set_rules('feeType', 'Fee Type', 'trim|required|xss_clean');

        }
        $this->form_validation->set_rules('month', 'Month', 'trim|required|xss_clean');
        $this->form_validation->set_rules('fee_year', 'Fee Year', 'trim|required|xss_clean');
        if ($this->form_validation->run() == false) {
            $data = array(
                'feeType' => form_error('feeType'),
                'month' => form_error('month'),
                'fee_year' => form_error('fee_year'),
                'issue_date' => form_error('issue_date'),
                'due_date' => form_error('due_date'),
                'stuck_off_date' => form_error('stuck_off_date'),
            );
            $array = array('status' => 'fail', 'error' => $data);
            echo json_encode($array);
        } else {
            $student_ids = $this->input->post('student_ids');
            $feeTypeIds = $this->input->post('feeType');
            $issue_date = $this->input->post('issue_date');
            $due_date = $this->input->post('due_date');
            $stuck_off_date = $this->input->post('stuck_off');
            $is_advanced = $this->input->post('is_advanced');
            $fine_wavier = $this->input->post('fine_wavier');
            $month = $this->input->post('month');
            $fee_case = $this->input->post('fee_case');
            $fee_year = $this->input->post('fee_year');

            $fees_discount = 0;
            $tuitionfeediscount = 0;
            $flag = false;
            $total_fee = 0;
            $tuitionFeeFlag = false;
            foreach ($feeTypeIds as $feeTypeId) {
                $feetypeDetail = $this->studentfee_model->getFeeType($feeTypeId);
//               $discountType=$this->input->post('dicsType'.$feeTypeId);
//               $discountRate=$this->input->post('discountRate'.$feeTypeId);
//               $balance=$this->input->post('balance'.$feeTypeId);
//               $discountDetailsArray[]=array(
//                   "fee_type"=>$feeTypeId,
//                   "discount_type"=>$discountType,
//                   "discount_rate"=>$discountRate,
//                   "balance"=>$balance,
//               );
//               $total_discount=$total_discount+$discountRate;
                if ($feetypeDetail['fee_type'] == "tuition") {
                    $tuitionFeeFlag = true;
                    if ($fee_case == 2) {
                        $currentfee = $feetypeDetail['amount'] * 2;
                    } else {
                        $currentfee = $feetypeDetail['amount'];
                    }

                } else {
                    $currentfee = $feetypeDetail['amount'];
                }
                $feeTypeInsertId[] = $feeTypeId;
                $total_fee = $total_fee + $currentfee;
            }
            $stdFeeTypeEncoded = json_encode($feeTypeInsertId);
            $stdIds=[];
//           $discountDetailsEncoded= json_encode($discountDetailsArray);
            foreach ($student_ids as $student_id) {
                $feeDetail = array();
                $arrears=0;
                unset($feeDetail);
                $stdExists = $this->Shared_model->selectDataWhereSingle("tbl_student_fee", array('std_id' => $student_id));
                $stdData = $this->Shared_model->selectDataWhereSingle("students", array('id' => $student_id));
                $total_fee = 0;
                $tuitionFee = 0;
                $arrearsinput = $this->input->post('arrears_'.$student_id);

                if($arrearsinput==null)
                {
                    $arrears=0;
                }else{
                    $arrears = $this->input->post('arrears_'.$student_id);
                }
                foreach ($feeTypeIds as $feeTypeId) {
                    $feetypeDetail = $this->studentfee_model->getFeeType($feeTypeId);
                    if ($feetypeDetail['fee_type'] == "tuition") {
                        if (empty($stdExists))
                        {
                            if ($fee_case == 2) {
                                $currentfee = $feetypeDetail['amount'] * 2;
                            } else {
                                $currentfee = $feetypeDetail['amount'];
                            }
                            $tuitionFee=$currentfee;

                        }else{
                            if ($fee_case == 2) {
                                $currentfee = $stdExists->std_tuition_fee * 2;
                            } else {
                                $currentfee = $stdExists->std_tuition_fee;
                            }

                        }

                    } else {
                        $currentfee = $feetypeDetail['amount'];
                    }
                    $total_fee = $total_fee + $currentfee;
                    $feeDetail[] = array(
                        'feeTypeID' => $feeTypeId,
                        'fee_amount' => $currentfee,
                    );
                }
//               $feeDetail=array_filter($feeDetail);
                $stdFeeTypeEncoded = json_encode($feeDetail);
                if (empty($stdExists)) {
                    $tbl_student_feeData = array(
                        'std_id' => $student_id,
                        'std_fee_case' => $fee_case,
                        'std_tuition_fee' => $tuitionFee,
                    );
                    $STDFeeID = $this->Shared_model->insert($tbl_student_feeData, "tbl_student_fee");
                } else {
                    $STDFeeID = $stdExists->std_fee_id;
                }
                $appliedDiscountArray=[];
                $discount_type=[];

                $feeData = array(
                    "std_fee_id" => $STDFeeID,
                    "fee_type" => $stdFeeTypeEncoded,
                    "total_amount" => $total_fee,
                    "issue_date" => $issue_date,
                    "due_date" => $due_date,
                    "stuck_off_date" => $stuck_off_date,
                    "discount" => $fees_discount,
                    "sibling_discount" => $tuitionfeediscount,
                    "total_discount" => $tuitionfeediscount + $fees_discount,
                    'applied_discounts'=>json_encode($appliedDiscountArray),
                    'discount_type'=>json_encode($discount_type),
                    "arrears" =>$arrears ,
                    "last_amount" => $total_fee+$arrears ,
                    "fee_status" => 0,
                    "fee_month" => $month,
                    "fee_year" => $fee_year,
                    "is_advanced" => $is_advanced,
                    "fine_wavier" => $fine_wavier,
                    "session_id" => $this->current_session,
                );
                $stdFeeArrears= $this->Shared_model->selectDataWhereSingle("tbl_student_fee", array('std_fee_id' =>$STDFeeID));
                $p_arrears=$stdFeeArrears->std_arrears;
                $total_arrears=$stdFeeArrears->std_total_arrears;
                if ($STDFeeID) {
                    $stdFeeDetailExsit = $this->Shared_model->selectDataWhereSingle("tbl_student_fee_detail", array('std_fee_id' =>$STDFeeID,'fee_month'=>$month,'fee_year'=>$fee_year));
                    if(!empty($stdFeeDetailExsit))
                    {
                        break;
                        $feeDepositDetails=$this->Shared_model->selectDataWhereSingle("tbl_student_fee_deposit",array('std_fee_detail_id'=>$stdFeeDetailExsit->fee_detail_id));
                        $feeInstallments=$this->Shared_model->selectDataWhereSingle("tbl_fee_installments",array('fee_detail_id'=>$stdFeeDetailExsit->fee_detail_id));


                        $newFeeTypeIds=[];
                        $new_feeDetail = array();
                        $newTotalfee=0;
                        if(empty($feeDepositDetails) && empty($feeInstallments))
                        {
                            $condition_break=false;
                            foreach ($feeTypeIds as $feeTypeId)if($condition_break) {
                                $feetypeDetail = $this->studentfee_model->getFeeType($feeTypeId);

                                $decodedFeeTypes=json_decode($stdFeeDetailExsit->fee_type,false);
                                foreach ($decodedFeeTypes as $decodedFeeType)
                                {

                                    if(!array_search($feeTypeId,(array) $decodedFeeType))
                                    {
//                                        $new_feeDetail = array();
                                        $newFeeTypeIds[]=$feeTypeId;
                                        if ($feetypeDetail['fee_type'] == "tuition") {
                                            if (empty($stdExists))
                                            {
                                                if ($fee_case == 2) {
                                                    $new_currentfee = $feetypeDetail['amount'] * 2;
                                                } else {
                                                    $new_currentfee = $feetypeDetail['amount'];
                                                }


                                            }else{
                                                if ($fee_case == 2) {
                                                    $new_currentfee = $stdExists->std_tuition_fee * 2;
                                                } else {
                                                    $new_currentfee = $stdExists->std_tuition_fee;
                                                }

                                            }

                                        } else {
                                            $new_currentfee = $feetypeDetail['amount'];
                                        }
                                        $newTotalfee = $newTotalfee + $new_currentfee;
                                        $new_feeDetail = array(
                                            'feeTypeID' => $feeTypeId,
                                            'fee_amount' => $new_currentfee,
                                        );
                                        $decodedFeeTypes[]=$new_feeDetail;

                                    }else{

                                    }

                                }

                            }
//                            die();
                                $arrears= $arrears+$p_arrears;
                            if($arrears<0)
                            {
                                $current_arrears=$arrears+$newTotalfee;
                                if($current_arrears>0)
                                {
                                    $lastAmount=abs($current_arrears);
                                    $current_arrears=0;
                                }else
                                {
                                    $feeData['fee_status']=1;
                                    $lastAmount=0;
                                }

                                $feeData['arrears']=$current_arrears;
                                $feeData['last_amount']=$lastAmount;
                                $this->Shared_model->updateData("tbl_student_fee",array('std_fee_id'=>$STDFeeID),array('std_arrears'=>$current_arrears,'std_total_arrears'=>$total_arrears+$arrears));

                            }
//                            $UpdatedFeeData1=[
//
//                            "fee_type" => json_encode($decodedFeeTypes),
//                                "total_amount" => $stdFeeDetailExsit->total_amount+$newTotalfee,
//                                "last_amount" => $stdFeeDetailExsit->last_amount+$newTotalfee ,
//                                "issue_date" => $issue_date,
//                                "due_date" => $due_date,
//                                "stuck_off_date" => $stuck_off_date,
//                                "discount" => $fees_discount,
//                                "sibling_discount" => $tuitionfeediscount,
//                                "total_discount" => $tuitionfeediscount + $fees_discount,
//                                'applied_discounts'=>json_encode($appliedDiscountArray),
//                                'discount_type'=>json_encode($discount_type),
//
//                            ];
//                            var_dump($UpdatedFeeData);
//                            die();
                            $this->Shared_model->updateData("tbl_student_fee_detail",array('fee_detail_id'=>$stdFeeDetailExsit->fee_detail_id),$feeData);
                            $array = array('status' => 'success', 'error' => '', 'message' => 'Fee Records Generated Successfully');

                        }
                        $feeDetailId=$stdFeeDetailExsit->fee_detail_id;

                    }
                    else{
                        $enteredArrears= $arrears;
                        if($p_arrears<0)
                            $arrears= $arrears+$p_arrears;
                        if($arrears!=0)
                        {
                            $description = "";
                            $payment_mode = "cash";
                            $amount_fine = 0;
                            $date = $issue_date;
                            $extra_amount = 0;
                            $staff_record = $this->staff_model->get($this->customlib->getStaffID());
                            $collected_by = " Collected By: " . $this->customlib->getAdminSessionUserName() . "(" . $staff_record['employee_id'] . ")";
                            $current_arrears=$arrears+$total_fee;
//                            check if arrears are in minus
                            if($current_arrears<=0)
                            {
//                               if arrears are in minus then mark the fee as paid and save the rest of arrears
                                $feeData['fee_status']=1;
                                 $feeData['last_amount']=$total_fee;
                                 $feeData['paid_amount']=$total_fee;
                                $feeDetailId = $this->Shared_model->insert($feeData, "tbl_student_fee_detail");

                                $feeDepositArray = array(
                                    'std_fee_detail_id' => $feeDetailId,
                                    'total_amount' => $total_fee,
                                    'paid_amount' => $total_fee,
                                    'remaining_amount' => 0,
                                    'fine' =>   $amount_fine,
                                    'mode' => $payment_mode,
                                    'description' => $description . $collected_by,
                                    'received_by' => $staff_record['id'],
                                    'date' => $date,
                                    'extra_amount' => $current_arrears,
                                     'session_id' => $this->current_session,
                                     'paid_by_arrears' => 1,

                                );
                                $this->Shared_model->insert($feeDepositArray, "tbl_student_fee_deposit");
                                $stdFeeDataArray = array(
                                    'std_arrears'=>$p_arrears+$current_arrears,
                                    'std_total_arrears'=>$total_arrears+$current_arrears
                                );
                                $this->Shared_model->updateData("tbl_student_fee",array('std_fee_id'=>$STDFeeID),$stdFeeDataArray);
                            }
                            else
                            {
                                if($p_arrears<0)
                                {

                                    $feeData['fee_status']=2;
                                    $paid_by_arrears = $p_arrears;
                                    $feeData['arrears']=0;
                                    $feeData['last_amount']=abs($total_fee);
                                    $feeData['pending_amount']=abs($p_arrears+$total_fee);
                                    $feeData['paid_amount']=abs($p_arrears);
                                    $stdFeeDataArray = array(
                                        'std_arrears'=>0
                                    );
                                    $this->Shared_model->updateData("tbl_student_fee",array('std_fee_id'=>$STDFeeID),$stdFeeDataArray);
                                    $feeDetailId = $this->Shared_model->insert($feeData, "tbl_student_fee_detail");
                                    $feeDepositArray = array(
                                        'std_fee_detail_id' => $feeDetailId,
                                        'total_amount' => $total_fee,
                                        'paid_amount' => abs($p_arrears),
                                        'remaining_amount' => abs($p_arrears+$total_fee),
                                        'fine' =>   $amount_fine,
                                        'mode' => $payment_mode,
                                        'description' => $description . $collected_by,
                                        'received_by' => $staff_record['id'],
                                        'date' => $date,
                                        'extra_amount' => $extra_amount,
                                        'session_id' => $this->current_session,
                                        'paid_by_arrears' => 1,

                                    );
                                $this->Shared_model->insert($feeDepositArray, "tbl_student_fee_deposit");
                                }else {
                                    $feeData['arrears'] = $enteredArrears;
                                    $feeData['last_amount'] = abs($current_arrears);
                                    $feeData['pending_amount'] = abs($current_arrears);
                                    $feeData['paid_amount'] = 0;
                                    $this->Shared_model->updateData("tbl_student_fee", array('std_fee_id' => $STDFeeID), array('std_arrears' => $arrears + $p_arrears, 'std_total_arrears' => $total_arrears + $arrears));
                                    $feeDetailId = $this->Shared_model->insert($feeData, "tbl_student_fee_detail");
                                }
                            }
                        }
                        else{
                            $feeDetailId = $this->Shared_model->insert($feeData, "tbl_student_fee_detail");
                        }
                        do {
                            $challanNumber = rand(0000, 9999);
                            $numlength = strlen((string)$challanNumber);
                            $challanNumberexsits = $this->Shared_model->selectDataWhereSingle("tbl_vouchers", array('challan_no' => $challanNumber));

                        } while (!empty($challanNumberexsits) || $numlength < 4);
                        $voucherDataArray = array(
                            'fee_detail_id' => $feeDetailId,
                            'challan_no' => $challanNumber,
                            'due_date' => $due_date,
                            'issue_date' => $issue_date,
                            "stuck_off_date" => $stuck_off_date,
                            'month' => $month,
                            'year' => date('Y'),
                            'expire' => 1, /* 0 For Yes/1 For No*/
                        );
                        if ($feeDetailId) {
                            $voucherID = $this->Shared_model->insert($voucherDataArray, "tbl_vouchers");
                            if ($voucherID) {
                                /*Success*/
                                $array = array('status' => 'success', 'error' => '', 'message' => 'Fee Records Generated Successfully');


                            } else {
                                /*Delete The Previous Data*/
                                $rollBack = $this->Shared_model->deleteData("tbl_student_fee_detail", array("fee_detail_id" => $feeDetailId));
                                $data = array(
                                    'Error' => 'Something Went Wrong.With Student Roll Number is "' . $stdData->roll_no . '"Please Try Again'
                                );
                                $array = array('status' => 'fail', 'error' => $data);

                                echo json_encode($array);
                                break;
                            }
                        }else{

                            $stdIds[]=$student_id;
                        }
                    }

                }
            }
            $array['no_assigned_to']=$stdIds;
            echo json_encode($array);

        }

    }

    function accept_feeType()
    {
        if (isset($_POST['feeType'])) return true;
        $this->form_validation->set_message('accept_feeType', 'Please Select The Fee Type.');
        return false;
    }

    private function getFeeMonth($month)
    {
        $month = ltrim($month, '0');
        if ($month == 8 || $month == 9) {
            $returnMonth = '8-9';

        } elseif ($month == 10 || $month == 11) {
            $returnMonth = '10-11';
        } elseif ($month == 12 || $month == 1) {
            $returnMonth = '12-1';
        } elseif ($month == 2 || $month == 3) {
            $returnMonth = '2-3';
        } elseif ($month == 4 || $month == 5) {
            $returnMonth = '4-5';
        } elseif ($month == 6 || $month == 7) {
            $returnMonth = '6-7';
        }
        return $returnMonth;
    }

    function feeCollectionSearch()
    {
        if (!$this->rbac->hasPrivilege('collect_fees', 'can_view')) {
            access_denied();
        }
        $this->session->set_userdata('sub_menu', 'studentfee/feeCollectionSearch');
        $data['title'] = 'Student Search';
        $class = $this->class_model->get();
        $data['classlist'] = $class;
        $button = $this->input->post('search');
        $data['adm_auto_insert'] = $this->sch_setting_detail->adm_auto_insert;
        $data['sch_setting'] = $this->sch_setting_detail;
        if ($this->input->server('REQUEST_METHOD') == "GET") {
            $this->load->view('layout/header', $data);
            $this->load->view('studentfee/collectfeeSearch', $data);
            $this->load->view('layout/footer', $data);
        } else {
            $class = $this->input->post('class_id');
            $section = $this->input->post('section_id');
            $search = $this->input->post('search');
            $search_text = $this->input->post('search_text');
            if (isset($search)) {
                if ($search == 'search_filter') {
                    $this->form_validation->set_rules('class_id', $this->lang->line('class'), 'trim|required|xss_clean');
                    if ($this->form_validation->run() == false) {

                    } else {
                        $resultlist = $this->student_model->searchByClassSection($class, $section);
                        $data['resultlist'] = $resultlist;
                    }
                } else if ($search == 'search_full') {
                    $resultlist = $this->student_model->searchFullText($search_text);
                    $data['resultlist'] = $resultlist;
                }
                $this->load->view('layout/header', $data);
                $this->load->view('studentfee/collectfeeSearch', $data);
                $this->load->view('layout/footer', $data);
            }
        }

    }

    function CollectFee($id)
    {
        if (!$this->rbac->hasPrivilege('collect_fees', 'can_add')) {
            access_denied();
        }
        $data['title'] = 'Student Detail';

        $studentId = $this->student_model->get($id);
        $student = $this->student_model->getByStudentSession($studentId['student_session_id']);
        $data['student'] = $student;

        $student_due_fee = $this->studentfeemaster_model->getStudentFees($id);
        $student_fee = $this->student_model->getStudentFee($id);

        $student_discount_fee = $this->feediscount_model->getStudentFeesDiscount($id);

        $data['student_discount_fee'] = $student_discount_fee;
        $data['student_due_fee'] = $student_due_fee;
        $data['student_fee'] = $student_fee;
        $category = $this->category_model->get();
        $data['categorylist'] = $category;
        $class_section = $this->student_model->getClassSection($student["class_id"]);
        $data["class_section"] = $class_section;
        $session = $this->setting_model->getCurrentSession();
        $studentlistbysection = $this->student_model->getStudentClassSection($student["class_id"], $session);
        $data["studentlistbysection"] = $studentlistbysection;

        $this->load->view('layout/header', $data);
        $this->load->view('studentfee/studentCollectFee', $data);
        $this->load->view('layout/footer', $data);
    }

    function getFeeDetails($para1 = null)
    {
        $fee_detail_id = $this->input->post('fee_detail_id');
        $fine=0;
        $rem_balance = 0;
        $paid_balance = 0;
        $payable_balance = 0;
        $fee_fine         = $this->Shared_model->selectDataWhereSingle("tbl_finetype",array('finetype_id'=>1));

        $feeDepositDetails = $this->Shared_model->selectDataWhereMultiple("tbl_student_fee_deposit", array('std_fee_detail_id' => $fee_detail_id));
        $feeDetails = $this->Shared_model->selectDataWhereSingle("tbl_student_fee_detail", array('fee_detail_id' => $fee_detail_id));
        if (!empty($feeDepositDetails)) {
            foreach ($feeDepositDetails as $depositDetail) {
                $rem_balance = $rem_balance + $depositDetail->remaining_amount;
                $paid_balance = $paid_balance + $depositDetail->paid_amount;
            }
            $payable_balance = $feeDetails->last_amount - $paid_balance;
        } else {
            $payable_balance = $feeDetails->last_amount;
        }

        $dueDate=strtotime($feeDetails->due_date);
        $currentDate=strtotime(date('m/d/Y'));
        if($currentDate>$dueDate)
        {
            $fine=$fee_fine->fine_amount;
        }

        $html='';

        $decodedFeeTypes=json_decode($feeDetails->fee_type);
        foreach ($decodedFeeTypes as $decodedFeeType)
        {
           $feeTypeDetails= $this->Shared_model->selectDataWhereSingle("tbl_feetype",array('id'=>$decodedFeeType->feeTypeID));
           $html.='<div class="form-group">
                            <label for="inputPassword3" class="col-sm-3 control-label">'.$feeTypeDetails->type.'<small class="req"> *</small></label>
                            <div class="col-sm-9">

                                <input type="text" autofocus="" class="form-control modal_amount collect_fee_modal_amount" name="entered_amount_'.$decodedFeeType->feeTypeID.'" id="entered_amount_'.$decodedFeeType->feeTypeID.'" feeTypeId="'.$decodedFeeType->feeTypeID.'" value="'.$decodedFeeType->fee_amount.'">

                                 
                            </div>
                        </div>';
        }
        if($feeDetails->arrears>0)
        {
            $html.='<div class="form-group">
                            <label for="inputPassword3" class="col-sm-3 control-label">P.Arrears<small class="req"> *</small></label>
                            <div class="col-sm-9">

                                <input type="text" autofocus="" class="form-control modal_amount" name="p_arrears" id="entered_amount_p_arrears" value="'.$feeDetails->arrears.'">

                                 
                            </div>
                        </div>';

        }


        $outputData = array(
            'status' => "success",
            'balance' => $payable_balance,
            'fine' => $fine,
            'html' => $html,

        );
        if (!empty($para1)) {
            return $payable_balance;
        } else {
            echo json_encode($outputData);
        }

    }

    function addstudentdepositfee()
    {

        $this->form_validation->set_rules('fee_detail_id', $this->lang->line('student'), 'required|trim|xss_clean');
        $this->form_validation->set_rules('amount', $this->lang->line('amount'), 'required|trim|xss_clean|callback_check_deposit_amount');
        $this->form_validation->set_rules('amount_fine', $this->lang->line('fine'), 'required|trim|xss_clean');
        $this->form_validation->set_rules('extra_amount', 'Extra Amount', 'required|trim|xss_clean');
        $this->form_validation->set_rules('payment_mode', $this->lang->line('payment_mode'), 'required|trim|xss_clean');
        if ($this->form_validation->run() == false) {
            $data = array(
                'amount' => form_error('amount'),
                'fee_detail_id' => form_error('fee_detail_id'),
//               'fee_groups_feetype_id'  => form_error('fee_groups_feetype_id'),
//               'amount_discount'        => form_error('amount_discount'),
                'extra_amount'        => form_error('extra_amount'),
                'amount_fine'            => form_error('amount_fine'),
                'payment_mode' => form_error('payment_mode'),
            );
            $array = array('status' => 'fail', 'error' => $data);
            echo json_encode($array);
        } else {
            $rem_balance = 0;
            $paid_balance = 0;
            $payable_balance = 0;
            $amount = 0;

//          $amount = $this->input->post('amount');
            $depositFeeTypeArray[]='';
            $enteredFeeAmountObj = $this->input->post('enteredFeeAmountObj');
            foreach ($enteredFeeAmountObj as $fee_id=>$amount_typed)
            {
                $amount+=$amount_typed;
             }
            $p_arrears = 0;
            if(!empty($_POST['p_arrears'])){
                $p_arrears = $this->input->post('p_arrears');
            }
            $amount+=$p_arrears;
            $description = $this->input->post('description');
            $payment_mode = $this->input->post('payment_mode');
            $fee_detail_id = $this->input->post('fee_detail_id');
            $amount_fine = $this->input->post('amount_fine');
            $date = $this->input->post('date');
            $extra_amount = $this->input->post('extra_amount');
            $feeDetails = $this->Shared_model->selectDataWhereSingle("tbl_student_fee_detail", array('fee_detail_id' => $fee_detail_id));
            $feeDepositDetails = $this->Shared_model->selectDataWhereMultiple("tbl_student_fee_deposit", array('std_fee_detail_id' => $fee_detail_id));
            if (!empty($feeDepositDetails)) {
                foreach ($feeDepositDetails as $depositDetail) {
                    $rem_balance = $rem_balance + $depositDetail->remaining_amount;
                    $paid_balance = $paid_balance + $depositDetail->paid_amount;
                }
                $payable_balance = ($feeDetails->last_amount+$amount_fine) - ($paid_balance + $amount+$amount_fine);
            } else {
                $payable_balance = ($feeDetails->last_amount+$amount_fine) - ($amount+$amount_fine);
            }
            $staff_record = $this->staff_model->get($this->customlib->getStaffID());
            $collected_by = " Collected By: " . $this->customlib->getAdminSessionUserName() . "(" . $staff_record['employee_id'] . ")";

            $dateArray = array(
                'std_fee_detail_id' => $fee_detail_id,
                'total_amount' => $feeDetails->last_amount+$amount_fine,
                'paid_amount' => $amount+$amount_fine,
                'remaining_amount' => $payable_balance,
                'fine' =>   $amount_fine,
                'mode' => $payment_mode,
                'description' => $description . $collected_by,
                'received_by' => $staff_record['id'],
                'date' => $date,
                'extra_amount' => $extra_amount,
                'p_arrears' => $p_arrears,
                'fee_type_deposite' => json_encode($enteredFeeAmountObj),
                'session_id' => $this->current_session,

            );
            if ($payable_balance == 0) {
                $status = 1;
            } else {
                $status = 2;
            }

            $feeDetailsData = array(
                'fee_status' => $status,
                'paid_amount' => $feeDetails->paid_amount + $amount,
                'pending_amount' => $feeDetails->pending_amount - $amount,
                 'fine' => $feeDetails->fine+$amount_fine,
            );

            $dataSaved = $this->Shared_model->insert($dateArray, "tbl_student_fee_deposit");

            if ($dataSaved) {
                $stdFeeArrears= $this->Shared_model->selectDataWhereSingle("tbl_student_fee", array('std_fee_id' =>$feeDetails->std_fee_id));
                $total_arrears=$stdFeeArrears->std_total_arrears;
                $p_arrears=$stdFeeArrears->std_arrears;

                $this->Shared_model->updateData("tbl_student_fee", array('std_fee_id' => $feeDetails->std_fee_id), array('std_arrears'=>$p_arrears+(-$extra_amount),'std_total_arrears'=>$total_arrears+$extra_amount));
                $this->Shared_model->updateData("tbl_student_fee_detail", array('fee_detail_id' => $fee_detail_id), $feeDetailsData);
                $stdFees = $this->Shared_model->selectDataWhereSingle("tbl_student_fee", array('std_fee_id' => $feeDetails->std_fee_id));
                $studentId = $this->student_model->get($stdFees->std_id);
                $student = $this->student_model->getByStudentSession($studentId['student_session_id']);

                $send_to = $student['guardian_phone'];
                $email = $student['guardian_email'];
                $parent_app_key = $student['parent_app_key'];

                $mailsms_array['firstname'] = $student['firstname'];
                $mailsms_array['lastname'] = $student['lastname'];
                $mailsms_array['class'] = $student['class'];
                $mailsms_array['invoice'] = $dataSaved;
                $mailsms_array['fee_amount'] = $amount+$amount_fine;
                $mailsms_array['contact_no'] = $send_to;
                $mailsms_array['email'] = $email;
                $mailsms_array['parent_app_key'] = $parent_app_key;
//                $this->mailsmsconf->mailsms('fee_submission', $mailsms_array);
                $array = array('status' => 'success', 'error' => '');
                echo json_encode($array);
            } else {


                $data = array(
                    'error' => "Something Went wrong Please Try Again!!",
                );
                $array = array('status' => 'fail', 'error' => $data);
                echo json_encode($array);
            }

        }

    }

    function installmentDeposit()
    {
        $this->form_validation->set_rules('date', $this->lang->line('date'), 'required|trim|xss_clean');
        $this->form_validation->set_rules('installment_detail_id', $this->lang->line('student'), 'required|trim|xss_clean');
        $this->form_validation->set_rules('amount', $this->lang->line('amount'), 'required|trim|xss_clean|callback_check_installment_deposit_amount');
        $this->form_validation->set_rules('payment_mode', $this->lang->line('payment_mode'), 'required|trim|xss_clean');
        if ($this->form_validation->run() == false) {
            $data = array(
                'installment_amount' => form_error('amount'),
                'fee_detail_id' => form_error('fee_detail_id'),
                'insatllment_payment_mode' => form_error('payment_mode'),
                'date' => form_error('date'),
            );
            $array = array('status' => 'fail', 'error' => $data);
            echo json_encode($array);
        } else {
            $staff_record = $this->staff_model->get($this->customlib->getStaffID());

            $collected_by = " Collected By: " . $this->customlib->getAdminSessionUserName() . "(" . $staff_record['employee_id'] . ")";

            $rem_balance = 0;
            $paid_balance = 0;
            $payable_balance = 0;
            $date = $this->input->post('date');
            $amount = $this->input->post('amount');
            $description = $this->input->post('description');
            $payment_mode = $this->input->post('payment_mode');
            $installment_detail_id = $this->input->post('installment_detail_id');
            $fee_detail_id = $this->input->post('fee_detail_id');
            $InstallmentfeeDetails = $this->Shared_model->selectDataWhereSingle("tbl_installment_details", array('installment_detail_id' => $installment_detail_id));
            $feeDetails = $this->Shared_model->selectDataWhereSingle("tbl_student_fee_detail", array('fee_detail_id' => $fee_detail_id));
            $feeDepositDetails = $this->Shared_model->selectDataWhereMultiple("tbl_student_fee_deposit", array('std_fee_detail_id' => $fee_detail_id));
//           $feeDepositDetails=$this->Shared_model->selectDataWhereMultiple("tbl_student_fee_deposit",array('installment_detail_id'=>$installment_detail_id,'is_installment'=>0));
            if (!empty($feeDepositDetails)) {
                foreach ($feeDepositDetails as $depositDetail) {
                    $rem_balance = $rem_balance + $depositDetail->remaining_amount;
                    $paid_balance = $paid_balance + $depositDetail->paid_amount;
                }
                $payable_balance = $feeDetails->last_amount - ($paid_balance + $amount);
            } else {
                $payable_balance = $feeDetails->last_amount - $amount;
            }
            $dateArray = array(
                'std_fee_detail_id' => $fee_detail_id,
                'total_amount' => $InstallmentfeeDetails->amount,
                'paid_amount' => $amount,
                'remaining_amount' => $InstallmentfeeDetails->amount - $amount,
                'mode' => $payment_mode,
                'description' => $description . $collected_by,
                'received_by' => $staff_record['id'],
                'date' => $date,
                'is_installment' => 1,
                'installment_detail_id' => $installment_detail_id,
            );
            if ($InstallmentfeeDetails->amount - $amount == 0) {
                $intallmentstatus = 1;
            } else {
                $intallmentstatus = 2;
            }
            if ($payable_balance == 0) {
                $status = 1;
            } else {
                $status = 2;
            }

            $feeDetailsData = array(
                'fee_status' => $status
            );

            $IntallmentData = array(
                'status' => $intallmentstatus
            );

            $dataSaved = $this->Shared_model->insert($dateArray, "tbl_student_fee_deposit");
            if ($dataSaved) {
                $this->Shared_model->updateData("tbl_installment_details", array('installment_detail_id' => $installment_detail_id), $IntallmentData);
                $this->Shared_model->updateData("tbl_student_fee_detail", array('fee_detail_id' => $fee_detail_id), $feeDetailsData);
                $array = array('status' => 'success', 'error' => '');
                echo json_encode($array);
            } else {
                $data = array(
                    'error' => "Something Went wrong Please Try Again!!",
                );
                $array = array('status' => 'fail', 'error' => $data);
                echo json_encode($array);
            }
        }
    }

    function revertDepositFee()
    {
        if (!$this->rbac->hasPrivilege('collect_fees', 'can_delete')) {
            access_denied();
        }
        $rem_balance = 0;
        $paid_balance = 0;
        $payable_balance = 0;
        $amount = 0;
        $std_deposit_id = $this->input->post('std_deposit_id');
        if (!empty($std_deposit_id)) {
            $feeDepositDetail = $this->Shared_model->selectDataWhereSingle("tbl_student_fee_deposit", array('std_deposit_id' => $std_deposit_id));
            $revertDone = $this->Shared_model->deleteData("tbl_student_fee_deposit", array('std_deposit_id' => $std_deposit_id));
            $revertDone = true;
            if ($revertDone) {
                $feeDetails=$this->Shared_model->selectDataWhereSingle("tbl_student_fee_detail",array('fee_detail_id'=>$feeDepositDetail->std_fee_detail_id));
                $feeDepositDetails = $this->Shared_model->selectDataWhereMultiple("tbl_student_fee_deposit", array('std_fee_detail_id' => $feeDepositDetail->std_fee_detail_id));
                if (!empty($feeDepositDetails)) {
                    $status = 2;
                } else {
                    $status = 0;
                }
                $feeDetailsData = array(
                    'fee_status' => $status,
                    'fine' =>$feeDetails->fine-$feeDepositDetail->fine
                );
                $stdArrearsDetails=$this->Shared_model->selectDataWhereSingle("tbl_student_fee",array('std_fee_id'=>$feeDetails->std_fee_id));

                $stdAreares=[
                    'std_arrears'=>$stdArrearsDetails->std_arrears-($feeDepositDetail->extra_amount+$feeDepositDetail->p_arrears),
                    'std_total_arrears'=>$stdArrearsDetails->std_total_arrears-($feeDepositDetail->extra_amount+$feeDepositDetail->p_arrears),
                ];

                $result = $this->Shared_model->updateData("tbl_student_fee", array('std_fee_id' => $feeDetails->std_fee_id), $stdAreares);
                $result = $this->Shared_model->updateData("tbl_student_fee_detail", array('fee_detail_id' => $feeDepositDetail->std_fee_detail_id), $feeDetailsData);

            }
        }
        $array = array('status' => 'success', 'result' => 'success');
        echo json_encode($array);
    }

    function revertInstallmentDepositFee()
    {
        if (!$this->rbac->hasPrivilege('collect_fees', 'can_delete')) {
            access_denied();
        }
        $rem_balance = 0;
        $paid_balance = 0;
        $payable_balance = 0;
        $amount = 0;
        $std_deposit_id = $this->input->post('std_deposit_id');
        if (!empty($std_deposit_id)) {
            $feeDepositDetail = $this->Shared_model->selectDataWhereSingle("tbl_student_fee_deposit", array('std_deposit_id' => $std_deposit_id));
            $revertDone = $this->Shared_model->deleteData("tbl_student_fee_deposit", array('std_deposit_id' => $std_deposit_id));
//           $revertDone=true;
            if ($revertDone) {
//                $feeDetails=$this->Shared_model->selectDataWhereSingle("tbl_student_fee_detail",array('fee_detail_id'=>$feeDepositDetail->std_fee_detail_id));
                $feeDepositDetails = $this->Shared_model->selectDataWhereMultiple("tbl_student_fee_deposit", array('std_fee_detail_id' => $feeDepositDetail->std_fee_detail_id));
                $feeInstallmentDepositDetails = $this->Shared_model->selectDataWhereMultiple("tbl_student_fee_deposit", array('std_fee_detail_id' => $feeDepositDetail->installment_detail_id));
                if (!empty($feeDepositDetails)) {
                    $status = 2;
                } else {
                    $status = 0;
                }
                if (!empty($feeInstallmentDepositDetails)) {
                    $intallmentstatus = 2;
                } else {
                    $intallmentstatus = 0;
                }
                $feeDetailsData = array(
                    'fee_status' => $status
                );
                $IntallmentData = array(
                    'status' => $intallmentstatus
                );

                $result = $this->Shared_model->updateData("tbl_student_fee_detail", array('fee_detail_id' => $feeDepositDetail->std_fee_detail_id), $feeDetailsData);
                $this->Shared_model->updateData("tbl_installment_details", array('installment_detail_id' => $feeDepositDetail->installment_detail_id), $IntallmentData);

            }
        }

        $array = array('status' => 'success', 'result' => 'success');
        echo json_encode($array);
    }

    function check_deposit_amount($amount)
    {
        $deposit_amount = $this->input->post('amount');
        if ($this->input->post('amount') != "") {
            if ($this->input->post('amount') < 0) {
                $this->form_validation->set_message('check_deposit_amount', $this->lang->line('deposit_amount_can_not_be_less_than_zero'));
                return false;
            } else {
                $remain_amount = $this->getFeeDetails('para1');
                if ($deposit_amount > $remain_amount) {
                    $this->form_validation->set_message('check_deposit_amount', $this->lang->line('deposit_amount_can_not_be_greater_than_remaining'));
                    return false;
                } else {
                    return true;
                }
            }
            return true;
        }
        $this->form_validation->set_message('check_deposit_amount', $this->lang->line('deposit_amount_can_not_be_less_than_zero'));
        return false;
    }

    function check_installment_deposit_amount()
    {
        $deposit_amount = $this->input->post('amount');
        $installment_detail_id = $this->input->post('installment_detail_id');
        if ($this->input->post('amount') != "") {
            if ($this->input->post('amount') < 0) {
                $this->form_validation->set_message('check_installment_deposit_amount', $this->lang->line('deposit_amount_can_not_be_less_than_zero'));
                return false;
            } else {
                $feeDepositDetails = $this->Shared_model->selectDataWhereMultiple("tbl_student_fee_deposit", array('installment_detail_id' => $installment_detail_id, 'is_installment' => 0));
                $tbl_installment_details = $this->Shared_model->selectDataWhereSingle("tbl_installment_details", array('installment_detail_id' => $installment_detail_id));
                $totalPaid = 0;
                foreach ($feeDepositDetails as $detail) {
                    $totalPaid = $totalPaid + $detail->paid_amount;
                }
                $remain_amount = $tbl_installment_details->amount - $totalPaid;
                if ($deposit_amount > $remain_amount) {
                    $this->form_validation->set_message('check_installment_deposit_amount', $this->lang->line('deposit_amount_can_not_be_greater_than_remaining'));
                    return false;
                } else {
                    return true;
                }
            }
            return true;
        }
        $this->form_validation->set_message('check_installment_deposit_amount', $this->lang->line('deposit_amount_can_not_be_less_than_zero'));
        return false;
    }

    function IndividualaddInstallments()
    {

        $num_installments = $this->input->post('num_installments');
        $feeDetailIds = $this->input->post('feeDetailIds');
        $stdId = $this->input->post('stdId');
        $fee_installments_select = $this->input->post('fee_installments_select');
        $formData = $this->input->post('formData');


        foreach ($feeDetailIds as $feeDetailId) {
            $feeDetail = $this->Shared_model->selectDataWhereSingle("tbl_student_fee_detail", array('fee_detail_id' => $feeDetailId));
            $installmentDataArray = array(
                'std_id' => $stdId,
                'fee_detail_id' => $feeDetailId,
                'number' => $num_installments,
                'fee_type_id' => $fee_installments_select,
            );

            $decodeFeeTypes=json_decode($feeDetail->fee_type);

            $feeAmount=0;
            foreach ($decodeFeeTypes as $decodeFeeType)
            {

                if($decodeFeeType->feeTypeID==$fee_installments_select)
                {
                    $feeAmount= $decodeFeeType->fee_amount;
                }
            }


            $InstallmentAmount = $feeAmount / $num_installments;
            $dataSaved = $this->Shared_model->insert($installmentDataArray, "tbl_fee_installments");
            for ($i = 1; $i <= $num_installments; $i++) {
                $installmentDetailsArray = array(
                    'installment_id' => $dataSaved,
                    'due_date' => $formData['due_date' . $i],
                    'stuckoff_date' => $formData['stuckoff_date_' . $i],
                    'issue_date' => date('m/d/Y'),
                    'amount' => $InstallmentAmount,
                    'status' => 0,
                );
                $result = $this->Shared_model->insert($installmentDetailsArray, "tbl_installment_details");
            }
            if ($result) {
                $feeDetailsData = array(
                    'is_installment' => 1,
                    'is_individual_installment' => 1
                );
                $this->Shared_model->updateData("tbl_student_fee_detail", array('fee_detail_id' => $feeDetailId), $feeDetailsData);

                $data = array(
                    'status' => 'success'
                );
                echo json_encode($data);
            }


        }


    }
    function addInstallments()
    {

        $num_installments = $this->input->post('num_installments');
        $feeDetailIds = $this->input->post('feeDetailIds');
        $stdId = $this->input->post('stdId');
        $formData = $this->input->post('formData');

        foreach ($feeDetailIds as $feeDetailId) {
            $feeDetail = $this->Shared_model->selectDataWhereSingle("tbl_student_fee_detail", array('fee_detail_id' => $feeDetailId));
            $installmentDataArray = array(
                'std_id' => $stdId,
                'fee_detail_id' => $feeDetailId,
                'number' => $num_installments,
            );
            $InstallmentAmount = $feeDetail->last_amount / $num_installments;
            $dataSaved = $this->Shared_model->insert($installmentDataArray, "tbl_fee_installments");
            for ($i = 1; $i <= $num_installments; $i++) {
                $installmentDetailsArray = array(
                    'installment_id' => $dataSaved,
                    'due_date' => $formData['due_date' . $i],
                    'stuckoff_date' => $formData['stuckoff_date_' . $i],
                    'issue_date' => date('m/d/Y'),
                    'amount' => $InstallmentAmount,
                    'status' => 0,
                );
                $result = $this->Shared_model->insert($installmentDetailsArray, "tbl_installment_details");
            }
            if ($result) {
                $feeDetailsData = array(
                    'is_installment' => 1
                );
                $this->Shared_model->updateData("tbl_student_fee_detail", array('fee_detail_id' => $feeDetailId), $feeDetailsData);

                $data = array(
                    'status' => 'success'
                );
                echo json_encode($data);
            }


        }


    }

    function FeeVouchers()
    {
        if (!$this->rbac->hasPrivilege('collect_fees', 'can_view')) {
            access_denied();
        }

        $this->session->set_userdata('top_menu', $this->lang->line('fees_collection'));
        $this->session->set_userdata('sub_menu', 'studentfee/FeeVouchers');

        $data['title'] = 'student fees Vouchers';
        $class = $this->class_model->get();
        $data['classlist'] = $class;
        $data['fee_case'] = '';
        $this->load->view('layout/header', $data);
        $this->load->view('studentfee/Search-Fee-Vouchers', $data);
        $this->load->view('layout/footer', $data);
    }

    function searchFeeVouchers()
    {
        if (!$this->rbac->hasPrivilege('collect_fees', 'can_view')) {
            access_denied();
        }
        $data['title'] = 'Student Search';
        $class = $this->class_model->get();
        $data['classlist'] = $class;
        $button = $this->input->post('search');
        $data['adm_auto_insert'] = $this->sch_setting_detail->adm_auto_insert;
        $data['sch_setting'] = $this->sch_setting_detail;
        $feeType_result = $this->studentfee_model->getFeeType();
        $data['feeTypeList'] = $feeType_result;
        if ($this->input->server('REQUEST_METHOD') == "GET") {
            $this->load->view('layout/header', $data);
            $this->load->view('studentfee/Search-Fee-Vouchers', $data);
            $this->load->view('layout/footer', $data);
        } else {

            $fee_case = $this->input->post('fee_case');
            if ($fee_case == 1) {
                $month = $this->input->post('month1');
            } elseif ($fee_case == 2) {
                $month = $this->input->post('month2');
            } else {
                $month = $this->input->post('month13');
            }

//           $section     = $this->input->post('section_id');
            $data['fee_case'] = $fee_case;
            $data['month'] = $month;
            $search = $this->input->post('search');
            $fee_year = $this->input->post('fee_year');
            $search_text = $this->input->post('search_text');
            if (isset($search)) {
                if ($search == 'search_filter') {
                    $this->form_validation->set_rules('fee_case', 'Fee Case', 'trim|required|xss_clean');
//                   $this->form_validation->set_rules('month', 'Month', 'trim|required|xss_clean');
                    if ($this->form_validation->run() == false) {

                    } else {
                        $resultlist = $this->student_model->searchByMonthAndFeeCase($month, $fee_year,$fee_case);
                        $resultlist = $this->removeDuplicatesFee($resultlist);
                        $data['resultlist'] = $resultlist;
                    }
                } else if ($search == 'search_full') {
                    $resultlist = $this->student_model->searchFullText($search_text);
                    $data['resultlist'] = $resultlist;
                }
                 $data['withAdmission'] = "yes"; /*If with out admission*/

                $this->load->view('layout/header', $data);
                $this->load->view('studentfee/Search-Fee-Vouchers', $data);
                $this->load->view('layout/footer', $data);
            }
        }

    }

    function removeDuplicatesFee($array)
    {
        $arr = array();
        foreach ($array as $obj) {
            $arr[$obj['std_id']] = $obj;
        }
        return $arr;
    }

    function generateFeeVoucher($para1 = null)
    {

        if (isset($_POST['btn_save'])) {


            $feeTypeIds = $this->input->post('feeType');
            $enquiryID = $this->input->post('enquiryID');
            $due_date = $this->input->post('due_date');
            $issue_date = $this->input->post('issue_date');
            $last_total_fee = $this->input->post('total_fee');
            $total_discount = 0;
            $total_fee = 0;
            if (isset($feeTypeIds)) {
                foreach ($feeTypeIds as $feeTypeId) {

                    $feetypeDetail = $this->studentfee_model->getFeeType($feeTypeId);
                    $discountType = $this->input->post('dicsType' . $feeTypeId);
                    $discountRate = $this->input->post('discountRate' . $feeTypeId);
                    $balance = $this->input->post('balance' . $feeTypeId);
                    $discountDetailsArray[] = array(
                        "fee_type" => $feeTypeId,
                        "discount_type" => $discountType,
                        "discount_rate" => $discountRate,
                        "balance" => $balance,
                    );
                    $total_discount = $total_discount + $discountRate;
                    $feeTypeInsertId[] = $feeTypeId;
                    $total_fee = $total_fee + $feetypeDetail['amount'];
                }
                $stdFees = json_encode($feeTypeInsertId);
                $discountDetailsEncoded = json_encode($discountDetailsArray);
            }
            $feeDetailArray = array(
                'enquiry_id' => $enquiryID,
                'fee_details' => $discountDetailsEncoded,
                'total_fee' => $last_total_fee,
            );
            $feeDetailId = $this->Shared_model->insert($feeDetailArray, "tbl_temparory_fee_details");
//            $challanNumber=rand(000,999);
//            $challanNumber=$this->genrateChallanNumber();
//            $challanNumberexsits=$this->Shared_model->selectDataWhereSingle("tbl_vouchers",array('challan_no'=>$challanNumber));
//            if(!empty($challanNumberexsits))
//            {
//                $challanNumber=rand(000,999);
//            }
            do {
                $challanNumber = rand(000, 999);
                $challanNumberexsits = $this->Shared_model->selectDataWhereSingle("tbl_vouchers", array('challan_no' => $challanNumber));

            } while (!empty($challanNumberexsits));

            $voucherDataArray = array(
                'temp_fee_detail_id' => $feeDetailId,
                'challan_no' => $challanNumber,
                'due_date' => $due_date,
                'issue_date' => $issue_date,
                'month' => date('m'),
                'year' => date('Y'),
                'expire' => 1, /* 0 For Yes/1 For No*/
            );
            $voucherID = $this->Shared_model->insert($voucherDataArray, "tbl_vouchers");
            if ($voucherID && $feeDetailId) {
                redirect('Studentfee/generateFeeVoucher/' . $feeDetailId);
            }
        } elseif ($para1 != null) {
            $feeDetails = $this->Shared_model->selectDataWhereSingle("tbl_temparory_fee_details", array('fee_detail_id' => $para1));
            $voucherDetail = $this->Shared_model->selectDataWhereSingle("tbl_vouchers", array('temp_fee_detail_id' => $para1));
//            if($para2!=null)
//            {
//                $stdFeeDetails=$this->Shared_model->selectDataWhereSingle("tbl_student_fee",array('std_fee_id'=>$feeDetails->std_fee_id));
//                $enquiryDetail= $this->student_model->get($stdFeeDetails->std_id);
//
//            }else{
            $enquiryDetail = $this->Shared_model->selectDataWhereSingle("enquiry", array('id' => $feeDetails->enquiry_id));

//            }

            $ClassDetail = $this->Shared_model->selectDataWhereSingle("classes", array('id' => $enquiryDetail->class));
            $data['feeDetail'] = $feeDetails;
            $data['voucherDetails'] = $voucherDetail;
            $data['enquireyDetail'] = $enquiryDetail;
            $data['ClassDetail'] = $ClassDetail;
            $data['withAdmission'] = "no"; /*If with out admission*/
            $this->load->view('studentfee/genrateSingleVoucher', $data);


        }
    }

    function getFeeVoucher($para1 = null)
    {
        if ($para1 != null) {
            if ($para1 == "multi") {
                $data['feeDetailIDs'] = $this->input->post('feeDetailArray');
                $data['withAdmission'] = "yes"; /*If with out admission*/
                $this->load->view('studentfee/stdMultiFeeVoucher', $data);
            } else {
                $feeDetails = $this->Shared_model->selectDataWhereSingle("tbl_student_fee_detail", array('fee_detail_id' => $para1));
                $stdFeeDetails = $this->Shared_model->selectDataWhereSingle("tbl_student_fee", array('std_fee_id' => $feeDetails->std_fee_id));
                $voucherDetail = $this->Shared_model->selectDataWhereSingle("tbl_vouchers", array('fee_detail_id' => $para1));
                $stdDetail = $this->student_model->get($stdFeeDetails->std_id);
                $data['feeDetail'] = $feeDetails;
                $data['feeDetailID'] = $para1;
                $data['voucherDetails'] = $voucherDetail;
                $data['stdDetail'] = $stdDetail;
                $data['feeCase'] = $stdFeeDetails->std_fee_case;
                $data['withAdmission'] = "yes"; /*If with out admission*/
                $this->load->view('studentfee/stdSingleVoucher', $data);
            }

        } else {
            redirect('studentfee/FeeVouchers');
        }
    }

    function genrateMultiFeeVoucher()
    {
        $data['feeDetailArray'] = $this->input->post('feeDetailArray');
        $data['InstallmentDetailArray'] = $this->input->post('InstallmentDetailArray');
        $data['voucherIssueDate'] = $this->input->post('voucherIssueDate');
        $data['voucherStuckOffDate'] = $this->input->post('voucherStuckOffDate');
        $data['voucherDueDate'] = $this->input->post('voucherDueDate');
        $data['voucherBillingPeriod'] = $this->input->post('voucherBillingPeriod');
        $data['stdId'] = $this->input->post('stdId');

        $stdFeeDetails = $this->Shared_model->selectDataWhereSingle("tbl_student_fee", array('std_id' => $data['stdId']));
        $student = $this->student_model->get($data['stdId']);
        $data['stdDetail'] = $student;
        $data['withAdmission'] = "yes";
        $data['feeCase'] = $stdFeeDetails->std_fee_case;
        $this->load->view('studentfee/multi-fee-voucher', $data);

    }

    function printSelectedFee()
    {
        $setting_result = $this->setting_model->get();

        $data['settinglist'] = $setting_result;
        $data['feeDetailArray'] = $this->input->post('feeDetailArray');
        $data['stdId'] = $this->input->post('stdId');
        $student = $this->student_model->get($data['stdId']);
        $data['stdDetail'] = $student;
        $student_fee = $this->student_model->getStudentFee($data['stdId']);
        $data['student_fee'] = $student_fee;
        $this->load->view('print/printSelectedFees', $data);
    }
    function deleteAssignedFee()
    {
        $fee_detail_id = $this->input->post('fee_detail_id');
        $feeDetails=$this->Shared_model->selectDataWhereSingle("tbl_student_fee_detail",array('fee_detail_id'=>$fee_detail_id));
        $result=$this->Shared_model->deleteData("tbl_student_fee_detail",['fee_detail_id'=>$fee_detail_id]);
        if($result)
        {
            $stdArrearsDetails=$this->Shared_model->selectDataWhereSingle("tbl_student_fee",array('std_fee_id'=>$feeDetails->std_fee_id));

            $stdArrears=[
                'std_arrears'=>$stdArrearsDetails->std_arrears-$feeDetails->arrears,
                'std_total_arrears'=>$stdArrearsDetails->std_total_arrears-$feeDetails->arrears,
            ];

            $this->Shared_model->updateData("tbl_student_fee", array('std_fee_id' => $feeDetails->std_fee_id), $stdArrears);

            echo json_encode(['status'=>true]);
        }else{
            echo json_encode(['status'=>false]);
        }
    }

    private function genrateChallanNumber()
    {
        $challanNumber = rand(000, 999);
        $challanNumberexsits = $this->Shared_model->selectDataWhereSingle("tbl_vouchers", array('challan_no' => $challanNumber));
        if (!empty($challanNumberexsits)) {
            $this->genrateChallanNumber();
        } else {
            return $challanNumber;
        }

    }

    function revert_student_fee()
    {
        if (empty($this->input->post('feeType'))) {
            $this->form_validation->set_rules('feeType', 'Fee Type', 'trim|required|xss_clean');

        }
        $this->form_validation->set_rules('month', 'Month', 'trim|required|xss_clean');
        if ($this->form_validation->run() == false) {
            $data = array(
                'feeType' => form_error('feeType'),
                'month' => form_error('month'),
                'issue_date' => form_error('issue_date'),
                'due_date' => form_error('due_date'),
                'stuck_off_date' => form_error('stuck_off_date'),
            );
            $array = array('status' => 'fail', 'error' => $data);
            echo json_encode($array);

        } else {
            $student_ids = $this->input->post('student_ids');
            $feeTypeIds = $this->input->post('feeType');
            $issue_date = $this->input->post('issue_date');
            $due_date = $this->input->post('due_date');
            $stuck_off_date = $this->input->post('stuck_off');
            $month = $this->input->post('month');
            $fee_case = $this->input->post('fee_case');
            $fees_discount = 0;
            $tuitionfeediscount = 0;
            $flag = false;
            $total_fee = 0;
            $tuitionFeeFlag = false;

            $index=1;
            $index1=1;
            foreach ($student_ids as $student_id)
            {
                echo $index ."<br>";
//                if($index==1)
//                {
//                    break;
//                }
//                $index++;
                $stdFee = $this->Shared_model->selectDataWhereSingle("tbl_student_fee", array('std_id' => $student_id));
//                $stdFeeDetail = $this->Shared_model->selectDataWhereSingle("tbl_student_fee_detail", array('std_fee_id' => $stdFee->std_fee_id,'fee_month'=>$month,'fee_year'=>date('Y')));

//                $feeTypes= json_decode($stdFeeDetail->fee_type);
                foreach ($student_ids as $key=>$student_id)
                {
                    echo $index1 ."<br>";
                    if($index1==1)
                    {
                        break;
                    }

//                    echo $key;
//                    var_dump($feeType);
//                     foreach ($feeTypeIds as $feeTypeId)
//                     {
//                         if($feeTypeId==$feeType['feeTypeID'])
//                         {
//                             unset($feeTypes['feeTypeId']);
//                         }
//                     }
                    $index1++;
                }
                $index++;

            }

//            $array = array('status' => 'success', 'error' => '', 'message' => 'Fee Records Generated Successfully');

//            echo json_encode($array);

        }

    }

    function feeCollection_report()
    {
//        $this->staff_model->get_StaffNameById($r_value->received_by)
        if (!$this->rbac->hasPrivilege('collect_fees', 'can_view')) {
            access_denied();
        }

        $data['collect_by'] = $this->studentfeemaster_model->get_feesreceived_by();

        $data['searchlist'] = $this->customlib->get_searchtype();
        $data['group_by'] = $this->customlib->get_groupby();
        $data['feeTypes'] = $this->Shared_model->selectAll("tbl_feetype");
        $this->session->set_userdata('top_menu', 'Reports');
        $this->session->set_userdata('sub_menu', 'Reports/finance');
        $this->session->set_userdata('subsub_menu', 'Reports/finance/collection_report');
        $unknownPayments = $this->Shared_model->selectAll("tbl_bank_fee_amounts");

        $data['unknownPayments'] = $unknownPayments;

        if (isset($_POST['search_type']) && $_POST['search_type'] != '') {

            $dates = $this->customlib->get_betweendate($_POST['search_type']);
            $data['search_type'] = $_POST['search_type'];

        } else {

            $dates = $this->customlib->get_betweendate('this_year');
            $data['search_type'] = '';

        }

        if (isset($_POST['collect_by']) && $_POST['collect_by'] != '') {

            $data['received_by'] = $received_by = $_POST['collect_by'];

        } else {

            $data['received_by'] = $received_by = '';

        }

        if (isset($_POST['group']) && $_POST['group'] != '') {

            $data['group_byid'] = $group = $_POST['group'];

        } else {

            $data['group_byid'] = $group = '';
        }

        $collect_by = array();
        $collection = array();

        $start_date = date('Y-m-d', strtotime($dates['from_date']));
        $end_date = date('Y-m-d', strtotime($dates['to_date']));

        $data['collectlist'] = $this->studentfeemaster_model->getFeeCollectionReport($start_date, $end_date);
//        $data['collectlist'] = $this->studentfeemaster_model->fetchFeeCollectionReport($start_date, $end_date);


        $this->form_validation->set_rules('search_type', $this->lang->line('search') . " " . $this->lang->line('type'), 'trim|required|xss_clean');
//        $this->form_validation->set_rules('collect_by', $this->lang->line('collect') . " " . $this->lang->line('by'), 'trim|required|xss_clean');
//        $this->form_validation->set_rules('group', $this->lang->line('group') . " " . $this->lang->line('by'), 'trim|required|xss_clean');


        if ($this->form_validation->run() == false) {

            $data['results'] = array();


        } else {
            $date1=strtotime(date('m-d-Y'));
            $date2=strtotime(date('m-d-Y',strtotime( '+ 1 days')));
            $whereDataArray[]="";
            if(!empty($received_by))
            {
                $whereDataArray['received_by']=$received_by;
            }
            if(!empty($group))
            {
                $whereDataArray['mode']=$group;
            }
            $unknownPayments = $this->Shared_model->selectAll("tbl_bank_fee_amounts");



            $feeDepositDetails = $this->Shared_model->selectDataWhereMultiple("tbl_student_fee_deposit",$whereDataArray);
            $currentFeeDeposits=$this->filterByDate($feeDepositDetails,$start_date,$end_date);

            $data['unknownPayments'] =$this->filterByDate($unknownPayments,$start_date,$end_date,'yes');

//           var_dump($currentFeeDeposits);
//           die();
            $return_data=array();
            if(!empty($currentFeeDeposits))
            {
                foreach ($currentFeeDeposits as $key=>$deposit)
                {

                    $stdFeeWiseDetails=[];
                    $stdtuitionFee=0;
                    $feeDetailid=$deposit->std_fee_detail_id;
                    $feeDetails = $this->Shared_model->selectDataWhereSingle("tbl_student_fee_detail", array('fee_detail_id' => $feeDetailid));
                     $stdFee = $this->Shared_model->selectDataWhereSingle("tbl_student_fee", array('std_fee_id' => $feeDetails->std_fee_id));
                    $studentId=$stdFee->std_id;
                    $studentDetails=$this->student_model->get($studentId);

                    $return_data[$key]=$deposit;
                    if($stdFee->std_fee_case==1)
                    {
                        $return_data[$key]->fee_month=$this->setMonthlyFeeByMonth($feeDetails->fee_month);
                    }else{
                        $return_data[$key]->fee_month=$this->getMonthName($feeDetails->fee_month);
                    }

                    $return_data[$key]->to_bePaid= $feeDetails->last_amount;
                    $return_data[$key]->name=$studentDetails['firstname'].' '.$studentDetails['lastname'];
                    $return_data[$key]->class=$studentDetails['class'].'('.$studentDetails['section'].')';
                    $return_data[$key]->roll_no=$studentDetails['roll_no'];
                    $decodedFeeType=json_decode($feeDetails->fee_type);
                    unset($feeType);
//                    unset($stdFeeWiseDetails);
                    foreach ($decodedFeeType as $value)
                    {
                        $feeTypeDetails = $this->Shared_model->selectDataWhereSingle("tbl_feetype", array('id' => $value->feeTypeID));
                        $feeType[]=$feeTypeDetails->type;
                    }
                    $is_discount = $this->Shared_model->selectDataWhereSingle("tbl_fee_discounts", array('fee_detail_id' => $feeDetailid));
                    $is_discount=null;
                    if(!empty($is_discount))
                    {

                    }
                    else{
//                        foreach ($data['feeTypes'] as $datum)
//                        {
                        foreach ($decodedFeeType as $value) {
//                                if($datum->fee_type=="other")
//                                {
                            $feeTypeDetails = $this->Shared_model->selectDataWhereSingle("tbl_feetype", array('id' => $value->feeTypeID));
                            if ($feeTypeDetails->fee_type == "other" || $feeTypeDetails->fee_type == "anuual" ) {
                                $stdFeeWiseDetails[$value->feeTypeID] = $value->fee_amount;
                            } else {
                                $stdtuitionFee += $value->fee_amount;
                            }
                        }

//                                }else{
//                                    if($value->feeTypeID==$datum->id)
//                                    {
//
//                                        $stdtuitionFee+=$value->fee_amount;
//                                    }
////else{
////
////                                        $stdtuitionFee=0;
////                                    }
//
//                                }
                    }

//                        }

//                    print_r($stdFeeWiseDetails)  ;



//                }



//                    if(array_key_exists(3,$stdFeeWiseDetails))
//                    {
//                        echo "yes";
//                        die();
//                    }else{
//                        die();
//                    }

                    $return_data[$key]->tutionFee=$stdtuitionFee;
                    $return_data[$key]->otherFees=$stdFeeWiseDetails ;
                    $return_data[$key]->feeType=implode(',',$feeType) ;
                    $return_data[$key]->received_byname=$this->staff_model->get_StaffNameById($deposit->received_by);
                }
            }

//                    echo "<pre>";
//                    print_r($return_data);
//        die();

            $data['results'] = $this->studentfeemaster_model->getFeeCollectionReport($start_date, $end_date, $received_by, $group);
//            $data['results'] = $this->studentfeemaster_model->fetchFeeCollectionReport($start_date, $end_date, $received_by, $group);

            if ($group != '') {

                if ($group == 'class') {

                    $group_by = 'class_id';

                } elseif ($group == 'collection') {

                    $group_by = 'received_by';

                } elseif ($group == 'mode') {

                    $group_by = 'payment_mode';

                }

                foreach ($data['results'] as $key => $value) {


                    $collection[$value[$group_by]][] = $value;


                }

            } else {

                $s = 0;
                foreach ($data['results'] as $key => $value) {

                    $collection[$s++] = array($value);


                }

            }

            $data['results'] = $collection;

            $data['results']=$return_data;
        }


        $this->load->view('layout/header', $data);
        $this->load->view('studentfee/feeCollection_report', $data);
        $this->load->view('layout/footer', $data);
    }
    private function filterByDate($data,$startDate,$endDate,$isSTR="")
    {
        $array = array();
        $st_date = strtotime($startDate);
        $ed_date = strtotime($endDate);
//         echo $st_date,$ed_date;
//        die();
        for ($i = $st_date; $i <= $ed_date; $i += 86400) {
            $find = date('m/d/Y', $i);
//            echo $find;
//            die();
            foreach ($data as $row_key => $row_value) {
                if ($isSTR!="")
                {
                    if(date('m/d/Y', $row_value->date) == $find) {
                        $array[$row_key] = $row_value;
                    }

                }else{
                    if($row_value->date == $find) {
                        $array[$row_key] = $row_value;
                    }

                }
            }
        }
        return $array;

    }
    function getMonthName($month)
    {
        $month=ltrim(date('m'),'0');

        if($month=='8-9' ||$month=='9' || $month=='8')
        {
            $returnMonth='August  - September';

        }elseif ($month=='10-11' ||$month=='10' || $month=='11')
        {
            $returnMonth='October - November';
        }elseif ($month=='12-1'||$month=='12' || $month=='1' )
        {
            $returnMonth='December - January';
        }elseif ($month=='2-3' ||$month=='2' || $month=='3')
        {
            $returnMonth='February - March';
        }elseif ($month=='4-5'||$month=='4' || $month=='5')
        {
            $returnMonth='April - May';
        }elseif ($month=='6-7' ||$month=='6' || $month=='7')
        {
            $returnMonth='June - July';
        }
        return $returnMonth;
    }

    public function feefine()
    {
        $this->session->set_userdata('top_menu', $this->lang->line('fees_collection'));
        $this->session->set_userdata('sub_menu', 'studentfee/feefine');
        $data['title']       = 'Fee Fine';
        $this->form_validation->set_rules('fine_amount', 'Amount', 'trim|required|xss_clean');
        if ($this->form_validation->run() == true) {
            $this->Shared_model->updateData("tbl_finetype",array('finetype_id'=>1),array('fine_amount'=>$this->input->post("fine_amount")));
            $this->session->set_flashdata('msg', '<div class="alert alert-success">'.$this->lang->line('update_message').'</div>');

        }

        $fee_fine         = $this->Shared_model->selectDataWhereSingle("tbl_finetype",array('finetype_id'=>1));
        $data['fee_fine']    = $fee_fine;

        $this->load->view('layout/header', $data);
        $this->load->view('studentfee/feeFine', $data);
        $this->load->view('layout/footer', $data);
    }

    public function bank_amount()
    {
        if (!$this->rbac->hasPrivilege('collect_fees', 'can_view')) {
            access_denied();
        }

        $this->session->set_userdata('top_menu', $this->lang->line('fees_collection'));
        $this->session->set_userdata('sub_menu', 'studentfee/bank_amount');
        $data['title']       = 'Bank amount';
        $session             = $this->session_model->getAllSession();
        $data['sessionList'] = $session;

        $bankAmountLists = $this->Shared_model->selectAll("tbl_bank_fee_amounts");
        $data['bankAmountLists']    = $bankAmountLists;
        $this->form_validation->set_rules('bank_name', $this->lang->line('name'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('amount', $this->lang->line('amount'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('date', $this->lang->line('amount'), 'trim|required|xss_clean');
        if ($this->form_validation->run() == true) {

            $data = array(
                'bank_name' => $this->input->post('bank_name'),
                'amount' => $this->input->post('amount'),
                'date' => strtotime($this->input->post('date')),
                'description' => $this->input->post('description'),
                'session_id' => $this->input->post('session_id'),
            );

              $this->Shared_model->insert($data, "tbl_bank_fee_amounts");
            $this->session->set_flashdata('msg', '<div class="alert alert-success">'.$this->lang->line('success_message').'</div>');
            redirect('studentfee/bank_amount');


        }


        $this->load->view('layout/header', $data);
        $this->load->view('studentfee/bank_amount', $data);
        $this->load->view('layout/footer', $data);

    }


    function delete_bank_amount($id) {
        $data['title'] = 'feecategory List';
        $this->Shared_model->deleteData("tbl_bank_fee_amounts",['bank_fee_id'=>$id]);
        $this->session->set_flashdata('msg', '<div class="alert alert-success">'.$this->lang->line('delete_message').'</div>');
        redirect('studentfee/bank_amount');

    }
    function edit_bank_amount() {
         $id=$this->input->post('bank_fee_id');
        $bank_amount         = $this->Shared_model->selectDataWhereSingle("tbl_bank_fee_amounts",['bank_fee_id'=>$id]);
        $lastAmount=$bank_amount->amount;
        $currentAmount=$this->input->post('minus_amount');
        $data = array(
             'amount' => $lastAmount-$currentAmount,
         );
        $this->Shared_model->updateData("tbl_bank_fee_amounts",['bank_fee_id'=>$id],$data);
        $this->session->set_flashdata('msg', '<div class="alert alert-success">'.$this->lang->line('update_message').'</div>');
        redirect('studentfee/bank_amount');

    }



    public function cash_addon()
    {
        if (!$this->rbac->hasPrivilege('collect_fees', 'can_view')) {
            access_denied();
        }

        $this->session->set_userdata('top_menu', $this->lang->line('fees_collection'));
        $this->session->set_userdata('sub_menu', 'studentfee/bank_amount');
        $data['title']       = 'Cash Addon amount';
        $session             = $this->session_model->getAllSession();
        $data['sessionList'] = $session;

        $cashAddonLists = $this->Shared_model->selectAll("tbl_cash_addons");
        $data['cashAddonLists']    = $cashAddonLists;
        $this->form_validation->set_rules('bank_name', $this->lang->line('name'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('amount', $this->lang->line('amount'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('date', $this->lang->line('amount'), 'trim|required|xss_clean');
        if ($this->form_validation->run() == true) {

            $data = array(
                'bank_name' => $this->input->post('bank_name'),
                'amount' => $this->input->post('amount'),
                'date' => strtotime($this->input->post('date')),
                'description' => $this->input->post('description'),
                'session_id' => $this->input->post('session'),
            );

            $this->Shared_model->insert($data, "tbl_cash_addons");
            $this->session->set_flashdata('msg', '<div class="alert alert-success">'.$this->lang->line('success_message').'</div>');
            redirect('studentfee/cash_addon');


        }


        $this->load->view('layout/header', $data);
        $this->load->view('studentfee/cash_addon', $data);
        $this->load->view('layout/footer', $data);

    }
    function delete_cash_addon($id) {
        $data['title'] = 'feecategory List';
        $this->Shared_model->deleteData("tbl_cash_addons",['cash_addon_id'=>$id]);
        $this->session->set_flashdata('msg', '<div class="alert alert-success">'.$this->lang->line('delete_message').'</div>');
        redirect('studentfee/cash_addon');

    }
    function edit_cash_addon() {
        $id=$this->input->post('bank_fee_id');
        $bank_amount         = $this->Shared_model->selectDataWhereSingle("tbl_bank_fee_amounts",['bank_fee_id'=>$id]);
        $lastAmount=$bank_amount->amount;
        $currentAmount=$this->input->post('minus_amount');
        $data = array(
            'amount' => $lastAmount-$currentAmount,
        );
        $this->Shared_model->updateData("tbl_bank_fee_amounts",['bank_fee_id'=>$id],$data);
        $this->session->set_flashdata('msg', '<div class="alert alert-success">'.$this->lang->line('update_message').'</div>');
        redirect('studentfee/bank_amount');

    }


    public function bank_transfer()
    {
        if (!$this->rbac->hasPrivilege('collect_fees', 'can_view')) {
            access_denied();
        }
        $session             = $this->session_model->getAllSession();
        $data['sessionList'] = $session;
        $this->session->set_userdata('top_menu', $this->lang->line('fees_collection'));
        $this->session->set_userdata('sub_menu', 'studentfee/bank_transfer');
        $data['title']       = 'Bank amount';
        $bankAmountLists = $this->Shared_model->selectAll("tbl_bank_transfers");
        $data['bankAmountLists']    = $bankAmountLists;
        $this->form_validation->set_rules('bank_from', $this->lang->line('name'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('bank_to', $this->lang->line('name'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('amount', $this->lang->line('amount'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('date', $this->lang->line('amount'), 'trim|required|xss_clean');
        if ($this->form_validation->run() == true) {

            $data = array(
                'bank_from' => $this->input->post('bank_from'),
                'bank_to' => $this->input->post('bank_to'),
                'amount' => $this->input->post('amount'),
                'date' => strtotime($this->input->post('date')),
                'description' => $this->input->post('description'),
                'session_id' => $this->input->post('session_id'),
            );

            $this->Shared_model->insert($data, "tbl_bank_transfers");
            $this->session->set_flashdata('msg', '<div class="alert alert-success">'.$this->lang->line('success_message').'</div>');
            redirect('studentfee/bank_transfer');


        }


        $this->load->view('layout/header', $data);
        $this->load->view('studentfee/bank_transfer', $data);
        $this->load->view('layout/footer', $data);

    }

    function delete_bank_transfer($id) {
        $data['title'] = 'feecategory List';
        $this->Shared_model->deleteData("tbl_bank_transfers",['transfer_id'=>$id]);
        $this->session->set_flashdata('msg', '<div class="alert alert-success">'.$this->lang->line('delete_message').'</div>');
        redirect('studentfee/bank_transfer');

    }
    public function withdraw()
    {
        if (!$this->rbac->hasPrivilege('collect_fees', 'can_view')) {
            access_denied();
        }

        $this->session->set_userdata('top_menu', $this->lang->line('fees_collection'));
        $this->session->set_userdata('sub_menu', 'studentfee/withdraw');
        $data['title']       = 'Withdraw Amount';
        $session             = $this->session_model->getAllSession();
        $data['sessionList'] = $session;

        $bankAmountLists = $this->Shared_model->selectAll("tbl_withdraw_investment");
        $data['bankAmountLists']    = $bankAmountLists;
        $this->form_validation->set_rules('payment_mode', $this->lang->line('name'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('type', $this->lang->line('name'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('amount', $this->lang->line('amount'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('date', $this->lang->line('amount'), 'trim|required|xss_clean');
        if ($this->form_validation->run() == true) {

            $data = array(
                'mode' => $this->input->post('payment_mode'),
                'type' => $this->input->post('type'),
                'amount' => $this->input->post('amount'),
                'date' => strtotime($this->input->post('date')),
                'description' => $this->input->post('description'),
                'session_id' => $this->input->post('session_id'),
            );

            $this->Shared_model->insert($data, "tbl_withdraw_investment");
            $this->session->set_flashdata('msg', '<div class="alert alert-success">'.$this->lang->line('success_message').'</div>');
            redirect('studentfee/withdraw');


        }


        $this->load->view('layout/header', $data);
        $this->load->view('studentfee/withdraw-investment', $data);
        $this->load->view('layout/footer', $data);

    }

    function delete_withdraw($id) {
        $data['title'] = 'feecategory List';
        $this->Shared_model->deleteData("tbl_withdraw_investment",['main_id'=>$id]);
        $this->session->set_flashdata('msg', '<div class="alert alert-success">'.$this->lang->line('delete_message').'</div>');
        redirect('studentfee/withdraw');

    }
    public function cash_deposit()
    {
        if (!$this->rbac->hasPrivilege('collect_fees', 'can_view')) {
            access_denied();
        }

        $this->session->set_userdata('top_menu', $this->lang->line('fees_collection'));
        $this->session->set_userdata('sub_menu', 'studentfee/withdraw');
        $data['title']       = 'Bank amount';
        $session             = $this->session_model->getAllSession();
        $data['sessionList'] = $session;

        $bankAmountLists = $this->Shared_model->selectAll("tbl_cash_deposit");
        $data['bankAmountLists']    = $bankAmountLists;
        $this->form_validation->set_rules('invoice_no', $this->lang->line('name'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('bank_name', $this->lang->line('name'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('amount', $this->lang->line('amount'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('date', $this->lang->line('amount'), 'trim|required|xss_clean');
        if ($this->form_validation->run() == true) {

            $data = array(
                'invoice_no' => $this->input->post('invoice_no'),
                'bank_name' => $this->input->post('bank_name'),
                'amount' => $this->input->post('amount'),
                'date' => strtotime($this->input->post('date')),
                'description' => $this->input->post('description'),
                'session_id' => $this->input->post('session_id'),
            );

            $this->Shared_model->insert($data, "tbl_cash_deposit");
            $this->session->set_flashdata('msg', '<div class="alert alert-success">'.$this->lang->line('success_message').'</div>');
            redirect('studentfee/cash_deposit');


        }


        $this->load->view('layout/header', $data);
        $this->load->view('studentfee/cash_deposit', $data);
        $this->load->view('layout/footer', $data);

    }

    function delete_cash_deposit($id) {
        $data['title'] = 'feecategory List';
        $this->Shared_model->deleteData("tbl_cash_deposit",['main_id'=>$id]);
        $this->session->set_flashdata('msg', '<div class="alert alert-success">'.$this->lang->line('delete_message').'</div>');
        redirect('studentfee/cash_deposit');

    }

    public function previous_balance()
    {
        if (!$this->rbac->hasPrivilege('fees_collection_report', 'can_update')) {
            access_denied();
        }

        $this->session->set_userdata('top_menu', 'Reports');
        $this->session->set_userdata('sub_menu', 'Reports/finance');
        $this->session->set_userdata('subsub_menu', 'Reports/finance/reconciliation_report');
        $data['title']       = 'Previous Session Balance';
        $previous_balance = $this->Shared_model->selectAll("tbl_previous_session_balance");
        $data['previous_balance']    = $previous_balance;
        $this->form_validation->set_rules('hbl_amount', $this->lang->line('name'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('soneri_amount', $this->lang->line('name'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('cash_amount', $this->lang->line('amount'), 'trim|required|xss_clean');
         if ($this->form_validation->run() == true) {

            $data1 = array(
                 'amount' => $this->input->post('hbl_amount'),
             );
            $data2 = array(
                 'amount' => $this->input->post('soneri_amount'),
             );
            $data3 = array(
                 'amount' => $this->input->post('cash_amount'),
             );

            $this->Shared_model->updateData('tbl_previous_session_balance',['type'=>"HBL"],$data1);
            $this->Shared_model->updateData('tbl_previous_session_balance',['type'=>"Soneri"],$data2);
            $this->Shared_model->updateData('tbl_previous_session_balance',['type'=>"Cash"],$data3);
            $this->session->set_flashdata('msg', '<div class="alert alert-success">'.$this->lang->line('update_message').'</div>');
            redirect('studentfee/reconciliation_report');


        }


        $this->load->view('layout/header', $data);
        $this->load->view('studentfee/previous_balance', $data);
        $this->load->view('layout/footer', $data);

    }

    public function getFeeTypes()
    {
        $id=$this->input->post('fee_id');
        $student_fee_details         = $this->Shared_model->selectDataWhereSingle("tbl_student_fee_detail",['fee_detail_id'=>$id]);

        $feeTypeIds=json_decode($student_fee_details->fee_type);
        $html='';
        foreach ($feeTypeIds as $feeTypeId)
        {
            $feeTypeDetails         = $this->Shared_model->selectDataWhereSingle("tbl_feetype",['id'=>$feeTypeId->feeTypeID]);


            $html.='<option value="'.$feeTypeDetails->id.'"> '.$feeTypeDetails->type.'</option>';
        }

        echo json_encode(['status'=>true,'html'=>$html]);

    }
    public function feeRegister()
    {
        if (!$this->rbac->hasPrivilege('search_due_fees', 'can_view')) {
            access_denied();
        }

        $this->session->set_userdata('top_menu', 'Fees Collection');
        $this->session->set_userdata('sub_menu', 'studentfee/feesearch');
        $data['title'] = 'student fees';
        $class = $this->class_model->get();
        $data['classlist'] = $class;
        $feesessiongroup = $this->feesessiongroup_model->getFeesByGroup();
        $months = array( 'Jul', 'Aug', 'Sep','Oct','Nov', 'Dec','Jan', 'Feb', 'Mar', 'Apr','May', 'Jun');
        $data['monthsLists'] = $months;
        $unknownPayments = $this->Shared_model->selectAll("tbl_bank_fee_amounts");

        $data['unknownPayments'] = $unknownPayments;
        $data['feesessiongrouplist'] = $feesessiongroup;
        $data['fees_group'] = "";
        if (isset($_POST['feegroup_id']) && $_POST['feegroup_id'] != '') {
            $data['fees_group'] = $_POST['feegroup_id'];
        }

        $this->form_validation->set_rules('feegroup_id', $this->lang->line('fee_group'), 'trim|required|xss_clean');

//        $this->form_validation->set_rules('class_id', $this->lang->line('class'), 'trim|required|xss_clean');
//        $this->form_validation->set_rules('section_id', $this->lang->line('section'), 'trim|required|xss_clean');
        $session             = $this->session_model->getAllSession();
        $data['sessionList'] = $session;
        if ($this->form_validation->run() == false) {
            $this->load->view('layout/header', $data);
            $this->load->view('studentfee/studentFeeRegister', $data);
            $this->load->view('layout/footer', $data);
        } else {
            $data['student_due_fee'] = array();
            $feegroup_id = $this->input->post('feegroup_id');
//            $feegroup                = explode("-", $feegroup_id);
//            $feegroup_id             = $feegroup[0];
//            $fee_groups_feetype_id   = $feegroup[1];
            $class_id = $this->input->post('class_id');
            $section_id = $this->input->post('section_id');
            $session_id = $this->input->post('session_id');

            $student_due_fee = $this->studentfee_model->getStudentDueFee($feegroup_id, $class_id, $section_id,$session_id);
            if (!empty($student_due_fee)) {
                foreach ($student_due_fee as $key => $value) {
                    $student_due_fee[$key]['amount_fine'] = 0;
                    $depositAmount = 0;
                    $discount = 0;
                    $anuualFee = 0;
                    $labFee = 0;
                    $otherFee = 0;
                    $security = 0;
                    $registration = 0;
                    $admission = 0;
                    $payable = 0;
                    $totalfee = 0;
                    $totalExtraPaid = 0;
                    $totalArrears = 0;
                    $totalPaidFee = 0;
                    $stdFeeByMonth = [];
                    $stdFeeDetails = $this->Shared_model->selectDataWhereMultiple("tbl_student_fee_detail", array('std_fee_id' => $value['std_fee_id']));
                    $stdArrears = $this->Shared_model->selectDataWhereSingle("tbl_student_fee", array('std_fee_id' => $value['std_fee_id']));
                    $installmentFlag=false;
                    foreach ($stdFeeDetails as $stdFeeDetail) {
//                        $depositAmount = 0;
                        if($stdArrears->std_fee_case==1)
                        {
                            $thisFeeMonth=$this->setMonthlyFeeByMonth($stdFeeDetail->fee_month);

                            if(!isset($stdFeeByMonth[$thisFeeMonth]))
                            {
                                $current_month_tution_fee=0;
                            }

                        }else{
                            $thisFeeMonth=$this->setBiMonthlyFeeByMonth($stdFeeDetail->fee_month);

                            if(!isset($stdFeeByMonth[$thisFeeMonth]))
                            {

                                $current_month_tution_fee=0;
                            }

                        }


//                         $current_month_tution_fee=0;

                        $current_date=strtotime(date('m/d/Y'));
                        $due_date=strtotime($stdFeeDetail->due_date);
                        $session_current   = substr($this->setting_model->getCurrentSessionName(),'5');
                        $currentYear=substr(date('Y'),'0','2');

                        $curentFeeYear=$currentYear.$session_current;

                        $previous_session=$currentYear.$session_current-1;

                        $feeDepositDetails = $this->Shared_model->selectDataWhereMultiple("tbl_student_fee_deposit", array('std_fee_detail_id' => $stdFeeDetail->fee_detail_id));

                        if(!empty($feeDepositDetails))
                        {
                            foreach ($feeDepositDetails as $feeDepositDetail) {
                                $totalExtraPaid = $totalExtraPaid + $feeDepositDetail->extra_amount;
                            }

                        }
                        // || $stdFeeDetail->fee_year<$curentFeeYear
                        if (($stdFeeDetail->fee_year==$curentFeeYear )  ) {
                            if( $stdFeeDetail->fee_status == 1)
                            {

                                $feesLists=json_decode($stdFeeDetail->fee_type);
                                if(!empty($feesLists))
                                {
                                    foreach ($feesLists as $feesList)
                                    {


                                        $appliedFeeDetails= $this->Shared_model->selectDataWhereSingle("tbl_feetype", array('id' => $feesList->feeTypeID));
                                        if ($appliedFeeDetails->fee_type=="anuual")
                                        {
                                            $anuualFee+=$feesList->fee_amount;
                                        }elseif($appliedFeeDetails->fee_type=="lab"){
                                            $labFee+=$feesList->fee_amount;
                                        }elseif($appliedFeeDetails->slug=="security"){
                                            $security+=$feesList->fee_amount;

                                        }elseif($appliedFeeDetails->slug=="registration"){
                                            $registration+=$feesList->fee_amount;

                                        }elseif($appliedFeeDetails->slug=="admission"){
                                            $admission+=$feesList->fee_amount;

                                        }
                                        if ($appliedFeeDetails->fee_type=="tuition")
                                        {
                                            $current_month_tution_fee=$feesList->fee_amount;
                                        }
                                    }

                                }



                                if ($stdFeeDetail->fee_status == 1) {
//                                    $totalfee = $totalfee + $stdFeeDetail->last_amount;
//                                    $payable = $payable + $stdFeeDetail->last_amount;
                                    $totalfee = $totalfee + $stdFeeDetail->total_amount;
                                    $payable = $payable + $stdFeeDetail->total_amount;

                                    if($stdArrears->std_fee_case==1)
                                    {
//                                        if($value['std_id']==989)
//                                            echo $current_month_tution_fee;
                                        $thisFeeMonth=$this->setMonthlyFeeByMonth($stdFeeDetail->fee_month);
                                        $feeofThisMonth=$current_month_tution_fee;
//                                        if($value['std_id']==989)
//                                            echo $feeofThisMonth.$thisFeeMonth;


                                    }else{
                                        $thisFeeMonth=$this->setBiMonthlyFeeByMonth($stdFeeDetail->fee_month);
                                        $feeofThisMonth=$current_month_tution_fee;

                                    }
//                                    $feeofThisMonth=$stdFeeDetail->last_amount;

//                                    if($value['std_id']==1135)
//                                    {
//                                        echo "<pre>";
//                                        print_r($stdFeeDetail->total_amount);echo "<pre>";
//                                        print_r($stdFeeDetail->fee_detail_id);
//
//
//                                    }

                                }
                                elseif ($stdFeeDetail->fee_status == 2) {
                                    if($stdArrears->std_fee_case==1)
                                    {
                                        $thisFeeMonth=$this->setMonthlyFeeByMonth($stdFeeDetail->fee_month);
                                        $feeofThisMonth=$current_month_tution_fee;

                                    }else{
                                        $thisFeeMonth=$this->setBiMonthlyFeeByMonth($stdFeeDetail->fee_month);
                                        $feeofThisMonth=$current_month_tution_fee;

                                    }

                                    $totalPaidFee=0;
                                    $totalExtraPaid=0;
                                    $feeDepositDetails = $this->Shared_model->selectDataWhereMultiple("tbl_student_fee_deposit", array('std_fee_detail_id' => $stdFeeDetail->fee_detail_id));
                                    foreach ($feeDepositDetails as $feeDepositDetail) {
                                        $totalPaidFee = $totalPaidFee + $feeDepositDetail->paid_amount;
                                        $totalExtraPaid = $totalExtraPaid + $feeDepositDetail->extra_amount;

                                    }
//                                    if($value['std_id']==1125)
//                                    {
//                                        echo $totalExtraPaid;
//                                    }
                                    $depositAmount = $depositAmount + $totalPaidFee;
                                    $totalfee = $totalfee + $stdFeeDetail->total_amount;
//                                    $payable = $payable + $stdFeeDetail->last_amount;
                                    $payable = $payable + $stdFeeDetail->total_amount;
//                                    $feeofThisMonth=$stdFeeDetail->last_amount-$totalPaidFee;
                                    if($stdArrears->std_fee_case==1)
                                    {
                                        $thisFeeMonth=$this->setMonthlyFeeByMonth($stdFeeDetail->fee_month);
                                        $feeofThisMonth=$current_month_tution_fee-$totalExtraPaid;

                                    }else{
                                        $thisFeeMonth=$this->setBiMonthlyFeeByMonth($stdFeeDetail->fee_month);
                                        $feeofThisMonth=$current_month_tution_fee-$totalExtraPaid;

                                    }


                                }
//                            $totalArrears=$totalArrears+$stdArrears->arrears;
                                $totalArrears=$totalArrears+$stdFeeDetail->arrears;
                                $discount+=$stdFeeDetail->total_discount;

                            }
                            else{



                                if($stdArrears->std_fee_case==1)
                                {
                                    $thisFeeMonth=$this->setMonthlyFeeByMonth($stdFeeDetail->fee_month);
                                    $feeofThisMonth=0;

                                }else{
                                    $thisFeeMonth=$this->setBiMonthlyFeeByMonth($stdFeeDetail->fee_month);
                                    $feeofThisMonth=0;

                                }


                            }
                            if(!$installmentFlag)
                            {

                                if($stdFeeDetail->is_installment==1)
                                {
                                    $installmentFlag=true;
                                }
                            }


                            if(!isset($stdFeeByMonth[$thisFeeMonth]))
                            {
                                $stdFeeByMonth[$thisFeeMonth]=$feeofThisMonth;

                            }


                        }
                        else{

                            $feeDepositDetails = $this->Shared_model->selectDataWhereMultiple("tbl_student_fee_deposit", array('std_fee_detail_id' => $stdFeeDetail->fee_detail_id));
                            $totalPaidFeeLastSession=0;
                            $totalPaidFineLastSession=0;
                            $totalExtraPaid=0;
                            if(!empty($feeDepositDetails))
                            {
                                foreach ($feeDepositDetails as $feeDepositDetail) {
                                    $totalPaidFeeLastSession = $totalPaidFeeLastSession + $feeDepositDetail->paid_amount;
                                    $totalPaidFineLastSession = $totalPaidFineLastSession + $feeDepositDetail->fine;
                                    $totalExtraPaid = $totalExtraPaid + $feeDepositDetail->extra_amount;

                                }

                            }
//                            $depositAmount = $depositAmount + $totalExtraPaid;
//                            if($value['std_id']==1048)
//                            {
//                                echo "<pre>";
//                                print_r($stdFeeDetail->total_amount);echo "<pre>";
//                                print_r($stdFeeDetail->last_amount);echo "<pre>";
//                                print_r($stdFeeDetail->arrears);echo "<pre>";
//                                print_r($totalPaidFeeLastSession);
//                                print_r($totalArrears);
//
//
//                            }

                            $totalArrears=(($totalArrears+$stdFeeDetail->last_amount)-$totalPaidFeeLastSession)+$totalPaidFineLastSession;
                            if($stdArrears->std_fee_case==1)
                            {

                                $thisFeeMonth=$this->setMonthlyFeeByMonth($stdFeeDetail->fee_month);
                                $feeofThisMonth=0;
                            }else{
                                $thisFeeMonth=$this->setBiMonthlyFeeByMonth($stdFeeDetail->fee_month);
                                $feeofThisMonth=0;

                            }

                        }
                    }
//                     if($value['std_id']==989)
//                     {
//                         echo "<pre>";
//                         print_r($totalfee);
//
//
//                     }

                    $student_due_fee[$key]['totalExtraPaid'] = $totalExtraPaid;
                    $student_due_fee[$key]['fine_amount'] = $payable;
                    $student_due_fee[$key]['otherFee'] = $otherFee;
                    $student_due_fee[$key]['security'] = $security;
                    $student_due_fee[$key]['registration'] = $registration;
                    $student_due_fee[$key]['admission'] = $admission;
                    $student_due_fee[$key]['labFee'] = $labFee;
                    $student_due_fee[$key]['anuualFee'] = $anuualFee;
                    $student_due_fee[$key]['stdInstallment'] = ($installmentFlag)?"Yes":"No";
                    $student_due_fee[$key]['stdTuituionFee'] = $stdArrears->std_tuition_fee;
                    $student_due_fee[$key]['stdMonthFeesLists'] = $stdFeeByMonth;
//                    $student_due_fee[$key]['amount'] = $totalfee+$totalArrears;
                    $student_due_fee[$key]['amount'] = $totalfee-$totalExtraPaid;
//                    $student_due_fee[$key]['amount'] =  $stdArrears->arrears;
                    $student_due_fee[$key]['amount_detail'] = $depositAmount;
                    $student_due_fee[$key]['total_discount'] = $discount;
//                    $student_due_fee[$key]['amount_arrears'] = $stdArrears->std_arrears;
                    $student_due_fee[$key]['amount_arrears'] = $totalArrears;
                }


            }
             //            $student_due_fee         = $this->studentfee_model->getDueStudentFees($feegroup_id, $fee_groups_feetype_id, $class_id, $section_id);
//            if (!empty($student_due_fee)) {
//                foreach ($student_due_fee as $student_due_fee_key => $student_due_fee_value) {
//                    $amt_due                                                  = $student_due_fee_value['amount'];
//                    $student_due_fee[$student_due_fee_key]['amount_discount'] = 0;
//                    $student_due_fee[$student_due_fee_key]['amount_fine']     = 0;
//                    $a                                                        = json_decode($student_due_fee_value['amount_detail']);
//                    if (!empty($a)) {
//                        $amount          = 0;
//                        $amount_discount = 0;
//                        $amount_fine     = 0;
//
//                        foreach ($a as $a_key => $a_value) {
//                            $amount          = $amount + $a_value->amount;
//                            $amount_discount = $amount_discount + $a_value->amount_discount;
//                            $amount_fine     = $amount_fine + $a_value->amount_fine;
//                        }
//                        if ($amt_due <= $amount) {
//                            unset($student_due_fee[$student_due_fee_key]);
//                        } else {
//
//                            $student_due_fee[$student_due_fee_key]['amount_detail']   = $amount;
//                            $student_due_fee[$student_due_fee_key]['amount_discount'] = $amount_discount;
//                            $student_due_fee[$student_due_fee_key]['amount_fine']     = $amount_fine;
//                        }
//                    }
//                }
//            }

            // die();
//            foreach ($student_due_fee as $value)
//            {
//                if($value['std_id']==962)
//                {
//                    echo "<pre>";
//                    print_r($value);
//
//                }
//            }
            $data['student_due_fee'] = $student_due_fee;
            $this->load->view('layout/header', $data);
            $this->load->view('studentfee/studentFeeRegister', $data);
            $this->load->view('layout/footer', $data);
        }


    }

    public function reconciliation_report_search()
    {
        if (!$this->rbac->hasPrivilege('fees_collection_report', 'can_view')) {
            access_denied();
        }

        $this->session->set_userdata('top_menu', 'Reports');
        $this->session->set_userdata('sub_menu', 'Reports/finance');
        $this->session->set_userdata('subsub_menu', 'Reports/finance/reconciliation_report_search');
        $data['title'] = 'Reconciliation report';
        $session             = $this->session_model->getAllSession();
        $data['sessionList'] = $session;
         $this->load->view('layout/header', $data);
        $this->load->view('studentfee/rc_report_search', $data);
        $this->load->view('layout/footer', $data);

    }
    public function reconciliation_report()
    {
        if (!$this->rbac->hasPrivilege('fees_collection_report', 'can_view')) {
            access_denied();
        }







        $session_id=$this->input->post('session_id');
        $this->session->set_userdata('top_menu', 'Reports');
        $this->session->set_userdata('sub_menu', 'Reports/finance');
        $this->session->set_userdata('subsub_menu', 'Reports/finance/reconciliation_report');
        $data['title'] = 'Reconciliation report';
        $session             = $this->session_model->getAllSession();
        $data['sessionList'] = $session;
        $data['bank_transfer'] = $this->Shared_model->selectDataWhereMultiple("tbl_bank_transfers",['session_id'=>$session_id]);
        $data['withdraw_investment'] = $this->Shared_model->selectDataWhereMultiple("tbl_withdraw_investment",['session_id'=>$session_id]);
        $data['cash_deposit'] = $this->Shared_model->selectDataWhereMultiple("tbl_cash_deposit",['session_id'=>$session_id]);
        $data['expenses'] = $this->Shared_model->selectAll("expenses");
        $data['incomes'] = $this->Shared_model->selectAll("income");
         $data['previous_balance']    = $this->Shared_model->selectAll("tbl_previous_session_balance");
//          $data['fee_collection']    = $this->Shared_model->selectDataWhereMultiple("tbl_student_fee_deposit",['session_id'=>$session_id]);
        $tbl_student_fee_details    = $this->Shared_model->selectDataWhereMultiple("tbl_student_fee_detail",['session_id'=>$session_id]);
         $data['bank_fee_amounts']    = $this->Shared_model->selectDataWhereMultiple("tbl_bank_fee_amounts",['session_id'=>$session_id]);
         $data['cash_addons']    = $this->Shared_model->selectDataWhereMultiple("tbl_cash_addons",['session_id'=>$session_id]);
//         $data['fee_collection']    = $this->Shared_model->updateData2($session_id);
        $feeCollectionArray=[];
//        foreach ($tbl_student_fee_details as $student_fee_detail)if(!empty($student_fee_detail))
//        {
        $start_date='2020-07-01';
        $end_date=date('Y-m-d');


        $feeDepositDetails = $this->Shared_model->selectAll("tbl_student_fee_deposit");
        $currentFeeDeposits=$this->filterByDate($feeDepositDetails,$start_date,$end_date);

        $random_plus=0;
            $tbl_student_fee_deposits=  $this->Shared_model->selectDataWhereMultiple("tbl_student_fee_deposit",array('date >='=>'01/07/2020'));
            foreach ($currentFeeDeposits as $key=>$student_fee_deposit)
            {
                $feeCollectionArray[$key]=$student_fee_deposit;
                $random_plus=$random_plus+$student_fee_deposit->paid_amount;
            }

//            echo count($currentFeeDeposits);
//
//            die();
//        }
        $data['fee_collection']=$feeCollectionArray;
        $this->load->view('layout/header', $data);
        $this->load->view('studentfee/reconciliation_report', $data);
        $this->load->view('layout/footer', $data);

    }

}
