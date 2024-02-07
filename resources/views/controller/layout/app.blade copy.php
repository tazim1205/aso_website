<!doctype html>
<html lang="{{  App::getLocale() }}" class="deeppurple-theme">
<!-- This system developed by DataTech BD ltd. Phone: 01304734623-25 | info@datatechbd.com | 23-08-2020-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
    <title>@stack('title') | {{ get_static_option('name') }} </title>
    <meta name="author" content="{{ get_static_option('author_name') ?? 'No author' }}">
    <meta name="description" content="{{ get_static_option('author_description') ?? 'No description' }}"/>
    <meta property="og:image" content="{{ asset(get_static_option('meta_image')) }}" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!--favicon-->
    <link rel="icon" href="{{ asset(get_static_option('fav') ?? 'uploads/images/defaults/fav.png') }}" type="image/x-icon">
    <!-- simplebar CSS-->
    <link href="{{ asset('assets/plugins/simplebar/css/simplebar.css') }}" rel="stylesheet"/>
    <!-- Bootstrap core CSS-->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet"/>
    <!-- animate CSS-->
    <link href="{{ asset('assets/css/animate.css') }}" rel="stylesheet" type="text/css"/>
    <!-- Icons CSS-->
    <link href="{{ asset('assets/css/icons.css') }}" rel="stylesheet" type="text/css"/>
    <!-- Sidebar CSS-->
    <link href="{{ asset('assets/css/sidebar-menu.css') }}" rel="stylesheet"/>
    <!-- Custom Style-->
    <link href="{{ asset('assets/css/app-style.css') }}" rel="stylesheet"/>
    <!--SweetAlert 2-->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <!--====== AJAX ======-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
    

    
    @stack('head')
</head>

<body>

<!--Start logout-->
@include('includes.logout')
<!--End logout-->

<!-- Start wrapper-->
<div id="wrapper">

    <!--Start sidebar-wrapper-->
@include('controller.layout.sidebar')
<!--End sidebar-wrapper-->

    <!--Start topbar header-->
@include('controller.layout.topbar')
<!--End topbar header-->

    <div class="clearfix">

    </div>
    <!--Start content-wrapper-->
@yield('content')
<!--End content-wrapper-->

    <!--Start Back To Top Button-->
    <a href="javaScript:void();" class="back-to-top"><i class="fa fa-angle-double-up"></i> </a>
    <!--End Back To Top Button-->

    <!--Start footer-->
@include('controller.layout.footer')
<!--End footer-->
</div>
<!--End wrapper-->
<!-- Bootstrap core JavaScript-->
<script src="{{ asset('assets/js/jquery.min.js') }}"></script>
<script src="{{ asset('assets/js/popper.min.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>

<!-- simplebar js -->
<script src="{{ asset('assets/plugins/simplebar/js/simplebar.js') }}"></script>
<!-- waves effect js -->
<script src="{{ asset('assets/js/waves.js') }}"></script>
<!-- sidebar-menu js -->
<script src="{{ asset('assets/js/sidebar-menu.js') }}"></script>
<!-- Custom scripts -->
<script src="{{ asset('assets/js/app-script.js') }}"></script>

@stack('foot')
@include('includes.ajax-scripts')
@include('sweetalert::alert')

</body>
<!-- This system developed by DataTech BD ltd. Phone: 01304734623-25 | info@datatechbd.com | 24-08-2020-->
</html>

<div class="modal fade" id="gigDetailsModal">
    <div class="modal-dialog">
        <div class="modal-content" id="gigDetailsModalContent">
            
        </div>
    </div>
</div>

<div class="modal fade" id="orderDetailsModal">
    <div class="modal-dialog ">
        <div class="modal-content" id="orderDetailsModalContent">
            
        </div>
    </div>
</div>

<div class="modal" tabindex="-1" role="dialog" id="gigEditModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Gig Edit</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('controller.worker.gig.update') }}" id="gig-form" method="post">
                    @csrf
                    <div class="form-group">
                        <input type="text" id="gig_title" name="title" class="form-control form-control-lg" placeholder="{{ __('Title here...') }}">
                    </div>
                    <div class="form-group">
                        <textarea class="form-control form-control-lg" name="description" id="gig_description" rows="4" placeholder="{{ __('Gig Description...') }}"></textarea>
                    </div>

                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <select id="gig_category" name="category" class="form-control form-control-lg">
                                    <option disabled selected>{{ __('Category') }}</option>
                                    @foreach(App\WorkerServiceCategory::orderBy('id', 'desc')->get() as $category)
                                        <optgroup label="{{ $category->name }}">
                                            @foreach($category->services as $service)
                                                <option value="{{ $service->id }}">{{ $service->name }}</option>
                                            @endforeach
                                        </optgroup>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <input type="number" id="gig_day" name="day" class="form-control form-control-lg" placeholder="{{ __('Hours 1') }}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                        <div class="form-group">
                            <input type="text" id="gig_tags" name="tags" class="form-control form-control-lg" placeholder="{{ __('Search tags') }}">
                        </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <input type="number" name="budget" id="gig_price" class="form-control form-control-lg" placeholder="{{ __('Price') }}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <input type="hidden" name="gig_id" id="gig_id">
                                <button type="submit" id="gig-submit-button" class="mb-2 btn btn-lg btn-success w-100 btn-rounded">{{ __('Update Gig') }}</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal" tabindex="-1" role="dialog" id="pageEditModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Page Edit</h5>
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

<div class="modal" tabindex="-1" role="dialog" id="serviceEditModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Service Edit</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('controller.worker.service.update') }}" id="" method="post">
                    @csrf
                    <div class="form-group">
                        <input type="text" id="service_title" name="title" class="form-control form-control-lg" placeholder="{{ __('Title here...') }}">
                    </div>
                    <div class="form-group">
                        <textarea class="form-control form-control-lg" name="description" id="service_description" rows="4" placeholder="{{ __('Gig Description...') }}"></textarea>
                    </div>

                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <input type="number" id="service_day" name="day" class="form-control form-control-lg" placeholder="{{ __('Hours 1') }}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                        <div class="form-group">
                            <input type="text" id="service_tags" name="tags" class="form-control form-control-lg" placeholder="{{ __('Search tags') }}">
                        </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <input type="number" name="budget" id="service_price" class="form-control form-control-lg" placeholder="{{ __('Price') }}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <input type="hidden" name="service_id" id="service_id">
                                <button type="submit" id="gig-submit-button" class="mb-2 btn btn-lg btn-success w-100 btn-rounded">{{ __('Update Service') }}</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

