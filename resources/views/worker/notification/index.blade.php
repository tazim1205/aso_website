@extends('worker.layout.app')
@push('title') {{ __('Notifications') }} @endpush
@push('head')

@endpush
@section('content')
    <!-- Start title -->
   <div class="">
       <div class="alert alert-warning text-center" role="alert">
           <b id="bid-job">{{ __('NOTIFICATIONS') }}</b>
       </div>
   </div>
    <!-- End title -->
    <div class="container">
        <div class="row">
            <div class="col-12 px-0">
                <div class="list-group list-group-flush ">
                    @foreach(auth()->user()->notifications as $notification)
                        <a class="list-group-item border-top @if(!$notification->read_at) active @endif text-dark" href="{{ url($notification->data['url']) }}">
                            <div class="row">
                                <div class="col-auto align-self-center">
                                    <i class="material-icons text-template-primary">@if($notification->read_at) notifications @else notifications_active @endif</i>
                                </div>
                                <div class="col pl-0">
                                    <div class="row mb-1">
                                        <div class="col">
                                            <p class="mb-0">{{ $notification->data['title'] }}</p>
                                        </div>
                                        <div class="col-auto pl-0">
                                            <p class="small text-mute text-trucated mt-1">{{ $notification->created_at->format('h:m a d/m/Y') }}</p>
                                        </div>
                                    </div>
                                    <p class="small text-mute">{{ $notification->data['message'] }}</p>
                                </div>
                            </div>
                        </a>
                        @php $notification->markAsRead(); @endphp
                    @endforeach
                </div>
            </div>
        </div>
    </div>



<script>
    $(document).ready(function() {

    });

</script>
@endsection
