<?php

/**
 * Config file for form validation
 * Reference: http://www.codeigniter.com/user_guide/libraries/form_validation.html
 * (Under section "Creating Sets of Rules")
 */

$CI = & get_instance();
$CI->load->database();
$CI->load->helper('form');
if ($CI->db->database != '') {
	$lang = $CI->db->get_where('language', array("active" => 1))->row()->name;
}

if(empty($lang))
{
	$lang = 'english';
}
$CI->lang->load($lang.'_menu', $lang,$lang );
$CI->lang->load($lang.'_body', $lang,$lang );
$CI->lang->load($lang.'_msg', $lang,$lang );
$CI->lang->load($lang.'_title', $lang,$lang );

$config = array(

	// Admin User Login
	'login/index' => array(
		array(
			'field'		=> 'email',
			'label'		=> 'Email',
			'rules'		=> 'required|xss_clean',
		),
		array(
			'field'		=> 'password',
			'label'		=> 'Password',
			'rules'		=> 'required|xss_clean',
		),
	),

	// Forgot Password
		'auth/forgot_password' => array(
				array(
						'field'		=> 'email',
						'label'		=> 'Email',
						'rules'		=> 'required|valid_email',
				),
		),

	// Reset Password
		'auth/reset_password' => array(
				array(
						'field'		=> 'password',
						'label'		=> 'Password',
						'rules'		=> 'required|min_length[8]',
				),
				array(
						'field'		=> 'retype_password',
						'label'		=> 'Retype Password',
						'rules'		=> 'required|matches[password]',
				),
		),

	// Create User
	'user/create' => array(
//		array(
//			'field'		=> 'first_name',
//			'label'		=> 'First Name',
//			'rules'		=> 'required',
//		),
//		array(
//			'field'		=> 'last_name',
//			'label'		=> 'Last Name',
//			'rules'		=> 'required',
//		),
		array(
			'field'		=> 'username',
			'label'		=> 'Username',
			'rules'		=> 'is_unique[users.username]',				// use email as username if empty
		),
		array(
			'field'		=> 'email',
			'label'		=> 'Email',
			'rules'		=> 'required|valid_email|is_unique[users.email]',
		),
		array(
			'field'		=> 'password',
			'label'		=> 'Password',
			'rules'		=> 'required',
		),
		array(
			'field'		=> 'retype_password',
			'label'		=> 'Retype Password',
			'rules'		=> 'required|matches[password]',
		),
	),

	// Reset User Password
	'user/reset_password' => array(
		array(
			'field'		=> 'new_password',
			'label'		=> 'New Password',
			'rules'		=> 'required',
		),
		array(
			'field'		=> 'retype_password',
			'label'		=> 'Retype Password',
			'rules'		=> 'required|matches[new_password]',
		),
	),

	// Create Admin User
	'panel/admin_user_create' => array(
		array(
			'field'		=> 'username',
			'label'		=> 'Username',
			'rules'		=> 'required|is_unique[admin_users.username]',
		),
		array(
			'field'		=> 'first_name',
			'label'		=> 'First Name',
			'rules'		=> 'required',
		),
		array(
			'field'		=> 'email',
			'label'		=> 'Email',
			'rules'		=> 'required|valid_email|is_unique[admin_users.email]',
		),
		array(
			'field'		=> 'password',
			'label'		=> 'Password',
			'rules'		=> 'required',
		),
		array(
			'field'		=> 'retype_password',
			'label'		=> 'Retype Password',
			'rules'		=> 'required|matches[password]',
		),

	),

	// Create Admin User
		'panel/admin_user_create' => array(
				array(
						'field'		=> 'username',
						'label'		=> 'Username',
						'rules'		=> 'required|is_unique[admin_users.username]',
				),
				array(
						'field'		=> 'first_name',
						'label'		=> 'First Name',
						'rules'		=> 'required',
				),
				array(
						'field'		=> 'email',
						'label'		=> 'Email',
						'rules'		=> 'required|valid_email|is_unique[admin_users.email]',
				),
				array(
						'field'		=> 'password',
						'label'		=> 'Password',
						'rules'		=> 'required',
				),
				array(
						'field'		=> 'retype_password',
						'label'		=> 'Retype Password',
						'rules'		=> 'required|matches[password]',
				),

		),



	// Reset Admin User Password
	'panel/admin_user_reset_password' => array(
		array(
			'field'		=> 'new_password',
			'label'		=> 'New Password',
			'rules'		=> 'required',
		),
		array(
			'field'		=> 'retype_password',
			'label'		=> 'Retype Password',
			'rules'		=> 'required|matches[new_password]',
		),
	),

	// Admin User Update Info
	'panel/account_update_info' => array(
		array(
			'field'		=> 'username',
			'label'		=> 'Username',
			'rules'		=> 'required',
		),
		array(
			'field'		=> 'password',
			'label'		=> 'Password',
			'rules'		=> 'required',
		),
	),

	// Admin User Change Password
	'panel/account_change_password' => array(
		array(
			'field'		=> 'new_password',
			'label'		=> 'New Password',
			'rules'		=> 'required',
		),
		array(
			'field'		=> 'retype_password',
			'label'		=> 'Retype Password',
			'rules'		=> 'required|matches[new_password]',
		),
	),


	// Company Information
	'admin/settings' => array(
			array(
					'field'		=> 'company_name',
					'label'		=> 'Company Name',
					'rules'		=> 'required',
			),

	),

	//=======================================
	//       admin user validation
	//=======================================

	//update admin user profile
	'panel/account_update_profile' => array(
			array(
					'field'		=> 'first_name',
					'label'		=> lang('first_name'),
					'rules'		=> 'required|xss_clean',
			),
			array(
					'field'		=> 'last_name',
					'label'		=> lang('last_name'),
					'rules'		=> 'required|xss_clean',
			),
			array(
					'field'		=> 'username',
					'label'		=> lang('username'),
					'rules'		=> 'required|trim|min_length[5]|max_length[12]|xss_clean|callback_chk_username',
			),
			array(
					'field'		=> 'email',
					'label'		=> lang('email'),
					'rules'		=> 'required|valid_email|callback_chk_email',
			),
	),


	//=======================================
	//       Employee validation
	//=======================================

	//Add new employee
	'employee/addEmployee' => array(
			array(
					'field'		=> 'first_name',
					'label'		=> lang('first_name'),
					'rules'		=> 'required|xss_clean',
			),
			array(
					'field'		=> 'last_name',
					'label'		=> lang('last_name'),
					'rules'		=> 'required|xss_clean',
			),
			array(
					'field'		=> 'date_of_birth',
					'label'		=> lang('date_of_birth'),
					'rules'		=> 'required',
			),
			array(
					'field'		=> 'country',
					'label'		=> lang('country'),
					'rules'		=> 'required',
			),

	),

		'employee_personal_info' => array(
				array(
						'field'		=> 'first_name',
						'label'		=> lang('first_name'),
						'rules'		=> 'required|xss_clean',
				),
				array(
						'field'		=> 'last_name',
						'label'		=> lang('last_name'),
						'rules'		=> 'required|xss_clean',
				),
				array(
						'field'		=> 'date_of_birth',
						'label'		=> lang('date_of_birth'),
						'rules'		=> 'required',
				),
				array(
						'field'		=> 'country',
						'label'		=> lang('country'),
						'rules'		=> 'required',
				),

		),

);