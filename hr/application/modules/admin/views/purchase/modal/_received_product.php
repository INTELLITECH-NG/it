
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only"><?= lang('close') ?></span></button>
    <h4 class="modal-title" id="myModalLabel"><?= lang('purchase_invoice') ?># <?php echo INVOICE_PRE + $purchase_order->id ?></h4>
</div>

<div class="modal-body">


    <?php echo form_open('admin/purchase/received_product')?>
    <table class="table table-bordered table-hover purchase-products" id="myTable">
        <thead ><!-- Table head -->
        <tr>
            <th class="active col-sm-1"><?= lang('sl') ?></th>
            <th class="active"><?= lang('product') ?></th>
            <th class="active"><?= lang('purchase_qty') ?></th>
            <th class="active"><?= lang('received') ?></th>
            <th class="active"><?= lang('received') ?> <?= lang('qty') ?></th>

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
                    <button type="submit" class="btn bg-navy" id="sbtn"><?= lang('update') ?>
                    </button>
                </td>

            </tr>
        <?php else : ?> <!--get error message if this empty-->
            <td colspan="6">
                <strong><?= lang('there_is_no_record_for_display') ?></strong>
            </td><!--/ get error message if this empty-->
        <?php endif; ?>

        </tbody><!-- / Table body -->

    </table> <!-- / Table -->

    <input type="hidden" value="<?php echo $purchase_order->id ?>" name="order_id">
    <?php echo form_close() ?>

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
        var value = qty + total_received_qty_value;

        if(value >purchase_qty){
            $("#sbtn").attr("disabled", "disabled");
            document.getElementById('msg'+id).innerHTML = "<?= lang('higher_than_purchase_qty'); ?>";
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
