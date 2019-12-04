<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Make extends CI_Controller
{
	private $error = '';
	function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->library('form_validation');
	}



	public function index()
	{

		$config_path = APPPATH . 'config/config.php';

		$debug = '';
		$step = 1;
		$passed_steps = array(
			1=>false,
			2=>false,
			3=>false,
			4=>false,
			);


		if($this->input->post()){
			if($this->input->post('step') && $this->input->post('step') == 2){
				$step = 2;
				$passed_steps[1] = true;
				$passed_steps[2] = true;
			} else if($this->input->post('step') && $this->input->post('step') == 3){
				if($this->input->post('hostname') == ''){
					$this->error = 'Hostname is required';
				} else if ($this->input->post('database') == '') {
					$this->error = 'Enter database name';
				} else if($this->input->post('password') == '' && strpos(site_url(),'localhost') === false){
					$this->error = 'Enter database password';
				} else if ($this->input->post('username') == ''){
					$this->error = 'Enter database username';
				}
				$step = 3;
				$passed_steps[1] = true;
				$passed_steps[2] = true;
				if($this->error === ''){
					$passed_steps[3] = true;
					$link = @mysqli_connect($this->input->post('hostname'), $this->input->post('username'), $this->input->post('password'), $this->input->post('database'));
					if (!$link) {
						$this->error .= "Error: Unable to connect to MySQL." . PHP_EOL;
						$this->error .= "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
						$this->error .= "Debugging error: " . mysqli_connect_error() . PHP_EOL;
					} else {
						$debug .= "Success: A proper connection to MySQL was made! The ".$this->input->post('database')." database is great." . PHP_EOL;
						$debug .= "Host information: " . mysqli_get_host_info($link) . PHP_EOL;
						if($this->write_db_config()){

							$mysqli = new mysqli($this->input->post('hostname'),$this->input->post('username'),$this->input->post('password'),$this->input->post('database'));

							// Check for errors
							if(mysqli_connect_errno())
								return false;

							// Open the default SQL file
							$database = file_get_contents(APPPATH . 'controllers/install/database.sql');
							// Execute a multi query
							$mysqli->multi_query($database);
							// Close the connection
							$mysqli->close();
							$passed_steps[1] = true;
							$passed_steps[2] = true;
							$passed_steps[3] = true;
							$step = 4;
						}
					}
				}
			} else if($this->input->post('requirements_success')) {
				$step = 2;
				$passed_steps[1] = true;
				$passed_steps[2] = true;
			} else if($this->input->post('permissions_success')){
				$step = 3;
				$passed_steps[1] = true;
				$passed_steps[2] = true;
				$passed_steps[3] = true;
			} else if($this->input->post('step') && $this->input->post('step') == 4){

				if($this->input->post('username') == ''){
					$this->error = 'Enter Your Login User Name';
				}else if($this->input->post('first_name') == ''){
					$this->error = 'Enter Your First Name';
				}
				else if($this->input->post('last_name') == ''){
					$this->error = 'Enter your Last Name';
				}
				else if($this->input->post('admin_email') == ''){
					$this->error = 'Enter admin email address';
				} else if (filter_var($this->input->post('admin_email'), FILTER_VALIDATE_EMAIL) === false) {
					$this->error = 'Enter valid email address';
				} else if($this->input->post('admin_password') == ''){
					$this->error = 'Enter admin password';
				} else if ($this->input->post('admin_password') != $this->input->post('admin_passwordr')){
					$this->error = 'Your password not match';
				}

				$passed_steps[1] = true;
				$passed_steps[2] = true;
				$passed_steps[3] = true;
				$passed_steps[4] = true;
				$step = 4;
			}


			if($this->error === '' && $this->input->post('step') && $this->input->post('step') == 4){


				$data['password'] = $this->input->post('admin_passwordr');
				$data['email'] = $this->input->post('admin_email');


				// passed validation
				$username = $this->input->post('username');
				$email = $this->input->post('admin_email');
				$password = $this->input->post('admin_passwordr');
				$additional_data = array(
						'username'		=> $this->input->post('username'),
						'first_name'	=> $this->input->post('first_name'),
						'last_name'		=> $this->input->post('last_name'),
						'active'		=> '1',
						'type'			=> 'admin',
				);

				$groups         = array('0'=>1);

				// [IMPORTANT] override database tables to update Frontend Users instead of Admin Users
				$this->ion_auth_model->tables = array(
						'users'				=> 'admin_users',
						'groups'			=> 'admin_groups',
						'users_groups'		=> 'admin_users_groups',
						'login_attempts'	=> 'admin_login_attempts',
				);

				// create user (default group as "members")
				$user = $this->ion_auth->register($username, $password, $email, $additional_data, $groups);

				if($user){
					$this->_change_config();
					$passed_steps[1] = true;
					$passed_steps[2] = true;
					$passed_steps[3] = true;
					$passed_steps[4] = true;
					$step = 5;
				}else{
					$error = $this->ion_auth->errors();
					$passed_steps[1] = true;
					$passed_steps[2] = true;
					$passed_steps[3] = true;
					$passed_steps[4] = true;
					$step = 4;
				}

			} else {
				$error = $this->error;
			}
		}
		include_once('html.php');
	}

	function _change_config(){
		$CI =& get_instance();
		$config_path = APPPATH . 'config/config.php';
		$CI->load->helper('file');
		@chmod($config_path, FILE_WRITE_MODE);
		$config_file = read_file($config_path);
		$config_file = trim($config_file);

		$config_file = str_replace("\$config['installed'] = FALSE;", "\$config['installed'] = TRUE;", $config_file);
		$config_file = str_replace("\$config['sess_driver'] = 'files';", "\$config['sess_driver'] = 'database';", $config_file);

		if (!$fp = fopen($config_path, FOPEN_WRITE_CREATE_DESTRUCTIVE)) {
			return FALSE;
		}
		flock($fp, LOCK_EX);
		fwrite($fp, $config_file, strlen($config_file));
		flock($fp, LOCK_UN);
		fclose($fp);
		@chmod($config_path, FILE_READ_MODE);
		
		$this->write_helper_file();
		
		//add line to helper
		/* $helper_path = APPPATH . 'helpers/my_constant_helper.php';
		@chmod($helper_path, FILE_WRITE_MODE);
		$helper_file = read_file($helper_path);
		$helper_file = trim($helper_file);

		$helper_file = str_replace("\//define('TITLE',get_option('company_name').' - ');", "\define('TITLE',get_option('company_name').' - ');", $helper_file);

		if (!$fp = fopen($helper_path, FOPEN_WRITE_CREATE_DESTRUCTIVE)) {
			return FALSE;
		}
		flock($fp, LOCK_EX);
		fwrite($fp, $helper_file, strlen($helper_file));
		flock($fp, LOCK_UN);
		fclose($fp);
		@chmod($helper_path, FILE_READ_MODE); */
		
		
		return TRUE;
	}

//	public function delete_install_dir(){
//		if(is_dir(APPPATH . 'controllers/install')){
//			redirect(site_url('admin'));
////			if(delete_dir(APPPATH . 'controllers/install')){
////				redirect(admin_url());
////			}
//		}
//	}

	private function write_helper_file()
	{
		$new_helper_file = '<?php define(\'IMAGE\',\'assets/img/\');
			define(\'UPLOAD_LOGO\',\'assets/uploads/logo/\');
			define(\'ATTACHMENT\',\'assets/uploads/attachment/\');
			define(\'UPLOAD_EMPLOYEE\',\'assets/uploads/employee/\');
			define(\'TMP_UPLOAD_FOLDER\',\'assets/uploads/tmpFolder/\');
			define(\'EMPLOYEE_ID_PREFIX\',\'100\');
			define(\'TRANSACTION_PREFIX\',\'100\');
			define(\'TITLE\',get_option(\'company_name\').\' - \');
		';
		
		$fp = fopen(APPPATH . 'helpers/my_constant_helper.php','w+');
		if($fp)
		{
			if(fwrite($fp,$new_helper_file)){
				return true;
			}
			fclose($fp);
		}

		return false;
	}
	private function clean_up_db_query() {
		$CI = &get_instance();
		while (mysqli_more_results($CI->db->conn_id) && mysqli_next_result($CI->db->conn_id)) {

			$dummyResult = mysqli_use_result($CI->db->conn_id);

			if ($dummyResult instanceof mysqli_result) {
				mysqli_free_result($CI->db->conn_id);
			}
		}
	}
	private function write_db_config(){

		$hostname = $this->input->post('hostname');
		$database = $this->input->post('database');
		$username = $this->input->post('username');
		$password = $this->input->post('password');


		$new_database_file = '<?php defined(\'BASEPATH\') OR exit(\'No direct script access allowed\');

		/*
		| -------------------------------------------------------------------
		| DATABASE CONNECTIVITY SETTINGS
		| -------------------------------------------------------------------
		| This file will contain the settings needed to access your database.
		|
		| For complete instructions please consult the \'Database Connection\'
		| page of the User Guide.
		|
		| -------------------------------------------------------------------
		| EXPLANATION OF VARIABLES
		| -------------------------------------------------------------------
		|
		|	[\'dsn\']      The full DSN string describe a connection to the database.
		|	[\'hostname\'] The hostname of your database server.
		|	[\'username\'] The username used to connect to the database
		|	[\'password\'] The password used to connect to the database
		|	[\'database\'] The name of the database you want to connect to
		|	[\'dbdriver\'] The database driver. e.g.: mysqli.
		|			Currently supported:
		|				 cubrid, ibase, mssql, mysql, mysqli, oci8,
		|				 odbc, pdo, postgre, sqlite, sqlite3, sqlsrv
		|	[\'dbprefix\'] You can add an optional prefix, which will be added
		|				 to the table name when using the  Query Builder class
		|	[\'pconnect\'] TRUE/FALSE - Whether to use a persistent connection
		|	[\'db_debug\'] TRUE/FALSE - Whether database errors should be displayed.
		|	[\'cache_on\'] TRUE/FALSE - Enables/disables query caching
		|	[\'cachedir\'] The path to the folder where cache files should be stored
		|	[\'char_set\'] The character set used in communicating with the database
		|	[\'dbcollat\'] The character collation used in communicating with the database
		|				 NOTE: For MySQL and MySQLi databases, this setting is only used
		| 				 as a backup if your server is running PHP < 5.2.3 or MySQL < 5.0.7
		|				 (and in table creation queries made with DB Forge).
		| 				 There is an incompatibility in PHP with mysql_real_escape_string() which
		| 				 can make your site vulnerable to SQL injection if you are using a
		| 				 multi-byte character set and are running versions lower than these.
		| 				 Sites using Latin-1 or UTF-8 database character set and collation are unaffected.
		|	[\'swap_pre\'] A default table prefix that should be swapped with the dbprefix
		|	[\'encrypt\']  Whether or not to use an encrypted connection.
		|
		|			\'mysql\' (deprecated), \'sqlsrv\' and \'pdo/sqlsrv\' drivers accept TRUE/FALSE
		|			\'mysqli\' and \'pdo/mysql\' drivers accept an array with the following options:
		|
		|				\'ssl_key\'    - Path to the private key file
		|				\'ssl_cert\'   - Path to the public key certificate file
		|				\'ssl_ca\'     - Path to the certificate authority file
		|				\'ssl_capath\' - Path to a directory containing trusted CA certificats in PEM format
		|				\'ssl_cipher\' - List of *allowed* ciphers to be used for the encryption, separated by colons (\':\')
		|				\'ssl_verify\' - TRUE/FALSE; Whether verify the server certificate or not (\'mysqli\' only)
		|
		|	[\'compress\'] Whether or not to use client compression (MySQL only)
		|	[\'stricton\'] TRUE/FALSE - forces \'Strict Mode\' connections
		|							- good for ensuring strict SQL while developing
		|	[\'ssl_options\']	Used to set various SSL options that can be used when making SSL connections.
		|	[\'failover\'] array - A array with 0 or more data for connections if the main should fail.
		|	[\'save_queries\'] TRUE/FALSE - Whether to "save" all executed queries.
		| 				NOTE: Disabling this will also effectively disable both
		| 				$this->db->last_query() and profiling of DB queries.
		| 				When you run a query, with this setting set to TRUE (default),
		| 				CodeIgniter will store the SQL statement for debugging purposes.
		| 				However, this may cause high memory usage, especially if you run
		| 				a lot of SQL queries ... disable this to avoid that problem.
		|
		| The $active_group variable lets you choose which connection group to
		| make active.  By default there is only one group (the \'default\' group).
		|
		| The $query_builder variables lets you determine whether or not to load
		| the query builder class.
						*/
		$active_group = \'default\';
		$query_builder = TRUE;

		$db[\'default\'] = array(
		\'dsn\'	=> \'\',
		\'hostname\' => \''.$hostname.'\',
		\'username\' => \''.$username.'\',
		\'password\' => \''.$password.'\',
		\'database\' => \''.$database.'\',
		\'dbdriver\' => \'mysqli\',
		\'dbprefix\' => \'\',
		\'pconnect\' => FALSE,
		\'db_debug\' => (ENVIRONMENT !== \'production\'),
		\'cache_on\' => FALSE,
		\'cachedir\' => \'\',
		\'char_set\' => \'utf8\',
		\'dbcollat\' => \'utf8_general_ci\',
		\'swap_pre\' => \'\',
		\'encrypt\' => FALSE,
		\'compress\' => FALSE,
		\'stricton\' => FALSE,
		\'failover\' => array(),
		\'save_queries\' => TRUE
		);
		';

		$fp = fopen(APPPATH . 'config/database.php','w+');
		if($fp)
		{
			if(fwrite($fp,$new_database_file)){
				return true;
			}
			fclose($fp);
		}

		return false;
	}

}

