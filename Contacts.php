<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Contacts</title>
    <meta charset="utf-8">
    <meta name="format-detection" content="telephone=no">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="images/favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="css/grid.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/google-map.css">
    <link rel="stylesheet" href="css/mailform.css">
	<link href="css/font-awesome.min.css" rel="stylesheet">
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
        <div class="container">
          <div class="brand">
            <h1 class="brand_name"><a href="./">INTELLITECH</a></h1><sup>&#174;</sup>
            <p class="slogan">CONFIGURE | CREATE | INNOVATE</p>
          </div>
        </div>
        <div id="stuck_container" class="stuck_container">
          <div class="container">
<nav class="nav">
  <ul data-type="navbar" class="sf-menu">
    <li><a href="./">Home</a></li>
    <li><a href="Services">Services</a>
      <ul>
        <li><a href="Maintenance">MAINTENENCE</a></li>
        <li><a href="Training">TRAINING</a></li>
        <li><a href="Consultancy">CONSULTANCY</a></li>
        <li><a href="Sales">SALES</a></li>
        <li><a href="Network">NETWORK DESIGN</a>
          <ul>
            <li><a href="Security">SECURITY</a></li>
          </ul>
        </li>
        <li><a href="Web">WEB &#38; SOFTWARE DEVELOPMENT</a></li>
      </ul>
    </li>
    <li><a href="About">About</a></li>
    <li class="active"><a href="Contacts">Contacts</a></li>
  </ul>
  <div class="sf-menu so">
    <div class="social">
      <a href=""><i class="fa fa-facebook" aria-hidden="true"></i></a>
    </div>
    <div class="social">
      <a href=""><i class="fa fa-twitter" aria-hidden="true"></i></a>
    </div>
    <div class="social">
      <a href=""><i class="fa fa-google-plus" aria-hidden="true"></i></a>
    </div> 
    <div class="social">
      <a href=""><i class="fa fa-youtube-play" aria-hidden="true"></i></a>
    </div>    
    <div class="social">
      <a href="" target="_blank"><i class="fa fa-instagram" aria-hidden="true"></i></a>
    </div>    
    <div class="social">
      <a href=""><i class="fa fa-linkedin" aria-hidden="true"></i></a>
    </div>
  </div>
</nav>
          </div>
        </div>
      </header>
      <!--
      ========================================================
                                  CONTENT
      ========================================================
      -->
      <main>
        <section class="map">
          <div id="google-map" class="map_model"></div>
          <ul class="map_locations">
            <li data-x="7.047150" data-y="4.808417">
              <p> Port Harcourt, Nigeria. <span>+234-080-6701-3794</span></p>
            </li>
          </ul>
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
                    <address>Trans Amadi, Port Harcourt<br/> Nigeria</address>
                  </div>
                </div>
                <div class="box">
                  <div class="box_aside">
                    <div class="icon2 fa-envelope"></div>
                  </div>
                  <div class="box_cnt__no-flow"><a href="mailto:#">info@intellitech.ng</a></div>
                </div>
              </li>
              <li class="grid_4">
                <div class="box">
                  <div class="box_aside">
                    <div class="icon2 fa-phone"></div>
                  </div>
                  <div class="box_cnt__no-flow"><a href="callto:#">+234-080-6701-3794</a></div>
                </div>
                <div class="box">
                  <div class="box_aside">
                    <div class="icon2 fa-fax"></div>
                  </div>
                  <div class="box_cnt__no-flow"><a href="callto:#">+234-080-6701-3794</a></div>
                </div>
              </li>
              <li class="grid_4">
                <div class="box">
                  <div class="box_aside">
                    <div class="icon2 fa-facebook"></div>
                  </div>
                  <div class="box_cnt__no-flow"><a href="#">Follow on facebook</a></div>
                </div>
                <div class="box">
                  <div class="box_aside">
                    <div class="icon2 fa-twitter"></div>
                  </div>
                  <div class="box_cnt__no-flow"><a href="#">Follow on Twitter</a></div>
                </div>
              </li>
            </ul>
          </div>
        </section>
        <section class="well1">
          <div class="container">
            <h2>Feedback</h2>
            <form method="post" action="bat/rd-mailform.php" class="mailform off2">
              <input type="hidden" name="form-type" value="contact">
              <fieldset class="row">
                <label class="grid_4">
                  <input type="text" name="name" placeholder="Your Name:" data-constraints="@LettersOnly @NotEmpty">
                </label>
                <label class="grid_4">
                  <input type="text" name="phone" placeholder="Telephone:" data-constraints="@Phone">
                </label>
                <label class="grid_4">
                  <input type="text" name="email" placeholder="Email:" data-constraints="@Email @NotEmpty">
                </label>
                <label class="grid_12">
                  <textarea name="message" placeholder="Message:" data-constraints="@NotEmpty"></textarea>
                </label>
                <div class="mfControls grid_12">
                  <button type="submit" class="btn">Sumbit comment</button>
                </div>
              </fieldset>
            </form>
          </div>
        </section>
      </main>
      <!--
      ========================================================
                                  FOOTER
      ========================================================
      -->
      <footer>
        <section>
          <div class="container">
            <div class="copyright">INTELLITECH © <span id="copyright-year"></span>
            </div>
          </div>
        </section>
      </footer>
    </div>
    <script src="js/script.js"></script>
  </body>
</html>