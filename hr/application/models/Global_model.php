<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Global_model extends CI_Model
{

    public $table;
    public $column_order; //set column field database for datatable orderable
    public $column_search; //set column field database for datatable searchable just firstname , lastname , address are searchable
    public $order; // default order
    Public $col;
    public $colId;


    public function __construct()
    {
        parent::__construct();
    }

    public function count_all()
    {
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    // Inbox Mailing List ==================================================================================>

    private function _get_inbox_query($term=''){ //term is value of $_REQUEST['search']['value']
        $id = $this->ion_auth->user()->row()->employee_id;

        $column = array('sender_name','subject' ,'attachment','date',null,null);
        $this->db->select('inbox.*');
        $this->db->from('inbox');

        $this->db->where('to_emp_id', $id);
        $this->db->where('to_type', 'employee');

        $this->db->order_by('id', 'desc');
        $this->db->group_start();
        $this->db->like('sender_name', $term);
        $this->db->or_like('subject', $term);
        $this->db->or_like('date', $term);
        $this->db->group_end();


        if(isset($_REQUEST['order'])) // here order processing
        {
            $this->db->order_by($column[$_REQUEST['order']['0']['column']], $_REQUEST['order']['0']['dir']);
        }
        else if(isset($this->order))
        {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function get_inbox_datatables(){
        $term = $_REQUEST['search']['value'];
        $this->_get_inbox_query($term);

        if($_REQUEST['length'] != -1)
            $this->db->limit($_REQUEST['length'], $_REQUEST['start']);

        $query = $this->db->get();

        return $query->result();
    }

    function count_filtered_inbox(){
        $term = $_REQUEST['search']['value'];
        $this->_get_inbox_query($term);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_inbox()
    {
        $id = $this->ion_auth->user()->row()->employee_id;
        $this->db->from($this->table);
        $this->db->where('from_emp_id', $id);
        $this->db->where('from_type', 'employee');
        return $this->db->count_all_results();
    }

    // Sent Item Mailing List ==================================================================================>

    public function count_sentItem()
    {
        $id = $this->ion_auth->user()->row()->employee_id;
        $this->db->from($this->table);
        $this->db->where('from_emp_id', $id);
        $this->db->where('from_type', 'employee');
        return $this->db->count_all_results();
    }

    private function _get_sentitem_query($term=''){ //term is value of $_REQUEST['search']['value']
        $id = $this->ion_auth->user()->row()->employee_id;

        $column = array('from_type','subject' ,'attachment','date',null);
        $this->db->select('outbox.*');
        $this->db->from('outbox');

        $this->db->where('from_emp_id', $id);
        $this->db->where('from_type', 'employee');

        $this->db->order_by('id', 'desc');
        $this->db->group_start();
        $this->db->like('from_type', $term);
        $this->db->or_like('subject', $term);
        $this->db->or_like('date', $term);
        $this->db->group_end();


        if(isset($_REQUEST['order'])) // here order processing
        {
            $this->db->order_by($column[$_REQUEST['order']['0']['column']], $_REQUEST['order']['0']['dir']);
        }
        else if(isset($this->order))
        {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function get_sentitem_datatables(){
        $term = $_REQUEST['search']['value'];
        $this->_get_sentitem_query($term);

        if($_REQUEST['length'] != -1)
            $this->db->limit($_REQUEST['length'], $_REQUEST['start']);

        $query = $this->db->get();

        return $query->result();
    }

    function count_filtered_sentitem(){
        $term = $_REQUEST['search']['value'];
        $this->_get_sentitem_query($term);
        $query = $this->db->get();
        return $query->num_rows();
    }

    // employee award List ==================================================================================>

    private function _get_datatables_award_query($term=''){ //term is value of $_REQUEST['search']['value']
        $column = array('employee.employee_id' ,'employee.first_name','employee.last_name', 'employee_award.award_name', 'employee_award.gift_item', 'employee_award.award_amount','employee_award.award_month');
        $this->db->select('employee_award.*, employee.employee_id as employee_personal_id, employee.first_name , employee.last_name, employee.termination');
        $this->db->from('employee_award');

        $this->db->join('employee', 'employee.id = employee_award.employee_id','left');

        $this->db->like('employee.first_name', $term);
        $this->db->or_like('employee.last_name', $term);
        $this->db->or_like('employee.employee_id', $term);
        $this->db->or_like('employee_award.award_name', $term);
        $this->db->or_like('employee_award.gift_item', $term);
        $this->db->or_like('employee_award.award_amount', $term);
        $this->db->or_like('employee_award.award_month', $term);



        if(isset($_REQUEST['order'])) // here order processing
        {
            $this->db->order_by($column[$_REQUEST['order']['0']['column']], $_REQUEST['order']['0']['dir']);
        }
        else if(isset($this->order))
        {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function get_award_datatables(){
        $term = $_REQUEST['search']['value'];
        $this->_get_datatables_award_query($term);

        if($_REQUEST['length'] != -1)
            $this->db->limit($_REQUEST['length'], $_REQUEST['start']);

        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered_award(){
        $term = $_REQUEST['search']['value'];
        $this->_get_datatables_award_query($term);
        $query = $this->db->get();
        return $query->num_rows();
    }



}