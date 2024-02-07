
    <div class="bid-area">
        <div class="bid-acont dg">
            <div class="bid-icon">
                <img src="{{ asset($serviceBid->customer->image ?? 'uploads/images/defaults/user.png') }}" alt="">
            </div>
            <div class="bid-tittle">
                <div class="bid-cont">
                    <h2>{{ App\WorkerPage::where('worker_id', $serviceBid->worker_id)->first()->name }}</h2>
                    <p>
                        @php
                            $sum = App\ServiceReview::where('worker_id', $serviceBid->worker_id)->sum('rating');
                            $count = App\ServiceReview::where('worker_id', $serviceBid->worker_id)->count();
                            if (App\ServiceReview::where('worker_id', $serviceBid->worker_id)->exists()) {
                                $total_review = $sum/$count;
                            }else {
                                $total_review = 0;
                            }

                            if ($total_review>4.5)
                                $star = 5;
                            else if ($total_review>3.5)
                                $star = 4;
                            else if ($total_review>2.5)
                                $star = 3;
                            else if ($total_review>1.5)
                                $star = 2;
                            else if ($total_review>0.5)
                                $star = 1;
                            else
                                $star = 0;
                        @endphp
                        <span><i onclick="window.href.location='{{ App\WorkerPage::where('worker_id', $serviceBid->worker_id)->first()->location }}'" class="fa-regular fa-star"></i> {{ $star }} ({{ $count }})</span>
                    </p>
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
                    <p>#AO{{ $serviceBid->id }}</p>
                </div>
            </div>

            <div class="box-foot">
                <h2>Title</h2>
                <p>{{ App\PageService::withTrashed()->find($serviceBid->worker_service_id)->title }}</p>
                <h2>Details</h2>
                <p>
                    {!! $serviceBid->description !!}
                </p>
                <h2>Address</h2>
                <p>{{ $serviceBid->address }}</p>
            </div>
        </div>

        <div class="delivary-date">
            <p>{{ __('ডেলিবারি তারিখ') }}: {{ date('h:i:s a d/m/y', strtotime($serviceBid->updated_at)) }}</p>
        </div>

        <div class="bid-mini">
            <p>অর্ডারটি শুরু করার সম্ভাব্য তারিখ ও সময়: {{  date('h:i a', strtotime($serviceBid->time)) }}, {{  date('d F Y', strtotime($serviceBid->date)) }}</p>
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
                    <a href="" data-id="{{ $serviceBid->id }}"><input type="submit" value="Submit" /></a>
                </div>
            </div>
        @endif
    </div>

