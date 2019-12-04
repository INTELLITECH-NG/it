
<div class="row">
    <div class="col-md-12">
        <!-- general form elements -->
        <div class="box box-primary">
            <div class="box-header with-border bg-primary-dark">
                <h3 class="box-title"><?= lang('Email Address Settings') ?></h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <?php echo form_open('admin/settings/save_settings', $attribute= array('enctype' => "multipart/form-data")); ?>

            <div class="box-body">

                <!-- View massage -->
                <?php echo message_box('success'); ?>
                <?php echo message_box('error'); ?>

                <div class="row">
                    <div class="col-md-6 col-sm-12 col-xs-12">

                        <?php echo $form->bs3_text( lang('mail_sender') , 'settings[mail_sender]', get_option('mail_sender')); ?>
<!--                        --><?php //echo $form->bs3_email(lang('invoice_mail_from'), 'settings[invoice_mail_from]' , get_option('invoice_mail_from')); ?>
<!--                        --><?php //echo $form->bs3_email(lang('campaign_mail_from'), 'settings[campaign_mail_from]' , get_option('campaign_mail_from')); ?>
                        <?php echo $form->bs3_email(lang('recovery_mail_from'), 'settings[recovery_mail_from]' , get_option('recovery_mail_from')); ?>
                        <?php echo $form->bs3_email(lang('all_other_mails_from'), 'settings[all_other_mails_from]' , get_option('all_other_mails_from')); ?>



                    </div>

                    <div class="col-md-6 col-sm-12 col-xs-12">


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