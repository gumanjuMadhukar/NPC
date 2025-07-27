@extends('site.layout')
@section('content')
        <div class="card">
            <div class="card-body p-4">
                <div class="mb-4">
                    <h4 class="text-uppercase mt-0">Forgot Password</h4>
                </div>
                <form id="form" method="post" action="{{ route('auth-otp') }}" class="form">
                    @csrf
                    <div class="form-floating">
                        <input type="text" name="email" class="form-control" placeholder="Enter Your Email">
                        <label>Enter Your Email *</label>
                    </div>
                    <div class="mb-3 d-grid text-center">
                        <button class="btn btn-primary btn-loading" type="submit"> Reset
                            Password</button>
                    </div>
                </form>
                <div class="row mb-3">
                    <div class="col-12 text-center">
                        <p> <a href="{{route('auth-login')}}" class="text-muted ms-1"> Back To Log
                                In</a></p>
                    </div>
                </div>
            </div>
        </div>
@endsection
@section('footer-scripts')
@include('site.auth.js.forgot')
@endsection