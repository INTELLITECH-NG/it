<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Office extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_builder');
        $this->load->model('settings_model');
        $this->load->model('global_model');
        $this->mTitle = TITLE;
    }



    function workingDays()
    {
        $this->mTitle .= lang('set_working_days');
        $this->mViewData['workingDays'] = $this->db->get('working_days')->result();
        $this->render('office/working_days');
    }

    public function save_working_days()
    {
        $workingDaysId = $this->input->post('working_days');
        $days = $this->input->post('days');

        foreach($days as $day){
            foreach($workingDaysId as $id){
                if($day == $id){
                    $data['flag'] = 1;
                    $this->db->where('id', $id);
                    $this->db->update('working_days', $data);

                    $val = array_search($id, $days);
                    unset($days[$val]);
                }
            }
        }

        foreach($days as $day){
            $data['flag'] = 0;
            $this->db->where('id', $day);
            $this->db->update('working_days', $data);
        }
        $this->message->save_success('admin/office/workingDays');
    }

    function holidayList()
    {
        $this->mTitle .= lang('list_of_holiday');

        // get yearly report
        if ($this->input->post('year', true)) { // if input data
            $year = $this->input->post('year', true);
            $this->mViewData['year'] = $year;
        } else {
            $year = date('Y'); // present year select
            $this->mViewData['year'] = $year;
        }
        $this->mViewData['yearly_holiday'] = $this->get_yearly_holiday($year);  // get yearly report


        $this->render('office/holidays');
    }

    /*** Get Yearly Report ***/
    public function get_yearly_holiday($year)
    {

        for ($i = 1; $i <= 12; $i++) { // query for months
            if ($i >= 1 && $i <= 9) {
                $start_date = $year.'-'.'0'.$i.'-'.'01';
                $end_date = $year.'-'.'0'.$i.'-'.'31';
            } else {
                $start_date = $year.'-'.$i.'-'.'01';
                $end_date = $year.'-'.$i.'-'.'31';
            }

            $get_all_holiday[$i] = $this->settings_model->get_all_holiday_by_date($start_date, $end_date); // get all report by start date and in date
        }


        return $get_all_holiday;
    }

    function add_holiday($id = null)
    {
        if(!empty($id)){
            $data['holiday'] = $this->db->get_where('holidays', array(
                'holiday_id' => $id
            ))->row();
        }else{
            $data['holiday'] ='';
        }
        $data['modal_subview'] = $this->load->view('admin/office/add_holiday',$data, FALSE);
        $this->load->view('admin/_partials/_layout_modal_small', $data);
    }

    public function save_holiday(){

        $holiday_id =  $this->input->post('holiday_id');

        $this->form_validation->set_rules('event_name', lang('event_name'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('description', lang('description'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('start_date', lang('start_date'), 'required');
        $this->form_validation->set_rules('end_date', lang('end_date'), 'required');


        if ($this->form_validation->run() == TRUE) {

            $data['event_name'] = $this->input->post('event_name');
            $data['description'] = $this->input->post('description');
            $data['start_date'] = date ("Y-m-d H:i:s", strtotime($this->input->post('start_date')));
            $data['end_date'] = date ("Y-m-d H:i:s", strtotime($this->input->post('end_date')));


            if(empty($holiday_id)){
                $this->db->insert('holidays', $data);
            }else{
                $this->db->where('holiday_id', $holiday_id);
                $this->db->update('holidays', $data);
            }


            $this->message->save_success('admin/office/holidayList');
        } else {
            $error = validation_errors();;
            $this->message->custom_error_msg('admin/office/holidayList');
        }

    }




    //============================================================
    //************************Leave Type*******************
    //============================================================

    function leaveType()
    {
        $this->mViewData['modal'] = FALSE;
        $this->mTitle .= lang('department');
        $this->render('office/leave_type_list');
    }

    public function leaveType_list()
    {

        $this->global_model->table = 'leave_application_type';
        $this->global_model->column_order = array('leave_category',null);
        $this->global_model->column_search = array('leave_category');
        $this->global_model->order = array('id' => 'desc');

        $list = $this->global_model->get_datatables();

        $data = array();
        $no = $_POST['start'];
        foreach ($list as $item) {
            $no++;
            $row = array();
            $row[] = $item->leave_category;


            //add html for action
            $row[] = '<div class="btn-group"><a class="btn btn-xs btn-default" href="javascript:void(0)" onclick="edit_title('."'".$item->id."'".')"><i class="fa fa-pencil"></i></a>
				  <a class="btn btn-xs btn-danger" href="javascript:void(0)"  onclick="deleteItem('."'".$item->id."'".')"><i class="glyphicon glyphicon-trash"></i></a></div>';
            $data[] = $row;
        }
        $this->global_model->render_table($data);
    }

    public function add_leave_category()
    {
        $this->global_model->table = 'leave_application_type';
        $this->_leave_category_validate();
        $data = array(
            'leave_category' => $this->input->post('leave_category'),
        );
        $insert = $this->global_model->save($data);
        echo json_encode(array("status" => TRUE));
    }

    private function _leave_category_validate()
    {
        $rules = array(
            array('field'=>'leave_category', 'label'=> lang('leave_type'), 'rules'=>'trim|required'),
        );

        $this->global_model->validation($rules);
    }

    public function edit_leave_category($id)
    {
        $this->global_model->table = 'leave_application_type';
        $data = $this->global_model->get_by_id($id);
        echo json_encode($data);
    }

    public function update_leave_category()
    {
        $this->global_model->table = 'leave_application_type';
        $this->_department_validate();
        $data = array(
            'leave_category' => $this->input->post('leave_category'),
        );
        $this->global_model->update(array('id' => $this->input->post('id')), $data);
        echo json_encode(array("status" => TRUE));
    }

    public function delete_leave_category($id)
    {
        $this->global_model->table = 'leave_application_type';

        $leave_category =  $this->db->get_where('tbl_attendance', array(
            'leave_category_id' => $id
        ))->row();

        if(empty($leave_category)){
            $this->global_model->delete_by_id($id);
            echo 1;
        }else{
            echo 0;
        }
    }

    function deleteHoliday($id=null){
        if(!empty($id)){
            $this->db->delete('holidays', array('holiday_id' => $id));
            $this->message->delete_success('admin/office/holidayList');
        }else{
            $this->message->norecord_found('admin/office/holidayList');
        }
    }













    //============================================================
    //************************Department**************************
    //============================================================

    function department()
    {
        $this->mViewData['modal'] = FALSE;
        $this->mTitle= lang('department');
        $this->render('office/department_list');
    }

    public function department_list()
    {

        $this->global_model->table = 'department';
        $this->global_model->column_order = array('department','description',null);
        $this->global_model->column_search = array('department','description');
        $this->global_model->order = array('id' => 'desc');

        $list = $this->global_model->get_datatables();

        $data = array();
        $no = $_POST['start'];
        foreach ($list as $item) {
            $no++;
            $row = array();
            $row[] = $item->department;
            $row[] = $item->description;

            //add html for action
            $row[] = '<div class="btn-group"><a class="btn btn-xs btn-default" href="javascript:void(0)" onclick="edit_title('."'".$item->id."'".')"><i class="fa fa-pencil"></i></a>
				  <a class="btn btn-xs btn-danger" href="javascript:void(0)"  onclick="deleteItem('."'".$item->id."'".')"><i class="glyphicon glyphicon-trash"></i></a></div>';
            $data[] = $row;
        }
        $this->global_model->render_table($data);
    }


    public function edit_department($id)
    {
        $this->global_model->table = 'department';
        $data = $this->global_model->get_by_id($id);
        echo json_encode($data);
    }

    public function add_department()
    {
        $this->global_model->table = 'department';
        $this->_department_validate();
        $data = array(
            'department' => $this->input->post('department'),
            'description' => $this->input->post('description'),

        );
        $insert = $this->global_model->save($data);
        echo json_encode(array("status" => TRUE));
    }

    public function update_department()
    {
        $this->global_model->table = 'department';
        $this->_department_validate();
        $data = array(
            'department' => $this->input->post('department'),
            'description' => $this->input->post('description'),
        );
        $this->global_model->update(array('id' => $this->input->post('id')), $data);
        echo json_encode(array("status" => TRUE));
    }

    public function delete_department($id)
    {
        $this->global_model->table = 'department';

        $result = $this->db->get_where('employee', array('department' => $id ))->result();

        if(empty($result)){
            $this->global_model->delete_by_id($id);
            echo 1;
        }else{
            echo 0;
        }

    }


    private function _department_validate()
    {
        $rules = array(
            array('field'=>'department', 'label'=> lang('department'), 'rules'=>'trim|required'),
            array('field'=>'description', 'label'=> lang('description'), 'rules'=>'trim|required'),
        );

        $this->global_model->validation($rules);
    }


    //============================================================
    //************************Job Title***************************
    //============================================================

    function jobTitle()
    {

        $this->mTitle= lang('job_title');
        $this->render('office/job_title');
    }

    public function title_list()
    {

        $this->global_model->table = 'job_title';
        $this->global_model->column_order = array('job_title','description',null);
        $this->global_model->column_search = array('job_title','description');
        $this->global_model->order = array('id' => 'desc');

        $list = $this->global_model->get_datatables();

        $data = array();
        $no = $_POST['start'];
        foreach ($list as $item) {
            $no++;
            $row = array();
            $row[] = $item->job_title;
            $row[] = $item->description;

            //add html for action
            $row[] = '<div class="btn-group"><a class="btn btn-xs btn-default" href="javascript:void(0)" onclick="edit_title('."'".$item->id."'".')"><i class="fa fa-pencil"></i></a>
				  <a class="btn btn-xs btn-danger" href="javascript:void(0)"  onclick="deleteItem('."'".$item->id."'".')"><i class="glyphicon glyphicon-trash"></i></a></div>';
            $data[] = $row;
        }

        $this->global_model->render_table($data);
    }


    public function title_edit($id)
    {
        $this->global_model->table = 'job_title';
        $data = $this->global_model->get_by_id($id);
        echo json_encode($data);
    }

    public function title_add()
    {
        $this->global_model->table = 'job_title';
        $this->_title_validate();
        $data = array(
            'job_title' => $this->input->post('job_title'),
            'description' => $this->input->post('description'),
        );
        $insert = $this->global_model->save($data);
        echo json_encode(array("status" => TRUE));
    }

    public function title_update()
    {
        $this->global_model->table = 'job_title';
        $this->_title_validate();
        $data = array(
            'job_title' => $this->input->post('job_title', TRUE),
            'description' => $this->input->post('description'),
        );
        $this->global_model->update(array('id' => $this->input->post('id')), $data);
        echo json_encode(array("status" => TRUE));
    }

    public function title_delete($id)
    {
        $this->global_model->table = 'job_title';
        $result = $this->db->get_where('employee', array('title' => $id ))->result();
        if(empty($result)){
            $this->global_model->delete_by_id($id);
            echo 1;
        }else{
            echo 0;
        }

    }


    private function _title_validate()
    {
        $rules = array(
            array('field'=>'job_title', 'label'=> lang('job_title'), 'rules'=>'trim|required'),
            array('field'=>'description', 'label'=>lang('description'), 'rules'=>'trim|required'),
        );
        $this->global_model->validation($rules);
    }




    //============================================================
    //************************Salary Component********************
    //============================================================

    function salaryComponent()
    {
        $this->mTitle= lang('salary_component');
        $this->render('office/salary_component');
    }

    public function salary_component_list()
    {
        $this->global_model->table = 'salary_component';
        $this->global_model->column_order = array('component_name','type',null,null,null,null);
        $this->global_model->column_search = array('component_name','type');
        $this->global_model->order = array('id' => 'asc');

        $list = $this->global_model->get_datatables();

        $data = array();
        $no = $_POST['start'];
        foreach ($list as $item) {
            $no++;
            $row = array();
            $row[] = $item->component_name;
            $row[] = $item->type == 1 ? 'Earning':'Deduction';
            $row[] = $item->total_payable == 1 ? 'Yes ':'No';
            $row[] = $item->cost_company == 1 ? 'Yes ':'No';
            $row[] = $item->value_type == 1 ? 'Amount':'percentage';

            //add html for action
            if($item->id != 1){
                $row[] = '<div class="btn-group"><a class="btn btn-xs btn-default" href="javascript:void(0)" onclick="edit_title('."'".$item->id."'".')"><i class="fa fa-pencil"></i></a>
				  <a class="btn btn-xs btn-danger" href="javascript:void(0)"  onclick="deleteItem('."'".$item->id."'".')"><i class="glyphicon glyphicon-trash"></i></a></div>';
            }else{
                $row[] = '';
            }

            $data[] = $row;
        }
        $this->global_model->render_table($data);
    }



    public function edit_salary_component($id)
    {
        $this->global_model->table = 'salary_component';
        $data = $this->global_model->get_by_id($id);
        echo json_encode($data);
    }

    public function add_salary_component()
    {
        $this->global_model->table = 'salary_component';
        $this->_salary_component_validate();
        $data = array(
            'component_name' => $this->input->post('component_name'),
            'type' => $this->input->post('type'),
            'total_payable' => $this->input->post('total_payable'),
            'cost_company' => $this->input->post('cost_company'),
            'value_type' => $this->input->post('value_type'),

        );
        $insert = $this->global_model->save($data);
        echo json_encode(array("status" => TRUE));
    }

    public function update_salary_component()
    {
        $this->global_model->table = 'salary_component';
        $this->_salary_component_validate();
        $data = array(
            'component_name' => $this->input->post('component_name'),
            'type' => $this->input->post('type'),
            'total_payable' => $this->input->post('total_payable'),
            'cost_company' => $this->input->post('cost_company'),
            'value_type' => $this->input->post('value_type'),
        );
        $this->global_model->update(array('id' => $this->input->post('id')), $data);
        echo json_encode(array("status" => TRUE));
    }

    public function delete_salary_component($id)
    {
        $this->global_model->table = 'salary_component';
        $result = $this->db->get_where('component', array('component_id' => $id ))->result();
        if(empty($result)){
            $this->global_model->delete_by_id($id);
            echo 1;
        }else{
            echo 0;
        }
    }


    private function _salary_component_validate()
    {
        $rules = array(
            array('field'=>'component_name', 'label'=>'Component Name', 'rules'=>'trim|required'),

        );

        $this->global_model->validation($rules);
    }


    //============================================================
    //***************************Pay Grade************************
    //============================================================

    function payGrades()
    {
        $this->mTitle= lang('pay_grade');
        $this->render('office/pay_grade');
    }

    public function pay_grade_list()
    {
        $this->global_model->table = 'salary_grade';
        $this->global_model->column_order = array('grade_name','min_salary','max_salary',null);
        $this->global_model->column_search = array('grade_name','min_salary','max_salary');
        $this->global_model->order = array('grade_name' => 'asc');

        $list = $this->global_model->get_datatables();

        $data = array();
        $no = $_POST['start'];
        foreach ($list as $item) {
            $no++;
            $row = array();
            $row[] = $item->grade_name;
            $row[] = $item->min_salary;
            $row[] = $item->max_salary;


            //add html for action
            $row[] = '<div class="btn-group"><a class="btn btn-xs btn-default" href="javascript:void(0)" onclick="edit_title('."'".$item->id."'".')"><i class="fa fa-pencil"></i></a>
				  <a class="btn btn-xs btn-danger" href="javascript:void(0)"  onclick="deleteItem('."'".$item->id."'".')"><i class="glyphicon glyphicon-trash"></i></a></div>';
            $data[] = $row;
        }
        $this->global_model->render_table($data);
    }



    public function edit_pay_grade($id)
    {
        $this->global_model->table = 'salary_grade';
        $data = $this->global_model->get_by_id($id);
        echo json_encode($data);
    }

    public function add_pay_grade()
    {
        $this->global_model->table = 'salary_grade';
        $this->_pay_grade_validate();
        $data = array(
            'grade_name' => $this->input->post('grade_name', TRUE),
            'min_salary' => floatval($this->input->post('min_salary')),
            'max_salary' => floatval($this->input->post('max_salary')),
        );
        $insert = $this->global_model->save($data);
        echo json_encode(array("status" => TRUE));
    }

    public function update_pay_grade()
    {
        $this->global_model->table = 'salary_grade';
        $this->_pay_grade_validate();
        $data = array(
            'grade_name' => $this->input->post('grade_name', TRUE),
            'min_salary' => floatval($this->input->post('min_salary')),
            'max_salary' => floatval($this->input->post('max_salary')),
        );
        $this->global_model->update(array('id' => $this->input->post('id')), $data);
        echo json_encode(array("status" => TRUE));
    }

    public function delete_pay_grade($id)
    {
        $this->global_model->table = 'salary_grade';
        $result = $this->db->get_where('salary', array('grade_id' => $id ))->result();
        if(empty($result)){
            $this->global_model->delete_by_id($id);
            echo 1;
        }else{
            echo 0;
        }
    }


    private function _pay_grade_validate()
    {
        $rules = array(
            array('field'=>'grade_name', 'label'=>lang('pay_grade'), 'rules'=>'trim|required'),
            array('field'=>'min_salary', 'label'=>lang('min_salary'), 'rules'=>'trim|required'),
            array('field'=>'max_salary', 'label'=>lang('max_salary'), 'rules'=>'trim|required'),

        );

        $this->global_model->validation($rules);
    }


    //============================================================
    //***************************Emp Status***********************
    //============================================================

    function employmentStatus()
    {
        $this->mTitle= lang('emp_status');
        $this->render('office/employee_status');
    }

    public function emp_status_list()
    {
        $this->global_model->table = 'emp_status';
        $this->global_model->column_order = array('status_name',null);
        $this->global_model->column_search = array('status_name');
        $this->global_model->order = array('status_name' => 'asc');

        $list = $this->global_model->get_datatables();

        $data = array();
        $no = $_POST['start'];
        foreach ($list as $item) {
            $no++;
            $row = array();
            $row[] = $item->status_name;

            //add html for action
            $row[] = '<div class="btn-group"><a class="btn btn-xs btn-default" href="javascript:void(0)" onclick="edit_title('."'".$item->id."'".')"><i class="fa fa-pencil"></i></a>
				  <a class="btn btn-xs btn-danger" href="javascript:void(0)"  onclick="deleteItem('."'".$item->id."'".')"><i class="glyphicon glyphicon-trash"></i></a></div>';
            $data[] = $row;
        }
        $this->global_model->render_table($data);
    }



    public function edit_emp_status($id)
    {
        $this->global_model->table = 'emp_status';
        $data = $this->global_model->get_by_id($id);
        echo json_encode($data);
    }

    public function add_emp_status()
    {
        $this->global_model->table = 'emp_status';
        $this->_emp_status_validate();
        $data = array(
            'status_name' => $this->input->post('status_name', TRUE)
        );
        $insert = $this->global_model->save($data);
        echo json_encode(array("status" => TRUE));
    }

    public function update_emp_status()
    {
        $this->global_model->table = 'emp_status';
        $this->_emp_status_validate();
        $data = array(
            'status_name' => $this->input->post('status_name', TRUE)
        );
        $this->global_model->update(array('id' => $this->input->post('id')), $data);
        echo json_encode(array("status" => TRUE));
    }

    public function delete_emp_status($id)
    {
        $this->global_model->table = 'emp_status';
        $empStatus = $this->db->get_where('job_history', array('employment_status' => $id ))->result();
        $emp = $this->db->get_where('employee', array('employment_status' => $id ))->result();

        if(empty($emp || $empStatus )){
            $this->global_model->delete_by_id($id);
            echo 1;
        }else{
            echo 0;
        }
    }


    private function _emp_status_validate()
    {
        $rules = array(
            array('field'=>'status_name', 'label'=>lang('emp_status'), 'rules'=>'trim|required'),

        );

        $this->global_model->validation($rules);
    }


    //============================================================
    //***************************Job Categories*******************
    //============================================================

    function jobCategories()
    {
        $this->mTitle= lang('job_categories');
        $this->render('office/job_categories');
    }

    public function job_categories_list()
    {
        $this->global_model->table = 'job_category';
        $this->global_model->column_order = array('category_name',null);
        $this->global_model->column_search = array('category_name');
        $this->global_model->order = array('category_name' => 'asc');

        $list = $this->global_model->get_datatables();

        $data = array();
        $no = $_POST['start'];
        foreach ($list as $item) {
            $no++;
            $row = array();
            $row[] = $item->category_name;

            //add html for action
            $row[] = '<div class="btn-group"><a class="btn btn-xs btn-default" href="javascript:void(0)" onclick="edit_title('."'".$item->id."'".')"><i class="fa fa-pencil"></i></a>
				  <a class="btn btn-xs btn-danger" href="javascript:void(0)"  onclick="deleteItem('."'".$item->id."'".')"><i class="glyphicon glyphicon-trash"></i></a></div>';
            $data[] = $row;
        }
        $this->global_model->render_table($data);
    }



    public function edit_job_categories($id)
    {
        $this->global_model->table = 'job_category';
        $data = $this->global_model->get_by_id($id);
        echo json_encode($data);
    }

    public function add_job_categories()
    {
        $this->global_model->table = 'job_category';
        $this->_job_categories_validate();
        $data = array(
            'category_name' => $this->input->post('category_name', TRUE)
        );
        $insert = $this->global_model->save($data);
        echo json_encode(array("status" => TRUE));
    }

    public function update_job_categories()
    {
        $this->global_model->table = 'job_category';
        $this->_job_categories_validate();
        $data = array(
            'category_name' => $this->input->post('category_name', TRUE)
        );
        $this->global_model->update(array('id' => $this->input->post('id')), $data);
        echo json_encode(array("status" => TRUE));
    }

    public function delete_job_categories($id)
    {
        $this->global_model->table = 'job_category';
        $empCategory = $this->db->get_where('job_history', array('category' => $id ))->result();
        $emp = $this->db->get_where('employee', array('category' => $id ))->result();

        if(empty($emp || $empCategory )){
            $this->global_model->delete_by_id($id);
            echo 1;
        }else{
            echo 0;
        }
    }


    private function _job_categories_validate()
    {
        $rules = array(
            array('field'=>'category_name', 'label'=>lang('job_categories'), 'rules'=>'trim|required'),

        );

        $this->global_model->validation($rules);
    }

    //============================================================
    //***************************Work Shift***********************
    //============================================================

    function workShift()
    {
        $this->mTitle= lang('work_shift');
        $this->render('office/workShift');
    }

    public function work_shift_list()
    {
        $this->global_model->table = 'work_shift';
        $this->global_model->column_order = array('shift_name','shift_form','shift_to',null);
        $this->global_model->column_search = array('shift_name','shift_form','shift_to');
        $this->global_model->order = array('shift_name' => 'asc');

        $list = $this->global_model->get_datatables();

        $data = array();
        $no = $_POST['start'];
        foreach ($list as $item) {
            $no++;
            $row = array();
            $row[] = $item->shift_name;
            $row[] = $item->shift_form;
            $row[] = $item->shift_to;

            //add html for action
            $row[] = '<div class="btn-group"><a class="btn btn-xs btn-default" href="javascript:void(0)" onclick="edit_title('."'".$item->id."'".')"><i class="fa fa-pencil"></i></a>
				  <a class="btn btn-xs btn-danger" href="javascript:void(0)"  onclick="deleteItem('."'".$item->id."'".')"><i class="glyphicon glyphicon-trash"></i></a></div>';
            $data[] = $row;
        }
        $this->global_model->render_table($data);
    }



    public function edit_work_shift($id)
    {
        $this->global_model->table = 'work_shift';
        $data = $this->global_model->get_by_id($id);
        echo json_encode($data);
    }

    public function add_work_shift()
    {
        $this->global_model->table = 'work_shift';
        $this->_job_work_shift_validate();
        $data = array(
            'shift_name' => $this->input->post('shift_name', TRUE),
            'shift_form' => $this->input->post('shift_form', TRUE),
            'shift_to' => $this->input->post('shift_to', TRUE),
        );
        $insert = $this->global_model->save($data);
        echo json_encode(array("status" => TRUE));
    }

    public function update_work_shift()
    {
        $this->global_model->table = 'work_shift';
        $this->_job_work_shift_validate();
        $data = array(
            'shift_name' => $this->input->post('shift_name', TRUE),
            'shift_form' => $this->input->post('shift_form', TRUE),
            'shift_to' => $this->input->post('shift_to', TRUE),
        );
        $this->global_model->update(array('id' => $this->input->post('id')), $data);
        echo json_encode(array("status" => TRUE));
    }

    public function delete_work_shift($id)
    {
        $this->global_model->table = 'work_shift';
        $empCategory = $this->db->get_where('job_history', array('work_shift' => $id ))->result();
        $emp = $this->db->get_where('employee', array('work_shift' => $id ))->result();

        if(empty($emp || $empCategory )){
            $this->global_model->delete_by_id($id);
            echo 1;
        }else{
            echo 0;
        }
    }


    private function _job_work_shift_validate()
    {
        $rules = array(
            array('field'=>'shift_name', 'label'=>lang('shift_name'), 'rules'=>'trim|required'),
            array('field'=>'shift_form', 'label'=>lang('shift_form'), 'rules'=>'trim|required'),
            array('field'=>'shift_to', 'label'=>lang('shift_to'), 'rules'=>'trim|required'),

        );

        $this->global_model->validation($rules);
    }


    //============================================================
    //************************Tax**************************
    //============================================================

    function tax()
    {
        $this->mViewData['modal'] = FALSE;
        $this->mTitle= lang('tax');
        $this->render('office/tax');
    }

    public function tax_list()
    {

        $this->global_model->table = 'tax';
        $this->global_model->column_order = array('name','rate','type',null);
        $this->global_model->column_search = array('name','rate','type');
        $this->global_model->order = array('id' => 'desc');

        $list = $this->global_model->get_datatables();

        $data = array();
        $no = $_POST['start'];
        foreach ($list as $item) {
            $no++;
            $row = array();
            $row[] = $item->name;
            $row[] = $item->rate;
            $type = $item->type==1? lang('percentage'): lang('fixed');
            $row[] = $type;

            //add html for action
            $row[] = '<div class="btn-group"><a class="btn btn-xs btn-default" href="javascript:void(0)" onclick="edit_title('."'".$item->id."'".')"><i class="fa fa-pencil"></i></a>
				  <a class="btn btn-xs btn-danger" href="javascript:void(0)"  onclick="deleteItem('."'".$item->id."'".')"><i class="glyphicon glyphicon-trash"></i></a></div>';
            $data[] = $row;
        }
        $this->global_model->render_table($data);
    }


    public function edit_tax($id)
    {
        $this->global_model->table = 'tax';
        $data = $this->global_model->get_by_id($id);
        echo json_encode($data);
    }

    public function add_tax()
    {
        $this->global_model->table = 'tax';
        $this->_tax_validate();
        $data = array(
            'name' => $this->input->post('name'),
            'type' => $this->input->post('type'),
            'rate' => (double)$this->input->post('rate'),

        );
        $insert = $this->global_model->save($data);
        echo json_encode(array("status" => TRUE));
    }

    public function update_tax()
    {
        $this->global_model->table = 'tax';
        $this->_tax_validate();
        $data = array(
            'name' => $this->input->post('name'),
            'type' => $this->input->post('type'),
            'rate' => (double)$this->input->post('rate'),
        );
        $this->global_model->update(array('id' => $this->input->post('id')), $data);
        echo json_encode(array("status" => TRUE));
    }

    public function tax_department($id)
    {
        $this->global_model->table = 'tax';

        $result = $this->db->get_where('tax', array('id' => $id ))->result();

        if(empty($result)){
            $this->global_model->delete_by_id($id);
            echo 1;
        }else{
            echo 0;
        }

    }


    private function _tax_validate()
    {
        $rules = array(
            array('field'=>'name', 'label'=> lang('name'), 'rules'=>'trim|required'),
            array('rate'=>'rate', 'label'=> lang('rate'), 'rules'=>'trim|required'),
        );

        $this->global_model->validation($rules);
    }







}