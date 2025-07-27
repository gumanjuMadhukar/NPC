@php use App\Models\Order; @endphp
<div class="left-side-menu">
    <div class="h-100" data-simplebar>

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <ul id="side-menu">
                <li class="@if($nav == 'dashboard') menuitem-active @endif">
                    <a href="{{route('council-dashboard')}}">
                        <i class="mdi mdi-view-dashboard-outline"></i><span> Dashboard </span>
                    </a>
                </li>
                <li class="@if($nav == 'applicant/pass') menuitem-active @endif">
                    <a href="{{route('council-applicant-passed-list')}}">
                        <i class="mdi mdi-view-dashboard-outline"></i><span> Passed Students </span>
                    </a>
                </li>
                <li class="@if($nav == 'applicant/tslc') menuitem-active @endif">
                    <a href="{{route('council-tslc-applicant-list')}}">
                        <i class="mdi mdi-view-dashboard-outline"></i><span> TSLC Students </span>
                    </a>
                </li>
                <li class="@if($nav == 'account') menuitem-active @endif">
                    <a href="{{route('council-account-setting')}}">
                        <i class="mdi mdi-view-dashboard-outline"></i><span> My Profile </span>
                    </a>
                </li>
                <li class="@if($nav == 'darta') menuitem-active @endif">
                    <a href="{{route('council-darta-book')}}">
                        <i class="mdi mdi-view-dashboard-outline"></i><span> DartaBook </span>
                    </a>
                </li>
            </ul>
        </div>
        <div class="clearfix"></div>
    </div>
</div>