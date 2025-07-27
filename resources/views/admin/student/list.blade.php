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
                    @if($result['students']->count() > 0)
                    <div class="table-responsive">
                        <table class="table mb-0">
                            <thead>
                                <tr>
                                    <th width="50">SN.</th>
                                    <th>Name</th>
                                    <th>Contact</th>
                                    <th>CItizenship Id.</th>
                                    <th>Email</th>
                                    <th>Password</th>
                                    <th width="150">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($result['students'] as $student)
                                <tr>
                                <tr>
                                    <td>{{$result['count']++}}</td>
                                    <td>{{ $student->name }}</td>
                                    <td>{{ $student->phone }}</td>
                                    <td>{{ $student->citizenship }}</td>
                                    <td>{{ $student->email }}</td>
                                    <td>{{ $student->password_reference }}</td>
                                    <td><button type="button" class="btn text-danger delete"
                                            data-id="{{ $student->id }}" title="Delete" data-bs-toggle="tooltip"
                                            data-bs-placement="top"><i class="fa fa-times"></i></button>
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
                                {{$result['students']->links('pagination::bootstrap-4')}}
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
@include('admin.student.js.list')
@endsection