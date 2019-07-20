<?php $current = 'Blog' ?>
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
                  $query = "SELECT * FROM post WHERE id = $the_post_id AND status = 'Published' "; }
                  $post_query = mysqli_query($conn, $query);

                  if (mysqli_num_rows($post_query) < 1) {
                    echo "<h1 class='blog'>No Post!! Come Back Later</h1>";
                  } else {

                  $view_count = "UPDATE post SET view_count = view_count + 1 WHERE id = $the_post_id ";
                  $send_view = mysqli_query($conn, $view_count);

                while ($Datarow = mysqli_fetch_assoc($post_query)) {
                       $post_id = $Datarow['id'];
                       $post_title = $Datarow['title'];
                       $post_author = $Datarow['author'];
                       $post_date = $Datarow['date'];
                       $post_image = $Datarow['image'];
                       $post_content = $Datarow['content'];

                     ?>
                    <?php Success_Message(); 
                    Error_Message() ?>
                    <img src="upload/<?php echo $post_image ?>" class="post" alt="">
                    <div class="row">
                      <div class="grid_5">
                        <h2><?php echo htmlentities($post_title); ?></h2>
                      </div>
                      <div class="grid_2 right">
                        <p>Published on <?php echo $post_date; ?> by <a href="Author?author=<?php echo $post_author; ?>&post=<?php echo $post_id; ?>" class="author"><?php echo $post_author;?></a> <span class="fa-comment"> <?php 

                        $Query = "SELECT * FROM comment WHERE post = $post_id";
                        $comment_view = mysqli_query($conn, $Query);
                        $viewcount = mysqli_num_rows($comment_view);
                        echo "$viewcount";
                        ?></span></p>
                      </div>
                    </div>
                    <p><?php echo $post_content; ?></p>
                    <hr>
                    <?php 
                    $query = "SELECT * FROM comment WHERE post = $the_post_id AND status = 'Approved' ORDER by id desc ";

                    $view_comment = mysqli_query($conn, $query);

                    if (!$view_comment) {
                      die('Query Falied' . mysqli_error($conn));
                    }

                    while ($row = mysqli_fetch_array($view_comment)) {
                      $author = $row['author'];
                      $date = $row['date'];
                      $comment = $row['comment'];

                      ?>

                      <div class="box_cnt__no-flow">

                        <h3><?php echo $author; ?> <small><?php echo $date; ?></small> </h3>

                        <p><?php echo $comment; ?></p>

                      </div>

                    <?php } ?>
                    <hr>
                    <h3>Leave a comment</h3>
                    <?php Comment_database ();?>
                    <form action="" method="POST" class="well1">
                      <div class="row">
                        <div class="grid_4 comment1">
                          <input type="text" name="author" placeholder="Full Name">
                        </div>
                        <div class="grid_4 comment2">
                          <input type="email" name="email" placeholder="Email">
                        </div>
                        <div class="grid_8 comment3">
                          <textarea name="content" id="" cols="60" rows="10" class="comment"></textarea>
                        </div>
                        <div class="grid_12">
                          <input type="submit" value="Comment" name="comment" class="btn postbo2">
                        </div>
                      </div>
                    </form>
                    <?php } }?>

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