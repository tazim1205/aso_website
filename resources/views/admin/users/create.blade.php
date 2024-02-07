@extends('admin.layout.app')
@push('title')
    {{ __('Create user') }}
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
                    <h4 class="page-title"> {{ __('Create new user') }}</h4>
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
                            <form action="{{ route('admin.users.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6 col-xl-6">
                                        <label>{{ __('Fullname') }}</label>
                                        <input value="{{ old('full_name') }}" required type="text" name="full_name" class="form-control" >
                                        <br>
                                        <label>{{ __('Username') }}</label>
                                        <input value="{{ old('user_name') }}" required type="text" name="user_name" class="form-control">
                                        <br>
                                        <label>{{ __('Phone') }}</label>
                                        <input value="{{ old('phone') }}" required type="text" name="phone" class="form-control">
                                        <br>
                                        <label>{{ __('Password') }}</label>
                                        <input value="{{ old('password') }}" required type="text" name="password" class="form-control">
                                        <br>
                                    </div>

                                    <div class="col-md-6 col-xl-6">
                                        <label for="basic-select">{{ __('Gender') }}</label>
                                        <select name="gender" class="form-control" id="basic-select">
                                            <option value="male">Male</option>
                                            <option value="female">Female</option>
                                        </select>
                                        <br>
                                        <label>{{ __('Chose user type') }}</label>
                                        <select name="role" class="form-control" id="role">
                                            <option value="controller">{{ __('Area Controller') }}</option>
                                            <option value="admin">{{ __('Sub Admin') }}</option>
                                        </select>
                                        <br>
                                        <div id="zone_section">
                                            <label>{{ __('Chose district') }}</label>
                                            <select name="district_id" class="form-control " id="district-id">
                                                @foreach($districts as $district)
                                                    <option id="districtId" value="{{ $district->id }}">{{ __($district->name) }}</option>
                                                @endforeach
                                            </select>
                                            <br>
                                            <label>{{ __('Chose upazila') }}</label>
                                            <select name="upazila_id" class="form-control " id="upazila-id">
                                                <option selected disabled value="" id="upazila-loader">
                                                    <span class="badge badge-warning mb-1">{{ __('Loading ...') }}</span>
                                                </option>
                                                <!-- Insert by ajax -->
                                            </select>
                                            <br>
                                        </div>


                                    </div>
                                    <br>
                                    <input type="hidden" name="page"">
                                    <button type="submit" class="btn btn-success btn-block waves-effect waves-light mb-1">{{ __('Create') }}</button>
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
        //when chnage role admin then hide zone section hide
        $("#role").change(function(){
            var role = $(this).val();
            console.log(role);
            if(role == 'admin'){
                $("#zone_section").addClass('d-none')
            }else{
                $("#zone_section").addClass('d-block')
            }
        });

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
    </script>
@endsection
@push('foot')

@endpush
