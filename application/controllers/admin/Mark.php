<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Mark extends Admin_Controller {

    function __construct() {
        parent::__construct();

        $this->load->library('smsgateway');
        $this->load->library('mailsmsconf');
        $this->load->model("classteacher_model");
        $this->load->model("Examresult_model");
        $this->load->model("Shared_model");
    }

    function index() {
       
//        $this->session->set_userdata('top_menu', 'Reports');
//        $this->session->set_userdata('sub_menu', 'Reports/examinations');
//        $this->session->set_userdata('subsub_menu', 'Reports/examinations/exam_marks_report');
        $this->session->set_userdata('top_menu', 'Examinations');
        $this->session->set_userdata('sub_menu', 'mark/index');
        $session = $this->setting_model->getCurrentSession();
        $data['title'] = 'Exam Marks';
        $data['exam_id'] = "";
        $data['class_id'] = "";
        $data['section_id'] = "";
        $exam = $this->exam_model->get();
        $class = $this->class_model->get(null,null,1);
        $data['examlist'] = $exam;
        $data['classlist'] = $class;
        $data['school_id']=1;
        $userdata = $this->customlib->getUserData();
        
        $feecategory = $this->feecategory_model->get();
        $data['feecategorylist'] = $feecategory;
        $this->form_validation->set_rules('exam_id', 'Exam', 'trim|required|xss_clean');
        $this->form_validation->set_rules('class_id', 'Class', 'trim|required|xss_clean');
        $this->form_validation->set_rules('section_id', 'Section', 'trim|required|xss_clean');
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('layout/header', $data);
            $this->load->view('admin/mark/markList', $data);
            $this->load->view('layout/footer', $data);
        } else {
            $feecategory_id = $this->input->post('feecategory_id');
            $exam_id = $this->input->post('exam_id');
            $class_id = $this->input->post('class_id');
            $section_id = $this->input->post('section_id');
            $school_id=$this->input->post('school_id');
            $class = $this->class_model->get(null,null,$school_id);
            $data['classlist'] = $class;
            $data['school_id']=$school_id;
            $data['exam_id'] = $exam_id;
            $data['class_id'] = $class_id;
            $data['section_id'] = $section_id;
            $examSchedule = $this->examschedule_model->getDetailbyClsandSection($class_id, $section_id, $exam_id);
            $studentList = $this->student_model->searchByClassSection($class_id, $section_id);
            $data['examSchedule'] = array();
            if (!empty($examSchedule)) {
                $new_array = array();
                $data['examSchedule']['status'] = "yes";
                foreach ($studentList as $stu_key => $stu_value) {
                    $array = array();
                    $array['student_id'] = $stu_value['id'];
                    $array['roll_no'] = $stu_value['roll_no'];
                    $array['firstname'] = $stu_value['firstname'];
                    $array['lastname'] = $stu_value['lastname'];
                    $array['admission_no'] = $stu_value['admission_no'];
                    $array['dob'] = $stu_value['dob'];
                    $array['father_name'] = $stu_value['father_name'];
                    $x = array();
                    foreach ($examSchedule as $ex_key => $ex_value) {
                        $exam_array = array();
                        $exam_array['exam_schedule_id'] = $ex_value['id'];
                        $exam_array['exam_id'] = $ex_value['exam_id'];
                        $exam_array['full_marks'] = $ex_value['full_marks'];
                        $exam_array['subject_id'] = $ex_value['subject_id'];
                        $exam_array['passing_marks'] = $ex_value['passing_marks'];
                        $exam_array['exam_name'] = $ex_value['name'];
                        $exam_array['exam_type'] = $ex_value['type'];
                        $student_exam_result = $this->examresult_model->get_result($ex_value['id'], $stu_value['id']);
                        // $exam_array['attendence'] = $student_exam_result->attendence;
                        // $exam_array['get_marks'] = $student_exam_result->get_marks;
                        // $exam_array['exam_result_id']=$student_exam_result->id;
                        if (empty($student_exam_result)) {
                             $exam_array['exam_result_id']=0;
                        } else {
                            $exam_array['attendence'] = $student_exam_result->attendence;
                            if ($school_id==1)
                            {
                                $exam_array['get_marks'] = $student_exam_result->get_grades;

                            }elseif($school_id==2)
                            {
                                $exam_array['get_marks'] = $student_exam_result->get_marks;

                            }
                            $exam_array['exam_result_id']=$student_exam_result->id;

                        }
                        $x[] = $exam_array;
                    }
                    if (empty($x)) {
                        $data['examSchedule']['status'] = "no";
                    }
                    $array['exam_array'] = $x;
                    $new_array[] = $array;
                }

                $data['examSchedule']['result'] = $new_array;
                
            } else {
                $s = array('status' => 'no');
                $data['examSchedule'] = $s;
            }

            $this->load->view('layout/header', $data);
            $this->load->view('admin/mark/markList', $data);
            $this->load->view('layout/footer', $data);
        }
    }

    function view($id) {
        if (!$this->rbac->hasPrivilege('marks_register', 'can_view')) {
            access_denied();
        }
        $data['title'] = 'Mark List';
        $mark = $this->mark_model->get($id);
        $data['mark'] = $mark;
        $this->load->view('layout/header', $data);
        $this->load->view('admin/mark/markShow', $data);
        $this->load->view('layout/footer', $data);
    }

    function delete($id) {
        $data['title'] = 'Mark List';
        $this->mark_model->remove($id);
        redirect('admin/mark/index');
    }
    
    function createtest()
    {
       echo "<pre>";
               var_dump($_POST);
               die();
    }

    function create() {
        
        $session = $this->setting_model->getCurrentSession();
        $data['title'] = 'Exam Schedule';
        $data['exam_id'] = "";
        $data['class_id'] = "";
        $data['section_id'] = "";
        $exam = $this->exam_model->get();
        $class = $this->class_model->get(null,null,1);
        $data['school_id']=1;
        $data['examlist'] = $exam;
        $data['classlist'] = $class;
        $userdata = $this->customlib->getUserData();
       
        $feecategory = $this->feecategory_model->get();
        $data['feecategorylist'] = $feecategory;
        $this->form_validation->set_rules('exam_id', 'Exam', 'trim|required|xss_clean');
        $this->form_validation->set_rules('class_id', 'Class', 'trim|required|xss_clean');
        $this->form_validation->set_rules('section_id', 'Section', 'trim|required|xss_clean');
        if ($this->form_validation->run() == FALSE) {
           
            $this->load->view('layout/header', $data);
            $this->load->view('admin/mark/markCreate', $data);
            $this->load->view('layout/footer', $data);
        } else {
             
            $feecategory_id = $this->input->post('feecategory_id');
            $exam_id = $this->input->post('exam_id');
            $class_id = $this->input->post('class_id');
            $section_id = $this->input->post('section_id');
            $school_id=$this->input->post('school_id');
            $data['school_id']=$school_id;
            $data['exam_id'] = $exam_id;
            $data['class_id'] = $class_id;
            $data['section_id'] = $section_id;
            $class = $this->class_model->get(null,null,$school_id);
            $data['classlist'] = $class;
            $userdata = $this->customlib->getUserData();
            $getTeacherSubjects = array();
            if (($userdata["role_id"] == 2) && ($userdata["class_teacher"] == "yes")) {
                $getTeacherSubjects = $this->examschedule_model->getTeacherSubjects($class_id, $section_id, $userdata["id"]);
            }
            $data["teacher_subjects"] = $getTeacherSubjects;
            $examSchedule = $this->examschedule_model->getDetailbyClsandSection($class_id, $section_id, $exam_id);

            $studentList = $this->student_model->searchByClassSection($class_id, $section_id);

            if (!empty($examSchedule)) {
                $new_array = array();
                foreach ($studentList as $stu_key => $stu_value) {
                    $array = array();
                    $array['student_id'] = $stu_value['id'];
                    $array['admission_no'] = $stu_value['admission_no'];
                    $array['roll_no'] = $stu_value['roll_no'];
                    $array['firstname'] = $stu_value['firstname'];
                    $array['lastname'] = $stu_value['lastname'];
                    $array['dob'] = $stu_value['dob'];
                    $array['father_name'] = $stu_value['father_name'];
                    $x = array();
                    foreach ($examSchedule as $ex_key => $ex_value) {
                        $exam_array = array();
                        $exam_array['exam_schedule_id'] = $ex_value['id'];
                        $exam_array['exam_id'] = $ex_value['exam_id'];
                        $exam_array['subject_id'] = $ex_value['subject_id'];
                        $exam_array['full_marks'] = $ex_value['full_marks'];
                        $exam_array['passing_marks'] = $ex_value['passing_marks'];
                        $exam_array['exam_name'] = $ex_value['name'];
                        $exam_array['exam_type'] = $ex_value['type'];
                        $student_exam_result = $this->examresult_model->get_exam_result($ex_value['id'], $stu_value['id']);
                        
                       if (empty($student_exam_result)) {
                            $exam_array['exam_result_id']=0;
                            
                        } else {
                            $exam_array['attendence'] = $student_exam_result->attendence;
                           if ($school_id==1)
                           {
                               $exam_array['get_marks'] = $student_exam_result->get_grades;

                           }elseif($school_id==2)
                           {
                               $exam_array['get_marks'] = $student_exam_result->get_marks;

                           }
                            if(isset($student_exam_result->id)){
                                 $exam_array['exam_result_id']=$student_exam_result->id;
                            }else
                            {
                                $exam_array['exam_result_id']=0;
                            }
                           

                        }
                        $x[] = $exam_array;
                    }
                    $array['exam_array'] = $x;
                    $new_array[] = $array;
                }
                $data['examSchedule'] = $new_array;
            }
             
            if ($this->input->post('save_exam_btn') == "save_exam") {
                // $max_input_vars = ini_get('max_input_vars');
        // echo $max_input_vars;
            //     echo "/<pre>";
            //   print_r($_POST);
            //     die();

                $school_id=$this->input->post('school_id');
                $ex_array = array();
                $exam_id = $this->input->post('exam_id');
                $student_array = $this->input->post('student');
                $exam_array = $this->input->post('exam_schedule');
                foreach ($student_array as $key => $student) {
                    foreach ($exam_array as $key => $exam) {

                        if ($school_id==1)
                        {
                            $record['get_grades'] = "";

                        }elseif($school_id==2)
                        {
                            $record['get_marks'] = 0;
                        }
                        $record['attendence'] = "pre";
                        if ($this->input->post('student_absent' . $student . "_" . $exam) == "") {
                            if ($school_id==1)
                            {
                                 $record['get_grades'] = $this->input->post('student_number' . $student . "_" . $exam);


                            }elseif($school_id==2)
                            {
                                $record['get_marks'] = $this->input->post('student_number' . $student . "_" . $exam);

                            }
                        } else {
                            $record['attendence'] = $this->input->post('student_absent' . $student . "_" . $exam);
                        }
                        
//                         echo $school_id."<br>";
                        
                        $record['exam_schedule_id'] = $exam;
                        $record['student_id'] = $student;
                        $inserted_id = $this->examresult_model->add_exam_result($record,$school_id);


// 
//                         $inserted_id=false;
                        if ($inserted_id) {

                            if(isset($_POST['class_work' . $student . "_" . $exam]))
                            {

                                $class_work = $this->input->post('class_work' . $student . "_" . $exam);
                                $home_work = $this->input->post('home_work' . $student . "_" . $exam);
                                $behaviour = $this->input->post('behaviour' . $student . "_" . $exam);

                                $grade_data=array(
                                    'exam_result_id'=>$inserted_id,
                                    'student_id'=>$student,
                                    'class_work'=>$class_work,
                                    'home_work'=>$home_work,
                                    'behaviour'=>$behaviour,
                                );
//                                print_r($grade_data);
                                $this->examresult_model->add_exam_result_grade($grade_data);
                            }
//                            echo "here";

                            $ex_array[$student] = $exam_id;
                        }
                    }
                    if ($this->input->post('remarks_'.$student) != "") {

                        $remarks = $this->input->post('remarks_'.$student);
                        $remarks_data=array(
                            'student_id'=>$student,
                            'remarks'=>$remarks,
                            'exam_type'=>$exam_id,
                        );
                        $this->examresult_model->add_student_remark($remarks_data);


                    }
               


//                echo "<pre>";
//                var_dump($record);
//                die();

//                die();
                // echo $student;
                if(isset($_POST['PUNCTUALITY'.$student]))
                {

                    $PUNCTUALITY = $this->input->post('PUNCTUALITY'.$student);
                    $Art = $this->input->post('Art'.$student);
                    $ATTENDANCE = $this->input->post('ATTENDANCE'.$student);
                    $CLASS_WORK = $this->input->post('CLASS_WORK'.$student);
                    $Home_work = $this->input->post('Home_work'.$student);
                    $GAME = $this->input->post('GAME'.$student);
                    $CONDUCT = $this->input->post('CONDUCT'.$student);
                    $PRESENTATION = $this->input->post('PRESENTATION'.$student);
                    $grade_data=array(
                        'student_id'=>$student,
                        'PUNCTUALITY'=>$PUNCTUALITY,
                        'Art'=>$Art,
                        'ATTENDANCE'=>$ATTENDANCE,
                        'CLASS_WORK'=>$CLASS_WORK,
                        'Home_work'=>$Home_work,
                        'GAME'=>$GAME,
                        'CONDUCT'=>$CONDUCT,
                        'PRESENTATION'=>$PRESENTATION,
                    );

                    // echo "<pre>";
                    // var_dump($grade_data);
                    $this->examresult_model->addMidTermGrade($grade_data);
                }
 }

                if (!empty($ex_array)) {
                    $this->mailsmsconf->mailsms('exam_result', $ex_array, NULL, $exam_array);
                }
                               $message='Marks of all the students have been added successfully';
                $this->session->set_flashdata('msg', '<div class="alert alert-success">' . $message . '</div>');

                // die();

                redirect('admin/mark');
            }

            $this->load->view('layout/header', $data);
            $this->load->view('admin/mark/markCreate', $data);
            $this->load->view('layout/footer', $data);
        }
    }

    function edit($id) {
        if (!$this->rbac->hasPrivilege('marks_register', 'can_edit')) {
            access_denied();
        }
        $data['title'] = 'Edit Mark';
        $data['id'] = $id;
        $mark = $this->mark_model->get($id);
        $data['mark'] = $mark;
        $this->form_validation->set_rules('name', 'Mark', 'trim|required|xss_clean');
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('layout/header', $data);
            $this->load->view('admin/mark/markEdit', $data);
            $this->load->view('layout/footer', $data);
        } else {
            $data = array(
                'id' => $id,
                'name' => $this->input->post('name'),
                'note' => $this->input->post('note'),
            );
            $this->mark_model->add($data);
            $this->session->set_flashdata('msg', '<div mark="alert alert-success text-center">Employee details added to Database!!!</div>');
            redirect('admin/mark/index');
        }
    }
    function get_school_classes()
    {
        $school_id= $this->input->post('school_id');
        $classes = $this->class_model->get(null,null,$school_id);
        echo "<option>Select</option>";
        foreach ($classes as  $class)
        {
//            echo $class['id'];
            echo '<option value="'.$class['id'].'" >'.$class['class'].'</option>';
//             array_push($class_option,'<option value="'.$class->id.'" >'.$class->class.'</option>')  ;

        }
    }
    function getSubjectExtras()
    {
        $subject_id= $this->input->post('subject_id');
        $student_id= $this->input->post('student_id');



        $subject_extras = $this->class_model->getSubjectExtras($subject_id);

        $subject_extras_data=json_decode($subject_extras,true);
        $count=1;
        $extra_data="";
        $subject_extras_grades = $this->class_model->getSubjectExtragrades($subject_id,$student_id);

        $counter=0;
//         var_dump($subject_extras_data);
//           echo $encoded_data[$counter] == "A" ? "selected" : " ";
//         die();
        if(!empty($subject_extras_data))
        {

            if(!empty($subject_extras_grades->extra_grades)&&$subject_extras_grades->extra_grades!="null" )
            {
                $encoded_data= json_decode($subject_extras_grades->extra_grades);
                foreach ($subject_extras_data as $extras_datum)
                {
                    $extra_data.= "
                    <div class='col-md-3' style='height: 100px;'>
                    <label>".strtoupper($extras_datum)."</label>
                    <select class='form-control  extra_grade_disable' name='extra_grade_".$count."'>";
                    if($encoded_data[$counter]=="A")
                    {  $extra_data.= "<option value='A' selected>A</option><option value='B'>B</option> <option value='C'>C</option><option value='D'>D</option>"; }
                    elseif($encoded_data[$counter]=="B")
                    {  $extra_data.= "<option value='A'>A</option> <option value='B' selected>B</option><option value='C'>C</option><option value='D'>D</option> ";  }
                    elseif($encoded_data[$counter]=="C")
                    {  $extra_data.= "<option value='A'>A</option><option value='B'>B</option><option value='C' selected>C</option> <option value='D'>D</option>";  }
                    elseif($encoded_data[$counter]=="D")
                    {  $extra_data.= "<option value='A'>A</option><option value='B'>B</option><option value='C'>C</option><option value='D' selected>D</option>  ";  }
                    $extra_data.= "     
                </select>
                </div>";
                    $counter++;
                    $count++;
                }
            }
            else{
                foreach ($subject_extras_data as $extras_datum)
                {


                    $extra_data.= "
                    <div class='col-md-3' style='height: 100px;'>
                    <label>".strtoupper($extras_datum)."</label>
                    <select class='form-control' name='extra_grade_".$count."'>
                   <option value='A'>A</option>
                   <option value='B'>B</option>
                  <option value='C'>C</option>
                   <option value='D'>D</option>
                </select>
                </div>";
                    $count++;
                }
            }

        }
        else
        {
            $extra_data.='
            <div style="margin-left: 37%;"> <h3> No Extra Found </h3></div>
            ';
        }


        $count=$count-1;
        $extra_data.="<input type='hidden' name='total_count' value='".$count."'> ";
        $extra_data.="<input type='hidden' name='subject_id' value='".$subject_id."'> ";
        $extra_data.="<input type='hidden' name='student_id' value='".$student_id."'> ";

        echo $extra_data;
    }
    function addSubjectExtras()
    {
        for ($i=1;$i<=$_POST['total_count'];$i++)
        {
            $grades[]=$this->input->post('extra_grade_'.$i);
        }
        $grade_data=array(
            'student_id'=>$this->input->post('student_id'),
            'subject_id'=>$this->input->post('subject_id'),
            'extra_grades'=>json_encode($grades),

        );
        $this->class_model->addSubjectExtras($grade_data,$this->input->post('subject_id'),$this->input->post('student_id'));
    }

    function reports()
    {
        $this->session->set_userdata('top_menu', 'Examinations');
        $this->session->set_userdata('sub_menu', 'report/index');
        $session = $this->setting_model->getCurrentSession();
        $data['title'] = 'Exam Marks Reports';
        $data['exam_id'] = "";
        $data['class_id'] = "";
        $data['section_id'] = "";
        $exam = $this->exam_model->get();
        $class = $this->class_model->get(null,null,1);
        $data['examlist'] = $exam;
        $data['classlist'] = $class;
        $data['school_id']=0;
        $userdata = $this->customlib->getUserData();
        //   if(($userdata["role_id"] == 2) && ($userdata["class_teacher"] == "yes")){
        // $data["classlist"] =   $this->customlib->getClassbyteacher($userdata["id"]);
        //     }
        $feecategory = $this->feecategory_model->get();
        $data['feecategorylist'] = $feecategory;
        $this->form_validation->set_rules('exam_id', 'Exam', 'trim|required|xss_clean');
        $this->form_validation->set_rules('class_id', 'Class', 'trim|required|xss_clean');
        $this->form_validation->set_rules('section_id', 'Section', 'trim|required|xss_clean');
        if ($this->form_validation->run() == FALSE) {

            $this->load->view('layout/header', $data);
            $this->load->view('admin/mark/reports');
            $this->load->view('layout/footer', $data);
        }
        else {

            $feecategory_id = $this->input->post('feecategory_id');
            $exam_id = $this->input->post('exam_id');
            $class_id = $this->input->post('class_id');
            $section_id = $this->input->post('section_id');
            $school_id=$this->input->post('school_id');
            $class = $this->class_model->get(null,null,$school_id);

            $data['classlist'] = $class;

            $data['school_id']=$school_id;
            $data['exam_id'] = $exam_id;
            $data['class_id'] = $class_id;
            $data['section_id'] = $section_id;
            $exam_type=$this->Examresult_model->getExamType($exam_id);
            $data['Type'] = $exam_type->type;
            $examSchedule = $this->examschedule_model->getDetailbyClsandSection($class_id, $section_id, $exam_id);
            $studentList = $this->student_model->searchByClassSection($class_id, $section_id);
            $data['examSchedule'] = array();
            if (!empty($examSchedule)) {
                $new_array = array();
                $data['examSchedule']['status'] = "yes";
                foreach ($studentList as $stu_key => $stu_value) {
                    $array = array();
                    $array['student_id'] = $stu_value['id'];
                    $array['roll_no'] = $stu_value['roll_no'];
                    $array['firstname'] = $stu_value['firstname'];
                    $array['lastname'] = $stu_value['lastname'];
                    $array['admission_no'] = $stu_value['admission_no'];
                    $array['dob'] = $stu_value['dob'];
                    $array['father_name'] = $stu_value['father_name'];
                    $x = array();
                    foreach ($examSchedule as $ex_key => $ex_value) {
                        $exam_array = array();
                        $exam_array['exam_schedule_id'] = $ex_value['id'];
                        $exam_array['exam_id'] = $ex_value['exam_id'];
                        $exam_array['subject_id'] = $ex_value['subject_id'];
                        $exam_array['full_marks'] = $ex_value['full_marks'];
                        $exam_array['passing_marks'] = $ex_value['passing_marks'];
                        $exam_array['exam_name'] = $ex_value['name'];
                        $exam_array['exam_type'] = $ex_value['type'];
                        $student_exam_result = $this->examresult_model->get_result($ex_value['id'], $stu_value['id']);
//                        var_dump($student_exam_result);
//                        die();
                        $exam_array['attendence'] = $student_exam_result->attendence;
                         if ($school_id==1)
                            {
                                $exam_array['get_marks'] = $student_exam_result->get_grades;

                            }elseif($school_id==2)
                            {
                                $exam_array['get_marks'] = $student_exam_result->get_marks;

                            }
                        $exam_array['exam_result_id']=$student_exam_result->id;
                        if (empty($student_exam_result)) {

                        } else {
                            $exam_array['attendence'] = $student_exam_result->attendence;
                             if ($school_id==1)
                            {
                                $exam_array['get_marks'] = $student_exam_result->get_grades;

                            }elseif($school_id==2)
                            {
                                $exam_array['get_marks'] = $student_exam_result->get_marks;

                            }
                            $exam_array['exam_result_id']=$student_exam_result->id;
                        }
                        $x[] = $exam_array;
                    }
                    if (empty($x)) {
                        $data['examSchedule']['status'] = "no";
                    }
                    $array['exam_array'] = $x;
                    $new_array[] = $array;
                    if($exam_type->type==3)
                    {
                        $this->db->select("*");
                        $this->db->where('type', 1);
                        $q = $this->db->get('exams');
                        $first = $q->row();
                        if(!empty($first))
                        {
                            $first_data[$stu_value['id']]=$this->getAssessmentData($class_id, $section_id, $first->id);
                        }



                        $this->db->select("*");
                        $this->db->where('type', 2);
                        $q = $this->db->get('exams');
                        $second = $q->row();
                        if(!empty($second))
                        {
                            $second_data[$stu_value['id']]=$this->getAssessmentData($class_id, $section_id, $second->id);
                        }


                    }
                    if($exam_type->type==6)
                    {
                        $this->db->select("*");
                        $this->db->where('type', 4);
                        $q = $this->db->get('exams');
                        $first = $q->row();
                        $first_data[$stu_value['id']]=$this->getAssessmentData($class_id, $section_id, $first->id);

                        $this->db->select("*");
                        $this->db->where('type', 5);
                        $q = $this->db->get('exams');
                        $second = $q->row();
                        $second_data[$stu_value['id']]=$this->getAssessmentData($class_id, $section_id, $second->id);
                    }
                }
                if(isset($first_data) || isset($second_data))
                {
                    $data['first_assessment_marks']=$first_data;
                    $data['second_assessment_marks']=$second_data;

                }
                $data['examSchedule']['result'] = $new_array;


            }
            else {
                $s = array('status' => 'no');
                $data['examSchedule'] = $s;
            }
            $this->load->view('layout/header', $data);
            $this->load->view('admin/mark/reports');
            $this->load->view('layout/footer', $data);
        }


    }
    function getAssessmentData($class_id, $section_id, $exam_id)
    {
        $examSchedule = $this->examschedule_model->getDetailbyClsandSection($class_id, $section_id, $exam_id);
        $studentList = $this->student_model->searchByClassSection($class_id, $section_id);
        $data['examSchedule'] = array();
        if (!empty($examSchedule)) {
            $new_array = array();
            $data['examSchedule']['status'] = "yes";
            foreach ($studentList as $stu_key => $stu_value) {
                $array = array();
                $array['student_id'] = $stu_value['id'];
                $array['roll_no'] = $stu_value['roll_no'];
                $array['firstname'] = $stu_value['firstname'];
                $array['lastname'] = $stu_value['lastname'];
                $array['admission_no'] = $stu_value['admission_no'];
                $array['dob'] = $stu_value['dob'];
                $array['father_name'] = $stu_value['father_name'];
                $x = array();
                foreach ($examSchedule as $ex_key => $ex_value) {
                    $exam_array = array();
                    $exam_array['exam_schedule_id'] = $ex_value['id'];
                    $exam_array['exam_id'] = $ex_value['exam_id'];
                    $exam_array['full_marks'] = $ex_value['full_marks'];
                    $exam_array['passing_marks'] = $ex_value['passing_marks'];
                    $exam_array['exam_name'] = $ex_value['name'];
                    $exam_array['exam_type'] = $ex_value['type'];
                    $student_exam_result = $this->examresult_model->get_result($ex_value['id'], $stu_value['id']);
//                        var_dump($student_exam_result);
//                        die();
                    $exam_array['attendence'] = $student_exam_result->attendence;
                    $exam_array['get_marks'] = $student_exam_result->get_marks;
                    $exam_array['exam_result_id']=$student_exam_result->id;
                    if (empty($student_exam_result)) {

                    } else {
                        $exam_array['attendence'] = $student_exam_result->attendence;
                        $exam_array['get_marks'] = $student_exam_result->get_marks;
                        $exam_array['exam_result_id']=$student_exam_result->id;
                    }
                    $x[] = $exam_array;
                }
                $array['exam_array'] = $x;
                $new_array[] = $array;
            }

            return $new_array;




        }

    }
    function genrateSinglereport($student_id=null)
    {
//        var_dump( $main_exam_id=$this->input->post('id') );
//        die();
        if(isset($_POST['print_all']) && $_POST['print_all']=='all' )
        {


            $data['exam_sec_id']=$this->input->post('id');


//            $student_id=$this->input->post('current_std_id');
            $student_ids=$this->input->post('student');
            $Type=$this->input->post('examType');
            $school_id=$this->input->post('school_id');
            $exam_type=$this->input->post('exam_type');
            $main_exam_id=$this->input->post('exam_id');

            if($school_id==2  ) {
                if ($Type == 3 || $Type == 6) {
                    foreach (array_unique($student_ids) as $id)
                    {
                        $second_marks[$id] =$this->input->post('second_marks_'.$id);
                        $first_marks[$id] =$this->input->post('first_marks_'.$id);

                    }
                    $data['second_marks']=$second_marks;
                    $data['first_marks']=$first_marks;
                    $data['first_total_marks']=$this->input->post('firstAssessment');
                    $data['second_total_marks']=$this->input->post('secondAssessment');
                }
            }



//            $school_id=$this->input->post('school_id');
            if($school_id==1 && $exam_type==1)
            {

            }elseif($school_id==1 && $exam_type==2)
            {

            }elseif ($school_id==2 && $exam_type==1)
            {

            }elseif ($school_id==2 && $exam_type==2)
            {

            }
            $this->db->select('*');
            // $this->db->where('exam_type',$exam_type);
            $this->db->where('id',$main_exam_id);
            $exam_id= $this->db->get('exams')->row();
            $data['examData']=$exam_id;
//            $remarks=$this->Examresult_model->getRemarks($student_id,$exam_id->id);
//            $data['remarks']=$remarks->remarks;

            $data['school_id']=$school_id;
//        $data['school_id']=2;
            $data['examType']=$exam_type;
            $data['main_exam_id']=$main_exam_id;

            $data['student_ids']=array_unique($student_ids);

//            $data['student_exam_result'] = $this->examresult_model->genrateSinglereport($exam_sec_id, $student_id);
//            $data['student_assesment_data']=$this->examresult_model->getAssessmentMarks($student_id);

//        echo "<pre>";
//        $first_assesment_marks=0;
//        $second_assesment_marks=0;
//        foreach ($data['student_exam_result'] as $datum)
//        {
////            var_dump($datum);
////            die();
//            if($datum->exam_type==1)
//            {
//                if($datum->type==1)
//                {
//                    $first_assesment_marks+= $datum->get_marks;
//                }
//            }
//            if ($datum->exam_type==1)
//            {
//                if($datum->type==2)
//                {
//                    $second_assesment_marks+=$datum->get_marks;
//                }
//            }
//        }
//        var_dump(($second_assesment_marks+$first_assesment_marks));
//        die();
//                var_dump($data['student_exam_result']);
//        print_r(array_filter((array)$data['student_exam_result'],"array_filter"));
//        die();
//        $this->load->view('layout/header');
            $this->load->view('admin/mark/all_report_card', $data);
//        $this->load->view('layout/footer', $data);

        }
        else{
            $exam_sec_id=$this->input->post('id');


            $student_id=$this->input->post('current_std_id');
            $data['second_marks'] =$this->input->post('second_marks_'.$student_id);
            $data['first_marks'] =$this->input->post('first_marks_'.$student_id);
            $main_exam_id=$this->input->post('exam_id');
            $exam_type=$this->input->post('exam_type');
            $school_id=$this->input->post('school_id');
            if($school_id==1 && $exam_type==1)
            {

            }elseif($school_id==1 && $exam_type==2)
            {

            }elseif ($school_id==2 && $exam_type==1)
            {

            }elseif ($school_id==2 && $exam_type==2)
            {

            }
//            $this->db->select('*');
//            $this->db->where('exam_type',$exam_type);
//            $exam_id= $this->db->get('exams')->row();
//            $data['examData']=$exam_id;
//            var_dump($exam_id);
//            die();
            $remarks=$this->Examresult_model->getRemarks($student_id,$main_exam_id);
            $data['remarks']=$remarks->remarks;

            $data['school_id']=$school_id;
//        $data['school_id']=2;
            $data['examType']=$exam_type;
//        $data['examType']=1;

            $data['student_id']=$student_id;

            $data['student_exam_result'] = $this->examresult_model->genrateSinglereport($exam_sec_id, $student_id);
            $data['student_assesment_data']=$this->examresult_model->getAssessmentMarks($student_id);

//        echo "<pre>";
//        $first_assesment_marks=0;
//        $second_assesment_marks=0;
//        foreach ($data['student_exam_result'] as $datum)
//        {
////            var_dump($datum);
////            die();
//            if($datum->exam_type==1)
//            {
//                if($datum->type==1)
//                {
//                    $first_assesment_marks+= $datum->get_marks;
//                }
//            }
//            if ($datum->exam_type==1)
//            {
//                if($datum->type==2)
//                {
//                    $second_assesment_marks+=$datum->get_marks;
//                }
//            }
//        }
//        var_dump(($second_assesment_marks+$first_assesment_marks));
//        die();
//                var_dump($data['student_exam_result']);
//        print_r(array_filter((array)$data['student_exam_result'],"array_filter"));
//        die();
//        $this->load->view('layout/header');
            $this->load->view('admin/mark/report_card', $data);
//        $this->load->view('layout/footer', $data);

        }



    }


}

?>