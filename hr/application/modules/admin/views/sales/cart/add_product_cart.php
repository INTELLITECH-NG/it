<?php
//echo '<pre>';
//print_r($this->cart->contents());
//echo '</pre>';
//?>
<div class="table">

    <div class="table-responsive">
        <table class="table table-bordered table-hover" id="tireFields">
            <thead>

            <tr style="background-color: #ECEEF1">
                <th style="width: 15px">#</th>
                <th class="col-sm-2"><?= lang('product/service') ?></th>
                <th class="col-md-6"><?= lang('description') ?></th>
                <th class=""><?= lang('qty') ?></th>
                <th class=""><?= lang('rate') ?></th>
                <th class=""><?= lang('amount') ?></th>
                <th class=""> </th>
            </tr>
            </thead>
            <tbody>

            <?php $i=1; if(!empty($this->cart->contents())) { foreach ($this->cart->contents() as $cart) {?>

                <tr>
                    <td>
                        <div class="form-group form-group-bottom">
                            <?php echo $i ?>
                        </div>
                    </td>

                    <td>
                        <div class="form-group form-group-bottom p_div">
                            <select class="form-control select2" style="width: 100%; z-index: 9999" onchange="get_product_id(this)" id="<?php echo $cart['rowid']?>">
                                <option value=""><?= lang('please_select') ?>..</option>
                                <?php if(!empty($products)){ foreach ($products as $key => $product){ ?>
                                    <optgroup label="<?php echo $key?>">
                                        <?php foreach ($product as $item){ ?>
                                            <option value="<?php echo $item->id  ?>" <?php echo $cart['id'] === $item->id ?'selected':''  ?>>
                                                <img src="<?php echo base_url() . IMAGE . 'inventory.png' ?>" width="40" height="40"> <?php echo $item->name ?>
                                            </option>
                                        <?php } ?>
                                    </optgroup>
                                <?php }; } ?>
                            </select>
                        </div>
                    </td>

                    <td>
                        <div class="form-group form-group-bottom">
                            <?php if($cart['type']){ ?>
                                <?php echo $cart['description']?>
                            <?php }else{ ?>
                                <input class="form-control" type="text" name="description" onblur ="updateItem(this);" id="<?php echo 'des'.$cart['rowid'] ?>" value="<?php echo $cart['description']?>">
                            <?php } ?>
                        </div>
                    </td>

                    <td>
                        <div class="form-group form-group-bottom">
                            <input class="form-control" type="text" name="qty" onblur ="updateItem(this);" value="<?php echo $cart['qty'] ?>" id="<?php echo 'qty'.$cart['rowid'] ?>">
                        </div>
                    </td>

                    <td>
                        <div class="form-group form-group-bottom">
                            <input class="form-control" type="text" name="price" value="<?php echo $cart['price'] ?>" onblur ="updateItem(this);" id="<?php echo 'prc'.$cart['rowid'] ?>">
                        </div>
                    </td>

                    <td>
                        <div class="form-group form-group-bottom">
                            <input class="form-control" type="text" readonly value="<?php echo $cart['subtotal'] ?>">
                        </div>
                    </td>

                    <input type="hidden" name="product_code" value="<?php echo $cart['id']  ?>" id="<?php echo 'pid'.$cart['rowid'] ?>">

                    <td>
                        <a href="javascript:void(0)" id="<?php echo $cart['rowid'] ?>" onclick="removeItem(this);"  class="remTire" style="color: red"><i class="glyphicon glyphicon-trash"></i></a>
                    </td>

                </tr>

                <?php $i++; };} ?>

            <tr>
                <td>
                    <div class="form-group form-group-bottom">

                    </div>
                </td>

                <td>
                    <div class="form-group form-group-bottom p_div">
                        <select class="form-control select2" style="width: 100%; z-index: 9999" onchange="get_product_id(this)" id="">
                            <option value=""><?= lang('please_select') ?>..</option>
                            <?php if(!empty($products)){ foreach ($products as $key => $product){ ?>
                                <optgroup label="<?php echo $key?>">
                                    <?php foreach ($product as $item){ ?>
                                        <option value="<?php echo $item->id  ?>" >
                                            <?php echo $item->name ?>
                                        </option>
                                    <?php } ?>
                                </optgroup>
                            <?php }; } ?>
                        </select>
                    </div>
                </td>

                <td>
                    <div class="form-group form-group-bottom">
                        <input class="form-control" type="text">
                    </div>
                </td>

                <td>
                    <div class="form-group form-group-bottom">
                        <input class="form-control" type="text" style="width:120px" >
                    </div>
                </td>

                <td>
                    <div class="form-group form-group-bottom">
                        <input class="form-control" type="text" style="width:120px">
                    </div>
                </td>

                <td>
                    <div class="form-group form-group-bottom">
                        <input class="form-control" type="text" readonly style="width:120px">
                    </div>
                </td>


            </tr>

            </tbody>
        </table>
    </div>

    <table class="table table-hover">
        <thead>

        <tr style="border-bottom: solid 1px #ccc">
            <th style="width: 15px"></th>
            <th class="col-sm-2"></th>
            <th class="col-sm-5"></th>
            <th class=""></th>
            <th class=""></th>
            <th style="width: 230px"></th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td colspan="5" style="text-align: right">
                <?= lang('total') ?>
            </td>

            <td style="text-align: right; padding-right: 30px">
                <?php echo $this->cart->total(); ?>
            </td>

        </tr>


        <?php if ($this->session->userdata('type') != 'quotation') { ?>

            <?php $total_tax = 0.00 ?>
            <?php if (!empty($this->cart->contents())): foreach ($this->cart->contents() as $item) : ?>
                <?php $total_tax += $item['tax'] ?>
            <?php endforeach; endif ?>
            <tr>
                <td colspan="5" style="text-align: right">
                    <?= lang('tax') ?>
                </td>

                <td style="text-align: right; padding-right: 30px">
                    <input class="form-control text-right" value="<?= $total_tax ?>" readonly>
                </td>

            </tr>

            <tr>
                <td colspan="5" style="text-align: right">
                    <?= lang('discount') ?> %
                </td>

                <td style="text-align: right; padding-right: 30px">
                    <input type="" class="form-control" style="text-align: right" onblur="order_discount(this)" value="<?php echo $this->session->userdata('discount');?>" name="discount">
                </td>

            </tr>
        <?php } ?>
        <tr>
            <td colspan="5" style="text-align: right; font-weight: bold">
                <?= lang('grand_total') ?>
            </td>

            <?php
            $gtotal =  $this->cart->total();
            $discount = $this->session->userdata('discount');

            $discount_amount = ($gtotal * $discount)/100;
            ?>

            <td style="text-align: right; padding-right: 30px; font-weight: bold; font-size: 16px">
                <?php echo get_option('default_currency').' '.$this->localization->currencyFormat($gtotal + $total_tax - $discount_amount); ?>
            </td>

        </tr>
<!--        --><?php //if ($this->session->userdata('type') != 'quotation') { ?>
<!--            <tr>-->
<!--                <td colspan="5" style="text-align: right">-->
<!--                    Amount received-->
<!--                </td>-->
<!---->
<!--                <td style="text-align: right; padding-right: 30px">-->
<!--                    <input type="text" class="form-control" style="text-align: right"  name="amount_received" value="">-->
<!--                </td>-->
<!---->
<!--            </tr>-->
<!---->
<!--            <tr>-->
<!--                <td colspan="5" style="text-align: right">-->
<!--                    Payment Method-->
<!--                </td>-->
<!---->
<!--                <td style="text-align: right; padding-right: 30px">-->
<!--                    <select class="form-control" name="payment_method">-->
<!--                        <option value="Cash Payment">Cash Payment</option>-->
<!--                        <option value="Check">Check</option>-->
<!--                        <option value="Credit Card">Credit Card</option>-->
<!--                    </select>-->
<!--                </td>-->
<!---->
<!--            </tr>-->
<!---->
<!--            <tr>-->
<!--                <td colspan="5" style="text-align: right">-->
<!--                    Reference No.-->
<!--                </td>-->
<!---->
<!--                <td style="text-align: right; padding-right: 30px">-->
<!--                    <input type="text" class="form-control" style="text-align: right"  name="p_reference" value="">-->
<!--                </td>-->
<!---->
<!--            </tr>-->
<!--        --><?php //} ?>

        </tbody>
    </table>
</div>