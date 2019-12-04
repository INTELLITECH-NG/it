<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Home page
 */
class Home extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->mTitle = TITLE;

		// only login users can access Account controller
		$this->verify_login();
		$user = $this->ion_auth->user()->row();
		if($user->type != 'user'){
			redirect('auth/login');
		}
		$this->load->model('employee_model');


	}

	public function index()
	{
		$user = $this->ion_auth->user()->row();

		$weekend = $this->db->get_where('working_days', array(
				'flag' => 0
		))->result();

		if(count($weekend)){
			foreach($weekend as $item){
				$days[]= date('w', strtotime($item->days));
			}
		}
		$month = date('m');
		$year = date('Y');
		$weeklyOfDays = $this->countDays($year, $month, $days);
		$public_holiday = count($this->total_attendace_in_month($user->employee_id, TRUE));
		$totalWorkingDays = $weeklyOfDays - $public_holiday;

		$this->mViewData['total_working_days'] = $totalWorkingDays;
		$this->mViewData['total_attendance'] = count($this->total_attendace_in_month($user->employee_id));

		//Award
		$this->mViewData['award'] = count($this->db->get_where('employee_award', array(
				'employee_id' => $user->employee_id
		))->result());

		//holiday this month
		$start_date= date('Y-m-01');
		$end_date = date('Y-m-t');

		$this->mViewData['holidays'] =	$this->db->select("*")
				->from('holidays')
				->where('start_date>=', $start_date)
				->where('end_date<=', $end_date)
				->order_by('start_date', 'asc')
				->get()
				->result();

		$today = date('Y-m-d');

		$this->mViewData['notice'] = $this->db->select("*")
				->from('notice')
				->where('date >=', $today)
				->where('status', 'Published')
				->order_by('date', 'asc')
				->get()
				->result();

		$firstDateYear= date('Y-01-01');
		$lastDateYear = date('Y-12-31');

		$this->mViewData['approved_leave'] = count($this->db->select("*")
				->from('leave_application')
				->where('start_date>=', $firstDateYear)
				->where('end_date<=', $lastDateYear)
				->where('employee_id', $user->employee_id)
				->where('status', 'Accepted')
				->get()->result());

		$this->mTitle .= lang('employee_home_page');
		$this->render('home');
	}

	function allEvents(){

		$start_date= date('Y-m-01');
		$end_date = date('Y-m-t');
		$this->mViewData['events'] =	$this->db->select("*")
				->from('holidays')
				->where('start_date>=', $start_date)
				->where('end_date<=', $end_date)
				->order_by('start_date', 'asc')
				->get()
				->result();
		$this->mTitle .= lang('list_all_events');
		$this->render('all_events');
	}

	function allNotice(){

		$today = date('Y-m-d');
		$this->mViewData['notice'] =	$this->db->select("*")
				->from('notice')
				->where('date >=', $today)
				->where('status', 'Published')
				->order_by('date', 'asc')
				->get()
				->result();

		$this->mViewData['panel'] = TRUE;
		$this->mTitle .= lang('list_of_notice');
		$this->render('all_notice');

	}

	function viewEvents($id = null){
		$id = $this->encrypt->decode(str_replace(array('-', '_', '~'), array('+', '/', '='), $id));
		$id == TRUE || redirect('employee/home/allEvents');

		$this->mViewData['event'] = $this->db->get_where('holidays', array(
				'holiday_id' => $id
		))->row();

		$this->render('view_events');
	}

	function viewNotice($id = null)
	{
		$id = $this->encrypt->decode(str_replace(array('-', '_', '~'), array('+', '/', '='), $id));
		$id == TRUE || redirect('employee/home/allNotice');
		$this->mViewData['panel'] = TRUE;
		$this->mViewData['empNotice'] = $this->db->get_where('notice', array(
				'id' => $id
		))->row();

		$this->mTitle .= lang('view_notice');

		$this->render('view_notice');
	}



	function countDays($year, $month, $ignore) {
		$count = 0;
		$counter = mktime(0, 0, 0, $month, 1, $year);
		//$counter = mktime(0, 0, 0, 1, 1, 2016);
		while (date("n", $counter) == $month) {
			if (in_array(date("w", $counter), $ignore) == false) {
				$count++;
			}
			$counter = strtotime("+1 day", $counter);
		}
		return $count;
	}

	public function total_attendace_in_month($employee_id, $flag = NULL) {
		$month = date('m');
		$year = date('Y');

		if ($month >= 1 && $month <= 9) { // if i<=9 concat with Mysql.became on Mysql query fast in two digit like 01.
			$start_date = $year . "-" . '0' . $month . '-' . '01';
			$end_date = $year . "-" . '0' . $month . '-' . '31';
		} else {
			$start_date = $year . "-" . $month . '-' . '01';
			$end_date = $year . "-" . $month . '-' . '31';
		}
		if (!empty($flag)) { // if flag is not empty
			$get_public_holiday = $this->employee_model->get_public_holiday($start_date, $end_date);

			if (!empty($get_public_holiday)) {
				foreach ($get_public_holiday as $v_holiday) {
					if ($v_holiday->start_date == $v_holiday->end_date) { // if start date and end date is equal return one data
						$total_holiday[] = $v_holiday->start_date;
					} else { // if start date and end date not equal
						for ($j = $v_holiday->start_date; $j <= $v_holiday->end_date; $j++) {
							$total_holiday[] = $j;
						}
					}
				}
				return $total_holiday;
			}
		} else {
			$get_total_attendance = $this->employee_model->get_total_attendance_by_date($start_date, $end_date, $employee_id); // get all attendace by start date and in date
			return $get_total_attendance;
		}
	}



	function getEvent()
	{

		//$result = $this->db->get('events')->result_array();
		$result = $this->db->get_where('events', array(
				'employee_id' 	=> $this->ion_auth->user()->row()->employee_id,
				'type'			=> 'E'
		))->result_array();
		echo json_encode($result);
	}

	function addEvent()
	{

		$data['title'] = $this->input->post('title');

		$data['start'] 			= $this->input->post('start').' '.$this->input->post('startTime');
		$data['end'] 			= $this->input->post('end').' '.$this->input->post('endTime');
		$data['color'] 			= $this->input->post('color');
		$data['employee_id'] 	= $this->ion_auth->user()->row()->employee_id;
		$data['type'] 			= 'E';

		$this->db->insert('events', $data);
		return true;

		//header('Location: '.$_SERVER['HTTP_REFERER']);
	}

	function editEventDate()
	{
		$id = $_POST['Event'][0];
		$data['start'] = $_POST['Event'][1];
		$data['end'] = $_POST['Event'][2];

		$this->db->where('id', $id);
		$this->db->update('events', $data);

		return true;
	}

	function edit_event()
	{


		$id = $this->input->post('id');
		$delete = $this->input->post('delete');

		if(isset($delete)){
			$this->db->delete('events', array('id' => $id));
			return true;
		}
		$data['title'] = $this->input->post('title');
		$data['start'] = $this->input->post('start').' '.$this->input->post('startTime');
		$data['end'] = $this->input->post('end').' '.$this->input->post('endTime');
		$data['color'] = $this->input->post('color');

		//update
		$this->db->where('id', $id);
		$this->db->update('events', $data);

		return true;
	}


}
