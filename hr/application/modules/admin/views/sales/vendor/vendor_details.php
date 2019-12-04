
<!-- Main content -->
<section class="content">


    <div class="row" id="custom-widget">

        <div class="col-sm-6 col-md-3">
            <a class="block block-rounded  block-link-hover2 text-center" >
                <div class="block-content block-content-full">
                    <div class="h2 font-w700"><?php echo get_option('currency_symbol').' '.$this->localization->currencyFormat($totalInvoice->total_purchase) ?></div>
                </div>
                <div class="block-content block-content-full block-content-mini bg-success text-white h4 font-w600"> <span class="h6 badge bg-white-op"><?php echo $totalInvoice->total_invoice ?></span> <?php  echo strtoupper(lang('life_time_purchase')) ?></div>
            </a>
        </div>

        <div class="col-sm-6 col-md-3">
            <a class="block block-rounded  block-link-hover2 text-center" >
                <div class="block-content block-content-full">
                    <div class="h2 font-w700"><?php echo get_option('currency_symbol').' '.$this->localization->currencyFormat($due->due_payment) ?></div>
                </div>
                <div class="block-content block-content-full block-content-mini bg-orange text-white h4 font-w600"> <span class="h6 badge bg-white-op"><?php echo $due->total_invoice ?></span> <?php  echo strtoupper(lang('open_invoice')) ?></div>
            </a>
        </div>



        <div class="col-sm-6 col-md-3">
            <a class="block block-rounded  block-link-hover2 text-center" >
                <div class="block-content block-content-full">
                    <div class="h2 font-w700"><?php echo get_option('currency_symbol').' '.$this->localization->currencyFormat($paid->paid_amount) ?></div>
                </div>
                <div class="block-content block-content-full block-content-mini bg-danger text-white h4 font-w600"> <span class="h6 badge bg-white-op"><?php echo $openInvoice->invoice_qty ?></span> <?php  echo strtoupper(lang('lifetime_paid')) ?></div>
            </a>
        </div>

        <div class="col-sm-6 col-md-3">
            <a class="block block-rounded  block-link-hover2 text-center" href="#">
                <div class="block-content block-content-full">
                    <div class="h2 font-w700"><?php echo get_option('currency_symbol').' '.$this->localization->currencyFormat($returnPurchase->grand_total) ?></div>
                </div>
                <div class="block-content block-content-full block-content-mini bg-purple text-white h4 font-w600"> <span class="h6 badge bg-white-op"><?php echo $returnPurchase->total_invoice ?></span> <?php  echo strtoupper(lang('return_purchase')) ?></div>
            </a>
        </div>
        <!-- /.col -->
    </div>

    <div class="row">



        <!-- /.col -->
        <div class="col-md-12">

            <!-- View massage -->
            <?php echo message_box('success'); ?>
            <?php echo message_box('error'); ?>

            <div class="box box-primary">
                <div class="box-header with-border">
                    <div class="row">
                        <div class="col-md-4">
                            <h3><?php echo $vendor->name?></h3>
                            <h4 class="class="box-title""><?php echo $vendor->company_name?></h4><br/>
                            <?= lang('phone') ?>: <?php echo $vendor->phone?><br/>
                            <?= lang('email') ?>: <?php echo $vendor->email?><br/>
                            <?= lang('fax') ?>: <?php echo $vendor->fax?><br/>
                        </div>

                        <div class="col-md-4">
                            <h4 class="class="box-title""><?= lang('billing_address') ?></h4><br/>
                            <?php echo $vendor->b_address?><br/>
                        </div>

                    </div>
                </div>
                <!-- /.box-header -->



                <?php
                foreach($crud->css_files as $file): ?>
                    <link type="text/css" rel="stylesheet" href="<?php echo $file; ?>" />
                <?php endforeach; ?>

                <?php foreach($crud->js_files as $file): ?>
                    <script src="<?php echo $file; ?>"></script>
                <?php endforeach; ?>

                <div class="box-body ">

                    <?php   echo $crud->output; ?>

                </div>
            </div>
            <!-- /. box -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
</section>
<!-- /.content -->




