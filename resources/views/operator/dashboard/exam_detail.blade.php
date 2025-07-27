@extends('operator.layout')
@section('content')
    <div class="content" id="exam-detail-page">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-12 col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <h3>{{ $page_title }} - {{$exam_name}}</h3>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div>
                                <div class="title">
                                    <h3>Student Detail</h3>
                                </div>
                                <div class="table-responsive">
                                    <table class="table mb-3 border">
                                        <tr>
                                            <td><strong>1</strong></td>
                                            <td><strong>Total Applied Student</strong></td>
                                            <td><strong>{{ $applicant_count }}</strong></td>
                                        </tr>
                                        <tr>
                                            <td><strong>2</strong></td>
                                            <td><strong>Rejected Student</strong></td>
                                            <td><strong>{{ $rejected_count }}</strong></td>
                                            <td><a href="{{ route('operator-dashboard-exam-statuswise-detail', ['status' => 'rejected', 'exam_id' => $exam_id]) }}"><i class="fas fa-eye"></i></strong></a></td>
                                        </tr>
                                        <tr>
                                            <td><strong>3</strong></td>
                                            <td><strong>Failed Student</strong></td>
                                            <td><strong>{{ $failed_count }}</strong></td>
                                        </tr>
                                        <tr>
                                            <td><strong>4</strong></td>
                                            <td><strong>Re-Exam Applied Student</strong></td>
                                            <td><strong>{{ $re_exam_count }}</strong></td>
                                            <td><a href="{{ route('operator-dashboard-exam-statuswise-detail', ['status' => 're-exam', 'exam_id' => $exam_id]) }}"><i class="fas fa-eye"></i></strong></a></td>
                                        </tr> 
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div>
                                <div class="title">
                                    <h3>Computer Operator State</h3>
                                </div>
                                <div class="table-responsive">
                                    <table class="table mb-3 border">
                                        <tr>
                                            <td><strong>1</strong></td>
                                            <td><strong>Operator Student</strong></td>
                                            <td><strong>{{ $operator_student_count }}</strong></td>
                                        </tr>
                                        <tr>
                                            <td><strong>2</strong></td>
                                            <td><strong>Operator Accepted Student</strong></td>
                                            <td><strong>{{ $operator_accepted_count }}</strong></td>
                                        </tr>
                                        <tr>
                                            <td><strong>3</strong></td>
                                            <td><strong>Operator Rejected Student</strong></td>
                                            <td><strong>{{ $operator_rejected_count }}</strong></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div>
                                <div class="title">
                                    <h3>Level Wise Count</h3>
                                </div>
                                <div class="table-responsive">
                                    <table class="table mb-3 border">
                                        <tr>
                                            <td><strong>1</strong></td>
                                            <td><strong>Master</strong></td>
                                            <td><strong>{{ $master_count }}</strong></td>
                                        </tr>
                                        <tr>
                                            <td><strong>2</strong></td>
                                            <td><strong>Bachelor</strong></td>
                                            <td><strong>{{ $bachelor_count }}</strong></td>
                                        </tr>
                                        <tr>
                                            <td><strong>3</strong></td>
                                            <td><strong>PCL / +2</strong></td>
                                            <td><strong>{{ $second_level_count }}</strong></td>
                                        </tr>
                                        <tr>                                                                                                                                                                         
                                            <td><strong>4</strong></td>
                                            <td><strong>T-SLC Count</strong></td>
                                            <td><strong>{{ $tslc_count }}</strong></td>
                                        </tr>
                                        <tr>
                                            <td><strong>5</strong></td>
                                            <td><strong>SLC Count</strong></td>
                                            <td><strong>{{ $slc_count }}</strong></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div>
                                <div class="title">
                                    <h3>Subject Committee Count</h3>
                                </div>
                                <div class="table-responsive">
                                    <table class="table mb-3 border">
                                        @foreach ($subject_committee_counts as $index => $subjectCommittee)

                                        <tr>
                                            <td><strong>{{$index + 1}}</strong></td>
                                            <td><strong>{{ $subjectCommittee['code'] }}</strong></td>
                                            <td><strong>{{ $subjectCommittee['count'] }}</strong></td>
                                        </tr>
                                        @endforeach
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div>
                                <div class="title float-start">
                                    <div>
                                        <h3>Program wise Count</h3>
                                        <div class="float-end"> </div>
                                    </div>
                                </div>
                                <div class="dropdown float-end">
                                    <a href="{{route('operator-applicant-programwise-export', ['exam_id' => $exam_id])}}" class="btn btn-primary" type="submit"><i class="fas fa-file-excel"></i> Export Excel </a>
                                </div>
                                <div class="clearfix"></div>
                                
                                <div class="table-responsive">
                                    <table class="table mb-3 border">
                                        @php 
                                        $sn = 1;
                                        @endphp
                                        @foreach ($program_wise_counts as $index => $program)
                                        @if($program['count']>0)
                                        <tr>
                                            <td><strong>{{$sn}}</strong></td>
                                            <td><strong>{{$program['program_name']}}</strong></td>
                                            <td><strong>{{$program['count']}}</strong></td>
                                            <td><a href="{{ route('operator-dashboard-program-detail', ['program_id' => $program['program_id'], 'exam_id' => $exam_id]) }}"><i class="fas fa-eye"></i></strong></a></td>
                                        </tr>
                                        @php
                                        $sn++;
                                        @endphp
                                        @endif
                                        @endforeach
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
