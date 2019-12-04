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
                    <h3 class="box-title">Purchase Order Invoive# <?php echo INVOICE_PRE + $purchase_order->id ?></h3>
                    <!-- /.box-tools -->
                </div>
                <!-- /.box-header -->

                <div class="box-body ">

                    <div class="row">
                        <div class="col-md-12 col-sm-12">

                            <div class="box box-warning">
                                <div class="box-header box-header-background-light with-border">
                                    <h3 class="box-title ">Purchase Product List</h3>
                                </div>


                                <div class="box-body">

                                    <?php echo form_open('admin/purchase/received_product')?>
                                    <table class="table table-bordered table-hover purchase-products" id="myTable">
                                        <thead ><!-- Table head -->
                                        <tr>
                                            <th class="active col-sm-1">Sl</th>
                                            <th class="active">Product Name</th>
                                            <th class="active">Purchase Qty</th>
                                            <th class="active">Received</th>
                                            <th class="active">Received Qty</th>

                                        </tr>
                                        </thead><!-- / Table head -->
                                        <tbody><!-- / Table body -->

                                        <?php $counter =1 ; ?>
                                        <?php if (!empty($purchase_product)): foreach ($purchase_product as $v_product) : ?>
                                            <tr class="custom-tr">
                                                <td class="vertical-td">
                                                    <?php echo  $counter ?>
                                                </td>
                                                <td class="vertical-td">
                                                    <?php echo $v_product->product_name ?><br/>
                                                    <span style=" color: #E13300" id="<?php echo 'msg'.$v_product->id ?>"></span>
                                                </td>
                                                <td class="vertical-td"> <?php echo $v_product->qty ?></td>
                                                <td class="vertical-td"> <?php echo $v_product->total_received ?></td>
                                                <td class="vertical-td">
                                                    <input type="text" class="form-control" name="qty[]" style="width: 100px" <?php echo $v_product->qty == $v_product->total_received ? 'readonly':'' ?>
                                                           onkeyup="receivedPurchase(this);" id="<?php echo 'rec_qty'.$v_product->id ?>">
                                                </td>
                                                <input type="hidden" id="<?php echo 'pur_qty'.$v_product->id ?>" value="<?php echo $v_product->qty ?>">
                                                <input type="hidden" id="<?php echo 'tot_qty'.$v_product->id ?>" value="<?php echo $v_product->total_received ?>">

                                                <input type="hidden" name="id[]" value="<?php echo $v_product->id ?>"

                                            </tr>
                                            <?php
                                            $counter++;
                                        endforeach;
                                            ?><!--get all sub category if not this empty-->
                                            <tr>
                                                <td colspan="4"></td>
                                                <td class="vertical-td">
                                                    <button type="submit" class="btn bg-navy" id="sbtn">Update
                                                    </button>
                                                </td>

                                            </tr>
                                        <?php else : ?> <!--get error message if this empty-->
                                            <td colspan="6">
                                                <strong>There is no record for display</strong>
                                            </td><!--/ get error message if this empty-->
                                        <?php endif; ?>

                                        </tbody><!-- / Table body -->

                                    </table> <!-- / Table -->

                                    <input type="hidden" value="<?php echo $purchase_order->id ?>" name="order_id">
                                <?php echo form_close() ?>


                                </div><!-- /.box-body -->
                            </div>
                            <!-- /.box -->
                        </div><!--/.col end -->



                    </div>


                </div>
            </div>
            <!-- /. box -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
</section>
<!-- /.content -->

<script>
    function receivedPurchase (arg){
        var val = arg.getAttribute('id');
        var id = val.slice(7);
        var qty = parseInt($( "#rec_qty"+id ).val());
        var purchase_qty = parseInt($( "#pur_qty"+id ).val());
        var total_received_qty_value= parseInt($( "#tot_qty"+id ).val());
        var value = qty + total_received_qty_value;

        if(value >purchase_qty){
            $("#sbtn").attr("disabled", "disabled");
            document.getElementById('msg'+id).innerHTML = "Higher than Purchase Qty";
        }else{
            $('#msg'+id).empty();
        }

        var IDs = [];
        $("#myTable").find("span").each(function(){ IDs.push(this.id); });
        for (var i = IDs.length -1; i >= 0; i--) {
            //alert(IDs[i]);
            if ($("#"+IDs[i]).is(':empty')){
                IDs.splice(i, 1);
            }
        }

        var flag = IDs.length;
        //alert(flag);
        if(flag == 0){
            $("#sbtn").removeAttr("disabled");
        }

    }
</script>