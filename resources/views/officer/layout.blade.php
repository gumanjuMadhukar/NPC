@include('officer.includes.metahead')

<body data-layout-color="light" data-layout-mode="default" data-layout-size="fluid" data-topbar-color="light"
    data-leftbar-position="fixed" data-leftbar-color="light" data-leftbar-size='default' data-sidebar-user='true'>
    <div id="wrapper">
        @include('officer.includes.top-bar')
        @include('officer.includes.nav')
        <div class="content-page">
            @yield('content')
            @include('officer.includes.footer')
        </div>
    </div>
    @include('officer.includes.scripts')
    @yield('footer-scripts')
</body>

</html>