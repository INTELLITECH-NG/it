
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
    <h4 class="modal-title" id="myModalLabel"><?= lang('attachment') ?></h4>
</div>

<div class="modal-body">

    <?php echo form_open_multipart('admin/employee/save_personal_attachment', $attribute= array('id' => 'personalAttach'))?>


        <div class="form-group">
            <label for="exampleInputEmail1"><?= lang('attachment') ?><span
                    class="required">*</span></label>
            <input type="file" name="file" class="form-control">
        </div>


        <div class="form-group">
            <label for="exampleInputEmail1"><?= lang('description') ?><span
                    class="required">*</span></label>
            <input type="text" name="description" class="form-control">
        </div>

        <input type="hidden" name="id" value="<?= $id ?>">

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

        $("#personalAttach").validate({
            excluded: ':disabled',
            rules: {

                description: {
                    required: true
                },
                file: {
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




