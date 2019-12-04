
<?php echo message_box('success'); ?>
<?php echo message_box('error'); ?>


<div class="row">
    <div class="col-sm-12">

        <div class="row">
            <div class="col-sm-12" data-offset="0">
                <div class="wrap-fpanel">
                    <div class="box box-primary" data-collapsed="0">
                        <div class="box-header with-border bg-primary-dark">
                            <h3 class="box-title">Find Purchase Order</h3>
                        </div>
                        <div class="panel-body">

                            <?php echo form_open('admin/purchase/find_purchase_details', array('class' => 'form-horizontal')) ?>
                            <div class="panel_controls">


                                <div class="form-group">
                                    <label  class="col-sm-3 control-label">Purchase No<span class="required">*</span></label>

                                    <div class="col-sm-5">
                                        <input type="text" class="form-control" name="purchase_no">
                                    </div>
                                </div>



                                <div class="form-group">
                                    <div class="col-sm-offset-3 col-sm-5">
                                        <button type="submit" id="sbtn" name="sbtn" value="1" class="btn bg-olive btn-md btn-flat"><?= lang('go') ?></button>
                                    </div>
                                </div>
                            </div>
                            <?php echo form_close() ?>







                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(function() {
            $('#date').datepicker({
                autoclose: true,
                format: "yyyy-mm-dd",
            });
        });
    </script>
