<!-- View massage -->
<?php echo message_box('success'); ?>
<?php echo message_box('error'); ?>
<!-- general form elements -->


<?php echo form_open('admin/employee/deposit', $attribute= array('id' => 'depositForm')); ?>


<div class="box box-primary">
    <div class="box-header with-border bg-primary-dark">
        <h3 class="box-title"><?= lang('direct_deposit') ?></h3>
    </div>
    <!-- /.box-header -->
    <!-- form start -->


    <?php
        if(!empty($employee->deposit)){
            $deposit = json_decode($employee->deposit);
        }
    ?>

    <div class="box-body">

        <div class="row">
            <div class="col-md-8">
                <div class="form-group">
                    <label><?= lang('account_name') ?> <span class="required">*</span></label>
                    <input type="text" class="form-control" name="account_name" value="<?php if(!empty($deposit->account_name)) echo $deposit->account_name ?>" >

                </div>

                <div class="form-group">
                    <label><?= lang('account_number') ?> <span class="required">*</span></label>
                    <input type="text" class="form-control" name="account_number" value="<?php if(!empty($deposit->account_number)) echo $deposit->account_number ?>">
                </div>

                <div class="form-group">
                    <label><?= lang('bank_name') ?> <span class="required">*</span></label>
                    <input type="text" name="bank_name" class="form-control" value="<?php if(!empty($deposit->bank_name)) echo $deposit->bank_name ?>">
                </div>

                <div class="form-group">
                    <label><?= lang('note') ?></label>
                    <textarea class="form-control" name="note"><?php if(!empty($deposit->note)) echo $deposit->note ?></textarea>
                </div>




            </div>
        </div>



        <br/>
        <br/>
        <span class="required">*</span> <?= lang('required_field') ?>

        <input type="hidden" name="id" value="<?php echo str_replace(array('+', '/', '='), array('-', '_', '~'), $this->encrypt->encode($employee->id)) ?>" >


    </div>
    <!-- /.box-body -->

    <div class="box-footer">

        <a class="btn bg-navy btn-flat btn-md" id="editDeposit" ><i class="fa fa-pencil-square-o"></i> Edit</a>
        <button id="saveDeposit" type="submit" class="btn bg-olive btn-flat" style="display: none;">Save</button>&nbsp;&nbsp;&nbsp;
        <a  class="btn bg-maroon btn-flat" id="cancelDeposit" style="display: none;" >Cancel</a>

    </div>

</div>
<!-- /.box -->

<?php echo form_close()?>



<script>
    var depositForm = $("#depositForm");
    $("#depositForm :input").attr("disabled", true);
    $('#editDeposit').click(function(event) {
        //event.preventDefault();
        depositForm.find(':disabled').each(function() {
            $(this).removeAttr('disabled');
            $('#cancelDeposit').show();
            $('#saveDeposit').show();
            $('#editDeposit').hide();
        });
    });

    $('#cancelDeposit').click(function(event) {
        //event.preventDefault();
        depositForm.find(':enabled').each(function() {
            $(this).attr("disabled", "disabled");
            $('#cancelDeposit').hide();
            $('#saveDeposit').hide();
            $('#editDeposit').show();
        });
    });
</script>


