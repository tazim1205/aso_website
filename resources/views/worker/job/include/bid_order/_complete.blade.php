@foreach($customerGig->workerBids->where('is_selected', '1')->where('worker_id', auth()->user()->id) as $bid)
<div class="bid-area">
    <div class="bid-acont dg">
        <div class="bid-icon">
            <img src="{{ asset($bid->customerGig->customer->image?? 'uploads/images/defaults/user.png') }}" alt="">
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
                <p><span><i class="fa-regular fa-star"></i> {{ $star }}(2)</span></p>
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
                <p>#AO{{  $bid->id }}</p>
            </div>
        </div>

        <div class="box-foot">
            <h2>Title</h2>
            <p>{!! $bid->description !!}</p>
            <h2>Details</h2>
            <p>{!! $bid->customerGig->description !!}</p>
            <h2>Address</h2>
            <p>{{ $bid->customerGig->address }}</p>
        </div>

    </div>

    <div class="delivary-date">
        <p>Delivery date:{{ date('h:i:s a d/m/y', strtotime($customerGig->updated_at)) }}</p>
    </div>


    <div class="bid-mini">
        <p>অর্ডারটি শুরু করার সম্ভাব্য তারিখ ও সময়:
            {{  date('h:i a', strtotime($customerGig->time)) }}, {{  date('d F Y', strtotime($customerGig->date)) }} </p>
    </div>

</div>
@endforeach
