
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
    <h4 class="modal-title" id="myModalLabel"><?= lang('send_email') ?></h4>
</div>

<div class="modal-body">


    <form id="addPayment" action="<?php echo site_url('admin/purchase/sendEmail')?>" method="post" onsubmit="return get_Cookie('csrf_cookie_name')" enctype="multipart/form-data">

        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" id="token">

        <div class="form-group">
            <input id="toEmail" class="form-control" placeholder="To:" name="to" value="<?php if(!empty($vendor->email)) echo $vendor->email ?>" onfocusout="toEmailValidator()">
            <p class="help-block" style="color: red" id="el"></p>
            <p class="help-block"><?= lang('use_comma(,)_for_multiple_email') ?> </p>
        </div>

        <div class="form-group">
            <input class="form-control" placeholder="Subject:" name="subject" value="<?php echo $file_name ?>">
        </div>

        <div class="form-group">
            <textarea id="compose-textarea" name="msg" class="form-control" style="height: 300px">
                Dear <?php echo $vendor->name ?>,</br>

                Please find out the purchase Invoice, attach with this email.</br>

            </br>
            </br>
            </br>

                Thanks
                </br>
                <?php echo $this->ion_auth->user()->row()->first_name.' '.$this->ion_auth->user()->row()->last_name?>


            </textarea>
        </div>

        <div class="form-group">
            <p class="help-block"><strong><?= lang('attachment') ?>: </strong><?php echo $file_name ?></p>
        </div>

        <input type="hidden" name="filepath" value="<?php echo $file_path ?>">
        <input type="hidden" name="id" value="<?php echo $order->id ?>">

        <div class="modal-footer" >

            <button type="button" id="close" class="btn btn-danger btn-flat pull-left" data-dismiss="modal"><?= lang('close') ?></button>
            <button type="submit" class="btn bg-olive btn-flat" id="btn" ><?= lang('send_invoice') ?></button>


        </div>
    </form>

</div>



<script language="JavaScript">

    $('#modalSmall').on('hidden.bs.modal', function () {
        location.reload();
    });

     $("#compose-textarea").wysihtml5();


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



    $('body').on('hidden.bs.modal', '.modal', function () {
        $(this).removeData('bs.modal');
    });

    function toEmailValidator(trim = true) {

        var emailList = $('#toEmail').val();
        var email_split = emailList.split(',');

        var valid = true;
        for (var n = 0; n < email_split.length; n++) {
            var email_info = trim ? email_split[n].trim() : email_split[n];
            var validRegExp = /^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z0-9]+$/;

            if (email_info.search(validRegExp) === -1) {
                valid = false;
                break;
            }
        }
        if (!valid) {
            document.getElementById("el").innerHTML = "<?= lang('email_addresses_are_not_valid.') ?><br/>";
            $('#btn').prop('disabled', true);
        }else {
            document.getElementById("el").innerHTML = "";
            $('#btn').prop('disabled', false);
        }
            //$('#el').val('Email addresses are Not valid.');
    }


</script>

