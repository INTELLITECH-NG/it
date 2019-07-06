<?php include('inc/database.php') ?>
<?php include('admin/inc/fun.php') ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>AUTHOR</title>
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
                  $the_post_author = $_GET['author'];

                  $query = "SELECT * FROM post WHERE author = '$the_post_author' "; }
                  $post_query = mysqli_query($conn, $query);

                while ($Datarow = mysqli_fetch_assoc($post_query)) {
                       $post_id = $Datarow['id'];
                       $post_title = $Datarow['title'];
                       $post_author = $Datarow['author'];
                       $post_date = $Datarow['date'];
                       $post_image = $Datarow['image'];
                       $post_content = $Datarow['content'];
                       $post_content = substr($Datarow['content'], 0,100);

                     ?>
                    <?php Success_Message(); 
                    Error_Message() ?>
                    <a href="Post?post=<?php echo $post_id; ?>"><img src="upload/<?php echo $post_image ?>" alt=""></a>
                    <div class="row">
                      <div class="grid_5">
                        <h2><a href="post?post=<?php echo $post_id; ?>"><?php echo htmlentities($post_title); ?></a></h2>
                      </div>
                      <div class="grid_2 right">
                        <p>All Post by <?php echo $post_author; ?> at <?php echo $post_date ?></p>
                      </div>
                    </div>
                    <div class="row">
                      <div class="grid_12">
                        <p><?php echo $post_content; ?></p><a href="Post?post=<?php echo $post_id; ?>" class="btn postbo">Read more</a>
                      </div>
                    </div>
                    <?php } ?>

                  </div>
              <div class="grid_4">
                <!-- Search form -->
                 <form action="Blog.php" method="get" enctype="multipart/form-data">
                      <div class="info-box">
                        <hr>
                        <div class="row down">
                          <div class="grid_1 sea">
                            <input type="text" name="Search" placeholder="Search for...">
                          </div>
                          <div class="grid_1_2">
                            <button class="btn" name="searchbutton" type="submit">Search</button>
                          </div>
                        </div>
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