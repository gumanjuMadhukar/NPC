@extends('subjectcommittee.layout')
@section('content')
    {{-- @php
dd($level_wise_students_count)
@endphp --}}
    <style>
        .card {
            .info {
                display: flex;
                gap: 5px;
                flex-direction: column;

                .info-item {
                    display: flex;
                    align-items: baseline;
                    justify-content: space-between;
                    .title{
                        color: red;
                    }
                    .title, p{
                        margin: 0;
                    }
                }
            }
        }
    </style>
    <div class="content">
        <!-- Start Content-->
        <div class="container-fluid">
            <div class="row">
                @foreach ($level_wise_students_count as $item)
                    <div class="col-xl-3 col-md-3 col-sm-12">
                        <div class="card">
                            <div class="card-body">
                                <a href="{{ route('subject_committee-applicant-list-level', $item['level_id']) }}">
                                    <h5 class="mt-0 mb-3">{{ $item['name'] }}</h5>
                                    <div class="widget-box-2 info d-flex">
                                        <div class="info-item">
                                            <h4 class="title"> {{ $item['count'] }} </h4>
                                            <p class="text-muted">Total Students</p>
                                        </div>
                                        <div class="info-item">
                                            <h4 class="title"> {{ $item['progress_count'] }} </h4>
                                            <p class="text-muted">In progress</p>
                                        </div>
                                        <div class="info-item">
                                            <h4 class="title"> {{ $item['accepted_count'] }} </h4>
                                            <p class="text-muted">Accepted</p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <!-- container-fluid -->
    </div>
@endsection
