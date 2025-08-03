@extends('officeadmin.layout')
@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="col-8">
            <div class="card">
                <div class="card-body">
                    <form enctype="multipart/form-data" method="post" action="{{$action}}" id="form">
                        @csrf
                        <input type="hidden" class="form-control" name="id" value="{{ ($row) ? $row->id : 0 }}">
                        <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input type="text" class="form-control" name="name"
                                value="{{ ($row) ? $row->name : old('name')}}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Short Name In English</label>
                            <input type="text" class="form-control" name="short_name_english"
                                value="{{ ($row) ? $row->short_name_english : old('short_name_english')}}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Short Name In Nepali</label>
                            <input type="text" class="form-control" name="short_name_nepali"
                                value="{{ ($row) ? $row->short_name_nepali : old('short_name_nepali')}}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Code</label>
                            <input type="text" class="form-control" name="code"
                                value="{{ ($row) ? $row->code : old('code')}}">
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-sm-6">
                                <div class="mb-3">
                                    <label class="form-label">Order By</label>
                                    <input type="text" class="form-control" name="order"
                                        value="{{old('order' , ($row) ? $row->order : $order)}}">
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6">
                                <div class="mb-3">
                                    <label class="form-label">Status</label>
                                    <label class="switch">
                                        <input type="checkbox" class="switch-input" name="status" value="1"
                                            {{ ($row && $row->status == 1) ||  (!$row) ? 'checked' : '' }} /> <span
                                            class="switch-label" data-on="Show" data-off="Hide"></span>
                                        <span class="switch-handle"></span> </label>
                                </div>
                            </div>
                        </div>


                        <button type="submit" class="btn btn-primary  btn-loading">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('footer-scripts')
@include('officeadmin.level.js.add')
@endsection