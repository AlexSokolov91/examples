$(document).ready(function () {
    $(document).on('click','.deleteOption', function () {
        let optionId = $(this).attr('data-value');
        let action = $(this).attr('data-action');
        let formId = $(this).attr('data-id');

        $.ajax({
            'type': "POST",
            'url': action,
            data: {
                id: optionId,
                formId: formId,
            },
            success: function (response) {

                if (response.success) {
                    console.log('1');
                    let del = $('.this').parents('.form-repeater').find('.kt_repeater_1').find('.selectOption').remove();

                }
            },

            error: function (response){
                for(error in response.responseJSON.errors){
                    Swal.fire("Warning!", response.responseJSON.errors[error][0], "warning");
                }
            }
        })
    });
    $(document).on('click', '.add', function () {
        var input = $(this).parents('.kt_repeater_1').find('.selectOption').clone();
        input.find('input').val('').empty();
        var parent = $(this).parents('.form-repeater').append(input);
        input.find('.deleteOption').removeClass('deleteOption').addClass('removeOption');
        input.removeClass('.selectOption').addClass('selectOptionNew');
        $(this).addClass('new');

    });
    $(document).on('click', '.new', function () {
        var input = $(this).parents('.selectOptionNew').clone();
        input.find('input').val('');
        $(this).parents('.form-repeater').append(input);
    });
    $(document).on('click', '.removeOption', function () {
           $(this).parents('.selectOptionNew').remove();
    });
});
