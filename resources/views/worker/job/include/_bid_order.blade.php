<div class="bid-order">

    <div class="order-area">
        <ul class="order-btn-area">
            <li class="order-btn pending-color l-item-1"><a class="cl-1" href="#">Pending({{ $activeBid }})</a></li>
            <li class="order-btn l-item-2"><a class="cl-2" href="#">Completed({{ $completeBid }})</a></li>
            <li class="order-btn l-item-3"><a class="cl-3" href="#">Running({{$runningBid }})</a></li>
            <li class="order-btn l-item-4"><a class="cl-4" href="#">Canceled({{ $cancelledBid }})</a></li>
        </ul>
    </div>

    <!-- admin ads -->
    <div id="carouselExample" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner" style="width: 50%;margin-left: 25%;">
            @foreach($adminAds as $chabi => $ads)
            <div class="carousel-item @if(isset($chabi)) active @endif">
                <img src="{{ asset($ads->image) }}" class="d-block w-100" alt="...">
            </div>
            @endforeach
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
    <!-- admin ads end -->

    <!-- controller ads area -->
    <div id="carouselExample" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            @foreach($controllerAds as $key => $controllerAdss)
            <div class="carousel-item @if(isset($key)) active @endif">
                
                <a  @if($controllerAdss->url) href="{{ $controllerAdss->url }}" target="_blank" @endif >
                <img src="{{ asset($controllerAdss->image) }}" class="d-block w-100" alt="...">
                </a>
            </div>
            @endforeach
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
    <!-- controller ads end -->

    @foreach(auth()->user()->workerBids as $workerBid)
        @if($workerBid->customerGig->status == 'cancelled' || $workerBid->is_cancelled == 1)
            <div class="order-area tab-4">
                <div class="order-comp">
                    <div class="order-comp-btn order-btn">
                        <a href="#"> Canceled | বিড অর্ডার</a>
                    </div>
                </div>
                    <div class="service-area">
                        <div class="service-up">

                            <div class="service-left">
                                <h2>{{ $workerBid->customerGig->title }}</h2>
                                <p>Canceled</p>
                                <p>{{ date('h:i a, d/m/y', strtotime($workerBid->customerGig->updated_at)) }}</p>
                            </div>
                            <div class="service-right">
                                <h4>Taka</h4>
                                <h4>৳ {{ $workerBid->budget }}</h4>
                            </div>
                        </div>
                        <div class="service-foot"><a href="{{ route('worker.showWorkerBid', \Illuminate\Support\Facades\Crypt::encryptString($workerBid->customerGig->id)) }}">Veiw Details</a></div>
                    </div>
            </div>

        @elseif($workerBid->customerGig->status == 'active')
            @php
                $proposal = App\WorkerBid::where('customer_gig_id',$workerBid->customer_gig_id)->count();
            @endphp
            <div class="order-area tab-1">
                <div class="order-comp">
                    <div class="order-comp-btn order-btn">
                        <a href="#">Pending | বিড অর্ডার</a>
                    </div>
                </div>
                    <div class="service-area">
                        <div class="service-up">

                            <div class="service-left">
                                <h2>{{ $workerBid->customerGig->title }}</h2>
                                <p>Created</p>
                                <p>{{ date('h:i a, d/m/y', strtotime($workerBid->customerGig->created_at)) }}</p>
                            </div>
                            <div class="service-right">
                                <h4>Bid</h4>
                                <h4>{{ $proposal }}</h4>
                            </div>
                        </div>
                        <div class="service-foot"><a href="{{ route('worker.showWorkerBid', \Illuminate\Support\Facades\Crypt::encryptString($workerBid->customerGig->id)) }}">Veiw Details</a></div>
                    </div>

            </div>

        @elseif($workerBid->customerGig->status == 'running')
            <div class="order-area tab-2">
                <div class="order-comp">
                    <div class="order-comp-btn order-btn">
                        <a href="#">Completed | বিড অর্ডার</a>
                    </div>
                </div>
                    <div class="service-area">
                        <div class="service-up">

                            <div class="service-left">
                                <h2>{{ $workerBid->customerGig->title }}</h2>
                                <p>Delivered</p>
                                <p>{{ date('h:i a, d/m/y', strtotime($workerBid->customerGig->created_at)) }}</p>
                            </div>
                            <div class="service-right">
                                <h4>Taka</h4>
                                <h4>৳ {{ $workerBid->budget }}</h4>
                            </div>
                        </div>
                        <div class="service-foot"><a href="{{ route('worker.showWorkerBid', \Illuminate\Support\Facades\Crypt::encryptString($workerBid->customerGig->id)) }}">Veiw Details</a></div>
                    </div>

                <!-- @include('customer.layout.include._carosole') -->
            </div>

        @elseif($workerBid->customerGig->status == 'completed')
            <div class="order-area tab-3">
                <div class="order-comp">
                    <div class="order-comp-btn order-btn">
                        <a href="#">Running | বিড অর্ডার</a>
                    </div>
                </div>
                    <div class="service-area">
                        <div class="service-up">
                            <div class="service-left">
                                <h2>{{ $workerBid->customerGig->title }}</h2>
                                <p>Delivery date</p>
                                <p>{{ date('h:i a, d/m/y', strtotime($workerBid->customerGig->updated_at)) }}</p>
                            </div>
                            <div class="service-right">
                                <h4>Taka</h4>
                                <h4>৳ {{ $workerBid->budget }}</h4>
                            </div>
                        </div>
                        <div class="service-foot"><a href="{{ route('worker.showWorkerBid', \Illuminate\Support\Facades\Crypt::encryptString($workerBid->customerGig->id)) }}">Veiw Details</a></div>
                    </div>

            </div>
        @endif
    @endforeach
</div>
