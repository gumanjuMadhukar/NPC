@extends('subjectcommittee.layout')
@section('content')
<div class="content">
    <div class="container-fluid">
        @include('subjectcommittee.applicant.user_info')
        @include('subjectcommittee.applicant.qualifications')
        @include('subjectcommittee.applicant.documents')
        @include('subjectcommittee.applicant.status')
        @include('subjectcommittee.applicant.exam_apply')
    </div>
</div>
@endsection
@section('footer-scripts')
@include('subjectcommittee.applicant.js.user')
@endsection
