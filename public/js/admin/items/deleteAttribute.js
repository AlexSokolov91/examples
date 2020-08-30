$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

   $('.btn-danger').click( function () {
        var action = $(this).attr('data-action');
        var id = $(this).attr('data-value');
        var keys = $('#keys').attr('data-value');

        $('.current' + keys).remove();

        $.ajax({
            type: "POST",
            url: action,
            data: { id: id},
        });
        Swal.fire({
            position: 'top-end',
            icon: 'success',
            title: 'successfully deleted!',
            showConfirmButton: false,
            timer: 1500
        });

    });

