@include('student.includes.metahead')

<body data-layout-color="light" data-layout-mode="default" data-layout-size="fluid" data-topbar-color="light"
    data-leftbar-position="fixed" data-leftbar-color="light" data-leftbar-size='default' data-sidebar-user='true'>
    <div id="wrapper">
        @include('student.includes.top-bar')
        @include('student.includes.nav')
        <div class="content-page">
            @yield('content')
            @include('student.includes.footer')
        </div>
    </div>
    @include('student.includes.scripts')
    @yield('footer-scripts')
</body>

</html>