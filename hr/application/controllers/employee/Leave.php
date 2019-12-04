<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Home page
 */
class Leave extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();

        // only login users can access Account controller
        $this->verify_login();
        $user = $this->ion_auth->user()->row();
        if($user->type != 'user'){
            redirect('auth/login');
        }

        $this->mTitle = TITLE;
    }


    function index(){
        $this->mViewData['panel'] = TRUE;
        $employeeID = $this->ion_auth->user()->row()->employee_id;
        $this->mViewData['leaveApplication'] = $this->db->select('leave_application.*, leave_application_type.leave_category ')
            ->from('leave_application')
            ->join('leave_application_type', 'leave_application.leave_ctegory_id = leave_application_type.id', 'left')
            ->where('leave_application.employee_id', $employeeID)
            ->get()
            ->result();

        $this->mTitle .= lang('list_all_leave');

        $this->render('leave_application');
    }

    function newApplication()
    {
        $this->mTitle .= lang('apply_for_leave');

        $this->mViewData['leaveCategory'] = $this->db->get('leave_application_type')->result();
        $this->render('new_application');
    }

    function saveApplication()
    {
        $this->form_validation->set_rules('leave_ctegory_id', lang('leave_category'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('start_date', lang('start_date'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('end_date', lang('end_date'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('reason', lang('reason'), 'trim|required|xss_clean');


        if ($this->form_validation->run() == TRUE) {

            $data['leave_ctegory_id']       = $this->input->post('leave_ctegory_id');
            $data['start_date']             = $this->input->post('start_date');
            $data['end_date']               = $this->input->post('end_date');
            $data['reason']                 = $this->input->post('reason');
            $data['employee_id']                 = $this->ion_auth->user()->row()->employee_id;

            $this->db->insert('leave_application', $data);

            $this->message->save_success('employee/leave');
        } else {
            $error = validation_errors();;
            $this->message->custom_error_msg('employee/leave', $error );
        }
    }


}