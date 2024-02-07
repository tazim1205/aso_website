@extends('worker.layout.master')
@push('title') {{ __('Gig Order') }} @endpush

@section('content')
    @if($customerBid->status == 'active')
        @include('worker.job.include.gig_order._pending')
    @elseif($customerBid->status == 'running')
        @include('worker.job.include.gig_order._running')
    @elseif($customerBid->status == 'completed')
        @include('worker.job.include.gig_order._complete')
    @elseif($customerBid->status == 'cancelled')
        @include('worker.job.include.gig_order._cancel')
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
    <script>
        $(document).ready(function(){
            //Update Budget with confirm alert
            $("#update-budget").click(function (){
                $("#update-budget").prop("disabled", true);
                var balance = {{ auth()->user()->recharge_amount * get_static_option('order_bid_limit_amount') }}
                if($('#budget').val() <= balance) {
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
                                url: "{{ route('worker.updateCustomerBidBudget') }}",
                                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                                data: formData,
                                processData: false,
                                contentType: false,
                                success: function (data) {
                                    $("#update-budget").prop("disabled", false);
                                    $('#budget').val('');
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
                                    $("#update-budget").prop("disabled", false);
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
                }else{
                    $('#rechargeModalforBid').modal('show');
                }
            });
            //Job Accept with confirm alert
            $("#job-accept").click(function (){
                $("#job-accept").prop("disabled", true);

                // alert(worker_id);
                Swal.fire({
                    title: 'Accept this job ?',
                    text: "",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, accept'
                }).then((result) => {
                    if (result.isConfirmed) {
                        var worker_id = $("#worker_id").val();
                        var formData = new FormData();
                        formData.append('bid', $('#bid-id').val());
                        formData.append('worker_id', worker_id);
                        $.ajax({
                            method: 'POST',
                            url: "{{ route('worker.acceptCustomerBid') }}",
                            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                            data: formData,
                            processData: false,
                            contentType: false,
                            success: function (data) {
                                $("#job-accept").prop("disabled", false);
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
                                $("#job-accept").prop("disabled", false);
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
                $("#job-cancel").prop("disabled", true);
                Swal.fire({
                    title: 'Reject this job ?',
                    text: "",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, reject'
                }).then((result) => {
                    if (result.isConfirmed) {
                        var formData = new FormData();
                        formData.append('bid', $('#bid-id').val())
                        $.ajax({
                            method: 'POST',
                            url: "{{ route('worker.rejectCustomerBid') }}",
                            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                            data: formData,
                            processData: false,
                            contentType: false,
                            success: function (data) {
                                $("#job-cancel").prop("disabled", false);
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
                                $("#job-cancel").prop("disabled", false);
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
            // Job Complete
            $('.completed-btn').click(function (){
                $(".completed-btn").prop("disabled", true);
                let id = $(this).attr('id');
                Swal.fire({
                    title: 'Are You Sure?',
                    showCancelButton: true,
                    confirmButtonText: 'Complete',
                    showLoaderOnConfirm: true,
                    preConfirm: (review) => {
                        var formData = new FormData();
                        formData.append('bid', id)
                        $.ajax({
                            method: 'POST',
                            url: "{{ route('worker.completedWorkerGigJob') }}",
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
                                $(".completed-btn").prop("disabled", false);
                                console.log(data);
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
                                $(".completed-btn").prop("disabled", false);
                                console.log(xhr);
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
            });
        });
    </script>

    <script>
        @if($customerBid->status == 'active')

            @php

                $deadline =  get_static_option('worker_job_request_accept_hour');
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
                    }, 2000);
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

            }, 2000)
        @endif


        @if($customerBid->status == 'running')
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

        // let countDown = new Date("{ $ending_at }}").getTime(),
        //     x = setInterval(function () {

        //         let now = new Date().getTime(),
        //             distance = countDown - now;

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
