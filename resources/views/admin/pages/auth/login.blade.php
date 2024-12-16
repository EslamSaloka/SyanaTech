<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" @if (\App::getLocale() == "ar")
    style="direction:rtl"
@endif>
    <head>
        <meta charset="utf-8" />
        <title>
            @lang('Login') | {{ getSettings("website_name",env('APP_NAME')) }} - @lang('Dashboard')
        </title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="shortcut icon" href="assets/images/favicon.ico">
        @if (\App::getLocale() == "ar")
            <link href="{{ url('/assets/css/bootstrap-rtl.min.css') }}" rel="stylesheet" type="text/css" />
        @else
            <link href="{{ url('/assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
        @endif
        <link href="{{ url('/assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
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
            </style>
        @endif
    </head>
    <body>
        <div class="account-pages my-5 pt-sm-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-6 col-xl-5">
                        <div class="card overflow-hidden">
                            <div class="mx-auto" style="margin-top: 20px;">
                                <div class="row mx-auto">
                                    <img src="{{ url('/dashboard.png') }}" alt="dashboard" class="img-fluid" style="width:150px">
                                </div>
                            </div>
                            <div class="card-body pt-0">
                                <div class="p-2">
                                    <form class="form-horizontal" method="POST" action="{{ route('admin.login') }}">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="email" class="form-label">
                                                @lang('Email')
                                            </label>
                                            <input
                                                type="email"
                                                class="form-control"
                                                name="email"
                                                id="email"
                                                value="{{ old('email') }}"
                                                placeholder="@lang('Enter email')">
                                        </div>
                                        @error('object')
                                        <span class="text-danger">
                                            {{ $message }}
                                        </span>
                                        @enderror
                                        @error('email')
                                            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                                <i class="mdi mdi-alert-outline me-2"></i>
                                                    {{ $errors->first('email') }}
                                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                            </div>
                                        @enderror

                                        <div class="mb-3">
                                            <label class="form-label">@lang('Password')</label>
                                            <div class="input-group auth-pass-inputgroup">
                                                <input type="password" class="form-control" placeholder="@lang('Enter password')" name="password" aria-label="Password" aria-describedby="password-addon">
                                                <button class="btn btn-light " type="button" id="password-addon"><i class="mdi mdi-eye-outline"></i></button>
                                            </div>
                                        </div>
                                        @error('password')
                                            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                                <i class="mdi mdi-alert-outline me-2"></i>
                                                    {{ $errors->first('password') }}
                                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                            </div>
                                        @enderror

                                        @if (Session::get('danger'))
                                            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                                <i class="mdi mdi-alert-outline me-2"></i>
                                                {{ Session::get('danger') }}
                                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                            </div>
                                        @endif

                                        <div class="form-check">
                                            <input class="form-check-input" name="remember_me" type="checkbox" id="remember-check">
                                            <label class="form-check-label" for="remember-check">
                                                @lang('Remember me')
                                            </label>
                                        </div>

                                        @if(env('APP_ENV') == 'production')

                                            {!! Captcha::display([]) !!}

                                            @error('g-recaptcha-response')
                                                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                                    <i class="mdi mdi-alert-outline me-2"></i>
                                                        {{ $errors->first('g-recaptcha-response') }}
                                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                                </div>
                                            @enderror

                                        @endif




                                        <div class="mt-3 d-grid">
                                            <button class="btn btn-primary waves-effect waves-light" type="submit">@lang('Log In')</button>
                                        </div>
                                    </form>
                                </div>

                            </div>
                        </div>
                        <div class="mt-5 text-center">

                            <div>
                                <p>{{ date('Y') }} © {{ getSettings("website_name",env('APP_NAME')) }}.
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <script src="{{ url('/assets/libs/jquery/jquery.min.js') }}"></script>
        <script src="{{ url('/assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ url('/assets/libs/metismenu/metisMenu.min.js') }}"></script>
        <script src="{{ url('/assets/libs/simplebar/simplebar.min.js') }}"></script>
        <script src="{{ url('/assets/libs/node-waves/waves.min.js') }}"></script>
        <script src="{{ url('/assets/js/app.js') }}"></script>
    </body>
</html>
