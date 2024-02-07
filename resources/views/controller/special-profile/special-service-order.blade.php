@extends('controller.layout.app')
@push('title') {{ __('Special Service Orders') }} @endpush
@push('head')
<link href="{{ asset('assets/plugins/fancybox/css/jquery.fancybox.min.css') }}" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.16/css/jquery.dataTables.css">
@endpush
@section('content')
<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-body  container-fluid">
                <!-- Zero configuration table -->
                <section id="configuration">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-head">
                                    <div class="card-header">
                                        <h4 class="card-title">Special Service {{$status}} Orders</h4>
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
                                                        <th>Create Date</th>
                                                        @if($status == 'running')
                                                            <th>Running Date</th>
                                                        @endif
                                                        @if($status == 'complete')
                                                            <th>Running Date</th>
                                                            <th>Complete Date</th>
                                                        @endif
                                                        @if($status == 'cancel')
                                                            <th>Running Date</th>
                                                            <th>Cancel Date</th>
                                                        @endif
                                                        <th>Order Number</th>
                                                        <th>Customer Name</th>
                                                        <th>Mobile Number</th>
                                                        <th>Price</th>
                                                        <th>Service Name</th>
                                                        <th>Area</th>
                                                        <th>Full Details</th>
                                                        <th>Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($data as $ss)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>
                                                            <span>{{ \Carbon\Carbon::parse($gig->created_at)->format('d M, Y') }}</span>
                                                        </td>
                                                        @if($status == 'running')
                                                            <td>
                                                                <span>{{ \Carbon\Carbon::parse($gig->running_date)->format('d M, Y') }}</span>
                                                            </td>
                                                        @endif
                                                        @if($status == 'complete')
                                                            <td>
                                                                <span>{{ \Carbon\Carbon::parse($gig->running_date)->format('d M, Y') }}</span>
                                                            </td>
                                                            <td>
                                                                <span>{{ \Carbon\Carbon::parse($gig->complete_date)->format('d M, Y') }}</span>
                                                            </td>
                                                        @endif
                                                        @if($status == 'cancel')
                                                            <td>
                                                                <span>{{ \Carbon\Carbon::parse($gig->running_date)->format('d M, Y') }}</span>
                                                            </td>
                                                            <td>
                                                                <span>{{ \Carbon\Carbon::parse($gig->cancel_date)->format('d M, Y') }}</span>
                                                            </td>
                                                        @endif
                                                        <td>
                                                            <span>{{ $ss->order_no }}</span>
                                                        </td>
                                                        <td>
                                                            <span>{{ $ss->customer->full_name }}</span>
                                                        </td>
                                                        <td>
                                                            <span>{{ $ss->customer->phone }}</span>
                                                        </td>
                                                        <td>
                                                            <span>{{ $ss->fee }}</span>
                                                        </td>
                                                        <td>
                                                            <span>{{ $ss->service->name }}</span>
                                                        </td>
                                                        <td>
                                                            <a href="#" data-toggle="modal" data-target="#area"
                                                                class="btn btn-info">
                                                                <i class="fa fa-eye" aria-hidden="true"></i>
                                                            </a>
                                                        </td>
                                                        <td>
                                                            <a href="#" data-toggle="modal" data-target="#view"
                                                                class="btn btn-info seeBtn" id="{{$ss->id}}">
                                                                <i class="fa fa-eye" aria-hidden="true"></i>
                                                            </a>
                                                        </td>
                                                        <td>
                                                            <span class="dropdown">
                                                                <button id="btnSearchDrop12" type="button"
                                                                    class="btn btn-sm btn-icon btn-pure font-medium-2"
                                                                    data-toggle="dropdown" aria-haspopup="true"
                                                                    aria-expanded="false">
                                                                    <i class="ft-more-vertical"></i>
                                                                </button>

                                                                <span aria-labelledby="btnSearchDrop12"
                                                                    class="dropdown-menu dropdown-menu-button">
                                                                    @if($status == 'pending')
                                                                        <a href="'{{route('controller.specialorder.running',$ss->id)}}" data-toggle="modal" data-target="#edit"
                                                                           class="dropdown-item">
                                                                        <i class="ft-activity"></i> Mark as Running</a>
                                                                        <a href="{{route('controller.specialorder.cancel',$ss->id)}}" class="dropdown-item">
                                                                        <i class="ft-alert-circle"></i> Mark as
                                                                        Canceled</a>
                                                                    @elseif($status == 'running')
                                                                        <a href="'{{route('controller.specialorder.complete',$ss->id)}}" data-toggle="modal" data-target="#edit"
                                                                           class="dropdown-item">
                                                                        <i class="ft-activity"></i> Mark as Complete</a>
                                                                        <a href="{{route('controller.specialorder.cancel',$ss->id)}}" class="dropdown-item">
                                                                        <i class="ft-alert-circle"></i> Mark as
                                                                        Canceled</a>
                                                                    @elseif($status == 'complete')
                                                                        <a href="'{{route('controller.specialorder.running',$ss->id)}}" data-toggle="modal" data-target="#edit"
                                                                           class="dropdown-item">
                                                                        <i class="ft-activity"></i> Mark as Running</a>
                                                                        <a href="{{route('controller.specialorder.cancel',$ss->id)}}" class="dropdown-item">
                                                                        <i class="ft-alert-circle"></i> Mark as
                                                                        Canceled</a>
                                                                    @elseif($status == 'cancel')
                                                                        <a href="'{{route('controller.specialorder.running',$ss->id)}}" data-toggle="modal" data-target="#edit"
                                                                           class="dropdown-item">
                                                                        <i class="ft-activity"></i> Mark as Running</a>
                                                                        <a href="'{{route('controller.specialorder.complete',$ss->id)}}" data-toggle="modal" data-target="#edit"
                                                                           class="dropdown-item">
                                                                        <i class="ft-activity"></i> Mark as Complete</a>
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

                <!-- Area Model start -->
                <div class="modal fade" id="area" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">

                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>

                            <div class="modal-body">
                                <form action="#" method="POST">
                                    <label for="uf">উপজেলা/মেট্টো থানা</label>
                                    <select class="form-control" id="uf" aria-label="Default select example">
                                        <option value="1" selected>Sonagazi</option>
                                    </select>
                                    <br>
                                    <label for="fu">পৌরসভা/ইউনিয়ন</label>
                                    <select class="form-control" id="fu" aria-label="Default select example">
                                        <option value="1" selected>Baliga Union</option>
                                    </select>
                                    <br>
                                    <label for="word">ওয়ার্ড নং</label>
                                    <select class="form-control" id="word" aria-label="Default select example">
                                        <option value="1" selected>One</option>
                                    </select>

                                    <br>
                                    <a href="#" class="btn btn-info">See Location</a>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Area Model end -->

                <!-- view Model start -->
                <div class="modal fade" id="view" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">

                                </h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>

                            <div class="modal-body" id="orderDetailsModalContent">
                                অর্ডারের ডিটেইস দেখা যাবে পপ আপে। Price এর পাশে ইডিট বাটন থাকবে, অর্থাৎ, এখান থেকে
                                অর্ডার অনুযায়ী একটা প্রাইস বসাই দিবে এরিয়া কন্ট্রোলার।
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
<script src="{{ asset('assets/plugins/fancybox/js/jquery.fancybox.min.js') }}"></script>
<script type="text/javascript" charset="utf8" src="//cdn.datatables.net/1.10.16/js/jquery.dataTables.js"></script>
<script>
    $(document).ready( function () {

            $(document).on('click', '.seeBtn', function(e){
                e.preventDefault();
                var id = $(this).attr("id");
                $.ajax({
                    url: "{{  url('/get/customer/special/service/orders/details/') }}/"+id,
                    type:"GET",
                    dataType : 'html',
                    success:function(data) {
                        var d =$('#orderDetailsModalContent').empty();
                        $('#orderDetailsModalContent').html(data);
                        $('#view').modal('show');
                    },
                });
            });

        });
</script>
@endpush
