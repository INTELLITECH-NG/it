
<?php echo message_box('success'); ?>
<?php echo message_box('error'); ?>


<div class="row">
    <div class="col-sm-12">

        <div class="row">
            <div class="col-sm-12" data-offset="0">
                <div class="wrap-fpanel">
                    <div class="box box-primary" data-collapsed="0">
                        <div class="box-header with-border bg-primary-dark">
                            <h3 class="box-title"><?= lang('employee_payroll_list') ?></h3>
                        </div>
                        <div class="panel-body">

                                <?php echo form_open('admin/payroll/listSalaryPayment', array('class' => 'form-horizontal')) ?>
                                <div class="panel_controls">


                                    <div class="form-group">
                                        <label for="field-1" class="col-sm-3 control-label"><?= lang('department') ?> <span class="required">*</span></label>

                                        <div class="col-sm-5">
                                            <select class="form-control select2" name="department_id" id="department">
                                                <option value="" ><?= lang('select_department') ?>...</option>
                                                <?php foreach ($department as $v_department) : ?>
                                                    <option value="<?php echo $v_department->id ?>" >
                                                        <?php echo $v_department->department ?></option>
                                                <?php endforeach; ?>

                                            </select>
                                        </div>
                                    </div>


                                    <div class="form-group margin">
                                        <label class="col-sm-3 control-label"><?= lang('month') ?> <span class="required">*</span></label>

                                        <div class="col-sm-5">
                                            <div class="input-group">
                                                <input type="text" name="month" class="form-control monthyear" value="<?php
                                                if (!empty($date)) {
                                                    echo date('Y-n', strtotime($date));
                                                }
                                                ?>" >
                                                <div class="input-group-addon">
                                                    <i class="fa fa-calendar"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-sm-offset-3 col-sm-5">
                                            <button type="submit" id="sbtn" name="sbtn" value="1" class="btn bg-olive btn-md btn-flat"><?= lang('go') ?></button>
                                        </div>
                                    </div>
                                </div>
                           <?php echo form_close() ?>



                            <?php if(!empty($payroll_list)){ ?>
                            <table id="datatable" class="table table-striped table-bordered datatable-buttons">
                                <thead ><!-- Table head -->
                                <tr>
                                    <th><?= lang('employee_id') ?></th>
                                    <th><?= lang('employee_name') ?></th>

                                    <th><?= lang('job_title') ?></th>
                                    <th><?= lang('gross_salary') ?></th>
                                    <th><?= lang('payment_amount') ?></th>
                                    <th><?= lang('month') ?></th>
                                    <th style="width:125px;"><?= lang('actions') ?></th>

                                </tr>
                                </thead><!-- / Table head -->
                                <tbody><!-- / Table body -->

                                <?php foreach ($payroll_list as $item) : ?>
                                    <tr class="custom-tr">
                                        <td class="vertical-td"><?php echo $item->termination == 0 ? '<span class="label bg-red">'.$item->employee_id .'</span>':$item->employee_id ?></td>
                                        <td class="vertical-td"><?php echo $item->first_name. $item->last_name ?></td>

                                        <td class="vertical-td"><?php echo $item->job_title ?></td>
                                        <td class="vertical-td"><?php echo $this->localization->currencyFormat($item->gross_salary) ?></td>

                                        <td class="vertical-td"><?php echo $this->localization->currencyFormat($item->net_payment) ?></td>
                                        <td class="vertical-td"><?php echo date("F, Y", strtotime($item->month));  ?></td>

                                        <td class="vertical-td">

                                            <div class="btn-group">
                                                <a href="<?php echo base_url().'admin/payroll/employeePaySlip/'. str_replace(array('+', '/', '='), array('-', '_', '~'), $this->encrypt->encode($item->id)) ?>" class="btn btn-xs btn-default" ><i class="fa fa-search" aria-hidden="true"></i></a>
                                            </div>
                                        </td>

                                    </tr>
                                    <?php endforeach;  ?><!--get all sub category if not this empty-->

                                </tbody><!-- / Table body -->
                            </table> <!-- / Table -->

                        <?php } ?>





                        </div>
                    </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(function() {
        $('#date').datepicker({
            autoclose: true,
            format: "yyyy-mm-dd",
        });
    });
</script>
