<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Home page
 */
class Award extends MY_Controller
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
        $this->load->model('global_model');
    }


    function index()
    {
        $this->mTitle .= lang('employee_award');

        $this->render('employee_award');
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

}