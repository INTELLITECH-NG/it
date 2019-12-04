
<div class="row">
    <div class="col-md-12">
        <!-- general form elements -->
        <div class="box box-primary">
            <div class="box-header with-border bg-primary-dark">
                <h3 class="box-title"><?= lang('add_asset') ?></h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
                <?php echo form_open('admin/asset/save_asset')?>

                <div class="box-body">
                    <!-- View massage -->
                    <?php echo message_box('success'); ?>
                    <?php echo message_box('error'); ?>


                    <div class="row">
                        <div class="col-md-6 col-sm-12 col-xs-12">


                            <div class="form-group">
                                <label><?= lang('asset_name') ?><span class="required" aria-required="true">*</span></label>
                                <input type="text" name="name" class="form-control" value="<?php if(!empty($asset)) echo $asset->name ?>">
                            </div>

                            <div class="form-group">
                                <label><?= lang('purchase_year') ?><span class="required" aria-required="true">*</span></label>
                                <input type="text" name="purchase_year" class="form-control" id="datepicker" data-date-format="yyyy/mm/dd" value="<?php if(!empty($asset)) echo $asset->purchase_year ?>">
                            </div>

                            <div class="form-group">
                                <label><?= lang('cost') ?><span class="required" aria-required="true">*</span></label>
                                <input type="text" name="cost" class="form-control" value="<?php if(!empty($asset)) echo $asset->cost ?>">
                            </div>

                            <div class="form-group">
                                <label><?= lang('lifespan') ?><span class="required" aria-required="true">*</span></label>
                                <input type="text" name="lifespan" class="form-control" value="<?php if(!empty($asset)) echo $asset->lifespan ?>">
                            </div>

                            <div class="form-group">
                                <label><?= lang('salvage_value') ?><span class="required" aria-required="true">*</span></label>
                                <input type="text" name="salvage_value" class="form-control" value="<?php if(!empty($asset)) echo $asset->salvage_value ?>">
                            </div>


                            <p class="text-muted"><span class="required" aria-required="true">*</span> <?= lang('required_field') ?></p>


                        </div>

                    </div>
                    <!-- /.box-body -->

                    <input type="hidden" name="id" value="<?php if(!empty($asset)) echo $asset->id ?>">

                    <div class="box-footer">
                        <button id="saveSalary" type="submit" class="btn bg-navy btn-flat"><?= lang('save') ?></button>
                    </div>




                </div>
                <!-- /.box -->
           <?php echo form_close()?>

        </div>
    </div>
</div>

