<script src="<?php echo site_url('assets/js/ajax.js') ?>"></script>
<!-- View massage -->
<?php echo message_box('success'); ?>
<?php echo message_box('error'); ?>
<div class="row">
    <div class="col-md-12">
        <!-- general form elements -->
        <div class="box box-primary">
            <div class="box-header with-border bg-primary-dark">
                <h3 class="box-title"><?= lang('employee_award') ?></h3>
                <div class="box-tools" style="padding-top: 5px">
                    <div class="input-group input-group-sm" >
                        <a  data-target="#modalSmall" title="View" data-placement="top" data-toggle="modal"
                            href="<?php echo base_url()?>admin/employee/add_award" class="btn bg-blue-active btn-sm btn-flat">
                            <i class="fa fa-plus"></i> <?= lang('add_award') ?>
                        </a>
                    </div>
                </div>
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
                                <th><?= lang('award_name') ?></th>
                                <th><?= lang('gift_item') ?></th>
                                <th><?= lang('award_amount') ?></th>
                                <th><?= lang('month') ?></th>
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
    var list        = 'admin/employee/employeeAwardTable';
    //var list        = '';
</script>


