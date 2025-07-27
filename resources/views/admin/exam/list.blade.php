@extends('admin.layout')
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
                            <a href="{{route('admin-exam-addedit')}}" class="btn btn-primary float-end">
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
                    @if($result['exams']->count() > 0)
                    <div class="table-responsive">
                        <table class="table mb-0">
                            <thead>
                                <tr>
                                    <th width="50">SN.</th>
                                    <th width="150">Opening Date</th>
                                    <th width="150">Closing Date</th>
                                    <th>Name</th>
                                    <th width="150">Status</th>
                                    <th width="150">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($result['exams'] as $exam)
                                <tr>
                                <tr>
                                    <td>{{$result['count']++}}</td>
                                    <td>{{ $exam->opening_date }}</td>
                                    <td>{{ $exam->closing_date }}</td>
                                    <td>{{ $exam->name }} <br/>
                                    @if($exam->description )<small>({{ $exam->description }})</small>@endif</td>
                                    <td>
                                        <label class="switch">
                                            <input class="switch-input switch-status" type="checkbox"
                                                data-id="{{ $exam->id }}" data-status-value="{{ $exam->status }}"
                                                @if($exam->
                                            status == 1) checked @endif /> <span class="switch-label" data-on="Show"
                                                data-off="Hide"></span> <span class="switch-handle"></span> </label>
                                    </td>
                                    <td>
                                        <a href="{{route('admin-exam-addedit', ['id='.$exam->id])}}"
                                            class="btn text-primary" title="Edit" data-bs-toggle="tooltip"
                                            data-bs-placement="top"><i class="fas fa-pen"></i></a>

                                            <a href="{{route('admin-dashboard-exam-detail', [$exam->id])}}"
                                            class="btn text-primary" title="Detail" data-bs-toggle="tooltip"
                                            data-bs-placement="top">  <i class="fas fa-eye"></i></a>
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
                                {{$result['exams']->links('pagination::bootstrap-4')}}
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
@include('admin.exam.js.list')
@endsection