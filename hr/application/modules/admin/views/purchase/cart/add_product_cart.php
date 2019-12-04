<?php
//echo '<pre>';
//print_r($order);
//echo '</pre>';
//?>
<div class="table">
    <table class="table table-bordered table-hover" id="tireFields">
        <thead>

        <tr style="background-color: #ECEEF1">
            <th style="width: 15px">#</th>
            <th class="col-sm-2"><?php  echo strtoupper(lang('product/service')) ?></th>
            <th class="col-sm-5"><?php  echo strtoupper(lang('description')) ?></th>
            <th class=""><?php  echo strtoupper(lang('qty')) ?></th>
            <th class=""><?php  echo strtoupper(lang('rate')) ?></th>
            <th class=""><?php  echo strtoupper(lang('amount')) ?></th>
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
                        <select class="form-control select2" style="width: 100%" onchange="pur_product_id(this)" id="<?php echo $cart['rowid']?>">
                            <option value=""><?= lang('please_select') ?>..</option>
                            <?php if(!empty($products)){ foreach ($products as $key => $product){ ?>
                                <optgroup label="<?php echo $key?>">
                                    <?php foreach ($product as $item){ ?>
                                        <option value="<?php echo $item->id  ?>" <?php echo $cart['id'] === $item->id ?'selected':''  ?>><?php echo $item->name ?></option>
                                    <?php } ?>
                                </optgroup>
                            <?php }; } ?>
                        </select>
                    </div>
                </td>

                <td>
                    <div class="form-group form-group-bottom">
                        <input class="form-control" type="text" name="description" onblur ="pur_updateItem(this);" id="<?php echo 'des'.$cart['rowid'] ?>" value="<?php echo $cart['description']?>">
                    </div>
                </td>

                <td>
                    <div class="form-group form-group-bottom">
                        <input class="form-control" type="text" name="qty" onblur ="pur_updateItem(this);" value="<?php echo $cart['qty'] ?>" id="<?php echo 'qty'.$cart['rowid'] ?>">
                    </div>
                </td>

                <td>
                    <div class="form-group form-group-bottom">
                        <input class="form-control" type="text" name="price" value="<?php echo $cart['price'] ?>" onblur ="pur_updateItem(this);" id="<?php echo 'prc'.$cart['rowid'] ?>">
                    </div>
                </td>

                <td>
                    <div class="form-group form-group-bottom">
                        <input class="form-control" type="text" readonly value="<?php echo $cart['subtotal'] ?>">
                    </div>
                </td>

                <td>
                    <a href="javascript:void(0)" id="<?php echo $cart['rowid'] ?>" onclick="pur_removeItem(this);"  class="remTire" style="color: red"><i class="glyphicon glyphicon-trash"></i></a>
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
                    <select class="form-control select2" style="width: 100%" onchange="pur_product_id(this)" id="">
                        <option value=""><?= lang('please_select') ?>..</option>
                        <?php if(!empty($products)){ foreach ($products as $key => $product){ ?>
                            <optgroup label="<?php echo $key?>">
                                <?php foreach ($product as $item){ ?>
                                    <option value="<?php echo $item->id  ?>"><?php echo $item->name ?></option>
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
                    <input class="form-control" type="text">
                </div>
            </td>

            <td>
                <div class="form-group form-group-bottom">
                    <input class="form-control" type="text">
                </div>
            </td>

            <td>
                <div class="form-group form-group-bottom">
                    <input class="form-control" type="text" readonly>
                </div>
            </td>


        </tr>

        </tbody>
    </table>
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

        <tr>
            <td colspan="5" style="text-align: right">
                <?= lang('discount') ?>
            </td>

            <td style="text-align: right; padding-right: 30px">
                <input type="" class="form-control" style="text-align: right" onblur="pur_order_discount(this)" value="<?php echo $this->session->userdata('discount');?>" name="discount">
            </td>

        </tr>

        <tr>
            <td colspan="5" style="text-align: right">
                <?= lang('tax_amount') ?>
            </td>

            <td style="text-align: right; padding-right: 30px">
                <input type="" class="form-control" style="text-align: right" onblur="pur_tax(this)" value="<?php echo $this->session->userdata('tax');?>" name="tax">
            </td>

        </tr>

        <tr>
            <td colspan="5" style="text-align: right">
                <?= lang('transport_cost') ?>
            </td>

            <td style="text-align: right; padding-right: 30px">
                <input type="" class="form-control" style="text-align: right" onblur="pur_shipping(this)" value="<?php echo $this->session->userdata('shipping');?>" name="shipping">
            </td>

        </tr>

        <tr>
            <td colspan="5" style="text-align: right; font-weight: bold">
                <?= lang('grand_total') ?>
            </td>

            <?php
            $gtotal =  $this->cart->total();
            $discount = $this->session->userdata('discount');
            $tax = $this->session->userdata('tax');
            $shipping = $this->session->userdata('shipping');
            ?>

            <td style="text-align: right; padding-right: 30px; font-weight: bold; font-size: 16px">
                <?php echo get_option('default_currency').' '.$this->localization->currencyFormat($gtotal + $tax + $shipping - $discount); ?>
            </td>

        </tr>




        </tbody>
    </table>
</div>