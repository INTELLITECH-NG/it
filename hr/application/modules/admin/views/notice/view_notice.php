
<?php echo message_box('success'); ?>
<?php echo message_box('error'); ?>


<div class="row">
    <div class="col-sm-12">

        <div class="row">
            <div class="col-sm-12" data-offset="0">
                <div class="wrap-fpanel">
                    <div class="box box-primary" data-collapsed="0">
                        <div class="box-header with-border bg-primary-dark">
                            <h3 class="box-title"><?= lang('view_notice') ?></h3>

                        </div>
                        <div class="panel-body">
                            <?php echo form_open('', array('class' => 'form-horizontal')) ?>

                                <div class="panel_controls">
                                    <div class="form-group margin">
                                        <label class="col-sm-3 control-label"><?= lang('created_date') ?> :</label>
                                        <div class="col-sm-5" style="padding-top: 5px">
                                            <?php echo date(get_option('date_format'), strtotime($notice->date)) ?>
                                        </div>
                                    </div>

                                    <div class="form-group margin">
                                        <label class="col-sm-3 control-label"><?= lang('title') ?> :</label>
                                        <div class="col-sm-5" style="padding-top: 5px">
                                            <?php echo  $notice->title ?>
                                        </div>
                                    </div>

                                    <div class="form-group margin">
                                        <label class="col-sm-3 control-label"><?= lang('short_description') ?> :</label>
                                        <div class="col-sm-5" style="padding-top: 5px">
                                            <?php echo  $notice->short ?>
                                        </div>
                                    </div>

                                    <div class="form-group margin">
                                        <label class="col-sm-3 control-label"><?= lang('long_description') ?> :</label>
                                        <div class="col-sm-5" style="padding-top: 5px">
                                            <?php echo  $notice->description ?>
                                        </div>
                                    </div>

                                    <div class="form-group margin">
                                        <label class="col-sm-3 control-label"><?= lang('publication_status') ?> :</label>
                                        <div class="col-sm-5" style="padding-top: 5px">
                                            <?php echo  $notice->status ?>
                                        </div>
                                    </div>
                                </div>
                           <?php echo form_close() ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

