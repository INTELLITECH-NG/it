
<div class="row">
    <div class="col-md-12">
        <!-- general form elements -->
        <div class="box box-primary">
            <div class="box-header with-border bg-primary-dark">
                <h3 class="box-title"><?= lang('search_transaction') ?></h3>
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


                               <?php echo form_open('admin/transaction/searchTransactions') ?>

                               <div class="col-md-11">

                                   <div class="col-md-3 col-sm-6 col-xs-12">
                                       <div class="form-group form-group-bottom">
                                           <label><?= lang('start_date') ?></label>

                                           <div class="input-group">
                                               <input type="text" class="form-control" id="datepicker" name="start_date" data-date-format="yyyy/mm/dd" value="<?php if(!empty($search['start_date'])) echo $search['start_date'] ?>">
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
                                               <input type="text" class="form-control" id="datepicker-1" name="end_date" data-date-format="yyyy/mm/dd" value="<?php if(!empty($search['end_date'])) echo $search['end_date'] ?>">
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
                                                   <option value="<?php echo $item->id ?>" <?php if(!empty($search['account_id'])) echo $search['account_id'] == $item->id ? 'selected':'' ?>>
                                                       <?php echo $item->account_title ?>
                                                   </option>
                                               <?php } ?>
                                           </select>
                                       </div>
                                   </div>



                                   <div class="col-md-2 col-sm-6 col-xs-12">
                                       <div class="form-group">
                                           <label><?= lang('transaction_type') ?></label>
                                           <select class="form-control select2" name="transaction_type" >
                                               <option value=""><?= lang('please_select') ?>...</option>
                                               <option value="1" <?php if(!empty($search['transaction_type'])) echo $search['transaction_type'] == 1 ? 'selected':'' ?>><?= lang('deposit') ?></option>
                                               <option value="2" <?php if(!empty($search['transaction_type'])) echo $search['transaction_type'] == 2 ? 'selected':'' ?>><?= lang('expense') ?></option>
                                               <option value="5" <?php if(!empty($search['transaction_type'])) echo $search['transaction_type'] == 5 ? 'selected':'' ?>><?= lang('transfer') ?></option>
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
                                <?php echo form_close() ?>





                           </div>


                       </div>

                        <table class="table table-striped table-bordered display-all" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>Trns ID</th>
                                <th>Account</th>
                                <th>Type</th>
                                <th>Category</th>
                                <th>Dr.</th>
                                <th>Cr.</th>
                                <th>Balance</th>
                                <th>Date</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if(!empty($transactions)): foreach($transactions as $item){ ?>
                                <tr>
                                    <td><?php echo $item->transaction_id ?></td>
                                    <td><?php echo $item->account_title ?></td>
                                    <td><?php echo $item->transaction_type ?></td>
                                    <td><?php echo $item->name ?></td>
                                    <td>
                                        <?php
                                        if($item->transaction_type_id == 1 || $item->transaction_type_id == 4){
                                            echo '<span class="dr">'.$this->localization->currencyFormat($item->amount).'</span>';
                                        }else{
                                            echo '<span class="dr">'.$this->localization->currencyFormat(0).'</span>';
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        if($item->transaction_type_id == 2 || $item->transaction_type_id == 3 || $item->transaction_type_id == 5 ){
                                            echo '<span class="cr">'.$this->localization->currencyFormat($item->amount).'</span>';
                                        }else{
                                            echo '<span class="cr">'.$this->localization->currencyFormat(0).'</span>';
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <?php echo '<span class="balance">'.$this->localization->currencyFormat($item->balance).'</span>'; ?>
                                    </td>
                                    <td><?php echo $this->localization->dateFormat($item->date_time); ?></td>
                                </tr>
                            <?php }; endif?>
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




