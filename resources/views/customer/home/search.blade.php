@extends('customer.layout.app')
@push('title')  {{ __('Search Result') }} @endpush
@push('head')
    <link href="{{ asset('assets/css/icons.css') }}" rel="stylesheet" type="text/css"/>
    <style type="text/css">
        .service_btn {
            font-weight: 700;
            border: 1px solid #2BB34B;
            border-radius: 10px !important;
        }
    </style>
@endpush
@section('content')

    <!-- Start title -->
    <div>
        <div class="alert alert-primary text-center" role="alert">
            <b>{{ __('Search Result') }}</b>
        </div>
        
    </div>


    <!-- Start worker's bid of this area-->
    <div class="container">
        <div class="row mb-2">
            <div class="col-4 text-center">
                <button id="gig-btn" type="button" class="service_btn mb-2 w-100 btn ">{{ __('গিগ') }}
                </button>
            </div>
            <div class="col-4 text-center">
                <button id="service-btn" type="button" class="service_btn mb-2 w-100  btn ">{{ __('সার্ভিস ') }}
                </button>
            </div>
            <div class="col-4 text-center">
                <button id="page-btn" type="button" class="service_btn mb-2 w-100  btn ">{{ __('পেইজ ') }}
                </button>
            </div>
            
        </div>    
        <div class="row" id="gig_area">
            <div class="col-12 px-0">
                <div class="row mt-3" id="gig_list_area">
                    @foreach($gigs as $gig)
                        @if($gig->status == 1)
                            @php
                            $check = false;
                            $worker = App\User::find($gig->worker_id);

                            $Word = $worker->word_road_id;
                            $workerWord = explode(',', $Word);
                            @endphp
                            @if ($Word != NULL)
                                @php
                                foreach ($workerWord as $w) {
                                    if ($w == auth()->user()->word_road_id) {
                                        $check = true;
                                    }
                                }
                                @endphp
                                @if ($check == true)
                                    <div class="col-lg-3 col-6 mb-1">
                                        <div class="card pt-2 pb-2" style="background-image: url('{{ asset($gig->thambline_photo) }}' );height: 170px; background-position: cover;">
                                            <div class="" style="margin-top: 113px;">
                                                <div class="d-flex justify-content-between">
                                                    <div class="">
                                                        <span class="badge badge-success">৳ {{ $gig->budget }}</span><br>
                                                        <span class="badge badge-success"><i class="fa fa-clock"></i> {{ $gig->day }} Hours</span>
                                                    </div>
                                                    <div class="text-right">
                                                        <span class="text-right text-warning"><i class="fa fa-star"></i>
                                                        @php
                                                        $percent = 100 - (($worker->rating->max_rate - $worker->rating->rate)/$worker->rating->max_rate)*100;
                                                        if ($percent>80){
                                                            echo $star = 5;
                                                        }else if ($percent>60){
                                                            echo $star = 4;
                                                        }else if ($percent>40){
                                                            echo $star = 3;
                                                        }else if ($percent>20){
                                                            echo $star = 2;
                                                        }else if ($percent>1){
                                                            echo $star = 1;
                                                        }else{
                                                            echo $star = 0;
                                                        }
                                                        @endphp
                                                       
                                                        ({{ $worker->rating->rateGivenBy }})</span><br>
                                                        <a href="{{ $worker->location }}" target="_blank" class="text-warning p-4"> <i class="fa fa-map-marker"></i> Location</a>
                                                    </div>
                                                   
                                                </div>
                                            </div>
                                        </div>
                                        <figcaption class="figure-caption "><a class="text-primary" href="{{ route('customer.showGigDetail',$gig->id) }}"><b>{{ \Illuminate\Support\Str::limit($gig->title, 80) }}</b></a></figcaption>
                                    </div>
                                @endif
                            @endif
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
        <div class="row" id="page_area">
            <div class="col-12 px-0">
                <div class="row mt-3" id="page_list_area">
                    @foreach($pages as $page)

                        @if ($membership = App\Membership::where('user_id', $page->worker_id)->where('ending_at', '>=', carbon\Carbon::now()->format('Y-m-d H:i:s'))->first())
                            @if ($membership->id == $page->membership_id)

                                    <div class="col-12 col-lg-12" style="border-bottom: 1px solid #e6e6e6;">
                                        <div class="d-flex">
                                            <button class="p-2 w-10 page_id" style="border: 0; background: none" value="{{ $page->id }}">
                                                <a href="{{ route('customer.showPages', $page->id) }}">
                                                    <img src="{{ asset($page->image)}}" class="rounded-circle" alt="Cinque Terre" width="80" height="80">
                                                </a>
                                            </button>
                                            <div class="p-2">
                                                <a href="{{ route('customer.showPages', $page->id) }}">
                                                    <h6 class="m-0">
                                                        {{ Str::of($page->name)->limit(40, '(...)') }}
                                                        <span class="text-right text-warning"><i class="fa fa-star"></i>
                                                            @php
                                                                $sum = App\ServiceReview::where('worker_id', $page->worker_id)->sum('rating');
                                                                $count = App\ServiceReview::where('worker_id', $page->worker_id)->count();
                                                                if (App\ServiceReview::where('worker_id', $page->worker_id)->exists()) {
                                                                    $total_review = $sum/$count;
                                                                }else {
                                                                    $total_review = 0;
                                                                }
                                                                if ($total_review != 0) {
                                                                    echo number_format((float)$total_review, 1, '.', '');
                                                                }
                                                            @endphp
                                                            ({{$count}})
                                                        </span>
                                                    </h6>
                                                </a>
                                                <div>
                                                    <span style="font-size: 15px">{{ Str::of($page->title)->limit(80, '(...)') }}</span>
                                                </div>

                                               </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                            @endif
                        @endif
                    @endforeach
                </div>
            </div>
        </div>

        <div class="container " id="service_area">
            <div class="row mt-3" id="service_list_area">
                @foreach($PageService as $service)
                    <div class="col-lg-12 card shadow border-0 mb-3">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <h5 class="font-weight-normal mb-1"><b>{{ $service->title }}</b></h5>
                                    <div class="row text-center">
                                        <div class="col-5 text-center color-border">
                                            <p class="text text-success mb-2">{{ __('Created') }}</p>
                                            <p class="text-mute small text-secondary mb-2">{{ date('h:i a d/m/y', strtotime($service->created_at)) }}</p>
                                        </div>
                                        <div class="col-3 text-center color-border">
                                            {{-- <p class="text text-success mb-2">{{ App\ServiceBid::where('worker_service_id', $service->id)->where('status', '!=', 'cancelled')->count() }}</p> --}}
                                            <p class="text-mute small text-secondary mb-2">{{ App\ServiceBid::where('worker_service_id', $service->id)->where('status', '!=', 'cancelled')->count() }} {{ __('Orders') }}</p>
                                            <p class="text-mute small text-secondary mb-2">{{ $service->click }}</p>
                                        </div>
                                        <div class="col-3 text-center">
                                            <a class="mb-2 btn btn-lg btn-success view-btn" href="{{ route('customer.showServiceDetail', [$service->page, $service->id]) }}">
                                                <i class="material-icons">visibility</i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <!-- End worker's bid of this area-->
    <script>
        $(document).ready( function () {
           
            $('#page_area').hide();
            $('#service_area').hide();
            $('#gig-btn').addClass("btn-success");

            $('#gig-btn').on('click', function(e){
                $('#gig_area').show();
                $('#page_area').hide();
                $('#service_area').hide();

                $('#gig-btn').addClass("btn-success");

                $('#page-btn').removeClass("btn-success");
                $('#service-btn').removeClass( "btn-success");
            });

            $('#page-btn').on('click', function(e){
                $('#gig_area').hide();
                $('#page_area').show();
                $('#service_area').hide();

                $('#page-btn').addClass( "btn-success");
                
                $('#gig-btn').removeClass( "btn-success" );
                $('#service-btn').removeClass( "btn-success");
            });

            $('#service-btn').on('click', function(e){
                $('#gig_area').hide();
                $('#page_area').hide();
                $('#service_area').show();

                $('#service-btn').addClass( "btn-success");
                
                $('#gig-btn').removeClass( "btn-success" );
                $('#page-btn').removeClass( "btn-success" );
            });

        });
    </script>
@endsection
