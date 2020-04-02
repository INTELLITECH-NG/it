<?php $current = 'Error' ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <title>Error Page</title>
  <meta charset="utf-8">
  <meta name="format-detection" content="telephone=no">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="INTELLITECH offer Systems Maintenance, Software Maintenance, Servers Maintenance and Database Management ">
  <meta name="keywords" content="INTELLITECH TECHNOLOGIES">
  <meta name="google-site-verification" content="UwlPsbLaXsUOVDTWl3srWXNaOXWQfKPEDJW0eT-TVpw" />
  <meta name="author" content="Bright Robert">
  <meta name="Copyright" content="Intellitech Technologies">
  <meta name="country" content="Nigeria">
  <meta name="city" content="Port Harcourt, Nigeria">
  <meta name="zipcode" content="500272">
  <link rel="icon" href="images/favicon.png" type="image/x-icon">
  <link rel="stylesheet" href="css/grid.css">
  <link rel="stylesheet" href="css/style.css">
  <script src="js/jquery.js"></script>
  <script src="js/jquery-migrate-1.2.1.js"></script>
  <script src="js/sweetalert2.all.min.js"></script>
  <!--[if lt IE 9]>
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
      <?php include('head.php') ?>
    </header>
    <!--
      ========================================================
                                  CONTENT
      ========================================================
      -->
    <main>
      <section class="container">
        <div class="row well1">
          <div class="grid_8">
            <h1 class="error well1">Oops!</h1>
            <p error>We can't seem to find the page you're looking for.</p>
          </div>
          <div class="grid_4"><img src="images/error.gif" alt=""></div>
        </div>
      </section>
    </main>
    <!--
      ========================================================
                                  FOOTER
      ========================================================
      -->
    <footer>
      <?php include 'footer.php'; ?>
    </footer>
  </div>
  <script src="js/script.js"></script>
</body>

</html>