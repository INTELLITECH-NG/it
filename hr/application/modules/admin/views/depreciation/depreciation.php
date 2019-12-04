
<?php echo message_box('success'); ?>
<?php echo message_box('error'); ?>


<div class="row">
    <div class="col-sm-12">

        <div class="row">
            <div class="col-sm-12" data-offset="0">
                <div class="wrap-fpanel">
                    <div class="box box-primary" data-collapsed="0">
                        <div class="box-header with-border bg-primary-dark">
                            <h3 class="box-title"><?= lang('asset_depreciation') ?></h3>
                        </div>
                        <div class="panel-body">




                            <?php if(!empty($depreciation)){ ?>
                                <table id="datatable" class="table table-striped table-bordered datatable-buttons">
                                    <thead>
                                    <tr class="active">
                                        <th><?= lang('year') ?></th>
                                        <th><?= lang('beginning_book_value') ?></th>
                                        <th><?= lang('depreciable_cost') ?></th>
                                        <th><?= lang('rate') ?>%</th>
                                        <th><?= lang('expense') ?></th>
                                        <th><?= lang('accumulated') ?></th>
                                        <th><?= lang('ending_book_value') ?></th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    <?php foreach ($depreciation as $key=> $item){ ?>

                                        <tr>
                                            <td><?= $item['year'] ?></td>
                                            <td><?= $item['beginning_value'] ?></td>
                                            <td><?= $item['depreciate_cost'] ?></td>
                                            <td><?= $item['depreciate_rate'] ?></td>
                                            <td><?= $item['depreciation_expense'] ?></td>
                                            <td><?= $item['accumulated'] ?></td>
                                            <td><?= $item['ending_value'] ?></td>

                                        </tr>
                                    <?php }?>

                                    </tbody>
                                </table>
                            <?php } ?>





                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(function() {
            $('#date').datepicker({
                autoclose: true,
                format: "yyyy-mm-dd",
            });
        });
    </script>
