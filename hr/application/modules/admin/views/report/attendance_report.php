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

                        <?php echo form_open('admin/reports/employeeAttendance', array('class' =>'form-horizontal')) ?>
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
                   <?php echo form_close() ?>
                </div>
            </div>
        </div>
    </div>
</div>


<br/>
<br/>
<?php if (!empty($period)): ?>
<div class="row">
    <div class="col-md-12">
        <!-- general form elements -->
        <div class="box box-primary">
            <div class="box-header with-border bg-primary-dark">
                <h3 class="box-title"><?= lang('attendance_report') ?></h3>
                <div class="box-tools" style="padding-top: 5px">
                    <div class="input-group input-group-sm">
                        <a id="printButton" class="btn btn-default"><i class="fa fa-print"></i> <?= lang('print') ?></a>
                    </div>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">

                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">

                        <div class="print-attendance">

                            <link href="<?php echo base_url(); ?>assets/css/AdminLTE.css" media="print" rel="stylesheet" type="text/css"  />
                            <link href="<?php echo base_url(); ?>assets/css/bootstrap/css/bootstrap.css" media="print" rel="stylesheet" type="text/css" />


                            <table class="table table-bordered cart-buttons" width="100%">
                            <thead>
                            <tr>
                                <th class="active" colspan="32"><?php echo $employee->first_name.' '.$employee->last_name?></th>
                            </tr>

                            </thead>

                            <tbody>

                            <?php foreach ($period as $item){ ?>
                                <tr>
                                    <?php $date = $item->format("Y-m") ?>
                                    <td rowspan="2" valign="middle"><strong><?= $date ?></strong></td>

                                    <?php foreach ($dateSl[$date] as $item){?>
                                        <td><?= $item ?></td>
                                    <?php } ?>
                                </tr>

                                <tr>
                                    <?php foreach ($attendance[$date] as $item){?>
                                        <td>
                                            <?php
                                            if ($item[0]->attendance_status == 1) {
                                                echo '<small class="label bg-olive">P</small>';
                                            }if ($item[0]->attendance_status == '0') {
                                                echo '<small class="label bg-red">A</small>';
                                            }if($item[0]->attendance_status == '3'){
                                                echo '<small class="label bg-yellow">L</small>';
                                            }if ($item[0]->attendance_status == 'H') {
                                                echo '<small class="label btn-default">H</small>';
                                            }
                                            ?>
                                        </td>
                                    <?php } ?>
                                </tr>
                            <?php } ?>

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
    $(document).ready(function(){
        $("#printButton").click(function(){
            var mode = 'iframe'; // popup
            var close = mode == "popup";
            var options = { mode : mode, popClose : close};
            $("div.print-attendance").printArea( options );
        });
    });

</script>