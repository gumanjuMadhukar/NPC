@extends('operator.layout')
@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 col-sm-6 col-xs-6">
                                <h3>{{ $page_title }}</h3>
                            </div>
                            {{-- <div class="col-md-6 col-sm-6 col-xs-6">
                            <a href="{{route('operator-kyc-addedit')}}" class="btn btn-primary float-end">
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
                        <form method="get" action="">
                            <div class="input-group">
                                <input type="text" name="q" value="{{ $q }}" class="form-control"
                                    placeholder="Search by name">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="submit"><i class="fa fa-search fa-6"
                                            aria-hidden="true"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        @if ($result['kycs']->count() > 0)
                            <div class="table-responsive">
                                <table class="table mb-0">
                                    <thead>
                                        <tr>
                                            <th width="50">SN.</th>
                                            <th>Symbol Number</th>
                                            <th>Name</th>
                                            <th>DOB</th>
                                            <th width="150">Profile</th>
                                            <th width="150">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($result['kycs'] as $kyc)
                                            <tr>
                                                <td>{{ $result['count']++ }}</td>
                                                <td>{{ $kyc->symbol_number }}</td>
                                                <td>{{ $kyc->name }}</td>
                                                <td>{{ $kyc->dob }}</td>
                                                <td>
                                                    <div class="document-image mt-0"> <a href="{{ $kyc->full_profile_img }}"
                                                            data-fancybox="image"><img style="border-radius:50px; height: 45px; width:45px"
                                                                src="{{ $kyc->full_profile_img }}"></a>
                                                    </div>
                                                </td>
                                                <td class=" ">
                                                    <a href="{{ route('operator-applicant-profile', $kyc->user->id) }}"
                                                        class="btn btn-outline-primary" title="View" data-bs-toggle="tooltip"
                                                        data-bs-placement="top">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <button class="btn text-danger delete-kyc" title="Delete" data-bs-toggle="tooltip" data-id="{{ $kyc->id }}"><i class="fas fa-trash"></i></button>
                                                    {{-- <a href="{{ route('operator-kyc-delete', $kyc->id) }}"
                                                        class="btn btn-danger" title="delete" data-bs-toggle="tooltip"
                                                        data-bs-placement="top">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </a> --}}
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
                                    records. </div>
                                <div class="col-md-8 col-sm-12 col-xs-12">
                                    <div class="float-end">
                                        {{ $result['kycs']->links('pagination::bootstrap-4') }}
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
    @include('operator.kyc.js.list')
@endsection
