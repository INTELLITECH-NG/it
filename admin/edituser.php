
<?php include 'inc/head.php'; ?>

<body id="page-top">

  <nav class="navbar navbar-expand navbar-dark bg-dark static-top">

    <a class="navbar-brand mr-1" href="index">INTELLITECH</a>

    <button class="btn btn-link btn-sm text-white order-1 order-sm-0" id="sidebarToggle" href="#">
      <i class="fas fa-bars"></i>
    </button>

    <!-- Navbar Search -->
    <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
      <div class="input-group">
        <input type="text" class="form-control" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
        <div class="input-group-append">
          <button class="btn btn-primary" type="button">
            <i class="fas fa-search"></i>
          </button>
        </div>
      </div>
    </form>

    <!-- Navbar -->
    <ul class="navbar-nav ml-auto ml-md-0">
      <li class="nav-item dropdown no-arrow mx-1">
        <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fas fa-envelope fa-fw"></i>
          <span class="badge badge-danger">7</span>
        </a>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="messagesDropdown">
          <a class="dropdown-item" href="#">Action</a>
          <a class="dropdown-item" href="#">Another action</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="#">Something else here</a>
        </div>
      </li>
      <li class="nav-item dropdown no-arrow">
        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fas fa-user-circle fa-fw"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
          <a class="dropdown-item" href="#">Settings</a>
          <a class="dropdown-item" href="#">Activity Log</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">Logout</a>
        </div>
      </li>
    </ul>

  </nav>

  <div id="wrapper">
    <!-- Sidebar -->
    <?php include 'inc/nav.php'; ?>

    <div id="content-wrapper">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12">
            <h2 class="page-header">
              Welcome <span>Admin</span>
            </h2>
            <hr>
          </div>
        </div>
        <?php 

        // Extract User
          if (isset($_GET['edit'])) {
          $theid = mysqli_real_escape_string($conn, $_GET['edit']);

          $query = "SELECT * FROM users WHERE id = {$theid}";
          $select_post = mysqli_query($conn, $query);

          while ($row = mysqli_fetch_array($select_post)) {
            $username = mysqli_real_escape_string($conn, $row['username']);
            $firstname = mysqli_real_escape_string($conn, $row['firstname']);
            $image = $row['image'];
            $lastname = mysqli_real_escape_string($conn, $row['lastname']);
            $email = mysqli_real_escape_string($conn, $row['email']);
            $password = mysqli_real_escape_string($conn, $row['password']);
            $role = mysqli_real_escape_string($conn, $row['role']);
          }
        }

          /// Update Post
          if (isset($_POST['updateuser'])) {
            $username = mysqli_real_escape_string($conn, $_POST['username']);
            $firstname = mysqli_real_escape_string($conn, $_POST['firstname']);
            $lastname = mysqli_real_escape_string($conn, $_POST['lastname']);
            $email = mysqli_real_escape_string($conn, $_POST['email']);
            $password = mysqli_real_escape_string($conn, $_POST['password']);
            $role = mysqli_real_escape_string($conn, $_POST['role']);

            $query = "UPDATE users SET username = '$username', firstname = '$firstname', date = now(), image = '$image', lastname = '$lastname', email = '$email', password = '$password', role = '$role' WHERE id = {$theid} ";

            $update_post = mysqli_query($conn, $query);

            $_SESSION['SuccessMessage'] = "$username Has Been Updated";
            redirect("viewusers");
          }
        ?>
        <form action="" method="POST" enctype="multipart/form-data">
          <div class="row">
            <div class="col-xl-6 form-group">
              <label for="title">First Name</label>
              <input type="text" name="firstname" class="form-control" placeholder="First Name" value="<?php echo $firstname; ?>">
            </div>
            <div class="col-xl-6 form-group">
              <label for="title">Last Name</label>
              <input type="text" name="lastname" class="form-control" placeholder="Last Name" value="<?php echo $lastname; ?>">
            </div>
            <div class="col-xl-6 form-group">
              <label for="title">Username</label>
              <input type="text" name="username" class="form-control" placeholder="User Name" value="<?php echo $username; ?>">
            </div>
            <div class="col-xl-6 form-group">
              <label for="title">Password</label>
              <input type="password" name="password" class="form-control" placeholder="Password" value="<?php echo $password; ?>">
            </div>
            <div class="col-xl-6 form-group">
              <label for="title">Email</label>
              <input type="email" name="email" class="form-control" placeholder="Email" value="<?php echo $email; ?>">
            </div>
            <div class="col-xl-6 form-group">
              <label for="title">Role</label><br>
              <select name="role" required id="" class="form-control">
                <option selected><?php echo $role; ?></option>
                <?php 
                if ($role == 'admin') {
                  echo "<option value='subscriber'>subscriber</option>";
                } else {
                  echo "<option value='admin'>admin</option>";
                }
                 ?>
              </select>
            </div>
            <div class="col-xl-12 form-group">
              <input type="submit" value="Update User" name="updateuser" class="btn btn-success">
            </div>
          </div>
        </form>        
      </div>
      </div>
      <!-- /.container-fluid -->

      <!-- Sticky Footer -->
<!-- <footer class="sticky-footer">
  <div class="container my-auto fl">
    <div class="copyright text-center my-auto">
      <span>Copyright © Your Website 2019</span>
    </div>
  </div>
</footer> -->

    </div>
    <!-- /.content-wrapper -->

  </div>
  <!-- /#wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Logout Modal-->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
          <a class="btn btn-primary" href="login">Logout</a>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Page level plugin JavaScript-->
  <script src="vendor/chart.js/Chart.min.js"></script>
  <script src="vendor/datatables/jquery.dataTables.js"></script>
  <script src="vendor/datatables/dataTables.bootstrap4.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="js/sb-admin.min.js"></script>

  <!-- Demo scripts for this page-->
  <script src="js/demo/datatables-demo.js"></script>
  <script src="js/demo/chart-area-demo.js"></script>

</body>

</html>
