@extends('worker.layout.app')
@push('title') {{ __('Gigs') }} @endpush
@push('head')
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
@endpush
@section('content')
    <div class="wrapper homepage">
        <!-- Start job posting area -->
        <div class="container">
            <div class="card shadow mt-4 h-500">
                <div class="card-body">
                    <div class="row">
                        <div class="container">
                            <div class="form-group">
                                <input type="text" id="title" class="form-control form-control-lg" placeholder="Title here..." value="{{ $workerGig->title }}">
                            </div>
                            <div class="form-group">
                                <textarea class="form-control form-control-lg" id="description" rows="4" placeholder="Gig Description...">{!! $workerGig->description !!}</textarea>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <select id="service" class="form-control form-control-lg">
                                            <option disabled selected>{{ __('Category') }}</option>
                                             @foreach($categories as $category)
                                                @php
                                                    $visible = 0;
                                                @endphp
                                                @foreach($category->services as $service)
                                                    @if ($service->gig_post == 1)
                                                        @php
                                                            $visible += 1;
                                                        @endphp
                                                    @endif
                                                @endforeach

                                                @if ($visible != 0)
                                                    <optgroup label="{{ $category->name }}">
                                                        @foreach($category->services as $service)
                                                            @if($service->gig_post == 1)
                                                            <option value="{{ $service->id }}"  @if($workerGig->service_id == $service->id) selected class="alert-success" @endif>{{ $service->name }}</option>
                                                            @endif
                                                        @endforeach
                                                    </optgroup>
                                                @endif         
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <input type="number" id="day" class="form-control form-control-lg" placeholder="Hours " value="{{ $workerGig->day }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <input type="text" id="tags" class="form-control form-control-lg" placeholder="Search tags" value="{{ $workerGig->tags }}">
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <input type="number" id="price" class="form-control form-control-lg" placeholder="Price" value="{{ $workerGig->budget }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                {{-- <div class="col">
                                    <div class="form-group">
                                        <input type="file" id="cover_photo" class="form-control form-control-lg" placeholder="{{ __('Cover Photo') }}">
                                        <div class="card-body">
                                            <img src="{{ asset($workerGig->cover_photo) }}" height="100px" width="100px">
                                        </div>
                                    </div>
                                </div> --}}
                                <div class="col">
                                    <div class="form-group">
                                        <input type="file" id="thambline_photo" class="form-control form-control-lg" placeholder="{{ __('Thambline Photo') }}">
                                        <div class="card-body">
                                            <img src="{{ asset($workerGig->thambline_photo) }}" height="100px" width="100px">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <button type="button" id="gig-submit-button" value="{{ $workerGig->id }}" class="mb-2 btn btn-lg btn-success w-100 btn-rounded">{{ __('Done') }}</button>
                                    </div>
                                </div>
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
    <script>
        
    </script>
    <script>
        $(document).ready(function() {

            //Submit new Job
            $('#gig-submit-button').click(function(){
                $("#gig-submit-button").prop("disabled", true);
                var formData = new FormData();
                formData.append('gig', $(this).val())
                formData.append('title', $('#title').val())
                formData.append('description', $('#description').val())
                formData.append('service', $('#service').val())
                formData.append('day', $('#day').val())
                formData.append('tags', $('#tags').val())
                formData.append('price', $('#price').val())
                // formData.append('cover_photo', $('#cover_photo')[0].files[0])
                formData.append('thambline_photo', $('#thambline_photo')[0].files[0])
                $.ajax({
                    method: 'POST',
                    url: "{{ route('worker.updateWorkerGig') }}",
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (data) {
                        $("#gig-submit-button").prop("disabled", false);
                        $('#title').val('');
                        $('#description').val('');
                        $('#tags').val('');
                        //$('#service').val('');
                        $('#day').val('');
                        $('#price').val('');
                        Swal.fire({
                            position: 'top-end',
                            icon: data.type,
                            title: data.message,
                            showConfirmButton: false,
                            timer: 1500
                        })
                        setTimeout(function() {
                            location.reload();
                        }, 1000); //1 second
                    },
                    error: function (xhr) {
                        $("#gig-submit-button").prop("disabled", false);
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
        $('#description').summernote({
            placeholder: 'Description',
            tabsize: 2,
            height: 120,
            
        });
    </script>
@endsection
