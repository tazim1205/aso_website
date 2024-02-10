@extends('admin.layout.app')
    @push('head')

    @endpush
@section('content')
    <div class="content-wrapper">
        <div class="container-fluid">
            <!-- Breadcrumb-->

            <div class="row pt-2 pb-2">
                <div class="col-sm-9">
                    <h4 class="page-title">{{ __('Worker | Services') }} </h4>
                </div>
                <div class="col-sm-3">
                    <div class="btn-group float-sm-right">
                        <button type="button" id="add-new" class="btn btn-outline-primary waves-effect waves-light"><i class="fa fa-plus"></i> {{ __('Add new service') }}</button>
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
                                        <th scope="col">{{ __('Company Comission Rate') }}</th>
                                        <th scope="col">{{ __('Marketer Comission Rate') }}</th>
                                        <th scope="col">{{ __('Action') }}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($services as $service)
                                    <tr>
                                        <td scope="row">{{ $loop->iteration }}</td>
                                        <td><img src="{{ asset('uploads/images/worker/service/'.$service->icon) }}" height="50px" width="50px" style="border-radius: 15px;"></td>
                                        <td>{{ $service->name }}</td>
                                        <td>{{ $service->category_name }}</td>
                                        <td>{{ $service->comission_rate ?? 0 }} %</td>
                                        <td>{{ $service->marketer_comission ?? 0 }} %</td>
                                        <td>
                                            <input type="hidden" class="hidden_comission_rate" value="{{ $service->comission_rate ?? 0 }}">
                                            <input type="hidden" class="hidden_marketer_comission" value="{{ $service->marketer_comission ?? 0 }}">

                                            <input type="hidden" class="hidden-id" value="{{ $service->id }}">
                                            <input type="hidden" class="hidden_meta_tag" value="{{ $service->meta_tag }}">
                                            <input type="hidden" class="hidden_gig_post" value="{{ $service->gig_post }}">
                                            <input type="hidden" class="hidden_job_post" value="{{ $service->job_post }}">
                                            <input type="hidden" class="hidden_page_post" value="{{ $service->page_post }}">
                                            <button type="button" id="edit" class="edit-button btn btn-outline-warning waves-effect waves-light m-1"> <i class="fa fa-edit"></i> </button>
                                            <a href="{{ route('admin.destroyWorkerService', $service->id) }}" class="btn btn-outline-danger waves-effect waves-light m-1" onclick="return confirm('Are You Sure ?')"><i class="fa fa-trash"></i></a>
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
                    <form action="#" id="add-new-from" enctype="multipart/form-data">
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
                                <option disabled selected value="">Chose category</option>
                                @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>

                        </div>
                        <div class="input-group input-group-lg mb-3">
                           <div class="input-group-prepend">
                                <span class="input-group-text">{{ __('URL/Meta Tag') }}</span>
                           </div>
                            <input type="text" name="meta_tag" class="form-control" id="meta_tag">

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

                        <div class="form-check gig_post_area" >

                        </div>
                        <div class="form-check job_post_area" >

                        </div>
                        <div class="form-check page_post_area" >

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
               formData.append('gig_post', $('#gig_post').val())
               formData.append('job_post', $('#job_post').val())
               formData.append('page_post', $('#page_post').val())
               formData.append('meta_tag', $('#meta_tag').val())
               formData.append('icon', $('#icon')[0].files[0])

               $.ajax({
                   method: 'POST',
                   url: '/admin/worker-service',
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
                $('#comission_rate').val($(this).parent().find('.hidden_comission_rate').val());
                $('#marketer_comission').val($(this).parent().find('.hidden_marketer_comission').val());
                // $('#service-name').val($(this).parent().parent().find('td').eq(2).text());
                //Find by value
                //$('#category-id').find('option[value="2"]').attr("selected",true);
                //Find by option
                var option = $(this).parent().parent().find('td').eq(3).text();
                $('#category-id').attr("selected",false)
                $('#category-id').find('option:contains('+option+')').attr("selected",true);


                if ($(this).parent().find('.hidden_gig_post').val() == 1) {
                  $('.gig_post_area').empty();
                  $('.gig_post_area').append('<input class="form-check-input" type="checkbox" id="gig_post" name="gig_post" value="1" checked="checked">'+
                     '<label class="form-check-label" for="gig_post">'+
                    'Accept Gig Post'+
                    '</label>');
                }else{
                    $('.gig_post_area').empty();
                    $('.gig_post_area').append('<input class="form-check-input" type="checkbox" id="gig_post" name="gig_post" value="0" >'+
                     '<label class="form-check-label" for="gig_post">'+
                    'Accept Gig Post'+
                    '</label>');
                }

                if ($(this).parent().find('.hidden_job_post').val() == 1) {
                  $('.job_post_area').empty();
                  $('.job_post_area').append('<input class="form-check-input" type="checkbox" id="job_post" name="job_post" value="1" checked="checked">'+
                     '<label class="form-check-label" for="job_post">'+
                    'Accept Job Post'+
                    '</label>');
                }else{
                    $('.job_post_area').empty();
                    $('.job_post_area').append('<input class="form-check-input" type="checkbox" id="job_post" name="job_post" value="0" >'+
                     '<label class="form-check-label" for="job_post">'+
                    'Accept Job Post'+
                    '</label>');
                }

                if ($(this).parent().find('.hidden_page_post').val() == 1) {
                  $('.page_post_area').empty();
                  $('.page_post_area').append('<input class="form-check-input" type="checkbox" id="page_post" name="page_post" value="1" checked="checked">'+
                     '<label class="form-check-label" for="page_post">'+
                    'Accept Page Post'+
                    '</label>');
                }else{
                    $('.page_post_area').empty();
                    $('.page_post_area').append('<input class="form-check-input" type="checkbox" id="page_post" name="page_post" value="0" >'+
                     '<label class="form-check-label" for="page_post">'+
                    'Accept Page Post'+
                    '</label>');
                }

                $('#service-id').val($(this).parent().parent().find('.hidden-id').val());
                $('#meta_tag').val($(this).parent().find('.hidden_meta_tag').val());
            });

            $(document).on("change", "#gig_post", function() {
                if (this.checked == true) {
                  $(this).val(1);
                }else{
                  $(this).val(0);
                }
            });

            $(document).on("change", "#job_post", function() {
                if (this.checked == true) {
                  $(this).val(1);
                }else{
                  $(this).val(0);
                }
            });

            $(document).on("change", "#page_post", function() {
                if (this.checked == true) {
                  $(this).val(1);
                }else{
                  $(this).val(0);
                }
            });



            // $("#page_post").change(function() {
            //     var ischecked= $(this).is(':checked');
            //     if(ischecked){
            //       $(this).val(1);
            //     }else{
            //       $(this).val(0);
            //     }
            //     // alert('uncheckd ' + $(this).val());
            // });


            //Submit edited
            $('#edit-submit-button').click(function(){

                var formData = new FormData();
                formData.append('id', $('#service-id').val())
                formData.append('name', $('#service-name').val())
                formData.append('category', $('#category-id').val())
                formData.append('comission_rate', $('#comission_rate').val())
                formData.append('marketer_comission', $('#marketer_comission').val())
                formData.append('gig_post', $('#gig_post').val())
                formData.append('job_post', $('#job_post').val())
                formData.append('page_post', $('#page_post').val())
                formData.append('meta_tag', $('#meta_tag').val())
                formData.append('icon', $('#icon')[0].files[0])
                $.ajax({
                    method: 'POST',
                    url: '/admin/worker-service/update',
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (data) {
                        $('#modal').modal('hide');
                        $('#category-name').val('');
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
