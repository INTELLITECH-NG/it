
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
                        Category List
                    </h3>
                    <!-- /.box-tools -->
                </div>

<!--                <form class="form-horizontal" action="--><?php //echo site_url("admin/product/save_product_category") ?><!--" id="form-category">-->
                <?php echo form_open('admin/product/save_product_category', $aatr = array('class'=>'form-horizontal') )?>
                        <div class="form-group margin">
                            <label class="col-sm-3 control-label"><?= lang('category') ?><span class="required">*</span></label>

                            <div class="col-sm-5">
                                <input type="text" class="form-control"  name="category" id="p_category" value="<?php if(!empty($category)) echo $category->category ?>" required>
                            </div>
                        </div>


                        <input type="hidden" name="product_id" value="<?php if(!empty($category)) echo $category->id ?>" >



                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-5">
                                <button type="submit" id="sbtn" name="sbtn" value="1" class="btn bg-olive btn-flat btn-md"><?= lang('save') ?></button>
                            </div>
                        </div>
                </form>

                <br/>
                <br/>
                <br/>

                <div class="container">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th><?= lang('sl') ?></th>
                            <th><?= lang('category') ?></th>
                            <th><?= lang('actions') ?></th>
                        </tr>
                        </thead>
                        <tbody>

                        <?php $i = 1; ?>
                        <?php if(!empty($categories)){ foreach ($categories as $item){ ?>
                        <tr>
                            <td><?= $i ?></td>
                            <td><?= $item->category ?></td>
                            <td>
                                <div class="btn-group"><a class="btn btn-xs btn-default" href="<?php echo base_url().'admin/product/categoryList/'. $item->id ?>" ><i class="fa fa-pencil"></i></a>
                                    <a class="btn btn-xs btn-danger" onClick="return confirm('Are you sure you want to delete?')" href="<?php echo base_url().'admin/product/deleteCategory/'. $item->id ?>" ><i class="glyphicon glyphicon-trash"></i></a></div>
                            </td>
                        </tr>
                        <?php $i++; }; }?>

                        </tbody>
                    </table>
                </div>


            </div>
            <!-- /.box -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
</section>
<!-- /.content -->

