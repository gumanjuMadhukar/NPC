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
                            <div class="col-md-12">
                                <div class="input-group">
                                    <input type="text" name="q" value="{{ $q }}" class="form-control" placeholder="Search by name">
                                    <div class="input-group-append">
                                        <button class="btn btn-primary" type="submit"><i class="fa fa-search fa-6" aria-hidden="true"></i>
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
                                    <th width="50">SN.</th>
                                    <th>Name</th>
                                    <th width="130">Citizenship</th>
                                    <th width="130">Registration Number</th>
                                    <th width="130">Serial No</th>
                                    <th>Level</th>
                                    <th>Program</th>
                                    <th>Status</th>
                                    <th width="">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($result['certificates'] as $certificate)
                                <tr>
                                    <td>{{$result['count']++}}</td>
                                    <td>{{@$certificate->user?->info->first_name }} {{ @$certificate->user?->info->middle_name}} {{@$certificate->user?->info->last_name }}</td>
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
                                            @if($certificate->user_id)
                                            <a href="{{ route('operator-id_card-profile', $certificate->id) }}" class="btn text-danger" title="ID card" data-bs-toggle="tooltip" data-bs-placement="top">
                                                <i class="far fa-id-badge"></i>
                                            </a>
                                            @endif
                                            @if($certificate->is_printed)
                                            <a href="{{ route('operator-duplicate_certificate_view', $certificate->id) }}" class="btn text-success" title="Duplicate" data-bs-toggle="tooltip" data-bs-placement="top">
                                                <i class="fas fa-file"></i>
                                            </a>
                                            @endif
                                            <button class="btn text-danger delete-certificate" title="Delete" data-bs-toggle="tooltip" data-id="{{ $certificate->id }}"><i class="fas fa-trash"></i></button>
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