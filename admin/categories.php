
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
        <!-- page content -->
        <div class="row">
        <div class="col-xl-6">
          <?php if (isset($_POST['submit'])) {
            $cat_title = mysqli_real_escape_string($conn, $_POST['cat_title']);

            if ($cat_title == "" || empty($cat_title)) {
              echo "This field should not be empty";
            }else {
              $query = "INSERT INTO categories(title) ";
              $query .= "VALUE('{$cat_title}') ";

              $create_categories = mysqli_query($conn, $query);

              if (!$create_categories) {
                die('query Failed' .mysqli_error($conn)); 
                }
            }
          } ?>
          <form action="" method="post">
            <div class="form-group">
              <label for="cat_title">Add Catergory</label>
              <input type="text" class="form-control" name="cat_title" id="cat_title">
            </div>
            <div class="form-group">
              <input type="submit" class="btn btn-primary" name="submit" value="Add Category">
            </div>
          </form>
          <form action="" method="post">
            <div class="form-group">
              <label for="cat_edit">Edit Catergory</label>
              <?php 

              if (isset($_GET['edit'])) {

              $cat_id = $_GET['edit'];

              $query = "SELECT * FROM categories WHERE id = $cat_id";
              $edit_categories = mysqli_query($conn, $query); 


              while ($row = mysqli_fetch_assoc($edit_categories)) {
                $cat_id = mysqli_real_escape_string($conn, $row['id']);
                $cat_title = mysqli_real_escape_string($conn, $row['title']);

              } 
              ?>
                <input type="text" value="<?php 
                if (isset($cat_title)) {
                  echo $cat_title;
                }
                ?> " class="form-control" name="cat_edit" id="cat_edit">

              <?php } ?>
              <?php if (isset($_POST['update_cat'])) {
              $the_cat_id = mysqli_real_escape_string($conn, $_POST['cat_title']);
              $query = "UPDATE  categories SET title = '{$the_cat_id}' WHERE id = {$cat_id} ";
              $update_query = mysqli_query($conn, $query);

              if (!$update_query) {
                die("query Failed" . mysqli_error($conn));
              }
              } ?>

              
            </div>
            <div class="form-group">
              <input type="submit" class="btn btn-primary" name="update_cat" value="Update Category">
            </div>
          </form>
        </div> 
        <div class="col-xl-6">
          <?php 
          $query = "SELECT * FROM categories";
          $select_categories = mysqli_query($conn, $query);
           ?>
           <h6>Category Table</h6>
          <table class="table table-bordered table-hover">
            <thead>
              <tr>
                <th>Id</th>
                <th>Category Title</th>
              </tr>
            </thead>
            <tbody>
              <?php 
              while ($row = mysqli_fetch_assoc($select_categories)) {
              $cat_id = mysqli_real_escape_string($conn, $row['id']);
              $cat_title = mysqli_real_escape_string($conn, $row['title']);

              echo "<tr>";
              echo "<td>{$cat_id}</td>";
              echo "<td>{$cat_title}</td>";
              echo "<td><a href='categories.php?del={$cat_id}'>Delete</a></td>";
              echo "<td><a href='categories.php?edit={$cat_id}'>Edit</a></td>";
              echo "</tr>";
            }?>

            <?php if (isset($_GET['del'])) {
              $the_cat_id = mysqli_real_escape_string($conn, $_GET['del']);
              $query = "DELETE FROM categories WHERE id = {$the_cat_id} ";
              $delete_query = mysqli_query($conn, $query);
              header("Location: categories.php");
            } ?>
            </tbody>
          </table>
        </div>
        </div>    
        <div></div>
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
