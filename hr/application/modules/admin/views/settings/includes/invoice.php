
<div class="row">
    <div class="col-md-12">
        <!-- general form elements -->
        <div class="box box-primary">
            <div class="box-header with-border bg-primary-dark">
                <h3 class="box-title"><?= lang('invoice_settings') ?></h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <?php echo form_open('admin/settings/save_settings', $attribute= array('enctype' => "multipart/form-data")); ?>

            <div class="box-body">

                <!-- View massage -->
                <?php echo message_box('success'); ?>
                <?php echo message_box('error'); ?>

                <div class="row">
                    <div class="col-md-7 col-sm-12 col-xs-12">

                        <?php echo $form->bs3_text(lang('invoice_prefix'), 'settings[invoice_prefix]', get_option('invoice_prefix')); ?>
                        <?php echo $form->bs3_text(lang('order_prefix'), 'settings[order_prefix]', get_option('order_prefix')); ?>

                        <?php $invoice_logo = get_option('invoice_logo') ?>
                        <?php if($invoice_logo != ''){ ?>
                            <div class="row" style="padding-top: 25px; padding-bottom: 30px">
                                <div class="col-md-4">
                                    <label><?= lang('invoice_logo') ?></label>
                                    <img height="80" width="80" src="<?php echo site_url(UPLOAD_LOGO.$invoice_logo)?>" class="img img-responsive">
                                </div>
                                <div class="col-md-8 text-left" style="padding-top: 20px">
                                    <a data-original-title="<?= lang('delete') ?>" data-toggle="tooltip" title="" class="btn btn-xs btn-danger"
                                       onClick="return confirm('<?= lang('are_you_sure_you_want_to_delete')?>')"
                                       href="<?php echo site_url('admin/settings/remove/invoice_logo') ?>"><i class="fa fa-remove"></i></a>
                                </div>
                            </div>
                            <hr/>
                        <?php } else { ?>
                            <div class="form-group">
                                <label><?= lang('invoice_logo') ?></label>
                                <div class="box">
                                    <input type="file" name="invoice_logo" id="file-1" class="inputfile inputfile-1" data-multiple-caption="{count} files selected"  />
                                    <label for="file-1"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17"><path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"/></svg> <span>Choose a file&hellip;</span></label>
                                </div>
                            </div>
                        <?php } ?>

                        <div class="form-group">
                            <label><?= lang('invoice_text') ?></label>
                            <div class="box">
                                <textarea class="textarea"  name="settings[invoice_text]"
                                          style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"><?php echo get_option('invoice_text') ?>
                                </textarea>
                            </div>
                        </div>



                    </div>

                    <div class="col-md-5 col-sm-12 col-xs-12">


                    </div>


                </div>

            </div>
            <!-- /.box-body -->
            <input type="hidden" name="tab" value="<?= $tab ?>">

            <div class="box-footer">
                <?php echo $form->bs4_submit(lang('save_settings')); ?>
            </div>
            <?php echo form_close(); ?>

        </div>
        <!-- /.box -->

    </div>
</div>

