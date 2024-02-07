@foreach($gigs as $gig)
	@php
    $check = false;
    $worker = App\User::find($gig->worker_id);

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
            <a href="{{ route('customer.showGigDetail',$gig->id) }}"><div class="card">
                    <img class="card-img-top" src="{{ asset($gig->thambline_photo ?? 'uploads/images/product1.jpg') }}" alt="Card image cap">
                    <div class="card-body">
                        <div class="cb-f">
                            <div class="user-f"><div class="user"></div>
                                <div>
                                    <h3>{{ $worker->full_name }} </h3>
                                    @php
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
                                    <p><span ><i class="fa-regular fa-star"></i></span>

                                         {{ $star }} ({{ getWorkerRatting($worker->id) }})</p></div>
                            </div>
                            <div>
                                <h3> ৳ {{ $gig->budget }} </h3>
                                <p><i class="fa-regular fa-clock"></i> {{ $gig->day }} ঘন্টা
                                <p>
                            </div>
                        </div>
                        <div class="gig-cont">
                            <a href="{{ route('customer.showGigDetail',$gig->id) }}"><h5>{{ \Illuminate\Support\Str::limit($gig->title, 80)}}</h5></a>
                        </div>
                    </div>
                </div></a>

        @endif
    @endif
@endforeach
