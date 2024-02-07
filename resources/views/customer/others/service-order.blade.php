@extends('customer.layout.app')
@push('title') {{ __('Special service order') }} @endpush
@push('head')

@endpush
@section('content')
    <div class="wrapper homepage">
        <!-- header -->
        
        <div>
            <div class="alert alert-primary text-center" role="alert">
                <b>{{ $service->name }}</b>
            </div>
        </div>


        <!-- Start worker's bid of this area-->
        <div class="container">
            <div class="row text-center">
                <div class="col-md-6 col-xl-3 col-lg-3"></div>
                <div class="col-md-6 col-xl-6 col-lg-6">
                    <div class="card shadow border-0 mb-3">
                        <div class="card-body">
                            <button class="btn btn-md btn-success m-2">{{ $service->name }}</button><br>
                            <div class="btn-group btn-group-sm btn-group w-100 mt-2 mb-2 text-center" role="group" aria-label="Basic example">
                                <button disabled="" type="button" class="btn btn-outline-success active" style="border-radius: 0px;"><small> {{ $service->phone }} </small></button>
                                <a href="tel:{{ $service->phone }}" class="btn btn-success" style="border-radius: 0px;"> {{ __('Call Now') }}</a>
                            </div>
                            <div class="avatar avatar-60 no-shadow border-0 mt-2 mb-2">
                                <div class="overlay"></div>
                                <figure class="avatar avatar-60 border-0">
                                    <img src="{{ asset($service->image ?? 'uploads/images/defaults/user.png') }}" alt="" height="70px" width="70px">
                                </figure>
                            </div>
                            <p class="mt-3 mb-3 font-weight-bold">{{__('অর্ডার ফরম পূরণ করে সার্ভিস ফী পরিশোধ করুন')}}</p>
                            <form action="{{ route('customer.storeSpeacialService') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <textarea id="details" name="details" class="form-control" rows="4" placeholder="বিবরণ" style="border-radius: 12px;" required=""></textarea>
                                </div>
                                <div class="form-group">
                                    <input type="text" name="address" id="address" class="form-control" placeholder="ঠিকানা" required="">
                                </div>
                                <div class="form-group">
                                    <input type="file" name="image" id="image" class="form-control" required="">
                                </div>
                                <div class="form-group">
                                    <input type="text" name="transaction_id" id="transaction_id" class="form-control" placeholder="লেনদেন নং" required="">
                                </div>
                                <div class="form-group">
                                    <input type="text" name="fee" id="fee" class="form-control" placeholder="নির্ধারিত ফি" required="">
                                </div>
                                <div class="form-group">
                                    <input type="hidden" name="id" value="{{ $service->id }}">
                                    <button type="submit" class="btn btn-success">ফী পরিশোধ করুন</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-xl-3 col-lg-3"></div>
            </div>
        </div>
    </div>

    <script>
    </script>
@endsection
