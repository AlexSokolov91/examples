Dropzone.autoDiscover = false;

$(document).ready(function () {
    $('#category').select2();

    Dropzone.options.kDropzoneTwo = {
        paramName: "attached_files",
        maxFiles: 20,
        maxFilesize: 20, // MB
        addRemoveLinks: true,
        headers: {
            'X-CSRF-Token': $('input[name="_token"]').val()
        },
        sending: function(file, xhr, formData) {
            formData.append("_token", $('[name=_token]').val());
        },
        accept: function(file, done) {
            done();
        },
        success: function(file, response){
            if($('#files_id').val() !== ''){
                $('#files_id').val( $('#files_id').val() + ',' + response.fileId);
            } else {
                $('#files_id').val(response.fileId);
            }
            file.deleteLink = response.deleteLink;
            file.fileId = response.fileId;
        },
        removedfile: function(file) {
            if (!file.deleteLink) { return; }
            $.ajax({
                url: file.deleteLink,
                async: false,
                method: 'DELETE',
                success: function (response) {
                    let filesIds = [];
                    myDropzone.files.forEach(function(item, i, arr) {
                        filesIds.push(item.fileId);
                    });

                    filesIds = filesIds.join(',');
                    $('#files_id').val(filesIds);
                }
            });

            let _ref;
            (_ref = file.previewElement) != null ? _ref.parentNode.removeChild(file.previewElement) : '';
        }
    };

    let myDropzone = new Dropzone("#k-dropzone-two", {
        url: $('#k-dropzone-two').attr('action'),
    });

});


