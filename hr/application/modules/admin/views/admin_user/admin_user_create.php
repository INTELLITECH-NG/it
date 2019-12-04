
<div class="row">
    <div class="col-md-12">
        <!-- general form elements -->
        <div class="box box-primary">
            <div class="box-header with-border bg-primary-dark">
                <h3 class="box-title"><?= lang('create_employee') ?></h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <?php echo $form->open(); ?>

            <div class="box-body">

                <!-- View massage -->
                <?php echo $form->messages(); ?>

                <div class="row">
                    <div class="col-md-6 col-sm-12 col-xs-12">

                        <?php echo $form->bs3_text(lang('username'), 'username'); ?>
                        <?php echo $form->bs3_text(lang('first_name'), 'first_name'); ?>
                        <?php echo $form->bs3_text(lang('last_name'), 'last_name'); ?>
                        <?php echo $form->bs3_email(lang('email'), 'email'); ?>
                        <?php echo $form->bs3_password(lang('password'), 'password'); ?>
                        <?php echo $form->bs3_password(lang('retype_password'), 'retype_password'); ?>

                        <?php if ( !empty($groups) ): ?>
                            <div class="form-group">
                                <label for="groups"><?= lang('group') ?></label>
                                <div>
                                    <select class="form-control" name="groups[]">
                                        <option value=""><?= lang('select_group') ?>...</option>
                                    <?php foreach ($groups as $group): ?>
                                        <option value="<?php echo $group->id; ?>"><?php echo $group->description; ?></option>
                                    <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        <?php endif; ?>


                    </div>




                </div>

            </div>
            <!-- /.box-body -->

            <div class="box-footer">
                <?php echo $form->bs4_submit(lang('submit')); ?>
            </div>
            <?php echo $form->close(); ?>

        </div>
        <!-- /.box -->

    </div>
</div>