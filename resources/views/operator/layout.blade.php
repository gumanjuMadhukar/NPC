@include('operator.includes.metahead')

<body data-layout-color="light" data-layout-mode="default" data-layout-size="fluid" data-topbar-color="light"
    data-leftbar-position="fixed" data-leftbar-color="light" data-leftbar-size='default' data-sidebar-user='true'>
    <div id="wrapper">
        @include('operator.includes.top-bar')
        @include('operator.includes.nav')
        <div class="content-page">
            @yield('content')
            @include('operator.includes.footer')
        </div>
    </div>
    @include('operator.includes.scripts')
    @yield('footer-scripts')
</body>

</html>