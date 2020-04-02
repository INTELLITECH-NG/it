<?php $current = 'Contacts' ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <title>Contacts</title>
  <meta charset="utf-8">
  <meta name="format-detection" content="telephone=no">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="images/favicon.png" type="image/x-icon">
  <link rel="stylesheet" href="css/grid.css">
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/google-map.css">
  <link rel="stylesheet" href="css/mailform.css">
  <link href="css/font-awesome.min.css" rel="stylesheet">
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
      <!-- <section class="map">
        <div id="google" class="map_model"></div>
        <ul class="map_locations">
          <li data-x="7.047150" data-y="4.808417">
            <p> Port Harcourt, Nigeria. <span>+234-080-6701-3794</span></p>
          </li>
        </ul>
      </section> -->
      <section class="">
        <iframe width="1400" height="460" id="gmap_canvas" src="https://maps.google.com/maps?q=Port%20Harcourt%20500211%2C%20Rivers%2C%20Nigeria&t=&z=13&ie=UTF8&iwloc=&output=embed" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe>
      </section>
      <section class="well1">
        <div class="container">
          <?php Contact() ?>
          <h2>Contact Us</h2>
          <form action="" method="POST" class="well1">
            <div class="row">
              <div class="grid_6 comment1">
                <input type="text" name="name" placeholder="Your Name:" required>
              </div>
              <div class="grid_6 comment2">
                <input type="email" name="email" placeholder="Email:" required>
              </div>
              <div class="grid_12 comment4">
                <input type="text" name="subject" placeholder="Subject:" required>
              </div>
              <div class="grid_12 comment3">
                <textarea name="message" id="" cols="60" rows="10" class="comment" placeholder="Meaasage:" required></textarea>
              </div>
              <div class="grid_12 mfControls">
                <input type="submit" value="Messenger" name="contact" class="btn">
              </div>
            </div>
          </form>
        </div>
      </section>
      <section class="well3 bg-secondary">
        <div class="container">
          <ul class="row contact-list">
            <li class="grid_4">
              <div class="box">
                <div class="box_aside">
                  <div class="icon2 fa-map-marker"></div>
                </div>
                <div class="box_cnt__no-flow">
                  <address>Trans Amadi, Port Harcourt<br /> Nigeria</address>
                </div>
              </div>
            </li>
            <li class="grid_4">
              <div class="box">
                <div class="box_aside">
                  <div class="icon2 fa-phone"></div>
                </div>
                <div class="box_cnt__no-flow"><a href="callto:+2348090224422">+2348090224422</a></div>
              </div>
            </li>
            <li class="grid_4">
              <div class="box">
                <div class="box_aside">
                  <div class="icon2 fa-envelope"></div>
                </div>
                <div class="box_cnt__no-flow"><a href="mailto:info@intellitech.ng">info@intellitech.ng</a></div>
              </div>
            </li>
          </ul>
          <hr class="down">
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