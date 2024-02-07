@extends('accountant.layout.app')

@section('title', 'Area Ad Exp.')

@section('content')
    <!-- Net Income Statement select option row -->
    <div class="row mt-1">
        <div class="col-md-12">
            <div class="card card-background-blue">
                <div class="card-content">
                    <div class="card-body select-card-design">

                        <select name="district" id="district" class="form-control width-30-percent">
                            <option value=''>-Select District-</option>
                            <option value="All">All</option>
                            @foreach(App\District::all() as $district)
                                <option value="{{$district->id}}">{{$district->name}}</option>
                            @endforeach
                        </select>
                        <select name="upazila" id="upazila" class="form-control width-30-percent">
                            <option value=''>-Select Upazila-</option>
                            <option value="All">All</option>
                            @foreach(App\Upazila::all() as $upazila)
                                <option value="{{$upazila->id}}">{{$upazila->name}}</option>
                            @endforeach
                        </select>

                        <select name="month" id="month" class="form-control width-15-percent">
                            <option value=''>-Select Month-</option>
                            <option value="All">All</option>
                            @for($i = 1; $i <= 12; $i++)
                                @php $monthNum  = $i; $dateObj= DateTime::createFromFormat('!m', $monthNum); $monthName = $dateObj->format('F'); @endphp
                                <option value="{{__($i) }}">{{__($monthName) }}</option>
                            @endfor
                        </select>
                        <select name="year" id="year" class="form-control width-15-percent">
                            <option value=''>-Select Year-</option>
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
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#new_create">
        <i class="fa fa-plus"></i> Create New Area's Ad Exp.
    </button> <h3></h3>
    <!--Model Start-->
    <div class="modal fade" id="new_create" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('accountant.expenses.ad.ad-area.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="date" class="col-form-label">Exp. Date</label>
                            <input type="date" class="form-control" id="date" name="exp_date">
                        </div>
                        <div class="form-group">
                            <label for="district" class="col-form-label">Select District</label>
                            <select name="district" class="form-control">
                                <option value=''>--Select District--</option>
                                @foreach(App\District::all() as $district)
                                    <option value="{{$district->id}}">{{$district->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="upazila" class="col-form-label">Select Upazila</label>
                            <select name="upazila" class="form-control">
                                <option value=''>--Select Upazila--</option>
                                @foreach(App\Upazila::all() as $upazila)
                                    <option value="{{$upazila->id}}">{{$upazila->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="amount" class="col-form-label">Amount</label>
                            <input type="number" class="form-control" placeholder="Enter Amount" id="amount" name="amount">
                        </div>
                        <div class="form-group">
                            <label for="details" class="col-form-label">Details</label>
                            <textarea name="details" id="" cols="15" rows="10" class="form-control" placeholder="Enter details" id="details"></textarea>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Create New Company Fund Exp.</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!--Model end-->
    <hr>
    @if(Session::has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Success!</strong> {{ Session::get('success') }}
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
    @endif
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-head">
                    <div class="card-header">
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
                            <table id="datatable" class="table table-white-space table-bordered table-striped row-grouping display no-wrap icheck table-middle">
                                <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Exp. Date</th>
                                    <th>District</th>
                                    <th>Upazila</th>
                                    <th>Amount</th>
                                    <th>Details</th>
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
@push('js')

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
                    ajax: "{{  url('/accountant/expenses/ad/ad-area-report/') }}/"+district+"/"+upazila+"/"+month+"/"+year,
                    columns: [
                        {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                        {data: 'exp_date', name: 'exp_date'},
                        {data: 'district', name: 'district'},
                        {data: 'upazila', name: 'upazila'},
                        {data: 'amount', name: 'amount'},
                        {data: 'details', name: 'details', orderable:false, serachable:false,},
                    ]
                });
            }
            filter(0,0,0,0);

            $('#district').on('change', function(e){
                console.log("Hello")
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
