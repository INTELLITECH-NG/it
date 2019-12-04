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
                            <h3 class="box-title"><?= lang('transaction') ?> <?= lang('report') ?></h3>
                        </div>
                        <div class="panel-body">
                            <?php echo form_open('admin/reports/transaction', array('class' => 'form-horizontal')) ?>
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
                                    <label class="col-sm-3 control-label"><?= lang('account') ?></label>
                                    <div class="col-sm-5">
                                        <select class="form-control select2" name="account">
                                            <option value=""><?= lang('please_select') ?>...</option>
                                            <?php foreach($account as $item){ ?>
                                                <option value="<?php echo $item->id ?>" <?php if(!empty($search['account_id'])) echo $search['account_id'] == $item->id ? 'selected':'' ?>>
                                                    <?php echo $item->account_title ?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-3 control-label"><?= lang('transaction_type') ?></label>
                                    <div class="col-sm-5">
                                        <select class="form-control select2" name="transaction_type" >
                                            <option value=""><?= lang('please_select') ?>...</option>
                                            <option value="1" <?php if(!empty($search['transaction_type'])) echo $search['transaction_type'] == 1 ? 'selected':'' ?>><?= lang('deposit') ?></option>
                                            <option value="2" <?php if(!empty($search['transaction_type'])) echo $search['transaction_type'] == 2 ? 'selected':'' ?>><?= lang('expense') ?></option>
                                            <option value="5" <?php if(!empty($search['transaction_type'])) echo $search['transaction_type'] == 5 ? 'selected':'' ?>><?= lang('transfer') ?></option>
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


                            <?php
                                $total_dr = 0;
                                $total_cr = 0;
                                $total_balance = 0;
                            ?>

                            <table class="table table-striped table-bordered display-all" cellspacing="0" width="100%">

                                <thead>
                                <tr>
                                    <th><?= lang('trns_id') ?></th>
                                    <th><?= lang('account') ?></th>
                                    <th><?= lang('type') ?></th>
                                    <th><?= lang('category') ?></th>
                                    <th><?= lang('dr') ?>.</th>
                                    <th><?= lang('cr') ?>.</th>
                                    <th><?= lang('balance') ?></th>
                                    <th><?= lang('date') ?></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php if(!empty($transactions)): foreach($transactions as $item){ ?>
                                    <tr>
                                        <td><?php echo $item->transaction_id ?></td>
                                        <td><?php echo $item->account_title ?></td>
                                        <td><?php echo $item->transaction_type ?></td>
                                        <td><?php echo $item->name ?></td>
                                        <td>
                                            <?php
                                            if($item->transaction_type_id == 1 || $item->transaction_type_id == 4){
                                                echo '<span class="dr">'.$this->localization->currencyFormat($item->amount).'</span>';
                                                $dr_amount = $item->amount;
                                            }else{
                                                echo '<span class="dr">'.$this->localization->currencyFormat(0).'</span>';
                                                $dr_amount = 0;
                                            }
                                            ?>

                                            <?php $total_dr += $dr_amount; ?>
                                        </td>
                                        <td>
                                            <?php
                                            if($item->transaction_type_id == 2 || $item->transaction_type_id == 3 || $item->transaction_type_id == 5 ){
                                                echo '<span class="cr">'.$this->localization->currencyFormat($item->amount).'</span>';
                                                $cr_amount = $item->amount;
                                            }else{
                                                echo '<span class="cr">'.$this->localization->currencyFormat(0).'</span>';
                                                $cr_amount = 0;
                                            }
                                            ?>

                                            <?php $total_cr += $cr_amount; ?>

                                        </td>
                                        <td>
                                            <?php echo '<span class="balance">'.$this->localization->currencyFormat($item->balance).'</span>'; ?>
                                            <?php $total_balance += $item->balance; ?>
                                        </td>
                                        <td><?php echo $this->localization->dateFormat($item->date_time); ?></td>
                                    </tr>
                                <?php }; endif?>


                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td><strong>= <?= $total_dr ?></strong></td>
                                    <td><strong>= <?= $total_cr ?></strong></td>
                                    <td><strong>= <?= $total_balance ?></strong></td>
                                    <td></td>
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