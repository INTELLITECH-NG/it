            <form action="" method="POST">
              <div class="form-group">
                <label for="title">Edit Category</label>
                <?php if (isset($_GET['edit'])) {
                  $edit_id  = $_GET['edit'];

                  $query = "SELECT * FROM categories WHERE id = $edit_id" ;
                  $edit_category = mysqli_query($conn, $query);

                  while ($row = mysqli_fetch_assoc($edit_category)) {
                    $id = $row['id'];
                    $title = $row['title'];
                  } ?>

                <input type="text" id="title" name="main_title" class="form-control" value="<?php if (isset($title)) { echo $title ;} ?>">

                <?php } ?>
                <?php if (isset($_POST['update'])) {
                  $update_title = $_POST['main_title'];

                  $query = "UPDATE categories SET title = '{$update_title}' WHERE id = {$id} " ;
                  $update_post = mysqli_query($conn, $query) ;

                  if (!$update_post ) {
                    die('Am a Killer' . mysqli_error($conn)) ;
                  }
                } ?>
              </div>
              <div class="form-group">
                <input type="submit" value="Update Category" name="update" class="btn btn-success">
              </div>
            </form>