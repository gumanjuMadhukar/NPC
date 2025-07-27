@extends('council.layout')
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
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <div class="float-end"> <a href="{{route('council-certificate-form')}}" class="btn btn-primary" type="submit"><i class="fas fa-file-excel"></i> Move to Darta </a></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    @if($result['applicants']->count() > 0)
                    <div class="table-responsive">
                        <table class="table mb-0">
                            <thead>
                                <tr>
                                    <th width="50">SN.</th>
                                    <th>Name</th>
                                    <th>Symbol No.</th>
                                    <th>Program</th>
                                    <th width="70">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($result['applicants'] as $applicant)
                                <tr>
                                    <td>{{$result['count']++}}</td>
                                    <td>{{$applicant->user_info->first_name }} {{ $applicant->user_info->middle_name}} {{ $applicant->user_info->last_name }}</td>
                                    <td>{{$applicant->admit_card?->symbol_number}}</td>
                                    <td>{{$applicant->program->name}}</td>
                                    <td>
                                        <a href="{{ route('officer-applicant-profile', $applicant->user->id) }}" class="btn text-primary" title="View" data-bs-toggle="tooltip" data-bs-placement="top">
                                            <i class="fas fa-eye"></i>
                                        </a>
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
                                {{$result['applicants']->links('pagination::bootstrap-4')}}
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
@include('council.applicant.js.list')
@endsection