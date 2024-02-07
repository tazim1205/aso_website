@extends('customer.layout.master')
@push('title') {{ __('notification') }} @endpush
@push('head')

@endpush
@section('content')
    <div class="notification-area">
        <div class="noti-alram">
            <h3>You have <span>{{ auth()->user()->unreadNotifications->count() }} notifications </span>today</h3>
        </div>
        @foreach(auth()->user()->notifications as $notification)
            <div class="noti-cont-area">
                <div class="noti-icon">
                    <div class="noti-dot">
                        <div class="noti-dot-img">
                            <img src="{{ asset('frontend/image/Ellipse 60.png') }}" alt="" />
                        </div>
                    </div>
                    <div class="noti-ball">
                        <div class="noti-ball-img">
                            <img src="{{ asset('frontend/image/bell (1).png') }}" alt="" />
                        </div>
                    </div>
                </div>

                <div class="noti-cont">
                    <div class="noti-head"><h3><a href="{{ url($notification->data['url']) }}">{{ $notification->data['title'] }}</a></h3></div>
                    <div class="noti-foot">
                        <div class="noti-msg">
                            <p>{{ $notification->data['message'] }}</p>
                            <p>{{ $notification->created_at->format('h:m a d/m/Y') }}</p>
                        </div>
                        <div class="noti-time"><p></p></div>
                    </div>
                </div>
            </div>
        @endforeach
        @php $notification->markAsRead(); @endphp
    </div>
@endsection
