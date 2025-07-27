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

$('#forward_reexam').click(function() {
    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: 'btn btn-success',
            cancelButton: 'btn btn-danger'
        },
        buttonsStyling: false
    })
    swalWithBootstrapButtons.fire({
        title: 'Are you sure to forward re-exam files to exam committee?',
        showCancelButton: true,
        confirmButtonText: 'Yes',
        cancelButtonText: 'No',
        reverseButtons: false
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: '{{ route("operator-fowrard-reexam")}}',
                type: 'GET',
                data: {
                    '_token': '{{ csrf_token() }}'
                },
                success: function(data) {
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

$('#move_selected_button').click(function () {
    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: 'btn btn-success',
            cancelButton: 'btn btn-danger'
        },
        buttonsStyling: false
    })
    swalWithBootstrapButtons.fire({
        title: 'Are you sure to forward re-exam files to exam committee?',
        showCancelButton: true,
        confirmButtonText: 'Yes',
        cancelButtonText: 'No',
        reverseButtons: false
    }).then((result) => {
        if (result.isConfirmed) {
            // Create an array to store selected values
            let selectedData = [];

            // Iterate through each checkbox with the class 'selected_id' that is checked
            $('.selected_id:checked').each(function () {
                // Push the value of the checkbox to the array
                selectedData.push($(this).val());
            });

            // Ensure there is data to send
            if (selectedData.length === 0) {
                alert("Please select at least one item.");
                return;
            }
            $.ajax({
                url: '{{ route("operator-selected-fowrard-reexam") }}',
                type: 'POST',
                data: {
                    selected_ids: selectedData, // Sending the selected data
                    _token: $('meta[name="csrf-token"]').attr('content') // Include CSRF token for Laravel
                },
                success: function(data) {
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
/////
    /*// Create an array to store selected values
    let selectedData = [];

    // Iterate through each checkbox with the class 'selected_id' that is checked
    $('.selected_id:checked').each(function () {
        // Push the value of the checkbox to the array
        selectedData.push($(this).val());
    });

    // Ensure there is data to send
    if (selectedData.length === 0) {
        alert("Please select at least one item.");
        return;
    }

    // Send the selected data using AJAX
    $.ajax({
        url: '{{ route("operator-selected-fowrard-reexam") }}',
        method: 'POST', // Use the appropriate HTTP method
        data: {
            selected_ids: selectedData, // Sending the selected data
            _token: $('meta[name="csrf-token"]').attr('content') // Include CSRF token for Laravel
        },
        success: function (response) {
            // Handle success
            console.log('Success:', response);
            alert('Data moved successfully!');
        },
        error: function (xhr, status, error) {
            // Handle error
            console.error('Error:', error);
            alert('An error occurred while moving data.');
        }
    });*/
});
</script>