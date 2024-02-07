@extends('customer.layout.app')
@push('title')  {{ __('All Gig') }} @endpush
@push('head')
    <script src="{{ asset('assets/product-search/jquery-1.10.2.min.js') }}"></script>
    <script src="{{ asset('assets/product-search/jquery-ui.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('assets/product-search/jquery-ui.css') }}">
@endpush
@section('content')

    <!-- Start title -->
    <div>
        <div class="alert alert-primary text-center" role="alert">
            <b>{{ $service->name }}</b>
            <input type="hidden" name="serviceId" id="serviceId" value="{{ $service->id }}">
        </div>
    </div>


    <!-- Start worker's bid of this area-->
    <div class="container">
        <div class="row">
            <div class="col-12 mb-3">
                <div class="row">
                    <div class="col-3">
                        <select class="form-control" name="district" id="district">
                            <option>District</option>
                            @foreach(App\District::all() as $district)
                            <option value="{{$district->id}}">{{$district->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-3">
                        <select class="form-control" name="upazila" id="upazila">
                            <option>Upazila</option>
                            @foreach(App\Upazila::all() as $upazila)
                            <option value="{{$upazila->id}}">{{$upazila->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-3">
                        <select class="form-control" name="pouroshava" id="pouroshava">
                            <option>Puroshova</option>
                            @foreach(App\Puroshova::all() as $pouroshava)
                            <option value="{{$pouroshava->id}}">{{$pouroshava->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-3">
                        <select class="form-control" name="word" id="word">
                            <option>Word</option>
                            @foreach(App\Word::all() as $word)
                            <option value="{{$word->id}}">{{$word->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="col-3">
                        <div class="form-group">
                            
                            <input type="hidden" id="hidden_minimum_price" value="0" />
                            <input type="hidden" id="hidden_maximum_price" value="100" />
                            <p id="price_show">1 - 100000</p>
                            <div id="price_range"></div>
                        </div>    
                    </div>
                    <div class="form-group col-4">
                        <label>{{__('Search by name')}}</label>
                        <input type="text" name="name" placeholder="Enter name" id="name" class="form-control" required="">
                    </div>
                </div>
            </div>
            <div class="col-12 mb-3">
                <div class="row">
                    
                </div>
            </div>
            <div class="col-12 px-0">
                <div class="list-group list-group-flush " id="gigList">
                    
                </div>
            </div>
        </div>
    </div>
    <style>
    #loading
    {
        text-align:center; 
        background: url('{{ asset('assets/images/loader.gif') }}') no-repeat center; 
        height: 150px;
    }
    </style>

    <!-- End worker's bid of this area-->
    
    <script>
        $(document).ready(function() {

            var id = $('#serviceId').val();
            function allGigs(id, name, min_price,max_price,district,upazila,pouroshava,word){
                $.ajax({  
                    url: "{{  url('/search/marketer/gig/byname/') }}/"+id+"/"+name+"/"+min_price+"/"+max_price+"/"+district+"/"+upazila+"/"+pouroshava+"/"+word,
                    type:"GET",
                    dataType : 'html',
                    success:function(data) {
                        var d =$('#gigList').empty();
                        $('#gigList').html(data);
                    },
                });
            }
            allGigs(id,0,0,0,0,0,0,0);

            $('#name').on('keyup', function(e){
                e.preventDefault();
                var name = $('#name').val();
                if (name){
                    allGigs(id,name,0);
                }else{
                    allGigs(id,0,0);
                }
                
            });

            $('#district').on('change', function(e){
                e.preventDefault();
                var district = $('#district').val();
                allGigs(id,0,0,0,district,0,0,0);      
            });

            $('#upazila').on('change', function(e){
                e.preventDefault();
                var upazila = $('#upazila').val();
                allGigs(id,0,0,0,0,upazila,0,0);      
            });

            $('#pouroshava').on('change', function(e){
                e.preventDefault();
                var pouroshava = $('#pouroshava').val();
                allGigs(id,0,0,0,0,0,pouroshava,0);      
            });

            $('#word').on('change', function(e){
                e.preventDefault();
                var word = $('#word').val();
                allGigs(id,0,0,0,0,0,0,word);      
            });

            jQuery.noConflict();
            $('#price_range').slider({
                range:true,
                min:100,
                max:10000,
                values:[1, 10000],
                step:100,
                stop:function(event, ui)
                {
                    $('#price_show').html(ui.values[0] + ' - ' + ui.values[1]);
                    $('#hidden_minimum_price').val(ui.values[0]);
                    $('#hidden_maximum_price').val(ui.values[1]);

                    var min_price = $('#hidden_minimum_price').val();
                    var max_price = $('#hidden_maximum_price').val();

                    allGigs(id,0,min_price,max_price,0,0,0,0);
                }
            });

        });
    </script>
@endsection
