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
                            <h3 class="box-title"><?= lang('vendor') ?> <?= lang('payment') ?> <?= lang('summary') ?> <?= lang('report') ?></h3>
                        </div>
                        <div class="panel-body">
                            <?php echo form_open('admin/reports/vendorPaymentByDate', array('class' => 'form-horizontal')) ?>
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
                                    <label class="col-sm-3 control-label"><?= lang('vendor') ?></label>
                                    <div class="col-sm-5">
                                        <select class="form-control select2" name="vendor_id" required>
                                            <option value=""><?= lang('please_select') ?>...</option>
                                            <?php foreach($vendors as $item){ ?>
                                                <option value="<?php echo $item->id ?>" >
                                                    <?php echo $item->company_name ?>
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



                        <?php if(!empty($purchase)){ ?>
                            <table class="table table-striped table-bordered display-all" cellspacing="0" width="40%" >

                                <thead>

                                <tr>
                                    <th><?= lang('vendor') ?> <?= lang('payment') ?> <?= lang('summary') ?> <?= lang('report') ?></th>
                                    <td></td>
                                </tr>

                                </thead>

                                <tbody>
                                    <tr>
                                        <td style="width: 50px"><?= lang('vendor') ?> <?= lang('name') ?>:</td>
                                        <td><?= $purchase->vendor_name ?></td>
                                    </tr>

                                    <tr>
                                        <td><?= lang('from') ?>:</td>
                                        <td><?= dateFormat($start_date) ?></td>
                                    </tr>

                                    <tr>
                                        <td><?= lang('to') ?>:</td>
                                        <td><?= dateFormat($end_date) ?></td>
                                    </tr>

                                    <tr>
                                        <td><?= lang('order_total') ?>:</td>
                                        <td><?= $purchase->total_purchase ?></td>
                                    </tr>

                                    <tr>
                                        <td><?= lang('purchase_total') ?></td>
                                        <td><?= currency($purchase->grand_total) ?></td>
                                    </tr>

                                    <tr>
                                        <td><?= lang('discount_total') ?></td>
                                        <td><?= currency($purchase->discount_total) ?></td>
                                    </tr>

                                    <tr>
                                        <td><?= lang('tax_total') ?></td>
                                        <td><?= currency($purchase->tax_total) ?></td>
                                    </tr>

                                    <tr>
                                        <td><?= lang('transport_cost') ?></td>
                                        <td><?= currency($purchase->transport_total) ?></td>
                                    </tr>

                                    <tr>
                                        <td> <?= lang('total') ?> <?= lang('payment') ?></td>
                                        <td><?= currency($purchase->paid_amount) ?></td>
                                    </tr>

                                    <tr>
                                        <td><?= lang('payment_due') ?> </td>
                                        <td><?= currency($purchase->due_payment) ?></td>
                                    </tr>

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
        $('#date1').datepicker({
            autoclose: true,
            format: "yyyy-mm-dd",
        });
    });
</script>

<script>




</script>