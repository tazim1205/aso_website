@foreach($gig->workerBids->where('is_selected', '1') as $bid)
<div class="bid-area">
    <div class="bid-acont dg">
        <div class="bid-icon">
            <img src="{{ asset($bid->worker->image ?? 'uploads/images/defaults/user.png') }}" alt="">
        </div>
        <div class="bid-tittle">
            <div class="bid-cont">
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
                    <span><i class="fa-regular fa-star"></i> {{$star}} ({{ getWorkerRatting($bid->worker->id) }})</span>
                </p>
            </div>
        </div>
    </div>

    <div class="box-area">
        <div class="box-head">
            <div class="box-left">
                <h3>Price</h3>
                <p>$ {{ $bid->budget }}</p>
            </div>
            <div class="box-right">
                <h3>Code:</h3>
                <p>#AO{{ $bid->id }}</p>
            </div>
        </div>

        <div class="box-foot">
            <h2>Title</h2>
            <p>{!! $bid->customerGig->title !!}</p>
            <h2>Details</h2>
            <p>
                {!! $bid->customerGig->description !!}
            </p>
            <h2>Address</h2>
            <p>{{ $bid->customerGig->address }}</p>
        </div>
    </div>

    <div class="delivary-date">
        <p>{{ __('ডেলিবারি তারিখ') }}: {{ date('h:i:s a d/m/y', strtotime($gig->updated_at)) }}</p>
    </div>

    <div class="bid-mini">
        <p>অর্ডারটি শুরু করার সম্ভাব্য তারিখ ও সময়: {{  date('h:i a', strtotime($bid->customerGig->time)) }}, {{  date('d F Y', strtotime($bid->customerGig->date)) }}</p>
    </div>
    @if($bid->rating_given == 0)
    <div class="review-area">
        <div class="review-1">
            <h3>How do you rate our service?</h3>
        </div>

        <div class="review-2">
            <span><i class="fa-regular fa-star"></i></span>
            <span><i class="fa-regular fa-star"></i></span>
            <span><i class="fa-regular fa-star"></i></span>
            <span><i class="fa-regular fa-star"></i></span>
            <span><i class="fa-regular fa-star"></i></span>
        </div>

        <div class="review-3">
            <h5>Bad</h5>
            <h5>Excellent</h5>
        </div>

        <div class="review-4">
            <h5>
                সার্ভিসটির মান ও সার্ভিস প্রোভাইডার সম্পর্কে আপনার মতামত লিখুন
            </h5>
            <input
                type="text"
                name="massage"
                placeholder="সার্ভিসটির মান ও সার্ভিস প্রোভাইডার সম্পর্কে আপনার মতামত লিখুন"
            />
            <a href="" data-id="{{$bid->id}}"><input type="submit" value="Submit" /></a>
        </div>
    </div>
        @endif
</div>
@endforeach
