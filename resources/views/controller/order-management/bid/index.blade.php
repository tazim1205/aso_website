@extends('controller.layout.app')
@push('title') {{ __('Bid Order') }} @endpush

@push('head')
@endpush
@section('content')
<div class="app-content content">
    <div class="content-wrapper padding-top5">
        <div class="content-header row">
            <div class="content-body  container-fluid">
                <!-- Zero configuration table -->
                <section id="configuration">
                    <!-- select option row start -->
                    <div class="row mt-1">
                        <div class="col-md-12">
                            <div class="card card-background-blue margin-bottom-10">
                                <div class="card-content">
                                    <div class="card-body select-card-design">
                                        <h4 class="select-title white">Active Order</h4>
                                        <select name="month" class="form-control width-12-percent">
                                            <option value=''>--Select Month--</option>
                                            <option selected value='1'>Janaury</option>
                                            <option value='2'>February</option>
                                            <option value='3'>March</option>
                                            <option value='4'>April</option>
                                            <option value='5'>May</option>
                                            <option value='6'>June</option>
                                            <option value='7'>July</option>
                                            <option value='8'>August</option>
                                            <option value='9'>September</option>
                                            <option value='10'>October</option>
                                            <option value='11'>November</option>
                                            <option value='12'>December</option>
                                        </select>
                                        <select name="year" class="form-control width-10-percent">
                                            <option value=''>--Select Year--</option>
                                            <option value="2030">2030</option>
                                            <option value="2029">2029</option>
                                            <option value="2028">2028</option>
                                            <option value="2027">2027</option>
                                            <option value="2026">2026</option>
                                            <option value="2025">2025</option>
                                            <option value="2024">2024</option>
                                            <option selected value="2023">2023</option>
                                            <option value="2022">2022</option>
                                            <option value="2021">2021</option>
                                            <option value="2020">2020</option>
                                        </select>
                                        <select name="area" class="form-control width-20-percent">
                                            <option selected>Area</option>
                                            <option value="1">One</option>
                                            <option value="2">Two</option>
                                            <option value="3">Three</option>
                                        </select>
                                        <select name="Category" class="form-control width-15-percent">
                                            <option selected>Category</option>
                                            <option value="1">One</option>
                                            <option value="2">Two</option>
                                            <option value="3">Three</option>
                                        </select>
                                        <select name="service" class="form-control width-15-percent">
                                            <option selected>Service</option>
                                            <option value="1">One</option>
                                            <option value="2">Two</option>
                                            <option value="3">Three</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- select option row end -->

                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-head">
                                    <div class="card-header">
                                        <h4 class="card-title">Bid Order</h4>
                                        <div class="heading-elements visible">
                                            <ul class="list-inline mb-0">
                                                <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                                <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                                                <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <!-- Task List table -->
                                        <div class="table-responsive">
                                            <table id="users-contacts"
                                                class="table table-white-space table-bordered table-striped row-grouping display no-wrap icheck table-middle">
                                                <thead>
                                                    <tr>
                                                        <th>No.</th>
                                                        <th>Order Create Date</th>
                                                        <th>Order Number</th>
                                                        @if($status != 'pending')
                                                            <th>Price</th>
                                                        @endif
                                                        <th>Customer Username</th>
                                                        @if($status != 'pending')
                                                            <th>Worker Username</th>
                                                        @endif
                                                        <th>Total Bids</th>
                                                        <th>Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($bidOrder as $order)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>
                                                            {{ \Carbon\Carbon::parse($order->created_at)->format('d M, Y') }}
                                                        </td>
                                                        <td>
                                                            OD#{{ $order->id }}
                                                        </td>
                                                        @if($status != 'pending')
                                                            <td>
                                                                {{ $order->budget }}
                                                            </td>
                                                        @endif
                                                        <td>
                                                            {{ $order->customer->full_name ?? '' }}
                                                        </td>
                                                        @if($status != 'pending')
                                                            <td>
                                                                {{ $order->worker->full_name ?? '' }}
                                                            </td>
                                                        @endif
                                                        <td>
                                                            {{ $order->workerGig->click }}
                                                        </td>
                                                        <td>
                                                            <span class="dropdown">
                                                                <a href="#" data-toggle="modal" data-target="#view"
                                                                    class="btn btn-info viewOrder" id="{{$order->id}}">
                                                                    View
                                                                </a>
                                                                <button id="btnSearchDrop12" type="button"
                                                                    class="btn btn-sm btn-icon btn-pure font-medium-2"
                                                                    data-toggle="dropdown" aria-haspopup="true"
                                                                    aria-expanded="false">
                                                                    <i class="ft-more-vertical"></i>
                                                                </button>

                                                                <span aria-labelledby="btnSearchDrop12"
                                                                    class="dropdown-menu dropdown-menu-button">
                                                                    @if($order->status == 'active')
                                                                        <button type="button" class="dropdown-item cancel_button" id="{{$order->id}}">
                                                                            <i class="ft-disc"></i>
                                                                            Canceled
                                                                        </button>
                                                                        <button type="button" class="dropdown-item deleted-click" id="{{$order->id}}">
                                                                        <i class="ft-trash-2"></i>
                                                                        Delete
                                                                    </button>
                                                                    @endif
                                                                    @if($status == 'running')
                                                                            <a href="{{ route('controller.bid.order.complete',$order->id) }}" class="dropdown-item deleted-click">
                                                                        <i class="ft-activity"></i> Complete</a>
                                                                            <button type="button" class="dropdown-item cancel_button" id="{{$order->id}}">
                                                                            <i class="ft-disc"></i>
                                                                            Canceled
                                                                        </button>
                                                                    @endif
                                                                    @if($status == 'complete')
                                                                        <button type="button" class="dropdown-item cancel_button" id="{{$order->id}}">
                                                                        <i class="ft-disc"></i>
                                                                        Canceled
                                                                    </button>
                                                                        @endif
                                                                    @if($status == 'canceled')
                                                                            <a href="{{ route('controller.bid.order.complete',$order->id) }}" class="dropdown-item deleted-click">
                                                                        <i class="ft-activity"></i> Complete</a>

                                                                    @endif

                                                                </span>
                                                            </span>
                                                        </td>
                                                    </tr>
                                                    @endforeach


                                                </tbody>

                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!--/ Zero configuration table -->
                <!-- view Model start -->
                <div class="modal fade" id="view" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="title">
                                    Title: I need AC Repair
                                </h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>

                            <div class="modal-body">
                                <h3>Details:</h3>
                                <p id="details"></p>

                                <h3>Address</h3>
                                <p id="address"></p>
                                <hr>
                                <div class="time">
                                    <div class="title">
                                        <h2><span id="hours"></span> Time Hours</h2>

                                        <div class="time_count">
                                            <span class="days">02</span>
                                            <time>Days</time>
                                            <span class="hours">12</span>
                                            <time>Hours</time>
                                            <span class="minutes">15</span>
                                            <time>Minutes</time>
                                            <span class="secound">45</span>
                                            <time>Secound</time>
                                        </div>
                                    </div>
                                </div>

                                <div class="start_message">
                                    <span>Probable order start date and time:</span>
                                    <span><span id="time"></span>, <span id="date"></span></span>
                                </div>

                                <div class="bids">
                                    <p>Bids - Rating and Review</p>
                                    <div class="rating">
                                        <input type="radio" id="star5" name="rating" value="5" /><label
                                            for="star5"></label>
                                        <input type="radio" id="star4" name="rating" value="4" /><label
                                            for="star4"></label>
                                        <input type="radio" id="star3" name="rating" value="3" /><label
                                            for="star3"></label>
                                        <input type="radio" id="star2" name="rating" value="2" /><label
                                            for="star2"></label>
                                        <input type="radio" id="star1" name="rating" value="1" /><label
                                            for="star1"></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- view Model end -->
            </div>
            <!-- container-fluid end -->
        </div>
    </div>
</div>
<!-- END: Main Content end-->
@endsection
@push('foot')
    <script !src="">
        $(document).ready(function(){
        //      View Order
            $(".viewOrder").click(function () {
               var id = $(this).attr("id");
                $.ajax({
                    method: 'GET',
                    url: "/controller/bid-order-by-id/"+id,
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    dataType: 'JSON',
                    success: function (data) {
                        console.log(data);
                        $("#title").html(data.worker_gig.title)
                        $("#details").html(data.description)
                        $("#address").html(data.address)
                        $("#hours").html(data.worker_gig.day)
                        $("#time").html(data.time)
                        $("#date").html(data.date)
                    },
                    error: function (xhr) {
                        console.log(xhr);
                    },
                })
            });


        //     Cancel Order
            $('.cancel_button').click(function(){
                var id = $(this).attr("id");

                Swal.fire({
                    title: 'Are you sure?',
                    text: "You Want to Cancel this gig!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, Cancel it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            method: 'GET',
                            url: "/controller/bid-cancel/"+id,
                            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                            dataType: 'JSON',
                            success: function (data) {
                                Swal.fire({
                                    position: 'top-end',
                                    icon: 'danger',
                                    title: 'Successfully Cancel '+data.id,
                                    showConfirmButton: false,
                                    timer: 1500
                                })
                                setTimeout(function() {
                                    location.reload();
                                }, 800);//

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
            // Delete Button
            $('.deleted-click').click(function(){
                var id = $(this).attr("id");
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You Want to delete this gig!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, Delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            method: 'GET',
                            url: "/controller/bid-cancel/"+id,
                            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                            dataType: 'JSON',
                            success: function (data) {
                                Swal.fire({
                                    position: 'top-end',
                                    icon: 'danger',
                                    title: 'Successfully Deleted '+data.id,
                                    showConfirmButton: false,
                                    timer: 1500
                                })
                                setTimeout(function() {
                                    location.reload();
                                }, 800);//

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
        });
    </script>
@endpush
