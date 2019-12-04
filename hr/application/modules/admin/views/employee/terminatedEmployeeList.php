<script src="<?php echo site_url('assets/js/ajax.js') ?>"></script>
<div class="row">
    <div class="col-md-12">
        <!-- general form elements -->
        <div class="box box-primary">
            <div class="box-header with-border bg-primary-dark">
                <h3 class="box-title"><?= lang('terminated_employee_list') ?></h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->

            <div class="box-body">

                <!-- View massage -->


                <div class="row">
                    <div class="col-md-12">


                        <div id="msg"></div>


                        <table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th><?= lang('employee_id') ?></th>
                                <th><?= lang('employee_name') ?></th>
                                <th><?= lang('department') ?></th>
                                <th><?= lang('job_title') ?></th>
                                <th><?= lang('employment_status') ?></th>
                                <th><?= lang('shift') ?></th>
                                <th style="width:125px;"><?= lang('actions') ?></th>
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
    var list        = 'admin/employee/terminatedEmployeeTable';
    //var list        = '';
</script>


