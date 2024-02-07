@foreach($customerGig->workerBids->where('is_selected', '1')->where('worker_id', auth()->user()->id) as $bid)
<div class="bid-area">
    <div class="bid-acont">

        <div class="bid-icon">
            <img src="{{ asset($bid->customerGig->customer->image ?? 'uploads/images/defaults/user.png') }}" alt="">
        </div>

        <div class="bid-tittle">
            <div class="bid-cont">
                <h2>{{ $bid->customerGig->customer->full_name }}</h2>
                @php
                    $percent = 100 - (($bid->customerGig->customer->rating->max_rate - $bid->customerGig->customer->rating->rate)/$bid->customerGig->customer->rating->max_rate)*100;
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
                <p><span><i class="fa-regular fa-star"></i></span> {{ $star }} (2)</p>
            </div>
        </div>

        <div class="bid-icon bi"><i onclick="window.location.href='{{ $customerGig->customer->location }}'" class="fa-solid fa-location-dot location"></i></div>
    </div>


    <div class="calling-area">

        <div class="calling-right">
            <span><i class="fa-solid fa-phone"></i></span>
        </div>
        <div class="calling-left">
            <h4>Start voice call</h4>
            <p>{{ $bid->customerGig->customer->phone }}</p>
        </div>


    </div>


    <div class="price-change">
        <h2>প্রয়োজন অনুযায়ী প্রাইস পরিবর্তন করুন</h2>
        <input type="hidden" id="bid-id" value="{{ $bid->id }}">
        <input type="text" id="budget" name="price" placeholder="250">
        <input type="submit" value="Submit">
    </div>

    @if ($bid->proposed_budget)
        <div class="col-auto">
            <div class="alert alert-success text-center"> <i class="fa fa-exclamation-circle text-danger"></i>  আপনার প্রত্যাশিত নতুন প্রাইস {{ $bid->proposed_budget }} টাকা Pending এ রয়েছে। কাস্টমার কর্তৃক Accept এর জন্য অপেক্ষা করুন।</div>
        </div>
    @endif



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
            <p>{!! $bid->customerGig->description !!} </p>
            <h2>Address</h2>
            <p>{{ $bid->customerGig->address }}</p>
        </div>

    </div>


    <div class="bid-time-count">
        <div class=" db-t">
            <h2>ডেলিবারি</h2>
            <h2> টাইম</h2>
        </div>
        <div>
            <p>{{ $bid->customerGig->day }}</p>
        </div>
        <div>
            <h2>ঘন্টা</h2>
        </div>

    </div>






    <div class="bid-mini">
        <p>অর্ডারটি শুরু করার সম্ভাব্য তারিখ ও সময়:
            {{  date('h:i a', strtotime($customerGig->time)) }}, {{  date('d F Y', strtotime($customerGig->date)) }} </p>
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
@endforeach
