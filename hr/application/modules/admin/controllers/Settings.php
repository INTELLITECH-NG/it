<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Settings extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_builder');
        $this->mTitle = TITLE;
        ini_set('max_input_vars', '3000');
        $this->load->model('settings_model');
    }


    function index()
    {
        $form = $this->form_builder->create_form();
        $tab = $this->input->get('tab');
        $tabView = explode("/", $tab);

        if(!$this->input->get('tab'))
        {
            $view   = 'company';
            $tab    = 'company';
            $data   = '';
        }
        elseif($tabView[0]=='language')
        {
            if(empty($tabView[1])){
                $view                               = $tabView[0];
                $tab                                = $tabView[0];
                $data['language']                   = $this->db->get('language')->result();
                $data['availabe_language']          = $this->settings_model->available_translations();
                $data['translation_stats']          = $this->settings_model->translation_stats();
            }else{
                $lang                               = $tabView[2];
                $data['editLang']                   = $tabView[2];
                $data['english_menu']               = $this->lang->load('english_menu', 'english', TRUE);
                $data['english_body']               = $this->lang->load('english_body', 'english', TRUE);
                $data['english_msg']                = $this->lang->load('english_msg', 'english', TRUE);
                $data['english_title']              = $this->lang->load('english_title', 'english', TRUE);

                if ($lang == 'english') {
                    $data['translation_menu']       = $data['english_menu'];
                    $data['translation_body']       = $data['english_body'];
                    $data['translation_msg']        = $data['english_msg'];
                    $data['translation_title']      = $data['english_title'];
                } else {
                    $data['translation_menu']       = $this->lang->load($lang.'_menu', $lang, TRUE, TRUE);
                    $data['translation_body']       = $this->lang->load($lang.'_body', $lang, TRUE, TRUE);
                    $data['translation_msg']        = $this->lang->load($lang.'_msg', $lang, TRUE, TRUE);
                    $data['translation_title']      = $this->lang->load($lang.'_title', $lang, TRUE, TRUE);
                }

                $tab                            = $tabView[0];
                $view                           = $tabView[1];
            }

        }else{
            $tab    = $tabView[0];
            $view   = $tabView[0];
            $data   = '';
        }

        if($tabView[0]=='localization')
        {
            $data['countries']                  = $this->db->get('countries')->result();
            $data['timezones']                  = $this->settings_model->timezones();
        }

        $data['form']                           = $form;
        $data['tab']                            = $tab;
        $this->mViewData['tab']                 = $tab;
        $this->mViewData['tab_view']            = $this->load->view('admin/settings/includes/'.$view,$data,true);
        $this->mTitle.= lang('system_settings');;
        $this->render('settings/all');
    }

    public function add_language() {
        $language = $this->input->post('language', TRUE);
        $this->settings_model->add_language($language, array(
            'english_menu_lang.php'     =>  "./application/language/",
            'english_body_lang.php'     =>  "./application/language/",
            'english_msg_lang.php'      =>  "./application/language/",
            'english_title_lang.php'    =>  "./application/language/",
        ));
        redirect('admin/settings?tab=language');
    }

    public function edit_translations($lang) {

        $path = array($lang . "_lang.php" => "./system/language/");

        $data['current_languages'] = $lang;
        $data['english'] = $this->lang->load('general', 'english', TRUE);

        if ($lang == 'english') {
            $data['translation'] = $data['english'];
        } else {
            $data['translation'] = $this->lang->load($lang, $lang, TRUE, TRUE);
        }

        $view = 'translation';
        $data['language_files'] = $lang;
        $this->mTitle.= 'Edit Translation';
        $this->mViewData['tab']                        =  'language';
        $this->mViewData['tab_view']                   =  $this->load->view('admin/settings/includes/'.$view,$data,true);
        $this->render('settings/all');
    }

    public function set_translations() {
        $lang = $this->input->post('language');
        $this->settings_model->save_translation($lang);
        $this->message->save_success('admin/settings?tab=language/translation/'.$lang);
        //redirect('admin/settings?tab=language/translation/'.$lang);

    }

    function language_status($language)
    {
       $result =  $this->db->get_where('language', array( "name" => $language))->row();
       if($result)
       {
           $data['active'] = 0;
           $id = $this->db->get_where('language', array( "active" => 1))->row()->id;
           $this->db->set('active', 0, FALSE)->where('id', $id)->update('language');
           $this->db->set('active', 1, FALSE)->where('name', $language)->update('language');

           // check with available options inside: application/config/language.php

           // save selected language to session
           $this->session->set_userdata('language', $language);
           $this->load->library('user_agent');

           $this->message->save_success('admin/settings?tab=language');
       }else{
           $this->message->norecord_found('admin/settings?tab=language');
       }
    }


//   ============== End Multi Language ==================================== //

    function save_settings()
    {

        $settings   = $this->input->post('settings');
        $tab        = $this->input->post('tab');

        if(!empty($settings))
        {
            // Loop through hotels and add the validation
            foreach($settings as $id => $data)
            {
                //$name = ucfirst(str_replace('_',' ',$id));
                $this->form_validation->set_rules('settings[' . $id . ']', lang($id), 'required|trim');

            }
        }


        if ($this->form_validation->run() == FALSE)
        {
            // Errors
            $error = validation_errors();

            $this->message->custom_error_msg('admin/settings?tab='.$tab ,$error);
        }
        else
        {
            // Success
            handel_upload_logo();
            handel_upload_icon();
            handel_upload_invoice_logo();
            handel_upload_login_logo();
            foreach ($settings as $name => $val) {
                // Check if the option exists
                $this->db->where('name', $name);
                $exists = $this->db->count_all_results('options');

                if ($exists == 0) {
                    //continue;
                    $this->db->insert('options', array(
                        'name' => $name
                    ));
                }

                $this->db->where('name', $name);
                $this->db->update('options', array(
                    'value' => $val
                ));
            }
        }
        $this->message->save_success('admin/settings?tab='.$tab);

    }

    function remove($prm)
    {
        $file = $this->db->get_where('options', array( "name" => $prm ))->row();
        $file = UPLOAD_LOGO.$file->value;
        if (!unlink($file))
        {
            //error
            $this->message->custom_error_msg('admin/settings?tab=company',"Error deleting $file");
        }
        else
        {
            //success
            $this->db->where('name', $prm);
            $this->db->update('options', array(
                'value' => ''
            ));
            $this->message->delete_success('admin/settings?tab=company');
        }
    }


    /* ===================================================================================================*/
    // *************************************** Office Settings *******************************************
    /*====================================================================================================*/



}