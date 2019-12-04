<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Employee extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_builder');
        $this->mTitle = TITLE;
        $this->load->model('global_model');
        $this->load->model('attendance_model');

        $this->load->model('crud_model', 'crud');
        $this->load->library('grocery_CRUD');
    }



    function employeeList()
    {
        $this->mViewData['modal'] = FALSE;
        $this->mTitle .= lang('employee_list');
        $this->render('employee/employeeList');
    }

    public function employeeTable(){
        $this->global_model->table = 'employee';
        $list = $this->global_model->get_employee_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $item) {
            $no++;
            $row = array();
            $row[] = $item->employee_id;
            $row[] = $item->first_name.' '.$item->last_name;
            $row[] = $item->department_name;
            $row[] = $item->title;
            $row[] = $item->status_name;
            $row[] = $item->shift_name;

            //add html for action
            $row[] = '<div class="btn-group"><a class="btn btn-xs btn-default" href="'. site_url('admin/employee/employeeDetails/'. str_replace(array('+', '/', '='), array('-', '_', '~'), $this->encrypt->encode($item->id)) ) .'" ><i class="fa fa-search"></i></a>
				  <a class="btn btn-xs btn-danger" onClick="return confirm(\'Are you sure you want to delete?\')"  href="'. site_url('admin/employee/DeleteEmployee/'. str_replace(array('+', '/', '='), array('-', '_', '~'), $this->encrypt->encode($item->id)) ) .'" >
				  <i class="glyphicon glyphicon-trash"></i></a></div>';
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->global_model->count_activeEmployee(),
            "recordsFiltered" => $this->global_model->count_filtered_employee(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }


    function addEmployee()
    {
        $form = $this->form_builder->create_form();

        if ($form->validate())
        {
           $prefix = EMPLOYEE_ID_PREFIX;

           $data= array(
               'first_name'     => $this->input->post('first_name'),
               'last_name'      => $this->input->post('last_name'),
               'marital_status' => $this->input->post('marital_status'),
               'date_of_birth'  => $this->input->post('date_of_birth'),
               'country'        => $this->input->post('country'),
               'blood_group'    => $this->input->post('blood_group'),
               'id_number'      => $this->input->post('id_number'),
               'religious'      => $this->input->post('religious'),
               'gender'         => $this->input->post('gender'),
           );

            $this->db->insert('employee', $data);
            $id = $this->db->insert_id();

            $employee_id = $prefix+$id;
            $path = UPLOAD_EMPLOYEE.$employee_id;
            mkdir_if_not_exist($path);
            $file = upload_employee_photo($employee_id);
            $data= array(
                'employee_id'   => $employee_id,
                'photo'         => $file,
            );

            $this->db->where('id', $id);
            $this->db->update('employee', $data);

            $this->message->save_success('admin/employee/addEmployee');

        }


        $this->mTitle= lang('add_employee');

        $this->mViewData['countries'] = $this->db->get('countries')->result();
        $this->mViewData['form'] = $form;
        $this->render('employee/create_employee');
    }

    function employeeDetails($id =null)
    {
        $id = $this->encrypt->decode(str_replace(array('-', '_', '~'), array('+', '/', '='), $id));
        
        if(empty($id)) {
            $url = $this->input->get('tab');
            $pieces = explode("/", $url);
            $tab = $pieces[0];
            $id = $this->encrypt->decode(str_replace(array('-', '_', '~'), array('+', '/', '='), $pieces[1]));
        }
        
        //select employee from database
        $data['employee'] = $this->global_model->get_employee($id);
        //country
        $data['countries'] = $this->db->get('countries')->result();

        $data['employee'] == TRUE || $this->message->norecord_found('admin/employee/employeeList');

        if(!$this->input->get('tab') || $tab == 'personal' )
        {
            $view   = 'personal';
            $tab    = 'personal';
            $this->mTitle .= lang('personal_details');
        }
        elseif($tab == 'contact')
        {
            $view   = $tab;
            $tab    = $tab;
            $this->mTitle .= lang('contact_details');
        }
        elseif($tab == 'dependents')
        {
            $view   = $tab;
            $tab    = $tab;
            $this->mTitle .= lang('dependents');
        }
        elseif($tab == 'job')
        {
            $view   = $tab;
            $tab    = $tab;

            $data['job'] =    $this->db->select('job_history.*, department.department as department_name, job_title.job_title as title, emp_status.status_name, work_shift.shift_name, job_category.category_name')
                ->from('job_history')
                ->join('department', 'department.id = job_history.department','left')
                ->join('job_title', 'job_title.id = job_history.title','left')
                ->join('emp_status', 'emp_status.id = job_history.employment_status','left')
                ->join('work_shift', 'work_shift.id = job_history.work_shift','left')
                ->join('job_category', 'job_category.id = job_history.category','left')
                ->where('job_history.employee_id', $id)
                ->order_by('job_history.id', 'desc')
                ->get()
                ->result();

            $this->mTitle .= lang('employee_job');
        }
        elseif($tab == 'salary')
        {
            $view   = $tab;
            $tab    = $tab;

            $data['empSalary'] = $this->db->get_where('salary', array('employee_id' => $id ))->row();

            if(!empty($data['empSalary']->component))
            {
                $data['empSalaryDetails'] = json_decode($data['empSalary']->component,true);
            }

            $data['gradeList'] = $this->db->get('salary_grade')->result();
            $data['salaryEarningList'] = $this->db->get_where('salary_component', array('type' =>1))->result();
            $data['salaryDeductionList'] = $this->db->get_where('salary_component', array('type' =>2))->result();
            $this->mTitle .= lang('salary');
        }
        elseif($tab == 'report')
        {
            $view   = $tab;
            $tab    = $tab;
            $data['supervisor'] =  $this->db->select('employee.first_name, employee.last_name, supervisor.*, s_visor.first_name as supervisor_first_name, s_visor.last_name as supervisor_last_name')
                                    ->from('supervisor')
                                    ->join('employee', 'employee.id = supervisor.employee_id', 'left')
                                    ->join('employee as s_visor', 's_visor.id = supervisor.supervisor_id', 'left')
                                    ->where('supervisor.employee_id', $id)
                                    ->get()
                                    ->result();

            $data['subordinate'] =  $this->db->select('employee.first_name, employee.last_name, subordinate.*, s_ordinate.first_name as subordinate_first_name, s_ordinate.last_name as subordinate_last_name')
                                    ->from('subordinate')
                                    ->join('employee', 'employee.id = subordinate.employee_id', 'left')
                                    ->join('employee as s_ordinate', 's_ordinate.id = subordinate.subordinate_id', 'left')
                                    ->where('subordinate.employee_id', $id)
                                    ->get()
                                    ->result();

            $this->mTitle .= lang('employee_report');
        }
        elseif($tab == 'deposit')
        {
            $view   = $tab;
            $tab    = $tab;
//            $data['deposit'] = $this->db->get_where('users', array('employee_id' => $id))->row();
            $this->mTitle .= lang('direct_deposit');
        }
        elseif($tab == 'login')
        {
            $view   = $tab;
            $tab    = $tab;
            $data['login'] = $this->db->get_where('users', array('employee_id' => $id))->row();
            $this->mTitle .= lang('employee_login');
        }
        elseif($tab == 'termination')
        {
            $view   = $tab;
            $tab    = $tab;
            $data['termination'] = $this->db->get_where('employee', array('id' => $id))->row();
            $this->mTitle .= lang('termination_note');
        }


        $data['form']  = $this->form_builder->create_form();
        $this->mViewData['tab']                 = $tab;
        $this->mViewData['tab_view']            = $this->load->view('admin/employee/includes/'.$view,$data,true);
        $this->render('employee/employee_details');
    }



    //=================================================================
    //*********************Employee Personal Details*******************
    //=================================================================

    function save_employee_personal_info()
    {

        $id = $this->encrypt->decode(str_replace(array('-', '_', '~'), array('+', '/', '='), $this->input->post('id')));

        if(empty($id)){
            $this->message->norecord_found('admin/employee/employeeList');
        }

        $tab = $this->input->post('tab_view');

        $this->form_validation->set_rules('first_name', lang('first_name'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('last_name', lang('last_name'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('date_of_birth', lang('date_of_birth'), 'required');
        $this->form_validation->set_rules('country', lang('country'), 'required');

        if ($this->form_validation->run()== TRUE) {
            $employee = $this->global_model->get_employee($id);
            $file = upload_employee_photo($employee->employee_id, $id);
            $flag = FALSE;
            if(!empty($file)){

                if(!empty($employee->photo))
                {
                    $path = UPLOAD_EMPLOYEE.$employee->employee_id.'/'.$employee->photo;
                    unlink($path);
                }
                $flag = TRUE;
            }

            $data = array(
                'first_name' => $this->input->post('first_name'),
                'last_name' => $this->input->post('last_name'),
                'marital_status' => $this->input->post('marital_status'),
                'date_of_birth' => $this->input->post('date_of_birth'),
                'country' => $this->input->post('country'),
                'blood_group' => $this->input->post('blood_group'),
                'id_number' => $this->input->post('id_number'),
                'religious' => $this->input->post('religious'),
                'gender' => $this->input->post('gender'),
            );
            $flag == FALSE || $data['photo'] = $file;

            $this->db->where('id', $id);
            $this->db->update('employee', $data);

            $this->message->save_success('admin/employee/employeeDetails?tab='.$tab.'/'. str_replace(array('+', '/', '='), array('-', '_', '~'), $this->encrypt->encode($id)));
        }else
        {
            $error = validation_errors();;
            $this->message->custom_error_msg('admin/employee/employeeDetails?tab='.$tab.'/'. str_replace(array('+', '/', '='), array('-', '_', '~'), $this->encrypt->encode($id)) ,$error);
        }

    }

    function add_personal_attachment($id)
    {
        $data['id'] = $id;
        $data['modal_subview'] = $this->load->view('admin/employee/_modals/personal_attachment',$data, FALSE);
        $this->load->view('admin/_partials/_layout_modal_small', $data);
    }

    function save_personal_attachment()
    {

        $id = $this->input->post('id');
        $employee = $this->global_model->get_employee($id);

        $this->form_validation->set_rules('description', lang('description'), 'trim|required|xss_clean');

        if ($this->form_validation->run()== TRUE) {

            $file_name = upload_employee_file($employee->employee_id, '*', $id);
            $description = $this->input->post('description');
            if(!empty($employee->personal_attachment))
            {
                $personal_attachment = json_decode($employee->personal_attachment);
            }
            $loggedUser = $this->ion_auth->user()->row();
            $personal_attachment[]= array(
                                                    'file'          => $file_name,
                                                    'description'   => $description,
                                                    'date'          => date("Y/m/d"),
                                                    'added_by'      => $loggedUser->first_name
                                                );
            $data['personal_attachment'] = json_encode($personal_attachment);

            $this->db->where('id', $id);
            $this->db->update('employee', $data);

            $this->message->save_success('admin/employee/employeeDetails?tab=personal/'. str_replace(array('+', '/', '='), array('-', '_', '~'), $this->encrypt->encode($id)));

        }
        else
        {
            $error = validation_errors();
            $this->message->custom_error_msg('admin/employee/employeeDetails?tab=personal/'. str_replace(array('+', '/', '='), array('-', '_', '~'), $this->encrypt->encode($id)) ,$error);
        }

    }

    function delete_personalAttach()
    {
        $attachments = $this->input->post('personalAttach');
        $id          = $this->input->post('id');
        $employee    = $this->global_model->get_employee($id);

        $personalAttachment = json_decode($employee->personal_attachment);

        foreach($attachments as $item)
        {
            //Delete File
            $path = UPLOAD_EMPLOYEE.$employee->employee_id.'/'.$personalAttachment[$item]->file;
            unlink($path);
            //remove from array
            unset($personalAttachment[$item]); // remove item at index
        }
        $personalAttachment = array_values($personalAttachment); // 'reindex' array

        $data['personal_attachment'] = json_encode($personalAttachment);

        //update
        $this->db->where('id', $id);
        $this->db->update('employee', $data);

        $this->message->delete_success('admin/employee/employeeDetails?tab=personal/'. str_replace(array('+', '/', '='), array('-', '_', '~'), $this->encrypt->encode($id)));

    }

    function download_personalAttachment($id = null)
    {
        $this->load->helper('download');
        $pieces = explode("_", $id);
        $id = $pieces[0];
        $index = $pieces[1];

        $employee    = $this->global_model->get_employee($id);
        $personalAttachment = json_decode($employee->personal_attachment);

        $file = base_url().UPLOAD_EMPLOYEE.$employee->employee_id.'/'.$personalAttachment[$index]->file;

        $data =  file_get_contents($file);
        force_download($personalAttachment[$index]->file, $data);

    }

    //=================================================================
    //*********************Employee Contact Details********************
    //=================================================================

    function save_employeeContact()
    {
        $id = $this->encrypt->decode(str_replace(array('-', '_', '~'), array('+', '/', '='), $this->input->post('id')));
        if(empty($id)){
            $this->message->norecord_found('admin/employee/employeeList');
        }
        $employee = $this->global_model->get_employee($id);

        $this->form_validation->set_rules('address_1', lang('address_street_1'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('city', lang('city'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('state', lang('state_province'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('postal', lang('zip_postal_code'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('country', lang('country'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('home_telephone', lang('home_telephone'), 'trim|required|xss_clean');

        if ($this->form_validation->run()== TRUE) {

            $contact_details = array(
                'address_1'         => $this->input->post('address_1'),
                'address_2'         => $this->input->post('address_2'),
                'city'              => $this->input->post('city'),
                'state'             => $this->input->post('state'),
                'postal'            => $this->input->post('postal'),
                'country'           => $this->input->post('country'),
                'home_telephone'    => $this->input->post('home_telephone'),
                'mobile'            => $this->input->post('mobile'),
                'work_telephone'    => $this->input->post('work_telephone'),
                'work_email'        => $this->input->post('work_email'),
                'other_email'       => $this->input->post('other_email'),
            );
            $data['contact_details'] = json_encode($contact_details);

            $this->db->where('id', $id);
            $this->db->update('employee', $data);

            $this->message->save_success('admin/employee/employeeDetails?tab=contact/'. str_replace(array('+', '/', '='), array('-', '_', '~'), $this->encrypt->encode($id)));
        }
        else
        {
            $error = validation_errors();
            $this->message->custom_error_msg('admin/employee/employeeDetails?tab=contact/'. str_replace(array('+', '/', '='), array('-', '_', '~'), $this->encrypt->encode($id)) ,$error);
        }
    }

    function add_emergency_contact($id = null)
    {
        $data['id'] = $id;
        $data['modal_subview'] = $this->load->view('admin/employee/_modals/emergency_contact',$data, FALSE);
        $this->load->view('admin/_partials/_layout_modal_small', $data);
    }

    function edit_emergency_contact($id)
    {
        $pieces = explode("_", $id);

        $data['id'] = str_replace(array('+', '/', '='), array('-', '_', '~'), $this->encrypt->encode($pieces[0]));
        $data['index'] = $pieces[1];

        $employee = $this->global_model->get_employee($pieces[0]);
        $emergency_contact = json_decode($employee->emergency_contact);
        $data['emergency_contact'] = $emergency_contact->$data['index'];

        $data['modal_subview'] = $this->load->view('admin/employee/_modals/emergency_contact',$data, FALSE);
        $this->load->view('admin/_partials/_layout_modal_small', $data);
    }

    function save_emergency_contact()
    {

        $id = $this->encrypt->decode(str_replace(array('-', '_', '~'), array('+', '/', '='), $this->input->post('id')));
        if(empty($id)){
            $this->message->norecord_found('admin/employee/employeeList');
        }
        $index  = $this->input->post('index');
        $employee = $this->global_model->get_employee($id);

        $this->form_validation->set_rules('name', lang('name'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('relationship', lang('relationship'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('home_telephone', lang('home_telephone'), 'trim|required|xss_clean');


        if ($this->form_validation->run()== TRUE) {

            if(!empty($employee->emergency_contact))
            {
                $emergency_contact = json_decode($employee->emergency_contact, true);
            }


            if(empty($index))
            {
                $emergency_contact[]= array(

                    'name'              => $this->input->post('name', TRUE),
                    'relationship'      => $this->input->post('relationship', TRUE),
                    'home_telephone'    => $this->input->post('home_telephone', TRUE),
                    'mobile'            => $this->input->post('mobile', TRUE),
                    'work_telephone'    => $this->input->post('work_telephone', TRUE),

                );
            }
            else
            {
                $emergency_contact[$index]= array(

                    'name'              => $this->input->post('name', TRUE),
                    'relationship'      => $this->input->post('relationship', TRUE),
                    'home_telephone'    => $this->input->post('home_telephone', TRUE),
                    'mobile'            => $this->input->post('mobile', TRUE),
                    'work_telephone'    => $this->input->post('work_telephone', TRUE),

                );
            }


            //reindex array start from 1
            $emergency_contact = array_combine(range(1, count($emergency_contact)), array_values($emergency_contact));

            $data['emergency_contact'] = json_encode($emergency_contact);

            $this->db->where('id', $id);
            $this->db->update('employee', $data);

            $this->message->save_success('admin/employee/employeeDetails?tab=contact/'. str_replace(array('+', '/', '='), array('-', '_', '~'), $this->encrypt->encode($id)));

        }
        else
        {
            $error = validation_errors();
            $this->message->custom_error_msg('admin/employee/employeeDetails?tab=contact/'. str_replace(array('+', '/', '='), array('-', '_', '~'), $this->encrypt->encode($id)) ,$error);
        }

    }


    function delete_emergencyContact()
    {
        $emergency = $this->input->post('emergencyContact');
        $id          = $this->encrypt->decode(str_replace(array('-', '_', '~'), array('+', '/', '='), $this->input->post('id')));
        if(empty($id)){
            $this->message->norecord_found('admin/employee/employeeList');
        }

        $employee    = $this->global_model->get_employee($id);

        $emergency_contact = json_decode($employee->emergency_contact,true);

        foreach($emergency as $item)
        {
            //remove from array
            unset($emergency_contact[$item]); // remove item at index
        }

        $emergency_contact = array_combine(range(1, count($emergency_contact)), array_values($emergency_contact)); // 'reindex' array

        $data['emergency_contact'] = json_encode($emergency_contact);

        //update
        $this->db->where('id', $id);
        $this->db->update('employee', $data);

        $this->message->delete_success('admin/employee/employeeDetails?tab=contact/'. str_replace(array('+', '/', '='), array('-', '_', '~'), $this->encrypt->encode($id)));

    }

    //=================================================================
    //*********************Employee Dependents*************************
    //=================================================================

    function add_dependent($id)
    {
        $data['id'] = $id;
        $data['modal_subview'] = $this->load->view('admin/employee/_modals/dependent',$data, FALSE);
        $this->load->view('admin/_partials/_layout_modal_small', $data);
    }

    function save_dependent()
    {

        $id = $this->encrypt->decode(str_replace(array('-', '_', '~'), array('+', '/', '='), $this->input->post('id')));
        if(empty($id)){
            $this->message->norecord_found('admin/employee/employeeList');
        }
        $index  = $this->input->post('index');
        $employee = $this->global_model->get_employee($id);

        $this->form_validation->set_rules('name', lang('name'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('relationship', lang('relationship'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('date_of_birth', lang('date_of_birth'), 'trim|required|xss_clean');


        if ($this->form_validation->run()== TRUE) {

            if(!empty($employee->dependents))
            {
                $dependents = json_decode($employee->dependents, true);
            }


            if(empty($index))
            {
                $dependents[]= array(

                    'name'              => $this->input->post('name', TRUE),
                    'relationship'      => $this->input->post('relationship', TRUE),
                    'date_of_birth'    => $this->input->post('date_of_birth', TRUE),
                );
            }
            else
            {
                $dependents[$index]= array(

                    'name'              => $this->input->post('name', TRUE),
                    'relationship'      => $this->input->post('relationship', TRUE),
                    'date_of_birth'    => $this->input->post('date_of_birth', TRUE),

                );
            }


            //reindex array start from 1
            $dependents = array_combine(range(1, count($dependents)), array_values($dependents));

            $data['dependents'] = json_encode($dependents);

            $this->db->where('id', $id);
            $this->db->update('employee', $data);

            $this->message->save_success('admin/employee/employeeDetails?tab=dependents/'. str_replace(array('+', '/', '='), array('-', '_', '~'), $this->encrypt->encode($id)) );

        }
        else
        {
            $error = validation_errors();
            $this->message->custom_error_msg('admin/employee/employeeDetails?tab=dependents/'. str_replace(array('+', '/', '='), array('-', '_', '~'), $this->encrypt->encode($id)) ,$error);
        }

    }

    function edit_dependent($id)
    {
        $pieces = explode("_", $id);

        $data['id'] = str_replace(array('+', '/', '='), array('-', '_', '~'), $this->encrypt->encode($pieces[0]));
        $data['index'] = $pieces[1];

        $employee = $this->global_model->get_employee($pieces[0]);
        $dependents = json_decode($employee->dependents);
        $data['dependents'] = $dependents->$data['index'];

        $data['modal_subview'] = $this->load->view('admin/employee/_modals/dependent',$data, FALSE);
        $this->load->view('admin/_partials/_layout_modal_small', $data);
    }

    function delete_dependent()
    {
        $dependentId = $this->input->post('dependentId');
        $id          = $this->input->post('id');
        $employee    = $this->global_model->get_employee($id);

        $dependents = json_decode($employee->dependents,true);

        foreach($dependentId as $item)
        {
            //remove from array
            unset($dependents[$item]); // remove item at index
        }

        $dependents = array_combine(range(1, count($dependents)), array_values($dependents)); // 'reindex' array

        $data['dependents'] = json_encode($dependents);

        //update
        $this->db->where('id', $id);
        $this->db->update('employee', $data);

        $this->message->delete_success('admin/employee/employeeDetails?tab=dependents/'. str_replace(array('+', '/', '='), array('-', '_', '~'), $this->encrypt->encode($id)) );

    }


    //=================================================================
    //*********************Employee Job********************************
    //=================================================================

    function save_commencement()
    {
        $id = $this->encrypt->decode(str_replace(array('-', '_', '~'), array('+', '/', '='), $this->input->post('id')));
        if(empty($id)){
            $this->message->norecord_found('admin/employee/employeeList');
        }

        $this->form_validation->set_rules('joined_date', lang('joined_date'), 'required');
        $this->form_validation->set_rules('date_of_permanency', lang('date_of_permanency'), 'required');
        $this->form_validation->set_rules('probation_end_date', lang('probation_end_date'), 'required');

        if ($this->form_validation->run()== TRUE) {
            $employee = $this->global_model->get_employee($id);

            $data = array(
                'joined_date' => $this->input->post('joined_date'),
                'date_of_permanency' => $this->input->post('date_of_permanency'),
                'probation_end_date' => $this->input->post('probation_end_date'),

            );

            $this->db->where('id', $id);
            $this->db->update('employee', $data);

            $this->message->save_success('admin/employee/employeeDetails?tab=job/'. str_replace(array('+', '/', '='), array('-', '_', '~'), $this->encrypt->encode($id)) );
        }else
        {
            $error = validation_errors();;
            $this->message->custom_error_msg('admin/employee/employeeDetails?tab=job/'.str_replace(array('+', '/', '='), array('-', '_', '~'), $this->encrypt->encode($id)),$error);
        }

    }

    function add_new_job($id)
    {
        $data['id'] = $id;
        $data['departments'] = $this->db->get('department')->result(); //department
        $data['titles'] = $this->db->get('job_title')->result(); //job_title
        $data['categories'] = $this->db->get('job_category')->result(); //job_category
        $data['emp_status'] = $this->db->get('emp_status')->result(); //emp_status
        $data['work_shift'] = $this->db->get('work_shift')->result(); //work_shift
        $data['modal_subview'] = $this->load->view('admin/employee/_modals/new_job',$data, FALSE);
        $this->load->view('admin/_partials/_layout_modal_small', $data);
    }

    function save_new_job()
    {
        $id = $this->encrypt->decode(str_replace(array('-', '_', '~'), array('+', '/', '='), $this->input->post('id')));
        if(empty($id)){
            $this->message->norecord_found('admin/employee/employeeList');
        }
        $job_id= $this->input->post('job_id');


        $this->form_validation->set_rules('effective_from', lang('effective_from'), 'required');
        $this->form_validation->set_rules('department', lang('department'), 'required');
        $this->form_validation->set_rules('title', lang('job_title'), 'required');
        $this->form_validation->set_rules('category', lang('job_category'), 'required');
        $this->form_validation->set_rules('employment_status', lang('employment_status'), 'required');
        $this->form_validation->set_rules('work_shift', lang('work_shift'), 'required');

        if ($this->form_validation->run()== TRUE) {

            $data = array(
                'effective_from' => $this->input->post('effective_from'),
                'department' => $this->input->post('department'),
                'title' => $this->input->post('title'),
                'category' => $this->input->post('category'),
                'employment_status' => $this->input->post('employment_status'),
                'work_shift' => $this->input->post('work_shift'),
            );

            if(!empty($job_id)){ //update

                $this->db->where('id', $job_id);
                $this->db->update('job_history', $data);

                $job = $this->db->get_where('job_history', array(
                    'id' => $job_id
                ))->row();

                //check active job
                if($job->status == 1)
                {
                    //update employee table record
                    $data = array(
                        'department' => $this->input->post('department'),
                        'title' => $this->input->post('title'),
                        'category' => $this->input->post('category'),
                        'employment_status' => $this->input->post('employment_status'),
                        'work_shift' => $this->input->post('work_shift'),
                    );
                    $this->db->where('id', $job->employee_id);
                    $this->db->update('employee', $data);
                }

            }else{//new insert

                $data['employee_id'] = $id;
                $this->db->insert('job_history', $data);
            }

            $this->message->save_success('admin/employee/employeeDetails?tab=job/'. str_replace(array('+', '/', '='), array('-', '_', '~'), $this->encrypt->encode($id)));
        }else
        {
            $error = validation_errors();;
            $this->message->custom_error_msg('admin/employee/employeeDetails?tab=job/'. str_replace(array('+', '/', '='), array('-', '_', '~'), $this->encrypt->encode($id)) ,$error);
        }
    }

    function edit_job_history($id)
    {

        $data['departments'] = $this->db->get('department')->result(); //department
        $data['titles'] = $this->db->get('job_title')->result(); //job_title
        $data['categories'] = $this->db->get('job_category')->result(); //job_category
        $data['emp_status'] = $this->db->get('emp_status')->result(); //emp_status
        $data['work_shift'] = $this->db->get('work_shift')->result(); //work_shift

        $data['job'] = $this->db->get_where('job_history', array(
                                        'id' => $id
                                    ))->row();
        $data['id'] = str_replace(array('+', '/', '='), array('-', '_', '~'), $this->encrypt->encode($data['job']->employee_id));
        $data['modal_subview'] = $this->load->view('admin/employee/_modals/new_job',$data, FALSE);
        $this->load->view('admin/_partials/_layout_modal_small', $data);
    }

    function job_activate($id = null)
    {
        $job = $this->db->get_where('job_history', array(
            'id' => $id
        ))->row();

        if($job->status == 0)
        {
            //find active job
            $activeJob = $this->db->get_where('job_history', array(
                'employee_id' => $job->employee_id,
                'status' => 1,
            ))->row();

            //inactive old job
            if($activeJob->status == 1)
            {
                $this->db->where('id', $activeJob->id);
                $this->db->update('job_history', $data = array('status' => 2));
            }

            //active new job record
            $this->db->where('id', $job->id);
            $this->db->update('job_history', $data = array('status' => 1));

            //update employee table
            $data = array(
                        'department'        => $job->department,
                        'title'             => $job->title,
                        'category'          => $job->category,
                        'employment_status' => $job->employment_status,
                        'work_shift'        => $job->work_shift,
                        );
            $this->db->where('id', $job->employee_id);
            $this->db->update('employee', $data);
        }
        $this->message->save_success('admin/employee/employeeDetails?tab=job/'. str_replace(array('+', '/', '='), array('-', '_', '~'), $this->encrypt->encode($job->employee_id)));
    }

    function delete_job($id = null){
        $id = $this->encrypt->decode(str_replace(array('-', '_', '~'), array('+', '/', '='), $id));
        if(empty($id)){
            $this->message->norecord_found('admin/employee/employeeList');
        }
        $job = $this->db->get_where('job_history', array(
            'id' => $id
        ))->row();

        //delete
        $this->db->delete('job_history', array('id' => $id));

        //update employee table
        if($job->status == 1)
        {
            $data = array(
                'department'        => '',
                'title'             => '',
                'category'          => '',
                'employment_status' => '',
                'work_shift'        => '',
            );
            $this->db->where('id', $job->employee_id);
            $this->db->update('employee', $data);
        }

        $this->message->delete_success('admin/employee/employeeDetails?tab=job/'. str_replace(array('+', '/', '='), array('-', '_', '~'), $this->encrypt->encode($job->employee_id)));
    }


    //=================================================================
    //*************************Employee Salary*************************
    //=================================================================

    public function get_salaryRange_by_id(){
        $grade_id = $this->input->post('grade_id');
        $salary_grade  = $this->db->get_where('salary_grade', array(
            'id' => $grade_id
        ))->row();
        if(count($salary_grade)) {
            echo json_encode(array($salary_grade->min_salary, $salary_grade->max_salary));

        }else{
            echo '';
        }
    }

    public function save_salary()
    {

        $id = $this->encrypt->decode(str_replace(array('-', '_', '~'), array('+', '/', '='), $this->input->post('id')));
        if(empty($id)){
            $this->message->norecord_found('admin/employee/employeeList');
        }

        $salary_id                  = $this->input->post('salary_id', true);
        if(!empty($salary_id)){
            $salary_id = $this->encrypt->decode(str_replace(array('-', '_', '~'), array('+', '/', '='), $salary_id));
            if(empty($salary_id)){
                $this->message->norecord_found('admin/employee/employeeDetails?tab=salary/'. str_replace(array('+', '/', '='), array('-', '_', '~'), $this->encrypt->encode($id)) );
            }
        }

        $data['employee_id']        = $id;

        $records = $this->db->get('salary_component')->result();

        $this->form_validation->set_rules('grade_id', lang('pay_grade'), 'required');
        foreach($records as $record)
        {
            $this->form_validation->set_rules($record->id , $record->component_name, 'required|xss_clean|integer');
        }


        if ($this->form_validation->run()== TRUE) {

            $data['grade_id']           = $this->input->post('grade_id', true);
            $data['comment']            = $this->input->post('comment', true);
            $earning_id                 = $this->input->post('earn');
            $deduction_id               = $this->input->post('deduction');


            $total_cost_company = 0;
            $total_payable = 0;
            $total_deduction =0;
            $basic_salary = $this->input->post(1);

            for($i=0; $i<sizeof($earning_id); $i++){

                if($_POST[$earning_id[$i]] == 0)
                    continue;

                $dbData['component_id'][] = $earning_id[$i];
                $dbData['salary'][] = $_POST[$earning_id[$i]];

                //check payment type
                foreach($records as $record)
                {
                    if($record->id == $earning_id[$i] )
                    {
                        if($record->total_payable == 1) //total payable
                        {
                            $total_payable += $_POST[$earning_id[$i]];
                        }
                        if($record->cost_company == 1 ) //cost to company
                        {
                            $total_cost_company += $_POST[$earning_id[$i]];
                        }
                    }
                }
            }
            for($j=0; $j<sizeof($deduction_id); $j++){

                if($_POST[$deduction_id[$j]] == 0)
                    continue;

                $dbData['component_id'][] = $deduction_id[$j];
                $dbData['salary'][] = $_POST[$deduction_id[$j]];

                foreach($records as $record)
                {
                    if($record->id == $deduction_id[$j])
                    {
                        if($record->value_type == 1) //Amount
                        {
                            $total_deduction += $_POST[$deduction_id[$j]];
                            if($record->total_payable == 1) //total payable
                            {
                                $total_payable -= $_POST[$deduction_id[$j]];
                            }
                            if($record->cost_company == 1 ) //cost to company
                            {
                                $total_cost_company += $_POST[$deduction_id[$j]];
                            }

                        }
                        if($record->value_type == 2 ) //percentage
                        {
                            $total_deduction += ($basic_salary * $_POST[$deduction_id[$j]])/100 ;
                            $deduction = ($basic_salary * $_POST[$deduction_id[$j]])/100 ;
                            if($record->total_payable == 1) //total payable
                            {
                                $total_payable -= $deduction;
                            }
                            if($record->cost_company == 1 ) //cost to company
                            {
                                $total_cost_company += $deduction;
                            }

                        }
                    }
                }

            }

            $data['total_payable']      = $total_payable;
            $data['total_cost_company'] = $total_cost_company;
            $data['total_deduction']    = $total_deduction;


            $salaryDetails = array();
            for($j=0; $j< sizeof($dbData['component_id']); $j++){
                $salaryDetails[$dbData['component_id'][$j]] = $dbData['salary'][$j];
                $componentID[] = $dbData['component_id'][$j];
            }

            //save component
            $salaryComponent = $this->db->select("id")
                ->from('salary_component')
                ->get()
                ->result();


//            echo '<pre>';
//            print_r($salaryComponent[0]->id);
//            echo '<br>';
//            print_r($componentID);
//            exit();

            foreach($salaryComponent as $key => $item){

                if($item->id == $componentID[$key]){
                    $component['component_id'] = $item->id;
                    $component['employee_id'] = $data['employee_id'];

                    $result = $this->db->get_where('component', array(
                        'employee_id' => $data['employee_id'],
                        'component_id' => $item->id,
                    ))->row();

                    if(empty($result)){
                        $this->db->insert('component',$component );
                    }
                }else{
                    $this->db->delete('component', array('component_id' => $item->id, 'employee_id' => $data['employee_id'] ));
                }

            }


            $data['component'] = json_encode($salaryDetails);

            if(!empty($salary_id))
            {
                //update data
                $this->db->where('id', $salary_id);
                $this->db->update('salary', $data);

            }
            else
            {
                //insert data
                $this->db->insert('salary', $data);
            }

            $this->message->save_success('admin/employee/employeeDetails?tab=salary/'. str_replace(array('+', '/', '='), array('-', '_', '~'), $this->encrypt->encode($id)) );

        }
        else
        {
            $error = validation_errors();;
            $this->message->custom_error_msg('admin/employee/employeeDetails?tab=salary/'. str_replace(array('+', '/', '='), array('-', '_', '~'), $this->encrypt->encode($id)) ,$error);
        }
    }

    //=================================================================
    //*************************Employee Report TO**********************
    //=================================================================

    function add_supervisors($id)
    {
        $data['id'] = $id;
        $data['department'] = $this->db->get('department')->result();
        $data['modal_subview'] = $this->load->view('admin/employee/_modals/add_supervisors',$data, FALSE);
        $this->load->view('admin/_partials/_layout_modal_small', $data);
    }

    function get_employee_by_department($id)
    {
        $department_id = $this->input->post('department_id');
        $employeeId = $this->input->post('employeeId');

        $employees = $this->db->get_where('employee', array(
            'department' => $department_id,
            'termination' => 1,
            'soft_delete' => 0,
        ))->result();
        if ($employees) {
            foreach ($employees as $item) {
                if ($item->id == $employeeId ) { // skip even members
                    continue;
                }
                $HTML.="<option value='" . $item->id . "'>" . $item->first_name.' '.$item->last_name . "</option>";
            }
        }
        echo $HTML;
    }

    function save_supervisor()
    {
        $id = $this->encrypt->decode(str_replace(array('-', '_', '~'), array('+', '/', '='), $this->input->post('id')));
        if(empty($id)){
            $this->message->norecord_found('admin/employee/employeeList');
        }

        $supervisor             = $this->input->post('supervisor');
        if(!empty($supervisor)){
            $supervisor = $this->encrypt->decode(str_replace(array('-', '_', '~'), array('+', '/', '='), $supervisor));
            if(empty($supervisor)){
                $this->message->norecord_found('admin/employee/employeeDetails?tab=report/'. str_replace(array('+', '/', '='), array('-', '_', '~'), $this->encrypt->encode($id)) );
            }
        }


        $data['employee_id']    = $id;
        $data['supervisor_id']  = $this->input->post('supervisor_id');
        $data['department_id']  = $this->input->post('department_id');

        if(!empty($supervisor))
        {
            $this->db->where('id', $supervisor);
            $this->db->update('supervisor', $data);
        }
        else
        {
            $this->db->insert('supervisor', $data);
        }
        $this->message->save_success('admin/employee/employeeDetails?tab=report/'. str_replace(array('+', '/', '='), array('-', '_', '~'), $this->encrypt->encode($id)) );
    }

    function edit_supervisor($id = null)
    {
        $id = $this->encrypt->decode(str_replace(array('-', '_', '~'), array('+', '/', '='), $id));
        if(empty($id)){
            $this->message->norecord_found('admin/employee/employeeList');
        }

        $data['supervisor'] = $this->db->get_where('supervisor', array('id' => $id ))->row();
        $data['id'] = str_replace(array('+', '/', '='), array('-', '_', '~'), $this->encrypt->encode($data['supervisor']->employee_id));
        $data['department'] = $this->db->get('department')->result();
        $data['employee'] =  $this->db->get_where('employee', array('department' => $data['supervisor']->department_id ))->result();

        $data['modal_subview'] = $this->load->view('admin/employee/_modals/add_supervisors',$data, FALSE);
        $this->load->view('admin/_partials/_layout_modal_small', $data);
    }

    function delete_supervisor($id = null)
    {
        $id = $this->encrypt->decode(str_replace(array('-', '_', '~'), array('+', '/', '='), $id));
        if(empty($id)){
            $this->message->norecord_found('admin/employee/employeeList');
        }else{
            //delete
            $employee = $this->db->get_where('supervisor', array('id' => $id ))->row()->employee_id;
            $this->db->delete('supervisor', array('id' => $id));
            $this->message->delete_success('admin/employee/employeeDetails?tab=report/'. str_replace(array('+', '/', '='), array('-', '_', '~'), $this->encrypt->encode($employee)) );
        }
    }

    // Subordinate -------------------------------------------------------------------------------------->>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>

    function add_subordinate($id)
    {
        $data['id'] = $id;
        $data['department'] = $this->db->get('department')->result();
        $data['modal_subview'] = $this->load->view('admin/employee/_modals/add_subordinate',$data, FALSE);
        $this->load->view('admin/_partials/_layout_modal_small', $data);
    }

    function save_subordinate()
    {
        $id = $this->encrypt->decode(str_replace(array('-', '_', '~'), array('+', '/', '='), $this->input->post('id')));
        if(empty($id)){
            $this->message->norecord_found('admin/employee/employeeList');
        }

        $subordinate             = $this->input->post('subordinate');

        if(!empty($subordinate)){
            $subordinate = $this->encrypt->decode(str_replace(array('-', '_', '~'), array('+', '/', '='), $subordinate));
            if(empty($subordinate)){
                $this->message->norecord_found('admin/employee/employeeDetails?tab=report/'. str_replace(array('+', '/', '='), array('-', '_', '~'), $this->encrypt->encode($id)) );
            }
        }

        $subordinate             = $subordinate;
        $data['employee_id']    = $id;
        $data['subordinate_id']  = $this->input->post('subordinate_id');
        $data['department_id']  = $this->input->post('department_id');

        if(!empty($subordinate))
        {
            $this->db->where('id', $subordinate);
            $this->db->update('subordinate', $data);
        }
        else
        {
            $this->db->insert('subordinate', $data);
        }
        $this->message->save_success('admin/employee/employeeDetails?tab=report/'. str_replace(array('+', '/', '='), array('-', '_', '~'), $this->encrypt->encode($id)) );
    }

    function edit_subordinate($id)
    {
        $id = $this->encrypt->decode(str_replace(array('-', '_', '~'), array('+', '/', '='), $id));
        if(empty($id)){
            $this->message->norecord_found('admin/employee/employeeList');
        }

        $data['subordinate'] = $this->db->get_where('subordinate', array('id' => $id ))->row();
        $data['id'] = str_replace(array('+', '/', '='), array('-', '_', '~'), $this->encrypt->encode($data['subordinate']->employee_id));
        $data['department'] = $this->db->get('department')->result();
        $data['employee'] =  $this->db->get_where('employee', array('department' => $data['subordinate']->department_id ))->result();

        $data['modal_subview'] = $this->load->view('admin/employee/_modals/add_subordinate',$data, FALSE);
        $this->load->view('admin/_partials/_layout_modal_small', $data);
    }

    function delete_subordinate($id = null)
    {
        $id = $this->encrypt->decode(str_replace(array('-', '_', '~'), array('+', '/', '='), $id));
        if(empty($id)){
            $this->message->norecord_found('admin/employee/employeeList');
        }else{
            //delete
            $employee = $this->db->get_where('subordinate', array('id' => $id ))->row()->employee_id;
            $this->db->delete('subordinate', array('id' => $id));
            $this->message->delete_success('admin/employee/employeeDetails?tab=report/'. str_replace(array('+', '/', '='), array('-', '_', '~'), $this->encrypt->encode($employee)) );
        }
    }

    //=================================================================
    //*************************Employee Create Login*******************
    //=================================================================

    function create_user()
    {
        $id = $this->encrypt->decode(str_replace(array('-', '_', '~'), array('+', '/', '='), $this->input->post('id')));

        if(empty($id)){
            $this->message->norecord_found('admin/employee/employeeList');
        }

        $this->form_validation->set_rules('password', lang('password'), 'required');
        $this->form_validation->set_rules('retype_password', lang('retype_password'), 'required|matches[password]');

        if ($this->form_validation->run()== TRUE) {

            $loginID =  $this->db->get_where('employee', array(
                            'id' => $id
                        ))->row();

            $employee_id    = $id;
            $username       = $loginID->employee_id;
            $email = '';
            $password       = $this->input->post('password');
            $identity = empty($username) ? $email : $username;
            $additional_data = array(
                'employee_id'	=> $employee_id
            );
            $groups         = array('0'=>1);

            // [IMPORTANT] override database tables to update Frontend Users instead of Admin Users
            $this->ion_auth_model->tables = array(
                'users'				=> 'users',
                'groups'			=> 'groups',
                'users_groups'		=> 'users_groups',
                'login_attempts'	=> 'login_attempts',
            );

            // proceed to create user
            $user_id = $this->ion_auth->register($identity, $password,$email ,$additional_data, $groups);
            if ($user_id)
            {
                // success
                $messages = $this->ion_auth->messages();
                $this->system_message->set_success($messages);

                // directly activate user
                $this->ion_auth->activate($user_id);
            }
            else
            {
                // failed
                $errors = $this->ion_auth->errors();
                $this->message->custom_error_msg('admin/employee/employeeDetails?tab=login/'.str_replace(array('+', '/', '='), array('-', '_', '~'), $this->encrypt->encode($id)),$errors);
            }

            $this->message->save_success('admin/employee/employeeDetails?tab=login/'. str_replace(array('+', '/', '='), array('-', '_', '~'), $this->encrypt->encode($id)));
        }else
        {
            $error = validation_errors();;
            $this->message->custom_error_msg('admin/employee/employeeDetails?tab=login/'.str_replace(array('+', '/', '='), array('-', '_', '~'), $this->encrypt->encode($id)),$error);
        }
    }

    // Frontend User Reset Password
    public function reset_password()
    {
        // only top-level users can reset user passwords
        //$this->verify_auth(array('webmaster', 'admin'));

        $id = $this->encrypt->decode(str_replace(array('-', '_', '~'), array('+', '/', '='), $this->input->post('id')));
        $user_id = $this->encrypt->decode(str_replace(array('-', '_', '~'), array('+', '/', '='), $this->input->post('login_id')));

        if(empty($id)){
            $this->message->norecord_found('admin/employee/employeeList');
        }
        if(empty($user_id)){
            $this->message->norecord_found('admin/employee/employeeDetails?tab=login/'.str_replace(array('+', '/', '='), array('-', '_', '~'), $this->encrypt->encode($id)));
        }

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

            // proceed to change user password
            if ($this->ion_auth->update($user_id, $data))
            {
                $messages = $this->ion_auth->messages();
                $this->system_message->set_success($messages);
            }
            else
            {
                $errors = $this->ion_auth->errors();
                $this->message->custom_error_msg('admin/employee/employeeDetails?tab=login/'. str_replace(array('+', '/', '='), array('-', '_', '~'), $this->encrypt->encode($id)) ,$errors);
            }
            $this->message->custom_success_msg('admin/employee/employeeDetails?tab=login/'. str_replace(array('+', '/', '='), array('-', '_', '~'), $this->encrypt->encode($id)), lang('password_update_successfully'));
        }else
        {
            $error = validation_errors();;
            $this->message->custom_error_msg('admin/employee/employeeDetails?tab=login/'. str_replace(array('+', '/', '='), array('-', '_', '~'), $this->encrypt->encode($id)) ,$error);
        }


    }

    function awardList()
    {
        $this->mViewData['modal'] = FALSE;
        $this->mTitle= lang('employee_award');
        $this->render('employee/employee_award');
    }

    function add_award()
    {
        $data['department'] = $this->db->get('department')->result();
        $data['modal_subview'] = $this->load->view('admin/employee/_modals/add_award',$data, FALSE);
        $this->load->view('admin/_partials/_layout_modal_small', $data);
    }

    function save_award(){

        $id = $this->encrypt->decode(str_replace(array('-', '_', '~'), array('+', '/', '='), $this->input->post('id')));

        $this->form_validation->set_rules('employee_id', lang('employee'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('award_name', lang('award_name'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('award_name', lang('award_name'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('month', lang('month'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('department_id', lang('department'), 'trim|required|xss_clean');


        if ($this->form_validation->run() == TRUE) {

            $data['employee_id'] = $this->input->post('employee_id');
            $data['gift_item'] = $this->input->post('gift_item');
            $data['award_name'] = $this->input->post('award_name');
            $data['award_amount'] = $this->input->post('award_amount');
            $data['award_month'] = $this->input->post('month');
            $data['department_id'] = $this->input->post('department_id');

            if(empty($id)){
                $this->db->insert('employee_award', $data);
            }else{
                $this->db->where('id', $id);
                $this->db->update('employee_award', $data);
            }


            $this->message->save_success('admin/employee/awardList');
        } else {
            $error = validation_errors();;
            $this->message->custom_error_msg('admin/employee/awardList',$error);
        }
    }

    public function employeeAwardTable(){
        $this->global_model->table = 'employee_award';
        $this->global_model->order =  array('id' => 'desc');
        $list = $this->global_model->get_award_datatables();

        $data = array();
        $no = $_POST['start'];
        foreach ($list as $item) {
            $no++;
            $row = array();
            //$row[] = $item->employee_personal_id;
            $row[] = $item->termination == 0 ? '<span class="label bg-red">'.$item->employee_personal_id .'</span>':$item->employee_personal_id ;
            $row[] = $item->first_name.' '.$item->last_name;
            $row[] = $item->award_name;
            $row[] = $item->gift_item;
            $row[] = $item->award_amount;
            $row[] = $item->award_month;

            //add html for action
            $row[] = '<div class="btn-group"><a class="btn btn-xs btn-default" data-target="#modalSmall" title="View" data-placement="top" data-toggle="modal"
                        href="'. site_url('admin/employee/editEmployeeAward/'. str_replace(array('+', '/', '='), array('-', '_', '~'), $this->encrypt->encode($item->id)) ) .'" ><i class="fa fa-pencil"></i></a>
				  <a class="btn btn-xs btn-danger" href="javascript:void(0)"  onclick="deleteItem('."'".$item->id."'".')"><i class="glyphicon glyphicon-trash"></i></a></div>';
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->global_model->count_all(),
            "recordsFiltered" => $this->global_model->count_filtered_award(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    function editEmployeeAward($id = null){

        $id = $this->encrypt->decode(str_replace(array('-', '_', '~'), array('+', '/', '='), $id));

        $data['award'] = $this->db->select('employee_award.*, employee.department')
            ->from('employee_award')
            ->join('employee', 'employee_award.employee_id = employee.id', 'left')
            ->where('employee_award.id', $id)
            ->get()
            ->row();

        $data['employee'] = $this->db->get_where('employee', array(
            'department' => $data['award']->department
        ))->result();

        $data['department'] = $this->db->get('department')->result();
        $data['modal_subview'] = $this->load->view('admin/employee/_modals/add_award',$data, FALSE);
        $this->load->view('admin/_partials/_layout_modal_small', $data);
    }

    function termination($id = null)
    {
        $data['id'] = $id;
        $id = $this->encrypt->decode(str_replace(array('-', '_', '~'), array('+', '/', '='), $id));
        $result = $this->db->get_where('employee', array('id' => $id ))->row();
        if(!empty($result->termination_note)){
            $termination = json_decode($result->termination_note);
            $data['termination'] = $termination;
        }
        $data['modal_subview'] = $this->load->view('admin/employee/_modals/termination',$data, FALSE);
        $this->load->view('admin/_partials/_layout_modal_small', $data);
    }

    function employeeTermination()
    {
        $id = $this->encrypt->decode(str_replace(array('-', '_', '~'), array('+', '/', '='), $this->input->post('id')));
        if(empty($id)){
            $this->message->norecord_found('admin/employee/employeeList');
        }

        $this->form_validation->set_rules('termination_date', lang('termination_date'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('termination_reason', lang('termination_reason'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('termination_note', lang('termination_note'), 'trim|required|xss_clean');

        if ($this->form_validation->run() == TRUE) {

            $termination = array(
                'termination_date' => $this->input->post('termination_date'),
                'termination_reason' => $this->input->post('termination_reason'),
                'termination_note' => $this->input->post('termination_note'),
            );

            $data['termination_note'] = json_encode($termination);
            $data['termination'] = 0;

            //update employee table
            $this->db->where('id', $id);
            $this->db->update('employee', $data);

            //update employee login table
            $loginId =  $this->db->get_where('users', array(
                'employee_id' => $id
            ))->row()->id;

            $login['active'] = 0;
            $this->db->where('id', $loginId);
            $this->db->update('users', $login);


            $this->message->save_success('admin/employee/employeeDetails?tab=termination/'. str_replace(array('+', '/', '='), array('-', '_', '~'), $this->encrypt->encode($id)) );
        } else {
            $error = validation_errors();;
            $this->message->custom_error_msg('admin/employee/employeeDetails/'. str_replace(array('+', '/', '='), array('-', '_', '~'), $this->encrypt->encode($id)), $error );
        }
    }

    function terminatedEmployeeList(){
        $this->mViewData['modal'] = FALSE;
        $this->mTitle .= lang('terminated_employee_list');
        $this->render('employee/terminatedEmployeeList');
    }

    public function terminatedEmployeeTable(){
        $this->global_model->table = 'employee';
        $list = $this->global_model->get_terminatedEmployee_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $item) {
            $no++;
            $row = array();
            $row[] = $item->employee_id;
            $row[] = $item->first_name.' '.$item->last_name;
            $row[] = $item->department_name;
            $row[] = $item->title;
            $row[] = $item->status_name;
            $row[] = $item->shift_name;

            //add html for action
            $row[] = '<div class="btn-group"><a class="btn btn-xs btn-default" href="'. site_url('admin/employee/employeeDetails/'. str_replace(array('+', '/', '='), array('-', '_', '~'), $this->encrypt->encode($item->id)) ) .'" ><i class="fa fa-search"></i></a>
				  <a class="btn btn-xs btn-danger" onClick="return confirm(\'Are you sure you want to delete ? \')"  href="'. site_url('admin/employee/DeleteEmployee/'. str_replace(array('+', '/', '='), array('-', '_', '~'), $this->encrypt->encode($item->id)) ) .'" >
				  <i class="glyphicon glyphicon-trash"></i></a></div>';
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->global_model->count_terminatedEmployee(),
            "recordsFiltered" => $this->global_model->count_filtered_terminatedEmployee(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    function change_status()
    {
        $id         = $this->encrypt->decode(str_replace(array('-', '_', '~'), array('+', '/', '='), $this->input->post('userId')));
        $status     = $this->input->post('status');

        $this->db->set('active', $status, FALSE)->where('id', $id)->update('users');
    }

    function reJoin($id=null){
        $id = $this->encrypt->decode(str_replace(array('-', '_', '~'), array('+', '/', '='), $id));
        if(empty($id))
        {
            $this->message->norecord_found('admin/employee/employeeList');
        }else{

            $this->db->set('termination', 1, FALSE)->where('id', $id)->update('employee');
            $this->db->set('active', 1, FALSE)->where('employee_id', $id)->update('users');

            $this->message->custom_success_msg('admin/employee/employeeDetails/'. str_replace(array('+', '/', '='), array('-', '_', '~'), $this->encrypt->encode($id)), lang('re_join_employment_successfully') );

        }
    }

    function deposit()
    {

        $id = $this->encrypt->decode(str_replace(array('-', '_', '~'), array('+', '/', '='), $this->input->post('id')));
        if(empty($id)){
            $this->message->norecord_found('admin/employee/employeeList');
        }

        $this->form_validation->set_rules('account_name', lang('account_name'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('account_number', lang('account_number'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('bank_name', lang('bank_name'), 'trim|required|xss_clean');


        if ($this->form_validation->run() == TRUE) {

            $deposit = array(
                'account_name' => $this->input->post('account_name'),
                'account_number' => $this->input->post('account_number'),
                'bank_name' => $this->input->post('bank_name'),
                'note' => $this->input->post('note'),
            );

            $data['deposit'] = json_encode($deposit);

            //update
            $this->db->where('id', $id);
            $this->db->update('employee', $data);

            $this->message->save_success('admin/employee/employeeDetails?tab=deposit/'. str_replace(array('+', '/', '='), array('-', '_', '~'), $this->encrypt->encode($id)) );
        } else {
            $error = validation_errors();;
            $this->message->custom_error_msg('admin/employee/employeeDetails?tab=deposit/'. str_replace(array('+', '/', '='), array('-', '_', '~'), $this->encrypt->encode($id)) , $error);
        }
    }

    function DeleteEmployee($id = null)
    {
        $id = $this->encrypt->decode(str_replace(array('-', '_', '~'), array('+', '/', '='), $id));
        if(empty($id))
            $this->message->norecord_found('admin/employee/employeeList');

        //delete
        $data['termination'] = 0;
        $data['soft_delete'] = 1;

        //update employee table
        $this->db->where('id', $id);
        $this->db->update('employee', $data);

        //update employee login table
        $loginId =  $this->db->get_where('users', array(
            'employee_id' => $id
        ))->row()->id;

        $this->db->delete('users', array('id' => $loginId));

        $this->message->custom_success_msg('admin/employee/employeeList', lang('employee_delete_success'));

    }




    //=================================================================
    //*************************Employee Attendance *******************
    //=================================================================



    function setAttendance()
    {

        $this->mTitle .= lang('set_attendance');

        $this->mViewData['all_leave_category_info'] = $this->db->get('leave_application_type')->result();

        $this->mViewData['all_department'] = $this->db->get('department')->result();
        $this->mViewData['department_id']           = $this->input->post('department_id');
        $this->mViewData['date']                    = $this->input->post('date', TRUE);
        $sbtnType                        = $this->input->post('sbtn');

        $flag = $this->session->userdata('flag');

        if ($sbtnType == 1 || $flag == 1) {
            if ($flag) {
                $this->mViewData['date'] = $this->session->userdata('date');
                $this->mViewData['department_id'] = $this->session->userdata('department_id');
                $this->session->unset_userdata('date');
                $this->session->unset_userdata('flag');
                $this->session->unset_userdata('department_id');
            } else {

                $this->form_validation->set_rules('date', lang('date'), 'required');
                $this->form_validation->set_rules('department_id', lang('department'), 'required');


                if ($this->form_validation->run() == TRUE) {

                    $this->mViewData['employee_info'] = $this->db->get_where('employee', array(
                        'department'    => $this->input->post('department_id'),
                        'termination'   => 1
                    ))->result();

                    foreach ($this->mViewData['employee_info'] as $v_employee) {
                        $where = array('employee_id' => $v_employee->id, 'date' => $this->mViewData['date']);
                        $this->mViewData['atndnce'][] = $this->attendance_model->check_by($where, 'tbl_attendance');
                    }

                    $this->mViewData['date'] = $this->input->post('date');
                    $this->mViewData['department_id'] = $this->input->post('department_id');
                } else {
                    $error = validation_errors();;
                    $this->message->custom_error_msg('admin/employee/setAttendance',$error);
                }

            }
        }


        $this->render('employee/set_attendance');
    }


    public function save_attendance() {

        $attendance_status = $this->input->post('attendance', TRUE);
        $leave_category_id = $this->input->post('leave_category_id', TRUE);
        $employee_id = $this->input->post('employee_id', TRUE);
        $attendance_id = $this->input->post('attendance_id', TRUE);
        $in_time = $this->input->post('in', TRUE);
        $out_time = $this->input->post('out', TRUE);
        if (!empty($attendance_id)) {
            $key = 0;
            foreach ($employee_id as $empID) {
                $data['date'] = $this->input->post('date', TRUE);
                $data['attendance_status'] = 0;
                $data['employee_id'] = $empID;
                if (!empty($leave_category_id[$key])) {
                    $data['leave_category_id'] = $leave_category_id[$key];
                    $data['attendance_status'] = 3;
                } else {
                    $data['leave_category_id'] = NULL;
                }
                if (!empty($attendance_status)) {
                    foreach ($attendance_status as $v_status) {
                        if ($empID == $v_status) {
                            $data['attendance_status'] = 1;
                            $data['leave_category_id'] = NULL;
                            $data['in_time'] = date("H:i:s", strtotime($in_time[$key]));
                            $data['out_time'] = date("H:i:s", strtotime($out_time[$key]));
                        }
                    }
                }
                $id = $attendance_id[$key];
                if (!empty($id)) {
                    $this->db->where('attendance_id', $id);
                    $this->db->update('tbl_attendance', $data);
                } else {
                    $this->db->insert('tbl_attendance', $data);
                }

                $key++;
            }
        } else {
            $key = 0;

            foreach ($employee_id as $empID) {
                $data['date'] = $this->input->post('date', TRUE);
                $data['attendance_status'] = 0;
                $data['employee_id'] = $empID;
                if (!empty($leave_category_id[$key])) {
                    $data['leave_category_id'] = $leave_category_id[$key];
                    $data['attendance_status'] = 3;
                } else {
                    $data['leave_category_id'] = NULL;
                }
                if (!empty($attendance_status)) {
                    foreach ($attendance_status as $v_status) {
                        if ($empID == $v_status) {
                            $data['attendance_status'] = 1;
                            $data['leave_category_id'] = NULL;
                            $data['in_time'] = date("H:i:s", strtotime($in_time[$key]));
                            $data['out_time'] = date("H:i:s", strtotime($out_time[$key]));
                        }
                    }
                }
                $this->db->insert('tbl_attendance', $data);
                $key++;
            }
        }
        $fdata['department_id'] = $this->input->post('department_id', TRUE);
        $fdata['date'] = $this->input->post('date');
        $fdata['flag'] = 1;
        $this->session->set_userdata($fdata);
        // messages for user
        $this->message->save_success('admin/employee/setAttendance');
    }

    function report()
    {

        $sbtn = $this->input->post('sbtn', TRUE);

        $this->form_validation->set_rules('date', lang('date'), 'required');
        $this->form_validation->set_rules('department_id', lang('department'), 'required');


        if($sbtn) {
            if ($this->form_validation->run() == TRUE) {
                $department_id = $this->input->post('department_id', TRUE);
                $date = $this->input->post('date', TRUE);


                $month = date('n', strtotime($date));
                $year = date('Y', strtotime($date));
                
            
                
                $num = cal_days_in_month(CAL_GREGORIAN, $month, $year);

                $this->mViewData['employee'] = $this->attendance_model->get_employee_id_by_dept_id($department_id);
                $day = date('d', strtotime($date));
                for ($i = 1; $i <= $num; $i++) {
                    $this->mViewData['dateSl'][] = $i;
                }
                $holidays = $this->db->get_where('working_days', array(
                    'flag' => 0
                ))->result();


                if ($month >= 1 && $month <= 9) {
                    $yymm = $year . '-' . '0' . $month;
                } else {
                    $yymm = $year . '-' . $month;
                }

                $public_holiday = $this->attendance_model->get_public_holidays($yymm);


                //tbl a_calendar Days Holiday
                if (!empty($public_holiday)) {
                    foreach ($public_holiday as $p_holiday) {
                        for ($k = 1; $k <= $num; $k++) {

                            if ($k >= 1 && $k <= 9) {
                                $sdate = $yymm . '-' . '0' . $k;
                            } else {
                                $sdate = $yymm . '-' . $k;
                            }

                            if ($p_holiday->start_date == $sdate && $p_holiday->end_date == $sdate) {
                                $p_hday[] = $sdate;
                            }
                            if ($p_holiday->start_date == $sdate) {
                                for ($j = $p_holiday->start_date; $j <= $p_holiday->end_date; $j++) {
                                    $p_hday[] = $j;
                                }
                            }
                        }
                    }
                }
                foreach ($this->mViewData['employee'] as $sl => $v_employee) {
                    $key = 1;
                    $x = 0;
                    for ($i = 1; $i <= $num; $i++) {

                        if ($i >= 1 && $i <= 9) {

                            $sdate = $yymm . '-' . '0' . $i;
                        } else {
                            $sdate = $yymm . '-' . $i;
                        }
                        $day_name = date('l', strtotime("+$x days", strtotime($year . '-' . $month . '-' . $key)));


                        if (!empty($holidays)) {
                            foreach ($holidays as $v_holiday) {

                                if ($v_holiday->days == $day_name) {
                                    $flag = 'H';
                                }
                            }
                        }
                        if (!empty($p_hday)) {
                            foreach ($p_hday as $v_hday) {
                                if ($v_hday == $sdate) {
                                    $flag = 'H';
                                }
                            }
                        }
                        if (!empty($flag)) {
                            $this->mViewData['attendance'][$sl][] = $this->attendance_model->attendance_report_by_empid($v_employee->id, $sdate, $flag);
                        } else {
                            $this->mViewData['attendance'][$sl][] = $this->attendance_model->attendance_report_by_empid($v_employee->id, $sdate);
                        }

                        $key++;
                        $flag = '';
                    }
                }

                $this->mViewData['date'] = $this->input->post('date', TRUE);
                $where = array('id' => $department_id);
                $this->mViewData['dept_name'] = $this->attendance_model->check_by($where, 'department');

                $this->mViewData['month'] = date('F-Y', strtotime($yymm));


            } else {
                $error = validation_errors();;
                $this->message->custom_error_msg('admin/employee/report', $error);
            }

        }



        $this->mViewData['all_department'] = $this->db->get('department')->result();
        $this->mViewData['department_id'] = $this->input->post('department_id', TRUE);
        $this->mTitle .= lang('attendance_report');
        $this->render('employee/attendance_report');
    }


    //=================================================================
    //*************************Employee Application *******************
    //=================================================================


    function applicationList()
    {
        $this->mTitle .= lang('application_list');

        // get yearly report
        if ($this->input->post('year', true)) { // if input data
            $year = $this->input->post('year', true);
            $this->mViewData['year'] = $year;
        } else {
            $year = date('Y'); // present year select
            $this->mViewData['year'] = $year;
        }

        $start_date = $year.'-'.'01'.'-'.'01';
        $end_date =   $year.'-'.'12'.'-'.'31';

        $this->mViewData['application'] = $this->db->select('leave_application.*, employee.first_name, employee.last_name, employee.employee_id, leave_application_type.leave_category')
            ->from('leave_application')
            ->join('employee', 'employee.id = leave_application.employee_id', 'left')
            ->join('leave_application_type', 'leave_application_type.id = leave_application.leave_ctegory_id', 'left')
            ->where('application_date >=', $start_date)
            ->where('application_date <=', $end_date)
            ->get()
            ->result();

        $this->render('employee/application_list');
    }

    function viewApplication($id = null)
    {
        $id = $this->encrypt->decode(str_replace(array('-', '_', '~'), array('+', '/', '='), $id));

        $id == TRUE || $this->message->norecord_found('admin/application/applicationList');

        $result = $this->db->select('leave_application.*, employee.first_name, employee.last_name, employee.employee_id, leave_application_type.leave_category')
            ->from('leave_application')
            ->join('employee', 'employee.id = leave_application.employee_id', 'left')
            ->join('leave_application_type', 'leave_application_type.id = leave_application.leave_ctegory_id', 'left')
            ->where('leave_application.id >=', $id)
            ->get()
            ->row();

        $this->mTitle .= lang('application_view');

        $result == TRUE || $this->message->norecord_found('admin/employee/applicationList');
        $this->mViewData['application'] =  $result;
        $this->render('employee/view_application');

    }

    function changeApplicationStatus()
    {
        $id = $this->encrypt->decode(str_replace(array('-', '_', '~'), array('+', '/', '='), $this->input->post('id')));
        $id == TRUE || $this->message->norecord_found('admin/employee/applicationList');

        //update
        $data['status'] = $this->input->post('status');
        $this->db->where('id', $id);
        $this->db->update('leave_application', $data);
        $this->message->save_success('admin/employee/applicationList');
    }

    //=============================================================
    //  Import Employee
    //=============================================================

    function downloadEmployeeSample()
    {
        $this->load->helper('download');
        $file = base_url().SAMPLE_FILE.'/'.'employee.csv';
        $data =  file_get_contents($file);
        force_download('employee.csv', $data);
    }

    function importEmployee(){
        if(isset($_POST["submit"]))
        {
            $tmp = explode(".", $_FILES['import']['name']); // For getting Extension of selected file
            $extension = end($tmp);
            $allowed_extension = array("xls", "xlsx", "csv"); //allowed extension
            if(in_array($extension, $allowed_extension)) //check selected file extension is present in allowed extension array
            {
                $this->load->library('Data_importer');
                $file = $_FILES["import"]["tmp_name"]; // getting temporary source of excel file
                $this->data_importer->employee_excel_import($file);
            }else{
                $this->message->custom_error_msg('admin/employee/importEmployee', lang('failed_to_import_data'));
            }
        }


        $this->mViewData['form'] = $this->form_builder->create_form();

        $this->mTitle .= lang('import_data');
        $this->render('import/import_employee');
    }

    //=============================================================
    //  Import Attendance
    //=============================================================

    function downloadAttendanceSample()
    {
        $this->load->helper('download');
        $file = base_url().SAMPLE_FILE.'/'.'attendance.csv';
        $data =  file_get_contents($file);
        force_download('attendance.csv', $data);
    }

    function importAttendance(){
        if(isset($_POST["submit"]))
        {
            $tmp = explode(".", $_FILES['import']['name']); // For getting Extension of selected file
            $extension = end($tmp);
            $allowed_extension = array("xls", "xlsx", "csv"); //allowed extension
            if(in_array($extension, $allowed_extension)) //check selected file extension is present in allowed extension array
            {
                $this->load->library('Data_importer');
                $file = $_FILES["import"]["tmp_name"]; // getting temporary source of excel file
                $this->data_importer->attendance_excel_import($file);
            }else{
                $this->message->custom_error_msg('admin/employee/importAttendance', lang('failed_to_import_data'));
            }
        }


        $this->mViewData['form'] = $this->form_builder->create_form();

        $crud = new grocery_CRUD();
        //$crud = $this->generate_crud('sales_order');
        $crud->columns('employee_id','first_name','last_name','department','title');

        $crud->set_relation('department','department','department');
        $crud->set_relation('title','job_title','job_title');

        $crud->order_by('id','desc');
        $crud->where('termination',1);
        $crud->where('soft_delete',0);
        $crud->display_as('title', lang('job_title'));
        $crud->set_table('employee');

        $crud->unset_add();
        $crud->unset_edit();
        $crud->unset_delete();
        $crud->unset_read();

        $this->mViewData['crud'] = $crud->render();

        $this->mTitle .= lang('import_data');
        $this->render('import/import_attendance');
    }




}