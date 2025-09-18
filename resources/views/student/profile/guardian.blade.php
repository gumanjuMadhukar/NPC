@extends('student.layout')
@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    @include('student.profile.breadcrumb')
                    @include('student.profile.note')
                    <div class="card">
                        <div class="card-body">
                            <h3 class="mb-3">{{ $page_title}}</h3>
                            <form id="form" method="post" action="{{ route('student-profile-save-guardian') }}">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 mb-3">
                                        <label class="form-label">Father Name *</label>
                                        <input class="form-control" name="father_name"
                                            value="{{ $user->father_name ?? old('father_name') }}" type="text">
                                    </div>
                                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 mb-3">
                                        <label class="form-label">बुबाको नाम</label>
                                        <input class="form-control" name="father_name_nep"
                                            value="{{ $user->father_name_nep ?? old('father_name_nep') }}" type="text">
                                    </div>
                                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 mb-3">
                                        <label class="form-label">Father Number</label>
                                        <input class="form-control" name="father_number"
                                            value="{{ $user->father_number ?? old('father_number') }}" type="text">
                                    </div>
                                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 mb-3">
                                        <label class="form-label">Father Email</label>
                                        <input class="form-control" name="father_email"
                                            value="{{ $user->father_email ?? old('father_email') }}" type="text">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 mb-3">
                                        <label class="form-label">Mother Name *</label>
                                        <input class="form-control" name="mother_name"
                                            value="{{ $user->mother_name ?? old('mother_name') }}" type="text">
                                    </div>
                                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 mb-3">
                                        <label class="form-label">आमाको नाम</label>
                                        <input class="form-control" name="mother_name_nep"
                                            value="{{ $user->mother_name_nep ?? old('mother_name_nep') }}" type="text">
                                    </div>
                                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 mb-3">
                                        <label class="form-label">Mother Number</label>
                                        <input class="form-control" name="mother_number"
                                            value="{{ $user->mother_number ?? old('mother_number') }}" type="text">
                                    </div>
                                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 mb-3">
                                        <label class="form-label">Mother Email</label>
                                        <input class="form-control" name="mother_email"
                                            value="{{ $user->mother_email ?? old('mother_email') }}" type="text">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 mb-3">
                                        <label class="form-label">Grandfather Name *</label>
                                        <input class="form-control" name="grandfather_name"
                                            value="{{ $user->grandfather_name ?? old('grandfather_name') }}" type="text">
                                    </div>
                                    <div class="col-lg-3 col-md-3 col-sm-12  mb-3">
                                        <label class="form-label">हजुरबुबाको नाम </label>
                                        <input class="form-control" name="grandfather_name_nep"
                                            value="{{ $user->grandfather_name_nep ?? old('grandfather_name_nep') }}"
                                            type="text">
                                    </div>
                                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 mb-3">
                                        <label class="form-label">Grandfather Number</label>
                                        <input class="form-control" name="grandfather_number"
                                            value="{{ $user->grandfather_number ?? old('grandfather_number') }}"
                                            type="text">
                                    </div>
                                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 mb-3">
                                        <label class="form-label">Grandfather Email</label>
                                        <input class="form-control" name="grandfather_email"
                                            value="{{ $user->grandfather_email ?? old('grandfather_email') }}" type="text">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 mb-3">
                                        <label class="form-label">Spouse Name *</label>
                                        <input class="form-control" name="spouse_name"
                                            value="{{ $user->spouse_name ?? old('spouse_name') }}" type="text">
                                    </div>
                                    <div class="col-lg-3 col-md-3 col-sm-12  mb-3">
                                        <label class="form-label">पति/पत्नीको नाम </label>
                                        <input class="form-control" name="spouse_name_nep"
                                            value="{{ $user->spouse_name_nep ?? old('spouse_name_nep') }}" type="text">
                                    </div>
                                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 mb-3">
                                        <label class="form-label">Spouse Number</label>
                                        <input class="form-control" name="spouse_number"
                                            value="{{ $user->spouse_number ?? old('spouse_number') }}" type="text">
                                    </div>
                                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 mb-3">
                                        <label class="form-label">Spouse Email</label>
                                        <input class="form-control" name="spouse_email"
                                            value="{{ $user->spouse_email ?? old('spouse_email') }}" type="text">
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <a href="{{ route('student-profile-personal')}}" class="btn btn-primary"> Back</a>
                                    <button class="btn btn-primary btn-loading" type="submit"> Next</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection
    @section('footer-scripts')
        @include('student.profile.js.guardian')
    @endsection