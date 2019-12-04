
<div class="row">
    <div class="col-md-12">
        <!-- general form elements -->
        <div class="box box-primary">
            <div class="box-header with-border bg-primary-dark">
                <h3 class="box-title"><?= lang('smtp_settings') ?></h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <?php echo form_open('admin/settings/save_settings', $attribute= array('enctype' => "multipart/form-data")); ?>

            <div class="box-body">

                <!-- View massage -->
                <?php echo message_box('success'); ?>
                <?php echo message_box('error'); ?>

                <div class="row">
                    <div class="col-md-6 col-sm-12 col-xs-12">

                        <select class="form-control" name="settings[email_send_option]">
                            <option value="smtp" <?php echo 'smtp' == get_option('email_send_option') ?'selected':'' ?>>SMTP Email</option>
                            <option value="php" <?php echo 'php' == get_option('email_send_option') ?'selected':'' ?>>PHP Mail()</option>
                        </select>

                        <div class="smtp mailbox">
                            <?php echo $form->bs3_text( lang('smtp_host'), 'settings[smtp_host]', get_option('smtp_host')); ?>
                            <?php echo $form->bs3_email(lang('smtp_username'), 'settings[smtp_username]' , get_option('smtp_username')); ?>
                            <?php echo $form->bs3_password(lang('smtp_password'), 'settings[smtp_password]' , get_option('smtp_password')); ?>
                            <?php echo $form->bs3_text(lang('smtp_port'), 'settings[smtp_port]' , get_option('smtp_port')); ?>
                        </div>
                        <div class="php mailbox"></div>




                    </div>

                    <div class="col-md-6 col-sm-12 col-xs-12">


                    </div>


                </div>

            </div>
            <!-- /.box-body -->
            <input type="hidden" name="tab" value="<?= $tab ?>">

            <div class="box-footer">
                <?php echo $form->bs4_submit(lang('save_settings')); ?>
            </div>
            <?php echo form_close(); ?>

        </div>
        <!-- /.box -->

    </div>
</div>

<script type="text/javascript">
    $(document).ready(function(){
        $("select").change(function(){
            $(this).find("option:selected").each(function(){
                if($(this).attr("value")=="smtp"){
                    $(".mailbox").not(".smtp").hide();
                    $(".smtp").show();
                }
                else if($(this).attr("value")=="php"){
                    $(".mailbox").not(".php").hide();
                    $(".php").show();
                }
                else{
                    $(".mailbox").hide();
                }
            });
        }).change();
    });
</script>