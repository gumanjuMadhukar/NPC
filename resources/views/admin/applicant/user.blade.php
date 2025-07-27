@extends('admin.layout')
@section('content')
<div class="content">
    <div class="container-fluid">
        @include('admin.applicant.user_info')
        @include('admin.applicant.qualifications')
        @include('admin.applicant.documents')
        @include('admin.applicant.exam_apply')
    </div>
</div>
@endsection
@section('footer-scripts')
@include('admin.applicant.js.user')
@endsection
