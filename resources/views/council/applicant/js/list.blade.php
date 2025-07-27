<script>
$(document).ready(function() {
    //$('.select2').select2();

    $("#frm_status").submit(function(e) {
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
                    window.location.reload();
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

$('.delete').click(function() {
    var id = $(this).data("id");
    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: 'btn btn-success',
            cancelButton: 'btn btn-danger'
        },
        buttonsStyling: false
    })
    swalWithBootstrapButtons.fire({
        title: 'Are you sure to delete this?',
        showCancelButton: true,
        confirmButtonText: 'Yes',
        cancelButtonText: 'No',
        reverseButtons: false
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: '{{ route("admin-student-delete")}}',
                type: 'POST',
                data: {
                    'id': id,
                    '_token': '{{ csrf_token() }}'
                },
                success: function(data) {
                    $("#tr" + id).remove();
                    toastr["success"](data.message);
                    setTimeout(function() {
                        location.reload();
                    }, 1000);
                },
                error: function(xhr) {
                    var res = $.parseJSON(xhr.responseText);
                    if (res.error) {
                        toastr['error'](res.error);
                    }
                }
            });
        } else if (
            result.dismiss === Swal.DismissReason.cancel
        ) {
            toastr["error"]('Cancelled.');
        }
    })
});

});
</script>