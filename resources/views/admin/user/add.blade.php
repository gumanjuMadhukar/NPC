@extends('admin.layout')
@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="col-8">
            <div class="card">
                <div class="card-body">
                    <form enctype="multipart/form-data" method="post" action="{{$action}}" id="form">
                        @csrf
                        <input type="hidden" class="form-control" name="id" value="{{ ($row) ? $row->id : 0 }}">
                        <div class="mb-3">
                            <label class="form-label"> Role</label>
                            <select class="form-control select2" name="role_id">
                                @if($roles->count() > 0)
                                @foreach($roles as $role)
                                <option value="{{ $role->id }}" @if($row && $row->role_id ==
                                    $role->id) selected @endif>{{ $role->name }}
                                </option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input type="text" class="form-control" name="name"
                                value="{{ ($row) ? $row->name : old('name')}}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="text" class="form-control" name="email"
                                value="{{ ($row) ? $row->email : old('email')}}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Phone</label>
                            <input type="text" class="form-control" name="phone"
                                value="{{ ($row) ? $row->phone : old('phone')}}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="text" class="form-control" name="password"
                                value="{{ ($row) ? $row->password_reference : old('password')}}">
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-sm-6">
                                <div class="mb-3">
                                    <label class="form-label">Status</label>
                                    <label class="switch">
                                        <input type="checkbox" class="switch-input" name="status" value="1"
                                            {{ ($row && $row->status == 1) ||  (!$row) ? 'checked' : '' }} /> <span
                                            class="switch-label" data-on="Show" data-off="Hide"></span>
                                        <span class="switch-handle"></span> </label>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary  btn-loading">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('footer-scripts')
@include('admin.user.js.add')
@endsection
