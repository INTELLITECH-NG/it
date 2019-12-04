<script src="<?php echo site_url('assets/js/dataTableAjax.js') ?>"></script>
<div class="row">
    <div class="col-md-12">
        <!-- general form elements -->
        <div class="box box-primary">
            <div class="box-header with-border bg-primary-dark">
                <h3 class="box-title"><?php echo $title ?></h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->

            <div class="box-body">

                <!-- View massage -->
                <?php echo message_box('success'); ?>
                <?php echo message_box('error'); ?>


                <div class="row">
                    <div class="col-md-12">


                        <div id="msg"></div>


                        <table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th><?= lang('trns_id') ?></th>
                                <?php if($column != 'account_id'){ ?>
                                <th><?= lang('account') ?></th>
                                <?php } ?>
                                <?php if($column != 'transaction_type_id'){ ?>
                                <th><?= lang('type') ?></th>
                                <?php } ?>
                                <?php if($column != 'category_id'){ ?>
                                    <th><?= lang('category') ?></th>
                                <?php } ?>
                                <th><?= lang('dr') ?>.</th>
                                <th><?= lang('cr') ?>.</th>
                                <th><?= lang('balance') ?></th>
                                <th><?= lang('date') ?></th>
                                <th style="width:25px;"><?= lang('actions') ?></th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->

    </div>
</div>
<script>
    //var table;
    var list        = 'admin/transaction/transaction_view/<?php echo $column.'-'.$id ?>';

</script>



