@extends('controller.layout.app')
@push('title') {{ __('Puroshobha') }} @endpush
@push('head')

@endpush
@section('content')
<div class="app-content content">
    <div class="content-wrapper padding-top-10">
        <div class="content-header row">
            <div class="content-body  container-fluid">

                <div class="row">
                    <div class="col-md-12">
                        <div class="float-right mb-1">
                            <button type="button" class="btn btn-outline-primary" data-toggle="modal"
                                data-target="#new_create" id="add-new">
                                <i class="fa fa-plus"></i> Create New Puroshobha/Union/Area
                            </button>

                            <div class="modal fade" id="new_create" tabindex="-1" role="dialog"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">
                                                Add a new Pouroshobha/Union/Area
                                            </h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>

                                        <div class="modal-body">
                                            <form id="add-new-from">
                                                <div class="form-group">
                                                    <label for="pouroshobha_name" class="col-form-label">Name</label>
                                                    <input type="text" class="form-control"
                                                        placeholder="Enter Pouroshobha/Union/Area Name"
                                                        id="pouroshobha_name" name="pouroshobha-name">
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-dismiss="modal">Close</button>
                                                    <button type="button" class="btn btn-primary" id="add-submit-button">ADD NEW</button>
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
                                        <h4 class="card-title">District Table</h4>
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
                                                        <th>Ward/Road Quantity</th>
                                                        <th>Customer</th>
                                                        <th>Worker</th>
                                                        <th>Membership</th>
                                                        <th>Marketer</th>
                                                        <th>Status</th>
                                                        <th>Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($pouroshovas as $pouroshova)
                                                    <tr>
                                                        <td> {{ $loop->iteration }}</td>
                                                        <td>
                                                            {{ $pouroshova->name }}
                                                        </td>
                                                        <td>
                                                            {{$pouroshova->word->count()}}
                                                        </td>
                                                        <td>
                                                            {{ $pouroshova->customer->count() }}
                                                        </td>
                                                        <td>
                                                            {{ $pouroshova->worker->count() }}
                                                        </td>
                                                        <td>
                                                            {{ $pouroshova->membership->count() }}
                                                        </td>
                                                        <td>
                                                            {{ $pouroshova->marketer->count() }}
                                                        </td>
                                                        <td>
                                                            {{ $pouroshova->status == 1 ? 'Enable' : 'Disable' }}
                                                        </td>
                                                        <td>
                                                            <input type="hidden" class="hidden-id" value="{{ $pouroshova->id }}">
                                                            <span class="dropdown">
                                                                <button id="btnSearchDrop12" type="button"
                                                                    class="btn btn-sm btn-icon btn-pure font-medium-2"
                                                                    data-toggle="dropdown" aria-haspopup="true"
                                                                    aria-expanded="false">
                                                                    <i class="ft-more-vertical"></i>
                                                                </button>

                                                                <span aria-labelledby="btnSearchDrop12"
                                                                    class="dropdown-menu dropdown-menu-button">
                                                                    @if ($pouroshova->status == 0)
                                                                    <button href="#" class="dropdown-item enable-click">
                                                                        <i class="ft-check-circle"></i>
                                                                        Enable
                                                                    </button>
                                                                    @endif
                                                                    @if ($pouroshova->status == 1)
                                                                    <button href="" class="dropdown-item disable-click">
                                                                        <i class="ft-disc"></i>
                                                                        Disable
                                                                    </button>
                                                                    @endif
                                                                    <button type="button" class="dropdown-item deleted-click">
                                                                        <i class="ft-trash-2"></i>
                                                                        Delete
                                                                    </button>
                                                                    <a href="#" data-toggle="modal" data-target="#edit" class="dropdown-item edit-button" data-pouroshova-name="{{ $pouroshova->name }}">
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
                                    Pouroshobha/Union/Area
                                </h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>

                            <div class="modal-body">
                                <form id="edit-from">
                                    <div class="form-group">
                                        <label for="district_name" class="col-form-label">Name</label>
                                        <input type="text" class="form-control" name="pouroshobha-name"
                                            id="pouroshobha-name-edit">
                                        <input type="hidden" id="pouroshobha-id">
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-dismiss="modal">Close</button>
                                        <button type="button" id="edit-submit-button" class="btn btn-primary">Save</button>
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
           $('#pouroshobha_name').val('');
       });

       //Submit new
       $('#add-submit-button').click(function(){
            $(this).html("Loading...");
           var pouroshobhaName = $('#pouroshobha_name').val();
           $.ajax({
               method: 'POST',
               url: '/controller/pouroshobha',
               headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
               data: { name: pouroshobhaName},
               dataType: 'JSON',
               success: function (data) {
                   $('#new_create').modal('hide');
                   $('#pouroshobha_name').val('');
                   $("#add-submit-button").html("Add New");
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
            $('#pouroshobha-name-edit').val($(this).data('pouroshova-name'));
            $('#pouroshobha-id').val($('.hidden-id').val());
        });

        //Submit edited
        $('#edit-submit-button').click(function(){
            $(this).html("Loading...");
            var pouroshobhaName = $('#pouroshobha-name-edit').val();
            var pouroshobhaId = $('#pouroshobha-id').val();
            $.ajax({
                method: 'PATCH',
                url: '/controller/pouroshobha/'+pouroshobhaId,
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                data: { name: pouroshobhaName},
                dataType: 'JSON',
                success: function (data) {
                    $('#edit').modal('hide');
                    $('#pouroshobha-name-edit').val('');
                    $("#edit-submit-button").html("Save");
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
            var pouroshobhaId = $('.hidden-id').val();
            console.log(pouroshobhaId);
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
                        url: '/controller/pouroshobha/'+pouroshobhaId,
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
            var pouroshobhaId = $('.hidden-id').val();
            console.log(pouroshobhaId);
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
                        url: "{{ route('controller.pouroshobha.enable') }}",
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        data: {
                            'id': pouroshobhaId
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
            var pouroshobhaId = $('.hidden-id').val();
            console.log(pouroshobhaId);
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
                        url: "{{ route('controller.pouroshobha.disable') }}",
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        data: {
                            'id': pouroshobhaId
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