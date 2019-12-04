<style>
    .dataTables_filter {
        display: none;
    }
    .dataTables_info{
        display: none;
    }
</style>
<?php echo message_box('success'); ?>
<?php echo message_box('error'); ?>


<div class="row">
    <div class="col-sm-12">

        <div class="row">
            <div class="col-sm-12" data-offset="0">
                <div class="wrap-fpanel">
                    <div class="box box-primary" data-collapsed="0">
                        <div class="box-header with-border bg-primary-dark">
                            <h3 class="box-title"><?= lang('payment_received') ?></h3>
                        </div>
                        <div class="panel-body">
                            <?php echo form_open('admin/reports/paymentReceived', array('class' => 'form-horizontal')) ?>
                            <div class="panel_controls">
                                <div class="form-group margin">
                                    <label class="col-sm-3 control-label"><?= lang('from') ?> <span class="required">*</span></label>

                                    <div class="col-sm-5">
                                        <div class="input-group">
                                            <input type="text" name="start_date" id="date" class="form-control" value="<?php if(!empty($start_date)) echo $start_date ?>" data-format="dd/mm/yyyy">
                                            <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="field-1" class="col-sm-3 control-label"><?= lang('to') ?> <span class="required">*</span></label>

                                    <div class="col-sm-5">
                                        <div class="input-group">
                                            <input type="text" name="end_date" id="date1"  class="form-control" value="<?php if(!empty($end_date)) echo $end_date ?>" data-format="dd/mm/yyyy">
                                            <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-offset-3 col-sm-5">
                                        <button type="submit" id="sbtn" name="sbtn" value="1" class="btn bg-olive btn-md btn-flat"><?= lang('submit') ?></button>
                                    </div>
                                </div>
                            </div>

                            <input type="hidden" name="flag" value="1">
                            <?php echo form_close() ?>




                            <table class="table table-striped table-bordered display-all" cellspacing="0" width="100%">

                                <thead>
                                <tr>
                                    <th><?= lang('date') ?></th>
                                    <th><?= lang('order_no') ?></th>
                                    <th><?= lang('amount') ?></th>
                                    <th><?= lang('payment_method') ?></th>
                                    <th><?= lang('received_by') ?></th>
                                </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $total_gt = 0;

                                    ?>
                                    <?php if(!empty($invoice)){ foreach ($invoice as $item){ ?>
                                        <tr>
                                            <td><?= dateFormat($item->payment_date)?></td>
                                            <td><a href="<?= site_url('admin/sales/sale_preview/'.get_orderID($item->order_id)) ?>"><?= get_orderID($item->order_id)?></a></td>
                                            <td><?= currency($item->amount) ?></td>
                                            <td><?= $item->payment_method ?></td>
                                            <td><?= $item->received_by ?></td>
                                        </tr>

                                        <?php
                                        $total_gt += $item->amount;
                                        ?>

                                    <?php };} ?>

                                    <tr>
                                      
                                        <td style="background-color: #e7e7e7"></td>
                                        <td style="background-color: #e7e7e7"></td>
                                        <td style="background-color: #e7e7e7"><strong>= <?= currency($total_gt)?></strong></td>
                                        <td style="background-color: #e7e7e7"></td>
                                        <td style="background-color: #e7e7e7"></td>

                                    </tr>

                                </tbody>



                            </table>




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
            format: "dd-mm-yyyy",
        });
        $('#date1').datepicker({
            autoclose: true,
            format: "dd-mm-yyyy",
        });
    });
</script>

