<script>
$(document).ready(function() {
    $('.switch-status').change(function() {
        if ($(this).attr('data-status-value') == 0) {
            var val = 1;
        } else {
            var val = 0;
        }
        $(this).attr("data-status-value", val);
        var id = $(this).attr('data-id');
        $.ajax({
            url: '{{ route("admin-user-status")}}',
            type: 'POST',
            data: {
                'id': id,
                'val': val,
                'field_name': 'status',
                '_token': '{{ csrf_token() }}'
            },
            success: function(data) {
                toastr["success"](data.message);
            },
            error: function(xhr) {
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