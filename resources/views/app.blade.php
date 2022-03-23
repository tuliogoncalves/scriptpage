<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Scriptpage</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <!-- Toastr Alert CSS -->
    <link rel="stylesheet" href="{{ asset('plugins/toastr/toastr.min.css') }}" />
    <!-- Sweetalert2 CSS -->
    <link rel="stylesheet" href="{{ asset('plugins/sweetalert2/sweetalert2.min.css') }}" />
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('css/adminlte.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/scriptpage.css') }}">

    <link rel="stylesheet" href="https://unpkg.com/vue-tel-input/dist/vue-tel-input.css" />
    @routes
    <!-- App Starter -->
    <script src="{{ asset('/js/app.js') }}" defer></script>
</head>

<body class="hold-transition">

    @inertia

    <!-- REQUIRED SCRIPTS -->
    
    <!-- jQuery -->
    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- InputMask -->
    <script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('plugins/inputmask/jquery.inputmask.min.js') }}"></script>
    <!-- Select2 -->
    <script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
    <!-- Toastr Alert -->
    <script src="{{ asset('plugins/toastr/toastr.min.js') }}"></script>
    <!-- Sweetalert2 -->
    <script src="{{ asset('plugins/sweetalert2/sweetalert2.all.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('js/adminlte.min.js') }}"></script>
    <!-- Scriptpage App -->
    <script src="{{ asset('js/scriptpage.js') }}"></script>
</body>

</html>