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
                            <form id="form" method="post" action="{{ route('student-profile-save-personal') }}">
                                @csrf
                                <input name="exam_apply_id" value="{{ $exam_apply->id ?? null }}" type="hidden">
                                <div class="mb-3">
                                    <label class="form-label">Level *</label>
                                    <select class="form-select select2" name="level">
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
                                <div class="row">
                                    <div class="col-lg-3 col-md-3 col-sm-12">
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
                                    </div>
                                    <div class="col-lg-9 col-md-9 col-sm-12">
                                        <div class="row">
                                            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 mb-3">
                                                <label class="form-label">First Name *</label>
                                                <input class="form-control myInput" id="first_name" name="first_name"
                                                    value="{{ $user->info->first_name ?? old('first_name') }}" type="text">
                                            </div>
                                            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 mb-3">
                                                <label class="form-label">Middle Name</label>
                                                <input class="form-control myInput" id="middle_name" name="middle_name"
                                                    value="{{ $user->info->middle_name ?? old('middle_name') }}" type="text">
                                            </div>
                                            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 mb-3">
                                                <label class="form-label">Last Name *</label>
                                                <input class="form-control myInput" id="last_name" name="last_name"
                                                    value="{{ $user->info->last_name ?? old('last_name') }}" type="text">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 mb-3">
                                                <label class="form-label">पहिलो नाम *</label>
                                                <input class="form-control" id="first_name_nep" name="first_name_nep"
                                                    value="{{ $user->info->first_name_nep ?? old('first_name_nep') }}"
                                                    type="text">
                                            </div>
                                            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 mb-3">
                                                <label class="form-label">बिचको नाम</label>
                                                <input class="form-control" id="middle_name_nep" name="middle_name_nep"
                                                    value="{{ $user->info->middle_name_nep ?? old('middle_name_nep') }}"
                                                    type="text">
                                            </div>
                                            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 mb-3">
                                                <label class="form-label">थर *</label>
                                                <input class="form-control" id="last_name_nep" name="last_name_nep"
                                                    value="{{ $user->info->last_name_nep ?? old('last_name_nep') }}"
                                                    type="text">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 mb-3">
                                                <label class="form-label">Phone Number *</label>
                                                <input class="form-control" id="phone_number" name="phone_number"
                                                    value="{{ $user->info->phone_number ?? old('phone_number') }}"
                                                    type="text">
                                            </div>
                                            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 mb-3">
                                                <label class="form-label">Emergency Number *</label>
                                                <input class="form-control" id="emergency_number" name="emergency_number"
                                                    value="{{ $user->info->emergency_number ?? old('emergency_number') }}"
                                                    type="text">
                                            </div>
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
                                </div>
                                <div class="row">
                                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 mb-3">
                                        <label class="form-label">Ethinicity *</label>
                                        <select class="form-select" name="ethinic">
                                            <option value="">Select Ethnicity</option>
                                            <option value="Brahamin/Chettri"
                                                @if ($user && $user->info?->ethinic == 'Brahamin/Chettri') selected @endif>Brahamin/Chettri</option>
                                            <option value="Dalits" @if ($user && $user->info?->ethinic == 'Dalits') selected @endif>Dalits
                                            </option>
                                            <option value="Janjati" @if ($user && $user->info?->ethinic == 'Janjati') selected @endif>
                                                Janjati</option>
                                            <option value="Tarai/Madhesi"
                                                @if ($user && $user->info?->ethinic == 'Tarai/Madhesi') selected @endif>Tarai/Madhesi</option>
                                            <option value="Other" @if ($user && $user->info?->ethinic == 'Other') selected @endif>Other
                                            </option>
                                        </select>
                                    </div>
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
                                    <div class="col-xl-4 col-md-4 col-sm-12 col-xs-12">
                                        <label class="form-label">Province *</label>
                                        <select class="form-control select2" name="province" id="province">
                                            <option value="">Select Your Province</option>
                                            @if ($provinces->count() > 0)
                                                @foreach ($provinces as $province)
                                                    <option value="{{ $province->id }}"
                                                        @if ($user && $user->info?->province_id == $province->id) selected @endif>
                                                        {{ $province->name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-4 col-md-4 col-sm-12 col-xs-12 mb-3">
                                        <label class="form-label">District *</label>
                                        <select class="form-control select2" name="district" id="district">
                                            <option value="">Select District</option>
                                            @if ($districts->count() > 0)
                                                @foreach ($districts as $district)
                                                    <option value="{{ $district->id }}"
                                                        class="{{ $district->province_id }}"
                                                        @if ($user && $user->info?->district_id == $district->id) selected @endif>
                                                        {{ $district->name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                    <div class="col-xl-4 col-md-4 col-sm-12 col-xs-12 mb-3">
                                        <label class="form-label">Municipality</label>
                                        <select class="form-control select2" name="municipality" id="municipality">
                                            <option value="">Select Municipality</option>
                                            @if ($municipalities->count() > 0)
                                                @foreach ($municipalities as $municipality)
                                                    <option value="{{ $municipality->id }}"
                                                        class="{{ $municipality->district_id }}"
                                                        @if ($user && $user->info?->municipality_id == $municipality->id) selected @endif>
                                                        {{ $municipality->name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                    <div class="col-xl-4 col-md-4 col-sm-12 col-xs-12 mb-3">
                                        <label class="form-label">Ward No *</label>
                                        <input class="form-control" name="ward_no"
                                            value="{{ $user->info->ward_no ?? old('ward_no') }}" type="text">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 mb-3">
                                        <label class="form-label">Citizenship Number*</label>
                                        <input class="form-control" name="citizenship_number"
                                            value="{{ $user->info->citizenship_number ?? old('citizenship_number') }}"
                                            type="text">
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 mb-3">
                                        <label class="form-label">Citizenship Issue Date</label>
                                        <input class="form-control" name="citizenship_issue_date"
                                            id="citizenship_issue_date"
                                            value="{{ $user->info->citizenship_issue_date ?? old('citizenship_issue_date') }}"
                                            type="text">
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 mb-3">
                                        <label class="form-label">Citizenship Issue District*</label>
                                        <select class="form-control select2" name="citizenship_issue_district">
                                            <option value="">Select District</option>
                                            @if ($districts->count() > 0)
                                                @foreach ($districts as $district)
                                                    <option value="{{ $district->name }}"
                                                        @if ($user && $user->info?->citizenship_issue_district == $district->name) selected @endif>
                                                        {{ $district->name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-4 col-md-4 col-sm-12 col-xs-12">
                                        <label for="">Citizenship Front Image</label>
                                        <div class="drag-container">
                                            <button type="button"
                                                class="{{ $user && $user->info?->citizenship_front ? 'd-block' : 'd-none' }} img-delete-btn"
                                                onclick="imageDelete('citizenship_front')"
                                                id="btn_citizenship_front_delete"><i class="fa fa-times"></i></button>
                                            <div class="drag-area drag-area-citizenship_front">
                                                <div
                                                    class="dropify-message dropify-message-citizenship_front {{ $user && $user->info?->citizenship_front ? 'd-none' : 'd-block' }}">
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
                                                <input name="citizenship_front" type="hidden" id="citizenship_front"
                                                    value="{{ $user->info->citizenship_front ?? old('citizenship_front') }}"
                                                    class="file-input" />
                                                <div class="image-preview">
                                                    @if ($user && $user->info?->citizenship_front)
                                                        <img src="{{ $user->info?->full_citizenship_front }}"
                                                            id="display_citizenship_front" class="preview-image">
                                                    @else
                                                        <img src="" id="display_citizenship_front"
                                                            class="d-none preview-image">
                                                    @endif
                                                </div>
                                            </div>
                                            <input type="file" style="display:none" id="drag-citizenship_front"
                                                class="drag-image" accept="image/*" />
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-md-4 col-sm-12 col-xs-12">
                                        <label>Citizenship Back Image</label>
                                        <div class="drag-container">
                                            <button type="button"
                                                class="{{ $user && $user->info?->citizenship_back ? 'd-block' : 'd-none' }} img-delete-btn"
                                                onclick="imageDelete('citizenship_back')"
                                                id="btn_citizenship_back_delete"><i class="fa fa-times"></i></button>
                                            <div class="drag-area drag-area-citizenship_back">
                                                <div
                                                    class="dropify-message dropify-message-citizenship_back {{ $user && $user->info?->citizenship_back ? 'd-none' : 'd-block' }}">
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
                                                <input name="citizenship_back" type="hidden" id="citizenship_back"
                                                    value="{{ $user->info->citizenship_back ?? old('citizenship_back') }}"
                                                    class="file-input" />
                                                <div class="image-preview">
                                                    @if ($user && $user->info?->citizenship_back)
                                                        <img src="{{ $user->info?->full_citizenship_back }}"
                                                            id="display_citizenship_back" class="preview-image">
                                                    @else
                                                        <img src="" id="display_citizenship_back"
                                                            class="d-none preview-image">
                                                    @endif
                                                </div>
                                            </div>
                                            <input type="file" style="display:none" id="drag-citizenship_back"
                                                class="drag-image" accept="image/*" />
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-md-4 col-sm-12 col-xs-12">
                                        <label>Signature Image </label>
                                        <div class="drag-container">
                                            <button type="button"
                                                class="{{ $user && $user->info?->signature_image ? 'd-block' : 'd-none' }} img-delete-btn"
                                                onclick="imageDelete('signature_image')"
                                                id="btn_signature_image_delete"><i class="fa fa-times"></i></button>
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
    @include('student.profile.js.personal')
    <script>
const translitMap = {
    'a':'अ','aa':'आ','i':'इ','ii':'ई','u':'उ','uu':'ऊ',
    'e':'ए','ai':'ऐ','o':'ओ','au':'औ','ri':'ऋ',

    'ka':'क','kaa':'का','ki':'कि','kii':'की','ku':'कु','kuu':'कू','ke':'के','kai':'कै','ko':'को','kau':'कौ',
    'kha':'ख','khaa':'खा','khi':'खि','khii':'खी','khu':'खु','khuu':'खू','khe':'खे','khai':'खै','kho':'खो','khau':'खौ',
    'ga':'ग','gaa':'गा','gi':'गि','gii':'गी','gu':'गु','guu':'गू','ge':'गे','gai':'गै','go':'गो','gau':'गौ',
    'gha':'घ','ghaa':'घा','ghi':'घि','ghii':'घी','ghu':'घु','ghuu':'घू','ghe':'घे','ghai':'घै','gho':'घो','ghau':'घौ',
    'nga':'ङ','ngaa':'ङा','ngi':'ङि','ngii':'ङी','ngu':'ङु','nguu':'ङू','nge':'ङे','ngai':'ङै','ngo':'ङो','ngau':'ङौ',

    'cha':'च','chaa':'चा','chi':'चि','chii':'ची','chu':'चु','chuu':'चू','che':'चे','chai':'चै','cho':'चो','chau':'चौ',
    'chha':'छ','chhaa':'छा','chhi':'छि','chhii':'छी','chhu':'छु','chhuu':'छू','chhe':'छे','chhai':'छै','chho':'छो','chhau':'छौ',

    'ja':'ज','jaa':'जा','ji':'जि','jii':'जी','ju':'जु','juu':'जू','je':'जे','jai':'जै','jo':'जो','jau':'जौ',
    'jha':'झ','jhaa':'झा','jhi':'झि','jhii':'झी','jhu':'झु','jhuu':'झू','jhe':'झे','jhai':'झै','jho':'झो','jhau':'झौ',
    'nya':'ञ','nyaa':'ञा','nyi':'ञि','nyii':'ञी','nyu':'ञु','nyuu':'ञू','nye':'ञे','nyai':'ञै','nyo':'ञो','nyau':'ञौ',

    'ta':'त','taa':'ता','ti':'ति','tii':'ती','tu':'तु','tuu':'तू','te':'ते','tai':'तै','to':'तो','tau':'तौ',
    'th':'थ','tha':'था','thi':'थि','thii':'थी','thu':'थु','thuu':'थू','the':'थे','thai':'थै','tho':'थो','thau':'थौ',
    'da':'द','daa':'दा','di':'दि','dii':'दी','du':'दु','duu':'दू','de':'दे','dai':'दै','do':'दो','dau':'दौ',
    'dha':'ध','dhaa':'धा','dhi':'धि','dhii':'धी','dhu':'धु','dhuu':'धू','dhe':'धे','dhai':'धै','dho':'धो','dhau':'धौ',
    'na':'न','naa':'ना','ni':'नि','nii':'नी','nu':'नु','nuu':'नू','ne':'ने','nai':'नै','no':'नो','nau':'नौ',

    'p':'प','pa':'पा','pi':'पि','pii':'पी','pu':'पु','puu':'पू','pe':'पे','pai':'पै','po':'पो','pau':'पौ',
    'pha':'फ','phaa':'फा','phi':'फि','phii':'फी','phu':'फु','phuu':'फू','phe':'फे','phai':'फै','pho':'फो','phau':'फौ',
    'ba':'ब','baa':'बा','bi':'बि','bii':'बी','bu':'बु','buu':'बू','be':'बे','bai':'बै','bo':'बो','bau':'बौ',
    'bha':'भ','bhaa':'भा','bhi':'भि','bhii':'भी','bhu':'भु','bhuu':'भू','bhe':'भे','bhai':'भै','bho':'भो','bhau':'भौ',
    'ma':'म','maa':'मा','mi':'मि','mii':'मी','mu':'मु','muu':'मू','me':'मे','mai':'मै','mo':'मो','mau':'मौ',

    'ya':'य','yaa':'या','yi':'यि','yii':'यी','yu':'यु','yuu':'यू','ye':'ये','yai':'यै','yo':'यो','yau':'यौ',
    'r':'र','ra':'रा','ri':'रि','rii':'री','ru':'रु','ruu':'रू','re':'रे','rai':'रै','ro':'रो','rau':'रौ',
    'la':'ल','laa':'ला','li':'लि','lii':'ली','lu':'लु','luu':'लू','le':'ले','lai':'लै','lo':'लो','lau':'लौ',
    'wa':'व','waa':'वा','wi':'वि','wii':'वी','wu':'वु','wuu':'वू','we':'वे','wai':'वै','wo':'वो','wau':'वौ',

    'sh':'श','sha':'शा','shi':'शि','shii':'शी','shu':'शु','shuu':'शू','she':'शे','shai':'शै','sho':'शो','shau':'शौ',
    'ssa':'ष','ssaa':'षा','ssi':'षि','ssii':'षी','ssu':'षु','ssuu':'षू','sse':'षे','ssai':'षै','sso':'षो','ssau':'षौ',
    'sa':'स','saa':'सा','si':'सि','sii':'सी','su':'सु','suu':'सू','se':'से','sai':'सै','so':'सो','sau':'सौ',
    'h':'ह','ha':'हा','hi':'हि','hii':'ही','hu':'हु','huu':'हू','he':'हे','hai':'है','ho':'हो','hau':'हौ',

    'ksha':'क्ष','tra':'त्र','gya':'ज्ञ','shri':'श्री','dri':'द्रि','pri':'प्री','pra':'प्र',

    '0':'०','1':'१','2':'२','3':'३','4':'४','5':'५','6':'६','7':'७','8':'८','9':'९',
    ' ':' ','-':'-','.':'.'
};

function toNepali(str) {
    str = str.toLowerCase();
    let nepStr = '';
    let i = 0;

    while (i < str.length) {
        let matched = false;

        if (i + 3 < str.length) {
            const four = str[i]+str[i+1]+str[i+2]+str[i+3];
            if (translitMap[four]) { nepStr+=translitMap[four]; i+=4; matched=true; continue; }
        }

        if (!matched && i + 2 < str.length) {
            const three = str[i]+str[i+1]+str[i+2];
            if (translitMap[three]) { nepStr+=translitMap[three]; i+=3; matched=true; continue; }
        }

        if (!matched && i + 1 < str.length) {
            const two = str[i]+str[i+1];
            if (translitMap[two]) { nepStr+=translitMap[two]; i+=2; matched=true; continue; }
        }

        if (!matched) { nepStr += translitMap[str[i]] || str[i]; i++; }
    }
    return nepStr;
}

['first_name','middle_name','last_name'].forEach(id=>{
    document.querySelector('#'+id).addEventListener('input', function() {
        document.querySelector('#'+id+'_nep').value = toNepali(this.value);
    });
});
</script>
@endsection
