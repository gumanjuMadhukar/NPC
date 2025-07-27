@extends('operator.layout')
@section('content')
@php use Illuminate\Support\Carbon;
@endphp
<div class="content">
    <div class="container-fluid">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <h3>{{$page_title}}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form method="post" action="{{ route('operator-kyc-allocate_save', [$id,]) }}" id="allocate_form">
                        @csrf
                        <input name="id" value="{{ $id }}" type="hidden">
                        <div class="mb-3">
                            <label class="form-label">Search *</label>
                            <select class="form-select ajax-select2" name="user_id">
                                <option value="">Select</option>
                                @foreach($kyc_records as $kyc_record)
                                <option value="{{$kyc_record->id}}">{{$kyc_record->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary" id="allocate">Allocate</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('footer-scripts')
@include('operator.kyc.js.allocate')
@endsection