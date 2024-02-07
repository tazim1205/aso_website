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
            <div class="col-lg-3 col-6 mb-1">
            	@if($gig->thambline_photo)
                <div class="card pt-2 pb-2" style="background-image: 
                url('{{ asset($gig->thambline_photo) }}');background-size: cover;background-position: center;">
                @else
                <div class="card pt-2 pb-2" style="background-image: 
                url({{ asset('uploads/images/product1.jpg')}});background-size: cover;background-position: center;">
                @endif
                    <div class="" style="margin-top: 113px;">
                        <div class="d-flex justify-content-between">
                            <div class="">
                                <span class="badge badge-success">৳ {{ $gig->budget }}</span><br>
                                <span class="badge badge-success"><i class="fa fa-clock"></i> {{ $gig->day }} Hours</span>
                            </div>
                            <div class="text-right">
                                <span class="text-right text-warning"><i class="fa fa-star"></i>
                                @php
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
                               {{ getWorkerRatting($worker->id) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <figcaption class="figure-caption "><a class="text-primary" href="{{ route('guest.showGigDetail',$gig->id) }}"><b>{{ \Illuminate\Support\Str::limit($gig->title, 80)}}</b></a></figcaption>
            </div>

        @endif
    @endif
@endforeach