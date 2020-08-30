$(document).ready(function () {
    $(document).on('change', '.form', function (v) {
        var value = $(this).val();
        var path = 'http://estore-alx.badvps.com/admin/form-generation/get-form-type';
        var parent = $(this).parents('.this');
        parent.find('.form-repeater').empty();
        parent.find('.accepted').empty();
        $.ajax({
            type: "POST",
            url: path,
            data: {
                value: value,
            },
            success: function (e) {
                if (e.success == true) {

                    parent.find('.form-repeater').append(e.render);
                    var name = parent.find('.forLabel').attr('name');
                    var replace = name.replace('label', 'option');
                    parent.find('.kt_repeater_1').find('.selectOption').find('input').attr('name', replace + '[]');

                }else{
                    $('.this').find('.accepted').last().append(e.render);
                }
            }
        });
    });
    $(document).on('click', '.add', function () {
        var input = $(this).parents('.kt_repeater_1').clone();
        input.find('input').val('');
        var parent = $(this).parents('.form-repeater').append(input);

    });
    $(document).on('click', '#delete', function (d) {
        var parent = $(this).parents('.kt_repeater_1');
        parent.remove();
    });

    $(document).on('click', '.create', function () {
        $('form').find('.selectOption :input').each(function () {
            this.name = this.name + '[]';
        });

    });
});
