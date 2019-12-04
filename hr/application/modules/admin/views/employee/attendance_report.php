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
        <div class="wrap-fpanel">
            <div class="box box-primary" data-collapsed="0">
                <div class="box-header with-border bg-primary-dark">
                    <h3 class="box-title"><?= lang('generate_attendance_report') ?></h3>
                </div>

                <div class="panel-body">

                        <?php echo form_open('admin/employee/report', array('class' =>'form-horizontal')) ?>
                    <div class="panel_controls">
                        <div class="form-group margin">
                            <label class="col-sm-3 control-label"><?= lang('date') ?><span class="required">*</span></label>

                            <div class="col-sm-5">
                                <div class="input-group">
                                    <input type="text" name="date"   class="form-control monthyear" value="<?php
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
                            <label for="field-1" class="col-sm-3 control-label"><?= lang('department') ?> <span class="required">*</span></label>

                            <div class="col-sm-5">
                                <select name="department_id" id="department" class="form-control">
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
                                <button type="submit" id="sbtn" name="sbtn" value="1" class="btn bg-olive btn-flat btn-md"><?= lang('go') ?></button>
                            </div>
                        </div>
                    </div>
                   <?php echo form_close() ?>
                </div>
            </div>
        </div>
    </div>
</div>


<br/>
<br/>
<?php if (!empty($attendance)): ?>
<div class="row">
    <div class="col-md-12">
        <!-- general form elements -->
        <div class="box box-primary">
            <div class="box-header with-border bg-primary-dark">
                <h3 class="box-title"><?= lang('set_working_days') ?></h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">

                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">


                        <table class="table table-bordered cart-buttons" width="100%">
                            <thead style="display: none">
                            <tr>
                                <th class="active">Name</th>

                                <?php foreach ($dateSl as $edate) : ?>
                                    <th class="active"><?php echo $edate ?></th>
                                <?php endforeach; ?>

                            </tr>

                            </thead>

                            <tbody style="display: none">

                            <?php foreach ($attendance as $key => $v_employee): ?>
                                <tr>

                                    <td ><?php echo $employee[$key]->first_name . ' ' . $employee[$key]->last_name ?></td>
                                    <?php foreach ($v_employee as $v_result): ?>
                                        <?php foreach ($v_result as $emp_attendance): ?>
                                            <td>
                                                <?php
                                                if ($emp_attendance->attendance_status == 1) {
                                                    echo '<small class="label bg-olive">P</small>';
                                                }if ($emp_attendance->attendance_status == '0') {
                                                    echo '<small class="label bg-red">A</small>';
                                                }if($emp_attendance->attendance_status == '3'){
                                                    echo '<small class="label bg-yellow">L</small>';
                                                }if ($emp_attendance->attendance_status == 'H') {
                                                    echo '<small class="label btn-default">H</small>';
                                                }
                                                ?>
                                            </td>
                                        <?php endforeach; ?>


                                    <?php endforeach; ?>
                                </tr>
                            <?php endforeach; ?>

                            </tbody>
                        </table>

                        <div class="table-responsive">
                        <table class="table table-bordered" width="100%">
                            <thead>
                            <tr>
                                <th class="active"><?= lang('name') ?></th>

                                <?php foreach ($dateSl as $edate) : ?>
                                    <th class="active"><?php echo $edate ?></th>
                                <?php endforeach; ?>

                            </tr>

                            </thead>

                            <tbody>

                            <?php foreach ($attendance as $key => $v_employee): ?>
                                <tr>

                                    <td ><?php echo $employee[$key]->first_name . ' ' . $employee[$key]->last_name ?></td>
                                    <?php foreach ($v_employee as $v_result): ?>
                                        <?php foreach ($v_result as $emp_attendance): ?>
                                            <td>
                                                <?php
                                                if ($emp_attendance->attendance_status == 1) {
                                                    echo '<small class="label bg-olive">P</small>';
                                                }if ($emp_attendance->attendance_status == '0') {
                                                    echo '<small class="label bg-red">A</small>';
                                                }if($emp_attendance->attendance_status == '3'){
                                                    echo '<small class="label bg-yellow">L</small>';
                                                }if ($emp_attendance->attendance_status == 'H') {
                                                    echo '<small class="label btn-default">H</small>';
                                                }
                                                ?>
                                            </td>
                                        <?php endforeach; ?>


                                    <?php endforeach; ?>
                                </tr>
                            <?php endforeach; ?>

                            </tbody>
                        </table>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<?php endif ?>


<script>

    var handleCartButtons = function() {
            "use strict";
            0 !== $(".cart-buttons").length && $(".cart-buttons").DataTable({
                "iDisplayLength": "All",
                "bSort" : false,
                paging: false,

                dom: "Bfrtip",
                buttons: [{
                    extend: "copy",
                    className: "btn-sm"
                }, {
                    extend: "csv",
                    className: "btn-sm"
                }, {
                    extend: "excel",
                    className: "btn-sm"
                }, {
                    extend: 'pdf',
                    orientation: 'landscape',
                    className: "btn-sm"
                }, {
                    extend: "print",
                    className: "btn-sm"
                }],
                responsive: !0
            })
        },
        cartButtons = function() {
            "use strict";
            return {
                init: function() {
                    handleCartButtons()
                }
            }
        }();


</script>