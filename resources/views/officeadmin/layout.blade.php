@include('officeadmin.includes.metahead')

<body data-layout-color="light" data-layout-mode="default" data-layout-size="fluid" data-topbar-color="light"
    data-leftbar-position="fixed" data-leftbar-color="light" data-leftbar-size='default' data-sidebar-user='true'>
    <div id="wrapper">
        @include('officeadmin.includes.top-bar')
        @include('officeadmin.includes.nav')
        <div class="content-page">
            @yield('content')
            @include('officeadmin.includes.footer')
        </div>
    </div>
    @include('officeadmin.includes.scripts')
    @yield('footer-scripts')
</body>

</html>
