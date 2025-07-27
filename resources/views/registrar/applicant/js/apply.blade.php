<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-chained/1.0.1/jquery.chained.min.js"
    integrity="sha512-rcWQG55udn0NOSHKgu3DO5jb34nLcwC+iL1Qq6sq04Sj7uW27vmYENyvWm8I9oqtLoAE01KzcUO6THujRpi/Kg=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
$(document).ready(function() {
    $("#program").chained("#level");
    var dropAreaImage = document.querySelector('.drag-area-voucher_image');
    var voucher_image = dropAreaImage.querySelector('#drag-voucher_image')

    dropAreaImage.onclick = () => {
        voucher_image.click();
    };
    voucher_image.addEventListener('change', function() {
        var fileExtension = ['jpeg', 'jpg', 'png', 'JPEG', 'JPG', 'PNG'];
        var maxSizeKB = 600; // Maximum file size in kilobytes
        if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
            toastr['error']("Allowed file formats : " + fileExtension.join(', '));
            $(this).val('');
        } else {
            file = this.files[0];
            var fileSizeKB = file.size / 1024; // File size in kilobytes
            if (fileSizeKB > maxSizeKB) {
                // toastr['error']("Maximum file size allowed is " + maxSizeKB + "KB");
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
                    $("#btn_voucher_image_delete").removeClass('d-none');
                    $("#display_voucher_image").removeClass('d-none');
                    $("#voucher_image").val(reader.result);
                    $("#display_voucher_image").attr("src", reader.result);
                    $(".dropify-message-voucher_image").removeClass('d-block').addClass('d-none');
                }
                reader.readAsDataURL(file);
            }
        }
    });
    $('.select2').select2();
    $("#form").submit(function(e) {
        e.preventDefault();
        $('.btn-loading').prop('disabled', true)
        $('.btn-loading').html(
            '<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span> Loading...'
        );
        $.ajax({
            type: 'post',
            url: $('#form').attr('action'),
            data: $("#form").serialize(),
            success: function(data) {
                // toastr["success"](data.message);
                setTimeout(function() {
                    window.location.href = "{{route('registrar-applicant-profile', $exam_apply->user_id)}}";
                }, 1000);
            },
            error: function(xhr) {
                $('.btn-loading').prop('disabled', false);
                $('.btn-loading').html(' Edit');
                if (xhr.status == 406) {
                    Swal.fire({
                        icon: "warning",
                        title: "You have already applied for this exam.",
                        timer: 4000,
                        timerProgressBar: true,
                        showConfirmButton: false,
                    });
                } else {
                    var res = $.parseJSON(xhr.responseText);
                    if (res.error) {
                        toastr['error'](res.error);
                    }

                }
            }
        });
    });


});
</script>
