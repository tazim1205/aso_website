@extends('worker.layout.master')
@push('title') {{ __($service->name) }} @endpush
@push('head')

@endpush
@section('content')
    @foreach($service->customerGigs->where('status', 'active')->sortByDesc("id") as $customerGig)
        @php
            $today = Carbon\Carbon::now()->toDateTimeString();
            $gigday = $customerGig->created_at;
            $diff = $gigday->diff($today);
            // echo $today;
            // echo $diff->format('%y years %m months %a days %h hours %i minutes %s seconds');
        @endphp
        @if($customerGig->day >= $diff->format('%H'))
            @php
                $check = false;
                $customer = App\User::find($customerGig->customer_id);
                $Word = $customer->word_road_id;

                $wWord = auth()->user()->word_road_id;
                $workerWord = explode(',', $wWord);
            @endphp
            @if ($wWord != NULL)
                @php
                    foreach ($workerWord as $w) {
                        if ($w == $Word) {
                            $check = true;
                        }
                    }
                @endphp
                @if ($check == true)
                    <!-- Check already bid or not -->
                    @if(!auth()->user()->workerBids()->where('customer_gig_id', $customerGig->id)->exists())
                        <div class="my-container">
                            <div class="pdb-area">
                                <div class="pdb-up">
                                    <div class="pdb-up-1">
                                        <h3>পোস্ট</h3>
                                        <p>{{ __(date('h:i a d/m/y', strtotime($customerGig->created_at))) }}</p>
                                    </div>
                                    <div class="pdb-up-1 pdb-up-2">
                                        <h3>ডেলিভারি</h3>
                                        <p>{{ $customerGig->day }}</p>
                                    </div>
                                    <div class="pdb-up-1">
                                        <h3>বিড</h3>
                                        <p>{{ __($customerGig->workerBids->count()) }}</p>
                                    </div>
                                </div>
                                <div class="pdb-down">
                                    <h3>Title:</h3>
                                    <p>{{ $customerGig->title }}</p>
                                    {!! $customerGig->description !!}
                                </div>
                            </div>

                            <div class="all-bid-2">
                                <a href="{{ route('worker.showJob',\Illuminate\Support\Facades\Crypt::encryptString($customerGig->id) ) }}"><input type="submit" value="BID NOW" /></a>
                            </div>
                        </div>

                    @endif
                @endif
            @endif
        @endif
    @endforeach

@endsection
@push('foot')
    <script>
        $(document).ready(function(){
            var maxLength = 150;
            $(".show-read-more").each(function(){
                var myStr = $(this).text();
                if($.trim(myStr).length > maxLength){
                    var newStr = myStr.substring(0, maxLength);
                    var removedStr = myStr.substring(maxLength, $.trim(myStr).length);
                    $(this).empty().html(newStr);
                    $(this).append(' <a href="javascript:void(0);" class="read-more" style="color:#007bff;">read more...</a>');
                    $(this).append('<span class="more-text">' + removedStr + '</span>');
                }
            });
            $(".read-more").click(function(){
                $(this).siblings(".more-text").contents().unwrap();
                $(this).remove();
            });
        });
    </script>
@endpush
