@extends('operator.layout')
@section('content')
    <div class="content" id="program-detail-page">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-12 col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <h3>{{ $page_title }} - {{ $exam_name }}</h3>

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
                                    <h3>Program Wise Students</h3>
                                </div>
                                <div class="mt-3 mb-3">
                                    <form method="get" action="">
                                        <div class="row">
                                            <div class="col-md-12 col-sm-12 col-xs-12">
                                                <div class="input-group">
                                                    <input type="text" name="q" value="{{ $q }}"
                                                        class="form-control" placeholder="Search">
                                                    <div class="input-group-append">
                                                        <button class="btn btn-primary" type="submit"><i class="fa fa-search fa-6"
                                                                aria-hidden="true"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="table-responsive">
                                    <table class="table mb-3 border">
                                        <thead>
                                            <tr>
                                                <th><strong>S.N</strong></th>
                                                <th><strong>Registration No.</strong></th>
                                                <th><strong>Name</strong></th>
                                                <th><strong>Applied Date</strong></th>
                                                <th><strong>Program Name</strong></th>
                                                <th><strong>Action</strong></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($result['program_wise_students'] as $program_wise)
                                                <tr>
                                                    <td><strong>{{ $result['count']++ }}</strong></td>
                                                    <td><strong>{{ $program_wise->id }}</strong></td>
                                                    <td><strong>{{ $program_wise->user_info->first_name }}
                                                            {{ $program_wise->user_info->middle_name }}
                                                            {{ $program_wise->user_info->last_name }}</strong></td>
                                                    <td><strong>{{ $program_wise->created_at }}</strong></td>
                                                    <td><strong>{{ $program_wise->program->name }}</strong></td>
                                                    <td><a
                                                            href="{{ route('operator-applicant-profile', $program_wise->user->id) }}"><i
                                                                class="fas fa-eye"></i></a></td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-4 col-sm-12 col-xs-12"> Showing {{ $result['from_data'] }} to
                                        {{ $result['to_data'] }} of
                                        {{ $result['total_data'] }}
                                        records. </div>
                                    <div class="col-md-8 col-sm-12 col-xs-12">
                                        <div class="float-end">
                                            {{ $result['program_wise_students']->links('pagination::bootstrap-4') }}
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
