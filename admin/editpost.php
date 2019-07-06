
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
              Welcome <span><?php echo $_SESSION['username'] ?></span>
            </h2>
            <hr>
          </div>
        </div>
        <?php 

        // Extract Post
          if (isset($_GET['edit'])) {
          $theid = mysqli_real_escape_string($conn, $_GET['edit']);

          $query = "SELECT * FROM post WHERE id = {$theid}";
          $select_post = mysqli_query($conn, $query);

          while ($row = mysqli_fetch_array($select_post)) {
            $title = mysqli_real_escape_string($conn, $row['title']);
            $author = mysqli_real_escape_string($conn, $row['author']);
            $image = $row['image'];
            $category = mysqli_real_escape_string($conn, $row['category']);
            $tags = mysqli_real_escape_string($conn, $row['tags']);
            $status = mysqli_real_escape_string($conn, $row['status']);
            $content = mysqli_real_escape_string($conn, $row['content']);
          }
        }

          /// Update Post
          if (isset($_POST['update'])) {
            $title = mysqli_real_escape_string($conn, $_POST['post_title']);
            $author = mysqli_real_escape_string($conn, $_POST['Post_author']);

            $image = $_FILES['Post_image']['name'];
            $image_temp = $_FILES['Post_image']['tmp_name'];
            move_uploaded_file($image_temp, "../upload/$image");
            
            $category = mysqli_real_escape_string($conn, $_POST['post_category']);
            $tag = mysqli_real_escape_string($conn, $_POST['post_tag']);
            $status = mysqli_real_escape_string($conn, $_POST['post_status']);
            $content = mysqli_real_escape_string($conn, $_POST['post_content']);

            if (empty($image)) {
              $query = "SELECT * post WHERE id = {$theid}" ;
              $select_image = mysqli_query($conn, $query);
            }

            $query = "UPDATE post SET ";
            $query .= "title = '$title', ";
            $query .= "author = '$author', ";
            $query .= "date = now(), ";
            $query .= "image = '$image', ";
            $query .= "category = '$category', ";
            $query .= "tags = '$tag', ";
            $query .= "status = '$status', ";
            $query .= "content = '$content' ";
            $query .= "WHERE id = {$theid} ";

            $update_post = mysqli_query($conn, $query);

            $_SESSION['SuccessMessage'] = "Post Has Been Updated";
            redirect("viewpost");
          }
        ?>
        <form action="" method="POST" enctype="multipart/form-data">
          <div class="row">
            <div class="col-xl-6 form-group">
              <label for="title">Title</label>
              <input type="text" name="post_title" class="form-control" placeholder="Post Title" value="<?php echo $title; ?>">
            </div>
            <div class="col-xl-6 form-group">
              <label for="title">Author</label>
              <input type="text" name="Post_author" class="form-control" placeholder="Author Title" value="<?php echo $author; ?>">
            </div>
            <div class="col-xl-6 form-group">
              <label for="title">Image</label><br>
              <span style="color: red;">Existing Image:</span> 
              <img src="../upload/<?php echo $image; ?>" alt="Post Image" width="100px">
              <input type="file" name="Post_image" class="form-control">
            </div>
            <div class="col-xl-6 form-group">
              <label for="title">Category</label><br>
              <span style="color: red; ">Existing Category:</span> <?php

              $query = "SELECT * FROM categories WHERE id = '$category'";
              $categories_view = mysqli_query($conn, $query);

              while ($row = mysqli_fetch_array($categories_view)) {

                $cat_id = $row['id'];
                $cat_title = $row['title'];

                echo "<td>$cat_title</td>";
              }
              ?>
              <select name="post_category" required id="" class="form-control">
                <option disabled selected>Select Category</option>
                <?php ViewPost () ?>
              </select>
            </div>
            <div class="col-xl-6 form-group">
              <label for="title">Tag</label>
              <input type="text" name="post_tag" class="form-control" placeholder="Tag" value="<?php echo $tags; ?>">
            </div>
            <div class="col-xl-6 form-group">
              <label for="title">Status</label>
              <select name="post_status" class="form-control" id="">
                <option value="<?php echo $status ?>"><?php echo $status; ?></option>
                <?php 
                if ($post_status == 'Published') {
                  echo "<option value='Draft'>Draft</option>";
                }else {
                  echo "<option value='Published'>Published</option>";
                }
                 ?>
              </select>
            </div>
            <div class="col-xl-12 form-group">
              <label for="title">Content</label>
              <textarea name="post_content" id="mytextarea" cols="30" rows="10" class="form-control"><?php echo $content; ?></textarea>
            </div>
            <div class="col-xl-12 form-group">
              <input type="submit" value="Update Post" name="update" class="btn btn-success">
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
          <a class="btn btn-primary" href="logout">Logout</a>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap core JavaScript-->

  <script src="js/tinymce/tinymce.min.js"></script>
  <script>
    tinymce.init({
    selector: "textarea#mytextarea",
    theme: "modern",
    
    plugins: [
         "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
         "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
         "save table contextmenu directionality emoticons template paste textcolor"
   ],
   content_css: "css/content.css",
   toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | l      ink image | print preview media fullpage | forecolor backcolor emoticons fullscreen | autosave ", 
   style_formats: [
        {title: 'Bold text', inline: 'b'},
        {title: 'Red text', inline: 'span', styles: {color: '#ff0000'}},
        {title: 'Red header', block: 'h1', styles: {color: '#ff0000'}},
        {title: 'Example 1', inline: 'span', classes: 'example1'},
        {title: 'Example 2', inline: 'span', classes: 'example2'},
        {title: 'Table styles'},
        {title: 'Table row 1', selector: 'tr', classes: 'tablerow1'}
    ]
 }); 
</script>
<?php include 'inc/footer.php'; ?>
