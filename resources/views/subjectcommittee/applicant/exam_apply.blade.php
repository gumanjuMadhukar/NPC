@php use Illuminate\Support\Carbon;
 @endphp
@if(count($user->exam_applies) > 0)
<div class="col-12">
    <div class="card">
        <div class="card-body">
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <button class="nav-link active" id="nav-qualifications-tab" data-bs-toggle="tab"
                    data-bs-target="#nav-qualifications" type="button" role="tab" aria-controls="nav-qualifications"
                    aria-selected="true">Licence Exam Applied</button>
            </div>
            <div class="tab-pane fade show active" id="qualifications" role="tabpanel"
                aria-labelledby="qualifications-tab" tabindex="0">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="table-responsive">
                            <table class="table table-bordered" width="100%">
                                <thead>
                                    <tr>
                                        <td>S.N.</td>
                                        <td>Exam Name</td>
                                        <td>Voucher Image</td>
                                        <td>Applied Date (B.S. / AD)</td>
                                        <td>Program Name</td>
                                        <td>Level</td>
                                        <td>File Status</td>
                                        <td>Status Progress</td>
                                        <td>Symbol Number</td>
                                        <td width="120">Exam Status</td>
                                        {{-- <td>Action</td> --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $count = 1 @endphp
                                    @foreach($user->exam_applies as $exam_apply)
                                    @php
                                    if ($exam_apply->is_passed == 0 && $exam_apply->is_admit_card_generate == 1)
                                    $status = 'Failed';
                                    elseif ($exam_apply->isPassed == 0 && $exam_apply->attempt == '2')
                                    $status = 'Re Exam';
                                    elseif ($exam_apply->status == 'progress' && $exam_apply->state == 'exam_committee')
                                    $status =  'Re Exam';
                                    elseif ($exam_apply->status == 'progress' && $exam_apply->state == 'exam_committee')
                                    $status =  'Re Exam';
                                    elseif ($exam_apply->rejected == 1)
                                    $status =  'Rejeted';
                                    elseif ($exam_apply->state != 'subjectcommittee')
                                    $status =  'Accepted';
                                    else
                                    $status = 'New Applied';
                                    @endphp
                                    <tr>
                                        <td>{{$count++}}</td>
                                        <td>{{$exam_apply->exam?->name}}</td>
                                        <td> <img src="{{ $exam_apply->full_voucher_image }}" height="250"></td>
                                        <td>{{Carbon::parse($exam_apply->created_at)->format('Y-m-d')}}</td>
                                        <td>{{$exam_apply->program?->name}}</td>
                                        <td>{{$exam_apply->level?->name}}</td>
                                        <td>{{$exam_apply->state}}</td>
                                        <td>{{$exam_apply->status}}</td>
                                        <td></td>
                                        <td>{{$status}}</td>
                                        <!-- <td>
                                            <p><button type="button" class="btn btn-success exam_status"
                                                    data-id="{{ $exam_apply->id }}" data-status="accepted" title="Accept"
                                                    data-bs-toggle="tooltip" data-bs-placement="top">Accept</button></p>
                                            <p><button type="button" class="btn btn-danger exam_status"
                                                    data-id="{{ $exam_apply->id }}"  data-status="rejected"  title="Reject"
                                                    data-bs-toggle="tooltip" data-bs-placement="top">Reject</button></p>
                                        </td> -->
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endif