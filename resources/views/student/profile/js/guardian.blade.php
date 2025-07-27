<script>
$(document).ready(function() {
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
                    window.location.href = "{{route('student-profile-slc')}}";
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
</script>
