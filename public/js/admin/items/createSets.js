$(document).ready(function() {

    $(document).on('change', '.lang', function () {

        var id = $(this).find('#select_for_product');
        var parent = $(this).parents('.product_list');
        let lang = $(this).val();
        var fullLang = $('.lang').find(':selected').text();
        var findEmptyLang = $('.repeater').find('.lang');
        var id = $('.form').attr('data-value');
        findEmptyLang.val(fullLang);

        var path = 'http://estore-alx.badvps.com/admin/sets/get-product';

        $.ajax({
            type: "POST",
            url: path,
            data: {
                lang: lang,
                id:id,

            },
            success: function (e) {
                parent.find('.select_for_product').empty();
                parent.find('.select_for_product').append(e.item);
                $('.product').attr('name', 'firstProduct').first();

            if(e.success == true)
            {
                $.ajax({
                    type: "POST",
                    url: path,
                    data: {
                        lang: lang,

                    },
                    success:function (s) {


                        var l = $('.repeater').find('.select_for_product');
                        l.html(s.item);

                    }
                })
            }
            },


        });
    });
    $(document).on('change', '.select_for_product', function () {

        var getPricePath = 'http://estore-alx.badvps.com/admin/sets/get-price';
        var id = $(this).find('option:selected').val();
        var name = $(this).find('option:selected').text();
        var parent = $(this).parents('.product_list');
        var lang = $('.product_list').find('.lang').first().val();

        $.ajax({
           type:"POST",
           url: getPricePath,
           data: {
             id:id,
               lang: lang,
           },
            success: function(i){
              parent.find('.price').val(i.price);

            }
        });
    });

    $(document).on('click', '#button1', function () {
        var fullLang = $('.lang').find(':selected').text();
        var findEmptyLang = $('.repeater').find('.lang');
        findEmptyLang.val(fullLang);
        var products = $('.repeater').find('.select_for_product').first().clone();
        $('.product_list').find('.select_for_product').last().empty();
        var lastProduct = $('.select_for_product').last();
        lastProduct.append(products);
    });

    $(document).on('click', '#button', function () {
        var lang = $('.lang').find(':selected').val();
        var fullLang = $('.lang').find(':selected').text();

        var findRepeaterLang = $('.repeater').find('.lang');
        findRepeaterLang.val(fullLang);
        var path = 'http://estore-alx.badvps.com/admin/sets/get-product';

        $.ajax({
            type: "POST",
            url: path,
            data: {
                lang: lang,
            },
            success: function (e) {

            console.log(e);
                $('.select_for_product').last().empty();
                $('.select_for_product').last().append(e.item);

            }
        });
        });
});
