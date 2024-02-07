@extends('admin.layout.app')
@push('title')
    {{ __('Special profile') }}
@endpush
@push('head')

@endpush
@section('content')
    <div class="content-wrapper">
        <div class="container-fluid">
            <!-- Breadcrumb-->
            <div class="row pt-2 pb-2">
                <div class="col-sm-9">
                    <h4 class="page-title">{{ $user->name }} {{ __('profile') }}</h4>
                </div>
            </div>
            <!-- End Breadcrumb-->
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            @include('includes.message')
                        </div>
                        <div class="card-body">
                            <form id="main-form" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-md-6 col-xl-6">
                                        <input class="user_id" type="hidden" value="{{ $user->id }}">
                                        <label>{{ __('Name') }}</label>
                                        <input value="{{ $user->name }}" required type="text" name="name" class="form-control full_name" >
                                        <br>
                                        <label>{{ __('Phone') }}</label>
                                        <input value="{{ $user->phone }}" required type="text" name="phone" class="form-control phone">
                                        <br>
                                        <label>{{ __('Chose Special Service') }}</label>
                                        <select name="special_service_id" class="form-control special_service_id">
                                            @foreach($special_service as $service)
                                                <option @if($service->id === $user->special_service_id ) selected @endif id="special_service_id" value="{{ $service->id }}">{{ __($service->name) }}</option>
                                            @endforeach
                                        </select>
                                        <br>

                                    </div>
                                    <div class="col-md-6 col-xl-6">
                                        <label for="basic-select">{{ __('Is free') }}</label>
                                        <select name="is_free" class="form-control is_free" id="gender">
                                            <option @if($user->is_free === '1') selected @endif value="1"></option>
                                            <option @if($user->is_free === '0') selected @endif  value="0"></option>
                                        </select>
                                        <br>
                                        <label>{{ __('Chose district') }} ({{ $user->upazila->district->name }})</label>
                                        <select name="district_id" class="form-control " id="district-id">
                                            @foreach($districts as $district)
                                                <option id="districtId" value="{{ $district->id }}">{{ __($district->name) }}</option>
                                            @endforeach
                                        </select>
                                        <br>
                                        <label>{{ __('Chose upazila') }} ({{ $user->upazila->name }})</label>
                                        <select name="upazila_id" class="form-control upazila_id" id="upazila-id">
                                            <option selected disabled value="" id="upazila-loader">
                                                <span class="badge badge-warning mb-1">{{ __('Loading ...') }}</span>
                                            </option>
                                            <!-- Insert by ajax -->
                                        </select>
                                        <br>
                                    </div>
                                    <br>
                                    <input type="hidden" name="page"">
                                    <button  type="submit" class="btn btn-success btn-block waves-effect waves-light mb-1 update-btn">{{ __('Update') }}</button>
                                </div>
                            </form>
                            <br>
                            <br>
                        </div>
                    </div>
                </div>
            </div><!--End Row-->
        </div>
        <!-- End container-fluid-->
    </div>
    <script>
        //Hide upazila first
        $("#upazila-id").hide()
        //Get upazila after click on district
        $("#district-id").change(function(){
            var districtId = $(this).val();
            $("#upazila-id").show() //now show district
            $.ajax({
                method: 'POST',
                url: '/guest/get/upazila-of-a-district',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                data: { districtId: districtId},
                dataType: 'JSON',
                beforeSend: function (){
                    $("#upazila-loader").show()
                },
                complete: function (){
                    $("#upazila-loader").hide()
                },
                success: function (response) {
                    //console.log(response)
                    var upazilaOption='<option selected disabled> Chose upazila</option>';
                    response.forEach(function(upazila){
                        upazilaOption += '<option value='+upazila.id+'>'+upazila.name+'</option>';
                    })
                    $("#upazila-id").html(upazilaOption)
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

        $('.update-btn').click(function(){

            var formData = new FormData();
            var id = $('#main-form').find('.user_id').val();
            formData.append('name', $('#main-form').find('.full_name').val());
            formData.append('phone', $('#main-form').find('.phone').val());
            formData.append('upazila_id', $('#main-form').find('.upazila_id').val());
            formData.append('special_service_id', $('#main-form').find('.special_service_id').val());
            formData.append('is_free', $('#main-form').find('.is_free').val());
            formData.append('id', id);

            var this_button = $(this);
            $.ajax({
                method: 'POST',
                url: "{{ route('admin.special.profile.update') }}",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                data: formData,
                processData: false,
                contentType: false,
                beforeSend: function (){
                    this_button.prop("disabled", true)
                },
                complete: function (){
                    this_button.prop("disabled", false)
                },
                success: function (response_data) {
                    if (response_data.type == 'success'){
                        Swal.fire({
                            position: 'top-end',
                            icon: response_data.type,
                            title: response_data.message,
                            showConfirmButton: false,
                            timer: 1500
                        })
                        location.reload();
                    }else{
                        Swal.fire({
                            icon: response_data.type,
                            title: 'Oops...',
                            text: response_data.message,
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
    </script>
@endsection
@push('foot')

@endpush
