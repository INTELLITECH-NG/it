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
                <img src="images/750x300.png" class="post" alt="">
                <div class="left">
                  <h2>Luching of New Software</h2>
                </div>
                <div class="right">
                  <p>Posted on January 1, 2017 by <a href="#">Admin </a></p>
                </div>
                <div class="clear"></div>
                <p>Lorem ipsum dolor sit amet conse ctetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatu. Lorem ipsum dolor sit amet conse ctetur adipisicing elit, sed do eiusmod tempor incididunt. Lorem ipsum dolor sit amet conse ctetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna.</p><a href="#" class="btn">Read more</a>
              </div>
              <div class="grid_4">
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