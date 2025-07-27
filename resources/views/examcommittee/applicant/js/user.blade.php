<link href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.css" rel="stylesheet"
    type="text/css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js"></script>
<script>
     $("#frm_status").submit(function(e) {
        e.preventDefault(); 
        var id = $(this).data("id");
        var status = $(this).data("status");
        $.ajax({
            url: "{{ route('operator-applicant-save-status') }}",
            type: 'POST',
            url: $('#frm_status').attr('action'),
            data: $("#frm_status").serialize(),
            success: function(data) {
                Swal.fire({
                    icon: "success",
                    title: data.message,
                    timer: 4000,
                    timerProgressBar: true,
                    showConfirmButton: false,
                });
                setTimeout(function() {
                    window.location.href = "{{route('operator-applicant-list')}}";
                }, 1000);
            },
            error: function(xhr) {
                var res = $.parseJSON(xhr.responseText);
                if (res.error) {
                    toastr['error'](res.error);
                }
            }
        });
    });
</script>