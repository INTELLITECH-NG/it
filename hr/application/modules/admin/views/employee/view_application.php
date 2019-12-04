
<?php echo message_box('success'); ?>
<?php echo message_box('error'); ?>


<div class="row">
    <div class="col-sm-12">

        <div class="row">
            <div class="col-sm-12" data-offset="0">
                <div class="wrap-fpanel">
                    <div class="box box-primary" data-collapsed="0">
                        <div class="box-header with-border bg-primary-dark">
                            <h3 class="box-title"><?= lang('application_view') ?></h3>

                        </div>
                        <div class="panel-body">
                            <?php echo form_open('admin/employee/changeApplicationStatus', array('class' => 'form-horizontal')) ?>

                                <div class="panel_controls">
                                    <div class="form-group margin">
                                        <label class="col-sm-3 control-label"><?= lang('employee_id') ?> :</label>
                                        <div class="col-sm-5" style="padding-top: 5px">
                                            <?php echo $application->employee_id ?>
                                        </div>
                                    </div>

                                    <div class="form-group margin">
                                        <label class="col-sm-3 control-label"><?= lang('employee_name') ?> :</label>
                                        <div class="col-sm-5" style="padding-top: 5px">
                                            <?php echo  $application->first_name.' '.$application->last_name ?>
                                        </div>
                                    </div>

                                    <div class="form-group margin">
                                        <label class="col-sm-3 control-label"><?= lang('leave_date') ?> :</label>
                                        <div class="col-sm-5" style="padding-top: 5px">
                                            <?php echo date(get_option('date_format'), strtotime($application->start_date)).' To '. date(get_option('date_format'), strtotime($application->end_date)) ?>
                                        </div>
                                    </div>

                                    <div class="form-group margin">
                                        <label class="col-sm-3 control-label"><?= lang('leave_type') ?> :</label>
                                        <div class="col-sm-5" style="padding-top: 5px">
                                            <?php echo $application->leave_category ?>
                                        </div>
                                    </div>

                                    <div class="form-group margin">
                                        <label class="col-sm-3 control-label"><?= lang('application_date') ?> :</label>
                                        <div class="col-sm-5" style="padding-top: 5px">
                                            <?php echo date(get_option('date_format'), strtotime($application->application_date)) ?>
                                        </div>
                                    </div>

                                    <div class="form-group margin">
                                        <label class="col-sm-3 control-label"><?= lang('status') ?> :</label>
                                        <div class="col-sm-3" style="padding-top: 5px">
                                            <select class="form-control" name="status">
                                                <option value="pending" <?php echo $application->status == 'Pending' ? 'selected':''  ?>>Pending</option>
                                                <option value="Accepted" <?php echo $application->status == 'Accepted' ? 'selected':''  ?>>Accepted</option>
                                                <option value="Rejected" <?php echo $application->status == 'Rejected' ? 'selected':''  ?>>Rejected</option>
                                            </select>
                                        </div>
                                    </div>

                                    <input type="hidden" name="id" value="<?php echo str_replace(array('+', '/', '='), array('-', '_', '~'), $this->encrypt->encode($application->id)) ?>">


                                    <div class="form-group no-print">
                                        <div class="col-sm-offset-3 col-sm-5">
                                            <button type="submit"  class="btn bg-olive btn-md btn-flat">  <?= lang('save') ?></button>
                                        </div>
                                    </div>

                                </div>
                           <?php echo form_close() ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

