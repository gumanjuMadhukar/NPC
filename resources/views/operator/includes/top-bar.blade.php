@php
use Illuminate\Support\Facades\Auth;
$user = Auth::guard('operator')->user();
@endphp
<div class="navbar-custom">
    <ul class="list-unstyled topnav-menu float-end mb-0">
        <li>
            <a class="nav-link">
               {{Auth::guard('operator')->user()->name}}  (<b>Operator</b>)
            </a>
        </li>
        <li>
            <a class="nav-link" href="{{route('operator-logout')}}">
                <i class="fe-log-out"></i> Logout
            </a>
        </li>
    </ul>
    @include('common.includes.top-bar')
</div>
