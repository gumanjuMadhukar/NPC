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
                        <form id="form" method="post" action="{{ route('student-profile-save-foreign_guardian') }}">
                            @csrf
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 mb-3">
                                    <label class="form-label">Father Name *</label>
                                    <input class="form-control" name="father_name" value="{{ $user->father_name ??  old('father_name') }}" type="text">
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 mb-3">
                                    <label class="form-label">Mother Name *</label>
                                    <input class="form-control" name="mother_name"  value="{{ $user->mother_name ??  old('mother_name') }}" type="text">
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 mb-3">
                                    <label class="form-label">Grandfather Name </label>
                                    <input class="form-control" name="grandfather_name" value="{{ $user->grandfather_name ??  old('grandfather_name') }}" type="text">
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
