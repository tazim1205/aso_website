@extends('controller.layout.app')
@push('title') {{ __('Membership By Area & Category') }} @endpush

@push('head')
@endpush
@section('content')
<div class="app-content content">
    <div class="content-wrapper padding-top5">
        <div class="content-header row">
            <div class="content-body  container-fluid">
                <!-- Zero configuration table -->
                <section id="configuration">

                    <!-- Member package Price select option row -->
                    <div class="row mt-1">
                        <div class="col-md-12">
                            <div class="card card-background-blue">
                                <div class="card-content">
                                    <div class="card-body select-card-design">
                                        <h4 class="select-title white">Membership by Categories & Area</h4>

                                        <select name="category" class="form-control width-25-percent">
                                            <option selected>Category</option>
                                            <option value="1">One</option>
                                            <option value="2">Two</option>
                                            <option value="3">Three</option>
                                        </select>

                                        <select name="package" class="form-control width-25-percent">
                                            <option selected>Package</option>
                                            <option value="1">One</option>
                                            <option value="2">Two</option>
                                            <option value="3">Three</option>
                                        </select>
                                        <select name="pourashava" class="form-control width-30-percent">
                                            <option selected>Pourashava/Union/Area</option>
                                            <option value="1">One</option>
                                            <option value="2">Two</option>
                                            <option value="3">Three</option>
                                        </select>
                                        <select name="ward" class="form-control width-25-percent">
                                            <option selected>Ward/Road</option>
                                            <option value="1">One</option>
                                            <option value="2">Two</option>
                                            <option value="3">Three</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Member package Price select option row end -->
                    <!-- Member package Price card start -->
                    <div class="row">
                        <!--Card 1-->
                        @foreach ($workerServices as $service)
                        <div class="col-12 col-sm-6 col-lg-6 col-xl-3 col-md-3">
                            <div class="card">
                                <div class="card-content">
                                    <div class="card-body">
                                        <div class="media d-flex">
                                            <div class="media-body text-left align-self-bottom">
                                                <span class="d-block mb-1 font-medium-1">{{ $service->name }}</span>
                                                <h5 class="mb-0 font-weight-bolder">{{ $service->memberships_count }}</h5>
                                            </div>
                                            <div class="align-self-top">
                                                <i class="material-icons dark-blue font-large-3">chrome_reader_mode</i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <!-- Member package Price card end -->

                </section>
                <!--/ Zero configuration table -->
                <!-- Edit Model start -->
                <div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">
                                    Edit Profile
                                </h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>

                            <div class="modal-body">
                                <form action="#" method="POST">
                                    <div class="form-group">

                                        <img src="../assets/images/area_controller/customer/avatar-s-11.png" width="100"
                                            alt="" id="blah">
                                        <input type="file" name="image" class="form-control" value="04" id="image"
                                            onchange="document.getElementById('blah').src = window.URL.createObjectURL(this.files[0])">
                                    </div>
                                    <div class="form-group">
                                        <label for="username" class="col-form-label">Username</label>
                                        <input type="text" name="username" class="form-control" value="smith455"
                                            id="username">
                                    </div>
                                    <div class="form-group">
                                        <label for="name" class="col-form-label">Full Name</label>
                                        <input type="text" name="name" class="form-control" value="smith chomok"
                                            id="name">
                                    </div>
                                    <div class="form-group">
                                        <label for="mobile" class="col-form-label">Mobile</label>
                                        <input type="text" name="mobile" class="form-control" value="018990099"
                                            id="mobile">
                                    </div>
                                    <div class="form-group">
                                        <label for="email" class="col-form-label">Email</label>
                                        <input type="text" name="email" class="form-control" value="tazuddin34"
                                            id="email">
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-dismiss="modal">Close</button>

                                        <button type="submit" class="btn btn-primary">Update</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Edit Model end -->
                <!-- Area Model start -->
                <div class="modal fade" id="area" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">
                                    Edit Profile
                                </h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>

                            <div class="modal-body">
                                <form action="#" method="POST">


                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary">Save Change</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Area Model end -->
            </div>
            <!-- container-fluid end -->
        </div>
    </div>
</div>
<!-- END: Main Content end-->
@endsection
@push('foot')

@endpush
