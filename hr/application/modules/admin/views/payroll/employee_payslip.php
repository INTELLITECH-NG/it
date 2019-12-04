
<?php echo message_box('success'); ?>
<?php echo message_box('error'); ?>


<div class="row">
    <div class="col-sm-12">

        <div class="row">
            <div class="col-sm-12" data-offset="0">
                <div class="wrap-fpanel">
                    <div class="box box-primary" data-collapsed="0">
                        <div class="box-header with-border bg-primary-dark">
                            <h3 class="box-title"><?= lang('employee_payroll_list') ?></h3>
                            <div class="box-tools" style="padding-top: 5px">
                                <div class="input-group input-group-sm" >
                                    <a class="btn" style="color: #FFF" id="printButton">
                                        <i class="fa fa-print fa-2x" aria-hidden="true"></i>
                                    </a>
                                </div>
                            </div>
                        </div>




                        <div class="panel-body">
                            <link href="<?php echo base_url(); ?>assets/css/bootstrap/css/bootstrap.css" media="print" rel="stylesheet" type="text/css" />

                            <div class="container">
                                <h2><?= lang('salary_payslip') ?></h2>
                                <p><?= lang('salary_month') ?>: <?php echo date("F, Y", strtotime($pay_slip->month));  ?></p>


                                <table  width="100%">
                                    <tbody>
                                        <tr>
                                            <th><?= lang('employee') ?></th>
                                            <td> <?php echo $employee->first_name.' '.$employee->last_name ?></td>
                                            <th><?= lang('employee_id') ?></th>
                                            <td> <?php echo $employee->employee_id ?></td>
                                        </tr>

                                        <tr>
                                            <th><?= lang('department') ?></th>
                                            <td><?php echo $employee->department ?></td>
                                            <th><?= lang('job_title') ?></th>
                                            <td><?php echo $employee->job_title ?></td>
                                        </tr>
                                        <?php if($employee->termination == 0){ ?>
                                        <tr>
                                            <th><?= lang('status') ?></th>
                                            <td><span class="label bg-red">Terminated</span></td>
                                        </tr>
                                        <?php }?>
                                    </tbody>
                                </table>

                                <br/><br/>
                                <table class="table" width="100%">
                                    <tbody>
                                    <tr>
                                        <th><?= lang('gross_salary') ?></th>
                                        <td><?php echo $pay_slip->gross_salary ?></td>
                                    </tr>
                                    <tr>
                                        <th><?= lang('deduction') ?></th>
                                        <td><?php echo $pay_slip->deduction ?></td>
                                    </tr>
                                    <tr>
                                        <th><?= lang('net_salary') ?></th>
                                        <td><?php echo $pay_slip->net_salary ?></td>
                                    </tr>
                                    <?php
                                    if(!empty($pay_slip->award)){
                                        $award = json_decode($pay_slip->award);
                                    }
                                    ?>
                                    <?php if(!empty($award)):  foreach($award as $item ): ?>
                                    <tr>
                                        <th><?= lang('award') ?></th>
                                        <td><?php echo $item->award_amount ?> (<?= $item->award_name ?>)</td>
                                    </tr>
                                    <?php endforeach; endif ?>

                                    <?php if(!empty($pay_slip->fine_deduction)): ?>
                                        <tr>
                                            <th><?= lang('fine_deduction') ?></th>
                                            <td><?= $pay_slip->fine_deduction ?></td>
                                        </tr>
                                    <?php endif ?>

                                    <?php if(!empty($pay_slip->bonus)): ?>
                                        <tr>
                                            <th><?= lang('bonus') ?></th>
                                            <td> <?= $pay_slip->bonus ?></td>
                                        </tr>
                                    <?php endif ?>

                                    <tr>
                                        <th><?= lang('payment_amount') ?></th>
                                        <td><?= $pay_slip->net_payment ?></td>
                                    </tr>

                                    <tr>
                                        <th><?= lang('payment_method') ?></th>
                                        <td><?= $pay_slip->payment_method ?></td>
                                    </tr>

                                    <tr>
                                        <th><?= lang('comment') ?></th>
                                        <td> <?= $pay_slip->note ?></td>
                                    </tr>

                                    </tbody>
                                </table>

                            </div>


                        </div>
                    </div>
            </div>
        </div>
    </div>
</div>

    <script>
        $(document).ready(function(){
            $("#printButton").click(function(){
                var mode = 'iframe'; // popup
                var close = mode == "popup";
                var options = { mode : mode, popClose : close};
                $("div.panel-body").printArea( options );
            });
        });

    </script>