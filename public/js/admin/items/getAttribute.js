$(document).ready(function() {
    $('.options').change(function (response) {
        var id = $(this).children("option:selected").val();
        var path = $(this).children('option:selected').attr('data-value');
        var lang = $(this).children('option:selected').attr('data-lang');
        $.ajax({
            type: "POST",
            url: path,
            data: {
                id: id,
                lang: lang,
            },
            success: function (e) {
                $('[class^="current"]').remove();

                $('.block').append(e.item);
            }
        });

    });

    $('.checkbox').on('change', function () {
            if($('.checkbox').is(':checked')) {
                $('#options').hide();
            }else{
                $('#options').show();
            }
    });

});
