<!-- View massage -->
<?php echo message_box('success'); ?>
<?php echo message_box('error'); ?>
<!-- general form elements -->
<div class="box box-primary">
    <div class="box-header with-border bg-primary-dark">
        <h3 class="box-title"><?= lang('employment_commencement') ?></h3>
    </div>
    <!-- /.box-header -->
    <!-- form start -->

    <?php echo form_open('admin/employee/save_commencement', $attribute= array('id' => 'ContactForm', 'class' => 'ContactForm') ) ?>
    <div class="box-body">

        <div class="row">
            <div class="col-md-6">

                <div class="form-group">
                        <label><?= lang('joined_date') ?><span class="required">*</span></label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="datepicker3" name="joined_date" value="<?php if($employee->joined_date != '0000-00-00')echo $employee->joined_date ?>" data-date-format="yyyy/mm/dd">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar-o"></i>
                            </div>
                        </div>
                </div>


                <div class="form-group">
                    <label><?= lang('date_of_permanency') ?> <span class="required">*</span></label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="datepicker1" name="date_of_permanency" value="<?php if($employee->date_of_permanency != '0000-00-00')echo $employee->date_of_permanency ?>" data-date-format="yyyy/mm/dd">
                        <div class="input-group-addon">
                            <i class="fa fa-calendar-o"></i>
                        </div>
                    </div>
                </div>

                <span class="required">*</span><?= lang('required_field') ?>

            </div>



            <div class="col-md-6">

                <div class="form-group">
                    <label><?= lang('probation_end_date') ?><span class="required">*</span></label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="datepicker2" name="probation_end_date" value="<?php if($employee->probation_end_date != '0000-00-00')echo $employee->probation_end_date ?>" data-date-format="yyyy/mm/dd">
                        <div class="input-group-addon">
                            <i class="fa fa-calendar-o"></i>
                        </div>
                    </div>
                </div>

            </div>

        </div>

        <input type="hidden" name="id" value="<?php echo str_replace(array('+', '/', '='), array('-', '_', '~'), $this->encrypt->encode($employee->id)) ?>" >

    </div>
    <!-- /.box-body -->

    <div class="box-footer">
        <a class="btn bg-navy btn-flat" id="editContact" ><i class="fa fa-pencil-square-o"></i><?= lang('edit') ?></a>
        <button id="saveContact" type="submit" class="btn bg-olive btn-flat" style="display:none ;"><?= lang('save') ?></button>&nbsp;&nbsp;&nbsp;
        <a  class="btn bg-maroon btn-flat" id="cancelContact" style="display: none;" ><?= lang('cancel') ?></a>
    </div>

    <?php echo form_close() ?>
</div>
<!-- /.box -->


<script>



</script>


<script>
    $("#ContactForm :input").attr("disabled", true);
    var contactForm = $("#ContactForm");
    $('#editContact').click(function(event) {
        //event.preventDefault();
        contactForm.find(':disabled').each(function() {
            $(this).removeAttr('disabled');
            $('#saveContact').show();
            $('#cancelContact').show();
            $('#editContact').hide();
        });
    });

    $('#cancelContact').click(function(event) {
        //event.preventDefault();
        contactForm.find(':enabled').each(function() {
            $(this).attr("disabled", "disabled");
            $('#saveContact').hide();
            $('#cancelContact').hide();
            $('#editContact').show();
        });
    });

</script>

<script>
    $(document).ready(function() {
        $('#datepicker1').datepicker({
            autoclose: true,
            format: "yyyy-mm-dd",
            todayHighlight: true,
            orientation: "top auto",
            todayBtn: true,
            todayHighlight: true,
            setDate : new Date(),
        });

        $('#datepicker2').datepicker({
            autoclose: true,
            format: "yyyy-mm-dd",
            todayHighlight: true,
            orientation: "top auto",
            todayBtn: true,
            todayHighlight: true,
        });

        $('#datepicker3').datepicker({
            autoclose: true,
            format: "yyyy-mm-dd",
            todayHighlight: true,
            orientation: "top auto",
            todayBtn: true,
            todayHighlight: true,
        });

    });
</script>

<div class="box box-primary">
    <div class="box-header with-border bg-primary-dark">
        <h3 class="box-title"><?= lang('job_history') ?></h3>
    </div>
    <!-- /.box-header -->
    <!-- form start -->

    <div class="box-body">

        <!-- View massage -->
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">

                <?php echo form_open('admin/employee/delete_emergencyContact') ?>

                <a  data-target="#modalSmall" title="View" data-placement="top" data-toggle="modal"
                    href="<?php echo base_url()?>admin/employee/add_new_job/<?= str_replace(array('+', '/', '='), array('-', '_', '~'), $this->encrypt->encode($employee->id)) ?>" class="btn bg-navy btn-md btn-flat">
                    <i class="fa fa-plus"></i> <?= lang('add_new_job') ?>
                </a>

                <br/>
                <br/>

                <!-- Table -->
                    <div class="table-responsive">
                    <table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <!--                                    <th class="col-sm-1 active" style="width: 21px"><input type="checkbox" class="checkbox-inline" id="parent_present" /></th>-->

                            <th class="active"><?= lang('effective') ?></th>
                            <th class="active"><?= lang('department') ?></th>
                            <th class="active"><?= lang('job_title') ?></th>
                            <th class="active"><?= lang('job_type') ?></th>
                            <th class="active"><?= lang('shift') ?></th>
                            <th class="active"><?= lang('status') ?></th>
                            <th class="active"><?= lang('actions') ?></th>

                        </tr>
                        </thead>

                        <tbody>
                        <?php if(!empty($job)){?>
                        <?php  foreach($job as $item){ ?>
                            <tr>
                                <td><?php echo date(get_option('date_format'), strtotime($item->effective_from)) ?></td>
                                <td><?php echo $item->department_name ?></td>
                                <td><?php echo $item->title ?></td>
                                <td><?php echo $item->status_name ?></td>
                                <td><?php echo $item->shift_name ?></td>
                                <td>
                                    <?php if($item->status == 0){ ?>
                                        <a href="<?php echo site_url('admin/employee/job_activate/'.$item->id)?>" type="button" class="btn bg-purple btn-xs"><?= lang('make_active') ?></a>
                                    <?php }elseif($item->status == 1){?>
                                        <a type="button" class="btn btn-success btn-xs" ><?= lang('job_active') ?></a>
                                    <?php }else{ ?>
                                        <a type="button" class="btn btn-default btn-xs" ><?= lang('job_expired') ?></a>
                                    <?php } ?>
                                </td>
                                <td>



                                    <div class="btn-group">
                                        <?php if($item->status !=2){ ?>
                                        <a  data-target="#modalSmall"  data-placement="top" data-toggle="modal"
                                            href="<?php echo site_url('admin/employee/edit_job_history/'. $item->id) ?>" class="btn btn-xs bg-gray">
                                            <i class="fa fa-pencil"></i>
                                        </a>
                                        <?php } ?>
                                        <a class="btn btn-xs btn-danger"
                                           onClick="return confirm('Are you sure you want to delete?')" href="<?php echo site_url('admin/employee/delete_job/'. str_replace(array('+', '/', '='), array('-', '_', '~'), $this->encrypt->encode($item->id))) ?>" onclick="deleteItem('1')"><i class="glyphicon glyphicon-trash"></i></a>
                                    </div>
                                </td>

                            </tr>
                        <?php }; } ?>
                        </tbody>

                    </table>
                    </div>

                <input type="hidden" name="id" value="<?php echo $employee->id ?>">
                <?php echo form_close() ?>


            </div>
        </div>

    </div>
    <!-- /.box-body -->



</div>
<!-- /.box -->


