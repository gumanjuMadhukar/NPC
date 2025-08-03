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
                toastr["success"](data.message);
                setTimeout(function() {
                    window.location.href = "{{route('office_admin-university')}}";
                }, 1000);
            },
            error: function(xhr) {
                $('.btn-loading').prop('disabled', false);
                $('.btn-loading').html('Submit');
                var res = $.parseJSON(xhr.responseText);
                if (res.error) {
                    toastr['error'](res.error);
                }
            }
        });
    });
});
</script>