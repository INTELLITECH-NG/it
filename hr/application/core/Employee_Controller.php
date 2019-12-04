<?php

/**
 * Base controllers for different purposes
 * 	- MY_Controller:
 * 	- Admin_Controller:
 * 	- API_Controller:
 */
class Employee_Controller extends  MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $loginSession = $this->ion_auth->user()->row();
        if(empty($loginSession)){
            redirect('login','refresh');
        }else{
            if($loginSession->type != 'user')
            {
                redirect('login','refresh');
            }
        }





    }

}