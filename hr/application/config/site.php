<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| Site (by CI Bootstrap 3)
| -------------------------------------------------------------------------
| This file lets you define default values to be passed into views when calling 
| MY_Controller's render() function. 
|
| Each of them can be overrided from child controllers.
|
*/



$CI = & get_instance();
$CI->load->database();
$lang = 0;

if ($CI->db->database != '') {
	$lang = $CI->db->get_where('language', array("active" => 1))->row()->name;
}
if(empty($lang))
{
	$lang = 'english';
}
$CI->lang->load($lang.'_menu', $lang,$lang );


$config['site'] = array(

	// Site name
	'name' => '',

	// Default page title
	// (set empty then MY_Controller will automatically generate one based on controller / action)
	'title' => '',

	// Default meta data (name => content)
	'meta'	=> array(
		'author'		=> 'Codes Lab, www.codeslab.net',
		'description'	=> 'Codes Lab is a perfect combination of developers and designers who understand clients need and desire and deliver more than which has been promised. We consider your satisfaction as the most powerful return on our efforts.'
	),

	// Default scripts to embed at page head / end
		'scripts' => array(
				'head'	=> array(
						'assets/js/jQuery-2.2.0.min.js',
						'assets/js/bootstrap.min.js',
				),
				'foot'	=> array(


						'assets/plugin/select2/select2.full.min.js',
						'assets/plugin/input-mask/jquery.inputmask.js',
						'assets/plugin/input-mask/jquery.inputmask.date.extensions.js',
						'assets/plugin/input-mask/jquery.inputmask.extensions.js',
					//date range picker
						//'https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js',
						'assets/plugin/daterangepicker/moment.min.js',
						'assets/plugin/daterangepicker/daterangepicker.js',
						'assets/plugin/datepicker/bootstrap-datepicker.js',
						'assets/plugin/colorpicker/bootstrap-colorpicker.min.js',
						'assets/plugin/timepicker/bootstrap-timepicker.min.js',
						'assets/plugin/slimScroll/jquery.slimscroll.min.js',
						'assets/plugin/fastclick/fastclick.js',
						'assets/js/app.min.js',
						'assets/js/admin.js',
						'assets/js/jquery.PrintArea.js',

					//data tables
						'assets/plugin/datatables/jquery.dataTables.min.js',
						'assets/plugin/datatables/dataTables.bootstrap.js',
						'assets/plugin/datatables/dataTables.buttons.min.js',
						'assets/plugin/datatables/buttons.bootstrap.min.js',
						'assets/plugin/datatables/jszip.min.js',
						'assets/plugin/datatables/pdfmake.min.js',
						'assets/plugin/datatables/vfs_fonts.js',
						'assets/plugin/datatables/buttons.html5.min.js',
						'assets/plugin/datatables/buttons.print.min.js',
						'assets/plugin/datatables/dataTables.fixedHeader.min.js',
						'assets/plugin/datatables/dataTables.keyTable.min.js',
						'assets/plugin/datatables/dataTables.responsive.min.js',
						'assets/plugin/datatables/responsive.bootstrap.min.js',
						'assets/plugin/datatables/dataTables.scroller.min.js',

						'assets/plugin/iCheck/icheck.min.js',

					//form validation
						'assets/plugin/jquery-validation/jquery.validate.min.js',
						'assets/plugin/jquery-validation/additional-methods.min.js',
						'assets/js/forms_validation.js',
						'assets/js/custom-file-input.js',

						'assets/js/ckeditor.js',
						'assets/plugin/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js',

					//graphChart
						'assets/plugin/morris/morris.min.js',
						'assets/plugin/morris/raphael.min.js',

					//calendar
						'assets/plugin/fullcalendar/fullcalendar.min.js',
						'assets/plugin/fullcalendar/moment.min.js',
				),
		),


		'stylesheets' => array(
				'screen' => array(

					'assets/css/bootstrap/css/bootstrap.css',
					'assets/plugin/select2/select2.min.css',
					'assets/css/AdminLTE.css',
						'assets/css/custom.css',
						'assets/frontend.css',
//						'assets/css/skins.css',
					//data tables
					'assets/plugin/datatables/jquery.dataTables.min.css',
					'assets/plugin/datatables/buttons.bootstrap.min.css',
					'assets/plugin/datatables/fixedHeader.bootstrap.min.css',
					'assets/plugin/datatables/responsive.bootstrap.min.css',
					'assets/plugin/datatables/scroller.bootstrap.min.css',

					'assets/plugin/daterangepicker/daterangepicker-bs3.css',
					'assets/plugin/datepicker/datepicker3.css',
					'assets/plugin/colorpicker/bootstrap-colorpicker.min.css',
					'assets/plugin/timepicker/bootstrap-timepicker.min.css',

					'assets/plugin/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css',
					//'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css',
					//'https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css',
					'assets/css/font-awesome.min',
					'assets/css/ionicons.min',

					//graphChart
					'assets/plugin/morris/morris.css',

					//calendar
					'assets/plugin/fullcalendar/fullcalendar.min.css',
					//'assets/plugin/fullcalendar/fullcalendar.print.css',
				)
		),



	// Multilingual settings (set empty array to disable this)
		'rightMenu' => array(

			'logout' => array(
					'name'		=> 'Logout',
					'url'		=> 'auth/logout',
					'icon'		=> 'fa fa-tachometer',
			),
		),


	// Multilingual settings (set empty array to disable this)
//	'multilingual' => array(
//		'default'		=> 'en',			// to decide which of the "available" languages should be used
//		'available'		=> array(			// availabe languages with names to display on site (e.g. on menu)
//			'en' => array(					// abbr. value to be used on URL, or linked with database fields
//				'label'	=> 'English',		// label to be displayed on language switcher
//				'value'	=> 'english',		// to match with CodeIgniter folders inside application/language/
//			),
//			'zh' => array(
//				'label'	=> '繁體中文',
//				'value'	=> 'traditional-chinese',
//			),
//			'cn' => array(
//				'label'	=> '简体中文',
//				'value'	=> 'simplified-chinese',
//			),
//		),
//		//'autoload'		=> array('general'),	// language files to autoload
//	),

	// Google Analytics User ID (UA-XXXXXXXX-X)
	'ga_id' => '',
	
	// Menu items
	// (or directly update view file: applications/views/_partials/navbar.php)
	'menu' => array(

		'home' => array(
			'name'		=> $CI->lang->line('home'),
			'url'		=> 'employee/home/',
		),

		'profile' => array(
				'name'		=> $CI->lang->line('profile'),
				'url'		=> 'employee/profile/',
		),

		'mail' => array(
				'name'		=> $CI->lang->line('mail'),
				'url'		=> 'mail',
				'children'  => array(
						$CI->lang->line('inbox')					=> 'employee/mail',
						$CI->lang->line('sent_item')				=> 'employee/mail/sentItem',

				)
		),

		'application' => array(
				'name'		=> $CI->lang->line('leave_application'),
				'url'		=> 'employee/leave',
		),

		'notice' => array(
				'name'		=> $CI->lang->line('notice'),
				'url'		=> 'employee/home/allNotice',
		),

		'award' => array(
				'name'		=> $CI->lang->line('award'),
				'url'		=> 'employee/award',
		),

	),

	// default page when redirect non-logged-in user
	'login_url' => 'auth/login',

	// restricted pages to specific groups of users, which will affect sidemenu item as well
	// pages out of this array will have no restriction
	'page_auth' => array(
		'account'		=> array('members')
	),

	// For debug purpose (available only when ENVIRONMENT = 'development')
	'debug' => array(
		'view_data'		=> FALSE,	// whether to display MY_Controller's mViewData at page end
		'profiler'		=> FALSE,	// whether to display CodeIgniter's profiler at page end
	),
);