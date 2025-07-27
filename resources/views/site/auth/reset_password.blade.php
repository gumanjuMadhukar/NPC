@extends('site.layout')
@section('content')
<div class="card">
    <div class="card-body p-4">
        <div class="mb-4">
            <h4 class="text-uppercase mt-0">Reset Password</h4>
        </div>
        <form id="form" method="post" action="{{ route('auth-save-password') }}" class="form">
            @csrf
            <div class="form-floating">
                <input type="text" name="otp" value="{{old('otp')}}" class="form-control" placeholder="OTP">
                <label>OTP *</label>
            </div>
            <div class="form-floating">
                <input type="password" name="new_password" value="{{old('new_password')}}"
                    value="{{old('new_password')}}" class="form-control" placeholder="New password">
                <label>New password *</label>
            </div>
            <div class="form-floating">
                <input type="password" name="password_confirmation" value="{{old('password_confirmation')}}"
                    class="form-control" placeholder="Confirm password">
                <label>Confirm Password*</label>
            </div>
            <div class="mb-3 d-grid text-center">
                <button class="btn btn-primary btn-loading" type="submit"> Change
                    Password</button>
            </div>
        </form>
    </div>
</div>
@endsection
@section('footer-scripts')
@include('site.auth.js.reset')
@endsection