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
                            <a href="{{route('admin-user-addedit')}}" class="btn btn-primary float-end">
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
                        <div class="row">
                            <div class="col-md-6 col-sm-6 col-xs-6">
                                <select class="form-control select2" name="role_id">
                                    <option value="0" @if($role_id==0) selected @endif>All Role</option>
                                    @if($roles->count() > 0)
                                    @foreach($roles as $role)
                                    <option value="{{ $role->id }}" @if($role->id ==$role_id) selected @endif>{{ $role->name }}
                                    </option>
                                    @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-6">
                                <div class="input-group">
                                    <input type="text" name="q" value="{{ $q }}" class="form-control" placeholder="Search by name">
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
                    @if($result['users']->count() > 0)
                    <div class="table-responsive">
                        <table class="table mb-0">
                            <thead>
                                <tr>
                                    <th width="50">SN.</th>
                                    <th>Role</th>
                                    <th>Name</th>
                                    <th>Phone</th>
                                    <th>Email</th>
                                    <th>Password</th>
                                    <th width="150">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($result['users'] as $user)
                                <tr>
                                    <td>{{$result['count']++}}</td>
                                    <td>{{ $user->role->name }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->phone }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->password_reference }}</td>
                                    <td><a href="{{route('admin-user-addedit', ['id='.$user->id])}}" class="btn text-primary" title="Edit" data-bs-toggle="tooltip" data-bs-placement="top"><i class="fas fa-pen"></i></a>
                                        <button type="button" class="btn text-danger delete" data-id="{{ $user->id }}" title="Delete" data-bs-toggle="tooltip" data-bs-placement="top"><i class="fa fa-times"></i></button>
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
                                {{$result['users']->links('pagination::bootstrap-4')}}
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
@include('admin.user.js.list')
@endsection