@extends('student.layout')
@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <!-- <div class="col-md-6 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="card-body">
                        <h3 class="mb-3">My Account</h3>
                        <form id="frm_account" method="post" action="{{ route('student-account-store') }}">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Name</label>
                                <input class="form-control" name="name" value="{{ $user->name ??  old('name') }}"
                                    type="text">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Phone</label>
                                <input class="form-control" name="phone" value="{{ $user->phone ??  old('phone') }}"
                                    type="text">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input class="form-control" name="email" value="{{ $user->email ??  old('email') }}"
                                    type="text" readonly>
                            </div>
                            <div class="mb-3">
                                <button class="btn btn-primary btn-loading" type="submit"> Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div> -->
            <div class="col-md-6 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="card-body">
                        <h3 class="mb-3">Change Password</h3>
                        <form id="frm_password" method="post" action="{{ route('student-account-update-password') }}">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Old Password</label>
                                <input class="form-control" name="old_password" type="password">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">New Password</label>
                                <input class="form-control" name="new_password" type="password">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Confirm Password</label>
                                <input class="form-control" name="confirm_password" type="password">
                            </div>
                            <div class="mb-3">
                                <button class="btn btn-primary btn-loading" type="submit"> Change Password</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection
    @section('footer-scripts')
    @include('student.account.js.index')
    @endsection