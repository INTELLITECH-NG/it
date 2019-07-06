<?php include '../inc/database.php'; ?>
<?php include '../admin/inc/fun.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>User - Login</title>

  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

  <!-- Custom styles for this template-->
  <link href="css/sb-admin.css" rel="stylesheet">

</head>

<body class="bg-dark">

  <div class="container">
    <?php User_log () ?>
    <div class="card card-login mx-auto mt-5">
      <div class="card-header">Login</div>
      <div class="card-body col-lg-12">
        <?php 
        echo Error_Message();
        echo Success_Message(); 
        ?>
        <form action="login" method="POST">
          <div class="form-group">
            <div class="form-label-group">
              <input type="text" id="inputEmail" name="username" class="form-control" placeholder="Username" autofocus="autofocus">
              <label for="inputEmail">Username</label>
            </div>
          </div>
          <div class="form-group">
            <div class="form-label-group">
              <input type="password" name="password" id="inputPassword" class="form-control" placeholder="Password">
              <label for="inputPassword">Password</label>
            </div>
          </div>
          <div class="form-group">
            <div class="checkbox">
              <label>
                <input type="checkbox" value="remember-me">
                Remember Password
              </label>
            </div>
          </div>
          <input type="submit" name="userlog" value="Login" class="btn btn-primary btn-block">
        </form>
        <div class="text-center">
          <a class="d-block small mt-3" href="register">Register an Account</a>
          <a class="d-block small" href="forgot-password">Forgot Password?</a>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

</body>

</html>
