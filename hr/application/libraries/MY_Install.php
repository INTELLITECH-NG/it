<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class MY_Install
{
    public function __construct()
    {
        $CI = &get_instance();
        $CI->load->database();
        if ($CI->db->database == '') {

            $_SESSION["install_flag"] = 'install';

            header('location:install/');
        } else {

            echo 'install';
        }
    }
}