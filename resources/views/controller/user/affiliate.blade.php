@extends('controller.layout.app')
@push('title') {{ __('Affiliate Marketer List') }} @endpush

@push('head')
@endpush
@section('content')
<div class="app-content content">
    <div class="content-wrapper padding-top5">
        <div class="content-header row">
            <div class="content-body  container-fluid">
                <!-- Zero configuration table -->
                <section id="configuration">
                    <!-- select option row start -->
                    <div class="row mt-1">
                        <div class="col-md-12">
                            <div class="card card-background-blue">
                                <div class="card-content">
                                    <div class="card-body select-card-design">
                                        <!-- <h4 class="select-title white">Affiliate Marketer List</h4> -->
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
                                        <select name="year" class="form-control width-15-percent">
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
                                        <select name="pourashava" class="form-control width-30-percent">
                                            <option selected>Pourashava/Union/Area</option>
                                            <option value="1">One</option>
                                            <option value="2">Two</option>
                                            <option value="3">Three</option>
                                        </select>
                                        <select name="ward" class="form-control width-30-percent">
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
                    <!-- select option row end -->

                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-head">
                                    <div class="card-header">
                                        <h4 class="card-title">Affiliate Marketer List</h4>
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
                                                class="table table-white-space table-bordered table-striped table-sm row-grouping display no-wrap icheck table-middle">
                                                <thead>
                                                    <tr>
                                                        <th>No.</th>
                                                        <th>Image</th>
                                                        <th>Username</th>
                                                        <th>Full Name</th>
                                                        <th>Income</th>
                                                        <th>Mobile</th>
                                                        <th>Email</th>
                                                        <th>Sign Up Date</th>
                                                        <th>Edit Profile</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($affiliate as $user)
                                                    <tr>
                                                        <td> {{ $loop->iteration }}</td>
                                                        <td>
                                                            <img src="{{ asset($user->user->image ?? 'uploads/images/defaults/user.png') }}"
                                                                width="60" alt="">
                                                        </td>
                                                        <td>
                                                            {{ $user->user->user_name }}
                                                        </td>
                                                        <td>
                                                            {{ $user->user->full_name }}
                                                        </td>
                                                        <td>
                                                            {{ $user->balance }}
                                                        </td>
                                                        <td>
                                                            {{ $user->user->phone }}
                                                        </td>
                                                        <td>
                                                            {{ $user->user->email }}
                                                        </td>
                                                        <td>
                                                            {{ \Carbon\Carbon::parse($user->created_at)->format('d M, Y') }}
                                                        </td>
                                                        <td>
                                                            <a href="#" data-toggle="modal" data-target="#view"
                                                                class="btn btn-info viewWorker" id="{{ $user->user_id }}">
                                                                View
                                                            </a>
                                                        </td>
                                                    </tr>
                                                    @endforeach

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

                <!-- Edit Model start -->
                <div class="modal fade" id="view" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">
                                    View Profile
                                </h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>

                            <div class="modal-body">
                                <form action="#" method="POST">
                                    <div class="form-group">
                                        <label for="nidnumber" class="col-form-label">NID Number</label>
                                        <input type="text" name="nidnumber" class="form-control" value="343 423 2323"
                                            id="nidnumber">
                                    </div>

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

{{--                                        <button type="submit" class="btn btn-primary">Update</button>--}}
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Edit Model end -->
            </div>
            <!-- container-fluid end -->
        </div>
    </div>
</div>
<!-- END: Main Content end-->
@endsection
@push('foot')
    <script>
        $(document).ready(function(){
            // View Worker By Id
            $(document).on('click', '.viewWorker', function(e){
                e.preventDefault();
                var id = $(this).attr("id");
                // alert(id);
                $.ajax({
                    url: "{{  url('controller/worker/') }}/"+id,
                    type:"GET",
                    dataType : 'json',
                    success:function(data) {
                        console.log(data);
                        $("#nidnumber").val(data.number);
                        $("#username").val(data.user_name);
                        $("#name").val(data.full_name);
                        $("#mobile").val(data.phone);
                        $("#email").val(data.email);
                        $('#view').modal('show');
                    },
                });
            });

        })
    </script>
@endpush
