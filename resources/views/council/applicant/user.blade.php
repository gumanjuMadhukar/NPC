@extends('council.layout')
@section('content')
<div class="content">
    <div class="container-fluid">
        @include('council.applicant.user_info')
        @include('council.applicant.qualifications')
        @include('council.applicant.documents')
        @include('council.applicant.exam_apply')
        @include('council.applicant.certificate_history')
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
@include('council.applicant.js.user')
@endsection
