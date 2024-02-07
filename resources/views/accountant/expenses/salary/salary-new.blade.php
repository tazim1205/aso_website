@extends('accountant.layout.app')

@section('title', 'New Salary Record')

@section('content')
    <!-- Net Income Statement select option row -->
    <div class="row mt-1">
        <div class="col-md-12">
            <div class="card card-background-blue">
                <div class="card-content">
                    <div class="card-body select-card-design">

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
        <i class="fa fa-plus"></i> Create new Salary
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
                    <form action="{{ route('accountant.expenses.salary.salary-new.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="date" class="col-form-label">Date</label>
                            <input type="date" class="form-control" id="date" name="date">
                        </div>
                        <div class="form-group">
                            <label for="salarymonth" class="col-form-label">Salary Month Select</label>
                            <select name="month" class="form-control">
                                <option value=''>--Select Month--</option>
                                <option value='January'>Janaury</option>
                                <option value='February'>February</option>
                                <option value='March'>March</option>
                                <option value='April'>April</option>
                                <option value='May'>May</option>
                                <option value='June'>June</option>
                                <option value='July'>July</option>
                                <option value='August'>August</option>
                                <option value='September'>September</option>
                                <option value='October'>October</option>
                                <option value='November'>November</option>
                                <option value='December'>December</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="amount" class="col-form-label">Amount</label>
                            <input type="number" class="form-control" placeholder="Enter Amount" name="amount" id="amount">
                        </div>
                        <div class="form-group">
                            <label for="salarymonth" class="col-form-label">Salary Category</label>
                            <select name="category" class="form-control">
                                <option value=''>--Select--</option>
                                <option value='director'>Director</option>
                                <option value='manager'>Manager</option>
                                <option value='marketing_manager'>Marketing Manager</option>
                                <option value='accountant'>Accountant</option>
                                <option value='marketing_panel_controller'>Marketing Panel Controller</option>
                                <option value='others'>Others</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="details" class="col-form-label">Details</label>
                            <textarea name="note" id="" cols="15" rows="10" class="form-control" placeholder="Enter details" id="details"></textarea>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Create new Salary</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!--Model end-->
    <h3>
        <i class="fa fa-list"></i> Salary List
    </h3>
    <hr>
    @if(Session::has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Success!</strong> {{ Session::get('success') }}
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
    @endif
    <div class="row" id="data">
        <!--Card 1-->

    </div>
@endsection
@push('js')
    <script>
        $(document).ready( function () {
            function filter(month, year){
                $.ajax({
                    url: "{{  url('/accountant/expenses/salary/salary-new/') }}/"+month+"/"+year,
                    type:"GET",
                    dataType : 'html',
                    success:function(data) {
                        var obj = JSON.parse(data);
                        console.log(obj)
                        $('#data').html(obj);
                    },
                });
            }
            filter(0,0);

            $('#month').on('change', function(e){
                e.preventDefault();
                var month = $(this).val();
                $('#datatable').DataTable().destroy();
                filter(month,0);
            });

            $('#year').on('change', function(e){
                e.preventDefault();
                var year = $(this).val();
                $('#datatable').DataTable().destroy();
                filter(0,year);
            });

        });
    </script>
@endpush
