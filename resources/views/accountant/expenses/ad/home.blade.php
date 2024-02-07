@extends('accountant.layout.app')

@section('title', 'Ad Expenses Home')

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
    <!-- card start -->
    <div class="row">
        <!--Card 1-->
        <div class="col-12 col-sm-6 col-lg-6 col-xl-3 col-md-3">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        <div class="media d-flex">
                            <div class="media-body text-left align-self-bottom">
                                <span class="d-block mb-1 font-medium-1">Total Ad Exp.</span>
                                <h5 class="mb-0 font-weight-bolder" id="total_exp">Loading...</h5>
                            </div>
                            <div class="align-self-top">
                                <i class="material-icons dark-blue font-large-3">account_balance_wallet
                                </i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--Card 2-->
        <div class="col-12 col-sm-6 col-lg-6 col-xl-3 col-md-3">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        <div class="media d-flex">
                            <div class="media-body text-left align-self-bottom">
                                <span class="d-block mb-1 font-medium-1">Total Cmpany Global Ad Exp.</span>
                                <h5 class="mb-0 font-weight-bolder" id="total_global_exp">Loading...</h5>
                            </div>
                            <div class="align-self-top">
                                <i class="material-icons dark-blue font-large-3">account_balance_wallet
                                </i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-lg-6 col-xl-3 col-md-3">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        <div class="media d-flex">
                            <div class="media-body text-left align-self-bottom">
                                <span class="d-block mb-1 font-medium-1">Total Area's Ad Exp.</span>
                                <h5 class="mb-0 font-weight-bolder" id="total_area_exp">Loading...</h5>
                            </div>
                            <div class="align-self-top">
                                <i class="material-icons dark-blue font-large-3">account_balance_wallet
                                </i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- card end -->
@endsection
@push('js')
    <script>
        $(document).ready( function () {
            function filter(month, year){
                $.ajax({
                    url: "{{  url('/accountant/expenses/ad/home/') }}/"+month+"/"+year,
                    type:"GET",
                    dataType : 'html',
                    success:function(data) {
                        var obj = JSON.parse(data);
                        console.log(obj)
                        $('#total_exp').html(obj.total_expense);
                        $('#total_global_exp').html(obj.total_ad_expense);
                        $('#total_area_exp').html(obj.total_area_ad_expense);
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
