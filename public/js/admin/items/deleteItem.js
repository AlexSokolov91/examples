let message;
$(document).ready(function() {
    $(document).on('click','.last', function (e) {
        e.preventDefault();
        var path = 'http://estore-alx.badvps.com/admin/items/getTranslation';
        $.ajax({
            type: "POST",
            url: path,
            success: function (response) {
                message = response.message;
            }
        });

        var action = $('form').attr('data-action');
        var id = $(this).find('form').attr('data-value');

        Swal.fire({
            title: 'Are you sure?',
            text: "Product will be removed! All sets containing this product will be removed" ,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'

        }).then((result) => {
            if (result.value) {

                $.ajax({
                    type: "POST",
                    url: action,
                    data: {
                        id: id,
                    },
                    success: function () {

                  Swal.fire(
                    'Deleted!',
                    'Your file has been deleted.',
                    'success'
                )
                    }
                });
                $(this).closest('tr').remove();
            }
        });
    });
});

