@extends('worker.gig.index')

@section('gig_content')
    @if (auth()->user()->membership)
        @if (!App\WorkerPage::where('worker_id', auth()->user()->id)->exists())
            @else
            <div class="my-container back-color-1">
                <div class="back-color">
                    @if(auth()->user()->membership && !auth()->user()->membershipActive)
                        <p>Your Membership is Expired For Page Please Update Your Package!</p>
                    @else
                        <p>Your Membership is Running For Page</p>
                    @endif
                </div>
            </div>
        @endif
    @else
        <div class="my-container back-color-1">
            <div class="back-color">
                <p>Please Buy a Membership Package to create or see pages</p>
            </div>
        </div>
    @endif


    <div class="order-area">
        @if (auth()->user()->membership)
            @foreach(auth()->user()->workerPages as $page)
                <div class="service-area">
                    <div class="service-up">
                        <div class="service-left">
                            <h2>{{ $page->name }}</h2>
                            <p>Created</p>
                            <p>{{ date('h:i a d/m/y', strtotime($page->created_at)) }}</p>
                        </div>
                        <div class="service-right">
                            <h4>.</h4>
                            @if(auth()->user()->membership && !auth()->user()->membershipActive)
                                <h4>Inactive</h4>
                            @else
                                <h4>{{ ($page->status == 1) ? "Active": "Page is Under Review" }}</h4>
                            @endif
                        </div>

                        <div class="service-right">
                            <h4>{{ $page->click }}</h4>
                            <h4>Clicks</h4>
                        </div>
                    </div>

                    <div class="service-foot">
                        <a href="{{ route('worker.showWorkerPage', \Illuminate\Support\Facades\Crypt::encryptString($page->id)) }}">View Details</a>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
@endsection
