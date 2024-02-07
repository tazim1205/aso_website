@extends('customer.layout.app')
@push('title')  {{ __('Gig') }} @endpush
@push('head')
    <link href="{{ asset('assets/css/icons.css') }}" rel="stylesheet" type="text/css"/>
    {{-- <style>
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
    </style> --}}
@endpush
@section('content')

        <!--Start active job detail view -->
        <!-- Start title -->
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
                    <div class="card pt-2 pb-2" {{-- style="background-image: url('{{ asset($gig->cover_photo)}}'); background-size: cover; background-size: cover; background-position: center;" --}}>
                        <img src="{{ asset($gig->cover_photo)}}" class="gig-detail-image" id="showImageBtn">
                        <div class="">
                            <div class="d-flex justify-content-between">
                                <div class="">
                                    <span class="badge badge-success">৳ {{ $gig->budget }}</span><br>
                                    <span class="badge badge-success"><i class="fa fa-clock"></i> {{ $gig->day }} Hours</span>
                                </div>
                                <div class="text-right">
                                    <span class="text-right text-warning p-4"><i class="fa fa-star"></i>
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

                                    ({{ getWorkerRatting($worker->id) }})</span><br>
                                    <a href="{{ $worker->location }}" target="_blank" class="text-warning p-4"> <i class="fa fa-map-marker"></i> Location</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-12 col-12 pt-2 pb-2">
                    <figcaption class="figure-caption "><a class="text-success" href="{{ route('customer.showGigDetail',$gig->id) }}"><b>{{ \Illuminate\Support\Str::limit($gig->title, 80) }}</b></a></figcaption>
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
                    <button id="" onclick="window.location.href='{{ route('customer.showGigOrderForm', \Illuminate\Support\Facades\Crypt::encryptString($gig->id)) }}'" type="button" class="btn btn-warning">{{ __('Order Now') }}</button>
                </div>

                <div class="col-lg-12 col-12 text-center pt-2 pb-2">
                    <button id="question_ans_btn" type="button" class="btn btn-sm btn-success mr-1 mb-1">{{ __('Questions and Answers') }}</button>
                    <button id="your_question_btn" type="button" class="btn btn-sm btn-success mr-1 mb-1">{{ __('Your Questions') }}</button>
                    <button id="ask_question_btn" type="button" class="btn btn-sm btn-default">{{ __('Ask Questions') }}</button>
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

                <div class="col-lg-12 col-12 pt-2 pb-2" id="your_question_area">
                    <div class="" id="yourquestionList">
                        
                    </div>
                </div>

                <div class="col-lg-12 col-12 pt-2 pb-2" id="ask_question_area">
                    <form action="{{ route('askQuestion') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label>{{ __('Enter Question') }}</label>
                            <textarea class="form-control" name="question" required=""></textarea>
                        </div>
                        <div class="form-group">
                            <input type="hidden" name="gig_id" value="{{ $gig->id }}">
                            <button type="submit" class="btn btn-success">{{ __('Submit') }}</button>
                        </div>
                    </form>
                </div>

                <div class="col-lg-12 col-12 pt-2 pb-2" id="review">
                    <div class="row">
                        <div class="col-12 col-lg-12 text-center">
                            <button class="btn btn-success">Customers Reviews</button>
                        </div>
                        @foreach(App\RattingReview::where('porpuse_id', $gig->id)->where('purpose', 'Bid')->get() as $row)
                            <div class="col-12 col-lg-12">
                                <div class="d-flex">
                                    <div class="p-2">
                                        <img src="{{ asset($row->user->image ?? 'uploads/images/defaults/user.png') }}" class="rounded-circle" alt="Cinque Terre" width="50" height="50">
                                    </div>
                                    <div class="">
                                        <h6 class="m-0">{{ $row->user->full_name}}</h6>
                                        <div>
                                            @for ($starCounter = 1; $starCounter <= $row->rate; $starCounter++)
                                                <i class="material-icons btn-outline-warning small">star</i>
                                            @endfor
                                        </div>
                                        <small>{{ $row->user->user_name}}, {{ date("H:i:s a",strtotime($row->created_at))}}, {{ date("d M Y",strtotime($row->created_at)) }}</small>
                                        <p>{{$row->review}}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        <div class="col-12 col-lg-12 text-center ">
                            <a href="" class="text-success"><i class="fa fa-arrow-right"></i> See All Reviews</a>
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

        // var maxLength = 200;
        // $(".show-read-more").each(function(){
        //     var myStr = $(this).text();
        //     if($.trim(myStr).length > maxLength){
        //         var newStr = myStr.substring(0, maxLength);
        //         var removedStr = myStr.substring(maxLength, $.trim(myStr).length);
        //         $(this).empty().html(newStr);
        //         $(this).append(' <a href="javascript:void(0);" class="read-more">read more...</a>');
        //         $(this).append('<span class="more-text">' + removedStr + '</span>');
        //     }
        // });
        // $(".read-more").click(function(){
        //     $(this).siblings(".more-text").contents().unwrap();
        //     $(this).remove();
        // });

        function getAllQuestions(gig_id,show){
            $.ajax({  
                url: "{{  url('/get/gig-questions/') }}/"+gig_id+"/"+show,
                type:"GET",
                dataType : 'html',
                success:function(data) {
                    var d =$('#questionList').empty();
                    $('#questionList').html(data);
                },
            });
        }
        getAllQuestions(gig_id,'0');

        function getAllYourQuestions(gig_id,show){
            $.ajax({  
                url: "{{  url('/get/gig-your-questions/') }}/"+gig_id+"/"+show,
                type:"GET",
                dataType : 'html',
                success:function(data) {
                    var d =$('#yourquestionList').empty();
                    $('#yourquestionList').html(data);
                },
            });
        }
        getAllYourQuestions(gig_id,0);

        $('#question_ans_btn').on('click', function(e){
            $('#question_ans_area').show();
            $('#your_question_area').hide();
            $('#ask_question_area').hide();

            $('#question_ans_btn').removeClass( "btn-default" );
            $('#question_ans_btn').addClass( "btn-success" );

            $('#your_question_btn').removeClass( "btn-success" );
            $('#your_question_btn').addClass( "btn-default" );

            $('#ask_question_btn').removeClass( "btn-success" );
            $('#ask_question_btn').addClass( "btn-default" );
        });
        $('#your_question_btn').on('click', function(e){
            $('#question_ans_area').hide();
            $('#your_question_area').show();
            $('#ask_question_area').hide();

            $('#your_question_btn').removeClass( "btn-default" );
            $('#your_question_btn').addClass( "btn-success" );

            $('#question_ans_btn').removeClass( "btn-success" );
            $('#question_ans_btn').addClass( "btn-default" );

            $('#ask_question_btn').removeClass( "btn-success" );
            $('#ask_question_btn').addClass( "btn-default" );
        });
        $('#ask_question_btn').on('click', function(e){
            $('#question_ans_area').hide();
            $('#your_question_area').hide();
            $('#ask_question_area').show();

            $('#ask_question_btn').removeClass( "btn-default" );
            $('#ask_question_btn').addClass( "btn-success" );

            $('#question_ans_btn').removeClass( "btn-success" );
            $('#question_ans_btn').addClass( "btn-default" );

            $('#your_question_btn').removeClass( "btn-success" );
            $('#your_question_btn').addClass( "btn-default" );
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

        function replayQuestion(id){
            alert('test');
        }

        $("#showImageBtn").on("click", function() {
           $('#imagepreview').attr('src', $(this).attr('src')); // here asign the image to the modal when the user click the enlarge link
           $('#imagemodal').modal('show'); // imagemodal is the id attribute assigned to the bootstrap modal, then i use the show function
        });
    });
</script>

@endsection
