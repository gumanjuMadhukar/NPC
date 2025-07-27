@extends('student.layout')
@section('content')
    <div class="content">
        <div class="container-fluid">
            @if (session('message'))
                <div class="card">
                    <div class="card-body conatiner">
                        <span class="text-justify text-danger">
                            {{ session('message') }}
                        </span>
                    </div>
                </div>
            @endif
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    @include('student.profile.breadcrumb')
                    @include('student.profile.note')
                    <div class="card">
                        <div class="card-body">
                            <h3 class="mb-3">{{ $page_title }}</h3>
                            <form id="form" method="post"
                                action="{{ route('student-profile-save-foreign-personal') }}">
                                @csrf
                                <input name="exam_apply_id" value="{{ $exam_apply->id ?? null }}" type="hidden">
                                <div class="mb-3">
                                    <label class="form-label">Level *</label>
                                    <select class="form-select select2" name="level_id">
                                        <option value="">Select level</option>
                                        @if ($levels->count() > 0)
                                            @foreach ($levels as $level)
                                                <option value="{{ $level->id }}"
                                                    @if ($user && $user->info?->level_id == $level->id) selected @endif>{{ $level->name }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label"> Profile Image </label>
                                    <div class="drag-container">
                                        <button type="button"
                                            class="{{ $user && $user->info?->profile_picture ? 'd-block' : 'd-none' }} img-delete-btn"
                                            onclick="imageDelete('profile_picture')" id="btn_profile_picture_delete"><i
                                                class="fa fa-times"></i></button>
                                        <div class="drag-area drag-area-profile_picture">
                                            <div
                                                class="dropify-message dropify-message-profile_picture {{ $user && $user->info?->profile_picture ? 'd-none' : 'd-block' }}">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" x="0px"
                                                    y="0px" width="64px" height="64px" viewBox="0 0 64 64"
                                                    enable-background="new 0 0 64 64" xml:space="preserve">
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
                                                value="{{ $user->info->profile_picture ?? old('profile_picture') }}"
                                                class="file-input" />
                                            <div class="image-preview">
                                                @if ($user && $user->info?->profile_picture)
                                                    <img src="{{ $user->info?->full_profile_picture }}"
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
                                <div class="row">
                                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 mb-3">
                                        <label class="form-label">First Name *</label>
                                        <input class="form-control myInput" name="first_name"
                                            value="{{ $user->info->first_name ?? old('first_name') }}" type="text">
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 mb-3">
                                        <label class="form-label">Middle Name</label>
                                        <input class="form-control myInput" name="middle_name"
                                            value="{{ $user->info->middle_name ?? old('middle_name') }}" type="text">
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 mb-3">
                                        <label class="form-label">Last Name *</label>
                                        <input class="form-control myInput" name="last_name"
                                            value="{{ $user->info->last_name ?? old('last_name') }}" type="text">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 mb-3">
                                        <label class="form-label">Date of Birth(B.S) *</label>
                                        <input class="form-control" readonly name="dob_nep" id="dob_nep"
                                            value="{{ $user->info->dob_nep ?? old('dob_nep') }}" type="text">
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 mb-3">
                                        <label class="form-label">Date of Birth(A.D) *</label>
                                        <input class="form-control" name="dob_eng" id="dob_eng"
                                            value="{{ $user->info->dob_eng ?? old('dob_eng') }}" type="text" readonly>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 mb-3">
                                        <label class="form-label">Gender *</label>
                                        <select class="form-select" name="sex">
                                            <option value="">Select</option>
                                            <option value="Male" @if ($user && $user->info?->sex == 'male') selected @endif>Male
                                            </option>
                                            <option value="Female" @if ($user && $user->info?->sex == 'female') selected @endif>Female
                                            </option>
                                            <option value="Other" @if ($user && $user->info?->sex == 'other') selected @endif>Other
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 mb-3">
                                        <label class="form-label">Marital Status *</label>
                                        <select class="form-select" name="marital_status">
                                            <option value="">Select Marital Status</option>
                                            <option value="Unmarried" @if ($user && $user->info?->marital_status == 'unmarried') selected @endif>
                                                Unmarried</option>
                                            <option value="Married" @if ($user && $user->info?->marital_status == 'married') selected @endif>
                                                Married</option>
                                        </select>
                                    </div>
                                </div>

                                @include('student.profile.partials.foreign_document')
                                <div class="col-xl-4 col-md-4 col-sm-12 col-xs-12">
                                    <label>Signature Image </label>
                                    <div class="drag-container">
                                        <button type="button"
                                            class="{{ $user && $user->info?->signature_image ? 'd-block' : 'd-none' }} img-delete-btn"
                                            onclick="imageDelete('signature_image')" id="btn_signature_image_delete"><i
                                                class="fa fa-times"></i></button>
                                        <div class="drag-area drag-area-signature_image">
                                            <div
                                                class="dropify-message dropify-message-signature_image {{ $user && $user->info?->signature_image ? 'd-none' : 'd-block' }}">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" x="0px"
                                                    y="0px" width="64px" height="64px" viewBox="0 0 64 64"
                                                    enable-background="new 0 0 64 64" xml:space="preserve">
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
                                            <input name="signature_image" type="hidden" id="signature_image"
                                                value="{{ $user->info->signature_image ?? old('signature_image') }}"
                                                class="file-input" />
                                            <div class="image-preview">
                                                @if ($user && $user->info?->signature_image)
                                                    <img src="{{ $user->info?->full_signature_image }}"
                                                        id="display_signature_image" class="preview-image">
                                                @else
                                                    <img src="" id="display_signature_image"
                                                        class="d-none preview-image">
                                                @endif
                                            </div>
                                        </div>
                                        <input type="file" style="display:none" id="drag-signature_image"
                                            class="drag-image" accept="image/*" />
                                    </div>
                                </div>
                                <div class="mt-3 mb-3">
                                    <button type="submit" class="btn btn-primary  btn-loading">Next</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('footer-scripts')
    @include('student.profile.js.foreign_personal')
@endsection
