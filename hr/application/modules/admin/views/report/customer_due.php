<style>
    .dataTables_filter {
        display: none;
    }
    .dataTables_info{
        display: none;
    }
</style>
<script type="text/javascript" src="<?php echo base_url()?>assets/js/attendance.js"></script>
<?php echo message_box('success'); ?>
<?php echo message_box('error'); ?>

<style>
    div[id="l_category"]{
        display: none;

    }
    input[class="child_absent"]:checked ~ div[id="l_category"]{
        display:block;
    }
    .child_absent{
        float: left;
    }
</style>

<div class="row">
    <div class="col-sm-12">

        <div class="row">
            <div class="col-sm-12" data-offset="0">
                <div class="wrap-fpanel">
                    <div class="box box-primary" data-collapsed="0">
                        <div class="box-header with-border bg-primary-dark">
                            <h3 class="box-title"><?= lang('customer') ?> <?= lang('payment_due') ?></h3>
                        </div>
                        <div class="panel-body">
                            <?php echo form_open('admin/reports/customerDue', array('class' => 'form-horizontal')) ?>
                            <div class="panel_controls">
                                <div class="form-group margin">
                                    <label class="col-sm-3 control-label"><?= lang('from') ?> <span class="required">*</span></label>

                                    <div class="col-sm-5">
                                        <div class="input-group">
                                            <input type="text" name="start_date" id="date" class="form-control" value="<?php if(!empty($start_date)) echo $start_date ?>" data-format="dd-mm-yyyy" required>
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
                                            <input type="text" name="end_date" id="date1"  class="form-control" value="<?php if(!empty($end_date)) echo $end_date ?>" data-format="dd-mm-yyyy" required>
                                            <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-3 control-label"><?= lang('customer') ?></label>
                                    <div class="col-sm-5">
                                        <select class="form-control select2" name="customer_id" required>
                                            <option value=""><?= lang('please_select') ?>...</option>
                                            <?php foreach($customers as $item){ ?>
                                                <option value="<?php echo $item->id ?>" >
                                                    <?php echo $item->name ?>
                                                </option>
                                            <?php } ?>
                                        </select>
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
                                    <th colspan="8">
                                        <strong><?php if(!empty($customer)) echo $customer->name ?></strong>
                                    </th>
                                </tr>
                                <tr>
                                    <th><?= lang('date') ?></th>
                                    <th><?= lang('order_no') ?></th>
                                    <th><?= lang('due_date') ?></th>
                                    <th><?= lang('grand_total') ?></th>
                                    <th><?= lang('paid') ?></th>
                                    <th><?= lang('balance') ?></th>
                                    <th><?= lang('shipping') ?></th>


                                </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $total_gt = 0;
                                        $total_rec = 0;
                                        $total_due = 0;
                                    ?>
                                    <?php if(!empty($invoice)){ foreach ($invoice as $item){ ?>
                                        <tr>
                                            <td><?= dateFormat($item->date)?></td>
                                            <td><a href="<?= site_url('admin/sales/sale_preview/'.get_orderID($item->id)) ?>"><?= get_orderID($item->id)?></a></td>
                                            <td><?= dateFormat($item->due_date) ?></td>
                                            <td><?= currency($item->grand_total) ?></td>
                                            <td><?= currency($item->amount_received) ?></td>
                                            <td><?= currency($item->due_payment) ?></td>
                                            <td><?= $item->delivery_status ?></td>
                                        </tr>

                                        <?php
                                        $total_gt += $item->grand_total;
                                        $total_rec += $item->amount_received;
                                        $total_due += $item->due_payment;
                                        ?>

                                    <?php };} ?>

                                    <tr>
                                        <td style="background-color: #e7e7e7"></td>
                                        <td style="background-color: #e7e7e7"></td>
                                        <td style="background-color: #e7e7e7"></td>
                                        <td style="background-color: #e7e7e7"><strong>= <?= currency($total_gt)?></strong></td>
                                        <td style="background-color: #e7e7e7"><strong>= <?= currency($total_rec)?></strong></td>
                                        <td style="background-color: #e7e7e7"><strong>= <?= currency($total_due)?></strong></td>
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