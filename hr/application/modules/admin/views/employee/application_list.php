<div class="row">
    <div class="col-md-12">
        <!-- general form elements -->
        <div class="box box-primary">
            <div class="box-header with-border bg-primary-dark">
                <h3 class="box-title"><?= lang('list_of_holiday') ?></h3>
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

                        <?php echo form_open('admin/employee/applicationList', $attribute= array('class'=>'form-inline'))?>
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
                                    <th class="active"><?= lang('employee_id') ?></th>
                                    <th class="active"><?= lang('employee_name') ?></th>
                                    <th class="active"><?= lang('start_date') ?></th>
                                    <th class="active"><?= lang('end_date') ?></th>
                                    <th class="active"><?= lang('leave_type') ?></th>
                                    <th class="active"><?= lang('application_date') ?></th>
                                    <th class="active"><?= lang('status') ?></th>
                                    <th class="active"><?= lang('actions') ?></th>


                                </tr>
                                </thead><!-- / Table head -->
                                <tbody><!-- / Table body -->


                                    <?php if(!empty($application)): foreach($application as $item):?>
                                        <tr class="custom-tr">
                                            <td class="vertical-td"><?php echo  $item->employee_id ?></td>
                                            <td class="vertical-td"><?php echo  $item->first_name.' '.$item->last_name ?></td>
                                            <td class="vertical-td"><?php echo date(get_option('date_format'), strtotime($item->start_date)) ?></td>
                                            <td class="vertical-td"><?php echo date(get_option('date_format'), strtotime($item->end_date)) ?></td>
                                            <td class="vertical-td"><?php echo  $item->leave_category ?></td>
                                            <td class="vertical-td"><?php echo date(get_option('date_format'), strtotime($item->application_date)) ?></td>
                                            <td class="vertical-td">
                                                <?php if($item->status == 'Pending'){ ?>
                                                    <span class="label label-warning"><?php echo $item->status ?></span>
                                                <?php }elseif($item->status == 'Accepted'){ ?>
                                                    <span class="label label-success"><?php echo $item->status ?></span>
                                                <?php }else{ ?>
                                                    <span class="label label-danger"><?php echo $item->status ?></span>
                                                <?php } ?>
                                            </td>
                                            <td class="vertical-td">
                                                <div class="btn-group">
                                                    <a  href="<?php echo site_url('admin/employee/viewApplication/'. str_replace(array('+', '/', '='), array('-', '_', '~'), $this->encrypt->encode($item->id))) ?>" class="btn btn-xs bg-gray">
                                                        <i class="fa fa-eye"></i>
                                                    </a>

                                                </div>
                                            </td>

                                        </tr>
                                        <?php
                                    endforeach;

                                    ?><!--get all sub category if not this empty-->
                                <?php else : ?> <!--get error message if this empty-->
                                    <td colspan="8">
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