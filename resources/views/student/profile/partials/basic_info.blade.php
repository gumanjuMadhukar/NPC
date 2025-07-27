<div class="mb-3">
    <label class="form-label">Level *</label>
    <select class="form-select select2" name="level">
        <option value="">Select level</option>
        @if ($levels->count() > 0)
            @foreach ($levels as $level)
                <option value="{{ $level->id }}" @if ($user && $user->info?->level_id == $level->id) selected @endif>{{ $level->name }}
                </option>
            @endforeach
        @endif
    </select>
</div>
<div class="mb-3">
    <label class="form-label"> Profile Image </label>
    <div class="drag-container">
        <button type="button" class="{{ $user && $user->info?->profile_picture ? 'd-block' : 'd-none' }} img-delete-btn"
            onclick="imageDelete('profile_picture')" id="btn_profile_picture_delete"><i
                class="fa fa-times"></i></button>
        <div class="drag-area drag-area-profile_picture">
            <div
                class="dropify-message dropify-message-profile_picture {{ $user && $user->info?->profile_picture ? 'd-none' : 'd-block' }}">
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1"
                    x="0px" y="0px" width="64px" height="64px" viewBox="0 0 64 64" enable-background="new 0 0 64 64"
                    xml:space="preserve">
                    <path fill="none" stroke="#8a8a8a" stroke-width="2" stroke-miterlimit="10"
                        d="M41,50h14c4.565,0,8-3.582,8-8s-3.435-8-8-8  c0-11.046-9.52-20-20.934-20C23.966,14,14.8,20.732,13,30c0,0-0.831,0-1.667,0C5.626,30,1,34.477,1,40s4.293,10,10,10H41" />
                    <polyline fill="none" stroke="#8a8a8a" stroke-width="2" stroke-linejoin="bevel"
                        stroke-miterlimit="10" points="23.998,34   31.998,26 39.998,34 " />
                    <g>
                        <line fill="none" stroke="#8a8a8a" stroke-width="2" stroke-miterlimit="10" x1="31.998"
                            y1="26" x2="31.998" y2="46" />
                    </g>
                </svg>
                <p>Click here to upload image</p>
            </div>
            <input name="profile_picture" type="hidden" id="profile_picture"
                value="{{ $user->info->profile_picture ?? old('profile_picture') }}" class="file-input" />
            <div class="image-preview">
                @if ($user && $user->info?->profile_picture)
                    <img src="{{ $user->info?->full_profile_picture }}" id="display_profile_picture"
                        class="preview-image">
                @else
                    <img src="" id="display_profile_picture" class="d-none preview-image">
                @endif
            </div>
        </div>
        <input type="file" style="display:none" id="drag-profile_picture" class="drag-image" accept="image/*" />
    </div>
</div>
<div class="row">
    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 mb-3">
        <label class="form-label">First Name *</label>
        <input class="form-control myInput" name="first_name" value="{{ $user->info->first_name ?? old('first_name') }}"
            type="text">
    </div>
    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 mb-3">
        <label class="form-label">Middle Name</label>
        <input class="form-control myInput" name="middle_name"
            value="{{ $user->info->middle_name ?? old('middle_name') }}" type="text">
    </div>
    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 mb-3">
        <label class="form-label">Last Name *</label>
        <input class="form-control myInput" name="last_name" value="{{ $user->info->last_name ?? old('last_name') }}"
            type="text">
    </div>
</div>
@if ($user->is_foreign != 1)
    @include('student.profile.partials.name_info_nepali')
@else
@endif
<div class="row">
    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 mb-3">
        <label class="form-label">Date of Birth(B.S) *</label>
        <input class="form-control" readonly name="dob_nep" id="dob_nep"
            value="{{ $user->info->dob_nep ?? old('dob_nep') }}" type="text">
    </div>
    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 mb-3">
        <label class="form-label">Date of Birth(A.D) *</label>
        <input class="form-control" name="dob_eng" id="dob_eng" value="{{ $user->info->dob_eng ?? old('dob_eng') }}"
            type="text" readonly>
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
    @if ($user->is_foreign != 1)
        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 mb-3">
            <label class="form-label">Ethinicity *</label>
            <select class="form-select" name="ethinic">
                <option value="">Select Ethnicity</option>
                <option value="Brahamin/Chettri" @if ($user && $user->info?->ethinic == 'Brahamin/Chettri') selected @endif>Brahamin/Chettri
                </option>
                <option value="Dalits" @if ($user && $user->info?->ethinic == 'Dalits') selected @endif>Dalits
                </option>
                <option value="Janjati" @if ($user && $user->info?->ethinic == 'Janjati') selected @endif>
                    Janjati</option>
                <option value="Tarai/Madhesi" @if ($user && $user->info?->ethinic == 'Tarai/Madhesi') selected @endif>
                    Tarai/Madhesi</option>
                <option value="Other" @if ($user && $user->info?->ethinic == 'Other') selected @endif>Other
                </option>
            </select>
        </div>
    @else
    @endif
</div>
@include('student.profile.js.personal')
