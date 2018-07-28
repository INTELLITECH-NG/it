<?php include('inc/database.php') ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Blog</title>
    <meta charset="utf-8">
    <meta name="format-detection" content="telephone=no">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="images/favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="css/grid.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="css/publicstyle.css">
    <script src="js/jquery.js"></script>
    <script src="js/jquery-migrate-1.2.1.js"></script><!--[if lt IE 9]>
    <html class="lt-ie9">
      <div style="clear: both; text-align:center; position: relative;"><a href="http://windows.microsoft.com/en-US/internet-explorer/.."><img src="images/ie8-panel/warning_bar_0000_us.jpg" border="0" height="42" width="820" alt="You are using an outdated browser. For a faster, safer browsing experience, upgrade for free today."></a></div>
    </html>
    <script src="js/html5shiv.js"></script><![endif]-->
    <script src="js/device.min.js"></script>
  </head>
  <body>
    <div class="page">
      <!--
      ========================================================
      							HEADER
      ========================================================
      
      
      -->
      <header>
        <?php include('inc/header.php'); ?>
      </header>
      <!--
      ========================================================
                                  CONTENT
      ========================================================
      -->
	  <main>
     <section class="well1">
          <div class="container">
            <div class="row">
              <div class="grid_8">
                <?php $query = "SELECT * FROM post";
                $post_query = mysqli_query($conn, $query);

                while ($Datarow = mysqli_fetch_assoc($post_query)) {
                     $post_title = $Datarow['title'];
                     $post_author = $Datarow['author'];
                     $post_date = $Datarow['date'];
                     $post_image = $Datarow['image'];
                     $post_content = $Datarow['content'];

                     ?>
                    <img src="upload/<?php echo $post_image ?>" class="post" alt="">
                    <div class="left">
                    <h2><?php echo htmlentities($post_title); ?></h2>
                    </div>
                    <div class="right">
                    <p>Posted on <?php echo $post_date; ?> by <a href="#" class="author"><?php echo $post_author; ?></a></p>
                    </div>
                    <div class="clear"></div>
                    <p><?php echo $post_content; ?></p><a href="#" class="btn postbo">Read more</a>

                    <?php } ?>
                  </div>
              <div class="grid_4">
                <?php 
                if (isset($_POST['submit'])) {
                  $search = $_POST['search'];

                  $query = "SELECT * FROM post WHERE tags LIKE '%$search%'";
                  $search_query = mysqli_query($conn, $query);

                  if (!$search_query) {
                    die("Search die". mysqli_error($conn));
                  }

                  $count = mysqli_num_rows($search_query);

                  if ($count == 0) {
                    echo "<h1>NO RESULT</h1>";
                  }
                }
                 ?>
                <form action="" method="post">
                  <div class="info-box">
                  <hr>
                  <div class="clear"></div>
                    <div class="lf">
                      <input type="text" name="search" placeholder="Search for..." >
                    </div>
                    <div class="rt">
                      <button class="btn" name="submit" type="submit">search</button>
                    </div>
                    <div class="clear"></div>
                    <hr>
                  </div>
                </form>
                <div class="info-box">
                  <h2>Help center</h2>
                  <hr>
                  <h3>Category:</h3>
                  <div class="clear"></div>
                  <div>
                    <ul>
                    <?php 
                    $query = "SELECT * FROM categories";
                    $categories_query = mysqli_query($conn, $query);

                    while ($row = mysqli_fetch_assoc($categories_query)) {
                         $cat_title = $row['title'];

                         echo "<li><a href='#'>{$cat_title}</a></li>";
                     } ?>
                   </ul>
                  </div>
                  <a href="" target=""></a>
                  <hr>
                  <h3>24/7 Online Support:</h3>
                  <dl>
                    <dt>800-2345-6789</dt>
                  </dl>
                </div>
              </div>
            </div>
          </div>
        </section> 
    </main>
      <!--
      ========================================================
                                  FOOTER
      ========================================================
      -->
      <footer>
        <?php include("inc/footer.php"); ?>
      </footer>
    </div>
    <script src="js/script.js"></script>
  </body>
</html>