<form enctype="multipart/form-data" method="post" action="{{ route('office_admin-applicant-save-status')}}" id="frm_status">
    @csrf
    <div class="modal-header">
        <h3>Edit</h3>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">   <div class="row">
                    <div class="col-md-6 col-sm-6">
                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <select class="form-control form-select" name="status">
                                <option value="accepted">Verified</option>
                                <option value="pending">Pending</option>
                                <option value="progress">Reviewing</option>
                                <option value="rejected">Rejected</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Remarks</label>
                    <textarea class="form-control" name="remarks" rows="5" maxlength="500"></textarea>
                </div> </div>
    <div class="modal-footer">
        <div class="button-wrap">
            <button class="cancel-btn btn-dafault" data-bs-dismiss="modal" aria-label="Close"
                type="button">Cancel</button>
            <button class=" main_P-btn btn-dafault btn-loading" type="submit">Update</button>
        </div>
    </div>
</form>
