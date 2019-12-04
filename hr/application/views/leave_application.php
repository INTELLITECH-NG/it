
<section class="content">
    <div class="row">
        <div class="col-sm-12">

            <div class="row">
                <div class="col-sm-12" data-offset="0">

                    <div class="wrap-fpanel">
                        <div class="box box-primary" data-collapsed="0">
                            <div class="box-header with-border bg-primary-dark">
                                <h3 class="box-title"><?= lang('list_all_leave') ?></h3>
                            </div>

                            <!-- View massage -->
                            <?php echo message_box('success'); ?>
                            <?php echo message_box('error'); ?>

                            <div class="panel-body">

                               <div class="pull-right">
                                   <a href="<?php echo base_url()?>employee/Leave/newApplication/" class="btn bg-navy btn-md btn-flat">
                                       <i class="fa fa-plus" aria-hidden="true"></i><?= lang('apply_for_leave') ?></a>
                               </div>

                                </br>
                                </br>

                                <table id="datatable" class="table" cellspacing="0" width="100%">
                                    <thead>
                                    <tr>
                                        <th><?= lang('leave_category') ?></th>
                                        <th><?= lang('start_date') ?></th>
                                        <th><?= lang('end_date') ?></th>
                                        <th><?= lang('reason') ?></th>
                                        <th><?= lang('applied_on') ?></th>
                                        <th><?= lang('actions') ?></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php if(!empty($leaveApplication)) { foreach($leaveApplication as $item){ ?>
                                        <tr>
                                            <td><?php echo $item->leave_category ?></td>
                                            <td><?php echo date(get_option('date_format'), strtotime($item->start_date)) ?></td>
                                            <td><?php echo date(get_option('date_format'), strtotime($item->end_date)) ?></td>
                                            <td><?php echo $item->reason ?></td>
                                            <td><?php echo date(get_option('date_format'), strtotime($item->application_date)) ?></td>
                                            <td>
                                                <?php
                                                    if($item->status == 'Pending'){
                                                        echo '<small class="label bg-yellow">'. $item->status  .'</small>';
                                                    }elseif($item->status == 'Accepted'){
                                                        echo '<small class="label label-success">'. $item->status  .'</small>';
                                                    }else{
                                                        echo '<small class="label bg-red">'. $item->status  .'</small>';
                                                    }
                                                ?>
                                            </td>
                                        </tr>
                                    <?php } } ?>
                                    </tbody>
                                </table>



                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div></section>
