@extends('officer.layout')
@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-12 col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <h3>{{ $page_title }}</h3>

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
                                <div class="title">
                                    <h3>Student Detail</h3>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="card bordered">
                                            <div class="card-body">
                                                <h2 class="card-title">{{ $applicant_count }}</h2>
                                                <h3 class="card-subtitle mb-2 text-muted">Applicants </h3>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="card bordered">
                                            <div class="card-body">
                                                <h2 class="card-title">{{ $rejected_count }}</h2>
                                                <h3 class="card-subtitle mb-2 text-muted">Rejected </h3>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="card bordered">
                                            <div class="card-body">
                                                <h2 class="card-title">{{ $failed_count }}</h2>
                                                <h3 class="card-subtitle mb-2 text-muted">Failed</h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div>
                                <div class="title">
                                    <h3>Officer State</h3>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="card bordered">
                                            <div class="card-body">
                                                <h2 class="card-title">{{ $officer_student_count }}</h2>
                                                <h3 class="card-subtitle mb-2 text-muted">Applicants </h3>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="card bordered">
                                            <div class="card-body">
                                                <h2 class="card-title">{{ $officer_accepted_count }}</h2>
                                                <h3 class="card-subtitle mb-2 text-muted">Accepted </h3>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="card bordered">
                                            <div class="card-body">
                                                <h2 class="card-title">{{ $officer_rejected_count }}</h2>
                                                <h3 class="card-subtitle mb-2 text-muted">Rejected</h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div>
                                <div class="title">
                                    <h3>Subject Committee</h3>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="card bordered">
                                            <div class="card-body">
                                                <h2 class="card-title">{{ $applicant_count }}</h2>
                                                <h3 class="card-subtitle mb-2 text-muted">Applicants </h3>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="card bordered">
                                            <div class="card-body">
                                                <h2 class="card-title">{{ $rejected_count }}</h2>
                                                <h3 class="card-subtitle mb-2 text-muted">Rejected </h3>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="card bordered">
                                            <div class="card-body">
                                                <h2 class="card-title">{{ $failed_count }}</h2>
                                                <h3 class="card-subtitle mb-2 text-muted">Failed</h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
