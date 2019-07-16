        <div class="container">
          <div class="brand">
            <h1 class="brand_name"><a href="./">INTELLITECH</a></h1>
            <p class="slogan"><span class="sl">CONFIGURE</span> | <span class="sl">CREATE</span> | <span class="sl">INNOVATE</span></p>
          </div>
        </div>
        <div id="stuck_container" class="stuck_container">
          <div class="container">
            <nav class="nav">
              <ul data-type="navbar" class="sf-menu">
                <li <?php if($current == 'Home') {echo 'class="active"';} ?>><a href="./">HOME</a></li>
                <li <?php if($current == 'Services') {echo 'class="active"';} ?>><a href="Services">SERVICES</a>
                  <ul>
                    <li <?php if($current == 'Services') {echo 'class="active"';} ?>><a href="Maintenance">MAINTENENCE</a></li>
                    <li <?php if($current == 'Services') {echo 'class="active"';} ?>><a href="Training">TRAINING</a></li>
                    <li <?php if($current == 'Services') {echo 'class="active"';} ?>><a href="Consultancy">CONSULTANCY</a></li>
                    <li <?php if($current == 'Services') {echo 'class="active"';} ?>><a href="Sales">SALES</a></li>
                    <li <?php if($current == 'Services') {echo 'class="active"';} ?>><a href="Network">NETWORK DESIGN</a>
                      <ul>
                        <li <?php if($current == 'Services') {echo 'class="active"';} ?>><a href="Security">SECURITY</a></li>
                      </ul>
                    </li>
                    <li <?php if($current == 'Services') {echo 'class="active"';} ?>><a href="Web">WEB &#38; SOFTWARE DEVELOPMENT</a></li>
                  </ul>
                  <li <?php if($current == 'Product') {echo 'class="active"';} ?>><a href="">PRODUCT</a></li>
                </li>
                <li <?php if($current == 'Blog') {echo 'class="active"';} ?>><a href="Blog">BLOG</a></li>
                <li <?php if($current == 'About') {echo 'class="active"';} ?>><a href="About">ABOUT</a></li>
                <li <?php if($current == 'Contacts') {echo 'class="active"';} ?>><a href="Contacts">CONTACTS</a></li>
              </ul>
              <?php include('social.php') ?>
            </nav>
          </div>
        </div>