@extends('admin.layout.app')
    @push('head')

    @endpush
@section('content')
    <div class="content-wrapper">
        <div class="container-fluid">
            <!-- Breadcrumb-->
            <div class="row pt-2 pb-2">
                <div class="col-sm-9">
                    <h4 class="page-title">{{ __('Membership | Services ') }}</h4>
                </div>
                <div class="col-sm-3">
                    <div class="btn-group float-sm-right">
                        <button type="button" id="add-new" class="btn btn-outline-primary waves-effect waves-light"><i class="fa fa-plus"></i>{{ __(' Add new service') }}</button>
                    </div>
                </div>
            </div>
            <!-- End Breadcrumb-->
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">{{ __('Service Table') }}</h5>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead class="thead-success shadow-success">
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">{{ __('Icon') }}</th>
                                        <th scope="col">{{ __('Service Name') }}</th>
                                        <th scope="col">{{ __('Category Name') }}</th>
                                        <th scope="col">{{ __('Action') }}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($services as $service)
                                    <tr>
                                        <td scope="row">{{ $loop->iteration }}</td>
                                        <td><img src="{{ asset('uploads/images/membership/service/'.$service->icon) }}" height="50px" width="50px" style="border-radius: 15px;"></td>
                                        <td>{{ $service->name }}</td>
                                        <td>{{ $service->category->name }}</td>
                                        <td>
                                            <input type="hidden" class="hidden-id" value="{{ $service->id }}">
                                            <button type="button" id="edit" class="edit-button btn btn-outline-warning waves-effect waves-light m-1"> <i class="fa fa-edit"></i> </button>
                                        </td>
                                    </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!--End Row-->
        </div>
        <!-- End container-fluid-->
    </div>
    <!-- Modal -->
    <div class="modal fade" id="modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-title"><i class="fa fa-star"></i> <!--Title insert by ajax--> </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="modal-body">
                    <form action="#" id="add-new-from">
                        <div class="input-group input-group-lg mb-3">
                           <div class="input-group-prepend">
                                <span class="input-group-text">{{ __('Name') }}</span>
                           </div>
                           <input type="hidden" id="service-id">
                           <input type="text" class="form-control" name="service-name" id="service-name">
                        </div>
                        <div class="input-group input-group-lg mb-3">
                            <input type="file" class="form-control valid" accept="image/*" id="icon" name="icon" required="" aria-invalid="false">
                        </div>
                        <div class="input-group input-group-lg mb-3">
                           <div class="input-group-prepend">
                                <span class="input-group-text">{{ __('Category') }}</span>
                           </div>
                            <select class="form-control" id="category-id">
                                <option disabled selected value="">{{ __('Chose category') }}</option>
                                @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>

                        </div>


                        <div class="input-group input-group-lg mb-3">
                            <div class="input-group-prepend">
                                 <span class="input-group-text">{{ __('Comission Rate') }}</span>
                            </div>
                            <div class="input-group input-group-lg mb-3">
                             <input type="number" class="form-control" id="comission_rate" name="comission_rate">
                             </div>

                         </div>

                         <div class="input-group input-group-lg mb-3">
                            <div class="input-group-prepend">
                                 <span class="input-group-text">{{ __('Marketer Comission Rate') }}</span>
                            </div>
                            <div class="input-group input-group-lg mb-3">
                             <input type="number" class="form-control" id="marketer_comission" name="marketer_comission">
                             </div>

                         </div>




                    </form>
                </div>
                <div class="modal-footer" id="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" ><i class="fa fa-times"></i> {{ __('Close') }}</button>
                    <button type="button" class="btn btn-primary" id="add-submit-button"><i class="fa fa-check-square-o"></i> {{ __('Add new service') }}</button>
                    <button type="button" class="btn btn-primary" id="edit-submit-button"><i class="fa fa-check-square-o"></i> {{ __('Edit service') }}</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Edit Modal -->
    <script>
        $(document).ready(function() {
           //Show modal for add
           $('#add-new').click(function(){
               $('#modal').modal('show');
               $('#edit-submit-button').hide();
               $('#add-submit-button').show();
               $('#modal-title').html('Add a new service');
               $('#service-name').val('');
               $('#category-id').prop('selectedIndex',0); //Reset dropdown after click on edit
           });

           //Submit new
           $('#add-submit-button').click(function(){
               var formData = new FormData();
               formData.append('name', $('#service-name').val())
               formData.append('category', $('#category-id').val())
               formData.append('comission_rate', $('#comission_rate').val())
               formData.append('marketer_comission', $('#marketer_comission').val())
               formData.append('icon', $('#icon')[0].files[0])
               $.ajax({
                   method: 'POST',
                   url: '/admin/membership-service',
                   headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                   data: formData,
                   processData: false,
                   contentType: false,
                   success: function (data) {
                       $('#modal').modal('hide');
                       $('#service-name').val('');
                       $('#category-id').val('');
                       $('#comission_rate').val('');
                       $('#marketer_comission').val('');
                       Swal.fire({
                           position: 'top-end',
                           icon: 'success',
                           title: 'Successfully add '+data.name,
                           showConfirmButton: false,
                           timer: 1500
                       })
                       setTimeout(function() {
                           location.reload();
                       }, 800);//

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

            //Show modal for edit and set data
            $(".edit-button").click(function(){
                $('#modal').modal('show');
                $('#modal-title').html('Edit service');
                $('#add-submit-button').hide();
                $('#edit-submit-button').show();
                $('#service-name').val($(this).parent().parent().find('td').eq(2).text());
                //Find by value
                //$('#category-id').find('option[value="2"]').attr("selected",true);
                //Find by option
                var option = $(this).parent().parent().find('td').eq(3).text();
                $('#category-id').find('option:contains('+option+')').attr("selected",true);

                $('#service-id').val($(this).parent().parent().find('.hidden-id').val());
            });

            //Submit edited
            $('#edit-submit-button').click(function(){
                var formData = new FormData();
                formData.append('id', $('#service-id').val())
                formData.append('name', $('#service-name').val())
                formData.append('category', $('#category-id').val())
                formData.append('comission_rate', $('#comission_rate').val())
                formData.append('marketer_comission', $('#marketer_comission').val())
                formData.append('icon', $('#icon')[0].files[0])

                $.ajax({
                    method: 'POST',
                    url: '/admin/membership-service/update',
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (data) {
                        $('#modal').modal('hide');
                        $('#category-name').val('');
                        $('#comission_rate').val('');
                        $('#comission_rate').val('');
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: 'Successfully edited '+data.name,
                            showConfirmButton: false,
                            timer: 1500
                        })
                        setTimeout(function() {
                            location.reload();
                        }, 800);//

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
@push('foot')

@endpush
