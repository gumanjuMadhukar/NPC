<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-chained/1.0.1/jquery.chained.min.js"
    integrity="sha512-rcWQG55udn0NOSHKgu3DO5jb34nLcwC+iL1Qq6sq04Sj7uW27vmYENyvWm8I9oqtLoAE01KzcUO6THujRpi/Kg=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="{{ asset('assets/plugins/nepali-datepicker/nepali.datepicker.v4.0.4.min.js') }}"></script>
<link href="{{ asset('assets/plugins/nepali-datepicker/nepali.datepicker.v4.0.4.min.css') }}" rel="stylesheet"
    type="text/css" />
<script>
    $(document).ready(function() {
        $('.select2').select2();
        $("#district").chained("#province");
        $("#municipality").chained("#district");
        $("#dob_nep").nepaliDatePicker({
            ndpEnglishInput: 'dob_eng',
            ndpYear: true,
            ndpMonth: true

        });
        // $("#citizenship_issue_date").nepaliDatePicker({
        //     ndpYear: true,
        //     ndpMonth: true
        // });

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
                    setTimeout(function() {
                        window.location.href =
                            "{{ route('student-profile-guardian') }}";
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

        $(".myInput").click(function() {
            const sanitizedValue = $(this).val().replace(/[^a-zA-Z0-9 ]/g, "");
            $(this).val(sanitizedValue);
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
                    url: '{{ route('student-profile-imageDelete') }}',
                    type: 'POST',
                    data: {
                        'id': '{{ $user ? $user->id : 0 }}',
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
