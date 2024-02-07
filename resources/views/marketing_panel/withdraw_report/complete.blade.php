@extends('marketing_panel.layout.app')
@push('title') {{ __('Complete Withdraw Report') }} @endpush
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
                        <select name="month" id="month" class="form-control width-20-percent">
                            <option value=''>--Select Month--</option>
                            <option value="All">All</option>
                            @for($i = 1; $i <= 12; $i++)
                                @php $monthNum  = $i; $dateObj= DateTime::createFromFormat('!m', $monthNum); $monthName = $dateObj->format('F'); @endphp
                                <option value="{{__($i) }}">{{__($monthName) }}</option>
                            @endfor
                        </select>
                        <select name="year" id="year" class="form-control width-20-percent">
                            <option value=''>--Select Year--</option>
                            <option value="All">All</option>
                            <option value="2021">2021</option>
                            <option value="2022">2022</option>
                            <option value="2023">2023</option>
                            <option value="2024">2024</option>
                            <option value="2025">2025</option>
                            <option value="2026">2026</option>
                            <option value="2027">2027</option>
                            <option value="2028">2028</option>
                            <option value="2029">2029</option>
                            <option value="2030">2030</option>
                            <option value="2031">2031</option>
                            <option value="2032">2032</option>
                            <option value="2033">2033</option>
                            <option value="2034">2034</option>
                            <option value="2035">2035</option>
                            <option value="2036">2036</option>
                            <option value="2037">2037</option>
                            <option value="2038">2038</option>
                            <option value="2039">2039</option>
                            <option value="2040">2040</option>
                            <option value="2041">2041</option>
                            <option value="2042">2042</option>
                            <option value="2043">2043</option>
                            <option value="2044">2044</option>
                            <option value="2045">2045</option>
                            <option value="2046">2046</option>
                            <option value="2047">2047</option>
                            <option value="2048">2048</option>
                            <option value="2049">2049</option>
                            <option value="2050">2050</option>
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
                        <h4 class="card-title">Withdraw Complete</h4>
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
                            <table id="datatable"
                                   class="table table-white-space table-bordered table-striped table-sm row-grouping display no-wrap icheck table-middle">
                                <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Paid Date</th>
                                    <th>Username</th>
                                    <th>Amount</th>
                                    <th>Via</th>
                                    <th>A/c Number</th>
                                    <th>A/C Details</th>
                                    <th>Paid Via</th>
                                    <th>Company A/C</th>
                                    <th>C.A/C Details</th>
                                    <th>Transaction id/info</th>
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
            function filter(district, upazila, month, year){
                var dataTable = $('#datatable').DataTable({
                    processing: true,
                    serverSide: true,
                    autoWidth: false,
                    pageLength: 10,
                    // scrollX: true,
                    "order": [[ 0, "desc" ]],
                    ajax: "{{  url('/filter/marketer/withdrawrequest/complete/') }}/"+district+"/"+upazila+"/"+month+"/"+year,
                    columns: [
                        {data: 'id', name: 'id'},
                        {data: 'date', name: 'date'},
                        {data: 'name', name: 'name',orderable:false,},
                        {data: 'amount', name: 'amount'},
                        {data: 'via', name: 'via'},
                        {data: 'ac_number', name: 'ac_number',orderable:false,},
                        {data: 'ac_details', name: 'ac_details',orderable:false,},
                        {data: 'paid_via', name: 'paid_via'},
                        {data: 'cac_number', name: 'cac_number'},
                        {data: 'cac_details', name: 'cac_details',orderable:false,},
                        {data: 'transaction_id', name: 'transaction_id',orderable:false,},
                    ]
                });
            }
            filter(0,0,0,0);

            $('#district').on('change', function(e){
                e.preventDefault();
                var district = $(this).val();
                $('#datatable').DataTable().destroy();
                filter(district,0,0,0);
            });

            $('#upazila').on('change', function(e){
                e.preventDefault();

                var upazila = $(this).val();

                $('#datatable').DataTable().destroy();
                filter(0,upazila,0,0);
            });

            $('#month').on('change', function(e){
                e.preventDefault();

                var month = $(this).val();

                $('#datatable').DataTable().destroy();
                filter(0,0,month,0);
            });

            $('#year').on('change', function(e){
                e.preventDefault();

                var year = $(this).val();
                $('#datatable').DataTable().destroy();
                filter(0,0,0,year);
            });

        });
    </script>
@endpush
