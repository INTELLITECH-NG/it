
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
    <h4 class="modal-title" id="myModalLabel"><?= $title ?></h4>
</div>

<div class="modal-body">

    <?php  echo form_open('admin/sales/cancelOrder', $attribute= array('id' => 'cancel_order')); ?>

        <div class="form-group">
            <label for="exampleInputEmail1">Cancel Note<span
                    class="required">*</span></label>
            <textarea name="cancel_note" class="form-control"></textarea>
        </div>

        <input type="hidden" name="id" value="<?= $id ?>">
        <input type="hidden" name="type" value="<?= $type ?>">

        <div class="modal-footer" >

            <button type="button" id="close" class="btn btn-danger btn-flat pull-left" data-dismiss="modal">Close</button>
            <button type="submit" class="btn bg-olive btn-flat" id="btn" >Update</button>


        </div>
    <?php echo form_close()?>

</div>






