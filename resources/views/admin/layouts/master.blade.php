<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" @if(\App::getLocale() == "ar")  style="direction:rtl" @endif>
<title>@yield('title')</title>
<head>
    @includeIf('admin.layouts.inc.head')
</head>
<body data-sidebar="dark">
     <!-- Loader -->
     <div id="preloader">
        <div id="status">
            <div class="spinner-chase">
                <div class="chase-dot"></div>
                <div class="chase-dot"></div>
                <div class="chase-dot"></div>
                <div class="chase-dot"></div>
                <div class="chase-dot"></div>
                <div class="chase-dot"></div>
            </div>
        </div>
    </div>
    <div id="layout-wrapper">
        @includeIf('admin.layouts.inc.header')
        @includeIf('admin.layouts.inc.menu')
        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">
                    @yield('PageContent')
                    @includeIf('admin.layouts.inc.footer')
                </div>
            </div>
        </div>
    </div>
    @includeIf('admin.layouts.inc.footer')
    @includeIf('admin.layouts.inc.right-bar')
    @includeIf('admin.layouts.inc.scripts')
</body>
</html>
