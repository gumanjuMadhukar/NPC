@extends('council.layout')
@section('content')
<div class="content">
    <div class="container-fluid">
        @if(session('message'))
        <div class="card">
            <div class="card-body conatiner">
                <span class="text-justify text-danger">
                    {{ session('message') }}
                </span>
            </div>
        </div>

        @endif
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="card-body">
                        <h3 class="mb-3">{{ $page_title}}</h3>
                        <form id="form" method="post" action="{{ route('move_to_darta') }}">
                            @csrf

                            <div class="row">
                                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 mb-3">
                                    <label class="form-label">Date *</label>
                                    <input class="form-control" name="date" id="date" value=""
                                        type="text">
                                </div>
                                
                            </div>
                            <div class="mt-3 mb-3">
                                <button type="submit" class="btn btn-primary  btn-loading">Generate</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @endsection
    @section('footer-scripts')
    @include('council.certificate.js.form')
    @endsection