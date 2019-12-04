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
                            <h3 class="box-title"><?= lang('summary') ?> <?= lang('account') ?> <?= lang('report') ?></h3>
                        </div>
                        <div class="panel-body">
                            <?php echo form_open('admin/reports/summaryAccount', array('class' => 'form-horizontal')) ?>
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
                                        <select class="form-control select2" name="account_id">
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
                                    <div class="col-sm-offset-3 col-sm-5">
                                        <button type="submit" id="sbtn" name="sbtn" value="1" class="btn bg-olive btn-md btn-flat"><?= lang('submit') ?></button>
                                    </div>
                                </div>
                            </div>

                            <input type="hidden" name="flag" value="1">
                            <?php echo form_close() ?>



                        <?php if(!empty($dr)){ ?>
                            <table class="table table-striped table-bordered display-all" cellspacing="0" width="40%" >

                                <thead>

                                <tr>
                                    <th><?= lang('account') ?> <?= lang('summary') ?></th>
                                    <td></td>
                                </tr>

                                </thead>

                                <tbody>
                                    <tr>
                                        <td style="width: 200px"><?= lang('account') ?>:</td>
                                        <td><?= $account_name ?></td>
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
                                        <td><?= lang('total') ?> <?= lang('dr') ?></td>
                                        <td><?= currency($dr->total_dr) ?></td>
                                    </tr>

                                    <tr>
                                        <td><?= lang('total') ?> <?= lang('cr') ?></td>
                                        <td><?= currency($cr->total_cr) ?></td>
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