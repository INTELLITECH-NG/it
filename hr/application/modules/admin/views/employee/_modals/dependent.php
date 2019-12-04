
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
    <h4 class="modal-title" id="myModalLabel"><?= lang('add_dependent') ?></h4>
</div>

<div class="modal-body">

    <?php echo form_open_multipart('admin/employee/save_dependent', $attribute= array('id' => 'dependent'))?>


        <div class="form-group">
            <label><?= lang('name') ?><span
                    class="required">*</span></label>
            <input type="text" name="name" value="<?php if(!empty($dependents->name)) echo $dependents->name ?>" class="form-control">
        </div>

        <div class="form-group">
            <label><?= lang('relationship_type') ?><span
                    class="required">*</span></label>
            <input type="text" name="relationship" value="<?php if(!empty($dependents->relationship)) echo $dependents->relationship ?>" class="form-control">
        </div>

        <div class="form-group form-group-bottom">
            <label><?= lang('date_of_birth') ?><span class="required" aria-required="true">*</span></label>

            <div class="input-group">
                <input type="text" class="form-control" id="datepicker" value="<?php if(!empty($dependents->date_of_birth)) echo $dependents->date_of_birth ?>" name="date_of_birth" data-date-format="yyyy/mm/dd">
                <div class="input-group-addon">
                    <i class="fa fa-calendar-o"></i>
                </div>
            </div>
        </div>




        <input type="hidden" name="id" value="<?= $id ?>">
        <input type="hidden" name="index" value="<?php if(!empty($index)) echo $index ?>">

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



