<nav
    class="header-navbar navbar-expand-md navbar navbar-with-menu navbar-without-dd-arrow fixed-top navbar-semi-light">
    <div class="navbar-wrapper">
        <div class="navbar-container content">
            <div class="collapse navbar-collapse show" id="navbar-mobile">
                <ul class="nav navbar-nav mr-auto float-left">
                    <li class="nav-item mobile-menu d-md-none mr-auto">
                        <a class="nav-link nav-menu-main menu-toggle hidden-xs" href="#">
                            <i class="ft-menu"></i>
                        </a>
                    </li>
                    <li class="nav-item d-none d-md-block">
                        <a class="nav-link nav-menu-main menu-toggle hidden-xs" href="#">
                            <i class="ft-menu"></i>
                        </a>
                    </li>
                    <li class="dropdown d-none d-md-block mr-1">
                        <a class="dropdown-toggle nav-link" id="apps-navbar-links" href="#" data-toggle="dropdown">
                            Apps
                        </a>
                        <div class="dropdown-menu">
                            <div class="arrow_box">
                                <a class="dropdown-item" href="new_buyers.html">
                                    <i class="ft-user"></i> New Buyer
                                </a>
                                <a class="dropdown-item" href="email-application.html">
                                    <i class="ft-user"></i> Email
                                </a>
                                <a class="dropdown-item" href="chat-application.html">
                                    <i class="ft-mail"></i> Chat
                                </a>
                                <a class="dropdown-item" href="project-summary.html">
                                    <i class="ft-briefcase"></i> Project Summary
                                </a>
                                <a class="dropdown-item" href="full-calender.html">
                                    <i class="ft-calendar"></i> Calendar
                                </a>
                            </div>
                        </div>
                    </li>
                    <li class="nav-item dropdown navbar-search">
                        <a class="nav-link dropdown-toggle hide" data-toggle="dropdown" href="#">
                            <i class="ficon ft-search"></i>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="arrow_box">
                                <form action="#" method="POST">
                                    <div class="input-group search-box">
                                        <div class="position-relative has-icon-right full-width">
                                            <input class="form-control" id="search" name="search" type="text"
                                                   placeholder="Search here...">
                                            <div class="form-control-position navbar-search-close">
                                                <i class="ft-x"></i>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
                <ul class="nav navbar-nav float-right">
                    <li class="dropdown dropdown-language nav-item">
                        <a class="dropdown-toggle nav-link" id="dropdown-flag" href="#" data-toggle="dropdown"
                           aria-haspopup="true" aria-expanded="false">
                            <i class="flag-icon flag-icon-us"></i>
                            <span class="selected-language"></span>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="dropdown-flag">
                            <div class="arrow_box">
                                @if(current_language() != 'en')
                                <a class="dropdown-item" href="{{ route('language') }}"><i class="flag-icon flag-icon-us"></i>
                                    English</a>
                                @else
                                <a class="dropdown-item" href="{{ route('language') }}">
                                    <i class="flag-icon flag-icon-bd"></i> Bangla</a>
                                @endif
                            </div>
                        </div>
                    </li>
                    <li class="dropdown dropdown-notification nav-item">
                        <a class="nav-link nav-link-label" href="#" data-toggle="dropdown">
                            <i class="ficon ft-bell bell-shake" id="notification-navbar-link"></i>
                            <span class="badge badge-pill badge-sm badge-danger badge-up badge-glow">5</span></a>
                        <ul class="dropdown-menu dropdown-menu-media dropdown-menu-right">
                            <div class="arrow_box_right">
                                <li class="dropdown-menu-header">
                                    <h6 class="dropdown-header m-0"><span class="grey darken-2">Notifications</span></h6>
                                </li>
                                <li class="scrollable-container media-list w-100">
                                    <a href="javascript:void(0)">
                                        <div class="media">
                                            <div class="media-left align-self-center"><i
                                                    class="ft-share info font-medium-4 mt-2"></i></div>
                                            <div class="media-body">
                                                <h6 class="media-heading info">New Order Received</h6>
                                                <p class="notification-text font-small-3 text-muted text-bold-600">Lorem ipsum
                                                    dolor sit amet!
                                                </p>
                                                <small>
                                                    <time class="media-meta text-muted" datetime="2015-06-11T18:29:20+08:00">3:30
                                                        PM</time></small>
                                            </div>
                                        </div>
                                    </a>
                                    <a href="javascript:void(0)">
                                        <div class="media">
                                            <div class="media-left align-self-center"><i
                                                    class="ft-save font-medium-4 mt-2 warning"></i>
                                            </div>
                                            <div class="media-body">
                                                <h6 class="media-heading warning">New User Registered</h6>
                                                <p class="notification-text font-small-3 text-muted text-bold-600">Aliquam
                                                    tincidunt mauris eu
                                                    risus.
                                                </p>
                                                <small>
                                                    <time class="media-meta text-muted" datetime="2015-06-11T18:29:20+08:00">10:05
                                                        AM</time></small>
                                            </div>
                                        </div>
                                    </a>
                                    <a href="javascript:void(0)">
                                        <div class="media">
                                            <div class="media-left align-self-center"><i
                                                    class="ft-repeat font-medium-4 mt-2 danger"></i>
                                            </div>
                                            <div class="media-body">
                                                <h6 class="media-heading danger">New Purchase</h6>
                                                <p class="notification-text font-small-3 text-muted text-bold-600">Lorem ipsum
                                                    dolor sit
                                                    ametest?
                                                </p>
                                                <small>
                                                    <time class="media-meta text-muted"
                                                          datetime="2015-06-11T18:29:20+08:00">Yesterday</time></small>
                                            </div>
                                        </div>
                                    </a>
                                    <a href="javascript:void(0)">
                                        <div class="media">
                                            <div class="media-left align-self-center"><i
                                                    class="ft-shopping-cart font-medium-4 mt-2 primary"></i></div>
                                            <div class="media-body">
                                                <h6 class="media-heading primary">New Item In Your Cart</h6>
                                                <small>
                                                    <time class="media-meta text-muted" datetime="2015-06-11T18:29:20+08:00">Last
                                                        week</time></small>
                                            </div>
                                        </div>
                                    </a>
                                    <a href="javascript:void(0)">
                                        <div class="media">
                                            <div class="media-left align-self-center"><i
                                                    class="ft-heart font-medium-4 mt-2 info"></i></div>
                                            <div class="media-body">
                                                <h6 class="media-heading info">New Sale</h6>
                                                <small>
                                                    <time class="media-meta text-muted" datetime="2015-06-11T18:29:20+08:00">Last
                                                        month</time></small>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <li class="dropdown-menu-footer"><a class="dropdown-item info text-right pr-1"
                                                                    href="javascript:void(0)">Read all</a></li>
                            </div>
                        </ul>
                    </li>
                    <li class="dropdown dropdown-notification nav-item">
                        <a class="nav-link nav-link-label" href="#" data-toggle="dropdown"><i
                                class="ficon ft-mail"></i></a>
                        <ul class="dropdown-menu dropdown-menu-media dropdown-menu-right">
                            <div class="arrow_box_right">
                                <li class="dropdown-menu-header">
                                    <h6 class="dropdown-header m-0"><span class="grey darken-2">Messages</span></h6>
                                </li>
                                <li class="scrollable-container media-list w-100">
                                    <a href="javascript:void(0)">
                                        <div class="media">
                                            <div class="media-left"><span class="avatar avatar-sm rounded-circle"><img
                                                        src="../assets/images/portrait/small/avatar-s-6.png" alt="avatar"></span>
                                            </div>
                                            <div class="media-body">
                                                <h6 class="media-heading text-bold-700">Sarah Montery<i
                                                        class="ft-circle font-small-2 success float-right"></i></h6>
                                                <p class="notification-text font-small-3 text-muted text-bold-600">Everything
                                                    looks good. I
                                                    will provide...
                                                </p>
                                                <small>
                                                    <time class="media-meta text-muted" datetime="2015-06-11T18:29:20+08:00">3:55
                                                        PM</time></small>
                                            </div>
                                        </div>
                                    </a>
                                    <a href="javascript:void(0)">
                                        <div class="media">
                                            <div class="media-left"><span class="avatar avatar-sm rounded-circle"><span
                                                        class="media-object rounded-circle text-circle bg-warning">E</span></span>
                                            </div>
                                            <div class="media-body">
                                                <h6 class="media-heading text-bold-700">Eliza Elliot<i
                                                        class="ft-circle font-small-2 danger float-right"></i></h6>
                                                <p class="notification-text font-small-3 text-muted text-bold-600">Okay. here is
                                                    some more
                                                    details...
                                                </p>
                                                <small>
                                                    <time class="media-meta text-muted" datetime="2015-06-11T18:29:20+08:00">2:10
                                                        AM</time></small>
                                            </div>
                                        </div>
                                    </a>
                                    <a href="javascript:void(0)">
                                        <div class="media">
                                            <div class="media-left"><span class="avatar avatar-sm rounded-circle"><img
                                                        src="../assets/images/portrait/small/avatar-s-3.png" alt="avatar"></span>
                                            </div>
                                            <div class="media-body">
                                                <h6 class="media-heading text-bold-700">Kelly Reyes<i
                                                        class="ft-circle font-small-2 warning float-right"></i></h6>
                                                <p class="notification-text font-small-3 text-muted text-bold-600">Check once and
                                                    let me know
                                                    if you...
                                                </p>
                                                <small>
                                                    <time class="media-meta text-muted"
                                                          datetime="2015-06-11T18:29:20+08:00">Yesterday</time></small>
                                            </div>
                                        </div>
                                    </a>
                                    <a href="javascript:void(0)">
                                        <div class="media">
                                            <div class="media-left"><span class="avatar avatar-sm rounded-circle"><img
                                                        src="../assets/images/portrait/small/avatar-s-19.png" alt="avatar"></span>
                                            </div>
                                            <div class="media-body">
                                                <h6 class="media-heading text-bold-700">Tonny Deep<i
                                                        class="ft-circle font-small-2 danger float-right"></i></h6>
                                                <p class="notification-text font-small-3 text-muted text-bold-600">We will start
                                                    new project
                                                    development...
                                                </p>
                                                <small>
                                                    <time class="media-meta text-muted"
                                                          datetime="2015-06-11T18:29:20+08:00">Friday</time></small>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <li class="dropdown-menu-footer"><a class="dropdown-item text-right info pr-1"
                                                                    href="javascript:void(0)">Read all</a></li>
                            </div>
                        </ul>
                    </li>
                    <li class="dropdown dropdown-user nav-item">
                        <a class="dropdown-toggle nav-link dropdown-user-link" href="#" data-toggle="dropdown"> <span
                                class="avatar avatar-online"><img src="{{ asset(auth()->user()->image ?? get_static_option('no_image')) }}"
                                                                  alt="avatar"></span></a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <div class="arrow_box_right">
                                <a class="dropdown-item" href="#"><span class="avatar avatar-online"><img
                                            src="{{ asset(auth()->user()->image ?? get_static_option('no_image')) }}" alt="avatar"><span
                                            class="user-name text-bold-700 ml-1">{{ auth()->user()->full_name }}</span></span></a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{ route('controller.profile.index') }}"><i class="ft-user"></i> Edit Profile</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" onclick="logout()"><form action="{{ route('logout') }}" method="post">
                            @csrf
                            <i class="mdi mdi-logout me-1"></i>
                            <button class="border-0 px-0 bg-transparent" type="submit"> {{ __('Logout') }}</button>
                        </form></a>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>
