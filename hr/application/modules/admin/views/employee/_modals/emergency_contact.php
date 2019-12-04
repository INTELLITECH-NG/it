
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
    <h4 class="modal-title" id="myModalLabel"><?= lang('emergency_contact') ?></h4>
</div>

<div class="modal-body">

    <?php echo form_open_multipart('admin/employee/save_emergency_contact', $attribute= array('id' => 'emergencyContact'))?>


        <div class="form-group">
            <label><?= lang('name') ?><span
                    class="required">*</span></label>
            <input type="text" name="name" value="<?php if(!empty($emergency_contact->name)) echo $emergency_contact->name ?>" class="form-control">
        </div>

        <div class="form-group">
            <label><?= lang('relationship') ?><span
                    class="required">*</span></label>
            <input type="text" name="relationship" value="<?php if(!empty($emergency_contact->relationship)) echo $emergency_contact->relationship ?>" class="form-control">
        </div>

        <div class="form-group">
            <label><?= lang('home_telephone') ?><span
                    class="required">*</span></label>
            <input type="text" name="home_telephone" value="<?php if(!empty($emergency_contact->home_telephone)) echo $emergency_contact->home_telephone ?>" class="form-control">
        </div>

        <div class="form-group">
            <label><?= lang('mobile') ?></label>
            <input type="text" name="mobile" value="<?php if(!empty($emergency_contact->mobile)) echo $emergency_contact->mobile ?>" class="form-control">
        </div>

        <div class="form-group">
            <label><?= lang('work_telephone') ?></label>
            <input type="text" name="work_telephone" value="<?php if(!empty($emergency_contact->work_telephone)) echo $emergency_contact->work_telephone ?>" class="form-control">
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


    $("#btn").click(function ()  {

        $("#emergencyContact").validate({
            excluded: ':disabled',
            rules: {

                name: {
                    required: true
                },
                relationship: {
                    required: true
                },
                home_telephone: {
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



