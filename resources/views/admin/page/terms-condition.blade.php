@extends('admin.layout.app')
@push('title')
    {{ __('Terms & Condition') }}
@endpush
@push('head')
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
@endpush
@section('content')
    <div class="content-wrapper">
        <div class="container-fluid">
            <!-- Breadcrumb-->
            <div class="row pt-2 pb-2">
                <div class="col-sm-9">
                    <h4 class="page-title"> {{ __('Terms & Condition') }}</h4>
                </div>
            </div>
             <!-- End Breadcrumb-->
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="customer-tab" data-toggle="tab" href="#customer" role="tab" aria-controls="customer" aria-selected="true">
                                        Customer Terms & Condition
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="marketer-tab" data-toggle="tab" href="#marketer" role="tab" aria-controls="marketer" aria-selected="false">
                                        Marketer Terms & Condition
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="service_provider-tab" data-toggle="tab" href="#service_provider" role="tab" aria-controls="service_provider" aria-selected="false">
                                        Service Provider Terms & Condition
                                    </a>
                                </li>
                            </ul>
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active" id="customer" role="tabpanel" aria-labelledby="customer-tab">
                                    <h5 class="card-title">{{ __('Customer Terms & Condition') }}</h5>
                                    <form action="{{ url('/admin/page/terms/condition/update') }}" id="add-new-from" method="post">
                                        @csrf
                                        <div class="form-group">
                                            <label>{{ __('Terms & Condition Details') }}</label>
                                            <textarea name="about"  id="about" class="summernote" cols="30" rows="10" required="">{!! $customer_terms->about !!}</textarea>
                                        </div>
                                        <input type="hidden" name="id" id="about-id" value="{{ $customer_terms->id }}">
                                        <button type="submit" class="btn btn-primary" id="edit-submit-button"><i class="fa fa-check-square-o"></i> {{ __('Update') }}</button>
                                    </form>
                                </div>
                                <div class="tab-pane fade" id="marketer" role="tabpanel" aria-labelledby="marketer-tab">
                                    <h5 class="card-title">{{ __('Marketer Terms & Condition') }}</h5>
                                    <form action="{{ url('/admin/page/terms/condition/update') }}" id="add-new-from" method="post">
                                        @csrf
                                        <div class="form-group">
                                            <label>{{ __('Terms & Condition Details') }}</label>
                                            <textarea name="about"  id="about" class="summernote" cols="30" rows="10" required="">{!! $marketer_terms->about !!}</textarea>
                                        </div>
                                        <input type="hidden" name="id" id="about-id" value="{{ $marketer_terms->id }}">
                                        <button type="submit" class="btn btn-primary" id="edit-submit-button"><i class="fa fa-check-square-o"></i> {{ __('Update') }}</button>
                                    </form>
                                </div>
                                <div class="tab-pane fade" id="service_provider" role="tabpanel" aria-labelledby="service_provider-tab">
                                    <h5 class="card-title">{{ __('Service Provider Terms & Condition') }}</h5>
                                    <form action="{{ url('/admin/page/terms/condition/update') }}" id="add-new-from" method="post">
                                        @csrf
                                        <div class="form-group">
                                            <label>{{ __('Terms & Condition Details') }}</label>
                                            <textarea name="about"  id="about" class="summernote" cols="30" rows="10" required="">{!! $service_provider_terms->about !!}</textarea>
                                        </div>
                                        <input type="hidden" name="id" id="about-id" value="{{ $service_provider_terms->id }}">
                                        <button type="submit" class="btn btn-primary" id="edit-submit-button"><i class="fa fa-check-square-o"></i> {{ __('Update') }}</button>
                                    </form>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div><!--End Row-->
        </div>
        <!-- End container-fluid-->
    </div>
    <script>
        $('.summernote').summernote({
            placeholder: '',
            tabsize: 2,
            height: 600,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'clear']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link', 'picture', 'video']],
                ['view', ['fullscreen', 'codeview', 'help']]
            ]
        });
        $(document).ready(function() {


        });
    </script>
@endsection
@push('foot')

@endpush
