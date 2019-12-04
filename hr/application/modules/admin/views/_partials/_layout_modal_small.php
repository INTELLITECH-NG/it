<!-- Modal -->

<div class="modal fade modal-small" id="modalSmall"  role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >

    <div id="modalSmall" class="modal-dialog" >
        <div class="modal-content">

        </div>
    </div>

</div>

<script type="text/javascript">
    $('body').on('hidden.bs.modal', '.modal', function() {
        $(this).removeData('bs.modal');
    });


</script>



