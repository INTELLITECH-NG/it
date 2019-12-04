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
                            <h3 class="box-title"><?= lang('summary') ?> <?= lang('transaction') ?> <?= lang('report') ?></h3>
                        </div>
                        <div class="panel-body">
                            <?php echo form_open('admin/reports/summaryTransaction', array('class' => 'form-horizontal')) ?>
                            <div class="panel_controls">

                                <div class="form-group margin">
                                    <label class="col-sm-3 control-label"><?= lang('from') ?> <span class="required">*</span></label>

                                    <div class="col-sm-5">
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="datepicker" name="start_date" data-date-format="yyyy/mm/dd" value="<?php if(!empty($search['start_date'])) echo $search['start_date'] ?>">
                                            <div class="input-group-addon">
                                                <i class="fa fa-calendar-o"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label"><?= lang('to') ?> <span class="required">*</span></label>
                                    <div class="col-sm-5">
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="datepicker-1" name="end_date" data-date-format="yyyy/mm/dd" value="<?php if(!empty($search['end_date'])) echo $search['end_date'] ?>">
                                            <div class="input-group-addon">
                                                <i class="fa fa-calendar-o"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-3 control-label"><?= lang('transaction') ?> <?= lang('type') ?></label>
                                    <div class="col-sm-5">
                                        <select class="form-control select2" name="transaction_type_id" required>
                                            <option value=""><?= lang('please_select') ?>...</option>
                                            <option value="1"><?= lang('deposit') ?></option>
                                            <option value="2"><?= lang('expense') ?></option>
                                            <option value="3"><?= lang('accounts_payable') ?></option>
                                            <option value="4"><?= lang('accounts_receivable') ?></option>
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



                        <?php if(!empty($transaction)){ ?>
                            <table class="table table-striped table-bordered display-all" cellspacing="0" width="40%" >

                                <thead>

                                <tr>
                                    <th><?= lang('transaction') ?> <?= lang('report') ?></th>
                                    <td></td>
                                </tr>

                                </thead>

                                <tbody>
                                    <tr>
                                        <td style="width: 150px"><?= lang('transaction') ?> <?= lang('type') ?>:</td>
                                        <td><?= $transaction->transaction_type ?></td>
                                    </tr>

                                    <tr>
                                        <td><?= lang('from') ?></td>
                                        <td><?= dateFormat($start_date) ?></td>
                                    </tr>

                                    <tr>
                                        <td><?= lang('to') ?></td>
                                        <td><?= dateFormat($end_date) ?></td>
                                    </tr>

                                    <tr>
                                        <td><?= lang('total') ?> <?= lang('transaction') ?></td>
                                        <td><?= $transaction->total_transaction ?></td>
                                    </tr>

                                    <tr>
                                        <td><?= lang('total') ?> <?= lang('amount') ?></td>
                                        <td><?= currency($transaction->total_amount) ?></td>
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