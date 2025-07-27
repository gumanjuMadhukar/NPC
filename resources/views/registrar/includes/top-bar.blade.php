@php
use Illuminate\Support\Facades\Auth;
$user = Auth::guard('registrar')->user();
@endphp
<div class="navbar-custom">
    <ul class="list-unstyled topnav-menu float-end mb-0">
        <li>
            <a class="nav-link">
               {{Auth::guard('registrar')->user()->name}}  (<b>Registrar</b>)
            </a>
        </li>
        <li>
            <a class="nav-link" href="{{route('registrar-logout')}}">
                <i class="fe-log-out"></i> Logout
            </a>
        </li>
    </ul>
    <div class="logo-box d-none d-sm-block">
        <a href="./" class="logo logo-dark text-center">
            <span class="logo-lg">
                <img src="{{ asset('assets/images/logo.svg')}}" alt="{{env('APP_NAME')}}">
            </span>
        </a>
    </div>
    <ul class="list-unstyled topnav-menu topnav-menu-left mb-0">
        <li>
            <button class="button-menu-mobile disable-btn waves-effect"> <i class="fe-menu"></i> </button>
        </li>
        
    </ul>
    <div class="clearfix"></div>
</div>