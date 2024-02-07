@extends('accountant.layout.app')

@section('title', 'Profit and Pay')

@section('content')
    <div class="row mt-1">
        <div class="col-md-12">
            <div class="card card-background-blue">
                <div class="card-content">
                    <div class="card-body select-card-design">
                        <form action="{{ request()->url() }}">
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
                            <table id="users-contacts" class="table table-white-space table-bordered table-striped row-grouping display no-wrap icheck table-middle">
                                <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Month</th>
                                    <th>Upazila</th>
                                    <th>Total Income</th>
                                    <th>Aff. marketer exp.</th>
                                    <th>Earning after Aff. Marketing exp.</th>
                                    <th>Marketing fund reserve {{ get_static_option('marketing_fund_reserve') }}%</th>
                                    <th>Area's marketing fund {{  get_static_option('area_marketing_fund') }}%</th>
                                    <th>Net income</th>
                                    <th>Area Controller's Profit {{ get_static_option('area_controller_percent') }}%</th>
                                    <th>Bonus</th>
                                    <th>Net profit</th>
                                    <th>Status</th>
                                    <th>Pay now</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $val)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            @php
                                                $month = "";
                                                if(array_key_exists('month_name', $val)){
                                                    $month = $val['month_name'];
                                                }
                                            @endphp
                                            {{ $month }}
                                        </td>
                                        <td>
                                            @php
                                                $upazila = "";
                                                if(array_key_exists('upazila_name', $val)){
                                                    $upazila = $val['upazila_name'];
                                                }
                                            @endphp
                                            {{ $upazila }}
                                        </td>
                                        <td>
                                        @php
                                            $sum = 0;
                                            if(array_key_exists('bid_income', $val)){
                                                $sum +=  $val['bid_income'];
                                            }
                                            if(array_key_exists('gig_income', $val)){
                                                $sum +=  $val['gig_income'];
                                            }
                                            if(array_key_exists('membership_income', $val)){
                                                $sum +=  $val['membership_income'];
                                            }
                                            if(array_key_exists('local_ad_income', $val)){
                                                $sum +=  $val['local_ad_income'];
                                            }
                                            if(array_key_exists('order_income', $val)){
                                                $sum +=  $val['order_income'];
                                            }
                                        @endphp
                                        {{ $sum }}
                                        </td>
                                        <td>
                                            @php
                                                $aff_marketer_exp = 0;
                                                if(array_key_exists('aff_expense', $val)){
                                                    $aff_marketer_exp +=$val['aff_expense']; 
                                                }
                                            @endphp
                                            {{ $aff_marketer_exp }}
                                        </td>
                                        <td>
                                            @php
                                                $earningAfterExp = $sum - $aff_marketer_exp;
                                            @endphp
                                            {{ $earningAfterExp }}
                                        </td>
                                        <td>
                                            @php
                                                $reserve_percentage = get_static_option('marketing_fund_reserve');
                                                $marketing_fund_reserve = $earningAfterExp * ($reserve_percentage/100);
                                            @endphp
                                            {{ $marketing_fund_reserve }}
                                        </td>
                                        <td>
                                            @php
                                                $percentage = get_static_option('area_marketing_fund');
                                                $area_fund_reserve = $marketing_fund_reserve * ($percentage/100);
                                            @endphp
                                            {{ $area_fund_reserve }}
                                        </td>
                                        <td>
                                            @php
                                                $netIncome = $earningAfterExp - $marketing_fund_reserve;
                                            @endphp
                                            {{ $netIncome }}
                                        </td>
                                        <td>
                                            @php
                                                $area_controller_profit =  $netIncome * (get_static_option('area_controller_percent')/100);
                                            @endphp
                                            {{ $area_controller_profit }}
                                        </td>
                                        <td>
                                            @php
                                                $amount_for_bonus = get_static_option('amount_for_bonus');
                                                $get_bonus = get_static_option('get_bonus');
                                                $floor = floor($earningAfterExp /$amount_for_bonus );
                                                $bonus = $floor * $get_bonus;
                                            @endphp
                                            {{ $bonus }}
                                        </td>
                                        <td>
                                            {{ $area_controller_profit + $bonus }}
                                        </td>
                                        <td>
                                            @php
                                                $payment = App\AreaControllerPayment::where('month', $month)
                                                                ->where('upazila', $upazila)->exists();
                                            @endphp
                                            @if ($payment)
                                                <span class="badge badge-primary">Complete</span>
                                            @else
                                                <span class="badge badge-warning">Pending</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if (!$payment)
                                            <a 
                                            data-month="{{ $month }}"
                                            data-upazila="{{ $upazila }}"
                                            data-amount = "{{ $area_controller_profit + $bonus }}"
                                            href="#" 
                                            data-toggle="modal" 
                                            data-target="#view"
                                            class="btn btn-info btn-pay">
                                                Pay
                                            </a>
                                            @else
                                                <strong class="text-success">Already Paid</strong>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach                                
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td> 01</td>
                                        <td>
                                            Nov
                                        </td>
                                        <td>
                                            Feni
                                        </td>
                                        <td>
                                            5,00,000
                                        </td>
                                        <td>
                                            50,000
                                        </td>
                                        <td>
                                            4,50,000
                                            <p class="red">(Total income-Merkt. exp)<p/>
                                        </td>
                                        <td>
                                            90,000
                                            <p class="red">(Earning after Merkt. exp * 20%)<p/>
                                        </td>
                                        <td>
                                            72,000
                                            <p class="red">(Marketing Fund R. * 80%)<p/>
                                        </td>
                                        <td>
                                            3,60,000
                                            <p class="red">(4,5000 - 90,000)<p/>
                                        </td>
                                        <td>
                                            1,80,000
                                            <p class="red">(Net income*50%)<p/>
                                        </td>
                                        <td>
                                            40,000
                                            <p class="red">(বোনাসের শর্ত অনুযায়ী বোনাস হিসাব হবে,,
                                                শর্তাবলী একটা ছবিতে দেওয়া হবে।)<p/>
                                        </td>
                                        <td>
                                            2,20,000
                                            <p class="red">(1,80,000+40,000)<p/>
                                        </td>
                                        <td>
                                            <span class="dropdown">
                                                <button id="btnSearchDrop12" type="button"
                                                        class="btn btn-sm btn-icon btn-pure font-medium-2"
                                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="ft-more-vertical"></i>
                                                </button>

                                                <span aria-labelledby="btnSearchDrop12"
                                                        class="dropdown-menu dropdown-menu-button">
                                                    <a href="#" class="dropdown-item deleted-click">
                                                        <i class="ft-disc"></i>
                                                        Pending
                                                    </a>
                                                    <a href="#" class="dropdown-item">
                                                        <i class="ft-check-circle"></i>
                                                        Complete
                                                    </a>
                                                </span>
                                            </span>
                                        </td>
                                        <td>
                                            <a href="#" data-toggle="modal" data-target="#view"
                                               class="btn btn-info btn-pay">
                                                Pay
                                            </a>
                                            <p class="red">Completed<p/>
                                        </td>
                                    </tr>
                                </tfoot>

                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- view Model start -->
    <div class="modal fade" id="view" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
       <div class="modal-content">
          <div class="modal-header card-background-blue">
             <h5 class="modal-title" id="exampleModalLabel">
                Pay Now
             </h5>
          </div>
          <div class="modal-body">
             <form action="{{ route('accountant.expenses.area-controller.profit-and-pay-store') }}" method="POST">
                @csrf
                <input type="hidden" name="upazila" id="view_upazila">
                <input type="hidden" name="month" id="view_month">
                <label for="amount">Amount</label>
                <input type="text" id="view_amount" name="amount" class="form-control mb-1" readonly>

                <label for="date">Date</label>
                <input type="date" id="date" name="date" class="form-control mb-1" required>

                <label for="ac-number">Controller A/C number</label>
                <input type="number" id="ac-number" name="controller_ac_number" class="form-control mb-1" required>

                <label for="ac-details">Controller A/C Details</label>
                <input type="text" id="ac-details" name="controller_ac_details" value="" class="form-control mb-1" required>

                <label for="com-ac-number">Company A/C number</label>
                <input type="number" id="com-ac-number" name="company_ac_number" class="form-control mb-1" required>

                <label for="com-ac-details">Company A/C Details</label>
                <input type="text" id="com-ac-details" name="company_ac_details" value="" class="form-control mb-1" required>

                <label for="transaction">Transaction id/info</label>
                <input type="text" id="transaction" name="transaction_id" value="" class="form-control mb-1" required>

                <button type="submit" class="btn btn-primary">Submit</button>
             </form>
          </div>
       </div>
    </div>
 </div>
 <!-- view Model end -->
@endsection

@push('js')
    <script>
        $(document).ready(function () {
            $(".btn-pay").click(function (e) { 
                e.preventDefault();
                var month = $(this).attr("data-month");
                var upazila = $(this).attr("data-upazila");
                var amount = $(this).attr("data-amount");
                console.log(month);
                $("#view_upazila").val(upazila);
                $("#view_month").val(month);
                $("#view_amount").val(amount);
            });
        });
    </script>
@endpush