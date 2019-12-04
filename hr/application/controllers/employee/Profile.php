<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Home page
 */
class Profile extends MY_Controller
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

        $this->load->library('form_builder');
        $this->load->library('form_validation');
        $this->mTitle = TITLE;
    }


    function index()
    {

        // only top-level users can reset Admin User passwords


        $user = $this->ion_auth->user()->row();

        $this->mViewData['employee'] =  $this->db->select('employee.*, department.department as department_name,
                                        job_title.job_title as job_title_name, job_category.category_name, emp_status.status_name, work_shift.shift_name ')
                                        ->from('employee')
                                        ->join('department', 'department.id = employee.department', 'left')
                                        ->join('job_title', 'job_title.id = employee.title', 'left')
                                        ->join('job_category', 'job_category.id = employee.category', 'left')
                                        ->join('emp_status', 'emp_status.id = employee.employment_status', 'left')
                                        ->join('work_shift', 'work_shift.id = employee.work_shift', 'left')
                                        ->where('employee.id', $user->employee_id)
                                        ->get()
                                        ->row();

        $form = $this->form_builder->create_form();

        $this->mViewData['form'] = $form;
        $this->mTitle .= lang('employee_profile');
        $this->render('employee_profile');
    }

    public function reset_password()
    {
        $this->form_validation->set_rules('password', lang('password'), 'required');
        $this->form_validation->set_rules('retype_password', lang('retype_password'), 'required|matches[password]');

        if ($this->form_validation->run()== TRUE)
        {
            // pass validation
            $data = array('password' => $this->input->post('password'));

            // [IMPORTANT] override database tables to update Frontend Users instead of Admin Users
            $this->ion_auth_model->tables = array(
                'users'				=> 'users',
                'groups'			=> 'groups',
                'users_groups'		=> 'users_groups',
                'login_attempts'	=> 'login_attempts',
            );
            $id = $this->ion_auth->user()->row()->id;

            // proceed to change user password
            if ($this->ion_auth->update($id, $data))
            {
                $messages = $this->ion_auth->messages();
                $this->system_message->set_success($messages);
            }
            else
            {
                $errors = $this->ion_auth->errors();
                $this->message->custom_error_msg('employee/profile/' ,$errors);
            }
            $this->message->custom_success_msg('employee/profile/', lang('password_update_successfully'));
        }else
        {
            $error = validation_errors();;
            $this->message->custom_error_msg('employee/profile/' ,$error);
        }


    }



}