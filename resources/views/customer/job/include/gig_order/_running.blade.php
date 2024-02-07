<div class="bid-area">
    <div class="bid-acont">
        <div class="bid-icon">
            <img src="{{ asset($customerBid->workerGig->worker->image ?? 'uploads/images/defaults/user.png') }}" alt="">
        </div>

        <div class="bid-tittle">
            <div class="bid-cont">
                <h2>{{ $customerBid->workerGig->worker->full_name }}</h2>
                <p>
                    @php
                        $percent = 100 - (($customerBid->workerGig->worker->rating->max_rate -
                        $customerBid->workerGig->worker->rating->rate)/$customerBid->workerGig->worker->rating->max_rate)*100;
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
                    <span><i class="fa-regular fa-star"></i></span> {{ $star }} ({{ $customerBid->workerGig->worker->rating->max_rate -
                                        $customerBid->workerGig->worker->rating->rate }})
                </p>
            </div>
        </div>

        <div class="bid-icon bi">
            <a href="{{ $customerBid->workerGig->worker->location }}">
                <i class="fa-solid fa-location-dot location"></i>
            </a>

        </div>
    </div>

    <div class="calling-area">
        <div class="calling-right">
            <span><i class="fa-solid fa-phone"></i></span>
        </div>
        <div class="calling-left">
            <h4>Start voice call</h4>
            <p>{{ $customerBid->workerGig->worker->phone }}</p>
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
            <p>{!! $customerBid->workerGig->title !!}</p>
            <h2>Details</h2>
            <p>
                {!! $customerBid->workerGig->description !!}
            </p>
            <h2>Address</h2>
            <p>{{ $customerBid->address }}</p>
        </div>
    </div>

    <div class="bid-time-count">
        <div class="db-t">
            <h2>ডেলিবারি</h2>
            <h2>টাইম</h2>
        </div>
        <div>
            <p>{{ $customerBid->workerGig->day }}</p>
        </div>
        <div>
            <h2>ঘন্টা</h2>
        </div>
    </div>

    <div class="bid-mini">
        <p>অর্ডারটি শুরু করার সম্ভাব্য তারিখ ও সময়: {{ date('h:i a', strtotime($customerBid->time)) }}, {{ date('d F Y', strtotime($customerBid->date)) }}</p>
    </div>

    <div class="photo-upload">
        <h2><i class="fa-regular fa-image"></i></h2>
        <p>Drop your image here, or <a href="#"> browse</a></p>
    </div>

    <div class="last-btn">
        <input type="submit" value="Complain" class="db" onclick="complainNow({{ $customerBid->id }});"/>
        <input type="submit" value="Completed" id="completed-btn"/>
    </div>
</div>
