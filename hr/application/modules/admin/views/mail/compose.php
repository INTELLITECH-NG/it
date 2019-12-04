
<?php echo message_box('success'); ?>
<?php echo message_box('error'); ?>



<div class="row">
<div class="col-md-12">

    <?php echo form_open_multipart('admin/mail/sendEmail') ?>
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title"><?= lang('compose_new_message') ?></h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">


            <div class="form-group">
                <select class="select2 form-control" multiple="multiple" data-placeholder="To:" style="width: 100%;" name="employee_id[]">
                    <option value="" ><?= lang('select_department') ?></option>
                    <?php foreach($employee as $name=> $item): ?>
                        <optgroup label="<?php echo $name ?>">
                            <?php foreach($item as $emp): ?>
                                <?php if(!empty($mail)){
                                    $cc = json_decode($mail->cc);
                                    $from_id = $mail->from_emp_id;
                                    $type = $mail->from_type == 'admin' ? 'A':'E';
                                    $cc[] = $from_id.'*'.$type;
                                ?>

                                    <option value="<?php echo $emp->id  ?>"
                                        <?php foreach($cc as $to) :
                                            $empID = $this->ion_auth->user()->row()->id.'*'.'A';
                                            if ($to == $empID) { // skip even members
                                                continue;
                                            }
                                        ?>

                                            <?php echo $to == $emp->id ? 'selected':'' ?>
                                        <?php endforeach ?>
                                    ><?php echo $emp->name ?></option>

                                <?php }else{ ?>
                                    <option value="<?php echo $emp->id  ?>" ><?php echo $emp->name ?></option>
                                <?php } ?>
                            <?php endforeach ?>
                        </optgroup>
                    <?php endforeach ?>

                </select>
            </div>

<!--            <div class="form-group">-->
<!--                <select class="form-control select2" data-placeholder="--><?//= lang('select_department') ?><!--" name="department" id="department" onchange="get_employeeAdmin(this.value)">-->
<!--                    <option value="" >--><?//= lang('select_department') ?><!--</option>-->
<!--                    <option value="admin" >--><?//= lang('admin') ?><!--</option>-->
<!--                    --><?php //foreach ($department as $v_department) : ?>
<!--                        <option value="--><?php //echo $v_department->id ?><!--" >-->
<!--                            --><?php //echo $v_department->department ?><!--</option>-->
<!--                    --><?php //endforeach; ?>
<!---->
<!--                </select>-->
<!--            </div>-->
<!--            <div class="form-group">-->
<!--                <select class="form-control select2" multiple="multiple" data-placeholder="To:" style="width: 100%;" name="employee_id[]" id="employee">-->
<!---->
<!--                </select>-->
<!--            </div>-->

            <div class="form-group">
                <input class="form-control" placeholder="<?= lang('subject') ?>:" name="subject" value="<?php if(!empty($mail)) echo 'Re: '.$mail->subject ?>">
            </div>


            <div class="form-group">
                <?php if(!empty($mail)) { ?>
                    <textarea id="compose-textarea" name="msg" class="form-control" style="height: 300px">
                        <?php

                            echo '</br></br></br>';
                            echo '--------------------------------------------------------------</br>';
                            if($emailType == 'inbox'){
                                echo '<strong>From:</strong> '.$mail->sender_name .'</br>';
                            }
                            echo '<strong>Time:</strong> '. date("j F, Y, g:i a", strtotime($mail->date) ).'</br>';
                            echo '<strong>To:</strong> ';

                            //$to_type = $mail->to_type;
                            $cc = json_decode($mail->cc);

                            foreach( $cc as $to){
                                $result =  explode("*", $to);
                                if($result[1] == 'A')
                                {
                                    $employee = $this->db->get_where('admin_users', array(
                                        'id' => $result[0]
                                    ))->row();
                                    echo $employee->first_name.' '.$employee->last_name .'; &nbsp';
                                }else
                                {
                                    $employee = $this->db->get_where('employee', array(
                                        'id' => $result[0]
                                    ))->row();
                                    echo $employee->first_name.' '.$employee->last_name .'; &nbsp';
                                }

                            }

                            echo '<br>';
                            echo '--------------------------------------------------------------</br>';
                            echo $mail->msg;
                        ?>
                    </textarea>
                <?php }else{?>
                    <textarea id="compose-textarea" name="msg" class="form-control" style="height: 300px"></textarea>
                <?php } ?>
            </div>
            <div class="form-group">
                <div class="btn btn-default btn-file">
                    <i class="fa fa-paperclip"></i> <?= lang('attachment') ?>
                    <input type="file" id="file" multiple="multiple" name="attachment[]" onchange="javascript:updateList()">
                </div>
                <div class="help-block" id="fileList"></div>
                <p class="help-block">Max. 32MB</p>
            </div>
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
            <div class="pull-right">
                <button type="submit" class="btn btn-primary"><i class="fa fa-envelope-o"></i> <?= lang('send') ?></button>
            </div>
            <a type="reset" class="btn btn-default" href="<?php echo site_url('admin/mail') ?>">
                <i class="fa fa-times"></i> <?= lang('discard') ?></a>
        </div>
        <!-- /.box-footer -->
    </div>
    <?php echo form_close() ?>


    <!-- /. box -->
</div>

</div>



    <script>
        $(function () {
            //Add text editor
            $("#compose-textarea").wysihtml5();
        });


        updateList = function() {
            var input = document.getElementById('file');
            var output = document.getElementById('fileList');

            output.innerHTML = '<ul>';
            for (var i = 0; i < input.files.length; ++i) {
                output.innerHTML += '<li>' + input.files.item(i).name + '</li>';
            }
            output.innerHTML += '</ul>';
        }

    </script>




