<!DOCTYPE html>
<html lang="fa">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title> | مدیریت فروشگاه </title>
    <link rel="icon" type="image/x-icon" href="{{url('panel/src/assets/img/favicon.ico')}}"/>
    <link href="{{url('panel/layouts/modern-light-menu/css/light/loader.css')}}" rel="stylesheet" type="text/css"/>
    <script src="{{url('panel/layouts/modern-light-menu/loader.js')}}"></script>
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="{{url('panel/src/bootstrap/css/bootstrap.rtl.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{url('panel/layouts/modern-light-menu/css/light/plugins.css')}}" rel="stylesheet" type="text/css"/>
    <!-- END GLOBAL MANDATORY STYLES -->

    <!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM STYLES -->
    <link rel="stylesheet" type="text/css" href="{{url('panel/src/assets/css/light/elements/alert.css')}}">
    <link rel="stylesheet" type="text/css" href="{{url('panel/src/plugins/src/table/datatable/datatables.css')}}">
    <link rel="stylesheet" type="text/css"
          href="{{url('panel/src/plugins/css/light/table/datatable/dt-global_style.css')}}">
    <!-- END PAGE LEVEL PLUGINS/CUSTOM STYLES -->
    <!-- BEGIN PAGE LEVEL STYLES -->
    <link rel="stylesheet" href="{{url('panel/src/plugins/src/filepond/filepond.min.css')}}">
    <link rel="stylesheet" href="{{url('panel/src/plugins/src/filepond/FilePondPluginImagePreview.min.css')}}">
    <link rel="stylesheet" href="{{url('panel/src/plugins/css/light/filepond/custom-filepond.css')}}" type="text/css"/>
    <link rel="stylesheet" type="text/css" href="{{url('panel/src/plugins/css/light/editors/quill/quill.snow.css')}}">
    <!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM STYLES -->
    <link rel="stylesheet" type="text/css" href="{{url('panel/src/assets/css/light/forms/switches.css')}}">
    <!--  BEGIN CUSTOM STYLE FILE  -->
    <link rel="stylesheet" href="{{url('panel/src/assets/css/light/apps/ecommerce-create.css')}}">
    <link rel="stylesheet" href="{{url('panel/fonts/fonts.css')}}">
    <link rel="stylesheet" href="{{url('panel/src/plugins/css/light/flatpickr/custom-flatpickr.css')}}">
    <link rel="stylesheet" href="{{url('panel/src/plugins/dropzone/css/dropzone.css')}}">
    <link rel="stylesheet" href="{{url('panel/src/plugins/css/light/sweetalerts2/custom-sweetalert.css')}}">
    <link rel="stylesheet" href="{{url('panel/src/plugins/src/sweetalerts2/sweetalerts2.css')}}">
    <!--  END CUSTOM STYLE FILE  -->

    @livewireStyles
    <style>
        body.dark .layout-px-spacing, .layout-px-spacing {
            min-height: calc(100vh - 155px) !important;
        }
    </style>

</head>
<body class="layout-boxed">
<!-- BEGIN LOADER -->
<div id="load_screen">
    <div class="loader">
        <div class="loader-content">
            <div class="spinner-grow align-self-center"></div>
        </div>
    </div>
</div>
<!--  END LOADER -->
@include('admin.layouts.header')
<!-- begin::main content -->
<div class="main-container " id="container">
    <div class="overlay"></div>
    <div class="search-overlay"></div>
    @include('admin.layouts.navigation')
    <div id="content" class="main-content">
        <div class="layout-px-spacing">

            <div class="middle-content container-xxl py-3">

                @yield('content')
            </div>
        </div>
    </div>
</div>
@livewireScripts
<script src="{{url('panel/src/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{url('panel/src/plugins/src/perfect-scrollbar/perfect-scrollbar.min.js')}}"></script>
<script src="{{url('panel/src/plugins/src/mousetrap/mousetrap.min.js')}}"></script>
<script src="{{url('panel/src/plugins/src/waves/waves.min.js')}}"></script>
<script src="{{url('panel/layouts/modern-light-menu/app.js')}}"></script>
@yield('scripts')
<script src="{{url('panel/src/plugins/src/filepond/filepond.min.js')}}"></script>
<script src="{{url('panel/src/plugins/src/filepond/FilePondPluginFileValidateType.min.js')}}"></script>
<script src="{{url('panel/src/plugins/src/filepond/FilePondPluginImageExifOrientation.min.js')}}"></script>
<script src="{{url('panel/src/plugins/src/filepond/FilePondPluginImagePreview.min.js')}}"></script>
<script src="{{url('panel/src/plugins/src/filepond/FilePondPluginImageCrop.min.js')}}"></script>
<script src="{{url('panel/src/plugins/src/filepond/FilePondPluginImageResize.min.js')}}"></script>
<script src="{{url('panel/src/plugins/src/filepond/FilePondPluginImageTransform.min.js')}}"></script>
<script src="{{url('panel/src/plugins/src/filepond/filepondPluginFileValidateSize.min.js')}}"></script>
<script src="{{url('panel/src/plugins/src/editors/quill/quill.js')}}"></script>
<script src="{{url('panel/src/plugins/src/flatpickr/flatpickr.js')}}"></script>
<script src="{{url('panel/src/plugins/src/flatpickr/custom-flatpickr.js')}}"></script>
<script src="{{url('panel/src/plugins/dropzone/js/dropzone.js')}}"></script>
<script src="{{url('panel/src/plugins/src/sweetalerts2/sweetalerts2.min.js')}}"></script>
<script src="{{url('panel/src/plugins/src/sweetalerts2/custom-sweetalert.js')}}"></script>

</body>
</html>
