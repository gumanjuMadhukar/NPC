@extends('student.layout')
@section('content')

    @php
        use App\Models\ExamApply;
        use App\Models\Exam;
        use Illuminate\Support\Facades\Auth;

        $exam = ExamApply::where('user_id', Auth::Guard('student')->id())
            ->whereHas('exam', function ($qry) {
                $qry->where('status', 1);
            })
            ->orderBy('id', 'DESC')
            ->first();
    @endphp
    <div class="content" id="student-dashboard">

        <!-- Start Content-->
        <div class="container-fluid">
            <div class="row">
                @if ($exam && $exam->admit_card)
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <strong>Congratulations !!</strong>
                            </div>
                            <div class="card-body">
                                <strong>You document has been sucessfully reviewed and approved .You can download your admit
                                    card by clicking admit card button.</strong><br>
                                <strong>तपाईँको कागजात सफलतापूर्वक समीक्षा गरियो र स्वीकृत भयो। तपाईँले आफ्नो प्रवेश पत्र
                                    डाउनलोड गर्न "Admit Card" बटनमा क्लिक गर्न सक्नुहुन्छ।</strong><br>
                                <a class="btn btn-outline-danger" href="{{ route('student-admitcard') }}">
                                    <i class="mdi mdi-view-dashboard-outline"></i><span> Admit Card </span> </a>

                            </div>
                        </div>
                    </div>
                @endif
                @if (@$exam->status == 'rejected')
                    <div class="col-xl-12 col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <strong>Warning</strong>
                            </div>
                            <div class="card-body">
                                <div class="widget-chart-1">
                                    <div class="widget-chart-box-1 float-start">
                                        <h3 class="fw-normal">Your file has been rejected from <b
                                                class="text-capitalize">{{ $exam->state }}</b> for student
                                            review. Please review and update your documents. </h3>
                                        <h3>Steps: Go to profile and update
                                            press the submit button</h3>
                                        <br>
                                        <h3 class="fw-normal">तपाइँको फाइल विद्यार्थी समीक्षाको लागि <b
                                                class="text-capitalize">{{ $exam->state }}</b>बाट अस्वीकार गरिएको छ। कृपया
                                            आफ्नो कागजातहरू समीक्षा र अद्यावधिक गर्नुहोस्। </h3>
                                        <h3>चरणहरू: प्रोफाइलमा जानुहोस् र सबमिट बटन थिच्नुहोस् अपडेट गर्नुहोस्</h3>
                                    </div>
                                    <div class="widget-detail-1">
                                        <!-- <h2 class="fw-normal pt-2 mb-1"> 256 </h2> -->
                                        <!-- <p class="text-muted mb-1">Revenue today</p> -->
                                        <a href="{{ route('student-profile-personal') }}" class="btn btn-primary">Profile
                                            Update</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
            @endif
            <div class="row">
                @if ($exam)
                    <div class="col-lg-12 col-md-8">
                        <div class="card border-primary mb-3">
                            <div class="card-header"><strong>Notice</strong></div>
                            <div class="card-body text-primary">
                                <h3 class="card-title">You have successfully applied for {{$exam->name}} Liscence Exam
                                    (<span>{{ $exam->created_at }}</span>).You documents are
                                    under review.</h3>
                                <h3 class="card-title">{{$exam->name_nep}} लाइसेन्स परीक्षाको लागि सफलतापूर्वक आवेदन दिनुभएको छ।
                                    (<span>{{ $exam->created_at }}</span>)
                                    तपाईंका कागजातहरू समीक्षा अन्तर्गत छन्।</h3>
                                <p class="card-text"></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12">
                        <div class="card">
                            <div class="card-header mb-2"><strong>Document Status</strong></div>
                            <div class="card-body">
                                <div class="hori-timeline" dir="ltr">
                                    <ul class="events">
                                        @php $status='accepted' @endphp
                                        @foreach (['operator', 'officer', 'registrar', 'subject_committee', 'exam_committee', 'council'] as $state)
                                            @if ($exam->state == $state)
                                                @php $status = $exam->status @endphp
                                            @endif
                                            <li class="event-list">
                                                <div class="inner status-{{ $status }}">
                                                    @if ($status)
                                                        <span class="icon" style="color:green"><i
                                                                class="fa-solid fa-circle-check"></i></span>
                                                    @endif
                                                    <h3 class="font-size-16">{{ ucfirst(str_replace('_', ' ', $state)) }}
                                                    </h3>
                                                    <h4 class="text-capitalize">-@if ($status)
                                                            {{ $status }}
                                                        @endif -</h4>
                                                    <hr style="color:white">
                                                    <div class="mb-2"></div>
                                                    @if ($exam_logs->count() == 0 && $state == 'operator' && $status == 'progress')
                                                        <p>Under Review</p>
                                                    @endif
                                                    @if ($exam_logs->count() > 0)
                                                        @foreach ($exam_logs->where('state', $state) as $exam_log)
                                                            <span
                                                                style="font-size:14px;font-style:italic;background:#ffffff80;padding:4px;border-radius:3px;">{{ $exam_log->created_at }}</span>
                                                            <p> - {{ $exam_log->remarks }}</p>
                                                        @endforeach
                                                    @endif
                                                </div>
                                            </li>
                                            @if ($exam->state == $state)
                                                @php $status = '' @endphp
                                            @endif
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="col-lg-12 col-md-8">
                        <div class="card border-primary mb-3">
                            <div class="card-header"><strong>Notice</strong></div>
                            <div class="card-body text-primary">
                                <h3 class="card-title">You have not applied for the exam .</h3>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
    <!-- container-fluid -->

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
