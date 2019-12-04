<div class="wrapper">
	<div class="container" style="background-color: #FFF">
		<div></div>
		<div class="row">
			<div class="col-md-12">
				<header id="header">

					<div class="slider" style="height: 400px; background-color: #F55E4A; background: url(<?php echo site_url(IMAGE.'desk.jpg') ?>) no-repeat" >
						<div class="text-center " style="padding-top: 10%">
							<span class="company"><?php echo get_option('company_name') ?></span>
						</div>

					</div><!--slider-->
					<?php $this->load->view('_partials/navbar'); ?>
				</header><!--/#HEADER-->
			</div>
		</div>

		<!--body Start-->
		<div class="row">
			<div class="col-md-12">
				<?php $this->load->view($inner_view); ?>
			</div>
		</div>
		<!--body End-->

		<!--footer Start-->
		<div class="footer">
			<div class="container">
				<?php if (ENVIRONMENT=='development'): ?>
					<p class="pull-right text-muted">
						CI Bootstrap Version: <strong><?php echo CI_BOOTSTRAP_VERSION; ?></strong>,
						CI Version: <strong><?php echo CI_VERSION; ?></strong>,
						Elapsed Time: <strong>{elapsed_time}</strong> seconds,
						Memory Usage: <strong>{memory_usage}</strong>
					</p>
				<?php endif; ?>
				<p class="text-muted"><?php echo get_option('company_name') ?> &copy; <strong><?php echo date('Y'); ?></strong> All rights reserved.</p>
			</div>
		</div>
		<!--footer End-->


	</div>
</div>







