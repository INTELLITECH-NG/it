<script src="<?php echo site_url('assets/js/dataTableAjax.js') ?>"></script>

<div class="row">
    <div class="col-md-12">
        <!-- general form elements -->
        <div class="box box-primary">
            <div class="box-header with-border bg-primary-dark">
                <h3 class="box-title"><?= lang('transactions_list') ?></h3>
                <div class="box-tools" style="padding-top: 5px">
                    <div class="input-group input-group-sm" >
                        <a class="btn bg-navy btn-sm btn-flat" href="<?php echo site_url('admin/transaction/addTransaction') ?>"><i class="fa fa-fw fa-plus"></i><?= lang('add_transaction') ?></a>
                    </div>
                </div>
            </div>
            <!-- /.box-header -->
            <!-- form start -->

            <div class="box-body">

                <!-- View massage -->
                <?php echo message_box('success'); ?>
                <?php echo message_box('error'); ?>


                <div class="row">
                    <div class="col-md-12">




                       <div class="well well-sm">
                           <div class="row">


                               <form id="addTransaction" action="<?php echo site_url('admin/transaction/searchTransactions')?>" method="post" onsubmit="return get_Cookie('csrf_cookie_name')">
                               <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" id="token">

                               <div class="col-md-11">

                                   <div class="col-md-3 col-sm-6 col-xs-12">
                                       <div class="form-group form-group-bottom">
                                           <label><?= lang('start_date') ?></label>

                                           <div class="input-group">
                                               <input type="text" class="form-control" id="datepicker" name="start_date" data-date-format="yyyy/mm/dd">
                                               <div class="input-group-addon">
                                                   <i class="fa fa-calendar-o"></i>
                                               </div>
                                           </div>
                                       </div>
                                   </div>

                                   <div class="col-md-3 col-sm-6 col-xs-12">
                                       <div class="form-group form-group-bottom">
                                           <label><?= lang('end_date') ?></label>

                                           <div class="input-group">
                                               <input type="text" class="form-control" id="datepicker-1" name="end_date" data-date-format="yyyy/mm/dd">
                                               <div class="input-group-addon">
                                                   <i class="fa fa-calendar-o"></i>
                                               </div>
                                           </div>
                                       </div>
                                   </div>

                                   <div class="col-md-3 col-sm-6 col-xs-12">
                                       <div class="form-group form-group-bottom">
                                           <label><?= lang('account') ?></label>

                                           <select class="form-control select2" name="account">
                                               <option value=""><?= lang('please_select') ?>...</option>
                                               <?php foreach($account as $item){ ?>
                                                   <option value="<?php echo $item->id ?>"><?php echo $item->account_title ?></option>
                                               <?php } ?>
                                           </select>
                                       </div>
                                   </div>



                                   <div class="col-md-2 col-sm-6 col-xs-12">
                                       <div class="form-group">
                                           <label><?= lang('transaction_type') ?></label>
                                           <select class="form-control select2" name="transaction_type" id="transaction_type" onchange="transactionType(this)">
                                               <option value=""><?= lang('please_select') ?>...</option>
                                               <option value="1"><?= lang('deposit') ?></option>
                                               <option value="2"><?= lang('expense') ?></option>
                                               <option value="5"><?= lang('transfer') ?></option>
                                           </select>
                                       </div>
                                   </div>


                                   <div class="col-md-1 col-sm-6 col-xs-12">
                                       <div class="form-group form-group-bottom" style="padding-top: 25px;">
                                           <button type="submit" class="btn bg-blue btn-flat btn-sm"><i class="fa fa-search" aria-hidden="true"></i>
                                               <?= lang('search') ?></button>
                                       </div>
                                   </div>


                               </div>
                                </form>





                           </div>


                       </div>

                        <table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th><?= lang('trns_id') ?></th>
                                <th><?= lang('account') ?></th>
                                <th><?= lang('type') ?></th>
                                <th><?= lang('category') ?></th>
                                <th><?= lang('dr') ?>.</th>
                                <th><?= lang('cr') ?>.</th>
                                <th><?= lang('balance') ?></th>
                                <th><?= lang('date') ?></th>
                                <th style="width:25px;"><?= lang('actions') ?></th>
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
    //var table;
    var list        = 'admin/transaction/transaction_list';

    function get_Cookie(name) {
        var cookieValue = null;
        if (document.cookie && document.cookie != '') {
            var cookies = document.cookie.split(';');
            for (var i = 0; i < cookies.length; i++) {
                var cookie = jQuery.trim(cookies[i]);
                // Does this cookie string begin with the name we want?
                if (cookie.substring(0, name.length + 1) == (name + '=')) {
                    cookieValue = decodeURIComponent(cookie.substring(name.length + 1));
                    break;
                }
            }
        }
        $('#token').val(cookieValue);
    }

</script>



