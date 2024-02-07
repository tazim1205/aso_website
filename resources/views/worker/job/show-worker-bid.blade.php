@extends('worker.layout.master')
@push('title') {{ __('Bid Order') }} @endpush

@section('content')
    @if($customerGig->status == 'active' && $customerGig->workerBids->where('worker_id', auth()->user()->id)->first()->is_cancelled == 0)
        @include('worker.job.include.bid_order._pending')
    @elseif($customerGig->status == 'running' && $customerGig->workerBids->where('is_selected', '1')->where('worker_id', auth()->user()->id)->first())
        @include('worker.job.include.bid_order._running')
    @elseif($customerGig->status == 'completed' && $customerGig->workerBids->where('is_selected', '1')->where('worker_id', auth()->user()->id)->first())
        @include('worker.job.include.bid_order._complete')
    @elseif($customerGig->status == 'cancelled' || $customerGig->workerBids->where('is_cancelled', '1')->where('worker_id', auth()->user()->id))
        @include('worker.job.include.bid_order._cancel')
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
        $(document).ready(function() {
            //Cancel worker bid with confirm alert
            $('#canceller-btn').click(function(){
                $("#canceller-btn").prop("disabled", true);
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, Cancel it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        var formData = new FormData();
                        formData.append('bid', $(this).val())
                        $.ajax({
                            method: 'POST',
                            url: "{{ route('worker.cancelWorkerBid') }}",
                            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                            data: formData,
                            processData: false,
                            contentType: false,
                            success: function (data) {
                                $("#canceller-btn").prop("disabled", false);
                                Swal.fire({
                                    position: 'top-end',
                                    icon: 'success',
                                    title: 'Successfully bid cancelled.',
                                    showConfirmButton: false,
                                    timer: 1500
                                })
                                setTimeout(function() {
                                    //your code to be executed after 1 second
                                    location.reload()
                                }, 1000);//2 second
                            },
                            error: function (xhr) {
                                $("#canceller-btn").prop("disabled", false);
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

            //Price update by worker with confirm alert
            $("#update-budget").click(function (){
                $("#update-budget").prop("disabled", true);
                var balance = {{ App\User::worker_bid_gig_limit(auth()->user()->id) }}
                if(Number($('#budget').val()) <= Number(balance)) {
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
                            formData.append('price', $('#budget').val())
                            formData.append('bid', $('#bid-id').val())
                            $.ajax({
                                method: 'POST',
                                url: "{{ route('worker.changePriceForMoreWork') }}",
                                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                                data: formData,
                                processData: false,
                                contentType: false,
                                success: function (data) {
                                    $("#update-budget").prop("disabled", false);
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


            $('#completed-btn').click(function (){
                $("#completed-btn").prop("disabled", true);
                $('.modal-backdrop').css("z-index", "0")
                $('#complete-modal').modal('show');
            });
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
                            url: "{{ route('worker.completedCustomerGigJob') }}",
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

            //Rating and completed submit
            $('#completed-submit').click(function (){
                $("#completed-submit").prop("disabled", true);
                var formData = new FormData();
                formData.append('bid', $('#bid-id').val())
                formData.append('review', $('#complete_review').val())
                $.ajax({
                    method: 'POST',
                    url: "{{ route('worker.completedCustomerGigJob') }}",
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
                            timer: 1500
                        })
                        setTimeout(function () {
                            location.reload()
                        }, 1000); //1 second
                    }
                });



            });

        });
    </script>

    <script>
        @php
            $deadline = get_static_option('worker_job_request_accept_hour');
            $date = $customerGig->created_at;
            $ending_at = Carbon\Carbon::parse($date);
            $ending_at->addHours($deadline);
            $current_timestamp = Carbon\Carbon::now()->toDateTimeString();
        @endphp

            @if($customerGig->status == 'active')
        if ("{{ $ending_at }}" < "{{ $current_timestamp }}") {

            // $("#job-cancel").click();

            var formData = new FormData();
            formData.append('bid', $('#canceller-btn').val())
            $.ajax({

                method: 'POST',
                url: "{{ route('worker.cancelWorkerBid') }}",
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
                    formData.append('bid', $('#canceller-btn').val())
                    $.ajax({
                        method: 'POST',
                        url: "{{ route('worker.cancelWorkerBid') }}",
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



        @if($customerGig->status == 'running' && $ending_at)
        @php
            // $deadline = $customerGig->day;
            // $date = $customerGig->updated_at;
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
