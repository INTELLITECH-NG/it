<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Admin Panel management, includes: 
 * 	- Admin Users CRUD
 * 	- Admin User Groups CRUD
 * 	- Admin User Reset Password
 * 	- Account Settings (for login user)
 */
class Panel extends Admin_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('form_builder');
		$this->load->library('form_validation');
		$this->mTitle = TITLE;
	}



	// Create Admin User
//	public function admin_user_create()
//	{
//		// (optional) only top-level admin user groups can create Admin User
//		//$this->verify_auth(array('webmaster'));
//
//		$form = $this->form_builder->create_form();
//
//		if ($form->validate())
//		{
//			// passed validation
//			$username = $this->input->post('username');
//			$email = $this->input->post('email');
//			$password = $this->input->post('password');
//			$additional_data = array(
//				'first_name'	=> $this->input->post('first_name'),
//				'last_name'		=> $this->input->post('last_name'),
//			);
//			$groups = $this->input->post('groups');
//
//			// create user (default group as "members")
//			$user = $this->ion_auth->register($username, $password, $email, $additional_data, $groups);
//			if ($user)
//			{
//				// success
//				$messages = $this->ion_auth->messages();
//				$this->system_message->set_success($messages);
//			}
//			else
//			{
//				// failed
//				$errors = $this->ion_auth->errors();
//				$this->system_message->set_error($errors);
//			}
//			refresh();
//		}
//
//		$groups = $this->ion_auth->groups()->result();
//		unset($groups[0]);	// disable creation of "webmaster" account
//		$this->mViewData['groups'] = $groups;
//		$this->mTitle.= 'Create Admin User';
//
//		$this->mViewData['form'] = $form;
//		$this->render('panel/admin_user_create');
//	}

	// Admin User Groups CRUD
	public function admin_user_group()
	{
		$crud = $this->generate_crud('admin_groups');
		$this->mTitle.= 'Admin User Groups';
		$this->render_crud();
	}

	// Admin User Reset password
	public function admin_user_reset_password($user_id)
	{
		// only top-level users can reset Admin User passwords
		$this->verify_auth(array('admin'));

		$user_id = $this->encrypt->decode(str_replace(array('-', '_', '~'), array('+', '/', '='), $user_id));

       

		$user_id == TRUE || $this->message->norecord_found('admin/panel/admin_list');

		$form = $this->form_builder->create_form();
		if ($form->validate())
		{
			// pass validation
			$data = array('password' => $this->input->post('new_password'));
			if ($this->ion_auth->update($user_id, $data))
			{
				$messages = $this->ion_auth->messages();
				$this->system_message->set_success($messages);
			}
			else
			{
				$errors = $this->ion_auth->errors();
				$this->system_message->set_error($errors);
			}
			refresh();
		}

		$this->load->model('admin_user_model', 'admin_users');
		$target = $this->admin_users->get($user_id);
		$this->mViewData['target'] = $target;

		$this->mViewData['form'] = $form;
		$this->mTitle .= lang('reset_password');
		$this->render('admin_user/admin_user_reset_password');
	}

	// Account Settings
	public function account()
	{
		// Update Info form
		$form1 = $this->form_builder->create_form('admin/panel/account_update_info');
		$form1->set_rule_group('panel/account_update_info');
		$this->mViewData['form1'] = $form1;



		// Change Password form
		$form2 = $this->form_builder->create_form('admin/panel/account_change_password');
		$form1->set_rule_group('panel/account_change_password');
		$this->mViewData['form2'] = $form2;

		$this->mTitle .= "Account Settings";
		$this->render('panel/account');
	}

	// Submission of Update Info form
	public function account_update_info()
	{
		$data = $this->input->post();
		if ($this->ion_auth->update($this->mUser->id, $data))
		{
			$messages = $this->ion_auth->messages();
			$this->system_message->set_success($messages);
		}
		else
		{
			$errors = $this->ion_auth->errors();
			$this->system_message->set_error($errors);
		}

		redirect('admin/panel/account');
	}

	// Submission of Change Password form
	public function account_change_password()
	{
		$data = array('password' => $this->input->post('new_password'));
		if ($this->ion_auth->update($this->mUser->id, $data))
		{
			$messages = $this->ion_auth->messages();
			$this->system_message->set_success($messages);
		}
		else
		{
			$errors = $this->ion_auth->errors();
			$this->system_message->set_error($errors);
		}

		redirect('admin/panel/account');
	}
	
	/**
	 * Logout user
	 */
	public function logout()
	{
		$this->ion_auth->logout();
		redirect('admin/login');
	}






	// Create Admin User
	public function  admin_user_create($id = null)
	{
		// (optional) only top-level admin user groups can create Admin User
		//$this->verify_auth(array('webmaster'));

		$form = $this->form_builder->create_form();

		if ($form->validate())
		{
			// passed validation
			$username = $this->input->post('username');
			$email = $this->input->post('email');
			$password = $this->input->post('password');
			$additional_data = array(
					'first_name'	=> $this->input->post('first_name'),
					'last_name'		=> $this->input->post('last_name'),
			);
			$groups = $this->input->post('groups');

			// create user (default group as "members")
			$user = $this->ion_auth->register($username, $password, $email, $additional_data, $groups);
			if ($user)
			{
				// success
				$messages = $this->ion_auth->messages();
				$this->system_message->set_success($messages);
			}
			else
			{
				// failed
				$errors = $this->ion_auth->errors();
				$this->system_message->set_error($errors);
			}
			refresh();
		}

		$groups = $this->ion_auth->groups()->result();
		$this->mViewData['groups'] = $groups;
		$this->mTitle .= lang('create_employee');

		$this->mViewData['form'] = $form;
		$this->render('admin_user/admin_user_create');
	}

	function admin_list()
	{
		$this->mViewData['employees']           = $this->db->select('*')
				->from('admin_users')
				->join('admin_users_groups', 'admin_users.id = admin_users_groups.user_id', 'left')
				->join('admin_groups', 'admin_users_groups.group_id = admin_groups.id', 'left')
				->get()
				->result();

		$this->mTitle                           .= lang('admin_list');
		$this->render('admin_user/admin_user_list');
	}

	function change_status()
	{
		$id         = $this->encrypt->decode(str_replace(array('-', '_', '~'), array('+', '/', '='), $this->input->post('userId')));
		$status     = $this->input->post('status');
		$loginID = $this->ion_auth->user()->row()->id;

		if($loginID != $id){
			$this->db->set('active', $status, FALSE)->where('id', $id)->update('admin_users');
		}

	}

	function update_profile($id = null){

		$id = $this->encrypt->decode(str_replace(array('-', '_', '~'), array('+', '/', '='), $id));
		$id == TRUE || $this->message->norecord_found('admin/panel/admin_list');

		$form = $this->form_builder->create_form('admin/panel/account_update_profile');
		$form->set_rule_group('panel/account_update_profile');
		$this->mViewData['form'] = $form;
		$this->mViewData['admin_user'] = $this->db->select('admin_users.*, admin_users_groups.id as admin_users_groups_id, admin_groups.id as admin_groups_id')
				->from('admin_users')
				->join('admin_users_groups', 'admin_users.id = admin_users_groups.user_id', 'left')
				->join('admin_groups', 'admin_users_groups.group_id = admin_groups.id', 'left')
				->where('admin_users.id', $id)
				->get()->row();


		$this->mViewData['groups'] = $this->ion_auth->groups()->result();

		$this->mTitle                           .= lang('update_admin_user_profile');
		$this->render('admin_user/admin_user_edit');
	}

	function account_update_profile()
	{
		$id = $this->input->post('id');

		$id = $this->encrypt->decode(str_replace(array('-', '_', '~'), array('+', '/', '='), $id));
		$id == TRUE || $this->message->norecord_found('admin/panel/admin_list');


		if ($this->form_validation->run($this) == FALSE)
		{
			// Errors
			$errors = validation_errors();
			$this->message->custom_error_msg('admin/panel/update_profile/'.str_replace(array('+', '/', '='), array('-', '_', '~'), $this->encrypt->encode($id)), $errors);
		}
		else
		{
			//success
			$data['username'] 		= $this->input->post('username');
			$data['first_name']		= $this->input->post('first_name');
			$data['last_name']		= $this->input->post('last_name');
			$data['email'] 			= $this->input->post('email');
			$data['active'] 		= $this->input->post('active');

			$this->db->where('id', $id);
			$this->db->update('admin_users', $data);

			$sdata['group_id']		= $this->input->post('groups');

			$this->db->where('user_id', $id);
			$this->db->update('admin_users_groups', $sdata);
			$this->message->save_success('admin/panel/update_profile/'.str_replace(array('+', '/', '='), array('-', '_', '~'), $this->encrypt->encode($id)));
		}
	}


	function chk_username($username){
		 //Check $value
		 $id = $this->encrypt->decode(str_replace(array('-', '_', '~'), array('+', '/', '='), $this->input->post('id')));
		 $tbl_id 	=  array('id !=' => $id);
		 $where 	= array('username' => $username);
		 $result 	= $this->check_duplicate_val('admin_users', $where, $tbl_id );
		 if($result)
		 {
			 $this->form_validation->set_message('chk_username', lang('username_exists'));
			 return false;
		 }else{
			return true;
		 }
	}

	function chk_email($email){
		//Check $value
		$id = $this->encrypt->decode(str_replace(array('-', '_', '~'), array('+', '/', '='), $this->input->post('id')));
		$tbl_id 	=  array('id !=' => $id);
		$where 	= array('email' => $email);
		$result 	= $this->check_duplicate_val('admin_users', $where, $tbl_id );
		if($result)
		{
			$this->form_validation->set_message('chk_email', lang('email_exists'));
			return false;
		}else{
			return true;
		}
	}

	function delete_employee($id = null)
	{
		$id = $this->encrypt->decode(str_replace(array('-', '_', '~'), array('+', '/', '='), $id));
		$id == TRUE || $this->message->norecord_found('admin/panel/admin_list');

		$user_id = $this->ion_auth->user()->row()->id;

		$id != $user_id || $this->message->custom_error_msg('admin/panel/admin_list', lang('you_can_not_delete_own_account'));
		$this->db->delete('admin_users', array('id' => $id));

		$this->message->delete_success('admin/panel/admin_list');
	}

}
