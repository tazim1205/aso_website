@extends('marketing_panel.layout.app')
@push('title') {{ __('Dashboard') }} @endpush
@push('head')
    <!-- notifications css -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/notifications/css/lobibox.min.css') }}"/>
    <!-- Vector CSS -->
    <link href="{{ asset('assets/plugins/vectormap/jquery-jvectormap-2.0.2.css') }}" rel="stylesheet"/>
@endpush
@section('content')
    <!-- select option row -->
    <div class="row mt-1">
        <div class="col-md-12">
            <div class="card card-background-blue">
                <div class="card-content">
                    <div class="card-body select-card-design">
                        <select name="district" class="form-control width-20-percent" id="district">
                            <option selected>Select District</option>
                            <option value="All">All</option>
                            @foreach(App\District::all() as $district)
                                <option value="{{$district->id}}">{{$district->name}}</option>
                            @endforeach
                        </select>
                        <select class="form-control width-20-percent" name="upazila" id="upazila">
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

    <!-- card start -->
    <div class="row mt-1" id="reportDiv">
        Loading.....

    </div>
    <!-- card start -->
    <!-- row end -->
@endsection
@push('foot')
    <script type="text/javascript" charset="utf8" src="//cdn.datatables.net/1.10.16/js/jquery.dataTables.js"></script>
    <script>
        $(document).ready( function () {
            function filter(district, upazila, month, year){
                $.ajax({
                    url: "{{  url('/filter/marketer/dashboard/') }}/"+district+"/"+upazila+"/"+month+"/"+year,
                    type:"GET",
                    dataType : 'html',
                    success:function(data) {
                        console.log(data);
                        var d =$('#reportDiv').empty();
                        $('#reportDiv').html(data);
                    },
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
