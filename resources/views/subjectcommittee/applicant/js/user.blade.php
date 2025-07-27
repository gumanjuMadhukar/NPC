<script>
$(document).ready(function() {


    $('.exam_status').click(function() {
        var id = $(this).data("id");
        var status = $(this).data("status");
        $.ajax({
            url: '{{ route("subject_committee-applicant-status")}}',
            type: 'POST',
            data: {
                'id': id,
                'status': status,
                '_token': '{{ csrf_token() }}'
            },
            success: function(data) {
                $("#tr" + id).remove();
                Swal.fire({
                        icon: "success",
                        title: data.message,
                        timer: 4000,
                        timerProgressBar: true,
                        showConfirmButton: false,
                    });
                setTimeout(function() {
                    window.location.reload();
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

    $("#frm_status").submit(function(e) {
        e.preventDefault(); 
        var id = $(this).data("id");
        var status = $(this).data("status");
        $.ajax({
            url: "{{ route('subject_committee-applicant-status') }}",
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
                    window.location.href = "{{route('subject_committee-applicant-list-level', $exam_apply->level->id )}}";
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

});
</script>