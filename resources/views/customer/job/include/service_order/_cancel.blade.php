<div class="bid-area">
    <div class="bid-acont-cancel">
        <div class="bid-icon">
            <img src="{{ asset($serviceBid->customer->image ?? 'uploads/images/defaults/user.png') }}" alt="">
        </div>
        <div class="bid-tittle">
            <div class="bid-cont">
                <h2>{{ App\WorkerPage::where('worker_id', $serviceBid->worker_id)->first()->name }}</h2>
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
    <div class="cancel-date">
        <p>Cancel date: {{ date('h:i:s a d/m/y', strtotime($serviceBid->updated_at)) }}</p>
    </div>

    <div class="bid-mini">
        <p>অর্ডারটি শুরু করার সম্ভাব্য তারিখ ও সময়: {{  date('h:i a', strtotime($serviceBid->time)) }}, {{  date('d F Y', strtotime($serviceBid->date)) }}</p>
    </div>
</div>
