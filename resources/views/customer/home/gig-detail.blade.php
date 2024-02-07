@extends('customer.layout.master')
@push('title')  {{ __('Gig') }} @endpush

@section('content')
    <div class="post-img">
        <img src="{{ asset($gig->cover_photo)}}" alt="">
        <input type="hidden" name="" id="gig_id" value="{{ $gig->id }}">
    </div>
    <div class="bid-area">
        <div class="box-area">
            <div class="box-head box-head-2">
                <div class="box-left">
                    <h3>প্রাইস</h3>
                    <p>৳ {{ $gig->budget }}</p>
                </div>
                <div class="box-right">
                    <h3>সময়:</h3>
                    <p>{{ $gig->day }} ঘন্টা</p>
                </div>
            </div>
            <div class="box-head box-head-2">
                <div class="box-left">
                    <h3>Rating</h3>
                    @php
                        $worker = App\User::find($gig->worker_id);
                        $percent = 100 - (($worker->rating->max_rate - $worker->rating->rate)/$worker->rating->max_rate)*100;
                        if ($percent>80){
                            $star = 5;
                        }else if ($percent>60){
                            $star = 4;
                        }else if ($percent>40){
                            $star = 3;
                        }else if ($percent>20){
                            $star = 2;
                        }else if ($percent>1){
                            $star = 1;
                        }else{
                            $star = 0;
                        }
                    @endphp
                    <p> <i class="fa-regular fa-star"></i> {{ $star }}({{ getWorkerRatting($worker->id) }})</p>
                </div>
                <div class="box-right">
                    <h3>লোকেশন</h3>
                    <p><i onclick="window.location.href='{{ $worker->location }}'" class="fa-solid fa-location-dot location"></i></p>
                </div>
            </div>
            <div class="box-foot">
                <h2>Title:</h2>
                <p onclick="window.location.href='{{ route('customer.showGigDetail',$gig->id) }}'">{{ \Illuminate\Support\Str::limit($gig->title, 80) }}</p>
                {!! $gig->description !!}
            </div>
        </div>
        <div class="sub-btn">
            <a href="{{ route('customer.showGigOrderForm', \Illuminate\Support\Facades\Crypt::encryptString($gig->id)) }}"> <input type="submit" value="ORDER NOW"></a>
        </div>
        <div class="sub-flex sub-flex-2">
            <div class="sub-flex-1 sb">
                <h4>রিভিউ
                </h4>
            </div>
            <div class="sub-flex-1 sb-1">
                <h4>প্রশ্ন এবং উত্তর
                </h4>
            </div>
            <div class="sub-flex-1 sb-2">
                <h4>আপনার প্রশ্ন সমূহ
                </h4>
            </div>
        </div>
        <div class="sub-reveiw qn">
            @foreach(App\RattingReview::where('porpuse_id', $gig->id)->where('purpose', 'Bid')->get() as $row)
            <div class="sub-reveiw-1">
                <div class="sub-reveiw-left">
                    <div class="sub-reveiw-icon">
                        <img src="{{ asset($row->user->image ?? 'uploads/images/defaults/user.png') }}" alt="">
                    </div>
                </div>
                <div class="sub-review-right">
                    <h2>{{ $row->user->full_name}}</h2>
                    @for ($starCounter = 1; $starCounter <= $row->rate; $starCounter++)
                        <i class="fa-regular fa-star"></i>
                    @endfor
                    <p class="sub-p">{{ $row->user->user_name}}, {{ date("H:i:s a",strtotime($row->created_at))}}, {{ date("d M Y",strtotime($row->created_at)) }}</p>
                    <p>{{$row->review}}
                    </p>
                </div>
            </div>
            @endforeach
            <div class="sub-reveiw-down">
                <a href="all_review.html">See All Reviews</a>
            </div>
        </div>
    </div>
    <div class="my-container qn-1">
        <div class="qn-flex">
            <h4>সকল প্রশ্ন ও উত্তর সমূহ (35)</h4>
            <h4><a href="qn_ans.html">সব দেখুন...</a></h4>

        </div>

        <div class="question">
            <div class="question-flex">
                <div class="q-f">
                    <i class="fa-regular fa-message"></i>
                </div>
                <div>
                    <h3>What is my AC under warrenty?</h3>
                    <div class=" qn-reply rep">
                        <p> Md Jahirul - 22 hours ago</p>
                        <h3>Reply</h3>
                    </div>
                    <div class="qn-x-1 qn-reply-1 rep-1">
                        <div class="as as-2"><input type="text" name="" id="" placeholder="প্রশ্ন করুন..."></div>
                        </a>
                        <div class="as-1 as-3">
                            <h3><i class="fa-solid fa-paper-plane"></i></h3>
                        </div>

                    </div>

                </div>
            </div>

            <div class="question-flex q-3">
                <div class="q-f q-f-1">
                    <i class="fa-regular fa-message"></i>
                </div>
                <div>
                    <h3>Please check if taking service from external service
                        provider would vail your manufacture warrenty.</h3>
                    <div class="qn-reply ans">
                        <p> Gig holder - answered within 15 hours </p>
                        <h3>Reply</h3>
                    </div>
                    <div class="qn-x-1 qn-reply-1 ans-1">
                        <div class="as as-2"><input type="text" name="" id="" placeholder="প্রশ্ন করুন..."></div>
                        </a>
                        <div class="as-1 as-3">
                            <h3><i class="fa-solid fa-paper-plane"></i></h3>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="question">
            <div class="question-flex">
                <div class="q-f">
                    <i class="fa-regular fa-message"></i>
                </div>
                <div>
                    <h3>What is my AC under warrenty?</h3>
                    <div class=" qn-reply">
                        <p> Md Jahirul - 22 hours ago</p>
                        <h3>Reply</h3>
                    </div>
                    <div class="qn-x-1 qn-reply-1">
                        <div class="as as-2"><input type="text" name="" id="" placeholder="প্রশ্ন করুন..."></div>
                        </a>
                        <div class="as-1 as-3">
                            <h3><i class="fa-solid fa-paper-plane"></i></h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="question-flex q-3">
                <div class="q-f q-f-1">
                    <i class="fa-regular fa-message"></i>
                </div>
                <div>
                    <h3>Please check if taking service from external service
                        provider would vail your manufacture warrenty.</h3>
                    <div class="qn-reply">
                        <p> Gig holder - answered within 15 hours </p>
                        <h3>Reply</h3>
                    </div>
                    <div class="qn-x-1 qn-reply-1">
                        <div class="as as-2"><input type="text" name="" id="" placeholder="প্রশ্ন করুন..."></div>
                        </a>
                        <div class="as-1 as-3">
                            <h3><i class="fa-solid fa-paper-plane"></i></h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="question">
            <div class="question-flex">
                <div class="q-f">
                    <i class="fa-regular fa-message"></i>
                </div>
                <div>
                    <h3>What is my AC under warrenty?</h3>
                    <div class=" qn-reply">
                        <p> Md Jahirul - 22 hours ago</p>
                        <h3>Reply</h3>
                    </div>
                    <div class="qn-x-1 qn-reply-1">
                        <div class="as as-2"><input type="text" name="" id="" placeholder="প্রশ্ন করুন..."></div>
                        </a>
                        <div class="as-1 as-3">
                            <h3><i class="fa-solid fa-paper-plane"></i></h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="question-flex q-3">
                <div class="q-f q-f-1">
                    <i class="fa-regular fa-message"></i>
                </div>
                <div>
                    <h3>Please check if taking service from external service
                        provider would vail your manufacture warrenty.</h3>
                    <div class="qn-reply">
                        <p> Gig holder - answered within 15 hours </p>
                        <h3>Reply</h3>
                    </div>
                    <div class="qn-x-1 qn-reply-1">
                        <div class="as as-2"><input type="text" name="" id="" placeholder="প্রশ্ন করুন..."></div>
                        </a>
                        <div class="as-1 as-3">
                            <h3><i class="fa-solid fa-paper-plane"></i></h3>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="my-container qn-2">
        <div class="qn-x-1">
            <div class="as"><input type="text" name="" id="" placeholder="প্রশ্ন করুন..."></div>
            </a>
            <div class="as-1">
                <h3><i class="fa-solid fa-paper-plane"></i></h3>
            </div>

        </div>
        <div class="qn-flex">
            <h4>আপনার প্রশ্ন সমূহ (12)</h4>
            <h4><a href="my_qn.html">সব দেখুন...</a></h4>

        </div>
        <div class="question">
            <div class="question-flex">
                <div class="q-f">
                    <i class="fa-regular fa-message"></i>
                </div>
                <div>
                    <h3>What is my AC under warrenty?</h3>
                    <div class=" qn-reply rep">
                        <p> Md Jahirul - 22 hours ago</p>
                        <h3>Reply</h3>
                    </div>
                    <div class="qn-x-1 qn-reply-1 rep-1">
                        <div class="as as-2"><input type="text" name="" id="" placeholder="প্রশ্ন করুন..."></div>
                        </a>
                        <div class="as-1 as-3">
                            <h3><i class="fa-solid fa-paper-plane"></i></h3>
                        </div>

                    </div>

                </div>
            </div>


            <div class="question-flex q-3">
                <div class="q-f q-f-1">
                    <i class="fa-regular fa-message"></i>
                </div>
                <div>
                    <h3>Please check if taking service from external service
                        provider would vail your manufacture warrenty.</h3>
                    <div class="qn-reply ans">
                        <p> Gig holder - answered within 15 hours </p>
                        <h3>Reply</h3>
                    </div>
                    <div class="qn-x-1 qn-reply-1 ans-1">
                        <div class="as as-2"><input type="text" name="" id="" placeholder="প্রশ্ন করুন..."></div>
                        </a>
                        <div class="as-1 as-3">
                            <h3><i class="fa-solid fa-paper-plane"></i></h3>
                        </div>

                    </div>
                </div>
            </div>
        </div>




        <div class="question">
            <div class="question-flex">
                <div class="q-f">
                    <i class="fa-regular fa-message"></i>
                </div>
                <div>
                    <h3>What is my AC under warrenty?</h3>
                    <div class=" qn-reply">
                        <p> Md Jahirul - 22 hours ago</p>
                        <h3>Reply</h3>
                    </div>
                    <div class="qn-x-1 qn-reply-1">
                        <div class="as as-2"><input type="text" name="" id="" placeholder="প্রশ্ন করুন..."></div>
                        </a>
                        <div class="as-1 as-3">
                            <h3><i class="fa-solid fa-paper-plane"></i></h3>
                        </div>

                    </div>

                </div>
            </div>


            <div class="question-flex q-3">
                <div class="q-f q-f-1">
                    <i class="fa-regular fa-message"></i>
                </div>
                <div>
                    <h3>Please check if taking service from external service
                        provider would vail your manufacture warrenty.</h3>
                    <div class="qn-reply">
                        <p> Gig holder - answered within 15 hours </p>
                        <h3>Reply</h3>
                    </div>
                    <div class="qn-x-1 qn-reply-1">
                        <div class="as as-2"><input type="text" name="" id="" placeholder="প্রশ্ন করুন..."></div>
                        </a>
                        <div class="as-1 as-3">
                            <h3><i class="fa-solid fa-paper-plane"></i></h3>
                        </div>

                    </div>
                </div>
            </div>
        </div>


        <div class="question">
            <div class="question-flex">
                <div class="q-f">
                    <i class="fa-regular fa-message"></i>
                </div>
                <div>
                    <h3>What is my AC under warrenty?</h3>
                    <div class=" qn-reply">
                        <p> Md Jahirul - 22 hours ago</p>
                        <h3>Reply</h3>
                    </div>
                    <div class="qn-x-1 qn-reply-1">
                        <div class="as as-2"><input type="text" name="" id="" placeholder="প্রশ্ন করুন..."></div>
                        </a>
                        <div class="as-1 as-3">
                            <h3><i class="fa-solid fa-paper-plane"></i></h3>
                        </div>

                    </div>

                </div>
            </div>
            <div class="question-flex q-3">
                <div class="q-f q-f-1">
                    <i class="fa-regular fa-message"></i>
                </div>
                <div>
                    <h3>Please check if taking service from external service
                        provider would vail your manufacture warrenty.</h3>
                    <div class="qn-reply">
                        <p> Gig holder - answered within 15 hours </p>
                        <h3>Reply</h3>
                    </div>
                    <div class="qn-x-1 qn-reply-1">
                        <div class="as as-2"><input type="text" name="" id="" placeholder="প্রশ্ন করুন..."></div>
                        </a>
                        <div class="as-1 as-3">
                            <h3><i class="fa-solid fa-paper-plane"></i></h3>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
