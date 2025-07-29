@include('admitcardreader.includes.metahead')

<body data-layout-color="light" data-layout-mode="default" data-layout-size="fluid" data-topbar-color="light"
    data-leftbar-position="fixed" data-leftbar-color="light" data-leftbar-size='default' data-sidebar-user='true'>
    <div id="wrapper">
        @include('admitcardreader.includes.top-bar')
        @include('admitcardreader.includes.nav')
        <div class="content-page">
            @yield('content')
            @include('admitcardreader.includes.footer')
        </div>
    </div>
    @include('admitcardreader.includes.scripts')
    @yield('footer-scripts')
</body>

</html>
