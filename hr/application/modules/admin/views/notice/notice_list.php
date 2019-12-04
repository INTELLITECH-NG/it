<div class="row">
    <div class="col-md-12">
        <!-- general form elements -->
        <div class="box box-primary">
            <div class="box-header with-border bg-primary-dark">
                <h3 class="box-title"><?= lang('notice_list') ?></h3>
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

                        <?php echo form_open('admin/notice/noticeList', $attribute= array('class'=>'form-inline'))?>
                        <label><?= lang('year') ?> </label>
                        <div class="input-group">

                            <input type="text" id="year" class="form-control years" name="year" value="<?php echo $year; ?>">
                                      <span class="input-group-btn">
                                        <button type="submit" class="btn bg-olive" type="button"><?= lang('go') ?>!</button>
                                      </span>
                        </div><!-- /input-group -->
                        <?php echo form_close() ?>
                    </div>

                    <form method="post" action="#">



                        <br/>
                        <br/>
                        <br/>
                        <div class="col-sm-12">
                            <table class="table table-bordered table-striped datatable-buttons" >
                                <thead ><!-- Table head -->
                                <tr>
                                    <th class="active"><?= lang('sl') ?></th>
                                    <th class="active"><?= lang('created_date') ?></th>
                                    <th class="active"><?= lang('title') ?></th>
                                    <th class="active"><?= lang('short_description') ?></th>
                                    <th class="active"><?= lang('status') ?></th>
                                    <th class="active"><?= lang('actions') ?></th>


                                </tr>
                                </thead><!-- / Table head -->
                                <tbody><!-- / Table body -->

                                    <?php $num = 1; ?>
                                    <?php if(!empty($notice)): foreach($notice as $item):?>
                                        <tr class="custom-tr">
                                            <td class="vertical-td"><?php echo  $num ?></td>
                                            <td class="vertical-td"><?php echo  date(get_option('date_format'), strtotime($item->date)) ?></td>
                                            <td class="vertical-td"><?php echo  $item->title ?></td>
                                            <td class="vertical-td"><?php echo  $item->short ?></td>
                                            <td class="vertical-td">
                                                <?php if($item->status == 'Published'){ ?>
                                                    <span class="label label-success"><?php echo $item->status ?></span>
                                                <?php }else{ ?>
                                                    <span class="label label-danger"><?php echo $item->status ?></span>
                                                <?php } ?>
                                            </td>
                                            <td class="vertical-td">
                                                <div class="btn-group dropdown">
                                                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                                                        More                                  <span class="caret"></span>
                                                    </button>

                                                    <ul class="dropdown-menu pull-right">
                                                        <li>
                                                            <a href="<?php echo base_url('admin/notice/viewNotice/'. str_replace(array('+', '/', '='), array('-', '_', '~'), $this->encrypt->encode($item->id))) ?>"><i class="glyphicon glyphicon-search text-success"></i><?= lang('view') ?></a>
                                                        </li>

                                                        <li>
                                                            <a href="<?php echo base_url('admin/notice/addNotice/'. str_replace(array('+', '/', '='), array('-', '_', '~'), $this->encrypt->encode($item->id))) ?>"><i class="fa fa-pencil-square-o"></i><?= lang('edit') ?></a>
                                                        </li>

                                                        <li>
                                                            <a onclick="return confirm('Are you sure want to cancel this order ?');" href="<?php echo base_url('admin/notice/deleteNotice/'. str_replace(array('+', '/', '='), array('-', '_', '~'), $this->encrypt->encode($item->id))) ?>">
                                                                <i class="fa fa-trash-o"></i><span class="text-danger"><?= lang('delete') ?></span></a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </td>

                                        </tr>
                                        <?php $num++ ?>
                                        <?php endforeach; ?><!--get all sub category if not this empty-->
                                <?php else : ?> <!--get error message if this empty-->
                                    <td colspan="6">
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