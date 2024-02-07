@extends('admin.layout.app')
@push('title')
    {{ __('Administrative profile') }}
@endpush
@push('head')
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.16/css/jquery.dataTables.css">
@endpush
@section('content')
    <div class="content-wrapper">
        <div class="container-fluid">
            <!-- Breadcrumb-->
            <div class="row pt-2 pb-2">
                <div class="col-sm-9">
                    <h4 class="page-title">{{ $user->user_name }} {{ __('profile') }}</h4>
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
                                        <label>{{ __('Fullname') }}</label>
                                        <input value="{{ $user->full_name }}" required type="text" name="full_name" class="form-control full_name" >
                                        <br>
                                        <label>{{ __('Username') }}</label>
                                        <input value="{{ $user->user_name }}" required type="text" name="user_name" class="form-control user_name">
                                        <br>
                                        <label>{{ __('Phone') }}</label>
                                        <input value="{{ $user->phone }}" required type="text" name="phone" class="form-control phone">
                                        <br>
                                        <label>{{ __('Password') }}</label>
                                        <input value="" required type="text" name="password" class="form-control password">
                                        <br>
                                    </div>
                                    <div class="col-md-6 col-xl-6">
                                        <label for="basic-select">{{ __('Gender') }}</label>
                                        <select name="gender" class="form-control gender" id="gender">
                                            <option @if($user->gender === 'male') selected @endif value="male">{{ __('Male') }}</option>
                                            <option @if($user->gender === 'female') selected @endif  value="female">{{ __('Female') }}</option>
                                        </select>
                                        <br>
                                        <label>{{ __('Chose district') }} ({{ $user->upazila->district->name }})</label>
                                        <select name="district_id" class="form-control district_id" id="district-id">
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
                        formData.append('role', 'admin');
                        formData.append('full_name', $('#main-form').find('.full_name').val());
                        formData.append('user_name', $('#main-form').find('.user_name').val());
                        formData.append('phone', $('#main-form').find('.phone').val());
                        formData.append('password', $('#main-form').find('.password').val());
                        formData.append('gender', $('#main-form').find('.gender').val());
                        formData.append('upazila_id', $('#main-form').find('.upazila_id').val());
                        formData.append('district_id', $('#main-form').find('.district_id').val());
                        formData.append('id', id);

                        var this_button = $(this);
                        $.ajax({
                            method: 'POST',
                            url: "{{ route('admin.users.profile.update') }}",
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
