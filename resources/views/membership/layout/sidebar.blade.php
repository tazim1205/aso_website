<div class="sidebar">
    <div class="mt-4 mb-3">
        <div class="row">
            <div class="col-auto">
                <figure class="avatar avatar-60 border-0"><img src="{{ asset(auth()->user()->image ?? 'uploads/images/defaults/user.png') }}" alt=""></figure>
            </div>
            <div class="col pl-0 align-self-center">
                <h5 class="mb-1">{{ auth()->user()->full_name }} </h5>
                <p class="text-mute small">{{ auth()->user()->phone }}</p>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <div class="list-group main-menu">
                <a href="{{ route('membership.home.index') }}" class="list-group-item list-group-item-action @if(Route::is('membership.home.index')) active @endif"><i class="material-icons icons-raised">home</i>Home</a>
                @if(auth()->user()->membership)
                    @if(auth()->user()->membershipPages->count() > 0)
                        <a href="{{ route('membership.page.index') }}" class="list-group-item list-group-item-action"><i class="material-icons icons-raised">edit</i> {{ __('Update page') }}</a>
                    @else
                        <a href="{{ route('membership.page.index') }}" class="list-group-item list-group-item-action"><i class="material-icons icons-raised">edit</i> {{ __('Create page') }}</a>
                    @endif
                @else
                    <a href="" class="list-group-item list-group-item-action"><i class="material-icons icons-raised">find_in_page</i> {{ __('Buy a package') }} </a>
                @endif
                <a href="{{ route('membership.page.index') }}" class="list-group-item list-group-item-action"><i class="material-icons icons-raised">view_quilt<span class="new-notification"></span></i>Pages Controls</a>
                <a href="{{ route('language') }}" class="list-group-item list-group-item-action"><i class="material-icons icons-raised">language</i>@if(current_language() == 'bn') {{ __('English') }} @else {{ __('বাংলা') }} @endif</a>

                <a href="javascript:void(0)" class="list-group-item list-group-item-action" data-toggle="modal" data-target="#colorscheme"><i class="material-icons icons-raised">color_lens</i>{{ __('Color') }}</a>

                <a href="{{ route('membership.profile.index') }}" class="list-group-item list-group-item-action @if(Route::is('membership.profile.index')) active @endif"><i class="material-icons">account_circle</i>  &nbsp; Profile</a>

                <a href="#" onclick="logout()" class="list-group-item list-group-item-action"><i class="material-icons icons-raised bg-danger">power_settings_new</i>{{ __('Sign out') }}</a>
            </div>
        </div>
    </div>
</div>
<a href="javascript:void(0)" class="closesidemenu"><i class="material-icons icons-raised bg-dark ">close</i></a>
