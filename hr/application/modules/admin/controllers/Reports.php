<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reports extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_builder');
        $this->load->model('global_model');
        $this->load->model('crud_model', 'crud');
        $this->load->model('report_model', 'report');
        $this->load->model('attendance_model');
        $this->load->library('grocery_CRUD');
        $this->mTitle = TITLE;
    }

    function index()
    {
        $this->mTitle .= 'Report';
        $this->render('report/report');
    }

    function salesReport()
    {
        $flag = $this->input->post('flag', true);

        if($flag) {
            $start_date = date('Y-m-d', strtotime($this->input->post('start_date', true)));
            $end_date = date('Y-m-d', strtotime($this->input->post('end_date', true)));

            $this->mViewData['start_date'] = $start_date;
            $this->mViewData['end_date'] = $end_date;

            $this->mViewData['invoice'] = $this->report->get_sales_invoice_by_date($start_date, $end_date);
        }
        $this->mTitle .= lang('sales'). lang('report');
        $this->render('report/sales_report');
    }

    function purchaseReport()
    {
        $flag = $this->input->post('flag', true);

        if($flag) {
            $start_date = date('Y-m-d', strtotime($this->input->post('start_date', true)));
            $end_date = date('Y-m-d', strtotime($this->input->post('end_date', true)));

            $this->mViewData['start_date'] = $start_date;
            $this->mViewData['end_date'] = $end_date;

            $this->mViewData['invoice'] = $this->report->get_purchase_invoice_by_date($start_date, $end_date);
        }
        $this->mTitle .= lang('purchase'). lang('report');
        $this->render('report/purchase_report');
    }

    function returnPurchase()
    {
        $flag = $this->input->post('flag', true);

        if($flag) {
            $start_date = date('Y-m-d', strtotime($this->input->post('start_date', true)));
            $end_date = date('Y-m-d', strtotime($this->input->post('end_date', true)));

            $this->mViewData['start_date'] = $start_date;
            $this->mViewData['end_date'] = $end_date;

            $this->mViewData['invoice'] = $this->report->get_returnPurchase_invoice_by_date($start_date, $end_date);
        }
        $this->mTitle .= lang('return_purchase');
        $this->render('report/return_purchase_report');
    }

    function paymentReceived()
    {
        $flag = $this->input->post('flag', true);

        if($flag) {

            $start_date = date('d/m/Y', strtotime($this->input->post('start_date', true)));
            $end_date = date('d/m/Y', strtotime($this->input->post('end_date', true)));

            $this->mViewData['start_date'] = $start_date;
            $this->mViewData['end_date'] = $end_date;

            $this->mViewData['invoice'] = $this->report->get_payment_received_by_date($start_date, $end_date);

            if(empty($this->mViewData['invoice'])){
                $this->mViewData['start_date'] ='';
                $this->mViewData['end_date'] = '';
            }

        }
        $this->mTitle .= lang('payment_received');;
        $this->render('report/received_payment_report');
    }

    function employeeAttendance()
    {

        $sbtn = $this->input->post('sbtn', TRUE);
        $this->form_validation->set_rules('from', 'From', 'required');
        $this->form_validation->set_rules('to', 'To', 'required');
        $this->form_validation->set_rules('department_id', lang('department'), 'required');
        $this->form_validation->set_rules('employee_id', lang('employee'), 'required');


        if($sbtn) {


            if ($this->form_validation->run() == TRUE) {

                $employee_id    = $this->input->post('employee_id', TRUE);
                $department_id  = $this->input->post('department_id', TRUE);

                $start    = (new DateTime($this->input->post('from', TRUE)))->modify('first day of this month');
                $end      = (new DateTime( $this->input->post('to', TRUE)))->modify('first day of next month');
                $interval = DateInterval::createFromDateString('1 month');
                $period   = new DatePeriod($start, $interval, $end);

                $this->mViewData['period'] = $period;

                foreach ($period as $dt) {
                    //echo $dt->format("Y-m") . "<br>\n";
                    $date =  $dt->format("Y-m");

                    //==========How many day in a Month================>>>>>>>>>>>>>>
                    $month = date('n', strtotime($date));
                    $year = date('Y', strtotime($date));

                    $num = cal_days_in_month(CAL_GREGORIAN, $month, $year);

                    $this->mViewData['employee'] = $this->db->get_where('employee', array( 'id' => $employee_id))->row();
                    for ($i = 1; $i <= $num; $i++) {
                        $this->mViewData['dateSl'][$dt->format("Y-m")][] = $i;
                    }

                    //==========Grab Holiday and Public Holiday===========>>>>>>>>>>
                    if ($month >= 1 && $month <= 9) {
                        $yymm = $year . '-' . '0' . $month;
                    } else {
                        $yymm = $year . '-' . $month;
                    }

                    $public_holiday = $this->attendance_model->get_public_holidays($yymm);
                    $holidays = $this->db->get_where('working_days', array( 'flag' => 0 ))->result();


                    //============ tbl a_calendar Days Holiday==========>>>>>>>>>>>>
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

                    //============= Employee Attendance Generate ==================>>>>>>>
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
                            $this->mViewData['attendance'][$dt->format("Y-m")][] = $this->attendance_model->attendance_report_by_empid($employee_id, $sdate, $flag);
                        } else {
                            $this->mViewData['attendance'][$dt->format("Y-m")][] = $this->attendance_model->attendance_report_by_empid($employee_id, $sdate);
                        }

                        $key++;
                        $flag = '';
                    }

                }



                $this->mViewData['from'] = $this->input->post('from', TRUE);
                $this->mViewData['to'] = $this->input->post('to', TRUE);
                $where = array('id' => $department_id);
                $this->mViewData['dept_name'] = $this->attendance_model->check_by($where, 'department');

                $this->mViewData['month'] = date('F-Y', strtotime($yymm));


            } else {
                $error = validation_errors();;
                $this->message->custom_error_msg('admin/reports/employeeAttendance', $error);
            }

        }



        $this->mViewData['all_department'] = $this->db->get('department')->result();
        $this->mViewData['department_id'] = $this->input->post('department_id', TRUE);
        $this->mTitle .= lang('attendance_report');
        $this->render('report/attendance_report');
    }

    function employeeList()
    {
        $flag = $this->input->post('flag', true);

        if($flag) {
            $this->mViewData['employees'] = $this->db->get_where('employee', array( 'department' => $this->input->post('department_id', true)))->result();
        }
        $this->mViewData['all_department'] = $this->db->get('department')->result();
        $this->mTitle .= lang('employee_list');
        $this->render('report/employee_list');
    }

    function payrollList()
    {
        $flag = $this->input->post('flag', true);

        $this->form_validation->set_rules('from', 'From', 'required');
        $this->form_validation->set_rules('to', 'To', 'required');
        $this->form_validation->set_rules('department_id', lang('department'), 'required');
        $this->form_validation->set_rules('employee_id', lang('employee'), 'required');

        if($flag) {
            if ($this->form_validation->run() == TRUE) {
                $from = $this->input->post('from', TRUE);
                $to = $this->input->post('to', TRUE);
                $employee_id = $this->input->post('employee_id', TRUE);

                $this->mViewData['payroll'] = $this->db->get_where('payroll', array(
                            'month >=' => $from,
                            'month <=' => $to,
                            'employee_id <=' => $employee_id,
                            ))->result();

                $this->mViewData['employee'] = $this->db->get_where('employee', array( 'id' => $employee_id))->row();

            }else {
                $error = validation_errors();;
                $this->message->custom_error_msg('admin/reports/payrollList', $error);
            }
        }

        $this->mViewData['all_department'] = $this->db->get('department')->result();
        $this->mViewData['department_id'] = $this->input->post('department_id', TRUE);
        $this->mTitle .= lang('payroll');
        $this->render('report/payroll_list');
    }

    function transaction()
    {
        $flag = $this->input->post('flag', true);

        if($flag) {
            $start_date = $this->input->post('start_date');
            $end_date = $this->input->post('end_date');
            $account_id = $this->input->post('account');
            $transaction_type = $this->input->post('transaction_type');

            $this->mViewData['search'] = array(
                'start_date' => $start_date,
                'end_date' => $end_date,
                'account_id' => $account_id,
                'transaction_type' => $transaction_type,
            );


            $result = $this->_search_transactions($start_date, $end_date, $account_id, $transaction_type );

            $this->mViewData['transactions'] = $result;
            $this->mViewData['account'] = $this->db->get('account_head')->result();
        }
        $this->mViewData['account'] = $this->db->get('account_head')->result();
        $this->mTitle .= lang('transaction');
        $this->render('report/transactions_report');
    }

    function BalanceCheck()
    {
        $flag = $this->input->post('flag', true);

        if($flag) {
            $start_date = $this->input->post('start_date');
            $end_date = $this->input->post('end_date');
            $account_id = $this->input->post('account');


            $this->mViewData['search'] = array(
                'start_date' => $start_date,
                'end_date' => $end_date,
                'account_id' => $account_id,

            );


            $result = $this->_search_transactions($start_date, $end_date, $account_id, '' );

            $this->mViewData['transactions'] = $result;
            $this->mViewData['account'] = $this->db->get('account_head')->result();
        }
        $this->mViewData['account'] = $this->db->get('account_head')->result();
        $this->mTitle .= lang('account') .lang('balance');;
        $this->render('report/account_balance');
    }

    private function _search_transactions($start_date = null, $end_date=null, $account_id = null, $transaction_type = null)
    {

        $this->db->select('transactions.*, account_head.account_title, transaction_category.name', false);
        $this->db->from('transactions');
        $this->db->join('account_head', 'account_head.id  =  transactions.account_id', 'left');
        $this->db->join('transaction_category', 'transaction_category.id  =  transactions.category_id', 'left');



        if(!empty($start_date) && !empty($end_date)){

            $start_date = date('Y-m-d', strtotime($start_date));
            $end_date = date('Y-m-d', strtotime($end_date));

            if ($start_date == $end_date) {
                $this->db->like('transactions.date_time', $start_date);
            } else {
                $this->db->where('transactions.date_time >=', $start_date);
                $this->db->where('transactions.date_time <=', $end_date.' '.'23:59:59');
            }
        }elseif(!empty($start_date)){
            $start_date = date('Y-m-d', strtotime($start_date));
            $this->db->like('transactions.date_time', $start_date);
        }elseif(!empty($end_date)){
            $end_date = date('Y-m-d', strtotime($end_date));
            $this->db->like('transactions.date_time', $end_date);
        }

        if(!empty($account_id)){
            $this->db->where('transactions.account_id', $account_id);
        }

        if(!empty($transaction_type)){
            $this->db->where('transactions.transaction_type_id', $transaction_type);
        }


        $query_result = $this->db->get();
        $result = $query_result->result();

        return $result;
    }

    function customerSales()
    {
        $flag = $this->input->post('flag', true);

        if($flag) {
            $start_date = date('Y-m-d', strtotime($this->input->post('start_date', true)));
            $end_date = date('Y-m-d', strtotime($this->input->post('end_date', true)));
            $customer_id    = $this->input->post('customer_id', true);

            $this->mViewData['start_date'] = $start_date;
            $this->mViewData['end_date'] = $end_date;

            $this->mViewData['invoice'] = $this->report->get_sales_invoice_by_date_customer_id($start_date, $end_date, $customer_id);
            $this->mViewData['customer'] = $this->db->get_where('customer', array('id' => $customer_id ))->row();
        }

        $this->mViewData['customers'] = $this->db->get('customer')->result();
        $this->mTitle .= lang('customer_sales');
        $this->render('report/customer_sales');
    }

    function customerDue()
    {
        $flag = $this->input->post('flag', true);

        if($flag) {
            $start_date = date('Y-m-d', strtotime($this->input->post('start_date', true)));
            $end_date = date('Y-m-d', strtotime($this->input->post('end_date', true)));
            $customer_id    = $this->input->post('customer_id', true);

            $this->mViewData['start_date'] = $start_date;
            $this->mViewData['end_date'] = $end_date;

            $this->mViewData['invoice'] = $this->report->get_sales_due_by_date_customer_id($start_date, $end_date, $customer_id);
            $this->mViewData['customer'] = $this->db->get_where('customer', array('id' => $customer_id ))->row();
        }

        $this->mViewData['customers'] = $this->db->get('customer')->result();
        $this->mTitle .= lang('customer') . lang('payment_due');
        $this->render('report/customer_due');
    }

    function customerOverDue()
    {
        $flag = $this->input->post('flag', true);

        if($flag) {
            $customer_id    = $this->input->post('customer_id', true);
            $this->mViewData['invoice'] = $this->report->get_sales_over_due_customer_id($customer_id);
            $this->mViewData['customer'] = $this->db->get_where('customer', array('id' => $customer_id ))->row();
        }

        $this->mViewData['customers'] = $this->db->get('customer')->result();
        $this->mTitle .= lang('over_due_payment') . lang('report');;
        $this->render('report/customer_over_due');
    }

    function vendorPurchaseReport()
    {
        $flag = $this->input->post('flag', true);

        if($flag) {
            $start_date = date('Y-m-d', strtotime($this->input->post('start_date', true)));
            $end_date = date('Y-m-d', strtotime($this->input->post('end_date', true)));
            $vendor_id    = $this->input->post('vendor_id', true);

            $this->mViewData['start_date'] = $start_date;
            $this->mViewData['end_date'] = $end_date;

            $this->mViewData['invoice'] = $this->report->get_purchase_invoice_by_date_vendor_id($start_date, $end_date, $vendor_id);
            $this->mViewData['vendor'] = $this->db->get_where('vendor', array('id' => $vendor_id ))->row();
        }

        $this->mViewData['vendors'] = $this->db->get('vendor')->result();
        $this->mTitle .= lang('purchase') . lang('report');
        $this->render('report/vendor_purchase_report');
    }

    function vendorPurchaseDuePayment()
    {
        $flag = $this->input->post('flag', true);

        if($flag) {
            $start_date = date('Y-m-d', strtotime($this->input->post('start_date', true)));
            $end_date = date('Y-m-d', strtotime($this->input->post('end_date', true)));
            $vendor_id    = $this->input->post('vendor_id', true);

            $this->mViewData['start_date'] = $start_date;
            $this->mViewData['end_date'] = $end_date;

            $this->mViewData['invoice'] = $this->report->get_purchase_vendor_due_payment($vendor_id);
            $this->mViewData['vendor'] = $this->db->get_where('vendor', array('id' => $vendor_id ))->row();
        }

        $this->mViewData['vendors'] = $this->db->get('vendor')->result();
        $this->mTitle .= lang('payment_due'). lang('report');
        $this->render('report/vendor_purchase_due_payment');
    }

    function vendorPaymentByDate()
    {
        $flag = $this->input->post('flag', true);

        if($flag) {
            $start_date = date('Y-m-d', strtotime($this->input->post('start_date', true)));
            $end_date = date('Y-m-d', strtotime($this->input->post('end_date', true)));
            $vendor_id    = $this->input->post('vendor_id', true);

            $this->mViewData['start_date'] = $start_date;
            $this->mViewData['end_date'] = $end_date;

            $this->mViewData['purchase']  = $this->db->select('vendor_id, vendor_name , count(id) AS total_purchase ,SUM(grand_total) AS grand_total, ,SUM(paid_amount) AS paid_amount, 
                                                                SUM(discount) AS discount_total, SUM(tax) AS tax_total, SUM(shipping) AS transport_total , SUM(due_payment) AS due_payment')
                                                ->from('purchase_order')
                                                ->group_by('vendor_id')
                                                ->where('vendor_id', $vendor_id)
                                                ->where('type', 'Purchase')
                                                ->where('date >=', $start_date)
                                                ->where('date <=', $end_date.' '.'23:59:59')
                                                ->get()
                                                ->row();


            $this->mViewData['vendor'] = $this->db->get_where('vendor', array('id' => $vendor_id ))->row();
        }

        $this->mViewData['vendors'] = $this->db->get('vendor')->result();
        $this->mTitle .= lang('vendor') . lang('payment') . lang('summary') . lang('report');
        $this->render('report/vendor_payment_report_by_date');
    }

    function lifetimePurchase()
    {
        $flag = $this->input->post('flag', true);

        if($flag) {

            $vendor_id    = $this->input->post('vendor_id', true);

            $this->mViewData['purchase']  = $this->db->select('vendor_id, vendor_name , count(id) AS total_purchase ,SUM(grand_total) AS grand_total, ,SUM(paid_amount) AS paid_amount, 
                                                                SUM(discount) AS discount_total, SUM(tax) AS tax_total, SUM(shipping) AS transport_total , SUM(due_payment) AS due_payment')
                                                ->from('purchase_order')
                                                ->group_by('vendor_id')
                                                ->where('vendor_id', $vendor_id)
                                                ->where('type', 'Purchase')
                                                ->get()
                                                ->row();


            $this->mViewData['vendor'] = $this->db->get_where('vendor', array('id' => $vendor_id ))->row();
        }

        $this->mViewData['vendors'] = $this->db->get('vendor')->result();
        $this->mTitle .= lang('life_time_purchase');
        $this->render('report/life_time_purchase');
    }

    function vendorReturnPurchase()
    {
        $flag = $this->input->post('flag', true);

        if($flag) {
            $start_date = date('Y-m-d', strtotime($this->input->post('start_date', true)));
            $end_date = date('Y-m-d', strtotime($this->input->post('end_date', true)));
            $vendor_id    = $this->input->post('vendor_id', true);

            $this->mViewData['start_date'] = $start_date;
            $this->mViewData['end_date'] = $end_date;

            $this->mViewData['invoice'] = $this->report->get_return_purchase_invoice_by_date_vendor_id($start_date, $end_date, $vendor_id);
            $this->mViewData['vendor'] = $this->db->get_where('vendor', array('id' => $vendor_id ))->row();
        }

        $this->mViewData['vendors'] = $this->db->get('vendor')->result();
        $this->mTitle .= lang('return_purchase');
        $this->render('report/vendor_return_purchase_report');
    }

    function customerSummaryReport()
    {
        $flag = $this->input->post('flag', true);

        if($flag) {
            $start_date = date('Y-m-d', strtotime($this->input->post('start_date', true)));
            $end_date = date('Y-m-d', strtotime($this->input->post('end_date', true)));
            $customer_id    = $this->input->post('customer_id', true);

            $this->mViewData['start_date'] = $start_date;
            $this->mViewData['end_date'] = $end_date;

            $this->mViewData['sales']  = $this->db->select('customer_id, customer_name , count(id) AS total_sales ,SUM(grand_total) AS grand_total, ,SUM(amount_received) AS received_amount, 
                                                                SUM(discount) AS discount_total , SUM(due_payment) AS due_payment')
                ->from('sales_order')
                ->group_by('customer_id')
                ->where('customer_id', $customer_id)
                ->where('type', 'Invoice')
                ->where('status !=', 'Cancel')
                ->where('date >=', $start_date)
                ->where('date <=', $end_date.' '.'23:59:59')
                ->get()
                ->row();

            $this->mViewData['customer'] = $this->db->get_where('customer', array('id' => $customer_id ))->row();
        }

        $this->mViewData['customers'] = $this->db->get('customer')->result();
        $this->mTitle .= lang('customer') . lang('summary') . lang('report');
        $this->render('report/customer_summery_report');
    }

    function customerLifetimeSales()
    {
        $flag = $this->input->post('flag', true);

        if($flag) {

            $customer_id    = $this->input->post('customer_id', true);

            $this->mViewData['sales']  = $this->db->select('customer_id, customer_name , count(id) AS total_sales ,SUM(grand_total) AS grand_total, ,SUM(amount_received) AS received_amount, 
                                                                SUM(discount) AS discount_total , SUM(due_payment) AS due_payment')
                ->from('sales_order')
                ->group_by('customer_id')
                ->where('customer_id', $customer_id)
                ->where('type', 'Invoice')
                ->where('status !=', 'Cancel')
                ->get()
                ->row();

            $this->mViewData['customer'] = $this->db->get_where('customer', array('id' => $customer_id ))->row();
        }

        $this->mViewData['customers'] = $this->db->get('customer')->result();
        $this->mTitle .= lang('life_time_sell');
        $this->render('report/customer_lifetime_sales');
    }

    function summaryAccount()
    {
        $flag = $this->input->post('flag', true);

        if($flag) {
            $start_date = date('Y-m-d', strtotime($this->input->post('start_date', true)));
            $end_date = date('Y-m-d', strtotime($this->input->post('end_date', true)));
            $account_id    = $this->input->post('account_id', true);

            $this->mViewData['start_date'] = $start_date;
            $this->mViewData['end_date'] = $end_date;

            $this->mViewData['dr']  = $this->db->select('SUM(amount) AS total_dr')
                ->from('transactions')
                ->group_by('account_id')
                ->where('account_id', $account_id)
                ->where_in('transaction_type_id', array('1','4'))
                ->where('date_time >=', $start_date)
                ->where('date_time <=', $end_date.' '.'23:59:59')
                ->get()
                ->row();

            $this->mViewData['cr']  = $this->db->select('SUM(amount) AS total_cr')
                ->from('transactions')
                ->group_by('account_id')
                ->where('account_id', $account_id)
                ->where_in('transaction_type_id', array('2','3','5'))
                ->where('date_time >=', $start_date)
                ->where('date_time <=', $end_date.' '.'23:59:59')
                ->get()
                ->row();

            $this->mViewData['account_name'] = $this->db->get_where('account_head', array('id' => $account_id ))->row()->account_title;
        }

        $this->mViewData['account'] = $this->db->get('account_head')->result();
        $this->mTitle .= lang('summary'). lang('account'). lang('report');
        $this->render('report/summary_account_report');
    }

    function summaryTransaction()
    {
        $flag = $this->input->post('flag', true);

        if($flag) {
            $start_date = date('Y-m-d', strtotime($this->input->post('start_date', true)));
            $end_date = date('Y-m-d', strtotime($this->input->post('end_date', true)));
            $transaction_type_id    = $this->input->post('transaction_type_id', true);

            $this->mViewData['start_date'] = $start_date;
            $this->mViewData['end_date'] = $end_date;

            $this->mViewData['transaction']  = $this->db->select('COUNT(id) AS total_transaction ,SUM(amount) AS total_amount, transaction_type')
                ->from('transactions')
                ->group_by('transaction_type_id')
                ->where('transaction_type_id', $transaction_type_id)
                ->where('date_time >=', $start_date)
                ->where('date_time <=', $end_date.' '.'23:59:59')
                ->get()
                ->row();
        }

        $this->mTitle .= lang('summary'). lang('transaction'). lang('report');
        $this->render('report/summary_transaction_report');
    }

    function stockValues()
    {
        $this->mViewData['products'] = $this->db->get_where('product', array('type' => 'Inventory' ))->result();
        $this->mTitle .= lang('stock_values');
        $this->render('report/stock_value');
    }

    function stockReport()
    {
        $this->mViewData['products'] = $this->db->get_where('product', array('type' => 'Inventory' ))->result();
        $this->mTitle .= lang('stock_report');
        $this->render('report/stock_report');
    }









}