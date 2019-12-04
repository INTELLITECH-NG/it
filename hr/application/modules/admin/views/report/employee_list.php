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
                            <h3 class="box-title"><?= lang('employee_list') ?></h3>
                        </div>
                        <div class="panel-body">
                            <?php echo form_open('admin/reports/employeeList', array('class' => 'form-horizontal')) ?>
                            <div class="panel_controls">

                                <div class="form-group">
                                    <label for="field-1" class="col-sm-3 control-label"><?= lang('department') ?> <span class="required">*</span></label>

                                    <div class="col-sm-5">
                                        <select name="department_id" id="department" class="form-control">
                                            <option value="" ><?= lang('select_department') ?>...</option>
                                            <?php foreach ($all_department as $v_department) : ?>
                                                <option value="<?php echo $v_department->id ?>">
                                                    <?php echo $v_department->department ?></option>
                                            <?php endforeach; ?>

                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-sm-offset-3 col-sm-5">
                                        <button type="submit" id="sbtn" name="sbtn" value="1" class="btn bg-olive btn-md btn-flat"><?= lang('submit') ?></button>
                                    </div>
                                </div>
                            </div>

                            <input type="hidden" name="flag" value="1">
                            <?php echo form_close() ?>




                            <table class="table table-striped table-bordered display-all" cellspacing="0" width="100%">

                                <thead>
                                <tr>
                                    <th><?= lang('employee_id') ?></th>
                                    <th><?= lang('name') ?></th>
                                    <th><?= lang('department') ?></th>
                                    <th><?= lang('job_title') ?></th>
                                    <th><?= lang('joined_date') ?></th>
                                    <th><?= lang('date_of_permanency') ?></th>
                                    <th><?= lang('shift') ?></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php if(!empty($employees)){ foreach ($employees as $item){ ?>
                                    <tr>
                                        <td><?= $item->employee_id ?></td>
                                        <td><?= $item->first_name.' '.$item->last_name?></a></td>
                                        <?php $department = $this->db->get_where('department', array( 'id' => $item->department))->row();?>
                                        <td><?php if(!empty($department)) echo $department->department ?></td>
                                        <?php $job_title = $this->db->get_where('job_title', array( 'id' => $item->title))->row();?>
                                        <td><?php if(!empty($job_title)) echo $job_title->job_title ?></td>
                                        <td><?= dateFormat($item->joined_date) ?></td>
                                        <td><?= dateFormat($item->date_of_permanency) ?></td>
                                        <?php $shift = $this->db->get_where('work_shift', array( 'id' => $item->work_shift))->row();?>
                                        <td><?php if(!empty($shift)) echo $shift->shift_name ?></td>
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

