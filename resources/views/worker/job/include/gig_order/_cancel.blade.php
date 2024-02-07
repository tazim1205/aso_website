<div class="bid-area">
    <div class="bid-acont-cancel">
        <div class="bid-icon"><img
                src="{{ asset($customerBid->customer->image ?? 'uploads/images/defaults/user.png') }}"
                alt=""></div>
        <div class="bid-tittle">
            <div class="bid-cont">
                <h2>{{ $customerBid->customer->full_name }}</h2>
            </div>
        </div>
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
            <p>{!! $customerBid->description !!}</p>
            <h2>Address</h2>
            <p>{{ $customerBid->address }}</p>
        </div>

    </div>
    <div class="cancel-date">
        <p>Cancel date: {{ date('h:i:s a d/m/y', strtotime($customerBid->updated_at)) }}</p>
    </div>


    <div class="bid-mini">
        <p>অর্ডারটি শুরু করার সম্ভাব্য তারিখ ও সময় ছিল:
            {{ date('h:i a', strtotime($customerBid->time)) }}, {{ date('d F Y', strtotime($customerBid->date)) }} </p>
    </div>

</div>
