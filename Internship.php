<?php $current = 'Services' ?>
<?php include('inc/database.php') ?>
<?php include('account/inc/fun.php') ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <title>Intenship</title>
  <meta charset="utf-8">
  <meta name="format-detection" content="telephone=no">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="INTELLITECH focus of services are IT Support, Web and Software Developing, Network Design as well as configuring of Servers, Training, Consult, providing maintenace of System's and Software">
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
  <link href="css/font-awesome.min.css" rel="stylesheet">
  <script src="js/jquery.js"></script>
  <script src="js/jquery-migrate-1.2.1.js"></script>
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
      <section class="well1 internbg">
        <div class="container">
          <div class="row">
            <div class="grid_6">
              <?php validate_intern($conn) ?>
              <form action="" method="POST" name="intern">
                <div class="row">
                  <div class="grid_3 comment1">
                    <input type="text" name="firstName" placeholder="First Name" required>
                  </div>
                  <div class="grid_3 comment2">
                    <input type="text" name="lastName" placeholder="Last Name" required>
                  </div>
                  <div class="grid_3 comment7">
                    <select name="track" id="" required>
                      <option value="" disabled selected>Preferred Track</option>
                      <option value="Backend Web Development">Backend Web Development</option>
                      <option value="Frontend Web Development">Frontend Web Development</option>
                      <option value="Mobile App Development">Mobile App Development</option>
                      <option value="Digital Marketing">Digital Marketing</option>
                      <option value="UI/UX Design">UI/UX Design</option>
                    </select>
                  </div>
                  <div class="grid_3 comment8">
                    <select name="level" id="" required>
                      <option value="" disabled selected>Level</option>
                      <option value="Beginner">Beginner</option>
                      <option value="Intermediate">Intermediate</option>
                      <option value="Advanced">Advanced</option>
                    </select>
                  </div>
                  <div class="grid_6 comment9">
                    <input type="email" name="email" placeholder="Email:" required>
                  </div>
                  <div class="grid_6 comment44">
                    <input type="submit" name="internship" value="REGISTER">
                  </div>
                </div>
              </form>
            </div>
            <div class="grid_6 intern">
              <div pad>
                <h4>Are you looking to get into Tech?</h4>
                <p style="text-align: center">join INTELLITECH.NG internship is free</p>
                <p>Learn the best practices in the tech world from the best facilitators around.</p>
                <p>Learning is the easiest when you are in a group of like-minded techies aiming at the same target.</p>
                <p>Get into our pool of verified and selected freelancers with first dibs on the very best freelancing opportunities around.</p>
                <div class="row off4">
                  <div class="grid_6">
                    <div class="row">
                      <ul class="marked-list wow fadeInRight grid_3">
                        <li><a href="#">UI/UX Design</a></li>
                        <li><a href="#">Backend Web Development</a></li>
                        <li><a href="#">Mobile App Development</a></li>
                      </ul>
                      <ul class="marked-list wow fadeInRight grid_3">
                        <li><a href="#">Digital Marketing</a></li>
                        <li><a href="#">Frontend Web Development</a></li>
                      </ul>
                    </div>
                  </div>
                </div>
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
      <?php include 'footer.php'; ?>
    </footer>
  </div>
  <script src="js/script.js"></script>
</body>

</html>