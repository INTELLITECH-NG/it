<script src="<?php echo site_url('assets/js/empCalander.js') ?>"></script>
<div class="row">
    <div class="col-md-8">



        <!-- Calender Start from Here -->

        <div class="box"><!-- /primary heading -->

            <div id="portlet2" class="panel-collapse collapse in">
                <div class="box-body" style="">

                    <div id="calendar" class="col-centered"></div>

                    <!-- Modal -->
                    <div class="modal fade" id="ModalAdd" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">

                                <form class="addEvent form-horizontal" id="addEventForm">

                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title" id="myModalLabel">Add Event</h4>
                                    </div>
                                    <div class="modal-body">

                                        <div class="form-group">
                                            <label for="title" class="col-sm-2 control-label">Title</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="title" class="form-control" id="title" placeholder="Title">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="color" class="col-sm-2 control-label">Color</label>
                                            <div class="col-sm-10">
                                                <select name="color" class="form-control" id="color">
                                                    <option value="">Choose</option>
                                                    <option style="color:#0071c5;" value="#0071c5">&#9724; Dark blue</option>
                                                    <option style="color:#40E0D0;" value="#40E0D0">&#9724; Turquoise</option>
                                                    <option style="color:#008000;" value="#008000">&#9724; Green</option>
                                                    <option style="color:#FFD700;" value="#FFD700">&#9724; Yellow</option>
                                                    <option style="color:#FF8C00;" value="#FF8C00">&#9724; Orange</option>
                                                    <option style="color:#FF0000;" value="#FF0000">&#9724; Red</option>
                                                    <option style="color:#000;" value="#000">&#9724; Black</option>

                                                </select>
                                            </div>
                                        </div>


                                        <div class="form-group">
                                            <label for="start" class="col-sm-2 control-label">Start date</label>
                                            <div class="col-sm-4">
                                                <input type="text"  name="start" class="form-control" id="start" data-date-format="yyyy-mm-dd">
                                            </div>

                                            <label for="start" class="col-sm-2 control-label">Time</label>
                                            <div class="col-sm-4">
                                                <div class="input-group bootstrap-timepicker timepicker">
                                                    <input type="text"  name="startTime" class="form-control" id="startTime" data-date-format="HH:mm:ss">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="end" class="col-sm-2 control-label">End date</label>
                                            <div class="col-sm-4">
                                                <input type="text" name="end" class="form-control" id="end" data-date-format="yyyy-mm-dd" >
                                            </div>

                                            <label for="start" class="col-sm-2 control-label">Time</label>
                                            <div class="col-sm-4">
                                                <div class="input-group bootstrap-timepicker timepicker">
                                                    <input type="text"  name="endTime" class="form-control" id="endTime" data-date-format="HH:mm:ss">
                                                </div>
                                            </div>
                                        </div>




                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                        <button type="submit" id="addEvent" class="btn btn-primary">Save changes</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>



                    <!-- Modal -->
                    <div class="modal fade" id="ModalEdit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <form class="editEvent form-horizontal">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title" id="myModalLabel">Edit Event</h4>
                                    </div>
                                    <div class="modal-body">

                                        <div class="form-group">
                                            <label for="title" class="col-sm-2 control-label">Title</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="title" class="form-control" id="title" placeholder="Title">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="color" class="col-sm-2 control-label">Color</label>
                                            <div class="col-sm-10">
                                                <select name="color" class="form-control" id="color">
                                                    <option value="">Choose</option>
                                                    <option style="color:#0071c5;" value="#0071c5">&#9724; Dark blue</option>
                                                    <option style="color:#40E0D0;" value="#40E0D0">&#9724; Turquoise</option>
                                                    <option style="color:#008000;" value="#008000">&#9724; Green</option>
                                                    <option style="color:#FFD700;" value="#FFD700">&#9724; Yellow</option>
                                                    <option style="color:#FF8C00;" value="#FF8C00">&#9724; Orange</option>
                                                    <option style="color:#FF0000;" value="#FF0000">&#9724; Red</option>
                                                    <option style="color:#000;" value="#000">&#9724; Black</option>

                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="start" class="col-sm-2 control-label">Start date</label>
                                            <div class="col-sm-4">
                                                <input type="text"  name="start" class="form-control" id="eStart" data-date-format="yyyy-mm-dd">
                                            </div>

                                            <label for="start" class="col-sm-2 control-label">Time</label>
                                            <div class="col-sm-4">
                                                <div class="input-group bootstrap-timepicker timepicker">
                                                    <input type="text"  name="startTime" class="form-control" id="eStartTime" data-date-format="HH:mm:ss">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="end" class="col-sm-2 control-label">End date</label>
                                            <div class="col-sm-4">
                                                <input type="text" name="end" class="form-control" id="eEnd" >
                                            </div>

                                            <label for="start" class="col-sm-2 control-label">Time</label>
                                            <div class="col-sm-4">
                                                <div class="input-group bootstrap-timepicker timepicker">
                                                    <input type="text"  name="endTime" class="form-control" id="eEndTime" data-date-format="HH:mm:ss">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-sm-offset-2 col-sm-10">
                                                <div class="checkbox">
                                                    <label class="text-danger"><input type="checkbox"  name="delete"> Delete event</label>
                                                </div>
                                            </div>
                                        </div>

                                        <input type="hidden" name="id" class="form-control" id="id">


                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                        <button type="submit" id="editEvent" class="btn btn-primary">Save changes</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>



                </div>
            </div>
        </div>

        <!-- Calender End from Here -->










    </div>
    <div class="col-md-4">


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
                    <a href="<?php echo site_url('employee/leave') ?>" style="color: white;">
                        <div class="uppercase text-center">
                            <strong><?php echo $approved_leave ?></strong>
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


    </div>
</div>




