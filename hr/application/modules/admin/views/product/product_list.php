<script src="<?php echo site_url('assets/js/ajax.js') ?>"></script>



<!-- Main content -->
<section class="content">
    <div class="row">



        <!-- /.col -->
        <div class="col-md-12">

<!--            <div class="row msg">-->
<!--                <div class="col-md-6 col-xs-12">-->
<!--                    <div class="info-box">-->
<!--                        <span class="info-box-icon bg-aqua"><img src="--><?php //echo base_url().IMAGE.'low-stock.png' ?><!--" height="80px"></span>-->
<!--                        <div class="info-box-content">-->
<!--                            <span class="info-box-text">Messages</span>-->
<!--                            <span class="info-box-number">1,410</span>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                   -->
<!--                </div>-->
<!--               -->
<!---->
<!--                <div class="col-md-6 col-xs-12">-->
<!--                    <div class="info-box">-->
<!--                        <span class="info-box-icon bg-red"><img src="--><?php //echo base_url().IMAGE.'out-stock.png' ?><!--" height="80px"></span>-->
<!--                        <div class="info-box-content">-->
<!--                            <span class="info-box-text">Likes</span>-->
<!--                            <span class="info-box-number">93,139</span>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->

            <!-- View massage -->
            <?php echo message_box('success'); ?>
            <?php echo message_box('error'); ?>

            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"><?= lang('product_services') ?></h3>
                    <!-- /.box-tools -->
                </div>
                <!-- /.box-header -->

                <div class="box-body ">
                    <div class="mailbox-controls">
<!--                        <a href="--><?php //echo site_url('admin/product/addProductServices') ?><!--" class="btn btn-default"><i class="fa fa-plus" aria-hidden="true"></i> --><?//= lang('add_product_services') ?><!--</a>-->
                        <div class="btn-group" role="group" aria-label="...">
                            <div class="btn-group" role="group">
                                <button type="button" class="btn bg-olive dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-plus" aria-hidden="true"></i> <?= lang('add_product_services') ?>
                                    <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a href="<?php echo base_url() . 'admin/product/productType?type=inventory' ?>">
                                            <img src="<?php echo base_url() . IMAGE . 'inventory.png' ?>" width="40" height="40"> <?= lang('inventory_product') ?>&nbsp;&nbsp;&nbsp;&nbsp;</a></li>
                                    <li><a href="<?php echo base_url() . 'admin/product/productType?type=non-inventory' ?>">
                                            <img src="<?php echo base_url() . IMAGE . 'non-inventory.png' ?>" width="40" height="40"> <?= lang('non_inventory') ?> </a></li>
                                    <li><a href="<?php echo base_url() . 'admin/product/productType?type=service' ?>">
                                            <img src="<?php echo base_url() . IMAGE . 'service.png' ?>" width="40" height="40"> <?= lang('service') ?></a></li>
                                    <li><a href="<?php echo base_url() . 'admin/product/productType?type=bundle' ?>">
                                            <img src="<?php echo base_url() . IMAGE . 'bundel.png' ?>" width="40" height="40"> <?= lang('bundel_product') ?></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- /.mail-box-messages -->
                </div>
                <!-- /.box-body -->

                <div class="box-body ">



                    <table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th><?= lang('pic') ?></th>
                            <th><?= lang('product') ?></th>
                            <th><?= lang('sku') ?></th>
                            <th><?= lang('sales_cost') ?></th>
                            <th><?= lang('buying_cost') ?></th>
                            <th><?= lang('inventory') ?></th>
                            <th><?= lang('type') ?></th>
                            <th style="width:125px;"><?= lang('actions') ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>


                </div>
            </div>
            <!-- /. box -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
</section>
<!-- /.content -->

<script>
    //var table;
    var list        = 'admin/product/productTable';
    //var list        = '';
</script>


