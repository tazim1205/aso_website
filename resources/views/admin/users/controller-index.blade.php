@extends('admin.layout.app')
@push('title')
    {{ __('Area controller List') }}
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
                    <h4 class="page-title">{{ __('Area controller List') }}</h4>
                </div>
            </div>
            <!-- End Breadcrumb-->
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="active-tab" data-toggle="tab" href="#active" role="tab" aria-controls="active" aria-selected="true">
                                        Active Controller List
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="deleted-data" data-toggle="tab" href="#deleted" role="tab" aria-controls="inactive" aria-selected="false">
                                        Deleted Data
                                    </a>
                                </li>
                            </ul>
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active" id="active" role="tabpanel" aria-labelledby="active-tab">
                                    <div class="row">
                                        <div class="table-responsive">
                                            <table  class="table" id="datatable">
                                                <thead class="thead-success shadow-success">
                                                <tr>
                                                    <th scope="col">{{ __('Name') }}</th>
                                                    <th scope="col">{{ __('Upazilla') }}</th>
                                                    <th scope="col">{{ __('District') }}</th>
                                                    <th scope="col">{{ __('Phone') }}</th>
                                                    <th scope="col">{{ __('Email') }}</th>
                                                    <th scope="col">{{ __('Username') }}</th>
                                                    <th scope="col">{{ __('Status') }}</th>
                                                    <th scope="col">{{ __('Action') }}</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                {{--  impoterd by ajax datatable--}}
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="deleted" role="tabpanel" aria-labelledby="deleted-data">
                                @php
                                use App\User;
                                $deleted=  User::where('role','controller')->onlyTrashed()->get();
                                @endphp
                                <div class="row">
                                    <div class="table-responsive">
                                        <table  class="table" id="datatable">
                                            <thead class="thead-success shadow-success">
                                                <tr>
                                                    <th scope="col">{{ __('Name') }}</th>
                                                    <th scope="col">{{ __('Upazilla') }}</th>
                                                    <th scope="col">{{ __('District') }}</th>
                                                    <th scope="col">{{ __('Phone') }}</th>
                                                    <th scope="col">{{ __('Email') }}</th>
                                                    <th scope="col">{{ __('Username') }}</th>
                                                    <th scope="col">{{ __('Action') }}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if($deleted)
                                                @foreach ($deleted as $v)
                                                <tr>
                                                    <td>{{$v->full_name}}</td>
                                                    <td>{{$v->upazila_id}}</td>
                                                    <td>{{$v->district_id}}</td>
                                                    <td>{{$v->phone}}</td>
                                                    <td>{{$v->email}}</td>
                                                    <td>{{$v->user_name}}</td>
                                                    <td>
                                                    <a href="{{ route('admin.users.users_information_restore', $v->id) }}" class="btn btn-sm btn-info">Restore</a>
                                                    <a href="{{ route('admin.users.users_information_delete', $v->id) }}" onclick="return Sure()" class="btn btn-sm btn-danger">Permenantly Delete</a>
                                                    </td>
                                                </tr>
                                                @endforeach
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!--End Row-->
        </div>
        <!-- End container-fluid-->
    </div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Controller</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('admin.users.profile.update') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="id" id="id">
                        <input type="hidden" name="user_name" id="username">
                        <input type="hidden" name="role" id="role">
                        <div class="form-group">
                            <label for="full_name">Full Name</label>
                            <input type="text" class="form-control" id="full_name" name="full_name" placeholder="">
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="">
                        </div>
                        <div class="form-group">
                            <label for="phone">Phone</label>
                            <input type="text" class="form-control" id="phone" name="phone" placeholder="">
                        </div>

                        <label for="basic-select">{{ __('Gender') }}</label>
                        <select name="gender" class="form-control gender" id="gender">
                            <option value="male">{{ __('Male') }}</option>
                            <option value="female">{{ __('Female') }}</option>
                        </select>
                        <br>
                        <label>{{ __('Chose district') }} </label>
                        <select name="district_id" class="form-control district_id" id="district-id">
                            @foreach($districts as $district)
                                <option id="districtId" value="{{ $district->id }}">{{ __($district->name) }}</option>
                            @endforeach
                        </select>
                        <br>
                        <label>{{ __('Chose upazila') }}</label>
                        <select name="upazila_id" class="form-control upazila_id" id="upazila-id">
                            <option selected disabled value="" id="upazila-loader">
                                <span class="badge badge-warning mb-1">{{ __('Loading ...') }}</span>
                            </option>
                            <!-- Insert by ajax -->
                        </select>
                        <br>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="">
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


@endsection
@push('foot')
    <script type="text/javascript" charset="utf8" src="//cdn.datatables.net/1.10.16/js/jquery.dataTables.js"></script>
    <script>
        $(document).ready( function () {
            var dataTable = $('#datatable').DataTable({
                processing: true,
                serverSide: true,
                autoWidth: false,
                pageLength: 10,
                // scrollX: true,
                "order": [[ 0, "desc" ]],
                ajax: '{{ route('admin.controller.index.ajax') }}',
                columns: [
                    {data: 'full_name', name: 'full_name'},
                    {data: 'upazila_id', name: 'upazila_id'},
                    {data: 'district_id', name: 'district_id'},
                    {data: 'phone', name: 'phone'},
                    {data: 'email', name: 'email'},
                    {data: 'user_name', name: 'user_name'},
                    {data: 'status', name: 'status'},
                    {data: 'Actions', name: 'Actions',orderable:false,serachable:false,sClass:'text-center'},
                ]
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


            //     Edit Button
            $(document).on('click', '.editbtn', function(){
                let id = $(this).data('id');
                let name = $(this).data('name');
                let email = $(this).data('email');
                let phone = $(this).data('phone');
                let gender = $(this).data('gender');
                let district_id = $(this).data('dist');
                let username = $(this).data('username');
                let role = $(this).data('role');
                let upazila_id = $(this).data('upazila');
                $("#exampleModal").modal('show');
                $("#full_name").val(name);
                $("#email").val(email);
                $("#phone").val(phone);
                $("#gender").val(gender);
                $("#district-id").val(district_id);
                $("#id").val(id);
                $("#username").val(username);
                $("#role").val(role);
                $("#upazila-id").val(upazila_id);
            })
        });
    </script>
    <script>
        function Sure()
        {
            if(confirm("Are Your Sure To Delete?"))
            {
                return ture;
            }
            else
            {
                return false;
            }
        }
    </script>
@endpush
