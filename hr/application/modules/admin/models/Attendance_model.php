<?php
class Attendance_model  extends CI_Model
{


    function __construct()
    {
        parent::__construct();
    }



    public function check_by($where, $tbl_name) {
        $this->db->select('*');
        $this->db->from($tbl_name);
        $this->db->where($where);
        $query_result = $this->db->get();
        $result = $query_result->row();
        return $result;
    }

    public function get_employee_id_by_dept_id($department_id) {
        $this->db->select('employee.*', FALSE);
        $this->db->select('job_title.job_title', FALSE);
        $this->db->select('department.department', FALSE);
        $this->db->from('employee');
        $this->db->join('job_title', 'job_title.id = employee.title', 'left');
        $this->db->join('department', 'department.id = employee.department', 'left');
        $this->db->where('employee.department', $department_id);
        $this->db->where('employee.termination', 1);
        $query_result = $this->db->get();
        $result = $query_result->result();


        return $result;
    }

    public function get_public_holidays($yymm) {
        $this->db->select('holidays.*', FALSE);
        $this->db->from('holidays');
        $this->db->like('start_date', $yymm);
        $query_result = $this->db->get();
        $result = $query_result->result();
        return $result;
    }




    public function attendance_report_by_empid($employee_id = null, $sdate = null, $flag = NULL) {

        $this->db->select('tbl_attendance.date,tbl_attendance.attendance_status', FALSE);
        $this->db->select('employee.first_name, employee.last_name ', FALSE);
        $this->db->from('tbl_attendance');
        $this->db->join('employee', 'tbl_attendance.employee_id  = employee.id', 'left');
        $this->db->where('tbl_attendance.employee_id', $employee_id);
        $this->db->where('tbl_attendance.date', $sdate);
        $query_result = $this->db->get();
        $result = $query_result->result();

        if (empty($result)) {
            $val['attendance_status'] = $flag;
            $val['date'] = $sdate;
            $result[] = (object) $val;
        } else {
            if ($result[0]->attendance_status == 0) {
                if ($flag == 'H') {
                    $result[0]->attendance_status = 'H';
                }
            }
        }


        return $result;
    }


}