@if ($user->latest_exam_apply)
    <div class="card">
        <div class="card-body">
            <form enctype="multipart/form-data" method="post" action="{{ route('operator-applicant-save-status') }}"
                id="frm_status">
                @csrf
                <input type="hidden" name="id" value="{{ $user->latest_exam_apply->id }}" />
                <div class="modal-header">
                    <h3>Accept / Reject</h3>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12  col-sm-12 col-xl-12 mb-3">
                            <label class="form-label">Remarks</label>
                            <textarea class="form-control" name="remarks" rows="5" maxlength="500"></textarea>
                        </div>
                        <div class="col-md-6 col-sm-12 col-sm-6">
                            <div class="mb-3">
                                <label class="form-label">Status</label>
                                <select class="form-select" name="status">
                                    <option value="accepted">Accepted</option>
                                    <option value="rejected">Rejected</option>
                                    <option value="pending">Pending</option>
                                    <option value="onhold">Hold</option>
                                </select>
                            </div>
                        </div>
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
        </div>
    </div>
@endif