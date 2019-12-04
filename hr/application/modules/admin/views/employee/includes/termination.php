<!-- View massage -->
<?php echo message_box('success'); ?>
<?php echo message_box('error'); ?>
<!-- general form elements -->

<div class="box box-primary" xmlns="http://www.w3.org/1999/html">
    <div class="box-header with-border bg-primary-dark">
        <h3 class="box-title"><?= lang('termination_note') ?></h3>
    </div>
    <!-- /.box-header -->
    <!-- form start -->


    <div class="box-body">


        <?php
        if(!empty($employee->termination_note)){
            $termination =  json_decode($employee->termination_note);
        }
        ?>


        <div class="panel_controls">

            <div class="form-group margin">
                <label class="col-sm-3 control-label"><?= lang('termination_date') ?> </label>

                <div class="col-sm-9">
                    <?php if(!empty($termination->termination_date)) echo $termination->termination_date ?>
                </div>
            </div>

            </br>

            <div class="form-group margin">
                <label class="col-sm-3 control-label"><?= lang('termination_reason') ?> </label>

                <div class="col-sm-9">
                    <?php if(!empty($termination->termination_reason)) echo $termination->termination_reason ?>
                </div>
            </div>

            </br>

            <div class="form-group margin">
                <label class="col-sm-3 control-label"><?= lang('termination_note') ?> </label>

                <div class="col-sm-9">
                    <?php if(!empty($termination->termination_note)) echo $termination->termination_note ?>
                </div>
            </div>






        </div>




        <br/>
        <br/>


    </div>
    <!-- /.box-body -->

    <div class="box-footer">
            <a  data-target="#modalSmall" data-placement="top" data-toggle="modal"
                href="<?php echo base_url()?>admin/employee/termination/<?php echo str_replace(array('+', '/', '='), array('-', '_', '~'), $this->encrypt->encode($employee->id))?>" class="btn bg-olive btn-flat">
                <?= lang('edit') ?>
            </a>
    </div>

</div>
<!-- /.box -->








