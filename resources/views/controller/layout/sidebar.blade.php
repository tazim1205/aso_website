<div class="main-menu menu-fixed menu-light menu-accordion menu-shadow" data-scroll-to-active="true"
    data-img="../assets/images/backgrounds/02.jpg">
    <div class="navbar-header">
        <div class="d-flex justify-content-center">
            <ul class="nav navbar-nav">
                <li class="nav-item">
                        <a class="navbar-brand" href="{{ route('controller.dashboard.index') }}">

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
                <a href="{{ route('controller.dashboard.index') }}">
                    <span class="menu-title" data-i18n="" style="font-size: 17px; font-weight: bold; padding: 0px 35px; color: #2b345f;">
                        Area Controller Panel
                    </span>
                </a>
            </li>
            <hr style="margin-top: -8px;">
            <li class="nav-item {{ Request::routeIs('controller.dashboard.index') ? 'open' : '' }}">
                <a href="{{ route('controller.dashboard.index') }}">
                    <i class="material-icons dark-blue">home</i>
                    <span class="menu-title" data-i18n="">
                        Dashboard
                    </span>
                </a>
            </li>
            <li class="nav-item @if(Request::routeIs('controller.pouroshobha.index') || Request::routeIs('controller.ward.index')) {{ 'open' }} @endif">
                <a href="#">
                    <i class="material-icons dark-blue">location_searching</i>
                    <span class="menu-title" data-i18n="">Area</span>
                </a>
                <ul class="menu-content">
                    <li class="">
                        <a href="{{route('controller.pouroshobha.index')}}" class="menu-item {{ Request::routeIs('controller.pouroshobha.index') ? 'active' : '' }}">Pouroshobha/Union/Area</a>
                    </li>
                    <li class="">
                        <a href="{{route('controller.ward.index')}}" class="menu-item {{ Request::routeIs('controller.ward.index') ? 'active' : '' }}">Ward/Road</a>
                    </li>
                </ul>
            </li>
            <li class="nav-item has-sub
                @if(
                    Request::routeIs('controller.worker.gigs') ||
                    Request::routeIs('controller.worker.pages') ||
                    Request::routeIs('controller.worker.services'))

                 {{ 'open' }}
                @endif
            ">
                <a href="#">
                    <i class="material-icons dark-blue">open_in_new</i>
                    <span class="menu-title" data-i18n="">Gigs/Page/Service</span>
                </a>
                <ul class="menu-content" style="">

                    <li class="has-sub is-shown {{ Request::routeIs('controller.worker.gigs') ? 'open' : '' }}">
                        <a class="menu-item" href="#">Worker Gig &nbsp;<span class="badge badge-primary">{{ menu_badge(\App\WorkerGig::class, 'pending') }}</span></a>
                        <ul class="menu-content" style="">
                            <li class=""><a class="menu-item {{ active('controller.worker.gigs', ['pending']) }}" href="{{route('controller.worker.gigs', "pending")}}">Pending&nbsp;<span class="badge badge-primary">{{ menu_badge(\App\WorkerGig::class, 'pending') }}</span></a>
                            </li>
                            <li class=""><a class="menu-item {{ active('controller.worker.gigs', ['active']) }}" href="{{route('controller.worker.gigs', "active")}}">Active&nbsp;<span class="badge badge-primary">{{ menu_badge(\App\WorkerGig::class, 'active') }}</span></a>
                            <li class=""><a class="menu-item {{ active('controller.worker.gigs', ['disabled']) }}" href="{{route('controller.worker.gigs', "disabled")}}">Disabled &nbsp;<span class="badge badge-primary">{{ menu_badge(\App\WorkerGig::class, 'disabled') }}</span></a>
                            </li>
                        </ul>
                    </li>
                    <li class="has-sub is-shown {{ Request::routeIs('controller.worker.pages') ? 'open' : '' }}">
                        <a class="menu-item" href="#">Worker Page&nbsp;<span class="badge badge-primary">{{ menu_badge(\App\WorkerPage::class, 'pending') }}</span></a>
                        <ul class="menu-content" style="">
                            <li class=""><a class="menu-item {{ active('controller.worker.pages', ['pending']) }}" href="{{route('controller.worker.pages', "pending")}}">Pending&nbsp;<span class="badge badge-primary">{{ menu_badge(\App\WorkerPage::class, 'pending') }}</span></a>
                            </li>
                            <li class=""><a class="menu-item {{ active('controller.worker.pages', ['active']) }}" href="{{route('controller.worker.pages', "active")}}">Active&nbsp;<span class="badge badge-primary">{{ menu_badge(\App\WorkerPage::class, 'active') }}</span></a>
                            <li class=""><a class="menu-item {{ active('controller.worker.pages', ['disabled']) }}" href="{{route('controller.worker.pages', "disabled")}}">Disabled &nbsp;<span class="badge badge-primary">{{ menu_badge(\App\WorkerPage::class, 'disabled') }}</span></a>
                            </li>
                        </ul>
                    </li>
                    <li class="has-sub is-shown {{ Request::routeIs('controller.worker.services') ? 'open' : '' }}">
                        <a class="menu-item" href="#">Worker Service &nbsp;<span class="badge badge-primary">{{ menu_badge(\App\PageService::class, 'pending') }}</span></a>
                        <ul class="menu-content" style="">
                            <li class=""><a class="menu-item {{ active('controller.worker.services', ['pending']) }}" href="{{route('controller.worker.services', "pending")}}">Pending&nbsp;<span class="badge badge-primary">{{ menu_badge(\App\PageService::class, 'pending') }}</span></a>
                            </li>
                            <li class=""><a class="menu-item {{ active('controller.worker.services', ['active']) }}" href="{{route('controller.worker.services', "active")}}">Active&nbsp;<span class="badge badge-primary">{{ menu_badge(\App\PageService::class, 'active') }}</span></a>
                            <li class=""><a class="menu-item {{ active('controller.worker.services', ['disabled']) }}" href="{{route('controller.worker.services', "disabled")}}">Disabled&nbsp;<span class="badge badge-primary">{{ menu_badge(\App\PageService::class, 'disabled') }}</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </li>
            <li class="nav-item {{ Request::routeIs('controller.special-profile.index') ? 'open' : '' }}">
                <a href="{{ route('controller.special-profile.index') }}">
                    <i class="material-icons dark-blue">star_border</i>
                    <span class="menu-title" data-i18n="">
                        Special Service
                    </span>
                </a>
            </li>
            <li class="nav-item {{ Request::routeIs('controller.specialServiceOrder') ? 'open' : '' }}">
                <a href="#">
                    <i class="material-icons dark-blue">border_all</i>
                    <span class="menu-title" data-i18n="">
                        Special Service Order <span class="badge badge-primary">{{ menu_badge(\App\SpecialServiceOrder::class, 'pending') }}</span>
                    </span>
                </a>
                <ul class="menu-content">
                    <li>
                        <a href="{{ route('controller.specialServiceOrder', "pending") }}" class="menu-item {{ active('controller.specialServiceOrder', ['pending']) }}">
                            Pending Order&nbsp;<span class="badge badge-primary">{{ menu_badge(\App\SpecialServiceOrder::class, 'pending') }}</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('controller.specialServiceOrder', "running") }}" class="menu-item {{ active('controller.specialServiceOrder', ['running']) }}">
                            Running Order&nbsp;<span class="badge badge-primary">{{ menu_badge(\App\SpecialServiceOrder::class, 'running') }}</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('controller.specialServiceOrder',"complete") }}" class="menu-item {{ active('controller.specialServiceOrder', ['complete']) }}">
                            Competed Order&nbsp;<span class="badge badge-primary">{{ menu_badge(\App\SpecialServiceOrder::class, 'complete') }}</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('controller.specialServiceOrder',"cancel") }}" class="menu-item {{ active('controller.specialServiceOrder', ['cancel']) }}">
                            Canceled Order&nbsp;<span class="badge badge-primary">{{ menu_badge(\App\SpecialServiceOrder::class, 'cancel') }}</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item has-sub @if(
                    Request::routeIs('controller.bid.order') ||
                    Request::routeIs('controller.gig.order') ||
                    Request::routeIs('controller.service.order'))

                 {{ 'open' }}
                @endif">
                <a href="#">
                    <i class="ft-life-buoy"></i>
                    <span class="menu-title" data-i18n="">Order Management</span>
                </a>
                <ul class="menu-content" style="">

                    <li class="has-sub is-shown {{ Request::routeIs('controller.bid.order') ? 'open' : '' }}">
                        <a class="menu-item" href="#">Bid Order <span class="badge badge-primary">{{ menu_badge(\App\CustomerBid::class, 'pending') }}</span></a>
                        <ul class="menu-content" style="">
                            <li class=""><a class="menu-item {{ active('controller.bid.order', ['pending']) }}"
                                    href="{{ route('controller.bid.order', 'pending') }}">
                                    Pending Order&nbsp;<span class="badge badge-primary">{{ menu_badge(\App\CustomerBid::class, 'pending') }}</span>
                                </a>
                            </li>
                            <li class=""><a class="menu-item {{ active('controller.bid.order', ['running']) }}"
                                    href="{{ route('controller.bid.order', 'running') }}">
                                    Running Order&nbsp;<span class="badge badge-primary">{{ menu_badge(\App\CustomerBid::class, 'running') }}</span>
                                </a>
                            <li class=""><a class="menu-item {{ active('controller.bid.order', ['complete']) }}"
                                    href="{{ route('controller.bid.order', 'complete') }}">
                                    Completed Order&nbsp;<span class="badge badge-primary">{{ menu_badge(\App\CustomerBid::class, 'complete') }}</span>
                                </a>
                            <li class=""><a class="menu-item {{ active('controller.bid.order', ['canceled']) }}"
                                    href="{{ route('controller.bid.order', 'canceled') }}">
                                    Canceled Order&nbsp;<span class="badge badge-primary">{{ menu_badge(\App\CustomerBid::class, 'canceled') }}</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="has-sub is-shown {{ Request::routeIs('controller.gig.order') ? 'open' : '' }}">
                        <a class="menu-item" href="#">Gig Order <span class="badge badge-primary">{{ menu_badge(\App\WorkerBid::class, 'pending') }}</span></a>
                        <ul class="menu-content" style="">
                            <li class=""><a class="menu-item {{ active('controller.gig.order', ['pending']) }}"
                                    href="{{ route('controller.gig.order', 'pending') }}">
                                    Pending Order&nbsp;<span class="badge badge-primary">{{ menu_badge(\App\WorkerBid::class, 'pending') }}</span>
                                </a>
                            </li>
                            <li class=""><a class="menu-item {{ active('controller.gig.order', ['running']) }}"
                                    href="{{ route('controller.gig.order', 'running') }}">
                                    Running Order&nbsp;<span class="badge badge-primary">{{ menu_badge(\App\WorkerBid::class, 'running') }}</span>
                                </a>
                            <li class=""><a class="menu-item {{ active('controller.gig.order', ['complete']) }}"
                                    href="{{ route('controller.gig.order', 'complete') }}">
                                    Completed Order&nbsp;<span class="badge badge-primary">{{ menu_badge(\App\WorkerBid::class, 'complete') }}</span>
                                </a>
                            <li class=""><a class="menu-item {{ active('controller.gig.order', ['canceled']) }}"
                                    href="{{ route('controller.gig.order', 'canceled') }}">
                                    Canceled Order&nbsp;<span class="badge badge-primary">{{ menu_badge(\App\WorkerBid::class, 'canceled') }}</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="has-sub is-shown {{ Request::routeIs('controller.service.order') ? 'open' : '' }}">
                        <a class="menu-item" href="#">Service Order <span class="badge badge-primary">{{ menu_badge(\App\ServiceBid::class, 'pending') }}</span></a>
                        <ul class="menu-content" style="">
                            <li class=""><a class="menu-item {{ active('controller.service.order', ['pending']) }}"
                                    href="{{ route('controller.service.order', 'pending') }}">
                                    Pending Order &nbsp;<span class="badge badge-primary">{{ menu_badge(\App\ServiceBid::class, 'pending') }}</span>
                                </a>
                            </li>
                            <li class=""><a class="menu-item {{ active('controller.service.order', ['running']) }}"
                                    href="{{ route('controller.service.order', 'running') }}">
                                    Running Order&nbsp;<span class="badge badge-primary">{{ menu_badge(\App\ServiceBid::class, 'running') }}</span>
                                </a>
                            <li class=""><a class="menu-item {{ active('controller.service.order', ['complete']) }}"
                                    href="{{ route('controller.service.order', 'complete') }}">
                                    Completed Order &nbsp;<span class="badge badge-primary">{{ menu_badge(\App\ServiceBid::class, 'complete') }}</span>
                                </a>
                            <li class=""><a class="menu-item {{ active('controller.service.order', ['canceled']) }}"
                                    href="{{ route('controller.service.order', 'canceled') }}">
                                    Canceled Order&nbsp;<span class="badge badge-primary">{{ menu_badge(\App\ServiceBid::class, 'canceled') }}</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </li>
            <li class=" nav-item {{ Request::routeIs('controller.complain.customer-complain') ? 'open' : '' }}">
                <a href="#">
                    <i class="material-icons dark-blue">credit_card</i>
                    <span class="menu-title" data-i18n="">Report Management&nbsp;<span class="badge badge-primary">{{ menu_badge(\App\Complain::class, '0', 'is_completed') }}</span></span>
                </a>
                <ul class="menu-content">
                    <li><a class="menu-item {{ active('controller.complain.customer-complain', ['submitted']) }}"
                            href="{{ route('controller.complain.customer-complain', 'submitted') }}">Submited&nbsp;<span class="badge badge-primary">{{ menu_badge(\App\Complain::class, '0', 'is_completed') }}</span></a></li>
                    <li><a class="menu-item {{ active('controller.complain.customer-complain', ['resolved']) }}"
                            href="{{ route('controller.complain.customer-complain', 'resolved') }}">Resolved&nbsp;<span class="badge badge-primary">{{ menu_badge(\App\Complain::class, '1', 'is_completed') }}</span></a></li>
                </ul>
            </li>

            <li class="nav-item {{ Request::routeIs('controller.customer') ? 'open' : '' }}">
                <a href="{{  route('controller.customer') }}">
                    <i class="material-icons dark-blue">people_outline</i>
                    <span class="menu-title" data-i18n="">
                        Customer
                    </span>
                </a>
            </li>
            <li class="nav-item {{ Request::routeIs('controller.worker') ? 'open' : '' }}">
                <a href="{{ route('controller.worker') }}">
                    <i class="material-icons dark-blue">people_outline</i>
                    <span class="menu-title" data-i18n="">
                        Service Provider
                    </span>
                </a>
            </li>
            <li class="nav-item {{ Request::routeIs('controller.sp.category') ? 'open' : '' }}">
                <a href="{{route('controller.sp.category')}}">
                    <i class="material-icons dark-blue">people_outline</i>
                    <span class="menu-title" data-i18n="">
                        SP by Categories & Area
                    </span>
                </a>
            </li>
            <li class="nav-item {{ Request::routeIs('controller.membership.category') ? 'open' : '' }}">
                <a href="{{route('controller.membership.category')}}">
                    <i class="material-icons dark-blue">portrait</i>
                    <span class="menu-title" data-i18n="" style="font-size:11px">
                        Membership by Categories & Area
                    </span>
                </a>
            </li>
            <li class="nav-item {{ Request::routeIs('controller.affiliate.marketer') ? 'open' : '' }}">
                <a href="{{ route('controller.affiliate.marketer') }}">
                    <i class="material-icons dark-blue">directions_boat</i>
                    <span class="menu-title" data-i18n="">
                        Affiliate Marketer List
                    </span>
                </a>
            </li>
            <li class="nav-item {{ Request::routeIs('controller.marketing.cost') ? 'open' : '' }}">
                <a href="{{ route('controller.marketing.cost') }}">
                    <i class="material-icons dark-blue">apps</i>
                    <span class="menu-title" data-i18n="">
                        Area Aff. Marketing Cost
                    </span>
                </a>
            </li>

            <li class=" nav-item @if(
                    Request::routeIs('controller.marketing.home') ||
                    Request::routeIs('controller.marketing.reserved') ||
                    Request::routeIs('controller.marketing.export'))

                 {{ 'open' }}
                @endif">
                <a href="#">
                    <i class="material-icons dark-blue">business</i>
                    <span class="menu-title" data-i18n="">Marketing Fund</span>
                </a>
                <ul class="menu-content">

                    <li><a class="menu-item {{ active('controller.marketing.home', []) }}" href="{{ route('controller.marketing.home') }}">Home</a>
                    </li>
                    <li><a class="menu-item {{ active('controller.marketing.reserved', []) }}" href="{{ route('controller.marketing.reserved') }}">Reserve Fund</a>
                    </li>
                    <li><a class="menu-item {{ active('controller.marketing.export', []) }}" href="{{ route('controller.marketing.export') }}">Fund Exp. Report</a>
                    </li>

                </ul>
            </li>



            <li class="nav-item {{ Request::routeIs('controller.ads.index') ? 'open' : '' }}">
                <a href="{{ route('controller.ads.index') }}">
                    <i class="material-icons dark-blue">spellcheck</i>
                    <span class="menu-title" data-i18n="">
                        Ads.
                    </span>
                </a>
            </li>
            <li class="nav-item {{ Request::routeIs('controller.helpline') ? 'open' : '' }}">
                <a href="">
                    <i class="material-icons dark-blue">phone</i>
                    <span class="menu-title" data-i18n="">
                        Helpline
                    </span>
                </a>
                <ul class="menu-content">
                    <li>
                        <a href="{{ route('controller.helpline', 'customer') }}" class="menu-item {{ active('controller.helpline', ['customer']) }}">
                            Customer Helpline
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('controller.helpline', 'worker') }}" class="menu-item {{ active('controller.helpline', ['worker']) }}">
                            SP Helpline
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item {{ Request::routeIs('controller.notice.index') ? 'open' : '' }}">
                <a href="{{ route('controller.notice.index') }}">
                    <i class="material-icons dark-blue">assignment_turned_in</i>
                    <span class="menu-title" data-i18n="">
                        Notice
                    </span>
                </a>
            </li>
        </ul>
    </div>
</div>
