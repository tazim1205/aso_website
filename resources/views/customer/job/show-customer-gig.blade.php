@extends('customer.layout.master')
@push('title') {{ __('Bid Order') }} @endpush
@section('content')
    @if($gig->status == 'active')
        @include('customer.job.include.bid_order._pending')
    @elseif($gig->status == 'completed')
        @include('customer.job.include.bid_order._complete')
    @elseif($gig->status == 'running')
        @include('customer.job.include.bid_order._running')
    @elseif($gig->status == 'cancelled')
        @include('customer.job.include.bid_order._cancel')
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

        var maxLength = 200;
        $(".show-read-more").each(function(){
            var myStr = $(this).text();
            if($.trim(myStr).length > maxLength){
                var newStr = myStr.substring(0, maxLength);
                var removedStr = myStr.substring(maxLength, $.trim(myStr).length);
                $(this).empty().html(newStr);
                $(this).append(' <a href="javascript:void(0);" class="read-more">read more...</a>');
                $(this).append('<span class="more-text">' + removedStr + '</span>');
            }
        });
        $(".read-more").click(function(){
            $(this).siblings(".more-text").contents().unwrap();
            $(this).remove();
        });

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
                    formData.append('gig', gig_id)
                    formData.append('complain', complain)
                    $.ajax({
                        method: 'POST',
                        url: "{{ route('customer.completedCustomerGigJobAndComplain') }}",
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
            //Submit
            $(".order-now").click(function (){
                Swal.fire({
                    title: 'Are you sure?',
                    text: "This worker selected for this job.",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, Order now!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        var formData = new FormData();
                        formData.append('bid', $(this).parent().find('.worker-bid-id').val())
                        $.ajax({
                            method: 'POST',
                            url: "{{ route('customer.selectWorkerForCustomerGig') }}",
                            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                            data: formData,
                            processData: false,
                            contentType: false,
                            success: function (data) {
                                Swal.fire({
                                    position: 'top-end',
                                    icon: 'success',
                                    title: 'Successfully order placed.',
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
                    title: 'Cancel this gig ?',
                    text: "",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        var formData = new FormData();
                        formData.append('gig', $('#gig-id').val())
                        $.ajax({
                            method: 'POST',
                            url: "{{ route('customer.cancelCustomerGig') }}",
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
                        formData.append('bid', $('#bid').val())
                        formData.append('budget', $('#proposed_budget').val())
                        $.ajax({
                            method: 'POST',
                            url: "{{ route('customer.acceptGigBudget') }}",
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
                        formData.append('bid', $('#bid').val())
                        formData.append('budget', $('#proposed_budget').val())
                        $.ajax({
                            method: 'POST',
                            url: "{{ route('customer.cancelGigBudget') }}",
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

            //new-price
            $("#new-price").click(function (){
                var worker_limit = $(this).attr('data-worker-limit');
                // alert('balance');
                if(Number($('#budget').val()) <= Number(worker_limit)) {
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
                                url: "{{ route('customer.changePriceForMoreWork') }}",
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
                }else{
                    Swal.fire({
                        icon: 'error',
                        title: 'Low Balance',
                        footer: 'অর্ডার প্রাইস বৃদ্ধি করতে সার্ভিস প্রোভাইডার বা ওয়ার্কারকে তার ব্যালেন্স বৃদ্ধি করতে বলুন।'
                    })
                }
            });

            //Job image upload
            $('#image').change(function(){
                var formData = new FormData();
                formData.append('bid', $('#bid-id').val())
                formData.append('image', $('#image')[0].files[0])
                $.ajax({
                    method: 'POST',
                    url: "{{ route('customer.imageUploadToCustomerGig') }}",
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
                $('.modal-backdrop').css("z-index", "0")
                let id = $(this).attr('data-id');
                $('#bid_id').val(id);
                $('#update_rating').val(0);
                $('#complete-modal').modal('show');
            });

            $('#rating-btn').click(function (){
                $('.modal-backdrop').css("z-index", "0")
                let id = $(this).attr('data-id');
                $('#bid_id').val(id);
                $('#update_rating').val(1);
                $('#complete-modal').modal('show');
            });


            //Rating and completed submit
            $('#completed-submit').click(function (){
                $("#completed-submit").prop("disabled", true);
                var formData = new FormData();
                formData.append('rate', $('.rating-btn:checked').val())
                formData.append('bid', $('#bid_id').val())
                formData.append('update_rating', $('#update_rating').val())
                formData.append('review', $('#complete_review').val())
                $.ajax({
                    method: 'POST',
                    url: "{{ route('customer.completedCustomerGigJobAndRating') }}",
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

        @if($gig->status == 'active')
            @php
                $deadline = get_static_option('worker_job_request_accept_hour');
                $date = $gig->created_at;
                $ending_at = Carbon\Carbon::parse($date);
                $ending_at->addHours($deadline);
                $current_timestamp = Carbon\Carbon::now()->toDateTimeString();
            @endphp

        if ("{{ $ending_at }}" < "{{ $current_timestamp }}") {

            // $("#job-cancel").click();

            var formData = new FormData();
            formData.append('gig', $('#gig-id').val())
            $.ajax({

                // method: 'POST',
                // url: "{{ route('customer.cancelCustomerBid') }}",
                // headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                // data: formData,
                // processData: false,
                // contentType: false,
                // success: function (data) {
                //     setTimeout(function() {
                //         location.reload()
                //     });
                // },

                method: 'POST',
                url: "{{ route('customer.cancelCustomerGig') }}",
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
                    formData.append('gig', $('#gig-id').val())
                    $.ajax({
                        method: 'POST',
                        url: "{{ route('customer.cancelCustomerGig') }}",
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



        @if($gig->status == 'running' )
        @php
            // $deadline = $gig->day;
            // $date = $gig->updated_at;
            // $ending_at = Carbon\Carbon::parse($date);
            // $ending_at->addHours($deadline);

        @endphp

        // const second = 1000,
        // minute = second * 60,
        // hour = minute * 60,
        // day = hour * 24;

        // let countDown = new Date(" $ending_at ").getTime(),
        //     x = setInterval(function () {

        //         let now = new Date().getTime(),
        //         distance = countDown - now;

        //         console.log(distance);

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
