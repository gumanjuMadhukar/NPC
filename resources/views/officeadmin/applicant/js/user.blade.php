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

    $('.delete-applicant_apply').click(function() {
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
                    url: '{{ route("operator-applicant-delete-application")}}',
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

    $("#frm_forward").submit(function(e) {
        e.preventDefault(); 
        var id = $(this).data("id");
        var state = $(this).data("state");
        $.ajax({
            url: "{{ route('operator-applicant-save-state') }}",
            type: 'POST',
            // url: $('#frm_state').attr('action'),
            data: $("#frm_forward").serialize(),
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

    function printDiv() {
            var divContents = document.getElementById("print-content");
            var a = window.open('');
            a.document.write(divContents.outerHTML);
            // a.print();
            // a.close();
        }
</script>