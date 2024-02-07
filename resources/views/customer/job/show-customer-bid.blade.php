@extends('customer.layout.master')
@push('title') {{ __('Gig Order') }} @endpush
@section('content')
    @if($customerBid->status == 'active')
        @include('customer.job.include.gig_order._pending')
    @elseif($customerBid->status == 'running')
        @include('customer.job.include.gig_order._running')
    @elseif($customerBid->status == 'completed')
        @include('customer.job.include.gig_order._complete')
    @elseif($customerBid->status == 'cancelled')
        @include('customer.job.include.gig_order._cancel')
    @endif
@endsection
@push('foot')
    <script>
        // Get the modal
        var modal = document.getElementById('myModal');

        // Get the image and insert it inside the modal - use its "alt" text as a caption
        var img = document.getElementById('myImg');
        var modalImg = document.getElementById("img01");
        var captionText = document.getElementById("caption");
        img.onclick = function(){
            modal.style.display = "block";
            modalImg.src = this.src;
            modalImg.alt = this.alt;
            captionText.innerHTML = this.alt;
        }


        // When the user clicks on <span> (x), close the modal
        modal.onclick = function() {
            img01.className += " out";
            setTimeout(function() {
                modal.style.display = "none";
                img01.className = "modal-content";
            }, 400);

        }

    </script>
    <!-- footer-->
    <script>
        function complainNow(gig_id){
            Swal.fire({
                title: ' Write Complain ',
                input: 'textarea',
                inputAttributes: {
                    autocapitalize: 'off',
                },
                inputPlaceholder: "{{ __('Write details of job and worker information for proper complain ... ') }}",
                showCancelButton: true,
                confirmButtonText: 'Complain',
                showLoaderOnConfirm: true,
                preConfirm: (complain) => {
                    var formData = new FormData();
                    formData.append('bid', gig_id)
                    formData.append('complain', complain)
                    $.ajax({
                        method: 'POST',
                        url: "{{ route('customer.completedCustomerBidJobAndComplain') }}",
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        data: formData,
                        processData: false,
                        contentType: false,
                        beforeSend: function (){
                            $(this).prop("disabled",true);
                        },
                        complete: function (){
                            $(this).prop("disabled",false);
                        },
                        success: function (data) {
                            if (data.type == 'success'){
                                Swal.fire({
                                    position: 'top-end',
                                    icon: data.type,
                                    title: data.message,
                                    showConfirmButton: false,
                                    timer: 1500
                                });
                                setTimeout(function() {
                                    location.reload();
                                }, 800);//
                            }else{
                                Swal.fire({
                                    icon: data.type,
                                    title: 'Oops...',
                                    text: data.message,
                                    footer: 'Something went wrong!'
                                });
                            }
                        },
                        error: function (xhr) {
                            var errorMessage = '<div class="card bg-danger">\n' +
                                '                        <div class="card-body text-center p-5">\n' +
                                '                            <span class="text-white">';
                            $.each(xhr.responseJSON.errors, function(key,value) {
                                errorMessage +=(''+value+'<br>');
                            });
                            errorMessage +='</span>\n' +
                                '                        </div>\n' +
                                '                    </div>';
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                footer: errorMessage
                            });
                        },
                    });
                },
            })
        }
        $(document).ready(function(){

            //Otp Verification Process
            $("#otp").keyup(function(){
                //console.log("Okay");
                var otp = $("#otp").val();
                var bid_id = $("#bid-id-otp").val();
                $.ajax({
                    method: 'POST',
                    url: "{{ route('customer.otpCheck') }}",
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    data: {
                        bid_id : bid_id,
                        otp : otp,
                    },
                    success: function (data) {
                        //console.log(data);
                        if(data.type === 'success'){
                            $("#success_otp").css('display','block');
                            $("#wrong_otp").css('display','none');
                        }else{
                            $("#success_otp").css('display','none');
                            $("#wrong_otp").css('display','block');
                        }
                        //$("#success_otp").css('display','block');
                    },
                    error: function (xhr) {
                        console.log(xhr.responseJSON.errors);
                    },
                })
            });



            //Update Budget with confirm alert
            $("#update_budget").click(function (){
                var worker_limit = Number($(this).attr('data-worker-limit'));
                var budget = Number($('#budget').val());
                if(budget > worker_limit) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Low Balance',
                        footer: 'অর্ডার প্রাইস বৃদ্ধি করতে সার্ভিস প্রোভাইডার বা ওয়ার্কারকে তার ব্যালেন্স বৃদ্ধি করতে বলুন।'
                    })
                }else{
                    Swal.fire({
                        title: 'Price update ?',
                        text: "",
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, update now!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            var formData = new FormData();
                            formData.append('bid', $('#bid-id').val())
                            formData.append('budget', $('#budget').val())
                            $.ajax({
                                method: 'POST',
                                url: "{{ route('customer.updateCustomerBidBudget') }}",
                                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                                data: formData,
                                processData: false,
                                contentType: false,
                                success: function (data) {
                                    Swal.fire({
                                        position: 'top-end',
                                        icon: data.type,
                                        title: data.message,
                                        showConfirmButton: false,
                                        timer: 1500
                                    })
                                    setTimeout(function() {
                                        location.reload()
                                    }, 1000); //1 second
                                },
                                error: function (xhr) {
                                    var errorMessage = '<div class="card bg-danger">\n' +
                                        '                        <div class="card-body text-center p-5">\n' +
                                        '                            <span class="text-white">';
                                    $.each(xhr.responseJSON.errors, function(key,value) {
                                        errorMessage +=(''+value+'<br>');
                                    });
                                    errorMessage +='</span>\n' +
                                        '                        </div>\n' +
                                        '                    </div>';
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Oops...',
                                        footer: errorMessage
                                    })
                                },
                            })
                        }
                    })
                }
            });

            $("#accept_budget").click(function (){
                Swal.fire({
                    title: 'Accept Proposed Budget?',
                    text: "",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, Accept!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        var formData = new FormData();
                        formData.append('bid', $('#bid-id').val())
                        formData.append('budget', $('#proposed_budget').val())
                        $.ajax({
                            method: 'POST',
                            url: "{{ route('customer.acceptGigBidBudget') }}",
                            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                            data: formData,
                            processData: false,
                            contentType: false,
                            success: function (data) {
                                Swal.fire({
                                    position: 'top-end',
                                    icon: data.type,
                                    title: data.message,
                                    showConfirmButton: false,
                                    timer: 1500
                                })
                                setTimeout(function() {
                                    location.reload()
                                }, 1000); //1 second
                            },
                            error: function (xhr) {
                                var errorMessage = '<div class="card bg-danger">\n' +
                                    '                        <div class="card-body text-center p-5">\n' +
                                    '                            <span class="text-white">';
                                $.each(xhr.responseJSON.errors, function(key,value) {
                                    errorMessage +=(''+value+'<br>');
                                });
                                errorMessage +='</span>\n' +
                                    '                        </div>\n' +
                                    '                    </div>';
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    footer: errorMessage
                                })
                            },
                        })
                    }
                })
            });

            $("#cancel_budget").click(function (){
                Swal.fire({
                    title: 'Cancel Proposed Budget?',
                    text: "",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, cancel!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        var formData = new FormData();
                        formData.append('bid', $('#bid-id').val())
                        formData.append('budget', $('#proposed_budget').val())
                        $.ajax({
                            method: 'POST',
                            url: "{{ route('customer.cancelGigBidBudget') }}",
                            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                            data: formData,
                            processData: false,
                            contentType: false,
                            success: function (data) {
                                Swal.fire({
                                    position: 'top-end',
                                    icon: data.type,
                                    title: data.message,
                                    showConfirmButton: false,
                                    timer: 1500
                                })
                                setTimeout(function() {
                                    location.reload()
                                }, 1000); //1 second
                            },
                            error: function (xhr) {
                                var errorMessage = '<div class="card bg-danger">\n' +
                                    '                        <div class="card-body text-center p-5">\n' +
                                    '                            <span class="text-white">';
                                $.each(xhr.responseJSON.errors, function(key,value) {
                                    errorMessage +=(''+value+'<br>');
                                });
                                errorMessage +='</span>\n' +
                                    '                        </div>\n' +
                                    '                    </div>';
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    footer: errorMessage
                                })
                            },
                        })
                    }
                })
            });

            //Job Cancel with confirm alert
            $("#job-cancel").click(function (){
                Swal.fire({
                    title: 'Cancel this bid ?',
                    text: "",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        var formData = new FormData();
                        formData.append('bid', $('#bid-id').val())
                        $.ajax({
                            method: 'POST',
                            url: "{{ route('customer.cancelCustomerBid') }}",
                            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                            data: formData,
                            processData: false,
                            contentType: false,
                            success: function (data) {
                                Swal.fire({
                                    position: 'top-end',
                                    icon: data.type,
                                    title: data.message,
                                    showConfirmButton: false,
                                    timer: 1500
                                })
                                setTimeout(function() {
                                    location.reload()
                                }, 1000); //1 second
                            },
                            error: function (xhr) {
                                var errorMessage = '<div class="card bg-danger">\n' +
                                    '                        <div class="card-body text-center p-5">\n' +
                                    '                            <span class="text-white">';
                                $.each(xhr.responseJSON.errors, function(key,value) {
                                    errorMessage +=(''+value+'<br>');
                                });
                                errorMessage +='</span>\n' +
                                    '                        </div>\n' +
                                    '                    </div>';
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    footer: errorMessage
                                })
                            },
                        })
                    }
                })
            });

            //Job image upload
            $('#image').change(function(){
                var formData = new FormData();
                formData.append('bid', $('#bid-id').val())
                formData.append('image', $('#image')[0].files[0])
                $.ajax({
                    method: 'POST',
                    url: "{{ route('customer.imageUploadToCustomerBid') }}",
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (data) {
                        Swal.fire({
                            position: 'top-end',
                            icon: data.type,
                            title: data.message,
                            showConfirmButton: false,
                            timer: 1500
                        })
                        setTimeout(function() {
                            //your code to be executed after 1 second
                            location.reload();
                        }, 1000); //1 second
                    },
                    error: function (xhr) {
                        var errorMessage = '<div class="card bg-danger">\n' +
                            '                        <div class="card-body text-center p-5">\n' +
                            '                            <span class="text-white">';
                        $.each(xhr.responseJSON.errors, function(key,value) {
                            errorMessage +=(''+value+'<br>');
                        });
                        errorMessage +='</span>\n' +
                            '                        </div>\n' +
                            '                    </div>';
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            footer: errorMessage
                        })
                    },
                })
            });

            //Complete and rating
            $('#completed-btn').click(function (){
                $('#complete-modal').modal('show');
            });

            //Rating and completed submit
            $('#completed-submit').click(function (){
                $("#completed-submit").prop("disabled", true);
                var formData = new FormData();
                formData.append('rate', $('.rating-btn:checked').val())
                formData.append('bid', $('#bid-id').val())
                formData.append('complete_review', $('#complete_review').val())
                $.ajax({
                    method: 'POST',
                    url: "{{ route('customer.completedCustomerBidJobAndRating') }}",
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (data) {
                        $("#completed-submit").prop("disabled", false);
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: data.message,
                            showConfirmButton: false,
                            // timer: 1500
                        })
                        setTimeout(function() {
                            //your code to be executed after 1 second
                            location.reload();
                        }, 1000); //1 second
                    }
                });
            });
        });
    </script>

    <script>
        @if($customerBid->status == 'active')
            @php
                $deadline = get_static_option('worker_job_request_accept_hour');
                $date = $customerBid->created_at;
                $ending_at = Carbon\Carbon::parse($date);
                $ending_at->addHours($deadline);
                $current_timestamp = Carbon\Carbon::now()->toDateTimeString();
            @endphp
        if ("{{ $ending_at }}" < "{{ $current_timestamp }}") {
            var formData = new FormData();
            formData.append('bid', $('#bid-id').val())
            $.ajax({
                method: 'POST',
                url: "{{ route('customer.cancelCustomerBid') }}",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                data: formData,
                processData: false,
                contentType: false,
                success: function (data) {
                    setTimeout(function() {
                        location.reload()
                    });
                },
            })
        }

        const second = 1000,
            minute = second * 60,
            hour = minute * 60,
            day = hour * 24;

        let countDown = new Date("{{ $ending_at }}").getTime(),
            x = setInterval(function () {

                let now = new Date().getTime(),
                    distance = countDown - now;

                document.getElementById('days').innerText = Math.floor(distance / (day)),
                    document.getElementById('hours').innerText = Math.floor((distance % (day)) / (hour)),
                    document.getElementById('minutes').innerText = Math.floor((distance % (hour)) / (minute)),
                    document.getElementById('seconds').innerText = Math.floor((distance % (minute)) / second);

                if (countDown <= now) {
                    var formData = new FormData();
                    formData.append('bid', $('#bid-id').val())
                    $.ajax({
                        method: 'POST',
                        url: "{{ route('customer.cancelCustomerBid') }}",
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function (data) {
                            setTimeout(function() {
                                location.reload()
                            });
                        },
                    })
                }

            }, second)
        @endif


        @if($customerBid->status == 'running') //$customerBid->completed_at
        @php
            // $deadline = $customerBid->workerGig->day;
            // $date = $customerBid->updated_at;
            // $ending_at = Carbon\Carbon::parse($date);
            // $ending_at->addHours($deadline);
        @endphp

        // const second = 1000,
        // minute = second * 60,
        // hour = minute * 60,
        // day = hour * 24;

        // let countDown = new Date(" $ending_at ").getTime();
        //$customerBid->completed_at


        //     x = setInterval(function () {

        //         let now = new Date().getTime(),
        //         distance = countDown - now;


        //         document.getElementById('days').innerText = Math.floor(distance / (day)),
        //         document.getElementById('hours').innerText = Math.floor((distance % (day)) / (hour)),
        //         document.getElementById('minutes').innerText = Math.floor((distance % (hour)) / (minute)),
        //         document.getElementById('seconds').innerText = Math.floor((distance % (minute)) / second);

        //         if (countDown <= now) {
        //             // alert("ok");
        //         }
        //     }, second)
        @endif
    </script>
@endpush
