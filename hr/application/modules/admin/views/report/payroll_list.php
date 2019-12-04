<style>
    .dataTables_filter {
        display: none;
    }
    .dataTables_info{
        display: none;
    }
</style>
<?php echo message_box('success'); ?>
<?php echo message_box('error'); ?>


<div class="row">
    <div class="col-sm-12">

        <div class="row">
            <div class="col-sm-12" data-offset="0">
                <div class="wrap-fpanel">
                    <div class="box box-primary" data-collapsed="0">
                        <div class="box-header with-border bg-primary-dark">
                            <h3 class="box-title"><?= lang('payroll') ?></h3>
                        </div>
                        <div class="panel-body">
                            <?php echo form_open('admin/reports/payrollList', array('class' => 'form-horizontal')) ?>
                            <div class="panel_controls">
                                <div class="form-group margin">
                                    <label class="col-sm-3 control-label"><?= lang('from') ?><span class="required">*</span></label>

                                    <div class="col-sm-5">
                                        <div class="input-group">
                                            <input type="text" name="from"   class="form-control monthyear" value="" >
                                            <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="form-group margin">
                                    <label class="col-sm-3 control-label"><?= lang('to') ?><span class="required">*</span></label>

                                    <div class="col-sm-5">
                                        <div class="input-group">
                                            <input type="text" name="to"   class="form-control monthyear" value="" >
                                            <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="field-1" class="col-sm-3 control-label"><?= lang('department') ?> <span class="required">*</span></label>

                                    <div class="col-sm-5">
                                        <select name="department_id" id="department" class="form-control" onchange="get_employee(this.value)">
                                            <option value="" ><?= lang('select_department') ?>...</option>
                                            <?php foreach ($all_department as $v_department) : ?>
                                                <option value="<?php echo $v_department->id ?>">
                                                    <?php echo $v_department->department ?></option>
                                            <?php endforeach; ?>

                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="field-1" class="col-sm-3 control-label"><?= lang('employee') ?> <span class="required">*</span></label>

                                    <div class="col-sm-5">
                                        <select class="form-control select2" name="employee_id" id="employee" >
                                            <option value=""><?= lang('please_select') ?></option>
                                            <?php foreach($employee as $item){ ?>
                                                <option value="<?php echo $item->id ?>" >
                                                    <?php echo  $item->first_name.' '.$item->last_name ?>
                                                </option>
                                            <?php } ?>

                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-sm-offset-3 col-sm-5">
                                        <button type="submit" id="sbtn" name="sbtn" value="1" class="btn bg-olive btn-flat btn-md"><?= lang('submit') ?></button>
                                    </div>
                                </div>
                            </div>

                            <input type="hidden" name="flag" value="1">
                            <?php echo form_close() ?>




                            <table class="table table-striped table-bordered display-all" cellspacing="0" width="100%">

                                <thead>
                                <tr>
                                    <td colspan="9">
                                        <strong><?php if(!empty($employee)) echo $employee->first_name.' '.$employee->last_name?>  <?= lang('payroll') ?> <?= lang('report') ?></strong>
                                    </td>
                                </tr>
                                <tr>
                                    <th><?= lang('salary_month') ?></th>
                                    <th><?= lang('gross_salary') ?></th>
                                    <th><?= lang('deduction') ?></th>
                                    <th><?= lang('net_salary') ?></th>
                                    <th><?= lang('award') ?></th>
                                    <th><?= lang('fine_deduction') ?></th>
                                    <th><?= lang('bonus') ?></th>
                                    <th><?= lang('payment_amount') ?></th>
                                    <th><?= lang('payment_method') ?></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php if(!empty($payroll)){ foreach ($payroll as $item){ ?>
                                    <tr>
                                        <td><?= $item->month ?></td>
                                        <td><?= currency($item->gross_salary)?></td>
                                        <td><?= currency($item->deduction)?></td>
                                        <td><?= currency($item->net_salary)?></td>
                                        <?php $award = json_decode($item->award); ?>
                                        <td><?php if(!empty($award[0]->award_amount)) echo currency($award[0]->award_amount)?></td>
                                        <td><?= currency($item->fine_deduction)?></td>
                                        <td><?= currency($item->bonus)?></td>
                                        <td><?= currency($item->net_payment)?></td>
                                        <td><?= $item->payment_method?></td>

                                    </tr>

                                <?php };} ?>



                                </tbody>



                            </table>




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
            $('#date1').datepicker({
                autoclose: true,
                format: "yyyy-mm-dd",
            });
        });
    </script>

