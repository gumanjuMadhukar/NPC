<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-chained/1.0.1/jquery.chained.min.js"
    integrity="sha512-rcWQG55udn0NOSHKgu3DO5jb34nLcwC+iL1Qq6sq04Sj7uW27vmYENyvWm8I9oqtLoAE01KzcUO6THujRpi/Kg=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    $(document).ready(function() {
        // Initialize drop area for voucher image
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

        // DOM elements
        const $applicationForm = $('#applicationForm');
        const $voucherSection = $('#voucherSection');
        const $khaltiSection = $('#khaltiSection');
        const $radioVoucher = $('#radioVoucher');
        const $radioKhalti = $('#radioKhalti');
        const $submitButton = $('#submitButton');
        const $voucherImageInput = $('#drag-voucher_image');
        const $levelSelect = $('#level');
        const $programSelect = $('#program');

        // Initialize Select2
        $('.select2').select2();

        // Chain program selection based on level
        $("#program_select").chained("#level_select");



        // Function to update form based on payment method
        function updateFormForPaymentMethod(method) {
            const levelSelected = $levelSelect.val();
            const programSelected = $programSelect.val();

            if (!levelSelected || !programSelected) {
                if (method === 'khalti') {
                    alert('Please select a Level and Program before choosing Khalti payment.');
                    $radioVoucher.prop('checked', true);
                    method = 'voucher';
                }
            }

            if (method === 'voucher') {
                $voucherSection.show();
                $khaltiSection.hide();
                $submitButton.show().html('<i class="fa fa-check"></i> Apply For Licence (Voucher)');
                $applicationForm.attr('action', '{{ route('student-exam-save-apply') }}');
                $applicationForm.attr('enctype', 'multipart/form-data');
            } else if (method === 'khalti') {
                $voucherSection.hide();
                $khaltiSection.show();
                $submitButton.show().html('<i class="fa fa-check"></i> Pay With Khalti');
                $applicationForm.attr('action',
                    '{{ route('student-payment-initiate1', ['gateway' => 'khalti', 'purpose' => 'examApply']) }}'
                );
                $applicationForm.removeAttr('enctype');
            }
        }

        // Initialize form with default payment method
        updateFormForPaymentMethod($('input[name="payment_option"]:checked').val());

        // Handle payment method change
        $('input[name="payment_option"]').on('change', function() {
            updateFormForPaymentMethod($(this).val());
        });

        // Handle form submission
        $applicationForm.on('submit', function(e) {
            const levelSelected = $levelSelect.val();
            const programSelected = $programSelect.val();
            const currentMethod = $('input[name="payment_option"]:checked').val();

            if (!levelSelected) {
                toastr.error('Please select a Level.');
                e.preventDefault();
                return;
            }
            if (!programSelected) {
                toastr.error('Please select a Program.');
                e.preventDefault();
                return;
            }

            // Additional validation for voucher payment
            if (currentMethod === 'voucher') {
                e.preventDefault();
                submitVoucherForm();
            }
        });

        function submitVoucherForm() {
            const formData = new FormData($applicationForm[0]);

            $.ajax({
                url: $applicationForm.attr('action'),
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.success) {
                        toastr.success(response.message);
                        setTimeout(() => {
                            window.location.href = "{{ route('student-exam-status') }}";
                        }, 1000);
                    } else {
                        toastr.error(response.message);
                        $submitButton.prop('disabled', false).html(
                            '<i class="fa fa-check"></i> Apply For Exam (Voucher)'
                        );
                    }
                },
                error: function(xhr) {
                    $('.btn-loading').prop('disabled', false);
                    $('.btn-loading').html(' Apply For Licence');
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

        // Image delete function

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
                    url: '{{ route('student-exam-voucher-imageDelete') }}',
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
</script>
