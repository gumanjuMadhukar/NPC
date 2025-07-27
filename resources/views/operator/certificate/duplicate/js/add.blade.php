<!-- Include Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<!-- Include jQuery and Select2 JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
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
                    url: '{{ route('student-profile-imageDelete') }}',
                    type: 'POST',
                    data: {

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
    $(document).ready(function() {
        $('.select2').select2();
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
                        container.find('.dropify-message').removeClass('d-block').addClass(
                            'd-none');
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
                    toastr["success"](data.message);
                    console.log(data);
                    setTimeout(function() {
                        window.location.href =
                            "{{route('operator-certificate-profile', $certificate->id)}}";
                    }, 1000);
                },
                error: function(xhr) {
                    $('.btn-loading').prop('disabled', false);
                    $('.btn-loading').html(' Edit');
                    if (xhr.status == 406) {
                        Swal.fire({
                            icon: "warning",
                            title: "",
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
