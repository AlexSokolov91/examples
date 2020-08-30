$(document).ready(function () {

   var lang = $('.lang').val();
    var langKey = $('.lang').attr('data-value');
   var t = $('.repeater').find('.lang_repeater');
   t.val(lang);
    var path = 'http://estore-alx.badvps.com/admin/sets/get-product';

    $.ajax({
        type: "POST",
        url: path,
        data: {
            lang: langKey,
        },
        success: function (e) {

            $('.repeater').find('.select_for_product').empty();
            $('.repeater').find('.select_for_product').append(e.item);
        }
    });

    $(document).on('change', '.select_for_product', function () {
        var getPricePath = 'http://estore-alx.badvps.com/admin/sets/get-price';
        var id = $(this).find('option:selected').val();
        var name = $(this).find('option:selected').text();
        var parent = $(this).parents('.product_list');
        var langKey = $('.lang').attr('data-value');

        $.ajax({
            type:"POST",
            url: getPricePath,
            data: {
                id:id,
                lang: langKey,
            },
            success: function(i){
                parent.find('.price').val(i.price);

            }
        });
    });

   $(document).on('click', '#button', function () {
       var lang = $('.lang').val();
       var langKey = $('.lang').attr('data-value');
       var t = $('.repeater').find('.lang_repeater');
       t.val(lang);
       var path = 'http://estore-alx.badvps.com/admin/sets/get-product';

       $.ajax({
           type: "POST",
           url: path,
           data: {
               lang: langKey,
           },
           success: function (e) {
            $('.select_for_product').last().empty();
            $('.select_for_product').last().append(e.item);

      }
     });
   });
   $(document).on('click', '#delete', function () {
       let id = $(this).attr('data-value');
       let action = 'http://estore-alx.badvps.com/admin/sets/delete-product';
       $('.product_list' +id).remove();

       $.ajax({
           type: "POST",
           url: action,
           data: {id: id},
       });
       Swal.fire({
           position: 'top-end',
           icon: 'success',
           title: 'successfully deleted!',
           showConfirmButton: false,
           timer: 1500
       });

   });
});
