<div class="well-custom">
    <!-- STATISTICS -->
    <div class="row">
        <div class="col-md-4 col-sm-4 col-xs-4" style="border-right: 1px solid #46b8da">
            <div class="uppercase text-center">
                <strong>
                    <?php echo $total_attendance ?> / <?php echo $total_working_days ?> </strong>
            </div>
            <div class="uppercase text-center">
                <?= lang('attendance') ?>
            </div>
        </div>
        <div class="col-md-4 col-sm-4 col-xs-4" style="border-right: 1px solid #46b8da">
            <a href="http://localhost/hr/employee/dashboard/leave_application" style="color: white;">
                <div class="uppercase text-center">
                    <strong>
                        0                                        </strong>
                </div>
                <div class="uppercase text-center">
                    <?= lang('leave') ?>
                </div>
            </a>
        </div>
        <div class="col-md-4 col-sm-4 col-xs-4">
            <a href="http://localhost/hr/employee/dashboard/all_award" style="color: white;">
                <div class="uppercase text-center">
                    <strong><?php echo $award ?></strong>
                </div>
                <div class="uppercase text-center">
                    <?= lang('award') ?>
                </div>
            </a>
        </div>
    </div>
</div>


<div class="panel panel-default">
    <div class="panel-heading">
        <h2 class="panel-title"><i class="fa fa-bell-o"></i> <strong><?= lang('notice_board') ?></strong><span class="pull-right"><a href="<?php echo site_url('employee/home/allNotice') ?>" class=" view-all-front"><?= lang('view_all') ?></a></span></h2>
    </div>
    <div class="panel-body notice">

        <?php if(!empty($notice)): foreach($notice as $item): ?>

        <div class="notice-calendar-list clearfix">
            <div class="notice-calendar">
                <span class="month"><?php echo date('M', strtotime($item->date)) ?></span>
                <span class="date"><?php echo date('d', strtotime($item->date)) ?></span>
            </div>

            <div class="notice-calendar-heading">
                <h5 class="notice-calendar-heading-title">
                    <a href="<?php echo base_url('employee/home/viewNotice/'.str_replace(array('+', '/', '='), array('-', '_', '~'), $this->encrypt->encode($item->id))) ?>"><?php echo $item->title ?></a>
                </h5>
                <div class="notice-calendar-date"><?php echo substr($item->short, 0, 100);  ?></div>
            </div>
            <div style="margin-top: 5px; padding-top: 5px; padding-bottom: 10px;">
                <span style="font-size: 10px;" class="pull-right">
                    <strong><a href="<?php echo base_url('employee/home/viewNotice/'.str_replace(array('+', '/', '='), array('-', '_', '~'), $this->encrypt->encode($item->id))) ?>" style="color: #004884;"><?= lang('view_details') ?></a></strong>
                </span>
            </div>
        </div>
        <?php endforeach; endif ?>

    </div>
</div>



<div class="panel panel-default">
    <div class="panel-heading">
        <h2 class="panel-title"><i class="fa fa-binoculars"></i><strong><?= lang('upcoming_events') ?></strong><span class="pull-right"><a href="<?php echo site_url('employee/home/allEvents') ?>" class=" view-all-front"><?= lang('view_all') ?></a></span></h2>
    </div>
    <div class="panel-body event">
        <?php foreach ($holidays as $v_events) { ?>
            <div class="notice-calendar-list clearfix" style="padding-bottom: 10px">
                <div class="notice-calendar">
                    <span class="month"><?php echo date('M', strtotime($v_events->start_date)) ?></span>
                    <span class="date"><?php echo date('d', strtotime($v_events->start_date)) ?></span>
                </div>

                <div class="notice-calendar-heading">
                    <h5 class="notice-calendar-heading-title">
                        <a href="<?php echo base_url() ?>employee/home/viewEvents//<?php echo str_replace(array('+', '/', '='), array('-', '_', '~'), $this->encrypt->encode($v_events->holiday_id)) ?>"><?php echo $v_events->event_name ?></a>
                    </h5>
                    <div class="notice-calendar-date"><span class="text-danger">End Date: </span>
                        <?php echo date('d M Y', strtotime($v_events->end_date)); ?>

                    </div>
                </div>
                <div style="margin-top: 5px; padding-top: 5px; padding-bottom: 5px;">
                        <span style="font-size: 10px;" class="pull-right">
                            <strong><a href="<?php echo base_url() ?>employee/home/viewEvents/<?php echo str_replace(array('+', '/', '='), array('-', '_', '~'), $this->encrypt->encode($v_events->holiday_id))  ?>" style="color: #004884;"><?= lang('view_details') ?></a></strong>
                        </span>
                </div>
            </div>
        <?php } ?>

    </div>
</div>


<div class="panel panel-default">
    <div class="panel-heading">
        <h2 class="panel-title"><strong>Upcomming Birhday </strong>- December</h2>
    </div>
    <div class="panel-body tab-pane-notice">
        <div class="notice-calendar-list clearfix">
            <div class="notice-calendar">
                <span class="month">Dec</span>
                <span class="date">27</span>
            </div>

            <div class="notice-calendar-heading">
                <h5 class="notice-calendar-heading-title">
                    <a href="http://localhost/hr/employee/dashboard/notice_detail/1">Hellooo</a>
                </h5>
                <div class="notice-calendar-date">
                    Echarts Some examples to get you started&nbsp;                                        </div>
            </div>
            <div style="margin-top: 5px; padding-top: 5px; padding-bottom: 10px;">
                                        <span style="font-size: 10px;" class="pull-right">
                                            <strong><a href="http://localhost/hr/employee/dashboard/notice_detail/1" style="color: #004884;">View Details</a></strong>
                                        </span>
            </div>
        </div>
    </div>
</div>