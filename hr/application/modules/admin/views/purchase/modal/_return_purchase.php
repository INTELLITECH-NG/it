
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only"><?= lang('close') ?></span></button>
    <h4 class="modal-title" id="myModalLabel"><?= lang('return_purchase') ?></h4>
</div>

<div class="modal-body">


    <form id="addSubordinate" action="<?php echo site_url('admin/purchase/return_product')?>" method="post" onsubmit="return get_Cookie('csrf_cookie_name')">

        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" id="token">

        <table class="table table-bordered table-hover purchase-products" id="myTable">
            <thead ><!-- Table head -->
            <tr>
                <th class="active col-sm-1"><?= lang('sl') ?></th>
                <th class="active"><?= lang('product') ?></th>
                <th class="active"><?= lang('purchase_qty') ?></th>
                <th class="active"><?= lang('received') ?></th>
                <th class="active"><?= lang('returned') ?></th>
                <th class="active"><?= lang('return_qty') ?></th>

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
                    <td class="vertical-td"> <?php echo $v_product->return_qty ?></td>

                    <?php
                        $has_qty = $v_product->total_received - $v_product->return_qty;
                    ?>

                    <td class="vertical-td">
                        <input type="text" class="form-control" name="qty[]" style="width: 100px" <?php echo $has_qty == 0 ? 'readonly':'' ?>
                               onkeyup="receivedPurchase(this);" id="<?php echo 'rec_qty'.$v_product->id ?>">
                    </td>
                    <input type="hidden" id="<?php echo 'pur_qty'.$v_product->id ?>" value="<?php echo $v_product->qty ?>">
                    <input type="hidden" id="<?php echo 'tot_qty'.$v_product->id ?>" value="<?php echo $v_product->total_received ?>">
                    <input type="hidden" id="<?php echo 'ret_qty'.$v_product->id ?>" value="<?php echo $v_product->return_qty ?>">

                    <input type="hidden" name="id[]" value="<?php echo $v_product->id ?>"

                </tr>
                <?php
                $counter++;
            endforeach;
                ?><!--get all sub category if not this empty-->

            <?php else : ?> <!--get error message if this empty-->
                <td colspan="6">
                    <strong>There is no record for display</strong>
                </td><!--/ get error message if this empty-->
            <?php endif; ?>

            </tbody><!-- / Table body -->

        </table> <!-- / Table -->

        <input type="hidden" value="<?php echo $purchase_order->id ?>" name="order_id">

        <div class="modal-footer" >

            <button type="button" id="close" class="btn btn-danger btn-flat pull-left" data-dismiss="modal">Close</button>
            <button type="submit" class="btn bg-olive btn-flat" id="sbtn" >Save</button>


        </div>
    </form>

</div>



<script>

    $('#modalSmall').on('hidden.bs.modal', function () {
        location.reload();
    });



    function get_Cookie(name) {
        var cookieValue = null;
        if (document.cookie && document.cookie != '') {
            var cookies = document.cookie.split(';');
            for (var i = 0; i < cookies.length; i++) {
                var cookie = jQuery.trim(cookies[i]);
                // Does this cookie string begin with the name we want?
                if (cookie.substring(0, name.length + 1) == (name + '=')) {
                    cookieValue = decodeURIComponent(cookie.substring(name.length + 1));
                    break;
                }
            }
        }
        $('#token').val(cookieValue);
    }

    $("#btn").click(function ()  {

        $("#addSubordinate").validate({
            excluded: ':disabled',
            rules: {

                department_id: {
                    required: true
                },
                subordinate_id: {
                    required: true
                }
            },

            highlight: function(element) {
                $(element).closest('.form-group').addClass('has-error');
            },
            unhighlight: function(element) {
                $(element).closest('.form-group').removeClass('has-error');
            },
            errorElement: 'span',
            errorClass: 'help-block animated fadeInDown',
            errorPlacement: function(error, element) {
                if (element.parent('.input-group').length) {
                    error.insertAfter(element.parent());
                } else {
                    error.insertAfter(element);
                }
            }
        })
    });

    $('body').on('hidden.bs.modal', '.modal', function () {
        $(this).removeData('bs.modal');
    });


</script>


<script>
    function receivedPurchase (arg){
        var val = arg.getAttribute('id');
        var id = val.slice(7);
        var qty = parseInt($( "#rec_qty"+id ).val());
        var purchase_qty = parseInt($( "#pur_qty"+id ).val());
        var total_received_qty_value= parseInt($( "#tot_qty"+id ).val());
        var return_qty = parseInt($( "#ret_qty"+id ).val());
        var value = total_received_qty_value - return_qty;

        if(qty > value ){
            $("#sbtn").attr("disabled", "disabled");
            document.getElementById('msg'+id).innerHTML = "Return Qty is higher Than Receive Qty";
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
