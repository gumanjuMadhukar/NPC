@extends('operator.layout')
@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <h3>{{$page_title}}</h3>
                        </div>
                        {{-- <div class="col-md-6 col-sm-6 col-xs-6">
                            <a href="{{route('operator-certificate-foreign-addedit')}}" class="btn btn-primary float-end">
                                Add New
                            </a>
                        </div> --}}
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
                    @if($result['foreign_requests']->count() > 0)
                    <div class="table-responsive">
                        <table class="table mb-0">
                            <thead>
                                <tr>
                                    <th width="50">SN.</th>
                                    <th>Name</th>
                                    <th>Voucher image</th>
                                    <th width="130">Citizenship</th>
                                    <th>Level</th>
                                    <th>Program</th>
                                    <th>Status</th>
                                    <th width="">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($result['foreign_requests'] as $req_list)
                                <tr>
                                    <td>{{$result['count']++}}</td>
                                    <td>{{$req_list->user?->name }}</td>
                                    <td>
                                        <div class="document-image mt-0"> <a href="{{ $req_list->full_voucher_image }}"
                                                data-fancybox="image"><img style="border-radius:50px; height: 45px; width:45px"
                                                    src="{{ $req_list->full_voucher_image }}"></a>
                                        </div>
                                    </td>
                                    {{-- <td><a href="{{ $req_list->full_voucher_image }}" data-fancybox="image"><img style="height:170px" src="{{ $req_list->full_voucher_image }}" height="250"></a></td> --}}
                                    <td>{{$req_list->user?->info->citizenship_number}}</td>
                                    <td>{{$req_list->level->name}}</td>
                                    <td>{{$req_list->program->name}}</td>
                                    <td><span style="
                                    @if ($req_list->is_printed == 1) background-color: green; 
                                    @else ($req_list->status == 'rejected') background-color: red; 
                                    @endif
                                    color:#fff;
                                    padding:3px;
                                    border-radius:4px;
                                    ">@if ($req_list->status == 1 ) Created
                                    @else Pending
                                    @endif</span></td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{ route('operator-applicant-profile', $req_list->user_id) }}" class="btn text-primary"     title="Profile" data-bs-toggle="tooltip" data-bs-placement="top">
                                                <i class="fa fa-address-book"></i>
                                            </a>
                                        </div>
                                        <div class="btn-group">
                                            <a href="{{ route('operator-certificate-foreign-addedit',['id='.$req_list->user_id]) }}" class="btn text-warning" title="Edit" data-bs-toggle="tooltip" data-bs-placement="top">
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
                                {{$result['foreign_requests']->links('pagination::bootstrap-4')}}
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