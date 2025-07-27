@extends('operator.layout')
@section('content')
    @php
        use Illuminate\Support\Carbon;

        $address = $row?->address ?? ':::';
        $qualification = $row?->qualification ?? '::';
        // list($province, $district, $municipality, $ward_no) = explode(':', $row?->address);
        // list($program, $board_university, $passed_year) = explode(':', $row?->qualification);
        [$province, $district, $municipality, $ward_no] = array_pad(explode(':', $address), 4, '');
        [$program, $board_university, $passed_year] = array_pad(explode(':', $qualification), 3, '');

    @endphp

    <style>
        table,
        th,
        td {
            border: 1px solid black;
        }

        .cert_name {
            display: flex;
            flex-direction: column;
            align-items: center
        }

        .cert_name span {
            padding: 0px 5px;
            background: blue;
            color: white;
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
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form method="POST" action="{{ route('operator-certificate-foreign-store') }}" id="form">
                            @csrf
                            <input type="hidden" name="id" value="{{ $row && $row->user_id ? $row->user_id : ($user_info && $user_info->user_id  ? $user_info->user_id : old('id'))}}">
                            <input type="hidden" name="user_info_id" value="{{ $row && $row->id ? $row->user_id : ($user_info && $user_info->id  ? $user_info->id : old('user_info_id'))}}">
                            <div class="header" style="text-align: center; font-weight: 500;">
                                <span class="p" style="font-size: 22px; font-weight: 700;">
                                    Schedule -3 <br>
                                    (Relating to sub rule (1) of Rule 10)
                                </span>
                                <h3 style="margin-top: 5px; font-size: 40px;font-weight: 700;line-height: 0.9;">
                                    Nepal Health Professional Council <br>
                                    <span style="font-weight: 700;font-size: 22px !important;">
                                        Bansbari, Kathmandu, Nepal
                                    </span>
                                </h3>
                            </div>
                            <div id="container"
                                style=" margin-top: 22px; display: flex; justify-content: space-between; align-items: center;">
                                <div class="col-side" id="col1"
                                    style="flex: 0 0 122px;  width: 22px !important;height: 122px;border: 1px solid black;margin-right: 22px;display: flex;justify-content: center;align-items: center;">
                                    <div style="width: 100%; height:100%">
                                        <div class="row">
                                            <div class="form-group col-md-12 col-lg-12">
                                                <div class="drag-container">
                                                    <button type="button"
                                                        class="{{ $user_info?->profile_picture ? 'd-block' : 'd-none' }} img-delete-btn"
                                                        onclick="imageDelete('profile_picture')"
                                                        id="btn_profile_picture_delete"><i class="fa fa-times"></i></button>
                                                    <div class="drag-area drag-area-profile_picture" style= "height:120px;">
                                                        <div
                                                            class="dropify-message dropify-message-profile_picture {{ $user_info?->profile_picture ? 'd-none' : 'd-block' }}">
                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1"
                                                                x="0px" y="0px" width="64px" height="64px"
                                                                viewBox="0 0 64 64" enable-background="new 0 0 64 64"
                                                                xml:space="preserve">
                                                                <path fill="none" stroke="#8a8a8a" stroke-width="2"
                                                                    stroke-miterlimit="10"
                                                                    d="M41,50h14c4.565,0,8-3.582,8-8s-3.435-8-8-8  c0-11.046-9.52-20-20.934-20C23.966,14,14.8,20.732,13,30c0,0-0.831,0-1.667,0C5.626,30,1,34.477,1,40s4.293,10,10,10H41" />
                                                                <polyline fill="none" stroke="#8a8a8a" stroke-width="2"
                                                                    stroke-linejoin="bevel" stroke-miterlimit="10"
                                                                    points="23.998,34   31.998,26 39.998,34 " />
                                                                <g>
                                                                    <line fill="none" stroke="#8a8a8a" stroke-width="2"
                                                                        stroke-miterlimit="10" x1="31.998" y1="26"
                                                                        x2="31.998" y2="46" />
                                                                </g>
                                                            </svg>
                                                            <p>Click here to upload image</p>
                                                        </div>
                                                        <input name="profile_picture" type="hidden" id="profile_picture"
                                                            value="{{ $user_info?->profile_picture ?? old('profile_picture') }}"
                                                            class="file-input" />
                                                        <div class="image-preview">
                                                            @if ($user_info?->profile_picture)
                                                                <img src="{{ $user_info?->full_profile_picture }}"
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
                                <div class="col cert_name" id="col2"
                                    style="padding-left: 0.3rem; font-size: 30px; font-weight: 600;">
                                    <span>Foreign Citizen</span>
                                    <span>Temporary</span>
                                    <span>Registration Certificate</span>
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

                            <div class="body"
                                style=" text-align: justify;
                        font-weight: 600;
                        font-size: 20px;
                        margin-top: 50px;
                        line-height: 1;
                        ">
                                Pursuant to the decision dated <input type="text" name="decision_date"
                                    class="form-control" placeholder="DD-MM-YYYY"
                                    value="{{ $row ? Carbon::parse($row->decision_date)->format('d-m-Y') : old('decision_date') }}" />
                                of the Council, the name of
                                <span style="font-size: 26px; font-weight: 600;">
                                    <input type="text" name="name" class="form-control"
                                        value="{{ $row && $row->name ? $row->name : ($user_info && $user_info->user && $user_info->user->name ? $user_info->user->name : old('name')) }}" />

                                </span> date of birth
                                <input type="text" class="form-control" name="dob"
                                    value="{{ $row ? $row->date_of_birth : old('dob') }}" />
                                a resident ward No.
                                <span style="font-size: 26px; font-weight: 700;">
                                    {{-- <input type="text" name="ward_no"
                                        value="{{ $row ? $row->ward_no : old('ward_no') }}" /> --}}
                                    <input type="text" id="ward_no" name="ward_no" class="form-control"
                                        value="{{ $ward_no }}" placeholder="Enter Ward Number" />
                                </span> of
                                <span style="font-size: 26px; font-weight: 700;">
                                    {{-- <input type="text" name="municipality"
                                        value="{{ $row ? $row->municipality : old('municipality') }}" /> --}}
                                    <input type="text" id="municipality" name="municipality" class="form-control"
                                        value="{{ $municipality }}" placeholder="Enter Municipality" />
                                </span>
                                Metropolitan City /Sub-Metropolitan City /Municipality /Rural Municipality
                                <span style="font-size: 26px; font-weight: 700;">
                                    {{-- <input type="text" name="district"
                                        value="{{ $row ? $district : old('district') }}" /> --}}
                                    <input type="text" id="district" name="district" class="form-control"
                                        value="{{ $district }}" placeholder="Enter District" />
                                </span>
                                District
                                <span style="font-size: 26px; font-weight: 700;">
                                    {{-- <input type="text" name="province"
                                        value="{{ $row ? $province : old('province') }}" /> --}}
                                    <input type="text" id="province" name="province" class="form-control"
                                        value="{{ $province }}" placeholder="Enter Province" />
                                </span>
                                Province is registered as
                                <span style="font-size: 26px; font-weight: 700;">
                                    <input type="text" name="program_code" class="form-control"
                                        value="{{ $row ? $row->program_certificate_code : old('program_code') }}" />
                                </span>
                                of
                                <span style="font-size: 26px; font-weight: 700;">
                                    <select name="level_id" style="min-width: 300px;">
                                        @foreach ($levels as $level)
                                            <option class="form-control" value="{{ $level->id }}"
                                                @if ($level->id == $certificate?->level_id) selected @endif>
                                                {{ $level->short_name_english }}</option>
                                        @endforeach
                                    </select>
                                </span>
                                Level in the registration book and this Registration Certificate is hereby
                                issued in accordance with subsection (4) of section 17 of the Nepal
                                Health Professional Council Act, 2053 B.S. (1997 A.D.) and Rule 10 of the Nepal Health
                                Professional
                                Council Rules 2056 B.S. (1999 A.D.)
                            </div>

                            <div class="" style="height: 130px; display: block; ">
                                <div class="left"
                                    style="font-weight: 700; line-height: 1.2;   text-align: left; font-size:18px ;float: left;">
                                    Registration No:
                                    <span style="font-size: 26px;">
                                        <input type="text" class="form-control" name="cert_registration_number"
                                            value ="{{ $row ? $row->cert_registration_number : old('cert_registration_number') }}" />
                                    </span>
                                    <br>
                                    Date of issue:
                                    <span style="font-size: 22px;">
                                        <input type="text" class="form-control" name="issued_date"
                                            value ="{{ $row ? $row->issued_date : old('issued_date') }}" />
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
                                        <input type="text" class="form-control" name="registrar"
                                            value="{{ $row ? $row->registrar : old('registrar') }}" />
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
                                <tr style="text-align: center;">
                                    <td
                                        style=" border: 1px solid black; text-align: center;  font-size: 20px; font-weight: bold;">
                                        {{ ++$key + 1 }}</td>
                                    <td
                                        style=" border: 1px solid black; text-align: center;  font-size: 20px; font-weight: bold;">
                                        <input type="text" class="form-control" name="program_id"
                                            value ="{{ $qualification ? $program : old('qualification') }}" />
                                    </td>
                                    </td>
                                    <td
                                        style=" border: 1px solid black; text-align: center;  font-size: 20px; font-weight: bold;">
                                        <input type="text" class="form-control" name="board_university"
                                            value ="{{ $qualification ? $board_university : old('board_university') }}" />
                                    </td>
                                    <td
                                        style=" border: 1px solid black; text-align: center;  font-size: 20px; font-weight: bold;">
                                        <input type="text" class="form-control" name="passed_year"
                                            value ="{{ $qualification ? $passed_year : old('passed_year') }}" />
                                    </td>
                                </tr>
                            </table>
                            <hr style=" margin-top: 45px; border: 1px solid black;">
                            <div class="" style="text-align: center;">
                                <span
                                    style="text-align: center; font-weight: 600; font-size: 16px; word-spacing: 1.6;">Note:
                                    - This certificate should be updated in every <input type="text"
                                        class="form-control" name="duration"
                                        value ="{{ $row ? $row->duration : old('qualification') }}" /> , from the date of
                                    issue.</span>
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
        .form-control {
            width: 300px;
            font-size: 18px;
            font-weight: 600;
            display: inline !important;
        }
    </style>
@endsection
@section('footer-scripts')
    @include('operator.certificate.foreign.js.update')
@endsection
