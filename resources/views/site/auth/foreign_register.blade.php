@extends('site.layout')
@section('content')
<div class="card">
    <div class="card-body p-4 text-start">
        <form id="form" method="post" action="{{ route('auth-register-save') }}">
            @csrf
            <div class="mb-3">
                <label class="form-label">Name</label>
                <input type="text" class="form-control" name="name" value="{{old('name')}}">
            </div>
            <div class="mb-3">
                <label class="form-label">Phone</label>
                <input type="text" class="form-control" name="phone" value="{{old('phone')}}">
            </div>
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="text" class="form-control" name="email" value="{{old('email')}}">
            </div>
            <div class="mb-3">
                <label class="form-label">Foreign</label>
                <label class="switch">
                    <input type="checkbox" class="switch-input" name="is_foreign" value="1" disabled
                        {{ ($row && $row->is_foreign == 1) ||  (!$row) ? 'checked' : '' }} /> <span
                        class="switch-label" data-on="Show" data-off="Hide"></span>
                    <span class="switch-handle"></span> </label>
            </div>
            <div class="mb-3">
                <label class="form-label">Password</label>
                <div class="input-group input-group-merge">
                    <input type="password" name="password" class="form-control" placeholder="Enter your password">
                    <div class="input-group-text" data-password="false">
                        <span class="password-eye"></span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 col-sm-6 col-xs-6">
                    <div class="d-grid text-center">
                        <button class="btn btn-primary btn-loading" type="submit"> Register</button>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-6">
                    <div class="d-grid text-center">
                        <a href="{{route('auth-login')}}" class="btn btn-info">Already registered? </a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
@section('footer-scripts')
@include('site.auth.js.foreign_register')
@endsection
