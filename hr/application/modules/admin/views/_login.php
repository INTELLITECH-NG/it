<link href="<?php echo base_url(); ?>assets/css/adminLogin.css" rel="stylesheet" type="text/css" />

<div class="top-content">

	<div class="inner-bg" >
		<div class="container">
			<div class="row">
				<div class="col-sm-8 col-sm-offset-2 text">
					<h1><strong><?= lang('admin') ?></strong> <?= lang('login_form') ?></h1>

				</div>
			</div>
			<div class="row">
				<div class="col-sm-6 col-sm-offset-3 form-box">
					<div class="form-top">
						<div class="form-top-left">
							<p><?= lang('enter_your_username_and_password_to_log_on') ?>:</p>
						</div>
						<div class="form-top-right">
							<i class="fa fa-key"></i>
						</div>
					</div>
					<div class="form-bottom">
						<?php echo $form->open(); ?>
									<?php echo $form->messages(); ?>
							<div class="form-group">
								<label class="sr-only" for="form-username"><?= lang('username') ?></label>
								<input name="email" id="email" placeholder="<?= lang('username') ?>" class="form-control input-lg" type="text">
							</div>
							<div class="form-group">
								<label class="sr-only" for="form-password"><?= lang('password') ?></label>
								<input name="password"  id="password" placeholder="<?= lang('password') ?>" class="form-control input-lg" type="password">
							</div>

						<div class="row">
							<div class="col-xs-8">
								<div class="checkbox">
									<label><input type="checkbox" name="remember"><?= lang('remember_me') ?></label>
								</div>
							</div>
							<div class="col-xs-4">
								<a href="<?php echo base_url('admin/auth/forgot_password') ?>">Forgot Password</a>
							</div>
						</div>
							<button type="submit" class="btn"><?= lang('sign_in') ?>!</button>
						<?php echo $form->close(); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<!--<div class="login-box">-->
<!---->
<!--	<div class="login-logo"><b>--><?php //echo $site_name; ?><!--</b></div>-->
<!---->
<!--	<div class="login-box-body">-->
<!--		<p class="login-box-msg">Sign in to start your session</p>-->
<!--		--><?php //echo $form->open(); ?>
<!--			--><?php //echo $form->messages(); ?>
<!--			--><?php //echo $form->bs3_text('Email', 'email', ENVIRONMENT==='development' ? 'admin@admin.com' : ''); ?>
<!--			--><?php //echo $form->bs3_password('Password', 'password', ENVIRONMENT==='development' ? 'admin' : ''); ?>
<!--			<div class="row">-->
<!--				<div class="col-xs-8">-->
<!--					<div class="checkbox">-->
<!--						<label><input type="checkbox" name="remember"> Remember Me</label>-->
<!--					</div>-->
<!--				</div>-->
<!--				<div class="col-xs-4">-->
<!--					--><?php //echo $form->bs3_submit('Sign In', 'btn btn-primary btn-block btn-flat'); ?>
<!--				</div>-->
<!--			</div>-->
<!--		--><?php //echo $form->close(); ?>
<!--	</div>-->
<!---->
<!--</div>-->

<!--<script>-->
<!--	$(function(){-->
<!--		$('body').css('background-color', '#00a7d0');-->
<!--	});-->
<!--</script>-->