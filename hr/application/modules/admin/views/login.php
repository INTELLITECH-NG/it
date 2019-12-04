<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Login Form</title>
    <link href="<?php echo base_url(); ?>assets/css/adminLogin.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="//maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css">


</head>

<body>
<!-- start site-wrapper -->
<div class="site-wrapper">

    <!-- start site-wrapper-inner -->
    <div class="site-wrapper-inner clearfix">

        <!-- start cover-container -->
        <div class="cover-container container">

            <!-- start inner cover -->
            <div class="inner cover clearfix">
                <div class="col-xs-12 col-sm-6 intro-cont">
                    <?php $logo = get_option('login_logo')?>
                    <?php $title = get_option('login_title')?>
                    <?php $description = get_option('login_description')?>
                <span>
                    <?php if(empty($logo)){ ?>
                        <img class="img-responsive" src="<?php echo base_url('assets/img/eoffice_logo_w.png') ?>">
                    <?php }else{ ?>
                        <img class="img-responsive" src="<?php echo site_url(UPLOAD_LOGO.$logo)?>" width="250" height="200">
                    <?php } ?>
                </span>
                    <?php if(empty($title)){ ?>
                        <h1 class="page-intro">Ultimate HRM & Accounts Features </h1>
                    <?php }else{ ?>
                        <h1 class="page-intro"><?= $title ?> </h1>
                    <?php } ?>

                    <?php if(empty($description)){ ?>
                        <p>eOffice is an office management software where you can easily manage your Employee, Accounts, Business Transaction, Manage product, customer, Vendor, Sales and Purchase etc.</p>
                    <?php }else{ ?>
                        <p><?= $description ?></p>
                    <?php } ?>


                </div>
                <div class="col-xs-12 col-sm-5 col-sm-offset-1 sign-in-outer">
                  <div class="sign-in-wrap">
                  <h2 class="form-heading"><?= lang('sign_in') ?></h2>
                        <?php echo $form->open(); ?>
                        <?php echo $form->messages(); ?>
                      <div class="input-group">
                        <i class="fa fa-user" aria-hidden="true"></i>
                        <input tabindex="1" class="form-control input-lg" name="email" type="text" size="30" maxlength="100" title="Email" placeholder="User" value="">
                      </div>
                           <div class="input-group">
                             <i class="fa fa-lock" aria-hidden="true"></i>
                      <input tabindex="1" class="form-control input-lg" name="password" type="password" size="30" maxlength="100" title="Password" placeholder="password" value="">
                      </div>
                            <input class="btn" type="submit" value="Log In" title="<?= lang('log_in') ?>" tabindex="3">

                        <a class="reset" tabindex="4" href="<?php echo base_url('admin/auth/forgot_password') ?>"><?= lang('forgot_password') ?> ?</a>
                      <?php echo $form->close(); ?>
                   <!--  </form> -->
                  </div>
                  
                </div>
            </div>
            <!-- end inner cover -->

        </div>
        <!-- end cover-container -->

    </div>
    <!-- end site-wrapper-inner -->

</div>
<!-- end site-wrapper -->


</body>
</html>