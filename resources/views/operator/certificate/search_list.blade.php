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
                    <form method="get">
                        <div class="row">
                            <div class="col-md-2 col-sm-6 col-xs-12">
                                <select class="form-select select2" name="level_id">
                                    <option value="0" @if($level_id==0) selected @endif>All Levels</option>
                                    @if($levels->count() > 0)
                                    @foreach($levels as $level)
                                    <option value="{{ $level->id }}" @if($level->id == $level_id) selected @endif>{{ $level->short_name_english }}
                                    </option>
                                    @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="col-md-2 col-sm-6 col-xs-12">
                                <select class="form-select select2" name="program_id">
                                    <option value="0" @if($program_id==0) selected @endif>All Programs</option>
                                    @if($programs->count() > 0)
                                    @foreach($programs as $program)
                                    <option value="{{ $program->id }}" @if($program->id == $program_id) selected @endif>{{ $program->name }}
                                    </option>
                                    @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="col-md-2 col-sm-6 col-xs-12">
                                <select class="form-select select2" name="decision_date">
                                    <option value="0" @if($decision_date==0) selected @endif>Decision Date</option>
                                    @if($decision_dates->count() > 0)
                                    @foreach($decision_dates as $date)
                                    <option value="{{ $date->decision_date }}" @if($date->decision_date == $decision_date) selected @endif>{{ $date->decision_date }}
                                    </option>
                                    @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="col-md-3 col-sm-6 col-xs-12">
                                <select class="form-select select2" name="is_printed">
                                    <option value="" @if($is_printed=="") selected @endif>All Certificates</option>
                                    <option value="1" @if($is_printed == 1) selected @endif>Printed</option>
                                    <option value="0" @if($is_printed == 0 ) selected @endif>Not Printed</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <div class="input-group">
                                    <input type="text" name="q" value="{{ $q }}" class="form-control" placeholder="Search by Name:">
                                    <div class="input-group-append">
                                        <button class="btn btn-primary" type="submit"><i class="fa fa-search fa-10" aria-hidden="true"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    @if($result['certificates']->count() > 0)
                    <div class="table-responsive">
                        <table class="table mb-0">
                            <thead>
                                <tr>
                                    <th width="40">SN.</th>
                                    <th>Name</th>
                                    <th>Decision Date</th>
                                    <th width="130">Citizenship</th>
                                    <th width="130">Registration Number</th>
                                    <th width="">Serial No</th>
                                    <th width="50">Level</th>
                                    <th width="180">Program</th>
                                    <th width="">Status</th>
                                    <th width="">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($result['certificates'] as $certificate)
                                <tr>
                                    <td>{{$result['count']++}}</td>
                                    <td>{{@$certificate->user?->info->first_name }} {{ @$certificate->user?->info->middle_name}} {{@$certificate->user?->info->last_name }}</td>
                                    <td>{{$certificate->decision_date}}</td>
                                    <td>{{$certificate->user?->info->citizenship_number}}</td>
                                    <td>{{$certificate->cert_registration_number}}</td>
                                    <td>{{$certificate->srn}}</td>
                                    <td>{{$certificate->user?->info->level->short_name_english}}</td>
                                    <td>{{$certificate->program->name}}</td>
                                    <td><span style="
                                    @if ($certificate->is_printed == 1) background-color: green; 
                                    @else ($certificate->status == 'rejected') background-color: red; 
                                    @endif
                                    color:#fff;
                                    padding:3px;
                                    border-radius:4px;
                                    ">@if ($certificate->is_printed) PRINTED
                                    @else NOT PRINTED
                                    @endif</span></td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{ route('operator-certificate-profile', $certificate->id) }}" class="btn text-primary"     title="Print" data-bs-toggle="tooltip" data-bs-placement="top">
                                                <i class="fas fa-print"></i>
                                            </a>
                                            <a href="{{ route('operator-certificate-edit', $certificate->id) }}" class="btn text-warning" title="Edit" data-bs-toggle="tooltip" data-bs-placement="top">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-4 col-sm-12 col-xs-12"> Showing {{ $result['from_data'] }} to
                            {{ $result['to_data'] }} of
                            {{ $result['total_data'] }}
                            records.
                        </div>
                        <div class="col-md-8 col-sm-12 col-xs-12">
                            <div class="float-end">
                                {{$result['certificates']->links('pagination::bootstrap-4')}}
                            </div>
                        </div>
                    </div>

                </div>
                @else
                <div class="alert alert-warning alert-message" role="alert">
                    No data found.
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
@section('footer-scripts')
@include('operator.certificate.js.list')
@endsection