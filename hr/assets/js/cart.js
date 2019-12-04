
    //*********************************************
    //           Get Base URL
    //*********************************************

    function getBaseURL() {
        return link = jQuery('body').data('baseurl');

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


    //*************************PURCHASE CART******************************
    //*******************Cart Ajax Start from here************************
    //********************************************************************

    function pur_product_id(str) {
        var rowid = str.id;
        var productID = str.value;
        var link = getBaseURL();
        var postUrl     = getBaseURL() + 'admin/purchase/add_to_cart';
        var csrftoken = getCookie('csrf_cookie_name');
        loader();
        $.ajax({
            url: postUrl,
            type: "POST",
            data: {
                product_id : productID,
                rowid: rowid,
                status: status, 'csrf_test_name': csrftoken
            },
            cache: false,
            success: function(response) {
                //location.reload(); // then reload the page.(3)
                $.get(link + "admin/purchase/show_cart", function (cart) {
                    //alert(cart);
                    $('#cart_view').html(cart);
                    $('select').select2();
                });
                $('#overlay').remove();
            }
        });

    }

    function pur_updateItem(str) {
        var val = str.id;
        var rowid = val.slice(3);
        var type = val.slice(0,3);
        var o_val = str.value;

        var postUrl     = getBaseURL() + 'admin/purchase/update_cart_item';
        var csrftoken 	= getCookie('csrf_cookie_name');
        loader();
        $.ajax({
            url: postUrl,
            type: "POST",
            data: {
                rowid: rowid,
                type: type,
                o_val: o_val,
                status: status, 'csrf_test_name': csrftoken
            },
            cache: false,
            success: function(response) {
                $.get(link + "admin/purchase/show_cart", function (cart) {
                    $('#cart_view').html(cart);
                    $('select').select2();
                });
                $('#overlay').remove();
            }
        });
    }

    function pur_removeItem(str) {
        var rowid = str.id;
        var postUrl     = getBaseURL() + 'admin/purchase/remove_item';
        var csrftoken = getCookie('csrf_cookie_name');
        loader();
        $.ajax({
            url: postUrl,
            type: "POST",
            data: {
                rowid: rowid,
                status: status, 'csrf_test_name': csrftoken
            },
            cache: false,
            success: function(response) {
                //location.reload(); // then reload the page.(3)
                $.get(link + "admin/purchase/show_cart", function (cart) {
                    $('#cart_view').html(cart);
                    $('select').select2();
                });
                $('#overlay').remove();
            }
        });
    }

    function pur_order_discount(str) {
        var discount =  str.value;
        var postUrl     = getBaseURL() + 'admin/purchase/order_discount';
        var csrftoken = getCookie('csrf_cookie_name');
        loader();
        $.ajax({
            url: postUrl,
            type: "POST",
            data: {
                discount: discount,
                status: status, 'csrf_test_name': csrftoken
            },
            cache: false,
            success: function(response) {
                //location.reload(); // then reload the page.(3)
                $.get(link + "admin/purchase/show_cart", function (cart) {
                    $('#cart_view').html(cart);
                    $('select').select2();
                });
                $('#overlay').remove();
            }
        });
    }

    function pur_tax(str) {
        var tax =  str.value;
        var postUrl     = getBaseURL() + 'admin/purchase/order_tax';
        var csrftoken = getCookie('csrf_cookie_name');
        loader();
        $.ajax({
            url: postUrl,
            type: "POST",
            data: {
                tax: tax,
                status: status, 'csrf_test_name': csrftoken
            },
            cache: false,
            success: function(response) {
                //location.reload(); // then reload the page.(3)
                $.get(link + "admin/purchase/show_cart", function (cart) {
                    $('#cart_view').html(cart);
                    $('select').select2();
                });
                $('#overlay').remove();
            }
        });
    }

    function pur_shipping(str) {
        var shipping =  str.value;
        var postUrl     = getBaseURL() + 'admin/purchase/order_shipping';
        var csrftoken = getCookie('csrf_cookie_name');
        loader();
        $.ajax({
            url: postUrl,
            type: "POST",
            data: {
                shipping: shipping,
                status: status, 'csrf_test_name': csrftoken
            },
            cache: false,
            success: function(response) {
                //location.reload(); // then reload the page.(3)
                $.get(link + "admin/purchase/show_cart", function (cart) {
                    $('#cart_view').html(cart);
                    $('select').select2();
                });
                $('#overlay').remove();
            }
        });
    }

    function get_vendor(str) {
        var vendor_id = str.value;
        var postUrl     = getBaseURL() + 'admin/purchase/select_vendor_by_id';
        var csrftoken = getCookie('csrf_cookie_name');

        loader();
        $.ajax({
            url: postUrl,
            type: "POST",
            data: {
                vendor_id: vendor_id,
                status: status, 'csrf_test_name': csrftoken
            },
            cache: false,
            success: function(response) {
                var customer = $.parseJSON(response);
                $('[name="email"]').val(customer.email);
                $('[name="b_address"]').val(customer.b_address);
                $('[name="s_address"]').val(customer.s_address);
                $('#overlay').remove();
            }
        });
    }

    function loader() {
        var baseUrl = getBaseURL();
        var over = '<div id="overlay">' +
            '<img id="loading" src= "'+ baseUrl +'assets/img/balls.gif">' +
            '</div>';
        $(over).appendTo('body');
    }

    function getPurchaseProduct(str)
    {
        var purchaseProductId = str.value;

        var req = getXMLHTTP();
        if (req) {

            var link = getBaseURL();

            $.post(link + "admin/purchase/add_purchase_product", {
                    purchase_product_id: purchaseProductId,
                    ajax: '1'
                },
                function (data) {
                    if (data == 'true') {

                        $.get(link + "admin/purchase/show_purchase", function (cart) {
                            $("#cart_content").html(cart);
                        });

                    }

                });
            return false;


        }

    }

