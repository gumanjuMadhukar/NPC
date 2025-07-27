@extends('site.layout')
@section('content')
<div class="card">
    <div class="card-body p-4 text-start">
        <form id="form" method="post" action="{{ route('auth-register-save') }}">
            @csrf
            <div class="mb-3 text-center ">
                <label class="form-label {{ $is_foreign == 0 ? 'd-none' :''  }} text-center">Foreigners</label>
                <input type="text" class="form-control d-none" name="is_foreign" value="{{old('is_foreign') ?? $is_foreign}}">
            </div>
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
                        <button class="btn btn-primary btn-loading" type="submit"> {{ $is_foreign == 0 ? 'Register' : 'Register as Foreign' }}</button>
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
@include('site.auth.js.register')
@endsection
