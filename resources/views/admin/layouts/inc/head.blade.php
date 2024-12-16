<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}"/>
<base href="{{ url('/') }}/{{\App::getLocale()}}">
<link href="{{ url('/assets/images/favicon.ico') }}" rel="shortcut icon">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/fontawesome.min.css" integrity="sha512-xX2rYBFJSj86W54Fyv1de80DWBq7zYLn2z0I9bIhQG+rxIF6XVJUpdGnsNHWRa6AvP89vtFupEPDP8eZAtu9qA==" crossorigin="anonymous" referrerpolicy="no-referrer" />


@if (\App::getLocale() == "ar")
    <link href="{{ url('/assets/css/bootstrap-rtl.min.css') }}" rel="stylesheet" type="text/css" />
@else
    <link href="{{ url('/assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
@endif


<link href="{{ url('/assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ url('/assets/libs/toastr/build/toastr.min.css') }}" rel="stylesheet" type="text/css">
<link href="{{ url('/assets/libs/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ url('/assets/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.css') }}" rel="stylesheet" type="text/css" />
@if (\App::getLocale() == "ar")
    <link href="{{ url('/assets/css/app-rtl.min.css') }}" rel="stylesheet" type="text/css" />
    @else
    <link href="{{ url('/assets/css/app.min.css') }}" rel="stylesheet" type="text/css" />
@endif
@if (\App::getLocale() == "ar")
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@600&display=swap" rel="stylesheet">
    <style>
        *{
            font-family: 'Cairo', sans-serif !important;
        }
        label{
            font-weight: lighter;
        }
        .form-check .form-check-input {
            float: right;
            margin-right: -1.5em;
        }
        .makeMargeLeft {
            margin-left: 20px;
        }
        input {
            font-weight: bold !important;
        }
        a {
            font-weight: bold !important;
        }
        .main-content {
            /* margin-right: 250px !important; */
        }
        .navbar-header {
            padding: 0 !important;
        }
    </style>
@endif


@stack('styles')
<script>
    var _URL = "{{ url('/') }}";
</script>

