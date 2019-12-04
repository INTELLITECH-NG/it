<script src="<?php echo site_url('assets/js/ajax.js') ?>"></script>

<!-- Main content -->
<section class="content">

    <div class="row">
        <!-- /.col -->
        <div class="col-md-12">

            <!-- View massage -->
            <?php echo message_box('success'); ?>
            <?php echo message_box('error'); ?>

            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"><?= lang('customer') ?></h3>
                    <!-- /.box-tools -->
                </div>
                <!-- /.box-header -->

               <div class="row">
                   <div class="col-md-12">
                       <div class="box-body">

                           <div class="mailbox-controls pull-right">
                               <!-- Check all button -->
                               <a href="<?php echo base_url('admin/trader/newCustomer') ?>" class="btn bg-green-active"><i class="fa fa-plus" aria-hidden="true"></i> <?= lang('new_customer') ?></a>
                               <a href="<?php echo base_url('admin/trader/importCustomer') ?>" class="btn bg-orange-active"><i class="fa fa-upload" aria-hidden="true"></i> <?= lang('import') ?></a>

                               <!-- /.pull-right -->
                           </div>

                           <!-- /.mail-box-messages -->
                       </div>
                   </div>
               </div>
                <!-- /.box-body -->
                <div class="box-body ">
                    <table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th><?= lang('customer/company') ?></th>
                            <th><?= lang('phone') ?></th>
                            <th><?= lang('open_balance') ?></th>
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
    var list        = 'admin/trader/customerTable';
    //var list        = '';
</script>


