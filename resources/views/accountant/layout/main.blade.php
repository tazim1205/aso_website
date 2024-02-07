<div class="main-menu menu-fixed menu-light menu-accordion    menu-shadow " data-scroll-to-active="true"
     data-img="../assets/images/backgrounds/02.jpg">
    <div class="navbar-header">
        <div class="d-flex justify-content-center">
            <ul class="nav navbar-nav">
                <li class="nav-item">
                    <a class="navbar-brand" href="{{ route('accountant.dashboard') }}">

                        <img class="brand-logo mt-1" alt="logo"
                             src="{{ asset(get_static_option('logo') ?? 'uploads/images/defaults/logo-white.png') }}"
                             style="width:120px" />
                    </a>
                </li>
                <li class="nav-item d-md-none"><a class="nav-link close-navbar"><i class="ft-x"></i></a></li>
            </ul>
        </div>
    </div>
    <div class="navigation-background"></div>

    <div class="main-menu-content">
        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
            <hr style="margin-bottom: 1px;">
            <li class="nav-item open">
                <a href="{{ route('accountant.dashboard') }}">
                    <span class="menu-title" data-i18n="" style="font-size: 17px; font-weight: bold; padding: 0px 35px; color: #2b345f;">
                        Accountant Panel
                    </span>
                </a>
            </li>
            <hr style="margin-top: -8px;">
            <li class="nav-item {{ Request::routeIs('accountant.dashboard') ? 'open' : '' }}">
                <a href="{{ route('accountant.dashboard') }}">
                    <i class="material-icons dark-blue">home</i>
                    <span class="menu-title" data-i18n="">
                     Dashboard
                  </span>
                </a>
            </li>
            <li class="nav-item has-sub
            @if(
                Request::routeIs('accountant.earnings.service-provider') ||
                Request::routeIs('controller.ward.index') ||
                Request::routeIs('accountant.earnings.member.home') ||
                Request::routeIs('accountant.earnings.member.total.paid') ||
                Request::routeIs('accountant.earnings.member.payment.report') ||
                Request::routeIs('accountant.earnings.service.home') ||
                Request::routeIs('accountant.earnings.service.total.paid') ||
                Request::routeIs('accountant.earnings.service.payment.report') ||
                Request::routeIs('accountant.earnings.others.home') ||
                Request::routeIs('accountant.earnings.others.report'))
                {{ 'open' }}
            @endif">
                <a href="#">
                    <i class="ft-life-buoy"></i>
                    <span class="menu-title" data-i18n="">Earnings</span>
                </a>
                <ul class="menu-content" style="">
                    <li class="{{ Request::routeIs('accountant.earnings.service-provider') ? 'open' : '' }}">
                        <a class="menu-item" href="{{ route('accountant.earnings.service-provider') }}">
                            Earning from Service Provider</a>
                    </li>
                    <li class="ha s-sub is-shown @if(
                        Request::routeIs('accountant.earnings.member.home') ||
                        Request::routeIs('accountant.earnings.member.total.paid') ||
                        Request::routeIs('accountant.earnings.member.payment.report'))
                        {{ 'open' }}
                    @endif">
                        <a class="menu-item" href="#">Earning from Membership</a>
                        <ul class="menu-content" style="">
                            <li class=""><a class="menu-item {{ active('accountant.earnings.member.home') }}" href="{{ route('accountant.earnings.member.home') }}">Home</a>
                            </li>
                            <li class=""><a class="menu-item {{ active('accountant.earnings.member.total.paid') }}" href="{{ route('accountant.earnings.member.total.paid') }}">Total paid by membership</a>
                            <li class=""><a class="menu-item {{ active('accountant.earnings.member.payment.report') }}" href="{{ route('accountant.earnings.member.payment.report') }}">Membership payment report</a>
                            </li>
                        </ul>
                    </li>
                    <li class="has-sub is-shown @if(
                        Request::routeIs('accountant.earnings.service.home') ||
                        Request::routeIs('accountant.earnings.service.total.paid') ||
                        Request::routeIs('accountant.earnings.service.payment.report'))
                        {{ 'open' }}
                    @endif">
                        <a class="menu-item" href="#">Earning from Special Service</a>
                        <ul class="menu-content" style="">
                            <li class=""><a class="menu-item {{ active('accountant.earnings.service.home') }}" href="{{ route('accountant.earnings.service.home') }}">Home</a>
                            </li>
                            <li class=""><a class="menu-item {{ active('accountant.earnings.service.total.paid') }}" href="{{ route('accountant.earnings.service.total.paid') }}">Total paid</a>
                            <li class=""><a class="menu-item {{ active('accountant.earnings.service.payment.report') }}" href="{{ route('accountant.earnings.service.payment.report') }}">Payment report</a>
                            </li>
                        </ul>
                    </li>
                    <li class="has-sub is-shown @if(
                        Request::routeIs('accountant.earnings.others.home') ||
                        Request::routeIs('accountant.earnings.others.report'))
                        {{ 'open' }}
                    @endif">
                        <a class="menu-item" href="#">Earning from Others</a>
                        <ul class="menu-content" style="">
                            <li class=""><a class="menu-item {{ active('accountant.earnings.others.home') }}" href="{{ route('accountant.earnings.others.home') }}">Home</a>
                            </li>
                            <li class=""><a class="menu-item {{ active('accountant.earnings.others.report') }}" href="{{ route('accountant.earnings.others.report') }}">Report</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </li>
            <li class="nav-item has-sub
            @if(
                Request::routeIs('accountant.expenses.*'))
                {{ 'open' }}
            @endif">
                <a href="#">
                    <i class="ft-life-buoy"></i>
                    <span class="menu-title" data-i18n="">Expenses</span>
                </a>
                <ul class="menu-content" style="">

                    <li class="has-sub is-shown @if(
                Request::routeIs('accountant.expenses.aff-marketer.*'))
                {{ 'open' }}
            @endif">
                        <a class="menu-item" href="#">Aff. Marketer Exp.</a>
                        <ul class="menu-content" style="">
                            <li class=""><a class="menu-item {{ active('accountant.expenses.aff-marketer.home') }}" href="{{ route('accountant.expenses.aff-marketer.home') }}">Home</a>
                            </li>
                            <li class=""><a class="menu-item {{ active('accountant.expenses.aff-marketer.exp-area') }}" href="{{ route('accountant.expenses.aff-marketer.exp-area') }}">Marketer exp. by area</a></li>
                        </ul>
                    </li>
                    <li class="has-sub is-shown @if(
                Request::routeIs('accountant.expenses.ad.*'))
                {{ 'open' }}
            @endif">
                        <a class="menu-item" href="#">Ad Exp.</a>
                        <ul class="menu-content" style="">
                            <li class=""><a class="menu-item {{ active('accountant.expenses.ad.home') }}" href="{{ route('accountant.expenses.ad.home') }}">Home</a>
                            </li>
                            <li class=""><a class="menu-item {{ active('accountant.expenses.ad.ad-global') }}" href="{{ route('accountant.expenses.ad.ad-global') }}">Company Global ad report</a>
                            </li>
                            <li class=""><a class="menu-item {{ active('accountant.expenses.ad.ad-area') }}" href="{{ route('accountant.expenses.ad.ad-area') }}">Area's ad report</a>
                            </li>
                        </ul>
                    </li>
                    <li class="has-sub is-shown @if(
                        Request::routeIs('accountant.expenses.area-controller.*'))
                        {{ 'open' }}
                    @endif">
                        <a class="menu-item" href="#">Area Controller Exp.</a>
                        <ul class="menu-content" style="">
                            <li class=""><a class="menu-item {{ active('accountant.expenses.area-controller.home') }}" href="{{ route('accountant.expenses.area-controller.home') }}">Home</a>
                            </li>
                            <li class=""><a class="menu-item {{ active('accountant.expenses.area-controller.total-income') }}" href="{{ route('accountant.expenses.area-controller.total-income') }}">Total income by area</a>
                            </li>
                            <li class=""><a class="menu-item {{ active('accountant.expenses.area-controller.profit-and-pay') }}" href="{{ route('accountant.expenses.area-controller.profit-and-pay') }}">Area profit and pay</a>
                            </li>
                            <li class=""><a class="menu-item {{ active('accountant.expenses.area-controller.payment-report') }}" href="{{ route('accountant.expenses.area-controller.payment-report') }}">Payment report</a>
                            </li>
                        </ul>
                    </li>
                    <li class="has-sub is-shown @if(
                        Request::routeIs('accountant.expenses.salary.*'))
                        {{ 'open' }}
                    @endif">
                        <a class="menu-item" href="#">Salary Exp.</a>
                        <ul class="menu-content" style="">
                            <li class=""><a class="menu-item {{ active('accountant.expenses.salary.home') }}" href="{{ route('accountant.expenses.salary.home') }}">Home</a>
                            </li>
                            <li class=""><a class="menu-item {{ active('accountant.expenses.salary.salary-report') }}" href="{{ route('accountant.expenses.salary.salary-report') }}">Report || Add</a>
                            </li>
                        </ul>
                    </li>
                    <li class="has-sub is-shown @if(
                        Request::routeIs('accountant.expenses.others.*'))
                        {{ 'open' }}
                    @endif">
                        <a class="menu-item" href="#">Others Exp.</a>
                        <ul class="menu-content" style="">
                            <li class=""><a class="menu-item {{ active('accountant.expenses.others.home') }}" href="{{ route('accountant.expenses.others.home') }}">Home</a>
                            </li>
                            <li class=""><a class="menu-item {{ active('accountant.expenses.others.report') }}" href="{{ route('accountant.expenses.others.report') }}">Report || Add</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </li>
            <li class="nav-item has-sub @if(
                Request::routeIs('accountant.marketing-fund.*'))
                {{ 'open' }}
            @endif">
                <a href="#">
                    <i class="ft-life-buoy"></i>
                    <span class="menu-title" data-i18n="">Marketing Fund</span>
                </a>
                <ul class="menu-content" style="">

                    <li class="{{ Request::routeIs('accountant.marketing-fund.overview') ? 'open' : '' }}"><a class="menu-item" href="{{ route('accountant.marketing-fund.overview') }}">Overview</a>
                    </li>

                    <li class="has-sub is-shown @if(
                Request::routeIs('accountant.marketing-fund.company.*'))
                {{ 'open' }}
            @endif">
                        <a class="menu-item" href="#">Company M. Fund Reserve</a>
                        <ul class="menu-content" style="">
                            <li class=""><a class="menu-item {{ active('accountant.marketing-fund.company.home') }}" href="{{ route('accountant.marketing-fund.company.home') }}">Home</a>
                            </li>
                            <li class=""><a class="menu-item {{ active('accountant.marketing-fund.company.fund-reserve') }}" href="{{ route('accountant.marketing-fund.company.fund-reserve') }}">Company Fund Reserve</a>
                            </li>
                            <li class=""><a class="menu-item {{ active('accountant.marketing-fund.company.fund-exp') }}" href="{{ route('accountant.marketing-fund.company.fund-exp') }}">Company Fund Exp.</a>
                            </li>
                        </ul>
                    </li>
                    <li class="has-sub is-shown @if(
                Request::routeIs('accountant.marketing-fund.area.*'))
                {{ 'open' }}
            @endif">
                        <a class="menu-item" href="#">Area's M. Fund Reserve</a>
                        <ul class="menu-content" style="">
                            <li class=""><a class="menu-item {{ active('accountant.marketing-fund.area.home') }}" href="{{ route('accountant.marketing-fund.area.home') }}">Home</a>
                            </li>
                            <li class=""><a class="menu-item {{ active('accountant.marketing-fund.area.fund-reserve') }}" href="{{ route('accountant.marketing-fund.area.fund-reserve') }}">Area's Fund Reserve</a>
                            </li>
                            <li class=""><a class="menu-item {{ active('accountant.marketing-fund.area.fund-exp') }}" href="{{ route('accountant.marketing-fund.area.fund-exp') }}">Area's Fund Exp.</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </li>

        </ul>
    </div>
</div>
