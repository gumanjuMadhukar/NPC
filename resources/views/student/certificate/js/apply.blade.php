<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-chained/1.0.1/jquery.chained.min.js"
    integrity="sha512-rcWQG55udn0NOSHKgu3DO5jb34nLcwC+iL1Qq6sq04Sj7uW27vmYENyvWm8I9oqtLoAE01KzcUO6THujRpi/Kg=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    $(document).ready(function() {
        // Initialize drag and drop area for voucher image
        var dropAreaImage = document.querySelector('.drag-area-voucher_image');
        var voucher_image = dropAreaImage.querySelector('#drag-voucher_image');

        dropAreaImage.onclick = () => {
            voucher_image.click();
        };

        // Handle voucher image upload
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
                        $(".dropify-message-voucher_image").removeClass('d-block').addClass(
                            'd-none');
                    }
                    reader.readAsDataURL(file);
                }
            }
        });

        // Payment method toggle functionality
        const $certificateApplicationForm = $('#certificateApplicationForm');
        const $voucherSection = $('#voucherSection');
        const $khaltiSection = $('#khaltiSection');
        const $radioVoucher = $('#radioVoucher');
        const $radioKhalti = $('#radioKhalti');
        const $submitButton = $('#submitButton');
        const $voucherImageInput = $('#drag-voucher_image');
        const $symbolNumberInput = $('#symbol_number_input');

        function updateFormForPaymentMethod(method) {
            const symbolNumber = $symbolNumberInput.val();

            if (!symbolNumber) {
                if (method === 'khalti') {
                    alert('Please enter your Symbol Number before choosing Khalti payment.');
                    $radioVoucher.prop('checked', true);
                    method = 'voucher';
                }
            }

            if (method === 'voucher') {
                $voucherSection.show();
                $khaltiSection.hide();
                $submitButton.show().html('<i class="fa fa-check"></i> Apply For Certificate (Voucher)');
                $certificateApplicationForm.attr('action', '{{ route('student-certificate-apply') }}');
                $certificateApplicationForm.attr('enctype', 'multipart/form-data');
                $voucherImageInput.prop('required', true);
            } else if (method === 'khalti') {
                $voucherSection.hide();
                $khaltiSection.show();
                $submitButton.show().html('<i class="fa fa-check"></i> Pay With Khalti');
                $certificateApplicationForm.attr('action',
                    '{{ route('student-payment-initiate1', ['gateway' => 'khalti', 'purpose' => 'certificateIssuance']) }}'
                    );
                $certificateApplicationForm.removeAttr('enctype');
                $voucherImageInput.prop('required', false);
            }
        }

        // Initial setup
        updateFormForPaymentMethod($('input[name="payment_option"]:checked').val());

        // Payment method change handler
        $('input[name="payment_option"]').on('change', function() {
            updateFormForPaymentMethod($(this).val());
        });

        // Form submission handler
        $certificateApplicationForm.on('submit', function(e) {
            const symbolNumber = $symbolNumberInput.val();
            const currentMethod = $('input[name="payment_option"]:checked').val();

            if (!symbolNumber) {
                alert('Please enter your Symbol Number.');
                e.preventDefault();
                return;
            }

            if (currentMethod === 'voucher') {
                e.preventDefault();
                submitVoucherForm();
            }
            // For Khalti, let the form submit normally
        });

        function submitVoucherForm() {
            const formData = new FormData($certificateApplicationForm[0]);

            $('.btn-loading').prop('disabled', true).html(
                '<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span> Processing...'
            );

            $.ajax({
                url: $certificateApplicationForm.attr('action'),
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.success) {
                        toastr.success(response.message);
                        setTimeout(() => {
                            window.location.reload();
                        }, 2000);
                    } else {
                        toastr.error(response.message);
                        $('.btn-loading').prop('disabled', false).html(
                            '<i class="fa fa-check"></i> Apply For Certificate (Voucher)'
                        );
                    }
                },
                error: function(xhr) {
                    const errorMessage = xhr.responseJSON?.message ||
                        'An error occurred. Please try again.';
                    toastr.error(errorMessage);
                    $('.btn-loading').prop('disabled', false).html(
                        '<i class="fa fa-check"></i> Apply For Certificate (Voucher)'
                    );
                }
            });
        }

        // Existing drag and drop image upload functionality
        $(".drag-area-voucher_image").on('click', function() {
            $("#drag-voucher_image").click();
        });

        $("#drag-voucher_image").on('change', function(e) {
            e.preventDefault();
            let file = this.files[0];
            let allowedExtensions = /(\.jpg|\.jpeg|\.png)$/i;

            if (!allowedExtensions.exec(file.name)) {
                toastr.error('Only JPG, JPEG, and PNG files are allowed.');
                return false;
            }

            if (file.size > 2 * 1024 * 1024) {
                toastr.error('File size must be less than 2MB');
                return false;
            }

            let imgURL = URL.createObjectURL(file);
            $("#display_voucher_image").attr('src', imgURL).removeClass('d-none');
            $(".dropify-message-voucher_image").addClass('d-none');
            $("#btn_voucher_image_delete").addClass('d-block');
        });


        // Image delete function (needs to be global as it's called from HTML)
        function imageDelete(type) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You want to delete this image?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('student-profile-voucher-imageDelete') }}",
                        type: 'POST',
                        data: {
                            _token: "{{ csrf_token() }}",
                            type: type
                        },
                        success: function(response) {
                            if (response.success) {
                                toastr.success(response.message);
                                $("#display_voucher_image").attr('src', '').addClass(
                                    'd-none');
                                $(".dropify-message-voucher_image").removeClass('d-none');
                                $("#btn_voucher_image_delete").removeClass('d-block');
                                $("#drag-voucher_image").val('');
                                $("#voucher_image_hidden_path").val('');
                            } else {
                                toastr.error(response.message);
                            }
                        },
                        error: function(xhr) {
                            toastr.error('An error occurred. Please try again.');
                        }
                    });
                }
            });
        }
    });
</script>
