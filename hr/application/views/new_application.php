


<section class="content">



    <div class="row">
        <div class="col-sm-12">

            <div class="row">
                <div class="col-sm-12" data-offset="0">
                    <div class="wrap-fpanel">
                        <div class="box box-primary" data-collapsed="0">
                            <div class="box-header with-border bg-primary-dark">
                                <h3 class="box-title"><?= lang('apply_for_leave') ?></h3>
                            </div>
                            <div class="panel-body">


                                <?php echo form_open_multipart('employee/Leave/saveApplication/', $attribute= array('id' => 'holiday'))?>


                                <div class="form-group">
                                    <label for="exampleInputEmail1"><?= lang('leave_category') ?> <span class="required">*</span></label>
                                    <select class="form-control" name="leave_ctegory_id" required>
                                        <option value=""><?= lang('please_select') ?></option>
                                        <?php if(!empty($leaveCategory)){ foreach($leaveCategory as $item){ ?>
                                            <option value="<?php echo $item->id ?>"><?= $item->leave_category ?></option>
                                        <?php }} ?>
                                    </select>
                                </div>



                                <div class="form-group">
                                    <label><?= lang('start_date') ?> <span class="required">*</span></label>
                                    <div class="input-group">
                                        <input type="text" class="form-control datepicker" required name="start_date" id="start_date" value=""
                                               data-date-format="yyyy/mm/dd">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label><?= lang('end_date') ?> <span class="required">*</span></label>
                                    <div class="input-group">
                                        <input type="text" class="form-control datepicker" name="end_date" required value=""
                                               data-date-format="yyyy/mm/dd">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label><?= lang('reason') ?><span class="required">*</span></label>
                                    <textarea class="form-control" name="reason" required></textarea>
                                </div>


                                <span class="required">*</span> <?= lang('required_field') ?>

                                <div class="modal-footer" >
                                    <button type="submit" class="btn bg-olive btn-flat pull-left" id="btn" ><?= lang('submit') ?></button>
                                </div>


                                <?php echo form_close()?>



                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div></section>




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




