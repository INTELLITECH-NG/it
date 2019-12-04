<script src="<?php echo site_url('assets/js/ajax.js') ?>"></script>

    <!-- Main content -->
    <section class="content">
        <div class="row">
                        <!-- /.col -->
            <div class="col-md-12">
                <!-- View massage -->
                <?php echo message_box('success'); ?>
                <?php echo message_box('error'); ?>

                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title"><?= lang('inbox') ?></h3>
                        <!-- /.box-tools -->
                    </div>
                    <!-- /.box-header -->
                    <?php echo form_open('employee/mail/deleteMails') ?>
                        <div class="box-body ">
                            <div class="mailbox-controls">
                                <!-- Check all button -->
                                <button type="button" class="btn btn-default btn-sm checkbox-toggle"><i class="fa fa-square-o"></i>
                                </button>
                                <div class="btn-group">
                                    <button type="submit" class="btn btn-default btn-sm"><i class="fa fa-trash-o"></i></button>
                                </div>
                                <!-- /.btn-group -->
                                <a href="<?php echo site_url('employee/mail') ?>" type="button" class="btn btn-default btn-sm"><i class="fa fa-refresh"></i></a>
                                <a href="<?php echo site_url('employee/mail/composeMail') ?>" class="btn btn-default btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> <?= lang('compose') ?></a>

                                <!-- /.pull-right -->
                            </div>
                            <div class="mailbox-messages">

                                <table id="table" class="table" cellspacing="0" width="100%">
                                    <thead>
                                    <tr>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.mail-box-messages -->
                        </div>
                    <!-- /.box-body -->
                    <input type="hidden" name="url" value="employee/mail">
                    <?php echo form_close() ?>

                </div>
                <!-- /. box -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->
<script>
    //var table;
    var list        = 'employee/mail/inboxList';
</script>



<style>
    .dataTables_wrapper table thead{
        display:none;
    }
</style>

<script>
    $(function () {
        //Enable iCheck plugin for checkboxes
        //iCheck for checkbox and radio inputs
        $('.mailbox-messages input[type="checkbox"]').iCheck({
            checkboxClass: 'icheckbox_flat-blue',
            radioClass: 'iradio_flat-blue'
        });

        //Enable check and uncheck all functionality
        $(".checkbox-toggle").click(function () {
            var clicks = $(this).data('clicks');
            if (clicks) {
                //Uncheck all checkboxes
                $(".mailbox-messages input[type='checkbox']").iCheck("uncheck");
                $(".fa", this).removeClass("fa-check-square-o").addClass('fa-square-o');
            } else {
                //Check all checkboxes
                $(".mailbox-messages input[type='checkbox']").iCheck("check");
                $(".fa", this).removeClass("fa-square-o").addClass('fa-check-square-o');
            }
            $(this).data("clicks", !clicks);
        });





        //Handle starring for glyphicon and font awesome
//        $(".mailbox-star").click(function (e) {
//            e.preventDefault();
//            //detect type
//            var $this = $(this).find("a > i");
//            var glyph = $this.hasClass("glyphicon");
//            var fa = $this.hasClass("fa");
//
//            //Switch states
//            if (glyph) {
//                $this.toggleClass("glyphicon-star");
//                $this.toggleClass("glyphicon-star-empty");
//            }
//
//            if (fa) {
//                $this.toggleClass("fa-star");
//                $this.toggleClass("fa-star-o");
//            }
//        });
    });


</script>


