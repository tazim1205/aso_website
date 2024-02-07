<div class="bid-area">
    <div class="bid-acont-cancel">
        <div class="bid-icon">
            <img src="{{ asset($customerGig->customer->image ?? 'uploads/images/defaults/user.png') }}" alt="">
        </div>
        <div class="bid-tittle">
            <div class="bid-cont">
                <h2>{{ $customerGig->customer->full_name }}</h2>
            </div>
        </div>
    </div>





    <div class="box-area">

        <div class="box-head">
            <div class="box-left">
                <h3>Price</h3>
                <p>$ {{ $customerGig->budget }}</p>
            </div>
            <div class="box-right">
                <h3>Code:</h3>
                <p>#AO{{  $customerGig->id }}</p>
            </div>
        </div>

        <div class="box-foot">
            <h2>Title</h2>
            <p>{{ $customerGig->title }}</p>
            <h2>Details</h2>
            <p>{!! $customerGig->description !!}</p>
            <h2>Address</h2>
            <p>{{ $customerGig->address }}</p>
        </div>

    </div>
    <div class="cancel-date">
        <p>Cancel date: {{ date('h:i:s a d/m/y', strtotime($customerGig->workerBids->where('worker_id', auth()->user()->id)->first()->updated_at)) }}</p>
    </div>


    <div class="bid-mini">
        <p>অর্ডারটি শুরু করার সম্ভাব্য তারিখ ও সময় ছিল:
            {{  date('h:i a', strtotime($customerGig->time)) }}, {{  date('d F Y', strtotime($customerGig->date)) }} </p>
    </div>

</div>
