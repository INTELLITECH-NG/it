
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
    <h4 class="modal-title" id="myModalLabel"><?= lang('view_payment') ?></h4>
</div>

<div class="modal-body">


    <?php if(!empty($payment)){ ?>
        <table class="table table-bordered">
            <thead>
            <tr class="active">
                <th><?= lang('date') ?></th>
                <th><?= lang('payment_ref') ?>.</th>
                <th><?= lang('payment_method') ?></th>
                <th><?= lang('amount') ?></th>
                <th><?= lang('actions') ?></th>
            </tr>
            </thead>

            <tbody>
            <?php foreach ($payment as $item){ ?>
                <tr>
                    <td><?php dateFormat($item->payment_date) ?></td>
                    <td><?php echo $item->order_ref ?></td>
                    <td><?php echo $item->payment_method ?></td>
                    <td>
                        <?php echo currency($item->amount) ?>
                        <?php if($item->attachment){ ?>
                        <a href="sales/downloadPaymentReceipt/<?php echo $item->attachment ?>"><i class="fa fa-link" aria-hidden="true"></i></a>
                        <?php } ?>
                    </td>
                    <td>
                        <a href="sales/viewPayment/<?= $item->id ?>" class="Button" data-target="#modalSmall" data-toggle="modal" data-dismiss="modal"><i class="fa fa-file-text-o" aria-hidden="true"></i></a>
                        <a href="sales/editPayment/<?= $item->id ?>" class="Button" data-target="#modalSmall" data-toggle="modal" data-dismiss="modal"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                        <a href="sales/deletePayment/<?= $item->id ?>" class="Button danger" onClick="return confirm('Are you sure you want to delete?')"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                    </td>
                </tr>
            <?php }?>

            </tbody>
        </table>
    <?php } ?>

</div>

<style>
    #modalSmall .modal-dialog
    {
        width: 50% !important;
    }
</style>

<script>
//    $('#myModal').on('hidden.bs.modal', function () {
//        location.reload();
//    });

    $('body').on('hidden.bs.modal', '.modal', function () {
        $(this).removeData('bs.modal');
    });
</script>
