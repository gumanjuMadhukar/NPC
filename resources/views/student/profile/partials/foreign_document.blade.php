<div class="row">
    <div class="col-xl-4 col-md-4 col-sm-12 col-xs-12">
        <label class="form-label">Country <span class="text-danger">*</span></label>
        <input class="form-control" name="country"
        value="{{ $user->info->country ?? old('country') }}" type="text">
    </div>
    <div class="col-xl-4 col-md-4 col-sm-12 col-xs-12">
        <label class="form-label">State/Province/Region <span class="text-danger">*</span></label>
        <input class="form-control" name="state_province_region"
        value="{{ $user->info->state_province_region ?? old('state_province_region') }}" type="text">
    </div>
    <div class="col-xl-4 col-md-4 col-sm-12 col-xs-12 mb-3">
        <label class="form-label">City/Town/Village <span class="text-danger">*</span></label>
        <input class="form-control" name="city_town"
        value="{{ $user->info->city_town ?? old('city_town') }}" type="text">
    </div>
    <div class="col-xl-4 col-md-4 col-sm-12 col-xs-12 mb-3">
        <label class="form-label">Street Name / Address line <span class="text-danger">*</span></label>
        <input class="form-control" name="street_name"
            value="{{ $user->info->street_name ?? old('street_name') }}" type="text">
    </div>
    <div class="col-xl-4 col-md-4 col-sm-12 col-xs-12 mb-3">
        <label class="form-label">Postal Code <span class="text-danger">*</span></label>
        <input class="form-control" name="postal_code"
            value="{{ $user->info->postal_code ?? old('postal_code') }}" type="text">
    </div>
</div>
<div class="row">
    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 mb-3">
        <label class="form-label">Passport Number*</label>
        <input class="form-control" name="passport_number"
            value="{{ $user->info->passport_number ?? old('passport_number') }}"
            type="text">
    </div>
    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 mb-3">
        <label class="form-label">Passport Issue Date</label>
        <input class="form-control" name="passport_issue_date"
            id="passport_issue_date"
            value="{{ $user->info->passport_issue_date ?? old('passport_issue_date') }}"
            type="text">
    </div>
    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 mb-3">
        <label class="form-label">Passport Issue Country *</label>
        <input class="form-control" name="passport_issue_country"
            id="passport_issue_country"
            value="{{ $user->info->passport_issue_country ?? old('passport_issue_country') }}"
            type="text">
    </div>

    <div class="col-xl-4 col-md-4 col-sm-12 col-xs-12">
        <label class="form-label">Passport Image 1 <span
                class="text-danger">*</span></label>
        <div class="drag-container mb-3">
            <button type="button"
                class="{{ $user && $user->info?->passport_image_1 ? 'd-block' : 'd-none' }} img-delete-btn"
                onclick="imageDelete('passport_image_1')"
                id="btn_passport_image_1_delete"><i class="fa fa-times"></i></button>
            <div class="drag-area drag-area-passport_image_1">
                <div
                    class="dropify-message dropify-message-passport_image_1 {{ $user && $user->info?->passport_image_1 ? 'd-none' : 'd-block' }}">
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
                <input name="passport_image_1" type="hidden" id="passport_image_1"
                    value="{{ $user->info->passport_image_1 ?? old('passport_image_1') }}"
                    class="file-input" />
                <div class="image-preview">
                    @if ($user && $user->info?->passport_image_1)
                        <img src="{{ $user->info?->full_passport_image_1 }}"
                            id="display_passport_image_1" class="preview-image">
                    @else
                        <img src="" id="display_passport_image_1"
                            class="d-none preview-image">
                    @endif
                </div>
            </div>
            <input type="file" style="display:none" id="drag-passport_image_1"
                class="drag-image" accept="image/*" />
        </div>
    </div>
    <div class="col-xl-4 col-md-4 col-sm-12 col-xs-12">
        <label class="form-label">Passport Image 2 <span class="text-danger">*</span> </label>
        <div class="drag-container mb-3">
            <button type="button"
                class="{{ $user && $user->info?->passport_image_2 ? 'd-block' : 'd-none' }} img-delete-btn"
                onclick="imageDelete('passport_image_2')"
                id="btn_passport_image_2_delete"><i class="fa fa-times"></i></button>
            <div class="drag-area drag-area-passport_image_2">
                <div
                    class="dropify-message dropify-message-passport_image_2 {{ $user && $user->info?->passport_image_2 ? 'd-none' : 'd-block' }}">
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
                <input name="passport_image_2" type="hidden" id="passport_image_2"
                    value="{{ $user->info->passport_image_2 ?? old('passport_image_2') }}"
                    class="file-input" />
                <div class="image-preview">
                    @if ($user && $user->info?->passport_image_2)
                        <img src="{{ $user->info?->full_passport_image_2 }}"
                            id="display_passport_image_2" class="preview-image">
                    @else
                        <img src="" id="display_passport_image_2"
                            class="d-none preview-image">
                    @endif
                </div>
            </div>
            <input type="file" style="display:none" id="drag-passport_image_2"
                class="drag-image" accept="image/*" />
        </div>
    </div>
    <div class="col-xl-4 col-md-4 col-sm-12 col-xs-12">
        <label class="form-label">Passport Image 3 </label>
        <div class="drag-container mb-3">
            <button type="button"
                class="{{ $user && $user->info?->passport_image_3 ? 'd-block' : 'd-none' }} img-delete-btn"
                onclick="imageDelete('passport_image_3')"
                id="btn_passport_image_3_delete"><i class="fa fa-times"></i></button>
            <div class="drag-area drag-area-passport_image_3">
                <div
                    class="dropify-message dropify-message-passport_image_3 {{ $user && $user->info?->passport_image_3 ? 'd-none' : 'd-block' }}">
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
                <input name="passport_image_3" type="hidden" id="passport_image_3"
                    value="{{ $user->info->passport_image_3 ?? old('passport_image_3') }}"
                    class="file-input" />
                <div class="image-preview">
                    @if ($user && $user->info?->passport_image_3)
                        <img src="{{ $user->info?->full_passport_image_3 }}"
                            id="display_passport_image_3" class="preview-image">
                    @else
                        <img src="" id="display_passport_image_3"
                            class="d-none preview-image">
                    @endif
                </div>
            </div>
            <input type="file" style="display:none" id="drag-passport_image_3"
                class="drag-image" accept="image/*" />
        </div>
    </div>
    <div class="col-xl-4 col-md-4 col-sm-12 col-xs-12">
        <label class="form-label">VISA Image 1 </label>
        <div class="drag-container mb-3 ">
            <button type="button"
                class="{{ $user && $user->info?->visa_image_1 ? 'd-block' : 'd-none' }} img-delete-btn"
                onclick="imageDelete('visa_image_1')" id="visa_image_1_delete"><i
                    class="fa fa-times"></i></button>
            <div class="drag-area drag-area-visa_image_1">
                <div
                    class="dropify-message dropify-message-visa_image_1 {{ $user && $user->info?->visa_image_1 ? 'd-none' : 'd-block' }}">
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
                <input name="visa_image_1" type="hidden" id="visa_image_1"
                    value="{{ $user->info->visa_image_1 ?? old('visa_image_1') }}"
                    class="file-input" />
                <div class="image-preview">
                    @if ($user && $user->info?->visa_image_1)
                        <img src="{{ $user->info?->visa_image_1 }}" id="visa_image_1"
                            class="preview-image">
                    @else
                        <img src="" id="visa_image_1"
                            class="d-none preview-image">
                    @endif
                </div>
            </div>
            <input type="file" style="display:none" id="drag-visa_image_1"
                class="drag-image" accept="image/*" />
        </div>
    </div>
    <div class="col-xl-4 col-md-4 col-sm-12 col-xs-12">
        <label class="form-label">VISA Image 2 </label>
        <div class="drag-container mb-3">
            <button type="button"
                class="{{ $user && $user->info?->visa_image_2 ? 'd-block' : 'd-none' }} img-delete-btn"
                onclick="imageDelete('visa_image_2')" id="btn_visa_image_2_delete"><i
                    class="fa fa-times"></i></button>
            <div class="drag-area drag-area-visa_image_2">
                <div
                    class="dropify-message dropify-message-visa_image_2 {{ $user && $user->info?->visa_image_2 ? 'd-none' : 'd-block' }}">
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
                <input name="visa_image_2" type="hidden" id="visa_image_2"
                    value="{{ $user->info->visa_image_2 ?? old('visa_image_2') }}"
                    class="file-input" />
                <div class="image-preview">
                    @if ($user && $user->info?->visa_image_2)
                        <img src="{{ $user->info?->full_visa_image_2 }}"
                            id="display_visa_image_2" class="preview-image">
                    @else
                        <img src="" id="display_visa_image_2"
                            class="d-none preview-image">
                    @endif
                </div>
            </div>
            <input type="file" style="display:none" id="drag-visa_image_2"
                class="drag-image" accept="image/*" />
        </div>
    </div>

</div>


