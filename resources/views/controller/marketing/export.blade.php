@extends('controller.layout.app')
@push('title') {{ __('Marketing Fund Export') }} @endpush

@push('head')
@endpush
@section('content')
<!-- BEGIN: Main Content start-->
<div class="app-content content">
    <div class="content-wrapper padding-top5">
        <div class="content-header row">
            <div class="content-body  container-fluid">
                <!-- Zero configuration table -->
                <section id="configuration">
                    <!-- select option row start -->
                    <div class="row mt-1">
                        <div class="col-md-12">
                            <div class="card card-background-blue margin-bottom-10">
                                <div class="card-content">
                                    <div class="card-body select-card-design">
                                        <h4 class="select-title white">Marketing Fund - Fund Exp. Report</h4>
                                        <select name="month" class="form-control width-20-percent">
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
                                        <select name="year" class="form-control width-20-percent">
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
                                            <table id="users-contacts"
                                                class="table table-white-space table-bordered table-striped row-grouping display no-wrap icheck table-middle">
                                                <thead>
                                                    <tr>
                                                        <th>No.</th>
                                                        <th>Exp. Date</th>
                                                        <th>Amount</th>
                                                        <th>Details</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td> 01</td>
                                                        <td>
                                                            15/03/2023
                                                        </td>
                                                        <td>
                                                            4000
                                                        </td>
                                                        <td>
                                                            <span>
                                                                Lorem ipsum dolor sit amet consectetur adipisicing elit.
                                                            </span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td> 02</td>
                                                        <td>
                                                            15/03/2023
                                                        </td>
                                                        <td>
                                                            4000
                                                        </td>
                                                        <td>
                                                            <span>
                                                                Lorem ipsum dolor sit amet consectetur adipisicing elit.
                                                            </span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td> 03</td>
                                                        <td>
                                                            15/03/2023
                                                        </td>
                                                        <td>
                                                            4000
                                                        </td>
                                                        <td>
                                                            <span>
                                                                Lorem ipsum dolor sit amet consectetur adipisicing elit.
                                                            </span>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!--/ Zero configuration table -->
            </div>
            <!-- container-fluid end -->
        </div>
    </div>
</div>
<!-- END: Main Content end-->
@endsection
@push('foot')

@endpush