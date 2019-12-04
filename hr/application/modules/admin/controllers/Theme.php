<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Admin Panel management, includes:
 * 	- Admin Users CRUD
 * 	- Admin User Groups CRUD
 * 	- Admin User Reset Password
 * 	- Account Settings (for login user)
 */
class Theme extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_builder');
        $this->mTitle = 'Admin Panel - ';
    }


    function data_table()
    {

        $this->mTitle.= 'Data Table';
        $this->render('theme/data_table');
    }

    function form_component()
    {
        $this->mTitle.= 'Form Component';
        $this->render('theme/form_component');
    }

    function form_validation()
    {
        $this->mTitle.= 'Form Validation';
        $this->render('theme/form_validation');
    }

}
