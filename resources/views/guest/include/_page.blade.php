<div class="page">

    <div class=" order-area ">
        <div class="order-btn-area s-btn">
            <button class="order-btn s-btnchild bajed"><a href="#">বাজেট bajed</a><i class="fa-solid fa-caret-down"></i></button>
            <button class="order-btn s-btnchild dtime"><a href="#">ডেলিভারি টাইম</a><i class="fa-solid fa-caret-down"></i></button>
            <button class="order-btn s-btnchild rating"><a href="#">রেটিং</a><i class="fa-solid fa-caret-down"></i></button>
            <button class="order-btn s-btnchild delivary big"><a href="#">সময়মত ডেলিভারি হার</a><i class="fa-solid fa-caret-down"></i></button>
            <button class="order-btn s-btnchild order-x big"><a href="#">অর্ডার সম্পন্ন হার</a><i class="fa-solid fa-caret-down"></i></button>
        </div>

        <div class="per-tab">

            <div class="pre-head">
                <div class="per-sta"> <h2>এখন অনলাইন</h2></div>
                <div class="pre-icon">
                    <div class="off"><i class="fa-solid fa-toggle-off"></i></div>
                    <div class="on"> <i class="fa-solid fa-toggle-on"></i></div>
                </div>
            </div>

            <div class="pre-head">
                <div class="per-sta"> <h2>সাম্প্রতিক অনলাইন</h2></div>
                <div class="pre-icon">
                    <div class="off-1"><i class="fa-solid fa-toggle-off"></i></div>
                    <div class="on-1"> <i class="fa-solid fa-toggle-on"></i></div>
                </div>
            </div>

            <div class="pre-head pre-bot">
                <div class="per-sta"> <h2>সাম্প্রতিক অর্ডার ডেলিভারি</h2></div>
                <div class="pre-icon">
                    <div class="off-2"><i class="fa-solid fa-toggle-off"></i></div>
                    <div class="on-2"> <i class="fa-solid fa-toggle-on"></i></div>
                </div>
            </div>
        </div>

        <div class="card-row">
            @foreach ($mamberships as $membership)
                {{-- {{ $membership->position }} --}}
                @foreach ($pages as $page)
                    @if (isset($membership->position) && App\MembershipPackage::withTrashed()->find(App\Membership::find($page->membership_id)->membership_package_id)->position == $membership->position)
                        @if ($membership = App\Membership::where('user_id', $page->worker_id)->where('ending_at', '>=', carbon\Carbon::now()->format('Y-m-d H:i:s'))->first())
                            @if ($membership->id == $page->membership_id)
                                @foreach (Str::of($page->services)->explode(',') as $service_id)
                                    @if ($service_id == $service->id)
                                        @php
                                            $check = false;
                                            $worker = App\User::find($page->worker_id);

                                            $Word = $worker->word_road_id;
                                            $workerWord = explode(',', $Word);
                                        @endphp
                                        @if ($Word != NULL)
                                            @foreach ($workerWord as $w)
                                                @if ($w == auth()->user()->word_road_id && $worker->out_of_work == 0)
                                                    @php $check = true; @endphp
                                                @endif
                                            @endforeach
                                            @if ($check == true)
                                                    <a href="{{ route('guest.showPages', $page->id) }}">
                                                        <div class="card">
                                                            <img class="card-img-top" src="{{ asset($page->image)}}" alt="Card image cap">
                                                            <div class="card-body">
                                                                <div class="cb-f">
                                                                    <div class="user-f"><div class="user"></div>
                                                                        <div>
                                                                            <h3>{{ $worker->full_name }}</h3>
                                                                            @php
                                                                                $sum = App\ServiceReview::where('worker_id', $page->worker_id)->sum('rating');
                                                                                $count = App\ServiceReview::where('worker_id', $page->worker_id)->count();
                                                                                if (App\ServiceReview::where('worker_id', $page->worker_id)->exists()) {
                                                                                    $total_review = $sum/$count;
                                                                                }else {
                                                                                    $total_review = 0;
                                                                                }
                                                                                if ($total_review != 0) {
                                                                                    $rat =  number_format((float)$total_review, 1, '.', '');
                                                                                }
                                                                            @endphp
                                                                            <p><span ><i class="fa-regular fa-star"></i></span> {{ $rat }} ({{$count}})</p></div>
                                                                    </div>
                                                                </div>
                                                                <div class="gig-cont">
                                                                    <a href="{{ route('guest.showPages', $page->id) }}"><h5>{{ Str::of($page->title)->limit(80, '(...)') }}</h5></a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </a>
                                            @endif
                                        @endif
                                    @endif
                                @endforeach
                            @endif
                        @endif
                    @endif
                @endforeach
            @endforeach

        </div>
    </div>
</div>
