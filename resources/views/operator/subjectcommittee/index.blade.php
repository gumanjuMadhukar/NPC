@extends('operator.layout')
@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 col-sm-6 col-xs-6">
                                <h3>Subject Committee</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
               <div class="row">
                @foreach ($exam_applies_by_program as $subjectCommitteeId => $items)
                <div class="col-3">
                    <div class="card" style="border-radius: 15px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); overflow: hidden;">
                        <div class="card-body" style="background: #f9f9f9; padding: 20px;">
                            <h1 style="font-size: 1.5rem; color: #333;">{{ $subject_committee_names[$subjectCommitteeId] }}</h1>
                            <p style="font-size: 1rem; color: #555;">No. of Exam Applications: <strong>{{ $items->count() }}</strong></p>
                            <p style="font-size: 1rem; color: #555;">No. of Progress Applications: <strong>{{ $progress_applications_by_sub_committee[$subjectCommitteeId] }}</strong></p>
                            <p style="font-size: 1rem; color: #555;">No. of Rejected Applications: <strong>{{ $rejected_applications_by_sub_committee[$subjectCommitteeId] }}</strong></p>
                            <div class="progress progress-bar-alt-warning progress-sm">
                                <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%;">
                                    <span class="visually-hidden">100% Complete</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
               </div>
            </div>
        </div>
    </div>
@endsection
@section('footer-scripts')
@endsection
