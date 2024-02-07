
    <div class="bid-area">
        <div class="bid-acont">
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
                        <span><i class="fa-regular fa-star"></i></span> {{ number_format((float)$total_review, 1, '.', '') }}({{ $count }})
                    </p>
                </div>
            </div>

            <div class="bid-icon bi">
                <i onclick="window.location.href='{{ App\WorkerPage::where('worker_id', $serviceBid->worker_id)->first()->location }}'" class="fa-solid fa-location-dot location"></i>
            </div>
        </div>

        <div class="calling-area">
            <div class="calling-right">
                <span><i class="fa-solid fa-phone"></i></span>
            </div>
            <div class="calling-left">
                <h4>Start voice call</h4>
                <p>{{ App\User::find($serviceBid->worker_id)->phone }}</p>
            </div>
        </div>

        <div class="price-change">
            <h2>প্রয়োজন অনুযায়ী প্রাইস পরিবর্তন করুন</h2>
            <input type="text" name="price" id="budget" placeholder="250" />
            <input type="hidden" id="service-id" value="{{ $serviceBid->id }}">
            <input type="button" value="Submit" data-worker-limit="{{ App\User::worker_bid_gig_limit($serviceBid->worker_id) }}" id="new-price"/>
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

        <div class="bid-mini">
            <p>অর্ডারটি শুরু করার সম্ভাব্য তারিখ ও সময়: {{  date('h:i a', strtotime($serviceBid->time)) }}, {{  date('d F Y', strtotime($serviceBid->date)) }}</p>
        </div>

        <div class="photo-upload">
            <h2><i class="fa-regular fa-image"></i></h2>
            <p>Drop your image here, or <a href="#"> browse</a></p>
        </div>

        <div class="last-btn">
            <input type="submit" onclick="complainNow({{ $serviceBid->id }});" value="Complain" class="complain" />
            <input type="button" id="completed-btn" value="Completed" class="r-area-1" />
        </div>
    </div>

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

