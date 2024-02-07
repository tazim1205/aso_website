<div class="main-menu menu-fixed menu-light menu-accordion    menu-shadow " data-scroll-to-active="true"
     data-img="../assets/images/backgrounds/02.jpg">
    <div class="navbar-header">
        <div class="d-flex justify-content-center">
            <ul class="nav navbar-nav flex-row">
                <li class="nav-item mr-auto">
                    <a class="navbar-brand" href="{{ route('controller.dashboard.index') }}">
                        <!-- <h3 class="brand-text">ASO</h3> -->
                        <img class="brand-logo mt-1" alt="logo" src="{{ asset(get_static_option('logo') ?? 'uploads/images/defaults/logo-white.png') }}" style="width:120px" />
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
                    <span class="menu-title" data-i18n="" style="font-size: 15px; font-weight: bold; padding: 0px 20px; color: #2b345f;">
                        Marketing Controller Panel
                    </span>
                </a>
            </li>
            <hr style="margin-top: -8px;">
            <li class="nav-item">
                <a href="{{ route('marketing_panel.dashboard.index') }}">
                    <i class="material-icons dark-blue">home</i>
                    <span class="menu-title" data-i18n="">
                     Dashboard
                  </span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('marketing_panel.marketer-list.index') }}">
                    <i class="material-icons dark-blue">assignment_turned_in</i>
                    <span class="menu-title" data-i18n="">
                     Marketer List
                  </span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('marketing_panel.marketer-statement.index') }}">
                    <i class="material-icons dark-blue">assignment_turned_in</i>
                    <span class="menu-title" data-i18n="">
                     Marketer Statement
                  </span>
                </a>
            </li>
            @php
                $totalPendingWithdraw = \App\WithdrawRequest::where('status', 'pending')->count();
            @endphp
            <li class="nav-item">
                <a href="{{ route('marketing_panel.withdraw-request.index') }}">
                    <i class="material-icons dark-blue">assignment_turned_in</i>
                    <span class="menu-title" data-i18n="">
                     Withdraw Request <span class="badge badge-primary">{{ $totalPendingWithdraw }}</span>
                  </span>
                </a>
            </li>
            <li class=" nav-item">
                <a href="#">
                    <i class="material-icons dark-blue">assignment_turned_in</i>
                    <span class="menu-title" data-i18n="">Withdraw Report</span>
                </a>
                <ul class="menu-content">
                    <li>
                        <a href="{{ route('marketing_panel.withdraw.complete') }}" class="menu-item">Complete</a>
                    </li>
                    <li>
                        <a href="{{ route('marketing_panel.withdraw.cancel') }}" class="menu-item">Cancel</a>
                    </li>
                </ul>
            </li>
            <li class="nav-item">
                <a href="{{ route('marketing_panel.notice.index') }}">
                    <i class="material-icons dark-blue">assignment_turned_in</i>
                    <span class="menu-title" data-i18n="">
                     Notice
                  </span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('marketing_panel.ads.index') }}">
                    <i class="material-icons dark-blue">assignment_turned_in</i>
                    <span class="menu-title" data-i18n="">
                     Ads.
                  </span>
                </a>
            </li>
            <li class=" nav-item">
                <a href="#">
                    <i class="material-icons dark-blue">assignment_turned_in</i>
                    <span class="menu-title" data-i18n="">Basic Information</span>
                </a>
                <ul class="menu-content">
                    <li>
                        <a href="{{ route('marketing_panel.trainingvideos') }}" class="menu-item">Training Videos</a>
                    </li>
                    <li>
                        <a href="{{ route('marketing_panel.helpline') }}" class="menu-item">Helpline</a>
                    </li>
                </ul>
            </li>
            <li class=" nav-item">
                <a href="#">
                    <i class="material-icons dark-blue">assignment_turned_in</i>
                    <span class="menu-title" data-i18n="">Blog</span>
                </a>
                <ul class="menu-content">
                    <li>
                        <a href="{{ route('marketing_panel.blog.index') }}" class="menu-item">Blog List</a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</div>
