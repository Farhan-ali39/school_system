<?php

/**
 * Created by PhpStorm.
 * User: HP
 * Date: 7/26/2020
 * Time: 3:10 PM
 */
class Onlineadmission extends CI_Controller
{
    function __construct() {
        parent::__construct();
         $this->load->model('Shared_model');
        $this->load->model('emailconfig_model');
        $this->mail_config = $this->emailconfig_model->getActiveEmail();
    }
    function index()
    {
        $class = $this->Shared_model->selectAll('classes');
        $data['classlist'] = $class;
        $this->load->view('admission_form',$data);
    }

    function saveData()
    {
        if(isset($_POST['save_data']))
        {
            $parentName=$this->input->post('parent_name');
            $email=$this->input->post('parent_email');
            $phoneNumber=$this->input->post('parent_contact');
            $class=$this->input->post('parent_contact');
             $dataArray=array(
                 'student_name'=>$this->input->post('std_name'),
                 'class_id'=>$this->input->post('online_class_id'),
                 'gender'=>$this->input->post('gender'),
                 'campus'=>$this->input->post('branch_name'),
                 'parent_name'=>$this->input->post('parent_name'),
                 'parent_contact'=>$this->input->post('parent_contact'),
                 'parent_email'=>$this->input->post('parent_email'),
                 'date'=>strtotime(date('d-M-Y h:i A' )),
             );
            $result = $this->Shared_model->insert($dataArray,"online_admissions_requests");
            $this->Shared_model->do_email($email, $parentName, $this->mail_config->smtp_username, 'Online Admission', $parentName.' has been applied for the admission. The contact number is '.$phoneNumber);
            if($result) {
                echo json_encode(array('status'=>true,'message'=>'Admission Form Submitted Successfully'));

            }
            else
            {
                echo json_encode(array('status'=>false,'message'=>'Something Went Wrong Please Try again'));

            }

        }else
        {
            echo json_encode(array('status'=>false,'message'=>'Something Went Wrong Please Try again'));
        }
    }

}