
<!-- Main content -->
<section class="content">
    <div class="row">
        <!-- /.col -->
        <div class="col-md-12">

            <!-- View massage -->
            <?php echo message_box('success'); ?>
            <?php echo message_box('error'); ?>

            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        <?= lang('create_purchase') ?>
                    </h3>
                    <!-- /.box-tools -->
                </div>
                <!-- /.box-header -->

                <?php echo $form->open(); ?>

<!--                --><?php //echo form_open_multipart('admin/product/save_product')?>

                <div class="box-body">

                    <!-- View massage -->
                    <?php echo $form->messages(); ?>
                    <!-- View massage -->
                    <?php echo message_box('success'); ?>
                    <?php echo message_box('error'); ?>

                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12 ">
                            <div id="msg"></div>
                            <div class="row">
                                <div class="col-md-6">

                                    <div class="row">
                                        <?php if(empty($order)){?>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label><?= lang('vendor') ?> <span class="required" aria-required="true">*</span></label>
                                                <select class="form-control select2" style="width: 100%" onchange="get_vendor(this)" name="vendor_id">
                                                    <option value=""><?= lang('please_select') ?>...</option>
                                                    <?php if(!empty($vendors)){ foreach ($vendors as $item){ ?>
                                                    <option value="<?php echo $item->id ?>" <?php echo  $v_detail->id == $item->id ? 'selected':'' ?>><?php echo 100+$item->id.'-'. $item->company_name ?></option>
                                                    <?php };} ?>
                                                </select>
                                            </div>
                                        </div>
                                        <?php }else{ ?>

                                        <div class="col-md-6">
                                            <!-- /.Start Date -->
                                            <div class="form-group form-group-bottom">
                                                <label><?= lang('customer') ?></label>
                                                <input type="text" class="form-control" value="<?php echo $v_detail->name ?>" readonly >
                                            </div>
                                        </div>

                                        <?php } ?>

                                        <div class="col-md-6">
                                            <!-- /.Start Date -->
                                            <div class="form-group form-group-bottom">
                                                <label><?= lang('email') ?></label>
                                                <input type="text" name="email" class="form-control" value="<?php echo $v_detail->email ?>" >
                                            </div>
                                        </div>
                                        <?php $address = nl2br($v_detail->b_address) ?>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label><?= lang('billing_address') ?></label>
                                                <textarea class="form-control" name="b_address"><?php echo $v_detail->b_address ?></textarea>
                                            </div>
                                        </div>


                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label><?= lang('billing_ref') ?>.</label>
                                                <input class="form-control" type="text" name="bill_ref">
                                            </div>
                                        </div>






                                    </div>
                                </div>
                                <?php if(!empty($order)){ ?>
                                <div class="col-md-6">
                                    <div class="row" style="padding-left: 70px">

                                        <div class="col-md-12">
                                            <div class="form-group">

                                                <?php if($type != 'quotation'){ ?>
                                                    <h3><?= get_option('invoice_prefix')?><?= INVOICE_PRE + $order->id?></h3>
                                                    <br>
                                                    <b><?= lang('order_date') ?>:</b> <?php echo $this->localization->dateFormat($order->due_date)?><br>
                                                    <b><?= lang('payment_due') ?>:</b> <?php echo $this->localization->dateFormat($order->due_date)?><br><br>
                                                    <?php if($order->status != 'Cancel'){ ?>
                                                        <p class="lead"><?= lang('received_amount') ?>: <?= get_option('currency_symbol').' '.$this->localization->currencyFormat($order->amount_received) ?></p>
                                                    <?php } ?>
                                                <?php }else{ ?>
                                                    <h3>Quotation# <?= INVOICE_PRE + $order->id?></h3><br>
                                                    <b>Estimate date:</b> <?php echo $this->localization->dateFormat($order->due_date)?><br>
                                                    <b>Expiration date:</b> <?php echo $this->localization->dateFormat($order->due_date)?><br>
                                                <?php } ?>

                                                <?php if($order->status === 'Cancel'){ ?>
                                                    <p class="lead">Status: <span style="color: red"><?= lang('canceled') ?></span></p>
                                                <?php } ?>

                                            </div>
                                        </div>


                                    </div>
                                </div>
                                <?php } ?>
                            </div>


<!--                            --><?php
//
//                            echo '<pre>';
//                            print_r($this->cart->contents());
//                            echo '</pre>';
//
//                            ?>



                            <div class="box">
                                <div class="box-body">

                                    <div id="cart_view">
                                        <?php echo $this->view('purchase/cart/add_product_cart'); ?>
                                    </div>



                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label><?= lang('note') ?></label>
                                                <textarea class="form-control" name="order_note"><?php if(!empty($order))echo $order->order_note ?></textarea>
                                            </div>
                                        </div>



                                    </div>

                                    <input type="hidden" name="order_id" value="<?php if(!empty($order)) echo str_replace(array('+', '/', '='), array('-', '_', '~'), $this->encrypt->encode($order->id)) ?>">

                                    <button type="submit" class="btn bg-navy btn-flat" id="saveInvoice" ><?= lang('save'); ?> </button>

                                </div><!-- /.box-body -->
                            </div><!-- /.box -->






                        </div>
                    </div>


                </div>
                <!-- /.box-body -->

                <div class="box-footer">

                </div>
                <?php echo $form->close(); ?>

            </div>
            <!-- /.box -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
</section>
<!-- /.content -->



<script lang="javascript">


    $(document).ready(function() {
        //***************** Tier Price Option Start *****************//
        $(".addTire").click(function() {
            $("#tireFields").append(
                '<tr>\
                    <td>\
                <div class="form-group form-group-bottom">\
                1\
                </div>\
                </td>\
                    <td>\
                <div class="form-group form-group-bottom p_div">\
                <select class="form-control select2" style="width: 100%">\
                <option value="">Select..</option>\
                <?php if(!empty($products)){ foreach ($products as $key => $product){ ?>\
                <optgroup label="<?php echo $key?>">\
                <?php foreach ($product as $item){ ?>\
                <option value="<?php echo $item->id  ?>"><?php echo $item->name ?></option>\
                <?php } ?>\
                </optgroup>\
                <?php }; } ?>\
                </select>\
                </div>\
                </td>\
                <td>\
                <div class="form-group form-group-bottom">\
                <input class="form-control" type="text">\
                </div>\
                </td>\
                <td>\
                <div class="form-group form-group-bottom">\
                <input class="form-control" type="text">\
                </div>\
                </td>\
                <td>\
                <div class="form-group form-group-bottom">\
                <input class="form-control" type="text">\
            </div>\
            </td>\
            <td>\
            <div class="form-group form-group-bottom">\
                <input class="form-control" type="text" readonly>\
            </div>\
            </td>\
            <td><a href="javascript:void(0);" class="remTire" style="color: red"><i class="glyphicon glyphicon-trash"></i></a></td>\
            </tr>'
            );

            set();

        });
        //***************** Tire Price Option End *****************//

        //Remove Tire Fields
        $("#tireFields").on('click', '.remTire', function() {
            $(this).parent().parent().remove();
        });

        function set() {
            //$("#product").select2();
            $('select').select2();
        }

    });


</script>

<style>
    .date-element {
        display: block;
        top: 439.267px;
        right: 962px;
        left: auto;
    }
</style>

<script>
    $("#quotation_btn").on("click", function(e){
        e.preventDefault();
        $('#from-invoice').attr('action', "sales/save_sales").submit();
    });
    <?php if(!empty($order)){ if(($order->status === 'Close')||$order->status === 'Cancel'){ ?>
    $('#from-invoice input, #from-invoice textarea, #from-invoice select').attr('disabled', 'disabled');
    $('#updateInvoice').hide();
    $('#quotation_btn').hide();
    <?php };} ?>


</script>