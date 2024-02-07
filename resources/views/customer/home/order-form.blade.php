@extends('customer.layout.master')
@push('title') {{ __('Order Now') }} @endpush

@section('content')
    <div class="my-container abb">
        <div class="bid-acont">
            <div class="bid-icon">
                <img src="{{ asset($gig->worker->image ?? 'uploads/images/defaults/user.png') }}" alt="">
            </div>

            <div class="bid-tittle">
                <div class="bid-cont">
                    <h2>{{ $gig->worker->full_name }}</h2>
                    <p>
                        @php
                            $percent = 100 - (($gig->worker->rating->max_rate - $gig->worker->rating->rate)/$gig->worker->rating->max_rate)*100;
                            if ($percent>80)
                                $star = 5;
                            else if ($percent>60)
                                $star = 4;
                            else if ($percent>40)
                                $star = 3;
                            else if ($percent>20)
                                $star = 2;
                            else if ($percent>1)
                                $star = 1;
                            else
                                $star = 0;
                        @endphp
                        <span><i class="fa-regular fa-star"></i></span> {{ $star }} ({{ $gig->worker->rating->max_rate - $gig->worker->rating->rate }})
                    </p>
                </div>
            </div>

            <div class="bid-icon bb-1">
                <i onclick="window.location.href='{{ $gig->worker->location }}'" class="fa-solid fa-location-dot"></i>
            </div>
        </div>
    </div>

    <div class="bid-area">
        <div class="box-area">
            <div class="box-head box-head-2">
                <div class="box-left">
                    <h3>প্রাইস</h3>
                    <p>৳ {{ $gig->budget }}</p>
                </div>
                <div class="box-right">
                    <h3>সময়:</h3>
                    <p>{{ $gig->day }} ঘন্টা</p>
                </div>
            </div>

            <div class="box-foot">
                <h2>Title: {{ $gig->title }}</h2>
                <div class="sub-input">
                    <input id="gig-id" type="hidden" value="{{$gig->id}}">
                    <label for="">কাজের বিবরণ...</label>
                    <textarea
                        name=""
                        id="description"
                        placeholder="কাজের বিবরণ..."
                        class="kajer-bb"
                    ></textarea>
                    <label for="">আপনার ঠিকানা</label>
                    <input type="text" placeholder="আপনার ঠিকানা" id="address"/>
                    <div class="new-flex">
                        <div class="new-flex-1">
                            <label for="">বুকিং তারিখ</label>
                            <input type="date" placeholder="তারিখ" id="date"/>
                        </div>
                        <div class="new-flex-1">
                            <label for="">বুকিং সময়</label>
                            <input type="time" placeholder="সময়" id="time"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="sub-btn">
            <input type="submit" value="ORDER NOW" id="job-submit" data-worker-limiit="{{ $gig->worker->recharge_amount * get_static_option('order_bid_limit_amount') }}"/>
        </div>
    </div>
@endsection
@push('foot')
    <script>
        $(document).ready(function(){
            //Submit
            $("#job-submit").click(function (){
                $("#job-submit").prop("disabled", true);
                var formData = new FormData();
                formData.append('gig', $('#gig-id').val())
                formData.append('description', $('#description').val())
                formData.append('address', $('#address').val())
                formData.append('date', $('#date').val())
                formData.append('time', $('#time').val())

                $.ajax({
                    method: 'POST',
                    url: "{{ route('customer.submitGigOrderForm') }}",
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (data) {
                        $("#job-submit").prop("disabled", false);

                        $.toast({
                            heading: 'Success',
                            position: 'top-right',
                            text: 'Successfully order placed.',
                            showHideTransition: 'slide',
                            icon: 'success'
                        })
                        setTimeout(function() {
                            window.location = "{{ route('customer.myJob') }}";
                        }, 1000); //1 second
                    },
                    error: function (xhr) {
                        $("#job-submit").prop("disabled", false);
                        $.each(xhr.responseJSON.errors, function(key,value) {
                            console.log(value)
                            $.toast({
                                heading: 'Opps!',
                                position: 'top-right',
                                text: value,
                                showHideTransition: 'slide',
                                icon: 'error',
                                hideAfter: 5000,
                            })
                        });
                    },
                })

            });
        });
    </script>

    <script>
        $('#description').summernote({
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'clear']],
                ['fontname', ['fontname']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
            ],
            placeholder: 'কাজের বিবরণ...',
            tabsize: 2,
            height: 120,

        });
    </script>
@endpush
