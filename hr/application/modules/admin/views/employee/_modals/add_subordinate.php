
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
    <h4 class="modal-title" id="myModalLabel"><?= lang('add_subordinate') ?></h4>
</div>

<div class="modal-body">


    <form id="addSubordinate" action="<?php echo site_url('admin/employee/save_subordinate')?>" method="post" onsubmit="return get_Cookie('csrf_cookie_name')">

        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" id="token">


        <div class="form-group">
            <label><?= lang('department') ?><span
                    class="required">*</span></label>
            <select class="form-control" name="department_id" id="department" onchange="get_employee(this.value)">
                <option value=""><?= lang('please_select') ?></option>
                <?php foreach($department as $item){ ?>
                    <option value="<?php echo $item->id ?>" <?php if(!empty($subordinate)) echo $subordinate->department_id == $item->id? 'selected':''  ?>>
                        <?php echo $item->department ?>
                    </option>
                <?php } ?>
            </select>
        </div>

    <div class="form-group">
        <label><?= lang('department') ?><span
                class="required">*</span></label>
        <select class="form-control" name="subordinate_id" id="employee" >
            <option value=""><?= lang('please_select') ?></option>
            <?php foreach($employee as $item){ ?>

                <?php
                if ($item->id == $id ) { // skip even members
                    continue;
                }
                ?>

                <option value="<?php echo $item->id ?>" <?php if(!empty($subordinate)) echo $subordinate->subordinate_id == $item->id? 'selected':''  ?>>
                    <?php echo  $item->first_name.' '.$item->last_name ?>
                </option>
            <?php } ?>

        </select>
    </div>




        <input type="hidden" name="id" id="employeeId" value="<?= $id ?>">
        <input type="hidden" name="subordinate"  value="<?php if(!empty($subordinate)) echo str_replace(array('+', '/', '='), array('-', '_', '~'), $this->encrypt->encode($subordinate->id)) ?>">

        <span class="required">*</span> <?= lang('required_field') ?>

        <div class="modal-footer" >

            <button type="button" id="close" class="btn btn-danger btn-flat pull-left" data-dismiss="modal">Close</button>
            <button type="submit" class="btn bg-olive btn-flat" id="btn" >Save</button>


        </div>
    </form>

</div>



<script>

    $('#modalSmall').on('hidden.bs.modal', function () {
        location.reload();
    });


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

    $("#btn").click(function ()  {

        $("#addSubordinate").validate({
            excluded: ':disabled',
            rules: {

                department_id: {
                    required: true
                },
                subordinate_id: {
                    required: true
                }



            },

            highlight: function(element) {
                $(element).closest('.form-group').addClass('has-error');
            },
            unhighlight: function(element) {
                $(element).closest('.form-group').removeClass('has-error');
            },
            errorElement: 'span',
            errorClass: 'help-block animated fadeInDown',
            errorPlacement: function(error, element) {
                if (element.parent('.input-group').length) {
                    error.insertAfter(element.parent());
                } else {
                    error.insertAfter(element);
                }
            }
        })
    });

    $('body').on('hidden.bs.modal', '.modal', function () {
        $(this).removeData('bs.modal');
    });


</script>



