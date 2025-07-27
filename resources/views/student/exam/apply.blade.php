@extends('student.layout')
@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <div class="h1">{{$page_title}}</div>
            </div>
        </div>

        {{-- Section to display session-flashed messages --}}
        @if (Session::has('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ Session::get('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (Session::has('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ Session::get('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        {{-- End of session-flashed messages section --}}

        <div class="card">
            <div class="card-body container">
                <h4 class="text-danger">
                    Note: Before applying for the licence please review your profile
                    <a class="btn btn-primary" href="{{route('student-exam-status')}}"> Here</a>
                </h4>
            </div>
        </div>
        <div class="card">
            <div class="card-body conatiner">
                <span class="text-justify">
                    <div class="row">
                        <div class="col-6">
                            <strong>बैंक विवरण</strong><br>
                            <span>(क) राष्ट्रिय बाणिज्य बैंक ११५०१००००२१३३००१ </span><br>
                            <span>(ख) नेपाल एस वि आई बैंक २०४३५२४०१००००८</span><br>
                            <span>(ग) हिमालयन बैंक ००२००५७४६६००१६</span><br>
                        </div>
                        <div class="col-6">
                            <strong>दस्तुर</strong><br>
                            <span>(क) विशिष्ठ तहको लागि रु. 3000।</span><br>
                            <span>(ख) प्रथम तहको लागि रु. 3000।</span><br>
                            <span>(ग) द्वितीय तहको लागि रु. 3000।</span><br>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <form method="post" id="applicationForm" action="" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="exam_id" value="{{ $exam_id}}">
                            <div class="row">
                                <div class="col-md-4 col-sm-12 col-xs-12">
                                    <div class="mb-3">
                                        <label class="form-label">Level *</label>
                                        <select class="form-select select2" name="level"  id="level">
                                            <option value="">Select level</option>
                                            @if($levels->count() > 0)
                                            @foreach($levels as $level)
                                            <option value="{{ $level->id}}" @if($level_id == 4) selected @endif>{{ $level->name}}</option>
                                            @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4 col-sm-12 col-xs-12">
                                    <label class="form-label">Program Name</label>
                                    <select class="form-select select2" name="program" id="program">
                                        <option value="">Select program</option>
                                        @if($programs->count() > 0)
                                        @foreach($programs as $program)
                                        <option value="{{ $program->id}}" class="{{ $program->level_id }}" >{{ $program->name}}</option>
                                        @endforeach
                                        @endif
                                    </select>

                                </div>
                            </div>


                            <div class="row mt-3">
                                <div class="col-12">
                                    <label class="form-label">Choose Payment Option:</label><br>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="payment_option" id="radioVoucher" value="voucher" checked>
                                        <label class="form-check-label" for="radioVoucher">Voucher</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="payment_option" id="radioKhalti" value="khalti">
                                        <label class="form-check-label" for="radioKhalti">Khalti</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row" id="voucherSection">
                                <div class="col-lg-4">
                                    <div class="col-md-12 col-lg-12">
                                        <h1 style="color: red; font-size: 26px; font-family: bold;">Voucher Image</h1>
                                        <br>
                                        <div class="drag-container">
                                            <button type="button"
                                                class="{{ ($user && $user->info?->voucher_image) ? 'd-block' : 'd-none' }}"
                                                onclick="imageDelete('voucher_image')" id="btn_voucher_image_delete"><i
                                                    class="fa fa-times"></i></button>
                                            <div class="drag-area drag-area-voucher_image">
                                                <div
                                                    class="dropify-message dropify-message-voucher_image {{ ($user && $user->info?->voucher_image) ? 'd-none' : 'd-block' }}">
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" x="0px"
                                                        y="0px" width="64px" height="64px" viewBox="0 0 64 64"
                                                        enable-background="new 0 0 64 64" xml:space="preserve">
                                                        <path fill="none" stroke="#8a8a8a" stroke-width="2"
                                                            stroke-miterlimit="10"
                                                            d="M41,50h14c4.565,0,8-3.582,8-8s-3.435-8-8-8
                                                            c0-11.046-9.52-20-20.934-20C23.966,14,14.8,20.732,13,30c0,0-0.831,0-1.667,0C5.626,30,1,34.477,1,40s4.293,10,10,10H41" />
                                                        <polyline fill="none" stroke="#8a8a8a" stroke-width="2"
                                                            stroke-linejoin="bevel" stroke-miterlimit="10"
                                                            points="23.998,34   31.998,26 39.998,34 " />
                                                        <g>
                                                            <line fill="none" stroke="#8a8a8a" stroke-width="2"
                                                                stroke-miterlimit="10" x1="31.998" y1="26" x2="31.998"
                                                                y2="46" />
                                                        </g>
                                                    </svg>
                                                    <p>Click here to upload image</p>
                                                </div>
                                                <input type="file" hidden="" id="drag-voucher_image" />
                                                <input name="voucher_image" type="hidden" id="voucher_image"
                                                    value="{{ $user->info->voucher_image ?? old('voucher_image') }}" />
                                                <div class="image-preview">
                                                    @if ($user && $user->info?->voucher_image)
                                                        <img src="{{ $user->info?->full_voucher_image }}"
                                                            id="display_voucher_image">
                                                    @else
                                                        <img src="" id="display_voucher_image" class="d-none">
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div id="khaltiSection" class="row d-none">
                                <div class="col-12">
                                    <p>You will be redirected to Khalti to complete your payment.</p>
                                </div>
                            </div>

                            <button type="submit" id="submitButton" class="btn btn-primary float-left mt-2 btn-loading"><i
                                        class="fa fa-check"></i>
                                    Apply For Licence</button>
                        </form>
                    </div>
                </span>
            </div>
        </div>
    </div>
</div>
@endsection

@section('footer-scripts')

    @include('student.exam.js.apply')
@endsection
