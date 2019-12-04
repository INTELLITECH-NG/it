
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
                    <h3 class="box-title">
                        <?= lang('add_new_vendor') ?>
                    </h3>
                    <!-- /.box-tools -->
                </div>
                <!-- /.box-header -->

                <?php echo $form->open(); ?>

<!--                --><?php //echo form_open_multipart('admin/product/save_product')?>

                <div class="box-body">

                    <!-- View massage -->
                    <?php echo $form->messages(); ?>
                    <!-- View massage -->
                    <?php echo message_box('success'); ?>
                    <?php echo message_box('error'); ?>

                    <div class="row">
                        <div class="col-md-7 col-sm-12 col-xs-12 col-md-push-2">
                            <div id="msg"></div>
                            <div class="row">
                                <div class="col-md-12">

                                    <div class="row">

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label><?= lang('contact_person') ?><span class="required" aria-required="true">*</span></label>
                                                <input type="text" name="name" value="<?php if(!empty($vendor->name))echo $vendor->name ?>" class="form-control">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <!-- /.Start Date -->
                                            <div class="form-group form-group-bottom">
                                                <label><?= lang('company_name') ?></label>
                                                <input type="text" name="company_name" class="form-control" value="<?php if(!empty($vendor->company_name))echo $vendor->company_name ?>">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <!-- /.Start Date -->
                                            <div class="form-group form-group-bottom">
                                                <label><?= lang('phone') ?></label>
                                                <input type="text" name="phone" class="form-control" value="<?php if(!empty($vendor->phone))echo $vendor->phone ?>">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <!-- /.Start Date -->
                                            <div class="form-group form-group-bottom">
                                                <label><?= lang('fax') ?></label>
                                                <input type="text" name="fax" class="form-control" value="<?php if(!empty($vendor->fax))echo $vendor->fax ?>">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <!-- /.Start Date -->
                                            <div class="form-group form-group-bottom">
                                                <label><?= lang('email') ?></label>
                                                <input type="text" name="email" class="form-control" value="<?php if(!empty($vendor->email))echo $vendor->email ?>">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <!-- /.Start Date -->
                                            <div class="form-group form-group-bottom">
                                                <label><?= lang('website') ?></label>
                                                <input type="text" name="website" class="form-control" value="<?php if(!empty($vendor->website))echo $vendor->website ?>">
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label><?= lang('billing_address') ?></label>
                                                <textarea class="form-control" name="b_address"><?php if(!empty($vendor->b_address))echo $vendor->b_address ?></textarea>
                                            </div>
                                        </div>





                                    </div>
                                </div>
                            </div>


                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label><?= lang('vendor_note') ?></label>
                                        <textarea class="form-control" name="note"><?php if(!empty($vendor->note))echo $vendor->note ?></textarea>
                                    </div>
                                </div>
                            </div>

                            <input type="hidden" name="id" value="<?php if(!empty($vendor->id))echo $vendor->id ?>">

<!--                            <a href="javascript::" class="btn bg-navy btn-flat" onclick="save_product()" >--><?//= lang('save') ?><!--</a>-->
                            <button class="btn bg-navy" type="submit" value="Submit"><?= lang('save') ?></button>

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


