
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
    <h4 class="modal-title" id="myModalLabel"><?= lang('add_new_job') ?></h4>
</div>

<div class="modal-body">

    <?php echo form_open_multipart('admin/employee/save_new_job', $attribute= array('id' => 'newJob'))?>


        <div class="form-group form-group-bottom">
            <label><?= lang('effective_from') ?><span class="required" aria-required="true">*</span></label>

            <div class="input-group">
                <input type="text" class="form-control" id="datepicker" value="<?php if(!empty($job->effective_from)) echo $job->effective_from ?>" name="effective_from" data-date-format="yyyy/mm/dd">
                <div class="input-group-addon">
                    <i class="fa fa-calendar-o"></i>
                </div>
            </div>
        </div>


        <div class="form-group">
            <label><?= lang('department') ?><span
                    class="required">*</span></label>
            <select class="form-control" name="department">
                <option value=""><?= lang('please_select') ?>..</option>
                <?php foreach($departments as $item){ ?>
                 <option value="<?= $item->id ?>" <?php if(!empty($job->department)) echo $item->id == $job->department ? 'selected':'' ?> ><?php echo $item->department ?></option>
                <?php } ?>

            </select>

        </div>


        <div class="form-group">
            <label><?= lang('job_title') ?><span
                    class="required">*</span></label>
            <select class="form-control" name="title">
                <option value=""><?= lang('please_select') ?>..</option>
                <?php foreach($titles as $item){ ?>
                    <option value="<?= $item->id ?>" <?php if(!empty($job->title)) echo $item->id == $job->title ? 'selected':'' ?> ><?php echo $item->job_title ?></option>
                <?php } ?>

            </select>

        </div>

        <div class="form-group">
            <label><?= lang('job_category') ?><span
                    class="required">*</span></label>
            <select class="form-control" name="category">
                <option value=""><?= lang('please_select') ?>..</option>
                <?php foreach($categories as $item){ ?>
                    <option value="<?= $item->id ?>" <?php if(!empty($job->category)) echo $item->id == $job->category ? 'selected':'' ?> ><?php echo $item->category_name ?></option>
                <?php } ?>

            </select>
        </div>

        <div class="form-group">
            <label><?= lang('employment_status') ?><span
                    class="required">*</span></label>
            <select class="form-control" name="employment_status">
                <option value=""><?= lang('please_select') ?>..</option>
                <?php foreach($emp_status as $item){ ?>
                    <option value="<?= $item->id ?>" <?php if(!empty($job->employment_status)) echo $item->id == $job->employment_status ? 'selected':'' ?> ><?php echo $item->status_name ?></option>
                <?php } ?>

            </select>

        </div>

        <div class="form-group">
            <label><?= lang('work_shift') ?><span
                    class="required">*</span></label>
            <select class="form-control" name="work_shift">
                <option value=""><?= lang('please_select') ?>..</option>
                <?php foreach($work_shift as $item){ ?>
                    <option value="<?= $item->id ?>" <?php if(!empty($job->work_shift)) echo $item->id == $job->work_shift ? 'selected':'' ?> ><?php echo $item->shift_name ?></option>
                <?php } ?>

            </select>

        </div>

        <input type="hidden" name="id" value="<?= $id ?>">
        <input type="hidden" name="job_id" value="<?php if(!empty($job->id)) echo $job->id ?>">

        <span class="required">*</span> Required field

        <div class="modal-footer" >

            <button type="button" id="close" class="btn btn-danger btn-flat pull-left" data-dismiss="modal">Close</button>
            <button type="submit" class="btn bg-olive btn-flat" id="btn" >Save</button>


        </div>
    <?php echo form_close()?>

</div>



<script>

    $('#modalSmall').on('hidden.bs.modal', function () {
        location.reload();
    });


    $(document).ready(function() {
        $('#datepicker').datepicker({
            autoclose: true,
            format: "yyyy-mm-dd",
            todayHighlight: true,
            orientation: "top auto",
            todayBtn: true,
            todayHighlight: true,
        });
    });


    $("#btn").click(function ()  {

        $("#dependent").validate({
            excluded: ':disabled',
            rules: {

                name: {
                    required: true
                },
                relationship: {
                    required: true
                },
                date_of_birth: {
                    required: true
                },



            },

            highlight: function(element) {
                $(element).closest('.form-group').addClass('has-error');
            },
            unhighlight: function(element) {
                $(element).closest('.form-group').removeClass('has-error');
            },
            errorElement: 'span',
            errorClass: 'help-block animated fadeInDown',
            errorPlacement: function(error, element) {
                if (element.parent('.input-group').length) {
                    error.insertAfter(element.parent());
                } else {
                    error.insertAfter(element);
                }
            }
        })
    });

    $('body').on('hidden.bs.modal', '.modal', function () {
        $(this).removeData('bs.modal');
    });


</script>



