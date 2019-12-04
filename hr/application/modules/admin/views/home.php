
<script src="<?php echo site_url('assets/js/calander.js') ?>"></script>
<!--<script src="--><?php //echo site_url('assets/plugin/datetimepicker/bootstrap-datetimepicker.min.js') ?><!--"></script>-->
<!--<link rel="stylesheet" href="--><?php //echo site_url('assets/plugin/datetimepicker/bootstrap-datetimepicker.min.css') ?><!--">-->

<?php if($this->ion_auth->in_group(array('admin','accounts'))){ ?>
<div class="row dashboard-wrap">

    <div class="col-sm-6 col-lg-3">
        <a class="block block-rounded block-link-hover2 text-center" href="javascript:void(0)">
            <div class="block-content block-content-full bg-success">
                <div class="h2 font-w700 text-white"><span
                            class="h2 text-white-op"><?= get_option('currency_symbol') ?></span> <?php echo $this->localization->currencyFormat($this_year->income) ?>
                </div>
                <div class="h6 text-white-op text-uppercase push-5-t"><?= lang('this_year') ?><?php echo date("Y") ?></div>
            </div>
            <div class="block-content block-content-full block-content-mini">
                <i class="fa fa-plus text-success" aria-hidden="true"></i> <?= lang('total_income') ?>
            </div>
        </a>
    </div>
    <div class="col-sm-6 col-lg-3">
        <a class="block block-rounded block-link-hover2 text-center" href="javascript:void(0)">
            <div class="block-content block-content-full bg-warning">
                <div class="h2 font-w700 text-white"><span
                            class="h2 text-white-op"><?= get_option('currency_symbol') ?></span> <?php echo $this->localization->currencyFormat($this_year->expense) ?>
                </div>
                <div class="h6 text-white-op text-uppercase push-5-t"><?= lang('this_year') ?><?php echo date("Y") ?></div>
            </div>
            <div class="block-content block-content-full block-content-mini">
                <i class="fa fa-minus text-warning" aria-hidden="true"></i> <?= lang('total_expense') ?>
            </div>
        </a>
    </div>
    <div class="col-sm-6 col-lg-3">
        <a class="block block-rounded block-link-hover2 text-center" href="javascript:void(0)">
            <div class="block-content block-content-full bg-danger">
                <div class="h2 font-w700 text-white"><span
                            class="h2 text-white-op"><?= get_option('currency_symbol') ?></span> <?php echo $this->localization->currencyFormat($this_year->receivable) ?>
                </div>
                <div class="h6 text-white-op text-uppercase push-5-t"><?= lang('this_year') ?><?php echo date("Y") ?></div>
            </div>
            <div class="block-content block-content-full block-content-mini">
                <i class="fa fa-plus text-danger" aria-hidden="true"></i> <?= lang('total_a_r') ?>
            </div>
        </a>
    </div>
    <div class="col-sm-6 col-lg-3">
        <a class="block block-rounded block-link-hover2 text-center" href="javascript:void(0)">
            <div class="block-content block-content-full bg-purple">
                <div class="h2 font-w700 text-white"><span
                            class="h2 text-white-op"><?= get_option('currency_symbol') ?></span> <?php echo $this->localization->currencyFormat($this_year->payable) ?>
                </div>
                <div class="h6 text-white-op text-uppercase push-5-t"><?= lang('this_year') ?><?php echo date("Y") ?></div>
            </div>
            <div class="block-content block-content-full block-content-mini">
                <i class="fa fa-minus" aria-hidden="true"></i> <?= lang('total_a_p') ?>
            </div>
        </a>
    </div>

<!-- END BLOCKS -->	
</div>

<div class="row dashboard-wrap">
	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="portlet"><!-- /primary heading -->
			<div class="portlet-heading box-header with-border">
				<h3 class="portlet-title text-dark text-uppercase">
					<?= lang('cash_flow_this_year') ?> <?php echo date('Y') ?>
				</h3>
			</div>
			<div id="portlet1" class="panel-collapse collapse in">
				<div class="portlet-body chart-responsive">

					<div class="chart" id="line-chart" style="height: 300px;"></div>

					<div class="row text-center m-t-30 m-b-30 chart-table">
						<div class="col-md-3 col-sm-6 col-xs-12">
							<h4>
								<?php echo $this->localization->currencyFormat($this_month->income)?>
							</h4>
							<small class="text-muted"><?= lang('this_month_income') ?></small>
						</div>
						<div class="col-md-3 col-sm-6 col-xs-12">
							<h4>
								<?php echo $this->localization->currencyFormat($this_month->expense)?>
							</h4>
							<small class="text-muted"><?= lang('this_month_expense') ?></small>
						</div>
						<div class="col-md-3 col-sm-6 col-xs-12">
							<h4>
								<?php echo $this->localization->currencyFormat($this_month->ar)?>
							</h4>
							<small class="text-muted"><?= lang('this_month_ar') ?></small>
						</div>
						<div class="col-md-3 col-sm-6 col-xs-12">

							<h4>
								<?php echo $this->localization->currencyFormat($this_month->ap)?>
							</h4>
							<small class="text-muted"><?= lang('this_month_ap') ?></small>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- /Portlet -->

	</div>
	<!-- end col -->




	<div class="col-md-6">
		<div class="portlet"><!-- /primary heading -->
			<div class="portlet-heading box-header with-border">
				<h3 class="portlet-title text-dark text-uppercase">
					<?= lang('account_balance') ?>
				</h3>
			</div>
			<div id="portlet2" class="panel-collapse collapse in">
				<div class="portlet-body" style="height: 450px">
					<div class="table-responsive">
						<table class="table no-margin">
							<thead>
							<tr>
								<th><?= lang('name') ?></th>
								<th><?= lang('balance') ?></th>
							</tr>
							</thead>
							<tbody>
							<?php $account_balance = 0 ?>
							<?php foreach($account_head as $item) { ?>

								<tr>
									<td>
										<a href="<?php echo site_url('admin/transaction/viewTransaction/'. str_replace(array('+', '/', '='), array('-', '_', '~'), $this->encrypt->encode('account-'.$item->id))) ?>">
											<?php echo $item->account_title ?>
										</a>
									</td>
									<td>
										<?php echo $this->localization->currencyFormat($item->balance) ?>
									</td>
									<?php $account_balance += $item->balance ?>
								</tr>
							<?php } ?>
							<tr>
								<td><?= lang('balance') ?></td>
								<td><strong><?php echo get_option('default_currency').' '.$this->localization->currencyFormat($account_balance) ?></strong></td>
							</tr>

							</tbody>
						</table>
					</div><!-- /.table-responsive -->
				</div>
			</div>
		</div>
	</div>



	<div class="col-md-6 col-sm-12 col-xs-12">
		<div class="portlet"><!-- /primary heading -->
			<div class="portlet-heading box-header with-border">
				<h3 class="portlet-title text-dark text-uppercase">
					<?= lang('income_vs_expense') ?> <strong><?php echo date('Y') ?></strong>
				</h3>
			</div>
			<div id="portlet2" class="panel-collapse collapse in">
				<div class="portlet-body" style="">


					<div class="box-body chart-responsive">
						<div class="chart" id="sales-chart" style="height: 300px; position: relative;"></div>


						<div class="row text-center m-t-30 m-b-30 chart-table">
							<div class="col-sm-6 col-xs-12">
								<h4> <?php echo get_option('default_currency').' '. $this->localization->currencyFormat($this_year->income) ?>  </h4>
								<small class="text-muted"><?= lang('income_this_year') ?></small>
							</div>
							<div class="col-sm-6 col-xs-12">
								<h4> <?php echo get_option('default_currency').' '.$this->localization->currencyFormat( $this_year->expense) ?>  </h4>
								<small class="text-muted"></small>
							</div>

						</div>


					</div>

				</div>
			</div>
		</div>
	</div>
</div>







<div class="row dashboard-wrap">

		<div class="col-md-12">
			<div class="portlet"><!-- /primary heading -->
				<div class="portlet-heading box-header with-border">
					<h3 class="portlet-title text-dark text-uppercase">
						<?= lang('last_ten_transactions') ?>
					</h3>
				</div>
				<div id="portlet2" class="panel-collapse collapse in">
					<div class="portlet-body" style="height: 450px">
						<div class="table-responsive">
							<table class="table no-margin">
								<thead>
								<tr>
									<th><?= lang('trns_id') ?></th>
									<th><?= lang('account') ?></th>
									<th><?= lang('transaction_type') ?></th>
									<th><?= lang('category') ?></th>


									<th><?= lang('amount') ?></th>
									<th><?= lang('balance') ?></th>
									<th><?= lang('date') ?></th>
								</tr>
								</thead>
								<tbody>

								<?php foreach($income as $item): ?>
								<tr>
									<td>
										<a href="<?php echo site_url('admin/transaction/view/'. str_replace(array('+', '/', '='), array('-', '_', '~'), $this->encrypt->encode($item->id)) ) ?>">
											<?php echo $item->transaction_id ?>
										</a>
									</td>
									<td><?php echo $item->account_name ?></td>
									<td><?php echo $item->transaction_type ?></td>
									<td><?php echo $item->category_name ?></td>
									<td><span class="text-right" style="color: #0B62A4; font-weight: bold"><?php echo $this->localization->currencyFormat($item->amount) ?></span></td>
									<td><span class="text-right" style="color: #019002; font-weight: bold"><?php echo $this->localization->currencyFormat($item->balance) ?></span></td>
									<td class="highlight"><?php echo date(get_option('date_format'), strtotime($item->date_time)) ?></td>
								</tr>
								<?php endforeach ?>

								</tbody>
							</table>
						</div><!-- /.table-responsive -->
					</div>
				</div>
			</div>
		</div>
	</div>


<?php } ?>



<?php if($this->ion_auth->in_group(array('admin','accounts','sales'))){ ?>
<!--Sales Dashboard=====================================================-->



<!-- Page Content Start -->
<!-- ================== -->




    <div class="row ">
        <div class="col-md-8 col-sm-12 col-xs-12">
            <div class="portlet"><!-- /primary heading -->
                <div class="portlet-heading box-header with-border">
                    <h3 class="portlet-title text-dark text-uppercase">
                        <?= lang('yearly_sales_report') ?>
                    </h3>
                </div>
                <div id="portlet1" class="panel-collapse collapse in">
                    <div class="portlet-body">
                        <div id="morris-bar-example" style="height: 310px;"></div>

                        <div class="row text-center m-t-30 m-b-30 chart-table">
                            <div class="col-md-3 col-sm-6 col-xs-12">
                                <h4>
                                    <?php
                                    if(!empty($today_sale)) {
                                        echo currency($today_sale->grand_total);
                                    }else{
                                        echo 0.00;
                                    }
                                    ?>
                                </h4>
                                <small class="text-muted"> <?= lang('today_sales') ?></small>
                            </div>
                            <div class="col-md-3 col-sm-6 col-xs-12">
                                <h4>
                                    <?php
                                    if(!empty($weekly_sales->grand_total)) {
                                        echo currency($weekly_sales->grand_total);
                                    }else{
                                        echo 0.00;
                                    }
                                    ?>
                                </h4>
                                <small class="text-muted"><?= lang('this_week_sales') ?></small>
                            </div>
                            <div class="col-md-3 col-sm-6 col-xs-12">
                                <h4>
                                    <?php
                                    if(!empty($monthly_sales->grand_total)) {
                                        echo currency($monthly_sales->grand_total);
                                    }else{
                                        echo 0.00;
                                    }
                                    ?>
                                </h4>
                                <small class="text-muted"><?= lang('this_month_sales') ?></small>
                            </div>
                            <div class="col-md-3 col-sm-6 col-xs-12">

                                <h4>
                                    <?php
                                    if(!empty($yearly_sale->grand_total)) {
                                        echo currency($yearly_sale->grand_total);
                                    }else{
                                        echo 0;
                                    }
                                    ?>
                                </h4>
                                <small class="text-muted"><?= lang('this_year_sales') ?></small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Portlet -->

        </div>
        <!-- end col -->

        <div class="col-md-4 col-sm-12 col-xs-12">
            <div class="portlet"><!-- /primary heading -->
                <div class="portlet-heading box-header with-border">
                    <h3 class="portlet-title text-dark text-uppercase">
                        <?= lang('top_5_selling_product') ?> <strong><?php echo date('Y')?></strong>
                    </h3>
                </div>
                <div id="portlet2" class="panel-collapse collapse in">
                    <div class="portlet-body" style="height: 450px">

                        <table class="table no-margin">
                            <thead>
                            <tr>
                                <th><?= lang('sl') ?></th>
                                <th><?= lang('product') ?></th>
                                <th><?= lang('qty') ?></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            if(!empty($top_sell_product)):
                                $top_product = array_slice($top_sell_product, 0, 10);
                                $i=1;
                                ?>
                                <?php foreach($top_product as $item): ?>
                                <tr>
                                    <td ><?php echo $i ?></td>
                                    <td class="highlight"><?php echo $item->product_name ?></td>
                                    <td class="highlight"><strong><?php echo $item->quantity ?></strong></td>
                                    <?php $i ++ ?>
                                </tr>
                            <?php endforeach;
                            else:?>
                                <tr style="column-span: 4">
                                    <td><strong><?= lang('no_records_found') ?></strong></td>
                                </tr>

                            <?php endif ?>
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End row -->






<!-- Page Content Ends -->
<!-- ================== -->
    <div class="row">

        <div class="col-md-8">
            <div class="portlet"><!-- /primary heading -->
                <div class="portlet-heading box-header with-border">
                    <h3 class="portlet-title text-dark text-uppercase">
                        <?= lang('recent_order') ?>
                    </h3>
                </div>
                <div id="portlet2" class="panel-collapse collapse in">
                    <div class="portlet-body" style="height: 400px">
                        <div class="table-responsive">
                            <table class="table no-margin">
                                <thead>
                                <tr>
                                    <th><?= lang('order_id') ?></th>
                                    <th><?= lang('customer') ?></th>
                                    <th><?= lang('date') ?></th>
                                    <th><?= lang('order_total') ?></th>
                                </tr>
                                </thead>
                                <tbody>

                                <?php if($order_info): foreach($order_info as $v_order): ?>
                                    <tr>
                                        <td><a href="<?php echo base_url()?>admin/sales/sale_preview/<?php echo get_orderID($v_order->id) ?>"><?php echo get_orderID($v_order->id) ?></a></td>
                                        <td><?php echo $v_order->customer_name ?></td>
                                        <td><?php echo dateFormat($v_order->date) ?></td>

                                        <td class="highlight"><strong><?php echo currency($v_order->grand_total)  ?></strong></td>
                                    </tr>
                                <?php endforeach;
                                else:?>
                                    <tr style="column-span: 5">
                                        <td><strong><?= lang('no_records_found') ?></strong></td>
                                    </tr>

                                <?php endif ?>
                                </tbody>
                            </table>
                        </div><!-- /.table-responsive -->
                    </div>
                </div>
            </div>
        </div>


        <div class="col-md-4 col-sm-12 col-xs-12">
            <div class="portlet"><!-- /primary heading -->
                <div class="portlet-heading box-header with-border">
                    <h5 class="portlet-title text-dark text-uppercase">
                        <?= lang('top_5_selling_product') ?> <?php echo date('F')?>
                    </h5>
                </div>
                <div id="portlet2" class="panel-collapse collapse in">
                    <div class="portlet-body" style="height: 400px">

                        <table class="table no-margin">
                            <thead>
                            <tr>
                                <th><?= lang('sl') ?></th>
                                <th><?= lang('product') ?></th>
                                <th><?= lang('qty') ?></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            if(!empty($top_sell_product_month)):
                                $top_product = array_slice($top_sell_product_month, 0, 5);
                                $i=1;
                                ?>
                                <?php foreach($top_product as $item): ?>
                                <tr>
                                    <td ><?php echo $i ?></td>
                                    <td class="highlight"><?php echo $item->product_name ?></td>
                                    <td class="highlight"><strong><?php echo $item->quantity ?></strong></td>
                                    <?php $i ++ ?>
                                </tr>
                            <?php endforeach;
                            else:?>
                                <tr style="column-span: 4">
                                    <td><strong><?= lang('no_records_found') ?></strong></td>
                                </tr>

                            <?php endif ?>
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>



    </div>


<script>

    $(function () {
        //Bar chart
        Morris.Bar({
            element: 'morris-bar-example',
            data: [
                <?php foreach ($yearly_sales_report as $name => $v_result):
                $month_name = date('M', strtotime($year . '-' . $name)); // get full name of month by date query
                ?>
                { y: '<?php echo $month_name; ?>', a:  <?php
                    if (!empty($v_result)) {
                        foreach($v_result as $result){
                            echo round($result->grand_total);
                        }
                    }
                    ?> },
                <?php endforeach; ?>
            ],
            xkey: 'y',
            ykeys: ['a'],
            labels: ['Sales'],
            barColors: ['#3bc0c3', '#1a2942', '#5F5AAB']
        });

    });
</script>

<!--Sales Dashboard=====================================================-->

<?php } ?>








<div class="row">

	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="box"><!-- /primary heading -->

			<div id="portlet2" class="panel-collapse collapse in">
				<div class="box-body" style="">

					<div id="calendar" class="col-centered"></div>

					<!-- Modal -->
					<div class="modal fade" id="ModalAdd" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
						<div class="modal-dialog" role="document">
							<div class="modal-content">

									<form class="addEvent form-horizontal" id="addEventForm">

									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
										<h4 class="modal-title" id="myModalLabel"><?= lang('add_event') ?></h4>
									</div>
									<div class="modal-body">

										<div class="form-group">
											<label for="title" class="col-sm-2 control-label"><?= lang('title') ?></label>
											<div class="col-sm-10">
												<input type="text" name="title" class="form-control" id="title" placeholder="Title">
											</div>
										</div>
										<div class="form-group">
											<label for="color" class="col-sm-2 control-label"><?= lang('color') ?></label>
											<div class="col-sm-10">
												<select name="color" class="form-control" id="color">
													<option value="">Choose</option>
													<option style="color:#0071c5;" value="#0071c5">&#9724; Dark blue</option>
													<option style="color:#40E0D0;" value="#40E0D0">&#9724; Turquoise</option>
													<option style="color:#008000;" value="#008000">&#9724; Green</option>
													<option style="color:#FFD700;" value="#FFD700">&#9724; Yellow</option>
													<option style="color:#FF8C00;" value="#FF8C00">&#9724; Orange</option>
													<option style="color:#FF0000;" value="#FF0000">&#9724; Red</option>
													<option style="color:#000;" value="#000">&#9724; Black</option>

												</select>
											</div>
										</div>


										<div class="form-group">
											<label for="start" class="col-sm-2 control-label"><?= lang('start_date') ?></label>
											<div class="col-sm-4">
												<input type="text"  name="start" class="form-control" id="start" data-date-format="yyyy-mm-dd">
											</div>

											<label for="start" class="col-sm-2 control-label"><?= lang('time') ?></label>
											<div class="col-sm-4">
												<div class="input-group bootstrap-timepicker timepicker">
													<input type="text"  name="startTime" class="form-control" id="startTime" data-date-format="HH:mm:ss">
												</div>
											</div>
										</div>

										<div class="form-group">
											<label for="end" class="col-sm-2 control-label"><?= lang('end_date') ?></label>
											<div class="col-sm-4">
												<input type="text" name="end" class="form-control" id="end" data-date-format="yyyy-mm-dd" >
											</div>

											<label for="start" class="col-sm-2 control-label"><?= lang('time') ?></label>
											<div class="col-sm-4">
												<div class="input-group bootstrap-timepicker timepicker">
													<input type="text"  name="endTime" class="form-control" id="endTime" data-date-format="HH:mm:ss">
												</div>
											</div>
										</div>




									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-default" data-dismiss="modal"><?= lang('close') ?></button>
										<button type="submit" id="addEvent" class="btn btn-primary"><?= lang('save') ?></button>
									</div>
									</form>
							</div>
						</div>
					</div>



					<!-- Modal -->
					<div class="modal fade" id="ModalEdit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
						<div class="modal-dialog" role="document">
							<div class="modal-content">
								<form class="editEvent form-horizontal">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
										<h4 class="modal-title" id="myModalLabel"><?= lang('edit_event') ?></h4>
									</div>
									<div class="modal-body">

										<div class="form-group">
											<label for="title" class="col-sm-2 control-label"><?= lang('title') ?></label>
											<div class="col-sm-10">
												<input type="text" name="title" class="form-control" id="title" placeholder="Title">
											</div>
										</div>
										<div class="form-group">
											<label for="color" class="col-sm-2 control-label"><?= lang('color') ?></label>
											<div class="col-sm-10">
												<select name="color" class="form-control" id="color">
													<option value="">Choose</option>
													<option style="color:#0071c5;" value="#0071c5">&#9724; Dark blue</option>
													<option style="color:#40E0D0;" value="#40E0D0">&#9724; Turquoise</option>
													<option style="color:#008000;" value="#008000">&#9724; Green</option>
													<option style="color:#FFD700;" value="#FFD700">&#9724; Yellow</option>
													<option style="color:#FF8C00;" value="#FF8C00">&#9724; Orange</option>
													<option style="color:#FF0000;" value="#FF0000">&#9724; Red</option>
													<option style="color:#000;" value="#000">&#9724; Black</option>

												</select>
											</div>
										</div>

										<div class="form-group">
											<label for="start" class="col-sm-2 control-label"><?= lang('start_date') ?></label>
											<div class="col-sm-4">
												<input type="text"  name="start" class="form-control" id="eStart" data-date-format="yyyy-mm-dd">
											</div>

											<label for="start" class="col-sm-2 control-label"><?= lang('time') ?></label>
											<div class="col-sm-4">
												<div class="input-group bootstrap-timepicker timepicker">
													<input type="text"  name="startTime" class="form-control" id="eStartTime" data-date-format="HH:mm:ss">
												</div>
											</div>
										</div>

										<div class="form-group">
											<label for="end" class="col-sm-2 control-label"><?= lang('end_date') ?></label>
											<div class="col-sm-4">
												<input type="text" name="end" class="form-control" id="eEnd" >
											</div>

											<label for="start" class="col-sm-2 control-label"><?= lang('time') ?></label>
											<div class="col-sm-4">
												<div class="input-group bootstrap-timepicker timepicker">
													<input type="text"  name="endTime" class="form-control" id="eEndTime" data-date-format="HH:mm:ss">
												</div>
											</div>
										</div>

										<div class="form-group">
											<div class="col-sm-offset-2 col-sm-10">
												<div class="checkbox">
													<label class="text-danger"><input type="checkbox"  name="delete"> <?= lang('delete_event') ?></label>
												</div>
											</div>
										</div>

										<input type="hidden" name="id" class="form-control" id="id">


									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-default" data-dismiss="modal"><?= lang('close') ?></button>
										<button type="submit" id="editEvent" class="btn btn-primary"><?= lang('update') ?></button>
									</div>
								</form>
							</div>
						</div>
					</div>



				</div>
			</div>
		</div>
	</div>

</div>

<?php if($this->ion_auth->in_group(array('admin','accounts'))){ ?>
<script>
	$(function () {
		"use strict";
		//DONUT CHART
		var donut = new Morris.Donut({
			element: 'sales-chart',
			resize: true,
			colors: [ "#019002", "#FF0000"],
			data: [

				{label: "Income", value: <?php echo $this_year->income !='' ? $this_year->income : '0.00'  ?>},
				{label: "Expense", value: <?php echo $this_year->expense != '' ? $this_year->expense : '0.00' ?>}
			],
			hideHover: 'auto'
		});


		var months = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];

		Morris.Line({
			element: 'line-chart',
            lineColors: [ "#019002", "#FF0000"],
			data: [

			<?php foreach ($yearly_transaction as $name => $v_result):
				$month = $year . '-' . $name; // get full name of month by date query
			?>
        {

        m: '<?php echo $month ?>',
        a: <?php echo $v_result->income !='' ? round($v_result->income): '0.00' ?>,
        b: <?php echo $v_result->expense !='' ? round($v_result->expense): '0.00' ?>

        },

        <?php endforeach ?>

    ],
    xkey: 'm',
    ykeys: ['a', 'b'],
    labels: ['Income', 'Expense'],
    xLabelFormat: function(x) { // <--- x.getMonth() returns valid index
        var month = months[x.getMonth()];
        return month;
    },
    dateFormat: function(x) {
        var month = months[new Date(x).getMonth()];
        return month;
    },
});

});
</script>
<?php } ?>