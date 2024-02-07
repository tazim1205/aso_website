@extends('controller.layout.app')
@push('title') {{ __('Special service') }} @endpush
@push('head')

@endpush
@section('content')
<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-body  container-fluid">
                <!-- Minimal statistics section start -->
                <section id="minimal-statistics">

                    <!-- select option row -->
                    <h3>Special Service
                        <a href="#" class="btn btn-primary float-right" data-toggle="modal"
                           data-target="#editModal" id="add-new">Add New Service</a>
                    </h3>
                    <div class="row mt-1">
                        @foreach(auth()->user()->upazila->special_profiles as $profile)
                        <div class="col-md-4">
                            <div class="card border  border-success ">
                                <div class="card">
                                    <img src="{{ asset($profile->image ?? 'uploads/images/defaults/user.png') }}"
                                        class="card-img-top" alt="Image" height="160">
                                    <div class="card-body">
                                        <h5 class="card-text"><b>Service :</b> {{ $profile->name }} </h5>

                                        <p class="card-text"><i class="ft-phone btn"></i> {{ $profile->phone }}</p>

                                        <div class="text-center">
                                            <button type="button" title="Details" class="btn btn-primary detailsBtn" data-toggle="modal"
                                                data-target="#detailsModal" data-details="{{ $profile->description }}">
                                                <i class="ft-book"></i>
                                            </button>


                                            <a href="#" class="btn btn-secondary edit-button" data-toggle="modal"
                                                data-target="#editModal" data-profile="{{ $profile->id }}" data-name="{{ $profile->name }}" data-phone="{{ $profile->phone }}" data-details="{{ $profile->description }}" data-image="{{$profile->image}}">
                                                <i class="ft-edit-2"></i>
                                            </a>

                                            <a href="#" class="btn btn-danger delete-special-user-btn" data-profile="{{ $profile->id }}">
                                                <i class="ft-trash-2"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach

                    </div>
                    <!-- select option row end -->

                </section>
                <!-- // Minimal statistics section end -->
            </div>
        </div>
    </div>
</div>
<!-- END: Main Content end-->


<!-- Details Modal -->
<div class="modal fade" id="detailsModal" tabindex="-1" role="dialog" aria-labelledby="detailsModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailsModalLabel">Service Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body details_body">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-title">Edit Service</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="#" id="add-new-from">
                    <input type="hidden" id="special-profile-id">
                    <div class="input-group input-group-lg mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">{{ __('Name') }}</span>
                        </div>
                        <input type="text" class="form-control" name="name" id="name">
                    </div>
                    <div class="input-group input-group-lg mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">{{ __('Phone') }}</span>
                        </div>
                        <input type="text" class="form-control" name="phone" id="phone">
                    </div>
                    <div class="input-group input-group-lg mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">{{ __('Image') }}</span>
                        </div>
                        <input type="file" accept="image/*" class="form-control" name="image" id="image">
                    </div>
                    <div class="input-group input-group-lg mb-3">
                        <textarea rows="4" class="form-control" id="description" placeholder="Service details ..."></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="add-submit-button">Save Changes</button>
                <button type="button" class="btn btn-primary" id="edit-submit-button">Save Changes</button>
            </div>
        </div>

    </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Delete Service</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this service?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger">Delete</button>
            </div>
        </div>
    </div>
</div>
<!-- Edit Modal -->


@endsection
@push('foot')
<script>
    $(document).ready(function() {
            // Details Button
            $(".detailsBtn").click(function (e) {
                e.preventDefault();
                // alert("Hello");
                var details = $(this).attr("data-details");
                // alert(details);
                $(".details_body").html(details);
            });


            //Show modal for add
            $('#add-new').click(function(){
                $('#modal').modal('show');
                $("#add-submit-button").show();
                $("#edit-submit-button").hide();
                $('#add-submit-button').html("Add New");
                $('#modal-title').html('Add a new special service');
                $('#add-new-from').trigger("reset");
            });

            //Submit new special profile
            $('#add-submit-button').click(function(){
                $(this).html("Loading...");
                var formData = new FormData();
                formData.append('name', $('#name').val())
                formData.append('phone', $('#phone').val())
                formData.append('description', $('#description').val())
                formData.append('image', $('#image')[0].files[0])
                $.ajax({
                    method: 'POST',
                    url: '{{ route('controller.special-profile.store') }}',
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
                            title: 'Successfully add ',
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
            $('.delete-special-user-btn').click(function(){
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
                        var formData = new FormData();
                        var profile = $(this).attr("data-profile");
                        formData.append('profile',  profile);
                        $.ajax({
                            method: 'POST',
                            url: '{{ route('controller.special-profile.delete') }}',
                            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                            data: formData,
                            processData: false,
                            contentType: false,
                            success: function (data) {
                                if (data.type == 'success'){
                                    Swal.fire(
                                        'Deleted!',
                                        'Your file has been deleted.',
                                        'success'
                                    )
                                    setTimeout(function() {
                                        location.reload();
                                    }, 800);//
                                }else{
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Oops...',
                                        footer: data.message
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
                    }
                })
            });

            //Show modal for edit and set data
            $(".edit-button").click(function(){
                var name = $(this).attr("data-name");
                var phone = $(this).attr("data-phone");
                var description = $(this).attr("data-details");
                var image = $(this).attr("data-image");
                var id = $(this).attr("data-profile");
                $('#modal').modal('show');
                $('#modal-title').html('Edit Service');
                $("#add-submit-button").hide();
                $("#edit-submit-button").show();
                $('#edit-submit-button').html("Update Service");
                $('#name').val(name);
                $('#phone').val(phone);
                $('#description').val(description);
                $('#special-profile-id').val(id);
            });

            //Submit edited category
            $('#edit-submit-button').click(function(){
                $(this).html("Loading..");
                var formData = new FormData();
                formData.append('id', $('#special-profile-id').val())
                formData.append('name', $('#name').val())
                formData.append('phone', $('#phone').val())
                formData.append('description', $('#description').val())
                formData.append('image', $('#image')[0].files[0])
                $.ajax({
                    method: 'POST',
                    url: "{{ route('controller.special-profile.update') }}",
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (data) {
                        $('#modal').modal('hide');
                        $('#name').val('');
                        $('#phone').val('');
                        $('#description').val('');
                        $('#special-profile-id').val('');
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: 'Successfully edited '+data.title,
                            showConfirmButton: false,
                            timer: 1500
                        })
                        setTimeout(function() {
                            location.reload();
                        }, 800);//

                    },
                    error: function (xhr) {
                        // alert(xhr);
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
@endpush
