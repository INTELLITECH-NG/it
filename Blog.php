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
          <div class="container">
            <div class="row">
              <!-- Blog Entries Column -->
              <div class="col-md-8">
                <h1 class="my-4">Page Heading
                  <small>Secondary Text</small>
                </h1>
                <!-- Blog Post -->
                <div class="card mb-4">
                  <img class="card-img-top" src="http://placehold.it/750x300" alt="Card image cap">
                  <div class="card-body">
                    <h2 class="card-title">Post Title</h2>
                    <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Reiciendis aliquid atque, nulla? Quos cum ex quis soluta, a laboriosam. Dicta expedita corporis animi vero voluptate voluptatibus possimus, veniam magni quis!</p>
                    <a href="#" class="btn btn-primary">Read More &rarr;</a>
                  </div>
                  <div class="card-footer text-muted">
                    <p>Posted on January 1, 2017 by</p>
                    <a href="#">Start Bootstrap</a>
                  </div>
                </div>
                <!-- Blog Post -->
                <div class="card mb-4">
                  <img class="card-img-top" src="http://placehold.it/750x300" alt="Card image cap">
                  <div class="card-body">
                    <h2 class="card-title">Post Title</h2>
                    <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Reiciendis aliquid atque, nulla? Quos cum ex quis soluta, a laboriosam. Dicta expedita corporis animi vero voluptate voluptatibus possimus, veniam magni quis!</p>
                    <a href="#" class="btn btn-primary">Read More &rarr;</a>
                  </div>
                  <div class="card-footer text-muted">
                    <p>Posted on January 1, 2017 by</p>
                    <a href="#">Start Bootstrap</a>
                  </div>
                </div>
                <!-- Blog Post -->
                <div class="card mb-4">
                  <img class="card-img-top" src="http://placehold.it/750x300" alt="Card image cap">
                  <div class="card-body">
                    <h2 class="card-title">Post Title</h2>
                    <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Reiciendis aliquid atque, nulla? Quos cum ex quis soluta, a laboriosam. Dicta expedita corporis animi vero voluptate voluptatibus possimus, veniam magni quis!</p>
                    <a href="#" class="btn btn-primary">Read More &rarr;</a>
                  </div>
                  <div class="card-footer text-muted">
                    <p>Posted on January 1, 2017 by</p>
                    <a href="#">Start Bootstrap</a>
                  </div>
                </div>
                <!-- Pagination -->
                <ul class="pagination justify-content-center mb-4">
                  <li class="page-item">
                    <a class="page-link" href="#">&larr; Older</a>
                  </li>
                  <li class="page-item disabled">
                    <a class="page-link" href="#">Newer &rarr;</a>
                  </li>
                </ul>
              </div>
              <!-- Sidebar Widgets Column -->
              <div class="col-md-4">
                <!-- Search Widget -->
                <div class="card my-4">
                  <h5 class="card-header">Search</h5>
                  <div class="card-body">
                    <div class="input-group">
                      <input type="text" class="form-control" placeholder="Search for...">
                      <span class="input-group-btn">
                        <button class="btn btn-secondary" type="button">Go!</button>
                      </span>
                    </div>
                  </div>
                </div>
                <!-- Categories Widget -->
                <div class="card my-4">
                  <h5 class="card-header">Categories</h5>
                  <div class="card-body">
                    <div class="row">
                      <div class="col-lg-6">
                        <ul class="list-unstyled mb-0">
                          <li><a href="#">Web Design</a></li>
                          <li><a href="#">HTML</a></li>
                          <li><a href="#">Freebies</a></li>
                        </ul>
                      </div>
                      <div class="col-lg-6">
                        <ul class="list-unstyled mb-0">
                          <li><a href="#">JavaScript</a></li>
                          <li><a href="#">CSS</a></li>
                          <li><a href="#">Tutorials</a></li>
                        </ul>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- Side Widget -->
                <div class="card my-4">
                  <h5 class="card-header">Side Widget</h5>
                  <div class="card-body">
                    <p>You can put anything you want inside of these side widgets. They are easy to use, and feature the new Bootstrap 4 card containers!</p>
                  </div>
                </div>
              </div>
            </div>
            <!-- /.row -->
          </div>
          <!-- /.container -->
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