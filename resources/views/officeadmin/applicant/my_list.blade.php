@extends('officeadmin.layout')
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
                            <div class="float-end"> <a href="{{route('office_admin-applicant-export', ['exam_id' => $exam_id, 'college_name' => $college_name, 'level_id' => $level_id, 'program_id' => $program_id, 'status' => $status])}}" class="btn btn-primary" type="submit"><i class="fas fa-file-excel"></i> Export Excel </a></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form method="get" action="">
                        <div class="row">
                            <div class="col-md-3 col-sm-6 col-xs-12">
                                <select class="form-select select2" name="exam_id">
                                    <option value="0" @if($exam_id==0) selected @endif>All </option>
                                    <option value="tslc" @if($exam_id=="tslc") selected @endif>TSLC</option>
                                    @if($exams->count() > 0)
                                    @foreach($exams as $exam)
                                    <option value="{{ $exam->id }}" @if($exam->id == $exam_id) selected @endif>{{ $exam->name }}
                                    </option>
                                    @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="col-md-3 col-sm-6 col-xs-12">
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
                            {{-- <div class="col-md-3 col-sm-6 col-xs-12">
                                <select class="form-select select2" name="college_name">
                                    <option value="" @if($college_name=="") selected @endif>All Colleges</option>
                                    @if($colleges->count() > 0)
                                    @foreach($colleges as $college)
                                    <option value="{{ $college->name }}" @if($college->name == $college_name) selected @endif>{{ $college->name }}
                                    </option>
                                    @endforeach
                                    @endif
                                </select>
                            </div> --}}
                            <div class="col-md-3 col-sm-6 col-xs-12">
                                <select class="form-select select2" name="program_id">
                                    <option value="" @if($program_id=="") selected @endif>All Programs</option>
                                    @if($programs->count() > 0)
                                    @foreach($programs as $program)
                                    <option value="{{ $program->id }}" @if($program->id == $program_id) selected @endif>{{ $program->name }}
                                    </option>
                                    @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="col-md-3 col-sm-6 col-xs-12">
                                <div class="input-group">
                                    <input type="text" name="q" value="{{ $q }}" class="form-control" placeholder="Search : ">
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
                    @if($result['applicants']->count() > 0)
                    <div class="table-responsive">
                        <table class="table mb-0">
                            <thead>
                                <tr>
                                    <th width="50">SN.</th>
                                    <th>Name</th>
                                    <th width="130">Citizenship</th>
                                    <th width="100">Date of Birth</th>
                                    <th>Email</th>
                                    <th>Exam Name</th>
                                    <th>Applied Date</th>
                                    <th>Level</th>
                                    <th>Status</th>
                                    <th>State</th>
                                    <th width="70">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($result['applicants'] as $applicant)
                                <tr>
                                    <td>{{$result['count']++}}</td>
                                    <td>{{$applicant->user_info->first_name }} {{ $applicant->user_info->middle_name}} {{ $applicant->user_info->last_name }}</td>
                                    <td>{{$applicant->user_info->citizenship_number}}</td>
                                    <td>{{$applicant->user_info->dob_nep}}</td>
                                    <td>{{$applicant->user->email}}</td>
                                    <td>{{$applicant->exam->name ?? 'TSLC' }}</td>
                                    <td>{{Carbon::parse($applicant->created_at)->format('Y-m-d')}}</td>
                                    <td>{{$applicant->level->short_name_english}}</td>
                                    <td><span style="
                                    @if ($applicant->status == 'accepted') background-color: green;
                                    @elseif ($applicant->status == 'rejected') background-color: red;
                                    @elseif ($applicant->status == 'progress') background-color: #00a1ff;
                                    @elseif ($applicant->status == 're-exam') background-color: #ff7600;
                                    @elseif ($applicant->status == 're-check') background-color: #ff7600;
                                    @elseif ($applicant->status == 'onhold')background-color: grey;
                                    @elseif ($applicant->status == 'pending')background-color: grey;
                                    @endif
                                    color:#fff;
                                    padding:3px;
                                    border-radius:4px;
                                    ">{{ucwords($applicant->status)}}</span></td>
                                    <td>{{$applicant->state}}</td>
                                    <td>
                                        <a href="{{ route('office_admin-applicant-profile', $applicant->user->id) }}" class="btn text-primary" title="View" data-bs-toggle="tooltip" data-bs-placement="top">
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
@include('officeadmin.applicant.js.list')
@endsection
