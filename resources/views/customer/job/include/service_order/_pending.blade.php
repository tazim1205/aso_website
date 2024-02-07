
<div class="bid-area">
    <div class="bid-acont">
        <div class="bid-icon">
            <img src="{{ asset($serviceBid->customer->image ?? 'uploads/images/defaults/user.png') }}" alt="">
        </div>
        <div class="bid-tittle">
            <div class="bid-cont">
                <h2>{{ App\WorkerPage::where('worker_id', $serviceBid->worker_id)->first()->name }}</h2>
                <p>01762867758</p>
            </div>
        </div>
    </div>

    <div class="box-area">
        <div class="box-head">
            <div class="box-left">
                <h3>Price</h3>
                <p>$ {{ $serviceBid->budget }}</p>
            </div>
            <div class="box-right">
                <h3>Code:</h3>
                <p>#AO{{  $serviceBid->id }}</p>
            </div>
        </div>

        <div class="box-foot">
            <h2>Title</h2>
            <p>I need Ac Repair</p>
            <h2>Details</h2>
            <p>
                {!! $serviceBid->description !!}
            </p>
            <h2>Address</h2>
            <p>{{ $serviceBid->address }}</p>
        </div>
    </div>

    <div class="bid-time-count">
        <div class="db-t">
            <h2>ডেলিবারি</h2>
            <h2>টাইম</h2>
        </div>
        <div>
            <p>{{ App\PageService::withTrashed()->find($serviceBid->worker_service_id)->day }}</p>
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
        <p>অর্ডারটি শুরু করার সম্ভাব্য তারিখ ও সময়: {{  date('h:i a', strtotime($serviceBid->time)) }}, {{  date('d F Y', strtotime($serviceBid->date)) }}</p>
    </div>
</div>

<div class="all-bid"><a href="#">বিড সমূহ</a></div>

<div class="my-container">
    <div class="service-area">
        <div class="service-up">
            <div class="service-left">
                <div class="s-b-2">
                    <div class="bid-icon bid-icon-2">
                        <i class="fa-regular fa-user"></i>
                    </div>
                    <div class="s-b-3">
                        <h2>Md abu ayed</h2>
                        <p>
                            <span><i class="fa-regular fa-star"></i> 3(2)</span>
                        </p>
                        <p>
                            i can fix the problen i can fix the problen i can fix the
                            problen...
                        </p>
                        <p>Order Me</p>
                    </div>
                </div>
            </div>
            <div class="service-right sb-r">
                <h4>৳ 1200</h4>
            </div>
        </div>
    </div>
    <div class="all-bid all-3"><a href="#">Order</a></div>
</div>

<div class="all-bid aii-cancel">
    <a href="order_panding_page_18.html">Cancel</a>
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
