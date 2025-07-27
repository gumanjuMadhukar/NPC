@extends('student.layout')
@section('content')

<div class="content" id="student-dashboard">
    <div class="container-fluid">
        <div class="row">
            @if ($exams->count() > 0)
                @foreach ($exams as $exam)
                    <div class="col-lg-12 col-md-8">
                        <div class="card border-primary mb-3">
                            <div class="card-header">
                                <strong>{{ $exam->exam->name ?? 'Exam' }}</strong> || 
                                <strong>Applied Date: {{ $exam->created_at->format('F j, Y') }}</strong>
                            </div>

                            <div class="card-header mb-2"><strong>Document Status</strong></div>
                            <div class="card-body">
                                <div class="hori-timeline" dir="ltr">
                                    <ul class="events">
                                        @php $status = 'accepted'; @endphp
                                        @foreach (['operator', 'officer', 'registrar', 'subject_committee', 'exam_committee', 'council'] as $state)

                                            @php
                                                // Set default status based on the current state
                                                $currentStatus = $status;
                                                $hideLogs = false;

                                                // If the current state is in the list and exam result_status is 0, change status to progress
                                                if ($exam->state === $state) {
                                                    $currentStatus = $exam->status;
                                                }

                                                // If exam.result_status is 0, hide logs for exam_committee and council
                                                if (in_array($state, ['exam_committee', 'council']) && optional($exam->exam)->result_status == 0) {
                                                    $currentStatus = 'progress'; // grey for progress
                                                    $hideLogs = true; // hide logs for these states if result_status is 0
                                                }
                                            @endphp

                                            <li class="event-list">
                                                <div class="inner status-{{ $currentStatus }}">
                                                    @if ($currentStatus)
                                                        <span class="icon" style="color:green">
                                                            <i class="fa-solid fa-circle-check"></i>
                                                        </span>
                                                    @endif
                                                    <h3 class="font-size-16">{{ ucfirst(str_replace('_', ' ', $state)) }}</h3>
                                                    <h4 class="text-capitalize">-{{ $currentStatus }}-</h4>
                                                    <hr style="color:white">
                                                    <div class="mb-2"></div>

                                                    {{-- Show logs for all exams when result_status is 1 --}}
                                                    @if (optional($exam->exam)->result_status == 1 || !$hideLogs)
                                                        @if ($exam->exam_logs->where('state', $state)->count() > 0)
                                                            @foreach ($exam->exam_logs->where('state', $state) as $exam_log)
                                                                <span style="font-size:14px;font-style:italic;background:#ffffff80;padding:4px;border-radius:3px;">
                                                                    {{ $exam_log->created_at->format('F j, Y H:i:s') }}
                                                                </span>
                                                                <p> - {{ $exam_log->remarks }}</p>
                                                            @endforeach
                                                        @elseif ($state == 'operator' && $currentStatus == 'progress')
                                                            <p>Under Review</p>
                                                        @endif
                                                    @endif
                                                </div>
                                            </li>

                                            @if ($exam->state === $state)
                                                @php $status = '' @endphp
                                            @endif
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                @endforeach
            @else
                <!-- If the student has not applied for any exams -->
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
        background-color: #d3d3d3 !important; /* grey */
        color: #3c3c3c !important;
    }
    .status-progress h4,
    .status-re-exam h4 {
        color: #666;
    }
</style>

@endsection
