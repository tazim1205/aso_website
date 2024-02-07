@extends('accountant.layout.app')

@section('title', 'New Income')

@section('content')
    <!-- Net Income Statement select option row -->
    <div class="row mt-1">
        <div class="col-md-12">
            <div class="card card-background-blue">
                <div class="card-content">
                    <div class="card-body select-card-design">

                        <select name="month" class="form-control width-25-percent">
                            <option value=''>--Select Month--</option>
                            <option value='1'>Janaury</option>
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
                            <option value="2023">2023</option>
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
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#new_create">
        <i class="fa fa-plus"></i> Create new income
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
                    <form action="#" method="POST">
                        <div class="form-group">
                            <label for="date" class="col-form-label">Date</label>
                            <input type="date" class="form-control" id="date">
                        </div>
                        <div class="form-group">
                            <label for="amount" class="col-form-label">Amount</label>
                            <input type="number" class="form-control" placeholder="Enter Amount" id="amount">
                        </div>
                        <div class="form-group">
                            <label for="details" class="col-form-label">Details</label>
                            <textarea name="" id="" cols="15" rows="10" class="form-control" placeholder="Enter details" id="details"></textarea>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Create new income</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!--Model end-->

    <div class="row">
        <!--Card 1-->
        <div class="col-12 col-sm-6 col-lg-6 col-xl-6 col-md-6">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        <div class="media d-flex">
                            <div class="media-body text-left align-self-bottom">
                                <span class="d-block mb-1 font-medium-1">Date : 27/05/2023</span>
                                <h5 class="mb-0 font-weight-bolder">Amount : 500</h5>
                                <p>
                                    <strong>Details :</strong>
                                    <span>
                                             Lorem ipsum dolor sit amet consectetur adipisicing elit. Perferendis.
                                          </span>
                                </p>
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
        <div class="col-12 col-sm-6 col-lg-6 col-xl-6 col-md-6">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        <div class="media d-flex">
                            <div class="media-body text-left align-self-bottom">
                                <span class="d-block mb-1 font-medium-1">Date : 27/05/2023</span>
                                <h5 class="mb-0 font-weight-bolder">Amount : 500</h5>
                                <p>
                                    <strong>Details :</strong>
                                    <span>
                                             Lorem ipsum dolor sit amet consectetur adipisicing elit. Perferendis.
                                          </span>
                                </p>
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
        <div class="col-12 col-sm-6 col-lg-6 col-xl-6 col-md-6">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        <div class="media d-flex">
                            <div class="media-body text-left align-self-bottom">
                                <span class="d-block mb-1 font-medium-1">Date : 27/05/2023</span>
                                <h5 class="mb-0 font-weight-bolder">Amount : 5000</h5>
                                <p>
                                    <strong>Details :</strong>
                                    <span>
                                             Lorem ipsum dolor sit amet consectetur adipisicing elit. Perferendis.
                                          </span>
                                </p>
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
@endsection
