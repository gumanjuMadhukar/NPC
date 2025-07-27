@include('registrar.includes.metahead')

<body data-layout-color="light" data-layout-mode="default" data-layout-size="fluid" data-topbar-color="light"
    data-leftbar-position="fixed" data-leftbar-color="light" data-leftbar-size='default' data-sidebar-user='true'>
    <div id="wrapper">
        @include('registrar.includes.top-bar')
        @include('registrar.includes.nav')
        <div class="content-page">
            @yield('content')
            @include('registrar.includes.footer')
        </div>
    </div>
    @include('registrar.includes.scripts')
    @yield('footer-scripts')
</body>

</html>