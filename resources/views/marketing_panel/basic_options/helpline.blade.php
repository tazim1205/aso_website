@extends('marketing_panel.layout.app')
@push('head')
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
@endpush
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="float-right mb-1">
                <button type="button" class="btn btn-outline-primary" data-toggle="modal"
                        data-target="#new_create">
                    <i class="fa fa-plus"></i>
                    Add New Helpline
                </button>
            </div>
        </div>
    </div>

    <div class="row">
        @foreach($notices as $notice)
        <div class="col-md-6">
            <div class="card border @if($loop->iteration == 1) border-success @else border-danger @endif">
                <div class="card-body">
                    <form action="#" id="add-new-from">
                        <div class="input-group input-group-lg mb-2">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Email</span>
                            </div>
                            <input value="{{ $notice->id }}" type="hidden" class="hidden-id">
                            <input type="text" class="form-control notice-email" name="title"
                                   value="{{ $notice->email }}">
                        </div>
                        <div class="input-group input-group-lg mb-2">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Phone</span>
                            </div>
                            <input type="text" class="form-control notice-phone" name="title" value="{{ $notice->phone }}">
                        </div>
                        <a href="javascript:void(0);"
                           class="btn btn-success waves-effect waves-light m-1 update-submit-button"><i
                                class="fa fa-edit"></i> Update</a>
                        <a href="javascript:void(0);" class="btn btn-danger delete-submit-button"><i
                                class="fa fa-trus"></i>Delete</a>
                    </form>
                </div>
            </div>
        </div>
        @endforeach


    </div>
    <!-- Add Model Start -->
    <div class="modal fade" id="new_create" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-title">
                        Add a new Helpline
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>

                <div class="modal-body">
                    <form action="#" id="add-new-from">
                        <div class="input-group input-group-lg mb-2">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Email</span>
                            </div>
                            <input type="hidden" id="notice-id">
                            <input type="text" class="form-control" name="email" id="addemail">
                        </div>
                        <div class="input-group input-group-lg mb-1">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Phone</span>
                            </div>
                            <input type="text" class="form-control" name="phone" id="addphone">
                        </div>

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary" id="add-submit-button">ADD NEW</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Add Model End -->


@endsection
@push('foot')
    <script>
        $(document).ready(function() {
            //Show modal for add
            $('#add-new').click(function(){
                $('#new_create').modal('show');
                $('#modal-title').html('Add a new helpline');
                $('#addemail').val('');
                $('#addphone').val('');
            });

            //Submit new category
            $('#add-submit-button').click(function(){
                var formData = new FormData();
                formData.append('email', $('#addemail').val())
                formData.append('phone', $('#addphone').val())
                $.ajax({
                    method: 'POST',
                    url: '{{ route('marketing_panel.helpline.store') }}',
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    data: formData,
                    processData: false,
                    contentType: false,
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
                formData.append('id', $('.hidden-id').val());
                formData.append('phone', $('.notice-phone').val());
                formData.append('email', $('.notice-email').val());
                $.ajax({
                    method: 'POST',
                    url: "{{ route('marketing_panel.helpline.update') }}",
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    data: formData,
                    processData: false,
                    contentType: false,
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
                    url: "{{ route('marketing_panel.helpline.delete') }}",
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    data: formData,
                    processData: false,
                    contentType: false,
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
@endpush
