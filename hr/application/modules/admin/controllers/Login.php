<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// NOTE: this controller inherits from MY_Controller instead of Admin_Controller,
// since no authentication is required
class Login extends MY_Controller {

	/**
	 * Login page and submission
	 */
	public function index()
	{
		$this->load->library('form_builder');
        $form = $this->form_builder->create_form('',false,array(
        	'class' => 'row',
        	'id' => 'login-form')
        );

		if ($form->validate())
		{
			// passed validation
			$identity = $this->input->post('email');
			$password = $this->input->post('password');
			$remember = ($this->input->post('remember')=='on');

			//$this->ion_auth_model->identity_column = 'email';
			$this->ion_auth_model->identity_column = 'username';
			
			if ($this->ion_auth->login($identity, $password, $remember))
			{
				// login succeed
				$messages = $this->ion_auth->messages();
				$this->system_message->set_success($messages);
				redirect('admin');
			}
			else
			{
				// login failed
				$errors = $this->ion_auth->errors();
				$this->system_message->set_error($errors);
				refresh();
			}
		}
		
		// display form when no POST data, or validation failed
//		$this->mViewData['body_class'] = 'login-page';
//		$this->mViewData['form'] = $form;
//		$this->mBodyClass = 'login-page';
//		$this->render('login', 'empty');

        $data['form'] = $form;
        $this->load->view('login',$data);
	}
}
