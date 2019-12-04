
<!-- Main content -->
<section class="content">
    <div class="row">
        <!-- /.col -->
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        <?= lang('import_attendance') ?>
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
                        <div class="col-md-5">
                            <div id="msg"></div>
                            <div class="row">
                                <div class="col-md-12">

                                    <div class="row">

                                        <div class="col-md-10">

                                            <strong><?= lang('download_sample_csv_file') ?></strong><br/>
                                            <p>Import employee attendance use <strong>Employee ID</strong> Search from bellow Table</p>
                                            <p>Attendance Status: 1 = Present | 0 = Absent | 3 = On leave</p>
                                            <p>Date Format: Month/Day/Year | 1/31/2017</p>
                                            <a href="<?php echo site_url('admin/employee/downloadAttendanceSample')?>"><i class="fa fa-download" aria-hidden="true"></i> <?= lang('sample_csv_file') ?></a>

                                            <div class="form-group">
                                                <label><?= lang('import_attendance') ?></label>
                                                <input type="file" name="import" class="form-control">
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <input class="btn bg-navy" name="submit" type="submit" value="<?= lang('import') ?>">
                        </div>

                        <div class="col-md-7">


                            <?php
                            foreach($crud->css_files as $file): ?>
                                <link type="text/css" rel="stylesheet" href="<?php echo $file; ?>" />
                            <?php endforeach; ?>

                            <?php foreach($crud->js_files as $file): ?>
                                <script src="<?php echo $file; ?>"></script>
                            <?php endforeach; ?>

                            <?php   echo $crud->output; ?>
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


