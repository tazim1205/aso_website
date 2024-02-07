 @extends('worker.layout.master')
@push('title') {{ __('BID Order') }} @endpush

@section('content')
    <div class="bid-area">
        <div class="bid-acont">
            <div class="bid-icon"><img src="{o{ asset($custmerGig->customer->image ?? 'uploads/images/defaults/user.png') }}" alt=""></div>

            <div class="bid-tittle">
                <div class="bid-cont">
                    <h2>{{ $customerGig->customer->full_name }}</h2>
                    <p>
                        <span><i class="fa-regular fa-star"></i></span> 3 (2)
                    </p>
                </div>
            </div>

            <div class="bid-icon bi">
                <i onclick="window.location.href='{{ $customerGig->customer->location }}'" class="fa-solid fa-location-dot location"></i>
            </div>
        </div>

        <div class="box-area">
            <div class="box-foot">
                <h2>Title</h2>
                <p>{{ $customerGig->title }}</p>
                <h2>Details</h2>
                <p>
                    {!! $customerGig->description !!}
                </p>
                <h2>Address</h2>
                <p>{{ $customerGig->address }}</p>
            </div>
        </div>

        <div class="bid-time-count">
            <div class="db-t">
                <h2>ডেলিবারি</h2>
                <h2>টাইম</h2>
            </div>
            <div>
                <p>{{ $customerGig->day }}</p>
            </div>
            <div>
                <h2>ঘন্টা</h2>
            </div>
        </div>

        <div class="bid-mini">
            <p>{{  date('h:i a, d/m/y', strtotime($customerGig->created_at)) }}</p>
        </div>

        <div class="bid-mini">
            <p>অর্ডারটি শুরু করার সম্ভাব্য তারিখ ও সময়: {{  date('h:i a', strtotime($customerGig->time)) }}, {{  date('d F Y', strtotime($customerGig->date)) }}</p>
        </div>
    </div>
    @if(auth()->user()->workerBids()->where('customer_gig_id', $customerGig->id)->exists())
    <div class="all-bid-2 all-bid-3">
        <a href="javascript:void();"><input type="submit" value="{{ __('BID ALREADY SUBMITTED') }}" /></a>
    </div>
    @else
        <div class="all-bid-2 all-bid-3">
            <a href="javascript:void();"><input type="submit" value="BID NOW" /></a>
        </div>
    @endif
    <div class="my-container pop-12">
        <div class="pop-up-1">
            <div class="pop-up-inner">
                <h2>আপনার অভিযোগ লিখুন</h2>
                <input
                    type="text"
                    placeholder="অর্ডার কোড সহ আপনার অডিযোগের বিস্তারিত লিখুন..."
                />
            </div>

            <div class="last-btn pop-up-btn">
                <input type="submit" value="Cancel" class="cancel" />
                <input type="submit" value="Submit" />
            </div>
        </div>
    </div>

    <div class="review-area r-area">
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
            <h5>সার্ভিসটির মান ও সার্ভিস প্রোভাইডার সম্পর্কে আপনার মতামত লিখুন</h5>
            <input
                type="text"
                name="massage"
                placeholder="সার্ভিসটির মান ও সার্ভিস প্রোভাইডার সম্পর্কে আপনার মতামত লিখুন"
            />
            <a href=""><input type="submit" value="Submit" /></a>
        </div>
    </div>
@endsection
