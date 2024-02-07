@extends('controller.layout.app')
@push('title') {{ __('Special Service Orders') }} @endpush
@push('head')
	<link href="{{ asset('assets/plugins/fancybox/css/jquery.fancybox.min.css') }}" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.16/css/jquery.dataTables.css">
@endpush
@section('content')
    <div class="content-wrapper">
        <!-- Start container-fluid-->
        <div class="container-fluid">

            <!--Start Customer, Worker, Member, Controller Content-->
            <div class="row mt-4">
                <div class="col-12 col-sm-12 col-lg-12 col-xl-12 mt-2" id="tableDiv">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">{{ __('Special Service Orders') }}</h5>
                            <table  class="table" id="datatable">
                                <thead class="thead-defult shadow-defult">
                                <tr>
                                    <th>Order No</th>
                                    <th>Date</th>
                                    <th>Customer Name</th>
                                    <th>Price</th>
                                    <th>Service Name</th>
                                    <th>Upazila</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                    <th>Full Details</th>
                                </tr>
                                </thead>
                                <tbody>
                                {{--  impoterd by ajax datatable--}}
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                 
            </div>
            <!--End Row-->

            


            <!--Start Districe, Upazila, Ads, notice Content-->
        </div>
        <!-- End container-fluid-->
    </div>
@endsection
@push('foot')
	<script src="{{ asset('assets/plugins/fancybox/js/jquery.fancybox.min.js') }}"></script>
    <script type="text/javascript" charset="utf8" src="//cdn.datatables.net/1.10.16/js/jquery.dataTables.js"></script>
    <script>
        $(document).ready( function () {
            function filter(){
                var dataTable = $('#datatable').DataTable({
                    processing: true,
                    serverSide: true,
                    autoWidth: false,
                    pageLength: 10,
                    // scrollX: true,
                    "order": [[ 0, "desc" ]],
                    ajax: "{{  url('/get/customer/special/service/orders/') }}",
                    columns: [
                        {data: 'id', name: 'id'},
                        {data: 'date', name: 'date'},
                        {data: 'customer_name', name: 'customer_name'},
                        {data: 'fee', name: 'fee'},
                        {data: 'service', name: 'service'},
                        {data: 'upazila', name: 'upazila'},
                        {data: 'status', name: 'status',orderable:false,serachable:false,sClass:'text-center'},
                        {data: 'link', name: 'link',orderable:false,serachable:false,sClass:'text-center'},
                        {data: 'Actions', name: 'Actions',orderable:false,serachable:false,sClass:'text-center'},
                    ]
                });
            }
            filter();

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
                        $('#orderDetailsModal').modal('show');
                    },
                });
            });

        });
    </script>
@endpush

