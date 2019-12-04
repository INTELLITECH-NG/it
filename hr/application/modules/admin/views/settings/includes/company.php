
<div class="row">
    <div class="col-md-12">
        <!-- general form elements -->
        <div class="box box-primary">
            <div class="box-header with-border bg-primary-dark">
                <h3 class="box-title">General Settings</h3>
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

                        <?php echo $form->bs3_text(lang('company_name'), 'settings[company_name]', get_option('company_name')); ?>
                        <?php echo $form->bs3_text(lang('address'), 'settings[address]' , get_option('address')); ?>
                        <?php echo $form->bs3_email(lang('email'), 'settings[email]' , get_option('email')); ?>
                        <?php echo $form->bs3_text(lang('city'), 'settings[city]' , get_option('city')); ?>
                        <?php echo $form->bs3_text(lang('postal_code'), 'settings[postal_code]' , get_option('postal_code')); ?>
                        <?php echo $form->bs3_text(lang('phone'), 'settings[phone]' , get_option('phone')); ?>


                    </div>

                    <div class="col-md-6 col-sm-12 col-xs-12">

                        <div class="row">
                            <div class="col-md-6">
                                <?php $company_logo = get_option('company_logo') ?>
                                <?php if($company_logo != ''){ ?>
                                    <div class="row" style="padding-top: 25px; padding-bottom: 30px">
                                        <div class="col-md-6">
                                            <label><?= lang('company_logo') ?></label>
                                            <img height="80" width="80" src="<?php echo site_url(UPLOAD_LOGO.$company_logo)?>" class="img img-responsive">
                                        </div>
                                        <div class="col-md-6 text-left" style="padding-top: 20px">
                                            <a data-original-title="<?= lang('delete') ?>" data-toggle="tooltip" title="" class="btn btn-xs btn-danger"
                                               onClick="return confirm('<?= lang('are_you_sure_you_want_to_delete')?>')"
                                               href="<?php echo site_url('admin/settings/remove/company_logo') ?>"><i class="fa fa-remove"></i></a>
                                        </div>
                                    </div>

                                <?php } else { ?>
                                    <div class="form-group">
                                        <label><?= lang('company_logo') ?></label>
                                        <div class="box">
                                            <input type="file" name="company_logo" id="file-1" class="inputfile inputfile-1" data-multiple-caption="{count} files selected"  />
                                            <label for="file-1"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17"><path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"/></svg> <span>Choose a file&hellip;</span></label>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                            <div class="col-md-6">
                                <?php $icon = get_option('icon') ?>
                                <?php if($icon != ''){ ?>
                                    <div class="row" style="padding-top: 15px; padding-bottom: 30px">
                                        <div class="col-md-6">
                                            <label><?= lang('fav_icon') ?></label>
                                            <img width="20" height="20" src="<?php echo site_url(UPLOAD_LOGO.$icon)?>" class="img img-responsive">
                                        </div>
                                        <div class="col-md-6 text-left" style="padding-top: 20px">
                                            <a data-original-title="<?= lang('delete') ?>" data-toggle="tooltip" title="" class="btn btn-xs btn-danger"
                                               onClick="return confirm('<?= lang('are_you_sure_you_want_to_delete')?>')"
                                               href="<?php echo site_url('admin/settings/remove/icon') ?>"><i class="fa fa-remove"></i></a>
                                        </div>
                                    </div>
                                <?php } else { ?>
                                    <div class="form-group">
                                        <label><?= lang('fav_icon') ?></label>
                                        <div class="box">
                                            <input type="file" name="icon" id="file-2" class="inputfile inputfile-1" data-multiple-caption="{count} files selected"  />
                                            <label for="file-2"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17"><path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"/></svg> <span>Choose a file&hellip;</span></label>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>

                        <hr/>

                        <div class="row">

                            <div class="col-md-12">
                                <?php echo $form->bs3_text(lang('brand'), 'settings[brand]', get_option('brand')); ?>
                                <?php $login_logo = get_option('login_logo') ?>
                                <?php if($login_logo != ''){ ?>
                                    <div class="row" style="padding-top: 25px; padding-bottom: 30px">
                                        <div class="col-md-6">
                                            <label><?= lang('login_logo') ?></label>
                                            <img height="80" width="80" src="<?php echo site_url(UPLOAD_LOGO.$login_logo)?>" class="img img-responsive">
                                        </div>
                                        <div class="col-md-6 text-left" style="padding-top: 20px">
                                            <a data-original-title="<?= lang('delete') ?>" data-toggle="tooltip" title="" class="btn btn-xs btn-danger"
                                               onClick="return confirm('<?= lang('are_you_sure_you_want_to_delete')?>')"
                                               href="<?php echo site_url('admin/settings/remove/login_logo') ?>"><i class="fa fa-remove"></i></a>
                                        </div>
                                    </div>

                                <?php } else { ?>
                                    <div class="form-group">
                                        <label><?= lang('login_logo') ?></label>
                                        <div class="box">
                                            <input type="file" name="login_logo" id="file-1" class="inputfile inputfile-1" data-multiple-caption="{count} files selected"  />
                                            <label for="file-1"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17"><path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"/></svg> <span>Choose a file&hellip;</span></label>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>

                            <div class="col-md-12">
                                <?php echo $form->bs3_text(lang('login_title'), 'settings[login_title]', get_option('login_title')); ?>
                                <?php echo $form->bs3_text(lang('login_description'), 'settings[login_description]' , get_option('login_description')); ?>
                            </div>


                        </div>


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