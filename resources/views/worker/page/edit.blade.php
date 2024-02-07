@extends('worker.layout.app')
@push('title') {{ __('Pages') }} @endpush
@push('head')
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
@endpush
@section('content')
    <div class="wrapper homepage">
        <!-- Start job posting area -->
        <div class="">
            <div class="alert alert-primary text-center active-job" role="alert">
                <b id="">{{ __('Edit Page') }}</b>
            </div>
        </div>
        <div class="container">
            <div class="card shadow mt-4 h-500">
                <div class="card-body">
                    <div class="row">
                        <div class="container">
                            <div class="form-group">
                                <input type="text" name="name" id="page_name" class="form-control form-control-lg" placeholder="{{ __('Page Name here...') }}" value="{{ $workerpage->name }}">
                            </div>
                            <div class="form-group">
                                <input type="hidden" name="page_package_id" id="page_package_id" value="{{ auth()->user()->membership->membership_package_id }}">
                                <input type="hidden" name="page_id" id="page_id" value="{{ Crypt::encryptString($workerpage->id) }}">
                                <input type="text" id="page_title" class="form-control form-control-lg" placeholder="Title here..." value="{{ $workerpage->title }}">
                            </div>
                            @if ($workerpage->description)
                            <div class="form-group">
                                <textarea class="form-control form-control-lg" id="page_description" rows="4" placeholder="Gig Description...">{!! $workerpage->description !!}</textarea>
                            </div>
                            @endif
                            @if ($workerpage->address)
                            <div class="form-group">
                                <textarea class="form-control form-control-lg" id="page_address" rows="1" placeholder="Gig Description...">{!! $workerpage->address !!}</textarea>
                            </div>
                            @endif

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <select id="page_service" name="service[]" class="form-control form-control-lg" style="width: 100%" multiple = "multiple">
                                            <option disabled>{{ __('Service') }}</option>

                                            @foreach($categories as $category)
                                                @php
                                                    $visible = 0;
                                                @endphp

                                                @foreach($category->services as $service)
                                                    @foreach (Str::of(auth()->user()->membership->sub_categories)->explode(',') as $service_id)
                                                        @if ($service_id)
                                                            @if ($service->id == $service_id)
                                                                @php
                                                                    $visible += 1;
                                                                @endphp
                                                            @endif
                                                        @endif
                                                    @endforeach
                                                @endforeach

                                                @if ($visible != 0)
                                                    <optgroup label="{{ $category->name }}">
                                                        @foreach($category->services as $service)
                                                            @foreach (Str::of(auth()->user()->membership->sub_categories)->explode(',') as $service_id)
                                                                @if ($service_id)
                                                                    @if ($service->id == $service_id)
                                                                        <option value="{{ $service->id }}"
                                                                            @foreach (Str::of($workerpage->services)->explode(',') as $worker_service_id)
                                                                                @if ($worker_service_id)
                                                                                    @if ($worker_service_id == $service->id)
                                                                                        {{ "selected" }}
                                                                                    @else 
                                                                                        {{ "" }}
                                                                                    @endif
                                                                                @endif
                                                                            @endforeach
                                                                            >{{ $service->name }}</option>
                                                                    @endif
                                                                @endif
                                                            @endforeach
                                                        @endforeach
                                                    </optgroup>
                                                @endif
                                                {{-- <optgroup label="{{ $category->name }}" 

                                                    @foreach($category->services as $service)
                                                        @foreach (Str::of(auth()->user()->membership->sub_categories)->explode(',') as $service_id)
                                                            @if ($service_id)
                                                                @if ($service->id == $service_id)
                                                                    @php
                                                                        $visible += 1;
                                                                    @endphp
                                                                @endif
                                                            @endif
                                                        @endforeach
                                                    @endforeach
                                                    @php
                                                        if ($visible == 0) {
                                                            // echo "hidden";
                                                            echo "disabled";
                                                        }
                                                    @endphp
                                                    >
                                                    @foreach($category->services as $service)
                                                        @foreach (Str::of(auth()->user()->membership->sub_categories)->explode(',') as $service_id)
                                                            @if ($service_id)
                                                                @if ($service->id == $service_id)
                                                                    <option value="{{ $service->id }}"
                                                                        @foreach (Str::of($workerpage->services)->explode(',') as $worker_service_id)
                                                                            @if ($worker_service_id)
                                                                                @if ($worker_service_id == $service->id)
                                                                                    {{ "selected" }}
                                                                                @else 
                                                                                    {{ "" }}
                                                                                @endif
                                                                            @endif
                                                                        @endforeach
                                                                        >{{ $service->name }}</option>
                                                                @endif
                                                            @endif
                                                        @endforeach
                                                    @endforeach
                                                </optgroup> --}}
                                            @endforeach
                                        </select>
                                    </div>
                                </div>



                                <div class="col-md-6">
                                    <div class="form-group">
                                        <select id="worker_service" name="worker_service" class="form-control form-control-lg" style="width: 100%" multiple = "multiple">
                                            {{-- <option disabled>Select your services to show in page</option> --}}
                                            {{ (auth()->user()->membership->id == $workerpage->membership_id) ? "Membership Running":"Page Expired, Page Hidden by Default" }}

                                            @foreach($page_service as $service)
                                                <option value="{{ $service->id }}"
                                                    @foreach (Str::of($workerpage->worker_services)->explode(',') as $service_id)
                                                        @foreach (Str::of($workerpage->worker_services)->explode(',') as $service_id)
                                                            @if ($service_id)
                                                                @if ($service_id == $service->id)
                                                                    @if (auth()->user()->membership->id == $workerpage->membership_id)
                                                                        {{ "selected" }}
                                                                    @endif
                                                                @else 
                                                                    {{ "" }}
                                                                @endif
                                                            @endif
                                                        @endforeach

                                                        {{-- @if ($service_id)
                                                            @if ($service_id == $service->id)
                                                                {{ "selected" }}
                                                            @else 
                                                                {{ "" }}
                                                            @endif
                                                        @endif --}}
                                                    @endforeach
                                                >{{ $service->title }}</option>
                                            @endforeach
                                        </select>
                                        {{-- <small class="text-danger">You can select maximum {{ App\MembershipPackage::find(auth()->user()->membership->membership_package_id)->service_count }} services</small> --}}
                                    </div>
                                </div>
                                @if ($workerpage->phone)
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="text" id="page_phone" class="form-control form-control-lg" placeholder="Phone Number" value="{{ $workerpage->phone }}">
                                    </div>
                                </div>
                                @endif
                                <div class="col-md-6">
                                    <div class="form-group">
                                        {{-- <input type="text" id="location_source" placeholder="Enter Location With <iframe> Tag" class="form-control mb-2" value=""> --}}
                                        <input type="text" id="page_location" class="form-control form-control-lg" placeholder="Location" value="{{ $workerpage->location }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="file" id="page_image"  class="form-control" value="">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group d-flex">
                                <button type="button" id="page-update-button" value="{{ $workerpage->id }}" class="mb-2 btn btn-lg btn-success w-50 btn-rounded">{{ __('Done') }}</button>
                                <a href="{{ route('worker.showWorkerPage', \Illuminate\Support\Facades\Crypt::encryptString($workerpage->id)) }}" type="button" value="{{ $workerpage->id }}" class="mb-2 btn btn-lg btn-danger w-50 btn-rounded">{{ __('Cancel') }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
        </div>
        <!-- End job posting area -->

        <!-- footer-->
        <div class="footer">
            <div class="no-gutters">
                <div class="col-auto mx-auto">
                    <div class="row no-gutters justify-content-center">
                        <div class="col-auto">
                            <a href="{{ route('customer.home.index') }}" class="btn btn-link-default active">
                                <i class="material-icons">home</i>
                            </a>
                        </div>
                        <div class="col-auto">
                            <a href="#" class="btn btn-link-default">
                                <i class="material-icons">insert_chart_outline</i>
                            </a>
                        </div>
                        <div class="col-auto">
                            <a href="#" class="btn btn-link-default">
                                <i class="material-icons">account_balance_wallet</i>
                            </a>
                        </div>
                        <div class="col-auto">
                            <a href="#" class="btn btn-link-default">
                                <i class="material-icons">widgets</i>
                            </a>
                        </div>
                        <div class="col-auto">
                            <a href="#" class="btn btn-link-default">
                                <i class="material-icons">account_circle</i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- footer ends-->
    </div>


    
    {{-- <script type="text/javascript">
        $(document).ready(function() {
            var arr = new Array();
            $("#worker_service").change(function() {
                $(this).find("option:selected")
                if ($(this).find("option:selected").length > {{ App\MembershipPackage::find(auth()->user()->membership->membership_package_id)->service_count }}) {
                    $(this).find("option").removeAttr("selected");
                    $(this).val(arr);
                }
                else {
                    arr = new Array();
                    $(this).find("option:selected").each(function(index, item) {
                        arr.push($(item).val());
                    });
                }
            });
        });
    </script> --}}
    <script>
        $(document).ready(function() {
            $("#page_service").select2({
                placeholder: "Services Where Page Will Show",
                allowClear: true,
            });
            $("#worker_service").select2({
                placeholder: "Services Where Page Will Show",
                allowClear: true,
                maximumSelectionLength: {{ App\MembershipPackage::withTrashed()->find(auth()->user()->membership->membership_package_id)->service_count }}
            });

            $("#location_source").keyup(function(){
                var location_source = $('#location_source').val();
                var location = $($(location_source)).filter('iframe').attr('src');
                $("#page_location").attr("value", location);
            });
            //Submit new Job
            $('#page-update-button').click(function(){
                var formData = new FormData();
                formData.append('package_id', $('#page_package_id').val())
                formData.append('page_id', $('#page_id').val())
                formData.append('name', $('#page_name').val())
                formData.append('title', $('#page_title').val())
                formData.append('description', $('#page_description').val())
                formData.append('address', $('#page_address').val())
                formData.append('service', $('#page_service').val())
                formData.append('worker_service', $('#worker_service').val())
                formData.append('phone', $('#page_phone').val())
                formData.append('image', $('#page_image')[0].files[0])
                formData.append('location', $('#page_location').val())

                // locaton = $('#page_location').val();
                // alert(locaton);

                $.ajax({
                    method: 'POST',
                    url: "{{ route('worker.updateworkerpage') }}",
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (data) {
                        $('#page_package_id').val('');
                        $('#page_name').val('');
                        $('#page_title').val('');
                        $('#page_description').val('');
                        $('#page_address').val('');
                        $('#page_service').val('');
                        $('#worker_service').val('');
                        $('#page_phone').val('');
                        $('#page_location').val('');
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: 'Successfully Page Updated.',
                            showConfirmButton: false,
                            timer: 1500
                        })
                        setTimeout(function() {
                            location.href='{{ route('worker.showWorkerPage', \Illuminate\Support\Facades\Crypt::encryptString($workerpage->id)) }}';
                        }, 1000); //1 second
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

     <script>
        $('#page_description').summernote({
            toolbar: [
              ['style', ['style']],
              ['font', ['bold', 'underline', 'clear']],
              ['fontname', ['fontname']],
              ['color', ['color']],
              ['para', ['ul', 'ol', 'paragraph']],
              ['table', ['table']],
              ['insert', ['link',  'video']],
            ],
            placeholder: 'Page Description',
            tabsize: 2,
            height: 120,
            
        });
    </script>
@endsection
