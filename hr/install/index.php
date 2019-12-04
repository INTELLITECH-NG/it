<?php
error_reporting(0);
require_once('includes/installer.php');

//$config_path = '../application/config/config.php';
//$config_file = file_get_contents($config_path);

$debug = '';
		$step = 1;
		$error ='';
		$passed_steps = array(
			1 => false,
			2 => false,
			3 => false,
			4 => false,
			);
			
			//catch submit
			if(!empty($_POST)){
				
				require_once('includes/core_class.php');
				require_once('includes/database_class.php');

				$core = new Core();
				$database = new Database();
				
			if(htmlspecialchars($_POST["step"]) && htmlspecialchars($_POST["step"]) == 2){
				$step = 2;
				$passed_steps[1] = true;
				$passed_steps[2] = true;
			} else if(htmlspecialchars($_POST["step"]) && htmlspecialchars($_POST["step"]) == 3){
				
				
				if($_POST['hostname'] == ''){
					$error .= 'Hostname is required';
				} else if ($_POST['database'] == '') {
					$error .= 'Enter database name';
				} else if ($_POST['username'] == ''){
					$error .= 'Enter database username';
				}
				
				
				$step = 3;
				$passed_steps[1] = true;
				$passed_steps[2] = true;
				
				if($error === ''){
					$passed_steps[3] = true;
					$link = @mysqli_connect($_POST['hostname'], $_POST['username'], $_POST['password'], $_POST['database']);
					if (!$link) {
						$error .= "Error: Unable to connect to MySQL." . PHP_EOL;
						$error .= "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
						$error .= "Debugging error: " . mysqli_connect_error() . PHP_EOL;
					} else {
						$debug .= "Success: A proper connection to MySQL was made! The ".$_POST['database']." database is great." . PHP_EOL;
						$debug .= "Host information: " . mysqli_get_host_info($link) . PHP_EOL;
					
						
						if($database->create_tables($_POST) == false){
							$error .= 'The database tables could not be created, please verify your settings.';
						}else if ($database->write_db_config($_POST) == false) {
							$error .= 'The database configuration file could not be written, please chmod application/config/database.php file to 777';
						}else{
							$passed_steps[1] = true;
							$passed_steps[2] = true;
							$passed_steps[3] = true;
							$step = 4;
							
							//open file and get data
							$file_path = '../index.php';
							$file_contents = @file_get_contents($file_path);
							// do tag replacements or whatever you want
							$file_contents = str_replace("\$intaller = TRUE;","\$intaller = FALSE;",$file_contents);
							@file_put_contents($file_path,$file_contents);
							
							
						}
					}
				}
				
				
			} else if($_POST["requirements_success"]) {
				$step = 2;
				$passed_steps[1] = true;
				$passed_steps[2] = true;
			} else if($_POST['permissions_success']){
				$step = 3;
				$passed_steps[1] = true;
				$passed_steps[2] = true;
				$passed_steps[3] = true;
			} 
			else {
				$error;
			}
		}
			
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
  <title>eOffice - Installation</title>
  <link href="../assets/css/bootstrap/css/bootstrap.css" rel="stylesheet">
  <link href="../assets/css/AdminLTE.css" rel="stylesheet">
  <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
  <!-- danger: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
      <![endif]-->
      <style>
        body {
          font-family:'Open Sans';
           background-color: #444A52;
        }
        .install-row {
          border:1px solid #e4e5e7;
          border-radius:2px;
          background:#fff;
          padding:15px;
        }
        .logo {
          margin-top:50px;
          background:#fff;
          padding:15px;
          display:inline-block;
          width:100%;
          border-radius:2px;
          margin-bottom:5px;
        }
        .logo img {
          display:block;
          margin:0 auto;
        }
        .control-label {
          font-weight:600;
        }
        .padding-10 {
          padding:10px;
        }
        .mbot15 {
          margin-bottom:15px;
        }
        .bg-default {
          background: #29323B;
          color:#fff;
          border:1px solid #29323B;
        }
        .bg-not-passed {
          border:1px solid #e4e5e7;
          border-radius:2px;
        }
        .bold {
          font-weight:600;
        }
        .col-xs-5ths,
        .col-sm-5ths,
        .col-md-5ths,
        .col-lg-5ths {
          position: relative;
          min-height: 1px;
          padding-right: 15px;
          padding-left: 15px;
        }
        .col-xs-5ths {
          width: 25%;
          float: left;
        }
      </style>
    </head>
    <body>
     <div class="container">
      <div class="row">

       <div class="col-md-8 col-md-offset-2">
        <div class="logo">
          <img src="../assets/img/codeslab.png">
        </div>
        <div class="install-row">
          <div class="col-xs-5ths text-center <?php if($passed_steps[1] == true || $step == 1){echo 'bg-default';} ?> padding-10 mbot15">
            <h5>Requirements</h5>
          </div>
          <div class="col-xs-5ths text-center <?php if($passed_steps[2] || $step == 2){echo 'bg-default';} else {echo 'bg-not-passed';} ?> padding-10 mbot15">
            <h5>Permissions</h5>
          </div>
          <div class="col-xs-5ths text-center <?php if($passed_steps[3] || $step == 3){echo 'bg-default';} else {echo 'bg-not-passed';} ?> padding-10 mbot15">
           <h5> Database setup</h5>
         </div>
           
         <div class="col-xs-5ths text-center <?php if($step == 4){echo 'bg-default';}else {echo 'bg-not-passed';} ?> padding-10 mbot15">
           <h5> Finish</h5>
         </div>
         <div class="clearfix"> </div>
         <hr />
		 
         <p><?php echo $debug; ?></p>
         <?php if(isset($error) && $error != ''){ ?>
         <div class="alert alert-danger text-center">
           <?php echo $error; ?>
         </div>
         <?php } ?>
         <?php if($step == 1){
           include_once('requirements.php');
         } else if($step == 2){
          include_once('file_permissions.php');
        } else if($step == 3){ ?>
       <form action="<?php echo htmlentities($_SERVER['PHP_SELF']);?>" method="post">
	   <input type="hidden" name="step" value="<?php echo $step?>">
        
        <div class="form-group">
          <label for="hostname" class="control-label">Hostname</label>
          <input type="text" class="form-control" name="hostname" value="localhost">
        </div>
        <div class="form-group">
          <label for="database" class="control-label">Database Name</label>
          <input type="text" class="form-control" name="database">
        </div>
        <div class="form-group">
          <label for="username" class="control-label">Username</label>
          <input type="text" class="form-control" name="username">
        </div>
        <div class="form-group">
          <label for="password" class="control-label">Password</label>
          <input type="text" class="form-control" name="password">
        </div>
        <div class="text-center">
          <button type="submit" class="btn btn-primary btn-block btn-flat">Next Step</button>
       </div>
             </form>
         <?php } else if($step == 4){ ?>
            
			<?php 
			  $redir = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") ? "https" : "http");
			  $redir .= "://".$_SERVER['HTTP_HOST'];
			  $redir .= str_replace(basename($_SERVER['SCRIPT_NAME']),"",$_SERVER['SCRIPT_NAME']);
			  $redir = str_replace('install/','',$redir); 
			?>

			<div class="well well-lg">
			
			<h4 class="bold">Congratulations! </h4>
             <p>You have successfully installed eOffice&reg; Application.</p>
			 
			 <div class="alert alert-info"><i class='icon-info-sign'></i> You can login now using the following credential:<br /><br />
            Username: <span style="font-weight:bold; letter-spacing:1px;">admin</span><br />Password: <span style="font-weight:bold; letter-spacing:1px;">admin</span><br /><br /></div>
            <div class="alert alert-warning"><i class='icon-warning-sign'></i> Please don't forget to change username and password.</div>
			 
             <a href="<?php echo $redir.'admin' ?>" class="btn btn-primary">Login</a>
			
			</div>
             
			 
			 <?php 
			 
				//open file and get data
				$file_path = 'includes/installer.php';
				$file_contents = @file_get_contents($file_path);
				// do tag replacements or whatever you want
				$file_contents = str_replace("\$install_flag = TRUE;","\$install_flag = FALSE;",$file_contents);
				@file_put_contents($file_path,$file_contents);
			 
			 ?>
           
         <?php } ?>
             
    </div>
  </div>
</div>
</div>
</body>
</html>

