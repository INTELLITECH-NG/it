
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
    <h4 class="modal-title" id="myModalLabel"><?= lang('view_payment') ?></h4>
</div>

<div class="modal-body">

    <div class="printArea" id="printArea">
        <link href="<?php echo base_url(); ?>assets/css/bootstrap/css/bootstrap.css" media="print" rel="stylesheet" type="text/css" />



        <table width="100%" border="0" cellpadding="10" cellspacing="15">
            <tr>
                <td width="50%"><img src="<?php echo base_url().UPLOAD_LOGO.get_option('invoice_logo')?>" style="height: 100px; width: 150px"></td>
                <td width="50%">
                    <h4><?= lang('date') ?>: <?php echo date("d/m/Y")?></h4>
                    <h4><?= lang('purchase_ref') ?>: <?php echo get_orderID($order->id) ?></h4>
                    <h4><?= lang('payment_ref') ?>: <?php echo get_orderID($payment->order_ref) ?></h4>
                </td>
            </tr>
            <tr>
                <td colspan="2"><hr/></td>
            </tr>
            <tr>
                <td>
                    <address>
                        <?= lang('to') ?>: <br>
                        <h4><?= $vendor->company_name ?></h4>
                        <?= $vendor->b_address ?><br>
                        <?= lang('phone') ?>: <?= $vendor->phone ?><br>
                        <?= lang('email') ?>: <?= $vendor->email ?>
                    </address>
                </td>
                <td>
                    <address>
                        <?= lang('from') ?>: <br>
                        <h4><?= get_option('company_name') ?></h4>
                        <?= get_option('address') ?><br>
                        <?= lang('phone') ?>: <?= get_option('phone') ?><br>
                        <?= lang('email') ?>: <?= get_option('email') ?>
                    </address>
                </td>
            </tr>
            <tr>
                <td colspan="2"><hr/></td>
            </tr>
            <tr>
                <td colspan="2" style="background:#F5F5F5; border:solid 1px #ccc;">
                    <table width="100%" border="0" cellpadding="5" cellspacing="5">
                        <tr style="">
                            <td style="padding: 10px">
                                <h4><?= lang('payment_sent') ?></h4>
                            </td>
                            <td align="right" style="padding: 10px">
                                <h4> <?= currency($payment->amount) ?></h4>
                            </td>
                        </tr>
                        <tr>
                            <td style="padding: 10px">
                                <h4><?= lang('paid_by') ?> </h4>
                            </td>
                            <td align="right" style="padding: 10px">
                                <h4><?=  $payment->payment_method; if(!empty($payment->payment_ref)) echo ' ('. $payment->payment_ref .')' ?></h4>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td style="border-top: dotted 2px #ccc"><?= lang('authorized_signature') ?></td>
                <td>&nbsp;</td>
            </tr>
        </table>


</div>



    <br/>
    <br/>

    <div class="modal-footer" >
        <button type="button" id="close" class="btn btn-danger btn-flat pull-left" data-dismiss="modal"><?= lang('close') ?></button>
        <a id="printButton" class="btn btn-default"><i class="fa fa-print"></i> <?= lang('print') ?></a>
    </div>

</div>
<script>
        $("#printButton").click(function(){
            var prtContent = document.getElementById("printArea");
            var WinPrint = window.open('', '', 'left=0,top=0,width=800,height=900,toolbar=0,scrollbars=0,status=0');
            WinPrint.document.write(prtContent.innerHTML);
            WinPrint.document.close();
            WinPrint.focus();
            WinPrint.print();
            WinPrint.close();
        });

        $('#modalSmall').on('hidden.bs.modal', function () {
            location.reload();
        });

        $('body').on('hidden.bs.modal', '.modal', function () {
            $(this).removeData('bs.modal');
        });
</script>

