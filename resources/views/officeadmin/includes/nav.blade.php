@php use App\Models\Order; @endphp
<div class="left-side-menu">
    <div class="h-100" data-simplebar>

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <ul id="side-menu">
                <li class="@if ($nav == 'dashboard') menuitem-active @endif">
                    <a class="@if ($nav == 'dashboard') active @endif" href="{{ route('office_admin-dashboard') }}">
                        <i class="mdi mdi-view-dashboard-outline"></i><span> Dashboard </span>
                    </a>
                </li>
                <li class="@if ($nav == 'account') menuitem-active @endif">
                    <a class="@if ($nav == 'account') active @endif"
                        href="{{ route('office_admin-account-setting') }}">
                        <i class="mdi mdi-view-dashboard-outline"></i><span> My Profile </span>
                    </a>
                </li>
                <li class="@if ($nav == 'exam') menuitem-active @endif">
                    <a class="@if ($nav == 'exam') active @endif" href="{{ route('office_admin-exam') }}">
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
                                <a class="@if ($nav == 'fee') active @endif" href="{{ route('office_admin-fee') }}">
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
                                                href="{{ route('office_admin-program') }}">
                                                <i class="mdi mdi-view-dashboard-outline"></i><span> Program</span>
                                            </a>
                                        </li>
                                        <li class="@if ($nav == 'level') menuitem-active @endif">
                                            <a class="@if ($nav == 'level') active @endif"
                                                href="{{ route('office_admin-level') }}">
                                                <i class="mdi mdi-view-dashboard-outline"></i><span> Level </span>
                                            </a>
                                        </li>
                                        <li class="@if ($nav == 'college') menuitem-active @endif"><a
                                                class="@if ($nav == 'college') active @endif"
                                                href="{{ route('office_admin-college') }}">
                                                <i class="mdi mdi-view-dashboard-outline"></i><span> College </span>
                                            </a>
                                        </li>
                                        <li class="@if ($nav == 'university') menuitem-active @endif">
                                            <a class="@if ($nav == 'university') active @endif"
                                                href="{{ route('office_admin-university') }}">
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
                                                href="{{ route('office_admin-province') }}">
                                                <i class="mdi mdi-view-dashboard-outline"></i><span> Province </span>
                                            </a>
                                        </li>
                                        <li class="@if ($nav == 'district') menuitem-active @endif">
                                            <a class="@if ($nav == 'district') active @endif"
                                                href="{{ route('office_admin-district') }}">
                                                <i class="mdi mdi-view-dashboard-outline"></i><span> District </span>
                                            </a>
                                        </li>
                                        <li class="@if ($nav == 'municipality') menuitem-active @endif">
                                            <a class="@if ($nav == 'municipality') active @endif" href="{{ route('office_admin-municipality') }}">
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
