@php use Illuminate\Support\Carbon;
@endphp
<div class="row">
    <div class="col-md-3 col-sm-12">
        <div class="card">
            <div class="card-body">
                <div class="user-profile-box d-flex flex-column align-items-center">
                    <h3 class="text-capitalize">State : {{$exam_apply->state}}</h3>
                    <div class="image-preview">
                        <a href="{{ $user->info->full_profile_picture }}" data-fancybox="image"> <img style="height:250px; width:100% ; object-fit:contain;" src="{{ $user->info->full_profile_picture }}"></a>
                    </div>
                    <div class="profile-detail d-flex flex-column align-items-center">
                        <div class="mt-2">
                            <h3>{{$user->info->first_name}} {{$user->info->middle_name}}
                                {{$user->info->last_name}}
                            </h3>
                        </div>
                        <div class="mt-1">
                            {{$user->email}}
                        </div>
                        <div class="mt-1">
                            {{$user->phone}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-9">
        <div class="card">
            <div class="card-body">
                <ul class="nav nav-tabs" id="documentTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link  active" id="details-tab" data-bs-toggle="tab" data-bs-target="#details" type="button" role="tab" aria-controls="details" aria-selected="true">Detail Information</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="logs-tab" data-bs-toggle="tab" data-bs-target="#logs" type="button" role="tab" aria-controls="logs" aria-selected="true">Exam Logs</button>
                    </li>
                </ul>
                <div class="tab-content" id="documentTabContent">
                    <div class="tab-pane fade show active" id="details" role="tabpanel" aria-labelledby="details-tab"
                        tabindex="0">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <tbody>
                                            <tr>
                                                <td class="text-bold">Name</td>
                                                <td>{{ $user->info->first_name }}
                                                    {{ $user->info->middle_name }}
                                                    {{ $user->info->last_name }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-bold">Grand Father's Name</td>
                                                <td>{{ $user->info->grandfather_name }} |
                                                    {{ $user->info->grandfather_name_nep }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-bold">Father's Name</td>
                                                <td>{{ $user->info->father_name }} |
                                                    {{ $user->info->father_name_nep }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-bold">Mother's Name</td>
                                                <td>{{ $user->info->mother_name }} |
                                                    {{ $user->info->mother_name_nep }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-bold">Sex</td>
                                                <td>{{ $user->info->sex }} </td>
                                            </tr>
                                            <tr>
                                                <td class="text-bold">Marital Status</td>
                                                <td>{{ $user->info->marital_status }} </td>
                                            </tr>
                                            <tr>
                                                <td class="text-bold">Ethnicity</td>
                                                <td>{{ $user->info->ethinic }} </td>
                                            </tr>
                                            <tr>
                                                <td class="text-bold">Date of Birth (B.S.) </td>
                                                <td>{{ $user->info->dob_nep }} </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <tbody>
                                            <tr>
                                                <td class="text-bold">Citizenship Number</td>
                                                <td>{{ $user->info->citizenship_number }}</td>
                                            </tr>
                                            <tr>
                                                <td class="text-bold">Citizenship issue date</td>
                                                <td>{{ $user->info->citizenship_issue_date }}</td>
                                            </tr>
                                            <tr>
                                                <td class="text-bold">Citizenship Issue District</td>
                                                <td>{{ $user->info->citizenship_issue_district }}</td>
                                            </tr>
                                            <tr>
                                                <td class="text-bold">Province</td>
                                                <td>{{ $user->info->province?->name }} </td>
                                            </tr>
                                            <tr>
                                                <td class="text-bold">District</td>
                                                <td>{{ $user->info->district?->name }} </td>
                                            </tr>
                                            <tr>
                                                <td class="text-bold">Municipality</td>
                                                <td>{{ $user->info->municipality?->name }} </td>
                                            </tr>
                                            <tr>
                                                <td class="text-bold">Ward No</td>
                                                <td>{{ $user->info->ward_no }} </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="logs" role="tabpanel" aria-labelledby="logs-tab" tabindex="0">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="table-responsive">
                                    <table class="table table-bordered" style="width:100%">
                                        <tbody>
                                            <tr>
                                                <th class="text-bold" style="width:15%">State</th>
                                                <th class="text-bold" style="width:10%">Status</th>
                                                <th class="text-bold" style="width:15%">Date</th>
                                                <th style="width:60%">Remarks</th>
                                            </tr>
                                            @foreach (['operator', 'officer', 'registrar', 'subject_committee', 'exam_committee'] as $state)
                                            @php $lastLog = $exam_logs->where('state', $state)->sortByDesc('id')->first(); @endphp
                                            @if($state == 'operator')
                                            @php $status = ($lastLog) ? $lastLog->status : 'progress'; @endphp
                                            @else
                                            @php $status = ($lastLog) ? $lastLog->status : ''; @endphp
                                            @endif
                                            <tr>
                                                <td class="text-bold">{{ ucfirst(str_replace('_', ' ', $state)) }}</td>
                                                <td> @if ($status) {{$status}} @else -- @endif </td>
                                                <td>
                                                    @foreach ($exam_logs->where('state', $state) as $exam_log)
                                                    <p>{{Carbon::parse($exam_log->created_at)->format('Y-m-d')}}</p>
                                                    @endforeach
                                                </td>
                                                <td>
                                                    @if($exam_logs->count() == 0 && $state == 'operator' && $status == 'progress')
                                                    <p>Under Review</p>
                                                    @endif
                                                    @if($exam_logs->count() > 0)
                                                    @foreach ($exam_logs->where('state', $state) as $exam_log)
                                                    <p>{{$exam_log->remarks}}</p>
                                                    @endforeach
                                                    @endif
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
    </div>
</div>