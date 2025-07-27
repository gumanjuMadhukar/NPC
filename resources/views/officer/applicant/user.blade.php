@extends('officer.layout')
@section('content')
<div class="content">
    <div class="container-fluid">
        @include('officer.applicant.user_info')
        @include('officer.applicant.qualifications')
        @include('officer.applicant.documents')
        @include('officer.applicant.status')
        @include('officer.applicant.exam_apply')
    </div>
</div>
<div id="statusModal" class="modal fade" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content" id="modal-content">
        <div class="cardbox"><span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span> Loading...</div>
        </div>
    </div>
</div>
@endsection
@section('footer-scripts')
@include('officer.applicant.js.user')
@endsection
