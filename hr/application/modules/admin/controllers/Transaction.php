<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Transaction extends Admin_Controller
{
    private $newTransactionBalance;

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_builder');
        $this->load->library('form_validation');
        $this->mTitle = TITLE;
        $this->load->model('global_model');
    }



    function chartOfAccount()
    {
        $account_type = $this->db->get('account_type')->result();

        //$account_head;
        foreach($account_type as $type)
        {

            $tem_head = $this->db->select('account_head.*,account_type.account_type')
                ->from('account_head')
                ->join('account_type', 'account_head.account_type_id = account_type.id', 'left')
                ->where('account_head.account_type_id', $type->id)
                ->get()
                ->result();

            foreach($tem_head as $item){
               $result[] = $item;
            }

        }

        $this->mViewData['account_head'] = $result;
        $this->mTitle .= lang('chart_of_accounts');
        $this->render('transaction/chart_of_account');

    }

    function add_account()
    {
        $data['modal_subview'] = $this->load->view('admin/transaction/_modals/add_account','', FALSE);
        $this->load->view('admin/_partials/_layout_modal_small', $data);
    }

    function save_new_account()
    {
        $id = $this->input->post('id');
        if(!empty($id)){
            $id = $this->encrypt->decode(str_replace(array('-', '_', '~'), array('+', '/', '='), $id));
            if(empty($id)){
                $this->message->norecord_found('admin/transaction/chartOfAccount');
            }
        }

        $this->form_validation->set_rules('account_title', lang('account_name'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('description', lang('description'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('account_number', lang('account_number'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('phone', lang('phone'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('address', lang('address'), 'trim|required|xss_clean');


        if ($this->form_validation->run() == TRUE) {

            $data['account_title']      = $this->input->post('account_title');
            $data['description']        = $this->input->post('description');
            $data['account_number']     = $this->input->post('account_number');
            $data['phone']              = $this->input->post('phone');
            $data['address']            = $this->input->post('address');
            $data['account_type_id']    = 1;

            if($id){
                $this->db->where('id', $id);
                $this->db->update('account_head', $data);
            }else{
                $this->db->insert('account_head', $data);
            }

            $this->message->save_success('admin/transaction/chartOfAccount/');
        } else {
            $error = validation_errors();
            $this->message->custom_error_msg('admin/transaction/chartOfAccount/', $error);
        }
    }


    function addTransaction()
    {
        $this->mTitle= lang('add_transaction');
        $this->mViewData['account'] = $this->db->get_where('account_head', array(
                                        'account_type_id' => 1
                                    ))->result();
        $this->render('transaction/add_transactions');

    }

    function get_transaction_category()
    {
        $type = $this->input->post('type');

        if($type == 'Deposit' || $type == 'AR'){
            $id = 1;
        }else{
            $id = 2;
        }

        $category = $this->db->order_by('name', 'asc')->get_where('transaction_category', array(
                            'type' => $id
                        ))->result();


        if ($category) {

            foreach ($category as $item) {
               $HTML.="<option value='" . $item->id . "'>" . $item->name. "</option>";
            }
        }
        echo $HTML;

    }

    function save_transaction()
    {
       $transaction_type = $this->input->post('transaction_type');



        $this->form_validation->set_rules('transaction_type', lang('transaction_type'), 'trim|required|xss_clean');
        if($transaction_type == 'Deposit' || $transaction_type == 'Expenses' ) {
            $this->form_validation->set_rules('account', lang('account'), 'trim|required|xss_clean');
            $this->form_validation->set_rules('payment_method', lang('payment_method'), 'trim|required|xss_clean');
            $this->form_validation->set_rules('category_id', lang('category'), 'trim|required|xss_clean');
        }elseif($transaction_type == 'TR'){
            $this->form_validation->set_rules('from_account', lang('from_account'), 'trim|required|xss_clean');
            $this->form_validation->set_rules('to_account', lang('to_account'), 'trim|required|xss_clean');
            $this->form_validation->set_rules('payment_method', lang('payment_method'), 'trim|required|xss_clean');
        }else{
            $this->form_validation->set_rules('category_id', lang('category'), 'trim|required|xss_clean');
        }

        $this->form_validation->set_rules('amount', lang('amount'), 'trim|required|xss_clean|numeric');
        $this->form_validation->set_rules('description', lang('description'), 'trim|required|xss_clean');


        if ($this->form_validation->run() == TRUE) {

            if($transaction_type == 'Deposit' || $transaction_type == 'Expenses' ) {
                $data['account_id']             = $this->input->post('account');
                $data['payment_method']         = $this->input->post('payment_method');
                $data['category_id']            = $this->input->post('category_id');
            }elseif($transaction_type == 'TR'){
                $from_account_id                = $this->input->post('from_account');
                $to_account_id                     = $this->input->post('to_account');
                $data['payment_method']         = $this->input->post('payment_method');

                if($from_account_id == $to_account_id) {
                    $this->message->custom_error_msg('admin/transaction/addTransaction', lang('same_account_transfer_not_allowed'));
                }

            }else{
                $data['category_id']            = $this->input->post('category_id');
            }

            if($transaction_type == 'AP'){
                $data['account_id']    = 4;
            }elseif($transaction_type == 'AR'){
                $data['account_id']    = 2;
            }


                $transaction_type = $this->_transaction_type($transaction_type);
                $data['transaction_type_id'] = $transaction_type[0];
                $data['transaction_type'] = $transaction_type[1];


            $data['amount']                     = floatval($this->input->post('amount'));
            $data['ref']                        = $this->input->post('ref');
            $data['description']                = $this->input->post('description');


            if($data['transaction_type_id'] == 3){//Accounts Payable(A/P)
                $balance = $this->db->get_where('account_head', array(
                    'id' => 4
                ))->row()->balance;

                $data['balance']            = $balance + $data['amount'];
                $account_head['balance']    = $balance + $data['amount'];

                $this->db->where('id', 4);
                $this->db->update('account_head', $account_head);

            }elseif($data['transaction_type_id'] == 4){//Accounts Receivable(A/R)
                $balance = $this->db->get_where('account_head', array(
                    'id' => 2
                ))->row()->balance;

                $data['balance']            = $balance + $data['amount'];
                $account_head['balance']    = $balance + $data['amount'];

                $this->db->where('id', 2);
                $this->db->update('account_head', $account_head);

            }elseif($data['transaction_type_id'] == 5){//Transfer Balance

                $from_account_balance = $this->db->get_where('account_head', array(
                    'id' => $from_account_id
                ))->row()->balance;

                $to_account_balance = $this->db->get_where('account_head', array(
                    'id' => $to_account_id
                ))->row()->balance;

                $data_form['balance']            = $from_account_balance - $data['amount'];
                $data_to['balance']              = $to_account_balance + $data['amount'];

                $this->db->where('id', $from_account_id);
                $this->db->update('account_head', $data_form);

                $this->db->where('id', $to_account_id);
                $this->db->update('account_head', $data_to);




            }else{//account

                $balance = $this->db->get_where('account_head', array(
                    'id' => $data['account_id']
                ))->row()->balance;

                if($data['transaction_type_id'] == 1)
                {
                    //Deposit
                    $data['balance']            = $balance + $data['amount'];
                    $account_head['balance']    = $balance + $data['amount'];

                    $this->db->where('id', $data['account_id']);
                    $this->db->update('account_head', $account_head);
                }

                if($data['transaction_type_id'] == 2)
                {
                    //Expenses
                    $data['balance']            = $balance - $data['amount'];
                    $account_head['balance']    = $balance - $data['amount'];

                    $this->db->where('id', $data['account_id']);
                    $this->db->update('account_head', $account_head);
                }

            }


            if($data['transaction_type_id'] != 5) {
                $this->db->insert('transactions', $data);

                $id = $this->db->insert_id();
                $prefix = TRANSACTION_PREFIX;
                $transaction_id['transaction_id'] = $prefix + $id;

                $this->db->where('id', $id);
                $this->db->update('transactions', $transaction_id);
            }else{

                //from account Transfer
                $this->db->insert('transactions', $data);
                $trn_from_id = $this->db->insert_id();
                $prefix = TRANSACTION_PREFIX;
                $data_form['transaction_id'] = $prefix + $trn_from_id;
                $data_form['transaction_type']      = lang('transfer');
                $data_form['transaction_type_id']   = 5 ;
                $data_form['account_id']   = $from_account_id ;
                $data_form['category_id']   = 99 ;

                $this->db->where('id', $trn_from_id);
                $this->db->update('transactions', $data_form);

                //to account Transfer
                $this->db->insert('transactions', $data);
                $trn_to_id = $this->db->insert_id();
                $prefix = TRANSACTION_PREFIX;
                $data_to['transaction_id'] = $prefix + $trn_to_id;
                $data_to['transaction_type']        = lang('deposit');
                $data_to['transaction_type_id']     = 1 ;
                $data_to['account_id']              = $to_account_id ;
                $data_to['category_id']             = 99 ;


                $this->db->where('id', $trn_to_id);
                $this->db->update('transactions', $data_to);

                $ref = array(
                    array(
                        'id' => $trn_from_id,
                        'transfer_ref' => $data_to['transaction_id']
                    ),
                    array(
                        'id' => $trn_to_id ,
                        'transfer_ref' => $data_form['transaction_id']
                    )
                );
                $this->db->update_batch('transactions',$ref, 'id');



            }


            $this->message->save_success('admin/transaction/addTransaction');
        } else {
            $error = validation_errors();;
            $this->message->custom_error_msg('admin/transaction/addTransaction',$error);
        }
    }

    function _transaction_type($prm)
    {
        /* @transaction_type
         *
         * Deposit
         * Expense
         * Accounts Payable
         * Accounts Payable
         *
         * @transaction_type_id
         *
         * 1 = Deposit
         * 2 = Expense
         * 3 = Accounts Payable(A/P)
         * 4 = Accounts Receivable(A/R)
         *
         * */

        switch ($prm) {
            case "Deposit":
                $transaction[0] = '1';
                $transaction[1] = lang('deposit');
                return $transaction;
                break;
            case "Expenses":
                $transaction[0] = '2';
                $transaction[1] = lang('expense');
                return $transaction;
                break;
            case "AP":
                $transaction[0] = '3';
                $transaction[1] = 'A/P';

                return $transaction;
                break;
            case "AR":
                $transaction[0] = '4';
                $transaction[1] = 'A/R';
                return $transaction;
                break;
            case "TR":
                $transaction[0] = '5';
                $transaction[1] = lang('account_transfer');
                return $transaction;
                break;

        }
    }

    function allTransaction()
    {
        $this->mViewData['modal'] = FALSE;
        $this->mViewData['account'] = $this->db->get('account_head')->result();
        $this->mTitle .= lang('transactions_list');
        $this->render('transaction/transaction_list');
    }

    public function transaction_list()
    {

        $this->global_model->table = 'transactions';
        $this->global_model->order = array('id' => 'desc');
        $list = $this->global_model->get_transactions_dataTables();


        $data = array();
        $no = $_POST['start'];


            foreach ($list as $item) {

                //str_replace(array('+', '/', '='), array('-', '_', '~'), $this->encrypt->encode($item->category_id))

            $no++;
            $row = array();
            $row[] = '<a href="'. site_url('admin/transaction/view/'.str_replace(array('+', '/', '='), array('-', '_', '~'), $this->encrypt->encode($item->id))) .'">'.$item->transaction_id.'</a>';
            $row[] = '<a href="'. site_url('admin/transaction/viewTransaction/'.str_replace(array('+', '/', '='), array('-', '_', '~'), $this->encrypt->encode('account-'.$item->account_id))) .'">'.$item->account_name.'</a>';
            $row[] = '<a href="'. site_url('admin/transaction/viewTransaction/'.str_replace(array('+', '/', '='), array('-', '_', '~'), $this->encrypt->encode('transaction_type-'.$item->transaction_type_id))) .'">'.$item->transaction_type.'</a>';
            $row[] = '<a href="'. site_url('admin/transaction/viewTransaction/'.str_replace(array('+', '/', '='), array('-', '_', '~'), $this->encrypt->encode('category-'.$item->category_id))) .'">'.$item->category_name .'</a>';

            if($item->transaction_type_id == 1 || $item->transaction_type_id == 4){
                $row[] = '<span class="dr">'.$this->localization->currencyFormat($item->amount).'</span>';
            }else{
                $row[] = '<span class="dr">'.$this->localization->currencyFormat(0).'</span>';
            }

            if($item->transaction_type_id == 2 || $item->transaction_type_id == 3 || $item->transaction_type_id == 5 ){
                $row[] = '<span class="cr">'.$this->localization->currencyFormat($item->amount).'</span>';
            }else{
                $row[] = '<span class="cr">'.$this->localization->currencyFormat(0).'</span>';
            }


            $row[] = '<span class="balance">'.$this->localization->currencyFormat($item->balance).'</span>';
            $row[] = $this->localization->dateFormat($item->date_time);

            //add html for action
            $row[] = '<div class="btn-group"><a class="btn btn-xs btn-default" href="'.site_url('admin/transaction/editTransaction/'.str_replace(array('+', '/', '='), array('-', '_', '~'), $this->encrypt->encode($item->id))).'" ><i class="fa fa-pencil"></i></a>
				  <a class="btn btn-xs btn-danger" onClick="return confirm(\'Are you sure you want to delete?\')" href="'.site_url('admin/transaction/deleteTransaction/'.str_replace(array('+', '/', '='), array('-', '_', '~'), $this->encrypt->encode($item->id))).'" >
				  <i class="glyphicon glyphicon-trash"></i></a></div>';
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->global_model->count_all_transactions(),
            "recordsFiltered" => $this->global_model->count_filtered_transactions(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }



    //    view transaction
    function viewTransaction($id = null)
    {
        if(!empty($id)) {
            $id = $this->encrypt->decode(str_replace(array('-', '_', '~'), array('+', '/', '='), $id));
            $prm = explode("-", $id);
            $this->mViewData['column'] = $prm[0] . '_id';
            $this->mViewData['id'] = $prm[1];

            if($this->mViewData['column'] == 'account_id')
            {
                $result = $this->db->get_where('account_head', array(
                    'id' => $this->mViewData['id']
                ))->row()->account_title;

                if(empty($result)){
                    $this->message->custom_error_msg('admin/transaction/allTransaction', lang('no_record_found'));
                }
            }
            elseif($this->mViewData['column'] == 'transaction_type_id')
            {
                $result = $this->db->get_where('transactions', array(
                    'transaction_type_id' => $this->mViewData['id']
                ))->row()->transaction_type;

                if(empty($result)){
                    $this->message->custom_error_msg('admin/transaction/allTransaction',lang('no_record_found'));
                }
            }
            elseif($this->mViewData['column'] == 'category_id')
            {
                $result = $this->db->get_where('transaction_category', array(
                    'id' => $this->mViewData['id']
                ))->row()->name;

                if(empty($result)){
                    $this->message->custom_error_msg('admin/transaction/allTransaction',lang('no_record_found'));
                }
            }
            else
            {
                $this->message->custom_error_msg('admin/transaction/allTransaction',lang('no_record_found'));
            }

        }else{
            $this->message->custom_error_msg('admin/transaction/allTransaction',lang('no_record_found'));
        }
        $this->mViewData['modal'] = FALSE;
        $this->mViewData['title'] = $result;
        $this->mTitle .= $result;
        $this->render('transaction/transaction_view');
    }


    public function transaction_view($id)
    {

        $prm = explode("-", $id);

        $column = $prm[0];
        $id = $prm[1];
        $this->global_model->table = 'transactions';
        $this->global_model->col = $column;
        $this->global_model->colId = $id;


        $this->global_model->order = array('id' => 'desc');
        $list = $this->global_model->get_transactions_dataTables($column,$id);


        $data = array();
        $no = $_POST['start'];


        foreach ($list as $item) {
            $no++;
            $row = array();
            $row[] = $item->transaction_id;
            if($column != 'account_id') {
                $row[] = '<a href="'. site_url('admin/transaction/viewTransaction/'.str_replace(array('+', '/', '='), array('-', '_', '~'), $this->encrypt->encode('account-'.$item->account_id))) .'">'.$item->account_name.'</a>';
            }
            if($column != 'transaction_type_id') {
                $row[] = '<a href="'. site_url('admin/transaction/viewTransaction/'.str_replace(array('+', '/', '='), array('-', '_', '~'), $this->encrypt->encode('transaction_type-'.$item->transaction_type_id))) .'">'.$item->transaction_type.'</a>';
            }
            if($column != 'category_id') {
                $row[] = '<a href="'. site_url('admin/transaction/viewTransaction/'.str_replace(array('+', '/', '='), array('-', '_', '~'), $this->encrypt->encode('category-'.$item->category_id))) .'">'.$item->category_name .'</a>';
            }
            //$row[] =$column;

            if($item->transaction_type_id == 1 || $item->transaction_type_id == 4){
                $row[] = '<span class="dr">'.$this->localization->currencyFormat($item->amount).'</span>';
            }else{
                $row[] = '<span class="dr">'.$this->localization->currencyFormat(0).'</span>';
            }

            if($item->transaction_type_id == 2 || $item->transaction_type_id == 3 || $item->transaction_type_id == 5 ){
                $row[] = '<span class="cr">'.$this->localization->currencyFormat($item->amount).'</span>';
            }else{
                $row[] = '<span class="cr">'.$this->localization->currencyFormat(0).'</span>';
            }


            $row[] = '<span class="balance">'.$this->localization->currencyFormat($item->balance).'</span>';
            $row[] = $this->localization->dateFormat($item->date_time);

            //add html for action
            $row[] = '<div class="btn-group"><a class="btn btn-xs btn-default" href="'.site_url('admin/transaction/editTransaction/'.str_replace(array('+', '/', '='), array('-', '_', '~'), $this->encrypt->encode($item->id))).'" ><i class="fa fa-pencil"></i></a>
				  <a class="btn btn-xs btn-danger" onClick="return confirm(\'Are you sure you want to delete?\')" href="'.site_url('admin/transaction/deleteTransaction/'.str_replace(array('+', '/', '='), array('-', '_', '~'), $this->encrypt->encode($item->id))).'" >
				  <i class="glyphicon glyphicon-trash"></i></a></div>';
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->global_model->count_all_transactions(),
            "recordsFiltered" => $this->global_model->count_filtered_transactions(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    function searchTransactions(){

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
        $this->mTitle .= lang('search_transaction');
        $this->render('transaction/search');

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


    function deleteTransaction($id=null)
    {
        $id = $this->encrypt->decode(str_replace(array('-', '_', '~'), array('+', '/', '='), $id));


        //select all transaction will effected
        $result = $this->db->select("*")
            ->from('transactions')
            ->where('id >', $id)
            ->order_by('id', 'asc')
            ->get()
            ->result();

        //select delete transaction row
        $transaction = $this->db->get_where('transactions', array(
            'id' => $id
        ))->row();

        $transaction == TRUE || $this->message->norecord_found('admin/transaction/allTransaction');

        /**
         * @deposit balance adjustment
         *
         * @deposit deduct from accounts head
         * @select delete transaction row amount and balance
         * @newTransactionBalance = balance - amount
         * @adjustTransactionBalance
         *
         * @deposit     =1
         * @expense     =2
         * @AP          =3
         * @AR          =4
         * @transfer    =5
         *
         */

        //Account head select
        $account_balance = $this->db->get_where('account_head', array(
            'id' => $transaction->account_id
        ))->row()->balance;

        if($transaction->transaction_type_id == 1){//deposit

            $accountBalance['balance'] = $account_balance - $transaction->amount;

            $this->db->where('id', $transaction->account_id);
            $this->db->update('account_head', $accountBalance);

            //Batch Update
            $this->newTransactionBalance = $transaction->balance - $transaction->amount;
            $this->_adjust_balance($result, $transaction);

            //Delete transactions
            $this->db->delete('transactions', array('id' => $id));

            //if account transfer has
            if(!empty($transaction->transfer_ref)){
                //Batch Update
                $this->_transfer_adjestment($transaction->transfer_ref);
            }


        }elseif($transaction->transaction_type_id == 2 || $transaction->transaction_type_id == 5){//expense and transfer

            $accountBalance['balance'] = $account_balance + $transaction->amount;

            $this->db->where('id', $transaction->account_id);
            $this->db->update('account_head', $accountBalance);

            //Batch Update
            $this->newTransactionBalance = $transaction->balance + $transaction->amount;
            $this->_adjust_balance($result, $transaction);

            //Delete transactions
            $this->db->delete('transactions', array('id' => $id));

            //if account transfer has
            if(!empty($transaction->transfer_ref)){
                $this->_transfer_adjestment($transaction->transfer_ref);
            }


        }elseif($transaction->transaction_type_id == 3 || $transaction->transaction_type_id == 4){//accounts payable

            $accountBalance['balance'] = $account_balance - $transaction->amount;

            $this->db->where('id', $transaction->account_id);
            $this->db->update('account_head', $accountBalance);

            //Batch Update
            $this->newTransactionBalance = $transaction->balance - $transaction->amount;
            $this->_adjust_balance_other($result, $transaction);

            //Delete transactions
            $this->db->delete('transactions', array('id' => $id));

        }

        $this->message->delete_success('admin/transaction/allTransaction');


    }

    private function _adjust_balance($result, $transaction)
    {
        foreach($result as $item){
            if($transaction->account_id == $item->account_id ) {

                if ($item->transaction_type_id == 1) {
                    $this->newTransactionBalance += $item->amount;
                    $transUpdate[] = array(
                        'id' => $item->id,
                        'balance' => $this->newTransactionBalance,
                    );
                } elseif ($item->transaction_type_id == 2 || $item->transaction_type_id == 5) {
                    $this->newTransactionBalance -= $item->amount;
                    $transUpdate[] = array(
                        'id' => $item->id,
                        'balance' => $this->newTransactionBalance,
                    );

                }

            }
        }
        if(!empty($transUpdate)){
            $this->db->update_batch('transactions',$transUpdate, 'id');
        }

    }

    private function _transfer_adjestment($transfer_ref)
    {
        $transfer = $this->db->get_where('transactions', array(
            'transaction_id' => $transfer_ref
        ))->row();

        $result = $this->db->select("*")
            ->from('transactions')
            ->where('id >', $transfer->id)
            ->order_by('id', 'asc')
            ->get()
            ->result();

        //account head
        $account_balance = $this->db->get_where('account_head', array(
            'id' => $transfer->account_id
        ))->row()->balance;

        if($transfer->transaction_type_id == 5){
            $accountBalance['balance'] = $account_balance + $transfer->amount;
            $this->newTransactionBalance = $transfer->balance + $transfer->amount;
        }else{

            $accountBalance['balance'] = $account_balance - $transfer->amount;
            $this->newTransactionBalance = $transfer->balance - $transfer->amount;
        }

        //update account head
        $this->db->where('id', $transfer->account_id);
        $this->db->update('account_head', $accountBalance);

        foreach($result as $item){
            if($transfer->account_id == $item->account_id ) {

                if ($item->transaction_type_id == 1) {
                    $this->newTransactionBalance += $item->amount;
                    $transUpdate[] = array(
                        'id' => $item->id,
                        'balance' => $this->newTransactionBalance,
                    );
                } elseif ($item->transaction_type_id == 2 || $item->transaction_type_id == 5) {
                    $this->newTransactionBalance -= $item->amount;
                    $transUpdate[] = array(
                        'id' => $item->id,
                        'balance' => $this->newTransactionBalance,
                    );
                }
            }
        }

        //Delete transactions
        $this->db->delete('transactions', array('id' => $transfer->id));

        if(!empty($transUpdate)){
            //return $transUpdate;
            $this->db->update_batch('transactions',$transUpdate, 'id');
        }

    }

    private function _adjust_balance_other($result, $transaction)
    {
        foreach($result as $item){
            if($transaction->account_id == $item->account_id ) {

                if ($item->transaction_type_id == 1 || $item->transaction_type_id == 3 || $item->transaction_type_id == 4 ) {
                    $this->newTransactionBalance += $item->amount;
                    $transUpdate[] = array(
                        'id' => $item->id,
                        'balance' => $this->newTransactionBalance,
                    );
                } elseif ($item->transaction_type_id == 2) {
                    $this->newTransactionBalance -= $item->amount;
                    $transUpdate[] = array(
                        'id' => $item->id,
                        'balance' => $this->newTransactionBalance,
                    );
                }

            }
        }
        if(!empty($transUpdate)){
            $this->db->update_batch('transactions',$transUpdate, 'id');
        }

    }

    function editTransaction($id)
    {
        $id = $this->encrypt->decode(str_replace(array('-', '_', '~'), array('+', '/', '='), $id));

        $result = $this->db->select('transactions.*, account_head.account_title, transaction_category.name as category_name ')
            ->from('transactions')
            ->join('account_head', 'account_head.id = transactions.account_id', 'left')
            ->join('transaction_category', 'transaction_category.id = transactions.category_id', 'left')
            ->where('transactions.id', $id)
            ->get()
            ->row();


        $result == TRUE || $this->message->norecord_found('admin/transaction/allTransaction');

        if(!empty($result->transfer_ref)){
            $transfer_form = $this->db->select('transactions.*, account_head.account_title, transaction_category.name as category_name ')
                ->from('transactions')
                ->join('account_head', 'account_head.id = transactions.account_id', 'left')
                ->join('transaction_category', 'transaction_category.id = transactions.category_id', 'left')
                ->where('transactions.transaction_id', $result->transfer_ref)
                ->get()
                ->row();
            $this->mViewData['transaction_from'] = $transfer_form;
        }

        $this->mViewData['transaction'] = $result;
        $this->mViewData['account'] = $this->db->get_where('account_head', array(
            'account_type_id' => 1
        ))->result();


        $this->mTitle .= lang('edit_transaction');
        $this->render('transaction/edit_transaction');

    }

    function view($id)
    {
        $id = $this->encrypt->decode(str_replace(array('-', '_', '~'), array('+', '/', '='), $id));
        $result = $this->db->select('transactions.*, account_head.account_title, transaction_category.name as category_name ')
            ->from('transactions')
            ->join('account_head', 'account_head.id = transactions.account_id', 'left')
            ->join('transaction_category', 'transaction_category.id = transactions.category_id', 'left')
            ->where('transactions.id', $id)
            ->get()
            ->row();


        $result == TRUE || $this->message->norecord_found('admin/transaction/allTransaction');

        if(!empty($result->transfer_ref)){
            $transfer_form = $this->db->select('transactions.*, account_head.account_title, transaction_category.name as category_name ')
                ->from('transactions')
                ->join('account_head', 'account_head.id = transactions.account_id', 'left')
                ->join('transaction_category', 'transaction_category.id = transactions.category_id', 'left')
                ->where('transactions.transaction_id', $result->transfer_ref)
                ->get()
                ->row();
            $this->mViewData['transaction_from'] = $transfer_form;
        }

        $this->mViewData['transaction'] = $result;
        $this->mViewData['account'] = $this->db->get_where('account_head', array(
            'account_type_id' => 1
        ))->result();


        $this->mTitle .= lang('view_transaction');
        $this->render('transaction/view_transaction');
    }

    function update_transaction()
    {
        $id = $this->my_encryption->decode($this->input->post('id'));

        $result = $this->db->get_where('transactions', array(
            'id' => $id
        ))->row();

        $result == TRUE || $this->message->norecord_found('admin/transaction/allTransaction');

        $this->form_validation->set_rules('description', lang('description'), 'trim|required|xss_clean');
        if($result->transaction_type_id == 3 || $result->transaction_type_id == 4){
            $this->form_validation->set_rules('account', lang('account'), 'trim|required|xss_clean');
            $this->form_validation->set_rules('payment_method', lang('payment_method'), 'trim|required|xss_clean');
        }


        if ($this->form_validation->run() == TRUE) {


            if($result->transaction_type_id == 3 || $result->transaction_type_id == 4){

                //account head select
                $balance = $this->db->get_where('account_head', array(
                    'id' => $result->account_id
                ))->row()->balance;

                $accountHeadBalance['balance'] = $balance - $result->amount;
                //update account head
                $this->db->where('id', $result->account_id);
                $this->db->update('account_head', $accountHeadBalance);

                //select all transaction will effected
                $affectedRow = $this->db->select("*")
                    ->from('transactions')
                    ->where('id >', $id)
                    ->order_by('id', 'asc')
                    ->get()
                    ->result();

                $this->newTransactionBalance = $result->balance - $result->amount;
                $this->_adjust_balance_other($affectedRow, $result);

                //create new transaction
                $data['account_id'] = $this->input->post('account');
                $data['payment_method'] = $this->input->post('payment_method');
                $result->transaction_type_id == 3 ? $data['transaction_type'] = 'Expenses' : $data['transaction_type'] = 'Deposit';

                $accountBalance = $this->db->get_where('account_head', array(
                    'id' => $data['account_id']
                ))->row()->balance;

                if($result->transaction_type_id == 3){//expense
                    $data['transaction_type'] = 'Expenses';
                    $data['transaction_type_id'] = 2;
                    $data['balance'] = $accountBalance - $result->amount;
                    $newHeadBalance['balance'] = $accountBalance - $result->amount;

                }else{//deposit
                    $data['transaction_type'] = 'Deposit';
                    $data['transaction_type_id'] = 1;
                    $data['balance'] = $accountBalance + $result->amount;
                    $newHeadBalance['balance'] = $accountBalance + $result->amount;
                }
                $data['category_id'] = $result->category_id;
                $data['amount'] = $result->amount;

                //insert transaction
                $this->db->insert('transactions', $data);

                $id = $this->db->insert_id();
                $prefix = TRANSACTION_PREFIX;
                $transaction_id['transaction_id'] = $prefix + $id;

                $this->db->where('id', $id);
                $this->db->update('transactions', $transaction_id);

                //update new account balance
                $this->db->where('id', $data['account_id']);
                $this->db->update('account_head', $newHeadBalance);

                //delete transaction
                $this->db->delete('transactions', array('id' => $result->id));


            }else{
                $data['description'] = $this->input->post('description');
                $data['ref'] = $this->input->post('ref');

                //update
                $this->db->where('id', $result->id);
                $this->db->update('transactions', $data);

            }

            $this->message->save_success('admin/transaction/allTransaction');
        } else {
            $error = validation_errors();;
            $this->message->custom_error_msg('admin/transaction/editTransaction/'.$this->my_encryption->encode($id),$error);
        }

    }

    function editAccount($id = null){
        $id = $this->encrypt->decode(str_replace(array('-', '_', '~'), array('+', '/', '='), $id));
        $result = $this->db->get_where('account_head',array(
                    'id' => $id
                  ))->row();

        $result == TRUE || $this->message->norecord_found('admin/transaction/chartOfAccount');
        $data['account'] = $result;

        $data['modal_subview'] = $this->load->view('admin/transaction/_modals/add_account',$data, FALSE);
        $this->load->view('admin/_partials/_layout_modal_small', $data);
    }

    function deleteAccount($id = null){
        $id = $this->encrypt->decode(str_replace(array('-', '_', '~'), array('+', '/', '='), $id));
        $id == TRUE || $this->message->norecord_found('admin/transaction/chartOfAccount');

        $result = $this->db->get_where('transactions',array(
            'account_id' => $id
        ))->row();

        if($result){
            $this->message->custom_error_msg('admin/transaction/chartOfAccount', lang('record_has_been_used'));
        }else{
            $this->db->delete('account_head', array('id' => $id));
            $this->message->delete_success('admin/transaction/chartOfAccount');
        }
    }


    //============================================================
    //************************Income Categories*******************
    //============================================================


    function incomeCategory()
    {
        $this->mViewData['category'] = $this->db->order_by('name', 'asc')->get_where('transaction_category', array(
            'type' => 1
        ))->result();
        $this->mTitle .= lang('income_categories');
        $this->render('transaction/income_category');
    }

    function add_income_category($id = null)
    {
        $data['category'] = $this->db->get_where('transaction_category', array(
            'id' => $id
        ))->row();

        $data['modal_subview'] = $this->load->view('admin/transaction/_modals/add_income_category',$data, FALSE);
        $this->load->view('admin/_partials/_layout_modal_small', $data);
    }

    function save_income_category()
    {
        $this->form_validation->set_rules('name', lang('name'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('description', lang('description'), 'trim|required|xss_clean');

        if ($this->form_validation->run() == TRUE) {

            $id = $this->input->post('id');
            $data['name'] = $this->input->post('name');
            $data['description'] = $this->input->post('description');

            if(empty($id)){
                $data['type'] = 1;
                $this->db->insert('transaction_category', $data);
            }else{
                $this->db->where('id', $id);
                $this->db->update('transaction_category', $data);
            }

            $this->message->save_success('admin/transaction/incomeCategory');

        } else {
            $error = validation_errors();
            $this->message->custom_error_msg('admin/transaction/incomeCategory', $error);
        }
    }






    //============================================================
    //************************expense Categories*******************
    //============================================================

    function expenseCategory()
    {
        $this->mViewData['category'] = $this->db->order_by('name', 'asc')->get_where('transaction_category', array(
            'type' => 2
        ))->result();
        $this->mTitle .= lang('expense_categories');
        $this->render('transaction/expense_category');
    }

    function add_expense_category($id = null)
    {
        $data['category'] = $this->db->get_where('transaction_category', array(
            'id' => $id
        ))->row();

        $data['modal_subview'] = $this->load->view('admin/transaction/_modals/add_expense_category',$data, FALSE);
        $this->load->view('admin/_partials/_layout_modal_small', $data);
    }

    function save_expense_category()
    {
        $this->form_validation->set_rules('name', lang('name'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('description', lang('description'), 'trim|required|xss_clean');

        if ($this->form_validation->run() == TRUE) {

            $id = $this->input->post('id');
            $data['name'] = $this->input->post('name');
            $data['description'] = $this->input->post('description');

            if(empty($id)){
                $data['type'] = 2;
                $this->db->insert('transaction_category', $data);
            }else{
                $this->db->where('id', $id);
                $this->db->update('transaction_category', $data);
            }

            $this->message->save_success('admin/transaction/expenseCategory');

        } else {
            $error = validation_errors();
            $this->message->custom_error_msg('admin/transaction/save_expense_category', $error);
        }
    }


    function deleteCategory($id = null)
    {
        $result = count($this->db->get_where('transactions',array(
            'category_id' => $id
        ))->result());

        $category =  $this->db->get_where('transaction_category', array(
            'id' => $id
        ))->row();

        if($category->type == 1){
            $url = 'admin/transaction/incomeCategory';
        }else{
            $url = 'admin/transaction/expenseCategory';
        }

        if($result)
        {
            $this->message->custom_error_msg($url, lang('record_has_been_used'));
        }else
        {
            $this->db->delete('transaction_category', array('id' => $id));
            $this->message->delete_success($url);
        }
    }


}