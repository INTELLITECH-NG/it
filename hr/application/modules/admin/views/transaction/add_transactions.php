
<div class="row">
    <div class="col-md-12">
        <!-- general form elements -->
        <div class="box box-primary">
            <div class="box-header with-border bg-primary-dark">
                <h3 class="box-title"><?= lang('add_transaction') ?></h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->



            <form id="addTransaction" action="<?php echo site_url('admin/transaction/save_transaction')?>" method="post" onsubmit="return get_Cookie('csrf_cookie_name')">
            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" id="token">

            <div class="box-body">

                <!-- View massage -->

                <!-- View massage -->
                <?php echo message_box('success'); ?>
                <?php echo message_box('error'); ?>


                <div class="row">
                    <div class="col-md-6 col-sm-12 col-xs-12">


                        <div class="form-group">
                            <label><?= lang('transaction_type') ?><span class="required" aria-required="true">*</span></label>
                            <select class="form-control select2" name="transaction_type" id="transaction_type" onchange="transactionType(this)">
                                <option value=""><?= lang('please_select') ?>...</option>
                                <option value="Deposit"><?= lang('deposit') ?></option>
                                <option value="Expenses"><?= lang('expense') ?></option>
                                <option value="AP"><?= lang('accounts_payable') ?></option>
                                <option value="AR"><?= lang('accounts_receivable') ?></option>
                                <option value="TR"><?= lang('account_transfer') ?></option>
                            </select>
                        </div>

                        <!-- account-->

                        <div id="account" style="display: none">
                            <div class="form-group" >
                                <label><?= lang('account') ?><span class="required" aria-required="true">*</span></label>
                                <select class="form-control select2" name="account" id="account_select">
                                    <option value=""><?= lang('please_select') ?>...</option>
                                    <?php foreach($account as $item){ ?>
                                        <option value="<?php echo $item->id ?>"><?php echo $item->account_title ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>

                        <!-- account Transfer START-->

                        <div id="transfer_account" style="display: none">
                            <div class="form-group" >
                                <label><?= lang('from_account') ?><span class="required" aria-required="true">*</span></label>
                                <select class="form-control select2" name="from_account" id="account_select">
                                    <option value=""><?= lang('please_select') ?>...</option>
                                    <?php foreach($account as $item){ ?>
                                        <option value="<?php echo $item->id ?>"><?php echo $item->account_title ?></option>
                                    <?php } ?>
                                </select>
                            </div>

                            <div class="form-group" >
                                <label><?= lang('to_account') ?><span class="required" aria-required="true">*</span></label>
                                <select class="form-control select2" name="to_account" id="account_select">
                                    <option value=""><?= lang('please_select') ?>...</option>
                                    <?php foreach($account as $item){ ?>
                                        <option value="<?php echo $item->id ?>"><?php echo $item->account_title ?></option>
                                    <?php } ?>
                                </select>
                            </div>

                        </div>

                        <!-- account Transfer END-->


                        <div class="form-group" id="trn_category">
                            <label><?= lang('category') ?><span class="required" aria-required="true">*</span></label>
                            <select class="form-control select2" name="category_id" id="category">
                                <option value=""><?= lang('please_select') ?>...</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label><?= lang('amount') ?><span class="required" aria-required="true">*</span></label>
                            <input type="text" name="amount" class="form-control">
                        </div>


                            <div class="form-group" id="method" style="display: none">
                                <label><?= lang('payment_method') ?><span class="required" aria-required="true">*</span></label>
                                <select class="form-control select2" name="payment_method">
                                    <option value=""><?= lang('please_select') ?>...</option>
                                    <option value="<?= lang('cash') ?>"><?= lang('cash') ?></option>
                                    <option value="<?= lang('check') ?>"><?= lang('check') ?></option>
                                    <option value="<?= lang('credit_card') ?>"><?= lang('credit_card') ?></option>
                                    <option value="<?= lang('debit_card') ?>"><?= lang('debit_card') ?></option>
                                    <option value="<?= lang('electronic_transfer') ?>"><?= lang('electronic_transfer') ?></option>
                                    <option value="<?= lang('online_payment') ?>"><?= lang('online_payment') ?></option>
                                </select>
                            </div>


                        <div class="form-group">
                            <label><?= lang('ref') ?>#</label>
                            <input type="text" name="ref" class="form-control">
                            <p class="help-block"><?= lang('trans_help') ?></p>
                        </div>

                        <div class="form-group">
                            <label><?= lang('description') ?><span class="required" aria-required="true">*</span></label>
                            <input type="text" name="description" class="form-control">
                        </div>

                        <p class="text-muted"><span class="required" aria-required="true">*</span> <?= lang('required_field') ?></p>



                    </div>

                </div>
                <!-- /.box-body -->

                <div class="box-footer">
                    <button id="saveSalary" type="submit" class="btn bg-navy btn-flat"><?= lang('save_transaction') ?></button>
                </div>




            </div>
            <!-- /.box -->
            </form>

        </div>
    </div>
</div>

<script>
    var select = '<?= lang('please_select') ?>'
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