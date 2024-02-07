@extends('controller.layout.app')
@push('title') {{ __('Helpline') }} @endpush
@push('head')
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
    integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous">
</script>
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
@endpush
@section('content')
<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-body  container-fluid">
                <!-- Minimal statistics section start -->
                <section id="minimal-statistics">

                    <!-- select option row -->
                    <div class="row">

                        <div class="col-md-12">
                            <h3>{{ Str::ucfirst($status) }} Helpline</h3>
                            <div class="float-right mb-1">
                                <button type="button" class="btn btn-outline-primary" id="addBtn" data-toggle="modal"
                                        data-target="#new_create">
                                    <i class="fa fa-plus"></i>
                                    Add new Helpline
                                </button>
                                <!-- Add Model Start -->
                                <div class="modal fade" id="new_create" tabindex="-1" role="dialog"
                                     aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">
                                                    Add new Helpline
                                                </h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>

                                            <div class="modal-body">
                                                <form id="add-new-from">
                                                    <div class="form-group">
                                                        <label for="addemail" class="col-form-label">{{ __('Email') }}</label>
                                                        <input type="text" class="form-control" name="email" id="addemail"
                                                               placeholder="Enter Title">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="addphone" class="col-form-label">{{ __('Phone') }}</label>
                                                        <input type="text" class="form-control" name="phone" id="addphone"
                                                               placeholder="Enter Title">
                                                    </div>
                                                    <input type="hidden" name="worker_or_customer" id="worker_or_customer" value="customer">
                                                    <div class="modal-footer">
                                                        <button type="reset" class="btn btn-danger mr-1">
                                                            <i class="ft-x"></i> Clear
                                                        </button>

                                                        <button type="submit" id="add-submit-button"
                                                                class="btn btn-primary">ADD NEW</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Add Model End -->
                            </div>
                        </div>
                    </div>
                    <div class="row mt-1">
                        @foreach($notices as $notice)
                        <div class="col-md-4">
                            <div class="card border  border-success ">
                                <div class="card-body">
                                    <form class="form">
                                        <input value="{{ $notice->id }}" type="hidden" class="hidden-id">
                                        <div class="form-group">
                                            <label for="email">Email:</label>
                                            <input type="email" class="form-control email" value="{{ $notice->email }}" id="email">
                                        </div>
                                        <div class="form-group">
                                            <label for="phone">Phone:</label>
                                            <input type="phone" class="form-control phone" value="{{ $notice->phone }}" id="phone">
                                        </div>


                                        {{-- <input type="hidden" class="hidden-id" value="000"> --}}

                                        <a href="javascript:void(0);" class="btn btn-primary update-submit-button">Update</a>

                                        <a href="javascript:void(0);" class="btn btn-danger delete-submit-button">Delete</a>
                                    </form>

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
<!-- Edit Modal -->
<script>
    $(document).ready(function() {
        //Show modal for add
        $('#addBtn').click(function(){
            $('#modal').modal('show');
            $('#edit-submit-button').hide();
            $('#add-submit-button').show();
            $('#modal-title').html('Add a new helpline');
            $('#addemail').val('');
            $('#addphone').val('');
        });

        //Submit new category
        $('#add-submit-button').click(function(e){
            e.preventDefault();
            var form = $('#add-new-from');
            var formData = $(form).serialize();

            $.ajax({
                method: 'POST',
                url: '{{ route('controller.helpline.store') }}',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                data: formData,
                dataType: 'JSON',
                success: function (data) {
                    $('#modal').modal('hide');
                    $('#addemail').val('');
                    $('#addphone').val('');
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        email: 'Successfully add '+data.email+','+data.phone,
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

            //Submit edited category
            $('.update-submit-button').click(function(){
                var formData = new FormData();
                formData.append('id', $(".hidden-id").val());
                formData.append('phone', $(".phone").val());
                formData.append('email', $(".email").val());
                formData.append('worker_or_customer', "customer");
                $.ajax({
                    method: 'POST',
                    url: "{{ route('controller.helpline.update') }}",
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    data: formData,
                    processData: false,
                    contentType: false,
                    dataType: 'JSON',
                    success: function (data) {
                        $('#modal').modal('hide');
                        $('#email').val('');
                        $('#phone').val('');
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: 'Successfully edited '+data.email+','+data.phone,
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

            //Submit edited category
            $('.delete-submit-button').click(function(){
                var formData = new FormData();
                formData.append('id', $('.hidden-id').val());
                $.ajax({
                    method: 'POST',
                    url: "{{ route('controller.helpline.delete') }}",
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    data: formData,
                    processData: false,
                    contentType: false,
                    dataType: 'JSON',
                    success: function (data) {
                        $('#modal').modal('hide');
                        $('#email').val('');
                        $('#phone').val('');
                        Swal.fire({
                            position: 'top-end',
                            icon: 'danger',
                            title: 'Successfully deleted '+data.email,
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
<script>
    $('.detail').summernote({

            tabsize: 2,
            height: 120,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'clear']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['view', ['fullscreen', 'codeview']]
            ]
        });
</script>

@endsection
@push('foot')

@endpush
