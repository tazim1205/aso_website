<div class="logo-nav">
    <div class="logo-nav-left">
        <img src="{{ asset( get_static_option('header_logo')  ?? '/image/aso-logo.png') }}" alt="">
    </div>
    <div class="logo-nav-right">
        <ul>
            <li><a href="search.html"><i class="fa-solid fa-magnifying-glass"></i></a></li>
            <li><a href="#"><i class="fa-solid fa-location-dot location"></i></a></li>
            <li><a href="{{ route('customer.notifications') }}"><i class="fa-regular fa-bell"></i><span class="counts">({{ auth()->user()->unreadNotifications->count() }})</span></a></li>
        </ul>
    </div>

</div>
