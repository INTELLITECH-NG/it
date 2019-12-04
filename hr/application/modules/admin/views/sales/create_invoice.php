
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
                        <?php if ($type === 'invoice') { ?>
                        <?= lang('create_sales_invoice'); }else{ ?>
                        <?= lang('create_quotation'); } ?>

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
                                                <label><?= lang('customer') ?> <span class="required" aria-required="true">*</span></label>
                                                <select class="form-control select2" style="width: 100%" onchange="get_customer(this)" name="customer_id">
                                                    <option value=""><?= lang('please_select') ?>...</option>
                                                    <?php if(!empty($customers)){ foreach ($customers as $item){ ?>
                                                    <option value="<?php echo $item->id ?>" <?php echo  $c_detail->id == $item->id ? 'selected':'' ?>><?php echo 100+$item->id.'-'. $item->name ?></option>
                                                    <?php };} ?>
                                                </select>
                                            </div>
                                        </div>
                                        <?php }else{ ?>

                                        <div class="col-md-6">
                                            <!-- /.Start Date -->
                                            <div class="form-group form-group-bottom">
                                                <label><?= lang('customer') ?></label>
                                                <input type="text" class="form-control" value="<?php echo $c_detail->name ?>" readonly >
                                            </div>
                                        </div>

                                        <?php } ?>

                                        <div class="col-md-6">
                                            <!-- /.Start Date -->
                                            <div class="form-group form-group-bottom">
                                                <label><?= lang('email') ?></label>
                                                <input type="text" name="email" class="form-control" value="<?php echo $c_detail->email ?>" >
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label><?= lang('billing_address') ?></label>
                                                <textarea class="form-control" name="b_address"><?php echo nl2br($c_detail->b_address) ?></textarea>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label><?= lang('shipping_address') ?></label>
                                                <textarea class="form-control" name="s_address"><?php echo nl2br($c_detail->s_address) ?></textarea>
                                            </div>
                                        </div>

                                        <?php
                                        if (!empty($order)) {
                                            $invoice_date = date("Y/m/d", strtotime($order->invoice_date));
                                            $due_date = date("Y/m/d", strtotime($order->due_date));
                                        } else {
                                            $invoice_date = date("Y/m/d");
                                            $due_date = date("Y/m/d");
                                        }
                                        ?>

                                        <?php if ($type != 'quotation') { ?>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label><?= lang('terms') ?></label>
                                                    <div class="input-group">
                                                        <button type="button" class="btn btn-default pull-left"
                                                                id="daterange-btn">
                                                        <span>
                                                          <i class="fa fa-calendar"></i> <?= lang('payment_term') ?>
                                                        </span>
                                                            <i class="fa fa-caret-down"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label><?= lang('invoice_date') ?> <span class="required"
                                                                              aria-required="true">*</span></label>
                                                    <input name="invoice_date" class="form-control invoice_date"
                                                           type="text" id="datepicker" data-date-format="yyyy/mm/dd"
                                                           value="<?php echo $invoice_date ?>">

                                                </div>
                                            </div>


                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label><?= lang('due_date') ?><span class="required" aria-required="true">*</span></label>
                                                    <input name="due_date" class="form-control due_date"
                                                           id="datepicker-1" type="text" data-date-format="yyyy/mm/dd"
                                                           value="<?php echo $due_date ?>">
                                                </div>
                                            </div>
                                        <?php }else{ ?>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label><?= lang('estimate_date') ?> <span class="required"
                                                                              aria-required="true">*</span></label>
                                                    <input name="invoice_date" class="form-control invoice_date"
                                                           type="text" id="datepicker" data-date-format="yyyy/mm/dd"
                                                           value="<?php echo $invoice_date ?>">

                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label> <?= lang('expiration_date') ?> <span class="required" aria-required="true">*</span></label>
                                                    <input name="due_date" class="form-control due_date"
                                                           id="datepicker-1" type="text" data-date-format="yyyy/mm/dd"
                                                           value="<?php echo $due_date ?>">
                                                </div>
                                            </div>

                                        <?php } ?>
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
                                                    <h3><?= lang('quotation') ?># <?= INVOICE_PRE + $order->id?></h3><br>
                                                    <b><?= lang('estimate_date') ?>:</b> <?php echo $this->localization->dateFormat($order->due_date)?><br>
                                                    <b><?= lang('expiration_date') ?>:</b> <?php echo $this->localization->dateFormat($order->due_date)?><br>
                                                <?php } ?>

                                                <?php if($order->status === 'Cancel'){ ?>
                                                    <p class="lead"><?= lang('status') ?>: <span style="color: red"><?= lang('canceled') ?></span></p>
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
                                        <?php echo $this->view('sales/cart/add_product_cart'); ?>
                                    </div>



                                    <div class="row">
                                        <?php if(!empty($order)){?>
                                            <?php if($order->status == 'Cancel'){?>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label><?= lang('cancellation_note') ?></label><br/>
                                                        <?php echo $order->cancel_note ?>
                                                    </div>
                                                </div>
                                            <?php }else{?>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Order Note</label>
                                                        <textarea class="form-control" name="order_note"><?php if(!empty($order))echo $order->order_note ?></textarea>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                        <?php }else{ ?>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label><?= lang('order_note') ?></label>
                                                    <textarea class="form-control" name="order_note"><?php if(!empty($order))echo $order->order_note ?></textarea>
                                                </div>
                                            </div>
                                        <?php } ?>



                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label><?= lang('order_activities') ?></label>
                                                <textarea class="form-control" name="order_activities"><?php if(!empty($product->sales_info))echo $product->sales_info ?></textarea>
                                            </div>
                                        </div>


                                    </div>



                                </div><!-- /.box-body -->
                            </div><!-- /.box -->

                                <input type="hidden" name="type" value="<?php if(!empty($type)) echo $type?>">
                                <input type="hidden" name="order_id" value="<?php if(!empty($order)) echo str_replace(array('+', '/', '='), array('-', '_', '~'), $this->encrypt->encode($order->id)) ?>">

                                <?php if(empty($order->type)){?>
                                    <button type="submit" class="btn bg-navy btn-flat" id="saveInvoice" ><?= lang('save'); ?> </button>
                                <?php }else{ ?>
                                    <button type="submit" class="btn bg-navy btn-flat" id="updateInvoice" ><?= lang('update') ?></button>
                                    <?php if($order->type == 'Quotation'){ ?>
                                        <button type="submit" class="btn bg-olive btn-flat" id="quotation_btn" > <?= lang('create_invoice') ?></button>
                                    <?php } ?>
                                <?php } ?>



                            <?php
                            if(!empty($order)){
                                $history =  json_decode($order->history, true);
                            }

//                            echo '<pre>';
//                            print_r($history);
//                            echo '</pre>';

                            ?>

                            <div class="row">
                                <div class="col-md-6 col-md-offset-2">


                                    <ul class="timeline">

                                        <?php if(!empty($history)){ foreach ($history as $item){  ?>


                                        <!-- timeline time label -->
                                        <li class="time-label">
                                            <span class="bg-red">
                                                <?php echo $item['sales']['date'] ?>
                                            </span>
                                        </li>
                                        <!-- /.timeline-label -->

                                        <!-- timeline item -->
                                        <li>
                                            <!-- timeline icon -->
                                            <i class="fa fa-envelope bg-blue"></i>
                                            <div class="timeline-item">

                                                <h3 class="timeline-header"><small><?= lang('sales_by') ?>:</small> <?php echo $item['sales']['sales_person'] ?></h3>

                                                <div class="timeline-body">
                                                    - <?php echo $item['list']['status'].'<br/>' ?>
                                                    <?php if(!empty($item['list']['activities'])) echo '- '.$item['list']['activities'].'<br/>' ?>
                                                    <?php if(!empty($item['list']['amount_received'])) echo '- '. lang('received_amount').': '.get_option('currency_symbol'). $this->localization->currencyFormat($item['list']['amount_received']).'<br/>' ?>
                                                    <?php if(!empty($item['list']['payment_method'])) echo '-'. lang('payment_method') . ': '.$item['list']['payment_method'].'<br/>' ?>
                                                    <?php if(!empty($item['list']['p_reference'])) echo '- '. lang('payment_ref').'.: '. $item['list']['p_reference'].'<br/>' ?>

                                                </div>

                                                <div class="timeline-footer">

                                                </div>
                                            </div>
                                        </li>
                                        <?php }; }  ?>
                                </ul>


                                </div>
                            </div>

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