<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>
        @lang('Reset Password') | {{ env('APP_NAME') }} - @lang('Dashboard')
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
                                    <h5 class="text-primary">@lang('Reset password') !</h5>
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
                    <form class="form-horizontal" method="POST" action="{{ route('admin.password.update') }}">
                        @csrf

                        <input type="hidden" name="token" value="{{ $token }}">

                        <div class="mb-3">
                            <label for="email" class="form-label">{{ __('E-Mail Address') }}</label>

                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>

                        <div class=" mb-3">
                            <label for="password" class="form-label">{{ __('Password') }}</label>

                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password-confirm" class="form-label">{{ __('Confirm Password') }}</label>

                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>

                        <div class="mt-3 d-grid">

                                <button type="submit" class="btn btn-primary">
                                    {{ __('Reset Password') }}
                                </button>
                        </div>
                    </form>
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
