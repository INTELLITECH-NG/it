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



$(document).ready(function() {

        table = $('#table').DataTable({
            "processing": true, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-
            "datatable-buttons": true,
            "iDisplayLength": 25,
            dom: "Bfrtip",



            buttons: [{
                extend: "copy",
                className: "btn-sm"
            }, {
                extend: "csv",
                className: "btn-sm"
            }, {
                extend: "excel",
                className: "btn-sm"
            }, {
                extend: "pdf",
                orientation: 'landscape',
                className: "btn-sm"
            }, {
                extend: "print",
                orientation: 'landscape',
                className: "btn-sm"
            }],


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

    $('#min').keyup( function() { table.draw(); } );
    $('#max').keyup( function() { table.draw(); } );

});
