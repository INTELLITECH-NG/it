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
              Welcome <span><?php echo $_SESSION['username'] ?></span> <sup>
                <?php 
                if (isset($_SESSION['role'])) {
                  if ($_SESSION['role'] ==  'Admin') {
                    echo "Admin";
                  } else {
                    echo "Subscriber";
                  }
                } 
                 ?>
              </sup>
            </h2>
            <hr>
          <div><?php 
        echo Error_Message();
        echo Success_Message(); ?></div>
          </div>
        </div>
        <!-- page content -->
        <div class="row">
          <div class="col-xl-3 col-sm-6 mb-3">
            <div class="card text-white bg-primary o-hidden h-100">
              <div class="card-body">
                <div class="card-body-icon">
                  <i class="fas fa-file-alt"></i>
                </div>
                <?php 
                $query = "SELECT * FROM post";
                $select_all_post = mysqli_query($conn, $query);
                $post_count = mysqli_num_rows($select_all_post);

                echo "<div class='mr-5'><h1>{$post_count}</h1> Post</div>";
                 ?>
              </div>
              <a class="card-footer text-white clearfix small z-1" href="viewpost">
                <span class="float-left">View Details</span>
                <span class="float-right">
                  <i class="fas fa-angle-right"></i>
                </span>
              </a>
            </div>
          </div>
          <div class="col-xl-3 col-sm-6 mb-3">
            <div class="card text-white bg-warning o-hidden h-100">
              <div class="card-body">
                <div class="card-body-icon">
                  <i class="fas fa-comments"></i>
                </div>
                <?php 
                $query = "SELECT * FROM comment";
                $select_all_comment = mysqli_query($conn, $query);
                $comment_count = mysqli_num_rows($select_all_comment);

                echo "<div class='mr-5'><h1>{$comment_count}</h1> Comment</div>";
                 ?>
              </div>
              <a class="card-footer text-white clearfix small z-1" href="comment">
                <span class="float-left">View Details</span>
                <span class="float-right">
                  <i class="fas fa-angle-right"></i>
                </span>
              </a>
            </div>
          </div>
          <div class="col-xl-3 col-sm-6 mb-3">
            <div class="card text-white bg-success o-hidden h-100">
              <div class="card-body">
                <div class="card-body-icon">
                  <i class="fas fa-user"></i>
                </div>
                <?php 
                $query = "SELECT * FROM users";
                $select_all_users = mysqli_query($conn, $query);
                $user_count = mysqli_num_rows($select_all_users);

                echo "<div class='mr-5'><h1>{$user_count}</h1> Users</div>";
                 ?>
              </div>
              <a class="card-footer text-white clearfix small z-1" href="viewusers">
                <span class="float-left">View Details</span>
                <span class="float-right">
                  <i class="fas fa-angle-right"></i>
                </span>
              </a>
            </div>
          </div>
          <div class="col-xl-3 col-sm-6 mb-3">
            <div class="card text-white bg-danger o-hidden h-100">
              <div class="card-body">
                <div class="card-body-icon">
                  <i class="fas fa-database"></i>
                </div>
                <?php 
                $query = "SELECT * FROM categories";
                $select_all_category = mysqli_query($conn, $query);
                $count_category = mysqli_num_rows($select_all_category);

                echo "<div class='mr-5'><h1>{$count_category}</h1> Category</div>";
                ?>
              </div>
              <a class="card-footer text-white clearfix small z-1" href="categories">
                <span class="float-left">View Details</span>
                <span class="float-right">
                  <i class="fas fa-angle-right"></i>
                </span>
              </a>
            </div>
          </div>
        </div>
        <div class="row">
          <?php 
          $query = "SELECT * FROM post WHERE status = 'Draft' ";
          $select_all_draft_post = mysqli_query($conn, $query);
          $draft_count = mysqli_num_rows($select_all_draft_post);

          $query = "SELECT * FROM comment WHERE status = 'unapproved' ";
          $select_unapprove = mysqli_query($conn, $query);
          $unapproved_count = mysqli_num_rows($select_unapprove);

          $query = "SELECT * FROM comment WHERE status = 'approved' ";
          $select_approve = mysqli_query($conn, $query);
          $approved_count = mysqli_num_rows($select_approve);

          $query = "SELECT * FROM users WHERE role = 'Subscriber' ";
          $select_subscriber = mysqli_query($conn, $query);
          $subscriber_count = mysqli_num_rows($select_subscriber);

          $query = "SELECT * FROM users WHERE role = 'Admin' ";
          $select_admin = mysqli_query($conn, $query);
          $admin_count = mysqli_num_rows($select_admin);

           ?>
          <script type="text/javascript">
            google.charts.load('current', {'packages':['bar']});
            google.charts.setOnLoadCallback(drawChart);
            function drawChart() {
              var data = google.visualization.arrayToDataTable([
          ['Data', 'Count'], 
          <?php 
          $elements_text = ['Active Posts', 'Draft Post', 'Approved Comment', 'Unapproved Comment', 'Comments', 'Users', 'Admin', 'Subscriber', 'Caterories'];
          $elements_count = [$post_count, $draft_count, $approved_count, $unapproved_count, $comment_count, $user_count, $admin_count, $subscriber_count, $count_category];

          for($i = 0; $i < 9; $i++) {
            echo "['{$elements_text[$i]}'" . "," . "{$elements_count[$i]}]," ;
          }

          ?>
          /*['Posts', 1000],*/

        ]);

        var options = {
          chart: {
            title: '',
            subtitle: '',
          }
        };

        var chart = new google.charts.Bar(document.getElementById('columnchart_material'));

        chart.draw(data, google.charts.Bar.convertOptions(options));
      }
    </script>
          <div class="col-lg-12">
            <div class="card mb-3">
              <div id="columnchart_material" style="width: auto; height: 500px;"></div>
            </div>
          </div>
        </div>
      <!-- /.container-fluid -->

      <!-- Sticky Footer -->
      <footer class="sticky-footer">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>Copyright © Your Website 2019</span>
          </div>
        </div>
      </footer>

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
          <a class="btn btn-primary" href="logout">Logout</a>
        </div>
      </div>
    </div>
  </div>
<?php include 'inc/footer.php'; ?>
