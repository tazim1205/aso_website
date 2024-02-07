@extends('guest.layout')
@push('title')  {{ __('Gig') }} @endpush
@push('head')
    <link href="{{ asset('assets/css/icons.css') }}" rel="stylesheet" type="text/css"/>
@endpush
@section('content')
    <div class="wrapper">
        <!-- Start title -->
        <!-- Swiper intro -->
        {{-- <div class="swiper-container introduction">
            <div class="swiper-wrapper">
                <div class="swiper-slide overflow-hidden text-center">
                    <div class="row no-gutters">
                        <div class="col align-self-center px-3">
                            <img src="{{ asset( get_static_option('logo')  ?? 'uploads/images/defaults/logo.png') }}" alt="" class="mx-100 my-5">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Swiper intro ends -->

         <!-- login buttons -->
        <div class="row mx-0">
            <div class="col-12 container text-center small">
                <p>{{ __('সার্ভিস নিতে অথবা সার্ভিস দিতে সাইন ইন করুন। আপনার কোনো অ্যাকাউন্ট নেই? এখনই সাইন আপ করুন।') }}</p>
                <br>
            </div>
        </div>
        
        <hr>     --}}
        <div class="">
            <div class="alert alert-info text-center" role="alert">
                <b id=""> {{ __('Gig') }} </b>
                <input type="hidden" name="" id="gig_id" value="{{ $gig->id }}">
            </div>
        </div>
        <!-- End title -->
        <!--Start worker info & price-->
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-12 mb-1">
                    <div class="card pt-2 pb-2" style="background-image: url({{ asset('uploads/images/product1.jpg')}});height: 170px;">
                        <div class="" style="margin-top: 113px;">
                            <div class="d-flex justify-content-between">
                                <div class="">
                                    <span class="badge badge-success">৳ {{ $gig->budget }}</span><br>
                                    <span class="badge badge-success"><i class="fa fa-clock"></i> {{ $gig->day }} Hours</span>
                                </div>
                                <div class="text-right">
                                    <span class="text-right text-warning"><i class="fa fa-star"></i>
                                    @php
                                    $worker = App\User::find($gig->worker_id);
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
                                    
                                    ({{ $worker->rating->rateGivenBy }})</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-12 col-12 pt-2 pb-2">
                    <figcaption class="figure-caption "><a class="text-primary" href="{{ route('customer.showGigDetail',$gig->id) }}"><b>{{ \Illuminate\Support\Str::limit($gig->title, 80) }}</b></a></figcaption>
                </div>
                <div class="col-lg-12 col-12 pt-2 pb-2">
                    <div class="show-read-more">{!! $gig->description !!}</div>
                </div>
                <style>
                    .show-read-more .more-text{
                        display: none;
                    }
                </style>
                <div class="col-lg-12 col-12 text-center pt-2 pb-2">
                    <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#LoginModalWhenClickOrder">{{ __('Order Now') }}</button>
                </div>

                <div class="col-lg-12 col-12 text-center pt-2 pb-2">
                    <button id="question_ans_btn" type="button" class="btn btn-sm btn-success mr-1 mb-1">{{ __('Questions and Answers') }}</button>
                </div>

                <div class="col-lg-12 col-12 pt-2 pb-2" id="question_ans_area">
                    <div class="" id="questionList">
                        
                    </div>
                    <div class="row">
                        <div class="col-12 col-lg-12 text-center ">
                            <a href="#" class="text-success loadmorequestion" id="loadmorequestion"><i class="fa fa-arrow-right"></i> See All Question Anwer</a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-12 col-12 pt-2 pb-2" id="review">
                    <div class="row">
                        <div class="col-12 col-lg-12 text-center">
                            <button class="btn btn-success">Customers Reviews</button>
                        </div>
                        <div class="col-12 col-lg-12">
                            <div class="d-flex">
                                <div class="p-2">
                                    <img src="{{ asset('uploads/images/product1.jpg')}}" class="rounded-circle" alt="Cinque Terre" width="50" height="50">
                                </div>
                                <div class="">
                                    <h6 class="m-0">Md Maruf</h6>
                                    <small>User_name, 08:45 pm, 25 Feb 2021</small>
                                    <p>the web’s favorite icon library + toolkit the web’s favorite icon library + toolkit</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-lg-12 text-center ">
                            <a href="" class="text-success"><i class="fa fa-arrow-right"></i> See All Reviews</a>
                        </div>
                    </div>
                </div>
            </div> 
        </div>
    </div>
    <script>
        $(document).ready(function(){
            var gig_id = $('#gig_id').val();
            // $('#question_ans_area').show();
            $('#your_question_area').hide();
            $('#ask_question_area').hide();

            var maxLength = 200;
            $(".show-read-more").each(function(){
                var myStr = $(this).text();
                if($.trim(myStr).length > maxLength){
                    var newStr = myStr.substring(0, maxLength);
                    var removedStr = myStr.substring(maxLength, $.trim(myStr).length);
                    $(this).empty().html(newStr);
                    $(this).append(' <a href="javascript:void(0);" class="read-more">read more...</a>');
                    $(this).append('<span class="more-text">' + removedStr + '</span>');
                }
            });
            $(".read-more").click(function(){
                $(this).siblings(".more-text").contents().unwrap();
                $(this).remove();
            });

            function getAllQuestions(gig_id,show){
                $.ajax({  
                    url: "{{  url('/get/worker/gig-questions/') }}/"+gig_id+"/"+show,
                    type:"GET",
                    dataType : 'html',
                    success:function(data) {
                        var d =$('#questionList').empty();
                        $('#questionList').html(data);
                    },
                });
            }
            getAllQuestions(gig_id,'0');


            $('#question_ans_btn').on('click', function(e){
                $('#question_ans_area').show();
                $('#your_question_area').hide();
                $('#ask_question_area').hide();
            });
            $("#loadmorequestion").click(function(e){
                e.preventDefault();
                getAllQuestions(gig_id,'all');
            });

            $('.replayBtn').on('click', function(e){
                e.preventDefault();
                alert('test');
                $('#replayModal').modal('show');
            });

            
        });
    </script>
@endsection
