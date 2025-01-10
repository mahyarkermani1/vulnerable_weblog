$(document).ready(function() {
    $('#imageInput').on('change', function() {
        var formData = new FormData();
        var fileInput = $(this)[0];

        if (fileInput.files.length > 0) {
            var file = fileInput.files[0];
            formData.append('image', file);

            $('#uploadProgress').show().val(0);
            $('#uploadStatus').text('Uploading...');

            $.ajax({
                url: 'image_upload.php',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                xhr: function() {
                    var xhr = new window.XMLHttpRequest();
                    xhr.upload.addEventListener('progress', function(evt) {
                        if (evt.lengthComputable) {
                            var percentComplete = evt.loaded / evt.total;

                            percentComplete = parseInt(percentComplete * 100);
                            $('#uploadProgress').val(percentComplete);
                        }
                    }, false);
                    return xhr;
                },
                success: function(response) {

                    location.reload()
                    $('#uploadStatus').text(response);
                    // $('#uploadProgress').hide();
                },
                error: function() {
                    $('#uploadStatus').text('Upload failed.');
                    // $('#uploadProgress').hide();
                }
            });
        }
    });
});
