<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Message
{

    public function custom_error_msg($url, $message)
    {
        $type = 'error';
        set_message($type, $message);
        redirect($url);
    }

    public function custom_success_msg($url, $message)
    {
        $type = 'success';
        set_message($type, $message);
        redirect($url);
    }

    public function save_success($url)
    {
        $type = 'success';
        $message = lang('save_success');
        set_message($type, $message);
        redirect($url);
    }

    public function delete_success($url)
    {
        $type = 'success';
        $message = lang('delete_success');
        set_message($type, $message);
        redirect($url);
    }

    public function norecord_found($url)
    {
        $type = 'error';
        $message = lang('no_record_found');
        set_message($type, $message);
        redirect($url);
    }

    public function success_msg()
    {
        return $message = lang('save_success');
    }

    public function delete_msg()
    {
        return $message = lang('delete_success');
    }

}