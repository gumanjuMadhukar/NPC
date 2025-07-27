@extends('examcommittee.layout')
@section('content')
<div class="content">
    <div class="container-fluid">
        @include('examcommittee.applicant.user_info')
        @include('examcommittee.applicant.qualifications')
        @include('examcommittee.applicant.documents')
        @include('examcommittee.applicant.status')
        @include('examcommittee.applicant.exam_apply')
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
@include('examcommittee.applicant.js.user')
@endsection
