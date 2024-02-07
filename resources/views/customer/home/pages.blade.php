@extends('customer.layout.app')
@push('title')  {{ __('Pages') }} @endpush
@push('head')
    <link href="{{ asset('assets/css/icons.css') }}" rel="stylesheet" type="text/css"/>
@endpush
@section('content')

        <!--Start active job detail view -->
        <!-- Start title -->
        <div class="">
            <div class="alert alert-info text-center" role="alert">
                <b id=""> {{ __('Pages') }} </b>
                <input type="hidden" name="" id="gig_id" value="">
            </div>
        </div>
        <!-- End title -->
        <!--Start worker info & price-->
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-12 pt-2 pb-2" id="">
                    <div class="row">
                        <div class="col-12 col-lg-12">
                            <div class="d-flex">
                                <div class="p-2">
                                    <img src="{{ asset($page_details->image ?? 'uploads/images/defaults/user.png') }}" class="rounded-circle" alt="Cinque Terre" width="100" height="100">
                                </div>
                                <div class="">
                                    <h6 class="m-0" style="text-transform: capitalize">{{ $page_details->name }} </h6>
                                    <span class="text-right text-warning"><i class="fa fa-star"></i>
                                    @php
                                        $sum = App\ServiceReview::where('worker_id', $page_details->worker_id)->sum('rating');
                                        $count = App\ServiceReview::where('worker_id', $page_details->worker_id)->count();
                                        if (App\ServiceReview::where('worker_id', $page_details->worker_id)->exists()) {
                                            $total_review = $sum/$count;
                                        }else {
                                            $total_review = 0;
                                        }
                                        if ($total_review != 0) {
                                            
                                            echo number_format((float)$total_review, 1, '.', '');
                                        }
                                    @endphp
                                    ({{$count}})</span><br>
                                    <a href="{{ $page_details->location }}" target="_blank" class="badge badge-success text-white"><i class="material-icons" style="font-size: 13px">edit_location</i>{{ "  " }}Location</a></br>
                                    @if ($page_details->phone)
                                    <a href="tel:{{ $page_details->phone }}" class="badge badge-success text-white"><i class="material-icons" style="font-size: 13px;">local_phone</i> {{ $page_details->phone }}</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 col-12 pt-2 pb-2 text-center">
                            <figcaption class="figure-caption " style="color: #00BB32; text-transform: capitalize"><b>{{ \Illuminate\Support\Str::limit($page_details->title, 80) }}</b></figcaption>
                            <hr>
                        </div>
                        @if ($page_details->description)
                        <div class="col-lg-12 col-12 pt-2 pb-2">
                            <div class="show-read-more"><?=$page_details->description?></div>
                        </div>
                        @endif
                        
                    </div>
                </div>
                <div class="col-lg-12 col-12 pt-2 pb-2">
                    @if ($page_details->address)
                    <div class="text-black">
                        <span style="background: rgba(0, 0, 0, 0.05); border-radius: 10px" class="p-3"><strong>Address: </strong> {{ $page_details->address }}</span>
                    </div>
                    @endif
                </div>
                <div class="col-lg-12 col-12 pt-2 pb-2" id="">
                    <div class="row">
                        <div class="col-12 col-lg-12 text-center mb-2">
                            <button class="btn btn-success">Services / Products</button>
                        </div>
                        <div class="col-12 col-lg-12">
                            <div class="row">
                                @foreach (Str::of($page_details->worker_services)->explode(',') as $service)
                                    @if (App\PageService::find($service) && App\PageService::find($service)->status == 'active')
                                        <div class="col-lg-3 col-6 mb-1">
                                            <div class="card pt-2 pb-2" style="background-image: url('{{ asset(App\PageService::find($service)->cover_photo) }}');height: 170px;background-size: cover; background-position: center;">
                                                <div class="" style="margin-top: 113px;">
                                                    <div class="d-flex justify-content-between">
                                                        <div class="">
                                                            <span class="badge badge-success">৳ {{ App\PageService::find($service)->budget }}</span><br>
                                                            <span class="badge badge-success"><i class="fa fa-clock"></i> {{ App\PageService::find($service)->day }}</span>
                                                        </div>
                                                        <div class="text-right">
                                                            <br>
                                                            <span class="text-right text-warning"><i class="fa fa-star"></i>
                                                            @php
                                                                $sum = App\ServiceReview::where('worker_service_id', $service)->sum('rating');
                                                                $count = App\ServiceReview::where('worker_service_id', $service)->count();
                                                                if (App\ServiceReview::where('worker_service_id', $service)->exists()) {
                                                                    $total_review = $sum/$count;
                                                                }else {
                                                                    $total_review = 0;
                                                                }
                                                                echo number_format((float)$total_review, 1, '.', '');
                                                            @endphp
                                                            ({{ $count }})</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <figcaption class="figure-caption ">
                                                <button class="service_id" style="border: 0; background: none" value="{{ $service }}">
                                                    <a class="text-primary" href="{{ route('customer.showServiceDetail', [$page_details->id, $service]) }}"><b>{{ \Illuminate\Support\Str::limit(App\PageService::find($service)->title, 80) }}</b></a>
                                                </button>
                                            </figcaption>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div> 
        </div>
            
<script>
        $(document).ready(function() {
            $('.service_id').on('click', function(){
                var service_id = $(this).val();
                // alert(service_id);
                $.ajax({
                    method: 'POST',
                    url: "{{ route('customer.serviceClick') }}",
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    data: {service_id:service_id},
                    // processData: false,
                    // contentType: false,
                    success: function (data) {
                        // alert(data);
                    }
                })
            });
        });
    </script>

@endsection
