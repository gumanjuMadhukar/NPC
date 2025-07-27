<!DOCTYPE html>
<html lang="en">
<head>
    {{-- Blade include for meta tags, title, and primary CSS --}}
    @include('site.includes.metahead')
    <title>Login - Nepal Health Professional Council</title>
    {{-- Any additional login-specific CSS goes here --}}
    <link rel="stylesheet" href="{{ asset('assets/css/login.css') }}">
</head>
<body class="authentication-bg-pattern auth-layout">

    <div class="account-pages d-flex justify-content-center align-items-center min-vh-100">
        <div class="">
            <div class="row justify-content-center">
                <div class="col-xl-10 col-lg-11 col-md-11">
                    <div class="card shadow-lg border-0 rounded-lg overflow-hidden formbg">
                        <div class="row g-0">
                            {{-- Left Column: Branding and Information --}}
                            <div class="col-md-6 d-none d-md-flex align-items-center justify-content-center p-4"
                                 style="background-color: #005f75; border-right: solid 1px #e9ecef;">
                                <div class="text-center w-100">
                                    <div class="company-logo mb-4">
                                        <img src="{{ asset('assets/images/logo.jpg') }}" alt="NHPC Logo" height="120" class="img-fluid">
                                    </div>
                                    <div class="nepali_flag mb-4">
                                        <img src="{{ asset('assets/images/flag.gif') }}" alt="Nepali Flag" height="60" class="img-fluid">
                                    </div>
                                    <h3 class="text-white mb-3">Welcome to <span style="background: #fff; color:#005f75;border-radius:4px;padding:5px;"> Nepal Pharmacy Council </span></h3>
                                    <h5 class="text-muted mb-4">
                                        Please log in to access your professional dashboard and services.
                                    </h5>
                                    {{-- Blade include for additional info --}}
                                    @include('site.includes.info')
                                </div>
                            </div>

                            {{-- Right Column: Login Form --}}
                            <div class="col-md-6 d-flex align-items-center justify-content-center p-4">
                                <div class="w-100 p-3">
                                    {{-- This is where your actual login form content will be injected --}}
                                    @yield('content')
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Blade include for general scripts --}}
    @include('site.includes.scripts')
    {{-- Any additional login-specific scripts go here --}}
    @yield('footer-scripts')

    <footer class="footer text-center py-3 d-none">
        <div class="">
            <div class="row">
                <div class="col-md-6 text-md-start text-center">
                    {{ date('Y')}} &copy; <a href="{{ env('APP_URL') }}" target="_blank">Nepal Health Professional Council</a>
                </div>
                <div class="col-md-6 text-md-end text-center mt-2 mt-md-0">
                    Design &amp; Develop by: <span class="fw-bold">Aeirc Tech</span>
                </div>
            </div>
        </div>
    </footer>

</body>
</html>
