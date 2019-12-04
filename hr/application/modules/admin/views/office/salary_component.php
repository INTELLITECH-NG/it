<script src="<?php echo site_url('assets/js/ajax.js') ?>"></script>
<div class="row">
    <div class="col-md-12">
        <!-- general form elements -->
        <div class="box box-primary">
            <div class="box-header with-border bg-primary-dark">
                <h3 class="box-title"><?= lang('salary_component_list') ?></h3>
                <div class="box-tools">
                    <div class="input-group input-group-sm" >
                        <a class="btn btn-default btn-sm btn-flat" onclick="add()"><i class="fa fa-fw fa-plus"></i><?= lang('add_component') ?></a>
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
                                <th><?= lang('name') ?></th>
                                <th><?= lang('type') ?></th>
                                <th style="width:125px;"><?= lang('total_payable') ?></th>
                                <th style="width:125px;"><?= lang('cost_company') ?></th>
                                <th style="width:125px;"><?= lang('rule') ?></th>
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
    var list        = 'admin/office/salary_component_list';
    var saveRow     = 'admin/office/add_salary_component';
    var edit        = 'admin/office/update_salary_component';
    var deleteRow   = 'admin/office/delete_salary_component/';
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
            url : "<?php echo site_url('admin/office/edit_salary_component/')?>/" + id,
            type: "GET",
            data : {'csrf_test_name' : getCookie('csrf_cookie_name')},
            dataType: "JSON",
            success: function(data)
            {
                $('[name="id"]').val(data.id);
                $('[name="component_name"]').val(data.component_name);
                $('[name="type"][value=' + data.type + ']').prop('checked', true);
                $('[name="total_payable"]').prop('checked', data.total_payable == 1 ? true:false);
                $('[name="cost_company"]').prop('checked', data.cost_company == 1 ? true:false);
                $('[name="value_type"][value=' + data.value_type + ']').prop('checked', true);
                $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
                $('.modal-title').text('Salary Component'); // Set title to Bootstrap modal title

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
                <h4 class="modal-title"><?= lang('add_salary_component') ?></h4>
            </div>
            <div class="modal-body form">
                <form action="#" id="form" class="form-horizontal">
                    <input type="hidden" value="" name="id"/>
                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label col-md-3"><?= lang('component_name') ?></label>
                            <div class="col-md-9">
                                <input name="component_name"  class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>

                            <table style="width: 100%; padding-left: 50px">
                                <tbody><tr style="height: 50px">
                                    <td>
                                        <label for="exampleInputEmail1"><?= lang('type') ?> <span class="required">*</span></label>
                                    </td>
                                    <td>
                                        <label class="css-input css-radio css-radio-success push-10-r">
                                            <input name="type" value="1" checked="" type="radio"><span></span><?= lang('earning') ?>
                                        </label>
                                    </td>
                                    <td>
                                        <label class="css-input css-radio css-radio-success push-10-r">
                                            <input name="type" value="2" type="radio"><span></span> <?= lang('deduction') ?>
                                        </label>
                                    </td>
                                </tr>

                                <tr style="height: 50px">
                                    <td>
                                        <label for="exampleInputEmail1"><?= lang('add_to') ?><span class="required">*</span></label>
                                    </td>
                                    <td>

                                        <label class="css-input css-checkbox css-checkbox-success">
                                            <input name="total_payable" value="1"  type="checkbox"><span></span> <?= lang('total_payable') ?>
                                        </label>
                                    </td>
                                    <td>
                                        <label class="css-input css-checkbox css-checkbox-success">
                                            <input name="cost_company" value="1"  type="checkbox"><span></span> <?= lang('cost_company') ?>
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                    </td>
                                    <td colspan="2">
                                        <span class="chk_error_msg"></span>
                                    </td>

                                </tr>


                                <tr style="height: 50px">
                                    <td>
                                        <label for="exampleInputEmail1"><?= lang('value_type') ?><span class="required">*</span></label>
                                    </td>
                                    <td>
                                        <label class="css-input css-radio css-radio-success push-10-r">
                                            <input name="value_type" value="1" checked="" type="radio"><span></span><?= lang('amount') ?>
                                        </label>
                                    </td>
                                    <td>
                                        <label class="css-input css-radio css-radio-success push-10-r">
                                            <input name="value_type" value="2"  type="radio"><span></span> <?= lang('percentage') ?>
                                        </label>
                                    </td>
                                </tr>

                                </tbody></table>

                    </div>

                </form>
            </div>


            <div class="modal-footer">
                <button type="button" id="btnSave" onclick="check()" class="btn btn-primary"><?= lang('save') ?></button>
                <button type="button" class="btn btn-danger" data-dismiss="modal"><?= lang('cancel') ?></button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- End Bootstrap modal -->

<script>
    function check()
    {
        if( $('[name="total_payable"]').prop('checked') == true || $('[name="cost_company"]').prop('checked') == true ){
            //do something
            save();

        }else{
            $(".chk_error_msg").html('<div class="help-block" style="color: #dd4b39;"><?= lang('please_select_at_least_one_chk') ?></div>');
            console.log('Not select');
        }

    }

</script>