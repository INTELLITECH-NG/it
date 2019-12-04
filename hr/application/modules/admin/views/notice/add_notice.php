
<?php echo message_box('success'); ?>
<?php echo message_box('error'); ?>


<div class="row">
    <div class="col-sm-12">

        <div class="row">
            <div class="col-sm-12" data-offset="0">
                <div class="wrap-fpanel">
                    <div class="box box-primary" data-collapsed="0">
                        <div class="box-header with-border bg-primary-dark">
                            <h3 class="box-title"><?= lang('add_notice') ?></h3>
                        </div>
                        <div class="panel-body">

                            <?php echo form_open('admin/notice/saveNotice', array('class' => 'form-horizontal')) ?>



                            <div class="panel_controls">
                                <div class="form-group margin">
                                    <label class="col-sm-3 control-label"><?= lang('title') ?> </label>

                                    <div class="col-sm-7">
                                        <input type="text" name="title" value="<?php if(!empty($notice)) echo $notice->title ?>" class="form-control"  >
                                    </div>
                                </div>

                                <div class="form-group margin">
                                    <label class="col-sm-3 control-label"><?= lang('short_description') ?> </label>

                                    <div class="col-sm-7">
                                        <textarea class="form-control" name="short"><?php if(!empty($notice)) echo $notice->short ?></textarea>
                                    </div>
                                </div>

                                <div class="form-group margin">
                                    <label class="col-sm-3 control-label"><?= lang('long_description') ?> </label>

                                    <div class="col-sm-7">
                                        <textarea id="compose-textarea" class="form-control" name="description"><?php if(!empty($notice)) echo $notice->description ?></textarea>
                                    </div>
                                </div>

                                <div class="form-group margin">
                                    <label class="col-sm-3 control-label"><?= lang('publication_status') ?> </label>

                                    <div class="col-sm-7">
                                        <div class="form-group">

                                            <label class="css-input css-radio css-radio-success push-10-r">
                                                <input name="status" value="Published"  type="radio" <?php if(!empty($notice)) echo $notice->status == 'Published' ? 'checked':'' ?>>
                                                <span></span><?= lang('published') ?></label>
                                            <label class="css-input css-radio css-radio-success push-10-r">
                                                <input name="status" value="UnPublished"  type="radio" <?php if(!empty($notice)) echo $notice->status == 'UnPublished' ? 'checked':'' ?>>
                                                <span></span><?= lang('un_published') ?></label>
                                        </div>
                                    </div>
                                </div>


                                <input type="hidden" name="id" value="<?php if(!empty($notice)) echo str_replace(array('+', '/', '='), array('-', '_', '~'), $this->encrypt->encode($notice->id)) ?>">

                                <div class="form-group">
                                    <div class="col-sm-offset-3 col-sm-5">
                                        <button type="submit" id="sbtn" name="sbtn" value="1" class="btn bg-olive btn-md btn-flat"><?= lang('save') ?></button>
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
        $(function () {
            //Add text editor
            $("#compose-textarea").wysihtml5();
        });
    </script>

    <script>
        $(function() {
            $('#date').datepicker({
                autoclose: true,
                format: "yyyy-mm-dd",
            });
        });
    </script>

    <script type="text/javascript">
        $(document).on("change", function() {
            var fine = 0;
            var bonus = 0;
            fine = $("#fine_deduction").val();
            bonus = $("#bonus").val();
            var net_salary = $("#net_salary").val();
            var total =  net_salary - fine + + bonus;
            $("#payment_amount").val(total);
        });
    </script>
