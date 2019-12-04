<!-- View massage -->
<?php echo message_box('success'); ?>
<?php echo message_box('error'); ?>
<!-- general form elements -->



<div class="box box-primary">
    <div class="box-header with-border bg-primary-dark">
        <h3 class="box-title"><?= lang('dependents') ?></h3>
    </div>
    <!-- /.box-header -->
    <!-- form start -->

    <div class="box-body">

        <!-- View massage -->
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">

                <?php echo form_open('admin/employee/delete_dependent') ?>

                <a  data-target="#modalSmall" title="View" data-placement="top" data-toggle="modal"
                    href="<?php echo base_url()?>admin/employee/add_dependent/<?= str_replace(array('+', '/', '='), array('-', '_', '~'), $this->encrypt->encode($employee->id)) ?>" class="btn bg-navy btn-md btn-flat">
                    <i class="fa fa-plus"></i> <?= lang('add_dependent') ?>
                </a>

                <button type="submit" onclick="return confirm('Are you sure want to delete this record ?');"
                        class="btn btn-danger btn-md btn-flat" id="deletePersonalAttach"><i class="fa fa-trash"></i> <?= lang('delete') ?>
                </button>

                <br/>
                <br/>

                <!-- Table -->
                <?php
                if(!empty($employee->dependents)) {
                    $dependents = json_decode($employee->dependents);
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
                            <th class="active"><?= lang('date_of_birth') ?></th>
                            <th class="active"><?= lang('actions') ?></th>


                        </tr>
                        </thead>

                        <tbody>
                        <?php if(!empty($dependents)){?>
                        <?php  foreach($dependents  as $key => $item){ ?>
                            <tr>
                                <!--                                        <td><input name="personalAttach[]" value="--><?php //echo $employee->id.'_'.$key ?><!--" class="child_present" type="checkbox" /></td>-->
                                <td>
                                    <label class="css-input css-checkbox css-checkbox-success">
                                        <input name="dependentId[]" value="<?php echo $key ?>" type="checkbox" class="child_present"><span></span>
                                    </label>
                                </td>
                                <td><?php echo $item->name ?></td>
                                <td><?php echo $item->relationship ?></td>
                                <td><?php echo date(get_option('date_format'), strtotime($item->date_of_birth)) ?></td>
                                <td>
                                    <a  data-target="#modalSmall" title="View" data-placement="top" data-toggle="modal"
                                        href="<?php echo site_url('admin/employee/edit_dependent/'.$employee->id.'_'.$key) ?>" class="btn btn-xs bg-gray">
                                        <i class="fa fa-pencil"></i>
                                    </a>
                                </td>

                            </tr>
                        <?php }; } ?>
                        </tbody>

                    </table>
                    </div>
                <?php } ?>
                <input type="hidden" name="id" value="<?php echo $employee->id ?>">
                <?php echo form_close() ?>


            </div>
        </div>

    </div>
    <!-- /.box-body -->



</div>
<!-- /.box -->


