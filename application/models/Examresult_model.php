<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Examresult_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->current_session = $this->setting_model->getCurrentSession();
    }

    /**
     * This funtion takes id as a parameter and will fetch the record.
     * If id is not provided, then it will fetch all the records form the table.
     * @param int $id
     * @return mixed
     */
    public function get($id = null) {
        $this->db->select()->from('exam_results');
        if ($id != null) {
            $this->db->where('id', $id);
        } else {
            $this->db->order_by('id');
        }
        $query = $this->db->get();
        if ($id != null) {
            return $query->row_array();
        } else {
            return $query->result_array();
        }
    }

    /**
     * This function will delete the record based on the id
     * @param $id
     */
    public function remove($id) {
        $this->db->where('id', $id);
        $this->db->delete('exam_results');
    }

    /**
     * This function will take the post data passed from the controller
     * If id is present, then it will do an update
     * else an insert. One function doing both add and edit.
     * @param $data
     */
    public function add($data) {
        if (isset($data['id'])) {
            $this->db->where('id', $data['id']);
            $this->db->update('exam_results', $data);
        } else {
            $this->db->insert('exam_results', $data);
            return $this->db->insert_id();
        }
    }

    public function add_exam_result($data,$school_id=null) {
        $this->db->where('exam_schedule_id', $data['exam_schedule_id']);
        $this->db->where('student_id', $data['student_id']);
        $q = $this->db->get('exam_results');
        $result = $q->row();
        if ($q->num_rows() > 0) {

            $this->db->where('id', $result->id);
            $this->db->update('exam_results', $data);
            if($school_id!=null)
            {
                if($school_id==1)
                {
                    if ($result->get_grades != $data['get_grades']) {
                        return $result->id;
                    }else
                    {
                        return $result->id;
                    }

                }elseif($school_id==2)
                {
                    if ($result->get_marks != $data['get_marks']) {
                        return $result->id;
                    }else
                    {
                        return $result->id;
                    }

                }

            }else{
                if ($result->get_marks != $data['get_marks']) {
                    return $result->id;
                }else
                {
                    return $result->id;
                }

            }

        } else {

            $this->db->insert('exam_results', $data);
            $insert_id = $this->db->insert_id();
            return $insert_id;
        }
        return false;
    }

    public function get_exam_result($exam_schedule_id = null, $student_id = null) {
        $this->db->select()->from('exam_results');
        $this->db->where('exam_schedule_id', $exam_schedule_id);
        $this->db->where('student_id', $student_id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            $obj = new stdClass();
            $obj->attendence = 'pre';
            $obj->get_marks = "0.00";
            return $obj;
        }
    }

    public function get_result($exam_schedule_id = null, $student_id = null) {
        $this->db->select()->from('exam_results');
        $this->db->where('exam_schedule_id', $exam_schedule_id);
        $this->db->where('student_id', $student_id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            
        }
    }

    public function checkexamresultpreparebyexam($exam_id, $class_id, $section_id) {
        $query = $this->db->query("SELECT count(*) `counter` FROM `exam_results`,exam_schedules,student_session WHERE exam_results.exam_schedule_id=exam_schedules.id and student_session.student_id=exam_results.student_id and student_session.class_id=" . $this->db->escape($class_id) . " and student_session.section_id=" . $this->db->escape($section_id) . " and exam_schedules.session_id=" . $this->db->escape($this->current_session) . " and exam_schedules.exam_id=" . $this->db->escape($exam_id));
        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
        return $query->result_array();
    }

    public function getStudentExamResultByStudent($exam_id, $student_id, $exam_schedule) {
        $sql = "SELECT exam_schedules.id as `exam_schedules_id`,exam_results.id as `exam_results_id`,exam_schedules.exam_id,exam_schedules.date_of_exam,exam_schedules.full_marks,exam_schedules.passing_marks,exam_results.student_id,exam_results.get_marks,students.firstname,students.lastname,students.guardian_phone,students.email ,exams.name as `exam_name` FROM `exam_schedules` INNER JOIN exams on exams.id=exam_schedules.exam_id INNER JOIN exam_results ON exam_results.exam_schedule_id=exam_schedules.id INNER JOIN students on students.id=exam_results.student_id WHERE exam_schedules.session_id =" . $this->db->escape($this->current_session) . " and exam_schedules.exam_id =" . $this->db->escape($exam_id) . " and exam_results.student_id =" . $this->db->escape($student_id) . " and exam_schedules.id in (" . $exam_schedule . ") ORDER BY `exam_results`.`id` ASC";

        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function getExamResults($exam_id, $post_exam_group_id, $students) {

        $result = array('exam_connection' => 0, 'students' => array(), 'exams' => array(), 'exam_connection_list' => array());
        $exam_connection = false;
        $exam_connections = $this->examgroup_model->getExamGroupConnectionList($post_exam_group_id);
        if (!empty($exam_connections)) {
            $lastkey = key(array_slice($exam_connections, -1, 1, true));
            if ($exam_connections[$lastkey]->exam_group_class_batch_exams_id == $exam_id) {
                $exam_connection = true;
                $result['exam_connection'] = 1;
            }
        }
        $result['exam_connection_list'] = $exam_connections;

        foreach ($students as $student_key => $student_value) {
            // print_r($students);
            $student = $this->examstudent_model->getStudentdetailByExam($student_value,$exam_id);
            $student['exam_result'] = array();
            if ($exam_connection) {
                foreach ($exam_connections as $exam_connection_key => $exam_connection_value) {
                    $exam_group_class_batch_exam_student = $this->examstudent_model->getStudentByExamAndStudentID($student_value, $exam_connection_value->exam_group_class_batch_exams_id);

                    $exam = $this->examgroup_model->getExamByID($exam_connection_value->exam_group_class_batch_exams_id);

                     $student['exam_result']['exam_roll_no_' . $exam_connection_value->exam_group_class_batch_exams_id]=$exam_group_class_batch_exam_student->roll_no;


                    $student['exam_result']['exam_result_' . $exam_connection_value->exam_group_class_batch_exams_id] = $this->getStudentResultByExam($exam_connection_value->exam_group_class_batch_exams_id, $exam_group_class_batch_exam_student->id);


                    $result['exams']['exam_' . $exam_connection_value->exam_group_class_batch_exams_id] = $exam;
                }
                $result['students'][] = $student;
            } else {
                $exam_group_class_batch_exam_student = $this->examstudent_model->getStudentByExamAndStudentID($student_value, $exam_id);
                $student['exam_roll_no'] = $exam_group_class_batch_exam_student->roll_no;
                $student['exam_result'] = $this->getStudentResultByExam($exam_id, $exam_group_class_batch_exam_student->id);
                $result['students'][] = $student;
            }
        }

        return $result;
    }

    public function getStudentResultByExam($exam_id, $student_id) {
        $sql = "SELECT exam_group_class_batch_exam_subjects.*,exam_group_exam_results.id as `exam_group_exam_results_id`,exam_group_exam_results.attendence,exam_group_exam_results.get_marks,exam_group_exam_results.note,subjects.name,subjects.code FROM `exam_group_class_batch_exam_subjects` inner JOIN exam_group_exam_results on exam_group_exam_results.exam_group_class_batch_exam_subject_id=exam_group_class_batch_exam_subjects.id INNER JOIN exam_group_class_batch_exam_students on exam_group_exam_results.exam_group_class_batch_exam_student_id=exam_group_class_batch_exam_students.id and exam_group_class_batch_exam_students.id=" . $this->db->escape($student_id) . " INNER JOIN subjects on subjects.id=exam_group_class_batch_exam_subjects.subject_id WHERE exam_group_class_batch_exam_subjects.exam_group_class_batch_exams_id=" . $this->db->escape($exam_id);
        $query = $this->db->query($sql);
        return $query->result();
    }

    public function getStudentExamResults($exam_id, $post_exam_group_id, $exam_group_class_batch_exam_student_id, $student_id) {

        $result = array('exam_connection' => 0, 'result' => array(), 'exams' => array(), 'exam_connection_list' => array());
        $exam_connection = false;
        $exam_connections = $this->examgroup_model->getExamGroupConnectionList($post_exam_group_id);
        if (!empty($exam_connections)) {
            $lastkey = key(array_slice($exam_connections, -1, 1, true));
            if ($exam_connections[$lastkey]->exam_group_class_batch_exams_id == $exam_id) {
                $exam_connection = true;
                $result['exam_connection'] = 1;
            }
        }
        $result['exam_connection_list'] = $exam_connections;
        if ($exam_connection) {
            $new_array = array();
            foreach ($exam_connections as $exam_connection_key => $exam_connection_value) {

                $exam_group_class_batch_exam_student = $this->examstudent_model->getStudentByExamAndStudentID($student_id, $exam_connection_value->exam_group_class_batch_exams_id);
                $exam = $this->examgroup_model->getExamByID($exam_connection_value->exam_group_class_batch_exams_id);
                $result['exam_result']['exam_result_' . $exam_connection_value->exam_group_class_batch_exams_id] = $this->getStudentResultByExam($exam_connection_value->exam_group_class_batch_exams_id, $exam_group_class_batch_exam_student->id);
                $result['exams']['exam_' . $exam_connection_value->exam_group_class_batch_exams_id] = $exam;
            }
//            $result['result'] = $new_array;
        } else {

            $result['exam_connection_list'] = $exam_connections;

            $result['result'] = $this->getStudentResultByExam($exam_id, $exam_group_class_batch_exam_student_id);
        }

        return $result;
    }
    public function add_exam_result_grade($grade_data)
    {
        $this->db->where('exam_result_id', $grade_data['exam_result_id']);
        $this->db->where('student_id', $grade_data['student_id']);
        $q = $this->db->get('exam_extra_grades');
        $result = $q->row();
        if ($q->num_rows() > 0) {

            $this->db->where('exam_extra_grade_id', $result->exam_extra_grade_id);
            $this->db->update('exam_extra_grades', $grade_data);
        } else {

            $this->db->insert('exam_extra_grades', $grade_data);
            $insert_id = $this->db->insert_id();
            return $insert_id;
        }

        return false;
    }
    public function getGrades($student_id,$result_id)
    {

        $this->db->where('exam_result_id', $result_id);
        $this->db->where('student_id',$student_id );
        $q = $this->db->get('exam_extra_grades');
        $result = $q->row();
        return $result;
    }
    public function add_student_remark($remarks_data)
    {
        $this->db->where('student_id', $remarks_data['student_id']);
        $this->db->where('exam_type', $remarks_data['exam_type']);
        $q = $this->db->get('student_remarks');
        $result = $q->row();
        if ($q->num_rows() > 0) {
            $this->db->where('remarks_id', $result->remarks_id);
            $this->db->update('student_remarks', $remarks_data);
        } else {
            $this->db->insert('student_remarks', $remarks_data);
            $insert_id = $this->db->insert_id();
            return $insert_id;
        }
        return false;
    }
    public function getRemarks($student_id,$exam_id=null)
    {
        if($exam_id!=null)
        {
            $this->db->where('exam_type', $exam_id);
        }
        $this->db->where('student_id', $student_id);
        $q = $this->db->get('student_remarks');
        $result = $q->row();
        return $result;
    }
    public function getExamType($examID)
    {
        $this->db->where('id', $examID);
        $q = $this->db->get('exams');
        $result = $q->row();
        return $result;
    }
    public function addMidTermGrade($grade_data)
    {

        $this->db->where('student_id', $grade_data['student_id']);
        $q = $this->db->get('mid_term_extra_grade');
        $result = $q->row();
        if ($q->num_rows() > 0) {
            $this->db->where('grade_id', $result->grade_id);
            $this->db->update('mid_term_extra_grade', $grade_data);
        } else {
            $this->db->insert('mid_term_extra_grade', $grade_data);
            $insert_id = $this->db->insert_id();
            return $insert_id;
        }
        return false;
    }
    public function getMidTermExtrsGrades($student_id)
    {
        $this->db->where('student_id', $student_id);
        $q = $this->db->get('mid_term_extra_grade');
        $result = $q->row();
        return $result;
    }
    public function genrateSinglereport($exam_sec_id, $student_id)
    {
        $this->db->select('exam_results.*,exam_results.id AS exam_result_id ,exam_schedules.*,teacher_subjects.*,subjects.*,students.*,class_sections.*,classes.*');
        $this->db->from('exam_results');
        $this->db->join('exam_schedules', 'exam_schedules.id =exam_results.exam_schedule_id');
        $this->db->join('teacher_subjects', 'exam_schedules.teacher_subject_id =teacher_subjects.id');
        $this->db->join('subjects', 'subjects.id =teacher_subjects.subject_id');
//        $this->db->join('exam_extra_grades', 'exam_extra_grades.exam_result_id ='.$this->db->escape($exam_sec_id));
        $this->db->join('class_sections', 'teacher_subjects.class_section_id =class_sections.id');
        $this->db->join('classes', 'classes.id =class_sections.class_id');
        $this->db->join('students', 'students.id ='.$this->db->escape($student_id));
        $this->db->where("exam_results.student_id",$student_id);
        $this->db->where_in("exam_results.exam_schedule_id",$exam_sec_id);
//        $this->db->where_in("exam_extra_grades.exam_result_id",$exam_sec_id);
        $result= $this->db->get()->result();

//        return $this->getAssessmentMarks($student_id);
//        die();

        return $result;
//        echo "<pre>";
//        var_dump($result);
//        die();
    }
    public function getAssessmentMarks($student_id)
    {
//        var_dump($student_id);
//        die();

        $where_array=array("1", "2",);


//        $this->db->select('exams.*,student_session.id AS student_session_id*,class_sections.id AS class_section_id,teacher_subjects.id AS teacher_subjects_id,exam_schedules.*');
//        $this->db->from('exams');
//        $this->db->join('student_session', 'student_session.student_id ='.$this->db->escape($student_id));
////        $this->db->join('class_sections', 'student_session.class_id =class_sections.class_id');
////        $this->db->join('class_sections', 'student_session.section_id =class_sections.section_id');
//        $this->db->join('class_sections', 'student_session.class_id =class_sections.class_id AND student_session.section_id =class_sections.section_id');
//        $this->db->join('teacher_subjects', 'class_sections.id =teacher_subjects.class_section_id');
//        $this->db->join('exam_schedules', 'teacher_subjects.id =exam_schedules.teacher_subject_id AND exams.id =exam_schedules.exam_id');
//
//        $this->db->where('exams.exam_type', 1);
//        $this->db->where_in('exams.type', $where_array);
//        $result = $this->db->get()->result();
////        print_r($this->db->last_query());
////        die();
//        return $result;


        $this->db->select('exams.*,exam_schedules.id AS exam_sec_id,exam_results.*');
        $this->db->from('exams');
        $this->db->join('exam_schedules', 'exam_schedules.exam_id =exams.id');
//        $this->db->join('class_sections', 'student_session.class_id =class_sections.class_id');
//        $this->db->join('class_sections', 'student_session.section_id =class_sections.section_id');
//        $this->db->join('class_sections', 'student_session.class_id =class_sections.class_id AND student_session.section_id =class_sections.section_id');
        $this->db->join('exam_results', 'exam_results.exam_schedule_id =exam_schedules.id AND exam_results.student_id ='.$this->db->escape($student_id));
//        $this->db->join('exam_schedules', 'teacher_subjects.id =exam_schedules.teacher_subject_id AND exams.id =exam_schedules.exam_id');

        $this->db->where('exams.exam_type', 1);
        $this->db->where_in('exams.type', $where_array);
        $result = $this->db->get()->result();
//        print_r($this->db->last_query());
//        die();
        return $result;


    }
}