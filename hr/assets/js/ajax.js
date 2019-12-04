/**
 * Created by Codes Lab on 7/14/2016.
 */


//*******************************************************
//*********************Get Base URL**********************
//*******************************************************

function getBaseURL() {
    return baseUrl = $('body').data('baseurl');
};

//*******************************************************
//*********************Get CSRF TOKEN********************
//*******************************************************

function getCookie(name) {
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
    return cookieValue;
}



//*********************************************
//           Mail start
//*********************************************

function changeStatus(str) {

    console.log(str.id);
    var id = str.id;
    var postUrl     = getBaseURL() + 'admin/mail/change_status';
    var csrftoken = getCookie('csrf_cookie_name');

    // now upload the file using $.ajax
    $.ajax({
        url: postUrl,
        type: "POST",
        data: { id : id, 'csrf_test_name': csrftoken },
        cache: false,
        success: function(response) {
            console.log(response);
            var list        = 'admin/mail/inboxList';
            reload_table();
        }
    });

}

function changeStatusMail(str) {

    console.log(str.id);
    var id = str.id;
    var postUrl     = getBaseURL() + 'employee/mail/change_status';
    var csrftoken = getCookie('csrf_cookie_name');

    // now upload the file using $.ajax
    $.ajax({
        url: postUrl,
        type: "POST",
        data: { id : id, 'csrf_test_name': csrftoken },
        cache: false,
        success: function(response) {
            console.log(response);
            var list        = 'admin/mail/inboxList';
            reload_table();
        }
    });

}


//*******************************************************
//*******************************************************
//          modal CURD                                  *
//          @add *call modal                            *
//          @table * ajax data table load               *
//          @save *save modal data                      *
//          @delete item *delete row                    *
//          @reload table *call data table ajax         *
//          @alert *alert msg display                   *
//*******************************************************
//*******************************************************


function add()
{
    save_method = 'add';
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string
    $('#modal_form').modal('show'); // show bootstrap modal
}



$(document).ready(function() {

    table = $('#table').DataTable({
        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-
        "datatable-buttons": true,

        "order": [], //Initial no order.

        // Load data for the table's content from an Ajax source
        "ajax": {
            url: getBaseURL() + list,
            type: "POST",
            data: function(d) {
                d.csrf_test_name = getCookie('csrf_cookie_name');
            },
        },

        //Set column definition initialisation properties.
        "columnDefs": [
            {
                "targets": [ -1 ], //last column
                "orderable": false, //set not orderable
            },
        ],

    });



    //datepicker
    $('#datepicker').datepicker({
        autoclose: true,
        format: "yyyy-mm-dd",
        todayHighlight: true,
        orientation: "top auto",
        todayBtn: true,
        todayHighlight: true,
    });



    //set input/textarea/select event when change value, remove class error and remove text help block
    $("input").change(function(){
        $(this).parent().parent().removeClass('has-error');
        $(this).next().empty();
    });
    $("textarea").change(function(){
        $(this).parent().parent().removeClass('has-error');
        $(this).next().empty();
    });
    $("select").change(function(){
        $(this).parent().parent().removeClass('has-error');
        $(this).next().empty();
    });

});


function save()
{
    $('#btnSave').text('saving...'); //change button text
    $('#btnSave').attr('disabled',true); //set button disable
    var url;

    if(save_method == 'add') {
        url = saveRow;
    } else {
        url = edit;
    }

    // ajax adding data to database
    var input = $("<input>")
        .attr("type", "hidden")
        .attr("name", "csrf_test_name").val( getCookie('csrf_cookie_name'));
    $('#form').append($(input));
    $.ajax({
        url : getBaseURL() + url,
        type: "POST",
        data: $('#form').serialize(),
        dataType: "JSON",
        success: function(data)
        {

            if(data.status) //if success close modal and reload ajax table
            {
                $('#modal_form').modal('hide');
                reload_table();
                alert('success',saveSuccess);

            }
            else
            {
                for (var i = 0; i < data.inputerror.length; i++)
                {
                    $('[name="'+data.inputerror[i]+'"]').parent().parent().addClass('has-error'); //select parent twice to select div form-group class and add has-error class
                    $('[name="'+data.inputerror[i]+'"]').next().text(data.error_string[i]); //select span help-block class set text error string
                }
            }
            $('#btnSave').text('save'); //change button text
            $('#btnSave').attr('disabled',false); //set button enable


        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error adding / update data');
            $('#btnSave').text('save'); //change button text
            $('#btnSave').attr('disabled',false); //set button enable

        }
    });
}

function deleteItem(id)
{
    if(confirm('Are you sure delete this data?'))
    {
        // ajax delete data to database
        $.ajax({
            url : getBaseURL()+ deleteRow + id,
            type: "POST",
            data: {"csrf_test_name" : getCookie('csrf_cookie_name')},
            dataType: "JSON",
            success: function(data)
            {
                if(data){
                    alert('success',deleteSuccess);
                }else{
                    alert('danger',deleteError);
                }
                //if success reload ajax table
                $('#modal_form').modal('hide');
                reload_table();
                //alert('danger',deleteSuccess);
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error deleting data');
            }
        });

    }
}

function reload_table()
{
    table.ajax.reload(null,false); //reload datatable ajax

}

function alert(type, msg)
{
    $("#msg").html('<div class="alert alert-'+type+'"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>'+ msg +'</div>');
    window.setTimeout(function() {
        $(".alert").fadeTo(500, 0).slideUp(500, function(){
            $(this).remove();
        });
    }, 5000);

}

