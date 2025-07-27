<div class="row">
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
        <select class="form-control select2" name="municipality"
            id="municipality">
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
