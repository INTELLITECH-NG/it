//*********************************************
//    Employee Attendance
//*********************************************

$(document).ready(function() {

    $(':checkbox').on('change', function() {
        var th = $(this), id = th.prop('id');

        if (th.is(':checked')) {
            $(':checkbox[id="' + id + '"]').not($(this)).prop('checked', false);
        }
    });


    $('input.select_one').on('change', function() {
        $('input.select_one').not(this).prop('checked', false);
    });


    var parent_absent = $('input[id="parent_absent"]');
    var parent_present = $('input[id="parent_present"]');
    var child_present = $('input[class="child_present"]');

    var child_absent = $('input[class="child_absent"]');

    $('select[id="disable"]').prop('disabled', true);
    child_absent.click(function() {
        if (this.checked) {
            $('select[id="disable"]').prop('disabled', false);
        }
    });
    parent_absent.change(function() {
        if (this.checked) {
            child_present.prop('checked', false);
        }
    });
    parent_present.change(function() {
        if (this.checked) {
            child_absent.prop('checked', false);
        }
    });
    child_present.change(function() {
        parent_absent.prop($('input[class="child_present"]').length === 0);
    }).change();
    child_absent.change(function() {
        parent_present.prop($('input[class="child_absent"]').length === 0);
    }).change();

});