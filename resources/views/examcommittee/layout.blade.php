@include('examcommittee.includes.metahead')

<body data-layout-color="light" data-layout-mode="default" data-layout-size="fluid" data-topbar-color="light"
    data-leftbar-position="fixed" data-leftbar-color="light" data-leftbar-size='default' data-sidebar-user='true'>
    <div id="wrapper">
        @include('examcommittee.includes.top-bar')
        @include('examcommittee.includes.nav')
        <div class="content-page">
            @yield('content')
            @include('examcommittee.includes.footer')
        </div>
    </div>
    @include('examcommittee.includes.scripts')
    @yield('footer-scripts')
</body>

</html>