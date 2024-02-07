@extends('worker.layout.app')
@push('title') {{ __('Services') }} @endpush
@push('head')
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
                                <input type="text" id="title" class="form-control form-control-lg" placeholder="Title here..." value="{{ $pageService->title }}">
                            </div>
                            <div class="form-group">
                                <textarea class="form-control form-control-lg" id="description" rows="4" placeholder="Service Description...">{!! $pageService->description !!}</textarea>
                            </div>

                            <div class="row">
                                {{-- <div class="col">
                                    <div class="form-group">
                                        <select id="service" class="form-control form-control-lg">
                                            <option disabled selected>{{ __('Category') }}</option>
                                            @foreach($categories as $category)
                                                <optgroup label="{{ $category->name }}">
                                                    @foreach($category->services as $service)
                                                        <option value="{{ $service->id }}" @if($pageService->service_id == $service->id) selected class="alert-success" @endif>{{ $service->name }}</option>
                                                    @endforeach
                                                </optgroup>
                                            @endforeach
                                        </select>
                                    </div>
                                </div> --}}
                                <div class="col">
                                    <div class="form-group">
                                        <input type="number" id="day" class="form-control form-control-lg" placeholder="Days 1" value="{{ $pageService->day }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <input type="text" id="tags" class="form-control form-control-lg" placeholder="Search tags" value="{{ $pageService->tags }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <input type="number" id="price" class="form-control form-control-lg" placeholder="Price" value="{{ $pageService->budget }}">
                                    </div>
                                </div>

                                <div class="col">
                                    <div class="form-group">
                                        <input type="file" id="service_photo" class="form-control form-control-lg" placeholder="{{ __('Thambline Photo') }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="form-group d-flex">
                                        <button type="button" id="service-submit-button" value="{{ $pageService->id }}" class="mb-2 btn btn-lg btn-success w-50 btn-rounded">{{ __('Done') }}</button>
                                        <a href="{{ route('worker.showWorkerService', \Illuminate\Support\Facades\Crypt::encryptString($pageService->id)) }}" type="button" value="{{ $pageService->id }}" class="mb-2 btn btn-lg btn-danger w-50 btn-rounded">{{ __('Cancel') }}</a>
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
        $(document).ready(function() {
            //Submit new Job
            $('#service-submit-button').click(function(){
                var balance = {{ App\User::worker_bid_gig_limit(auth()->user()->id) }}
                if(Number($('#price').val()) <= Number(balance)) {

                    var formData = new FormData();
                    formData.append('pageService', $(this).val())
                    formData.append('title', $('#title').val())
                    formData.append('description', $('#description').val())
                    formData.append('service', $('#service').val())
                    formData.append('day', $('#day').val())
                    formData.append('tags', $('#tags').val())
                    formData.append('price', $('#price').val())
                    formData.append('thambline_photo', $('#service_photo')[0].files[0])
                    $.ajax({
                        method: 'POST',
                        url: "{{ route('worker.updateWorkerService') }}",
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function (data) {
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

                            // setTimeout(function() {
                            //     location.reload();
                            // }, 1000);

                            setTimeout(function() {
                                location.href='{{ route('worker.showWorkerService', \Illuminate\Support\Facades\Crypt::encryptString($pageService->id)) }}';
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
                }else{
                    $('#rechargeModalforBid').modal('show');
                }
            });
        });
    </script>
    <script>
        $('#description').summernote({
            placeholder: 'Description',
            tabsize: 2,
            height: 120,
            toolbar: [

            ]
        });
    </script>
@endsection
