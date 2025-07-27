<script>
$(document).ready(function() {

    $('.ajax-select2').select2({
        minimumInputLength: 2,
        ajax: {
            url: '{{ route ("operator-kyc-json-list") }}', // Your API endpoint
            dataType: 'json',
            delay: 250,
            data: function (term) {
                return {
                    term: term, // The search term from the input field
                };
            },
            processResults: function (data) {
                // Ensure that each option has a valid 'id' and 'text'
                return {
                    results: $.map(data, function (v) {
                        return {
                            id: v.user_id, // Ensure 'id' is set
                            text: v.name, // Set 'text' to the name
                            user: v // Pass the full user object for custom templates
                        };
                    })
                };
            }
        },
        templateResult: function (data) {
            if (!data.id) {
                return data.text;
            }

            var user = data.user;
            var imgSrc = user.full_profile_img ? user.full_profile_img : 'default.png';

            var $result = $(
                `<div style="display: flex; align-items: center;">
                    <img src="${imgSrc}" style="width: 40px; height: 40px; border-radius: 50%; margin-right: 10px;">
                    <div>
                        <div><strong>${user.name}</strong> (${user.dob})</div>
                        <div>User ID: ${user.user_id}</div>
                        <div>${user.symbol_number ? 'Symbol Number: ' + user.symbol_number : 'No Symbol Number'}</div>
                    </div>
                </div>`
            );

            return $result;
        },
        templateSelection: function (data) {
            // Fallback in case 'data.user' is missing, as it might not be available
            console.log(data);
            var user = data.user || {};

            // If no 'user' is available, just return the 'text' field
            if (!user.name) {
                return data.text || 'Select an option';
            }

            // Show name and DOB in the selected option
            return `${user.name} (${user.dob || 'Unknown DOB'})`;
        },
        escapeMarkup: function (markup) {
            return markup; // Allow HTML rendering in the options
        }
    });

    $("#allocate_form").submit(function(e) {
        e.preventDefault();
        $(this).find('.btn-loading').prop('disabled', true)
        $(this).find('.btn-loading').html(
            '<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span> Loading...'
        );
        $.ajax({
            type: 'post',
            url: $(this).attr('action'),
            data: $(this).serialize(),
            success: function(data) {
                Swal.fire({
                    icon: "success",
                    title: (data.message),
                    timer: 4000,
                    timerProgressBar: true,
                    showConfirmButton: false,
                });
                setTimeout(function() {
                    window.location.href = "{{ route('operator-certificate-profile', ['id' => $id]) }}";
                }, 1000);
            },
            error: function(xhr) {
                $("#frm_status").find('.btn-loading').prop('disabled', false);
                $("#frm_status").find('.btn-loading').html('Submit');
                var res = $.parseJSON(xhr.responseText);
                if (res.error) {
                    toastr['error'](res.error);
                }
            }
        });
    });
});  
</script>