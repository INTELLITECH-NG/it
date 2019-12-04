
<?php echo message_box('success'); ?>
<?php echo message_box('error'); ?>


<div class="row">
    <div class="col-sm-12">

        <div class="row">
            <div class="col-sm-12" data-offset="0">
                <div class="wrap-fpanel">
                    <div class="box box-primary" data-collapsed="0">
                        <div class="box-header with-border bg-primary-dark">
                            <h3 class="box-title"><?= lang('make_payment') ?></h3>
                        </div>
                        <div class="panel-body">

                                <?php echo form_open('admin/payroll/savePayroll', array('class' => 'form-horizontal')) ?>



                                <div class="panel_controls">


                                    <div class="form-group">
                                        <label for="field-1" class="col-sm-3 control-label"><?= lang('month') ?> </label>
                                        <div style="padding-top: 5px">
                                        <span class="label label-success" style="font-size: 15px"><?php echo $month ?></span>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="field-1" class="col-sm-3 control-label"><?= lang('employee') ?></label>

                                        <div class="col-sm-2" style="padding-top: 5px">
                                            <?php echo $employee->first_name.' '.$employee->last_name ?>
                                        </div>

                                        <label class="col-sm-1 control-label" style="text-align: right"><?= lang('employee_id') ?> </label>

                                        <div class="col-sm-3" style="padding-top: 5px">
                                            <?php echo $employee->employee_id ?>
                                        </div>

                                    </div>

                                    <div class="form-group">
                                        <label for="field-1" class="col-sm-3 control-label"><?= lang('department') ?></label>

                                        <div class="col-sm-2" style="padding-top: 5px">
                                            <?php echo $department->department ?>
                                        </div>

                                        <label class="col-sm-1 control-label" style="text-align: right"><?= lang('job_title') ?> </label>

                                        <div class="col-sm-3" style="padding-top: 5px">
                                            <?php echo $employee->job_title ?>
                                        </div>

                                    </div>

                                    <div class="form-group">
                                        <label for="field-1" class="col-sm-3 control-label"><?= lang('gross_salary') ?></label>

                                        <div class="col-sm-2" style="padding-top: 5px">
                                            <input type="text" value=" <?php echo $this->localization->currencyFormat($salary->total_payable + $salary->total_deduction) ?>" class="form-control" disabled>
                                        </div>

                                        <label class="col-sm-1 control-label" style="text-align: right"><?= lang('deduction') ?> </label>

                                        <div class="col-sm-2" style="padding-top: 5px">
                                            <input type="text" value=" <?php echo $this->localization->currencyFormat($salary->total_deduction) ?>" class="form-control" disabled>
                                        </div>

                                    </div>

                                    <div class="form-group margin">
                                        <label class="col-sm-3 control-label"><?= lang('net_salary') ?> </label>

                                        <div class="col-sm-5">
                                            <input type="text" value=" <?php echo $this->localization->currencyFormat($salary->total_payable) ?>" class="form-control"  disabled>
                                        </div>
                                    </div>

                                    <?php if(!empty($award)): $totalAward = 0; foreach($award as $item ): ?>

                                        <?php if ($item->award_amount == '0.00') { // skip even members
                                            continue;
                                        } ?>

                                        <div class="form-group margin">
                                            <label class="col-sm-3 control-label"><?= lang('award') ?> </label>

                                            <div class="col-sm-5">
                                                <input type="text" value=" <?php echo $this->localization->currencyFormat($item->award_amount) ?>" class="form-control" disabled>
                                                <span style="font-size: small"><?= $item->award_name ?></span>
                                            </div>
                                        </div>
                                        <?php $totalAward += $item->award_amount ?>

                                    <?php endforeach; endif ?>

                                    <?php
                                    if(!empty($totalAward)){
                                        $totalPayable =  $totalAward + $salary->total_payable;
                                    }else{
                                        $totalPayable = $salary->total_payable;
                                    }
                                    ?>
                                    <input type="hidden" value=" <?php echo $totalPayable ?>"  id="net_salary">

                                    <div class="form-group margin">
                                        <label class="col-sm-3 control-label"><?= lang('fine_deduction') ?> </label>

                                        <div class="col-sm-5">
                                            <input type="text" value="<?php if(!empty($payroll)) echo $this->localization->currencyFormat($payroll->fine_deduction) ?>" class="form-control" name="fine_deduction" id="fine_deduction">
                                        </div>
                                    </div>

                                    <div class="form-group margin">
                                        <label class="col-sm-3 control-label"><?= lang('bonus') ?> </label>

                                        <div class="col-sm-5">
                                            <input type="text" value="<?php if(!empty($payroll)) echo $this->localization->currencyFormat($payroll->bonus) ?>" class="form-control" name="bonus" id="bonus">
                                        </div>
                                    </div>

                                    <div class="form-group margin">
                                        <label class="col-sm-3 control-label"><?= lang('payment_amount') ?> </label>

                                        <div class="col-sm-5">
                                            <input type="text" value="<?php if(!empty($payroll)){ echo $payroll->net_payment; }else{ echo $totalPayable; }  ?>" class="form-control" id="payment_amount" name="payment_amount" disabled>
                                        </div>
                                    </div>

                                    <div class="form-group margin">
                                        <label class="col-sm-3 control-label"><?= lang('payment_method') ?> </label>

                                        <div class="col-sm-5">
                                            <select class="form-control select2" name="payment_method">
                                                <option value=""><?= lang('please_select') ?>...</option>
                                                <option value="<?= lang('cash') ?>"><?= lang('cash') ?></option>
                                                <option value="<?= lang('check') ?>"><?= lang('check') ?></option>
                                                <option value="<?= lang('electronic_transfer') ?>"><?= lang('electronic_transfer') ?></option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group margin">
                                        <label class="col-sm-3 control-label"><?= lang('comment') ?> </label>

                                        <div class="col-sm-5">
                                            <input type="text" value="<?php if(!empty($payroll)) echo $payroll->note ?>" name="note" class="form-control">
                                        </div>
                                    </div>

                                    <input type="hidden" name="employee_id" value="<?php echo str_replace(array('+', '/', '='), array('-', '_', '~'), $this->encrypt->encode($employee->id)) ?>" >
                                    <input type="hidden" name="month" value="<?php echo str_replace(array('+', '/', '='), array('-', '_', '~'), $this->encrypt->encode($month)) ?>">

                                    <div class="form-group">
                                        <div class="col-sm-offset-3 col-sm-5">
                                            <button type="submit" id="sbtn" name="sbtn" value="1" class="btn bg-olive btn-md btn-flat"><?= lang('save') ?></button>
                                        </div>
                                    </div>
                                </div>
                           <?php echo form_close() ?>







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

    <script type="text/javascript">
        $(document).on("change", function() {
            var fine = 0;
            var bonus = 0;
            fine = $("#fine_deduction").val();
            bonus = $("#bonus").val();
            var net_salary = $("#net_salary").val();
            var total =  net_salary - fine + + bonus;
            $("#payment_amount").val(total);
        });
    </script>
