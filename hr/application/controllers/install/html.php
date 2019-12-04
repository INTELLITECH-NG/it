<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
  <title>eOffice - Installation</title>
  <link href="<?php echo site_url(); ?>assets/css/bootstrap/css/bootstrap.css" rel="stylesheet">
  <link href="<?php echo site_url(); ?>assets/css/AdminLTE.css" rel="stylesheet">
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
          width: 20%;
          float: left;
        }
      </style>
    </head>
    <body>
     <div class="container">
      <div class="row">

       <div class="col-md-8 col-md-offset-2">
        <div class="logo">
          <img src="<?php echo site_url('assets/img/codeslab.png'); ?>">
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
            <div class="col-xs-5ths text-center <?php if($passed_steps[4] || $step == 4){echo 'bg-default';} else {echo 'bg-not-passed';} ?> padding-10 mbot15">
                <h5> Create User</h5>
            </div>
         <div class="col-xs-5ths text-center <?php if($step == 5){echo 'bg-default';}else {echo 'bg-not-passed';} ?> padding-10 mbot15">
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
        <?php echo form_open($this->uri->uri_string()); ?>
        <?php echo form_hidden('step',$step); ?>
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
             <?php echo form_close(); ?>
         <?php } else if($step == 4){ ?>
             <?php echo form_open($this->uri->uri_string()); ?>
             <?php echo form_hidden('step',$step); ?>

             <div class="form-group">
                 <label for="admin_email" class="control-label">Username (Login)</label>
                 <input type="text" class="form-control" name="username" id="username">
             </div>

             <div class="form-group">
                 <label for="admin_email" class="control-label">First Name</label>
                 <input type="text" class="form-control" name="first_name" id="first_name">
             </div>

             <div class="form-group">
                 <label for="admin_email" class="control-label">Last Name</label>
                 <input type="text" class="form-control" name="last_name" id="last_name">
             </div>

             <div class="form-group">
                 <label for="admin_email" class="control-label">Email</label>
                 <input type="email" class="form-control" name="admin_email" id="admin_email">
             </div>
             <div class="form-group">
                 <label for="admin_password" class="control-label">Password</label>
                 <input type="password" pattern=".{8,10}" required title="must be 8-10 characters Long" class="form-control" name="admin_password" id="admin_password">
             </div>
             <div class="form-group">
                 <label for="admin_passwordr" class="control-label">Repeat Password</label>
                 <input type="password" pattern=".{8,10}" required title="must be 8-10 characters Long" class="form-control" name="admin_passwordr" id="admin_passwordr">
             </div>
             <div class="text-center">
                 <button type="submit" class="btn btn-primary btn-block btn-flat">Install</button>
             </div>
             <?php echo form_close(); ?>
         <?php } else if($step == 5){ ?>
             <h4 class="bold">Congratulations! </h4>
             <p>You have successfully installed eOffice&reg; Application.</p>
             <a href="<?php echo site_url('admin')?>" class="btn btn-primary">Login</a>
         <?php } ?>
    </div>
  </div>
</div>
</div>
</body>
</html>

