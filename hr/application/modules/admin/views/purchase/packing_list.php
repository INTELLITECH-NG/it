
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
        <h2 style="font-size:30px;" class="name">SHIPPING </h2>
        <span class="date">Ordered Date: <?php echo $this->localization->dateFormat($order->date)?></span><br />
        <h2 class="invoce_name"><?= get_option('invoice_prefix')?><?= INVOICE_PRE + $order->id?></h2>
    </div>
</header>



<main>
    <div id="details" class="clearfix">

        <div id="client">
            <div class="to">CUSTOMER:</div>
            <h2 class="name"><?= $customer->name ?></h2>
<!--            <div class="address">--><?php //echo $order_info->customer_address ?><!--</div>-->
<!--            <div class="address">--><?php //echo $order_info->customer_phone ?><!--</div>-->
<!--            <div class="email">--><?php //echo $order_info->customer_email ?><!--</div>-->
        </div>



        <div id="invoice_due">
            <div class="to">Shipping Address:</div>
            <div class="due"><?= $order->s_address ?></div>
            <div class="due">Phone: <?= $customer->phone ?></div>
            <div class="due">Email: <?= $customer->email ?></div>
        </div>
    </div>
    <table border="0" cellspacing="0" cellpadding="0">
        <thead>
        <tr>
            <th class="qty">SL.</th>
            <th class="qty">PRODUCT</th>
            <th class="unit text-right">QTY</th>
<!--            <th class="total text-right ">TOTAL</th>-->
            <th class="qty text-right">Status</th>
        </tr>
        </thead>
        <tbody>
        <?php $counter = 1?>
        <?php foreach($order_details as $item): ?>
            <tr>
                <td class="qty"><strong><center><?php echo $counter ?></center></strong></td>
                <td class="desc"><strong><center><?php echo $item->product_name ?></center></strong></td>
                <td class="qty"><strong><center><?php echo $item->qty ?></center></strong></td>
                <td class="text-center"> <span class="upfont">Partial</span> ____  <span class="upfont">Complete</span> ____ </td>
            </tr>
            <?php $counter ++?>
        <?php endforeach; ?>
        </tbody>

    </table>
    <div class="row">
        <div class="container-fluid text-left">
            <div class="col-xs-7 form-group">
                <div class="control-label"><div class="line"></div><p class="upfont"># OF BOXES:</p><div class="line2"></div></div>
            </div>
            <div class="col-xs-7 form-group">
                <div class="control-label"><div class="line"></div><p class="upfont">QTY PER BOX:</p><div class="line2"></div></div>
            </div>
            <div class="col-xs-7 form-group">
                <div class="control-label"><div class="line"></div><p class="upfont">SHRINK WRAP SAMPLES</p><div class="line_none"></div></div>
            </div>
            <div class="col-xs-7 form-group">
                <div class="control-label"><div class="line"></div><p class="upfont">INSPECTIONED BY:</p><div class="line2"></div></div>
            </div>
            <div class="col-xs-7 form-group">
                <div class="control-label"><div class="line"></div><p class="upfont">DELIVERED BY:</p><div class="line2"></div></div>
            </div>
            <br/>
            <br/>
            <br/>
            <br/>
            <br/>
            <br/>
            <br/>
            <div class="col-xs-7 form-group">
                <div class="control-label"><div class="line"></div><p class="upfont">RECEIVED BY:</p><div class="line2"></div></div>
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