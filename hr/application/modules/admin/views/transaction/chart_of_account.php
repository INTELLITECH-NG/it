<!-- Main content -->
<section class="content">

    <!-- Your Page Content Here -->

    <div class="row">
        <div class="col-md-12">
            <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header with-border bg-primary-dark">
                    <h3 class="box-title"><?= lang('chart_account_list') ?></h3>
                    <div class="box-tools" style="padding-top: 5px">
                        <div class="input-group input-group-sm" >
                            <a  data-target="#modalSmall" title="View" data-placement="top" data-toggle="modal"
                                href="<?php echo base_url()?>admin/transaction/add_account" class="btn bg-blue-active btn-sm btn-flat">
                                <i class="fa fa-plus"></i> <?= lang('new_account') ?>
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

                    <table id="datatable" class="table table-striped table-bordered datatable-buttons">
                        <thead>
                        <tr>
                            <th><?= lang('name') ?></th>
                            <th><?= lang('description') ?></th>
                            <th><?= lang('account_type') ?></th>
                            <th><?= lang('balance') ?></th>
                            <th><?= lang('actions') ?></th>

                        </tr>
                        </thead>


                        <tbody>
                        <?php foreach($account_head as $item) { ?>

                            <tr>
                                <td>
                                    <a href="<?php echo site_url('admin/transaction/viewTransaction/'.str_replace(array('+', '/', '='), array('-', '_', '~'), $this->encrypt->encode('account-'.$item->id))) ?>">
                                    <?php echo $item->account_title ?>
                                    </a>
                                </td>
                                <td><?php echo $item->description ?></td>
                                <td><?php echo $item->account_type ?></td>
                                <td>
                                    <?php echo $item->balance ?>

                                </td>
                                <td>
                                    <?php if($item->sys): ?>
                                    <div class="btn-group">
                                        <a data-target="#modalSmall" title="View" data-placement="top" data-toggle="modal"
                                           class="btn btn-xs btn-default" href="<?php echo base_url()?>admin/transaction/editAccount/<?php echo str_replace(array('+', '/', '='), array('-', '_', '~'), $this->encrypt->encode($item->id))?>">
                                            <i class="fa fa-pencil"></i>
                                        </a>
                                        <a class="btn btn-xs btn-danger" onClick="return confirm('Are you sure you want to delete?')"
                                           href="<?php echo site_url('admin/transaction/deleteAccount/'. str_replace(array('+', '/', '='), array('-', '_', '~'), $this->encrypt->encode($item->id))) ?>"> <i class="glyphicon glyphicon-trash"></i></a>
                                    </div>
                                    <?php endif ?>
                                </td>
                            </tr>
                        <?php } ?>

                        </tbody>
                    </table>


                </div>


            </div>
            <!-- /.box -->

        </div>
    </div>

</section>
<!-- /.content -->

<script>
    var handleDataTableButtons = function() {
            "use strict";
            0 !== $(".datatable-buttons").length && $(".datatable-buttons").DataTable({
                "iDisplayLength": 25,
                "bSort" : false,
                paging: false,
                dom: "Bfrtip",
                buttons: [{
                    extend: "copy",
                    className: "btn-sm"
                }, {
                    extend: "csv",
                    className: "btn-sm"
                }, {
                    extend: "excel",
                    className: "btn-sm"
                }, {
                    extend: "pdf",
                    className: "btn-sm"
                }, {
                    extend: "print",
                    className: "btn-sm"
                }],
                responsive: !0
            })
        },
        TableManageButtons = function() {
            "use strict";
            return {
                init: function() {
                    handleDataTableButtons()
                }
            }
        }();
</script>
