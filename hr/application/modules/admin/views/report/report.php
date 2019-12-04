<div class="row report-listing">
    <div class="col-md-6  ">
        <div class="panel">
            <div class="panel-body">
                <div class="list-group parent-list">
                    <h3 id="right_heading" class="page-header text-info"><i class="icon ti-angle-double-left"></i><?= lang('report_category') ?></h3>

                    <?php if($this->ion_auth->in_group(array('admin','accounts','hr'))){ ?>
                    <a href="#" class="list-group-item" id="employee"><?= lang('employee') ?></a>
                    <?php } ?>
                    <?php if($this->ion_auth->in_group(array('admin','accounts'))){ ?>
                    <a href="#" class="list-group-item" id="transaction"><?= lang('transaction') ?></a>
                    <?php } ?>
                    <?php if($this->ion_auth->in_group(array('admin','accounts','sales'))){ ?>
                    <a href="#" class="list-group-item" id="sales_purchase"><?= lang('sales') ?> & <?= lang('purchase') ?></a>
                    <a href="#" class="list-group-item" id="customer"><?= lang('customer') ?></a>
                    <a href="#" class="list-group-item" id="vendor"><?= lang('vendor') ?></a>
                    <a href="#" class="list-group-item" id="product"><?= lang('product_services') ?></a>
                    <?php } ?>
<!--                    <a href="#" class="list-group-item" id="assets">Assets</a>-->






                </div>
            </div>
        </div> <!-- /panel -->
    </div>
    <div class="col-md-6" id="report_selection">
        <div class="panel">
            <div class="panel-body child-list">
                <h3 id="right_heading" class="page-header text-info"><i class="icon ti-angle-double-left"></i><?= lang('make_a_selection') ?></h3>

                <?php if($this->ion_auth->in_group(array('admin','accounts','hr'))){ ?>
                <div class="list-group employee hidden">
                    <a href="<?php echo site_url('admin/reports/employeeAttendance')?>" class="list-group-item"><i class="icon ti-bar-chart-alt"></i><?= lang('attendance') ?></a>
                    <a href="<?php echo site_url('admin/reports/employeeList')?>" class="list-group-item"><i class="icon ti-receipt"></i> <?= lang('employee_list') ?> </a>
                    <a href="<?php echo site_url('admin/reports/payrollList')?>" class="list-group-item"><i class="icon ti-receipt"></i><?= lang('payroll') ?> </a>
                </div>
                <?php } ?>
                <?php if($this->ion_auth->in_group(array('admin','accounts'))){ ?>
                <div class="list-group transaction hidden">
                    <a href="<?php echo site_url('admin/reports/transaction')?>" class="list-group-item"><i class="icon ti-bar-chart-alt"></i><?= lang('transaction') ?></a>
                    <a href="<?php echo site_url('admin/reports/summaryAccount')?>" class="list-group-item"><i class="icon ti-bar-chart-alt"></i><?= lang('summary') ?> <?= lang('account') ?> <?= lang('report') ?> </a>
                    <a href="<?php echo site_url('admin/reports/summaryTransaction')?>" class="list-group-item"><i class="icon ti-bar-chart-alt"></i><?= lang('summary') ?> <?= lang('transaction') ?> <?= lang('report') ?> </a>
                    <a href="<?php echo site_url('admin/reports/BalanceCheck')?>" class="list-group-item"><i class="icon ti-receipt"></i> <?= lang('account_balance') ?></a>
                </div>
                <?php } ?>
                <?php if($this->ion_auth->in_group(array('admin','accounts','sales'))){ ?>
                <div class="list-group sales_purchase hidden">
                    <a href="<?php echo site_url('admin/reports/salesReport')?>" class="list-group-item"><i class="icon ti-bar-chart-alt"></i> <?= lang('sales') ?> <?= lang('report') ?></a>
                    <a href="<?php echo site_url('admin/reports/purchaseReport')?>" class="list-group-item"><i class="icon ti-receipt"></i> <?= lang('purchase') ?> <?= lang('report') ?></a>
                    <a href="<?php echo site_url('admin/reports/returnPurchase')?>" class="list-group-item"><i class="icon ti-receipt"></i> <?= lang('return_purchase') ?></a>
                    <a href="<?php echo site_url('admin/reports/paymentReceived')?>" class="list-group-item"><i class="icon ti-receipt"></i> <?= lang('payment_received') ?></a>
                </div>

                <div class="list-group customer hidden">
                    <a href="<?php echo site_url('admin/reports/customerSales')?>" class="list-group-item"><i class="icon ti-bar-chart-alt"></i> <?= lang('customer') ?> <?= lang('sales') ?></a>
                    <a href="<?php echo site_url('admin/reports/customerSummaryReport')?>" class="list-group-item"><i class="icon ti-bar-chart-alt"></i><?= lang('summary') ?> <?= lang('report') ?></a>
                    <a href="<?php echo site_url('admin/reports/customerLifetimeSales')?>" class="list-group-item"><i class="icon ti-bar-chart-alt"></i> <?= lang('lifetime_sales') ?></a>
                    <a href="<?php echo site_url('admin/reports/customerDue')?>" class="list-group-item"><i class="icon ti-receipt"></i> <?= lang('due_payment') ?></a>
                    <a href="<?php echo site_url('admin/reports/customerOverDue')?>" class="list-group-item"><i class="icon ti-receipt"></i> <?= lang('over_due_payment') ?></a>
                </div>

                <div class="list-group vendor hidden">
                    <a href="<?php echo site_url('admin/reports/vendorPurchaseReport')?>" class="list-group-item"><i class="icon ti-bar-chart-alt"></i><?= lang('purchase') ?> <?= lang('report') ?></a>
                    <a href="<?php echo site_url('admin/reports/vendorPurchaseDuePayment')?>" class="list-group-item"><i class="icon ti-receipt"></i> <?= lang('due_payment') ?></a>
                    <a href="<?php echo site_url('admin/reports/vendorPaymentByDate')?>" class="list-group-item"><i class="icon ti-receipt"></i><?= lang('summary') ?> <?= lang('report') ?></a>
                    <a href="<?php echo site_url('admin/reports/lifetimePurchase')?>" class="list-group-item"><i class="icon ti-receipt"></i> <?= lang('lifetime_purchase') ?></a>
                    <a href="<?php echo site_url('admin/reports/vendorReturnPurchase')?>" class="list-group-item"><i class="icon ti-receipt"></i> <?= lang('return_purchase') ?></a>
                </div>

                <div class="list-group product hidden">
                    <a href="<?php echo site_url('admin/reports/stockValues')?>" class="list-group-item"><i class="icon ti-bar-chart-alt"></i> <?= lang('stock_values') ?></a>
                    <a href="<?php echo site_url('admin/reports/purchaseReport')?>" class="list-group-item"><i class="icon ti-receipt"></i> <?= lang('product_purchase_report') ?></a>
                    <a href="<?php echo site_url('admin/reports/stockReport')?>" class="list-group-item"><i class="icon ti-receipt"></i><?= lang('stock_report') ?></a>
                </div>
                <?php } ?>

<!--                <div class="list-group assets hidden">-->
<!--                    <a href="#" class="list-group-item"><i class="icon ti-bar-chart-alt"></i> Asset List</a>-->
<!--                    <a href="#" class="list-group-item"><i class="icon ti-receipt"></i> Asset Value</a>-->
<!--                    <a href="#" class="list-group-item"><i class="icon ti-receipt"></i> Asset Depreciation Chart</a>-->
<!--                </div>-->






            </div>
        </div> <!-- /panel -->
    </div>
</div>

<script type="text/javascript">
    $('.parent-list a').click(function(e){
        e.preventDefault();
        $('.parent-list a').removeClass('active');
        $(this).addClass('active');
        var currentClass='.child-list .'+ $(this).attr("id");
        $('.child-list .page-header').html($(this).html());
        $('.child-list .list-group').addClass('hidden');
        $(currentClass).removeClass('hidden');
        $('#right_heading').addClass('active');
        $('html, body').animate({
            scrollTop: $("#report_selection").offset().top
        }, 500);
    });
</script>