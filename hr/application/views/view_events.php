


<section class="content">



    <div class="row">
        <div class="col-sm-12">

            <div class="row">
                <div class="col-sm-12" data-offset="0">
                    <div class="wrap-fpanel">
                        <div class="box box-primary" data-collapsed="0">
                            <div class="box-header with-border bg-primary-dark">
                                <h3 class="box-title"><?= lang('events_details') ?></h3>
                            </div>
                            <div class="panel-body" id="printableArea">





                                <form action="" class="form-horizontal" accept-charset="utf-8">


                                    <div class="panel_controls">

                                        <div class="form-group margin">
                                            <label class="col-sm-3 control-label"><?= lang('event_name') ?></label>

                                            <div class="col-sm-5" style="padding-top: 5px"><?php echo $event->event_name ?></div>
                                        </div>

                                        <div class="form-group margin">
                                            <label class="col-sm-3 control-label"><?= lang('start_date') ?></label>

                                            <div class="col-sm-5" style="padding-top: 5px"><?php echo date(get_option('date_format'), strtotime($event->start_date)) ?></div>
                                        </div>

                                        <div class="form-group margin">
                                            <label class="col-sm-3 control-label"><?= lang('end_date') ?></label>

                                            <div class="col-sm-5" style="padding-top: 5px"><?php echo date(get_option('date_format'), strtotime($event->end_date)) ?></div>
                                        </div>

                                        <div class="form-group margin">
                                            <label class="col-sm-3 control-label"><?= lang('description') ?></label>

                                            <div class="col-sm-5" style="padding-top: 5px"><?php echo $event->description ?></div>
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
