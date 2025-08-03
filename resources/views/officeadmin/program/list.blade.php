@extends('officeadmin.layout')
@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <h3>{{$page_title}}</h3>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <a href="{{route('office_admin-program-addedit')}}" class="btn btn-primary float-end">
                                Add New
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form method="get" action="">
                        <div class="input-group">
                            <input type="text" name="q" value="{{ $q }}" class="form-control"
                                placeholder="Search by name">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="submit"><i class="fa fa-search fa-6"
                                        aria-hidden="true"></i>
                                </button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    @if($result['programs']->count() > 0)
                    <div class="table-responsive">
                        <table class="table mb-0">
                            <thead>
                                <tr>
                                    <th width="50">SN.</th>
                                    <th>Program Name</th>
                                    <th>Certificate Name</th>
                                    <th>Qualification</th>
                                    <th width="150">Status</th>
                                    <th width="150">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($result['programs'] as $program)
                                <tr>
                                <tr>
                                    <td>{{$result['count']++}}</td>
                                    <td>{{ $program->name }}</td>
                                    <td>{{ $program->certificate_name }}</td>
                                    <td>{{ $program->qualification }}</td>
                                    <td>
                                        <label class="switch">
                                            <input class="switch-input switch-status" type="checkbox"
                                                data-id="{{ $program->id }}" data-status-value="{{ $program->status }}"
                                                @if($program->
                                            status == 1) checked @endif /> <span class="switch-label" data-on="Show"
                                                data-off="Hide"></span> <span class="switch-handle"></span> </label>
                                    </td>
                                    <td>
                                        <a href="{{route('office_admin-program-addedit', ['id='.$program->id])}}"
                                            class="btn text-primary" title="Edit" data-bs-toggle="tooltip"
                                            data-bs-placement="top"><i class="fas fa-pen"></i></a>
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
                            records. </div>
                        <div class="col-md-8 col-sm-12 col-xs-12">
                            <div class="float-end">
                                {{$result['programs']->links('pagination::bootstrap-4')}}
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
@include('officeadmin.program.js.list')
@endsection