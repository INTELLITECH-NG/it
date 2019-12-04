<section class="content">
    <div class="row">
        <div class="col-sm-12">

            <div class="row">
                <div class="col-sm-12" data-offset="0">
                    <div class="wrap-fpanel">
                        <div class="box box-primary" data-collapsed="0">
                            <div class="box-header with-border bg-primary-dark">
                                <h3 class="box-title"><?= lang('list_all_events') ?></h3>
                            </div>
                            <div class="panel-body">


                                <table class="table ">
                                    <thead>
                                    <tr>
                                        <th><?= lang('event_name') ?></th>
                                        <th><?= lang('start_date') ?></th>
                                        <th><?= lang('end_date') ?></th>
                                        <th><?= lang('actions') ?></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php if(!empty($events)){ foreach($events as $item){ ?>
                                        <tr>
                                            <td><?php echo $item->event_name ?></td>
                                            <td><?php echo date(get_option('date_format'), strtotime($item->start_date)) ?></td>
                                            <td><?php echo date(get_option('date_format'), strtotime($item->end_date)) ?></td>
                                            <td><a class="btn btn-xs btn-default" href="<?php echo base_url('employee/home/viewEvents/'.str_replace(array('+', '/', '='), array('-', '_', '~'), $this->encrypt->encode($item->holiday_id))) ?>"><i class="fa fa-eye"></i></a></td>
                                        </tr>
                                    <?php }; } ?>
                                    </tbody>
                                </table>



                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div></section>
