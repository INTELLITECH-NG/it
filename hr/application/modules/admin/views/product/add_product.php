<style>
    .image-upload > input {
        visibility:hidden;
        width:0;
        height:0;
        /*cursor: pointer;*/
        /*cursor: hand;*/
    }
    img{

    }
</style>


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
                        <?php
                            echo $title;
                        ?>
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
                        <div class="col-md-7 col-sm-12 col-xs-12 col-md-push-2">
                            <div id="msg"></div>
                            <div class="row">
                                <div class="col-md-6">

                                    <div class="row">

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label><?= lang('name') ?><span class="required" aria-required="true">*</span></label>
                                                <input type="text" name="name" value="<?php if(!empty($product->name))echo $product->name ?>" class="form-control">
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <!-- /.Start Date -->
                                            <div class="form-group form-group-bottom">
                                                <label><?= lang('sku') ?> <span class="required" aria-required="true">*</span></label>
                                                <input type="text" name="sku" class="form-control" value="<?php if(!empty($product->sku))echo $product->sku ?>">
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label><?= lang('category') ?> <span class="required" aria-required="true">*</span></label>
                                                <select class="form-control select2" name="category_id" >
                                                    <span><option value=""><?= lang('please_select') ?>..</option>
                                                    <?php foreach($categories as $item){ ?>
                                                        <option value="<?php echo $item->id ?>"
                                                            <?php if(!empty($product->category_id)) echo $item->id === $product->category_id? 'selected':''?>
                                                        >
                                                            <?php echo $item->category ?></option>
                                                    <?php } ?>
                                                </select> <a href="#" data-toggle="modal" data-target="#myModal">+ <?= lang('add_category') ?></a></span>
                                            </div>
                                        </div>



                                    </div>

                                </div>

                                <div class="col-md-6">

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label><?= lang('product_image') ?> <span class="required" aria-required="true">*</span></label>
                                                <div class="row">
                                                    <div class="col-xs-6 col-md-3">
                                                        <div class="image-upload" >

                                                            <?php if(empty($product->p_image)){ ?>
                                                            <label for="file-input">
                                                                <div class="thumbnail" style="cursor:pointer" >
                                                                    <img id="blah" src="<?php echo base_url() . IMAGE . 'image.png' ?>" width="120" height="120" alt="..." style="pointer-events: none"/>
                                                                </div>
                                                            </label>
                                                            <?php }else{?>
                                                                <label for="file-input">
                                                                    <div class="thumbnail" style="cursor:pointer" >
                                                                        <img id="blah" src="<?php echo base_url() . UPLOAD_PRODUCT . $product->p_image ?>" width="120" height="120" alt="..." style="pointer-events: none"/>
                                                                    </div>

                                                                    <div class="text-right">
                                                                        <a class="btn btn-xs btn-danger" href="javascript::" id="<?php echo $product->id ?>" onclick="deletePimage(this)"><i class="glyphicon glyphicon-trash"></i></a>
                                                                    </div>
                                                                </label>
                                                            <?php } ?>
                                                            <?php if(empty($product->p_image)){ ?>
                                                            <input id="file-input" type="file" name="p_image"/>
                                                            <?php }?>


                                                        </div>
                                                    </div>


                                                </div>

                                            </div>
                                        </div>

                                    </div>

                                </div>

                            </div>

                            <?php if($type != 'bundle'){ ?>

                            <div class="row">

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><?= lang('sales_price/rate') ?></label>
                                        <input type="text" name="sales_cost" class="form-control" value="<?php if(!empty($product->sales_cost))echo $product->sales_cost ?>">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><?= lang('sales_information') ?></label>
                                        <textarea class="form-control" name="sales_info"><?php if(!empty($product->sales_info))echo $product->sales_info ?></textarea>
                                    </div>
                                </div>

                            </div>

                            <div class="row">

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><?= lang('cost') ?></label>
                                        <input type="text" name="buying_cost" class="form-control" value="<?php if(!empty($product->buying_cost))echo $product->buying_cost ?>">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><?= lang('purchasing_information') ?></label>
                                        <textarea class="form-control" name="buying_info"><?php if(!empty($product->buying_info))echo $product->buying_info ?></textarea>
                                    </div>
                                </div>

                            </div>

                            <div class="form-group">
                                <label><?= lang('tax') ?> <span class="required" aria-required="true">*</span></label>
                                <select class="form-control select2" name="tax_id">
                                    <option value=""><?= lang('please_select') ?>...</option>
                                    <?php if(!empty($tax)){ foreach ($tax as $item){ ?>
                                        <option value="<?= $item->id ?>" <?php if(!empty($product)) echo $product->tax_id == $item->id ?'selected':'' ?>><?= $item->name ?></option>
                                    <?php }; } ?>
                                </select>
                            </div>

                            <?php } ?>

                            <?php if($type === 'inventory'){ ?>
                            <div class="form-group">
                                <label><?= lang('quantity_on_hand') ?> <span class="required" aria-required="true">*</span></label>
                                <input type="text" name="inventory" class="form-control" value="<?php if(!empty($product->inventory))echo $product->inventory ?>">
                            </div>


                            <?php }?>

                            <!--                        Non-Inventory and Service area-->

                            <input type="hidden" name="id" value="<?php if(!empty($product)) echo $product->id ?>">

                            <?php if($type === 'bundle'){ ?>

                                <div class="form-group">
                                    <label><?= lang('tax') ?> <span class="required" aria-required="true">*</span></label>
                                    <select class="form-control select2" name="tax_id">
                                        <option value=""><?= lang('please_select') ?>...</option>
                                        <?php if(!empty($tax)){ foreach ($tax as $item){ ?>
                                            <option value="<?= $item->id ?>" <?php if(!empty($product)) echo $product->tax_id == $item->id ?'selected':'' ?>><?= $item->name ?></option>
                                        <?php }; } ?>
                                    </select>
                                </div>

                            <?php
                                if(!empty($product->bundle)){
                                    $bundle = json_decode($product->bundle);
                                }
                            ?>

                            <div class="form-group">
                                <label><?= lang('products/services_included_in_the_bundle') ?></label>
                                <table class="table table-bordered table-hover table-sortable" id="tab_logic">
                                    <thead>
                                    <tr >
                                        <th class="text-center">
                                            <?= lang('product/services') ?>
                                        </th>
                                        <th class="text-center">
                                            <?= lang('qty') ?>
                                        </th>
                                        <th class="text-center" style="border-top: 1px solid #ffffff; border-right: 1px solid #ffffff;">
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr id='addr0'  class="hidden">
                                        <td data-name="sel">
                                            <select name="product[]" class="form-control" required>
<!--                                                <option value"">Select Product</option>-->

                                                <?php if(!empty($products)){ foreach ($products as $item){ ?>
                                                    <option value="<?php echo $item->id ?>" ><?php echo $item->name ?></option>
                                                <?php };} ?>
                                            </select>
                                        </td>
                                        <td data-name="mail">
                                            <input type="text" name='qty[]' class="form-control"/>
                                        </td>


                                        <td data-name="del">
                                            <button name="del0" class='btn btn-danger glyphicon glyphicon-remove row-remove'></button>
                                        </td>
                                    </tr>

                                    <?php if(!empty($bundle)){ foreach ($bundle as $product){ ?>

                                    <tr id='addr1'>
                                        <td data-name="sel">
                                            <select name="product[]" class="form-control" required>
                                                <!--                                                <option value"">Select Product</option>-->

                                                <?php if(!empty($products)){ foreach ($products as $item){ ?>
                                                    <option value="<?php echo $item->id ?>"
                                                        <?php echo $item->id === $product->product_id ? 'selected':'' ?>>
                                                        <?php echo $item->name ?>
                                                    </option>
                                                <?php };} ?>
                                            </select>
                                        </td>
                                        <td data-name="mail">
                                            <input type="text" name='qty[]' class="form-control" value="<?php echo $product->qty ?>"/>
                                        </td>


                                        <td data-name="del">
                                            <button name="del0" class='btn btn-danger glyphicon glyphicon-remove row-remove'></button>
                                        </td>
                                    </tr>
                                    <?php };} ?>




                                    </tbody>
                                </table>
                                <a id="add_row" class="btn btn-default pull-right"><?= lang('add_row') ?></a>
                            </div>
                            <?php } ?>



                            <input type="hidden" name="type" value="<?php echo $type?>">

                            <a href="javascript::" class="btn bg-navy btn-flat" onclick="save_product()" ><?= lang('save') ?></a>
<!--                            <button type="submit" value="Submit"></button>-->

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



    <!-- Modal -->
    <div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"><?= lang('add_category') ?></h4>
                </div>
                <div class="modal-body">
                    <div id="msgModal"></div>
                    <form class="form-horizontal" action="<?php echo site_url("admin/product/save_category") ?>" id="form-category">
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label"><?= lang('category') ?></label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control"  name="category" id="p_category" >
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <a href="javascript::" class="btn btn-default" onclick="save_category()"><?= lang('save') ?></a>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><?= lang('close') ?></button>
                </div>
            </div>

        </div>
    </div>



<script>
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                jQuery('#blah').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }
    $("#file-input").change(function(){
        readURL(this);
    });

    $('#myModal').on('hidden.bs.modal', function () {
        location.reload();
    });
</script>


<?php if($type === 'bundle'){ ?>
<script>
    $(document).ready(function($) {
       // $('table#tab_logic tr#addr0 ').attr('name','some');

//        $.noConflict();

        $('#tab_logic').on('click', 'button', function () {
            $(this).closest('tr').remove();
        });

        $("#add_row").on("click", function() {
            // Dynamic Rows Code

            // Get max row id and set new id
            var newid = 0;
            $.each($("#tab_logic tr"), function() {
                if (parseInt($(this).data("id")) > newid) {
                    newid = parseInt($(this).data("id"));
                }
            });
            newid++;

            var tr = $("<tr></tr>", {
                id: "addr"+newid,
                "data-id": newid
            });

            // loop through each td and create new elements with name of newid
            $.each($("#tab_logic tbody tr:nth(0) td"), function() {
                var cur_td = $(this);

                var children = cur_td.children();

                // add new td and element if it has a nane
                if ($(this).data("name") != undefined) {
                    var td = $("<td></td>", {
                        //"data-name": $(cur_td).data("name")
                    });

                    var c = $(cur_td).find($(children[0]).prop('tagName')).clone().val("");
                    //c.attr("name", $(cur_td).data("name") + newid);
                    c.appendTo($(td));
                    td.appendTo($(tr));
                } else {
                    var td = $("<td></td>", {
                        'text': $('#tab_logic tr').length
                    }).appendTo($(tr));
                }
            });

            // add delete button and td
            /*
             $("<td></td>").append(
             $("<button class='btn btn-danger glyphicon glyphicon-remove row-remove'></button>")
             .click(function() {
             $(this).closest("tr").remove();
             })
             ).appendTo($(tr));
             */

            // add the new row
            $(tr).appendTo($('#tab_logic'));

            $(tr).find("td button.row-remove").on("click", function() {
                $(this).closest("tr").remove();
            });
        });

        // Sortable Code
        var fixHelperModified = function(e, tr) {
            var $originals = tr.children();
            var $helper = tr.clone();

            $helper.children().each(function(index) {
                $(this).width($originals.eq(index).width())
            });

            return $helper;
        };

        $(".table-sortable tbody").sortable({
            helper: fixHelperModified
        }).disableSelection();

        $(".table-sortable thead").disableSelection();

        $("#add_row").trigger("click");
    });
</script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/jquery-ui.min.js"></script>
<?php }?>