@extends('guest.layout')
@push('title')  {{ __('Chane Area') }} @endpush
@push('head')
    <link href="{{ asset('assets/css/icons.css') }}" rel="stylesheet" type="text/css"/>
@endpush
@section('content')

    <!-- Start title -->
    <div class="container text-center">
        <button type="button" class="mb-2 btn btn-success mt-4">{{ __('Select Your Area') }}</button>
    </div>


    <!-- Start worker's bid of this area-->
    <div class="container">
        <div class="row">
            <div class="col-12 px-0 text-center">
                <form action="{{ route('store.area') }}" method="POST" class="row">
                    @csrf
                    <div class="col-lg-4"></div>
                    <div class="col-lg-4 form-group mt-3">
                        <select class="form-control" name="district_id" id="district_id" required="">
                            <option value="">{{ __('Select District') }}</option>
                            @foreach($district as $row)
                            <option value="{{ $row->id }}" <?php if ($row->id == Cookie::get('guest_district')) {
                                echo "selected";
                            } ?> >{{ __($row->name) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-4"></div>
                    <div class="col-lg-4"></div>
                    <div class="col-lg-4 form-group mt-3">
                        <select class="form-control" name="upazila_thana_id" id="upazila_thana_id" required="">
                            <option value="">{{ __('Select Upazila / Thana') }}</option>
                            @foreach($upazila as $row)
                            <option value="{{ $row->id }}" <?php if ($row->id == Cookie::get('guest_upazila')) {
                                echo "selected";
                            } ?> >{{ __($row->name) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-4"></div>
                    <div class="col-lg-4"></div>
                    <div class="col-lg-4 form-group mt-3">
                        <select class="form-control" name="pouroshava_union_id" id="pouroshava_union_id" required="">
                            <option value="">{{ __('Select Pouroshava / Union') }}</option>
                            @foreach($puroshova as $row)
                            <option value="{{ $row->id }}" <?php if ($row->id == Cookie::get('guest_puroshova')) {
                                echo "selected";
                            } ?> >{{ __($row->name) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-4"></div>
                    <div class="col-lg-4"></div>
                    <div class="col-lg-4 form-group mt-3">
                        <select class="form-control" name="word_road_id" id="word_road_id" required="">
                            <option value="">{{ __('Select Ward / Road') }}</option>
                            @foreach($word as $row)
                            <option value="{{ $row->id }}" <?php if ($row->id == Cookie::get('guest_word')) {
                                echo "selected";
                            } ?> >{{ __($row->name) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-4"></div>
                    <div class="col-lg-4"></div>
                    <div class="col-lg-4 form-group mt-3">
                        <button type="submit" class="btn btn-success">Save Change</button>
                    </div>
                    <div class="col-lg-4"></div>
                </form>
            </div>
        </div>
    </div>
    <!-- End worker's bid of this area-->

    <script type="text/javascript">
       

    </script>
@endsection
