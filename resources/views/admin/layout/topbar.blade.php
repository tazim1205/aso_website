<header class="topbar-nav">
    <nav class="navbar navbar-expand fixed-top gradient-ibiza">
        <ul class="navbar-nav mr-auto align-items-center">
            <li class="nav-item">
                <a class="nav-link toggle-menu" href="javascript:void();">
                    <i class="icon-menu menu-icon"></i>
                </a>
            </li>
            <li class="nav-item">

            </li>
        </ul>

        <ul class="navbar-nav align-items-center right-nav-link">
            <li class="nav-item language">
                <a class="nav-link dropdown-toggle dropdown-toggle-nocaret waves-effect" href="{{ route('language') }}">
                    @if(current_language() != 'en')
                    <i class="flag-icon flag-icon-bd"></i>
                    @else
                        <i class="flag-icon flag-icon-us"></i>
                    @endif
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link dropdown-toggle dropdown-toggle-nocaret" data-toggle="dropdown" href="#">
                    <span class="user-profile"><img src="{{ asset(auth()->user()->image ?? 'uploads/images/defaults/user.png') }}" class="img-circle" alt="user avatar"></span>
                </a>
                <ul class="dropdown-menu dropdown-menu-right animated fadeIn">
                    <li class="dropdown-item user-details">
                        <a href="javaScript:void();">
                            <div class="media">
                                <div class="avatar"><img class="align-self-start mr-3" src="{{ asset(auth()->user()->image ?? 'uploads/images/defaults/user.png') }}" alt="user avatar"></div>
                                <div class="media-body">
                                    <h6 class="mt-2 user-title">{{ auth()->user()->full_name }}</h6>
                                    <p class="user-subtitle">{{ auth()->user()->email }}</p>
                                </div>
                            </div>
                        </a>
                    </li>
                    <li class="dropdown-item" > <a href="{{ route('admin.profile.index') }}"><i class="icon-user mr-2"></i> {{ __('Profile') }} </a> </li>
                    <li class="dropdown-item" onclick="logout()"> <a  style="cursor: pointer;"><i class="icon-power mr-2"></i> {{ __('Logout') }}</a> </li>
                </ul>
            </li>
        </ul>
    </nav>
</header>
