<div class="col-12">
    <div class="card">
        <div class="card-body student-documents">

            <ul class="nav nav-tabs d-none" id="documentTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link  active" id="supportive-tab" data-bs-toggle="tab" data-bs-target="#supportive"
                        type="button" role="tab" aria-controls="supportive" aria-selected="true">Supportive
                        Documents
                    </button>
                </li>
                @if ($user->slc)
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="slc-tab" data-bs-toggle="tab" data-bs-target="#slc"
                            type="button" role="tab" aria-controls="slc" aria-selected="true">SLC / SEE
                            Documents</button>
                    </li>
                @endif
                @if ($user->tslc)
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="tslc-tab" data-bs-toggle="tab" data-bs-target="#tslc"
                            type="button" role="tab" aria-controls="tslc" aria-selected="flase">TSLC
                            Documents</button>
                    </li>
                @endif
                @if ($user->pcl)
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pcl-tab" data-bs-toggle="tab" data-bs-target="#pcl"
                            type="button" role="tab" aria-controls="pcl" aria-selected="false">PCL / +2
                            Documents</button>
                    </li>
                @endif
                @if ($user->bachelor)
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="bachelor-tab" data-bs-toggle="tab" data-bs-target="#bachelor"
                            type="button" role="tab" aria-controls="bachelor" aria-selected="false">Bachelor
                            Documents</button>
                    </li>
                @endif
                @if ($user->master)
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="master-tab" data-bs-toggle="tab" data-bs-target="#master"
                            type="button" role="tab" aria-controls="master" aria-selected="false">Master
                            Documents</button>
                    </li>
                @endif
            </ul>
            <div class="tab-content" id="documentTabContent">
                @if ($user->info)
                    <div class="title"><h4>Supportive Documents</h4></div>
                    <div class="tab-pane fade show active" id="supportive" role="tabpanel"
                        aria-labelledby="supportive-tab">
                        <div class="row">
                            <div class="col-md-12 col-sm-12">
                                <div class="row">
                                    @if ($user->info->citizenship_front)
                                        <div class="col-md-4 img-container">
                                            <strong>Citizenship Front Image</strong>
                                            <div class="document-image"><a
                                                    href="{{ $user->info->full_citizenship_front }}"
                                                    data-fancybox="image"><img
                                                        src="{{ $user->info->full_citizenship_front }}"></a>
                                            </div>
                                        </div>
                                    @endif
                                    @if ($user->info->citizenship_back)
                                        <div class="col-md-4 img-container">
                                            <strong>Citizenship Back Image</strong>
                                            <div class="document-image"><a
                                                    href="{{ $user->info->full_citizenship_back }}"
                                                    data-fancybox="image"><img
                                                        src="{{ $user->info->full_citizenship_back }}"></a>
                                            </div>
                                        </div>
                                    @endif

                                    @if ($user->info->signature_image)
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
                @if ($user->slc)
                <div class="title"><h4>SLC / SEE Documents</h4></div>
                    <div class="tab-pane fade show active" id="slc" role="tabpanel" aria-labelledby="slc-tab">
                        <div class="row">
                            <div class="col-md-12 col-sm-12">
                                <div class="row">
                                    @if ($user->slc->registration_image)
                                        <div class="col-md-4 img-container">
                                            <strong>Transcript Image</strong>
                                            <div class="document-image"> <a
                                                    href="{{ $user->slc->full_registration_image }}"
                                                    data-fancybox="image"><img
                                                        src="{{ $user->slc->full_registration_image }}"></a>
                                            </div>
                                        </div>
                                    @endif
                                    @if ($user->slc->transcript_image)
                                        <div class="col-md-4 img-container">
                                            <strong>Transcript Image</strong>
                                            <div class="document-image"> <a
                                                    href="{{ $user->slc->full_transcript_image }}"
                                                    data-fancybox="image"><img
                                                        src="{{ $user->slc->full_transcript_image }}"></a>
                                            </div>
                                        </div>
                                    @endif
                                    @if ($user->slc->transcript_bac_1)
                                        <div class="col-md-4 img-container">
                                            <strong>Transcript Image 1</strong>
                                            <div class="document-image"> <a
                                                    href="{{ $user->slc->full_transcript_bac_1 }}"
                                                    data-fancybox="image"><img
                                                        src="{{ $user->slc->full_transcript_bac_1 }}"></a>
                                            </div>
                                        </div>
                                    @endif
                                    @if ($user->slc->transcript_bac_2)
                                        <div class="col-md-4 img-container">
                                            <strong>Transcript Image</strong>
                                            <div class="document-image"> <a
                                                    href="{{ $user->slc->full_transcript_bac_2 }}"
                                                    data-fancybox="image"><img
                                                        src="{{ $user->slc->full_transcript_bac_2 }}"></a>
                                            </div>
                                        </div>
                                    @endif
                                    @if ($user->slc->transcript_bac_3)
                                        <div class="col-md-4 img-container">
                                            <strong>Transcript Image</strong>
                                            <div class="document-image"> <a
                                                    href="{{ $user->slc->full_transcript_bac_3 }}"
                                                    data-fancybox="image"><img
                                                        src="{{ $user->slc->full_transcript_bac_3 }}"></a>
                                            </div>
                                        </div>
                                    @endif
                                    @if ($user->slc->migration_image)
                                        <div class="col-md-4 img-container">
                                            <strong>Provisional Image</strong>
                                            <div class="document-image"><a
                                                    href="{{ $user->slc->full_migration_image }}"
                                                    data-fancybox="image"><img
                                                        src="{{ $user->slc->full_migration_image }}"></a>
                                            </div>
                                        </div>
                                    @endif
                                    @if ($user->slc->provisional_image)
                                        <div class="col-md-4 img-container">
                                            <strong>Provisional Image</strong>
                                            <div class="document-image"><a
                                                    href="{{ $user->slc->full_provisional_image }}"
                                                    data-fancybox="image"><img
                                                        src="{{ $user->slc->full_provisional_image }}"></a>
                                            </div>
                                        </div>
                                    @endif

                                    @if ($user->slc->character_image)
                                        <div class="col-md-4 img-container">
                                            <strong>Character Image</strong>
                                            <div class="document-image"> <a
                                                    href="{{ $user->slc->full_character_image }}"
                                                    data-fancybox="image"><img
                                                        src="{{ $user->slc->full_character_image }}"></a>
                                            </div>
                                        </div>
                                    @endif
                                    @if ($user->slc->equivalence_certificate)
                                        <div class="col-md-4 img-container">
                                            <strong>Equivalence Image</strong>
                                            <div class="document-image"> <a
                                                    href="{{ $user->slc->full_equivalence_certificate }}"
                                                    data-fancybox="image"><img
                                                        src="{{ $user->slc->full_equivalence_certificate }}"></a>
                                            </div>
                                        </div>
                                    @endif
                                    @if ($user->slc->council_registration_certificate)
                                        <div class="col-md-4 img-container">
                                            <strong>Equivalence Image</strong>
                                            <div class="document-image"> <a
                                                    href="{{ $user->slc->full_council_registration_certificate }}"
                                                    data-fancybox="image"><img
                                                        src="{{ $user->slc->full_council_registration_certificate }}"></a>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                @if ($user->tslc)
                    <div class="title"><h4>TSLC Documents</h4></div>
                    <div class="tab-pane fade show active" id="tslc" role="tabpanel" aria-labelledby="tslc-tab">
                        <div class="row">
                            <div class="col-md-12 col-sm-12  mt-3">
                                <div class="row">
                                    @if ($user->tslc->transcript_image)
                                        <div class="col-md-4 img-container">
                                            <strong>Transcript Image</strong>
                                            <div class="document-image"> <a
                                                    href="{{ $user->tslc->full_transcript_image }}"
                                                    data-fancybox="image"><img
                                                        src="{{ $user->tslc->full_transcript_image }}"></a>
                                            </div>
                                        </div>
                                    @endif
                                    @if ($user->tslc->transcript_bac_1)
                                        <div class="col-md-4 img-container">
                                            <strong>Transcript Image 1</strong>
                                            <div class="document-image"><a
                                                    href="{{ $user->tslc->full_transcript_bac_1 }}"
                                                    data-fancybox="image"><img
                                                        src="{{ $user->tslc->full_transcript_bac_1 }}"></a>
                                            </div>
                                        </div>
                                    @endif
                                    @if ($user->tslc->transcript_bac_2)
                                        <div class="col-md-4 img-container">
                                            <strong>Transcript Image 2</strong>
                                            <div class="document-image"><a
                                                    href="{{ $user->tslc->full_transcript_bac_2 }}"
                                                    data-fancybox="image"><img
                                                        src="{{ $user->tslc->full_transcript_bac_2 }}"></a>
                                            </div>
                                        </div>
                                    @endif
                                    @if ($user->tslc->transcript_bac_3)
                                        <div class="col-md-4 img-container">
                                            <strong>Transcript Image 3</strong>
                                            <div class="document-image"><a
                                                    href="{{ $user->tslc->full_transcript_bac_3 }}"
                                                    data-fancybox="image"><img
                                                        src="{{ $user->tslc->full_transcript_bac_3 }}"></a>
                                            </div>
                                        </div>
                                    @endif
                                    @if ($user->tslc->provisional_image)
                                        <div class="col-md-4 img-container">
                                            <strong>Provisional Image</strong>
                                            <div class="document-image"><a
                                                    href="{{ $user->tslc->full_provisional_image }}"
                                                    data-fancybox="image"><img
                                                        src="{{ $user->tslc->full_provisional_image }}"></a>
                                            </div>
                                        </div>
                                    @endif
                                    @if ($user->tslc->character_image)
                                        <div class="col-md-4 img-container">
                                            <strong>Character Image</strong>
                                            <div class="document-image"> <a
                                                    href="{{ $user->tslc->full_character_image }}"
                                                    data-fancybox="image"><img
                                                        src="{{ $user->tslc->full_character_image }}"></a>
                                            </div>
                                        </div>
                                    @endif
                                    @if ($user->tslc->ojt_image)
                                        <div class="col-md-4 img-container">
                                            <strong>OJT Image</strong>
                                            <div class="document-image"> <a href="{{ $user->tslc->full_ojt_image }}"
                                                    data-fancybox="image"><img
                                                        src="{{ $user->tslc->full_ojt_image }}"></a>
                                            </div>
                                        </div>
                                    @endif
                                    @if ($user->tslc->intership_image)
                                        <div class="col-md-4 img-container">
                                            <strong>Internship Image</strong>
                                            <div class="document-image"> <a
                                                    href="{{ $user->tslc->full_intership_image }}"
                                                    data-fancybox="image"><img
                                                        src="{{ $user->tslc->full_intership_image }}"></a>
                                            </div>
                                        </div>
                                    @endif
                                    @if ($user->tslc->noc_image)
                                        <div class="col-md-4 img-container">
                                            <strong>NOC Image</strong>
                                            <div class="document-image"> <a href="{{ $user->tslc->full_noc_image }}"
                                                    data-fancybox="image"><img
                                                        src="{{ $user->tslc->full_noc_image }}"></a>
                                            </div>
                                        </div>
                                    @endif
                                    @if ($user->tslc->migration_image)
                                        <div class="col-md-4 img-container">
                                            <strong>Migration Image</strong>
                                            <div class="document-image"> <a href="{{ $user->tslc->migration_image }}"
                                                    data-fancybox="image"><img
                                                        src="{{ $user->tslc->migration_image }}"></a>
                                            </div>
                                        </div>
                                    @endif
                                    @if ($user->tslc->migration_image)
                                        <div class="col-md-4 img-container">
                                            <strong>Migration Image</strong>
                                            <div class="document-image"> <a
                                                    href="{{ $user->tslc->full_migration_image }}"
                                                    data-fancybox="image"><img
                                                        src="{{ $user->tslc->full_migration_image }}"></a>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                @if ($user->pcl)
                    <div class="title"><h4>PCL / +2 Documents</h4></div>
                    <div class="tab-pane fade show active" id="pcl" role="tabpanel" aria-labelledby="pcl-tab">
                        <div class="row">
                            <div class="col-md-12 col-sm-12">
                                <div class="row">
                                    @if ($user->pcl->transcript_image)
                                        <div class="col-md-4 img-container">
                                            <strong>Transcript Image</strong>
                                            <div class="document-image"> <a
                                                    href="{{ $user->pcl->full_transcript_image }}"
                                                    data-fancybox="image"><img
                                                        src="{{ $user->pcl->full_transcript_image }}"></a>
                                            </div>
                                        </div>
                                    @endif
                                    @if ($user->pcl->transcript_bac_1)
                                        <div class="col-md-4 img-container">
                                            <strong>Transcript Image 1</strong>
                                            <div class="document-image"> <a
                                                    href="{{ $user->pcl->full_transcript_bac_1 }}"
                                                    data-fancybox="image"><img
                                                        src="{{ $user->pcl->full_transcript_bac_1 }}"></a>
                                            </div>
                                        </div>
                                    @endif
                                    @if ($user->pcl->transcript_bac_2)
                                        <div class="col-md-4 img-container">
                                            <strong>Transcript Image 2</strong>
                                            <div class="document-image"> <a
                                                    href="{{ $user->pcl->full_transcript_bac_2 }}"
                                                    data-fancybox="image"><img
                                                        src="{{ $user->pcl->full_transcript_bac_2 }}"></a>
                                            </div>
                                        </div>
                                    @endif
                                    @if ($user->pcl->transcript_bac_3)
                                        <div class="col-md-4 img-container">
                                            <strong>Transcript Image 3</strong>
                                            <div class="document-image"> <a
                                                    href="{{ $user->pcl->full_transcript_bac_3 }}"
                                                    data-fancybox="image"><img
                                                        src="{{ $user->pcl->full_transcript_bac_3 }}"></a>
                                            </div>
                                        </div>
                                    @endif
                                    @if ($user->pcl->provisional_image)
                                        <div class="col-md-4 img-container">
                                            <strong>Provisional Image</strong>
                                            <div class="document-image"><a
                                                    href="{{ $user->pcl->full_provisional_image }}"
                                                    data-fancybox="image"><img
                                                        src="{{ $user->pcl->full_provisional_image }}"></a>

                                            </div>
                                        </div>
                                    @endif
                                    @if ($user->pcl->character_image)
                                        <div class="col-md-4 img-container">
                                            <strong>Character Image</strong>
                                            <div class="document-image"> <a
                                                    href="{{ $user->pcl->full_character_image }}"
                                                    data-fancybox="image"><img
                                                        src="{{ $user->pcl->full_character_image }}"></a>
                                            </div>
                                        </div>
                                    @endif
                                    @if ($user->pcl->equivalence_certificate)
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
                                    @if ($user->pcl->ojt_pcl_community_1_image)
                                        <div class="col-md-4 img-container">
                                            <strong>Clinical / Community Work Image 1</strong>
                                            <div class="document-image"><a
                                                    href="{{ $user->pcl->full_ojt_pcl_community_1_image }}"
                                                    data-fancybox="image"><img
                                                        src="{{ $user->pcl->full_ojt_pcl_community_1_image }}"></a>
                                            </div>
                                        </div>
                                    @endif
                                    @if ($user->pcl->ojt_pcl_community_2_image)
                                        <div class="col-md-4 img-container">
                                            <strong>Clinical / Community Work Image 2</strong>
                                            <div class="document-image"><a
                                                    href="{{ $user->pcl->full_ojt_pcl_community_2_image }}"
                                                    data-fancybox="image"><img
                                                        src="{{ $user->pcl->full_ojt_pcl_community_2_image }}"></a>
                                            </div>
                                        </div>
                                    @endif
                                    @if ($user->pcl->passport_image)
                                        <div class="col-md-4 img-container">
                                            <strong>Passport Image</strong>
                                            <div class="document-image"><a
                                                    href="{{ $user->pcl->full_passport_image }}"
                                                    data-fancybox="image"><img
                                                        src="{{ $user->pcl->full_passport_image }}"></a>
                                            </div>
                                        </div>
                                    @endif
                                    @if ($user->pcl->visa_image)
                                        <div class="col-md-4 img-container">
                                            <strong>VISA Image</strong>
                                            <div class="document-image"><a href="{{ $user->pcl->full_visa_image }}"
                                                    data-fancybox="image"><img
                                                        src="{{ $user->pcl->full_visa_image }}"></a>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                @if ($user->bachelor)
                    <div class="title"><h4>Bachelor Documents</h4></div>
                    <div class="tab-pane fade show active" id="bachelor" role="tabpanel" aria-labelledby="bachelor-tab">
                        <div class="row">
                            <div class="col-md-12 col-sm-12">
                                <div class="row">
                                    @if ($user->bachelor->transcript_image)
                                        <div class="col-md-4 img-container">
                                            <strong>Transcript Image </strong>
                                            <div class="document-image"><a
                                                    href="{{ $user->bachelor->full_transcript_image }}"
                                                    data-fancybox="image"><img
                                                        src="{{ $user->bachelor->full_transcript_image }}"></a>
                                            </div>
                                        </div>
                                    @endif
                                    @if ($user->bachelor->transcript_bac_1)
                                        <div class="col-md-4 img-container">
                                            <strong>Transcript Image 1</strong>
                                            <div class="document-image"><a
                                                    href="{{ $user->bachelor->full_transcript_bac_1 }}"
                                                    data-fancybox="image"><img
                                                        src="{{ $user->bachelor->full_transcript_bac_1 }}"></a>
                                            </div>
                                        </div>
                                    @endif
                                    @if ($user->bachelor->transcript_bac_2)
                                        <div class="col-md-4 img-container">
                                            <strong>Transcript Image 2</strong>
                                            <div class="document-image"> <a
                                                    href="{{ $user->bachelor->full_transcript_bac_2 }}"
                                                    data-fancybox="image"><img
                                                        src="{{ $user->bachelor->full_transcript_bac_2 }}"></a>
                                            </div>
                                        </div>
                                    @endif
                                    @if ($user->bachelor->transcript_bac_3)
                                        <div class="col-md-4 img-container">
                                            <strong>Transcript Image 3</strong>
                                            <div class="document-image"> <a
                                                    href="{{ $user->bachelor->full_transcript_bac_3 }}"
                                                    data-fancybox="image"><img
                                                        src="{{ $user->bachelor->full_transcript_bac_3 }}"></a>
                                            </div>
                                        </div>
                                    @endif
                                    @if ($user->bachelor->transcript_bac_4)
                                        <div class="col-md-4 img-container">
                                            <strong>Transcript Image 4</strong>
                                            <div class="document-image"> <a
                                                    href="{{ $user->bachelor->full_transcript_bac_4 }}"
                                                    data-fancybox="image"><img
                                                        src="{{ $user->bachelor->full_transcript_bac_4 }}"></a>
                                            </div>
                                        </div>
                                    @endif
                                    @if ($user->bachelor->transcript_bac_5)
                                        <div class="col-md-4 img-container">
                                            <strong>Transcript Image 5</strong>
                                            <div class="document-image"> <a
                                                    href="{{ $user->bachelor->full_transcript_bac_5 }}"
                                                    data-fancybox="image"><img
                                                        src="{{ $user->bachelor->full_transcript_bac_5 }}"></a>
                                            </div>
                                        </div>
                                    @endif
                                    @if ($user->bachelor->transcript_bac_6)
                                        <div class="col-md-4 img-container">
                                            <strong>Transcript Image 6</strong>
                                            <div class="document-image"> <a
                                                    href="{{ $user->bachelor->full_transcript_bac_6 }}"
                                                    data-fancybox="image"><img
                                                        src="{{ $user->bachelor->full_transcript_bac_6 }}"></a>
                                            </div>
                                        </div>
                                    @endif
                                    @if ($user->bachelor->transcript_bac_7)
                                        <div class="col-md-4 img-container">
                                            <strong>Transcript Image 7</strong>
                                            <div class="document-image"> <a
                                                    href="{{ $user->bachelor->full_transcript_bac_7 }}"
                                                    data-fancybox="image"><img
                                                        src="{{ $user->bachelor->full_transcript_bac_7 }}"></a>
                                            </div>
                                        </div>
                                    @endif
                                    @if ($user->bachelor->transcript_bac_8)
                                        <div class="col-md-4 img-container">
                                            <strong>Transcript Image 8</strong>
                                            <div class="document-image"> <a
                                                    href="{{ $user->bachelor->full_transcript_bac_8 }}"
                                                    data-fancybox="image"><img
                                                        src="{{ $user->bachelor->full_transcript_bac_8 }}"></a>
                                            </div>
                                        </div>
                                    @endif
                                    @if ($user->bachelor->equivalence_certificate)
                                        <div class="col-md-4 img-container">
                                            <strong>Equivalence Certificate</strong>
                                            <div class="document-image"> <a
                                                    href="{{ $user->bachelor->full_equivalence_certificate }}"
                                                    data-fancybox="image"><img
                                                        src="{{ $user->bachelor->full_equivalence_certificate }}"></a>
                                            </div>
                                        </div>
                                    @endif
                                    @if ($user->bachelor->provisional_image)
                                        <div class="col-md-4 img-container">
                                            <strong>Provisional Image</strong>
                                            <div class="document-image">
                                                <a href="{{ $user->bachelor->full_provisional_image }}"
                                                    data-fancybox="image"><img
                                                        src="{{ $user->bachelor->full_provisional_image }}"
                                                        id="display_provisional_image"></a>
                                            </div>
                                        </div>
                                    @endif
                                    @if ($user->bachelor->migration_image)
                                        <div class="col-md-4 img-container">
                                            <strong>Migration Image</strong>
                                            <div class="document-image"><a
                                                    href="{{ $user->bachelor->full_migration_image }}"
                                                    data-fancybox="image"><img
                                                        src="{{ $user->bachelor->full_migration_image }}"></a>
                                            </div>
                                        </div>
                                    @endif
                                    @if ($user->bachelor->character_image)
                                        <div class="col-md-4 img-container">
                                            <strong>Character Image</strong>
                                            <div class="document-image"><a
                                                    href="{{ $user->bachelor->full_character_image }}"
                                                    data-fancybox="image"><img
                                                        src="{{ $user->bachelor->full_character_image }}"></a>
                                            </div>
                                        </div>
                                    @endif
                                    @if ($user->bachelor->intership_image)
                                        <div class="col-md-4 img-container">
                                            <strong>Internship Image</strong>
                                            <div class="document-image"> <a
                                                    href="{{ $user->bachelor->full_intership_image }}"
                                                    data-fancybox="image"><img
                                                        src="{{ $user->bachelor->full_intership_image }}"></a>
                                            </div>
                                        </div>
                                    @endif
                                    @if ($user->bachelor->noc_image)
                                        <div class="col-md-4 img-container">
                                            <strong>NOC Image</strong>
                                            <div class="document-image"> <a
                                                    href="{{ $user->bachelor->full_noc_image }}"
                                                    data-fancybox="image"><img
                                                        src="{{ $user->bachelor->full_noc_image }}"></a>
                                            </div>
                                        </div>
                                    @endif
                                    @if ($user->bachelor->visa_image)
                                        <div class="col-md-4 img-container">
                                            <strong>VISA Image</strong>
                                            <div class="document-image"> <a
                                                    href="{{ $user->bachelor->full_visa_image }}"
                                                    data-fancybox="image"><img
                                                        src="{{ $user->bachelor->full_visa_image }}"></a>
                                            </div>
                                        </div>
                                    @endif
                                    @if ($user->bachelor->passport_image)
                                        <div class="col-md-4 img-container">
                                            <strong>Passport Image</strong>
                                            <div class="document-image"> <a
                                                    href="{{ $user->bachelor->full_passport_image }}"
                                                    data-fancybox="image"><img
                                                        src="{{ $user->bachelor->full_passport_image }}"></a>
                                            </div>
                                        </div>
                                    @endif
                                    @if ($user->bachelor->passport_image)
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
                @if ($user->master)
                 <div class="title"><h4>Master Documents</h4></div>
                    <div class="tab-pane fade show active" id="master" role="tabpanel" aria-labelledby="master-tab">
                        <div class="row">
                            <div class="col-md-12 col-sm-12">
                                <div class="row">
                                    @if ($user->master->transcript_mas_marksheet)
                                        <div class="col-md-4 img-container">
                                            <strong>Transcript Image</strong>
                                            <div class="document-image"> <a
                                                    href="{{ $user->master->full_transcript_mas_marksheet }}"
                                                    data-fancybox="image"><img
                                                        src="{{ $user->master->full_transcript_mas_marksheet }}"></a>
                                            </div>
                                        </div>
                                    @endif
                                    @if ($user->master->transcript_bac_1)
                                        <div class="col-md-4 img-container">
                                            <strong>Transcript Image</strong>
                                            <div class="document-image"> <a
                                                    href="{{ $user->master->full_transcript_bac_1 }}"
                                                    data-fancybox="image"><img
                                                        src="{{ $user->master->full_transcript_bac_1 }}"></a>
                                            </div>
                                        </div>
                                    @endif
                                    @if ($user->master->transcript_bac_2)
                                        <div class="col-md-4 img-container">
                                            <strong>Transcript Image</strong>
                                            <div class="document-image"> <a
                                                    href="{{ $user->master->full_transcript_bac_2 }}"
                                                    data-fancybox="image"><img
                                                        src="{{ $user->master->full_transcript_bac_2 }}"></a>
                                            </div>
                                        </div>
                                    @endif
                                    @if ($user->master->transcript_bac_3)
                                        <div class="col-md-4 img-container">
                                            <strong>Transcript Image</strong>
                                            <div class="document-image"> <a
                                                    href="{{ $user->master->full_transcript_bac_3 }}"
                                                    data-fancybox="image"><img
                                                        src="{{ $user->master->full_transcript_bac_3 }}"></a>
                                            </div>
                                        </div>
                                    @endif
                                    @if ($user->master->transcript_bac_4)
                                        <div class="col-md-4 img-container">
                                            <strong>Transcript Image</strong>
                                            <div class="document-image"> <a
                                                    href="{{ $user->master->full_transcript_bac_4 }}"
                                                    data-fancybox="image"><img
                                                        src="{{ $user->master->full_transcript_bac_4 }}"></a>
                                            </div>
                                        </div>
                                    @endif
                                    @if ($user->master->transcript_bac_4)
                                        <div class="col-md-4 img-container">
                                            <strong>Transcript Image</strong>
                                            <div class="document-image"> <a
                                                    href="{{ $user->master->full_transcript_bac_4 }}"
                                                    data-fancybox="image"><img
                                                        src="{{ $user->master->full_transcript_bac_4 }}"></a>
                                            </div>
                                        </div>
                                    @endif
                                    @if ($user->master->transcript_bac_5)
                                        <div class="col-md-4 img-container">
                                            <strong>Transcript Image</strong>
                                            <div class="document-image"> <a
                                                    href="{{ $user->master->full_transcript_bac_5 }}"
                                                    data-fancybox="image"><img
                                                        src="{{ $user->master->full_transcript_bac_5 }}"></a>
                                            </div>
                                        </div>
                                    @endif
                                    @if ($user->master->transcript_bac_6)
                                        <div class="col-md-4 img-container">
                                            <strong>Transcript Image</strong>
                                            <div class="document-image"> <a
                                                    href="{{ $user->master->full_transcript_bac_6 }}"
                                                    data-fancybox="image"><img
                                                        src="{{ $user->master->full_transcript_bac_6 }}"></a>
                                            </div>
                                        </div>
                                    @endif
                                    @if ($user->master->transcript_bac_7)
                                        <div class="col-md-4 img-container">
                                            <strong>Transcript Image</strong>
                                            <div class="document-image"> <a
                                                    href="{{ $user->master->full_transcript_bac_7 }}"
                                                    data-fancybox="image"><img
                                                        src="{{ $user->master->full_transcript_bac_7 }}"></a>
                                            </div>
                                        </div>
                                    @endif
                                    @if ($user->master->equivalence_certificate)
                                        <div class="col-md-4 img-container">
                                            <strong>Equivalence Image</strong>
                                            <div class="document-image"> <a
                                                    href="{{ $user->master->full_equivalence_certificate }}"
                                                    data-fancybox="image"><img
                                                        src="{{ $user->master->full_equivalence_certificate }}"></a>
                                            </div>
                                        </div>
                                    @endif
                                    @if ($user->master->provisional_image)
                                        <div class="col-md-4 img-container">
                                            <strong>Provisional Image</strong>
                                            <div class="document-image"> <a
                                                    href="{{ $user->master->full_provisional_image }}"
                                                    data-fancybox="image"><img
                                                        src="{{ $user->master->full_provisional_image }}"></a>

                                            </div>
                                        </div>
                                    @endif
                                    @if ($user->master->character_image)
                                        <div class="col-md-4 img-container">
                                            <strong>Character Image</strong>
                                            <div class="document-image"> <a
                                                    href="{{ $user->master->full_character_image }}"
                                                    data-fancybox="image"><img
                                                        src="{{ $user->master->full_character_image }}"></a>
                                            </div>
                                        </div>
                                    @endif
                                    @if ($user->master->intership_image)
                                        <div class="col-md-4 img-container">
                                            <strong>Internship Image</strong>
                                            <div class="document-image"> <a
                                                    href="{{ $user->master->full_intership_image }}"
                                                    data-fancybox="image"><img
                                                        src="{{ $user->master->full_intership_image }}"></a>
                                            </div>
                                        </div>
                                    @endif
                                    @if ($user->master->noc_image)
                                        <div class="col-md-4 img-container">
                                            <strong>NHPC permission Letter Image</strong>
                                            <div class="document-image"> <a
                                                    href="{{ $user->master->full_noc_image }}"
                                                    data-fancybox="image"><img
                                                        src="{{ $user->master->full_noc_image }}"></a>
                                            </div>
                                        </div>
                                    @endif
                                    @if ($user->master->passport_image)
                                        <div class="col-md-4 img-container">
                                            <strong>Passport Image</strong>
                                            <div class="document-image"> <a
                                                    href="{{ $user->master->full_passport_image }}"
                                                    data-fancybox="image"><img
                                                        src="{{ $user->master->full_passport_image }}"></a>
                                            </div>
                                        </div>
                                    @endif
                                    @if ($user->master->visa_image)
                                        <div class="col-md-4 img-container">
                                            <strong>VISA Image</strong>
                                            <div class="document-image"> <a
                                                    href="{{ $user->master->full_visa_image }}"
                                                    data-fancybox="image"><img
                                                        src="{{ $user->master->full_visa_image }}"></a>
                                            </div>
                                        </div>
                                    @endif
                                    @if ($user->master->council_registration_certificate)
                                        <div class="col-md-4 img-container">
                                            <strong>Passport Image</strong>
                                            <div class="document-image"> <a
                                                    href="{{ $user->master->full_council_registration_certificate }}"
                                                    data-fancybox="image"><img
                                                        src="{{ $user->master->full_council_registration_certificate }}"></a>
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
