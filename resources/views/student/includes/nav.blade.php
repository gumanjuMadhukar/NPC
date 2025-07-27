@php
    use App\Models\ExamApply;
    use App\Models\Certificate;
    use Illuminate\Support\Facades\Auth;
    use App\Models\User;

    $user = User::where('id', Auth::guard('student')->id())->first();
    $exam = ExamApply::where('user_id', $user->id)
        ->whereHas('exam', function ($qry) {
            $qry->where('status', 1);
        })
        ->orderBy('id', 'DESC')
        ->first();
    $passed_exam = ExamApply::where('user_id', $user->id)->where('is_passed', 1)->first();
    $certificate = Certificate::where('user_id', $user->id)->where('is_printed', 1)->first();
@endphp

<div class="left-side-menu">
    <div class="h-100" data-simplebar>
        <div id="sidebar-menu">
            <ul id="side-menu">
                {{-- Always visible for all users --}}
                <li class="@if ($nav == 'dashboard') menuitem-active @endif">
                    <a class="@if ($nav == 'dashboard') active @endif" href="{{ route('student-dashboard') }}">
                        <i class="mdi mdi-view-dashboard-outline"></i><span> Dashboard</span>
                    </a>
                </li>

                <li class="@if ($nav == 'account') menuitem-active @endif">
                    <a class="@if ($nav == 'account') active @endif" href="{{ route('student-account-setting') }}">
                        <i class="mdi mdi-view-dashboard-outline"></i><span> My Account </span>
                    </a>
                </li>

                @if ((!$exam || ($exam && $exam->status == 'rejected')) && !$passed_exam)
                    <li class="@if ($nav == 'profile') menuitem-active @endif">
                        <a class="@if ($nav == 'profile') active @endif" href="{{ route('student-profile-personal') }}">
                            <i class="mdi mdi-view-dashboard-outline"></i><span> My Profile </span>
                        </a>
                    </li>
                @endif
                <li class="@if ($nav == 'exam') menuitem-active @endif">
                    <a class="@if ($nav == 'exam') active @endif" href="{{ route('student-exam-dashboard') }}">
                        <i class="mdi mdi-view-dashboard-outline"></i><span> Apply Exam </span>
                    </a>
                </li>


                @if ($user->is_foreign != 1)
                    {{-- Show full menu for non-foreign users --}}

                    @if ($certificate && $certificate->user_id && $certificate->is_printed == 1)
                        <li class="@if ($nav == 'idcard') menuitem-active @endif">
                            <a class="@if ($nav == 'idcard') active @endif" href="{{ route('student-idcard') }}">
                                <i class="mdi mdi-view-dashboard-outline"></i><span> ID Card </span>
                            </a>
                        </li>
                    @endif

                    @if ($exam && $exam->admit_card)
                        <li class="@if ($nav == 'admitcard') menuitem-active @endif">
                            <a class="@if ($nav == 'admitcard') active @endif" href="{{ route('student-admitcard') }}">
                                <i class="mdi mdi-view-dashboard-outline"></i><span> Admit Card </span>
                            </a>
                        </li>
                    @endif

                    @if ($passed_exam)
                        <li class="@if ($nav == 'certificate') menuitem-active @endif">
                            <a class="@if ($nav == 'certificate') active @endif" href="{{ route('student-certificate') }}">
                                <i class="mdi mdi-view-dashboard-outline"></i><span> Certificate </span>
                            </a>
                        </li>
                    @endif

                    <li class="@if ($nav == 'kyc') menuitem-active @endif">
                        <a class="@if ($nav == 'kyc') active @endif" href="{{ route('student-kyc') }}">
                            <i class="mdi mdi-view-dashboard-outline"></i><span> KYC </span>
                        </a>
                    </li>
                @else
                @endif
            </ul>
        </div>
        <div class="clearfix"></div>
    </div>
</div>
