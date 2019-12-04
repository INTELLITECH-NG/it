
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
</head>
<body>

<header class="clearfix">
    <div id="logo">
        <img src="<?php echo base_url().UPLOAD_LOGO.get_option('invoice_logo')?>">
    </div>
    <div id="company">
        <h2 style="font-size:30px;" class="name"><?= strtoupper(lang('shipping')) ?></h2>
        <span class="date"><?= lang('order_date') ?>: <?php echo $this->localization->dateFormat($order->date)?></span><br />
        <h2 class="invoce_name"><?= get_option('invoice_prefix')?><?= INVOICE_PRE + $order->id?></h2>
    </div>
</header>



<main>
    <div id="details" class="clearfix">

        <div id="client">
            <div class="to"><?= strtoupper(lang('customer')) ?>:</div>
            <h2 class="name"><?= $customer->name ?></h2>
        </div>



        <div id="invoice_due">
            <div class="to"><?= lang('shipping_address') ?>:</div>
            <div class="due"><?= $order->s_address ?></div>
            <div class="due"><?= lang('phone') ?>: <?= $customer->phone ?></div>
            <div class="due"><?= lang('email') ?>: <?= $customer->email ?></div>
        </div>
    </div>
    <table border="0" cellspacing="0" cellpadding="0">
        <thead>
        <tr>
            <th class="qty"><?= strtoupper(lang('sl')) ?>.</th>
            <th class="qty"><?= strtoupper(lang('product')) ?></th>
            <th class="unit text-right"><?php echo strtoupper(lang('qty')) ?></th>
<!--            <th class="total text-right ">TOTAL</th>-->
            <th class="qty text-right"><?php echo strtoupper(lang('status')) ?></th>
        </tr>
        </thead>
        <tbody>
        <?php $counter = 1?>
        <?php foreach($order_details as $item): ?>
            <tr>
                <td class="qty"><strong><center><?php echo $counter ?></center></strong></td>
                <td class="desc"><strong><center><?php echo $item->product_name ?></center></strong></td>
                <td class="qty"><strong><center><?php echo $item->qty ?></center></strong></td>
                <td class="text-center"> <span class="upfont"><?= lang('partial') ?></span> ____  <span class="upfont"><?= lang('complete') ?></span> ____ </td>
            </tr>
            <?php $counter ++?>
        <?php endforeach; ?>
        </tbody>

    </table>
    <div class="row">
        <div class="container-fluid text-left">
            <div class="col-xs-7 form-group">
                <div class="control-label"><div class="line"></div><p class="upfont"># <?php  echo strtoupper(lang('of_boxes')) ?>:</p><div class="line2"></div></div>
            </div>
            <div class="col-xs-7 form-group">
                <div class="control-label"><div class="line"></div><p class="upfont"><?php  echo strtoupper(lang('qty_per_box')) ?>:</p><div class="line2"></div></div>
            </div>
            <div class="col-xs-7 form-group">
                <div class="control-label"><div class="line"></div><p class="upfont"><?php  echo strtoupper(lang('shrink_wrap_samples')) ?></p><div class="line_none"></div></div>
            </div>
            <div class="col-xs-7 form-group">
                <div class="control-label"><div class="line"></div><p class="upfont"><?php  echo strtoupper(lang('inspectioned_by')) ?>:</p><div class="line2"></div></div>
            </div>
            <div class="col-xs-7 form-group">
                <div class="control-label"><div class="line"></div><p class="upfont"><?php  echo strtoupper(lang('delivered_by')) ?>:</p><div class="line2"></div></div>
            </div>
            <br/>
            <br/>
            <br/>
            <br/>
            <br/>
            <br/>
            <br/>
            <div class="col-xs-7 form-group">
                <div class="control-label"><div class="line"></div><p class="upfont"><?php  echo strtoupper(lang('received_by')) ?>:</p><div class="line2"></div></div>
            </div>
        </div>
    </div>

</main>

</br>
<footer style="width:675px">
    <strong><?php echo get_option('company_name') ?></strong>&nbsp;&nbsp;&nbsp;<?php  echo get_option('address') ?>
</footer>
<!--<script src="--><?php //echo base_url(); ?><!--asset/js/jquery-barcode.min.js"></script>-->
<!--<script type="text/javascript">-->
<!--    $(document).ready(function() {-->
<!--        $(".barinv").each(function() {-->
<!--            var bcdigits = $(this).attr('rel');-->
<!--            $(this).barcode(bcdigits, "code39",{barWidth:2, barHeight:60, showHRI:false, output:"bmp"});-->
<!---->
<!--        });-->
<!--    });-->
<!---->
<!--</script>-->

</body>
</html>