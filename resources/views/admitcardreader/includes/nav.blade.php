@php use App\Models\Order; @endphp
<div class="left-side-menu">
    <div class="h-100" data-simplebar>

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <ul id="side-menu">
                <li class="@if ($nav == 'dashboard') menuitem-active @endif">
                    <a class="@if ($nav == 'dashboard') active @endif" href="{{ route('admin-dashboard') }}">
                        <i class="mdi mdi-view-dashboard-outline"></i><span> Dashboard </span>
                    </a>
                </li>
                <li class="@if ($nav == 'account') menuitem-active @endif">
                    <a class="@if ($nav == 'account') active @endif"
                        href="{{ route('admin-account-setting') }}">
                        <i class="mdi mdi-view-dashboard-outline"></i><span> My Profile </span>
                    </a>
                </li>
            </ul>
        </div>
        <div class="clearfix"></div>
    </div>
</div>
