<div class="bid-area">
    <div class="bid-acont">
        <div class="bid-icon">
            <img src="{{ asset($customerBid->workerGig->worker->image ?? 'uploads/images/defaults/user.png') }}" alt="">
        </div>

        <div class="bid-tittle">
            <div class="bid-cont">
                <h2>{{ $customerBid->workerGig->worker->full_name }}</h2>
            </div>
        </div>

        <div class="bid-icon bi">
            <a href="{{ $customerBid->workerGig->worker->location }}">
                <i class="fa-solid fa-location-dot location"></i>
            </a>

        </div>
    </div>

    <div class="price-change">
        <h2>প্রয়োজন অনুযায়ী প্রাইজ পরিবর্তন করুন</h2>
        <input type="hidden" id="bid-id" value="{{ $customerBid->id }}">
        <input type="text" id="budget" name="price" placeholder="250" />
        <input type="submit" value="Submit" id="update_budget" data-worker-limit="{{ App\User::worker_bid_gig_limit($customerBid->workerGig->worker_id) }}"/>
    </div>

    <div class="box-area">
        <div class="box-head">
            <div class="box-left">
                <h3>Price</h3>
                <p>$ {{ $customerBid->budget }}</p>
            </div>
            <div class="box-right">
                <h3>Code:</h3>
                <p>#AO{{ $customerBid->id }}</p>
            </div>
        </div>

        <div class="box-foot">
            <h2>Title</h2>
            <p>{{ $customerBid->workerGig->title }}</p>
            <h2>Details</h2>
            <p>
                {!! $customerBid->description !!}
            </p>
            <h2>Address</h2>
            <p>{{ $customerBid->workerGig->worker->address }}</p>
        </div>
    </div>
    <div class="bid-time-count">
        <div class="db-t">
            <h2>ডেলিবারি</h2>
            <h2>টাইম</h2>
        </div>
        <div>
            <p>{{
            $customerBid->workerGig->day }}</p>
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
        <p>অর্ডারটি শুরু করার সম্ভাব্য তারিখ ও সময়: {{ date('h:i a', strtotime($customerBid->time)) }}, {{ date('d F Y',
                strtotime($customerBid->date)) }}</p>
    </div>
</div>

<div class="all-bid aii-cancel"><a href="javascript:void();" id="job-cancel">Cancel</a></div>
