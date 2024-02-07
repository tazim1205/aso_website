@extends('controller.layout.app')
    @push('head')
        <!--Lightbox Css-->
        <link href="{{ asset('assets/plugins/fancybox/css/jquery.fancybox.min.css') }}" rel="stylesheet" type="text/css"/>
    @endpush
@section('content')
    <div class="content-wrapper">
        <div class="container-fluid">
            <!-- Breadcrumb-->
            <div class="row pt-2 pb-2">
                <div class="col-sm-9">
                    <h4 class="page-title">{{ __('Users of') }} {{ auth()->user()->upazila->name }}</h4>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javaScript:void();">{{ get_static_option('name') }}</a></li>
                        <li class="breadcrumb-item"><a href="javaScript:void();">Users of</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ auth()->user()->upazila->name }}</li>
                    </ol>
                </div>
            </div>
            <!-- End Breadcrumb-->
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <ul class="nav nav-tabs nav-tabs-info nav-justified">
                                <li class="nav-item">
                                    <a class="nav-link active show" data-toggle="tab" href="#worker"><i class="icon-home"></i> <span class="hidden-xs">{{ __('Worker') }}</span></a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#membership"><i class="icon-user"></i> <span class="hidden-xs">{{ __('Membership') }}</span></a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#customer"><i class="icon-envelope-open"></i> <span class="hidden-xs">{{ __('Customer') }}</span></a>
                                </li>
                            </ul>
                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div id="worker" class="container tab-pane active show">
                                    <div class="table-responsive">
                                            <table class="table">
                                                <thead class="thead-success shadow-success">
                                                <tr>
                                                    <th scope="col">#</th>
                                                    <th scope="col">{{ __('Image') }}</th>
                                                    <th scope="col">{{ __('Name') }}</th>
                                                    <th scope="col">{{ __('Phone') }}</th>
                                                    <th scope="col">{{ __('Balance') }}</th>
                                                    <th scope="col">{{ __('Bid Limit') }}</th>
                                                    <th scope="col">{{ __('Action') }}</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach(auth()->user()->upazila->workers as $worker)
                                                    <tr>
                                                        <td scope="row">{{ $loop->iteration }}</td>
                                                        <td>
                                                            <span class="user-profile"><img src="{{ asset($worker->image ?? 'uploads/images/defaults/user.png') }}" class="img-circle" alt=""></span>
                                                        </td>
                                                        <td>{{ $worker->full_name }}</td>
                                                        <td>{{ $worker->phone }}</td>
                                                        <td>{{ $worker->recharge_amount }}</td>
                                                        <td>{{ $worker->recharge_amount * get_static_option('order_bid_limit_amount') }}</td>
                                                        <td>
                                                            <input type="hidden" class="hidden-id" value="{{ $worker->id }}">
                                                            @if($worker->is_verified == 1)
                                        
                                                                <button type="button" class="badge-button btn btn-outline-success waves-effect waves-light m-1"> <i class="fa fa-check-circle"></i> </button>
                                                            @else
                                                                <button type="button" class="badge-button btn btn-outline-danger waves-effect waves-light m-1"> <i class="fa fa-times-circle"></i> </button>
                                                            @endif
                                                            @if($worker->status == 1)
                                                                <button type="button" class="status-button btn btn-outline-success waves-effect waves-light m-1"> <i class="fa fa-smile-o"></i> </button>
                                                            @else
                                                                <button type="button" class="status-button btn btn-outline-danger waves-effect waves-light m-1"> <i class="fa ti-face-sad"></i> </button>
                                                            @endif
                                                            <button type="button" data-toggle="modal" data-target="#worker-details-of-id-{{ $worker->id }}" class="btn btn-outline-warning waves-effect waves-light m-1"> <i class="fa fa-eye"></i> </button>
                                                            <a href="{{ route('controller.worker.balance.reset',$worker->id) }}" class="btn btn-danger">Reset Balance</a>
                                                        </td>
                                                    </tr>
                                                    <div class="modal fade" id="worker-details-of-id-{{ $worker->id }}">
                                                        <div class="modal-dialog modal-lg">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="modal-title"><i class="fa fa-star"></i> {{ $worker->full_name }} </h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="modal-title"><i class="fa fa-phone"></i> {{ $worker->phone }} </h5>
                                                                </div>
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="modal-title"><i class="fa fa-id-card"></i> {{ $worker->nid }} </h5>
                                                                </div>
                                                                <div class="modal-body" id="modal-body">
                                                                    <div class="row">
                                                                        <div class="col-md-6 col-lg-3 col-xl-3">
                                                                            <a href="{{ asset($worker->image) }}" data-fancybox="images">
                                                                                <img src="{{ asset($worker->image) }}" class="lightbox-thumb img-thumbnail">
                                                                            </a>
                                                                        </div>
                                                                        <div class="col-md-6 col-lg-3 col-xl-3">
                                                                            <a href="{{ asset($worker->front_image) }}" data-fancybox="images">
                                                                                <img src="{{ asset($worker->front_image) }}" class="lightbox-thumb img-thumbnail">
                                                                            </a>
                                                                        </div>
                                                                        <div class="col-md-6 col-lg-3 col-xl-3">
                                                                            <a href="{{ asset($worker->back_image) }}" data-fancybox="images">
                                                                                <img src="{{ asset($worker->back_image) }}" class="lightbox-thumb img-thumbnail">
                                                                            </a>
                                                                        </div>
                                                                        @foreach (App\UserUsefulFile::where('user_id',$worker->id)->get() as $img)
                                                                            <div class="col-md-6 col-lg-3 col-xl-3">
                                                                                <a href="{{ asset($img->file) }}" data-fancybox="images">
                                                                                    <img src="{{ asset($img->file) }}" class="lightbox-thumb img-thumbnail">
                                                                                </a>
                                                                                <a href="{{ route('controller.userUsefulDocDelete',$img->id) }}" class="text-danger"><i class="fa fa-times"></i></a>
                                                                            </div>
                                                                        @endforeach
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer" id="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal" ><i class="fa fa-times"></i> {{ __('Close') }}</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                </div>
                                <div id="membership" class="container tab-pane fade">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead class="thead-warning shadow-warning">
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">{{ __('Image') }}</th>
                                                <th scope="col">{{ __('Name') }}</th>
                                                <th scope="col">{{ __('Phone') }}</th>
                                                <th scope="col">{{ __('Action') }}</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach(auth()->user()->upazila->memberships as $membership)
                                                <tr>
                                                    <td scope="row">{{ $loop->iteration }}</td>
                                                    <td>
                                                        <span class="user-profile"><img src="{{ asset($membership->image ?? 'uploads/images/defaults/user.png') }}" class="img-circle" alt=""></span>
                                                    </td>
                                                    <td>{{ $membership->full_name }}</td>
                                                    <td>{{ $membership->phone }}</td>
                                                    <td>
                                                        <input type="hidden" class="hidden-id" value="{{ $membership->id }}">
                                                        @if($membership->status == 1)
                                                            <button type="button" class="status-button btn btn-outline-success waves-effect waves-light m-1"> <i class="fa fa-smile-o"></i> </button>
                                                        @else
                                                            <button type="button" class="status-button btn btn-outline-danger waves-effect waves-light m-1"> <i class="fa ti-face-sad"></i> </button>
                                                        @endif
                                                        <button type="button" data-toggle="modal" data-target="#membership-details-of-id-{{ $membership->id }}" class="btn btn-outline-warning waves-effect waves-light m-1"> <i class="fa fa-eye"></i> </button>
                                                    </td>
                                                </tr>
                                                <div class="modal fade" id="membership-details-of-id-{{ $membership->id }}">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="modal-title"><i class="fa fa-star"></i> {{ $membership->full_name }} </h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="modal-title"><i class="fa fa-phone"></i> {{ $membership->phone }} </h5>
                                                            </div>
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="modal-title"><i class="fa fa-id-card"></i> {{ $membership->nid }} </h5>
                                                            </div>
                                                            <div class="modal-body" id="modal-body">
                                                                <div class="row">
                                                                    <div class="col-md-6 col-lg-3 col-xl-3">
                                                                        <a href="{{ asset($membership->image) }}" data-fancybox="images">
                                                                            <img src="{{ asset($membership->image) }}" class="lightbox-thumb img-thumbnail">
                                                                        </a>
                                                                    </div>
                                                                    <div class="col-md-6 col-lg-3 col-xl-3">
                                                                        <a href="{{ asset($membership->front_image) }}" data-fancybox="images">
                                                                            <img src="{{ asset($membership->front_image) }}" class="lightbox-thumb img-thumbnail">
                                                                        </a>
                                                                    </div>
                                                                    <div class="col-md-6 col-lg-3 col-xl-3">
                                                                        <a href="{{ asset($membership->back_image) }}" data-fancybox="images">
                                                                            <img src="{{ asset($membership->back_image) }}" class="lightbox-thumb img-thumbnail">
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer" id="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal" ><i class="fa fa-times"></i> {{ __('Close') }}</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div id="customer" class="container tab-pane fade">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead class="thead-info shadow-info">
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">{{ __('Image') }}</th>
                                                <th scope="col">{{ __('Name') }}</th>
                                                <th scope="col">{{ __('Phone') }}</th>
                                                <th scope="col">{{ __('Action') }}</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach(auth()->user()->upazila->customers as $customer)
                                                <tr>
                                                    <td scope="row">{{ $loop->iteration }}</td>
                                                    <td>
                                                        <span class="user-profile"><img src="{{ asset($customer->image ?? 'uploads/images/defaults/user.png') }}" class="img-circle" alt=""></span>
                                                    </td>
                                                    <td>{{ $customer->full_name }}</td>
                                                    <td>{{ $customer->phone }}</td>
                                                    <td>
                                                        <input type="hidden" class="hidden-id" value="{{ $customer->id }}">
                                                        @if($customer->status == 1)
                                                        <button type="button" class="status-button btn btn-outline-success waves-effect waves-light m-1"> <i class="fa fa-smile-o"></i> </button>
                                                        @else
                                                            <button type="button" class="status-button btn btn-outline-danger waves-effect waves-light m-1"> <i class="fa ti-face-sad"></i> </button>
                                                        @endif
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
            </div>
        </div>
        <!-- End container-fluid-->
    </div>
    <!-- Modal -->

    <script>
        $(document).ready(function() {
            //Submit Badge
            $('.badge-button').click(function(){
                $.ajax({
                    method: 'POST',
                    url: '{{ route('controller.userBadge') }}',
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    data: { person: $(this).parent().parent().find('.hidden-id').val()},
                    dataType: 'JSON',
                    success: function (data) {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: 'Successfully Verification Status Changes',
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
            //Submit Status
            $('.status-button').click(function(){
                $.ajax({
                    method: 'POST',
                    url: '{{ route('controller.userStatus') }}',
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    data: { person: $(this).parent().parent().find('.hidden-id').val()},
                    dataType: 'JSON',
                    success: function (data) {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: 'Successfully status changed',
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
        });
    </script>

@endsection
@push('foot')
    <!--Lightbox-->
    <script src="{{ asset('assets/plugins/fancybox/js/jquery.fancybox.min.js') }}"></script>
@endpush

