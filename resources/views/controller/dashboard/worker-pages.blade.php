@extends('controller.layout.app')
@push('title') {{ __('Worker Pages') }} @endpush
@push('head')
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.16/css/jquery.dataTables.css">
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
@endpush
@section('content')
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
                                            <h4 class="card-title">Gigs Table</h4>
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
                                                            <th>Create Date</th>
                                                            <th>MemberShip</th>
                                                            <th>Service</th>
                                                            <th>Phone</th>
                                                            <th>Location</th>
                                                            <th>Service Provider</th>
                                                            <th>Full Details</th>
                                                            <th>Actions</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($data as $gig)
                                                        <tr>
                                                            <td class="text-center"> {{ $loop->iteration }}</td>
                                                            <td>
                                                                <span>{{ \Carbon\Carbon::parse($gig->created_at)->format('d M, Y') }}</span>
                                                            </td>
                                                            <td>
                                                                <span>{{ $gig->membership->name ?? '' }}</span>
                                                            </td>
                                                            <td>
                                                                <span>{{ $gig->services ?? '' }}</span>
                                                            </td>
                                                            <td>
                                                                <span>{{ $gig->phone ?? '' }}</span>
                                                            </td>
                                                            <td>
                                                                <span>{{ $gig->location ?? '' }}</span>
                                                            </td>
                                                            <td>
                                                                <span>
                                                                    <a href="#" data-toggle="modal"
                                                                        data-target="#service_provider"
                                                                        class="dropdown-item btn btn-primary viewWorker" id="{{ $gig->worker_id }}">
                                                                        {{ $gig->worker->full_name ?? '' }}
                                                                    </a>
                                                                </span>
                                                            </td>
                                                            <td>
                                                                <span>
                                                                    <a href="#" data-toggle="modal"
                                                                        data-target="#full_details"
                                                                        class="dropdown-item btn btn-info seeBtn">
                                                                        View
                                                                    </a>
                                                                </span>
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
                                                                        @if($status == 'pending')
                                                                            <a href="{{route('controller.worker.page.active',$gig->id)}}" class="dropdown-item deleted-click">
                                                                            <i class="ft-activity"></i> Approve</a>

                                                                            <a href="{{route('controller.worker.page.deactive',$gig->id)}}" class="dropdown-item deleted-click">
                                                                            <i class="ft-alert-circle"></i> Disable</a>
                                                                        @elseif($status == 'active')
                                                                            <a href="{{route('controller.worker.page.pending',$gig->id)}}" class="dropdown-item deleted-click">
                                                                            <i class="ft-activity"></i> Pending</a>

                                                                            <a href="{{route('controller.worker.page.deactive',$gig->id)}}" class="dropdown-item deleted-click">
                                                                            <i class="ft-alert-circle"></i> Disable</a>
                                                                        @else
                                                                            <a href="{{route('controller.worker.page.active',$gig->id)}}" class="dropdown-item deleted-click">
                                                                            <i class="ft-activity"></i> Approve</a>
                                                                            <a href="{{route('controller.worker.page.pending',$gig->id)}}" class="dropdown-item deleted-click">
                                                                            <i class="ft-activity"></i> Pending</a>
                                                                        @endif


                                                                        <a href="#" data-toggle="modal" data-target="#edit"
                                                                            class="dropdown-item editPageBtn" id="{{ $gig->id }}">
                                                                            <i class="ft-edit-2"></i> Edit</a>
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
                </div>
                <!-- container-fluid end -->
            </div>
        </div>
    </div>
    <!-- END: Main Content end-->


    <!-- edit Model start -->
    <div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                    <form action="{{ route('controller.worker.page.update') }}" id="page-form" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <input type="text" name="name" id="page_name" class="form-control form-control-lg" placeholder="{{ __('Page Name here...') }}">
                        </div>
                        <div class="form-group">
                            <input type="text" name="title" id="page_title" class="form-control form-control-lg" placeholder="{{ __('Page title here...') }}">
                        </div>

                        <div class="form-group">
                            <textarea class="form-control form-control-lg" id="page_description" name="description" rows="4" placeholder="{{ __('page Description...') }}"></textarea>
                        </div>

                        <div class="form-group">
                            <textarea class="form-control form-control-lg" id="page_address" name="address" rows="1" placeholder="{{ __('Your Address') }}"></textarea>
                        </div>

                        <div class="form-group">
                            <input type="number" id="page_phone" name="phone" class="form-control form-control-lg" placeholder="{{ __('Phone Number') }}">
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <input type="text" name="location" id="page_location" class="form-control form-control-lg" placeholder="Location" value="">
                                </div>
                            </div>
                            <div class="col-12 m-auto">
                                <div class="form-group">
                                    <input type="hidden" name="page_id" id="page_id">
                                    <button type="submit" id="page-submit-button" class="mb-2 btn btn-lg btn-success w-100 btn-rounded">{{ __('Update Page') }}</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- edit Model end -->

    <!-- service_provider Model start -->
    <div class="modal fade" id="service_provider" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">

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
                            <input type="text" name="name" class="form-control" value="smith chomok" id="name">
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
                            <label for="service_category" class="col-form-label">Service Category</label>

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
    <!-- service_provider Model end -->

    <!-- full_details Model start -->
    <div class="modal fade" id="full_details" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                        Full Details
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body" id="gigDetailsModalContent">

                </div>
            </div>
        </div>
    </div>
    <!-- full_details Model end -->
@endsection
@push('foot')
    <script type="text/javascript" charset="utf8" src="//cdn.datatables.net/1.10.16/js/jquery.dataTables.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
    <script>
        $('#page_description').summernote({
            placeholder: 'page Description',
            tabsize: 2,
            height: 120,
            toolbar: [

            ]
        });
        $(document).ready( function () {

            $(document).on('click', '.seeBtn', function(e){
                e.preventDefault();
                var id = $(this).attr("id");
                $.ajax({
                    url: "{{  url('/worker/page/details/') }}/"+id,
                    type:"GET",
                    dataType : 'html',
                    success:function(data) {
                        var d =$('#gigDetailsModalContent').empty();
                        $('#gigDetailsModalContent').html(data);
                        $('#full_details').modal('show');
                    },
                });
            });

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
                        $('#service_category').val('data.worker_service')
                        $('#service_provider').modal('show');
                    },
                });
            });

            $(document).on('click', '.editPageBtn', function(e){
                e.preventDefault();
                var id = $(this).attr("id");
                $.ajax({
                    url: "{{  url('/worker/page/edit/details/') }}/"+id,
                    type:"GET",
                    dataType : 'JSON',
                    success:function(data) {
                        $('#page_id').val(data.id);
                        $('#page_name').val(data.name);
                        $('#page_title').val(data.title);
                        $('#page_location').val(data.location);
                        // $('#page_description').val(data.description);
                        $('#page_description').summernote('editor.pasteHTML', data.description);
                        $('#page_address').val(data.address);
                        $('#page_phone').val(data.phone);
                        $('#pageEditModal').modal('show');
                    },
                });
            });

        });
    </script>
@endpush

