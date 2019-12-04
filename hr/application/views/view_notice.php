


<section class="content">



    <div class="row">
        <div class="col-sm-12">

            <div class="row">
                <div class="col-sm-12" data-offset="0">
                    <div class="wrap-fpanel">
                        <div class="box box-primary" data-collapsed="0">
                            <div class="box-header with-border bg-primary-dark">
                                <h3 class="box-title"><?= lang('notice_detail') ?></h3>
                            </div>
                            <div class="panel-body" id="printableArea">





                                <form action="" class="form-horizontal" accept-charset="utf-8">


                                    <div class="panel_controls">

                                        <div class="form-group margin">
                                            <label class="col-sm-2 control-label"><?= lang('date') ?></label>

                                            <div class="col-sm-9" style="padding-top: 5px"><?php echo date(get_option('date_format'), strtotime($empNotice->date)) ?></div>
                                        </div>

                                        <div class="form-group margin">
                                            <label class="col-sm-2 control-label"><?= lang('title') ?></label>

                                            <div class="col-sm-9" style="padding-top: 5px"><?php echo $empNotice->title ?></div>
                                        </div>


                                        <div class="form-group margin">
                                            <label class="col-sm-2 control-label"><?= lang('notice') ?></label>

                                            <div class="col-sm-9" style="padding-top: 5px"><?php echo $empNotice->description ?></div>
                                        </div>



                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div></section>
