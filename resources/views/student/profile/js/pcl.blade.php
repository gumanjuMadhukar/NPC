<script>
$(document).ready(function() {
    $('.select2').select2();
    $('#college_type').change(function() {
        $college_type = $(this).val();
        $board_university = $('#board_university').val();
        if ($college_type == 'nepal' && $board_university == 'PCL') {
            $('#college_name').removeClass('d-none');
        } else {
            $('#college_name').addClass('d-none');
            $('#international_college_name').removeClass('d-none');
        }
    });

    $('#board_university').change(function() {
        $board_university = $(this).val();
        $college_type = $('#college_type').val();
        if ($college_type == 'nepal' || $board_university == 'CTEVT, NEPAL' || $board_university == 'HSEB' ) {
            $('#college_name').removeClass('d-none');
            $('#international_college_name').addClass('d-none');
        } else {
            $('#college_name').addClass('d-none');
            $('#international_college_name').removeClass('d-none');
        }
    });


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
                    container.find('.img-delete-btn').removeClass('d-none');
                    container.find('.preview-image').removeClass('d-none');
                    container.find('.file-input').val(reader.result);
                    container.find('.preview-image').attr("src", reader.result);
                    container.find('.dropify-message').removeClass('d-block').addClass('d-none');
                    container.find('.dropify-message-profile_picture').removeClass('d-block')
                        .addClass('d-none');
                }
                reader.readAsDataURL(file);
            }
        }
    });
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
                setTimeout(function() {
                    window.location.href = "{{$return_url}}";
                }, 1000);
            },
            error: function(xhr) {
                $('.btn-loading').prop('disabled', false);
                $('.btn-loading').html('Next');
                var res = $.parseJSON(xhr.responseText);
                if (res.error) {
                    Swal.fire({
                        icon: "error",
                        title: res.error,
                        timer: 2000,
                        timerProgressBar: true,
                        showConfirmButton: false,
                    });
                }
            }
        });
    });
});

function imageDelete(field_name) {
    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: 'btn btn-success',
            cancelButton: 'btn btn-danger'
        },
        buttonsStyling: false
    })
    swalWithBootstrapButtons.fire({
        title: 'Are you sure to delete this?',
        text: "",
        showCancelButton: true,
        confirmButtonText: 'Yes',
        cancelButtonText: 'No',
        reverseButtons: false
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: '{{ route("student-profile-college-imageDelete")}}',
                type: 'POST',
                data: {
                    'id': '{{ ($user_qualification) ? $user_qualification->id : 0 }}',
                    'field_name': field_name,
                    '_token': '{{ csrf_token() }}'
                },
                success: function(data) {
                    $("#btn_" + field_name + "_delete").addClass('d-none');
                    $("#display_" + field_name).addClass('d-none');
                    $(".dropify-message-" + field_name).removeClass('d-none')
                        .addClass('d-block');
                    $("#display_" + field_name).attr("src", '');
                    $("#" + field_name).val('');
                    toastr["success"](data.message);
                }
            });
        } else if (
            result.dismiss === Swal.DismissReason.cancel
        ) {
            toastr["error"]('Cancelled.');
        }
    })
}
</script>
