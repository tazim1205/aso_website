@extends('customer.layout.master')
@push('title')  {{ __($service->name) }} @endpush

@section('content')
    <input type="hidden" name="" id="service_id" value="{{ $service->id }}">
@include('customer.home.include._gig_nav')
@include('customer.home.include._gig')
@include('customer.home.include._page')

<div class="pop-up-2 pop-up-2-b">
    <div class="pop-up-2-up">
        <div class="pop-up-2-cont">
            <label for=""><p>Min.</p></label>
            <input type="text" placeholder="৳" name="min_budget" id="min_budget">
            <div class="pop-up-radio">
                <div class="pop-up-in"><input type="radio" ></div>
                <div class="pop-up-la" id="high" name="budget" value="High To Low"> <label for=""><p>High To Low</p></label></div>
            </div>

        </div>
        <div class="pop-up-2-cont">
            <label for=""><p>Max.</p></label>
            <input type="text" placeholder="৳" name="max_budget" id="max_budget">
            <div class="pop-up-radio">
                <div class="pop-up-in"><input type="radio" ></div>
                <div class="pop-up-la" id="low" name="budget" value="Low To High"> <label for=""><p>High To Low</p></label></div>
            </div>
        </div>

    </div>
    <div class="pop-up-2-down pop-up-2-as">
        <button id="budget_apply_btn">Apply</button>
    </div>
</div>
</div>

<div class="pop-up-2 pop-up-d">
    <div class="pop-up-2-up">
        <div class="pop-up-2-cont pop-up-2-full">
            <label for=""><p>Up to</p></label>
            <input type="text" placeholder="" name="delivery_time" id="delivery_time">
        </div>
    </div>
    <div class="pop-up-2-down pop-up-2-c">
        <button id="delivery_time_btn">Apply</button>
    </div>
</div>



<div class="w-pop-up w-pop-up-1">

    <div class="w-pop-up-content rating-1">
        <div class="w-pop-up-left"><h3>রেটিং</h3></div>
        <div class="w-pop-up-right"><input type="radio" name="" id=""></div>
    </div>

    <div class="w-pop-up-content">
        <div class="w-pop-up-left"><h3>Up to 1</h3></div>
        <div class="w-pop-up-right"><input type="radio" name="" id=""></div>
    </div>

    <div class="w-pop-up-content">
        <div class="w-pop-up-left"><h3>Up to 1.5</h3></div>
        <div class="w-pop-up-right"><input type="radio" name="" id=""></div>
    </div>

    <div class="w-pop-up-content">
        <div class="w-pop-up-left"><h3>Up to 2</h3></div>
        <div class="w-pop-up-right"><input type="radio" name="" id=""></div>
    </div>

    <div class="w-pop-up-content">
        <div class="w-pop-up-left"><h3>Up to 2.5</h3></div>
        <div class="w-pop-up-right"><input type="radio" name="" id=""></div>
    </div>

    <div class="w-pop-up-content">
        <div class="w-pop-up-left"><h3>Up to 3</h3></div>
        <div class="w-pop-up-right"><input type="radio" name="" id=""></div>
    </div>

    <div class="w-pop-up-content">
        <div class="w-pop-up-left"><h3>Up to 3.5</h3></div>
        <div class="w-pop-up-right"><input type="radio" name="" id=""></div>
    </div>

    <div class="w-pop-up-content">
        <div class="w-pop-up-left"><h3>Up to 4</h3></div>
        <div class="w-pop-up-right"><input type="radio" name="" id=""></div>
    </div>

    <div class="w-pop-up-content">
        <div class="w-pop-up-left"><h3>Up to 4.5</h3></div>
        <div class="w-pop-up-right"><input type="radio" name="" id=""></div>
    </div>

    <div class="w-pop-up-content">
        <div class="w-pop-up-left"><h3>5</h3></div>
        <div class="w-pop-up-right"><input type="radio" name="" id=""></div>
    </div>

</div>


<div class="w-pop-up w-pop-up-2">

    <div class="w-pop-up-content rating-2">
        <div class="w-pop-up-left"><h3>সময়মতো ডেলিভারি হার</h3></div>
        <div class="w-pop-up-right"><input type="radio" name="" id=""></div>
    </div>

    <div class="w-pop-up-content">
        <div class="w-pop-up-left"><h3>100%</h3></div>
        <div class="w-pop-up-right"><input type="radio" name="" id=""></div>
    </div>

    <div class="w-pop-up-content">
        <div class="w-pop-up-left"><h3>90%</h3></div>
        <div class="w-pop-up-right"><input type="radio" name="" id=""></div>
    </div>

    <div class="w-pop-up-content">
        <div class="w-pop-up-left"><h3>80%</h3></div>
        <div class="w-pop-up-right"><input type="radio" name="" id=""></div>
    </div>

    <div class="w-pop-up-content">
        <div class="w-pop-up-left"><h3>70%</h3></div>
        <div class="w-pop-up-right"><input type="radio" name="" id=""></div>
    </div>

    <div class="w-pop-up-content">
        <div class="w-pop-up-left"><h3>60%</h3></div>
        <div class="w-pop-up-right"><input type="radio" name="" id=""></div>
    </div>

    <div class="w-pop-up-content">
        <div class="w-pop-up-left"><h3>50%</h3></div>
        <div class="w-pop-up-right"><input type="radio" name="" id=""></div>
    </div>

    <div class="w-pop-up-content">
        <div class="w-pop-up-left"><h3>25%</h3></div>
        <div class="w-pop-up-right"><input type="radio" name="" id=""></div>
    </div>

    <div class="w-pop-up-content">
        <div class="w-pop-up-left"><h3>1%</h3></div>
        <div class="w-pop-up-right"><input type="radio" name="" id=""></div>
    </div>

</div>


<div class="w-pop-up w-pop-up-3">

    <div class="w-pop-up-content rating-3">
        <div class="w-pop-up-left"><h3>অর্ডার সম্পন্ন হার</h3></div>
        <div class="w-pop-up-right"><input type="radio" name="" id=""></div>
    </div>

    <div class="w-pop-up-content">
        <div class="w-pop-up-left"><h3>100%</h3></div>
        <div class="w-pop-up-right"><input type="radio" name="" id=""></div>
    </div>

    <div class="w-pop-up-content">
        <div class="w-pop-up-left"><h3>90%</h3></div>
        <div class="w-pop-up-right"><input type="radio" name="" id=""></div>
    </div>

    <div class="w-pop-up-content">
        <div class="w-pop-up-left"><h3>80%</h3></div>
        <div class="w-pop-up-right"><input type="radio" name="" id=""></div>
    </div>

    <div class="w-pop-up-content">
        <div class="w-pop-up-left"><h3>70%</h3></div>
        <div class="w-pop-up-right"><input type="radio" name="" id=""></div>
    </div>

    <div class="w-pop-up-content">
        <div class="w-pop-up-left"><h3>60%</h3></div>
        <div class="w-pop-up-right"><input type="radio" name="" id=""></div>
    </div>

    <div class="w-pop-up-content">
        <div class="w-pop-up-left"><h3>50%</h3></div>
        <div class="w-pop-up-right"><input type="radio" name="" id=""></div>
    </div>

    <div class="w-pop-up-content">
        <div class="w-pop-up-left"><h3>1%</h3></div>
        <div class="w-pop-up-right"><input type="radio" name="" id=""></div>
    </div>


</div>
@endsection
@push('foot')
    <script>
        $(document).ready( function () {
            var service_id = $('#service_id').val();
            $('#page_area').hide();

            $('#gig-btn').on('click', function(e){
                $('#gig_area').show();
                $('#page_area').hide();

                $('#gig-btn').removeClass( "btn-default" );
                $('#gig-btn').addClass( "btn-success" );

                $('#page-btn').removeClass( "btn-success" );
                $('#page-btn').addClass( "btn-default" );
            });

            $('#page-btn').on('click', function(e){
                $('#gig_area').hide();
                $('#page_area').show();

                $('#page-btn').removeClass( "btn-default" );
                $('#page-btn').addClass( "btn-success" );

                $('#gig-btn').removeClass( "btn-success" );
                $('#gig-btn').addClass( "btn-default" );
            });

            $('.page_id').on('click', function(){
                var page_id = $(this).val();
                // alert(page_id);
                $.ajax({
                    method: 'POST',
                    url: "{{ route('customer.pageClick') }}",
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    data: {page_id:page_id},
                    // processData: false,
                    // contentType: false,
                    success: function (data) {
                        // alert(data);
                    }
                })
            });

            function getGigList(service_id,budget,min_budget,max_budget,delivery_time,rating,timely_delivery_rate,order_complete_rate,now_online,recent_online,recent_order_delivery){
                $.ajax({
                    url: "{{  url('/get/gig-list/') }}/"+service_id+"/"+budget+"/"+min_budget+"/"+max_budget+"/"+delivery_time+"/"+rating+"/"+timely_delivery_rate+"/"+order_complete_rate+"/"+now_online+"/"+recent_online+"/"+recent_order_delivery,
                    type:"GET",
                    dataType : 'html',
                    success:function(data) {
                        var d =$('#gig_list_area').empty();
                        $('#gig_list_area').html(data);
                    },
                });
            }
            getGigList(service_id);

            $("input[name=budget]").on('change', function(e){
                e.preventDefault();
                var budget = $(this).val();
                // alert(budget);
                getGigList(service_id,budget);
            });

            $('#budget_apply_btn').on('click', function(e){
                e.preventDefault();
                var min_budget = $('#min_budget').val();
                var max_budget = $('#max_budget').val();
                // alert(max_budget + min_budget);
                getGigList(service_id,0,min_budget,max_budget);
            });

            $('#delivery_time_btn').on('click', function(e){
                e.preventDefault();
                var delivery_time = $('#delivery_time').val();
                // alert(delivery_time);
                getGigList(service_id,0,0,0,delivery_time);
            });

            $("#rating").on('change', function(e){
                e.preventDefault();
                var rating = $(this).val();
                // alert(rating);
                getGigList(service_id,0,0,0,0,rating);
            });

            $("#timely_delivery_rate").on('change', function(e){
                e.preventDefault();
                var timely_delivery_rate = $(this).val();
                // alert(rating);
                getGigList(service_id,0,0,0,0,0,timely_delivery_rate);
            });

            $("#order_complete_rate").on('change', function(e){
                e.preventDefault();
                var order_complete_rate = $(this).val();
                // alert(rating);
                getGigList(service_id,0,0,0,0,0,0,order_complete_rate);
            });

            $("#order_complete_rate").on('change', function(e){
                e.preventDefault();
                var order_complete_rate = $(this).val();
                // alert(rating);
                getGigList(service_id,0,0,0,0,0,0,order_complete_rate);
            });

            $("#now_online, #now_online_icon").on('click', function(e){
                e.preventDefault();
                if(event.target.className == "btn btn-sm btn-default now_online_deactive"){
                    $('#now_online').removeClass("btn-default now_online_deactive");
                    $('#now_online').addClass("btn-success now_online_active");
                    $('.now_online_icon').removeClass("fa-toggle-off");
                    $('.now_online_icon').addClass("fa-toggle-on");
                    getGigList(service_id,0,0,0,0,0,0,0,1);

                }else{
                    $('#now_online').removeClass("btn-success now_online_active");
                    $('#now_online').addClass("btn-default now_online_deactive");
                    $('.now_online_icon').removeClass("fa-toggle-on");
                    $('.now_online_icon').addClass("fa-toggle-off");
                    getGigList(service_id,0,0,0,0,0,0,0,0);
                }

            });

            $("#recent_online, #recent_online_icon").on('click', function(e){
                e.preventDefault();
                if(event.target.className == "btn btn-sm btn-default recent_online_deactive"){
                    $('#recent_online').removeClass("btn-default recent_online_deactive");
                    $('#recent_online').addClass("btn-success recent_online_active");
                    $('.recent_online_icon').removeClass("fa-toggle-off");
                    $('.recent_online_icon').addClass("fa-toggle-on");
                    getGigList(service_id,0,0,0,0,0,0,0,0,1);
                }else{
                    $('#recent_online').removeClass("btn-success recent_online_active");
                    $('#recent_online').addClass("btn-default recent_online_deactive");
                    $('.recent_online_icon').removeClass("fa-toggle-on");
                    $('.recent_online_icon').addClass("fa-toggle-off");
                    getGigList(service_id,0,0,0,0,0,0,0,0,0);
                }
            });

            $("#recent_order_delivery, #recent_order_delivery_icon").on('click', function(e){
                e.preventDefault();
                if(event.target.className == "btn btn-sm btn-default recent_order_delivery_deactive"){
                    $('#recent_order_delivery').removeClass("btn-default recent_order_delivery_deactive");
                    $('#recent_order_delivery').addClass("btn-success recent_order_delivery_active");
                    $('.recent_order_delivery_icon').removeClass("fa-toggle-off");
                    $('.recent_order_delivery_icon').addClass("fa-toggle-on");
                    getGigList(service_id,0,0,0,0,0,0,0,0,0,1);
                }else{
                    $('#recent_order_delivery').removeClass("btn-success recent_order_delivery_active");
                    $('#recent_order_delivery').addClass("btn-default recent_order_delivery_deactive");
                    $('.recent_order_delivery_icon').removeClass("fa-toggle-on");
                    $('.recent_order_delivery_icon').addClass("fa-toggle-off");
                    getGigList(service_id,0,0,0,0,0,0,0,0,0,0);
                }
            });

        });
    </script>
@endpush
