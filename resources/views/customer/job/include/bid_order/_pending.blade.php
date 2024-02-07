<div class="bid-area">
    <div class="bid-acont">
        <div class="bid-icon">
            <img src="{{ asset($gig->customer->image ?? 'uploads/images/defaults/user.png') }}" alt="">
        </div>
        <div class="bid-tittle">
            <div class="bid-cont">
                <h2>{{ $gig->customer->full_name }}</h2>
                <p>{{ $gig->customer->phone }}</p>
            </div>
        </div>
    </div>

    <div class="box-area">
        <div class="box-head">
            <div class="box-left">
                <h3>Price</h3>
                <p>$ {{ $gig->budget }}</p>
            </div>
            <div class="box-right">
                <h3>Code:</h3>
                <p>#BO{{ $gig->id }}</p>
            </div>
        </div>

        <div class="box-foot">
            <h2>Title</h2>
            <p>{{ $gig->title }}</p>
            <h2>Details</h2>
            <p>
                {!! $gig->description !!}
            </p>
            <h2>Address</h2>
            <p>{{ $gig->address }}</p>
        </div>
    </div>

    <div class="bid-time-count">
        <div class="db-t">
            <h2>ডেলিবারি</h2>
            <h2>টাইম</h2>
        </div>
        <div>
            <p>{{ $gig->day }}</p>
        </div>
        <div>
            <h2>ঘন্টা</h2>
        </div>
    </div>

    <div class="bid-details">
        <p>
            বিডিং চলছে..কাস্টমার নির্দিষ্ট সময়ের মধ্যে পছন্দসই বিডিটিতে অর্ডার
            confirm করবে, একটু অপেক্ষা করুন..আপনার বিডটির অর্ডার confirm করলে
            অর্ডার রানিং হবে, অন্যথায় আপনার অফারটি Auto Cancel হয়ে যাবে
        </p>
    </div>

    <div class="bid-time">
        <div class="bid-time-flex">
            <div class="bid-circle"><h2 id="days">02</h2></div>
            <div class="bid-info"><h3>Days</h3></div>
        </div>
        <div class="bid-time-flex">
            <div class="bid-circle"><h2 id="hours">12</h2></div>
            <div class="bid-info"><h3>Hours</h3></div>
        </div>
        <div class="bid-time-flex">
            <div class="bid-circle"><h2 id="minutes">52</h2></div>
            <div class="bid-info"><h3>Minute</h3></div>
        </div>
        <div class="bid-time-flex">
            <div class="bid-circle"><h2 id="seconds">42</h2></div>
            <div class="bid-info"><h3>Second</h3></div>
        </div>
    </div>

    <div class="bid-mini">
        <p>অর্ডারটি শুরু করার সম্ভাব্য তারিখ ও সময়: {{  date('h:i a', strtotime($gig->time)) }}, {{  date('d F Y', strtotime($gig->date)) }}</p>
    </div>
</div>

<div class="all-bid"><a href="#">বিড সমূহ</a></div>

<div class="my-container">
    @foreach($gig->workerBids->where('is_cancelled', 0) as $bid)
    <div class="service-area">
        <div class="service-up">
            <div class="service-left">
                <div class="s-b-2">
                    <div class="bid-icon bid-icon-2">
                        <img src="{{ asset($bid->worker->image ?? 'uploads/images/defaults/user.png') }}" alt="">
                    </div>
                    <div class="s-b-3">
                        <h2>{{ $bid->worker->full_name }}</h2>
                        <p>
                            @php
                                $percent = 100 - (($bid->worker->rating->max_rate - $bid->worker->rating->rate)/$bid->worker->rating->max_rate)*100;
                                if ($percent>80)
                                    $star = 5;
                                else if ($percent>60)
                                    $star = 4;
                                else if ($percent>40)
                                    $star = 3;
                                else if ($percent>20)
                                    $star = 2;
                                else if ($percent>1)
                                    $star = 1;
                                else
                                    $star = 0;
                            @endphp
                            <span>
                                @for ($starCounter = 1; $starCounter <= $star; $starCounter++)
                                    <i class="fa-regular fa-star"></i>
                                @endfor
                                 3(2)
                            </span>
                        </p>
                        <p>
                            {!! $bid->description !!}
                        </p>
                    </div>
                </div>
            </div>
            <div class="service-right sb-r">
                <h4>৳ {{ $bid->budget }}</h4>
            </div>
        </div>
    </div>
        <input type="hidden" id="gig-id" value="{{ $gig->id }}">
        <div class="all-bid all-3"><a href="javascript:void();" class="order-now">Order</a></div>
    @endforeach

</div>

<div class="all-bid aii-cancel">
    <a href="javascript:void();" id="job-cancel">Cancel</a>
</div>

<div class="sure">
    <div class="my-container">
        <div class="pop-up-3">
            <div class="pop-qn"><i class="fa-solid fa-question"></i></div>
            <div>
                <h4>Are you sure?</h4>
                <p>This worker selected for this job.</p>
            </div>
            <div class="pop-up-3-flex">
                <a href="order_panding_deatails_page19.html"
                ><button>Cancel</button></a
                >
                <a href="order_complete_page_20.html"
                ><button>Order Now !</button></a
                >
            </div>
        </div>
    </div>
</div>
