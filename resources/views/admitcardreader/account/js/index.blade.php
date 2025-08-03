<script>
$(document).ready(function() {

    $("#frm_profile").submit(function(e) {
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
                toastr["success"](data.message);
                setTimeout(function() {
                    window.location.href = "{{route('admit_card_reader-account-setting')}}";
                }, 1000);
            },
            error: function(xhr) {
                $("#frm_profile").find('.btn-loading').prop('disabled', false);
                $("#frm_profile").find('.btn-loading').html('Submit');
                var res = $.parseJSON(xhr.responseText);
                if (res.error) {
                    toastr['error'](res.error);
                }
            }
        });
    });

    $("#frm_password").submit(function(e) {
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
                toastr["success"](data.message);
                setTimeout(function() {
                    toastr["info"]('Your are being logout now.');
                }, 1000);
                setTimeout(function() {
                    window.location.href = "{{route('admit_card_reader-logout')}}";
                }, 2000);
            },
            error: function(xhr) {
                $('#frm_password').find('.btn-loading').prop('disabled', false);
                $('#frm_password').find('.btn-loading').html('Change Password');
                var res = $.parseJSON(xhr.responseText);
                if (res.error) {
                    toastr['error'](res.error);
                }
            }
        });
    });

    
});
</script>