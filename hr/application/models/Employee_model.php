<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Employee_model extends MY_Model {


    public function get_public_holiday($start_date, $end_date) {
        $this->db->select('holidays.*', FALSE);
        $this->db->from('holidays');
        $this->db->where('start_date >=', $start_date);
        $this->db->where('end_date <=', $end_date);
        $query_result = $this->db->get();
        $result = $query_result->result();
        return $result;
    }

    public function get_total_attendance_by_date($start_date, $end_date, $employee_id) {
        $this->db->select('tbl_attendance.*', FALSE);
        $this->db->from('tbl_attendance');
        $this->db->where('employee_id', $employee_id);
        $this->db->where('date >=', $start_date);
        $this->db->where('date <=', $end_date);
        $this->db->where('attendance_status !=', 0);
        $query_result = $this->db->get();
        $result = $query_result->result();
        return $result;
    }

}