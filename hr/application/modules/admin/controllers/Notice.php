<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Notice extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_builder');
    }


    function noticeList()
    {
        $this->mTitle= lang('notice_list');

        // get yearly report
        if ($this->input->post('year', true)) { // if input data
            $year = $this->input->post('year', true);
            $this->mViewData['year'] = $year;
        } else {
            $year = date('Y'); // present year select
            $this->mViewData['year'] = $year;
        }

        $start_date = $year.'-'.'01'.'-'.'01';
        $end_date =   $year.'-'.'12'.'-'.'31';

        $this->mViewData['notice'] = $this->db->order_by('id', 'desc')->get_where('notice', array(
                                                'date >=' => $start_date,
                                                'date <=' => $end_date
                                            ))->result();

        $this->render('notice/notice_list');
    }

    function addNotice($id = null)
    {

        if(!empty($id)){
            $id = $this->encrypt->decode(str_replace(array('-', '_', '~'), array('+', '/', '='), $id));
            $notice = $this->db->get_where('notice', array(
                            'id' => $id
                        ))->row();
            $notice == TRUE|| $this->message->norecord_found('admin/notice/noticeList');

            $this->mViewData['notice'] = $notice;
        }

        $this->mTitle= lang('add_notice');

        $this->render('notice/add_notice');
    }

    function saveNotice()
    {



        $this->form_validation->set_rules('title', lang('title'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('short', lang('short_description'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('description', lang('long_description'), 'trim|required|xss_clean');

        $id = $this->input->post('id');

        if ($this->form_validation->run() == TRUE) {

            $data['title'] = $this->input->post('title');
            $data['short'] = $this->input->post('short');
            $data['description'] = $this->input->post('description');
            $data['status'] = $this->input->post('status');

            $id = $this->encrypt->decode(str_replace(array('-', '_', '~'), array('+', '/', '='), $id));

            if(!empty($id)){//update
                $this->db->where('id', $id);
                $this->db->update('notice', $data);
            }else{//insert
                $this->db->insert('notice', $data);
            }


            $this->message->save_success('admin/notice/noticeList');
        } else {
            $error = validation_errors();;
            $this->message->custom_error_msg('admin/notice/noticeList',$error);
        }
    }

    function viewNotice($id = null)
    {
        $id = $this->encrypt->decode(str_replace(array('-', '_', '~'), array('+', '/', '='), $id));

        $result = $this->db->get_where('notice', array(
            'id' => $id
        ))->row();

        $result == TRUE || $this->message->norecord_found('admin/notice/noticeList');
        $this->mViewData['notice'] =  $result;

        $this->render('admin/notice/view_notice');

    }

    function deleteNotice($id)
    {
        $id = $this->encrypt->decode(str_replace(array('-', '_', '~'), array('+', '/', '='), $id));
        $id == TRUE || $this->message->norecord_found('admin/notice/noticeList');

        //delete
        $this->db->delete('notice', array('id' => $id));
        $this->message->delete_success('admin/notice/noticeList');
    }




}
