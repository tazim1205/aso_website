@extends('controller.layout.app')
@push('title') {{ __('Ward') }} @endpush
@push('head')

@endpush
@section('content')
<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-body  container-fluid">

                <div class="row">
                    <div class="col-md-12">
                        <div class="float-right mb-1">
                            <button type="button" class="btn btn-outline-primary" data-toggle="modal"
                                data-target="#new_create" id="add-new">
                                <i class="fa fa-plus"></i> Create New Ward/Road Name
                            </button>

                            <div class="modal fade" id="new_create" tabindex="-1" role="dialog"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">
                                                Add a new Ward/Road
                                            </h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>

                                        <div class="modal-body">
                                            <form>
                                                <div class="form-group">
                                                    <label for="name" class="col-form-label">Name</label>
                                                    <input type="text" class="form-control"
                                                        placeholder="Enter Ward/Road Name" id="ward-name">
                                                </div>
                                                <div class="form-group">
                                                    <label for="pouroshobha"
                                                        class="col-form-label">Pouroshoba/Union/Area</label>

                                                    <select name="" id="pouroshobha-id" class="form-control">
                                                        <option value="">-select-</option>
                                                        @foreach($pouroshobhas as $pouroshobha)
                                                        <option value="{{ $pouroshobha->id }}">{{ $pouroshobha->name }}</option>
                                                        @endforeach
                                                        
                                                    </select>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-dismiss="modal">Close</button>
                                                    <button type="button" class="btn btn-primary" id="add-submit-button">Add New
                                                        Ward/Road</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Zero configuration table -->
                <section id="configuration">
                    <!-- select option row start -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card card-background-blue">
                                <div class="card-content">
                                    <div class="card-body select-card-design">
                                        <h4 class="select-title white">Area</h4>

                                        <select name="month" class="form-control width-30-percent">
                                            <option value=''>--Select Month--</option>
                                            <option selected value='1'>Janaury</option>
                                            <option value='2'>February</option>
                                            <option value='3'>March</option>
                                            <option value='4'>April</option>
                                            <option value='5'>May</option>
                                            <option value='6'>June</option>
                                            <option value='7'>July</option>
                                            <option value='8'>August</option>
                                            <option value='9'>September</option>
                                            <option value='10'>October</option>
                                            <option value='11'>November</option>
                                            <option value='12'>December</option>
                                        </select>
                                        <select name="year" class="form-control width-30-percent">
                                            <option value=''>--Select Year--</option>
                                            <option value="2030">2030</option>
                                            <option value="2029">2029</option>
                                            <option value="2028">2028</option>
                                            <option value="2027">2027</option>
                                            <option value="2026">2026</option>
                                            <option value="2025">2025</option>
                                            <option value="2024">2024</option>
                                            <option selected value="2023">2023</option>
                                            <option value="2022">2022</option>
                                            <option value="2021">2021</option>
                                            <option value="2020">2020</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- select option row end -->

                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-head">
                                    <div class="card-header">
                                        <h4 class="card-title">Ward/Road Table</h4>
                                        <div class="heading-elements visible">
                                            <ul class="list-inline mb-0">
                                                <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                                <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                                                <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <!-- Task List table -->
                                        <div class="table-responsive">
                                            <table id="users-contacts"
                                                class="table table-white-space table-bordered table-striped row-grouping display no-wrap icheck table-middle">
                                                <thead>
                                                    <tr>
                                                        <th>No.</th>
                                                        <th>Pouroshoba/Union/Area</th>
                                                        <th>Ward/Road Name</th>
                                                        <th>Customer</th>
                                                        <th>Worker</th>
                                                        <th>Membership</th>
                                                        <th>Marketer</th>
                                                        <th>Status</th>
                                                        <th>Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($wards as $ward)
                                                    <tr>
                                                        <td> {{ $loop->iteration }}</td>
                                                        <td>
                                                            {{ $ward->pouroshobha->name }}
                                                        </td>
                                                        <td>
                                                            {{ $ward->name }}
                                                        </td>
                                                        <td>
                                                            {{ $ward->customer->count() }}
                                                        </td>
                                                        <td>
                                                            {{ $ward->worker->count() }}
                                                        </td>
                                                        <td>
                                                            {{ $ward->membership->count() }}
                                                        </td>
                                                        <td>
                                                            {{ $ward->marketer->count() }}
                                                        </td>
                                                        <td>
                                                            {{ $ward->status == 1 ? 'Enable' : 'Disable' }}
                                                        </td>
                                                        <td>
                                                            <input type="hidden" class="hidden-id" value="{{ $ward->id }}">
                                                            <span class="dropdown">
                                                                <button id="btnSearchDrop12" type="button"
                                                                    class="btn btn-sm btn-icon btn-pure font-medium-2"
                                                                    data-toggle="dropdown" aria-haspopup="true"
                                                                    aria-expanded="false">
                                                                    <i class="ft-more-vertical"></i>
                                                                </button>

                                                                <span aria-labelledby="btnSearchDrop12"
                                                                    class="dropdown-menu dropdown-menu-button">
                                                                    @if ($ward->status == 0)
                                                                    <button href="#" class="dropdown-item enable-click">
                                                                        <i class="ft-check-circle"></i>
                                                                        Enable
                                                                    </button>
                                                                    @endif
                                                                    @if ($ward->status == 1)
                                                                    <button href="" class="dropdown-item disable-click">
                                                                        <i class="ft-disc"></i>
                                                                        Disable
                                                                    </button>
                                                                    @endif
                                                                    <button type="button" class="dropdown-item deleted-click">
                                                                        <i class="ft-trash-2"></i>
                                                                        Delete
                                                                    </button>
                                                                    <a href="#" data-toggle="modal" data-target="#edit"
                                                                        class="dropdown-item edit-button" data-ward-name="{{ $ward->name }}" data-pouroshova-name="{{ $ward->pouroshobha->name }}">
                                                                        <i class="ft-edit-2"></i> Edit</a>
                                                                </span>
                                                            </span>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>

                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!--/ Zero configuration table -->

                <!-- Edit distric Model start -->
                <div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">
                                    Edit Ward/Road
                                </h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>

                            <div class="modal-body">
                                <form action="#" method="POST">
                                    <div class="form-group">
                                        <label for="name" class="col-form-label">Name</label>
                                        <input type="text" class="form-control" id="name">
                                    </div>
                                    <input type="hidden" id="ward-id">
                                    <div class="form-group">
                                        <label for="pouroshobha" class="col-form-label">Pouroshoba/Union/Area</label>

                                        <select name="" id="pouroshobha" class="form-control">
                                            <option value="">-select-</option>
                                            @foreach($pouroshobhas as $pouroshobha)
                                            <option value="{{ $pouroshobha->id }}">{{ $pouroshobha->name }}</option>
                                            @endforeach
                                            
                                        </select>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-dismiss="modal">Close</button>
                                        <button type="button" class="btn btn-primary" id="edit-submit-button">Save</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Edit distric Model end -->
            </div>
            <!-- container-fluid end -->
        </div>
    </div>
</div>
<!-- END: Main Content end-->
<!-- Edit Modal -->


@endsection
@push('foot')
<script>
    $(document).ready(function() {
           //Show modal for add
           $('#add-new').click(function(){
               $('#new_create').modal('show');               
               $('#ward-name').val('');
               $('#pouroshobha-id').prop('selectedIndex',0); //Reset dropdown after click on edit
           });

           //Submit new
           $('#add-submit-button').click(function(){
               $(this).html("Loading...");
               var wardName = $('#ward-name').val();
               var pouroshobhaId = $('#pouroshobha-id').val();
               $.ajax({
                   method: 'POST',
                   url: '/controller/ward',
                   headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                   data: { name: wardName, pouroshobhaId: pouroshobhaId},
                   dataType: 'JSON',
                   success: function (data) {
                        $("#add-submit-button").html("Add New");
                       $('#new_create').modal('hide');
                       $('#ward-name').val('');
                       $('#pouroshobha-id').val('');
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
                $('#edit').modal('show');                
                $('#name').val($(this).data('ward-name'));
                //Find by value
                //$('#pouroshobha-id').find('option[value="2"]').attr("selected",true);
                //Find by option
                var option = $(this).data('pouroshova-name');
                $('#pouroshobha').find('option:contains('+option+')').attr("selected",true);

                $('#ward-id').val($('.hidden-id').val());
            });

            //Submit edited
            $('#edit-submit-button').click(function(){
                $(this).html("Loading...");
                var pouroshobhaName = $('#name').val();
                var pouroshobhaId = $('#pouroshobha').val();
                var wardId = $('#ward-id').val();
                $.ajax({
                    method: 'PATCH',
                    url: '/controller/ward/'+wardId,
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    data: { name: pouroshobhaName, pouroshobhaId: pouroshobhaId},
                    dataType: 'JSON',
                    success: function (data) {
                        $("#edit-submit-button").html("Save");
                        $('#edit').modal('hide');
                        $('#ward-name').val('');
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

            // Delete
            $('.deleted-click').click(function () {
                var wardId = $('.hidden-id').val();
                console.log(wardId);
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {                
                        $.ajax({
                            type: "DELETE",
                            url: '/controller/ward/'+wardId,
                            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                            dataType: "JSON",
                            success: function (response) {
                                console.log(response);
                                Swal.fire(
                                    'Deleted!',
                                    'Your file has been deleted.',
                                    'success'
                                ),
                                setTimeout(function() {
                                    location.reload();
                                }, 800);//
                            },
                            error: function (xhr) {
                                console.log(xhr);                            
                            },
                        });
                    }
                })
            });
            // Enable Click
            $('.enable-click').click(function () {
                var wardId = $('.hidden-id').val();
                console.log(wardId);
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You want to enable this?!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, enable it!'
                }).then((result) => {
                    if (result.isConfirmed) {                
                        $.ajax({
                            type: "POST",
                            url: "{{ route('controller.ward.enable') }}",
                            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                            data: {
                                'id': wardId
                            },
                            dataType: "JSON",
                            success: function (response) {
                                console.log(response);
                                Swal.fire(
                                    'Enable!',
                                    'Your item has been enable.',
                                    'success'
                                ),
                                setTimeout(function() {
                                    location.reload();
                                }, 800);//
                            },
                            error: function (xhr) {
                                console.log(xhr);                            
                            },
                        });
                    }
                })
            });

            // Disable Click
            $('.disable-click').click(function () {
                var wardId = $('.hidden-id').val();
                console.log(wardId);
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You want to disable this?!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, disable it!'
                }).then((result) => {
                    if (result.isConfirmed) {                
                        $.ajax({
                            type: "POST",
                            url: "{{ route('controller.ward.disable') }}",
                            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                            data: {
                                'id': wardId
                            },
                            dataType: "JSON",
                            success: function (response) {
                                console.log(response);
                                Swal.fire(
                                    'Disable!',
                                    'Your item has been disabled.',
                                    'success'
                                ),
                                setTimeout(function() {
                                    location.reload();
                                }, 800);//
                            },
                            error: function (xhr) {
                                console.log(xhr);                            
                            },
                        });
                    }
                })
            });
        });
</script>
@endpush