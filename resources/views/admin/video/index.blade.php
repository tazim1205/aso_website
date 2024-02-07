@extends('admin.layout.app')
@push('title')
    {{ __('Video Training') }}
@endpush
@section('content')
    <div class="content-wrapper">
        <div class="container-fluid">
            <!-- Breadcrumb-->
            <div class="row pt-2 pb-2">
                <div class="col-sm-9">
                    <h4 class="page-title"> {{ __('Video Training') }}</h4>
                </div>
                <div class="col-sm-3">
                    <div class="btn-group float-sm-right">
                        <button type="button" id="add-new" class="btn btn-outline-primary waves-effect waves-light"><i class="fa fa-plus"></i> {{ __('Add new Video') }}</button>
                    </div>
                </div>
            </div>
            <!-- End Breadcrumb-->
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">{{ __('Video Training') }}</h5>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead class="thead-success shadow-success">
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">{{ __('Link') }}</th>
                                        <th scope="col">{{ __('Status') }}</th>
                                        <th scope="col">{{ __('Action') }}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($videos as $video)
                                        <tr>
                                            <td scope="row">{{ $loop->iteration }}</td>
                                            <td>
                                                <h5>{{ $video->link }}</h5>
                                            </td>
                                            <td>
                                                {{ $video->status == 0 ? 'Pending' : 'Active' }}
                                            </td>
                                            <td>
                                                <button
                                                    data-link="{{ $video->link }}"
                                                    data-description ="{{ $video->description }}"
                                                    class="view-button btn btn-outline-warning waves-effect waves-light btn-sm"
                                                >
                                                    <i class="fa fa-eye"></i>
                                                </button>

                                                <button
                                                    data-id="{{ $video->id }}"
                                                    data-link="{{ $video->link }}"
                                                    data-description ="{{ $video->description }}"
                                                    data-status="{{ $video->status }}"
                                                    class="edit-button btn btn-outline-warning waves-effect waves-light btn-sm"
                                                > <i class="fa fa-edit"></i> </button>

                                                <a href="javascript:void(0);" class="btn btn-danger waves-effect waves-light  delete-submit-button btn-sm" ><i class="fa fa-trash"></i></a>


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
                        <div class="form-group">
                            <label class="">{{ __('Status') }}</label>
                            <select class="form-control" name="status" id="status" required="">
                                <option value="">Select</option>
                                <option value="0">Pending</option>
                                <option value="1">Active</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="">{{ __('Video Link') }}</label>
                            <input type="text" class="form-control" name="link" id="link" required="">
                        </div>
                        <div class="form-group">
                            <label class="">{{ __('Description') }}</label>
                            <input type="hidden" id="video_id">
                            <textarea class="form-control"  name="description" id="description" required=""></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer" id="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" ><i class="fa fa-times"></i> {{ __('Close') }}</button>
                    <button type="button" class="btn btn-primary" id="add-submit-button"><i class="fa fa-check-square-o"></i> {{ __('Add new Video') }}</button>
                    <button type="button" class="btn btn-primary" id="edit-submit-button"><i class="fa fa-check-square-o"></i> {{ __('Edit Video') }}</button>
                </div>
            </div>
        </div>
    </div>
    {{--    View Modal--}}
    <div class="modal fade" id="view">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="view-modal-title"><i class="fa fa-star"></i> <!--Title insert by ajax--> </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="modal-body">
                    <h5 id="view_link"></h5>
                    <hr>
                    <p id="view_description"></p>
                </div>
                <div class="modal-footer" id="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" ><i class="fa fa-times"></i> {{ __('Close') }}</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            //Show modal for add
            $('#add-new').click(function(){
                $('#modal').modal('show');
                $('#edit-submit-button').hide();
                $('#add-submit-button').show();
                $('#modal-title').html('Add a new Video');
                $('#status').val('');
                $('#link').val('');
                $('#description').val('');
            });

            //Submit new
            $('#add-submit-button').click(function(){
                var status = $('#status').val();
                var link = $('#link').val();
                var description = $('#description').val();
                $.ajax({
                    method: 'POST',
                    url: '/admin/video/store',
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    data: { link: link, description: description, status: status },
                    dataType: 'JSON',
                    success: function (data) {
                        $('#modal').modal('hide');
                        $('#status').val('');
                        $('#link').val('');
                        $('#description').val('');
                        Swal.fire({
                            icon: 'success',
                            title: 'Successfully add '+data.question,
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
                $('#modal-title').html('Edit Video');
                $('#add-submit-button').hide();
                $('#edit-submit-button').show();
                $( "#status").val($(this).data("status")).change();
                $('#link').val($(this).data("link"));
                var description = $(this).data("description");
                $('#description').val(description);
                $('.note-editable').html('');
                $('.note-editable').append(description);
                $('#video_id').val($(this).data("id"));
            });

            //Submit edited
            $('#edit-submit-button').click(function(){
                var id = $('#video_id').val();
                var link = $('#link').val();
                var description = $('#description').val();
                var status = $('#status').val();
                $.ajax({
                    method: 'POST',
                    url: '/admin/video/update',
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    data: { id: id,link: link, description: description, status: status},
                    dataType: 'JSON',
                    success: function (data) {
                        $('#modal').modal('hide');
                        $('#link').val('');
                        $('#description').val('');
                        $('#status').val('');
                        Swal.fire({
                            icon: 'success',
                            title: 'Successfully edited ',
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

            $('.delete-submit-button').click(function(){
                var formData = new FormData();
                formData.append('id', $(this).parent().find('.hidden-id').val());
                $.ajax({
                    method: 'POST',
                    url: "{{ route('admin.faq.destroy') }}",
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (data) {
                        $('#modal').modal('hide');
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

            //     View Modal
            $(".view-button").click(function(){
                $('#view').modal('show');
                $('#view-modal-title').html('View Video');
                var link = $(this).data("link");
                var description = $(this).data("description");

                $("#view_link").html(link);
                $("#view_description").html(description);
            })
        });
    </script>
    <script>
        $('#faq-answer').summernote({
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
