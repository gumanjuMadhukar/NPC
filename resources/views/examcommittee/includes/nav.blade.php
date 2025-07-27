@php use App\Models\Order; @endphp
<div class="left-side-menu">
    <div class="h-100" data-simplebar>

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <ul id="side-menu">
                <li class="@if ($nav == 'dashboard') menuitem-active @endif"> 
                    <a href="{{ route('exam_committee-dashboard') }}">
                        <i class="mdi mdi-view-dashboard-outline"></i><span> Dashboard </span> 
                    </a> 
                </li>
                <li class="@if ($nav == 'applicant') menuitem-active @endif">
                    <a class="@if ($nav == 'applicant') active @endif" href="#applicants" data-bs-toggle="collapse">
                        <i class="mdi mdi-view-dashboard-outline"></i>
                        <span> Applicants </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="applicants">
                        <ul class="nav-second-level">
                            <li class="@if ($nav == 'appplicantlist/approved_list') menuitem-active @endif"> 
                                <a class="@if ($nav == 'applicant-approved-list') active @endif" href="{{ route('exam_committee-applicant-approved-list') }}">
                                    <i class="mdi mdi-view-dashboard-outline"></i><span> Approved By Me</span> 
                                </a>
                            </li>
                            <li class="@if ($nav == 'appplicantlist/rejected_list') menuitem-active @endif"> 
                                <a class="@if ($nav == 'applicant-rejected-list') active @endif" href="{{ route('exam_committee-applicant-rejected-list') }}">
                                    <i class="mdi mdi-view-dashboard-outline"></i><span> Rejected By Me</span> 
                                </a>
                            </li>
                            <li class="@if ($nav == 'appplicantlist/pending_list') menuitem-active @endif"> 
                                <a class="@if ($nav == 'applicant-pending-list') active @endif" href="{{ route('exam_committee-applicant-pending-list') }}">
                                    <i class="mdi mdi-view-dashboard-outline"></i><span> Pending List</span> 
                                </a> 
                            </li>
                            <li class="@if ($nav === 'appplicantlist') menuitem-active @endif"> 
                                <a class="@if ($nav == 'applicant-list') active @endif" href="{{ route('exam_committee-applicant-list') }}">
                                    <i class="mdi mdi-view-dashboard-outline"></i><span> New Applicants </span> 
                                </a> 
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="@if ($nav == 'all') menuitem-active @endif"> 
                    <a class="@if ($nav == 'all') active @endif" href="{{ route('exam_committee-all-applicant-list') }}">
                        <i class="mdi mdi-view-dashboard-outline"></i><span> Search Applicants </span> 
                    </a> 
                </li>
                <li class="@if ($nav == 'account') menuitem-active @endif">
                    <a href="{{ route('exam_committee-account-setting') }}">
                        <i class="mdi mdi-view-dashboard-outline"></i><span> My Profile </span>
                    </a>
                </li>

            </ul>
        </div>
        <div class="clearfix"></div>
    </div>
</div>