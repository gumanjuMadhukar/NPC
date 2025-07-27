@extends('student.layout')
@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h3>{{$page_title}}</h3>
                    <div class="text-justify">Thank you, You have applied form successfully.</div>
                </div>
            </div>

        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <ul class="nav nav-tabs" id="documentTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link  active" id="personal-tab" data-bs-toggle="tab"
                                data-bs-target="#personal" type="button" role="tab" aria-controls="personal"
                                aria-selected="true">Personal Detail</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="supportive-tab" data-bs-toggle="tab"
                                data-bs-target="#supportive" type="button" role="tab" aria-controls="supportive"
                                aria-selected="true">Supportive Documents</button>
                        </li>
                        @if($user->slc)
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="slc-tab" data-bs-toggle="tab" data-bs-target="#slc"
                                type="button" role="tab" aria-controls="slc" aria-selected="true">SLC / SEE
                                Documents</button>
                        </li>
                        @endif
                        @if($user->tslc)
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="tslc-tab" data-bs-toggle="tab" data-bs-target="#tslc"
                                type="button" role="tab" aria-controls="tslc" aria-selected="flase">TSLC
                                Documents</button>
                        </li>
                        @endif
                        @if($user->pcl)
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pcl-tab" data-bs-toggle="tab" data-bs-target="#pcl"
                                type="button" role="tab" aria-controls="pcl" aria-selected="false">PCL / +2
                                Documents</button>
                        </li>
                        @endif
                        @if($user->bachelor)
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="bachelor-tab" data-bs-toggle="tab" data-bs-target="#bachelor"
                                type="button" role="tab" aria-controls="bachelor" aria-selected="false">Bachelor
                                Documents</button>
                        </li>
                        @endif
                        @if($user->master)
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="master-tab" data-bs-toggle="tab" data-bs-target="#master"
                                type="button" role="tab" aria-controls="master" aria-selected="false">Master
                                Documents</button>
                        </li>
                        @endif
                        @if($exam_apply)
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="voucher-tab" data-bs-toggle="tab" data-bs-target="#voucher"
                                type="button" role="tab" aria-controls="voucher" aria-selected="false">Voucher
                                Details</button>
                        </li>
                        @endif
                    </ul>
                    <div class="tab-content" id="documentTabContent">
                        @if($user->info)
                        <div class="tab-pane fade show active" id="personal" role="tabpanel"
                            aria-labelledby="personal-tab">
                            <div class="row">
                                <div class="col-md-4 col-sm-12 text-center img-container">
                                    <div class="document-image"><a href="{{ $user->info->full_profile_picture }}"
                                            data-fancybox="image"><img
                                                src="{{ $user->info->full_profile_picture }}"></a>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12">
                                    <table class="table mb-0">
                                        <tr scope="row">
                                            <th width="200">First Name</th>
                                            <td>{{$user->info->first_name}}</td>
                                        </tr>
                                        <tr scope="row">
                                            <th>Middle Name</th>
                                            <td>{{$user->info->middle_name}}</td>
                                        </tr>
                                        <tr scope="row">
                                            <th>Last Name</th>
                                            <td>{{$user->info->last_name}}</td>
                                        </tr>
                                        <tr scope="row">
                                            <th>Date of Birth(A.D)</th>
                                            <td>{{$user->info->dob_eng}}</td>
                                        </tr>
                                        <tr scope="row">
                                            <th>Father's Name</th>
                                            <td>{{$user->info->father_name}}</td>
                                        </tr>
                                        <tr scope="row">
                                            <th>Mother's Name</th>
                                            <td>{{$user->info->mother_name}}</td>
                                        </tr>
                                        <tr scope="row">
                                            <th>Grandfather's Name</th>
                                            <td>{{$user->info->grandfather_name}}</td>
                                        </tr>
                                        <tr scope="row">
                                            <th>Gender</th>
                                            <td>{{$user->info->sex}}</td>
                                        </tr>
                                        <tr scope="row">
                                            <th>Marital Status</th>
                                            <td>{{$user->info->marital_status}}</td>
                                        </tr>
                                        <tr scope="row">
                                            <th>District</th>
                                            <td>{{$user->info->district?->name}}</td>
                                        </tr>
                                        <tr scope="row">
                                            <th>Ward No.</th>
                                            <td>{{$user->info->ward_no}}</td>
                                        </tr>
                                        <tr scope="row">
                                            <th>Citizenship Issued Date</th>
                                            <td>{{$user->info->citizenship_issue_date}}</td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-md-4 col-sm-12">
                                    <table class="table mb-0">
                                        <tr scope="row">
                                            <th width="200">पहिलो नाम </th>
                                            <td>{{$user->info->first_name_nep}}</td>
                                        </tr>
                                        <tr scope="row">
                                            <th>
बिचको नाम</th>
                                            <td>{{$user->info->middle_name_nep}}</td>
                                        </tr>
                                        <tr scope="row">
                                            <th>
थर </th>
                                            <td>{{$user->info->last_name_nep}}</td>
                                        </tr>
                                        <tr scope="row">
                                            <th>
Date of Birth(B.S)</th>
                                            <td>{{$user->info->dob_nep}}</td>
                                        </tr>
                                        <tr scope="row">
                                            <th>
बुबाको नाम </th>
                                            <td>{{$user->info->father_name_nep}}</td>
                                        </tr>
                                        <tr scope="row">
                                            <th>
आमाको नाम </th>
                                            <td>{{$user->info->mother_name_nep}}</td>
                                        </tr>
                                        <tr scope="row">
                                            <th>
हजुरबुबाको नाम</th>
                                            <td>{{$user->info->grandfather_name_nep}}</td>
                                        </tr>
                                        <tr scope="row">
                                            <th>Ethnicity</th>
                                            <td>{{$user->info->ethinic}}</td>
                                        </tr>
                                        <tr scope="row">
                                            <th>Province</th>
                                            <td>{{$user->info->province?->name}}</td>
                                        </tr>
                                        <tr scope="row">
                                            <th>Municipality</th>
                                            <td>{{$user->info->municipality?->name}}</td>
                                        </tr>
                                        <tr scope="row">
                                            <th>
Citizenship No.</th>
                                            <td>{{$user->info->citizenship_number}}</td>
                                        </tr>
                                        <tr scope="row">
                                            <th>
Citizenship Issued District</th>
                                            <td>{{$user->info->citizenship_issue_district}}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>

                           
                        </div>
                        @endif
                        @if($user->info)
                        <div class="tab-pane fade" id="supportive" role="tabpanel" aria-labelledby="supportive-tab">
                            <div class="row">
                                <div class="col-md-12 col-sm-12">
                                    <div class="row">
                                        @if($user->info->citizenship_front)
                                        <div class="col-md-4 img-container">
                                            <strong>Citizenship Front Image</strong>
                                            <div class="document-image"><a
                                                    href="{{ $user->info->full_citizenship_front }}"
                                                    data-fancybox="image"><img
                                                        src="{{ $user->info->full_citizenship_front }}"></a>
                                            </div>
                                        </div>
                                        @endif
                                        @if($user->info->citizenship_back)
                                        <div class="col-md-4 img-container">
                                            <strong>Citizenship Back Image</strong>
                                            <div class="document-image"><a
                                                    href="{{ $user->info->full_citizenship_back }}"
                                                    data-fancybox="image"><img
                                                        src="{{ $user->info->full_citizenship_back }}"></a>
                                            </div>
                                        </div>
                                        @endif

                                        @if($user->info->signature_image)
                                        <div class="col-md-4 img-container">
                                            <strong>Signature Image</strong>
                                            <div class="document-image"> <a
                                                    href="{{ $user->info->full_signature_image }}"
                                                    data-fancybox="image"><img
                                                        src="{{ $user->info->full_signature_image }}"></a>
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                        @if($user->slc)
                        <div class="tab-pane fade" id="slc" role="tabpanel" aria-labelledby="slc-tab">
                            <div class="row">
                                <div class="col-md-12 col-sm-12">
                                    <div class="row">
                                        <div class="col-md-12 info-container mb-3">
                                            <div><strong>School Name :
                                                </strong><span>{{$user->slc->college_name}}</span></div>
                                            <div><strong>Board: </strong><span>{{$user->slc->board_university}}</span>
                                            </div>
                                            <div><strong>Passed Year : </strong><span>{{$user->slc->passed_year}}</span>
                                            </div>
                                        </div>
                                        @if($user->slc->transcript_image)
                                        <div class="col-md-4 img-container">
                                            <strong>Transcript Image</strong>
                                            <div class="document-image"> <a
                                                    href="{{ $user->slc->full_transcript_image }}"
                                                    data-fancybox="image"><img
                                                        src="{{ $user->slc->full_transcript_image }}"></a>
                                            </div>
                                        </div>
                                        @endif
                                        @if($user->slc->provisional_image)
                                        <div class="col-md-4 img-container">
                                            <strong>Provisional Image</strong>
                                            <div class="document-image"><a
                                                    href="{{ $user->slc->full_provisional_image }}"
                                                    data-fancybox="image"><img
                                                        src="{{ $user->slc->full_provisional_image }}"></a>
                                            </div>
                                        </div>
                                        @endif

                                        @if($user->slc->character_image)
                                        <div class="col-md-4 img-container">
                                            <strong>Character Image</strong>
                                            <div class="document-image"> <a
                                                    href="{{ $user->slc->full_character_image }}"
                                                    data-fancybox="image"><img
                                                        src="{{ $user->slc->full_character_image }}"></a>
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif

                        @if($user->tslc)
                        <div class="tab-pane fade" id="tslc" role="tabpanel" aria-labelledby="tslc-tab">
                            <div class="row">
                                <div class="col-md-12 col-sm-12  mt-3">
                                    <div class="row">
                                        <div class="col-md-12 info-container mb-3">
                                            <div><strong>College Name :
                                                </strong><span>{{$user->tslc->college_name}}</span></div>
                                            <div><strong>Board: </strong><span>{{$user->tslc->board_university}}</span>
                                            </div>
                                            <div><strong>Passed Year :
                                                </strong><span>{{$user->tslc->passed_year}}</span></div>
                                            <div><strong>Registration Number :
                                                </strong><span>{{$user->tslc->registration_number}}</span></div>
                                        </div>
                                        @if($user->tslc->transcript_image)
                                        <div class="col-md-4 img-container">
                                            <strong>Transcript Image</strong>
                                            <div class="document-image"> <a
                                                    href="{{ $user->tslc->full_transcript_image }}"
                                                    data-fancybox="image"><img
                                                        src="{{ $user->tslc->full_transcript_image }}"></a>
                                            </div>
                                        </div>
                                        @endif
                                        @if($user->tslc->provisional_image)
                                        <div class="col-md-4 img-container">
                                            <strong>Provisional Image</strong>
                                            <div class="document-image"><a
                                                    href="{{ $user->tslc->full_provisional_image }}"
                                                    data-fancybox="image"><img
                                                        src="{{ $user->tslc->full_provisional_image }}"></a>
                                            </div>
                                        </div>
                                        @endif
                                        @if($user->tslc->character_image)
                                        <div class="col-md-4 img-container">
                                            <strong>Character Image</strong>
                                            <div class="document-image"> <a
                                                    href="{{ $user->tslc->full_character_image }}"
                                                    data-fancybox="image"><img
                                                        src="{{ $user->tslc->full_character_image }}"></a>
                                            </div>
                                        </div>
                                        @endif
                                        @if($user->tslc->ojt_image)
                                        <div class="col-md-4 img-container">
                                            <strong>OJT Image</strong>
                                            <div class="document-image"> <a href="{{ $user->tslc->full_ojt_image }}"
                                                    data-fancybox="image"><img
                                                        src="{{ $user->tslc->full_ojt_image }}"></a>
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                        @if($user->pcl)
                        <div class="tab-pane fade" id="pcl" role="tabpanel" aria-labelledby="pcl-tab">
                            <div class="row">
                                <div class="col-md-12 col-sm-12">
                                    <div class="row">
                                        <div class="col-md-12 info-container mb-3">
                                            <div><strong>College Name :
                                                </strong><span>{{$user->pcl->college_name}}</span></div>
                                            <div><strong>Board : </strong><span>{{$user->pcl->board_university}}</span>
                                            </div>
                                            <div><strong>Passed Year : </strong><span>{{$user->pcl->passed_year}}</span>
                                            </div>
                                            <div><strong>RegistrationNumber :
                                                </strong><span>{{$user->pcl->registration_number}}</span></div>
                                        </div>
                                        @if($user->pcl->transcript_image)
                                        <div class="col-md-4 img-container">
                                            <strong>Transcript Image</strong>
                                            <div class="document-image"> <a
                                                    href="{{ $user->pcl->full_transcript_image }}"
                                                    data-fancybox="image"><img
                                                        src="{{ $user->pcl->full_transcript_image }}"></a>
                                            </div>
                                        </div>
                                        @endif
                                        @if($user->pcl->transcript_bac_1)
                                        <div class="col-md-4 img-container">
                                            <strong>Transcript Image</strong>
                                            <div class="document-image"> <a
                                                    href="{{ $user->pcl->full_transcript_bac_1 }}"
                                                    data-fancybox="image"><img
                                                        src="{{ $user->pcl->full_transcript_bac_1 }}"></a>
                                            </div>
                                        </div>
                                        @endif
                                        @if($user->pcl->provisional_image)
                                        <div class="col-md-4 img-container">
                                            <strong>Provisional Image</strong>
                                            <div class="document-image"><a
                                                    href="{{ $user->pcl->full_provisional_image }}"
                                                    data-fancybox="image"><img
                                                        src="{{ $user->pcl->full_provisional_image }}"></a>
                                            </div>
                                        </div>
                                        @endif
                                        @if($user->pcl->character_image)
                                        <div class="col-md-4 img-container">
                                            <strong>Character Image</strong>
                                            <div class="document-image"> <a
                                                    href="{{ $user->pcl->full_character_image }}"
                                                    data-fancybox="image"><img
                                                        src="{{ $user->pcl->full_character_image }}"></a>
                                            </div>
                                        </div>
                                        @endif
                                        @if($user->pcl->equivalence_certificate)
                                        <div class="col-md-4 img-container">
                                            <strong>Equivalence Image</strong>
                                            <div class="document-image"> <a
                                                    href="{{ $user->pcl->full_equivalence_certificate }}"
                                                    data-fancybox="image"><img
                                                        src="{{ $user->pcl->full_equivalence_certificate }}"></a>
                                            </div>
                                        </div>
                                        @endif
                                        @if ($user->pcl->ojt_image)
                                        <div class="col-md-4 img-container">
                                            <strong>OJT Image</strong>
                                            <div class="document-image"><a href="{{ $user->pcl->full_ojt_image }}"
                                                    data-fancybox="image"><img
                                                        src="{{ $user->pcl->full_ojt_image }}"></a>
                                            </div>
                                        </div>
                                    @endif
                                    @if ($user->pcl->noc_image)
                                        <div class="col-md-4 img-container">
                                            <strong>NOC Image</strong>
                                            <div class="document-image"><a href="{{ $user->pcl->full_noc_image }}"
                                                    data-fancybox="image"><img
                                                        src="{{ $user->pcl->full_noc_image }}"></a>
                                            </div>
                                        </div>
                                    @endif
                                    @if ($user->pcl->intership_image)
                                        <div class="col-md-4 img-container">
                                            <strong>Internship Image</strong>
                                            <div class="document-image"><a
                                                    href="{{ $user->pcl->full_intership_image }}"
                                                    data-fancybox="image"><img
                                                        src="{{ $user->pcl->full_intership_image }}"></a>
                                            </div>
                                        </div>
                                    @endif
                                    @if ($user->pcl->council_registration_certificate)
                                        <div class="col-md-4 img-container">
                                            <strong>Council Registration Certificate</strong>
                                            <div class="document-image"><a
                                                    href="{{ $user->pcl->full_council_registration_certificate }}"
                                                    data-fancybox="image"><img
                                                        src="{{ $user->pcl->full_council_registration_certificate }}"></a>
                                            </div>
                                        </div>
                                    @endif
                                        @if($user->pcl->ojt_pcl_community_1_image)
                                        <div class="col-md-4 img-container">
                                            <strong>Clinical / Community Work Image 1</strong>
                                            <div class="document-image"><a
                                                    href="{{ $user->pcl->full_ojt_pcl_community_1_image }}"
                                                    data-fancybox="image"><img
                                                        src="{{ $user->pcl->full_ojt_pcl_community_1_image }}"></a>
                                            </div>
                                        </div>
                                        @endif
                                        @if($user->pcl->ojt_pcl_community_2_image)
                                        <div class="col-md-4 img-container">
                                            <strong>Clinical / Community Work Image 2</strong>
                                            <div class="document-image"><a
                                                    href="{{ $user->pcl->full_ojt_pcl_community_2_image }}"
                                                    data-fancybox="image"><img
                                                        src="{{ $user->pcl->full_ojt_pcl_community_2_image }}"></a>
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                        @if($user->bachelor)
                        <div class="tab-pane fade" id="bachelor" role="tabpanel" aria-labelledby="bachelor-tab">
                            <div class="row">
                                <div class="col-md-12 col-sm-12">
                                    <div class="row">
                                        <div class="col-md-12 info-container mb-3">
                                            <div><strong>College Name :
                                                </strong><span>{{$user->bachelor->college_name}}</span></div>
                                            <div><strong>University :
                                                </strong><span>{{$user->bachelor->board_university}}</span></div>
                                            <div><strong>Admission Year :
                                                </strong><span>{{$user->bachelor->admission_year}}</span></div>
                                            <div><strong>Passed Year :
                                                </strong><span>{{$user->bachelor->passed_year}}</span></div>
                                            <div><strong>Registration Number :
                                                </strong><span>{{$user->bachelor->registration_number}}</span></div>
                                        </div>
                                        @if($user->bachelor->transcript_bac_1)
                                        <div class="col-md-4 img-container">
                                            <strong>Transcript Image 1</strong>
                                            <div class="document-image"><a
                                                    href="{{ $user->bachelor->full_transcript_bac_1 }}"
                                                    data-fancybox="image"><img
                                                        src="{{ $user->bachelor->full_transcript_bac_1 }}"></a>
                                            </div>
                                        </div>
                                        @endif
                                        @if($user->bachelor->transcript_bac_2)
                                        <div class="col-md-4 img-container">
                                            <strong>Transcript Image 2</strong>
                                            <div class="document-image"> <a
                                                    href="{{ $user->bachelor->full_transcript_bac_2 }}"
                                                    data-fancybox="image"><img
                                                        src="{{ $user->bachelor->full_transcript_bac_2 }}"></a>
                                            </div>
                                        </div>
                                        @endif
                                        @if($user->bachelor->transcript_bac_3)
                                        <div class="col-md-4 img-container">
                                            <strong>Transcript Image 3</strong>
                                            <div class="document-image"> <a
                                                    href="{{ $user->bachelor->full_transcript_bac_3 }}"
                                                    data-fancybox="image"><img
                                                        src="{{ $user->bachelor->full_transcript_bac_3 }}"></a>
                                            </div>
                                        </div>
                                        @endif
                                        @if($user->bachelor->transcript_bac_4)
                                        <div class="col-md-4 img-container">
                                            <strong>Transcript Image 4</strong>
                                            <div class="document-image"> <a
                                                    href="{{ $user->bachelor->full_transcript_bac_4 }}"
                                                    data-fancybox="image"><img
                                                        src="{{ $user->bachelor->full_transcript_bac_4 }}"></a>
                                            </div>
                                        </div>
                                        @endif
                                        @if($user->bachelor->transcript_bac_5)
                                        <div class="col-md-4 img-container">
                                            <strong>Transcript Image 5</strong>
                                            <div class="document-image"> <a
                                                    href="{{ $user->bachelor->full_transcript_bac_5 }}"
                                                    data-fancybox="image"><img
                                                        src="{{ $user->bachelor->full_transcript_bac_5 }}"></a>
                                            </div>
                                        </div>
                                        @endif
                                        @if($user->bachelor->transcript_bac_6)
                                        <div class="col-md-4 img-container">
                                            <strong>Transcript Image 6</strong>
                                            <div class="document-image"> <a
                                                    href="{{ $user->bachelor->full_transcript_bac_6 }}"
                                                    data-fancybox="image"><img
                                                        src="{{ $user->bachelor->full_transcript_bac_6 }}"></a>
                                            </div>
                                        </div>
                                        @endif
                                        @if($user->bachelor->transcript_bac_7)
                                        <div class="col-md-4 img-container">
                                            <strong>Transcript Image 7</strong>
                                            <div class="document-image"> <a
                                                    href="{{ $user->bachelor->full_transcript_bac_7 }}"
                                                    data-fancybox="image"><img
                                                        src="{{ $user->bachelor->full_transcript_bac_7 }}"></a>
                                            </div>
                                        </div>
                                        @endif
                                        @if($user->bachelor->transcript_bac_8)
                                        <div class="col-md-4 img-container">
                                            <strong>Transcript Image 8</strong>
                                            <div class="document-image"> <a
                                                    href="{{ $user->bachelor->full_transcript_bac_8 }}"
                                                    data-fancybox="image"><img
                                                        src="{{ $user->bachelor->full_transcript_bac_8 }}"></a>
                                            </div>
                                        </div>
                                        @endif
                                        @if($user->bachelor->equivalence_certificate)
                                        <div class="col-md-4 img-container">
                                            <strong>Equivalence Certificate</strong>
                                            <div class="document-image"> <a
                                                    href="{{ $user->bachelor->full_equivalence_certificate }}"
                                                    data-fancybox="image"><img
                                                        src="{{ $user->bachelor->full_equivalence_certificate }}"></a>
                                            </div>
                                        </div>
                                        @endif
                                        <div class="col-md-4 img-container">
                                            <strong>Provisional Image</strong>
                                            <div class="document-image">
                                                @if($user->bachelor->provisional_image) <a
                                                    href="{{ $user->bachelor->full_provisional_image }}"
                                                    data-fancybox="image"><img
                                                        src="{{ $user->bachelor->full_provisional_image }}"
                                                        id="display_provisional_image"></a> @else <img src=""
                                                    id="display_provisional_image" class="d-none preview-image">
                                                @endif
                                            </div>
                                        </div>
                                        @if($user->bachelor->character_image)
                                        <div class="col-md-4 img-container">
                                            <strong>Character Image</strong>
                                            <div class="document-image"><a
                                                    href="{{ $user->bachelor->full_character_image }}"
                                                    data-fancybox="image"><img
                                                        src="{{ $user->bachelor->full_character_image }}"></a>
                                            </div>
                                        </div>
                                        @endif
                                        @if($user->bachelor->intership_image)
                                        <div class="col-md-4 img-container">
                                            <strong>Internship Image</strong>
                                            <div class="document-image"> <a
                                                    href="{{ $user->bachelor->full_intership_image }}"
                                                    data-fancybox="image"><img
                                                        src="{{ $user->bachelor->full_intership_image }}"></a>
                                            </div>
                                        </div>
                                        @endif
                                        @if($user->bachelor->passport_image)
                                        <div class="col-md-4 img-container">
                                            <strong>NHPC permission Letter Image</strong>
                                            <div class="document-image"><a href="{{ $user->bachelor->full_noc_image }}"
                                                    data-fancybox="image"><img
                                                        src="{{ $user->bachelor->full_noc_image }}"></a>
                                            </div>
                                        </div>
                                        @endif
                                        @if($user->bachelor->visa_image)
                                        <div class="col-md-4 img-container">
                                            <strong>VISA Image</strong>
                                            <div class="document-image"> <a
                                                    href="{{ $user->bachelor->full_visa_image }}"
                                                    data-fancybox="image"><img
                                                        src="{{ $user->bachelor->full_visa_image }}"></a>
                                            </div>
                                        </div>
                                        @endif
                                        @if($user->bachelor->passport_image)
                                        <div class="col-md-4 img-container">
                                            <strong>Passport Image</strong>
                                            <div class="document-image"> <a
                                                    href="{{ $user->bachelor->full_passport_image }}"
                                                    data-fancybox="image"><img
                                                        src="{{ $user->bachelor->full_passport_image }}"></a>
                                            </div>
                                        </div>
                                        @endif

                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                        @if($user->master)
                        <div class="tab-pane fade" id="master" role="tabpanel" aria-labelledby="master-tab">
                            <div class="row">
                                <div class="col-md-12 col-sm-12">
                                    <div class="row">
                                        <div class="col-md-12 info-container mb-3">
                                            <div><strong>College Name :
                                                </strong><span>{{$user->master->college_name}}</span></div>
                                            <div><strong>University :
                                                </strong><span>{{$user->master->board_university}}</span></div>
                                            <div><strong>Admission Year :
                                                </strong><span>{{$user->master->admission_year}}</span></div>
                                            <div><strong>Passed Year :
                                                </strong><span>{{$user->master->passed_year}}</span></div>
                                            <div><strong>Registration Number :
                                                </strong><span>{{$user->master->registration_number}}</span></div>
                                        </div>
                                        @if($user->master->transcript_mas_marksheet)
                                        <div class="col-md-4 img-container">
                                            <strong>Transcript Image</strong>
                                            <div class="document-image"> <a
                                                    href="{{ $user->master->full_transcript_mas_marksheet }}"
                                                    data-fancybox="image"><img
                                                        src="{{ $user->master->full_transcript_mas_marksheet }}"></a>
                                            </div>
                                        </div>
                                        @endif
                                        @if($user->master->equivalence_certificate)
                                        <div class="col-md-4 img-container">
                                            <strong>Equivalence Image</strong>
                                            <div class="document-image"> <a
                                                    href="{{ $user->master->full_equivalence_certificate }}"
                                                    data-fancybox="image"><img
                                                        src="{{ $user->master->full_equivalence_certificate }}"></a>
                                            </div>
                                        </div>
                                        @endif
                                        @if($user->master->provisional_image)
                                        <div class="col-md-4 img-container">
                                            <strong>Provisional Image</strong>
                                            <div class="document-image"> <a
                                                    href="{{ $user->master->full_provisional_image }}"
                                                    data-fancybox="image"><img
                                                        src="{{ $user->master->full_provisional_image }}"></a>
                                            </div>
                                        </div>
                                        @endif
                                        @if($user->master->character_image)
                                        <div class="col-md-4 img-container">
                                            <strong>Character Image</strong>
                                            <div class="document-image"> <a
                                                    href="{{ $user->master->full_character_image }}"
                                                    data-fancybox="image"><img
                                                        src="{{ $user->master->full_character_image }}"></a>
                                            </div>
                                        </div>
                                        @endif
                                        @if($user->master->intership_image)
                                        <div class="col-md-4 img-container">
                                            <strong>Internship Image</strong>
                                            <div class="document-image"> <a
                                                    href="{{ $user->master->full_intership_image }}"
                                                    data-fancybox="image"><img
                                                        src="{{ $user->master->full_intership_image }}"></a>
                                            </div>
                                        </div>
                                        @endif
                                        @if($user->master->passport_image)
                                        <div class="col-md-4 img-container">
                                            <strong>NHPC permission Letter Image</strong>
                                            <div class="document-image"> <a href="{{ $user->master->full_noc_image }}"
                                                    data-fancybox="image"><img
                                                        src="{{ $user->master->full_noc_image }}"></a>
                                            </div>
                                        </div>
                                        @endif
                                        @if($user->master->visa_image)
                                        <div class="col-md-4 img-container">
                                            <strong>VISA Image</strong>
                                            <div class="document-image"> <a href="{{ $user->master->full_visa_image }}"
                                                    data-fancybox="image"><img
                                                        src="{{ $user->master->full_visa_image }}"></a>
                                            </div>
                                        </div>
                                        @endif
                                        @if($user->master->passport_image)
                                        <div class="col-md-4 img-container">
                                            <strong>Passport Image</strong>
                                            <div class="document-image"> <a
                                                    href="{{ $user->master->full_passport_image }}"
                                                    data-fancybox="image"><img
                                                        src="{{ $user->master->full_passport_image }}"></a>
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                        @if($exam_apply)
                        <div class="tab-pane fade" id="voucher" role="tabpanel" aria-labelledby="voucher-tab">
                            <div class="row">
                                <div class="col-md-12 col-sm-12">
                                    <div class="row">
                                        <div class="col-md-12 info-container mb-3">
                                            <div><strong>Level : </strong>{{$exam_apply->level->name}}</span></span>
                                            </div>
                                            <div><strong>Program : </strong><span>{{$exam_apply->program->name}}</span>
                                            </div>
                                        </div>
                                        @if($exam_apply->voucher_image)
                                        <div class="col-md-4 img-container">
                                            <strong>Voucher Image</strong>
                                            <div class="document-image"> <a href="{{ $exam_apply->full_voucher_image}}"
                                                    data-fancybox="image"><img
                                                        src="{{ $exam_apply->full_voucher_image }}"></a>
                                            </div>
                                        </div>
                                        @endif

                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>

                </div>
            </div>
        </div>
    </div>
    @endsection
@section('footer-scripts')
<link href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.css" rel="stylesheet"
    type="text/css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js"></script>
@endsection



