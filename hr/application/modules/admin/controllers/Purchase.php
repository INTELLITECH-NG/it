<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Purchase extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_builder');
        $this->load->library('cart');
        $this->load->model('global_model');
        $this->load->model('sales_model', 'sales');
        $this->load->model('crud_model', 'crud');
        $this->load->library('grocery_CRUD');
        $this->mTitle = TITLE;
    }


    function newPurchase()
    {
        $this->cart->destroy();
        $data = array(
            'tax' => '',
            'discount' => '',
            'shipping' => '',
        );
        $this->session->set_userdata($data);

        $vendorId = $this->input->get('nameID');

        if(!empty($vendorId)){
            $v_detail = $this->db->get_where('vendor', array('id' => $vendorId))->row();
            if(count($v_detail)){
                $this->mViewData['v_detail'] = $v_detail;
            }
        }else{
            $this->mViewData['v_detail'] = (object) array(
                'id'        => '',
                'b_address' => '',
                'email'     => '',
            );
        }

        $this->mViewData['form'] = $this->form_builder->create_form('admin/purchase/save_purchase',true, array('id'=>'from-invoice'));
        $this->mViewData['vendors'] = $this->db->get('vendor')->result();

        $categories = $this->db->order_by('category', 'asc')->get('product_category')->result();

        if(!empty($categories)){
            foreach ($categories as $item){
                $tm_product = $this->db->order_by('name', 'asc')->get_where('product', array(
                    'category_id' => $item->id,
                    'type' => 'Inventory',
                ))->result();

                if(!count($tm_product))
                    continue;

                $products[$item->category] = $tm_product;
            }
        }

        $this->mViewData['products'] = $products;
        $this->mTitle .= lang('create_purchase');
        $this->render('purchase/create_invoice');

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

            $data = array(
                'id'                => $product->id,
                'qty'               => 1,
                'price'             => $product->buying_cost,
                'name'              => $product->name,
                'description'       => $product->buying_info,
                //'options' => array('Size' => 'L', 'Color' => 'Red')
            );
            $this->cart->insert($data);
        }

    }

    function update_cart_item()
    {
        $type = $this->input->post('type');

        if($type === 'qty')
        {
            $data = array(
                'rowid' => $this->input->post('rowid'),
                'qty'   => (int)$this->input->post('o_val')
            );
        }
        elseif ($type === 'prc'){
            $data = array(
                'rowid' => $this->input->post('rowid'),
                'price'   => (float)$this->input->post('o_val')
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
                    'category_id' => $item->id,
                    'type' => 'Inventory',
                ))->result();

                if(!count($tm_product))
                    continue;

                $products[$item->category] = $tm_product;
            }
        }
        $data['products'] = $products;
        $this->load->view('purchase/cart/add_product_cart',$data);
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

    function order_tax()
    {
        $tax = (float)$this->input->post('tax');
        if(!empty($tax)){
            $data = array(
                'tax' => $tax
            );
        }else{
            $data = array(
                'tax' => 0
            );
        }
        $this->session->set_userdata($data);
    }

    function order_shipping()
    {
        $shipping = (float)$this->input->post('shipping');
        if(!empty($shipping)){
            $data = array(
                'shipping' => $shipping
            );
        }else{
            $data = array(
                'shipping' => 0
            );
        }
        $this->session->set_userdata($data);
    }

    function select_vendor_by_id()
    {
        $result  =  $this->db->get_where('vendor', array( 'id' => $this->input->post('vendor_id') ))->row();
        if(count($result)){
            echo json_encode(array(
                'id'          => $result->id,
                'email'       => $result->email,
                'b_address'   => $result->b_address,
            ));
        }else{
            echo json_encode(array(
                'id'          => '',
                'email'       => '',
                'b_address'   => '',
            ));
        }
    }

    function save_purchase()
    {
        $sales_person = $this->ion_auth->user()->row();

        $data['email']          = $this->input->post('email');
        $data['b_address']      = $this->input->post('b_address');
        $data['order_note']     = $this->input->post('order_note');
        $data['ref']     = $this->input->post('bill_ref');

        $data['cart_total']     = $this->cart->total();
        $data['discount']       = (float)$this->session->userdata('discount');
        $data['tax']            = (float)$this->session->userdata('tax');
        $data['shipping']       = (float)$this->session->userdata('shipping');

        $data['grand_total']    = $this->cart->total()+ $data['tax'] + $data['shipping']  - $data['discount'];
        $data['due_payment']    = $data['grand_total'];
        $data['cart']           = json_encode($this->cart->contents());

        $data['sales_person']   = $sales_person->first_name.' '.$sales_person->last_name;
        $data['vendor_id']      = $this->input->post('vendor_id');

        $data['vendor_name']    = $this->db->get_where('vendor', array(
                                        'id' => $data['vendor_id']
                                    ))->row()->company_name;

        //save purchase_order table
        $this->db->insert('purchase_order', $data);
        $purchase_id = $this->db->insert_id();

        //save purchase order details
        foreach ($this->cart->contents() as $item){
            $o_details['purchase_id']       = $purchase_id;
            $o_details['product_id']        = $item['id'];
            $o_details['product_name']      = $item['name'];
            $o_details['description']       = $item['description'];
            $o_details['qty']               = $item['qty'];
            $o_details['unit_price']        = $item['price'];
            $o_details['sub_total']        = $item['subtotal'];
            //save order details
            $this->db->insert('purchase_details', $o_details);
        }

        $this->message->save_success('admin/purchase/purchaseList');


    }

    function purchaseList()
    {
        $this->mViewData['due'] = $this->sales->total_purchase_due_by_vendor();
        $this->mViewData['paid'] = $this->sales->total_purchase_paid_by_vendor();
        $this->mViewData['totalInvoice'] = $this->sales->total_purchase_invoice_by_vendor();
        $this->mViewData['returnPurchase'] = $this->sales->total_return_purchase_by_vendor();


        $crud = new grocery_CRUD();
        //$crud = $this->generate_crud('sales_order');
        $crud->columns('date','purchase_id','vendor_name', 'purchase_status','grand_total','paid_amount','due_payment', 'actions');
        $crud->order_by('id','desc');

        $crud->display_as('date', lang('date'));
        $crud->display_as('purchase_id',lang('purchase_no'));
        $crud->display_as('vendor_name',lang('supplier'));
        $crud->display_as('purchase_status',lang('status'));
        $crud->display_as('grand_total', lang('grand_total'));
        $crud->display_as('paid_amount', lang('paid'));
        $crud->display_as('due_payment', lang('balance'));
        $crud->display_as('actions', lang('actions'));

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
        $this->mViewData['title'] = lang('purchase_list');

        $this->mTitle .= lang('purchase_list');
        $this->render('purchase/purchase_list');
    }

    function purchaseInvoice($id = null)
    {
        $id = $id - INVOICE_PRE;
        //query
        $this->mViewData['order'] = $this->db->get_where('purchase_order', array(
            'id' => $id
        ))->row();

        if(!count($this->mViewData['order'])){
            redirect('admin/dashboard', 'refresh');
        }

        //purchase
        $this->mViewData['order_details'] = $this->db->get_where('purchase_details', array(
            'purchase_id' => $id,
            'type'        => 'Purchase'
        ))->result();

        //return
        $this->mViewData['return'] = $this->db->get_where('purchase_details', array(
            'purchase_id' => $id,
            'type'        => 'Return'
        ))->result();

        $this->mViewData['payment'] = $this->db->get_where('payment', array(
            'order_id' => $id,
            'type'     => 'purchase'
        ))->result();


        //vendor
        $this->mViewData['vendor'] = $this->db->get_where('vendor', array(
            'id' => $this->mViewData['order']->vendor_id
        ))->row();

        $this->mTitle .= lang('purchase_invoice');
        $this->render('purchase/invoice');
    }

    function pdfInvoice($id = null)
    {
        $id = $id - INVOICE_PRE;

        //query
        $data['order'] = $this->db->get_where('purchase_order', array(
            'id' => $id
        ))->row();

        if(!count($data['order'])){
            redirect('admin/dashboard', 'refresh');
        }

        $data['order_details'] = $this->db->get_where('purchase_details', array(
            'purchase_id' => $id,
            'type'        => 'Purchase'
        ))->result();

        //return
        $data['return'] = $this->db->get_where('purchase_details', array(
            'purchase_id' => $id,
            'type'        => 'Return'
        ))->result();

        $data['payment'] = $this->db->get_where('payment', array(
            'order_id' => $id,
            'type'     => 'purchase'
        ))->result();

        //customer
        $data['vendor'] = $this->db->get_where('vendor', array(
            'id' => $data['order']->vendor_id
        ))->row();

        $file= INVOICE_PRE + $id;
        $filename = get_option('order_prefix').$file.'.pdf';
        $this->load->library('pdf');
        $pdf = $this->pdf->load();

        $html = $this->load->view('purchase/invoice_pdf', $data, true);


        $pdf->SetFooter($_SERVER['HTTP_HOST'].'|{PAGENO}|'.date(DATE_RFC822));
        $stylesheet = file_get_contents(FCPATH.'assets/css/invoice.css');

        $pdf->WriteHTML($stylesheet,1);
        $pdf->WriteHTML($html,2);
        $pdf->Output($filename, 'D');
    }

    function createReceipt()
    {
        $this->mTitle .= 'Create Receipt Product';
        $this->render('purchase/create_receipt');
    }

    function find_purchase_details()
    {
        $purchase_no = $this->input->post('purchase_no');
        $id = $purchase_no - INVOICE_PRE;

        $this->mViewData['purchase_order'] =  $this->db->get_where('purchase_order', array(
            'id' => $id
        ))->row();


        if(empty($this->mViewData['purchase_order'])){
            $this->message->norecord_found('admin/purchase/createReceipt');
        }

        $this->mViewData['purchase_product'] = $this->db->get_where('purchase_details', array(
            'purchase_id' => $id
        ))->result();


        $this->mTitle .= 'Create Receipt Product';
        $this->mViewData['flag'] = 1;
        $this->render('purchase/receipt_product');
    }

    function received_product()
    {
        $receiver = $this->ion_auth->user()->row();
        $id     = $this->input->post('id');
        $qty    = $this->input->post('qty');
        $order_id    = $this->input->post('order_id');

        $purchase_order = $this->db->get_where('purchase_order', array('id' => $order_id ))->row();

        foreach ($id as $key => $item)
        {
            if($qty[$key]<=0)
                continue;
            $purchase_product = $this->db->get_where('purchase_details', array('id' => $item ))->row();

            $data = array();
            $data['order_id']       = $purchase_order->id;
            $data['vendor_id']      = $purchase_order->vendor_id;
            $data['vendor_name']    = $purchase_order->vendor_name;
            $data['product_id']     = $purchase_product->product_id;
            $data['product_name']   = $purchase_product->product_name;
            $data['qty']            = $qty[$key];
            $data['receiver']       = $receiver->first_name.' '.$receiver->last_name;

            //insert Received Product
            $this->db->insert('received_product', $data);
            //update
            $total_received = $purchase_product->total_received + $qty[$key];
            $this->db->set('total_received', $total_received, FALSE)->where('id', $item)->update('purchase_details');
            //update inventory
            $product = $this->db->get_where('product', array('id' => $purchase_product->product_id ))->row();
            $data = array();
            $data['inventory'] = $product->inventory+$qty[$key];
            $this->db->where('id', $purchase_product->product_id);
            $this->db->update('product', $data);
        }

        redirect('admin/purchase/receivedProductList');


    }

    function receivedProductList()
    {
        $crud = new grocery_CRUD();
        //$crud = $this->generate_crud('sales_order');
        $crud->columns('date_time','order_id','vendor_name','product_name','qty','receiver');
        $crud->order_by('id','desc');

        $crud->display_as('date', lang('date'));
        $crud->display_as('order_id',lang('purchase_no'));
        $crud->display_as('vendor_name',lang('supplier'));
        $crud->display_as('product_name',lang('product'));
        $crud->display_as('qty',lang('qty'));
        $crud->display_as('receiver',lang('received_by'));

        $crud->display_as('purchase_status',lang('status'));
        $crud->display_as('grand_total', lang('grand_total'));
        $crud->display_as('paid_amount', lang('paid'));
        $crud->display_as('due_payment', lang('balance'));
        $crud->display_as('actions', lang('actions'));



        $crud->set_table('received_product');
        $crud->callback_column('date_time',array($this->crud,'_callback_action_date_time'));
        $crud->callback_column('order_id',array($this->crud,'_callback_action_received_Product'));

        $crud->unset_add();
        $crud->unset_edit();
        $crud->unset_delete();
        $crud->unset_read();

        $this->mViewData['crud'] = $crud->render();
        $this->mViewData['title'] = lang('received_product');

        $this->mTitle .= lang('received_product');
        $this->render('purchase/crud');
    }

    function returnPurchase($id = null)
    {
        $id = $id - INVOICE_PRE;
        //query
        $data['purchase_order'] =  $this->db->get_where('purchase_order', array(
            'id' => $id
        ))->row();

        $data['purchase_product'] = $this->db->get_where('purchase_details', array(
            'purchase_id' => $id,
            'type'        => 'Purchase'
        ))->result();

        $data['modal_subview'] = $this->load->view('admin/purchase/modal/_return_purchase',$data, FALSE);
        $this->load->view('admin/_partials/_layout_modal', $data);

    }

    function addPayment($id = null)
    {
        $id = $id - INVOICE_PRE;
        $data['purchase_order'] =  $this->db->get_where('purchase_order', array('id' => $id ))->row();

        $data['modal_subview'] = $this->load->view('admin/purchase/modal/_add_payment',$data, FALSE);
        $this->load->view('admin/_partials/_layout_modal', $data);
    }

    function received_payment ()
    {
        $id = $this->input->post('payment_id');
        $data['order_id'] = $this->input->post('order_id');
        $purchase_order =  $this->db->get_where('purchase_order', array('id' => $data['order_id'] ))->row();


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

        $data['type'] = 'Purchase';
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
            $p_data['paid_amount'] = $purchase_order->paid_amount + $data['amount'] - $payment->amount;
            $p_data['due_payment'] = $purchase_order->grand_total - $p_data['paid_amount'];
            $this->db->where('id', $purchase_order->id);
            $this->db->update('purchase_order', $p_data);

        }else{
            //insert
            $this->db->insert('payment', $data);

            //update purchase order
            $p_data['paid_amount'] = $purchase_order->paid_amount + $data['amount'];
            $p_data['due_payment'] = $purchase_order->due_payment - $data['amount'];
            $this->db->where('id', $purchase_order->id);
            $this->db->update('purchase_order', $p_data);
        }

        redirect('admin/purchase/purchaseInvoice/'.get_orderID($purchase_order->id));
    }

    function downloadPaymentReceipt($file = null)
    {
        $this->load->helper('download');
        $file = base_url().UPLOAD_BILL.'/'.$file;
        $data =  file_get_contents($file);
        force_download($file, $data);
    }

    function paymentList($id = null)
    {
        $id = $id - INVOICE_PRE;
        $data['payment'] = $this->db->get_where('payment', array(
            'order_id' => $id,
            'type'     => 'purchase'
        ))->result();

        $data['modal_subview'] = $this->load->view('admin/purchase/modal/_payment_list',$data, FALSE);
        $this->load->view('admin/_partials/_layout_modal_small', $data);
    }

    function editPayment($id = null)
    {
        $data['payment'] = $this->db->get_where('payment', array(
            'id' => $id,
        ))->row();

        $data['purchase_order'] =  $this->db->get_where('purchase_order', array('id' => $data['payment']->order_id ))->row();
        $data['modal_subview'] = $this->load->view('admin/purchase/modal/_add_payment',$data, FALSE);
        $this->load->view('admin/_partials/_layout_modal', $data);
    }

    function viewPayment($id = null){

        $data['payment'] = $this->db->get_where('payment', array( 'id' => $id,))->row();

        $purchase = $this->db->get_where('purchase_order', array( 'id' => $data['payment']->order_id,))->row();

        $data['purchase'] = $purchase;

        $data['vendor'] = $this->db->get_where('vendor', array( 'id' => $purchase->vendor_id, ))->row();

        $data['modal_subview'] = $this->load->view('admin/purchase/modal/_view_payment',$data, FALSE);
        $this->load->view('admin/_partials/_layout_modal', $data);
    }

    function deletePayment($id = null)
    {
        $payment = $this->db->get_where('payment', array('id' => $id, ))->row();
        $purchase = $this->db->get_where('purchase_order', array( 'id' => $payment->order_id, ))->row();

        //delete payment
        $this->db->delete('payment', array('id' => $id));

        //update purchase order
        $p_data['paid_amount'] = $purchase->paid_amount - $payment->amount;
        $p_data['due_payment'] = $purchase->grand_total - $p_data['paid_amount'];

        $this->db->where('id', $purchase->id);
        $this->db->update('purchase_order', $p_data);

        redirect('admin/purchase/purchaseInvoice/'.get_orderID($purchase->id));
    }

    function receivedProduct($id = null)
    {
        $id = $id - INVOICE_PRE;
        //query
        $data['purchase_order'] =  $this->db->get_where('purchase_order', array(
            'id' => $id
        ))->row();

        $data['purchase_product'] = $this->db->get_where('purchase_details', array(
            'purchase_id' => $id,
            'type' => 'Purchase',

        ))->result();

        $data['modal_subview'] = $this->load->view('admin/purchase/modal/_received_product',$data, FALSE);
        $this->load->view('admin/_partials/_layout_modal', $data);
    }

    function return_product()
    {
        $return_amount = 0;
        $receiver = $this->ion_auth->user()->row();
        $id     = $this->input->post('id');
        $qty    = $this->input->post('qty');
        $order_id    = $this->input->post('order_id');


        $purchase_order = $this->db->get_where('purchase_order', array('id' => $order_id ))->row();

        $data['vendor_id'] = $purchase_order->vendor_id;
        $data['vendor_name'] = $purchase_order->vendor_name;
        $data['email'] = $purchase_order->email;
        $data['b_address'] = $purchase_order->b_address;
        $data['return_ref'] = $purchase_order->id;
        $data['type'] = 'Return';
        $data['sales_person'] = $receiver->first_name.' '.$receiver->last_name;

        $this->db->insert('purchase_order', $data);
        $purchaseID = $this->db->insert_id();

//                echo '<pre>';
//        print_r($data);
//        exit();


        foreach ($id as $key => $item)
        {
            if($qty[$key]<=0)
                continue;
            $purchase_product = $this->db->get_where('purchase_details', array('id' => $item ))->row();

            //update return Quantity
            $r_data['return_qty'] = $purchase_product->return_qty + $qty[$key];
            $this->db->where('id', $purchase_product->id);
            $this->db->update('purchase_details', $r_data);


            $p_data['purchase_id']      = $purchase_product->purchase_id;
            $p_data['product_id']       = $purchase_product->product_id;
            $p_data['product_name']     = $purchase_product->product_name;
            $p_data['description']      = $purchase_product->description;
            $p_data['qty']              = $qty[$key];
            $p_data['unit_price']       = $purchase_product->unit_price;
            $p_data['sub_total']        = $purchase_product->unit_price * $qty[$key];
            $p_data['type']             = 'Return';

            $return_amount += $p_data['sub_total'];

            //insert Purchase Details refer original purchase
            $this->db->insert('purchase_details', $p_data);
            $ref_id = $this->db->insert_id();

            //insert product details for return
            $p_data['purchase_id']      = $purchaseID;
            $p_data['ref']              = $ref_id;
            $this->db->insert('purchase_details', $p_data);

            //update inventory
            $product = $this->db->get_where('product', array('id' => $purchase_product->product_id ))->row();
            $inv_data['inventory'] = $product->inventory - $qty[$key];
            $this->db->where('id', $purchase_product->product_id);
            $this->db->update('product', $inv_data);
        }

        $data = array();
        //update purchase table original purchase
        $data['cart_total']     = $purchase_order->cart_total - $return_amount;
        $data['grand_total']    = $purchase_order->grand_total - $return_amount;
        $data['due_payment']    = $data['grand_total'] - $purchase_order->paid_amount;

        $this->db->where('id', $purchase_order->id);
        $this->db->update('purchase_order', $data);

        //update purchase table for return
        $data = array();
        $data['cart_total']     = -$return_amount;
        $data['grand_total']    = -$return_amount;
        $data['paid_amount']    = -$return_amount;

        $this->db->where('id', $purchaseID);
        $this->db->update('purchase_order', $data);

        redirect('admin/purchase/purchaseList');
    }

    function deleteReturn_purchase($id = null)
    {
        $id = $id - INVOICE_PRE;
        $return_purchase_order = $this->db->get_where('purchase_order', array( 'id' => $id  ))->row();
        $return_purchase_details = $this->db->get_where('purchase_details', array( 'purchase_id' => $id  ))->result();
        $purchase_order = $this->db->get_where('purchase_order', array( 'id' => $return_purchase_order->return_ref  ))->row();

        //update original purchase_order Table return Money
        $data['cart_total'] = $purchase_order->cart_total + abs($return_purchase_order->cart_total);
        $data['grand_total'] = $purchase_order->grand_total + abs($return_purchase_order->grand_total);
        $data['due_payment'] = $purchase_order->due_payment + abs($return_purchase_order->grand_total);
        //update command
        $this->db->where('id', $return_purchase_order->return_ref);
        $this->db->update('purchase_order', $data);

        //Delete Return purchase Invoice
        $this->db->delete('purchase_order', array('id' => $id));

        //update purchase_details return quantity
        //$return_purchase_order->return_ref;
        foreach ($return_purchase_details as $item)
        {
            $p_details = $this->db->get_where('purchase_details', array(
                'product_id'    => $item->product_id,
                'purchase_id'   => $return_purchase_order->return_ref,
            ))->row();

            $data = array();
            $data['return_qty'] = $p_details->return_qty - $item->qty;
            //update command
            $this->db->where('id', $p_details->id);
            $this->db->update('purchase_details', $data);

            //update inventory
            $product = $this->db->get_where('product', array('id' => $item->product_id ))->row();
            $inv_data['inventory'] = $product->inventory + $item->qty;
            $this->db->where('id', $item->product_id);
            $this->db->update('product', $inv_data);

            //Delete Return purchase details
            $this->db->delete('purchase_details', array('id' => $item->ref));
            $this->db->delete('purchase_details', array('id' => $item->id));
        }


        $this->message->delete_success('admin/purchase/purchaseList');
    }

    function deletePurchase($id = null)
    {
        $id = $id - INVOICE_PRE;

        $purchase_order = $this->db->get_where('purchase_order', array( 'id' => $id ))->row();

        if(!count($purchase_order)){
            redirect('admin/dashboard', 'refresh');
        }

        $pur_products = $this->db->get_where('purchase_details', array('purchase_id' => $id, 'type' => 'Purchase' ))->result();

        foreach ($pur_products as $item)
        {
            //update inventory
            $product = $this->db->get_where('product', array('id' => $item->product_id ))->row();
            $inv_data['inventory'] = $product->inventory - $item->total_received;
            $this->db->where('id', $item->product_id);
            $this->db->update('product', $inv_data);
        }


        $return_ref = $this->db->get_where('purchase_order', array( 'return_ref' => $id ))->result();

        foreach ($return_ref as $item)
        {
            $this->db->delete('purchase_details', array('purchase_id' => $item->id));
            $this->db->delete('purchase_order', array('id' => $item->id));
        }

        //Delete from Purchase details purchase_details
        $this->db->delete('purchase_details', array('purchase_id' => $purchase_order->id));


        //delete from payment
        $this->db->delete('payment', array('order_id' => $purchase_order->id, 'type' => 'Purchase'));

        //delete from received_product
        $this->db->delete('received_product', array('order_id' => $purchase_order->id));

        //delete from Purchase Order purchase_order
        $this->db->delete('purchase_order', array('id' => $id));

        $this->message->delete_success('admin/purchase/purchaseList');
    }

    function sendInvoice($id = null)
    {
        $id = $id - INVOICE_PRE;

        //query
        $data['order'] = $this->db->get_where('purchase_order', array(
            'id' => $id
        ))->row();

        if(!count($data['order'])){
            redirect('admin/dashboard', 'refresh');
        }

        $data['order_details'] = $this->db->get_where('purchase_details', array(
            'purchase_id' => $id,
            'type'        => 'Purchase'
        ))->result();

        //return
        $data['return'] = $this->db->get_where('purchase_details', array(
            'purchase_id' => $id,
            'type'        => 'Return'
        ))->result();

        $data['payment'] = $this->db->get_where('payment', array(
            'order_id' => $id,
            'type'     => 'purchase'
        ))->result();

        //customer
        $data['vendor'] = $this->db->get_where('vendor', array(
            'id' => $data['order']->vendor_id
        ))->row();

        $file= INVOICE_PRE + $id;
        $filename = get_option('order_prefix').$file.'.pdf';
        $this->load->library('pdf');
        $pdf = $this->pdf->load();

        $html = $this->load->view('purchase/invoice_pdf', $data, true);


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
        $data['modal_subview'] = $this->load->view('admin/purchase/modal/_send_email',$data, FALSE);
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
                $this->message->custom_success_msg('admin/purchase/purchaseInvoice/'.get_orderID($id),'Your email has been send successfully!');
            }else{
                $this->message->custom_error_msg('admin/purchase/purchaseInvoice/'.get_orderID($id),'Fail to send your email');
            }

        }else{
            //$this->load->library('mail');

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
                $this->message->custom_success_msg('admin/purchase/purchaseInvoice/'.get_orderID($id),'Your email has been send successfully!');
            }else{
                $this->message->custom_error_msg('admin/purchase/purchaseInvoice/'.get_orderID($id),'Fail to send your email');
            }
        }
    }


}

