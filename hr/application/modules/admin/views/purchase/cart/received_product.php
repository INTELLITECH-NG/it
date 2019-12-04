
<?php echo form_open('admin/purchase/save_received_product')?>
<?php $msg = $this->session->flashdata('message'); ?>
<?php if(!empty($msg)){ ?>
    <div class="alert alert-danger alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <?php echo $msg ?>
    </div>
<?php } ?>

<table class="table table-bordered table-hover" id="myTable" width="100%">
    <thead ><!-- Table head -->
    <tr>
        <th class="active">Sl</th>
        <th class="active">Product</th>
        <th class="active">Received Qty</th>


    </tr>
    </thead><!-- / Table head -->
    <tbody><!-- / Table body -->
    <?php $cart = $this->cart->contents() ;
    //    echo '<pre>';
    //    print_r($cart);

    ?>
    <?php $counter =1 ; ?>
    <?php if (!empty($cart)): foreach ($cart as $item) : ?>

        <tr class="custom-tr">
            <td class="vertical-td">
                <?php echo  $counter ?>
            </td>
            <td class="vertical-td"><?php echo $item['name'] ?></td>

            <td class="vertical-td">
                <input  type="text" name="<?php echo $item['id']?>"  onkeyup="receivedPurchase(this);" id="<?php echo 'rec_qty'.$item['id'] ?>" class="form-control" <?php echo $item['received'] == $item['qty'] ? 'disabled' : '' ?>>
                <input  type="hidden" name="qty" value="<?php echo $item['qty'] ?>" id="<?php echo 'pur_qty'.$item['id'] ?>"   class="form-control">
                <span style=" color: #E13300" id="<?php echo 'msg'.$item['id'] ?>"></span>
            </td>

            <input  type="hidden" name="received" value="<?php echo $item['received'] ?>" id="<?php echo 'tot_qty'.$item['id'] ?>"  class="form-control">

        </tr>


        <?php
        $counter++;
    endforeach;
        ?><!--get all sub category if not this empty-->

        <tr>
            <td colspan="2" class="text-right active">

            </td>
            <td colspan="2" class="text-left active">
                <button type="submit" id="sbtn" class="btn bg-navy btn-block btn-flat " type="submit">Save
                </button>
            </td>
        </tr>

    <?php else : ?> <!--get error message if this empty-->
        <td colspan="6">
            <strong>No Records Found</strong>
        </td><!--/ get error message if this empty-->
    <?php endif; ?>
    </tbody><!-- / Table body -->
</table> <!-- / Table -->
<?php echo form_close() ?>
<script>
    function receivedPurchase (arg){
        var val = arg.getAttribute('id');
        var id = val.slice(7);

        var qty = parseInt($( "#rec_qty"+id ).val());
        var purchase_qty = parseInt($( "#pur_qty"+id ).val());
        var total_received_qty_value= parseInt($( "#tot_qty"+id ).val());
        var value = qty + total_received_qty_value;
        //$("#check_qty").val(value);
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

