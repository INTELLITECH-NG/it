
<div class="row">
    <div class="col-md-12">
        <!-- general form elements -->
        <div class="box box-primary">
            <div class="box-header with-border bg-primary-dark">
                <h3 class="box-title"><?= lang('add_employee') ?></h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <?php echo $form->open(); ?>

            <div class="box-body">

                <!-- View massage -->
                <?php echo $form->messages(); ?>
                <!-- View massage -->
                <?php echo message_box('success'); ?>
                <?php echo message_box('error'); ?>

                <div class="mailbox-controls pull-right">
                    <!-- Check all button -->
                    <a href="<?php echo base_url('admin/employee/importEmployee') ?>" class="btn bg-orange-active"><i class="fa fa-upload" aria-hidden="true"></i> <?= lang('import') ?></a>

                    <!-- /.pull-right -->
                </div>

                <div class="row">
                    <div class="col-md-7 col-sm-12 col-xs-12">

                            <div class="row">

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><?= lang('first_name') ?><span class="required" aria-required="true">*</span></label>
                                        <input type="text" name="first_name" class="form-control">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><?= lang('last_name') ?><span class="required" aria-required="true">*</span></label>
                                        <input type="text" name="last_name" class="form-control">
                                    </div>
                                </div>


                                <div class="col-md-6">

                                    <!-- /.Start Date -->
                                    <div class="form-group form-group-bottom">
                                        <label><?= lang('date_of_birth') ?><span class="required" aria-required="true">*</span></label>

                                        <div class="input-group">
                                            <input type="text" class="form-control" id="datepicker" name="date_of_birth" data-date-format="yyyy/mm/dd">
                                            <div class="input-group-addon">
                                               <i class="fa fa-calendar-o"></i>
                                            </div>
                                        </div>
                                    </div>

                                </div>


                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><?= lang('marital_status') ?></label>
                                        <select class="form-control" name="marital_status">
                                            <option value=""><?= lang('please_select') ?>..</option>
                                            <option value="Singel"><?= lang('singel') ?></option>
                                            <option value="Married"><?= lang('married') ?></option>
                                        </select>
                                    </div>
                                </div>


                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><?= lang('country') ?><span class="required" aria-required="true">*</span></label>
                                        <select class="form-control select2" name="country" >
                                            <option value=""><?= lang('please_select') ?>..</option>
                                            <?php foreach($countries as $item){ ?>
                                                <option value="<?php echo $item->country ?>"><?php echo $item->country ?></option>
                                            <?php } ?>

                                        </select>
                                    </div>
                                </div>


                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><?= lang('blood_group') ?></label>
                                        <select class="form-control select2" name="blood_group">
                                            <option value=""><?= lang('please_select') ?>..</option>
                                            <option value="A">A</option>
                                            <option value="B">B</option>
                                            <option value="AB">AB</option>
                                            <option value="O">O</option>
                                        </select>
                                    </div>
                                </div>

                            </div>

                            <div class="form-group">
                                <label><?= lang('id_number') ?></label>
                                <input type="text" name="id_number" class="form-control">
                            </div>

                            <div class="form-group">
                                <label><?= lang('religious') ?> </label>
                                <select class="form-control select2" name="religious">
                                    <option value="Christians">Christians</option>
                                    <option value="Muslims">Muslims</option>
                                    <option value="Hindus">Hindus</option>
                                    <option value="Buddhists">Buddhists</option>
                                    <option value="Jews">Jews</option>
                                </select>

                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label><?= lang('gender') ?><span class="required" aria-required="true">*</span></label>
                                        <label class="css-input css-radio css-radio-success push-10-r">
                                            <input name="gender" value="Male" checked="" type="radio"><span></span><?= lang('male') ?>
                                        </label>
                                        <label class="css-input css-radio css-radio-success push-10-r">
                                            <input name="gender" value="Female"  type="radio"><span></span><?= lang('female') ?>
                                        </label>
                                    </div>
                                </div>
                            </div>



                            <!-- /.Employee Image -->
                            <div class="form-group">
                                <label><?= lang('Photograph') ?></label>
                            </div>
                            <div class="form-group">
                                <input type="file" name="employee_photo" id="file-1" class="inputfile inputfile-1" data-multiple-caption="{count} files selected"  />
                                <label for="file-1"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17"><path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"/></svg> <span>Choose a file&hellip;</span></label>

                            </div>
                            <!-- /.Employee Image -->
                            <p class="text-muted">Accepts jpg, .png, .gif up to 1MB. Recommended dimensions: 200px X 200px</p>
                            <p class="text-muted"><span class="required" aria-required="true">*</span><?= lang('required_field') ?></p>

                    </div>




                </div>

            </div>
            <!-- /.box-body -->

            <div class="box-footer">
                <?php echo $form->bs4_submit(lang('save_employee')); ?>
            </div>
            <?php echo $form->close(); ?>

        </div>
        <!-- /.box -->

    </div>
</div>