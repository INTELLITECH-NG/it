<!-- View massage -->
<?php echo message_box('success'); ?>
<?php echo message_box('error'); ?>
<!-- general form elements -->
<div class="box box-primary">
    <div class="box-header with-border bg-primary-dark">
        <h3 class="box-title"><?= lang('contact_details') ?></h3>
    </div>
    <!-- /.box-header -->
    <!-- form start -->

    <?php echo form_open('admin/employee/save_employeeContact', $attribute= array('id' => 'ContactForm', 'class' => 'ContactForm') ) ?>
    <div class="box-body">

        <?php
        $contact_details = json_decode($employee->contact_details);
        ?>


        <div class="row">
            <div class="col-md-6">

                <div class="form-group">
                        <label><?= lang('address_street_1') ?><span class="required">*</span></label>
                        <input type="text" name="address_1" class="form-control" value="<?php if(!empty($contact_details->address_1)){echo $contact_details->address_1; }?>" >
                </div>


                <div class="form-group">
                    <label><?= lang('city') ?> <span class="required">*</span></label>
                    <input type="text" name="city" class="form-control" value="<?php if(!empty($contact_details->city)){echo $contact_details->city; }?>" >
                </div>

                <div class="form-group">
                    <label><?= lang('zip_postal_code') ?><span class="required">*</span></label>
                    <input type="text" name="postal" class="form-control" value="<?php if(!empty($contact_details->postal)){echo $contact_details->postal; }?>" >
                </div>

                <hr/>
                <div class="form-group">
                    <label><?= lang('home_telephone') ?> <span class="required">*</span></label>
                    <input type="text" name="home_telephone" class="form-control" value="<?php if(!empty($contact_details->home_telephone)){echo $contact_details->home_telephone; }?>" >
                </div>

                <div class="form-group">
                    <label><?= lang('work_telephone') ?></label>
                    <input type="text" name="work_telephone" class="form-control" value="<?php if(!empty($contact_details->home_telephone)){echo $contact_details->home_telephone; }?>" >
                </div>

                <div class="form-group">
                    <label><?= lang('mobile') ?></label>
                    <input type="text" name="mobile" class="form-control" value="<?php if(!empty($contact_details->mobile)){echo $contact_details->mobile; }?>" >
                </div>

                <span class="required">*</span><?= lang('required_field') ?>

            </div>



            <div class="col-md-6">

                <div class="form-group">
                    <label><?= lang('address_street_2') ?></label>
                    <input type="text" name="address_2" class="form-control" value="<?php if(!empty($contact_details->address_2)){echo $contact_details->address_2; }?>" >
                </div>

                <div class="form-group">
                    <label><?= lang('state_province') ?><span class="required">*</span></label>
                    <input type="text" name="state" class="form-control" value="<?php if(!empty($contact_details->state)){echo $contact_details->state; }?>" >
                </div>

                <div class="form-group">
                    <label><?= lang('country') ?><span class="required">*</span></label>
                    <select class="form-control" name="country" >
                        <option value=""><?= lang('please_select') ?>...</option>
                        <?php foreach($countries as $country){ ?>
                            <option value="<?php echo $country->country ?>" <?php if(!empty($contact_details->country)) echo $contact_details->country == $country->country ?'selected':''  ?>><?php echo $country->country ?></option>
                        <?php } ?>
                    </select>
                </div>

                <hr/>
                <div class="form-group">
                    <label><?= lang('work_email') ?></label>
                    <input type="text" name="work_email" class="form-control" value="<?php if(!empty($contact_details->work_email)){echo $contact_details->work_email; }?>" >
                </div>

                <div class="form-group">
                    <label><?= lang('other_email') ?></label>
                    <input type="text" name="other_email" class="form-control" value="<?php if(!empty($contact_details->other_email)){echo $contact_details->other_email; }?>" >
                </div>



            </div>

        </div>

        <input type="hidden" name="id" value="<?php echo str_replace(array('+', '/', '='), array('-', '_', '~'), $this->encrypt->encode($employee->id)) ?>" >

    </div>
    <!-- /.box-body -->

    <div class="box-footer">
        <a class="btn bg-navy btn-flat" id="editContact" ><i class="fa fa-pencil-square-o"></i><?= lang('edit') ?></a>
        <button id="saveContact" type="submit" class="btn bg-olive btn-flat" style="display:none ;"><?= lang('save') ?></button>&nbsp;&nbsp;&nbsp;
        <a  class="btn bg-maroon btn-flat" id="cancelContact" style="display: none;" ><?= lang('cancel') ?></a>
    </div>

    <?php echo form_close() ?>
</div>
<!-- /.box -->


<script>



</script>


<script>
    $("#ContactForm :input").attr("disabled", true);
    var contactForm = $("#ContactForm");
    $('#editContact').click(function(event) {
        //event.preventDefault();
        contactForm.find(':disabled').each(function() {
            $(this).removeAttr('disabled');
            $('#saveContact').show();
            $('#cancelContact').show();
            $('#editContact').hide();
        });
    });

    $('#cancelContact').click(function(event) {
        //event.preventDefault();
        contactForm.find(':enabled').each(function() {
            $(this).attr("disabled", "disabled");
            $('#saveContact').hide();
            $('#cancelContact').hide();
            $('#editContact').show();
        });
    });
</script>



<div class="box box-primary">
    <div class="box-header with-border bg-primary-dark">
        <h3 class="box-title"><?= lang('emergency_contact') ?></h3>
    </div>
    <!-- /.box-header -->
    <!-- form start -->

    <div class="box-body">

        <!-- View massage -->
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">

                <?php echo form_open('admin/employee/delete_emergencyContact') ?>

                <a  data-target="#modalSmall" title="View" data-placement="top" data-toggle="modal"
                    href="<?php echo base_url()?>admin/employee/add_emergency_contact/<?= str_replace(array('+', '/', '='), array('-', '_', '~'), $this->encrypt->encode($employee->id)) ?>" class="btn bg-navy btn-md btn-flat">
                    <i class="fa fa-plus"></i> <?= lang('add_emegergency') ?>
                </a>

                <button type="submit" onclick="return confirm('Are you sure want to delete this record ?');"
                        class="btn btn-danger btn-md btn-flat" id="deletePersonalAttach"><i class="fa fa-trash"></i> <?= lang('delete') ?>
                </button>

                <br/>
                <br/>

                <!-- Table -->
                <?php
                if(!empty($employee->emergency_contact)) {
                    $emergency_contact = json_decode($employee->emergency_contact);
                    ?>
                    <div class="table-responsive">
                    <table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <!--                                    <th class="col-sm-1 active" style="width: 21px"><input type="checkbox" class="checkbox-inline" id="parent_present" /></th>-->
                            <th class="active">
                                <label class="css-input css-checkbox css-checkbox-danger">
                                    <input type="checkbox" id="parent_present"><span></span>
                                </label>
                            </th>
                            <th class="active"><?= lang('name') ?></th>
                            <th class="active"><?= lang('relationship') ?></th>
                            <th class="active"><?= lang('home_telephone') ?></th>
                            <th class="active"><?= lang('mobile') ?></th>
                            <th class="active"><?= lang('work_telephone') ?></th>
                            <th class="active"><?= lang('actions') ?></th>

                        </tr>
                        </thead>

                        <tbody>
                        <?php if(!empty($emergency_contact)){?>
                        <?php  foreach($emergency_contact  as $key => $item){ ?>
                            <tr>
                                <!--                                        <td><input name="personalAttach[]" value="--><?php //echo $employee->id.'_'.$key ?><!--" class="child_present" type="checkbox" /></td>-->
                                <td>
                                    <label class="css-input css-checkbox css-checkbox-success">
                                        <input name="emergencyContact[]" value="<?php echo $key ?>" type="checkbox" class="child_present"><span></span>
                                    </label>
                                </td>
                                <td><?php echo $item->name ?></td>
                                <td><?php echo $item->relationship ?></td>
                                <td><?php echo $item->home_telephone ?></td>
                                <td><?php echo $item->mobile ?></td>
                                <td><?php echo $item->work_telephone ?></td>
                                <td>


                                    <a  data-target="#modalSmall" title="View" data-placement="top" data-toggle="modal"
                                        href="<?php echo site_url('admin/employee/edit_emergency_contact/'.$employee->id.'_'.$key) ?>" class="btn btn-xs bg-gray">
                                        <i class="fa fa-pencil"></i>
                                    </a>
                                </td>

                            </tr>
                        <?php }; } ?>
                        </tbody>

                    </table>
                    </div>
                <?php } ?>
                <input type="hidden" name="id" value="<?php echo str_replace(array('+', '/', '='), array('-', '_', '~'), $this->encrypt->encode($employee->id)) ?>">
                <?php echo form_close() ?>


            </div>
        </div>

    </div>
    <!-- /.box-body -->



</div>
<!-- /.box -->


