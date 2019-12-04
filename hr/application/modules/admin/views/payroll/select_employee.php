
<?php echo message_box('success'); ?>
<?php echo message_box('error'); ?>


<div class="row">
    <div class="col-sm-12">

        <div class="row">
            <div class="col-sm-12" data-offset="0">
                <div class="wrap-fpanel">
                    <div class="box box-primary" data-collapsed="0">
                        <div class="box-header with-border bg-primary-dark">
                            <h3 class="box-title"><?= lang('make_payment') ?></h3>
                        </div>
                        <div class="panel-body">

                                <?php echo form_open('admin/payroll/setEmployeePayment', array('class' => 'form-horizontal')) ?>
                                <div class="panel_controls">


                                    <div class="form-group">
                                        <label for="field-1" class="col-sm-3 control-label"><?= lang('department') ?> <span class="required">*</span></label>

                                        <div class="col-sm-5">
                                            <select class="form-control select2" name="department_id" id="department" onchange="get_employee(this.value)">
                                                <option value="" ><?= lang('select_department') ?>...</option>
                                                <?php foreach ($department as $v_department) : ?>
                                                    <option value="<?php echo $v_department->id ?>" >
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
