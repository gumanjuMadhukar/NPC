@extends('examcommittee.layout')
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
                            {{-- <div class="float-end"> <a href="{{route('examcommittee-applicant-export', ['exam_id' => $exam_id, 'college_name' => $college_name, 'level_id' => $level_id, 'program_id' => $program_id, 'status' => $status])}}" class="btn btn-primary" type="submit"><i class="fas fa-file-excel"></i> Export Excel </a></div> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table mb-0 table-hover">
                            @foreach($result as $day=>$shifts)
                                <thead>
                                    <tr>
                                        <th colspan="2" style="text-align: center;">Day: {{ $day }}</th>
                                    </tr>
                                </thead>
                                @foreach($shifts as $shift=>$routines)
                                    <tr>
                                        <td>Shift: {{ $shift }}</td>
                                        <td>
                                            @foreach($routines as $routine)
                                                {{ $routine }} <br>
                                            @endforeach
                                        </td>
                                    </tr>
                                @endforeach
                            @endforeach        
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('footer-scripts')
@include('examcommittee.applicant.js.list')
@endsection