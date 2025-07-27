@extends('operator.layout')
@section('content')
<div class="content">
    <div class="container-fluid">
        @include('operator.applicant.user_info')
        @include('operator.applicant.qualifications')
        @include('operator.applicant.documents')
        @include('operator.applicant.status')
        @include('operator.applicant.forward')
        @include('operator.applicant.exam_apply')
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
@include('operator.applicant.js.user')
@endsection
