<form enctype="multipart/form-data" method="post" action="{{ route('officer-applicant-save-status')}}" id="frm_status">
    @csrf
    <input type="hidden" name="id" value="{{ $exam_apply->id }}" />
    <div class="modal-header">
        <h3>Accept / Reject</h3>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
        <div class="row">
            <div class="col-md-6 col-sm-6">
                <div class="mb-3">
                    <label class="form-label">Status</label>
                    <select class="form-control" name="status">
                        <option value="accepted">Accepted</option>
                        <option value="rejected">Rejected</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label">Remarks</label>
            <textarea class="form-control" name="remarks" rows="5" maxlength="500"></textarea>
        </div>
    </div>
    <div class="modal-footer">
        <div class="button-wrap">
            <button class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close"
                type="button">Cancel</button>
            <button class="btn btn-primary btn-loading" type="submit">Update</button>
        </div>
    </div>
</form>

<script>
     $("#frm_status").submit(function(e) {
        e.preventDefault();
        var id = $(this).data("id");
        var status = $(this).data("status");
        $.ajax({
            url: '{{ route("officer-applicant-save-status")}}',
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
</script>