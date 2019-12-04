<script src="<?php echo site_url('assets/js/ajax.js') ?>"></script>

<div class="row">
    <div class="col-md-12">
        <!-- general form elements -->
        <div class="box box-primary">
            <div class="box-header with-border bg-primary-dark">
                <h3 class="box-title"><?= lang('work_shift') ?></h3>
                <div class="box-tools">
                    <div class="input-group input-group-sm" >
                        <a class="btn btn-default btn-sm btn-flat" onclick="add()"><i class="fa fa-fw fa-plus"></i><?= lang('add_work_shift') ?></a>
                    </div>
                </div>
            </div>
            <!-- /.box-header -->
            <!-- form start -->

            <div class="box-body">

                <!-- View massage -->


                <div class="row">
                    <div class="col-md-12">


                        <div id="msg"></div>


                        <table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th><?= lang('shift_name') ?></th>
                                <th style="width:125px;"><?= lang('shift_form') ?></th>
                                <th style="width:125px;"><?= lang('shift_to') ?></th>
                                <th style="width:125px;"><?= lang('actions') ?></th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->

    </div>
</div>
<script>

    var save_method; //for save method string
    var table;
    var list        = 'admin/office/work_shift_list'; //list view
    var saveRow     = 'admin/office/add_work_shift';
    var edit        = 'admin/office/update_work_shift';
    var deleteRow   = 'admin/office/delete_work_shift/';
    var saveSuccess = "<?php echo $this->message->success_msg() ?>" ;
    var deleteSuccess = "<?php echo $this->message->delete_msg() ?>" ;
    var deleteError = "<?php echo lang('record_has_been_used'); ?>" ;



    function edit_title(id)
    {

        save_method = 'update';
        $('#form')[0].reset(); // reset form on modals
        $('.form-group').removeClass('has-error'); // clear error class
        $('.help-block').empty(); // clear error string

        //Ajax Load data from ajax
        $.ajax({
            url : "<?php echo site_url('admin/office/edit_work_shift/')?>/" + id,
            type: "GET",
            data : {'csrf_test_name' : getCookie('csrf_cookie_name')},
            dataType: "JSON",
            success: function(data)
            {
                $('[name="id"]').val(data.id);
                $('[name="shift_name"]').val(data.shift_name);
                $('[name="shift_form"]').val(data.shift_form);
                $('[name="shift_to"]').val(data.shift_to);
                $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
                $('.modal-title').text('<?= lang('edit_work_shift') ?>'); // Set title to Bootstrap modal title

            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error get data from ajax');
            }
        });
    }

</script>





<!-- Bootstrap modal -->
<div class="modal fade" id="modal_form" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><?= lang('add_work_shift') ?></h4>
            </div>
            <div class="modal-body form">
                <form action="#" id="form" class="form-horizontal">
                    <input type="hidden" value="" name="id"/>
                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label col-md-3"><?= lang('shift_name') ?></label>
                            <div class="col-md-9">
                                <input name="shift_name"  class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>


                            <div class="form-group">
                                <label class="control-label col-md-3"><?= lang('shift_form') ?></label>
                                <div class="col-md-9">

                                        <div class="input-group bootstrap-timepicker timepicker">
                                            <input id="timepicker1" name="shift_form" class="form-control" data-provide="timepicker" value="<?= date("h:i A"); ?>"  data-date-format="HH:ii p" type="text"/>

                                        </div>

                                        <span class="help-block"></span>

                                </div>
                            </div>




                        <div class="form-group">
                            <label class="control-label col-md-3"><?= lang('shift_to') ?></label>
                            <div class="col-md-9">
                                <div class="input-group bootstrap-timepicker timepicker">
                                    <input id="timepicker2" name="shift_to" class="form-control" data-provide="timepicker"  value="<?= date("h:i A"); ?>" data-date-format="HH:ii p" type="text"/>
                                </div>
                                <span class="help-block"></span>
                            </div>
                        </div>



                    </div>

                </form>
            </div>


            <div class="modal-footer">
                <button type="button" id="btnSave" onclick="save()" class="btn btn-primary"><?= lang('save') ?></button>
                <button type="button" class="btn btn-danger" data-dismiss="modal"><?= lang('cancel') ?></button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- End Bootstrap modal -->

<script>
    $(document).ready(function() {
        $("#timepicker1").timepicker({
            showInputs: false,
            defaultTime: 'current',

        });

        $("#timepicker2").timepicker({
            showInputs: false,
            defaultTime: 'current',
        });
    })
</script>
