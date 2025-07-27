@include('subjectcommittee.includes.metahead')

<body data-layout-color="light" data-layout-mode="default" data-layout-size="fluid" data-topbar-color="light"
    data-leftbar-position="fixed" data-leftbar-color="light" data-leftbar-size='default' data-sidebar-user='true'>
    <div id="wrapper">
        @include('subjectcommittee.includes.top-bar')
        @include('subjectcommittee.includes.nav')
        <div class="content-page">
            @yield('content')
            @include('subjectcommittee.includes.footer')
        </div>
    </div>
    @include('subjectcommittee.includes.scripts')
    @yield('footer-scripts')
</body>

</html>