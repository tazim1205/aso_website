@extends('worker.layout.app')
@push('title') {{ __('Gigs') }} @endpush
@push('head')
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
    <style>
        .preview {
            margin-top: 20px;
            display: none;
        }

        .preview img {
            max-width: 100%;
            max-height: 200px;
        }
    </style>
@endpush
@section('content')
    <div class="order-nav">
        <div class="order-nav-flex">
            <ul>
                <li class="@if(Route::is('worker.gig.index')) under @endif">
                    <a href="{{ route('worker.gig.index') }}" class="@if(Route::is('worker.gig.index')) blue-0 @endif">গিগ</a>
                </li>
                <li class="@if(Route::is('worker.services')) under @endif">
                    <a href="{{ route('worker.services') }}" class="@if(Route::is('worker.services')) blue-0 @endif">সার্ভিস</a>
                </li">
                <li class="@if(Route::is('worker.services.pages')) under @endif">
                    <a href="{{ route('worker.services.pages') }}" class="@if(Route::is('worker.services.pages')) blue-0 @endif">পেইজ</a>
                </li>
                <li class="@if(Route::is('worker.services.membership')) under @endif">
                    <a href="{{ route('worker.services.membership') }}" class="@if(Route::is('worker.services.membership')) blue-0 @endif">মেম্বারশিপ</a>
                </li>
            </ul>
        </div>
    </div>

    @yield('gig_content')
@endsection
@push('foot')
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
    <script>
        function browseImage() {
            document.getElementById('fileInput').click();
        }
        // Listen for file input changes
        document.getElementById('fileInput').addEventListener('change', handleFileSelect);

        function handleFileSelect(event) {
            // Handle the selected file (you can add further processing here)
            var selectedFile = event.target.files[0];
            var fileInput = this;
            var imagePreview = document.getElementById('imagePreview');
            var previewImage = imagePreview.querySelector('img');

            if (selectedFile) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    previewImage.src = e.target.result;
                };

                reader.readAsDataURL(selectedFile);

                imagePreview.style.display = 'block';
            }
        }


        $(document).ready(function() {
            //Submit new Job
            $('#gig-submit-button').click(function(){
                var formData = new FormData();
                formData.append('title', $('#title').val())
                formData.append('description', $('#description').val())
                formData.append('service', $('#gig_category').val())
                formData.append('day', $('#day').val())
                formData.append('tags', $('#tags').val())
                formData.append('price', $('#price').val())
                formData.append('thambline_photo', $('#fileInput')[0].files[0])
                $.ajax({
                    method: 'POST',
                    url: "{{ route('worker.gig.store') }}",
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (data) {
                        $('#title').val('');
                        $('#description').val('');
                        $('#tags').val('');
                        $('#gig_category').val('');
                        $('#day').val('');
                        $('#price').val('');
                        Swal.fire({
                            icon: 'success',
                            title: 'Successfully add new gig.',
                            showConfirmButton: false,
                            timer: 1500
                        })
                        setTimeout(function() {
                            location.reload();
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

            //Submit new Job
            $('#service-submit-button').click(function(){
                var balance = {{ App\User::worker_bid_gig_limit(auth()->user()->id) }}
                if(Number($('#service_price').val()) <= Number(balance)) {
                    var formData = new FormData();
                    formData.append('title', $('#service_title').val())
                    formData.append('description', $('#service_description').val())
                    // formData.append('service', $('#service_category').val())
                    formData.append('day', $('#service_day').val())
                    formData.append('tags', $('#service_tags').val())
                    formData.append('price', $('#service_price').val())
                    formData.append('thambline_photo', $('#fileInput')[0].files[0])
                    $.ajax({
                        method: 'POST',
                        url: "{{ route('worker.service.store') }}",
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function (data) {
                            $('#service_title').val('');
                            $('#service_description').val('');
                            $('#service_tags').val('');
                            // $('#service_category').val('');
                            $('#service_day').val('');
                            $('#pservice_rice').val('');
                            Swal.fire({
                                icon: 'success',
                                title: 'Successfully added new service.',
                                showConfirmButton: false,
                                timer: 1500
                            })
                            setTimeout(function() {
                                location.reload();
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
        })
    </script>


@endpush
