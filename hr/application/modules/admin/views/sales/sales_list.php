<!-- Main content -->
<section class="content">
<!-- BLOCKS -->


<div class="row head-box">
      <div class="col-sm-6 col-md-3">
        <a class="block block-rounded  block-link-hover2 text-center" href="<?php echo site_url('admin/sales/overdueInvoice')?>">
            <div class="block-content block-content-full">
                <div class="h2 font-w700"><?php echo get_option('currency_symbol').' '.$this->localization->currencyFormat($due->due_amount) ?></div>
            </div>
        <div class="block-content block-content-full block-content-mini bg-success text-white h4 font-w600"> <span class="h6 badge bg-white-op"><?php echo $due->due_qty ?></span> <?php echo strtoupper(lang('overdue')) ?></div>
        </a>
    </div>
      <div class="col-sm-6 col-md-3">
        <a class="block block-rounded  block-link-hover2 text-center" href="<?php echo site_url('admin/sales/allQuotation')?>">
            <div class="block-content block-content-full">
                <div class="h2 font-w700"><?php echo get_option('currency_symbol').' '.$this->localization->currencyFormat($estimate->estimate_amount) ?></div>
            </div>
        <div class="block-content block-content-full block-content-mini bg-orange text-white h4 font-w600"> <span class="h6 badge bg-white-op"><?php echo $estimate->estimate_qty ?></span> <?php  echo strtoupper(lang('estimate')) ?></div>
        </a>
    </div>
          <div class="col-sm-6 col-md-3">
        <a class="block block-rounded  block-link-hover2 text-center" href="<?php echo site_url('admin/sales/openInvoice')?>">
            <div class="block-content block-content-full">
                <div class="h2 font-w700"><?php echo get_option('currency_symbol').' '.$this->localization->currencyFormat($openInvoice->invoice_amount) ?></div>
            </div>
        <div class="block-content block-content-full block-content-mini bg-danger text-white h4 font-w600"> <span class="h6 badge bg-white-op"><?php echo $openInvoice->invoice_qty ?></span> <?php  echo strtoupper(lang('open_invoice')) ?></div>
        </a>
    </div>

          <div class="col-sm-6 col-md-3">
        <a class="block block-rounded  block-link-hover2 text-center" href="#">
            <div class="block-content block-content-full">
                <div class="h2 font-w700"><?php echo get_option('currency_symbol').' '.$this->localization->currencyFormat($lifeTimeSell->invoice_amount) ?></div>
            </div>
        <div class="block-content block-content-full block-content-mini bg-purple text-white h4 font-w600"> <span class="h6 badge bg-white-op"><?php echo $lifeTimeSell->invoice_qty ?></span> <?php  echo strtoupper(lang('life_time_sell')) ?></div>
        </a>
    </div>

</div>



<!-- END BLOCKS --> 

    <div class="row">

        <!-- /.col -->
        <div class="col-md-12">

            <!-- View massage -->
            <?php echo message_box('success'); ?>
            <?php echo message_box('error'); ?>

            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"><?= lang('invoice_list') ?></h3>
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