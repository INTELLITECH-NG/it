<?php
class Report_model  extends CI_Model
{


    function __construct()
    {
        parent::__construct();
    }


    function get_sales_invoice_by_date($start_date, $end_date){
        $this->db->select('*', false);
        $this->db->from('sales_order');

        if ($start_date == $end_date) {
            $this->db->like('date', $start_date);
        } else {
            $this->db->where('date >=', $start_date);
            $this->db->where('date <=', $end_date.' '.'23:59:59');
        }
        $this->db->where('type', 'Invoice');
        $this->db->where('status !=', 'Cancel');
        $query_result = $this->db->get();
        $result = $query_result->result();

        return $result;
    }

    function get_purchase_invoice_by_date($start_date, $end_date){
        $this->db->select('*', false);
        $this->db->from('purchase_order');

        if ($start_date == $end_date) {
            $this->db->like('date', $start_date);
        } else {
            $this->db->where('date >=', $start_date);
            $this->db->where('date <=', $end_date.' '.'23:59:59');
        }
        $this->db->where('type', 'Purchase');
        $query_result = $this->db->get();
        $result = $query_result->result();

        return $result;
    }

    function get_returnPurchase_invoice_by_date($start_date, $end_date){
        $this->db->select('*', false);
        $this->db->from('purchase_order');

        if ($start_date == $end_date) {
            $this->db->like('date', $start_date);
        } else {
            $this->db->where('date >=', $start_date);
            $this->db->where('date <=', $end_date.' '.'23:59:59');
        }
        $this->db->where('type', 'Return');
        $query_result = $this->db->get();
        $result = $query_result->result();

        return $result;
    }

    function get_payment_received_by_date($start_date, $end_date){
        $this->db->select('*', false);
        $this->db->from('payment');

        if ($start_date == $end_date) {
            $this->db->like('payment_date', $start_date);
        } else {
            $this->db->where('payment_date >=', $start_date);
            $this->db->where('payment_date <=', $end_date.' '.'23:59:59');
        }
        $this->db->where('type', 'Sales');

        $query_result = $this->db->get();
        $result = $query_result->result();

        return $result;
    }

    function get_sales_invoice_by_date_customer_id($start_date, $end_date, $customer_id){
        $this->db->select('*', false);
        $this->db->from('sales_order');

        if ($start_date == $end_date) {
            $this->db->like('date', $start_date);
        } else {
            $this->db->where('date >=', $start_date);
            $this->db->where('date <=', $end_date.' '.'23:59:59');
        }
        $this->db->where('type', 'Invoice');
        $this->db->where('status !=', 'Cancel');
        $this->db->where('customer_id', $customer_id);

        $query_result = $this->db->get();
        $result = $query_result->result();

        return $result;
    }

    function get_sales_due_by_date_customer_id($start_date, $end_date, $customer_id){
        $this->db->select('*', false);
        $this->db->from('sales_order');

        if ($start_date == $end_date) {
            $this->db->like('date', $start_date);
        } else {
            $this->db->where('date >=', $start_date);
            $this->db->where('date <=', $end_date.' '.'23:59:59');
        }
        $this->db->where('type', 'Invoice');
        $this->db->where('status !=', 'Cancel');
        $this->db->where('customer_id', $customer_id);
        $this->db->where('due_payment >', 0);

        $query_result = $this->db->get();
        $result = $query_result->result();

        return $result;
    }

    function get_sales_over_due_customer_id($customer_id){
        $today = date('Y/m/d');
        $this->db->select('*', false);
        $this->db->from('sales_order');

        $this->db->where('due_payment >', 0);
        $this->db->where('due_date <=',$today);
        $this->db->where('type', 'Invoice');
        $this->db->where('status !=', 'Cancel');
        $this->db->where('customer_id', $customer_id);


        $query_result = $this->db->get();
        $result = $query_result->result();

        return $result;
    }

    function get_purchase_invoice_by_date_vendor_id($start_date, $end_date, $vendor_id)
    {
        $this->db->select('*', false);
        $this->db->from('purchase_order');

        if ($start_date == $end_date) {
            $this->db->like('date', $start_date);
        } else {
            $this->db->where('date >=', $start_date);
            $this->db->where('date <=', $end_date.' '.'23:59:59');
        }
        $this->db->where('type', 'Purchase');
        $this->db->where('vendor_id', $vendor_id);
        $query_result = $this->db->get();
        $result = $query_result->result();

        return $result;
    }

    function get_purchase_vendor_due_payment($vendor_id)
    {

        $this->db->select('*', false);
        $this->db->from('purchase_order');

        $this->db->where('type', 'Purchase');
        $this->db->where('vendor_id', $vendor_id);
        $this->db->where('due_payment >', 0);

        $query_result = $this->db->get();
        $result = $query_result->result();

        return $result;
    }

    function get_return_purchase_invoice_by_date_vendor_id($start_date, $end_date, $vendor_id)
    {
        $this->db->select('*', false);
        $this->db->from('purchase_order');

        if ($start_date == $end_date) {
            $this->db->like('date', $start_date);
        } else {
            $this->db->where('date >=', $start_date);
            $this->db->where('date <=', $end_date.' '.'23:59:59');
        }
        $this->db->where('type', 'Return');
        $this->db->where('vendor_id', $vendor_id);
        $query_result = $this->db->get();
        $result = $query_result->result();

        return $result;
    }

}