@extends('controller.layout.app')
@push('title') {{ __('Customer') }} @endpush

@push('head')
@endpush
@section('content')
<!-- END: Main Content end-->
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
                                        <h4 class="select-title white">Customer</h4>
                                        <select name="Category" class="form-control width-30-percent">
                                            <option selected>Pourashava/Union/Area</option>
                                            <option value="1">One</option>
                                            <option value="2">Two</option>
                                            <option value="3">Three</option>
                                        </select>
                                        <select name="service" class="form-control width-30-percent">
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
                                        <h4 class="card-title">Customer</h4>
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
                                                    <th>Image</th>
                                                    <th>Username</th>
                                                    <th>Full Name</th>
                                                    <th>Mobile</th>
                                                    <th>Email</th>
                                                    <th>Running Order</th>
                                                    <th>Completed Order</th>
                                                    <th>Canceled Order</th>
                                                    <th>Sign Up Date</th>
                                                    <th>Area</th>
                                                    <th>Actions</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach (auth()->user()->upazila->customers as $data)
                                                    <tr>
                                                        <td> {{ $loop->iteration }}</td>
                                                        <td>
                                                            <img src="{{ asset($data->image ?? 'uploads/images/defaults/user.png') }}"
                                                                 width="60" alt="">
                                                        </td>
                                                        <td>
                                                            {{ $data->user_name }}
                                                        </td>
                                                        <td>
                                                            {{ $data->full_name }}
                                                        </td>
                                                        <td>
                                                            {{ $data->phone }}
                                                        </td>
                                                        <td>
                                                            {{ $data->email }}
                                                        </td>
                                                        <td>
                                                            Bid : {{ countBids('running', $data->id) }} <br>
                                                            Gig : {{ countGig('running', $data->id) }} <br>
                                                            Service Order : {{ countService('running', $data->id) }}
                                                        </td>
                                                        <td>
                                                            Bid : {{ countBids('complete', $data->id) }} <br>
                                                            Gig : {{ countGig('complete', $data->id) }} <br>
                                                            Service Order : {{ countService('complete', $data->id) }}
                                                        </td>
                                                        <td>
                                                            Bid : {{ countBids('cancelled', $data->id) }} <br>
                                                            Gig : {{ countGig('cancelled', $data->id) }} <br>
                                                            Service Order : {{ countService('cancelled', $data->id) }}
                                                        </td>
                                                        <td>
                                                            {{ \Carbon\Carbon::parse($data->created_at)->format('d M, Y') }}
                                                        </td>
                                                        <td>
                                                            <a href="#" data-toggle="modal" data-target="#area"
                                                               class="btn btn-info">
                                                                <i class="fa fa-eye" aria-hidden="true"></i>
                                                            </a>
                                                        </td>
                                                        <td>


                                                            <span class="dropdown">
                                                                <button id="btnSearchDrop12" type="button"
                                                                        class="btn btn-sm btn-icon btn-pure font-medium-2"
                                                                        data-toggle="dropdown" aria-haspopup="true"
                                                                        aria-expanded="false">
                                                                    <i class="ft-more-vertical"></i>
                                                                </button>
                                                                <span aria-labelledby="btnSearchDrop12"
                                                                      class="dropdown-menu dropdown-menu-button">
                                                                    <a
                                                                        href="#"
                                                                        class="dropdown-item editWorker"
                                                                        data-toggle="modal" data-target="#edit"
                                                                        data-id="{{$data->id}}"
                                                                        data-name="{{$data->full_name}}"
                                                                        data-phone="{{$data->phone}}"
                                                                        data-email="{{$data->email}}"
                                                                    >
                                                                        <i class="ft-trash-2"></i> Edit</a>
                                                                    <a id="{{$data->id}}" class="dropdown-item delete-submit-button">
                                                                        <i class="ft-trash-2"></i> Delete</a>
                                                                </span>
                                                            </span>

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

                                    <div class="card m-auto" style="width: 70%;">
                                        <img class="card-img-top"
                                             src="../assets/images/area_controller/customer/sdv-1.webp"
                                             alt="Card image cap" style="width: 250px;">
                                        <h4>আপনার লোকেশন নির্বাচন করুন</h4>
                                    </div>

                                    <select class="form-control" aria-label="Default select example">
                                        <option selected>Feni | ফেনী</option>
                                        <option value="1">One</option>
                                        <option value="2">Two</option>
                                        <option value="3">Three</option>
                                    </select>
                                    <br>
                                    <select class="form-control" aria-label="Default select example">
                                        <option selected>Feni Sadar | ফেনী সদর</option>
                                        <option value="1">One</option>
                                        <option value="2">Two</option>
                                        <option value="3">Three</option>
                                    </select>
                                    <br>
                                    <select class="form-control" aria-label="Default select example">
                                        <option selected>Feni Pouroshova</option>
                                        <option value="1">One</option>
                                        <option value="2">Two</option>
                                        <option value="3">Three</option>
                                    </select>
                                    <br>
                                    <select class="form-control" aria-label="Default select example">
                                        <option selected>Select Word/Road</option>
                                        <option value="1">One</option>
                                        <option value="2">Two</option>
                                        <option value="3">Three</option>
                                    </select>
                                    <br>
                                    <textarea class="form-control" id="exampleFormControlTextarea1"
                                              placeholder="আপনার গুগল ম্যাপ লিংক দিন " rows="3"></textarea>
                                    <br>
                                    <button type="submit" class="btn btn-primary width_100_percent">Save Change</button>

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


<!-- Edit Model start -->
<div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                    Edit Worker
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <form action="#" method="POST">
                    <input type="hidden" name="id" value="" id="edit_id">
                    <div class="form-group">
                        <label for="name" class="col-form-label">Name</label>
                        <input type="text" class="form-control" value="Kevin G. Sadowski" id="name">
                    </div>
                    <div class="form-group">
                        <label for="phone" class="col-form-label">Phone</label>
                        <input type="text" class="form-control" value="01345345435" id="phone">
                    </div>
                    <div class="form-group">
                        <label for="email" class="col-form-label">Email</label>
                        <input type="email" class="form-control" value="demo@gmail.com" id="email">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                                data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="updateBtn">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Edit Model end -->
@endsection
@push('foot')
    <script>
        $(document).ready(function() {

            //     Edit Worker
            $(document).on('click', '.editWorker', function (e) {
                e.preventDefault();
                var id = $(this).attr("data-id");
                var name = $(this).attr("data-name");
                var phone = $(this).attr("data-phone");
                var email = $(this).attr("data-email");
                $('#name').val(name);
                $('#phone').val(phone);
                $('#email').val(email);
                $('#edit_id').val(id);
            })

            //     Update Worker
            $('#updateBtn').click(function(){
                var formData = new FormData();
                formData.append('id', $("#edit_id").val());
                formData.append('full_name', $("#name").val());
                formData.append('phone', $("#phone").val());
                formData.append('email', $("#email").val());
                $.ajax({
                    method: 'POST',
                    url: "{{ route('controller.customer.update') }}",
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    data: formData,
                    processData: false,
                    contentType: false,
                    dataType: 'JSON',
                    success: function (data) {
                        $('#modal').modal('hide');
                        $('#email').val('');
                        $('#phone').val('');
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: 'Successfully edited '+data.name+','+data.phone,
                            showConfirmButton: false,
                            timer: 1500
                        })
                        setTimeout(function() {
                            location.reload();
                        }, 800);//

                    },
                    error: function (xhr) {
                        var errorMessage = '<div class="card bg-danger">\n' +
                            '                        <div class="card-body text-center p-5">\n' +
                            '                            <span class="text-white">';
                        $.each(xhr.responseJSON.errors, function(key,value) {
                            errorMessage +=(''+value+'<br>');
                        });
                        errorMessage +='</span>\n' +
                            '                        </div>\n' +
                            '                    </div>';
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            footer: errorMessage
                        })
                    },
                })
            });

            //     Delete Worker
            $('.delete-submit-button').click(function(){
                var id = $(this).attr("id");
                var formData = new FormData();
                formData.append('id',id);

                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        var formData = new FormData();
                        formData.append('id',id);
                        $.ajax({
                            method: 'POST',
                            url: "{{ route('controller.customer.delete') }}",
                            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                            data: formData,
                            processData: false,
                            contentType: false,
                            dataType: 'JSON',
                            success: function (data) {
                                $('#modal').modal('hide');
                                $('#email').val('');
                                $('#phone').val('');
                                Swal.fire({
                                    position: 'top-end',
                                    icon: 'danger',
                                    title: 'Successfully deleted '+data.full_name,
                                    showConfirmButton: false,
                                    timer: 1500
                                })
                                setTimeout(function() {
                                    location.reload();
                                }, 800);//

                            },
                            error: function (xhr) {
                                var errorMessage = '<div class="card bg-danger">\n' +
                                    '                        <div class="card-body text-center p-5">\n' +
                                    '                            <span class="text-white">';
                                $.each(xhr.responseJSON.errors, function(key,value) {
                                    errorMessage +=(''+value+'<br>');
                                });
                                errorMessage +='</span>\n' +
                                    '                        </div>\n' +
                                    '                    </div>';
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    footer: errorMessage
                                })
                            },
                        })
                    }
                })


            });


        })
    </script>
@endpush
