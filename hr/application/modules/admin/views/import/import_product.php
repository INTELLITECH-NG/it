
<!-- Main content -->
<section class="content">
    <div class="row">
        <!-- /.col -->
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        <?= lang('import_Product') ?>
                    </h3>
                    <!-- /.box-tools -->
                </div>
                <!-- /.box-header -->

                <?php echo $form->open(); ?>

                <div class="box-body">

                    <!-- View massage -->
                    <?php echo $form->messages(); ?>
                    <!-- View massage -->
                    <?php echo message_box('success'); ?>
                    <?php echo message_box('error'); ?>

                    <div class="row">
                        <div class="col-md-4">
                            <div id="msg"></div>
                            <div class="row">
                                <div class="col-md-12">

                                    <div class="row">

                                        <div class="col-md-10">

                                            <strong><?= lang('download_sample_csv_file') ?></strong><br/>
                                            <a href="<?php echo site_url('admin/product/downloadProductSample')?>"><i class="fa fa-download" aria-hidden="true"></i> <?= lang('sample_csv_file') ?></a>

                                            <br/>
                                            <br/>
                                            <p>Product Type:</p>
                                            <p>Inventory Product Type use -> '<strong>Inventory</strong>'</p>
                                            <p>Non Inventory Product Type use -> '<strong>Non-Inventory</strong>'</p>
                                            <p>Service Product Type use -> '<strong>Service</strong>'</p>



                                            <div class="form-group">
                                                <label><?= lang('import_Product') ?></label>
                                                <input type="file" name="import" class="form-control">
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <input class="btn bg-navy" name="submit" type="submit" value="<?= lang('import') ?>">
                        </div>

                        <div class="col-md-8">
                            <div class="row">
                                <div class="col-md-12">
                                    <h5>Use Product Category ID and Tax ID when prepare CSV file.</h5>
                                    <br/>
                                    <br/>
                                </div>
                                <div class="col-md-6">
                                    <table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                        <tr>
                                            <th colspan="2">Product Category</th>
                                        </tr>
                                        <tr>
                                            <th>Category ID</th>
                                            <th>Category</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php if(!empty($category)){ foreach ($category as $item){ ?>
                                            <tr>
                                                <td><?= $item->id ?></td>
                                                <td><?= $item->category ?></td>

                                            </tr>
                                        <?php };} ?>
                                        </tbody>
                                    </table>
                                </div>

                                <div class="col-md-6">
                                    <table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                        <tr>
                                            <th colspan="3">Tax Table</th>
                                        </tr>
                                        <tr>
                                            <th>Tax ID</th>
                                            <th><?= lang('tax_rate') ?></th>
                                            <th><?= lang('tax_type') ?></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php if(!empty($tax)){ foreach ($tax as $item){ ?>
                                            <tr>
                                                <td><?= $item->id ?></td>
                                                <td><?= $item->name ?></td>
                                                <td>
                                                    <?php if($item->type == 1){
                                                        echo 'Percentage';
                                                    }else{
                                                        echo 'Fixed';
                                                    } ?>
                                                </td>
                                            </tr>
                                        <?php };} ?>
                                        </tbody>
                                    </table>
                                </div>

                            </div>

                        </div>

                    </div>


                </div>
                <!-- /.box-body -->

                <div class="box-footer">

                </div>
                <?php echo $form->close(); ?>

            </div>
            <!-- /.box -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
</section>
<!-- /.content -->


