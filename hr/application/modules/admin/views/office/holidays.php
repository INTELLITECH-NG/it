<div class="row">
    <div class="col-md-12">
        <!-- general form elements -->
        <div class="box box-primary">
            <div class="box-header with-border bg-primary-dark">
                <h3 class="box-title"><?= lang('list_of_holiday') ?></h3>
                <div class="box-tools" style="padding-top: 5px">
                    <div class="input-group input-group-sm" >
                        <a  data-target="#modalSmall" title="View" data-placement="top" data-toggle="modal"
                                href="<?php echo base_url()?>admin/office/add_holiday" class="btn btn-sm bg-blue-active btn-flat">
                            <i class="fa fa-plus"></i> <?= lang('add_holiday') ?>
                        </a>
                    </div>
                </div>
            </div>
            <!-- /.box-header -->
            <!-- form start -->




            <div class="box-body">

                <!-- View massage -->

                <!-- View massage -->
                <?php echo message_box('success'); ?>
                <?php echo message_box('error'); ?>



                <div class="row">
                    <div class="col-sm-3">

                       <?php echo form_open('admin/office/holidayList', $attribute= array('class'=>'form-inline'))?>
                            <label><?= lang('year') ?> </label>
                            <div class="input-group">

                                <input type="text" id="year" class="form-control years" name="year" value="<?php echo $year; ?>">
                                      <span class="input-group-btn">
                                        <button type="submit" class="btn bg-olive" type="button"><?= lang('go') ?>!</button>
                                      </span>
                            </div><!-- /input-group -->
                        <?php echo form_close() ?>
                    </div>

                    <form method="post" action="<?php echo base_url()?>admin/holiday/delete_holiday">



                        <br/>
                        <br/>
                        <br/>
                        <div class="col-sm-12">
                            <table class="table table-bordered table-striped datatable-buttons" >
                                <thead ><!-- Table head -->
                                <tr>
                                    <th class="active"><?= lang('holiday') ?></th>
                                    <th class="active"><?= lang('description') ?></th>
                                    <th class="active"><?= lang('start_date') ?></th>
                                    <th class="active"><?= lang('end_date') ?></th>
                                    <th class="active"><?= lang('actions') ?></th>
                                </tr>
                                </thead><!-- / Table head -->
                                <tbody><!-- / Table body -->

                                <?php if (!empty($yearly_holiday)): foreach ($yearly_holiday as $name => $month) : ?>
                                    <?php if(!empty($month)): foreach($month as $item):?>
                                        <tr class="custom-tr">
                                            <td class="vertical-td"><?php echo  $item->event_name ?></td>
                                            <td class="vertical-td"><?php echo  $item->description ?></td>
                                            <td class="vertical-td"><?php echo date(get_option('date_format'), strtotime($item->start_date)) ?></td>
                                            <td class="vertical-td"><?php echo date(get_option('date_format'), strtotime($item->end_date)) ?></td>
                                            <td class="vertical-td">
                                                <div class="btn-group">
                                                        <a  data-target="#modalSmall"  data-placement="top" data-toggle="modal"
                                                            href="<?php echo site_url('admin/office/add_holiday/'. $item->holiday_id) ?>" class="btn btn-xs bg-gray">
                                                            <i class="fa fa-pencil"></i>
                                                        </a>
                                                    <a class="btn btn-xs btn-danger"
                                                       onClick="return confirm('Are you sure you want to delete?')" href="<?php echo site_url('admin/office/deleteHoliday/'. $item->holiday_id) ?>" ><i class="glyphicon glyphicon-trash"></i></a>
                                                </div>
                                            </td>

                                        </tr>
                                        <?php
                                    endforeach;
                                    endif;
                                endforeach;
                                    ?><!--get all sub category if not this empty-->
                                <?php else : ?> <!--get error message if this empty-->
                                    <td colspan="5">
                                        <strong><?= lang('no_records_found') ?></strong>
                                    </td><!--/ get error message if this empty-->
                                <?php endif; ?>
                                </tbody><!-- / Table body -->
                            </table> <!-- / Table -->
                        </div>


                    </form>

                </div>


            </div>
            <!-- /.box -->


        </div>
    </div>


    <script>

        $(function() {

            $('#select_employee').on('change', function() {
                $('.checkEmployee').prop('checked', $(this).prop('checked'));
            });
            $('.checkEmployee').on('change', function() {
                $('#select_employee').prop($('.child_present:checked').length ? true : false);
            });

        });

        $(function() {
            $("body").delegate(".datepicker", "focusin", function(){
                $(this).datepicker();
            });
        });

    </script>