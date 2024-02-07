@extends('marketer.layout.app')
@push('title')  {{ __('Gig') }} @endpush
@push('head')
    <style>
        .color-border{
            border-style: solid;
            border-width: thin;
            border-color: white;
            border-radius: 5px;
            margin-left: 5px;
            padding: 10px;
        }
        .view-btn{
            margin-left: -10px;
            height: 100%;
        }
    </style>
@endpush
@section('content')

        <!--Start active job detail view -->
        <!-- Start title -->
            <div class="">
                <div class="alert alert-info text-center" role="alert">
                    <b id=""> {{ __('Gig') }} </b>
                </div>
            </div>
            <!-- End title -->
            <!--Start worker info & price-->
            <div class="container worker-profile">
                <div class="card bg-info shadow mt-4 h-190">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-auto">
                                <figure class="avatar avatar-60"><img class="worker-profile-image" src="{{ asset('uploads/images/users/'.$gig->worker->image) }}" alt=""></figure>
                            </div>
                            <div class="col pl-0 align-self-center">
                                <h5 class="mb-1">{{ $gig->worker->full_name }}</h5>
                                <div class="col-auto pl-0">
                                    <p class="small text-mute text-trucated mt-1">
                                        
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container top-100">
                <div class="card mb-4 shadow">
                    <div class="card-body border-bottom">
                        <div class="row">
                            <div class="col">
                                <h3 class="mb-0 font-weight-normal"> {{ __('Price') }} ৳ </h3>
                            </div>
                            <div class="col-auto">
                                <button disabled class="btn btn-info btn-rounded-54 shadow" data-toggle="modal" data-target="#addmoney"> <b>{{ $gig->budget }}</b> </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-none">
                        <div class="row">
                            <div class="col">
                                <p class="gig-title"><b>{{ $gig->title }}</b></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--End gig info & price-->
            <!--Start work detail , address, day-->
            <div class="container">
                <h4 class="mb-3">
                    <b> {{ __('Details') }}:</b>
                </h4>
                <div>{!! $gig->description !!}</div>
                <div class="btn-group btn-group-lg btn-group w-100 mb-2 text-center" role="group" aria-label="Basic example">
                    <button disabled type="button" class="btn btn-outline-success active"><small>{{ __('Time') }} </small>{{ $gig->day }}<small> {{ __('Day') }}</small></button>
                    <button id="" onclick="window.location.href='{{ route('customer.showGigOrderForm', \Illuminate\Support\Facades\Crypt::encryptString($gig->id)) }}'" type="button" class="btn btn-success">{{ __('Order Now') }}</button>
                </div>
            </div>
            <!--End work detail , address, day-->
            <hr>

            <!--Start work detail , address, day-->
            <div class="container">
                <h4 class="mb-3">
                    <b> 
                        @if(Auth::user()->affiliate_user != null && Auth::user()->affiliate_user->status)
                        @php
                            if(Auth::check()){
                                if(Auth::user()->referral_code == null){
                                    Auth::user()->referral_code = substr(Auth::user()->id.Str::random(10), 0, 10);
                                    Auth::user()->save();
                                }
                                $referral_code = Auth::user()->referral_code;
                                $referral_code_url = URL::to('/marketer/gig-details').'/'.$gig->id."?gig_referral_code=$referral_code";
                            }
                        @endphp
                        <div>
                            <p id="success" class="text-warning"><p>
                            <button type=button id="ref-cpurl-btn" class="btn btn-sm btn-success" data-attrcpy="{{ __('Copied') }}" onclick="CopyToClipboard(this)" data-url="{{$referral_code_url}}">{{ __('Copy the Promote Link') }}</button>
                        </div>
                        @endif
                  </b>
                </h4>
                 
              
            </div>
            <!--End work detail , address, day-->
            <hr>
            
     
 
<script>
      function CopyToClipboard(e) {
            var url = $(e).data('url');
            var $temp = $("<input>");
            $("body").append($temp);
            $temp.val(url).select();
            try {
                document.execCommand("copy"); 
                document.getElementById('success').innerHTML = "Copied";
            } catch (err) {
               
            }
            $temp.remove();
           
        }
</script>

@endsection
