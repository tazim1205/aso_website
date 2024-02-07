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


<!-- Package Modal -->
<div class="modal fade" id="package-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header border-0">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body pt-0">
                <div class="alert alert-dark shadow-dark" role="alert">
                    <h4 class="alert-heading package_name_modal"><!--Insert by ajax--></h4>
                    <hr>
                    <div class="row package-detail-modal">
                        <!--Insert by ajax-->
                    </div>
                </div>
                <table width="100%">
                    <form action="{{ route('worker.buyMembership') }}" method="post">
                        @csrf
                        <input type="hidden" name="package_id" id="hidden_package_id_modal">

                        <h6 class="subtitle">Select Preference</h6>
                        <div class="form-group">
                            <label for="">Months</label>
                            <select name="duration" class="form-control  text-center" id="duration">
                                @for ($i = 1; $i <= 12; $i++)
                                    <option value="{{$i}}">{{$i}}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Services</label>
                            <select id="service" name="sub_categories[]" class="form-control form-control-lg" multiple="multiple" style="width: 100%" data-mdb-filter="true">

                            </select>
                        </div>
                        <div id="total_amount_modal" class="mt-3">{{-- load with ajax  --}}</div>
                        <input type="hidden" id="payment_status" name="payment_status" value="">

                        
                        <tr> 
                            <td class="text-center" width="30%"><button type="submit" id="buy_membership" value="{{ Crypt::encryptString(1) }}"  class="btn badge badge-success shadow-success m-1" >{{ __('Buy') }}</button></td>
                        </tr>
                        @if (!App\Membership::where('user_id', Auth::id())->where('payment_status', 'trial')->exists())
                        <tr> 
                            <td class="text-center" width="30%"><button type="submit" id="free_trial" value="{{ Crypt::encryptString(2) }}"  class="btn badge badge-warning shadow-warning m-1" >{{ App\MembershipTrial::first()->days }} {{ __('Days Free Trial') }}</button></td>
                        </tr>
                        @endif
                    </form>

                </table>
            </div>

        </div>
    </div>
</div>


<!-- Package Modal -->
<div class="modal fade" id="view_category-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header border-0">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body pt-0">
                <div id="view_service">

                </div>
            </div>

        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('.select-package-btn').click(function(){
            $('#package-modal').modal('show');
        });
        $('.view_category').click(function(){
            $('#view_category-modal').modal('show');
        });

        $("#free_trial").click(function(){
            var payment_status = $(this).val();
            $("#payment_status").attr('value', payment_status);
        });
        $("#buy_membership").click(function(){
            var payment_status = $(this).val();
            $("#payment_status").attr('value', payment_status);
        });
    });
</script>

<!-- Modal -->
<div class="modal fade" id="sendmoney" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5>Send Money</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body pt-0">
                <div class="form-group mt-4">
                    <select class="form-control form-control-lg text-center">
                        <option>Mrs. Magon Johnson</option>
                        <option selected>Ms. Shivani Dilux</option>
                    </select>
                </div>

                <div class="card shadow border-0 mb-3">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-auto pr-0">
                                <div class="avatar avatar-60 no-shadow border-0">
                                    <img src="{{ asset('assets/mobile/img/user2.png') }}" alt="">
                                </div>
                            </div>
                            <div class="col">
                                <h6 class="font-weight-normal mb-1">Ms. Shivani Dilux</h6>
                                <p class="text-mute small text-secondary">London, UK</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group text-center mt-4">
                    <input type="text" class="form-control form-control-lg text-center" placeholder="Enter amount" required="" autofocus="">
                </div>
                <p class="text-mute text-center">You will be redirected to payment gatway to procceed further. Enter amount in USD.</p>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-default btn-lg btn-rounded shadow btn-block" class="close" data-dismiss="modal">Next</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="paymodal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5>Pay</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body pt-0">
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="customRadioInline1" name="customRadioInline1" class="custom-control-input">
                    <label class="custom-control-label" for="customRadioInline1">To Bill</label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="customRadioInline2" name="customRadioInline1" class="custom-control-input" checked>
                    <label class="custom-control-label" for="customRadioInline2">To Person</label>
                </div>

                <div class="form-group mt-4">
                    <select class="form-control text-center">
                        <option>Mrs. Magon Johnson</option>
                        <option selected>Ms. Shivani Dilux</option>
                    </select>
                </div>

                <div class="card shadow border-0 mb-3">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-auto pr-0">
                                <div class="avatar avatar-60 no-shadow border-0">
                                    <img src="{{ asset('assets/mobile/img/user2.png') }}" alt="">
                                </div>
                            </div>
                            <div class="col align-self-center">
                                <h6 class="font-weight-normal mb-1">Ms. Shivani Dilux</h6>
                                <p class="text-mute small text-secondary">London, UK</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group text-center mt-4">
                    <input type="text" class="form-control form-control-lg text-center" placeholder="Enter amount" required="" autofocus="">
                </div>
                <p class="text-mute text-center">You will be redirected to payment gatway to procceed further. Enter amount in USD.</p>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-default btn-lg btn-rounded shadow btn-block" class="close" data-dismiss="modal">Next</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="bookmodal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5>Pay</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body pt-0">
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="customRadioInline12" name="customRadioInline12" class="custom-control-input">
                    <label class="custom-control-label" for="customRadioInline12">Flight</label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="customRadioInline22" name="customRadioInline12" class="custom-control-input" checked>
                    <label class="custom-control-label" for="customRadioInline22">Train</label>
                </div>
                <h6 class="subtitle">Select Location</h6>
                <div class="form-group mt-4">
                    <input type="text" class="form-control text-center" placeholder="Select start point" required="" autofocus="">
                </div>
                <div class="form-group mt-4">
                    <input type="text" class="form-control text-center" placeholder="Select end point" required="">
                </div>
                <h6 class="subtitle">Select Date</h6>
                <div class="form-group mt-4">
                    <input type="date" class="form-control text-center" placeholder="Select end point" required="">
                </div>
                <h6 class="subtitle">number of passangers</h6>
                <div class="form-group mt-4">
                    <select class="form-control  text-center">
                        <option>1</option>
                        <option selected>2</option>
                        <option>3</option>
                        <option>4</option>
                        <option>5</option>
                        <option>6</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-default btn-lg btn-rounded shadow btn-block" class="close" data-dismiss="modal">Next</button>
            </div>
        </div>
    </div>
</div>
