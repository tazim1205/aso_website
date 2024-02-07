@extends('accountant.layout.app')

@section('title', 'Payment Report')

@section('content')
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
                            <table id="datatable" class="table table-white-space table-bordered table-striped row-grouping display no-wrap icheck table-middle">
                                <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Payment Date</th>
                                    <th>Username</th>
                                    <th>Amount</th>
                                    <th>Payment for</th>
                                    <th>Package name</th>
                                    <th>Via</th>
                                    <th>A/C number</th>
                                    <th>A/C details</th>
                                    <th>Transaction ID/info</th>
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
            function filter(){
                var dataTable = $('#datatable').DataTable({
                    processing: true,
                    serverSide: true,
                    autoWidth: false,
                    pageLength: 10,
                    // scrollX: true,
                    "order": [[ 0, "desc" ]],
                    ajax: "{{  route('accountant.earnings.member.payment.report') }}",
                    columns: [
                        {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                        {data: 'created_at', name: 'created_at'},
                        {data: 'user_id', name: 'user_id'},
                        {data: 'amount', name: 'amount'},
                        {data: 'package_name', name: 'package_name'},
                        {data: 'via', name: 'via'},
                        {data: 'ac_number', name: 'ac_number'},
                        {data: 'ac_details', name: 'ac_details'},
                        {data: 'tx_id', name: 'tx_id'},
                    ]
                });
            }
            filter();

        });
    </script>
@endpush
