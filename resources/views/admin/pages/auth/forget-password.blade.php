<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>
            @lang('Forget Password') | {{ env('APP_NAME') }} - @lang('Dashboard')
        </title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="shortcut icon" href="assets/images/favicon.ico">
        <link href="{{ url('/assets/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" />
        <link href="{{ url('/assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ url('/assets/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />
    </head>
    <body>
        <div class="account-pages my-5 pt-sm-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-6 col-xl-5">
                        <div class="card overflow-hidden">
                            <div class="bg-primary bg-soft">
                                <div class="row">
                                    <div class="col-7">
                                        <div class="text-primary p-4">
                                            <h5 class="text-primary">@lang('Forget password') !</h5>
                                            <p>@lang('Set a new password').</p>
                                        </div>
                                    </div>
                                    <div class="col-5 align-self-end">
                                        <img src="{{ url('/assets/images/profile-img.png') }}" alt="" class="img-fluid">
                                    </div>
                                </div>
                            </div>
                            <div class="card-body pt-0">
                                <div class="auth-logo">
                                    <a href="#!" class="auth-logo-light">
                                        <div class="avatar-md profile-user-wid mb-4">
                                            <span class="avatar-title rounded-circle bg-light">
                                                <img src="{{ url('/assets/images/logo-light.svg') }}" alt="" class="rounded-circle" height="34">
                                            </span>
                                        </div>
                                    </a>

                                    <a href="#!" class="auth-logo-dark">
                                        <div class="avatar-md profile-user-wid mb-4">
                                            <span class="avatar-title rounded-circle bg-light">
                                                <img src="{{ url('/assets/images/logo.svg') }}" alt="" class="rounded-circle" height="34">
                                            </span>
                                        </div>
                                    </a>
                                </div>
                                <div class="p-2">
                                    @if (session('status'))
                                        <div class="alert alert-success" role="alert">
                                            {{ session('status') }}
                                        </div>
                                    @else
                                        <form class="form-horizontal" method="POST" action="{{ route('admin.password.email') }}">
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
                                            @error('email')
                                                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                                    <i class="mdi mdi-alert-outline me-2"></i>
                                                        {{ $errors->first('email') }}
                                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                                </div>
                                            @enderror

                                            @if(Session::get('danger'))
                                                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                                    <i class="mdi mdi-alert-outline me-2"></i>
                                                    {{ Session::get('danger') }}
                                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                                </div>
                                            @endif

                                            <div class="mt-3 d-grid">
                                                <button class="btn btn-primary waves-effect waves-light" type="submit">@lang('Send')</button>
                                            </div>
                                        </form>
                                    @endif
                                </div>

                            </div>
                        </div>
                        <div class="mt-5 text-center">

                            <div>
                                <p>{{ date('Y') }} © {{ env('APP_NAME') }}. - @lang('Development by asgatech')</p>
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
