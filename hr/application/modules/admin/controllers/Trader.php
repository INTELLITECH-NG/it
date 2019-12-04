<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Trader extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_builder');
        $this->load->model('global_model');
        $this->load->model('sales_model', 'sales');
        $this->load->model('crud_model', 'crud');
        $this->load->library('grocery_CRUD');
        $this->mTitle = TITLE;
    }


    //------------------------------------------------------------------------------------------------------------
    //------------------------------------------------------------------------------------------------------------
    //************************* Customer Section *****************************************************************
    //------------------------------------------------------------------------------------------------------------
    //------------------------------------------------------------------------------------------------------------

    function customerList()
    {
        $this->mTitle .= lang('customer');
        $this->render('sales/customer/customer_list');
    }

    public function customerTable()
    {

        $this->global_model->table = 'customer';
        $this->global_model->column_order = array('name','company_name','phone',null);
        $this->global_model->column_search = array('name','company_name','phone');
        $this->global_model->order = array('id' => 'desc');

        $list = $this->global_model->get_datatables();

        $data = array();
        $no = $_POST['start'];
        foreach ($list as $item) {
            $no++;
            $row = array();
            $row[] = '<a href="'. site_url('admin/trader/customerDetails/'.$item->id) .'">'.$item->name.'</a><br/>'.'<span style="color: grey">'.$item->company_name.'</span>';
            $row[] = $item->phone;
            $openInvoice = $this->sales->open_invoice($item->id);
            //$row[] = '';
            $row[] = get_option('currency_symbol').' '.$this->localization->currencyFormat($openInvoice->invoice_amount);


            //add html for action
            $row[] = '
            <div class="btn-group dropdown">
                                                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                       '. lang('actions').'                               <span class="caret"></span>
                                                    </button>
                                                    <ul class="dropdown-menu pull-right">
                                                        <li>
                                                            <a href="sales/type/invoice?nameID='.$item->id.'"><i class="fa fa-shopping-basket text-success"></i>'. lang('create_invoice').'</a>
                                                        </li>
                                                        <li>
                                                            <a href="sales/type/quotation?nameID='.$item->id.'"><i class="fa fa-list-ol"></i>'. lang('quotation').'</a>
                                                        </li>
                                                        <li>
                                                            <a href="trader/editCustomer/'.$item->id.'"><i class="fa fa-pencil-square-o"></i>'. lang('edit').'</a>
                                                        </li>
                                                        <li>
                                                            <a onclick="return confirm(\'Are you sure you want to delete ? \');" href="trader/deleteCustomer/'. $item->id .'">
                                                                <i class="fa fa-trash-o"></i><span class="text-danger">'. lang('delete').'</span></a>
                                                        </li>
                                                    </ul>
                                                </div>
            ';
            $data[] = $row;
        }
        $this->global_model->render_table($data);
    }

    function deleteCustomer($id = null)
    {
        $order = $this->db->get_where('sales_order', array( 'customer_id' => $id ))->row();

        if($order){
            $this->message->custom_error_msg('admin/trader/customerList', lang('sorry_you_can_not_delete_used_by_other'));
        }else{
            //delete
            $this->db->delete('customer', array('id' => $id));
            $this->message->delete_success('admin/trader/customerList');
        }


    }

    function vendor($id = null)
    {
        $order = $this->db->get_where('sales_order', array( 'customer_id' => $id ))->row();

        if($order){
            $this->message->custom_error_msg('admin/trader/customerList', lang('sorry_you_can_not_delete_used_by_other'));
        }else{
            //delete
            $this->db->delete('customer', array('id' => $id));
            $this->message->delete_success('admin/trader/customerList');
        }


    }

    function newCustomer()
    {
        $this->mViewData['form'] = $this->form_builder->create_form('admin/trader/saveCustomer',true, array('id'=>'from-product'));
        $this->mTitle .= lang('add_new_customer');
        $this->render('sales/customer/add_customer');
    }

    function customerDetails($id = null)
    {

        $customer = $this->db->get_where('customer', array(
            'id' => $id
        ))->row();

        if(!count($customer))
            redirect('admin', 'refresh');
        $this->mViewData['customer'] = $customer;
        $this->mViewData['due'] = $this->sales->overdue_order($id);
        $this->mViewData['estimate'] = $this->sales->estimate_order($id);
        $this->mViewData['openInvoice'] = $this->sales->open_invoice($id);
        $this->mViewData['lifeTimeSell'] = $this->sales->life_time_sell($id);

        $crud = new grocery_CRUD();

        //$crud = $this->generate_crud('sales_order');
        $crud->columns('date','type','id','due_date','grand_total','amount_received','due_payment','delivery_status');
        $crud->order_by('id','desc');
        $crud->where('customer_id',$id);

        $crud->display_as('date', lang('date'));
        $crud->display_as('type',lang('type'));
        $crud->display_as('id', lang('order_no'));
        $crud->display_as('due_date', lang('due_date'));
        $crud->display_as('grand_total', lang('grand_total'));
        $crud->display_as('due_payment', lang('balance'));
        $crud->display_as('amount_received', lang('paid'));
        $crud->display_as('delivery_status',lang('order_status'));


        $crud->set_table('sales_order');
        $crud->callback_column('date',array($this->crud, '_callback_action_date'));
        $crud->callback_column('id',array($this->crud,'_callback_action_orderNo'));
        $crud->callback_column('due_date',array($this->crud,'_callback_action_dueDate'));
        $crud->callback_column('due_payment',array($this->crud,'_callback_action_due_payment'));
        $crud->callback_column('grand_total',array($this->crud,'_callback_action_grand_total'));
        $crud->callback_column('delivery_status',array($this->crud,'_callback_action_order_status'));
        $crud->unset_add();
        $crud->unset_edit();
        $crud->unset_delete();
        $crud->unset_read();

        $this->mViewData['crud'] = $crud->render();

        $this->mTitle .= lang('customer_details');
        $this->render('sales/customer/customer_details');
    }

    function saveCustomer(){
        $this->form_validation->set_rules('name', 'Name', 'trim|required|xss_clean');
        $this->form_validation->set_rules('company_name', 'Company Name', 'trim|required|xss_clean');


        if ($this->form_validation->run() == TRUE) {

            $data['name'] = $this->input->post('name');
            $data['company_name'] = $this->input->post('company_name');
            $data['phone'] = $this->input->post('phone');
            $data['fax'] = $this->input->post('fax');
            $data['email'] = $this->input->post('email');
            $data['website'] = $this->input->post('website');
            $data['b_address'] = $this->input->post('b_address');
            $data['s_address'] = $this->input->post('s_address');
            $data['note'] = $this->input->post('note');

            $id = $this->input->post('id');

            if($id){
                $this->db->where('id', $id);
                $this->db->update('customer', $data);
            }else{
                $this->db->insert('customer', $data);
                $id = $this->db->insert_id();

                $data = array();
                $data['customer_code'] = 1000 + $id;

                $this->db->where('id', $id);
                $this->db->update('customer', $data);

            }

            $this->message->save_success('admin/trader/customerList');
        } else {
            $error = validation_errors();;
            $this->message->custom_error_msg('admin/trader/customerList', $error);
        }
    }

    function editCustomer($id = null)
    {
        $this->mViewData['customer'] = $this->db->get_where('customer', array( 'id' => $id ))->row();

        $this->mViewData['form'] = $this->form_builder->create_form('admin/trader/saveCustomer',true, array('id'=>'from-product'));
        $this->mTitle .= lang('add_new_customer');
        $this->render('sales/customer/add_customer');
    }


    //------------------------------------------------------------------------------------------------------------
    //------------------------------------------------------------------------------------------------------------
    //************************* Vendor Section *****************************************************************
    //------------------------------------------------------------------------------------------------------------
    //------------------------------------------------------------------------------------------------------------


    function vendorList()
    {
        $this->mTitle .= lang('vendor_list');
        $this->render('sales/vendor/vendor_list');
    }

    public function vendorTable()
    {

        $this->global_model->table = 'vendor';
        $this->global_model->column_order = array('name','company_name','phone',null);
        $this->global_model->column_search = array('name','company_name','phone');
        $this->global_model->order = array('id' => 'desc');

        $list = $this->global_model->get_datatables();

        $data = array();
        $no = $_POST['start'];
        foreach ($list as $item) {
            $no++;
            $row = array();
            $row[] = '<a href="'. site_url('admin/trader/vendorDetails/'.$item->id) .'">'.$item->name.'</a><br/>'.'<span style="color: grey">'.$item->company_name.'</span>';
            $row[] = $item->phone;
            $due_payment = $this->sales->purchase_due_invoice($item->id);
            //$row[] = '';
            $row[] = get_option('currency_symbol').' '.$this->localization->currencyFormat($due_payment);


            //add html for action
            $row[] = '
            <div class="btn-group dropdown">
                                                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                        Actions                                  <span class="caret"></span>
                                                    </button>
                                                    <ul class="dropdown-menu pull-right">
                                                        <li>
                                                            <a href="purchase/newPurchase?nameID='.$item->id.'"><i class="fa fa-shopping-basket text-success"></i>Create Bill</a>
                                                        </li>
                                                 
                                                        <li>
                                                            <a href="trader/editVendor/'.$item->id.'"><i class="fa fa-pencil-square-o"></i>Edit Vendor</a>
                                                        </li>
                                                        <li>
                                                            <a onclick="return confirm(\'Are you sure you want to delete ? \');" href="trader/deleteVendor/'. $item->id .'">
                                                                <i class="fa fa-trash-o"></i><span class="text-danger">'. lang('delete').'</span></a>
                                                        </li>
                                                    </ul>
                                                </div>
            ';
            $data[] = $row;
        }
        $this->global_model->render_table($data);
    }

    function deleteVendor($id = null)
    {
        $purchase = $this->db->get_where('purchase_order', array( 'vendor_id' => $id ))->row();

        if($purchase){
            $this->message->custom_error_msg('admin/trader/vendorList', lang('sorry_you_can_not_delete_used_by_other'));
        }else{
            //delete
            $this->db->delete('vendor', array('id' => $id));
            $this->message->delete_success('admin/trader/vendorList');
        }


    }

    function newVendor()
    {
        $this->mViewData['form'] = $this->form_builder->create_form('admin/trader/saveVendor',true, array('id'=>'from-product'));
        $this->mTitle .= lang('add_new_vendor');
        $this->render('sales/vendor/add_vendor');
    }

    function saveVendor(){
        $this->form_validation->set_rules('name', 'Name', 'trim|required|xss_clean');
        $this->form_validation->set_rules('company_name', 'Company Name', 'trim|required|xss_clean');


        if ($this->form_validation->run() == TRUE) {

            $data['name'] = $this->input->post('name');
            $data['company_name'] = $this->input->post('company_name');
            $data['phone'] = $this->input->post('phone');
            $data['fax'] = $this->input->post('fax');
            $data['email'] = $this->input->post('email');
            $data['website'] = $this->input->post('website');
            $data['b_address'] = $this->input->post('b_address');
            $data['note'] = $this->input->post('note');

            $id = $this->input->post('id');

            if($id){
                $this->db->where('id', $id);
                $this->db->update('vendor', $data);
            }else{
                $this->db->insert('vendor', $data);
                $id = $this->db->insert_id();
                $vendor_code = 1000 + $id;
                $this->db->set('vendor_code', $vendor_code, FALSE)->where('id', $id)->update('vendor');

            }

            $this->message->save_success('admin/trader/vendorList');
        } else {
            $error = validation_errors();;
            $this->message->custom_error_msg('admin/trader/vendorList', $error);
        }
    }

    function editVendor($id = null)
    {
        $this->mViewData['vendor'] = $this->db->get_where('vendor', array( 'id' => $id ))->row();

        $this->mViewData['form'] = $this->form_builder->create_form('admin/trader/saveVendor',true, array('id'=>'from-product'));
        $this->mTitle .= lang('add_new_vendor');
        $this->render('sales/vendor/add_vendor');
    }

    function vendorDetails($id = null)
    {
        $vendor = $this->db->get_where('vendor', array(
            'id' => $id
        ))->row();

        if(!count($vendor))
            redirect('admin', 'refresh');
        $this->mViewData['vendor'] = $vendor;

        $this->mViewData['due'] = $this->sales->total_purchase_due_by_vendor($id);
        $this->mViewData['paid'] = $this->sales->total_purchase_paid_by_vendor($id);
        $this->mViewData['totalInvoice'] = $this->sales->total_purchase_invoice_by_vendor($id);
        $this->mViewData['returnPurchase'] = $this->sales->total_return_purchase_by_vendor($id);


        $crud = new grocery_CRUD();
        //$crud = $this->generate_crud('sales_order');
        $crud->columns('date','purchase_id','vendor_name', 'purchase_status','grand_total','paid_amount','due_payment', 'actions');
        $crud->order_by('id','desc');
        $crud->where('vendor_id',$id);

        $crud->display_as('date', lang('date'));
        $crud->display_as('purchase_id',lang('purchase_no'));
        $crud->display_as('vendor_name',lang('supplier'));
        $crud->display_as('purchase_status',lang('status'));
        $crud->display_as('grand_total', lang('grand_total'));
        $crud->display_as('paid_amount', lang('paid'));
        $crud->display_as('due_payment', lang('balance'));

        $crud->set_table('purchase_order');
        $crud->callback_column('date',array($this->crud,'_callback_action_date'));
        $crud->callback_column('purchase_id',array($this->crud,'_callback_action_purchase_order_no'));

        $crud->callback_column('grand_total',array($this->crud,'_callback_action_grand_total'));
        $crud->callback_column('paid_amount',array($this->crud,'_callback_action_pur_paid_amount'));
        $crud->callback_column('due_payment',array($this->crud,'_callback_action_pur_due_amount'));
        $crud->callback_column('actions',array($this->crud,'_callback_action_purchase_order'));
        $crud->callback_column('purchase_status',array($this->crud,'_callback_action_purchase_status'));
        $crud->unset_add();
        $crud->unset_edit();
        $crud->unset_delete();
        $crud->unset_read();

        $this->mViewData['crud'] = $crud->render();

        $this->mTitle .= lang('vendor_details');
        $this->render('sales/vendor/vendor_details');
    }

    //=============================================================
    //  Import Customer
    //=============================================================
    function downloadCustomerSample()
    {
        $this->load->helper('download');
        $file = base_url().SAMPLE_FILE.'/'.'customer.csv';
        $data =  file_get_contents($file);
        force_download('customer.csv', $data);
    }

    function importCustomer(){
        if(isset($_POST["submit"]))
        {
            $tmp = explode(".", $_FILES['import']['name']); // For getting Extension of selected file
            $extension = end($tmp);

            $allowed_extension = array("xls", "xlsx", "csv"); //allowed extension
            if(in_array($extension, $allowed_extension)) //check selected file extension is present in allowed extension array
            {
                $this->load->library('Data_importer');
                $file = $_FILES["import"]["tmp_name"]; // getting temporary source of excel file
                $this->data_importer->customer_excel_import($file);
            }else{
                $this->message->custom_error_msg('admin/trader/importCustomer','Failed to Import Data');
            }
        }


        $this->mViewData['form'] = $this->form_builder->create_form();
        $this->mTitle .= lang('import_data');
        $this->render('import/import_customer');
    }

    //=============================================================
    //  Import Vendor
    //=============================================================

    function downloadVendorSample()
    {
        $this->load->helper('download');
        $file = base_url().SAMPLE_FILE.'/'.'vendor.csv';
        $data =  file_get_contents($file);
        force_download('vendor.csv', $data);
    }

    function importVendor(){
        if(isset($_POST["submit"]))
        {
            $tmp = explode(".", $_FILES['import']['name']); // For getting Extension of selected file
            $extension = end($tmp);
            $allowed_extension = array("xls", "xlsx", "csv"); //allowed extension
            if(in_array($extension, $allowed_extension)) //check selected file extension is present in allowed extension array
            {
                $this->load->library('Data_importer');
                $file = $_FILES["import"]["tmp_name"]; // getting temporary source of excel file
                $this->data_importer->vendor_excel_import($file);
            }else{
                $this->message->custom_error_msg('admin/trader/importVendor', lang('failed_to_import_data'));
            }
        }


        $this->mViewData['form'] = $this->form_builder->create_form();
        $this->mTitle .= lang('import_data');
        $this->render('import/import_vendor');
    }






}