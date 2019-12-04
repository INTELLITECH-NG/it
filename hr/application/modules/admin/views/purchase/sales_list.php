
<!-- Main content -->
<section class="content">


    <div class="row" id="custom-widget">
        <div class="col-md-3">
            <!-- Widget: user widget style 1 -->

                <div class="box box-widget widget-user-2">
                    <!-- Add the bg color to the header using any of the bg-* classes -->
                    <div class="widget-user-header bg-orange">
                        <!-- /.widget-user-image -->
                        <h3 class="widget-user-username"><?php echo get_option('currency_symbol').' '.$this->localization->currencyFormat($due->due_amount) ?></h3>
                        <h5 class="widget-user-desc"><?php echo $due->due_qty ?> OVERDUE</h5>
                    </div>
                </div>

            <!-- /.widget-user -->
        </div>
        <!-- /.col -->

        <div class="col-md-3">
            <!-- Widget: user widget style 1 -->
            <div class="box box-widget widget-user-2">
                <!-- Add the bg color to the header using any of the bg-* classes -->
                <div class="widget-user-header bg-aqua-active">
                    <!-- /.widget-user-image -->
                    <h3 class="widget-user-username"><?php echo get_option('currency_symbol').' '.$this->localization->currencyFormat($estimate->estimate_amount) ?></h3>
                    <h5 class="widget-user-desc"><?php echo $estimate->estimate_qty ?> ESTIMATE</h5>
                </div>
            </div>
            <!-- /.widget-user -->
        </div>

        <!-- /.col -->
        <div class="col-md-3">
            <!-- Widget: user widget style 1 -->
            <div class="box box-widget widget-user-2">
                <!-- Add the bg color to the header using any of the bg-* classes -->
                <div class="widget-user-header bg-blue-active">
                    <!-- /.widget-user-image -->
                    <h3 class="widget-user-username"><?php echo get_option('currency_symbol').' '.$this->localization->currencyFormat($openInvoice->invoice_amount) ?></h3>
                    <h5 class="widget-user-desc"><?php echo $openInvoice->invoice_qty ?> OPEN INVOICE</h5>
                </div>
            </div>
            <!-- /.widget-user -->
        </div>
        <!-- /.col -->

        <div class="col-md-3">
            <!-- Widget: user widget style 1 -->
            <div class="box box-widget widget-user-2">
                <!-- Add the bg color to the header using any of the bg-* classes -->
                <div class="widget-user-header bg-olive-active">
                    <!-- /.widget-user-image -->
                    <h3 class="widget-user-username"><?php echo get_option('currency_symbol').' '.$this->localization->currencyFormat($lifeTimeSell->invoice_amount) ?></h3>
                    <h5 class="widget-user-desc"><?php echo $lifeTimeSell->invoice_qty ?> LIFE TIME SELL</h5>
                </div>
            </div>
            <!-- /.widget-user -->
        </div>


    </div>

    <div class="row">



        <!-- /.col -->
        <div class="col-md-12">

            <!-- View massage -->
            <?php echo message_box('success'); ?>
            <?php echo message_box('error'); ?>

            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Sales List</h3>
                    <!-- /.box-tools -->
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
