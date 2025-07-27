@php 
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
$user = Auth::guard('subject_committee')->user();
$show_move_to = 0;
foreach($user->subject_committee_users as $subject_committee_user){
    if($subject_committee_user->coordinator){
        $show_move_to = 1;
    }
}
@endphp
<div class="left-side-menu">
    <div class="h-100" data-simplebar>

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <ul id="side-menu">
                <li class="@if ($nav == 'dashboard') menuitem-active @endif"> <a
                        href="{{ route('subject_committee-dashboard') }}">
                        <i class="mdi mdi-view-dashboard-outline"></i><span> Dashboard </span> </a> </li>
                <li class="@if ($nav == 'applicant') menuitem-active @endif">
                    <a class="@if ($nav == 'applicant') active @endif" href="#applicants"
                        data-bs-toggle="collapse">
                        <i class="mdi mdi-view-dashboard-outline"></i>
                        <span> Applicants </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="applicants">
                        <ul class="nav-second-level">
                            <li class="@if ($nav == 'appplicantlist/approved_list') menuitem-active @endif"> <a
                                    class="@if ($nav == 'applicant-approved-list') active @endif"
                                    href="{{ route('subject_committee-applicant-approved-list') }}">
                                    <i class="mdi mdi-view-dashboard-outline"></i><span> Approved By Me</span> </a>
                            </li>
                            <li class="@if ($nav == 'appplicantlist/rejected_list') menuitem-active @endif"> <a
                                    class="@if ($nav == 'applicant-rejected-list') active @endif"
                                    href="{{ route('subject_committee-applicant-rejected-list') }}">
                                    <i class="mdi mdi-view-dashboard-outline"></i><span> Rejected By Me</span> </a>
                            </li>
                            <li class="@if ($nav == 'appplicantlist/rejected_list') menuitem-active @endif"> <a
                                    class="@if ($nav == 'applicant-rejected-list') active @endif"
                                    href="{{ route('subject_committee-applicant-committee-rejected-list') }}">
                                    <i class="mdi mdi-view-dashboard-outline"></i><span> Rejected By Subject Committee</span> </a>
                            </li>
                            <li class="@if ($nav === 'appplicantlist') menuitem-active @endif"> <a
                                    class="@if ($nav == 'applicant-list') active @endif"
                                    href="{{ route('subject_committee-applicant-list') }}">
                                    <i class="mdi mdi-view-dashboard-outline"></i><span> New Applicants </span> </a> </li>
                        </ul>
                    </div>
                </li>
                @if($show_move_to)
                <li class="@if ($nav == 'move-council') menuitem-active @endif"> <a
                        class="@if ($nav == 'move-council') active @endif"
                        href="{{ route('subject_committee-move-council') }}">
                        <i class="mdi mdi-view-dashboard-outline"></i><span> Move To Council</span> </a> </li>
                <li class="@if ($nav == 'move-examcommittee') menuitem-active @endif"> <a
                        class="@if ($nav == 'move-examcommittee') active @endif"
                        href="{{ route('subject_committee-move-examcommittee-list') }}">
                        <i class="mdi mdi-view-dashboard-outline"></i><span>Exam Committee</span> </a> </li>
                @endif
                <li class="@if ($nav == 'account') menuitem-active @endif"> <a
                        href="{{ route('subject_committee-account-setting') }}">
                        <i class="mdi mdi-view-dashboard-outline"></i><span> My Profile </span> </a> </li>
            </ul>
        </div>
        <div class="clearfix"></div>
    </div>
</div>
