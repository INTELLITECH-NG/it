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

//$this->CI =& get_instance();


$CI = & get_instance();
$CI->load->database();
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
    'name' => 'Admin Panel',

    // Default page title
    // (set empty then MY_Controller will automatically generate one based on controller / action)
    'title' => '',

    // Default meta data (name => content)
    'meta'	=> array(
        'author'		=> 'Codes Lab (www.codeslab.net)',
        'description'	=> 'eOffice Manager'
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
            'assets/js/cart.js',
            'assets/js/jquery.PrintArea.js',
            'assets/js/printThis.js',

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

            //Editor wys
            'assets/plugin/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js',
        ),
    ),


    'stylesheets' => array(
        'screen' => array(

            'assets/css/bootstrap/css/bootstrap.css',
            'assets/plugin/select2/select2.min.css',
            'assets/css/AdminLTE.css',
            'assets/css/custom.css',
            'assets/css/skins.css',
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
            'https://fonts.googleapis.com/icon?family=Material+Icons',
            'assets/css/font-awesome.min.css',
            'assets/css/ionicons.min.css',

            //graphChart
            'assets/plugin/morris/morris.css',

            //calendar
            'assets/plugin/fullcalendar/fullcalendar.min.css',
            //'assets/plugin/fullcalendar/fullcalendar.print.css',

            //Editor wys
            'assets/plugin/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css',
            'https://fonts.googleapis.com/icon?family=Material+Icons'
        )
    ),


    // Multilingual settings (set empty array to disable this)
    'multilingual' => array(),

    // AdminLTE settings
    'adminlte' => array(
        'hr'		    => array('skin' => 'skin-purple'),
        'admin'		    => array('skin' => 'skin-purple'),
        'accounts'	    => array('skin' => 'skin-purple'),
        'staff'		    => array('skin' => 'skin-purple'),
        'sales'	        => array('skin' => 'skin-purple'),
        'sales_staff'	=> array('skin' => 'skin-purple'),
    ),

    // Menu items which support icon fonts, e.g. Font Awesome
    // (or directly update view file: /application/modules/admin/views/_partials/sidemenu.php)
    'menu' => array(
        'home' => array(
            'name'		=> $CI->lang->line('dashboard'),
            'url'		=> 'home',
            'icon'		=> 'dashboard',
        ),

        'mail' => array(
            'name'		=> $CI->lang->line('mailbox'),
            'url'		=> 'mail',
            'icon'		=> 'mail_outline',
            'children'  => array(
                $CI->lang->line('inbox')					=> 'mail',
                $CI->lang->line('sent_item')				=> 'mail/sentItem',
                $CI->lang->line('sent_item')				=> 'mail/sentItem',

            )
        ),

        'sales' => array(
            'name'		=> $CI->lang->line('sales'),
            'url'		=> 'sales',
            'icon'		=> 'shopping_basket',
            'children'  => array(
                $CI->lang->line('create_invoice')	        => 'sales/type/invoice',
                $CI->lang->line('all_invoice')	        => 'sales/allOrder',
                $CI->lang->line('processing_order')	    => 'sales/processing',
                $CI->lang->line('pending_shipment')	    => 'sales/pending',
                $CI->lang->line('delivered_order')	    => 'sales/deliveredOrder',
                $CI->lang->line('quotation')	        => 'sales/type/quotation',
                $CI->lang->line('all_quotation')	    => 'sales/allQuotation',
            )
        ),

        'purchase' => array(
            'name'		=> $CI->lang->line('purchase'),
            'url'		=> 'purchase',
            'icon'		=> 'shopping_cart',
            'children'  => array(
                $CI->lang->line('new_purchase')	        => 'purchase/newPurchase',
                $CI->lang->line('purchase_list')	        => 'purchase/purchaseList',
                $CI->lang->line('received_product')	    => 'purchase/receivedProductList',

            )
        ),

        'trader' => array(
            'name'		=> $CI->lang->line('trader'),
            'url'		=> 'trader',
            'icon'		=> 'people_outline',
            'children'  => array(
                $CI->lang->line('customer')	=> 'trader/customerList',
                $CI->lang->line('vendor')	=> 'trader/vendorList',
            )
        ),

        'product' => array(
            'name'		=> $CI->lang->line('product_services'),
            'url'		=> 'product',
            'icon'		=> 'archive',
            'children'  => array(
                $CI->lang->line('product_list')	=> 'product/productList',
                $CI->lang->line('import_Product')	=> 'product/importProduct',
                $CI->lang->line('category')	=> 'product/categoryList',

            )
        ),

        'asset' => array(
            'name'		=> $CI->lang->line('depreciation'),
            'url'		=> 'asset',
            'icon'		=> 'exposure',
            'children'  => array(
                $CI->lang->line('add_asset')		=> 'asset/addAsset',
                $CI->lang->line('assets_list')		=> 'asset/assetsList',

            )
        ),

        'transaction' => array(
            'name'		=> $CI->lang->line('transaction'),
            'url'		=> 'transaction',
            'icon'		=> 'local_atm',
            'children'  => array(
                $CI->lang->line('add_transaction')			=> 'transaction/addTransaction',
                $CI->lang->line('transactions_list')		=> 'transaction/allTransaction',
                $CI->lang->line('chart_of_accounts')		=> 'transaction/chartOfAccount',

                $CI->lang->line('income_categories')	    => 'transaction/incomeCategory',
                $CI->lang->line('expense_categories')	    => 'transaction/expenseCategory',
            )
        ),


        'employee' => array(
            'name'		=> $CI->lang->line('employee'),
            'url'		=> 'employee',
            'icon'		=> 'account_circle',
            'children'  => array(
                $CI->lang->line('add_employee')		    => 'employee/addEmployee',
                $CI->lang->line('import_employee')		=> 'employee/importEmployee',
                $CI->lang->line('employee_list')	    => 'employee/employeeList',
                $CI->lang->line('terminated_employee')	=> 'employee/terminatedEmployeeList',
                $CI->lang->line('employee_award')	    => 'employee/awardList',
                $CI->lang->line('set_attendance')		=> 'employee/setAttendance',
                $CI->lang->line('import_attendance')	=> 'employee/importAttendance',
                $CI->lang->line('attendance_report')	=> 'employee/report',
                $CI->lang->line('application_list')	    => 'employee/applicationList',
            )
        ),


        'payroll' => array(
            'name'		=> $CI->lang->line('payroll'),
            'url'		=> 'payroll',
            'icon'		=> 'account_balance_wallet',
            'children'  => array(
                $CI->lang->line('make_payment')		=> 'payroll/employee',
                $CI->lang->line('list_payment')		=> 'payroll/listSalaryPayment',
            )
        ),

        'reports' => array(
            'name'		=> $CI->lang->line('reports'),
            'url'		=> 'reports',
            'icon'		=> 'assignment',
        ),

        'notice' => array(
            'name'		=> $CI->lang->line('notice_board'),
            'url'		=> 'notice',
            'icon'		=> 'keyboard',
            'children'  => array(
                $CI->lang->line('add_notice')					=> 'notice/addNotice',
                $CI->lang->line('manage_notice')				=> 'notice/noticeList',

            )
        ),


        'panel' => array(
            'name'		=> 'Admin User',
            'url'		=> 'panel',
            'icon'		=> 'group',
            'children'  => array(
                $CI->lang->line('manage_user')		=> 'panel/admin_list',
                $CI->lang->line('create_user')		=> 'panel/admin_user_create',
            )
        ),

        'office' => array(
            'name'		=> $CI->lang->line('office_settings'),
            'url'		=> 'office',
            'icon'		=> 'perm_data_setting',
            'children'  => array(
                $CI->lang->line('department')		=> 'office/department',
                $CI->lang->line('job_titles')		=> 'office/jobTitle',
                $CI->lang->line('job_categories')	=> 'office/jobCategories',
                $CI->lang->line('work_shifts')		=> 'office/workShift',
                $CI->lang->line('working_days')		=> 'office/workingDays',
                $CI->lang->line('holiday_list')		=> 'office/holidayList',
                $CI->lang->line('leave_type')		=> 'office/leaveType',
                $CI->lang->line('pay_grades')		=> 'office/payGrades',
                $CI->lang->line('salary_component')	=> 'office/salaryComponent',
                $CI->lang->line('employment_status')=> 'office/employmentStatus',
                $CI->lang->line('tax')              => 'office/tax',

            )
        ),

        'setting' => array(
            'name'		=> $CI->lang->line('settings'),
            'url'		=> 'settings',
            'icon'		=> 'settings',
        ),




    ),

    // default page when redirect non-logged-in user
    'login_url' => 'admin/login',

    // restricted pages to specific groups of users, which will affect sidemenu item as well
    // pages out of this array will have no restriction (except required admin user login)
    'page_auth' => array(

        //Admin User Menu Permission
        'panel'									=> array('admin'),
        'panel/admin_list'						=> array('admin'),
        'panel/admin_user_create'				=> array('admin'),
        'panel/admin_user_reset_password'		=> array('admin'),
        'panel/update_profile'					=> array('admin'),
        'panel/delete_employee'					=> array('admin'),

        //Settings Menu Permission
        'settings'								=> array('admin'),

        //Office Settings Menu Permission
        'office'								=> array('admin','staff','hr','accounts'),
        'office/workingDays'					=> array('admin','staff','hr'),
        'office/holidayList'					=> array('admin','staff','hr'),
        'office/leaveType'						=> array('admin','staff','hr'),
        'office/incomeCategory'					=> array('admin','accounts'),
        'office/expenseCategory'				=> array('admin','accounts'),

        //Payroll Menu Permission
        'payroll'								=> array('admin','accounts'),
        'payroll/setEmployeePayment'			=> array('admin','accounts'),
        'payroll/employee'						=> array('admin','accounts'),
        'payroll/listSalaryPayment'				=> array('admin','accounts'),

        //Transaction Menu Permission
        'transaction'							=> array('admin','accounts'),
        'transaction/addTransaction'			=> array('admin','accounts'),
        'transaction/allTransaction'			=> array('admin','accounts'),
        'transaction/editTransaction'			=> array('admin','accounts'),
        'transaction/view'						=> array('admin','accounts'),
        'transaction/viewTransaction'			=> array('admin','accounts'),
        'transaction/deleteTransaction'			=> array('admin','accounts'),
        'transaction/save_transaction'			=> array('admin','accounts'),
        'transaction/searchTransactions'		=> array('admin','accounts'),
        'transaction/chartOfAccount'			=> array('admin','accounts'),

        //Application Menu Permission
        'application'							=> array('admin','hr'),
        'application/applicationList'			=> array('admin','hr'),
        'application/viewApplication'			=> array('admin','hr'),

        //Attendance Menu Permission
        'attendance'							=> array('admin','hr','staff'),
        'attendance/setAttendance'				=> array('admin','hr','staff'),
        'attendance/report'						=> array('admin','hr','staff'),

        //Employee Menu Permission
        'employee'								=> array('admin','hr'),
        'employee/employeeList'					=> array('admin','hr'),
        'employee/awardList'					=> array('admin','hr'),
        'employee/employeeDetails'				=> array('admin','hr'),

        //Job Menu Permission
        'job'									=> array('admin','hr', 'accounts'),
        'job/jobTitle'							=> array('admin','hr'),
        'job/department'						=> array('admin','hr'),
        'job/salaryComponent'					=> array('admin','hr', 'accounts'),
        'job/payGrades'							=> array('admin','hr', 'accounts'),
        'job/employmentStatus'					=> array('admin','hr'),
        'job/jobCategories'						=> array('admin','hr'),
        'job/workShift'							=> array('admin','hr'),

        //Notice Menu Permission
        'notice'								=> array('admin','hr','staff'),
        'notice/addNotice'						=> array('admin','hr','staff'),
        'notice/noticeList'						=> array('admin','hr','staff'),
        'notice/viewNotice'						=> array('admin','hr','staff'),

        //sales
        'sales'									=> array('admin','accounts','sales'),
        'sales/type/invoice'					=> array('admin','accounts','sales'),
        'sales/allOrder'					    => array('admin','accounts','sales'),
        'sales/processing'					    => array('admin','accounts','sales'),
        'sales/pending'					        => array('admin','accounts','sales'),
        'sales/deliveredOrder'					=> array('admin','accounts','sales'),
        'sales/type/quotation'					=> array('admin','accounts','sales'),
        'sales/allQuotation'					=> array('admin','accounts','sales'),

        //purchase
        'purchase'								=> array('admin','sales', 'accounts'),
        'purchase/newPurchase'					=> array('admin','sales', 'accounts'),
        'purchase/purchaseList'					=> array('admin','sales', 'accounts'),
        'purchase/receivedProductList'			=> array('admin','sales', 'accounts'),

        //Trader
        'trader'								=> array('admin','sales', 'accounts'),
        'trader/vendorList'						=> array('admin','sales', 'accounts'),
        'trader/customerList'					=> array('admin','sales', 'accounts'),




//        'trader' => array(
//            'name'		=> 'Trader',
//            'url'		=> 'trader',
//            'icon'		=> 'fa fa-delicious',
//            'children'  => array(
//                'Customer'	=> 'trader/customerList',
//                'Vendor'	=> 'trader/vendorList',
//            )
//        ),
//
//        'product' => array(
//            'name'		=> $CI->lang->line('product_services'),
//            'url'		=> 'product',
//            'icon'		=> 'fa fa-cubes',
//            'children'  => array(
//                $CI->lang->line('product_list')	=> 'product/productList',
//
//            )
//        ),


    ),


    // For debug purpose (available only when ENVIRONMENT = 'development')
    'debug' => array(
        'view_data'		=> FALSE,	// whether to display MY_Controller's mViewData at page end
        'profiler'		=> FALSE,	// whether to display CodeIgniter's profiler at page end
    ),
);