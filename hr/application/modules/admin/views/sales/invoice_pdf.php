<!doctype html>
<html>
<head>
    <meta charset="utf-8">
</head>

<body>
<div class="invoice-box">
    <table cellpadding="0" cellspacing="0">
        <tr class="top">
            <td colspan="5">
                <table>
                    <tr>
                        <td class="title">
                            <?php $logo = FCPATH.UPLOAD_LOGO.get_option('invoice_logo') ?>
                            <img src="<?php echo $logo ?>" style="height: 100px; width: 150px">
                        </td>

                        <td align="right">
                            <?php if($type != 'Quotation'){ ?>
                                <h2><?= get_option('invoice_prefix')?><?= INVOICE_PRE + $order->id?></h2>
                                <b><?= lang('order_date') ?>:</b> <?php echo $this->localization->dateFormat($order->date)?><br>
                                <b><?= lang('payment_due') ?>:</b> <?php echo $this->localization->dateFormat($order->due_date)?><br>
                            <?php }else{ ?>
                                <h2><?= lang('quotation') ?># <?= INVOICE_PRE + $order->id?></h2>
                                <b><?= lang('estimate_date') ?>: </b> <?php echo $this->localization->dateFormat($order->date)?><br>
                                <b><?= lang('expiration_date') ?>: </b> <?php echo $this->localization->dateFormat($order->due_date)?><br>
                            <?php } ?>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        <tr class="information">
            <td colspan="5">
                <table>
                    <tr>
                        <td>
                            <?= lang('billing_address') ?>
                            <address>
                                <strong><?= $customer->name ?></strong><br>
                                <?= $order->b_address ?><br>
                                <?= lang('phone') ?>: <?= $customer->phone ?><br>
                                <?= lang('email') ?>: <?= $customer->email ?>
                            </address>
                        </td>
                        <?php if($type != 'Quotation'){ ?>
                        <td align="right">
                            <?= lang('shipping_address') ?>
                            <address>
                                <strong><?= $customer->name ?></strong><br>
                                <?= $order->s_address ?><br>
                                <?= lang('phone') ?>: <?= $customer->phone ?><br>
                                <?= lang('email') ?>: <?= $customer->email ?>
                            </address>
                        </td>
                        <?php } ?>
                    </tr>
                </table>
            </td>
        </tr>

        <tr class="heading">
            <td width="2%">#</td>
            <td width="57%"> <?= lang('item') ?> </td>
            <td width="7%"><?= lang('qty') ?></td>
            <td width="16%"><?= lang('unit_price') ?></td>
            <td width="18%"><?= lang('total') ?></td>
        </tr>

        <?php $i=1 ; foreach ($order_details as $item){?>
        <tr class="item">
            <td><?= $i ?></td>
            <td>
                <?= $item->product_name ?>
                <br>
                <small><?= $item->description ?></small>
            </td>
            <td><?= $item->qty ?></td>
            <td><?= $item->sales_cost ?></td>
            <td><?= get_option('currency_symbol').' '.$this->localization->currencyFormat($item->sales_cost * $item->qty) ?></td>
        </tr>
        <?php $i++; } ?>

        <tr class="total">
            <td></td>
            <td rowspan="6"><table width="70%" border="0" cellspacing="2">

                    <tr class="order_note">
                        <?php if(!empty($order->order_note)){?>
                        <td height="110"><strong><?= lang('order_note') ?>:</strong><br>
                            <small> <?= $order->order_note ?> </small></td>
                        <?php }?>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                    </tr>
                    <tr style="border:solid 1px #ccc;">
                        <td><?php echo get_option('invoice_text') ?></td>
                    </tr>
                </table></td>
            <td colspan="2" align="right" style="border-bottom:solid 1px #eee"><?= lang('subtotal') ?>: </td>
            <td style="border-bottom:solid 1px #eee">
                <?= get_option('currency_symbol').' '.$this->localization->currencyFormat($order->cart_total) ?>
            </td>
        </tr>
        <tr class="total">
            <td></td>
            <td colspan="2" align="right" style="border-bottom:solid 1px #eee"><?= lang('tax') ?>:</td>
            <td style="border-bottom:solid 1px #eee"><?= get_option('currency_symbol').' '.$this->localization->currencyFormat($order->tax) ?></td>
        </tr>
        <?php $discount_amount = ($order->cart_total * $order->discount)/100; ?>
        <tr class="total">
            <td></td>
            <td colspan="2" align="right" style="border-bottom:solid 1px #eee"><?= lang('discount') ?>:</td>
            <td style="border-bottom:solid 1px #eee"><?= get_option('currency_symbol').' - '.$this->localization->currencyFormat($discount_amount) ?></td>
        </tr>
        <tr class="total">
            <td></td>
            <td colspan="2" align="right" style="border-bottom:solid 1px #eee"><?= lang('grand_total') ?>:</td>
            <td style="border-bottom:solid 1px #eee"><?= get_option('currency_symbol').' '.$this->localization->currencyFormat($order->grand_total) ?></td>
        </tr>
        <tr class="total">
            <td></td>
            <td colspan="2" align="right" style="border-bottom:solid 1px #eee"><?= lang('received_amount') ?>:</td>
            <td style="border-bottom:solid 1px #eee"><?= get_option('currency_symbol').' '.$this->localization->currencyFormat($order->amount_received) ?></td>
        </tr>
        <tr class="total">
            <td></td>
            <td colspan="2" align="right" style="border-bottom:solid 1px #eee"><?= lang('amount_due') ?>:</td>
            <td style="border-bottom:solid 1px #eee"><?= get_option('currency_symbol').' '.$this->localization->currencyFormat($order->due_payment) ?> </td>
        </tr>
    </table>

    <br/>
    <?php if(!empty($payment)){ ?>
        <table  cellpadding="0" cellspacing="0">

            <tr  class="heading">
                <td><?= lang('date') ?></td>
                <td><?= lang('payment_ref') ?>.</td>
                <td><?= lang('payment_method') ?></td>
                <td><?= lang('amount') ?></td>

            </tr>
            <?php foreach ($payment as $id){ ?>
                <tr  class="total">
                    <td><?php dateFormat($id->payment_date) ?></td>
                    <td><?php echo $id->order_ref ?></td>
                    <td><?php echo $id->payment_method ?></td>
                    <td><?php echo currency($id->amount) ?></td>
                </tr>
            <?php }?>


        </table>
    <?php } ?>

</div>
</body>
</html>
