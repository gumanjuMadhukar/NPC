@extends('operator.layout')
@section('content')

<style>
    .action{
        display: flex;
        justify-content: flex-end;
        a{
            font-size:16px;
            margin-right:10px;
        }
   }
</style>
<div class="content">
    <div class="container-fluid">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <h3>{{$page_title}}</h3>
                        </div>
                        <div class="col-md-6 action col-sm-6 col-xs-6">
                            <a class="btn btn-success text-xl" href="{{route('operator-certificate-foreign-addedit')}}" class="btn btn-primary float-end">
                                Add New
                                <i class="fa fa-user-plus"></i>
                            </a>
                            <a class="btn btn-warning text-xl"  href="{{route('operator-certificate-foreign-request-list')}}" class="btn btn-primary float-end">
                                Request List
                                  <i class="far fa-id-badge"></i>
                            </a>
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
                            <div class="col-md-3 col-sm-12">
                                <select class="form-select" name="is_printed">
                                    <option value="" @if($is_printed == "") selected @endif>Print Status</option>
                                    <option value="1" @if($is_printed == 1) selected @endif>Printed</option>
                                    <option value="0" @if($is_printed == 0) selected @endif>Not Printed</option>
                                </select>
                            </div>

                            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                            <script>
                                $(document).ready(function() {
                                    $('select[name="is_printed"]').val("");
                                });
                            </script>
                            <div class="col-md-9 col-sm-12">
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
                                    <th width="130">Date of Birth</th>
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
                                    <td>{{$certificate->name }}</td>
                                    <td>{{$certificate->user?->info->dob_eng}}</td>
                                    <td>{{$certificate->user?->info->citizenship_number}}</td>
                                    <td>{{$certificate->cert_registration_number}}</td>
                                    <td>{{$certificate->srn}}</td>
                                    <td>{{$certificate->user?->info->level->short_name_english}}</td>
                                    <td>{{$certificate->program? $certificate->program->name : $certificate->program_certificate_code}}</td>
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
                                            <a href="{{ route('operator-certificate-edit',$certificate->id) }}" class="btn text-warning" title="Edit" data-bs-toggle="tooltip" data-bs-placement="top">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            @if($certificate->user_id)
                                            <a href="{{ route('operator-id_card-profile', $certificate->user_id) }}" class="btn text-danger" title="ID card" data-bs-toggle="tooltip" data-bs-placement="top">
                                                <i class="far fa-id-badge"></i>
                                            </a>
                                            @endif
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
