@extends('admin.layout.app')
    @push('title') {{ __('Membership') }} @endpush
    @push('head')

    @endpush
@section('content')
    <div class="content-wrapper">
        <div class="container-fluid">
            <!-- Breadcrumb-->
            <div class="row pt-2 pb-2">
                <div class="col-sm-9">
                    <h4 class="page-title">{{ __('Membership package manage ') }}</h4>
                </div>
                <div class="col-sm-3">
                    <div class="btn-group float-sm-right">
                        <button type="button" id="add-new" class="btn btn-outline-primary waves-effect waves-light"><i class="fa fa-plus"></i> {{ __('Add membership') }}</button>
                    </div>
                </div>
            </div>
            <!-- End Breadcrumb-->

            <div class="card">
                <div class="card-body d-flex align-items-center justify-content-between row">
                    <div class="col">Trial Period for Each Package</div>
                    <div class="col-auto d-flex justify-content-center">
                        <div class="row">
                            <div class="col-auto">
                                <div class="btn trial-data">{{ $trial_period->days }} days</div>
                                <div class="btn btn-outline-primary btn-round" id="edit-trial">Edit</div>
                            </div>
                            <div class="col-auto d-none" id="trial-from">
                                <form action="#" class="">
                                    <div class="row d-flex align-items-center">
                                        <div class="input-group-prepend col-md-6">
                                            <input type="hidden" name="id" value="{{ $trial_period->id }}" id="id">
                                            <input type="number" name="days" id="days" value="{{ $trial_period->days }}" class="form-control w-100">
                                            <span class="input-group-text">days</span>
                                        </div>
                                        <div class="col-auto">
                                            <button type="button" class="btn btn-outline-success btn-round" id="update-trial">Save</button>
                                            <button type="button" class="btn btn-outline-danger btn-round" id="cancel-trial">cancel</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                @foreach($packages as $package)
                                    <div class="col-lg-4">
                                        <div class="pricing-table">
                                            <div class="card border border-success">
                                                <div class="card-body text-center">
                                                    <div class="price-title text-success package-name">{{ $package->name }}</div>
                                                    <input type="hidden" class="hidden-id" value="{{ $package->id }}">
                                                    <ul class="list-group list-group-flush">
                                                        <li class="list-group-item"><b>{{ __('Monthly Price ') }}</b> <i class="monthly_price">{{ $package->monthly_price }}</i> ৳</li>
                                                        <li class="list-group-item"><b>{{ __('Category Extra Fee  ') }}</b> <i class="extendable_price">{{ $package->extendable_price }}</i> ৳</li>
                                                        {{-- <li class="list-group-item"><b>{{ __('Monthly Price ') }}</b> <i class="monthly_fee">{{ $package->monthly_fee }}</i> ৳</li>
                                                        <li class="list-group-item"><b>{{ __('Extra Category Price ') }}</b> <i class="extendable_price">{{ $package->extendable_price }}</i> ৳</li>
                                                        <li class="list-group-item"><b>{{ __('12 Month price ') }}</b> <i class="twelve_month_price">{{ $package->twelve_month_price }}</i> ৳</li> --}}
                                                        <li class="list-group-item"><b>{{ __('Mobile Number') }}</b>
                                                            @if($package->mobile_availability == 1)
                                                                <span class="badge badge-success shadow-success m-1 mobile_availability">{{ __('Active') }}</span>
                                                            @else
                                                                <span class="badge badge-danger shadow-danger m-1 mobile_availability">{{ __('Inactive') }}</span>
                                                            @endif
                                                           </li>
                                                        <li class="list-group-item"><b>{{ __('Description') }}</b>
                                                            @if($package->description_availability == 1)
                                                                <span class="badge badge-success shadow-success m-1 description_availability">{{ __('Active') }}</span>
                                                            @else
                                                                <span class="badge badge-danger shadow-danger m-1 description_availability">{{ __('Inactive') }}</span>
                                                            @endif
                                                        </li>
                                                        <li class="list-group-item"><b>{{ __('Maximum Service') }}</b>
                                                            <span class="badge badge-success shadow-success m-1 service_count">{{ $package->service_count }}</span>
                                                        </li>
                                                        <li class="list-group-item"><b>{{ __('Position') }}</b>
                                                            <span class="badge badge-success shadow-success m-1 position">{{ $package->position }}</span>
                                                        </li>
                                                    </ul>
                                                    <button href="javascript:void();" type="button" value="{{ $package->id }}" class="btn btn-outline-success my-3 btn-round edit-button">{{ __('Edit') }}</button>
                                                    <button type="button" class="btn btn-outline-danger my-3 btn-round delete-button" value="{{ $package->id }}">{{ __('Delete') }}</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
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
                        <input type="hidden" id="package-id">
                        <div class="input-group input-group-lg mb-3">
                           <div class="input-group-prepend">
                           <span class="input-group-text">{{ __('Package Name') }}</span>
                           </div>
                           <input type="text" class="form-control" name="name" id="name">
                         </div>
                        <div class="input-group input-group-lg mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">{{ __('Position Number') }}</span>
                            </div>
                            <input type="number" class="form-control" name="position" id="position">
                        </div>
                        <div class="input-group input-group-lg mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">{{ __('Maximum Service') }}</span>
                            </div>
                            <input type="number" class="form-control" name="service" id="service">
                        </div>

                        {{-- <div class="input-group input-group-lg mb-3">
                           <div class="input-group-prepend">
                           <span class="input-group-text">{{ __('Monthly Price') }}</span>
                           </div>
                           <input type="number" class="form-control" name="monthly_price" id="monthly_price">
                         </div> --}}

                        <div class="input-group input-group-lg mb-3">
                           <div class="input-group-prepend">
                           <span class="input-group-text">{{ __('Monthly Price') }}</span>
                           </div>
                           <input type="number" class="form-control" name="monthly_price" id="monthly_price">
                        </div>

                        <div class="input-group input-group-lg mb-3">
                           <div class="input-group-prepend">
                           <span class="input-group-text">{{ __('Category Extra Fee') }}</span>
                           </div>
                           <input type="number" class="form-control" name="extendable_price" id="extendable_price">
                        </div>
{{--

                        <div class="input-group input-group-lg mb-3">
                            <div class="input-group-prepend">
                                 <span class="input-group-text">{{ __('Category') }}</span>
                            </div>
                             <select multiple data-live-search="true" class="form-control selectpicker" id="category-id">
                                 <option disabled selected value="">Chose category</option>
                                 @foreach($categories as $category)
                                 <option value="{{ $category->id }}">{{ $category->name }}</option>
                                 @endforeach
                             </select>
                          </div> --}}


                            {{-- <div class="bs-multiselect">
                                <select name="categories" id="categories" multiple = "multiple">
                                    <option disabled selected value="">Chose category</option>
                                    @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                <style>
                                    .btn-group{
                                        width: 100%;
                                    }
                                    .btn-group > .btn:first-child {
                                        width: 100%;
                                    }
                                </style>
                            </div> --}}
                            <div class="form-group add-form">
                                <select name="sub_categories[]" id="add-categories" multiple = "multiple" class="form-control" style="width: 100%">
                                    @foreach($categories as $category)
                                        <optgroup label="{{ $category->name }}">
                                            @foreach($category->services as $service)
                                                <option value="{{ $service->id }}">{{ $service->name }}</option>
                                            @endforeach
                                        </optgroup>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group edit-form">
                                <select name="sub_categories[]" id="edit-categories" multiple = "multiple" class="form-control" style="width: 100%">

                                </select>
                            </div>
                            <br>
                            <div class="input-group input-group-lg mb-3">
                                <input type="checkbox" id="phone" value="0" class="filled-in chk-col-success">
                                <label for="phone" class="btn-round btn-info waves-effect waves-light">{{ __('Is available phone number !!!!') }}</label>
                            </div>


                        <div class="input-group input-group-lg mb-3">
                            <input type="checkbox" id="description" value="0" class="filled-in chk-col-success">
                            <label for="description" class="btn-round btn-info waves-effect waves-light">{{ __('Is available description and address !!!!!!!!!!!') }}</label>
                        </div>
                    </form>
                </div>
                <div class="modal-footer" id="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" ><i class="fa fa-times"></i> Close</button>
                    <button type="button" class="btn btn-primary" id="add-submit-button"><i class="fa fa-check-square-o"></i> {{ __('Add new package') }}</button>
                    <button type="button" class="btn btn-primary" id="edit-submit-button"><i class="fa fa-check-square-o"></i> {{ __('Edit package') }}</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Edit Modal -->
    <script>
        $(document).ready(function() {

            $('#edit-trial').click(function(){
                // alert("ok");
               $('.trial-data').hide();
               $('#edit-trial').hide();
               $('#trial-from').removeClass("d-none");
           });
            $('#cancel-trial').click(function(){
                // alert("ok");
               $('.trial-data').show();
               $('#edit-trial').show();
               $('#trial-from').addClass("d-none");
           });

           //Submit new category
           $('#update-trial').click(function(){
               var formData = new FormData();
               formData.append('trial_id', $('#id').val())
               formData.append('trial_days', $('#days').val())

               $.ajax({
                   method: 'POST',
                   url: "{{ route('admin.updateMembershipPackageTrial') }}",
                   headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                   data: formData,
                   processData: false,
                   contentType: false,
                   success: function (data) {
                       $('#modal').modal('hide');
                       $('#add-new-from').trigger("reset");
                       Swal.fire({
                           position: 'top-end',
                           icon: 'success',
                           title: 'Successfully Trial Period Updated.',
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

            //Assign checkbox box value
            $('#phone').change(function (){
                if($('#phone').prop('checked')) {
                    $('#phone').val('1')
                } else {
                    $('#phone').val('0')
                }
            })

            $('#description').change(function (){
                if($('#description').prop('checked')) {
                    $('#description').val('1')
                } else {
                    $('#description').val('0')
                }
            })

           //Show modal for add
           $('#add-new').click(function(){
               $(".edit-form").hide();
               $(".add-form").show();
               $('#modal').modal('show');
               $('#edit-submit-button').hide();
               $('#add-submit-button').show();
               $('#modal-title').html('Add a new package');
               $('#add-new-from').trigger("reset");
           });

           //Submit new category
           $('#add-submit-button').click(function(){
               var formData = new FormData();
               formData.append('package_name', $('#name').val())
               formData.append('position_number', $('#position').val())
               formData.append('maximum_service', $('#service').val())
               formData.append('monthly_price', $('#monthly_price').val())
               formData.append('extendable_price', $('#extendable_price').val())
               formData.append('sub_categories[]', $('#add-categories').val())
               formData.append('is_available_phone_number', $('#phone').val())
               formData.append('is_available_description', $('#description').val())

               $.ajax({
                   method: 'POST',
                   url: "{{ route('admin.membership-package.store') }}",
                   headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                   data: formData,
                   processData: false,
                   contentType: false,
                   success: function (data) {
                       $('#modal').modal('hide');
                       $('#add-new-from').trigger("reset");
                       Swal.fire({
                           position: 'top-end',
                           icon: 'success',
                           title: 'Successfully add new package.',
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
                $(".add-form").hide();
                $(".edit-form").show();

                $('#modal').modal('show');
                $('#modal-title').html('Edit membership package');
                $('#add-submit-button').hide();
                $('#edit-submit-button').show();
                $('#name').val($(this).parent().find('.package-name').text());
                $('#position').val($(this).parent().find('.position').text());
                $('#service').val($(this).parent().find('.service_count').text());
                $('#monthly_price').val($(this).parent().find('.monthly_price').text());
                $('#extendable_price').val($(this).parent().find('.extendable_price').text());
                // $('#categories').val($(this).parent().find('.categories').text());
                $('#package-id').val($(this).parent().find('.hidden-id').text());

                if ($(this).parent().find('.mobile_availability').text() == 'Active'){
                    $('#phone').prop("checked", true )
                    $('#phone').val('1')
                }else{
                    $('#phone').prop("checked", false )
                    $('#phone').val('1')
                }
                if ($(this).parent().find('.description_availability').text() == 'Active'){
                    $('#description').prop('checked', true )
                    $('#description').val('1')
                }else{
                    $('#description').prop('checked', false )
                    $('#description').val('0')
                }
                $('#package-id').val($(this).parent().find('.hidden-id').val());

                // load categories with ajax on click
                var package_id = $(this).val();
                // alert(package_id);
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: 'POST',
                    dataType: 'html',
                    url: "{{ route('admin.categoriesMembershipPackage') }}",
                    data: {package_id:package_id},
                    success: function(data){
                        // alert(data);
                        $('#edit-categories').html(data);
                    }
                });

            });

            //Submit edited category
            $('#edit-submit-button').click(function(){
                var formData = new FormData();
                formData.append('package', $('#package-id').val())
                formData.append('package_name', $('#name').val())
                formData.append('position_number', $('#position').val())
                formData.append('maximum_service', $('#service').val())
                formData.append('monthly_price', $('#monthly_price').val())
                formData.append('extendable_price', $('#extendable_price').val())
                formData.append('sub_categories[]', $('#edit-categories').val())
                formData.append('is_available_phone_number', $('#phone').val())
                formData.append('is_available_description', $('#description').val())
                $.ajax({
                    method: 'POST',
                    url: "{{ route('admin.updateMembershipPackage') }}",
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (data) {
                        $('#modal').modal('hide');
                        $('#add-new-from').trigger("reset");
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: 'Successfully updated',
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


            $('.delete-button').click(function(){

                var item_id = $(this).val();
                // alert(item_id);

                Swal.fire({
                title: 'Are you sure?',
                text: "You want to delete the package?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete!'
                }).then((result) => {
                    if (result.isConfirmed) {

                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });

                        $.ajax({
                            type: 'POST',
                            url: "{{ route('admin.destroyMembershipPackage') }}",
                            data: {item_id:item_id},
                            success: function(data){
                                // alert(data);
                                Swal.fire({
                                    position: 'top-end',
                                    icon: 'success',
                                    title: 'Successfully Deleted',
                                    showConfirmButton: false,
                                    timer: 1500
                                })
                                setTimeout(function() {
                                    location.reload();
                                }, 800);
                            },
                            // error: function (xhr) {
                            //     var errorMessage = '<div class="card bg-danger">\n' +
                            //         '                        <div class="card-body text-center p-5">\n' +
                            //         '                            <span class="text-white">';
                            //     $.each(xhr.responseJSON.errors, function(key,value) {
                            //         errorMessage +=(''+value+'<br>');
                            //     });
                            //     errorMessage +='</span>\n' +
                            //         '                        </div>\n' +
                            //         '                    </div>';
                            //     Swal.fire({
                            //         icon: 'error',
                            //         title: 'Oops...',
                            //         footer: errorMessage
                            //     })
                            // },

                        });
                    }
                })
            });

            $("#add-categories").select2({
                placeholder: "Search Category",
                allowClear: true,
            });
            $("#edit-categories").select2({
                placeholder: "Search Category",
                allowClear: true,
            });


        });


    </script>

@endsection
@push('foot')
{{-- <script>
    $(document).ready(function() {
    $('#categories').multiselect({
    includeSelectAllOption: true,
    enableFiltering: true,
    enableCaseInsensitiveFiltering: true,
    filterPlaceholder:'Search Here..'
    });
    });
    </script> --}}
@endpush




