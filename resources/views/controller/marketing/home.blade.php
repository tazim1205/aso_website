@extends('controller.layout.app')
@push('title') {{ __('Marketing Fund') }} @endpush

@push('head')
@endpush
@section('content')
<!-- BEGIN: Main Content start-->
<div class="app-content content">
    <div class="content-wrapper padding-top5">
        <div class="content-header row">
            <div class="content-body  container-fluid">
                <div class="row mt-1">
                    <div class="col-md-12">
                        <div class="card card-background-blue">
                            <div class="card-content">
                                <div class="card-body select-card-design">
                                    <h4 class="select-title white">Marketing Fund - Home</h4>

                                    <select name="month" class="form-control width-30-percent">
                                        <option value=''>--Select Month--</option>
                                        <option selected value='1'>Janaury</option>
                                        <option value='2'>February</option>
                                        <option value='3'>March</option>
                                        <option value='4'>April</option>
                                        <option value='5'>May</option>
                                        <option value='6'>June</option>
                                        <option value='7'>July</option>
                                        <option value='8'>August</option>
                                        <option value='9'>September</option>
                                        <option value='10'>October</option>
                                        <option value='11'>November</option>
                                        <option value='12'>December</option>
                                    </select>
                                    <select name="year" class="form-control width-25-percent">
                                        <option value=''>--Select Year--</option>
                                        <option value="2030">2030</option>
                                        <option value="2029">2029</option>
                                        <option value="2028">2028</option>
                                        <option value="2027">2027</option>
                                        <option value="2026">2026</option>
                                        <option value="2025">2025</option>
                                        <option value="2024">2024</option>
                                        <option selected value="2023">2023</option>
                                        <option value="2022">2022</option>
                                        <option value="2021">2021</option>
                                        <option value="2020">2020</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- select option row end -->
                <!-- Income & Exp card start -->
                <div class="row">
                    <!--Card 1-->
                    <div class="col-12 col-sm-6 col-lg-6 col-xl-3 col-md-3">
                        <div class="card">
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="media d-flex">
                                        <div class="media-body text-left align-self-bottom">
                                            <span class="d-block mb-1 font-medium-1">Total Reserve</span>
                                            <h5 class="mb-0 font-weight-bolder">2000</h5>
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
                                            <span class="d-block mb-1 font-medium-1">Total Exp.</span>
                                            <h5 class="mb-0 font-weight-bolder">930</h5>
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
                                            <span class="d-block mb-1 font-medium-1">Net Reserve</span>
                                            <h5 class="mb-0 font-weight-bolder">500</h5>
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
            </div>
            <!-- container-fluid end -->
        </div>
    </div>
</div>
<!-- END: Main Content end-->
@endsection
@push('foot')

@endpush