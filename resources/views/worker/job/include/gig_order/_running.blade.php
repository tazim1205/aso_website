<div class="bid-area">
    <div class="bid-acont">

        <div class="bid-icon"> <img src="{{ asset($customerBid->customer->image ?? 'uploads/images/defaults/user.png') }}"
                                    alt=""></div>

        <div class="bid-tittle">
            <div class="bid-cont">
                <h2>{{ $customerBid->customer->full_name }}</h2>
                @php
                    $percent = 100 - (($customerBid->customer->rating->max_rate -
                    $customerBid->customer->rating->rate)/$customerBid->customer->rating->max_rate)*100;
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
                <p><span><i class="fa-regular fa-star"></i></span> {{ $star }} (5)</p>
            </div>
        </div>

        <div class="bid-icon bi"><i onclick="window.location.href='{{ $customerBid->customer->location }}'" class="fa-solid fa-location-dot location"></i></div>
    </div>


    <div class="calling-area">

        <div class="calling-right">
            <span><i class="fa-solid fa-phone"></i></span>
        </div>
        <div class="calling-left">
            <h4>Start voice call</h4>
            <p>{{ $customerBid->customer->phone }}</p>
        </div>


    </div>


    <div class="price-change">
        <h2>প্রয়োজন অনুযায়ী প্রাইস পরিবর্তন করুন</h2>
        <input type="hidden" id="bid-id" value="{{ $customerBid->id }}">
        <input type="text" name="price" placeholder="250" id="budget">
        <input type="submit" value="Submit">
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
        <div class="row p-4">
            <div class="col-6">
                <div class="d-flex align-items-center pt-2 pb-2">
                    <strong>Verification Number: &nbsp;&nbsp;</strong>
                    <div>{{ $customerBid->otp_code }}</div>
                </div>
            </div>
            <div class="col-12">
                <div class="d-flex pt-2 pb-2">
                    <strong>Worker Name: </strong>&nbsp;&nbsp;
                    <div class="d-flex justify-content-between">
                        <div>{{ $customerBid->worker->name ?? '' }}</div>
                        <div>
                            <div class="input-group">
                                <input type="text" class="form-control" id="phone"
                                       placeholder="phone" readonly
                                       value="{{ $customerBid->worker->phone ?? '' }}">
                                <div class="input-group-prepend">
                                    <a href="tel:{{ $customerBid->worker->phone ?? '' }}">
                                                            <span
                                                                class="input-group-text bg-success text-white dz-clickable"
                                                                onclick="" id="phone">{{ __('Call')
                                                                }}</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="box-foot">
            <h2>Title</h2>
            <p>{!! $customerBid->workerGig->title !!}</p>
            <h2>Details</h2>
            <p>{!! $customerBid->description !!}</p>
            <h2>Address</h2>
            <p>{{ $customerBid->address }}</p>
        </div>

    </div>


    <div class="bid-time-count">
        <div class=" db-t">
            <h2>ডেলিবারি</h2>
            <h2> টাইম</h2>
        </div>
        <div>
            <p>{{ $customerBid->workerGig->day }}</p>
        </div>
        <div>
            <h2>ঘন্টা</h2>
        </div>

    </div>






    <div class="bid-mini">
        <p>অর্ডারটি শুরু করার সম্ভাব্য তারিখ ও সময়:
            {{ date('h:i a', strtotime($customerBid->time)) }}, {{ date('d F Y', strtotime($customerBid->date)) }} </p>
    </div>



    <div class="photo-upload">
        <h2><i class="fa-regular fa-image"></i></h2>
        <p>Drop your image here, or <a href="#"> browse</a></p>

    </div>

    <div class="last-btn">
        <input type="submit" value="Complain" class="complain">
        <input type="submit" value="Completed" class="r-area-1">
    </div>

</div>

<div class="my-container pop-12">

    <div class="pop-up-1">
        <div class="pop-up-inner">
            <h2>আপনার অভিযোগ লিখুন</h2>
            <input type="text" placeholder="অর্ডার কোড সহ আপনার অডিযোগের বিস্তারিত লিখুন...">
        </div>

        <div class="last-btn pop-up-btn">
            <input type="submit" value="Cancel" class="cancel">
            <input type="submit" value="Submit">
        </div>

    </div>


</div>
