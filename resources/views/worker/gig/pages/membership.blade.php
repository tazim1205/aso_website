@extends('worker.gig.index')

@section('gig_content')
    @if (session('success_buy_package'))
        <div class="alert alert-success" id="alert_success">
            <div class="container">
                {{ session('success_buy_package') }}
            </div>
        </div>
    @endif
    @if (session('success_update_package'))
        <div class="alert alert-success" id="alert_success">
            <div class="container">
                {{ session('success_update_package') }}
            </div>
        </div>
    @endif
    @if (session('danger_update_package'))
        <div class="alert alert-danger" id="alert_danger">
            <div class="container">
                {{ session('danger_update_package') }}
            </div>
        </div>
    @endif
    @if(!auth()->user()->membership)
        @else

        <div class="my-container back-color-1">
            <div class="back-color">
                @if(auth()->user()->membership && !auth()->user()->membershipActive)
                <p>Your Membership is Expired For Page Please Update Your
                    Package!</p>
                @else
                    <p>Your Membership is Running For Page </p>
                @endif
            </div>
        </div>
        <div class="login-form l-1 l-2">
            <a href="javascript:void(0);"><input type="submit"
                                                 value="My Package: {{ auth()->user()->membership->membershipPackage->name ?? '' }}"></a>
        </div>

        <div class="my-container abb-0">
            <div class="abb-1">
                <div><h3>Mobile number</h3></div>
                @if(auth()->user()->membership->membershipPackage->mobile_availability == 1)
                    <div><img src="{{ asset('frontend/image/comment 1.png') }}" alt=""></div>
                @else
                    <div><img src="{{ asset('frontend/image/comment 1.png') }}" alt=""></div>
                @endif
            </div>
            <div class="abb-1 abb-2">
                <div><h3>Despriction</h3></div>
                <div>
                    @if(auth()->user()->membership->membershipPackage->description_availability == 1)
                        <img src="{{ asset('frontend/image/comment 1.png') }}" alt="">
                    @else
                        <img src="{{ asset('frontend/image/comment 1.png') }}" alt="">
                    @endif
                </div>
            </div>
            <div class="abb-1 abb-2">
                <div><h3>Maximum Service</h3></div>
                <div>{{ auth()->user()->membership->membershipPackage->service_count }}</div>
    </div>
</div>


<div class="login-form l-1 l-2">
    <a href="#"><input type="submit" value="Duration"></a>
</div>


<div class="my-container abb-0">
    <div class="abb-1">
        <div><h3>Status</h3></div>
        <div><h4>
        @if(Carbon\Carbon::now()->diffInDays(auth()->user()->membership->ending_at) > 0)
            <span class="badge badge-success shadow-success m-1">Running</span>
        @else
            <span class="badge badge-success shadow-success m-1">Complete</span>
        @endif
        </h4></div>
    </div>
    <div class="abb-1 abb-2">
        <div><h3>Duration</h3></div>
        <div><p>
        @if (auth()->user()->membership->payment_status == 'trial')
                                        <span class="badge badge-success shadow-success m-1">{{ auth()->user()->membership->created_at->diffInDays(auth()->user()->membership->ending_at) }}
                    Days</span>
                    @else
                        <span class="badge badge-success shadow-success m-1">{{ auth()->user()->membership->duration }} months</span>
                        @endif</p></div>
            </div>
            <div class="abb-1 abb-2">
                <div><h3>Start</h3></div>
                <div><p>{{ auth()->user()->membership->created_at->format('d/m/Y') }}</p></div>
            </div>
            <div class="abb-1 abb-2">
                <div><h3>Renew</h3></div>
                <div><p>{{ auth()->user()->membership->updated_at->format('d/m/Y') }}</p></div>
            </div>
            <div class="abb-1 abb-2">
                <div><h3>Ending Date</h3></div>
                <div><p>{{  date('d/m/Y', strtotime(auth()->user()->membership->ending_at)) }}</p></div>
            </div>
        </div>

        <div class="pre-next pre-next-1 my-container abb-3">
            <a href="service_edit_page.html"><input type="text" value="Change Package"></a>
            @if (auth()->user()->membership->payment_status != 'trial')
                <a href="#"><input type="submit" value="Update Package" class="blue-1"></a>
            @else
                <a href="#"><input type="submit" value="Buy Package" class="blue-1"></a>
            @endif
</div>
        @endif
@endsection
