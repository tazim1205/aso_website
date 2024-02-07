<!--Offer Modal -->
<!-- Modal -->


@foreach(get_all_static_pages() as $page)
<div class="modal fade" id="{{ $page->slug }}" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" aria-labelledby="staticBackdropLabel">
    <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header border-0">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center pt-0">
                @if(current_language() == 'bn')
                    <p class="text-mute">{!! $page->bn_description !!}</p>
                @else
                    <p class="text-mute">{!! $page->en_description !!}</p>
                @endif
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-default btn-lg btn-rounded shadow btn-block close" aria-hidden="true" data-dismiss="modal">{{ __('Close') }}</button>
            </div>
        </div>
    </div>
</div>
@endforeach


<!-- Payment Modal -->
<div class="modal fade" id="" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header border-0">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center pt-0">
                <img src="{{ asset('assets/mobile/img/surjopay.png') }}" alt="logo" class="logo-small">
                <div class="form-group mt-4" style="display: none">
                    <input type="text" class="form-control form-control-lg bg-secondary text-white text-center payment-amount" placeholder="Enter amount" required="" autofocus="">
                </div>
                <br>
                <p class="text-mute">{{ __('Your due amount id') }} <b class="text-red-600"></b></p>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-default btn-lg btn-rounded shadow btn-block payment">{{ __('Pay Now') }}</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="payment-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header border-0 text-center">
                <h5 style="color: tomato">
                
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body pt-0">
                <div class="card shadow border-0 mb-3">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-auto pr-0">
                                <div class="avatar avatar-60 no-shadow border-0">
                                    <img src="{{ asset('uploads/images/users/'.auth()->user()->image) }}" alt="">
                                </div>
                            </div>
                            <div class="col">
                                <h6 class="font-weight-normal mb-1">{{ auth()->user()->full_name }}</h6>
                                <p class="text-mute small text-secondary">{{ auth()->user()->phone }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="form-group mt-4 text-center">
                    <img src="{{ asset('assets/mobile/img/surjopay.png') }}" alt="logo" class="logo-small">
                </div>
            </div>
            <div class="modal-footer border-0">
                
            </div>
        </div>
    </div>
</div>

<!-- Payment Modal -->
<div class="modal fade" id="seeModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header border-0">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center pt-0" id="seeDivForModal">
                
            </div>
        </div>
    </div>
</div>


<script>
    $(document).ready(function() {
        $('.payment-modal-btn').click(function(){
            $('#payment-modal').modal('show');
        });

        $('.payment').click(function (){
            $('.payment-amount').val()
            location.replace("{{ route('worker.duePay', 'payment') }}");
        });
    });
</script>


