<div id="sidebar-wrapper" data-simplebar="" data-simplebar-auto-hide="true">
    <div class="brand-logo text-center">
        <a href="{{ route('admin.dashboard.index') }}">

            <img src="{{ asset( get_static_option('header_logo_white')  ?? 'uploads/images/defaults/logo-white.png') }}"  class="logo center" alt="aso">
        </a>
    </div>
    <ul class="sidebar-menu do-nicescrol">

        <li class="sidebar-header">{{ __('ADMIN DASHBOARD') }} </li>
        <li>
            <a href="{{ route('admin.dashboard.index') }}" class="waves-effect">
                <i class="icon-home"></i> <span>{{ __('Dashboard') }}</span>
            </a>
        </li>
        <li>
            <a href="javaScript:void();" class="waves-effect">
                <i class="icon-briefcase"></i>
                <span>{{ __('Area') }}</span> <i class="fa fa-angle-left pull-right"></i>
            </a>
            <ul class="sidebar-submenu">
                <li><a href="{{ route('admin.district.index') }}"><i class="fa fa-circle-o"></i> {{ __('District') }} </a></li>
                <li><a href="{{ route('admin.upazila.index') }}"><i class="fa fa-circle-o"></i> {{ __('Upazila') }} </a></li>
            </ul>
        </li>
        <li>
            <a href="javaScript:void();" class="waves-effect">
                <i class="icon-briefcase"></i>
                <span>{{ __('User') }}</span> <i class="fa fa-angle-left pull-right"></i>
            </a>
            <ul class="sidebar-submenu">
                <li><a href="{{ route('admin.administrative.index') }}"><i class="fa fa-circle-o"></i> {{ __('Sub Admin') }} </a></li>
                <li><a href="{{ route('admin.controller.index') }}"><i class="fa fa-circle-o"></i> {{ __('Area controller') }} </a></li>
{{--                <li><a href="{{ route('admin.worker.index') }}"><i class="fa fa-circle-o"></i> {{ __('Worker') }} </a></li>--}}
{{--                <li><a href="{{ route('admin.membership.index') }}"><i class="fa fa-circle-o"></i> {{ __('Member') }} </a></li>--}}
{{--                <li><a href="{{ route('admin.customer.index') }}"><i class="fa fa-circle-o"></i> {{ __('Customer') }} </a></li>--}}
                <li><a href="{{ route('admin.users.create') }}"><i class="fa fa-circle-o"></i> {{ __('Create new') }} </a></li>
            </ul>
        </li>
        <li>
            <a href="javaScript:void();" class="waves-effect">
                <i class="icon-briefcase"></i>
                <span>{{ __('Service category') }}</span> <i class="fa fa-angle-left pull-right"></i>
            </a>
            <ul class="sidebar-submenu">
                <li><a href="{{ route('admin.worker-service-category.index') }}"><i class="fa fa-circle-o"></i>{{ __(' Category') }}</a></li>
                <li><a href="{{ route('admin.worker-service.index') }}"><i class="fa fa-circle-o"></i> {{ __('Sub Category') }}</a></li>
            </ul>
        </li>
        {{-- <li>
            <a href="javaScript:void();" class="waves-effect">
                <i class="icon-briefcase"></i>
                <span>{{ __('General. | Service') }}</span> <i class="fa fa-angle-left pull-right"></i>
            </a>
            <ul class="sidebar-submenu">
                <li><a href="{{ route('admin.membership-service-category.index') }}"><i class="fa fa-circle-o"></i> {{ __('Category') }}</a></li>
                <li><a href="{{ route('admin.membership-service.index') }}"><i class="fa fa-circle-o"></i> {{ __('Service') }}</a></li>
            </ul>
        </li> --}}
        <li>
            <a href="javaScript:void();" class="waves-effect">
                <i class="icon-briefcase"></i>
                <span>{{ __('Special. | Service') }}</span> <i class="fa fa-angle-left pull-right"></i>
            </a>
            <ul class="sidebar-submenu">
                <li><a href="{{ route('admin.special-service.index') }}"><i class="fa fa-circle-o"></i> {{ __('Service') }}</a></li>
            </ul>
        </li>
        <li>
            <a href="javaScript:void();" class="waves-effect">
                <i class="icon-briefcase"></i>
                <span>{{ __('Complain') }}</span> <i class="fa fa-angle-left pull-right"></i>
            </a>
            <ul class="sidebar-submenu">
                <li><a href="{{ route('admin.complain.customer-complain') }}"><i class="fa fa-circle-o"></i> {{ __('Customer. | complain') }}</a></li>
            </ul>
        </li>
        <li>
            <a href="javaScript:void();" class="waves-effect">
                <i class="icon-briefcase"></i>
                <span>{{ __('Notices') }}</span> <i class="fa fa-angle-left pull-right"></i>
            </a>
            <ul class="sidebar-submenu">
                <li><a href="{{ route('admin.admin-notice.index') }}"><i class="fa fa-circle-o"></i> {{ __('Admin notices') }}</a></li>
            </ul>
            <ul class="sidebar-submenu">
                <li><a href="{{ route('admin.controller-notice.index') }}"><i class="fa fa-circle-o"></i> {{ __('Controller notices') }}</a></li>
            </ul>
        </li>
        <li>
            <a href="javaScript:void();" class="waves-effect">
                <i class="icon-briefcase"></i>
                <span>{{ __('Ads.') }}</span> <i class="fa fa-angle-left pull-right"></i>
            </a>
            <ul class="sidebar-submenu">
                <li><a href="{{ route('admin.admin-ads.index') }}"><i class="fa fa-circle-o"></i> {{ __('Admin ads') }}.</a></li>
            </ul>
            <ul class="sidebar-submenu">
                <li><a href="{{ route('admin.controller-ads.index') }}"><i class="fa fa-circle-o"></i> {{ __('Controller ads') }}.</a></li>
            </ul>
        </li>
        <li>
            <a href="javaScript:void();" class="waves-effect">
                <i class="icon-briefcase"></i>
                <span>{{ __('Membership') }}</span> <i class="fa fa-angle-left pull-right"></i>
            </a>
            <ul class="sidebar-submenu">
                <li><a href="{{ route('admin.membership-package.index') }}"><i class="fa fa-circle-o"></i> {{ __('Memberships') }}</a></li>
            </ul>
        </li>

        <li class="sidebar-header">SETTING</li>
        <li>
            <a href="javaScript:void();" class="waves-effect">
                <i class="icon-briefcase"></i>
                <span>{{ __('Other Pages') }}</span> <i class="fa fa-angle-left pull-right"></i>
            </a>
            <ul class="sidebar-submenu">
                <li><a href="{{ route('admin.page.service.details') }}"><i class="fa fa-circle-o"></i> Service Details</a></li>
                <li><a href="{{ route('admin.page.about') }}"><i class="fa fa-circle-o"></i> About</a></li>
                <li><a href="{{ route('admin.page.terms.condition') }}"><i class="fa fa-circle-o"></i> Terms & Condition</a></li>
                <li><a href="{{ route('admin.page.privacy.policy') }}"><i class="fa fa-circle-o"></i> Privacy Policy</a></li>
                <li><a href="{{ route('admin.page.faq') }}"><i class="fa fa-circle-o"></i> FAQ</a></li>
                <li><a href="{{ route('admin.video.index') }}"><i class="fa fa-circle-o"></i> Video</a></li>
                <li><a href="{{ route('admin.page.training-video') }}"><i class="fa fa-circle-o"></i> Training Video</a></li>
            </ul>
        </li>
        <li><a href="{{ route('admin.showGeneralInformation') }}" class="waves-effect"><i class="fa fa-circle-o text-aqua"></i>
                <span>{{ __('Static Options') }}</span></a>
        </li>

    <li><a href="{{ route('admin.showGeneralMarketerCommission') }}" class="waves-effect"><i class="fa fa-circle-o text-aqua"></i>
        <span>{{ __('Marketer Commission') }}</span></a>
</li>








        <li><a href="javascript:0" target="_blank" class="waves-effect translation-btn"><i class="fa fa-circle-o text-red"></i>
                <span>{{ __('Translation') }} ({{ current_language() }})</span></a>
        </li>
        <br>
        <br>
        <br>
        <br>
    </ul>
</div>


<script>
    $(document).ready(function() {
        //Show modal
        $('.translation-btn').click(function(){
            let params = `scrollbars=no,resizable=no,status=no,location=no,toolbar=no,menubar=no,
            width=0,height=0,left=-1000,top=-1000`;
            open('{{ url('/language-management/'. current_language() .'/translations') }}', 'test', params);
        });
    });
</script>
