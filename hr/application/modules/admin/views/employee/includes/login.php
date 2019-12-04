<!-- View massage -->
<?php echo message_box('success'); ?>
<?php echo message_box('error'); ?>
<!-- general form elements -->


<?php
    if(!empty($login)) {
        echo form_open('admin/employee/reset_password');
    }else{
        echo form_open('admin/employee/create_user');
    }
?>


<div class="box box-primary">
    <div class="box-header with-border bg-primary-dark">
        <h3 class="box-title"><?= lang('employee_login') ?></h3>
    </div>
    <!-- /.box-header -->
    <!-- form start -->


    <div class="box-body">

        <div class="row">
            <div class="col-md-8">
                <div class="form-group">
                    <label><?= lang('loginid') ?></label>
                    <input type="text" class="form-control" name="username" value="<?php if(!empty($employee->employee_id)) echo $employee->employee_id ?>" disabled>

                </div>

                <div class="form-group">
                    <label><?= lang('password') ?><span class="required">*</span></label>
                    <input type="password" class="form-control" name="password">
                </div>

                <div class="form-group">
                    <label><?= lang('retype_password') ?><span class="required">*</span></label>
                    <input type="password" name="retype_password" class="form-control" >
                </div>

                <?php if($employee->termination){?>

                <?php if(!empty($login->id)):?>
                <div class="form-group">
                    <label><?= lang('active_deactive') ?></label>
                    <label class="css-input switch switch-sm switch-success">
                        <input id="<?php echo str_replace(array('+', '/', '='), array('-', '_', '~'), $this->encrypt->encode($login->id)) ?>" <?php echo $login->active == 1 ? 'checked':'' ?> type="checkbox" onclick='employeeActivation(this)'><span></span>
                    </label>
                </div>
                <?php endif ?>

                <?php } ?>


            </div>
        </div>



        <br/>
        <br/>
        <span class="required">*</span> <?= lang('required_field') ?>

        <input type="hidden" name="id" value="<?php echo str_replace(array('+', '/', '='), array('-', '_', '~'), $this->encrypt->encode($employee->id)) ?>" >
        <?php if(!empty($login->id)): ?>
            <input type="hidden" name="login_id" value="<?php echo str_replace(array('+', '/', '='), array('-', '_', '~'), $this->encrypt->encode($login->id)) ?>" >
        <?php endif ?>
    </div>
    <!-- /.box-body -->

    <div class="box-footer">

        <button id="saveSalary" type="submit" class="btn bg-olive btn-flat"  >
           <?php if(!empty($login)) {
               echo lang('update_password');
           }else{
               echo lang('create_login');
           }
           ?>
        </button>

    </div>

</div>
<!-- /.box -->

<?php echo form_close()?>






