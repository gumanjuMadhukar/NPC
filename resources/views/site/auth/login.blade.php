@extends('site.layout')
@section('content')
<div class="card">
    <div class="card-body p-4">
        <div class="text-center mb-4">
            <h3 class="fw-bold text-dark">Member Login</h3>
            <p class="text-muted">Enter your credentials to access your account.</p>
        </div>
        <form id="form" method="post" action="{{ route('auth-checkLogin') }}" class="form">
            <div class="form-floating">
                <input type="text" name="email" class="form-control" placeholder="Enter Your Email">
                <label>Enter Your Email *</label>
            </div>
            <div class="_fi3ld" id="show_hide_password">
                <div class="form-floating">
                    <input type="password" name="password" placeholder="Password" class="form-control"
                        spellcheck="false" autocorrect="off" autocapitalize="off">
                    <label>Password *</label>
                    <div class="eyeicon" data-password="false">
                        <span class="password-eye"></span>
                    </div>
                </div>
            </div>
            <div class="mb-3 d-grid text-center">
                <button class="btn btn-primary btn-loading" type="submit"> Log In </button>
            </div>
            <hr/>
            <div class="row">
                <div class="col-md-6 col-sm-6 col-xs-6">
                    <div class="mb-3 d-grid text-center">
                        <a href="{{route('auth-register',[0])}}" class="btn btn-info py-2"> Register</a>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-6">
                    <div class="mb-3 d-grid text-center">
                        <a href="{{route('auth-register',[1])}}" class="btn btn-info py-2"> Foreign Register</a>
                    </div>
                </div>
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="mb-3 d-grid text-center">
                        <a href="{{route('auth-forgot-password')}}" class="btn btn-danger py-2"> Forgot Password?</a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
@section('footer-scripts')
@include('site.auth.js.login')
@endsection
