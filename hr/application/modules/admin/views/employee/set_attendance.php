<script type="text/javascript" src="<?php echo base_url()?>assets/js/attendance.js"></script>
<?php echo message_box('success'); ?>
<?php echo message_box('error'); ?>

<style>
    div[id="l_category"]{
        display: none;

    }
    input[class="child_absent"]:checked ~ div[id="l_category"]{
        display:block;
    }
    .child_absent{
        float: left;
    }


    div[id="check_in"]{
        display: none;
    }
    input[class="child_present"]:checked ~ div[id="check_in"]{
        display:block;
    }
    .child_present{
        float: left;
    }

</style>

<div class="row">
    <div class="col-sm-12">

        <div class="row">
            <div class="col-sm-12" data-offset="0">
                <div class="wrap-fpanel">
                    <div class="box box-primary" data-collapsed="0">
                        <div class="box-header with-border bg-primary-dark">
                            <h3 class="box-title"><?= lang('set_attendance') ?></h3>
                        </div>
                        <div class="panel-body">

                            <div class="mailbox-controls pull-right">
                                <!-- Check all button -->
                                <a href="<?php echo base_url('admin/employee/importAttendance') ?>" class="btn bg-orange-active"><i class="fa fa-upload" aria-hidden="true"></i> <?= lang('import') ?></a>

                                <!-- /.pull-right -->
                            </div>


                            <?php echo form_open('admin/employee/setAttendance', array('class' => 'form-horizontal')) ?>
                                <div class="panel_controls">
                                    <div class="form-group margin">
                                        <label class="col-sm-3 control-label"><?= lang('date') ?> <span class="required">*</span></label>

                                        <div class="col-sm-5">
                                            <div class="input-group">
                                                <input type="text" name="date" id="date"  class="form-control" value="<?php
                                                if (!empty($date)) { echo $date;}else{ echo date('Y-m-d');}
                                                ?>" data-format="dd-mm-yyyy">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-calendar"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="field-1" class="col-sm-3 control-label"><?= lang('department') ?> <span class="required">*</span></label>

                                        <div class="col-sm-5">
                                            <select name="department_id" id="department" class="form-control select2">
                                                <option value="" ><?= lang('select_department') ?>...</option>
                                                <?php foreach ($all_department as $v_department) : ?>
                                                    <option value="<?php echo $v_department->id ?>"
                                                        <?php
                                                        if (!empty($department_id)) {
                                                            echo $v_department->id == $department_id ? 'selected' : '';
                                                        }
                                                        ?>
                                                    >
                                                        <?php echo $v_department->department ?></option>
                                                <?php endforeach; ?>

                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-offset-3 col-sm-5">
                                            <button type="submit" id="sbtn" name="sbtn" value="1" class="btn bg-olive btn-md btn-flat"><?= lang('go') ?></button>
                                        </div>
                                    </div>
                                </div>
                           <?php echo form_close() ?>

<!--                            --><?php
//
//                            echo '<pre>';
//                            print_r($employee_info);
//                            exit();
//
//                            ?>

                            <?php if (!empty($employee_info)): ?>

                            <?php echo form_open('admin/employee/save_attendance')?>

                                <table class="table table-hover table-bordered">
                                    <thead>
                                    <tr>
                                        <th class="active"><?= lang('employee_id') ?></th>
                                        <th class="active"><?= lang('employee') ?></th>
                                        <th class="active"><?= lang('job_title') ?></th>
                                        <th class="active">
                                            <label class="css-input css-checkbox css-checkbox-success">
                                                <input type="checkbox" class="checkbox-inline select_one" id="parent_present"><span></span> <?= lang('attendance') ?>
                                            </label>
                                        </th>
                                        <th class="active">
                                            <label class="css-input css-checkbox css-checkbox-danger">
                                                <input type="checkbox" class="checkbox-inline select_one" id="parent_absent"><span></span> <?= lang('leave_category') ?>
                                            </label>
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    <?php foreach ($employee_info as $v_employee) { ?>
                                        <tr>

                                            <td> <?php echo $v_employee->employee_id ?> </td>

                                            <td>
                                                <input type="hidden" name="date" value="<?php echo $date ?>">
                                                <?php
                                                foreach ($atndnce as $atndnce_status) {
                                                    if (!empty($atndnce_status)) {
                                                        if ($v_employee->id == $atndnce_status->employee_id) {
                                                            ?>
                                                            <input type="hidden" name="attendance_id[]" value="<?php if ($atndnce_status) echo $atndnce_status->attendance_id ?>">
                                                            <?php
                                                        }
                                                    }
                                                }
                                                ?>

                                                <input type="hidden" name="employee_id[]"  value="<?php echo $v_employee->id ?>"> <?php echo $v_employee->first_name . ' ' . $v_employee->last_name; ?>

                                            </td>

                                            <?php

                                            $job_title = $this->db->get_where('job_title', array(
                                                'id' => $v_employee->title
                                            ))->row()->job_title;

                                            ?>

                                            <td><?php echo $job_title ?></td>

                                            <td>

                                                <input  name="attendance[]"
                                                    <?php
                                                    foreach ($atndnce as $atndnce_status) {
                                                        if ($atndnce_status) {
                                                            if ($v_employee->id == $atndnce_status->employee_id) {
                                                                echo $atndnce_status->attendance_status == 1 ? 'checked ' : '';
                                                            }
                                                        }
                                                    }
                                                    ?> id="<?php echo $v_employee->id ?>" value="<?php echo $v_employee->id ?>" type="checkbox" class="child_present">

                                                <div id="check_in" class="col-sm-8">
                                                    <?php
                                                    foreach ($atndnce as $atndnce_status) {
                                                        if (!empty($atndnce_status)) {
                                                            if ($v_employee->id == $atndnce_status->employee_id) {
                                                               $inTime = date("h:i A", strtotime($atndnce_status->in_time));
                                                               $out_time = date("h:i A", strtotime($atndnce_status->out_time));
                                                            }
                                                        }
                                                    }
                                                    ?>
                                                        <div class="form-group row">
                                                            <label class="col-md-1 control-label">In</label>
                                                            <div class="col-md-4">
                                                                <div class="input-group bootstrap-timepicker timepicker">
                                                                    <input type="text" class="form-control timepicker" name="in[]" value="<?php if(!empty($inTime)){ echo $inTime; }else{ echo '10:00 AM'; }?>">
                                                                </div>
                                                            </div>
                                                            <label for="inputValue" class="col-md-1 control-label">Out</label>
                                                            <div class="col-md-4">
                                                                <div class="input-group bootstrap-timepicker timepicker">
                                                                    <input type="text" class="form-control timepicker" name="out[]" value="<?php if(!empty($out_time)){ echo $out_time; }else{ echo '05:00 PM'; }?>">
                                                                </div>
                                                            </div>
                                                        </div>

                                                </div>


                                            </td>

                                            <td style="width: 35%">

                                                <input id="<?php echo $v_employee->id ?>" type="checkbox"
                                                    <?php
                                                    foreach ($atndnce as $atndnce_status) {
                                                        if ($atndnce_status) {
                                                            if ($v_employee->id == $atndnce_status->employee_id) {
                                                                echo $atndnce_status->leave_category_id ? 'checked ' : '';
                                                            }
                                                        }
                                                    }
                                                    ?>
                                                       value="<?php echo $v_employee->id ?>" class="child_absent" >

                                                <div id="l_category" class="col-sm-9">
                                                    <select name="leave_category_id[]" class="form-control" >
                                                        <option value="" ><?= lang('select_leave_category') ?>...</option>
                                                        <?php foreach ($all_leave_category_info as $v_L_category) : ?>
                                                            <option value="<?php echo $v_L_category->id ?>"
                                                                <?php
                                                                foreach ($atndnce as $atndnce_status) {
                                                                    if ($atndnce_status) {
                                                                        if ($v_employee->id == $atndnce_status->employee_id) {
                                                                            echo $v_L_category->id == $atndnce_status->leave_category_id ? 'selected ' : '';
                                                                        }
                                                                    }
                                                                }
                                                                ?> >
                                                                <?php echo $v_L_category->leave_category ?></option>;
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>

                                            </td>
                                        </tr>
                                    <?php }
                                    ?>
                                    </tbody>
                                </table>
                                <button type="submit" id="sbtn" class="btn bg-navy btn-md btn-flat">
                                    <i class="fa fa-plus"></i> <?= lang('update') ?> </button>
                        </div>


                        <input type="hidden" name="department_id" value="<?php echo $department_id ?>">

                        <?php echo form_close() ?>
                        <?php endif; ?>




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



<script>




</script>