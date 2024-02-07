<div class="gig-order">
    <div class="order-area">

        <ul class="order-btn-area">
            <li class="order-btn pending-color l-item-1"><a class="cl-1" href="#">Pending({{ $activeGig }})</a></li>
            <li class="order-btn l-item-2"><a class="cl-2" href="#">Completed({{ $completeGig }})</a></li>
            <li class="order-btn l-item-3"><a class="cl-3" href="#">Running({{ $runningGig }})</a></li>
            <li class="order-btn l-item-4"><a class="cl-4" href="#">Canceled({{ $cancelledGig }})</a></li>
        </ul>
    </div>

    <div class="order-area tab-1">

        <div class="order-comp">
            <div class="order-comp-btn order-btn">
                <a href="#">Pending | গিগ অর্ডার</a>
            </div>
        </div>
        @foreach(auth()->user()->workerGigs as $workerGigs)
            @foreach($workerGigs->customerBids->where('status', 'active') as $customerBids)
        <div class="service-area">
            <div class="service-up">

                <div class="service-left">
                    <h2>{{ $workerGigs->title }}</h2>
                    <p>Created</p>
                    <p>{{ date('h:i a, d/m/y', strtotime($customerBids->created_at)) }}</p>
                </div>
                <div class="service-right">
                    <h4>Taka</h4>
                    <h4>$ {{ $workerGigs->budget }}</h4>
                </div>

            </div>

            <div class="service-foot"><a href="{{ route('worker.showCustomerBid', \Illuminate\Support\Facades\Crypt::encryptString($customerBids->id)) }}">Veiw Details</a></div>
        </div>
            @endforeach
        @endforeach
        @include('customer.layout.include._carosole')
    </div>

    <div class="order-area tab-2">

        <div class="order-comp">
            <div class="order-comp-btn order-btn">
                <a href="#">Completed | গিগ অর্ডার</a>
            </div>
        </div>

        @foreach(auth()->user()->workerGigs as $workerGigs)
            @foreach($workerGigs->customerBids->where('status', 'completed') as $customerBids)
        <div class="service-area">
            <div class="service-up">

                <div class="service-left">
                    <h2>{{ $workerGigs->title }}</h2>
                    <p>Delivered</p>
                    <p>{{ date('h:i a, d/m/y', strtotime($customerBids->created_at)) }}</p>
                </div>
                <div class="service-right">
                    <h4>Taka</h4>
                    <h4>৳ {{ $customerBids->budget }}</h4>
                </div>

            </div>

            <div class="service-foot"><a href="{{ route('worker.showCustomerBid', \Illuminate\Support\Facades\Crypt::encryptString($customerBids->id)) }}">Veiw Details</a></div>
        </div>
            @endforeach
        @endforeach

        @include('customer.layout.include._carosole')
    </div>
    <div class="order-area tab-3">

        <div class="order-comp">
            <div class="order-comp-btn order-btn">
                <a href="#">Running | গিগ অর্ডার</a>
            </div>
        </div>
        @foreach(auth()->user()->workerGigs as $workerGigs)
            @foreach($workerGigs->customerBids->where('status', 'running') as $customerBids)
        <div class="service-area">
            <div class="service-up">
                <div class="service-left">
                    <h2>{{ $workerGigs->title }}</h2>
                    <p>Created</p>
                    <p>{{ date('h:i a, d/m/y', strtotime($customerBids->created_at)) }}</p>
                </div>
                <div class="service-right">
                    <h4>Taka</h4>
                    <h4>৳ {{ $customerBids->budget }}</h4>
                </div>
            </div>
            <div class="service-foot"><a href="{{ route('worker.showCustomerBid', \Illuminate\Support\Facades\Crypt::encryptString($customerBids->id)) }}">Veiw Details</a></div>
        </div>
            @endforeach
        @endforeach
        @include('customer.layout.include._carosole')
    </div>
<div class="order-area tab-4">
    <div class="order-comp">
        <div class="order-comp-btn order-btn">
            <a href="#">Canceled | গিগ অর্ডার</a>
        </div>
    </div>
    @foreach(auth()->user()->workerGigs as $workerGigs)
        @foreach($workerGigs->customerBids->where('status', 'cancelled') as $customerBids)
    <div class="service-area">
        <div class="service-up">
            <div class="service-left">
                <h2>{{ $workerGigs->title }}</h2>
                <p>Canceled</p>
                <p>{{ date('h:i a, d/m/y', strtotime($customerBids->created_at)) }}</p>
            </div>
            <div class="service-right">
                <h4>Taka</h4>
                <h4>৳ {{ $customerBids->budget }}</h4>
            </div>
        </div>
        <div class="service-foot"><a href="{{ route('worker.showCustomerBid', \Illuminate\Support\Facades\Crypt::encryptString($customerBids->id)) }}">Veiw Details</a></div>
    </div>
        @endforeach
    @endforeach
    @include('customer.layout.include._carosole')
</div>
</div>
