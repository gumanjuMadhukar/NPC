@php
    use Illuminate\Support\Facades\Auth;

    $user = Auth::guard('student')->user();
@endphp
<div class="navbar-custom">
    <ul class="list-unstyled topnav-menu float-end mb-0">
        <li>
            <a class="nav-link">
                {{Auth::guard('student')->user()->name}} (<b>Student</b>)
            </a>
        </li>
        <li>
            <a class="nav-link" href="{{route('student-logout')}}">
                <i class="fe-log-out"></i> Logout
            </a>
        </li>
    </ul>
    @include('common.includes.top-bar')
    <div class="clearfix"></div>
</div>
