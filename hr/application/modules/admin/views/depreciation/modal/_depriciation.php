
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
    <h4 class="modal-title" id="myModalLabel">Depreciation</h4>
</div>

<div class="modal-body">


    <?php if(!empty($depreciation)){ ?>
        <table class="table table-bordered">
            <thead>
            <tr class="active">
                <th>Year</th>
                <th>Beginning Book Value</th>
                <th>Depreciable Cost</th>
                <th>Rate%</th>
                <th>Expenses</th>
                <th>Accumulated</th>
                <th>Ending Book Value</th>
            </tr>
            </thead>

            <tbody>
            <?php foreach ($depreciation as $key=> $item){ ?>

                <tr>
                    <td><?= $item['year'] ?></td>
                    <td><?= $item['beginning_value'] ?></td>
                    <td><?= $item['depreciate_cost'] ?></td>
                    <td><?= $item['depreciate_rate'] ?></td>
                    <td><?= $item['depreciation_expense'] ?></td>
                    <td><?= $item['accumulated'] ?></td>
                    <td><?= $item['ending_value'] ?></td>

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
