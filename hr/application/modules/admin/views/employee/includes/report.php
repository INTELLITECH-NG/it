<!-- View massage -->
<?php echo message_box('success'); ?>
<?php echo message_box('error'); ?>
<!-- general form elements -->




<div class="box box-primary">
    <div class="box-header with-border bg-primary-dark">
        <h3 class="box-title"><?= lang('assigned_supervisors') ?></h3>
    </div>
    <!-- /.box-header -->
    <!-- form start -->

    <div class="box-body">

        <!-- View massage -->
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">



                <a  data-target="#modalSmall" title="View" data-placement="top" data-toggle="modal"
                    href="<?php echo base_url()?>admin/employee/add_supervisors/<?= str_replace(array('+', '/', '='), array('-', '_', '~'), $this->encrypt->encode($employee->id)) ?>" class="btn bg-navy btn-md btn-flat">
                    <i class="fa fa-plus"></i> <?= lang('add_supervisor') ?>
                </a>

                <button type="submit" onclick="return confirm('Are you sure want to delete this record ?');"
                        class="btn btn-danger btn-md btn-flat" id="deletePersonalAttach"><i class="fa fa-trash"></i> <?= lang('delete') ?>
                </button>

                <br/>
                <br/>

                <!-- Table -->
                <?php
                if(!empty($supervisor)) {

                    ?>
                    <div class="table-responsive">
                    <table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th class="active"><?= lang('employee') ?></th>
                            <th class="active"><?= lang('supervisor') ?></th>
                            <th class="active"><?= lang('actions') ?></th>

                        </tr>
                        </thead>

                        <tbody>
                        <?php if(!empty($supervisor)){?>
                        <?php  foreach($supervisor  as  $item){ ?>
                            <tr>
                                <td><?php echo $item->first_name.' '.$item->last_name ?></td>
                                <td><?php echo $item->supervisor_first_name.' '.$item->supervisor_last_name ?></td>
                                <td>

                                    <div class="btn-group">
                                        <a  data-target="#modalSmall" title="View" data-placement="top" data-toggle="modal"
                                            href="<?php echo site_url('admin/employee/edit_supervisor/'. str_replace(array('+', '/', '='), array('-', '_', '~'), $this->encrypt->encode($item->id)) ) ?>" class="btn btn-xs bg-gray">
                                            <i class="fa fa-pencil"></i>
                                        </a>
                                        <a class="btn btn-xs btn-danger"
                                           onClick="return confirm('Are you sure you want to delete?')" href="<?php echo site_url('admin/employee/delete_supervisor/'. str_replace(array('+', '/', '='), array('-', '_', '~'), $this->encrypt->encode($item->id)) ) ?>" onclick="deleteItem('1')"><i class="glyphicon glyphicon-trash"></i></a>
                                    </div>
                                </td>

                            </tr>
                        <?php }; } ?>
                        </tbody>

                    </table>
                    </div>
                <?php } ?>




            </div>
        </div>

    </div>
    <!-- /.box-body -->
</div>
<!-- /.box -->










<div class="box box-primary">
    <div class="box-header with-border bg-primary-dark">
        <h3 class="box-title"><?= lang('assigned_subordinates') ?></h3>
    </div>
    <!-- /.box-header -->
    <!-- form start -->

    <div class="box-body">

        <!-- View massage -->
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">



                <a  data-target="#modalSmall" title="View" data-placement="top" data-toggle="modal"
                    href="<?php echo base_url()?>admin/employee/add_subordinate/<?= str_replace(array('+', '/', '='), array('-', '_', '~'), $this->encrypt->encode($employee->id)) ?>" class="btn bg-navy btn-md btn-flat">
                    <i class="fa fa-plus"></i> <?= lang('add_subordinate') ?>
                </a>

                <br/>
                <br/>

                <?php
                if(!empty($subordinate)) {

                    ?>
                    <div class="table-responsive">
                    <table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th class="active"><?= lang('employee') ?></th>
                            <th class="active"><?= lang('subordinate') ?></th>
                            <th class="active"><?= lang('actions') ?></th>

                        </tr>
                        </thead>

                        <tbody>
                        <?php if(!empty($subordinate)){?>
                        <?php  foreach($subordinate  as  $item){ ?>
                            <tr>
                                <td><?php echo $item->first_name.' '.$item->last_name ?></td>
                                <td><?php echo $item->subordinate_first_name.' '.$item->subordinate_last_name ?></td>
                                <td>

                                    <div class="btn-group">
                                        <a  data-target="#modalSmall" title="View" data-placement="top" data-toggle="modal"
                                            href="<?php echo site_url('admin/employee/edit_subordinate/'. str_replace(array('+', '/', '='), array('-', '_', '~'), $this->encrypt->encode($item->id))) ?>" class="btn btn-xs bg-gray">
                                            <i class="fa fa-pencil"></i>
                                        </a>
                                        <a class="btn btn-xs btn-danger"
                                           onClick="return confirm('Are you sure you want to delete?')" href="<?php echo site_url('admin/employee/delete_subordinate/'. str_replace(array('+', '/', '='), array('-', '_', '~'), $this->encrypt->encode($item->id)) ) ?>" onclick="deleteItem('1')"><i class="glyphicon glyphicon-trash"></i></a>
                                    </div>
                                </td>

                            </tr>
                        <?php }; } ?>
                        </tbody>

                    </table>
                    </div>
                <?php } ?>



            </div>
        </div>

    </div>
    <!-- /.box-body -->
</div>
<!-- /.box -->


