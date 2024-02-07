@extends('worker.layout.app')
@push('title') {{ ('Order') }} @endpush

@section('content')
    @php
        $activeGig = 0;
        $completeGig = 0;
        $runningGig = 0;
        $cancelledGig = 0;
        foreach (auth()->user()->workerGigs as $gigs){
            foreach ($gigs->customerBids as $customerBid){
                if ($customerBid->status == 'active'){
                    $activeGig++;
                }else if($customerBid->status == 'completed'){
                    $completeGig++;
                }else if($customerBid->status == 'running'){
                    $runningGig++;
                }else if($customerBid->status == 'cancelled'){
                    $cancelledGig++;
                }
            }
        }

        $activeBid = 0;
        $completeBid = 0;
        $runningBid = 0;
        $cancelledBid = 0;
        foreach (auth()->user()->workerBids as $bids){
            if ($bids->customerGig->status == 'cancelled' || $bids->is_cancelled == 1){
                $cancelledBid++;
            }else if ($bids->customerGig->status == 'active'){
                $activeBid++;
            }else if($bids->customerGig->status == 'completed'){
                $completeBid++;
            }else if($bids->customerGig->status == 'running'){
                $runningBid++;
            }
        }
    @endphp
    @include('worker.job.include._header')
    @include('worker.job.include._bid_order')
    @include('worker.job.include._gig_order')
    @include('worker.job.include._service_order')
@endsection
