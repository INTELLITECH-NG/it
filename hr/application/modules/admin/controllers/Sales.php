<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sales extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('cart');
        $this->load->library('form_builder');
        $this->load->model('global_model');
        $this->load->model('sales_model', 'sales');
        $this->load->model('crud_model', 'crud');
        $this->load->library('grocery_CRUD');
        $this->mTitle = TITLE;
    }



    //------------------------------------------------------------------------------------------------------------
    //------------------------------------------------------------------------------------------------------------
    //************************* Sales Section *****************************************************************
    //------------------------------------------------------------------------------------------------------------
    //------------------------------------------------------------------------------------------------------------


    function allOrder()
    {

        $this->mViewData['due'] = $this->sales->overdue_order();
        $this->mViewData['estimate'] = $this->sales->estimate_order();
        $this->mViewData['openInvoice'] = $this->sales->open_invoice();
        $this->mViewData['lifeTimeSell'] = $this->sales->life_time_sell();


        $crud = new grocery_CRUD();
        //$crud = $this->generate_crud('sales_order');
        $crud->columns('date','id','customer_name','due_date','grand_total','amount_received', 'due_payment','delivery_status', 'actions');
        $crud->order_by('id','desc');
        $crud->where('type','Invoice');
        $crud->order_by('id','desc');

        $crud->display_as('date', lang('date'));
        $crud->display_as('id', lang('order_no'));
        $crud->display_as('customer_name', lang('customer'));
        $crud->display_as('due_date', lang('due_date'));
        $crud->display_as('grand_total', lang('grand_total'));
        $crud->display_as('due_payment', lang('balance'));
        $crud->display_as('amount_received', lang('paid'));
        $crud->display_as('delivery_status',lang('order_status'));
        $crud->display_as('actions', lang('actions'));

        $crud->set_table('sales_order');

        $crud->callback_column('date',array($this->crud,'_callback_action_date'));
        $crud->callback_column('id',array($this->crud,'_callback_action_orderNo'));
        $crud->callback_column('due_date',array($this->crud,'_callback_action_dueDate'));
        $crud->callback_column('due_payment',array($this->crud,'_callback_action_due_payment'));
        $crud->callback_column('grand_total',array($this->crud,'_callback_action_grand_total'));
        $crud->callback_column('actions',array($this->crud,'_callback_action_all_order'));
        $crud->callback_column('delivery_status',array($this->crud,'_callback_action_order_status'));

        $crud->unset_add();
        $crud->unset_edit();
        $crud->unset_delete();
        $crud->unset_read();

        $this->mViewData['crud'] = $crud->render();

        $this->mTitle .= lang('invoice_list');
        $this->render('sales/sales_list');
    }

    function processing()
    {
        $crud = new grocery_CRUD();
        $crud->columns('date','id','customer_name','due_date','due_payment','grand_total', 'actions');
        $crud->where('delivery_status','Processing Order');
        $crud->where('type','Invoice');

        $crud->order_by('id','desc');

        $crud->display_as('date', lang('date'));
        $crud->display_as('id', lang('order_no'));
        $crud->display_as('customer_name', lang('customer'));
        $crud->display_as('due_date', lang('due_date'));
        $crud->display_as('grand_total', lang('total'));
        $crud->display_as('actions', lang('actions'));

        $crud->set_table('sales_order');

        $crud->callback_column('date',array($this->crud,'_callback_action_date'));
        $crud->callback_column('id',array($this->crud,'_callback_action_orderNo'));
        $crud->callback_column('due_date',array($this->crud,'_callback_action_dueDate'));
        $crud->callback_column('due_payment',array($this->crud,'_callback_action_due_payment'));
        $crud->callback_column('grand_total',array($this->crud,'_callback_action_grand_total'));
        $crud->callback_column('actions',array($this->crud,'_callback_action_order_process'));
        $crud->unset_add();
        $crud->unset_edit();
        $crud->unset_delete();
        $crud->unset_read();

        $this->mViewData['crud'] = $crud->render();
        $this->mViewData['title'] = lang('process_order');

        $this->mTitle .= lang('process_order');
        $this->render('sales/crud');
    }

    function pending()
    {
        $crud = new grocery_CRUD();
        $crud->columns('date','id','customer_name','due_date','due_payment','grand_total','actions', 'delivery_status');
        $crud->where('delivery_status','Awaiting Delivery');
        $crud->where('type','Invoice');

        $crud->order_by('id','desc');

        $crud->display_as('date', lang('date'));
        $crud->display_as('id', lang('order_no'));
        $crud->display_as('customer_name', lang('customer'));
        $crud->display_as('due_date', lang('due_date'));
        $crud->display_as('grand_total', lang('total'));

        $crud->display_as('delivery_status',lang('shipping'));
        $crud->display_as('actions',lang('print'));

        $crud->set_table('sales_order');
        $crud->callback_column('date',array($this->crud,'_callback_action_date'));
        $crud->callback_column('id',array($this->crud,'_callback_action_orderNo'));
        $crud->callback_column('due_date',array($this->crud,'_callback_action_dueDate'));
        $crud->callback_column('due_payment',array($this->crud,'_callback_action_due_payment'));
        $crud->callback_column('grand_total',array($this->crud,'_callback_action_grand_total'));
        $crud->callback_column('delivery_status',array($this->crud,'_callback_action_order_shipment'));
        $crud->callback_column('actions',array($this->crud,'_callback_action_label_print'));
        $crud->unset_add();
        $crud->unset_edit();
        $crud->unset_delete();
        $crud->unset_read();

        $this->mViewData['crud'] = $crud->render();
        $this->mViewData['title'] = lang('awaiting_delivery_order');;

        $this->mTitle .= lang('awaiting_delivery_order');;
        $this->render('sales/crud');
    }

    function deliveredOrder()
    {
        $crud = new grocery_CRUD();
        $crud->columns('date','id','customer_name','tracking','delivery_person','delivery_date');
        $crud->where('delivery_status','Done');
        $crud->where('type','Invoice');

        $crud->order_by('id','desc');

        $crud->display_as('date', lang('invoice_date'));
        $crud->display_as('id', lang('order_no'));
        $crud->display_as('customer_name', lang('customer'));
        $crud->display_as('tracking', lang('tracking'));
        $crud->display_as('delivery_person', lang('delivery_person'));
        $crud->display_as('delivery_date', lang('delivery_date'));


        $crud->set_table('sales_order');

        $crud->callback_column('date',array($this->crud,'_callback_action_date'));
        $crud->callback_column('id',array($this->crud,'_callback_action_orderNo'));

        $crud->unset_add();
        $crud->unset_edit();
        $crud->unset_delete();
        $crud->unset_read();

        $this->mViewData['crud'] = $crud->render();
        $this->mViewData['title'] = lang('delivered_order_list');

        $this->mTitle .= lang('delivered_order_list');
        $this->render('sales/crud');
    }

    function allQuotation()
    {
        $crud = new grocery_CRUD();
        $crud->columns('date','id','customer_name','due_date','grand_total','status', 'actions');
        $crud->order_by('id','desc');
        $crud->where('type','Quotation');


        $crud->display_as('date', lang('date'));
        $crud->display_as('id', lang('order_no'));
        $crud->display_as('customer_name', lang('customer'));
        $crud->display_as('due_date', lang('expiry_date'));
        $crud->display_as('due_date', lang('expiry_date'));
        $crud->display_as('status', lang('status'));
        $crud->display_as('actions', lang('actions'));



        $crud->display_as('status','Status');
        $crud->set_table('sales_order');
        $crud->callback_column('date',array($this->crud,'_callback_action_date'));
        $crud->callback_column('id',array($this->crud,'_callback_action_orderNo'));
        $crud->callback_column('due_date',array($this->crud,'_callback_action_dueDate'));
        $crud->callback_column('due_payment',array($this->crud,'_callback_action_due_payment'));
        $crud->callback_column('grand_total',array($this->crud,'_callback_action_grand_total'));
        $crud->callback_column('actions',array($this->crud,'_callback_action_all_order'));
        $crud->unset_add();
        $crud->unset_edit();
        $crud->unset_delete();
        $crud->unset_read();

        $this->mViewData['crud'] = $crud->render();
        $this->mViewData['title'] = lang('all_quotation_list');

        $this->mTitle .= lang('all_quotation_list');
        $this->render('sales/crud');
    }

    function move_for_shipping($id = null)
    {
        $id = $id - INVOICE_PRE;
        $this->db->where('id',$id);
        $this->db->update('sales_order',array('delivery_status'=>'Awaiting Delivery'));
        $this->message->custom_success_msg('admin/sales/processing', lang('your_order_successfully_move_to_shipping_module'));
    }

    function marked_shipped()
    {
        $order_id = $this->uri->segment(4);
        $id = $order_id - INVOICE_PRE;
        $data['tracking'] = $this->uri->segment(5);
        $data['delivery_person'] = $this->uri->segment(6);
        $data['delivery_date'] = date("Y-m-d");
        $data['delivery_status'] = 'Done';

        $this->db->where('id', $id);
        $this->db->update('sales_order', $data);

        $this->message->custom_success_msg('admin/sales/pending', lang('your_order_successfully_delivered'));
    }

    function updateSales($orderId = null){

        $this->cart->destroy();
        $orderId = $orderId - INVOICE_PRE;
        //query
        $this->mViewData['order'] = $this->db->get_where('sales_order', array(
            'id' => $orderId
        ))->row();

        if(!count($this->mViewData['order'])){
            redirect('admin/dashboard', 'refresh');
        }

        $this->mViewData['type'] = strtolower($this->mViewData['order']->type);
        $type = array('type' => strtolower($this->mViewData['order']->type));
        $this->session->set_userdata($type);
        if($this->mViewData['type'] === 'invoice') {
            $this->mViewData['form'] = $this->form_builder->create_form('admin/sales/update_save_sales', true, array('id' => 'from-invoice'));
        }else{
            $this->mViewData['form'] = $this->form_builder->create_form('admin/sales/save_quotation', true, array('id' => 'from-invoice'));
        }

        //customer
        $this->mViewData['c_detail'] = $this->db->get_where('customer', array(
            'id' => $this->mViewData['order']->customer_id
        ))->row();

        //cart Operation
        $cartItem = json_decode($this->mViewData['order']->cart);
        foreach ($cartItem as $item ){

            $cart[] = array(
                'id'                => $item->id,
                'qty'               => $item->qty,
                'price'             => $item->price,
                'purchase_cost'     => $item->purchase_cost,
                'name'              => $item->name,
                'description'       => $item->description,
                'type'              => $item->type,
                'bundle'            => $item->bundle,
                'tax'               => $item->tax
            );
        }

        $this->cart->insert($cart);

        $s_data = array(
            'discount' => $this->mViewData['order']->discount,
            'amount_received' => $this->mViewData['order']->amount_received,
            'payment_method' => $this->mViewData['order']->payment_method,
            'p_reference' => $this->mViewData['order']->p_reference,
        );

        $this->session->set_userdata($s_data);
        $categories = $this->db->order_by('category', 'asc')->get('product_category')->result();

        if(!empty($categories)){
            foreach ($categories as $item){
                $tm_product = $this->db->order_by('name', 'asc')->get_where('product', array(
                    'category_id' => $item->id
                ))->result();

                if(!count($tm_product))
                    continue;

                $products[$item->category] = $tm_product;
            }
        }

        $this->mViewData['products'] = $products;
        $this->mTitle .= lang('create_invoice');;
        $this->render('sales/create_invoice');
    }

    function type(){

        $this->cart->destroy();
        $this->mViewData['type'] = $this->uri->segment(4);

        $type = array('type' => $this->uri->segment(4));
        $this->session->set_userdata($type);

        $customerId = $this->input->get('nameID');

        if(!empty($customerId)){
            $c_detail = $this->db->get_where('customer', array('id' => $customerId))->row();
            if(count($c_detail)){
                $this->mViewData['c_detail'] = $c_detail;
            }
        }else{
            $this->mViewData['c_detail'] = (object) array(
                'id'        => '',
                'b_address' => '',
                's_address' => '',
                'email'     => '',
            );
        }

        if($this->mViewData['type'] == 'invoice')
        {
            $this->mViewData['form'] = $this->form_builder->create_form('admin/sales/save_sales',true, array('id'=>'from-invoice'));
        }else
        {
            $this->mViewData['form'] = $this->form_builder->create_form('admin/sales/save_quotation',true, array('id'=>'from-invoice'));
        }

        $this->_discount_session();

        $this->mViewData['customers'] = $this->db->get('customer')->result();
        $categories = $this->db->order_by('category', 'asc')->get('product_category')->result();

        if(!empty($categories)){
            foreach ($categories as $item){
                $tm_product = $this->db->order_by('name', 'asc')->get_where('product', array(
                    'category_id' => $item->id
                ))->result();

                if(!count($tm_product))
                    continue;

                $products[$item->category] = $tm_product;
            }
        }

        $this->mViewData['products'] = $products;
        if($this->uri->segment(4) === 'invoice')
            $this->mTitle .= lang('create_invoice');
        else
            $this->mTitle .= lang('create_quotation');

        $this->render('sales/create_invoice');
    }

    function _discount_session(){
        $discount = array('discount' => 0);
        $this->session->set_userdata($discount);
    }


    function save_sales()
    {

        if(empty($this->cart->contents()))
            $this->message->custom_error_msg('admin/sales/allOrder', lang('sorry!_cart_is_empty'));

        $order_id = $this->encrypt->decode(str_replace(array('-', '_', '~'), array('+', '/', '='), $this->input->post('order_id')));
        $sales_person = $this->ion_auth->user()->row();

        $data['email']          = $this->input->post('email');
        $data['b_address']      = $this->input->post('b_address');
        $data['s_address']      = $this->input->post('s_address');
        //$data['invoice_date']   = $this->input->post('invoice_date');
        $data['invoice_date']   =  date( "Y/m/d", strtotime( $this->input->post('invoice_date') ) );
        //$data['due_date']       = $this->input->post('due_date');
        $data['due_date']       = date( "Y/m/d", strtotime( $this->input->post('due_date') ) );
        $data['order_note']     = $this->input->post('order_note');
        $data['cart_total']     = $this->cart->total();
        $total_tax = 0.00;
        foreach ($this->cart->contents() as $item) {
             $total_tax += $item['tax'];
        }
        $data['tax']     = $total_tax;
        $gtotal =  $this->cart->total();
        $discount = $this->session->userdata('discount');
        $discount_amount = ($gtotal * $discount)/100;
        $data['grand_total']    = $this->cart->total() + $total_tax - $discount_amount;
        $data['cart']           = json_encode($this->cart->contents());
        $data['type']           = ucwords($this->session->userdata('type'));


        if($order_id != ''){
            $data['status']         = 'Open';
            $data['sales_person']   = $sales_person->first_name.' '.$sales_person->last_name;
            $data['due_payment']    = $data['grand_total'];
        }else{
            $data['customer_id']    = $this->input->post('customer_id');
            $data['customer_name']  = $this->db->get_where('customer', array(
                'id' => $data['customer_id']
            ))->row()->name;
            $data['sales_person']   = $sales_person->first_name.' '.$sales_person->last_name;
            $data['type']           = str_replace("_"," ",$this->input->post('type'));
            $data['discount']       = (float)$this->session->userdata('discount');
            $data['amount_received']= (float)$this->input->post('amount_received');
            $data['due_payment']    = $data['grand_total'] - $data['amount_received'];

            if($data['due_payment'] <= 0){
                $data['status'] = 'Close';
            }else{
                $data['status'] = 'Open';
            }
        }


        //check first time booking made or update
        date_default_timezone_set(get_option('time_zone'));
        $history[] = array(
            'sales' => array(
                'sales_person'      => $data['sales_person'],
                'date'              => date("F j, Y, H:i:s")
            ),
            'list' => array(
                'status'            =>  'Order Created',
                'activities'        => $this->input->post('order_activities'),
                'amount_received'   => $this->input->post('amount_received'),
                'payment_method'    => $this->input->post('payment_method'),
                'p_reference'       => $this->input->post('p_reference'),
            )
        );
        $data['history'] = json_encode($history);

        if(empty($order_id)){
            $this->db->insert('sales_order', $data);
            $order_id = $this->db->insert_id();
        }else{
            //update
            $this->db->where('id', $order_id);
            $this->db->update('sales_order', $data);
        }

        $o_details['order_id'] = $order_id;
        foreach ($this->cart->contents() as $item){

            $o_details['product_id']        = $item['id'];
            $o_details['product_name']      = $item['name'];
            $o_details['purchase_cost']     = $item['purchase_cost'];
            $o_details['sales_cost']        = $item['price'];
            $o_details['qty']               = $item['qty'];
            $o_details['tax_amount']        = $item['tax'];
            $o_details['description']       = $item['description'];


            //save order details
            $this->db->insert('order_details', $o_details);


            if($item['bundle']){

                foreach ($item['bundle'] as $product){
                    //inventory
                    $p_details = $this->db->get_where('product', array( 'id' => $product->product_id ))->row();

                    if($p_details->type === 'Inventory'){

                        $p_qty['inventory'] =  $p_details->inventory - $product->qty * $item['qty'] ;

                        $this->db->where('id', $product->product_id);
                        $this->db->update('product', $p_qty);
                    }
                }

            }else{
                //inventory
                $p_details = $this->db->get_where('product', array(
                    'id' => $item['id']
                ))->row();

                if($p_details->type === 'Inventory'){
                    $p_qty['inventory'] =  $p_details->inventory - $item['qty'];

                    $this->db->where('id', $item['id']);
                    $this->db->update('product', $p_qty);
                }
            }



        }


        redirect('admin/sales/sale_preview/'.get_orderID($order_id));
    }

    function save_quotation()
    {
        if(empty($this->cart->contents()))
            $this->message->custom_error_msg('admin/sales/allQuotation', lang('sorry!_cart_is_empty'));

        $order_id = $this->encrypt->decode(str_replace(array('-', '_', '~'), array('+', '/', '='), $this->input->post('order_id')));
        $sales_person = $this->ion_auth->user()->row();

        if(empty($order_id)){
            $data['customer_id']    = $this->input->post('customer_id');
            $data['customer_name']  = $this->db->get_where('customer', array(
                                        'id' => $data['customer_id']
                                    ))->row()->name;
            $data['s_address']      = $this->input->post('s_address');
        }
        $data['email']          = $this->input->post('email');
        $data['b_address']      = nl2br($this->input->post('b_address'));
        $data['invoice_date']   = $this->input->post('invoice_date');
        $data['due_date']       = $this->input->post('due_date');
        $data['order_note']     = $this->input->post('order_note');
        $data['cart_total']     = $this->cart->total();
        $data['grand_total']    = $this->cart->total();
        $data['type']           = 'Quotation';
        $data['cart']           = json_encode($this->cart->contents());

        $data['sales_person']     = $sales_person->first_name.' '.$sales_person->last_name;
        $data['status'] = 'Pending';
        if($order_id){
            //update
            $this->db->where('id', $order_id);
            $this->db->update('sales_order', $data);
        }else{
            $this->db->insert('sales_order', $data);
            $order_id = $this->db->insert_id();
        }

        redirect('admin/sales/sale_preview/'.get_orderID($order_id));
    }

    function update_save_sales()
    {
        if(empty($this->cart->contents()))
            $this->message->custom_error_msg('admin/sales/allOrder', lang('sorry!_cart_is_empty'));
        $order_id = $this->encrypt->decode(str_replace(array('-', '_', '~'), array('+', '/', '='), $this->input->post('order_id')));
        $order_details = $this->db->get_where('sales_order', array('id' => $order_id))->row();
        if(!count($order_details))
            redirect('admin/dashboard');

        $sales_person = $this->ion_auth->user()->row();

        $data['email']          = $this->input->post('email');
        $data['b_address']      = $this->input->post('b_address');
        $data['s_address']      = $this->input->post('s_address');
        $data['due_date']       = $this->input->post('due_date');
        $data['order_note']     = $this->input->post('order_note');
        $data['cart_total']     = $this->cart->total();
        $data['discount']       = (float)$this->session->userdata('discount');
        $total_tax = 0.00;
        foreach ($this->cart->contents() as $item) {
            $total_tax += $item['tax'];
        }
        $data['tax']     = $total_tax;
        $gtotal =  $this->cart->total();
        $discount = $this->session->userdata('discount');
        $discount_amount = ($gtotal * $discount)/100;
        $data['grand_total']    = $this->cart->total() + $total_tax - $discount_amount;
        $data['amount_received']= (float)$this->input->post('amount_received') + $order_details->amount_received;
        $data['due_payment']    = $data['grand_total'] - $data['amount_received'];

        if($data['due_payment'] <= 0){
            $data['status'] = 'Close';
        }else{
            $data['status'] = 'Open';
        }

        $data['cart']           = json_encode($this->cart->contents());

        //Order History
        date_default_timezone_set(get_option('time_zone'));
        $history = json_decode($order_details->history);

        if($this->input->post('amount_received')){
            $payment_method = $this->input->post('payment_method');
        }else{
            $payment_method = '';
        }
        $history[] = array(
            'sales' => array(
                'sales_person'      => $sales_person->first_name.' '.$sales_person->last_name,
                'date'              => date("F j, Y, H:i:s")
            ),
            'list' => array(
                'status'            =>  'Update Order',
                'activities'        =>  $this->input->post('order_activities'),
                'amount_received'   => $this->input->post('amount_received'),
                'payment_method'    => $payment_method,
                'p_reference'       => $this->input->post('p_reference'),
            )
        );
        $data['history'] = json_encode($history);

        //old Cart Manipulate
        $old_cart = json_decode($order_details->cart,true);

        foreach ($this->cart->contents() as $n_item){
            foreach ($old_cart as $o_item)
            {
                if($n_item['id'] === $o_item['id']){
                    unset($old_cart[$o_item['rowid']]);
                }
            }
        }

        //return back to Inventory
        if(count($old_cart)){
            foreach ($old_cart as $item){


                if($item['bundle']){

                    foreach ($item['bundle'] as $product){

                        //inventory
                        $p_details = $this->db->get_where('product', array( 'id' => $product['product_id'] ))->row();

                        if($p_details->type === 'Inventory'){

                            $p_qty['inventory'] =  $p_details->inventory + $product['qty'] ;
                            $this->db->where('id', $product['product_id']);
                            $this->db->update('product', $p_qty);
                        }
                    }

                }else{
                    $p_details = $this->db->get_where('product', array(
                        'id' => $item['id']
                    ))->row();

                    if($p_details->type === 'Inventory'){
                        $p_qty['inventory'] =  $p_details->inventory + $item['qty'];
                        //return Product qty
                        $this->db->where('id', $item['id']);
                        $this->db->update('product', $p_qty);
                    }
                }

                //delete from order
                $order_details_id = $this->db->get_where('order_details', array(
                    'order_id' => $order_id,
                    'product_id' => $item['id'],
                ))->row();

                $this->db->delete('order_details', array('id' => $order_details_id->id));
            }
        }


        //update Order
        $this->db->where('id', $order_id);
        $this->db->update('sales_order', $data);

        $o_details['order_id'] = $order_id;
        foreach ($this->cart->contents() as $item){

            $o_details['product_id']        = $item['id'];
            $o_details['product_name']      = $item['name'];
            $o_details['purchase_cost']     = $item['purchase_cost'];
            $o_details['sales_cost']        = $item['price'];
            $o_details['qty']               = $item['qty'];
            $o_details['description']       = $item['description'];
            $o_details['tax_amount']        = $item['tax'];

            $p_details = $this->db->get_where('product', array(
                'id' => $item['id']
            ))->row();

            //save order details
            $has_product = $this->db->get_where('order_details', array(
                'order_id' => $order_id,
                'product_id' => $item['id'],
            ))->row();

            $pre_qty = $has_product->qty;

            if(count($has_product))
            {
                $this->db->where('id', $has_product->id);
                $this->db->update('order_details', $o_details);

                if($item['bundle']){
                    foreach ($item['bundle'] as $product){
                        //inventory
                        $p_details = $this->db->get_where('product', array( 'id' => $product->product_id ))->row();

                        if($p_details->type === 'Inventory'){

                            $p_qty['inventory'] =  ($p_details->inventory + $product->qty * $pre_qty) - ($product->qty * $item['qty']) ;
                            $this->db->where('id', $product->product_id);
                            $this->db->update('product', $p_qty);
                        }
                    }
                }else{
                    $p_qty['inventory'] =  $p_details->inventory + $pre_qty - $item['qty'];
                    //return Product qty
                    $this->db->where('id', $item['id']);
                    $this->db->update('product', $p_qty);
                }



            }else
            {
                $this->db->insert('order_details', $o_details);

                if($item['bundle']){
                    foreach ($item['bundle'] as $product){
                        //inventory
                        $p_details = $this->db->get_where('product', array( 'id' => $product->product_id ))->row();

                        if($p_details->type === 'Inventory'){

                            $p_qty['inventory'] =  $p_details->inventory - $product->qty * $item['qty'] ;

                            $this->db->where('id', $product->product_id);
                            $this->db->update('product', $p_qty);
                        }
                    }
                }else{
                    if($p_details->type === 'Inventory'){
                        $p_qty['inventory'] =  $p_details->inventory - $item['qty'];

                        $this->db->where('id', $item['id']);
                        $this->db->update('product', $p_qty);
                    }
                }


            }

        }


        redirect('admin/sales/sale_preview/'.get_orderID($order_id));


    }

    function sale_preview($id = null)
    {
        $id = $id - INVOICE_PRE;
        //query
        $this->mViewData['order'] = $this->db->get_where('sales_order', array(
            'id' => $id
        ))->row();

        if(!count($this->mViewData['order'])){
            redirect('/', 'refresh');
        }

        $this->mViewData['type'] = $this->mViewData['order']->type;

       if($this->mViewData['order']->type === 'Quotation')
       {
            $cart = json_decode($this->mViewData['order']->cart);
            foreach ($cart as $item)
            {
                $order_details[] = (object)array(
                    'product_name' => $item->name,
                    'description' => $item->description,
                    'purchase_cost' => $item->purchase_cost,
                    'sales_cost' => $item->price,
                    'qty' => $item->qty,
                );
            }
           $this->mViewData['order_details'] = $order_details;
       }
       else
       {
           $this->mViewData['order_details'] = $this->db->get_where('order_details', array(
               'order_id' => $id
           ))->result();
       }

        $this->mViewData['payment'] = $this->db->get_where('payment', array(
            'order_id' => $id,
            'type'     => 'Sales'
        ))->result();

        //customer
        $this->mViewData['customer'] = $this->db->get_where('customer', array(
            'id' => $this->mViewData['order']->customer_id
        ))->row();

        $this->mTitle .= 'Sales Invoice';
        $this->render('sales/sales_preview');
    }

    function printInvoice(){
        $data['bootstrap'] =  base_url().'assets/css/bootstrap/css/bootstrap.css';
        $this->load->view('sales/invoice',$data);
    }

    function createPdfInvoice($id = null)
    {
        $id = $id - INVOICE_PRE;
        //query
        $data['order'] = $this->db->get_where('sales_order', array(
            'id' => $id
        ))->row();

        if(!count($data['order'])){
            redirect('admin/dashboard', 'refresh');
        }

        if($data['order']->type === 'Quotation')
        {
            $cart = json_decode($data['order']->cart);
            foreach ($cart as $item)
            {
                $order_details[] = (object)array(
                    'product_name' => $item->name,
                    'description' => $item->description,
                    'purchase_cost' => $item->purchase_cost,
                    'sales_cost' => $item->price,
                    'qty' => $item->qty,
                );
            }
            $data['order_details'] = $order_details;
        }
        else
        {
            $data['order_details'] = $this->db->get_where('order_details', array(
                'order_id' => $id
            ))->result();
        }

        $data['payment'] = $this->db->get_where('payment', array(
            'order_id' => $id,
            'type'     => 'Sales'
        ))->result();

        //customer
        $data['customer'] = $this->db->get_where('customer', array(
            'id' => $data['order']->customer_id
        ))->row();

        $data['type'] = $data['order']->type;

        $file= INVOICE_PRE + $id;
        $filename = get_option('invoice_prefix').$file.'.pdf';
        $this->load->library('pdf');
        $pdf = $this->pdf->load();

        $html = $this->load->view('sales/invoice_pdf', $data, true);


        $pdf->SetFooter($_SERVER['HTTP_HOST'].'|{PAGENO}|'.date(DATE_RFC822));
        $stylesheet = file_get_contents(FCPATH.'assets/css/invoice.css');

        $pdf->WriteHTML($stylesheet,1);
        $pdf->WriteHTML($html,2);
        $pdf->Output($filename, 'D');

    }

    function packing_list($id = null)
    {
        $id = $id - INVOICE_PRE;
        //query
        $data['order'] = $this->db->get_where('sales_order', array(
            'id' => $id
        ))->row();

        if(!count($data['order'])){
            redirect('admin/dashboard', 'refresh');
        }

        $data['order_details'] = $this->db->get_where('order_details', array(
            'order_id' => $id
        ))->result();

        //customer
        $data['customer'] = $this->db->get_where('customer', array(
            'id' => $data['order']->customer_id
        ))->row();



        $file= INVOICE_PRE + $id;
        $filename = get_option('invoice_prefix').$file.'.pdf';
        $this->load->library('pdf');
        $pdf = $this->pdf->load();

        $html = $this->load->view('sales/packing_list', $data, true);


        $pdf->SetFooter($_SERVER['HTTP_HOST'].'|{PAGENO}|'.date(DATE_RFC822));
        $stylesheet = file_get_contents(base_url().'assets/css/packing_list.css');
        $stylesheet .= file_get_contents(base_url().'assets/css/bootstrap/css/bootstrap.css');

        $pdf->WriteHTML($stylesheet,1);
        $pdf->WriteHTML($html,2);
        $pdf->Output($filename, 'D');
    }

    function cancelQuotation($id = null)
    {
        $id = $id - INVOICE_PRE;
        $data['id'] = get_encode($id);
        $data['title'] = 'Cancel Quotation';
        $data['type'] = 'Quotation';
        $data['modal_subview'] = $this->load->view('admin/sales/_cancalation_note',$data, FALSE);
        $this->load->view('admin/_partials/_layout_modal_small', $data);
    }

    function cancelSales($id = null)
    {
        $id = $id - INVOICE_PRE;
        $data['id'] = get_encode($id);
        $data['title'] = 'Cancel Order';
        $data['type'] = 'Invoice';
        $data['modal_subview'] = $this->load->view('admin/sales/_cancalation_note',$data, FALSE);
        $this->load->view('admin/_partials/_layout_modal_small', $data);
    }

    function cancelOrder()
    {
        $id = get_decode($this->input->post('id'));
        $type = $this->input->post('type');

        if($type === 'Invoice')
        {
            $order = $this->db->get_where('sales_order', array(
                'id' => $id
            ))->row();

            $cart = json_decode($order->cart, true);
            //return back to Inventory

                foreach ($cart as $item){
                    $p_details = $this->db->get_where('product', array(
                        'id' => $item['id']
                    ))->row();

                    if($p_details->type === 'Inventory'){
                        $p_qty['inventory'] =  $p_details->inventory + $item['qty'];
                        //return Product qty
                        $this->db->where('id', $item['id']);
                        $this->db->update('product', $p_qty);
                    }
                }
            $data['amount_received'] = '0.00';
            $data['due_payment'] = '0.00';
        }
        $data['status'] = 'Cancel';
        $data['cancel_note'] = $this->input->post('cancel_note');

        //update
        $this->db->where('id', $id);
        $this->db->update('sales_order', $data);

        redirect('admin/sales/sale_preview/'.get_orderID($id));

     }

    function addPayment($id = null)
    {
        $id = $id - INVOICE_PRE;
        $data['order'] =  $this->db->get_where('sales_order', array('id' => $id ))->row();

        $data['modal_subview'] = $this->load->view('admin/sales/modal/_add_payment',$data, FALSE);
        $this->load->view('admin/_partials/_layout_modal', $data);
    }

    function received_payment ()
    {
        $id = $this->input->post('payment_id');
        $data['order_id'] = $this->input->post('order_id');
        $order =  $this->db->get_where('sales_order', array('id' => $data['order_id'] ))->row();

        $data['payment_date'] = $this->input->post('payment_date');
        $order_ref = $this->input->post('order_ref');
        if($order_ref == ''){
            $data['order_ref'] = get_orderID($data['order_id']).'/'. date("d/m/Y");
        }else{
            $data['order_ref'] = $order_ref;
        }

        $data['amount'] = (float)$this->input->post('amount');
        $data['method'] = $this->input->post('payment_method');
        $payment_method = $this->input->post('payment_method');

        if($payment_method == 'cash'){
            $data['payment_method'] = 'Cash';
        }
        elseif ($payment_method == 'cc')
        {
            $data['payment_method'] = 'Credit Card';
            $data['cc_name'] = $this->input->post('cc_name');
            $data['cc_number'] = $this->input->post('cc_number');
            $data['cc_type'] = $this->input->post('cc_type');
            $data['cc_month'] = $this->input->post('cc_month');
            $data['cc_year'] = $this->input->post('cc_year');
            $data['cvc'] = $this->input->post('cvc');
        }
        elseif ($payment_method == 'ck')
        {
            $data['payment_method'] = 'Cheque';
            $data['payment_ref'] = $this->input->post('payment_ref');
        }
        elseif ($payment_method == 'bank')
        {
            $data['payment_method'] = 'Bank Transfer';
            $data['payment_ref'] = $this->input->post('payment_ref');
        }

        $data['type'] = 'Sales';
        $sales_person = $this->ion_auth->user()->row();
        $data['received_by'] = $sales_person->first_name.' '.$sales_person->last_name;

        $path = UPLOAD_BILL;
        mkdir_if_not_exist($path);
        $file = upload_bill();
        if($file)
            $data['attachment'] = $file;

        if($id){//update
            $payment =  $this->db->get_where('payment', array('id' => $id ))->row();
            //trancate Payment
            $t_data['payment_method'] = '';
            $t_data['cc_name'] = '';
            $t_data['cc_number'] = '';
            $t_data['cc_type'] = '';
            $t_data['cc_month'] = '';
            $t_data['cc_year'] = '';
            $t_data['cvc'] = '';
            $t_data['payment_ref'] = '';

            $this->db->where('id', $id);
            $this->db->update('payment', $t_data);

            //update payment table
            $this->db->where('id', $id);
            $this->db->update('payment', $data);

            //update purchase order
            $p_data['amount_received'] = $order->amount_received + $data['amount'] - $payment->amount;
            $p_data['due_payment'] = $order->grand_total - $p_data['amount_received'];
            $this->db->where('id', $order->id);
            $this->db->update('sales_order', $p_data);

        }else{
            //insert
            $this->db->insert('payment', $data);

            //update purchase order
            $p_data['amount_received'] = $order->amount_received + $data['amount'];
            $p_data['due_payment'] = $order->due_payment - $data['amount'];

            $this->db->where('id', $order->id);
            $this->db->update('sales_order', $p_data);
        }

        redirect('admin/sales/sale_preview/'.get_orderID($order->id));
    }

    function paymentList($id = null)
    {
        $id = $id - INVOICE_PRE;
        $data['payment'] = $this->db->get_where('payment', array(
            'order_id' => $id,
            'type'     => 'Sales'
        ))->result();

        $data['modal_subview'] = $this->load->view('admin/sales/modal/_payment_list',$data, FALSE);
        $this->load->view('admin/_partials/_layout_modal_small', $data);
    }

    function viewPayment($id = null){

        $data['payment'] = $this->db->get_where('payment', array( 'id' => $id,))->row();

        $order = $this->db->get_where('sales_order', array( 'id' => $data['payment']->order_id,))->row();

        $data['order'] = $order;

        $data['customer'] = $this->db->get_where('customer', array( 'id' => $order->customer_id, ))->row();

        $data['modal_subview'] = $this->load->view('admin/sales/modal/_view_payment',$data, FALSE);
        $this->load->view('admin/_partials/_layout_modal', $data);
    }

    function editPayment($id = null)
    {
        $data['payment'] = $this->db->get_where('payment', array(
            'id' => $id,
        ))->row();

        $data['order'] =  $this->db->get_where('sales_order', array('id' => $data['payment']->order_id ))->row();
        $data['modal_subview'] = $this->load->view('admin/sales/modal/_add_payment',$data, FALSE);
        $this->load->view('admin/_partials/_layout_modal', $data);
    }

    function deletePayment($id = null)
    {
        $payment = $this->db->get_where('payment', array('id' => $id, ))->row();
        $order = $this->db->get_where('sales_order', array( 'id' => $payment->order_id, ))->row();

        //delete payment
        $this->db->delete('payment', array('id' => $id));

        //update purchase order
        $p_data['amount_received'] = $order->amount_received - $payment->amount;
        $p_data['due_payment'] = $order->grand_total - $p_data['amount_received'];

        $this->db->where('id', $order->id);
        $this->db->update('sales_order', $p_data);

        redirect('admin/sales/sale_preview/'.get_orderID($order->id));
    }

    function deleteInvoice($id = null)
    {
        $id = $id - INVOICE_PRE;
        $order = $this->db->get_where('sales_order', array('id' => $id ))->row();

        if($order->type == 'Invoice'){
            //delete Payment
            $this->db->delete('payment', array('order_id' => $order->id, 'type' => 'Sales'));

            //Return Inventory
            $products = $this->db->get_where('order_details', array('order_id' => $order->id ))->result();

            foreach ($products as $item)
            {
                //update inventory
                $product = $this->db->get_where('product', array('id' => $item->product_id ))->row();

                if($product->type === 'Bundle'){
                    $bundle = json_decode($product->bundle);
                    foreach ($bundle as $s_item){
                        $product = $this->db->get_where('product', array('id' => $s_item->product_id ))->row();
                        $inv_data['inventory'] = $product->inventory + $s_item->qty;
                        $this->db->where('id', $s_item->product_id);
                        $this->db->update('product', $inv_data);
                    }

                }elseif ($product->type === 'Inventory'){
                    $inv_data['inventory'] = $product->inventory + $item->qty;
                    $this->db->where('id', $item->product_id);
                    $this->db->update('product', $inv_data);
                }
            }
            //delete order details
            $this->db->delete('order_details', array('order_id' => $order->id));
        }

        $this->db->delete('sales_order', array('id' => $order->id));

        $this->message->delete_success('admin/sales/allOrder');


    }

    function overdueInvoice(){
        //$this->mViewData['due'] = $this->sales->overdue_order();
        $today = date('Y/m/d');
        $crud = new grocery_CRUD();
        //$crud = $this->generate_crud('sales_order');
        $crud->columns('date','id','customer_name','due_date','grand_total','amount_received', 'due_payment','status','delivery_status', 'actions');
        $crud->order_by('id','desc');
        $crud->where('due_payment >','0');
        $crud->where('due_date <=',$today);
        $crud->where('type','Invoice');


        $crud->display_as('date', lang('date'));
        $crud->display_as('id', lang('order_no'));
        $crud->display_as('customer_name', lang('customer'));
        $crud->display_as('due_date', lang('due_date'));
        $crud->display_as('grand_total', lang('grand_total'));
        $crud->display_as('amount_received', lang('paid'));
        $crud->display_as('due_payment', lang('balance'));
        $crud->display_as('status',lang('status'));
        $crud->display_as('delivery_status',lang('shipping'));
        $crud->display_as('actions', lang('actions'));

        $crud->set_table('sales_order');
        $crud->callback_column('date',array($this->crud,'_callback_action_date'));
        $crud->callback_column('id',array($this->crud,'_callback_action_orderNo'));
        $crud->callback_column('due_date',array($this->crud,'_callback_action_dueDate'));
        $crud->callback_column('due_payment',array($this->crud,'_callback_action_due_payment'));
        $crud->callback_column('grand_total',array($this->crud,'_callback_action_grand_total'));
        $crud->callback_column('actions',array($this->crud,'_callback_action_all_order'));
        $crud->unset_add();
        $crud->unset_edit();
        $crud->unset_delete();
        $crud->unset_read();

        $this->mViewData['crud'] = $crud->render();
        $this->mViewData['title'] = lang('overdue_invoice_list');

        $this->mTitle .= lang('overdue_invoice_list');
        $this->render('sales/crud');
    }

    function openInvoice(){

        $today = date('Y/m/d');
        $crud = new grocery_CRUD();
        //$crud = $this->generate_crud('sales_order');
        $crud->columns('date','id','customer_name','due_date','grand_total','amount_received', 'due_payment','delivery_status', 'actions');
        $crud->order_by('id','desc');
        $crud->where('status','Open');
        $crud->where('type','Invoice');


        $crud->display_as('date', lang('date'));
        $crud->display_as('id', lang('order_no'));
        $crud->display_as('customer_name', lang('customer'));
        $crud->display_as('due_date', lang('due_date'));
        $crud->display_as('grand_total', lang('grand_total'));
        $crud->display_as('due_payment', lang('balance'));
        $crud->display_as('amount_received', lang('paid'));
        $crud->display_as('delivery_status',lang('order_status'));
        $crud->display_as('actions', lang('actions'));

        $crud->set_table('sales_order');
        $crud->callback_column('date',array($this->crud,'_callback_action_date'));
        $crud->callback_column('id',array($this->crud,'_callback_action_orderNo'));
        $crud->callback_column('due_date',array($this->crud,'_callback_action_dueDate'));
        $crud->callback_column('due_payment',array($this->crud,'_callback_action_due_payment'));
        $crud->callback_column('grand_total',array($this->crud,'_callback_action_grand_total'));
        $crud->callback_column('delivery_status',array($this->crud,'_callback_action_order_status'));
        $crud->callback_column('actions',array($this->crud,'_callback_action_all_order'));
        $crud->unset_add();
        $crud->unset_edit();
        $crud->unset_delete();
        $crud->unset_read();

        $this->mViewData['crud'] = $crud->render();
        $this->mViewData['title'] = lang('open_invoice_list');

        $this->mTitle .= lang('open_invoice_list');
        $this->render('sales/crud');
    }


    //------------------------------------------------------------------------------------------------------------
    //************************* Add to cart *****************************************************************
    //------------------------------------------------------------------------------------------------------------


    function add_to_cart()
    {
        $id = $this->input->post('product_id');
        $product = $this->db->get_where('product', array( 'id' => $id ))->row();

        if(!empty($this->input->post('rowid'))){
            $data = array(
                'rowid' => $this->input->post('rowid'),
                'qty'   => 0
            );
            $this->cart->update($data);
        }

        if(count($product)){

            if($product->type === 'Bundle'){
                $total_qty = 0;
                $price = 0;
                $total_purchase = 0;
                $product_name = '';
                $bundle = json_decode($product->bundle);
                foreach ($bundle as $item){
                    $b_product =  $this->db->get_where('product', array( 'id' => $item->product_id ))->row();

                    $total_qty += $item->qty;
                    $price += $b_product->sales_cost * $item->qty;
                    $total_purchase += $b_product->buying_cost * $item->qty;
                    $product_name .= '<p>'.$b_product->name.' - '.$item->qty.' PCS</p>';
                }

                $tax = $this->product_tax_calculate($product->tax_id, $qty=1, $price);
                $data = array(
                    'id'                => $id,
                    'qty'               => 1,
                    'price'             => $price,
                    'purchase_cost'     => $total_purchase,
                    'name'              => $product->name,
                    'description'       => $product_name,
                    'tax'               => $tax,
                    'type'              => TRUE,
                    'bundle'            => $bundle
                );

//                echo '<pre>';
//                print_r($data);
//                exit();

                $this->cart->insert($data);

            }else{

                //product tax check
                $tax = $this->product_tax_calculate($product->tax_id, $qty=1, $product->sales_cost);

                $data = array(
                    'id'                => $product->id,
                    'qty'               => 1,
                    'price'             => $product->sales_cost,
                    'purchase_cost'     => $product->buying_cost,
                    'name'              => $product->name,
                    'description'       => $product->sales_info,
                    'tax'               => $tax,
                    'type'              => FALSE,
                    'bundle'            => ''
                    //'options' => array('Size' => 'L', 'Color' => 'Red')
                );
                $this->cart->insert($data);
            }
        }
    }

    /*** Product tax calculation ***/
    public function product_tax_calculate($tax_id, $qty ,$price)
    {
        $tax = $this->db->get_where('tax', array('id' => $tax_id ))->row();

        //1 = tax in %
        //2 = Fixed tax Rate

        if($tax){
            if($tax->type == 1)
            {
                $subtotal = $price * $qty;
                $product_tax = ($tax->rate * $subtotal) / 100;
                return $result = $product_tax;

            }else
            {
                $product_tax = $tax->rate * $qty;
                return $result = $product_tax;
            }
        }
    }

    function update_cart_item()
    {
        $type = $this->input->post('type');

        //product tax check
        $product = $this->db->get_where('product', array( 'id' => $this->input->post('p_id') ))->row();
        $qty = $this->input->post('qty');
        $price = $this->input->post('price');
        $tax = $this->product_tax_calculate($product->tax_id, $qty, $price);

        if($type === 'qty')
        {
            $data = array(
                'rowid' => $this->input->post('rowid'),
                'qty'   => (int)$this->input->post('o_val'),
                'tax'   => $tax
            );
        }
        elseif ($type === 'prc'){
            $data = array(
                'rowid' => $this->input->post('rowid'),
                'price'   => (float)$this->input->post('o_val'),
                'tax'   => $tax
            );
        }
        elseif ($type === 'des'){
            $data = array(
                'rowid' => $this->input->post('rowid'),
                'description'   => $this->input->post('o_val')
            );
        }

        $this->cart->update($data);
    }

    function remove_item(){
        $data = array(
            'rowid' => $this->input->post('rowid'),
            'qty'   => 0
        );
        $this->cart->update($data);
    }

    /*** Show cart ***/
    function show_cart(){
        $categories = $this->db->order_by('category', 'asc')->get('product_category')->result();

        if(!empty($categories)){
            foreach ($categories as $item){
                $tm_product = $this->db->order_by('name', 'asc')->get_where('product', array(
                    'category_id' => $item->id
                ))->result();

                if(!count($tm_product))
                    continue;

                $products[$item->category] = $tm_product;
            }
        }
        $data['products'] = $products;
        $this->load->view('sales/cart/add_product_cart',$data);
    }

    function order_discount()
    {
        $discount = (float)$this->input->post('discount');
        if(!empty($discount)){
            $data = array(
                'discount' => $discount
            );
        }else{
            $data = array(
                'discount' => 0
            );
        }
        $this->session->set_userdata($data);
    }

    function select_customer_by_id()
    {
        $result  =  $this->db->get_where('customer', array( 'id' => $this->input->post('customer_id') ))->row();
        if(count($result)){
            echo json_encode(array(
                'id'          => $result->id,
                'email'       => $result->email,
                'b_address'   => $result->b_address,
                's_address'   => $result->s_address,
            ));
        }else{
            echo json_encode(array(
                'id'          => '',
                'email'       => '',
                'b_address'   => '',
                's_address'   => '',
            ));
        }


    }

    function sendInvoice($id = null)
    {
        $id = $id - INVOICE_PRE;
        //query
        $data['order'] = $this->db->get_where('sales_order', array(
            'id' => $id
        ))->row();


        if(!count($data['order'])){
            redirect('admin/dashboard', 'refresh');
        }

        if($data['order']->type === 'Quotation')
        {
            $cart = json_decode($data['order']->cart);
            foreach ($cart as $item)
            {
                $order_details[] = (object)array(
                    'product_name' => $item->name,
                    'description' => $item->description,
                    'purchase_cost' => $item->purchase_cost,
                    'sales_cost' => $item->price,
                    'qty' => $item->qty,
                );
            }
            $data['order_details'] = $order_details;
        }
        else
        {
            $data['order_details'] = $this->db->get_where('order_details', array(
                'order_id' => $id
            ))->result();
        }

        $data['payment'] = $this->db->get_where('payment', array(
            'order_id' => $id,
            'type'     => 'Sales'
        ))->result();

        //customer
        $data['customer'] = $this->db->get_where('customer', array(
            'id' => $data['order']->customer_id
        ))->row();

        $data['type'] = $data['order']->type;

        $file= INVOICE_PRE + $id;
        $filename = get_option('invoice_prefix').$file.'.pdf';
        $this->load->library('pdf');
        $pdf = $this->pdf->load();

        $html = $this->load->view('sales/invoice_pdf', $data, true);


        $pdf->SetFooter($_SERVER['HTTP_HOST'].'|{PAGENO}|'.date(DATE_RFC822));
        $stylesheet = file_get_contents(FCPATH.'assets/css/invoice.css');

        $pdf->WriteHTML($stylesheet,1);
        $pdf->WriteHTML($html,2);
        $pdfFilePath = FCPATH.'assets/invoice/'.$filename;


        ini_set('memory_limit','32M');
        //$pdf->Output($filename, 'D');
        $pdf->Output($pdfFilePath, 'f');

        $data['file_name'] = $filename;
        $data['file_path'] = $pdfFilePath;
        $data['modal_subview'] = $this->load->view('admin/sales/modal/_send_email',$data, FALSE);
        $this->load->view('admin/_partials/_layout_modal', $data);


    }

    function sendEmail()
    {
        $id = $this->input->post('id');
        $mailType = get_option('email_send_option');
        if($mailType == 'smtp')
        {
            $config = Array(
                'protocol' => 'smtp',
                'smtp_host' => get_option('smtp_host'),
                'smtp_port' => get_option('smtp_port'),
                'smtp_user' => get_option('smtp_username'),
                'smtp_pass' => get_option('smtp_password'),
                'mailtype'  => 'html',
                'charset'   => 'iso-8859-1'
            );
            $this->load->library('email', $config);

            $to_list = $this->input->post('to');
            //$to = explode(",", $to_list);

            $this->email->from(get_option('all_other_mails_from'), get_option('mail_sender'));
            $this->email->to($to_list);

            $this->email->subject($this->input->post('subject'));
            $this->email->message($this->input->post('msg'));
            $this->email->attach($this->input->post('filepath'));
            if ($this->email->send())
            {
                $this->message->custom_success_msg('admin/sales/sale_preview/'.get_orderID($id), lang('your_email_has_been_send_successfully!'));
            }else{
                $this->message->custom_error_msg('admin/sales/sale_preview/'.get_orderID($id), lang('fail_to_send_your_email'));
            }

        }else{
            require_once(APPPATH.'third_party/PHPMailer/class.phpmailer.php');
            $email = new PHPMailer();
            $email->From      = get_option('all_other_mails_from');
            $email->FromName  = get_option('mail_sender');
            $email->Subject   = $this->input->post('subject');
            $email->Body      = $this->input->post('msg');
            $email->IsHTML(true);
            $to_list = $this->input->post('to');
            $email_list = explode(',',$to_list);

            foreach ($email_list as $item) {
                $email->AddAddress($item);
            }

            $file_to_attach = $this->input->post('filepath');

            $email->AddAttachment( $file_to_attach);

            //return $email->Send();
            if ($email->Send())
            {
                $this->message->custom_success_msg('admin/sales/sale_preview/'.get_orderID($id), lang('your_email_has_been_send_successfully!'));
            }else{
                $this->message->custom_error_msg('admin/sales/sale_preview/'.get_orderID($id), lang('fail_to_send_your_email'));
            }
        }
    }

    function downloadPaymentReceipt($file = null)
    {
        $this->load->helper('download');
        $file = base_url().UPLOAD_BILL.'/'.$file;
        $data =  file_get_contents($file);
        force_download($file, $data);
    }

}