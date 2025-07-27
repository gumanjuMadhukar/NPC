@extends('student.layout')
@section('content')

<div class="content" id="student-dashboard">
    <div class="container-fluid">
        <div class="row">
            @if ($has_exams)
                @foreach ($exams as $exam)
                    <div class="col-lg-12 col-md-8">
                        <div class="card border-primary mb-3">
                            <div class="card-header">
                                <strong>{{ $exam['exam_name'] }}</strong> || 
                                <strong>Applied Date: {{ $exam['applied_date'] }}</strong>
                            </div>

                            <div class="card-header mb-2"><strong>Document Status</strong></div>
                            <div class="card-body">
                                <div class="hori-timeline" dir="ltr">
                                    <ul class="events">
                                        @foreach ($exam['timeline'] as $step)
                                            <li class="event-list">
                                                <div class="inner status-{{ $step['status'] }}">
                                                    @if ($step['status'])
                                                        <span class="icon" style="color:green">
                                                            <i class="fa-solid fa-circle-check"></i>
                                                        </span>
                                                    @endif
                                                    <h3 class="font-size-16">{{ ucfirst(str_replace('_', ' ', $step['state'])) }}</h3>
                                                    <h4 class="text-capitalize">-{{ $step['status'] }}-</h4>
                                                    <hr style="color:white">
                                                    <div class="mb-2"></div>

                                                    @foreach ($step['logs'] as $log)
                                                        @if ($log['timestamp'])
                                                            <span style="font-size:14px;font-style:italic;background:#ffffff80;padding:4px;border-radius:3px;">
                                                                {{ $log['timestamp'] }}
                                                            </span>
                                                        @endif
                                                        <p> - {{ $log['remarks'] }}</p>
                                                    @endforeach
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                @endforeach
            @else
                <div class="col-lg-12 col-md-8">
                    <div class="card border-primary mb-3">
                        <div class="card-header"><strong>Notice</strong></div>
                        <div class="card-body text-primary">
                            <h3 class="card-title">You have not applied for any exams.</h3>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<style>
    .status-rejected {
        background-color: #ff5959 !important;
        color: #e7e7e7 !important;
    }
    .status-rejected h4 {
        color: #fff;
    }
    .status-accepted {
        background-color: #6bff59ab !important;
        color: #3c3c3c !important;
    }
    .status-accepted h4 {
        color: #238f00;
    }
    .status-pending,
    .status-onhold {
        background-color: #fcff25ab !important;
        color: #3c3c3c !important;
    }
    .status-pending h4,
    .status-onhold h4 {
        color: #35778b;
    }
    .status-progress,
    .status-re-exam {
        background-color: #6fcaffab !important;
        color: #3c3c3c !important;
    }
    .status-progress h4,
    .status-re-exam h4 {
        color: #0072ff;
    }
</style>

@endsection
