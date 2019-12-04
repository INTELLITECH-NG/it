<br/>
<br/>
<br/>
<div class="container">
	<div class="row">
		<div class="col-md-7 col-md-offset-2">


			<div class="box box-info">
				<div class="box-header with-border">
					<h3 class="box-title"><?= lang('forgot_password') ?></h3>
				</div>
				<!-- /.box-header -->
				<!-- form start -->
				<?php echo $form->open(); ?>
					<div class="box-body">

						<?php echo $form->messages(); ?>


						<div class="form-group">
							<label for="inputEmail3" class="col-sm-2 control-label"><?= lang('email') ?></label>

							<div class="col-sm-10">
								<input class="form-control" id="email" placeholder="<?= lang('email') ?>" type="email" name="email">
								<small>
									<?= lang('enter_valid_email_retrive_password') ?>
								</small>

							</div>
						</div>



					</div>
					<!-- /.box-body -->
					<div class="box-footer">
						<a href="<?php echo base_url('admin/login') ?>" class="btn btn-default"><?= lang('cancel') ?></a>
						<button type="submit" class="btn btn-info pull-right"><?= lang('submit') ?></button>
					</div>
					<!-- /.box-footer -->
				<?php echo $form->close(); ?>
			</div>


		</div>
	</div>
</div>





<?php //echo $form->bs3_email('Email'); ?>
<?php //echo $form->bs3_submit('Submit'); ?>

