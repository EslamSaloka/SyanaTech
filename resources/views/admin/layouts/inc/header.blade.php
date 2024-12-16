<header id="page-topbar">
    <div class="navbar-header">
        <div class="d-flex">
            <!-- LOGO -->
            <div class="navbar-brand-box">
                <p style="margin-top: 22px; font-weight: bold;color: white !important">
                    {{ env('APP_NAME') }}
                </p>
            </div>

            <button type="button" class="btn btn-sm px-3 font-size-16 header-item waves-effect" id="vertical-menu-btn">
                <i class="bx bx-menu"></i>
            </button>

            <?php $convertLang = (\App::getLocale() == "en") ? "ar" : "en"; ?>
            <a href="{{ LaravelLocalization::getLocalizedURL($convertLang, null, [], true) }}" data-language="{{ $convertLang }}" hreflang="{{ $convertLang }}"  class="btn btn-sm px-3 font-size-16 header-item waves-effect" style=" padding-top: 23px; ">
                {{ (\App::getLocale() =="en") ? __('Ar') : __('En') }}
            </a>

        </div>

        <div class="d-flex">

            <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img class="rounded-circle header-profile-user" src="{{ display_image_by_model(\Auth::user(),'avatar',"first_name") }}"
                        alt="Header Avatar">
                    <span class="d-none d-xl-inline-block ms-1" key="t-{{ \Auth::user()->first_name }}">{{ \Auth::user()->first_name }}</span>
                    <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-end">
                    <!-- item-->
                    <a class="dropdown-item" href="{{ route('admin.profile.index') }}"><i class="bx bx-user font-size-16 align-middle me-1"></i> <span key="t-profile">@lang('Profile')</span></a>
                    <a class="dropdown-item" href="{{ route('admin.settings.index') }}"><i class="bx bx-wrench font-size-16 align-middle me-1"></i> <span key="t-profile">@lang('Settings')</span></a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item text-danger" href="{{ route('admin.logout') }}"><i class="bx bx-power-off font-size-16 align-middle me-1 text-danger"></i> <span key="t-logout">@lang('Logout')</span></a>
                </div>
            </div>

        </div>
    </div>
</header>
