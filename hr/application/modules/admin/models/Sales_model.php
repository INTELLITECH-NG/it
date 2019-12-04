<?php
class Sales_model  extends CI_Model
{


    function __construct()
    {
        parent::__construct();
    }



    public function overdue_order($customer_id = '')
    {
        $today = date('Y/m/d');
        $this->db->select('*', false);
        $this->db->from('sales_order');
        if($customer_id != '') {
            $this->db->where('customer_id', $customer_id);
        }
        $this->db->where('due_payment >', 0);
        $this->db->where('due_date <=',$today);
        $query_result = $this->db->get();
        $result = $query_result->result();

        $total_due_amount = 0;
        foreach ($result as $item){
            $total_due_amount += $item->due_payment;
        }

        $due = (object) array(
            'due_qty'       => count($result),
            'due_amount'    => $total_due_amount,
        );

        return $due;
    }

    public function estimate_order($customer_id = '')
    {
        $this->db->select('*', false);
        $this->db->from('sales_order');
        if($customer_id != '') {
            $this->db->where('customer_id', $customer_id);
        }
        $this->db->where('type', 'Quotation');
        $this->db->where('status', 'Pending');

        $query_result = $this->db->get();
        $result = $query_result->result();

        $total_estimate_amount = 0;
        foreach ($result as $item){
            $total_estimate_amount += $item->grand_total;
        }

        $estimate = (object) array(
            'estimate_qty'       => count($result),
            'estimate_amount'    => $total_estimate_amount,
        );

        return $estimate;
    }

    public function open_invoice($customer_id='')
    {
        $this->db->select('*', false);
        $this->db->from('sales_order');
        if($customer_id != '') {
            $this->db->where('customer_id', $customer_id);
        }
        $this->db->where('type', 'Invoice');
        $this->db->where('status', 'Open');

        $query_result = $this->db->get();
        $result = $query_result->result();

        $total_open_invoice = 0;
        foreach ($result as $item){
            $total_open_invoice += $item->due_payment;
        }

        $open_invoice = (object) array(
            'invoice_qty'       => count($result),
            'invoice_amount'    => $total_open_invoice,
        );

        return $open_invoice;
    }

    public function life_time_sell($customer_id='')
    {
        $this->db->select('*', false);
        $this->db->from('sales_order');
        if($customer_id != '') {
            $this->db->where('customer_id', $customer_id);
        }
        $this->db->where('type', 'Invoice');
        $this->db->where('status !=', 'Cancel');

        $query_result = $this->db->get();
        $result = $query_result->result();

        $total_sell = 0;
        foreach ($result as $item){
            $total_sell += $item->grand_total;
        }

        $lifetime_sell = (object) array(
            'invoice_qty'       => count($result),
            'invoice_amount'    => $total_sell,
        );

        return $lifetime_sell;
    }

    function purchase_due_invoice($id =  null){

        $query = $this->db->select('vendor_id, SUM(due_payment) AS due_payment')
            ->from('purchase_order')
            ->group_by('vendor_id')
            ->where('vendor_id', $id)
            ->where('type', 'Purchase')
            ->get()
            ->row();

        if(!empty($query)){
            return $query->due_payment;
        }else{
            return 0;
        }

    }

    function total_purchase_invoice_by_vendor($id = '')
    {
            $this->db->select('vendor_id, count(id) AS total_invoice, SUM(grand_total) AS grand_total');
            $this->db->from('purchase_order');
        if($id != '') {
            $this->db->group_by('vendor_id');
            $this->db->where('vendor_id', $id);
        }
            $this->db->where('type', 'Purchase');
            $query_result = $this->db->get();
            $query = $query_result->row();

        if(!empty($query)){

            return $value =  (object) array(
                'total_invoice'=> $query->total_invoice,
                'total_purchase' => $query->grand_total,
            );

        }else{
            return $value =  (object) array(
                'total_invoice'=> 0,
                'total_purchase' => 0,
            );
        }
    }

    function total_purchase_due_by_vendor($id = '')
    {
        $this->db->select('vendor_id, count(id) AS total_invoice, SUM(due_payment) AS due_payment');
            $this->db->from('purchase_order');
            if($id != '') {
                $this->db->group_by('vendor_id');
                $this->db->where('vendor_id', $id);
            }
            $this->db->where('due_payment >', 0);
            $this->db->where('type', 'Purchase');

        $query_result = $this->db->get();
        $query = $query_result->row();

        if(!empty($query)){

            return $value =  (object) array(
                'total_invoice'=> $query->total_invoice,
                'due_payment' => $query->due_payment,
            );

        }else{
            return $value =  (object) array(
                'total_invoice'=> 0,
                'due_payment' => 0,
            );
        }
    }

    function total_purchase_paid_by_vendor($id = '')
    {
        $this->db->select('vendor_id, SUM(paid_amount) AS paid_amount');
            $this->db->from('purchase_order');
        if($id != '') {
            $this->db->group_by('vendor_id');
            $this->db->where('vendor_id', $id);
        }
            $this->db->where('type', 'Purchase');

        $query_result = $this->db->get();
        $query = $query_result->row();

        if(!empty($query)){

            return $value =  (object) array(
                'paid_amount'=> $query->paid_amount,
            );

        }else{
            return $value =  (object) array(
                'paid_amount'=> 0,
            );
        }
    }

    function total_return_purchase_by_vendor($id = null)
    {
            $this->db->select('vendor_id,  count(id) AS total_invoice, SUM(grand_total) AS grand_total');
            $this->db->from('purchase_order');
        if($id != '') {
            $this->db->group_by('vendor_id');
            $this->db->where('vendor_id', $id);
        }
            $this->db->where('type', 'Return');
            $query_result = $this->db->get();
            $query = $query_result->row();

        if(!empty($query)){

            return $value =  (object) array(
                'grand_total'=> $query->grand_total,
                'total_invoice'=> $query->total_invoice,
            );

        }else{
            return $value =  (object) array(
                'grand_total'=> 0,
                'total_invoice'=> 0,
            );
        }
    }











}