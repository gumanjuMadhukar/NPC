<div class="col-lg-12">
    <div class="info-box">
        <div class="card tab-style1">
            <!-- Nav tabs -->
            <ul class="nav nav-tabs profile-tab" role="tablist">
                <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#documents"
                        role="tab">Forward</a> </li>

            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="documents" role="tabpanel">
                    <div class="card-body">
                        <form action="" method="post" id="frm_forward">
                            @csrf
                            <input type="hidden" name="id" value="{{ @$user->latest_exam_apply->id }}" />
                            <div class="form-group mb-3">
                                <label class="col-sm-12">Select State</label>
                                <div class="col-sm-12">
                                    <select class="form-control form-control-line" name="state">
                                        <option value="operator">Computer Operator</option>
                                        <option value="officer">Officer</option>
                                        <option value="registrar">Registrar</option>
                                        <option value="subject_committee">Subject Committeee</option>
                                        <option value="exam_committee">Exam Committee</option>
                                        <option value="council">Council</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-12 ">
                                    <button class="btn btn-success">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>