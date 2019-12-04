
<div class="row">
    <div class="col-md-12">
        <!-- general form elements -->
        <div class="box box-primary">
            <div class="box-header with-border bg-primary-dark">
                <h3 class="box-title"><?= lang('localization_settings') ?></h3>
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

                        <!-- Country-->
                        <div class="form-group">
                            <label><?= lang('country') ?></label>
                            <select class="form-control select2" style="width: 100%;" name="settings[country]">
                                <?php foreach($countries as $item){ ?>
                                    <option value="<?php echo $item->country ?>" <?php echo get_option('country') == $item->country ? 'selected="selected"':'' ?>><?php echo $item->country  ?></option>
                                <?php } ?>
                            </select>
                        </div>

                        <!-- Time Zone-->
                        <div class="form-group">
                            <label><?= lang('time_zone') ?></label>
                            <select class="form-control select2" style="width: 100%;" name="settings[time_zone]">
                                <?php foreach ($timezones as $timezone => $description) : ?>
                                    <option value="<?php echo $timezone ?>" <?php echo get_option('time_zone') == $timezone ? 'selected="selected"':'' ?>>
                                        <?php echo $description ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Currency-->
                        <div class="form-group">
                            <label><?= lang('default_currency') ?></label>
                            <select class="form-control select2" style="width: 100%;" name="settings[default_currency]">
                                <?php foreach ($countries as $item) : ?>
                                    <option value="<?php echo $item->currency_code ?>" <?php echo get_option('default_currency') == $item->currency_code ? 'selected="selected"':'' ?>>
                                        <?php echo $item->currency_code .' - '. $item->country  ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <?php echo $form->bs2_text('Currency Symbol', 'settings[currency_symbol]', get_option('currency_symbol')); ?>

                        <!-- Currency Format-->
                        <div class="form-group">
                            <label><?= lang('currency_format') ?></label>
                            <select class="form-control select2" style="width: 100%;" name="settings[currency_format]">
                                <option value="1" <?php echo get_option('currency_format') == 1 ? 'selected="selected"':'' ?>>
                                    1234.56
                                </option>
                                <option value="2" <?php echo get_option('currency_format') == 2 ? 'selected="selected"':'' ?>>
                                    1,234.56
                                </option>
                                <option value="3" <?php echo get_option('currency_format') == 3 ? 'selected="selected"':'' ?>>
                                    1234,56
                                </option>
                                <option value="4" <?php echo get_option('currency_format') == 4 ? 'selected="selected"':'' ?>>
                                    1.234,56
                                </option>
                                <option value="5" <?php echo get_option('currency_format') == 5 ? 'selected="selected"':'' ?>>
                                    1,234
                                </option>
                            </select>
                        </div>

                        <!-- Date Format-->
                        <div class="form-group">
                            <label><?= lang('date_format') ?></label>
                            <select class="form-control select2" style="width: 100%;" name="settings[date_format]">
                                <option value="d/m/Y" <?php echo get_option('date_format') == 'd/m/Y' ? 'selected="selected"':'' ?> >20/07/2015</option>
                                <option value="d.m.Y" <?php echo get_option('date_format') == 'd.m.Y' ? 'selected="selected"':'' ?> >20.07.2015</option>
                                <option value="d-m-Y" <?php echo get_option('date_format') == 'd-m-Y' ? 'selected="selected"':'' ?> >20-07-2015</option>
                                <option value="m/d/Y" <?php echo get_option('date_format') == 'm/d/Y' ? 'selected="selected"':'' ?> >07/20/2015</option>
                                <option value="Y/m/d" <?php echo get_option('date_format') == 'Y/m/d' ? 'selected="selected"':'' ?> >2015/07/20</option>
                                <option value="Y-m-d" <?php echo get_option('date_format') == 'Y-m-d' ? 'selected="selected"':'' ?> >2015-07-20</option>
                                <option value="M d Y" <?php echo get_option('date_format') == 'M d Y' ? 'selected="selected"':'' ?> >Jul 20 2015</option>
                                <option value="d M Y" <?php echo get_option('date_format') == 'd M Y' ? 'selected="selected"':'' ?> >20 Jul 2015</option>
                            </select>
                        </div>



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