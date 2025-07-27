@extends('council.layout')
@section('content')
@php use Illuminate\Support\Carbon;
@endphp
<div class="content">
    <div class="container-fluid">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <h3>{{$page_title}}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form method="get" action="">
                        <div class="row">
                            <div class="col-md-2 col-sm-6 col-xs-12">
                                <div class="input-group">
                                    <input type="text" name="q" value="{{ $q }}" class="form-control" placeholder="Search">
                                    <div class="input-group-append">
                                        <button class="btn btn-primary" type="submit"><i class="fa fa-search fa-6" aria-hidden="true"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    @if($result['applicants']->count() > 0)
                    <div class="table-responsive">
                        <table class="table mb-0">
                            <thead>
                                <tr>
                                    <th width="50">SN.</th>
                                    <th>Name</th>
                                    <th>Level</th>
                                    <th>Program</th>
                                    <th>Certificate Number</th>
                                    <th>registration Number</th>
                                    <th width="70">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($result['applicants'] as $applicant)
                                <tr>
                                    <td>{{$result['count']++}}</td>
                                    <td>{{ @$applicant->user->name}}</td>
                                    <td>{{ $applicant->level->short_name_english }}</td>
                                    <td>{{ $applicant->program->certificate_name }} - {{ $applicant->program->name}}</td>
                                    <td>{{ $applicant->cert_registration_number }}</td>
                                    <td>{{ $applicant->registration_id }}</td>
                                    <td>
                                        @if ($applicant->user_id)
                                        <a href="{{ route('council-applicant-profile', $applicant->user_id) }}" target="_blank"><i class="fa fa-eye"></i></a>
                                        @else
                                        Need to view old system
                                        @endif
                                    </td>
                                    
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-4 col-sm-12 col-xs-12"> Showing {{ $result['from_data'] }} to
                            {{ $result['to_data'] }} of
                            {{ $result['total_data'] }}
                            records.
                        </div>
                        <div class="col-md-8 col-sm-12 col-xs-12">
                            <div class="float-end">
                                {{$result['applicants']->links('pagination::bootstrap-4')}}
                            </div>
                        </div>
                    </div>

                </div>
                @else
                <div class="alert alert-warning alert-message" role="alert">
                    No data found.
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
@section('footer-scripts')
@include('council.applicant.js.list')
@endsection