@include('council.includes.metahead')

<body data-layout-color="light" data-layout-mode="default" data-layout-size="fluid" data-topbar-color="light"
    data-leftbar-position="fixed" data-leftbar-color="light" data-leftbar-size='default' data-sidebar-user='true'>
    <div id="wrapper">
        @include('council.includes.top-bar')
        @include('council.includes.nav')
        <div class="content-page">
            @yield('content')
            @include('council.includes.footer')
        </div>
    </div>
    @include('council.includes.scripts')
    @yield('footer-scripts')
</body>

</html>