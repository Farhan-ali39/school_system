<?php

/**
 * Created by PhpStorm.
 * User: HP
 * Date: 6/13/2020
 * Time: 9:17 AM
 */
class Classschedule_model  extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->current_session = $this->setting_model->getCurrentSession();
    }

    public function getClassScheduleByClassandSection($class=null,$section=null)
    {
        $this->db->select('tbl_class_schedule.*,classes.class,sections.section');
        $this->db->from("tbl_class_schedule");
        $this->db->join('classes','tbl_class_schedule.class_id=classes.id');
        $this->db->join('sections','tbl_class_schedule.section_id=sections.id');
        if($class!=null && $section!=null)
        {
            $this->db->where("tbl_class_schedule.class_id",$class);
            if($section!="all")
            {
                $this->db->where("tbl_class_schedule.section_id",$section);

            }

        }
        $query = $this->db->get();

        if($class!=null && $section!="all")
        {
            return $query->row_array();

        }else
        {
            return $query->result_array();
        }

    }
    public function ScheduleClass($data=null)
    {
        if($data!=null)
        {
            $exsits=$this->getClassScheduleByClassandSection($data['class_id'],$data['section_id']);
            if(!empty($exsits))
            {
                $this->db->set($data);
                $this->db->where("class_id",$data['class_id']);
                $this->db->where("section_id",$data['section_id']);
                $result=$this->db->update("tbl_class_schedule");
                return $result;
            }else
            {
                $insertData = $this->db->insert("tbl_class_schedule", $data);
                $user_id = $this->db->insert_id();
                return ($insertData == true ) ? $user_id : false;
            }

        }else{
            return false;
        }
    }
    public function add($data) {
        $this->db->insert('tbl_online_classes', $data);
        return $this->db->insert_id();
    }
    function count_all($st = NULL, $media_type = NULL,$classid=null,$sectionid=null) {
        $this->db->like('file_type', $media_type);
        $this->db->like('img_name', $st);
        $this->db->where("class_id",$classid);
        $this->db->where("section_id",$sectionid);
        $query = $this->db->get("tbl_online_classes");
        return $query->num_rows();
    }
    function fetch_details($limit, $start, $st = 'img', $media_type = NULL,$classid=null,$sectionid=null) {
        $output = '';
        $this->db->select("*");
        $this->db->like('img_name', $st);
        $this->db->like('file_type', $media_type);
        $this->db->where("class_id",$classid);
        $this->db->where("section_id",$sectionid);
        $this->db->from("tbl_online_classes");
        $this->db->order_by("id", "DESC");
        $this->db->limit($limit, $start);
        $query = $this->db->get();
        return $query->result();
    }

    function get($id=null)
    {
        $this->db->select("*");
        $this->db->from("tbl_online_classes");
        if($id!=null)
        {
            $this->db->where("id",$id);
        }
        $query = $this->db->get();
        if($id!=null)
        {
            return $query->row_array();
        }else
        {
            return $query->result_array();
        }

    }

    function getAllComments($id=null)
    {
        $this->db->select("*");
        $this->db->from("tbl_online_class_comments");
        if($id!=null)
        {
            $this->db->where("schedule_id",$id);
        }
        $query = $this->db->get();
        return $query->result();
    }

}