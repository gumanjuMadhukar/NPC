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
                                        <td>Online Payment</td>
                                        <td>Applied Date (B.S./AD)</td>
                                        <td>Last Updated (B.S./AD)</td>
                                        <td>Program Name</td>
                                        <td>Level</td>
                                        <td>File Status</td>
                                        <td>Status Progress</td>
                                        <td>Symbol Number</td>
                                        <td width="120">Exam Status</td>
                                        <td>Action</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $count = 1 @endphp
                                    @foreach($user->exam_applies as $exam_apply)
                                    @php
                                    if ($exam_apply->is_passed == 0 && $exam_apply->is_admit_card_generate == 1)
                                    $status = 'Failed';
                                    elseif ($exam_apply->is_passed == 0 && $exam_apply->attempt >= 2)
                                    $status = 'Re Exam';
                                    elseif ($exam_apply->status == 'progress' && $exam_apply->state == 'exam_committee')
                                    $status =  'Re Exam';
                                    elseif ($exam_apply->rejected == 1)
                                    $status =  'Rejeted';
                                    elseif ($exam_apply->state != 'officeadmin')
                                    $status =  'Accepted';
                                    else
                                    $status = 'New Applied';
                                    @endphp
                                    <tr
                                    style="
                                    @if ($exam_apply->level_id == 1) background-color:#7ce97c;
                                    @elseif ($exam_apply->level_id == 2) background-color:#8deaed;
                                    @elseif ($exam_apply->level_id == 3) background-color:yellow;
                                    @elseif ($exam_apply->level_id == 4) background-color:#ff8acc;
                                    @elseif ($exam_apply->level_id == 5) background-color:yellow;
                                    @endif
                                    ">
                                        <td>{{$count++}}</td>
                                        <td>{{$exam_apply->exam?->name}}</td>
                                        <td><a href="{{ $exam_apply->full_voucher_image }}" data-fancybox="image"><img style="height:170px" src="{{ $exam_apply->full_voucher_image }}" height="250"></a></td>
                                        <td>{{$exam_apply->payment?->total_amount}}</td>
                                        <td>{{Carbon::parse($exam_apply->created_at)->format('Y-m-d')}}</td>
                                        <td>{{Carbon::parse($exam_apply->updated_at)->format('Y-m-d')}}</td>
                                        <td>{{$exam_apply->program?->name}}</td>
                                        <td>{{$exam_apply->level?->name}}</td>
                                        <td>{{$exam_apply->state}}</td>
                                        <td>{{$exam_apply->status}}</td>
                                        <td>{{@$exam_apply->admit_card->symbol_number}}</td>
                                        <td>{{$status}}</td>
                                        <td>
                                            <!-- @if(@$exam_apply->exam->status == 1 || !$exam_apply->exam)
                                            <p><button type="button" class="btn btn-primary" data-id="{{ $exam_apply->id }}"  data-bs-toggle="modal"  data-bs-target="#statusModal">Accept / Reject</button></p>
                                                    @endif -->
                                            <p><a href="{{ route('office_admin-applicant-apply-form', $exam_apply->id) }}"  class="btn btn-success">Edit</a></p>
                                            <p><button class="btn btn-danger delete-applicant_apply" data-id="{{ $exam_apply->id }}">Delete</button></p>
                                        </td>
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
