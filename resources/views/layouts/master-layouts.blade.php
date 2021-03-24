

@include('Common_Section.header')

<body class="text-left">
<div class="app-admin-wrap layout-sidebar-vertical sidebar-full">
    @include('layouts.nav-bar-aside')
    <div class="main-content-wrap mobile-menu-content bg-off-white m-0">
        @include('layouts.nav-bar-header')
        <!-- ============ Body content start ============= -->
        @yield('content')
        <!-- fotter end -->
    </div>
</div>
<!-- ============ javascript start ============= -->
@include('Common_Section.footer')
