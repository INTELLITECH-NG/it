<div class="row">
    <div class="col-md-12">

        <?php echo message_box('success'); ?>
        <?php echo message_box('error'); ?>
        <!-- general form elements -->
        <div class="box box-primary">
            <div class="box-header with-border bg-primary-dark">
                <h3 class="box-title"><?= lang('employee_list') ?></h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->

            <!-- View massage -->



            <div class="box-body">

                <!-- View massage -->
                <div class="row">
                    <div class="col-md-12">



                        <table id="datatable-buttons" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>
                                        <?= lang('group') ?>
                                    </th>
                                    <th>
                                        <?= lang('username') ?>
                                    </th>
                                    <th>
                                        <?= lang('name') ?>
                                    </th>
                                    <th>
                                        <?= lang('email') ?>
                                    </th>
                                    <th>
                                        <?= lang('active') ?>
                                    </th>
                                    <th class="text-center">
                                        <?= lang('actions') ?>
                                    </th>
                                </tr>
                            </thead>


                            <tbody>
                                <?php if(!empty($employees)){ ?>
                                    <?php foreach($employees as $employee){ ?>
                                        <tr>
                                            <td>
                                                <?php echo $employee->description ?>
                                            </td>
                                            <td>
                                                <?php echo $employee->username ?>
                                            </td>
                                            <td>
                                                <?php echo $employee->first_name.' '.$employee->last_name ?>
                                            </td>
                                            <td>
                                                <?php echo $employee->email ?>
                                            </td>
                                            <td>
                                                <label class="css-input switch switch-sm switch-success">
                                                    <input id="<?php echo str_replace(array('+', '/', '='), array('-', '_', '~'), $this->encrypt->encode($employee->user_id)) ?>" <?php echo $employee->active == 1 ? 'checked':'' ?> type="checkbox" onclick='adminUserActivation(this)'><span></span>
                                                </label>
                                            </td>
                                            <td class="text-center">
                                                <div class="btn-group">
                                                    <a data-original-title="<?= lang('reset_password') ?>"
                                                       href="<?php echo base_url('admin/panel/admin_user_reset_password/'.str_replace(array('+', '/', '='), array('-', '_', '~'), $this->encrypt->encode($employee->user_id))) ?>"
                                                       class="btn btn-xs btn-default" type="button" data-toggle="tooltip" title=""><i class="fa fa-key"></i></a>
                                                    <a data-original-title="<?= lang('edit_user') ?>"
                                                       href="<?php echo base_url('admin/panel/update_profile/'.str_replace(array('+', '/', '='), array('-', '_', '~'), $this->encrypt->encode($employee->user_id))) ?>"
                                                       class="btn btn-xs bg-gray" type="button" data-toggle="tooltip" title=""><i class="fa fa-pencil"></i></a>
                                                    <a data-original-title="<?= lang('remove_employee') ?>" onClick="return confirm('Are you sure you want to delete?')"
                                                       href="<?php echo base_url('admin/panel/delete_employee/'. str_replace(array('+', '/', '='), array('-', '_', '~'), $this->encrypt->encode($employee->user_id))) ?>"
                                                       class="btn btn-xs btn-danger" type="button" data-toggle="tooltip" title=""><i class="fa fa-times"></i></a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                <?php } ?>
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