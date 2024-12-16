<!-- ========== Left Sidebar Start ========== -->
<div class="vertical-menu">

    <div data-simplebar class="h-100">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title" key="t-menu">@lang('Menu')</li>
                <li>
                    <a href="{{ route('admin.home.index') }}" class="waves-effect">
                        <i class="bx bx-home-circle"></i>
                        <span key="t-dashboards">
                            @lang('Dashboard')
                        </span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.admins.index') }}" class="waves-effect">
                        <i class="bx bxs-user-check"></i>
                        <span key="t-contacts">@lang('Admins')</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.customers.index') }}" class="waves-effect">
                        <i class="bx bxs-user-pin"></i>
                        <span key="t-contacts">@lang('Customers')</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.providers.index') }}" class="waves-effect">
                        <i class="bx bxs-shopping-bag-alt"></i>
                        <span key="t-contacts">@lang('Providers')</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route("admin.know_us.index") }}" class="waves-effect">
                        <i class="bx bxs-wine"></i>
                        <span key="t-contacts">@lang('How Know Us')</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route("admin.areas.index") }}" class="waves-effect">
                        <i class="bx bxs-area"></i>
                        <span key="t-contacts">@lang('Areas')</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route("admin.cars.index") }}" class="waves-effect">
                        <i class="bx bxs-car"></i>
                        <span key="t-contacts">@lang('Cars')</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route("admin.car_factories.index") }}" class="waves-effect">
                        <i class="bx bxs-graduation"></i>
                        <span key="t-contacts">@lang('Car Country Factories')</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route("admin.car_modals.index") }}" class="waves-effect">
                        <i class="bx bxs-graduation"></i>
                        <span key="t-contacts">@lang('Car Modals')</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route("admin.contents.index") }}" class="waves-effect">
                        <i class="bx bxs-package"></i>
                        <span key="t-contacts">@lang('Contents')</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route("admin.categories.index") }}" class="waves-effect">
                        <i class="bx bxs-zap"></i>
                        <span key="t-contacts">@lang('Categories')</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route("admin.intros.index") }}" class="waves-effect">
                        <i class="bx bxs-wrench"></i>
                        <span key="t-contacts">@lang('Intros')</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route("admin.sliders.index") }}" class="waves-effect">
                        <i class="bx bxs-carousel"></i>
                        <span key="t-contacts">@lang('Sliders')</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route("admin.refusals.index") }}" class="waves-effect">
                        <i class="bx bxs-sad"></i>
                        <span key="t-contacts">@lang('Refusals')</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route("admin.colors.index") }}" class="waves-effect">
                        <i class="bx bxs-color-fill"></i>
                        <span key="t-contacts">@lang('CarColors')</span>
                    </a>
                </li>
                {{-- <li>
                    <a href="{{ route("admin.banks.index") }}" class="waves-effect">
                        <i class="bx bxs-user-pin"></i>
                        <span key="t-contacts">@lang('Banks')</span>
                    </a>
                </li> --}}
                <li>
                    <a href="{{ route('admin.orders.index') }}" class="waves-effect">
                        <i class="bx bxs-badge-check"></i>
                        <span key="t-contacts">@lang('Orders')</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.dues.index') }}" class="waves-effect">
                        <i class="bx bxs-message-dots"></i>
                        <span key="t-contacts">@lang('Dues')</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.contact-us.index') }}" class="waves-effect">
                        <i class="bx bxs-contact"></i>
                        <span key="t-contacts">@lang('Contact Us')</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.notifications.index') }}" class="waves-effect">
                        <i class="bx bxs-navigation"></i>
                        <span key="t-contacts">@lang('Notifications')</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
<!-- Left Sidebar End -->
