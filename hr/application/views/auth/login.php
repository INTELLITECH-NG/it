
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
	<title>eOffice - Employee Login</title>

	<!-- Bootstrap -->
	<link href="<?php echo base_url(); ?>assets/css/bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo base_url(); ?>assets/css/login.css" rel="stylesheet" type="text/css" />
	<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css" type="text/css" />

</head>
<body>

<div class="top-content">

	<div class="inner-bg">
		<div class="container">
			<div class="row">
				<div class="col-sm-8 col-sm-offset-2 text">
					<h1><strong><?= lang('employee') ?></strong> <?= lang('login') ?></h1>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-6 col-sm-offset-3 form-box">
					<div class="form-top">
						<div class="form-top-left">
<!--							<h3>Login to our site</h3>-->
							<p><?= lang('enter_ur_username_pass_for_login') ?>:</p>
						</div>
						<div class="form-top-right">
							<i class="fa fa-lock"></i>
						</div>
					</div>
					<div class="form-bottom" >
						<?php echo $form->open(); ?>
						<?php echo $form->messages(); ?>
							<div class="form-group">
								<label class="sr-only" for="form-username"><?= lang('username') ?></label>
								<input type="text" name="username" placeholder="<?= lang('username') ?>..." class="form-username form-control" id="form-username">
							</div>
							<div class="form-group">
								<label class="sr-only" for="form-password"><?= lang('password') ?></label>
								<input type="password" name="password" placeholder="<?= lang('password') ?>..." class="form-password form-control" id="form-password">
							</div>
							<button type="submit" class="btn"><?= lang('log_in') ?>!</button>
						<?php echo $form->close(); ?>
					</div>
				</div>
			</div>

		</div>
	</div>

</div>

<?php //echo $form->open(); ?>
<!---->
<?php //echo $form->messages(); ?>
<!---->
<?php //echo $form->bs3_text('username','username'); ?>
<?php //echo $form->bs3_password('Password'); ?>
<!---->
<!--<div class="checkbox">-->
<!--	<label>-->
<!--		<input type="checkbox" name="remember"> Remember me-->
<!--	</label>-->
<!--</div>-->
<!--<div class="form-group">-->
<!--	Don't have Account? <a href="auth/sign_up">Sign Up</a>-->
<!--</div>-->
<!--<div class="form-group">-->
<!--	<a href="auth/forgot_password">Forgot password?</a>-->
<!--</div>-->
<?php //echo $form->bs3_submit('Login'); ?>
<!---->
<?php //echo $form->close(); ?>

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="<?php echo base_url(); ?>assets/js/jQuery-2.2.0.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/jquery.backstretch.min.js"></script>

<script>

	jQuery(document).ready(function() {

		/*
		 Fullscreen background
		 */
		$.backstretch("<?php echo base_url() ?>assets/loginBackground.jpg");

		/*
		 Form validation
		 */
		$('.login-form input[type="text"], .login-form input[type="password"], .login-form textarea').on('focus', function() {
			$(this).removeClass('input-error');
		});

		$('.login-form').on('submit', function(e) {

			$(this).find('input[type="text"], input[type="password"], textarea').each(function(){
				if( $(this).val() == "" ) {
					e.preventDefault();
					$(this).addClass('input-error');
				}
				else {
					$(this).removeClass('input-error');
				}
			});

		});


	});

</script>

</body>
</html>

