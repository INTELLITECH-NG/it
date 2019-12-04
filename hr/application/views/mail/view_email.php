<section class="content">
    <div class="row">
        <!-- /.col -->
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"><?= lang('read_mail') ?></h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body no-padding" >
                    <div class="mailbox-read-info">
                        <h3><?php echo $mail->subject ?></h3>

                        <?php if($type == 'inbox'){ ?>
                        <h5>From: <?php echo $mail->sender_name ?>
                            <span class="mailbox-read-time pull-right"><?php echo date("j F, Y, g:i a", strtotime($mail->date) );  ?></span></h5>
                        <?php }?>

                        </br>
                        <h5>To:
                        <?php
                        //$to_type = $mail->to_type;
                        $cc = json_decode($mail->cc);

                        foreach( $cc as $to){
                           $result =  explode("*", $to);
                            if($result[1] == 'A')
                            {
                                $employee = $this->db->get_where('admin_users', array(
                                    'id' => $result[0]
                                ))->row();
                                echo '<span class="label label-default">'. $employee->first_name.' '.$employee->last_name .'</span> &nbsp';
                            }else
                            {
                                $employee = $this->db->get_where('employee', array(
                                    'id' => $result[0]
                                ))->row();
                                echo '<span class="label label-default">'. $employee->first_name.' '.$employee->last_name .'</span> &nbsp';
                            }

                        }
                        ?>

                       </h5>

                    </div>
                    <!-- /.mailbox-read-info -->
                    <?php
                    if($type == 'inbox'){
                        $mailType = 'inbox';
                    }else{
                        $mailType = 'sent';
                    }
                    ?>

                    <?php echo form_open('employee/mail/deleteMails') ?>
                        <div class="mailbox-controls with-border text-center">
                            <div class="btn-group">
                                    <button type="submit" class="btn btn-default btn-sm" data-toggle="tooltip" data-container="body" title="" data-original-title="Delete">
                                        <i class="fa fa-trash-o"></i></button>
                                    <input type="hidden" name="id[]" value="<?php echo str_replace(array('+', '/', '='), array('-', '_', '~'), $this->encrypt->encode($mail->id.'*'.$type)) ?>">

                                <a type="button" class="btn btn-default btn-sm" data-toggle="tooltip" data-container="body" title="Reply"
                                   href="<?php echo site_url('employee/mail/forwardMail/'.str_replace(array('+', '/', '='), array('-', '_', '~'), $this->encrypt->encode($mail->id.'*'.$mailType))) ?>">
                                    <i class="fa fa-share"></i></a>
                            </div>
                            <!-- /.btn-group -->
                            <a type="button" class="btn btn-default btn-sm" data-toggle="tooltip" title="Print" id="printButton">
                                <i class="fa fa-print"></i></a>
                        </div>
                    <?php echo form_close() ?>

                    <!-- /.mailbox-controls -->
                    <div class="mailbox-read-message">
                        <?php echo $mail->msg ?>
                    </div>
                    <!-- /.mailbox-read-message -->
                </div>
                <!-- /.box-body -->
                <?php  $attachments = json_decode($mail->attachment); ?>
                <div class="box-footer">
                    <ul class="mailbox-attachments clearfix">

                     <?php if(!empty($attachments)):foreach($attachments as $key => $item): ?>
                        <li>
                            <?php echo $this->file_type->get_file_type(str_replace(".","",strtolower($item->file_ext)),$item->file_name) ?>

                                <?php
                                $file = explode("@@@", $item->file_name);
                                ?>
                            <div class="mailbox-attachment-info">
                                <a href=" <?php echo site_url('employee/mail/downloadFile/'.str_replace(array('+', '/', '='), array('-', '_', '~'), $this->encrypt->encode($mail->id.'*'.$key)))  ?> " class="mailbox-attachment-name"><i class="fa fa-paperclip"></i><?php echo substr($file[1],0,15) ?></a>
                        <span class="mailbox-attachment-size">
                            <?php echo $this->file_type->formatSizeUnits($item->file_size) ?>
                          <a href="<?php echo site_url('employee/mail/downloadFile/'.str_replace(array('+', '/', '='), array('-', '_', '~'), $this->encrypt->encode($mail->id.'*'.$key)))  ?>" class="btn btn-default btn-xs pull-right"><i class="fa fa-cloud-download"></i></a>
                        </span>
                            </div>
                        </li>
                     <?php endforeach; endif ?>

                    </ul>
                </div>
                <?php echo form_open('employee/mail/deleteMails') ?>
                <!-- /.box-footer -->
                    <div class="box-footer">
                        <div class="pull-right">
                            <a type="button" class="btn btn-default" href="<?php echo site_url('employee/mail/forwardMail/'.str_replace(array('+', '/', '='), array('-', '_', '~'), $this->encrypt->encode($mail->id.'*'.$mailType))) ?>">
                                <i class="fa fa-share"></i><?= lang('replay') ?></a>
                        </div>
                            <button type="submit" class="btn btn-default"><i class="fa fa-trash-o"></i> <?= lang('delete') ?></button>
                            <input type="hidden" name="id[]" value="<?php echo str_replace(array('+', '/', '='), array('-', '_', '~'), $this->encrypt->encode($mail->id.'*'.$type)) ?>">
                        <a type="button" id="printButton1" class="btn btn-default"><i class="fa fa-print"></i> <?= lang('print') ?></a>
                    </div>
                <!-- /.box-footer -->
                <?php echo form_close() ?>
            </div>
            <!-- /. box -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
</section>

<script>
    $(document).ready(function(){
        $("#printButton").click(function(){
            var mode = 'iframe'; // popup
            var close = mode == "popup";
            var options = { mode : mode, popClose : close};
            $("div.box-body").printArea( options );
        });
        $("#printButton1").click(function(){
            var mode = 'iframe'; // popup
            var close = mode == "popup";
            var options = { mode : mode, popClose : close};
            $("div.box-body").printArea( options );
        });
    });

</script>