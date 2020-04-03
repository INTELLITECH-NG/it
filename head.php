        <?php include('inc/database.php') ?>
        <?php include('account/inc/fun.php') ?>
        <div class="container">
          <div class="brand">
            <h1 class="brand_name"><a href="./">INTELLITECH</a></h1>
            <p class="slogan"><span class="sl">CONFIGURE</span> | <span class="sl">CREATE</span> | <span class="sl">INNOVATE</span></p>
          </div>
          <button class="btn quote" onclick="document.getElementById('id01').style.display='block'">GET A QUOTE</button>
          <p>One of our representatives will happily contact you within 24 hours.</p>
        </div>
        <link rel="stylesheet" href="css/w3.css">
        <!-- Modal that pops up when you click on "New Message" -->
        <div id="id01" class="w3-modal" style="z-index:4">
          <div class="w3-modal-content w3-animate-opacity">
            <div class="w3-container w3-padding w3-teal">
              <span onclick="document.getElementById('id01').style.display='none'" class="w3-button w3-display-topright">&times;</span>
              <h2 style="color: #fff">Get a Quote</h2>
            </div>
            <div class="w3-panel">
              <?php getQuote(); ?>
              <form action="" method="POST">
                <label>Full Name</label>
                <input class="w3-input w3-margin-bottom" type="text" placeholder="Full Name" name="fullname" require>
                <div class="w3-row">
                  <div class="w3-col s6 w3-center section">
                    <label>Phone Number</label>
                    <input class="w3-input w3-margin-bottom" type="number" placeholder="Phone Number" name="pnum" require>
                  </div>
                  <div class="w3-col s6 w3-center section">
                    <label>Email Address</label>
                    <input class="w3-input w3-margin-bottom" type="email" placeholder="Email Address" name="email" require>
                  </div>
                </div>
                <div class="w3-section">
                  <select class="w3-select" name="service" require>
                    <option value="" disabled selected>Choose a services</option>
                    <option value="Website Design and Development">Website Design and Development</option>
                    <option value="App Design and Development">App Design and Development</option>
                    <option value="IT Support">IT Support</option>
                    <option value="IT Consulting">IT Consulting</option>
                    <option value="Product">Product</option>
                    <option value="Networking">Networking</option>
                    <option value="Others">Others</option>
                  </select>
                </div>
                <label>Subject</label>
                <textarea name="subject" id="" cols="30" rows="10" class="w3-input w3-margin-bottom" placeholder="Tell us about your business" require></textarea>
                <div class="w3-section">
                  <input type="submit" class="w3-btn w3-blue" value="Get Quote" name="quote">
                </div>
              </form>
            </div>
          </div>
        </div>
        <div id="stuck_container" class="stuck_container">
          <div class="container">
            <nav class="nav">
              <ul data-type="navbar" class="sf-menu">
                <li <?php if ($current == 'Home') {
                      echo 'class="active"';
                    } ?>><a href="./">HOME</a></li>
                <li <?php if ($current == 'Services') {
                      echo 'class="active"';
                    } ?>><a href="Services">SERVICES</a>
                  <ul>
                    <li <?php if ($current == 'Services') {
                          echo 'class="active"';
                        } ?>><a href="Maintenance">MAINTENENCE</a></li>
                    <li <?php if ($current == 'Services') {
                          echo 'class="active"';
                        } ?>><a href="Training">TRAINING</a></li>
                    <li <?php if ($current == 'Services') {
                          echo 'class="active"';
                        } ?>><a href="Consultancy">CONSULTANCY</a></li>
                    <li <?php if ($current == 'Services') {
                          echo 'class="active"';
                        } ?>><a href="Sales">SALES</a></li>
                    <li <?php if ($current == 'Services') {
                          echo 'class="active"';
                        } ?>><a href="Network">NETWORK</a>
                      <ul>
                        <li <?php if ($current == 'Services') {
                              echo 'class="active"';
                            } ?>><a href="Security">SECURITY</a></li>
                      </ul>
                    </li>
                    <li <?php if ($current == 'Services') {
                          echo 'class="active"';
                        } ?>><a href="Software">SOFTWARE DEVELOPMENT</a></li>
                  </ul>
                <li <?php if ($current == 'Product') {
                      echo 'class="active"';
                    } ?>><a href="Product">PRODUCT</a></li>
                </li>
                <li <?php if ($current == 'Blog') {
                      echo 'class="active"';
                    } ?>><a href="Blog">BLOG</a></li>
                <li <?php if ($current == 'About') {
                      echo 'class="active"';
                    } ?>><a href="About">ABOUT</a></li>
                <li <?php if ($current == 'Contacts') {
                      echo 'class="active"';
                    } ?>><a href="Contacts">CONTACTS</a></li>
              </ul>
              <?php include('social.php') ?>
            </nav>
          </div>
        </div>