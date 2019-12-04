<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Payroll extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_builder');
        $this->load->model('settings_model');
        $this->load->model('global_model');
        $this->mTitle = TITLE;
    }

    function payrollList()
    {
        echo 'hi';
    }

    function employee()
    {
        $this->mTitle .= lang('make_payment');
        $this->mViewData['department'] = $this->db->get('department')->result();
        $this->render('payroll/select_employee');
    }

    function setEmployeePayment()
    {
        $this->form_validation->set_rules('department_id', lang('department'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('employee_id', lang('employee'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('month', lang('month'), 'trim|required|xss_clean');

        if ($this->form_validation->run() == TRUE) {

            $this->mTitle .= lang('make_payment');
            $this->mViewData['department']  = $this->db->get_where('department', array('id' => $this->input->post('department_id')))->row();
            $this->mViewData['employee']    = $this->db->get_where('employee', array('id' => $this->input->post('employee_id')))->row();
            $this->mViewData['employee']    =  $this->db->select('employee .*, job_title.job_title, emp_status.status_name ')
                                                ->from('employee')
                                                ->join('job_title', 'job_title.id = employee.title', 'left')
                                                ->join('emp_status', 'emp_status.id = employee.employment_status', 'left')
                                                ->where('employee.id', $this->input->post('employee_id'))
                                                ->get()->row();



            $this->mViewData['month']       = $this->input->post('month');
            $this->mViewData['salary']      = $this->db->get_where('salary', array('employee_id' => $this->input->post('employee_id')))->row();

            $this->mViewData['salary'] == TRUE || $this->message->custom_error_msg('admin/payroll/employee','Sorry! This Employee salary has not set yet.');
            $this->mViewData['award']       = $this->db->get_where('employee_award', array(
                                                'award_month' => $this->input->post('month'),
                                                'employee_id' =>$this->input->post('employee_id')
                                                ))->result();

            $this->mViewData['payroll']     = $this->db->get_where('payroll', array(
                                                    'department_id' => $this->input->post('department_id'),
                                                    'month' =>$this->input->post('month')
                                                ))->row();



            $this->render('payroll/make_payment');

        } else {
            $error = validation_errors();
            $this->message->custom_error_msg('admin/payroll/employee',$error);
        }
    }

    public function savePayroll()
    {
        $this->form_validation->set_rules('payment_method', lang('payment_method'), 'trim|required|xss_clean');


        if ($this->form_validation->run() == TRUE) {

            $id = $this->encrypt->decode(str_replace(array('-', '_', '~'), array('+', '/', '='), $this->input->post('employee_id', TRUE)));
            $month = $this->encrypt->decode(str_replace(array('-', '_', '~'), array('+', '/', '='), $this->input->post('month', TRUE)));



            //check duplicate payroll
            $payroll_id = $this->db->get_where('payroll', array(
                'employee_id' => $id,
                'month' => $month
            ))->row()->id;

            //salary
            $salary = $this->db->get_where('salary', array('employee_id' => $id))->row();
            //award
            $award  = $this->db->get_where('employee_award', array(
                            'award_month' => $month,
                            'employee_id' =>$id
                        ))->result();
            //employee
            $employee = $this->db->get_where('employee', array('id' => $id))->row();


            $data['employee_id']    = $id;
            $data['department_id']  = $employee->department;
            $data['gross_salary']   = $salary->total_payable + $salary->total_deduction;
            $data['deduction']      = $salary->total_deduction;
            $data['net_salary']     = $salary->total_payable;

            $total_payable = $salary->total_payable;

            if(!empty($award)){
                $employee_award = array();
                foreach($award as $item){
                    if(!empty($item->award_amount)) {
                        $employee_award[] = array(
                            'award_name' => $item->award_name,
                            'award_amount' => $item->award_amount,
                        );
                        $total_payable += $item->award_amount;
                    }
                }

                $data['award'] = json_encode($employee_award);
            }

            //fine deduction
            if(!empty($this->input->post('fine_deduction', TRUE))){
                $data['fine_deduction'] = $this->input->post('fine_deduction', TRUE);
                $total_payable -= $data['fine_deduction'];
            }

            //add bonus
            if(!empty($this->input->post('bonus', TRUE))){
                $data['bonus'] = $this->input->post('bonus', TRUE);
                $total_payable += $data['bonus'];
            }

            $data['net_payment'] = $total_payable;
            $data['payment_method'] = $this->input->post('payment_method', TRUE);
            $data['note'] = $this->input->post('note', TRUE);
            $data['month'] = $month;


            //validation check @id and @month
            if($id && $month){//validation check
                if($payroll_id){//update
                    $this->db->where('id', $payroll_id);
                    $this->db->update('payroll', $data);
                    $paySleepID = $payroll_id;
                }else{//insert new data
                    $this->db->insert('payroll', $data);
                    $paySleepID = $this->db->insert_id();
                }
            }else{//redirect with error
                $this->message->norecord_found('admin/payroll/employee/');
            }

            
            $this->message->save_success('admin/payroll/employeePaySlip/'. str_replace(array('+', '/', '='), array('-', '_', '~'), $this->encrypt->encode($paySleepID)));
        } else {
            $error = validation_errors();;
            $this->message->custom_error_msg('admin/payroll/employee/',$error);
        }
    }



    function employeePaySlip($id = null)
    {
        $this->mTitle .= lang('salary_payslip');
        $id = $this->encrypt->decode(str_replace(array('-', '_', '~'), array('+', '/', '='), $id));

        $id == TRUE || $this->message->norecord_found('admin/payroll/employee');

        $this->mViewData['pay_slip'] = $this->db->get_where('payroll', array('id' => $id))->row();
        $this->mViewData['employee'] = $this->db->get_where('employee', array('id' => $this->mViewData['pay_slip']->employee_id))->row();

        $this->mViewData['employee']    =  $this->db->select('employee .*, job_title.job_title, department.department, ')
                                            ->from('employee')
                                            ->join('job_title', 'job_title.id = employee.title', 'left')
                                            ->join('department', 'department.id = employee.department', 'left')
                                            ->where('employee.id', $this->mViewData['pay_slip']->employee_id)
                                            ->get()->row();


        $this->render('payroll/employee_payslip');
    }

    function listSalaryPayment()
    {
        $this->mTitle .= lang('employee_payroll_list');
        $this->mViewData['department'] = $this->db->get('department')->result();

        if($this->input->post('department_id') && $this->input->post('month') ){


            $this->mViewData['payroll_list'] = $this->db->select('payroll .*, employee.employee_id, employee.first_name, employee.last_name, employee.termination  ,job_title.job_title, department.department, ')
                ->from('payroll')
                ->join('employee', 'employee.id = payroll.employee_id', 'left')
                ->join('job_title', 'job_title.id = employee.title', 'left')
                ->join('department', 'department.id = payroll.department_id', 'left')
                ->where('payroll.department_id', $this->input->post('department_id'))
                ->where('payroll.month', $this->input->post('month'))
                ->get()->result();


        }
        $this->render('payroll/list_payroll');
    }

}