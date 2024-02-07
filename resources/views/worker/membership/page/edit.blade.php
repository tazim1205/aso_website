@extends('worker.layout.app')
@push('title') {{ __('Edit') }} @endpush
@section('content')
    <!-- Start job posting area -->
    <div class="container">
        <div class="card shadow mt-4 h-500">
            <div class="card-body">
                <div class="row">
                    <div class="container">
                        <form action="">
                            <div class="form-group">
                                <lable>{{ __('Logo') }}</lable>
                                <!--Image upload with preview start -->
                                <div class="figure-profile shadow my-4">
                                    <figure><img src="{{ asset($myPage->logo) }}" alt="" class="image-display"></figure>
                                    <div class="btn btn-dark text-white floating-btn image-chose-btn">
                                        <i class="material-icons">camera_alt</i>
                                        <input type="file" id="logo" accept="image/*" value="{{ $myPage->logo }}" class="float-file image-importer">
                                    </div>
                                </div>
                                <!--Image upload with preview end -->
                            </div>
                            <div class="form-group">
                                <lable>{{ __('Brand name') }}</lable>
                                <input type="text" id="name" class="form-control form-control-lg" value="{{ $myPage->name }}" placeholder="{{ __('Brand name') }}...">
                            </div>
                            @if(auth()->user()->membership->membershipPackage->mobile_availability == 1)
                                <div class="form-group">
                                    <lable>{{ __('Mobile no.') }}</lable>
                                    <input type="text" id="mobile" class="form-control form-control-lg" value="{{ $myPage->mobile }}" placeholder="{{ __('Mobile no.') }}...">
                                </div>
                            @endif
                            <div class="form-group">
                                <lable>{{ __('Title') }}</lable>
                                <input type="text" id="title" class="form-control form-control-lg" value="{{ $myPage->title }}" placeholder="{{ __('Title') }}...">
                            </div>
                            @if(auth()->user()->membership->membershipPackage->description_availability == 1)
                            <div class="form-group">
                                <lable>{{ __('Description') }}</lable>
                                <textarea class="form-control form-control-lg" id="description" rows="6" placeholder="{{ __('Description') }}">{!! $myPage->description !!}</textarea>
                            </div>
                            <div class="form-group">
                                <lable>{{ __('Address') }}</lable>
                                <input type="text" id="address" class="form-control form-control-lg" value="{{ $myPage->address }}" placeholder="{{ __('Address') }}">
                            </div>
                            @endif
                            @for($image_amount=1; $image_amount <= auth()->user()->membership->membershipPackage->image_count; $image_amount++)
                                <div class="form-group">
                                    <lable>{{ __('Image-') }} {{ $image_amount }}</lable>
                                    <!--Image upload with preview start -->
                                    <div class="figure-profile shadow my-4">
                                        @php
                                        $img = 'image'.$image_amount;
                                        @endphp
                                        <figure><img alt="" src="{{ asset($myPage->$img) }}" class="image-display"></figure>
                                        <div class="btn btn-dark text-white floating-btn image-chose-btn">
                                            <i class="material-icons">camera_alt</i>
                                            <input type="file" accept="image/*" id="image-{{ $image_amount }}" value="{{ $myPage->logo.$image_amount }}" class="float-file image-importer">
                                        </div>
                                    </div>
                                    <!--Image upload with preview end -->
                                </div>
                            @endfor
                            <div class="form-group">
                                <lable>{{ __('Service') }} </lable>
                                <select id="service" class="form-control form-control-lg">
                                    <option disabled selected>{{ __('Select service') }}</option>
                                    @foreach(auth()->user()->membershipService as $service)
                                        <option value="{{ $service->service->id }}" @if($service->service->id == $myPage->membership_service_id) selected style="background-color: maroon;" @endif>{{ $service->service->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <button type="button" id="save" class="mb-2 btn btn-lg btn-success w-100 btn-rounded">{{ __('SAVE') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <hr>
    </div>
    <!-- End job posting area -->
    <!-- page level script -->
    <script>
        $(document).ready(function(){
            //Profile image upload preview
            //Chose image
            $(".image-chose-btn").click(function (){
                $(this).parent().find('.image-importer').click();
            })
            //Display image
            $(".image-importer").change(function (event){
                if(event.target.files.length > 0) {
                    $(this).parent().parent().find('.image-display').attr("src",URL.createObjectURL(event.target.files[0]));
                }
            })

            //Customer register submit
            $("#save").click(function (){
                var formData = new FormData();
                formData.append('logo', $('#logo')[0].files[0])
                formData.append('name', $('#name').val())
                formData.append('mobile', $('#mobile').val())
                formData.append('title', $('#title').val())
                formData.append('description', $('#description').val())
                formData.append('address', $('#address').val())
                formData.append('service', $('#service').val())
                for (x=1; x<={{ auth()->user()->membership->membershipPackage->image_count }}; x++){
                    formData.append('image-'+x, $('#image-'+x)[0].files[0])
                }

                $.ajax({
                    method: 'POST',
                    url: "{{ route('worker.page.update') }}",
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (data) {
                        if (data.type == 'success'){
                            Swal.fire({
                                position: 'top-end',
                                icon: data.type,
                                title: data.message,
                                showConfirmButton: false,
                                timer: 1500
                            })
                            setTimeout(function() {
                                //your code to be executed after 1 second
                                window.location = data.url;
                            }, 1000); //1 second
                        }else{
                            Swal.fire({
                                icon: data.type,
                                title: 'Oops...',
                                text: data.message,
                                footer: ''
                            })
                        }
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
