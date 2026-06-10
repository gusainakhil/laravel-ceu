<!doctype html>
<html class="no-js" lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>@yield('title', 'CEUTrainers Admin')</title>
    <link rel="icon" href="{{ asset('ceuadmin/favicon.png') }}" type="image/x-icon">
    
    <!-- Datatable and plugin CSS -->
    <link rel="stylesheet" href="{{ asset('ceuadmin-assets/assets/plugin/datatables/responsive.dataTables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('ceuadmin-assets/assets/plugin/datatables/dataTables.bootstrap5.min.css') }}">
    
    <!-- Project styling -->
    <link rel="stylesheet" href="{{ asset('ceuadmin-assets/assets/css/ceu.style.min.css') }}">
    @yield('styles')
</head>
<body>
    <div id="ebazar-layout" class="theme-blue">
        @include('admin.layouts.sidebar')
        
        <!-- Main body area -->
        <div class="main px-lg-4 px-md-4">
            @include('admin.layouts.header')
            
            <!-- Body: Content -->
            <div class="body d-flex py-3">
                <div class="container-xxl">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>
    
    <!-- Jquery & Template Scripts -->
    <script src="{{ asset('ceuadmin-assets/assets/bundles/libscripts.bundle.js') }}"></script>
    <script src="{{ asset('ceuadmin-assets/assets/bundles/dataTables.bundle.js') }}"></script>
    <script src="{{ asset('ceuadmin-assets/assets/js/template.js') }}"></script>
    @yield('scripts')
</body>
</html>
