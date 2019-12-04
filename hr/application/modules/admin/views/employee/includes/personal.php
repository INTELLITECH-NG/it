<!-- View massage -->
<?php echo message_box('success'); ?>
<?php echo message_box('error'); ?>
<!-- general form elements -->
<div class="box box-primary">
    <div class="box-header with-border bg-primary-dark">
        <h3 class="box-title"><?= lang('personal_details') ?></h3>
    </div>
    <!-- /.box-header -->

    <!-- Content Start-->
    <!-- form start -->
    <?php echo form_open_multipart('admin/employee/save_employee_personal_info', $attribute= array('id' => 'personalForm')) ?>



    <div class="box-body">

        <!-- View massage -->
        <?php echo $form->messages(); ?>

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">

                <div class="row">

                    <div class="col-md-6">
                        <div class="form-group">
                            <label><?= lang('first_name') ?><span class="required" aria-required="true">*</span></label>
                            <input type="text" name="first_name" value="<?php echo $employee->first_name ?>" class="form-control">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label><?= lang('last_name') ?><span class="required" aria-required="true">*</span></label>
                            <input type="text" name="last_name" value="<?php echo $employee->last_name ?>" class="form-control">
                        </div>
                    </div>


                    <div class="col-md-6">

                        <!-- /.Start Date -->
                        <div class="form-group form-group-bottom">
                            <label><?= lang('date_of_birth') ?><span class="required" aria-required="true">*</span></label>

                            <div class="input-group">
                                <input type="text" class="form-control" id="datepicker" name="date_of_birth" value="<?php echo $employee->date_of_birth ?>" data-date-format="yyyy/mm/dd">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar-o"></i>
                                </div>
                            </div>
                        </div>

                    </div>


                    <div class="col-md-6">
                        <div class="form-group">
                            <label><?= lang('marital_status') ?></label>
                            <select class="form-control" name="marital_status">
                                <option value=""><?= lang('please_select') ?>..</option>
                                <option value="Singel" <?php if(!empty($employee->marital_status)) echo $employee->marital_status == 'Singel'?'selected':''  ?>><?= lang('singel') ?></option>
                                <option value="Married" <?php if(!empty($employee->marital_status)) echo $employee->marital_status == 'Married'?'selected':''  ?>><?= lang('married') ?></option>
                            </select>
                        </div>
                    </div>


                    <div class="col-md-6">
                        <div class="form-group">
                            <label><?= lang('country') ?><span class="required" aria-required="true">*</span></label>
                            <select class="form-control" name="country">
                                <option value=""><?= lang('please_select') ?>..</option>
                                <?php foreach($countries as $item){ ?>
                                    <option value="<?php echo $item->country ?>" <?php if(!empty($employee->country)) echo $employee->country == $item->country ?'selected':''  ?>><?php echo $item->country ?></option>
                                <?php } ?>

                            </select>
                        </div>
                    </div>


                    <div class="col-md-6">
                        <div class="form-group">
                            <label><?= lang('blood_group') ?></label>
                            <select class="form-control" name="blood_group">
                                <option value=""><?= lang('please_select') ?>..</option>
                                <option value="A" <?php if(!empty($employee->blood_group)) echo $employee->blood_group == 'A'?'selected':''  ?>>A</option>
                                <option value="B" <?php if(!empty($employee->blood_group)) echo $employee->blood_group == 'B'?'selected':''  ?>>B</option>
                                <option value="AB" <?php if(!empty($employee->blood_group)) echo $employee->blood_group == 'AB'?'selected':''  ?>>AB</option>
                                <option value="O" <?php if(!empty($employee->blood_group)) echo $employee->blood_group == 'O'?'selected':''  ?>>O</option>
                            </select>
                        </div>
                    </div>

                </div>

                <div class="form-group">
                    <label><?= lang('id_number') ?></label>
                    <input type="text" name="id_number" value="<?php if(!empty($employee->id_number)) echo $employee->id_number ?>" class="form-control">
                </div>

                <div class="form-group">
                    <label><?= lang('religious') ?> </label>
                    <select class="form-control" name="religious">
                        <option value="Christians" <?php if(!empty($employee->religious)) echo $employee->religious == 'Christians'?'selected':''  ?>>Christians</option>
                        <option value="Muslims" <?php if(!empty($employee->religious)) echo $employee->religious == 'Muslims'?'selected':''  ?>>Muslims</option>
                        <option value="Hindus" <?php if(!empty($employee->religious)) echo $employee->religious == 'Hindus'?'selected':''  ?>>Hindus</option>
                        <option value="Buddhists" <?php if(!empty($employee->religious)) echo $employee->religious == 'Buddhists'?'selected':''  ?>>Buddhists</option>
                        <option value="Jews" <?php if(!empty($employee->religious)) echo $employee->religious == 'Jews'?'selected':''  ?>>Jews</option>
                    </select>

                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label><?= lang('gender') ?><span class="required" aria-required="true">*</span></label>
                            <label class="css-input css-radio css-radio-success push-10-r">
                                <input name="gender" value="Male" <?php echo $employee->gender == 'Male'?'checked':''  ?> type="radio"><span></span><?= lang('male') ?>
                            </label>
                            <label class="css-input css-radio css-radio-success push-10-r">
                                <input name="gender" value="Female" <?php echo $employee->gender == 'Female'?'checked':''  ?> type="radio"><span></span><?= lang('female') ?>
                            </label>
                        </div>
                    </div>
                </div>



                <!-- /.Employee Image -->
                <div class="form-group">
                    <label><?= lang('Photograph') ?></label>
                </div>
                <div class="form-group">
                    <input type="file" name="employee_photo" id="file-1" class="inputfile inputfile-1" data-multiple-caption="{count} files selected"  />
                    <label for="file-1"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17"><path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"/></svg> <span>Choose a file&hellip;</span></label>

                </div>
                <!-- /.Employee Image -->
                <p class="text-muted">Accepts jpg, .png, .gif up to 1MB. Recommended dimensions: 200px X 200px</p>
                <p class="text-muted"><span class="required" aria-required="true">*</span><?= lang('required_field') ?></p>

            </div>




        </div>

    </div>
    <!-- /.box-body -->

    <input type="hidden" name="id" value="<?php echo str_replace(array('+', '/', '='), array('-', '_', '~'), $this->encrypt->encode($employee->id)) ?>">
    <input type="hidden" name="tab_view" value="personal">

    <div class="box-footer">
        <a class="btn bg-navy btn-flat btn-md" id="editPersonal" ><i class="fa fa-pencil-square-o"></i> Edit</a>
        <button id="savePersonal" type="submit" class="btn bg-olive btn-flat" style="display: none;">Save</button>&nbsp;&nbsp;&nbsp;
        <a  class="btn bg-maroon btn-flat" id="cancelPersonal" style="display: none;" >Cancel</a>
    </div>
    <?php echo $form->close(); ?>

</div>
<!-- /.box -->


<script>
    var personalForm = $("#personalForm");
    $("#personalForm :input").attr("disabled", true);
    $('#editPersonal').click(function(event) {
        //event.preventDefault();
        personalForm.find(':disabled').each(function() {
            $(this).removeAttr('disabled');
            $('#cancelPersonal').show();
            $('#savePersonal').show();
            $('#editPersonal').hide();
        });
    });

    $('#cancelPersonal').click(function(event) {
        //event.preventDefault();
        personalForm.find(':enabled').each(function() {
            $(this).attr("disabled", "disabled");
            $('#cancelPersonal').hide();
            $('#savePersonal').hide();
            $('#editPersonal').show();
        });
    });
</script>





<!-- general form elements -->
<div class="box box-primary">
    <div class="box-header with-border bg-primary-dark">
        <h3 class="box-title"><?= lang('attachment') ?></h3>
    </div>
    <!-- /.box-header -->
    <!-- form start -->

    <div class="box-body">

        <!-- View massage -->
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">

            <?php echo form_open('admin/employee/delete_personalAttach') ?>

                <a  data-target="#modalSmall" title="View" data-placement="top" data-toggle="modal"
                    href="<?php echo base_url()?>admin/employee/add_personal_attachment/<?= $employee->id ?>" class="btn bg-navy btn-md btn-flat">
                    <i class="fa fa-plus"></i> <?= lang('add_attachment') ?>
                </a>

                <button type="submit" onclick="return confirm('Are you sure want to delete this record ?');"
                        class="btn btn-danger btn-md btn-flat" id="deletePersonalAttach"><i class="fa fa-trash"></i><?= lang('delete') ?>
                </button>

                        <br/>
                        <br/>

                        <!-- Table -->
                    <?php
                        if(!empty($employee->personal_attachment)) {
                        $personal_attachment = json_decode($employee->personal_attachment);
                    ?>
                            <table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                <tr>
<!--                                    <th class="col-sm-1 active" style="width: 21px"><input type="checkbox" class="checkbox-inline" id="parent_present" /></th>-->
                                    <th class="active">
                                        <label class="css-input css-checkbox css-checkbox-danger">
                                            <input type="checkbox" id="parent_present"><span></span>
                                        </label>
                                    </th>
                                    <th class="active"><?= lang('file_name') ?></th>
                                    <th class="active"><?= lang('description') ?></th>
                                    <th class="active"><?= lang('date_added') ?></th>
                                    <th class="active"><?= lang('added_by') ?></th>

                                </tr>
                                </thead>

                                <tbody>
                                    <?php  foreach($personal_attachment  as $key => $item){ ?>
                                    <tr>
<!--                                        <td><input name="personalAttach[]" value="--><?php //echo $employee->id.'_'.$key ?><!--" class="child_present" type="checkbox" /></td>-->
                                        <td>
                                            <label class="css-input css-checkbox css-checkbox-success">
                                                <input name="personalAttach[]" value="<?php echo $key ?>" type="checkbox" class="child_present"><span></span>
                                            </label>
                                        </td>
                                        <td><a href="<?php echo site_url('admin/employee/download_personalAttachment/'.$employee->id.'_'.$key)?>"><?php echo $item->file ?></a></td>
                                        <td><?php echo $item->description ?></td>
                                        <td><?php echo date(get_option('date_format'), strtotime($item->date)) ?></td>
                                        <td><?php echo $item->added_by ?></td>
                                    </tr>
                                    <?php } ?>
                                </tbody>

                            </table>
                <?php } ?>
                <input type="hidden" name="id" value="<?php echo $employee->id ?>">
            <?php echo form_close() ?>


            </div>
        </div>

    </div>
    <!-- /.box-body -->



</div>
<!-- /.box -->


