@extends('accountant.layout.app')

@section('title', 'Accountant Panel')

@push('css')
    <style>
        thead.thead_dashboard {
            background-color: #F36523;
            color: white;
            font-weight: bold;
            text-align: center;
        }
        tr.total_tr {
            background-color: #f35c15;
            color: white;
            font-weight: bold;
        }
        tr.net_income_tr {
            background-color: #44C333;
            color: white;
            font-weight: bold;
            font-size: 20px;
        }
    </style>
@endpush

@section('content')
    <!-- top select option row -->
    <div class="row mt-1">
        <div class="col-md-12">
            <div class="card card-background-blue">
                <div class="card-content">
                    <div class="card-body select-card-design">
                        <form action="{{ request()->url() }}">
                            <select name="district" id="district" class="form-control width-20-percent">
                                <option selected>--Select District--</option>
                                <option value="All"  @if(request()->get('district') == 'All') selected @endif>All</option>
                                @foreach(App\District::all() as $district)
                                    <option value="{{$district->id}}" @if(request()->get('district') == $district->id) selected @endif>{{$district->name}}</option>
                                @endforeach
                            </select>
                            <select name="upazila" id="upazila" class="form-control width-20-percent">
                                <option selected>--Select Upazilla--</option>
                                <option value="All" @if(request()->get('upazila') == 'All') selected @endif>All</option>
                                @foreach(App\Upazila::all() as $upazila)
                                    <option value="{{$upazila->id}}" @if(request()->get('upazila') == $upazila->id) selected @endif>{{$upazila->name}}</option>
                                @endforeach
                            </select>
                            <button type="submit" class="btn btn-primary">Apply</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- select option row end -->
    <!-- Company Net Income card start -->
    <div class="row">
        <!--Card 1-->
        <div class="col-12 col-sm-6 col-lg-6 col-xl-3 col-md-3">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        <div class="media d-flex">
                            <div class="media-body text-left align-self-bottom">
                                <span class="d-block mb-1 font-medium-1">Lifetime Earnings</span>
                                <h5 class="mb-0 font-weight-bolder">{{ $totalEarnings }}</h5>
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
                                <span class="d-block mb-1 font-medium-1">Lifetime Exp.</span>
                                <h5 class="mb-0 font-weight-bolder">{{ $totalExpense }}</h5>
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
        <!--Card 3-->
        <div class="col-12 col-sm-6 col-lg-6 col-xl-3 col-md-3">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        <div class="media d-flex">
                            <div class="media-body text-left align-self-bottom">
                                <span class="d-block mb-1 font-medium-1">Lifetime Net Income</span>
                                <h5 class="mb-0 font-weight-bolder">{{ $totalNetIncome }}</h5>
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
        <!--Card 4 -->
        <div class="col-12 col-sm-6 col-lg-6 col-xl-3 col-md-3">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        <div class="media d-flex">
                            <div class="media-body text-left align-self-bottom">
                                <span class="d-block mb-1 font-medium-1">Total Area Controller</span>
                                <h5 class="mb-0 font-weight-bolder">{{ $totalAreaController }}</h5>
                            </div>
                            <div class="align-self-top">
                                <i class="material-icons dark-blue font-large-3">people_outline
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
                                <span class="d-block mb-1 font-medium-1">Total Customer</span>
                                <h5 class="mb-0 font-weight-bolder">{{ $totalCustomer }}</h5>
                            </div>
                            <div class="align-self-top">
                                <i class="material-icons dark-blue font-large-3">people_outline
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
                                <span class="d-block mb-1 font-medium-1">Total Service Provider</span>
                                <h5 class="mb-0 font-weight-bolder">{{ $totalWorker }}</h5>
                            </div>
                            <div class="align-self-top">
                                <i class="material-icons dark-blue font-large-3">people_outline
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
                                <span class="d-block mb-1 font-medium-1">Total Active Membership</span>
                                <h5 class="mb-0 font-weight-bolder">{{ $totalMembership }}</h5>
                            </div>
                            <div class="align-self-top">
                                <i class="material-icons dark-blue font-large-3">people_outline
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
                                <span class="d-block mb-1 font-medium-1">Total Aff. Marketer</span>
                                <h5 class="mb-0 font-weight-bolder">{{ $totalAffMarketer }}</h5>
                            </div>
                            <div class="align-self-top">
                                <i class="material-icons dark-blue font-large-3">people_outline
                                </i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- top card end -->
    <!-- Company Net Income select option row -->
    <div class="row mt-1">
        <div class="col-md-12">
            <div class="card card-background-blue">
                <div class="card-content">
                    <div class="card-body select-card-design">
                        <h4 class="select-title white width-100-percent">Company Net Income Statement</h4>
                        <form action="{{ request()->url() }}">
                            <select name="district" id="district" class="form-control width-20-percent">
                                <option selected>--Select District--</option>
                                <option value="All"  @if(request()->get('district') == 'All') selected @endif>All</option>
                                @foreach(App\District::all() as $district)
                                    <option value="{{$district->id}}" @if(request()->get('district') == $district->id) selected @endif>{{$district->name}}</option>
                                @endforeach
                            </select>
                            <select name="upazila" id="upazila" class="form-control width-20-percent">
                                <option selected>--Select Upazilla--</option>
                                <option value="All" @if(request()->get('upazila') == 'All') selected @endif>All</option>
                                @foreach(App\Upazila::all() as $upazila)
                                    <option value="{{$upazila->id}}" @if(request()->get('upazila') == $upazila->id) selected @endif>{{$upazila->name}}</option>
                                @endforeach
                            </select>
                            <select name="month" id="month" class="form-control width-20-percent">
                                <option selected>--Select Month--</option>
                                <option value="All" @if(request()->get('month') == 'All') selected @endif>All</option>
                                @for($i = 1; $i <= 12; $i++)
                                    @php $monthNum  = $i; $dateObj= DateTime::createFromFormat('!m', $monthNum); $monthName = $dateObj->format('F'); @endphp
                                    <option value="{{__($i) }}" @if(request()->get('month') == $i) selected @endif>{{__($monthName) }}</option>
                                @endfor
                            </select>
                            <select name="year" id="year" class="form-control width-20-percent">
                                <option selected>--Select Year--</option>
                                <option value="All" @if(request()->get('year') == 'All') selected @endif>All</option>
                                <option value="2021" @if(request()->get('year') == '2021') selected @endif>2021</option>
                                <option value="2022" @if(request()->get('year') == '2022') selected @endif>2022</option>
                                <option value="2023" @if(request()->get('year') == '2023') selected @endif>2023</option>
                                <option value="2024" @if(request()->get('year') == '2024') selected @endif>2024</option>
                                <option value="2025" @if(request()->get('year') == '2025') selected @endif>2025</option>
                                <option value="2026" @if(request()->get('year') == '2026') selected @endif>2026</option>
                                <option value="2027" @if(request()->get('year') == '2027') selected @endif>2027</option>
                                <option value="2028" @if(request()->get('year') == '2028') selected @endif>2028</option>
                                <option value="2029" @if(request()->get('year') == '2029') selected @endif>2029</option>
                                <option value="2030" @if(request()->get('year') == '2030') selected @endif>2030</option>
                                <option value="2031" @if(request()->get('year') == '2031') selected @endif>2031</option>
                                <option value="2032" @if(request()->get('year') == '2032') selected @endif>2032</option>
                                <option value="2033" @if(request()->get('year') == '2033') selected @endif>2033</option>
                                <option value="2034" @if(request()->get('year') == '2034') selected @endif>2034</option>
                                <option value="2035" @if(request()->get('year') == '2035') selected @endif>2035</option>
                                <option value="2036" @if(request()->get('year') == '2036') selected @endif>2036</option>
                                <option value="2037" @if(request()->get('year') == '2037') selected @endif>2037</option>
                                <option value="2038" @if(request()->get('year') == '2038') selected @endif>2038</option>
                                <option value="2039" @if(request()->get('year') == '2039') selected @endif>2039</option>
                                <option value="2040" @if(request()->get('year') == '2040') selected @endif>2040</option>
                                <option value="2041" @if(request()->get('year') == '2041') selected @endif>2041</option>
                                <option value="2042" @if(request()->get('year') == '2042') selected @endif>2042</option>
                                <option value="2043" @if(request()->get('year') == '2043') selected @endif>2043</option>
                                <option value="2044" @if(request()->get('year') == '2044') selected @endif>2044</option>
                                <option value="2045" @if(request()->get('year') == '2045') selected @endif>2045</option>
                                <option value="2046" @if(request()->get('year') == '2046') selected @endif>2046</option>
                                <option value="2047" @if(request()->get('year') == '2047') selected @endif>2047</option>
                                <option value="2048" @if(request()->get('year') == '2048') selected @endif>2048</option>
                                <option value="2049" @if(request()->get('year') == '2049') selected @endif>2049</option>
                                <option value="2050" @if(request()->get('year') == '2050') selected @endif>2050</option>
                            </select>
                            <button type="submit" class="btn btn-primary">Apply</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- select option row end -->
    <!-- Company Net Income card start -->
    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table table-white-space table-bordered table-striped row-grouping display no-wrap icheck table-middle">
                    <thead class="thead_dashboard">
                        <tr>
                            <th>Details</th>
                            <th>TK</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><h3 class="font-weight-bold" style="color: #760807">Earnings</h3></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td><h5 class="font-weight-bold text-center" style="color: #F35C15">Earnings From Area Controller</h5></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td class="text-right">Worker Income</td>
                            <td>{{ $workerIncome }}</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td class="text-right">Membership Income</td>
                            <td>{{ $membershipIncome }}</td>
                            <td></td>
                        </tr>
                        <tr>                            
                            <td class="text-right">Special Service Income</td>
                            <td>{{ $specilaServiceIncome }}</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td>{{ $areaControllerEarnings }}</td>
                        </tr>
                        <tr>
                            <td class="text-right">Earnings from Others</td>
                            <td>{{ $othersIncome }}</td>
                            <td></td>
                        </tr>
                        <tr class="total_tr">
                            <td class="text-right">Total Earning</td>
                            <td></td>
                            <td>{{ $totalEarnings }}</td>
                        </tr>
                        <tr>
                            <td><h3 class="font-weight-bold" style="color: #760807">Expense</h3></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td><h5 class="font-weight-bold text-center" style="color: #F35C15">Area Controller Expense</h5></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td class="text-right">Area Controller Profit</td>
                            <td>{{ $areaControllerProfit }}</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td class="text-right">Marketing Fund Reserve</td>
                            <td>{{ $marketingFundReserve }}</td>
                            <td></td>
                        </tr>
                        <tr>                            
                            <td class="text-right">Aff Marketing Cost</td>
                            <td>{{ $affMarketingCost }}</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td>{{ $areaControllerExpense }}</td>
                        </tr>
                        <tr>
                            <td class="text-right">Ad Expense</td>
                            <td>{{ $adExpense }}</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td class="text-right">Salary Expense</td>
                            <td>{{ $salaryExpense }}</td>
                            <td></td>
                        </tr>
                        <tr>                            
                            <td class="text-right">Other Expense</td>
                            <td>{{ $othersExpense }}</td>
                            <td></td>
                        </tr>
                        <tr class="total_tr">
                            <td class="text-right">Total Expense</td>
                            <td></td>
                            <td>{{ $totalExpense }}</td>
                        </tr>                       
                    </tbody>
                    <tfoot>
                         <tr class="net_income_tr">
                            <th class="text-center">Net Income</th>
                            <th></th>
                            <th>{{ $netIncome }}</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
    <!-- Company Net Income card end -->
@endsection
