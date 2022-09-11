<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Feediscount extends Admin_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model("Shared_model");
        $this->sch_setting_detail = $this->setting_model->getSetting();
    }

    function delete($id) {
        $data['title'] = 'feecategory List';
        $this->feediscount_model->remove($id);
        redirect('admin/feediscount/index');

    }

    function index() {
        if (!$this->rbac->hasPrivilege('fees_discount', 'can_view')) {
            access_denied();
        }
        $this->session->set_userdata('top_menu', 'Fees Collection');
        $this->session->set_userdata('sub_menu', 'admin/feediscount');
        $feesdiscount_result = $this->feediscount_model->get();
        $data['feediscountList'] = $feesdiscount_result;
        $this->form_validation->set_rules('code', $this->lang->line('discount_code'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('name', $this->lang->line('name'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('amount', $this->lang->line('amount'), 'trim|required|xss_clean');
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('layout/header', $data);
            $this->load->view('admin/feediscount/feediscountList', $data);
            $this->load->view('layout/footer', $data);
        } else {
            $data = array(
                'name' => $this->input->post('name'),
                'code' => $this->input->post('code'),
                'amount' => $this->input->post('amount'),
                'description' => $this->input->post('description'),
            );
            $this->feediscount_model->add($data);
            $this->session->set_flashdata('msg', '<div class="alert alert-success">'.$this->lang->line('success_message').'</div>');
            redirect('admin/feediscount');
        }
    }

    function edit($id) {
        if (!$this->rbac->hasPrivilege('fees_discount', 'can_edit')) {
            access_denied();
        }
        $this->session->set_userdata('top_menu', 'Fees Collection');
        $this->session->set_userdata('sub_menu', 'admin/feediscount');
        $feesdiscount_result = $this->feediscount_model->get();
        $data['feediscountList'] = $feesdiscount_result;
        $data['title'] = 'Edit feecategory';
        $data['id'] = $id;

        $feediscount = $this->feediscount_model->get($id);
        $data['feediscount'] = $feediscount;
        $this->form_validation->set_rules('name', $this->lang->line('category'), 'trim|required|xss_clean');
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('layout/header', $data);
            $this->load->view('admin/feediscount/feediscountEdit', $data);
            $this->load->view('layout/footer', $data);
        } else {
            $data = array(
                'id' => $id,
                 'name' => $this->input->post('name'),
                'code' => $this->input->post('code'),
                'amount' => $this->input->post('amount'),
                'description' => $this->input->post('description'),
            );
            $this->feediscount_model->add($data);
            $this->session->set_flashdata('msg', '<div class="alert alert-success">'.$this->lang->line('update_message').'</div>');
            redirect('admin/feediscount/index');
        }
    }

    function assign($id) {
        if (!$this->rbac->hasPrivilege('fees_discount_assign', 'can_view')) {
            access_denied();
        }
        $this->session->set_userdata('top_menu', 'Fees Collection');
        $this->session->set_userdata('sub_menu', 'admin/feediscount');
        $data['id'] = $id;
        $data['title'] = 'student fees';
        $class = $this->class_model->get();
        $data['classlist'] = $class;
        $feediscount_result = $this->feediscount_model->get($id);
        $data['feediscountList'] = $feediscount_result;

        $genderList = $this->customlib->getGender();
        $data['genderList'] = $genderList;
        $RTEstatusList = $this->customlib->getRteStatus();
        $data['RTEstatusList'] = $RTEstatusList;
        $category = $this->category_model->get();
        $data['categorylist'] = $category;

        if ($this->input->server('REQUEST_METHOD') == 'POST') {

            $data['category_id'] = $this->input->post('category_id');
            $data['gender'] = $this->input->post('gender');
            $data['rte_status'] = $this->input->post('rte');
            $data['class_id'] = $this->input->post('class_id');
            $data['section_id'] = $this->input->post('section_id');

            $resultlist = $this->feediscount_model->searchAssignFeeByClassSection($data['class_id'], $data['section_id'], $id, $data['category_id'], $data['gender'], $data['rte_status']);
            $data['resultlist'] = $resultlist;
        }
        $this->load->view('layout/header', $data);
        $this->load->view('admin/feediscount/assign', $data);
        $this->load->view('layout/footer', $data);
    }

    function studentdiscount() {
        if (!$this->rbac->hasPrivilege('fees_discount_assign', 'can_view')) {
            access_denied();
        }
        $this->session->set_userdata('top_menu', 'Fees Collection');
        $this->session->set_userdata('sub_menu', 'admin/feediscount');
        $this->form_validation->set_rules('feediscount_id', 'Fee Discount', 'required|trim|xss_clean');
      

        if ($this->form_validation->run() == false) {
            $data = array(
                'feediscount_id' => form_error('feediscount_id'),
                  
            );
            $array = array('status' => 'fail', 'error' => $data);
            echo json_encode($array);
        } else {

            $student_list = $this->input->post('student_list');
            $feediscount_id = $this->input->post('feediscount_id');
            $student_sesssion_array = $this->input->post('student_session_id');
            if (!isset($student_sesssion_array)) {
                $student_sesssion_array = array();
            }
            $diff_aray = array_diff($student_list, $student_sesssion_array);
            $preserve_record = array();
            foreach ($student_sesssion_array as $key => $value) {

                $insert_array = array(
                    'student_session_id' => $value,
                    'fees_discount_id' => $feediscount_id,
                );
                $inserted_id = $this->feediscount_model->allotdiscount($insert_array);

                $preserve_record[] = $inserted_id;
            }
            if (!empty($diff_aray)) {
                $this->feediscount_model->deletedisstd($feediscount_id, $diff_aray);
            }

            $array = array('status' => 'success', 'error' => '', 'message' => $this->lang->line('success_message'));
            echo json_encode($array);
        }
    }

    function applydiscount() {
        if (!$this->rbac->hasPrivilege('fees_discount_assign', 'can_add')) {
            access_denied();
        }
        $this->form_validation->set_rules('discount_payment_id', $this->lang->line('fees_payment_id'), 'required|trim|xss_clean');
        $this->form_validation->set_rules('student_fees_discount_id', $this->lang->line('fees_discount_id'), 'required|trim|xss_clean');

        if ($this->form_validation->run() == false) {
            $data = array(
                'amount' => form_error('amount'),
                'discount_payment_id' => form_error('discount_payment_id'),
            );
            $array = array('status' => 'fail', 'error' => $data);
            echo json_encode($array);
        } else {

            $data = array(
                'id' => $this->input->post('student_fees_discount_id'),
                'payment_id' => $this->input->post('discount_payment_id'),
                'description' => $this->input->post('dis_description'),
                'status' => 'applied'
            );

            $this->feediscount_model->updateStudentDiscount($data);
            $array = array('status' => 'success', 'error' => '');
            echo json_encode($array);
        }
    }


    function feediscounts()
    {
        if (!$this->rbac->hasPrivilege('fees_discount', 'can_view')) {
            access_denied();
        }
        $this->session->set_userdata('top_menu', 'Fees Collection');
        $this->session->set_userdata('sub_menu', 'admin/feediscount');
//        $feesdiscount_result = $this->feediscount_model->get();
         $feesdiscount_result = $this->Shared_model->selectAll("tbl_fee_discount");

        $data['feediscountList'] = $feesdiscount_result;
        $feeType_result = $this->studentfee_model->getFeeType();
        $data['feeTypeList'] = $feeType_result;
        $this->form_validation->set_rules('code', $this->lang->line('discount_code'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('name', $this->lang->line('name'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('amount', $this->lang->line('amount'), 'trim|required|xss_clean');
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('layout/header', $data);
            $this->load->view('studentfee/feediscountList', $data);
            $this->load->view('layout/footer', $data);
        } else {
            $data = array(
                'name' => $this->input->post('name'),
                'code' => $this->input->post('code'),
                'discount_rate' => $this->input->post('amount'),
                'description' => $this->input->post('description'),
                'fee_type_id' => $this->input->post('feeType'),
                'date' => date('m-d-Y'),
            );
            $feeDiscountId = $this->Shared_model->insert($data, "tbl_fee_discount");
            $this->session->set_flashdata('msg', '<div class="alert alert-success">'.$this->lang->line('success_message').'</div>');
            redirect('admin/feediscount/feediscounts');
        }

    }
    function delete1($id) {
        $data['title'] = 'feecategory List';
        $feeDiscountId = $this->Shared_model->deleteData("tbl_fee_discount",array('discount_id'=>$id));
        $this->session->set_flashdata('msg', '<div class="alert alert-success">'.$this->lang->line('delete_message').'</div>');
        redirect('admin/feediscount/feediscounts');

    }
    function edit1($id) {
        if (!$this->rbac->hasPrivilege('fees_discount', 'can_edit')) {
            access_denied();
        }
        $this->session->set_userdata('top_menu', 'Fees Collection');
        $this->session->set_userdata('sub_menu', 'admin/feediscount');
        $feesdiscount_result = $this->Shared_model->selectAll("tbl_fee_discount");
        $data['feediscountList'] = $feesdiscount_result;
        $data['title'] = 'Edit feecategory';
        $data['id'] = $id;
        $feeType_result = $this->studentfee_model->getFeeType();
        $data['feeTypeList'] = $feeType_result;
        $feediscount = $this->Shared_model->selectDataWhereSingle("tbl_fee_discount",array('discount_id'=>$id));
        $data['feediscount'] = $feediscount;
        $this->form_validation->set_rules('name', $this->lang->line('category'), 'trim|required|xss_clean');
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('layout/header', $data);
            $this->load->view('studentfee/feediscountEdit', $data);
            $this->load->view('layout/footer', $data);
        } else {
            $data = array(
                'id' => $id,
                'name' => $this->input->post('name'),
                'code' => $this->input->post('code'),
                'amount' => $this->input->post('amount'),
                'description' => $this->input->post('description'),
            );
            $this->feediscount_model->add($data);
            $this->session->set_flashdata('msg', '<div class="alert alert-success">'.$this->lang->line('update_message').'</div>');
            redirect('admin/feediscount/index');
        }
    }

    function assignFeeDiscount($id=null)
    {
        if (!$this->rbac->hasPrivilege('fees_discount_assign', 'can_view')) {
            access_denied();
        }
        $this->session->set_userdata('top_menu', 'Fees Collection');
        $this->session->set_userdata('sub_menu', 'admin/feediscount');
        $data['id'] = $id;
        $data['title'] = 'student fees';
        $data['fee_case'] = '';
        $data['adm_auto_insert'] = $this->sch_setting_detail->adm_auto_insert;
        $data['sch_setting'] = $this->sch_setting_detail;
         if ($this->input->server('REQUEST_METHOD') == "GET") {
             $this->load->view('layout/header', $data);
             $this->load->view('studentfee/assignfeediscount', $data);
             $this->load->view('layout/footer', $data);
        } else {
            $fee_case = $this->input->post('fee_case');
            $fee_year = $this->input->post('fee_year');
            if ($fee_case == 1) {
                $month = $this->input->post('month1');
            } elseif ($fee_case == 2) {
                $month = $this->input->post('month2');
            } else {
                $month = $this->input->post('month13');
            }
            $data['fee_case'] = $fee_case;
            $data['fee_year'] = $fee_year;
            $data['month'] = $month;
            $search = $this->input->post('search');
            if (isset($search)) {
                if ($search == 'search_filter') {
                    $this->form_validation->set_rules('fee_case', 'Fee Case', 'trim|required|xss_clean');
                    $this->form_validation->set_rules('fee_year', 'Fee Year', 'trim|required|xss_clean');
                    if ($this->form_validation->run() == false) {
                        $this->load->view('layout/header', $data);
                        $this->load->view('studentfee/assignfeediscount', $data);
                        $this->load->view('layout/footer', $data);
                    } else {
                        $resultlist = $this->student_model->getFeeAssignedStudents($month, $fee_case,$fee_year);
//                       $resultlist = $this->removeDuplicatesFee($resultlist);
                        $data['resultlist'] = $resultlist;
                    }
                }
                $this->load->view('layout/header', $data);
                $this->load->view('studentfee/assignfeediscount', $data);
                $this->load->view('layout/footer', $data);
            }


        }
    }

    function assignDiscount()
    {
        if ($this->input->server('REQUEST_METHOD') == "POST") {

            $fee_detail_ids = $this->input->post('fee_detail_ids');
            $fee_case = $this->input->post('fee_case');
            $discount_id = $this->input->post('discount_id');
            foreach ($fee_detail_ids as $fee_detail_id) {
                $feedetail=$this->Shared_model->selectDataWhereSingle("tbl_student_fee_detail",array('fee_detail_id'=>$fee_detail_id));
                $feediscount = $this->Shared_model->selectDataWhereSingle("tbl_fee_discount",array('discount_id'=>$discount_id));
                $discFeeType=$feediscount->fee_type_id;
                $stdFeeTypes=json_decode($feedetail->fee_type);
                $feeAmount=0;
                $DiscountTypeArray=[];
                $AppliedDiscountArray=[];

                if(!empty($feedetail->discount_type)){
                    $DiscountTypeArray=json_decode($feedetail->discount_type);
                    $AppliedDiscountArray=json_decode($feedetail->applied_discounts);
                    if(in_array($discount_id,$DiscountTypeArray))
                    {
                        continue;
                    }
                }
                array_push($DiscountTypeArray,$discount_id);
                foreach ($stdFeeTypes as $stdFeeType)
                {
                    if($stdFeeType->feeTypeID==$discFeeType)
                    {
                        $feeAmount=$stdFeeType->fee_amount;
                    }
                }
                $disc_rate=$feediscount->discount_rate;
                $disc_factor=$disc_rate/100;
                $discount_price=$feeAmount*$disc_factor;
                $discounted_fee=$feeAmount-$discount_price;
                array_push($AppliedDiscountArray,$discount_price);
                $updatedFee=array(
                    'total_discount'=>$feedetail->total_discount+$discount_price,
                    'discount_type'=>json_encode($DiscountTypeArray),
                    'applied_discounts'=>json_encode($AppliedDiscountArray),
                    'last_amount'=>($feedetail->last_amount-$feeAmount)+($discounted_fee)
                );
                $this->Shared_model->updateData("tbl_student_fee_detail", array('fee_detail_id' => $fee_detail_id), $updatedFee);

            }
            $array = array('status' => 'success', 'error' => '', 'message' => 'Fee Discount Applied Successfully');
            echo json_encode($array);
        }
    }

}

?>