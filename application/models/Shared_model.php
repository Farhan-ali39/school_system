<?php

/**
 * Created by PhpStorm.
 * User: HP
 * Date: 4/3/2020
 * Time: 4:26 PM
 */
class Shared_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
    /**
     * Function for inserting the data into data base
     * It returns true or false
     */
    public function insert($data=null,$tablename)
    {

        if($data) {
            $insertData = $this->db->insert($tablename, $data);
            $user_id = $this->db->insert_id();
            return ($insertData == true ) ? $user_id : false;
        }
    }
    /**
     * Function for selecting all the data from the   database
     * It returns an data array
     */
    public function selectAll($tableName)
    {
        $this->db->select('*');
        return $this->db->get($tableName)->result();
    }

    /**
     * Function for selecting the data from the database as a single row
     * It returns a single data array
     */
    public function selectDataWhereSingle($tableName,$whereArrayValues)
    {
        $this->db->select('*');
        $this->db->where($whereArrayValues);
        return $this->db->get($tableName)->row() ;
    }

    /**
     * Function for selecting the data from the database as a Multiples  rows
     * It returns a multiple data array
     */

    public function selectDataWhereMultiple($tableName,$whereArrayValues)
    {
        $this->db->select('*');
        $this->db->where($whereArrayValues);
        return $this->db->get($tableName)->result() ;
    }

    /**
     * Function for deleting the data from the database by using the where condition as single or multiple
     * It returns a true or false
     */
    public function deleteData($tableName,$whereArrayValues)
    {
        $this->db->where($whereArrayValues);
        return  $this->db->delete($tableName);
    }
    /**
     * Function for updating the data in the database as a single/multiple row by the where conditions
     * It returns a true or false
     */
    public function updateData($tableName,$whereArrayValues,$dataArray)
    {
        $this->db->set($dataArray);
        $this->db->where($whereArrayValues);
        $result=$this->db->update($tableName);
        return $result;
    }
    
    public function updateData2($current_session)
    {

        $this->db->select('tbl_student_fee_detail.fee_detail_id,tbl_student_fee_deposit.*');
        $this->db->join('tbl_student_fee_deposit', 'tbl_student_fee_detail.fee_detail_id = tbl_student_fee_deposit.std_fee_detail_id');
        $this->db->where('tbl_student_fee_detail.session_id ',$current_session);
        $query        = $this->db->get();
        $result_value = $query->result();
        return $result_value;
    }

    function do_email($from = '', $from_name = '', $to = '', $sub = '', $msg = '') {
        //echo $msg;exit;
        //$from = "ghiastalha31@gmail.com";
        //$config['validate'] = TRUE;
        //$result = false;

             $this->load->library('email');
            $this->email->set_mailtype("html");
            $this->email->set_newline("\r\n");
            $this->email->from($from, $from_name);
            $this->email->to($to);
            $this->email->subject($sub);
            $this->email->message($msg);
            //echo "idhr";exit;
             if ($this->email->send()) {
                 //echo "sent";exit;
                return true;
            } else {
                //echo "not sent";exit;
                //echo $this->email->print_debugger();
                return false;
            }

    }



}