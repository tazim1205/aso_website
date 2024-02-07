@extends('marketing_panel.layout.app')
@push('title') {{ __('Marketer Statement') }} @endpush
@push('head')
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.16/css/jquery.dataTables.css">
@endpush
@section('content')
    <!-- select option row -->
    <div class="row mt-1">
        <div class="col-md-12">
            <div class="card card-background-blue">
                <div class="card-content">
                    <div class="card-body select-card-design">
                        <select name="district" id="district" class="form-control width-20-percent">
                            <option selected>Select District</option>
                            <option value="All">All</option>
                            @foreach(App\District::all() as $district)
                                <option value="{{$district->id}}">{{$district->name}}</option>
                            @endforeach
                        </select>
                        <select name="upazila" id="upazila" class="form-control width-20-percent">
                            <option selected>Upazila</option>
                            <option value="All">All</option>
                            @foreach(App\Upazila::all() as $upazila)
                                <option value="{{$upazila->id}}">{{$upazila->name}}</option>
                            @endforeach
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
                        <h4 class="card-title">Marketer Statement</h4>
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
                            <table id="datatable" class="table table-white-space table-bordered table-striped table-sm row-grouping display no-wrap icheck table-middle">
                                <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Username</th>
                                    <th>Total Income</th>
                                    <th>Total Paid</th>
                                    <th>Total Pending</th>
                                    <th>Full Details</th>
                                </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('foot')
    <script type="text/javascript" charset="utf8" src="//cdn.datatables.net/1.10.16/js/jquery.dataTables.js"></script>
    <script>
        $(document).ready( function () {
            function filter(district, upazila){
                var dataTable = $('#datatable').DataTable({
                    processing: true,
                    serverSide: true,
                    autoWidth: false,
                    pageLength: 10,
                    // scrollX: true,
                    "order": [[ 0, "desc" ]],
                    ajax: "{{  url('/filter/marketer/statement/') }}/"+district+"/"+upazila,
                    columns: [
                        {data: 'id', name: 'id'},
                        {data: 'user_name', name: 'user_name'},
                        {data: 'income', name: 'income'},
                        {data: 'paid', name: 'paid'},
                        {data: 'pending', name: 'pending'},
                        {data: 'Actions', name: 'Actions',orderable:false,serachable:false},
                    ]
                });
            }
            filter(0,0);

            $('#district').on('change', function(e){
                e.preventDefault();
                var district = $(this).val();
                $('#datatable').DataTable().destroy();
                filter(district,0);
            });

            $('#upazila').on('change', function(e){
                e.preventDefault();
                var upazila = $(this).val();
                $('#datatable').DataTable().destroy();
                filter(0,upazila);
            });

        });
    </script>
@endpush
