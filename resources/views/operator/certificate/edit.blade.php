@extends('operator.layout')
@section('content')
    @phpuse Illuminate\Support\Carbon;
    @endphp

    <style>
        table,
        th,
        td {
            border: 1px solid black;
        }
    </style>
    <div class="content">
        <div class="container-fluid">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 col-sm-6 col-xs-6">
                                <h3>{{ $page_title }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div>
                    <button class="btn btn-primary waves-effect waves-light" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                        Edit Program Details
                    </button>
                </div>
                <div class="collapse" id="collapseExample">
                    <div class="card">
                        <div class="card-body">
                            <form enctype="multipart/form-data" method="post"
                                action="{{ route('operator-program-store') }}" id="form2">
                                @csrf
                                <input type="hidden" class="form-control" name="id"
                                    value="{{ $program ? $program->id : 0 }}">
                                <div class="row">
                                    <div class="col-md-3 col-sm-6">
                                        <div class="mb-3">
                                            <label class="form-label">Name</label>
                                            <input type="text" class="form-control" name="name"
                                                value="{{ $program ? $program->name : old('name') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-6">
                                        <div class="mb-3">
                                            <label class="form-label">Certificate Name</label>
                                            <input type="text" class="form-control" name="certificate_name"
                                                value="{{ $program ? $program->certificate_name : old('certificate_name') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-6">
                                        <label class="form-label">Code</label>
                                        <div class="mb-3">
                                            <input type="text" class="form-control" name="code"
                                                value="{{ $program ? $program->code : old('code') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-6">
                                        <div class="mb-3">
                                            <label class="form-label">Qualification</label>
                                            <input type="text" class="form-control" name="qualification"
                                                value="{{ $program ? $program->qualification : old('qualification') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-6">
                                        <div class="mb-3">
                                            <label class="form-label">Level</label>
                                            <select class="form-control select2" name="level_id">
                                                @if ($levels->count() > 0)
                                                    @foreach ($levels as $level)
                                                        <option value="{{ $level->id }}"
                                                            @if ($program && $program->level_id == $level->id) selected @endif>
                                                            {{ $level->name }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-6">
                                        <div class="mb-3">
                                            <label class="form-label"> Program Duration</label>
                                            <input type="text" class="form-control" name="program_duration"
                                                value="{{ $program ? $program->program_duration : old('program_duration') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-6">
                                        <div class="mb-3">
                                            <label class="form-label">Duration Type</label>
                                            <select class="form-control select2" name="duration_type" required>
                                                <option value="year" @if ($program && $program->duration_type == 'year') selected @endif>
                                                    Year</option>
                                                <option value="month" @if ($program && $program->duration_type == 'month') selected @endif>
                                                    Month</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-6">
                                        <div class="mb-3">
                                            <label class="form-label">Program Type</label>
                                            <select class="form-control select2" name="program_type">
                                                <option value="yearly" @if ($program && $program->program_type == 'yearly') selected @endif>
                                                    Yearly</option>
                                                <option value="semester" @if ($program && $program->program_type == 'semester') selected @endif>
                                                    Semester</option>

                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-6">
                                        <div class="mb-3">
                                            <label class="form-label">
                                                Subject Committee</label>
                                            <select class="form-control select2" name="subject_committee_id">
                                                @if ($subject_committees->count() > 0)
                                                    @foreach ($subject_committees as $subject_committee)
                                                        <option value="{{ $subject_committee->id }}"
                                                            @if ($program && $program->subject_committee_id == $subject_committee->id) selected @endif>
                                                            {{ $subject_committee->name }}</option>
                                                    @endforeach
                                                @endif

                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-6">
                                        <div class="mb-3">
                                            <label class="form-label">Has Exam</label>
                                            <label class="switch">
                                                <input type="checkbox" class="switch-input" name="has_exam" value="1"
                                                    {{ ($program && $program->has_exam == 1) || !$program ? 'checked' : '' }} />
                                                <span class="switch-label" data-on="Yes" data-off="No"></span>
                                                <span class="switch-handle"></span> </label>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-6">
                                        <div class="mb-3">
                                            <label class="form-label">Status</label>
                                            <label class="switch">
                                                <input type="checkbox" class="switch-input" name="status"
                                                    value="1"
                                                    {{ ($program && $program->status == 1) || !$program ? 'checked' : '' }} /> <span
                                                    class="switch-label" data-on="Show" data-off="Hide"></span>
                                                <span class="switch-handle"></span> </label>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary  btn-loading">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">

            </div>
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form method="POST" action="{{ url('operator/certificate/store', $certificate->id) }}"
                            id="form">
                            @csrf
                            <input type="hidden" name="id" value="{{ $certificate->id }}">
                            <input type="hidden" name="user_info_id" value="{{ $certificate->user->info->id }}">
                            <div class="header" style="text-align: center; font-weight: 500;">
                                <span class="p" style="font-size: 22px; font-weight: 700;">
                                    Schedule -3 <br>
                                    (Relating to sub rule (1) of Rule 10)
                                </span>
                                <h3
                                    style="margin-top: 5px;
                            font-size: 40px;
                            font-weight: 700;
                            line-height: 0.9;">
                                    Nepal Health Professional Council <br>
                                    <span style="font-weight: 700;font-size: 22px !important;">
                                        Bansbari, Kathmandu, Nepal
                                    </span>
                                </h3>
                            </div>
                            <div id="container"
                                style=" margin-top: 22px; display: flex; justify-content: space-between; align-items: center;">
                                <div class="col-side" id="col1"
                                    style="flex: 0 0 122px;  width: 22px !important;
                            height: 122px;
                            border: 1px solid black;
                            margin-right: 22px;
                            display: flex;
                            justify-content: center;
                            align-items: center;
                            ">
                                    <div style="width: 100%; height:100%">
                                        <div class="row">
                                            <div class="form-group col-md-12 col-lg-12">
                                                <div class="drag-container">
                                                    <button type="button"
                                                        class="{{ $certificate->user->info?->profile_picture ? 'd-block' : 'd-none' }} img-delete-btn"
                                                        onclick="imageDelete('profile_picture')"
                                                        id="btn_profile_picture_delete"><i
                                                            class="fa fa-times"></i></button>
                                                    <div class="drag-area drag-area-profile_picture" style="height:116px">
                                                        <div
                                                            class="dropify-message dropify-message-profile_picture {{ $certificate->user->info?->profile_picture ? 'd-none' : 'd-block' }}">
                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1"
                                                                x="0px" y="0px" width="64px" height="64px"
                                                                viewBox="0 0 64 64" enable-background="new 0 0 64 64"
                                                                xml:space="preserve">
                                                                <path fill="none" stroke="#8a8a8a" stroke-width="2"
                                                                    stroke-miterlimit="10"
                                                                    d="M41,50h14c4.565,0,8-3.582,8-8s-3.435-8-8-8  c0-11.046-9.52-20-20.934-20C23.966,14,14.8,20.732,13,30c0,0-0.831,0-1.667,0C5.626,30,1,34.477,1,40s4.293,10,10,10H41" />
                                                                <polyline fill="none" stroke="#8a8a8a"
                                                                    stroke-width="2" stroke-linejoin="bevel"
                                                                    stroke-miterlimit="10"
                                                                    points="23.998,34   31.998,26 39.998,34 " />
                                                                <g>
                                                                    <line fill="none" stroke="#8a8a8a"
                                                                        stroke-width="2" stroke-miterlimit="10"
                                                                        x1="31.998" y1="26" x2="31.998"
                                                                        y2="46" />
                                                                </g>
                                                            </svg>
                                                            <p>Click here to upload image</p>
                                                        </div>
                                                        <input name="profile_picture" type="hidden" id="profile_picture"
                                                            value="{{ $certificate->user->info->profile_picture ?? old('profile_picture') }}"
                                                            class="file-input" />
                                                        <div class="image-preview p-0">
                                                            @if ($certificate->user->info?->profile_picture)
                                                                <img style="object-fit:contain;width:100%; object-position:center; height:auto;"src="{{ $certificate->user->info?->full_profile_picture }}"
                                                                    id="display_profile_picture" class="preview-image">
                                                            @else
                                                                <img src="" id="display_profile_picture"
                                                                    class="d-none preview-image">
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <input type="file" style="display:none" id="drag-profile_picture"
                                                        class="drag-image" accept="image/*" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col" id="col2"
                                    style="flex: 2; background-color: blue;
                            justify-content: center;
                            padding-left: 0.3rem;
                            font-size: 30px;
                            font-weight: 600;
                            border: 2px solid black; color:white;">
                                    Registration Certificate
                                </div>
                                <div class="col-side" id="col3"
                                    style="flex: 0 0 122px;width: 22px !important;
                            height: 122px;
                            border: 1px solid black;
                            margin-left: 22px;
                            display: flex;
                            justify-content: center;
                            align-items: center;
                            ">
                                    Photo
                                </div>
                            </div>

                            <p class="body"
                                style=" text-align: justify;
                        font-weight: 600;
                        font-size: 20px;
                        margin-top: 50px;
                        line-height: 1;
                        ">
                                Pursuant to the decision dated {{ date('d-m-Y', strtotime($certificate['decision_date'])) }}
                                of the Council, the name of
                                <span style="font-size: 26px; font-weight: 600;">
                                    <input type="text" name="first_name"
                                        value="{{ $certificate->user->info->first_name }}" />
                                    <input type="text" name="middle_name"
                                        value="{{ $certificate->user->info->middle_name }}" />
                                    <input type="text" name="last_name"
                                        value="{{ $certificate->user->info->last_name }}" />
                                </span> date of birth
                                <input type="text" name="dob_nep" value="{{ $certificate->user->info->dob_nep }}" />
                                a resident ward No.
                                <span style="font-size: 26px; font-weight: 700;">
                                    <input type="text" name="ward_no"
                                        value="{{ $certificate->user->info->ward_no }}" />
                                </span> of
                                <span style="font-size: 26px; font-weight: 700;">
                                    <select class="form-select select2" name="municipality_id" style="min-width: 300px;">
                                        @foreach ($municipalities as $municipality)
                                            <option value="{{ $municipality->id }}"
                                                @if ($municipality->id == $certificate->user->info->municipality_id) selected @endif>{{ $municipality->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </span>
                                Metropolitan City /Sub-Metropolitan City /Municipality /Rural Municipality
                                <span style="font-size: 26px; font-weight: 700;">
                                    <select class="form-select select2" name="district_id" style="min-width: 300px;">
                                        @foreach ($districts as $district)
                                            <option value="{{ $district->id }}"
                                                @if ($district->id == $certificate->user->info->district_id) selected @endif>{{ $district->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </span>
                                District
                                <span style="font-size: 26px; font-weight: 700;">
                                    <select class="form-select select2" name="province_id" style="min-width: 300px;">
                                        <option value="">Select Your Province</option>
                                        @foreach ($provinces as $province)
                                            <option value="{{ $province->id }}"
                                                @if ($province->id == $certificate->user->info->province_id) selected @endif>{{ $province->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </span>
                                Province is registered as
                                <span style="font-size: 26px; font-weight: 700;">
                                    <select class="form-select select2" name="program_id" style="min-width: 300px;">
                                        @foreach ($programs as $program)
                                            <option value="{{ $program->id }}"
                                                @if ($program->id == $certificate->program_id) selected @endif>{{ $program->qualification }}
                                            </option>
                                        @endforeach
                                    </select>
                                </span>
                                of
                                <span style="font-size: 26px; font-weight: 700;">
                                    <select name="level_id" style="min-width: 300px;">
                                        @foreach ($levels as $level)
                                            <option value="{{ $level->id }}"
                                                @if ($level->id == $certificate->level_id) selected @endif>
                                                {{ $level->short_name_english }}</option>
                                        @endforeach
                                    </select>
                                </span>
                                Level in the registration book and this Registration Certificate is hereby
                                issued in accordance with subsection (4) of section 17 of the Nepal
                                Health Professional Council Act, 2053 B.S. (1997 A.D.) and Rule 10 of the Nepal Health
                                Professional
                                Council Rules 2056 B.S. (1999 A.D.)
                            </p>

                            <div class="" style="height: 130px; display: block; ">
                                <div class="left"
                                    style="font-weight: 700; line-height: 1.2;   text-align: left; font-size:18px ;float: left;">
                                    Registration No:
                                    <span style="font-size: 26px;">
                                        <input type="text" name="cert_registration_number"
                                            value="{{ $certificate['cert_registration_number'] }}" />
                                    </span>
                                    <br>
                                    Date of issue:
                                    <span style="font-size: 22px;">
                                        <input type="text" name="issued_date"
                                            value="{{ date('d-m-Y', strtotime($certificate['issued_date'])) }}" />
                                    </span>
                                    <br>
                                    </span><br>
                                    Seal of the Council:
                                </div>
                                <div class="right"
                                    style="font-weight: 600;
                            margin-top: 50px;
                            text-align: center;
                            font-size:22px ;
                            line-height: 1;
                            float: right;">
                                    <span style="font-size:20px; margin-right: 190px;">
                                        Signature:
                                    </span>
                                    <br>
                                    Name:
                                    <span style="font-weight: 700; font-size: 20px; ">
                                        <input type="text" name="registrar" value="{{ $certificate->registrar }}" />
                                    </span>
                                    <br>
                                    <span style="font-weight: 700; font-size: 20px;">
                                        Registrar</span>
                                </div>
                            </div>
                            <div class="" style="text-align: center; margin-top: 30px;">
                                <span style="text-align: center; font-weight: bold; font-size: 14px;">Descriptions of
                                    Qualifications / Degree</span>
                            </div>
                            <table style="text-align: center; border-collapse: collapse; width: 100%;">
                                <tr style="text-align: center;">
                                    <th style="text-align: center; font-size:14px ; font-weight: bold;">S.N</th>
                                    <th style="text-align: center; font-size:14px ; font-weight: bold;">Qualification</th>
                                    <th style="text-align: center;font-size:14px ;font-weight: bold;">Institution /
                                        University / Board</th>
                                    <th style="text-align: center; font-size:14px ;font-weight: bold;">Passed Year</th>
                                </tr>
                                @php $key = 0; @endphp
                                @foreach ($qualifications as $key => $qualification)
                                    <tr style="text-align: center;">
                                        <input type="hidden" name="qualification[{{ $key }}][id]"
                                            value="{{ $qualification['id'] }}">
                                        <td
                                            style=" border: 1px solid black; text-align: center;  font-size: 20px; font-weight: bold;">
                                            {{ $key + 1 }}</td>
                                        <td
                                            style=" border: 1px solid black; text-align: center;  font-size: 20px; font-weight: bold;">
                                            <select name="qualification[{{ $key }}][program_id]"
                                                style="min-width: 300px;">
                                                @foreach ($programs as $program)
                                                    <option value="{{ $program->id }}"
                                                        @if ($program->id == $certificate->program_id) selected @endif>
                                                        {{ $program->code }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td
                                            style=" border: 1px solid black; text-align: center;  font-size: 20px; font-weight: bold;">
                                            <input type="text"
                                                name="qualification[{{ $key }}][board_university]"
                                                value="{{ @$qualification['board_university'] }}" />
                                        </td>
                                        <td
                                            style=" border: 1px solid black; text-align: center;  font-size: 20px; font-weight: bold;">
                                            <input type="text" name="qualification[{{ $key }}][passed_year]"
                                                value="{{ @$qualification['passed_year'] }}" />
                                        </td>
                                    </tr>
                                @endforeach
                                <tr style="text-align: center;">
                                    <td
                                        style=" border: 1px solid black; text-align: center;  font-size: 20px; font-weight: bold;">
                                        {{ ++$key + 1 }}</td>
                                    <td
                                        style=" border: 1px solid black; text-align: center;  font-size: 20px; font-weight: bold;">
                                        <select name="qualification[{{ $key }}][program_id]"
                                            style="min-width: 300px;">
                                            <option value="">select</option>
                                            @foreach ($programs as $program)
                                                <option value="{{ $program->id }}">{{ $program->code }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td
                                        style=" border: 1px solid black; text-align: center;  font-size: 20px; font-weight: bold;">
                                        <input type="text" name="board_university" /></td>
                                    <td
                                        style=" border: 1px solid black; text-align: center;  font-size: 20px; font-weight: bold;">
                                        <input type="text" name="passed_year" /></td>
                                </tr>
                                <tr style="text-align: center;">
                                    <td
                                        style=" border: 1px solid black; text-align: center;  font-size: 20px; font-weight: bold;">
                                        {{ ++$key + 1 }}</td>
                                    <td
                                        style=" border: 1px solid black; text-align: center;  font-size: 20px; font-weight: bold;">
                                        <select name="qualification[{{ $key }}][program_id]"
                                            style="min-width: 300px;">
                                            <option value="">select</option>
                                            @foreach ($programs as $program)
                                                <option value="{{ $program->id }}">{{ $program->code }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td
                                        style=" border: 1px solid black; text-align: center;  font-size: 20px; font-weight: bold;">
                                        <input type="text" name="board_university" /></td>
                                    <td
                                        style=" border: 1px solid black; text-align: center;  font-size: 20px; font-weight: bold;">
                                        <input type="text" name="passed_year" /></td>
                                </tr>
                            </table>
                            <hr style=" margin-top: 45px; border: 1px solid black;">
                            <div class="" style="text-align: center;">
                                <span
                                    style="text-align: center; font-weight: 600; font-size: 16px; word-spacing: 1.6;">Note:
                                    - This certificate should be updated in every five years, from the date of issue.</span>
                            </div>
                            <button type="submit" class="btn btn-primary float-left mt-2">
                                <i class="fa fa-check"></i>
                                Save
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <style>
        .select2{
            width: 300px!important;
        }
    </style>

@endsection
@section('footer-scripts')
    @include('operator.certificate.js.update')
@endsection
