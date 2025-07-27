@php use App\Models\Order; @endphp
<div class="left-side-menu">
    <div class="h-100" data-simplebar>

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <ul id="side-menu">
                <li class="@if ($nav == 'dashboard') menuitem-active @endif">
                    <a href="{{ route('operator-dashboard') }}">
                        <i class="mdi mdi-view-dashboard-outline"></i><span> Dashboard </span>
                    </a>
                </li>
                <li class="@if ($nav == 'applicant') menuitem-active @endif">
                    <a class="@if ($nav == 'applicant') active @endif" href="#applicants"
                        data-bs-toggle="collapse">
                        <i class="mdi mdi-view-dashboard-outline"></i>
                        <span> Applicants </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="applicants">
                        <ul class="nav-second-level">
                            <li class="@if ($nav == 'appplicantlist/approved_list') menuitem-active @endif">
                                <a class="@if ($nav == 'applicant-approved-list') active @endif"
                                    href="{{ route('operator-applicant-approved-list') }}">
                                    <i class="mdi mdi-view-dashboard-outline"></i><span> Approved By Me</span>
                                </a>
                            </li>
                            <li class="@if ($nav == 'appplicantlist/rejected_list') menuitem-active @endif">
                                <a class="@if ($nav == 'applicant-rejected-list') active @endif"
                                    href="{{ route('operator-applicant-rejected-list') }}">
                                    <i class="mdi mdi-view-dashboard-outline"></i><span> Rejected By Me</span>
                                </a>
                            </li>
                            <li class="@if ($nav == 'appplicantlist/pending_list') menuitem-active @endif">
                                <a class="@if ($nav == 'applicant-pending-list') active @endif"
                                    href="{{ route('operator-applicant-pending-list') }}">
                                    <i class="mdi mdi-view-dashboard-outline"></i><span> Pending List</span>
                                </a>
                            </li>
                            <li class="@if ($nav === 'appplicantlist') menuitem-active @endif">
                                <a class="@if ($nav == 'applicant-list') active @endif"
                                    href="{{ route('operator-applicant-list') }}">
                                    <i class="mdi mdi-view-dashboard-outline"></i><span> New Applicants</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="@if ($nav == 'all') menuitem-active @endif">
                    <a class="@if ($nav == 'all') active @endif"
                        href="{{ route('operator-all-applicant-list') }}">
                        <i class="mdi mdi-view-dashboard-outline"></i><span> Search Applicants </span>
                    </a>
                </li>
                <li class="@if ($nav == 'certificate') menuitem-active @endif">
                    <a class="@if ($nav == 'certificate') active @endif" href="#certificates"
                        data-bs-toggle="collapse">
                        <i class="mdi mdi-view-dashboard-outline"></i>
                        <span> Certificates </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="certificates">
                        <ul class="nav-second-level">
                            <li class="@if ($nav == '/') menuitem-active @endif">
                                <a href="{{ route('operator-certificate-list',['print_status' => 'not_printed']) }}">
                                    <i class="mdi mdi-view-dashboard-outline"></i><span> Certificates </span>
                                </a>
                            </li>
                            <li class="@if ($nav == 'certificate_issuance') menuitem-active @endif">
                                <a href="{{ route('operator-certificate-issuance-request-list') }}">
                                    <i class="mdi mdi-view-dashboard-outline"></i><span> New Request List </span>
                                </a>
                            </li>
                            <li class="@if ($nav == 'search_certificate') menuitem-active @endif">
                                <a href="{{ route('operator-certificate-list',['print_status' => 'printed']) }}">
                                    <i class="mdi mdi-view-dashboard-outline"></i><span> Printed Certificates </span>
                                </a>
                            </li>
                            <li class="@if ($nav == 'foreign_certificate') menuitem-active @endif">
                                <a href="{{ route('operator-certificate-foreign-list') }}">
                                    <i class="mdi mdi-view-dashboard-outline"></i><span> Foreign Certificate </span>
                                </a>
                            </li>

                            <li class="@if ($nav == 'duplicate_certificate') menuitem-active @endif">
                                <a href="{{ route('operator-certificate-duplicate-list') }}">
                                    <i class="mdi mdi-view-dashboard-outline"></i><span> Duplicate Old Certificate </span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="@if ($nav == 'kyc') menuitem-active @endif">
                    <a class="@if ($nav == 'kyc') active @endif" href="#kycs"
                        data-bs-toggle="collapse">
                        <i class="mdi mdi-view-dashboard-outline"></i>
                        <span> KYC </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="kycs">
                        <ul class="nav-second-level">
                            <li class="@if ($nav == 'kyc') menuitem-active @endif">
                                <a href="{{ route('operator-kyc') }}">
                                    <i class="mdi mdi-view-dashboard-outline"></i><span> KYC List </span>
                                </a>
                            </li>
                            <li class="@if ($nav == 'kyc/search') menuitem-active @endif">
                                <a href="{{ route('operator-kyc-certificate') }}">
                                    <i class="mdi mdi-view-dashboard-outline"></i><span> Search Certificates </span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="@if ($nav == 'subject_committee') menuitem-active @endif">
                    <a href="{{ route('operator-subject_committee-list') }}">
                        <i class="mdi mdi-view-dashboard-outline"></i><span> SubjectCommittee </span>
                    </a>
                </li>
                <li class="@if ($nav == 'account') menuitem-active @endif">
                    <a href="{{ route('operator-account-setting') }}">
                        <i class="mdi mdi-view-dashboard-outline"></i><span> My Profile </span>
                    </a>
                </li>
                <li class="@if ($nav == 'exam') menuitem-active @endif">
                    <a class="@if ($nav == 'exam') active @endif" href="{{ route('operator-exam') }}">
                        <i class="mdi mdi-view-dashboard-outline"></i><span> Exam</span>
                    </a>
                </li>
                <li class="@if ($nav == 'setting') menuitem-active @endif">
                    <a class="@if ($nav == 'setting') active @endif" href="#settings"
                        data-bs-toggle="collapse">
                        <i class="mdi mdi-view-dashboard-outline"></i>
                        <span> Settings </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="settings">
                        <ul class="nav-second-level">
                            <li class="@if ($nav == 'fee') menuitem-active @endif">
                                <a class="@if ($nav == 'fee') active @endif" href="{{ route('operator-fee') }}">
                                    <i class="mdi mdi-view-dashboard-outline"></i><span> Fee</span>
                                </a>
                            </li>
                            <li>
                                <a href="#education" data-bs-toggle="collapse">
                                    <i class="mdi mdi-view-dashboard-outline"></i>
                                    Education <span class="menu-arrow"></span>
                                </a>
                                <div class="collapse" id="education">
                                    <ul class="nav-second-level">
                                        <li class="@if ($nav == 'program') menuitem-active @endif">
                                            <a class="@if ($nav == 'program') active @endif"
                                                href="{{ route('operator-program') }}">
                                                <i class="mdi mdi-view-dashboard-outline"></i><span> Program</span>
                                            </a>
                                        </li>
                                        <li class="@if ($nav == 'level') menuitem-active @endif">
                                            <a class="@if ($nav == 'level') active @endif"
                                                href="{{ route('operator-level') }}">
                                                <i class="mdi mdi-view-dashboard-outline"></i><span> Level </span>
                                            </a>
                                        </li>
                                        <li class="@if ($nav == 'college') menuitem-active @endif"><a
                                                class="@if ($nav == 'college') active @endif"
                                                href="{{ route('operator-college') }}">
                                                <i class="mdi mdi-view-dashboard-outline"></i><span> College </span>
                                            </a>
                                        </li>
                                        <li class="@if ($nav == 'university') menuitem-active @endif">
                                            <a class="@if ($nav == 'university') active @endif"
                                                href="{{ route('operator-university') }}">
                                                <i class="mdi mdi-view-dashboard-outline"></i><span> University </span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li>
                                <a href="#address" data-bs-toggle="collapse">
                                    <i class="mdi mdi-view-dashboard-outline"></i>
                                    Address <span class="menu-arrow"></span>
                                </a>
                                <div class="collapse" id="address">
                                    <ul class="nav-second-level">
                                        <li class="@if ($nav == 'province') menuitem-active @endif">
                                            <a class="@if ($nav == 'province') active @endif"
                                                href="{{ route('operator-province') }}">
                                                <i class="mdi mdi-view-dashboard-outline"></i><span> Province </span>
                                            </a>
                                        </li>
                                        <li class="@if ($nav == 'district') menuitem-active @endif">
                                            <a class="@if ($nav == 'district') active @endif"
                                                href="{{ route('operator-district') }}">
                                                <i class="mdi mdi-view-dashboard-outline"></i><span> District </span>
                                            </a>
                                        </li>
                                        <li class="@if ($nav == 'municipality') menuitem-active @endif">
                                            <a class="@if ($nav == 'municipality') active @endif" href="{{ route('operator-municipality') }}">
                                                <i class="mdi mdi-view-dashboard-outline"></i><span> Municipality
                                                </span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </div>
                </li>
            </ul>
        </div>
        <div class="clearfix"></div>
    </div>
</div>
