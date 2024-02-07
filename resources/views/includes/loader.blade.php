<div class="row no-gutters vh-100 loader-screen">
    <div class="col align-self-center text-white text-center">
        <img src="{{ asset( get_static_option('logo_white')  ?? 'uploads/images/defaults/header-logo.png') }}" alt="logo">
        <!-- <h1 class="mt-3"><span class="font-weight-light ">Fi</span>mobile</h1> -->
        <p class="text-mute text-uppercase small">{{ get_static_option('motto') }}</p>
        <div class="laoderhorizontal">
            <div></div>
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div>
</div>
<div class="modal fade" id="LoginModalWhenClickOrder" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" aria-labelledby="staticBackdropLabel">
    <div class="modal-dialog  modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header border-0">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body pt-0">
                <div class="row mx-0">
                    <div class="col-12 container text-center small">
                        <p>{{ __('সার্ভিস নিতে অথবা সার্ভিস দিতে সাইন ইন করুন। আপনার কোনো অ্যাকাউন্ট নেই? এখনই সাইন আপ করুন।') }}</p>
                        <br>
                    </div>
                    <div class="col">
                        <a href="{{ route('login') }}" class="btn btn-default btn-lg btn-rounded bg-success shadow btn-block">{{ __('Sign in') }}</a>
                    </div>
                    <div class="col">
                        <a href="{{ route('register') }}" class="btn btn-default btn-lg btn-rounded bg-success shadow btn-block">{{ __('Sign up') }}</a>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</div>

<div class="modal hide fade" id="areachangeModal" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" aria-labelledby="staticBackdropLabel">
    <div class="modal-dialog  modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header border-0">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body pt-0">
                <div class="row no-gutters">
                    <div class="col-12 text-center">
                        <img src="{{ asset('assets/images/location.png') }}" alt="" class="mx-100 my-5" width="100">
                    </div>
                </div>
                <div class="row mx-0">
                    <div class="col-12 container text-center small">
                        <p>{{ __('আপনার এরিয়াতে সার্ভিস নিতে আপনার লোকেশন নির্বাচন করুন।') }}</p>
                        <br>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 px-0 text-center">
                        <form action="{{ route('store.area') }}" method="POST" class="row">
                            @csrf
                            
                            <div class="col-lg-12 form-group mt-3">
                                <select class="form-control" name="district_id" id="district_id" required="">
                                    <option value="">{{ __('জেলা') }}</option>
                                    @foreach(App\District::all() as $row)
                                    <option value="{{ $row->id }}" <?php if ($row->id == Cookie::get('guest_district')) {
                                        echo "selected";
                                    } ?> >{{ __($row->name) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-12 form-group mt-3">
                                <select class="form-control" name="upazila_thana_id" id="upazila_thana_id" required="">
                                    <option value="">{{ __('উপজেলা /মেট্টোপলিটন থানা') }}</option>
                                    @foreach(App\Upazila::where('district_id', Cookie::get('guest_district'))->get() as $row)
                                    <option value="{{ $row->id }}" <?php if ($row->id == Cookie::get('guest_upazila')) {
                                        echo "selected";
                                    } ?> >{{ __($row->name) }}</option>
                                    @endforeach
                                </select>
                            </div>
                           
                            <div class="col-lg-12 form-group mt-3">
                                <select class="form-control" name="pouroshava_union_id" id="pouroshava_union_id" required="">
                                    <option value="">{{ __('পৌরসভা /ইউনিয়ন /এরিয়া') }}</option>
                                    @foreach(App\Puroshova::where('upazila_id', Cookie::get('guest_upazila'))->get() as $row)
                                    <option value="{{ $row->id }}" <?php if ($row->id == Cookie::get('guest_puroshova')) {
                                        echo "selected";
                                    } ?> >{{ __($row->name) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div class="col-lg-12 form-group mt-3">
                                <select class="form-control" name="word_road_id" id="word_road_id" required="">
                                    <option value="">{{ __('ওয়ার্ড /রোড') }}</option>
                                    @foreach(App\Word::where('puroshova_id', Cookie::get('guest_puroshova'))->get() as $row)
                                    <option value="{{ $row->id }}" <?php if ($row->id == Cookie::get('guest_word')) {
                                        echo "selected";
                                    } ?> >{{ __($row->name) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div class="col-lg-12 form-group mt-3">
                                <button type="submit" class="btn btn-default btn-lg btn-rounded bg-success shadow btn-block"><i class="material-icons">edit_location</i> {{ __('সাবমিট লোকেশন') }}</button>
                            </div>
                            
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal hide fade" id="privacyPolicyModal" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" aria-labelledby="staticBackdropLabel">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header border-0">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body pt-0">
                <div class="row no-gutters">
                    <div class="col-12 text-center">
                        <img src="{{ asset( get_static_option('logo')  ?? 'uploads/images/defaults/logo.png') }}" alt="" class="mx-60 my-2"><br>
                        <hr>
                        <h3>{{ __('Privacy Policy') }}</h3>
                        <hr>
                    </div>
                </div>
                <div class="row p-2">
                    @php
                        $customer_privacy = App\PrivacyPolicy::where('about_for', 'customer')->orderByDesc('id')->first();
                    @endphp
                    {!! $customer_privacy->about !!}
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal hide fade" id="termsConditionModal" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" aria-labelledby="staticBackdropLabel">
    <div class="modal-dialog modal-lg  modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header border-0">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body pt-0">
                <div class="row no-gutters">
                    <div class="col-12 text-center">
                        <img src="{{ asset( get_static_option('logo')  ?? 'uploads/images/defaults/logo.png') }}" alt="" class="mx-60 my-2"><br>
                        <hr>
                        <h3>{{ __('Terms & Condition') }}</h3>
                        <hr>
                    </div>
                </div>
                <div class="row p-2">
                    @php
                        $customer_terms = App\TermsAndCondition::where('about_for', 'customer')->orderByDesc('id')->first();
                    @endphp
                    {!! $customer_terms->about !!}
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $('select[name="district_id"]').on('change', function(){
            var district_id = $(this).val();
            if(district_id) {
                $.ajax({
                    url: "{{  url('/get/district/upazila/') }}/"+district_id,
                    type:"GET",
                    dataType:"json",
                    success:function(data) {
                        var d =$('select[name="upazila_thana_id"]').empty();
                        $('select[name="upazila_thana_id"]').append('<option value="">সিলেক্ট উপজেলা /মেট্রোপলিটন থানা</option>');
                        $.each(data, function(key, value){
                           $('select[name="upazila_thana_id"]').append('<option value="'+ value.id +'">' + value.name + '</option>');
                        });

                        $('select[name="pouroshava_union_id"]').empty();
                        $('select[name="word_road_id"]').empty();

                        $('select[name="pouroshava_union_id"]').append('<option value="">Select Pouroshava / Union</option>');
                        $('select[name="word_road_id"]').append('<option value="">Select Ward / Road</option>');
                    },

                });
            } else {
                alert('danger');
            }
        });

        $('select[name="upazila_thana_id"]').on('change', function(){
            var upazila_thana_id = $(this).val();
            if(upazila_thana_id) {
                $.ajax({
                    url: "{{  url('/get/upazila/pouroshava-union/') }}/"+upazila_thana_id,
                    type:"GET",
                    dataType:"json",
                    success:function(data) {
                        var d =$('select[name="pouroshava_union_id"]').empty();
                        $('select[name="pouroshava_union_id"]').append('<option value="">Select Pouroshava / Union</option>');
                        $.each(data, function(key, value){
                           $('select[name="pouroshava_union_id"]').append('<option value="'+ value.id +'">' + value.name + '</option>');
                        });
                    },

                });
            } else {
                alert('danger');
            }
        });

        $('select[name="pouroshava_union_id"]').on('change', function(){
            var pouroshava_union_id = $(this).val();
            if(pouroshava_union_id) {
                $.ajax({
                    url: "{{  url('/get/pouroshava-union/word-road/') }}/"+pouroshava_union_id,
                    type:"GET",
                    dataType:"json",
                    success:function(data) {
                        var d =$('select[name="word_road_id"]').empty();
                        $('select[name="word_road_id"]').append('<option value="">Select Ward / Road</option>');
                        $.each(data, function(key, value){
                           $('select[name="word_road_id"]').append('<option value="'+ value.id +'">' + value.name + '</option>');
                        });
                    },

                });
            } else {
                alert('danger');
            }
        });
    });

</script>

