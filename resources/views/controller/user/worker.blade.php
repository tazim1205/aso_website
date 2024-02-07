@extends('controller.layout.app')
@push('title') {{ __('Worker') }} @endpush

@push('head')
@endpush
@section('content')
<!-- BEGIN: Main Content start-->
<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-body  container-fluid">
                <!-- Zero configuration table -->
                <section id="configuration">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-head">
                                    <div class="card-header">
                                        <h4 class="card-title">Worker Table</h4>
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
                                                        <th>Name</th>
                                                        <th>Phone</th>
                                                        <th>Balance</th>
                                                        <th>Bid Limit</th>
                                                        <th>Document</th>
                                                        <th>Worker</th>
                                                        <th>Area</th>
                                                        <th>Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach (auth()->user()->upazila->workers as $worker)
                                                    <tr>
                                                        <td class="text-center">
                                                            {{ $loop->iteration }}
                                                        </td>
                                                        <td>
                                                            <div class="media">
                                                                <div class="media-left pr-1">
                                                                    <span class="avatar avatar-sm rounded-circle">
                                                                        <img src="{{ asset($worker->image ?? 'uploads/images/defaults/user.png') }}"
                                                                            alt="avatar">
                                                                        <i></i>
                                                                    </span>
                                                                </div>
                                                                <div class="media-body media-middle">
                                                                    <span class="media-heading text-bold-700">{{ $worker->full_name }}
                                                                        @if($worker->is_verified == 1)
                                                                            <i class="ft-check-circle success float-right"></i>
                                                                        @else
                                                                            <i class="ft-x-circle danger float-right"></i>
                                                                        @endif
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </td>

                                                        <td>{{ $worker->phone }}</td>

                                                        <td>{{ $worker->recharge_amount }}</td>


                                                        <td>{{ $worker->recharge_amount * get_static_option('order_bid_limit_amount') }}</td>
                                                        <td>
                                                            <button
                                                                class="btn btn-outline-dark btn-sm document_view"
                                                                data-toggle="modal"
                                                                data-target="#document"
                                                                data-id="{{ $worker->id }}"
                                                                data-image="{{ asset($worker->image ?? 'uploads/images/defaults/user.png') }}"
                                                                data-nid_front="{{ asset($worker->front_image ?? 'uploads/images/defaults/user.png') }}"
                                                                data-nid_back="{{ asset($worker->back_image ?? 'uploads/images/defaults/user.png') }}"
                                                            ><i class="ft-eye"></i></button>
                                                        </td>
                                                        <td>
                                                            <button
                                                                class="btn btn-outline-dark btn-sm document_view"
                                                                data-toggle="modal"
                                                                data-target="#worker"
                                                            ><i class="ft-eye"></i></button>
                                                        </td>
                                                        <td>
                                                            <a href="#" data-toggle="modal" data-target="#area"
                                                               class="btn btn-outline-dark btn-sm">
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
                                                                    <a href="{{ route('controller.userBadge', $worker->id) }}"
                                                                       class="dropdown-item ">
                                                                        @if($worker->is_verified == 1)
                                                                            <i class="ft-x-square"></i> Remove Verify
                                                                        @else
                                                                            <i class="ft-check-square"></i> Verify
                                                                        @endif
                                                                    </a>
                                                                    <a href="#" data-toggle="modal" data-target="#view"
                                                                        class="dropdown-item viewWorker" id="{{ $worker->id }}">
                                                                        <i class="ft-eye"></i> View</a>

                                                                    <a href="#" data-toggle="modal" data-target="#edit"
                                                                        class="dropdown-item editWorker"
                                                                        data-id="{{$worker->id}}"
                                                                        data-name="{{$worker->full_name}}"
                                                                        data-phone="{{$worker->phone}}"
                                                                        data-balance="{{$worker->recharge_amount}}"
                                                                        data-limit="{{$worker->recharge_amount * get_static_option('order_bid_limit_amount')}}"
                                                                    >
                                                                        <i class="ft-edit-2"></i> Edit</a>

                                                                    <a id="{{$worker->id}}" class="dropdown-item delete-submit-button">
                                                                        <i class="ft-trash-2"></i> Delete</a>
                                                                </span>
                                                            </span>
                                                            @if($worker->status == 1)
                                                                <a href="{{ route('controller.userStatus',$worker->id) }}" class="btn btn-outline-danger" title="Decline"><i class="ft-x-square"></i></a>
                                                            @else
                                                                <a href="{{ route('controller.userStatus',$worker->id) }}" class="btn btn-outline-success" title="Approve"><i class="ft-check-square"></i></a>
                                                            @endif
                                                            <a href="{{ route('controller.worker.balance.reset',$worker->id) }}" class="btn btn-outline-dark">Reset Balance</a>
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
                                        <label for="balanc" class="col-form-label">Balance</label>
                                        <input type="number" class="form-control" value="20" id="balance">
                                    </div>
                                    <div class="form-group">
                                        <label for="bid" class="col-form-label">Bid Limit</label>
                                        <input type="number" class="form-control" value="04" id="bid" disabled>
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



                <!-- View Model start -->
                <div class="modal fade" id="view" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">
                                    View Worker
                                </h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>

                            <div class="modal-body">
                                <form action="#" method="POST">
                                    <div class="form-group">
                                        <label for="nidnumber" class="col-form-label">NID Number</label>
                                        <input type="text" name="nidnumber" class="form-control" value="343 423 2323" id="nidnumber">
                                    </div>

                                    <div class="form-group">
                                        <img src="../assets/images/area_controller/customer/avatar-s-11.png" width="100" alt=""
                                             id="blah">
                                        <input type="file" name="image" class="form-control" value="04" id="image"
                                               onchange="document.getElementById('blah').src = window.URL.createObjectURL(this.files[0])">
                                    </div>
                                    <div class="form-group">
                                        <label for="username" class="col-form-label">Username</label>
                                        <input type="text" name="username" class="form-control" value="smith455" id="username">
                                    </div>
                                    <div class="form-group">
                                        <label for="name" class="col-form-label">Full Name</label>
                                        <input type="text" name="name" class="form-control" value="smith chomok" id="fullname">
                                    </div>
                                    <div class="form-group">
                                        <label for="mobile" class="col-form-label">Mobile</label>
                                        <input type="text" name="mobile" class="form-control" value="018990099" id="mobile">
                                    </div>
                                    <div class="form-group">
                                        <label for="email" class="col-form-label">Email</label>
                                        <input type="text" name="email" class="form-control" value="tazuddin34" id="email">
                                    </div>
                                    <div class="form-group">
                                        <label for="service_category" id="service_category" class="col-form-label">Service Category</label>

                                        <select class="form-control">
                                            <option selected>Select Category</option>
                                            <option value="1">Option 1</option>
                                            <option value="2">Option 2</option>
                                            <option value="3">Option 3</option>
                                        </select>
                                    </div>
                                    <div class="modal-footer">

                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- View Model end -->

{{--                View Document Model--}}
                <div class="modal fade" id="document" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                     aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">
                                    View Document
                                </h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>

                            <div class="modal-body">
                                <form action="#" method="POST">

                                    <div class="form-group">
                                        <label for="image">Image</label>
                                        <input type="file" name="image" class="form-control" value="04" id="image"
                                               onchange="document.getElementById('blah').src = window.URL.createObjectURL(this.files[0])">
                                        <hr>
                                        <img src="../assets/images/area_controller/customer/avatar-s-11.png" width="100" alt=""
                                             id="blah">
                                    </div>
                                    <div class="form-group">
                                        <label for="nid_front">Nid Front</label>
                                        <input type="file" name="image" class="form-control" value="04" id="nid_front"
                                               onchange="document.getElementById('nid_front_preview').src = window.URL.createObjectURL(this.files[0])">
                                        <hr>
                                        <img src="../assets/images/area_controller/customer/avatar-s-11.png" width="100" alt=""
                                             id="nid_front_preview">
                                    </div>
                                    <div class="form-group">
                                        <label for="nid_back">Nid Back</label>
                                        <input type="file" name="image" class="form-control" value="04" id="nid_back"
                                               onchange="document.getElementById('nid_back_preview').src = window.URL.createObjectURL(this.files[0])">
                                        <hr>
                                        <img src="../assets/images/area_controller/customer/avatar-s-11.png" width="100" alt=""
                                             id="nid_back_preview">
                                    </div>

                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary">Update</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

{{--                View Worker Model--}}
                <div class="modal fade" id="worker" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                     aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">
                                    View Worker
                                </h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>

                            <div class="modal-body">

                            </div>
                        </div>
                    </div>
                </div>

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
<!-- END: Main Content end-->
@endsection
@push('foot')
    <script>
        $(document).ready(function() {

            // View Document
            $(document).on('click', '.document_view', function(e){
                e.preventDefault();
                var id = $(this).attr("data-id");
                var image = $(this).attr("data-image");
                var nid_front = $(this).attr("data-nid_front");
                var nid_back = $(this).attr("data-nid_back");
                // alert(id);
                $("#blah").attr("src", image);
                $("#nid_front_preview").attr("src", nid_front);
                $("#nid_back_preview").attr("src", nid_back);
            });

            // View Worker
            $(document).on('click', '.viewWorker', function(e){
                e.preventDefault();
                var id = $(this).attr("id");
                // alert(id);
                $.ajax({
                    url: "{{  url('controller/worker/') }}/"+id,
                    type:"GET",
                    dataType : 'json',
                    success:function(data) {
                        // console.log(data);
                        $("#nidnumber").val(data.number);
                        $("#username").val(data.user_name);
                        $("#fullname").val(data.full_name);
                        $("#mobile").val(data.phone);
                        $("#email").val(data.email);
                        $('#service_category').val('data.worker_service')
                        $('#service_provider').modal('show');
                    },
                });
            });
        //     Edit Worker
            $(document).on('click', '.editWorker', function (e) {
                e.preventDefault();
                var id = $(this).attr("data-id");
                var name = $(this).attr("data-name");
                var phone = $(this).attr("data-phone");
                var balance = $(this).attr("data-balance");
                var limit = $(this).attr("data-limit");
                $('#name').val(name);
                $('#phone').val(phone);
                $('#balance').val(balance);
                $('#bid').val(limit);
                $('#edit_id').val(id);
            })

        //     Update Worker
            $('#updateBtn').click(function(){
                var formData = new FormData();
                formData.append('id', $("#edit_id").val());
                formData.append('full_name', $("#name").val());
                formData.append('phone', $("#phone").val());
                formData.append('recharge_amount', $("#balance").val());
                $.ajax({
                    method: 'POST',
                    url: "{{ route('controller.worker.update') }}",
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
                            url: "{{ route('controller.worker.delete') }}",
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
