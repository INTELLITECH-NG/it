<style>
    .dataTables_filter {
        display: none;
    }
    .dataTables_info{
        display: none;
    }
</style>
<div class="row">
    <div class="col-sm-12">

        <div class="row">
            <div class="col-sm-12" data-offset="0">
                <div class="wrap-fpanel">
                    <div class="box box-primary" data-collapsed="0">
                        <div class="box-header with-border bg-primary-dark">
                            <h3 class="box-title"><?= lang('stock_values') ?></h3>
                        </div>
                        <div class="panel-body">




                            <?php if(!empty($products)){  ?>
                            <table class="table table-striped table-bordered display-all" cellspacing="0" width="100%">

                                <thead>
                                <tr>
                                    <th><?= lang('sl') ?>.</th>
                                    <th><?= lang('sku') ?></th>
                                    <th><?= lang('product') ?></th>
                                    <th><?= lang('inventory') ?></th>
                                    <th><?= lang('total') ?> <?= lang('buying_cost') ?> </th>
                                    <th><?= lang('total') ?> <?= lang('selling_cost') ?></th>
                                </tr>
                                </thead>
                                <tbody>

                                <?php $i = 1; ?>
                                <?php foreach ($products as $item){ ?>

                                        <tr>
                                            <td><?php echo $i ?></td>
                                            <td><?= $item->sku ?></td>
                                            <td><?= $item->name ?></td>
                                            <td><?= $item->inventory ?></td>
                                            <td><?= currency($item->buying_cost * $item->inventory) ?></td>
                                            <td><?= currency($item->sales_cost * $item->inventory) ?></td>
                                        </tr>

                                <?php $i++; } ?>

                                </tbody>

                            </table>

                            <?php }?>


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
        $('#date1').datepicker({
            autoclose: true,
            format: "yyyy-mm-dd",
        });
    });
</script>

<script>




</script>