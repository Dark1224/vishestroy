/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

// window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

// Vue.component('example-component', require('./components/ExampleComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

// const app = new Vue({
//     el: '#app',
// });

require('jquery-mask-plugin');
require('ion-rangeslider');

$(document).ready(function () {

    $('a.checkout').on('click', function(e){
        e.preventDefault();
        var location = $(this).attr('href');
        var cart = [];
        Promise.all( $.each($('.products .about_product .quantity input'), function(key, val){
                var elemrnt = {};
                elemrnt.id = $(this).attr('data-id');
                elemrnt.qty = $(this).val();
                cart.push(elemrnt);
            })
        ).then(function () {
            $.ajax({
                url: "/addProductsToSession",
                type: 'post',
                dataType: 'html',
                data: {'data': JSON.stringify(cart)},
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            }).done(function (res) {
                if($.parseJSON(res).success){
                    window.location = location;
                }
            })

        })
    })

    $('.to_delivery').on('click', function(){

        var location = '/delivery';
        var name = $('input[name="name"]').val();
        var surname = $('input[name="surname"]').val();
        var email = $('input[name="email"]').val();
        var tel = $('input[name="tel"]').val();
        var pay = $('input[name="pay"]').val();
        var elemrnt = {};
        if(name == '' || surname == '' || email == '' || tel == '' || pay == ''){
            $('.error').html(` 
        <div class="alert alert-danger" role="alert">
           Все поля должны быть заполненны
        </div>
    `);
            return;
        }
        elemrnt.name = name;
        elemrnt.surname = surname;
        elemrnt.email = email;
        elemrnt.tel = tel;
        elemrnt.pay = pay;
        var info = [elemrnt];
        $.ajax({
            url: "/addInfoToSession",
            type: 'post',
            dataType: 'html',
            data: {'data': JSON.stringify(info)},
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        }).done(function (res) {
            if($.parseJSON(res).success){
                window.location = location;
            }
        })

    })

    if ($('#map_container').length > 0) {
        ymaps.ready(() => {
            var myMap = new ymaps.Map("map_container", {
                center: [55.76, 37.64],
                zoom: 9
            });

            var data = ymaps.geoXml.load("https://gig-stroy.ru/map.kml");

            // Обработка полученного асинхронно ответа.
            data.then(function (res) {
                // Добавление объектов на карту.
                myMap.geoObjects.add(res.geoObjects);
            });

            // var suggestView = new ymaps.SuggestView('suggest', {
            //     offset: [10, 10]
            // });
            suggestView.events.add('select', function (e) {
                myMap.geoObjects.removeAll()
                var myGeocoder = ymaps.geocode(e.get('item').value, {results: 1});
                myGeocoder.then(function (res) {
                    myMap.geoObjects.add(res.geoObjects);
                    myMap.setCenter(res.geoObjects.get(0).geometry.getCoordinates(), 10);
                    data.then(function (res) {
                        // Добавление объектов на карту.
                        myMap.geoObjects.add(res.geoObjects);
                    });
                });

            })
            // suggestView.state.events.add('change', function () {
            //     var activeIndex = suggestView.state.get('activeIndex');
            //     if (typeof activeIndex == 'number') {
            //         var activeItem = suggestView.state.get('items')[activeIndex];
            //         if (activeItem && activeItem.value != $('#suggest').val()) {
            //             $('#suggest').val(activeItem.value);
            //             console.log($('#suggest').val())
            //         }
            //     }
            // });
        })
        // moscow_map.addOverlay(polygon);
    }


    var faindLocation = () => {
        var location = $('input#locality').val();
        var street = $('input#street').val();
        var house = $('input#house').val();
        var corps = $('input#corps').val();
        var apartment = $('input#apartment').val();
        var loc_str = location
    }
    $('article').css({
        'pointer-events': 'all'
    });
    if($('.select2').length > 0){
        $('.select2').select2();
    }
    $('.phone').mask('+0 (000) 000 00 00', {
        placeholder: "+_ (___) ___ __ __"
    });
    $(".js-range-slider").ionRangeSlider({
        type: "double",
        skin: "round",
        min: 0,
        max: 10000,
        onStart: function onStart(data) {
            $('input[name="my_range"]').show();
        },
        onFinish: function onFinish(data) {
            $vals = Array();
            $price = $('input[name="my_range"]').val().split(';');
            Promise.all($.each($('input.manufacturer'), function () {
                if ($(this).is(":checked")) {
                    $vals.push($(this).val());
                }
            })).then(function () {
                filter($price[0], $price[1], $vals);
            });
        }
    });

    function getIDfromURL() {
        //Grab the path from your URL. In your case /writers/1/books/
        path = window.location.pathname; //Break the path into segments

        segments = path.split("/"); //Return the segment that has the ID

        return segments[segments.length - 1];
    }

    function filter(min_price, max_price, manufacturer) {
        $('.product_types').html(' ');
        var html = '';
        console.log(getIDfromURL());
        $.ajax({
            url: "/filter",
            type: 'post',
            dataType: 'html',
            data: {
                'min_price': min_price,
                'max_price': max_price,
                'manufacturer': manufacturer,
                'category_id': getIDfromURL()
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        }).done(function (res) {
            res = $.parseJSON(res);
            console.log(res);
            $.each(res[0], function (key, val) {
                html = '';
                html = "\n                        <div class=\"product_card col\">\n                                <i title=\"\u0414\u043E\u0431\u0430\u0432\u0438\u0442\u044C \u0432 \u0438\u0437\u0431\u0440\u0430\u043D\u043D\u043E\u0435\" class=\"pc_add_to_favorites far fa-heart\" data-id=\"".concat(val.id, "\"></i>\n                                <i title=\"\u0414\u043E\u0431\u0430\u0432\u0438\u0442\u044C \u0432 \u0441\u0440\u0430\u0432\u043D\u0435\u043D\u0438\u0435\" class=\"pc_add_to_comparison fas fa-sync-alt\" data-id=\"").concat(val.id, "\"></i>\n                                <i title=\"\u0411\u044B\u0441\u0442\u0440\u044B\u0439 \u043F\u0440\u043E\u0441\u043C\u043E\u0442\u0440\" class=\"pc_quick-view far fa-plus-square\" data-id=\"").concat(val.id, "\"></i>\n                                <span class=\"pc_vendor_code\">\u0410\u0440\u0442\u0438\u043A\u0443\u043B:<span class=\"pc_vc\">").concat(val.article.replace(/['"]+/g, ''), "</span></span>\n                                <div class=\"types\">");

                if (val.bestseller) {
                    html += "<div class=\"pc_hit\">\u0425\u0438\u0442 \u043F\u0440\u043E\u0434\u0430\u0436!</div>";
                }

                if (val.sel_lout) {
                    html += "<div class=\"pc_sale\">\u0420\u0430\u0441\u043F\u0440\u043E\u0434\u0430\u0436\u0430!</div>";
                }

                if (val["new"]) {
                    html += "<div class=\"pc_new\">\u041D\u043E\u0432\u0438\u043D\u043A\u0430!</div>";
                }

                html += "</div>\n                                <a href=\"/product/".concat(val.id, "\"><img class=\"product_card_img\" title=\"").concat(val.name, "\" src=\"").concat($.parseJSON(val.img_path)[0], "\" alt=\"\"></a>\n                                <div class=\"card_body\">\n                                    <a href=\"/product/").concat(val.id, "\"><h5 title=\"").concat(val.name, "\">").concat(val.name, "</h5></a>\n                                    <hr>\n                                    <p class=\"pc_delivery\"><i class=\"pc_delivery_icon fas fa-truck-moving\"></i>\u0414\u043E\u0441\u0442\u0430\u0432\u043A\u0430: <span class=\"pc_delivery_tod_tom\">").concat(val.delivery, "</span></p>\n                                    <p class=\"pc_pickup\"><i class=\"pc_pickup_icon fas fa-map-marker-alt\"></i>\u0421\u0430\u043C\u043E\u0432\u044B\u0432\u043E\u0437: <a class=\"pc_pickup_link\" href=\"#\" title=\"\u0421\u0430\u043C\u043E\u0432\u044B\u0432\u043E\u0437\"><span class=\"pc_pickup_tod_tom\">").concat(val.pickup, "</span></a></p>\n                                    <div class=\"pc_price_block\">\n                                        <div class=\"pc_piece_price\">");

                if (val.old_price != 0) {
                    html += "<del class=\"pc_old_price\">".concat(val.old_price, "<span class=\"pc_price_currency\">\u0440.</span></del>");
                }

                html += " <span class=\"pc_price\">".concat(val.price, "\n                                                <span class=\"pc_price_currency\">\u0440.</span>\n                                            </span>\n                                            <span class=\"pc_piece\">/ ").concat(res[1][val.unit], ".</span>\n                                        </div>\n                                    </div>\n                                    <div class=\"pc_add_to_cart_btn\" title=\"\u0414\u043E\u0431\u0430\u0432\u0438\u0442\u044C \u0432 \u043A\u043E\u0440\u0437\u0438\u043D\u0443\">\n                                        <span class=\"add_to_cart\" data-id=\" ").concat(val.id, "\"></i>\u0412 \u043A\u043E\u0440\u0437\u0438\u043D\u0443</span>\n                                        <div class=\"pc_quantity_block\">\n                                            <input class=\"pc_quantity_number\" type=\"number\" disabled=\"disabled\" data-value=\"").concat(val.in_package, "\" value=\"").concat(val.in_package, "\" size=\"9999\">\n                                            <div class=\"quantity_arrows\">\n                                                <span class=\"pc_quantity_arrow_plus\" title=\"\u0423\u0432\u0435\u043B\u0438\u0447\u0438\u0442\u044C\">\u25B2</span>\n                                                <span class=\"pc_quantity_arrow_minus\" title=\"\u0423\u043C\u0435\u043D\u044C\u0448\u0438\u0442\u044C\">\u25BC</span>\n                                            </div>\n                                        </div>\n                                    </div>\n                                </div>\n                            </div>");
                $('.product_types').prepend(html);
            });
        });
    }

    $('#dashboard_config').on('submit', function (e) {
        e.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            type: 'POST',
            url: '/saveConfig',
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function success(data) {
                console.log("success");
                console.log(data.error);

                if (data.error) {
                    var html = "<div class=\"alert alert-danger\" role=\"alert\">\n                                   ".concat(data.error, "\n                                </div>");
                    $('form nav').append(html);
                }
            },
            error: function error(data) {
                console.log("error");
                console.log(data);
            }
        });
    });
    $(document).on('change', 'input.manufacturer', function () {
        $vals = Array();
        $price = $('input[name="my_range"]').val().split(';');
        Promise.all($.each($('input.manufacturer'), function () {
            if ($(this).is(":checked")) {
                $vals.push($(this).val());
            }
        })).then(function () {
            filter($price[0], $price[1], $vals);
        });
    });
    $.ajax({
        url: "/getAllFromCache",
        type: 'get',
        dataType: 'html',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    }).done(function (res) {
        $.each($.parseJSON(res).comparison, function (key, val) {
            if (val !== null) {
                $(".qv_add_to_comparision[data-id=\"".concat(val.id, "\"]")).addClass('active');
                $(".pc_add_to_comparison[data-id=\"".concat(val.id, "\"]")).addClass('active');
                $(".pp_add_to_comparision[data-id=\"".concat(val.id, "\"]")).addClass('active');
            }
        });
        $.each($.parseJSON(res).wishlist, function (key, val) {
            if (val !== null) {
                $(".qv_add_to_favorites[data-id=\"".concat(val.id, "\"]")).addClass('active');
                $(".pc_add_to_favorites[data-id=\"".concat(val.id, "\"]")).addClass('active');
                $(".pp_add_to_favorites[data-id=\"".concat(val.id, "\"]")).addClass('active');
            }
        });
        var total_qty = 0;
        var total_summ = 0;
        Promise.all($.parseJSON(res).cart.map(function (val) {
            if (val.product.price !== null) {
                total_qty += parseInt(val.qty);
                total_summ += val.product.price * val.qty;
                return [total_qty, total_summ];
            }
        })).then(function (results) {
            $('#number_of_products').html(total_qty);
            $('#th_total_amount').html(total_summ);
        });
    }).fail(function () {
        console.log("error");
    }).always(function () {});
    $(document).on('click', '.add_info', function () {
        var id = $('.additional_section .form-row').length;
        id += 1;
        var html = "<div class=\"form-row mt-3 align-items-center\">\n                        <div class=\"col\">\n                        <input type=\"text\" class=\"form-control\" placeholder=\"Description\" name=\"additional_info[".concat(id, "][desc]\">\n                        </div>\n                        <div class=\"col\">\n                        <input type=\"text\" class=\"form-control\" placeholder=\"Value\" name=\"additional_info[").concat(id, "][val]\">\n                        </div>\n                        <span class=\"remove_info\"> X </span>\n                      </div>");
        $('.additional_section').append(html);
    });
    $(document).on('click', '.remove_info', function () {
        $(this).parent().remove();
    }); // $(document).on('click', '.add_image', function(){
    //     let id = $('.image_section .form-group').length;
    //     id += 1;
    //     let html =  '<div class="form-group">'  +
    //         ' <label for="image">Product Image</label>' +
    //         ' <input type="file" class="form-control-file" id="image" name="image['+id+']">' +
    //         ' <span class="remove_image"> X </span>'+
    //         '</div>';
    //     $('.image_section').append(html);
    //
    // });

    $(document).on('click', '.remove_image', function () {
        $(this).parent().remove();
    });
    $(document).on('click', '.add_video', function () {
        var id = $('.video_section .form-group').length;
        id += 1;
        var html = ' <div class="form-group">' + '    <label for="category_video">Product Video</label>' + '    <input type="text" class="form-control-file" name="video[' + id + ']">' + '    <span class="remove_video"> X </span>' + '  </div>';
        $('.video_section').append(html);
    });
    $(document).on('click', '.remove_video', function () {
        $(this).parent().remove();
    });
    $(document).on('click', '.delete_image', function(){
        var image_name = $(this).parent().parent().children('img').attr('src');
        var el = $(this);


        if( confirm('Удалить иоброжение ?')){
            $.ajax({
                url: '/admin/removeImage',
                type: 'POST',
                dataType: 'html',
                data: {'name': image_name},
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            }).done(function (res) {
                res = $.parseJSON(res);
                if(res.success){
                    $(el).parent().parent().remove();
                }
            }).fail(function () {
                console.log("error");
            }).always(function () {});
        }


    })
    var addImages = function addImages(el) {
        var html = `<div class="img_block">
                    <div class="image_options"><i class="float-right delete_image fas fa-times" style="color: red;"></i></div>
                    <img class="choose_this" src="/${el}" alt="">
                </div>`;
        $('.pop_up_image_section').append(html);
    };

    var addFolder = function addFolder(el) {
        var html = "<div class=\"img_block choose_folder\" data-src=\"".concat(el, "\"><p>").concat(el, "</p><img src=\"/img/folder.png\" alt=\"\"></div>");
        $('.pop_up_image_section').prepend(html);
    };

    $(document).on('click', '.add_image', function () {
        $('.bd-example-modal-xl').modal('show');
        $.ajax({
            url: '/admin/getAllImages',
            type: 'GET',
            dataType: 'html',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        }).done(function (res) {
            Promise.all($.parseJSON(res).images.map(addImages)).then(function (results) {
                // Promise.all($.parseJSON(res).directory.map().then(function (results) {});
            });
        }).fail(function () {
            console.log("error");
        }).always(function () {});
    });
    $('#imageUploadForm').on('submit', function (e) {
        e.preventDefault();
        var formData = new FormData(this);
        console.log(formData);
        $.ajax({
            type: 'POST',
            url: $(this).attr('action'),
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function success(data) {
                console.log("success");
                console.log(data);
                var html = `<div class="img_block">
                        <div class="image_options"><i class="float-right delete_image fas fa-times" style="color: red;"></i></div>
                        <img class="choose_this" src="/${data}" alt="">
                    </div>`;

                $('.pop_up_image_section').append(html);
                $("#imageUploadForm").val(' ').change();
            },
            error: function error(data) {
                console.log("error");
                console.log(data);
            }
        });
    });
    $(document).on('click', '.upload_image', function () {
        $("#ImageBrowse").click();
    });
    $("#ImageBrowse").on("change", function () {
        if ($(this).val() !== '') {
            $("#imageUploadForm").submit();
        }
    });
    $(document).on('click', '.choose_this', function () {
        var id = $('.image_section .img_block').length + 1;
        if($(this).children('img').attr('src')){
            var image_path = $(this).children('img').attr('src');
        }else{
            var image_path = $(this).attr('src');
        }
        $('.image_section').prepend("<div class=\"img_block remove\">\n                                <img src=\"".concat(image_path, "\" alt=\"\">\n                                <input type=\"hidden\" value=\"").concat(image_path, "\" name=\"image[").concat(id, "]\">\n                            </div>"));
        $('.bd-example-modal-xl').modal('hide');
    });
    $('.bd-example-modal-xl').on('hide.bs.modal', function (e) {
        $('.pop_up_image_section').html(' ');
    });
    $(document).on('click', '.img_block.remove', function () {
        $(this).remove();
    });
    $(document).on('dblclick', '.choose_folder', function () {
        var directory = $(this).attr('data-src');
        $.ajax({
            url: '/admin/getAllImages',
            type: 'GET',
            dataType: 'html',
            data: {
                'directory': directory
            }
        }).done(function (res) {
            $('.pop_up_image_section').html(' ');
            Promise.all($.parseJSON(res).images.map(addImages)).then(function (results) {
                Promise.all($.parseJSON(res).directory.map(addFolder)).then(function (results) {});
            });
        }).fail(function () {
            console.log("error");
        }).always(function () {});
    });
});
$(document).ready(function () {
    $(window).scroll(function () {
        if ($(this).scrollTop() < 30) {
            $('.top_header').css({
                'width': 'initial',
                'position': 'relative',
                'background': 'linear-gradient(#333, #000)',
                'box-shadow': '0 0 5px 2px rgba(0,0,0,.8)',
                'z-index': 1,
                'align-items': 'center'
            });
            $('.top_header_logo').css({
                'display': 'none'
            });
        } else if ($(this).scrollTop() > 150 && parseInt($(window).width()) > 991) {
            $('.top_header').css({
                'width': '100%',
                'position': 'fixed',
                'background': 'linear-gradient(#333, #000)',
                'box-shadow': '0 0 5px 2px rgba(0,0,0,.8)',
                'z-index': 100
            });
            $('.top_header_logo').css({
                'display': 'block'
            });
        }
    });
    $(document).on('click', '.pc_quantity_arrow_minus', function () {
        var quantityRes = parseInt($(this).parent().parent().children('.pc_quantity_number').val()) - parseInt($(this).parent().parent().children('.pc_quantity_number').attr('data-value'));

        if (quantityRes <= parseInt($(this).parent().parent().children('.pc_quantity_number').attr('data-value'))) {
            $(this).parent().parent().children('.pc_quantity_number').val(parseInt($(this).parent().parent().children('.pc_quantity_number').attr('data-value')));
        } else {
            $(this).parent().parent().children('.pc_quantity_number').val(quantityRes);
        }
    });
    $(document).on('click', '.pc_quantity_arrow_plus', function () {
        var quantityRes = parseInt($(this).parent().parent().children('.pc_quantity_number').val()) + parseInt($(this).parent().parent().children('.pc_quantity_number').attr('data-value'));
        $(this).parent().parent().children('.pc_quantity_number').val(quantityRes);
    });
    $(document).on('click', '.quantity_arrow_minus', function () {
        var quantityRes = parseInt($(this).parent().children('.quantity_number').val()) - parseInt($(this).parent().children('.quantity_number').attr('data-value'));

        if (quantityRes <= parseInt($(this).parent().children('.quantity_number').attr('data-value'))) {
            $(this).parent().children('.quantity_number').val(parseInt($(this).parent().children('.quantity_number').attr('data-value')));
        } else {
            $(this).parent().children('.quantity_number').val(quantityRes);
        }
    });

    $(document).on('click', '.quantity_arrow_plus', function () {
        var quantityRes = parseInt($(this).parent().children('.quantity_number').val()) + parseInt($(this).parent().children('.quantity_number').attr('data-value'));
        $(this).parent().children('.quantity_number').val(quantityRes);
    });
    $(document).on('click', '.pc_quick-view', function () {
        var product_id = $(this).attr('data-id');
        $('.quick_view_content').html(' ');
        $.ajax({
            url: '/get_product/' + product_id,
            type: 'GET',
            dataType: 'html',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        }).done(function (res) {
            var data = $.parseJSON(res);
            var manufacturer = data.manufacturer;
            var available = data.available;
            var unit = data.unit;
            var in_package = data.in_package;
            var article = data.article;
            var name = data.name;
            var img_path = $.parseJSON(data.img_path);
            var bestseller = data.bestseller;
            var old_price = data.old_price;
            var price = data.price;
            var delivery = data.delivery;
            var pickup = data.pickup;
            var new_product = data["new"];
            var sel_lout = data.sel_lout;
            var additional = $.parseJSON(data.additional);
            var html = "<div class=\"quick_view_popup_close_btn_block\">\n                                <i title=\"\u0417\u0430\u043A\u0440\u044B\u0442\u044C\" class=\"quick_view_popup_close_btn fas fa-times\"></i>\n                            </div>\n                            <div class=\"quick_view_block_1 col-12\">\n                                <span title=\"\u0414\u043E\u0431\u0430\u0432\u0438\u0442\u044C \u0432 \u0438\u0437\u0431\u0440\u0430\u043D\u043D\u043E\u0435\" class=\"qv_add_to_favorites dont_rm\">\u0412 \u0438\u0437\u0431\u0440\u0430\u043D\u043D\u043E\u0435<i class=\"qv_add_to_favorites_icon dont_rm far fa-heart\"></i></span>\n                                <span title=\"\u0414\u043E\u0431\u0430\u0432\u0438\u0442\u044C \u0432 \u0441\u0440\u0430\u0432\u043D\u0435\u043D\u0438\u0435\" class=\"qv_add_to_comparision dont_rm\">\u0412 \u0441\u0440\u0430\u0432\u043D\u0435\u043D\u0438\u0435<i class=\"qv_add_to_comparison_icon dont_rm fas fa-sync-alt\"></i></span>\n                                <span class=\"qv_vendor_code\">\n                        <span class=\"qv_w_vendor_code\">\u0410\u0440\u0442\u0438\u043A\u0443\u043B:</span>\n                        <span class=\"qv_vc\">".concat(article.replace(/['"]+/g, ''), "</span>\n                        </span>\n                                <h5 class=\"qv_product_name\">").concat(name, "</h5>\n                            </div>\n                            <div class=\"quick_view_block_2 col-12\">\n                            <div class=\"pp_types\">\n                                ").concat(bestseller === 1 ? ' <div class="pc_hit">Хит продаж!</div>' : '', "\n                                ").concat(sel_lout === 1 ? ' <div class="pc_sale">Распродажа!</div>' : '', "\n                                ").concat(new_product === 1 ? ' <div class="pc_new">Новинка!</div>' : '', "\n                            </div>  \n                                <div class=\"qv_big_img_block\">\n                                    <img src=\"").concat(img_path[0], "\">\n                                </div>\n                                <div class=\"qv_mini_img_block\">\n                                    ");
            $.each(img_path, function (key, val) {
                html += "<div class=\"qv_mini_img img_1\"><img src=\"".concat(val, "\" alt=\"\" title=\"\"></div>");
            });
            html += "\n                                </div>\n                            </div>\n                            <div class=\"quick_view_block_3 col-12\">\n                                <div class=\"short_description_block\">\n                                    <ul>\n                                        <li><span class=\"des_a des_a_1\">\u041F\u0440\u043E\u0438\u0437\u0432\u043E\u0434\u0438\u0442\u0435\u043B\u044C</span><span class=\"des_q des_q_1\">".concat(manufacturer, "</span></li>\n                                        <li><span class=\"des_a des_a_2\">\u0415\u0441\u0442\u044C \u0432 \u043D\u0430\u043B\u0438\u0447\u0438\u0438 ?</span><span class=\"des_q des_q_2\">").concat(available === 1 ? 'да' : 'нет', "</span></li>\n                                        <li><span class=\"des_a des_a_4\">\u0415\u0434. \u0438\u0437\u043C\u0435\u0440\u0435\u043D\u0438\u044F</span><span class=\"des_q des_q_3\">").concat(unit, ".</span></li>\n                                        <li><span class=\"des_a des_a_3\">\u0412 \u0443\u043F\u0430\u043A\u043E\u0432\u043A\u0435, \u0448\u0442.</span><span class=\"des_q des_q_4\">").concat(in_package, "</span></li>\n                                        ");
            $.each(additional, function (key, val) {
                html += "\n                                                <li><span class=\"des_a des_a_5\">".concat(val.desc, "</span><span class=\"des_q des_q_5\">").concat(val.val, "</span></li>\n                                                ");
            });
            html += " </ul>\n                                </div>\n                                <div class=\"pp_buy_card\">\n                                    <div class=\"pp_deliveri_pickup_container\">\n                                        <div class=\"pp_delivery\"><i class=\"pp_delivery_icon fas fa-truck-moving\"></i>\u0414\u043E\u0441\u0442\u0430\u0432\u043A\u0430: <span class=\"pp_delivery_tod_tom\">".concat(delivery, "</span></div>\n                                        <div class=\"pp_pickup\"><i class=\"pp_pickup_icon fas fa-map-marker-alt\"></i>\u0421\u0430\u043C\u043E\u0432\u044B\u0432\u043E\u0437: <a class=\"pp_pickup_link\" href=\"#\" title=\"\u0421\u0430\u043C\u043E\u0432\u044B\u0432\u043E\u0437\"><span class=\"pp_pickup_tod_tom\">").concat(pickup, "</span></a></div>\n                                    </div>\n                                    <div class=\"pp_price_block\">\n                                        <div class=\"pp_piece_price\">");

            if (old_price != 0) {
                html += "<del class=\"pp_old_price\">".concat(old_price, "<span class=\"pp_price_currency\">\u0440.</span></del>");
            }

            html += "<span class=\"pp_price\">".concat(price, "<span class=\"pp_price_currency\">\u0440.</span></span><span class=\"pp_piece\">/ ").concat(unit, ".</span></div>\n                        \n                                        <div class=\"pp_package_price\">");

            if (old_price != 0) {
                html += " <del class=\"pp_old_package_price\">".concat(old_price * in_package, "<span class=\"pp_package_price_currency\">\u0440.</span>");
            }

            html += "</del> <span class=\"pp_package_price\">".concat(price * in_package, "<span class=\"pp_price_currency\">\u0440.</span></span><span class=\"pp_package\">/ \u0443\u043F.</span></div>\n                                    </div>\n                                    <div class=\"quantity_block\">\n                                        <span class=\"quantity_arrow_minus\"><i class=\"fas fa-minus\"></i></span>\n                                        <input class=\"quantity_number\" type=\"number\" data-value=\"").concat(in_package, "\" value=\"").concat(in_package, "\" size=\"9999\">\n                                        <span class=\"quantity_arrow_plus\"><i class=\"fas fa-plus\"></i></span>\n                                    </div>\n                                    <div class=\"add_to_cart_block\">\n                                        <div class=\"pp_add-to-cart_btn\" title=\"\u0414\u043E\u0431\u0430\u0432\u0438\u0442\u044C \u0432 \u043A\u043E\u0440\u0437\u0438\u043D\u0443\">\u0412 \u043A\u043E\u0440\u0437\u0438\u043D\u0443</div>\n                                    </div>\n                                </div>\n                            </div>");
            $('.quick_view_content').append(html);
        }).fail(function () {
            console.log("error");
        }).always(function () {});
        $('.quick_view_popup_block').css({
            'display': 'block'
        });
        $('body').css({
            'overflow': 'hidden'
        });
    });
    $(document).on('click', '.quick_view_popup_block', function (e) {
        if (!$('.quick_view_content').is(e.target) && $('.quick_view_content').has(e.target).length === 0) {
            $('.quick_view_popup_block').css({
                'display': 'none'
            });
            $('body').css({
                'overflow': 'auto'
            });
        }
    });
    $(document).on('click', '.quick_view_popup_close_btn', function () {
        $('.quick_view_popup_block').css({
            'display': 'none'
        });
        $('body').css({
            'overflow': 'auto'
        });
    });

    function qo_total() {
        var price = parseInt($('.qo_price').html());
        var qty = $('.qo_quantity_block .quantity_number').val();
        var total = price * parseInt(qty);
        $('.qo_summ').html(total + '<span class="qo_summ_currency">р.</span>');
    }

    $(document).on('click', '.quantity_arrow_minus, .quantity_arrow_plus', function () {
        qo_total();
    });
    $(document).on('click', '.pp_quick_order_btn', function () {
        var product_id = $(this).attr('data-id');
        $('.quick_order_popup_block').html(' ');
        $.ajax({
            url: '/get_product/' + product_id,
            type: 'GET',
            dataType: 'html',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        }).done(function (res) {
            console.log($.parseJSON(res));
            var data = $.parseJSON(res);
            var manufacturer = data.manufacturer;
            var available = data.available;
            var unit = data.unit;
            var in_package = data.in_package;
            var article = data.article.replace(/['"]+/g, '');
            var name = data.name;
            var img_path = $.parseJSON(data.img_path);
            var bestseller = data.bestseller;
            var old_price = data.old_price;
            var price = data.price;
            var delivery = data.delivery;
            var pickup = data.pickup;
            var new_product = data["new"];
            var sel_lout = data.sel_lout;
            var additional = $.parseJSON(data.additional);
            var html = "<div class=\"row\">\n            <div class=\"quick_order_content col-12 col-sm-7 col-md-7\">\n                <form action=\"\">\n                    <div class=\"quick_order_popup_close_btn_block\">\n                        <i title=\"\u0417\u0430\u043A\u0440\u044B\u0442\u044C\" class=\"quick_order_popup_close_btn fas fa-times\"></i>\n                    </div>\n                    <div class=\"qo_top\">\n                        <div class=\"quick_order_block_1 col-12\">\n                            <div class=\"qo_b1_1\">\n                                <h5>".concat(name, "</h5>\n                            </div>\n                        </div>\n                        <div class=\"quick_order_block_2 col-12\">\n                            <div class=\"row\">\n                                <div class=\"qo_b2_1 col-6\">\n                                    <img src=\"").concat(img_path[0], "\">\n                                </div>\n                                <div class=\"qo_b2_2 col-6\">\n                                    <span class=\"qo_vendor_code\">\n                                    <span class=\"qo_w_vendor_code\">\u0410\u0440\u0442\u0438\u043A\u0443\u043B:</span>\n                                    <span class=\"qo_vc\">").concat(article, "</span>\n                                    </span>\n                                    <span>\u041A\u043E\u043B.\u0432\u043E</span>\n                                    <div class=\"qo_quantity_block\">\n                                        <span class=\"quantity_arrow_minus\"><i class=\"fas fa-minus\"></i></span>\n                                        <input class=\"quantity_number\" type=\"number\" disabled=\"disabled\" data-value=\"").concat(in_package, "\" value=\"").concat(in_package, "\" size=\"9999\">\n                                        <span class=\"quantity_arrow_plus\"><i class=\"fas fa-plus\"></i></span>\n                                    </div>\n                                </div>\n                            </div>\n                        </div>\n                    </div>\n                    <div class=\"qo_bottom\">\n                        <div class=\"quick_order_block_3 col-12\">\n                            <div class=\"row\">\n                                <div class=\"qo_b3_1 col-6\">\n                                    <span>\u0426\u0435\u043D\u0430</span>\n                                    <div class=\"qo_piece_price\">");

            if (old_price != 0) {
                html += "<del class=\"qo_old_price\">".concat(old_price, "<span class=\"qo_price_currency\">\u0440.</span></del>");
            }

            html += " <span class=\"qo_price\">".concat(price, "<span class=\"qo_price_currency\">\u0440.</span></span><span class=\"qo_piece\">/ ").concat(unit, ".</span></div>\n\n                                    <div class=\"qo_package_price\">");

            if (old_price != 0) {
                html += "<del class=\"qo_old_package_price\">".concat(old_price * in_package, "<span class=\"qo_package_price_currency\">\u0440.</span></del>");
            }

            html += "<span class=\"qo_package_price\">".concat(price * in_package, "<span class=\"qo_price_currency\">\u0440.</span></span><span class=\"qo_package\">/ \u0443\u043F.</span></div>\n                                </div>\n                                <div class=\"qo_b3_1 col-6\">\n                                    <span>\u0421\u0442\u043E\u0438\u043C\u043E\u0441\u0442\u044C</span>\n                                    <div class=\"qo_summ\">").concat(price * in_package, "<span class=\"qo_summ_currency\">\u0440.</span></div>\n                                </div>\n                            </div>\n                        </div>\n                        <div class=\"quick_order_block_4 form-row\">\n                            <div class=\"qo_b4_1 col-6\">\n                                <label for=\"qo_name\">\u0418\u043C\u044F <span class=\"input_required\">*</span></label>\n                                <input type=\"name\" name=\"name\" id=\"qo_name\">\n                            </div>\n                            <div class=\"qo_b4_2 col-6\">\n                                <label for=\"qo_tel\">\u0422\u0435\u043B\u0435\u0444\u043E\u043D <span class=\"input_required\">*</span></label>\n                                <input type=\"text\" name=\"tel\" class=\"phone\" id=\"qo_tel\">\n                                \n                            </div>\n                            <div class=\"qo_b4_3 col-12\">\n                                <button class=\"qo_nt_button\">\u041E\u0442\u043F\u0440\u0430\u0432\u0438\u0442\u044C \u0437\u0430\u043A\u0430\u0437</button>\n                                <div class=\"qo_form_info\">\n                                    <p>\u041D\u0430\u0436\u0438\u043C\u0430\u044F \u043A\u043D\u043E\u043F\u043A\u0443 \xAB\u041E\u0442\u043F\u0440\u0430\u0432\u0438\u0442\u044C \u0437\u0430\u043A\u0430\u0437\xBB, \u044F \u0441\u043E\u0433\u043B\u0430\u0448\u0430\u044E\u0441\u044C \u043D\u0430 \u043F\u043E\u043B\u0443\u0447\u0435\u043D\u0438\u0435 \u0438\u043D\u0444\u043E\u0440\u043C\u0430\u0446\u0438\u0438 \u043E\u0442 \u0438\u043D\u0442\u0435\u0440\u043D\u0435\u0442-\u043C\u0430\u0433\u0430\u0437\u0438\u043D\u0430 \u0438 \u0443\u0432\u0435\u0434\u043E\u043C\u043B\u0435\u043D\u0438\u0439 \u043E \u0441\u043E\u0441\u0442\u043E\u044F\u043D\u0438\u0438 \u043C\u043E\u0438\u0445 \u0437\u0430\u043A\u0430\u0437\u043E\u0432, \u0430 \u0442\u0430\u043A\u0436\u0435 \u043F\u0440\u0438\u043D\u0438\u043C\u0430\u044E \u0443\u0441\u043B\u043E\u0432\u0438\u044F <a href=\"privacy_policy\">\u043F\u043E\u043B\u0438\u0442\u0438\u043A\u0438 \u043A\u043E\u043D\u0444\u0438\u0434\u0435\u043D\u0446\u0438\u0430\u043B\u044C\u043D\u043E\u0441\u0442\u0438</a> \u0438 <a href=\"terms_of_use\">\u043F\u043E\u043B\u044C\u0437\u043E\u0432\u0430\u0442\u0435\u043B\u044C\u0441\u043A\u043E\u0433\u043E \u0441\u043E\u0433\u043B\u0430\u0448\u0435\u043D\u0438\u044F</a>.</p>\n                                </div>\n                            </div>\n                        </div>\n                    </div>\n                </form>\n            </div>\n        </div>");
            $('.quick_order_popup_block').append(html);
            setTimeout(function () {}, 500);
            $('.phone').mask('+7 (000) 000 00 00', {
                placeholder: "+7 (903) 233 03 07"
            });
        }).fail(function () {
            console.log("error");
        }).always(function () {});
        $('.quick_order_popup_block').css({
            'display': 'block'
        });
        $('body').css({
            'overflow': 'hidden'
        });
    });
    $(document).on('click', '.quick_order_popup_close_btn', function () {
        $('.quick_order_popup_block').css({
            'display': 'none'
        });
        $('body').css({
            'overflow': 'auto'
        });
    });
    $(document).on('click', '.quick_order_popup_block', function (e) {
        if (!$('.quick_order_content').is(e.target) && $('.quick_order_content').has(e.target).length === 0) {
            $('.quick_order_popup_block').css({
                'display': 'none'
            });
            $('body').css({
                'overflow': 'auto'
            });
        }
    });
    $('.tile').on('mouseover', function () {
        $(this).children('.photo').css({
            'transform': 'scale(' + $(this).attr('data-scale') + ')'
        });
    }).on('mouseout', function () {
        $(this).children('.photo').css({
            'transform': 'scale(1)'
        });
    }).on('mousemove', function (e) {
        $(this).children('.photo').css({
            'transform-origin': (e.pageX - $(this).offset().left) / $(this).width() * 100 + '% ' + (e.pageY - $(this).offset().top) / $(this).height() * 100 + '%'
        });
    }) // cart page
        .each(function () {
            $(this).append('<div class="photo"></div>').children('.photo').css({
                'background-image': 'url(' + $(this).attr('data-image') + ')'
            });
        });
    $(document).on('click', '.mini_img_block .mini_img', function () {
        var img_path = $(this).children('img').attr('src');
        $('.tile').attr('data-image', img_path);
        $('.tile').children('.photo').css({
            'background-image': 'url(' + img_path + ')'
        });
    });
    $(document).on('click', '.remove_basket', function () {
        var product_id = 'all';
        $('.products .col-xl-8 .row').remove();
        $.ajax({
            url: "/removeFromCart",
            type: 'get',
            dataType: 'html',
            data: {
                'product': product_id
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        }).done(function (res) {
            $('.products').children('div').children('.justify-content-around').html(' ');
            $('#number_of_products').html('0');
            $('#th_total_amount').html('0');
            totals();
        }).fail(function () {
            console.log("error");
        }).always(function () {});
    });
    $(document).on('click', '.remove_one_product', function () {
        $(this).parent().parent().parent('.about_product').remove();
        var product_id = $(this).attr('data-id');
        totals();
        $.ajax({
            url: "/removeFromCart",
            type: 'get',
            dataType: 'html',
            data: {
                'product': product_id
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        }).done(function (res) {// res = $.parseJSON(res);
            // console.log(res);
            // $('#number_of_products').html(parseInt($('#number_of_products').html()) - parseInt(res.qty));
            // $('#th_total_amount').html(parseInt($('#th_total_amount').html()) - parseInt(res.qty) * parseInt(res.price));
        }).fail(function () {
            console.log("error");
        }).always(function () {});
    });
    $(document).on('click', '.remove_one_product_whishlist', function () {
        $(this).parent().parent().parent('.about_product').remove();
        var product_id = $(this).attr('data-id');
        totals();
        $.ajax({
            url: "/removeFromWishlist",
            type: 'get',
            dataType: 'html',
            data: {
                'product': product_id
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        }).done(function (res) {
            console.log(res);
        }).fail(function () {
            console.log("error");
        }).always(function () {});
    });
    $(document).on('click', '.quantity .fa-plus', function () {
        var count = '';
        var qty = parseInt($(this).parent().children('input').attr('data-value'));

        if ($(this).parent().children('input').val() == '') {
            count = qty;
            $(this).parent().children('input').val(count);
        } else {
            var val = $(this).parent().children('input').val();
            count = parseInt(val) + qty;
            $(this).parent().children('input').val(count);
        }

        var price = $(this).parent().parent().parent().children().children().children('.price_one_product').html();
        var value = $(this).parent().children('input').val();
        var total = price * value;
        $(this).parent().parent().parent().children().children().children('.total_one_product').html(total);
        totals();
    });
    $(document).on('click', '.quantity .fa-minus', function () {
        var count = 0;
        var qty = parseInt($(this).parent().children('input').attr('data-value'));

        if ($(this).parent().children('input').val() <= qty) {
            count = qty;
            $(this).parent().children('input').val(count);
        } else {
            var val = $(this).parent().children('input').val();
            count = parseInt(val) - qty;
            $(this).parent().children('input').val(count);
        }

        var price = $(this).parent().parent().parent().children().children().children('.price_one_product').html();
        var value = $(this).parent().children('input').val();
        var total = price * value;
        $(this).parent().parent().parent().children().children().children('.total_one_product').html(total);
        totals();
    });
    $(document).on('keyup', '.quantity input', function () {
        var val = $(this).val();
        var price_one_product = $(this).parent().parent().parent().children().children().children('.price_one_product').html();
        var result = val * price_one_product;
        $(this).parent().parent().parent().children().children().children('.total_one_product').html(result);
        totals();
    });

    function totals() {
        var total_qty = 0;
        var total = 0;
        $.when($.each($('.quantity'), function (key, val) {
            total_qty += parseInt($(this).children('input').val());
            total += parseInt($(this).parent().parent().children().children().children('.total_one_product').html());
        })).then(function () {
            $('.amaount').html(total_qty);
            $('.mobile_cart_product_number').html(total_qty);
            $('.total').html(total);
            $('#number_of_products').html(total_qty);
            $('#th_total_amount').html(total);
            if(total == 0){
                $('.checkout_button').html('<button disabled class="form-control checkout">Оформить заказ</button>')
            }
        });
    } // mobile


    $(document).on('click', '.header_search_mobile', function () {
        $('.mobile_search_block').toggle();
    });
    $(window).resize(function () {
        if ($(window).width() > 968) {
            $('.mobile_search_block').css({
                'display': 'none'
            });
            $('.mobile_categories_block').css({
                'display': 'none'
            });
        }

        ;
    });
    $(document).on('click', '.mobile-category_hamburger', function () {
        $('.mobile_categories_block').toggle();
    });
    $(document).on('click', '.pc_add_to_favorites, .pp_add_to_favorites, .qv_add_to_favorites', function () {
        var _this = this;

        var product_id = $(this).attr('data-id');

        if (!$(this).hasClass('active')) {
            console.log(1);
            $.ajax({
                url: "/addToWhishList",
                type: 'get',
                dataType: 'html',
                data: {
                    'product': product_id
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            }).done(function (res) {
                $(_this).addClass('active');
            }).fail(function () {
                console.log("error");
            }).always(function () {});
        } else {
            $.ajax({
                url: "/removeFromWishlist",
                type: 'get',
                dataType: 'html',
                data: {
                    'product': product_id
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            }).done(function (res) {
                if (!$(_this).hasClass('dont_rm')) {
                    $($(_this).parent().parent().remove());
                } else {
                    $(_this).removeClass('active');
                }
            }).fail(function () {
                console.log("error");
            }).always(function () {});
        }
    });
    $(document).on('click', '.qv_mini_img', function () {
        var src = $(this).children('img').attr('src');
        console.log(src);
        $(this).parent().parent().children('.qv_big_img_block').children('img').attr('src', src);
    });
    $(document).on('click', '.pc_add_to_cart_btn>span, .pp_add_to_cart_btn, .pp_add-to-cart_btn', function () {
        var qty = 0;

        if ($(this).parent().parent().children('.quantity_block').children('.quantity_number').val()) {
            qty = $(this).parent().parent().children('.quantity_block').children('.quantity_number').val();
        } else if ($(this).parent().children('.pc_quantity_block').children('.pc_quantity_number').val()) {
            qty = $(this).parent().children('.pc_quantity_block').children('.pc_quantity_number').val();
        }

        var product_id = $(this).attr('data-id');
        $.ajax({
            url: "/addToCart",
            type: 'get',
            dataType: 'html',
            data: {
                'product': product_id,
                'qty': qty
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        }).done(function (res) {
            console.log(res);
            $('#number_of_products').html(parseFloat($('#number_of_products').html()) + parseFloat(qty));
            $('.mobile_cart_product_number').html(parseInt($('.mobile_cart_product_number').html()) + parseFloat(qty));
            $('#th_total_amount').html(parseFloat($('#th_total_amount').html()) + parseFloat(qty) * parseFloat(res));
        }).fail(function () {
            console.log("error");
        }).always(function () {});
    });
    $(document).on('click', '.comparision_close_btn', function () {
        var _this2 = this;

        var product_id = $(this).parent().attr('data-id');
        $.ajax({
            url: "/removeFromComparison",
            type: 'get',
            dataType: 'html',
            data: {
                'product': product_id
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        }).done(function (res) {
            $($(_this2).parent().parent().remove());
        }).fail(function () {
            console.log("error");
        }).always(function () {});
    });
    $(document).on('click', '.pc_add_to_comparison, .pp_add_to_comparison, .pp_add_to_comparision, .qv_add_to_comparision', function () {
        var _this3 = this;

        var product_id = $(this).attr('data-id');

        if (!$(this).hasClass('active')) {
            $.ajax({
                url: "/addToComparison",
                type: 'get',
                dataType: 'html',
                data: {
                    'product': product_id
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            }).done(function (res) {
                $(_this3).addClass('active');
            }).fail(function () {
                console.log("error");
            }).always(function () {});
        } else {
            $.ajax({
                url: "/removeFromComparison",
                type: 'get',
                dataType: 'html',
                data: {
                    'product': product_id
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            }).done(function (res) {
                if ($(_this3).hasClass('qv_add_to_comparision') && !$(_this3).hasClass('dont_rm')) {
                    $(_this3).parent().parent().remove();
                } else {
                    $(_this3).removeClass('active');
                }
            }).fail(function () {
                console.log("error");
            }).always(function () {});
        }
    });
    $(document).on('mousemove', '.rating>span>i', function () {
        $(".rating>span>i").removeClass('fa').addClass('far').css({
            'color': 'inherit'
        });
        var rate = $(this).attr('data-id');

        for (var i = 1; i <= rate; i++) {
            $(".rating>span>i[data-id=\"".concat(i, "\"]")).removeClass('far').addClass('fa').css({
                'color': '#f18701'
            });
        }
    });
    $(document).on('mouseout', '.rating>span>i', function () {
        var rate = $(this).parent().attr('data-rate');
        $(".rating>span>i").removeClass('fa').addClass('far').css({
            'color': 'inherit'
        });

        for (var i = 1; i <= rate; i++) {
            $(".rating>span>i[data-id=\"".concat(i, "\"]")).removeClass('far').addClass('fa').css({
                'color': '#f18701'
            });
        }
    });
    $(document).on('click', '.rating>span>i', function () {
        var rate = $(this).attr('data-id');
        $('input[name="rate"]').val(rate);
        $(this).parent().attr('data-rate', rate);

        for (var i = 1; i <= rate; i++) {
            $(".rating>span>i[data-id=\"".concat(i, "\"]")).removeClass('far').addClass('fa').css({
                'color': '#f18701'
            });
        } // $.ajax({
        //     url: `/addRate`,
        //     type: 'get',
        //     dataType: 'html',
        //     data: {'id': product_id, 'rate': rate},
        //     headers: {
        //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //     }
        // })
        //     .done((res) => {
        //         for (let i = 1; i <= res; i++){
        //             $(`.rating>span>i[data-id="${i}"]`).removeClass('far').addClass('fa').css({'color': '#f18701'})
        //         }
        //     })
        //     .fail(function() {
        //
        //     })
        //     .always(function() {
        //
        //     });

    });
    $(document).on('click', '.leave_review_btn', function () {
        var rate = $('input[name="rate"]').val();
        var review = $('textarea[name="review"]').val();
        var product_id = $(this).attr('data-id');

        if (rate == null || rate == '') {
            $('.rate_error').html('Оценка обязательна');
        }

        $('strong').html(' ');
        $.ajax({
            url: "/addReview",
            type: 'get',
            dataType: 'html',
            data: {
                'rate': rate,
                'review': review,
                'product_id': product_id
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        }).done(function (res) {
            res = $.parseJSON(res);

            if (res.success) {
                var html = "\n                                 <div class=\"new_review row align-items-center\">\n                                     <div class=\"review_l col-md-3 col-sm-4\">\n                                         <div class=\"user_name\">".concat(res.success.name, " ").concat(res.success.last_name, "</div>\n                                         <div class=\"rate\">");

                for (var i = 1; i <= 5; i++) {
                    html += "<i class=\" ".concat(i <= rate ? 'fa' : 'far', " fa-star\" style=\"").concat(i <= rate ? 'color: #f18701' : '', "\" data-id=\"").concat(i, "\"></i>");
                }

                html += "</div>\n                                         <div class=\"review_date\">".concat(res.date, "</div>\n                                         <div class=\"avatar_container\"><img id=\"user_avatar\" src=\"").concat(res.success.avatar, "\"></div>\n                                     </div>\n                                     <div class=\"review_r col-md-9 col-sm-8\">\n                                         <p class=\"user_review\">").concat(review, "</p>\n                                     </div>\n                                 </div>\n                    ");
                $('.comments_section').prepend(html);
            } else {
                $.each(res.errors, function (key, val) {
                    $("strong.".concat(key)).html(val);
                });
            }
        }).fail(function () {}).always(function () {});
    });
    $("#searchForAdmin").on("keyup", function () {
        var value = $(this).val().toLowerCase();
        $("#productTable tr").filter(function () {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
        });
    });
    $(document).on('input', 'input[name="header_search"]', function () {
        if ($(this).val() !== '') {
            $.ajax({
                url: "/searchProduct",
                type: 'get',
                dataType: 'html',
                data: {
                    'name': $(this).val()
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            }).done(function (res) {
                $('.search_section').css({
                    'display': 'block'
                });
                $('.search_section ul').html(' ');
                $.each($.parseJSON(res), function (key, val) {
                    $('.search_section ul').append("<li><a href=\"/product/".concat(val.id, "\">").concat(val.name, "</a></li>"));
                });
            }).fail(function () {}).always(function () {});
        } else {
            $('.search_section').css({
                'display': 'none'
            });
            $('.search_section ul').html(' ');
        }
    });
    $(document).on('blur', 'input[name="header_search"]', function () {
        setTimeout(function () {
            $('.search_section').css({
                'display': 'none'
            });
            $('.search_section ul').html(' ');
        }, 300);
    });
    $(document).on('click', '.choose_avatar', function () {
        $('.bd-example-modal-xl').modal('show');
    });
    $(document).on('click', '.modal_image_block', function () {
        var src = $(this).children('img').attr('src');
        $('input[name="image"]').val(src).change();
        $('.bd-example-modal-xl').modal('hide');
    });
    $(document).on('change', 'input[name="image"]', function () {
        var src = $(this).val();
        $('.choose_avatar').html("<img src=\"".concat(src, "\">"));
    });
    $(document).on('click', '.filed_name', function () {
        var id = $(this).attr('data-id');
        $("input[name=\"field\"]").val(id);
        $.ajax({
            url: "/admin/fields",
            type: 'post',
            dataType: 'html',
            data: {
                'type': 'get',
                'id': id
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        }).done(function (res) {
            console.log($.parseJSON(res));
            $("ul[data-id=\"".concat(id, "\"]")).html(' ');
            res = $.parseJSON(res);
            $.each(res, function (key, val) {
                $("ul[data-id=\"".concat(id, "\"]")).prepend("<li><b class=\"text\">".concat(val.name, "</b> <span class=\"edit_value\"><i class=\"far fa-edit\"  data-toggle=\"modal\" data-target=\"#edit\" data-id=\"").concat(val.id, "\"></i></span> <span class=\"remove_value\"><i class=\"fas fa-times\" data-id=\"").concat(val.id, "\"></i></span></li>"));
            });
        }).fail(function () {}).always(function () {});
    });
    $(document).on('click', '.submit_value', function () {
        var id = $("input[name=\"field\"]").val();
        var value = $("input[name=\"value\"]").val();
        $.ajax({
            url: "/admin/fields",
            type: 'post',
            dataType: 'html',
            data: {
                'type': 'add',
                'id': id,
                'val': value
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        }).done(function (res) {
            $("ul[data-id=\"".concat(id, "\"]")).prepend("<li><b class=\"text\">".concat(value, "</b> <span class=\"edit_value\"><i class=\"far fa-edit\"  data-toggle=\"modal\" data-target=\"#edit\" data-id=\"").concat(res, "\"></i></span> <span class=\"remove_value\"><i class=\"fas fa-times\" data-id=\"").concat(res, "\"></i></span></li>"));
            $('#edit').modal('hide');
        }).fail(function () {}).always(function () {});
    });
    $(document).on('click', '.edit_value', function () {
        var value = $(this).parent().children('.text').html();
        var id = $(this).children().attr('data-id');
        $('input[name="edit_value"]').val(value);
        $('input[name="value_id"]').val(id);
    });
    $(document).on('click', '.submit_edit', function () {
        var value = $('input[name="edit_value"]').val();
        var id = $('input[name="value_id"]').val();
        $.ajax({
            url: "/admin/fields",
            type: 'post',
            dataType: 'html',
            data: {
                'type': 'update',
                'id': id,
                'val': value
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        }).done(function (res) {
            $('.edit_value i[data-id="' + id + '"]').parent().parent().children('.text').html(value);
            $('#edit').modal('hide');
        }).fail(function () {}).always(function () {});
    });
    $(document).on('click', '.remove_value', function () {
        var id = $(this).children().attr('data-id');
        $(this).parent().remove();
        $.ajax({
            url: "/admin/fields",
            type: 'post',
            dataType: 'html',
            data: {
                'type': 'remove',
                'id': id
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        }).done(function (res) {}).fail(function () {}).always(function () {});
    });
});
