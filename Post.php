<?php include('inc/database.php') ?>
<?php include('admin/inc/fun.php') ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>POST</title>
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
        <?php include('head.php'); ?>
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
                <?php 
                if (isset($_GET["searchbutton"])) {
                  $Search = mysqli_real_escape_string($conn, $_GET["Search"]);
                  $query = "SELECT * FROM post WHERE content LIKE '%$Search%' OR title LIKE '%$Search%' OR tags LIKE '%$Search%'";
                }else {

                  $the_post_id = $_GET['post'];
                  $query = "SELECT * FROM post WHERE id = $the_post_id"; }
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
                    <p>Published on <?php echo $post_date; ?> by <a href="#" class="author"><?php echo $post_author; ?></a></p>
                    </div>
                    <div class="clear"></div>
                    <p><?php echo $post_content; ?></p>
                    <hr>
                    <h3>Leave a comment</h3>
                    <form action="" class="well1">
                      <div class="row">
                        <div class="mfControls grid_12">
                          <textarea name="" id="" cols="60" rows="10" class="comment"></textarea>
                        </div>
                        <div class="grid_12">
                          <input type="submit" value="Comment" name="comment" class="btn postbo2">
                        </div>
                      </div>
                    </form>
                    <?php } ?>

                  </div>
              <div class="grid_4">
                <!-- Search form -->
                 <form action="Blog.php" method="get" enctype="multipart/form-data">
                      <div class="info-box">
                        <hr>
                        <div class="clear"></div>
                        <div class="lf">
                          <input type="text" name="Search" placeholder="Search for...">
                        </div>
                        <div class="rt">
                          <button class="btn" name="searchbutton" type="submit">search</button>
                        </div>
                        <div class="clear"></div>
                        <hr>
                      </div>
                  </form>
                  <!-- end of serach form -->
                <div class="info-box">
                  <h2>Category</h2>
                  <hr>
                  <div class="clear"></div>
                  <div>
                    <ul>
                    <?php Category () ?>
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
        <?php include("footer.php"); ?>
      </footer>
    </div>
    <script src="js/script.js"></script>
  </body>
</html>