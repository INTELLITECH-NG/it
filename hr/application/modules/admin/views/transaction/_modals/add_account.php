
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
    <h4 class="modal-title" id="myModalLabel"><?= lang('add_new_account') ?></h4>
</div>

<div class="modal-body">

    <?php echo form_open_multipart('admin/transaction/save_new_account', $attribute= array('id' => 'newAccount'))?>


        <div class="form-group">
            <label><?= lang('account_name') ?><span
                    class="required">*</span></label>
            <input type="text" name="account_title" value="<?php if(!empty($account)) echo $account->account_title ?>" class="form-control">
        </div>

        <div class="form-group">
            <label><?= lang('account_number') ?><span
                    class="required">*</span></label>
            <input type="text" name="account_number" value="<?php if(!empty($account)) echo $account->account_number ?>" class="form-control">
        </div>


        <div class="form-group">
            <label for="exampleInputEmail1"><?= lang('description') ?><span
                    class="required">*</span></label>
            <input type="text" name="description" value="<?php if(!empty($account)) echo $account->description ?>" class="form-control">
        </div>

        <div class="form-group">
            <label for="exampleInputEmail1"><?= lang('phone') ?><span
                    class="required">*</span></label>
            <input type="text" name="phone" value="<?php if(!empty($account)) echo $account->phone ?>" class="form-control">
        </div>

        <div class="form-group">
            <label for="exampleInputEmail1"><?= lang('address') ?><span
                    class="required">*</span></label>

            <textarea class="form-control" name="address"><?php if(!empty($account)) echo $account->address ?></textarea>
        </div>

        <?php if(!empty($account)): ?>
            <input type="hidden" value="<?php echo str_replace(array('+', '/', '='), array('-', '_', '~'), $this->encrypt->encode($account->id)) ?>" name="id">
        <?php endif ?>

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


    $("#btn").click(function ()  {

        $("#newAccount").validate({
            excluded: ':disabled',
            rules: {

                account_title: {
                    required: true
                },
                description: {
                    required: true
                },
                account_number: {
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




