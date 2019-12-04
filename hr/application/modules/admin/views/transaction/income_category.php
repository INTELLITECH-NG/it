<div class="row">
    <div class="col-md-12">
        <!-- general form elements -->
        <div class="box box-primary">
            <div class="box-header with-border bg-primary-dark">
                <h3 class="box-title"><?= lang('income_categories') ?></h3>

                <div class="box-tools" style="padding-top: 5px">
                    <div class="input-group input-group-sm" >
                        <a  data-target="#modalSmall" title="View" data-placement="top" data-toggle="modal"
                            href="<?php echo base_url()?>admin/transaction/add_income_category" class="btn btn-sm bg-blue-active btn-flat">
                            <i class="fa fa-plus"></i> <?= lang('add_income') ?>
                        </a>
                    </div>
                </div>
            </div>
            <!-- /.box-header -->
            <!-- form start -->

            <div class="box-body">

                <!-- View massage -->
                <?php echo message_box('success'); ?>
                <?php echo message_box('error'); ?>

                <div class="row">
                    <div class="col-md-12">


                        <div id="msg"></div>


                        <table id="datatable" class="table table-striped table-bordered" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th class="active"><?= lang('name') ?></th>
                                <th class="active"><?= lang('description') ?></th>
                                <th class="active" style="width:125px;"><?= lang('actions') ?></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach($category as $item){ ?>
                                <tr>
                                    <td><?php echo $item->name?></td>
                                    <td><?php echo $item->description?></td>
                                    <td>
                                        <div class="btn-group">
                                            <a data-target="#modalSmall" title="View" data-placement="top" data-toggle="modal"
                                               class="btn btn-xs btn-default" href="<?php echo base_url()?>admin/transaction/add_income_category/<?php echo $item->id?>">
                                                <i class="fa fa-pencil"></i>
                                            </a>
                                            <a class="btn btn-xs btn-danger" onClick="return confirm('Are you sure you want to delete?')"
                                               href="<?php echo site_url('admin/transaction/deleteCategory/'.$item->id) ?>"> <i class="glyphicon glyphicon-trash"></i></a>
                                        </div>
                                    </td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->

    </div>
</div>