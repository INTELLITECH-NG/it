
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
    <h4 class="modal-title" id="myModalLabel"><?= lang('add_expense') ?></h4>
</div>

<div class="modal-body">

    <?php echo form_open_multipart('admin/transaction/save_expense_category', $attribute= array('id' => 'expense_category'))?>


    <div class="form-group">
        <label class="control-label col-md-3"><?= lang('name') ?></label>
        <div class="col-md-9">
            <input name="name"  class="form-control" type="text" value="<?php if(!empty($category->name)) echo $category->name ?>">
            <span class="help-block"></span>
        </div>
    </div>

    <div class="form-group">
        <label class="control-label col-md-3"><?= lang('description') ?></label>
        <div class="col-md-9">
            <textarea name="description"  class="form-control"><?php if(!empty($category->description)) echo $category->description ?></textarea>
            <span class="help-block"></span>
        </div>
    </div>

        <input type="hidden" name="id" value="<?php if(!empty($category->id)) echo $category->id ?>">

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

        $("#expense_category").validate({
            excluded: ':disabled',
            rules: {

                description: {
                    required: true
                },
                name: {
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




