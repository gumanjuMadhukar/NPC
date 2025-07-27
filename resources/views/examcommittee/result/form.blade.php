@extends('examcommittee.layout')
@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-12 col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <h3>Result</h3>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div>
                                <!-- <div class="title float-start">
                                    <h3>Student Detail</h3>
                                </div> -->
                                <form action="{{ route('exam_committee-result-upload') }}" method="post" id="frm_forward" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group mb-3">
                                        <label class="col-sm-12">Exam</label>
                                        <div class="col-sm-12">
                                            <select class="form-control form-control-line" name="exam_id">
                                                @foreach($exams as $exam)
                                                <option value="{{ $exam->id }}">{{ $exam->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label class="col-sm-12">Select Result File</label>
                                        <div class="col-sm-12">
                                            <input type='file' class="form-control form-control-line" name="result" accept=".xls,.xlsx">
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
    </div>
@endsection

@section('footer-scripts')
@include('examcommittee.dashboard.js.exam_detail')
@endsection
