
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only"><?= lang('close') ?></span></button>
    <h4 class="modal-title" id="myModalLabel"><?= lang('add_holiday') ?></h4>
</div>

<div class="modal-body">

    <?php echo form_open_multipart('admin/office/save_holiday/', $attribute= array('id' => 'holiday'))?>


        <div class="form-group">
            <label for="exampleInputEmail1"><?= lang('event_name') ?><span class="required">*</span></label>
            <input type="text" name="event_name" value="<?php if (!empty($holiday)) {echo $holiday->event_name;} ?>" required class="form-control">
        </div>

        <div class="form-group">
            <label for="exampleInputEmail1"><?= lang('description') ?><span
                    class="required">*</span></label>
            <textarea class="form-control" name="description" required><?php if (!empty($holiday)) {echo $holiday->description;} ?></textarea>
        </div>

        <div class="form-group">
            <label for="exampleInputEmail1"><?= lang('start_date') ?><span class="required">*</span></label>
            <div class="input-group">
                <input type="text" class="form-control datepicker" required name="start_date" id="start_date" value="<?php if (!empty($holiday)) {echo date('Y-m-d', strtotime($holiday->start_date));} ?>"
                       data-date-format="yyyy/mm/dd">
                <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label for="exampleInputEmail1"><?= lang('end_date') ?><span class="required">*</span></label>
            <div class="input-group">
                <input type="text" class="form-control datepicker" name="end_date" required value="<?php if (!empty($holiday)) {echo date('Y-m-d', strtotime($holiday->end_date));} ?>"
                       data-date-format="yyyy/mm/dd">
                <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                </div>
            </div>
        </div>

        <input type="hidden" name="holiday_id" value="<?php if(!empty($holiday)) echo $holiday->holiday_id ?>">

        <span class="required">*</span> <?= lang('required_field') ?>

        <div class="modal-footer" >

            <button type="button" id="close" class="btn btn-danger btn-flat pull-left" data-dismiss="modal"><?= lang('close') ?></button>
            <button type="submit" class="btn bg-olive btn-flat" id="btn" ><?= lang('save') ?></button>


        </div>


    <?php echo form_close()?>

</div>



<script>

    $('#modalSmall').on('hidden.bs.modal', function () {
        location.reload();
    });

    $(document).ready(function() {
        $('.datepicker').datepicker({
            autoclose: true,
            format: "yyyy-mm-dd",
            todayHighlight: true,
            orientation: "top auto",
            todayBtn: true,
            todayHighlight: true,
        });
    });

    $("#btn").click(function ()  {

        $("#holiday").validate({
            excluded: ':disabled',
            rules: {
                event_name: {
                    required: true
                },
                description: {
                    required: true
                },

                start_date: {
                    required: true
                },
                end_date: { greaterThanDate: "#start_date" }

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


    // start date end date validation
    jQuery.validator.addMethod("greaterThanDate",
        function(value, element, params) {


            if (!/Invalid|NaN/.test(new Date(value))) {
                return new Date(value) >= new Date($(params).val());
            }

            return Number(value) >= Number($(params).val());
        },'<?= lang ('end_date_must_be_greater_than_start_date.') ?>');

    $('body').on('hidden.bs.modal', '.modal', function () {
        $(this).removeData('bs.modal');
    });


</script>




