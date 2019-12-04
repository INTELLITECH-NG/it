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
                    <h3 class="box-title"><?= lang('inbox') ?></h3>
                    <!-- /.box-tools -->
                </div>
                <!-- /.box-header -->

                <?php echo $form->open(); ?>

                <div class="box-body">

                    <!-- View massage -->
                    <?php echo $form->messages(); ?>
                    <!-- View massage -->
                    <?php echo message_box('success'); ?>
                    <?php echo message_box('error'); ?>


                    <div class="row">
                        <div class="col-md-7 col-sm-12 col-xs-12 col-md-push-2">

                            <div class="row">
                                <div class="col-md-6">

                                    <div class="row">

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label><?= lang('name') ?><span class="required" aria-required="true">*</span></label>
                                                <input type="text" name="first_name" class="form-control">
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <!-- /.Start Date -->
                                            <div class="form-group form-group-bottom">
                                                <label><?= lang('sku') ?> <span class="required" aria-required="true">*</span></label>
                                                <input type="text" name="first_name" class="form-control">
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label><?= lang('category') ?> <span class="required" aria-required="true">*</span></label>
                                                <select class="form-control select2" name="country" >
                                                    <option value=""><?= lang('please_select') ?>..</option>
                                                    <?php foreach($countries as $item){ ?>
                                                        <option value="<?php echo $item->country ?>"><?php echo $item->country ?></option>
                                                    <?php } ?>

                                                </select>
                                            </div>
                                        </div>



                                    </div>

                                </div>

                                <div class="col-md-6">

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label><?= lang('name') ?> <span class="required" aria-required="true">*</span></label>
                                                <div class="row">
                                                    <div class="col-xs-6 col-md-3">
                                                        <div class="image-upload" >
                                                            <label for="file-input">
                                                                <div class="thumbnail" style="cursor:pointer" >
                                                                    <img id="blah" src="<?php echo base_url() . IMAGE . 'image.png' ?>" width="120" height="120" alt="..." style="pointer-events: none"/>

                                                                </div>
                                                                <div class="text-right">
                                                                    <a class="btn btn-xs btn-danger" href="#" onclick="deleteItem('7')"><i class="glyphicon glyphicon-trash"></i></a>
                                                                </div>
                                                            </label>

                                                            <input id="file-input" type="file" />


                                                        </div>
                                                    </div>


                                                </div>

                                            </div>
                                        </div>

                                    </div>

                                </div>

                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Sales information</label>
                                        <textarea class="form-control"></textarea>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Sales price/rate</label>
                                        <input type="text" name="first_name" class="form-control">
                                    </div>
                                </div>

                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Purchasing information</label>
                                        <textarea class="form-control"></textarea>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Cost</label>
                                        <input type="text" name="first_name" class="form-control">
                                    </div>
                                </div>

                            </div>

                            <div class="form-group">
                                <label><?= lang('quantity_on_hand') ?> <span class="required" aria-required="true">*</span></label>
                                <input type="text" name="id_number" class="form-control">
                            </div>


                            <!--                        Non-Inventory and Service area-->





                            <div class="form-group">
                                <label>Products/services included in the bundle</label>
                                <table class="table table-bordered table-hover table-sortable" id="tab_logic">
                                    <thead>
                                    <tr >
                                        <th class="text-center">
                                            Product/Services
                                        </th>
                                        <th class="text-center">
                                            Qty
                                        </th>
                                        <th class="text-center" style="border-top: 1px solid #ffffff; border-right: 1px solid #ffffff;">
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr id='addr0' data-id="0" class="hidden">
                                        <td data-name="sel">
                                            <select name="sel0" class="form-control">
                                                <option value"">Select Option</option>
                                                <option value"1">Option 1</option>
                                                <option value"2">Option 2</option>
                                                <option value"3">Option 3</option>
                                            </select>
                                        </td>
                                        <td data-name="mail">
                                            <input type="text" name='mail0' class="form-control"/>
                                        </td>


                                        <td data-name="del">
                                            <button nam"del0" class='btn btn-danger glyphicon glyphicon-remove row-remove'></button>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                                <a id="add_row" class="btn btn-default pull-right">Add Row</a>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- /.box-body -->

                <div class="box-footer">
                    <?php echo $form->bs4_submit(lang('save_employee')); ?>
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




<script type="text/javascript">
    $(document).ready(function(){
        jQuery('input[type="checkbox"]').click(function(){
            var inputValue = jQuery(this).attr("value");
            jQuery("." + inputValue).toggle();
        });
    });
</script>

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
</script>

<script>



    $(document).ready(function($) {

        $.noConflict();

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