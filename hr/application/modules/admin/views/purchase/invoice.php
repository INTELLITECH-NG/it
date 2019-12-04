
<section class="invoice">

    <div class="print-invoice">

        <!-- View massage -->
        <?php echo message_box('success'); ?>
        <?php echo message_box('error'); ?>
        <link href="<?php echo base_url(); ?>assets/css/AdminLTE.css" media="print" rel="stylesheet" type="text/css"  />
        <link href="<?php echo base_url(); ?>assets/css/bootstrap/css/bootstrap.css" media="print" rel="stylesheet" type="text/css" />

        <!-- title row -->
        <div class="row">
            <div class="col-xs-12">
                <h2 class="page-header">
                    <?= get_option('company_name')?>
                    <small class="pull-right"><?= lang('date') ?>: <?= $order->date ?></small>
                </h2>
            </div>
            <!-- /.col -->
        </div>
        <!-- info row -->
        <div class="row invoice-info">
            <div class="col-sm-4 invoice-col">
                <?= lang('billing_address') ?>
                <address>
                    <strong><?= $vendor->company_name ?></strong><br>
                    <?= $order->b_address ?><br>
                    <?= lang('phone') ?>: <?= $vendor->phone ?><br>
                    <?= lang('email') ?>: <?= $order->email ?>
                </address>
            </div>
            <!-- /.col -->

            <div class="col-sm-4 invoice-col">

            </div>

            <!-- /.col -->

            <div class="col-sm-4 invoice-col">
                <h3><?= get_option('order_prefix')?><?= INVOICE_PRE + $order->id?></h3><br>
                <b><?= lang('order_date') ?>:</b> <?php echo $this->localization->dateFormat($order->date)?><br>
                <b><?= lang('billing_ref') ?>:</b> <?php echo $order->ref ?><br>
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->

        <!-- Table row -->
        <div class="row" style="padding-top: 50px">
            <div class="col-xs-12 table-responsive">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th><?= lang('sl') ?>.</th>
                        <th><?= lang('product') ?></th>
                        <th><?= lang('description') ?></th>
                        <th><?= lang('price') ?></th>
                        <th><?= lang('qty') ?></th>
                        <th><?= lang('subtotal') ?> (<?= get_option('currency_symbol') ?>)</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $i=1 ; foreach ($order_details as $item){?>
                        <tr>
                            <td><?= $i ?></td>
                            <td><?= $item->product_name ?></td>
                            <td><?= $item->description ?></td>
                            <td><?= $item->unit_price ?></td>
                            <td><?= $item->qty ?></td>
                            <td><?= $this->localization->currencyFormat($item->sub_total) ?></td>
                        </tr>
                        <?php $i++; } ?>

                    <?php if(!empty($return)){ ?>
                        <?php $total_return = 0 ?>
                        <tr class="warning">
                            <td colspan="6"><strong><?= lang('returned_items') ?></strong></td>
                        </tr>
                        <?php foreach ($return as $item){ ?>
                            <tr>
                                <td><?= $i ?></td>
                                <td><?= $item->product_name ?></td>
                                <td><?= $item->description ?></td>
                                <td><?= $item->unit_price ?></td>
                                <td><?= '-'.$item->qty ?></td>
                                <td><?= '-'. $this->localization->currencyFormat($item->sub_total) ?></td>
                            </tr>
                            <?php $total_return += $item->sub_total ?>
                        <?php $i++; } ?>

                    <?php }?>

                    </tbody>
                </table>
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->

        <div class="row">

            <!-- accepted payments column -->
            <div class="col-xs-7">

                <?php if(!empty($order->order_note)){?>
                        <p class="lead"><?= lang('order_note') ?>:</p>
                        <p>
                            <?= $order->order_note ?>
                        </p>
                <?php }?>



            </div>
            <!-- /.col -->
            <div class="col-xs-5">

                <div class="table-responsive">
                    <table class="table">
                        <tbody>
                            <tr>
                                <th style="width:50%"><?= lang('subtotal') ?>:</th>
                                <td><?= $this->localization->currencyFormat($order->cart_total) ?></td>
                            </tr>

                            <?php if(!empty($return)){ ?>
                            <tr>
                                <th style="width:50%"><?= lang('total_return') ?>:</th>
                                <td>- <?= $this->localization->currencyFormat($total_return) ?></td>
                            </tr>
                            <?php } ?>

                            <tr>
                                <th><?= lang('discount') ?>:</th>
                                <td>- <?= $this->localization->currencyFormat($order->discount) ?></td>
                            </tr>
                            <tr>
                                <th><?= lang('tax_amount') ?>:</th>
                                <td><?= $this->localization->currencyFormat($order->tax) ?></td>
                            </tr>
                            <tr>
                                <th><?= lang('shipping') ?>:</th>
                                <td><?= $this->localization->currencyFormat($order->shipping) ?></td>
                            </tr>
                            <tr>
                                <th><?= lang('grand_total') ?>:</th>
                                <td><?= $this->localization->currencyFormat($order->grand_total) ?></td>
                            </tr>
                            <tr>
                                <th><?= lang('paid') ?> :</th>
                                <td><?= $this->localization->currencyFormat($order->paid_amount) ?></td>
                            </tr>
                            <tr>
                                <th><?= lang('balance') ?> :</th>
                                <td><?= $this->localization->currencyFormat($order->due_payment) ?></td>
                            </tr>

                        </tbody>
                    </table>
                </div>
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div>


    <?php if(!empty($payment)){ ?>
        <table class="table table-bordered">
            <thead>
            <tr class="info">
                <th><?= lang('date') ?></th>
                <th><?= lang('payment_ref') ?>.</th>
                <th><?= lang('payment_method') ?></th>
                <th><?= lang('amount') ?></th>
                <th><?= lang('received_by') ?></th>
            </tr>
            </thead>

            <tbody>
            <?php foreach ($payment as $id){ ?>
            <tr>
                <td><?php dateFormat($id->payment_date) ?></td>
                <td><?php echo $id->order_ref ?></td>
                <td><?php echo $id->payment_method ?></td>
                <td><?php echo currency($id->amount) ?></td>
                <td><?php echo $id->received_by ?></td>
            </tr>
            <?php }?>

            </tbody>
        </table>
    <?php } ?>


    <!-- this row will not appear when printing -->
    <div class="row no-print">
        <div class="col-xs-12">

            <a id="printButton" class="btn btn-default"><i class="fa fa-print"></i> <?= lang('print') ?></a>

            <a onclick="return confirm('Are you sure want to delete this Invoice ?');" href="<?php echo base_url()?>admin/purchase/deletePurchase/<?php echo get_orderID($order->id) ?> " class="btn btn-danger pull-right" style="margin-right: 5px;">
                <i class="fa fa-trash"></i> <?= lang('delete') ?>
            </a>

            <?php if($order->type != 'Return'){ ?>
            <a href="<?php echo base_url()?>admin/purchase/returnPurchase/<?php echo get_orderID($order->id) ?> " data-target="#modalSmall" data-toggle="modal" class="btn btn-warning pull-right" style="margin-right: 5px;">
                <i class="fa fa-angle-double-left"></i> <?= lang('return_purchase') ?>
            </a>

            <a href="<?php echo base_url()?>admin/purchase/receivedProduct/<?php echo get_orderID($order->id) ?> "  data-target="#myModal" data-toggle="modal" class="btn btn-success pull-right" style="margin-right: 5px;">
                <i class="fa fa-cube"></i> <?= lang('received_product') ?>
            </a>

            <a href="<?php echo base_url()?>admin/purchase/paymentList/<?php echo get_orderID($order->id) ?> " data-target="#myModal" data-toggle="modal" class="btn bg-olive pull-right" style="margin-right: 5px;">
                <i class="fa fa-money"></i> <?= lang('view_payment') ?>
            </a>

            <a href="<?php echo base_url()?>admin/purchase/addPayment/<?php echo get_orderID($order->id) ?> " data-target="#modalSmall" data-toggle="modal" class="btn bg-purple pull-right" style="margin-right: 5px;">
                <i class="fa fa-money"></i> <?= lang('add_payment') ?>
            </a>

            <?php } ?>

            <a href="<?php echo base_url()?>admin/purchase/pdfInvoice/<?php echo get_orderID($order->id) ?> "  class="btn btn-info pull-right" style="margin-right: 5px;">
                <i class="fa fa-download"></i> <?= lang('generate_pdf') ?>
            </a>

            <a href="<?php echo base_url()?>admin/purchase/sendInvoice/<?php echo get_orderID($order->id) ?> " data-target="#modalSmall" data-toggle="modal" class="btn btn-primary pull-right" style="margin-right: 5px;">
                <i class="fa fa-envelope"></i> <?= lang('email') ?>
            </a>


        </div>
    </div>



</section>

<script>
    $(document).ready(function(){
        $("#printButton").click(function(){
            var mode = 'iframe'; // popup
            var close = mode == "popup";
            var options = { mode : mode, popClose : close};
            $("div.print-invoice").printArea( options );
        });
    });
</script>