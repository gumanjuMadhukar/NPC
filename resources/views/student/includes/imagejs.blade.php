<script>
$(document).ready(function() {
    $('.drag-area').click(function() {
        $(this).parent().find('.drag-image').trigger('click');
    });

    $('.drag-image').on('change', function() {
        var container = $(this).closest('.drag-container');
        var fileExtension = ['jpeg', 'jpg', 'png', 'JPEG', 'JPG', 'PNG'];
        var maxSizeKB = 600; // Maximum file size in kilobytes
        if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
            toastr['error']("Allowed file formats : " + fileExtension.join(', '));
            $(this).val('');
        } else {
            file = this.files[0];
            var fileSizeKB = file.size / 1024; // File size in kilobytes
            if (fileSizeKB > maxSizeKB) {
                Swal.fire({
                    icon: "warning",
                    title: "Maximum file size allowed is " + maxSizeKB + "KB",
                    timer: 4000,
                    timerProgressBar: true,
                    showConfirmButton: false,
                });
                $(this).val('');
                return; // Exit function if file size exceeds the limit
            } else {
                var reader = new FileReader();
                reader.onloadend = function() {
                    container.find('.img-delete-btn').removeClass('d-none');
                    container.find('.preview-image').removeClass('d-none');
                    container.find('.file-input').val(reader.result);
                    container.find('.preview-image').attr("src", reader.result);
                    container.find('.dropify-message').removeClass('d-block').addClass('d-none');
                    container.find('.dropify-message-image').removeClass('d-block').addClass(
                        'd-none');
                }
                reader.readAsDataURL(file);
            }
        }
    });
});
</script>