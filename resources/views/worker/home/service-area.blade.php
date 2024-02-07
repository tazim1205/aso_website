@extends('worker.layout.app')
@push('title')  {{ __('My Service Area') }} @endpush
@push('head')

@endpush
@section('content')

    <!-- Start title -->
    <div class="container text-center">
        <button type="button" class="mb-2 btn btn-success mt-4">{{ __('Service Area Filter') }}</button>
    </div>
    

    <!-- Start worker's bid of this area-->
    <div class="container">
        <div class="row">
            <div class="col-12 px-0 text-center">
                <form action="{{ route('worker.changeArea') }}" method="POST" class="">
                    @csrf
                    <div class="row">
                        <div class="col-lg-4"></div>
                        <div class="col-lg-4 form-group mt-3">
                            <select class="form-control" name="district_id" id="district_id" required="">
                                <option value="">{{ __('Select District') }}</option>
                                @foreach($district as $row)
                                <option value="{{ $row->id }}" <?php if ($row->id == $user->district_id) {
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
                                <option value="{{ $row->id }}" <?php if ($row->id == $user->upazila_id) {
                                    echo "selected";
                                } ?> >{{ __($row->name) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-4"></div>
                    </div>
                    <div class="row" id="pouroshava_area_div">
                        @foreach($puroshova as $row)
                        <div class="col-lg-4"></div>
                        <div class="col-lg-4 mt-3">
                            <div class="d-flex justify-content-between bg-success p-2" style="border-radius: 5px;">
                                <div class="text-light text-capitalize">
                                    {{ __($row->name) }}
                                </div>
                                <div class=" text-light">
                                   {{ __('All') }}
                                   <input type="checkbox" name="all[]" value="{{ $row->id }}">
                                </div>
                            </div>
                            <div class="mt-1" style="border-radius: 5px;border: 1px solid #00bb32;">   
                                 @php
                                $words = DB::table('words')->where('puroshova_id', $row->id)
                                                    ->get();
                                @endphp
                                @foreach($words as $w)
                                <div class="d-flex justify-content-between p-2" >
                                    <div class="text-capitalize" style="color: #027321;">
                                       {{ __($w->name) }}
                                    </div>
                                    <div class=" text-success">
                                        @if(in_array($w->id, $userword))
                                        <input type="checkbox" name="word_road_id[]" id="" checked="" value="{{ $w->id }}">
                                        @else
                                        <input type="checkbox" name="word_road_id[]" id="" value="{{ $w->id }}">
                                        @endif
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="col-lg-4"></div>
                        @endforeach
                    </div>

                    <div class="row">
                        <div class="col-lg-4"></div>
                        <div class="col-lg-4 form-group mt-3">
                            <button type="submit" class="btn btn-success">Save Change</button>
                        </div>
                        <div class="col-lg-4"></div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End worker's bid of this area-->

    <script type="text/javascript">
        $(document).ready(function() {
            $('select[name="district_id"]').on('change', function(){
                var district_id = $(this).val();
                if(district_id) {
                    $.ajax({
                        url: "{{  url('/get/district/upazila/') }}/"+district_id,
                        type:"GET",
                        dataType:"json",
                        success:function(data) {
                            var d =$('select[name="upazila_thana_id"]').empty();
                            $.each(data, function(key, value){
                               $('select[name="upazila_thana_id"]').append('<option value="'+ value.id +'">' + value.name + '</option>');
                            });
                        },
                        
                    });
                } else {
                    alert('danger');
                }
            });

            $('select[name="upazila_thana_id"]').on('change', function(){
                var upazila_thana_id = $(this).val();
                if(upazila_thana_id) {
                    $.ajax({
                        url: "{{  url('/get/pouroshava/word/') }}/"+upazila_thana_id,
                        type:"GET",
                        dataType : 'html',
                        success:function(data) {
                            var d =$('#pouroshava_area_div').empty();
                            $('#pouroshava_area_div').html(data);
                        },
                        
                    });
                } else {
                    alert('danger');
                }
            });

            $('select[name="pouroshava_union_id"]').on('change', function(){
                var pouroshava_union_id = $(this).val();
                if(pouroshava_union_id) {
                    $.ajax({
                        url: "{{  url('/get/pouroshava-union/word-road/') }}/"+pouroshava_union_id,
                        type:"GET",
                        dataType:"json",
                        success:function(data) {
                            var d =$('select[name="word_road_id"]').empty();
                            $.each(data, function(key, value){
                               $('select[name="word_road_id"]').append('<option value="'+ value.id +'">' + value.name + '</option>');
                            });
                        },
                        
                    });
                } else {
                    alert('danger');
                }
            });
        });

    </script>
@endsection
