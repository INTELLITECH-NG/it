<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();

        // CI Bootstrap libraries
        $this->load->library('form_builder');
        $this->load->library('system_message');
        $this->load->library('email_client');

        $this->push_breadcrumb('Auth');
    }


    /**
     * Forgot Password page
     */
    public function forgot_password()
    {
        $form = $this->form_builder->create_form();

        if ($form->validate())
        {
            // passed validation
            $this->ion_auth_model->identity_column = 'email';
            $identity = $this->input->post('email');
            $user = $this->ion_auth->forgotten_password($identity);
            if ($user)
            {
                $subject = $this->lang->line('email_forgotten_password_subject');
                $email_view = $this->config->item('email_templates', 'ion_auth') . $this->config->item('email_forgot_password', 'ion_auth');

                $send_option = get_option('email_send_option');
                if($send_option =='smtp') {
                    if (!$this->config->item('use_ci_email', 'ion_auth')) {
                        // send email using Email Client library
                        $this->email_client->send($identity, $subject, $email_view, $user);
                    }
                }else{
                    $from = get_option('mail_sender');
                    $to = $identity;
                    $send_email = $this->mail->sendEmail($from, $to, $subject, $email_view);

                    if ($send_email) {
                        $messages = 'Retrieve Password email has been send successfully!';
                        $this->system_message->set_success($messages);
                    } else {
                        $messages = 'Sorry unable to send your email!';
                        $this->system_message->set_success($messages);
                    }
                }

                // success
                $messages = $this->ion_auth->messages();
                $this->system_message->set_success($messages);
                redirect('admin/login');
            }
            else
            {
                // failed
                $errors = $this->ion_auth->errors();
                $this->system_message->set_error($errors);
                refresh();
            }
        }

        // display form
        $this->mViewData['form'] = $form;
        $this->render('auth/forgot_password', 'empty');
    }

    /**
     * Reset Password page
     */
    public function reset_password($code = NULL)
    {
        if (!$code)
        {
            redirect();
        }

        $this->ion_auth_model->identity_column = 'email';
        // check whether code is valid
        $user = $this->ion_auth->forgotten_password_check($code);


        if ($user)
        {
            $form = $this->form_builder->create_form();

            if ($form->validate())
            {
                // passed validation
                $identity = $user->email;
                $password = $this->input->post('password');


                // confirm update password
                if ( $this->ion_auth->reset_password($identity, $password) )
                {
                    if (!$this->config->item('use_ci_email', 'ion_auth'))
                    {
                        // send email using Email Client library
                        $subject = $this->lang->line('email_new_password_subject');
                        $email_view = $this->config->item('email_templates', 'ion_auth').$this->config->item('email_forgot_password_complete', 'ion_auth');
                        $data = array('identity' => $identity);
                        $this->email_client->send($identity, $subject, $email_view, $data);
                    }

                    // success
                    $messages = $this->ion_auth->messages();
                    $this->system_message->set_success($messages);
                    redirect('admin/login');
                }
                else
                {
                    // failed
                    $errors = $this->ion_auth->errors();
                    $this->system_message->set_error($errors);
                    redirect('admin/auth/reset_password/' . $code);
                }
            }

            // display form
            $this->mViewData['form'] = $form;
            $this->render('auth/reset_password', 'empty');
        }
        else
        {
            // code invalid
            $errors = $this->ion_auth->errors();
            $this->system_message->set_error($errors);
            redirect('admin/auth/forgot_password', 'refresh');
        }
    }

}