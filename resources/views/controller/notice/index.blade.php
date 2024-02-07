@extends('controller.layout.app')
@push('title') {{ __('Notice') }} @endpush

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

                <div class="row">
                    <div class="col-md-12">
                        <div class="float-right mb-1">
                            <button type="button" class="btn btn-outline-primary" data-toggle="modal"
                                data-target="#new_create">
                                <i class="fa fa-plus"></i>
                                Add new notices
                            </button>
                            <!-- Add Model Start -->
                            <div class="modal fade" id="new_create" tabindex="-1" role="dialog"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">
                                                Add new notices
                                            </h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>

                                        <div class="modal-body">
                                            <form id="add-new-from">
                                                <div class="form-group">
                                                    <label for="title" class="col-form-label">Title</label>
                                                    <input type="text" class="form-control" name="title"
                                                        placeholder="Enter Title" id="title">
                                                </div>
                                                <div class="form-group">
                                                    <label for="description">Description</label>
                                                    <textarea rows="5" class="form-control" name="comment" id="detail"
                                                        placeholder="Enter Description"></textarea>
                                                </div>
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


                <section id="configuration">
                    <h1>Active Notice</h1>
                    <hr>
                    <div class="row">
                        <!-- Card -->
                        @foreach(auth()->user()->controllerActiveNoticeForController as $notice)
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <a class="heading-elements-toggle">
                                        <i class="la la-ellipsis-v font-medium-3"></i>
                                    </a>
                                    <div class="heading-elements">
                                        <ul class="list-inline mb-0">
                                            <li>
                                                <a data-action="collapse">
                                                    <i class="ft-minus"></i>
                                                </a>
                                            </li>
                                            <li>
                                                <a data-action="reload">
                                                    <i class="ft-rotate-cw"></i>
                                                </a>
                                            </li>
                                            <li>
                                                <a data-action="expand">
                                                    <i class="ft-maximize"></i>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="card-content collapse show">
                                    <div class="card-body">

                                        <form class="form" id="edit-new-form">
                                            <input value="{{ $notice->id }}" type="hidden" class="notice-id">
                                            <div class="form-body">
                                                <h4 class="form-section">
                                                    <i class="ft-flag"></i>Notice
                                                </h4>
                                                <div class="form-group">
                                                    <label for="title">Title</label>
                                                    <input type="text" id="title" class="form-control notice-title"
                                                        placeholder="Enter Title" value="{{ $notice->title }}"
                                                        name="title">
                                                </div>
                                                <div class="form-group">
                                                    <label for="description">Description</label>
                                                    <textarea rows="5" class="form-control detail" name="description"
                                                        placeholder="Enter Description">
                                                        {!! $notice->detail !!}
                                              </textarea>
                                                </div>
                                            </div>


                                            <div class="form-actions">

                                                <time>{{ $notice->created_at->format('d/m/Y h-m-s') }}</time>
                                                <a href="{{ route('controller.notice.disabled', $notice->id) }}"
                                                        class="btn btn-danger mx-2 float-right mb-1">
                                                    Disabled
                                                </a>
                                                <button type="submit"
                                                    class="btn btn-primary float-right mb-1 edit-submit-button">
                                                    Update
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <h1>Deactive Notice</h1>
                    <hr>
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
                                                    <th>Title</th>
                                                    <th>Description</th>
                                                    <th>Status</th>
                                                    <th>Actions</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach(auth()->user()->controllerInActiveNoticeForController as $notice)
                                                    <tr>
                                                        <td> {{ $loop->iteration }}</td>
                                                        <td>
                                                            {{ $notice->title }}
                                                        </td>
                                                        <td>
                                                            {{ $notice->detail }}
                                                        </td>

                                                        <td>
                                                            {{ $notice->is_active == 1 ? 'Active' : 'InActive' }}
                                                        </td>
                                                        <td>
                                                            <input type="hidden" class="hidden-id" value="{{ $notice->id }}">
                                                            <span class="dropdown">
                                                                <button id="btnSearchDrop12" type="button"
                                                                        class="btn btn-sm btn-icon btn-pure font-medium-2"
                                                                        data-toggle="dropdown" aria-haspopup="true"
                                                                        aria-expanded="false">
                                                                    <i class="ft-more-vertical"></i>
                                                                </button>

                                                                <span aria-labelledby="btnSearchDrop12"
                                                                      class="dropdown-menu dropdown-menu-button">
                                                                    <a href="{{ route('controller.notice.enable', $notice->id) }}" class="dropdown-item deleted-click">
                                                                        <i class="ft-trash-2"></i>
                                                                        Active
                                                                    </a>
                                                                    <button type="button" class="dropdown-item deleted-click">
                                                                        <i class="ft-trash-2"></i>
                                                                        Delete
                                                                    </button>
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
                <!--/ Card end -->
            </div>
            <!-- container-fluid end -->
        </div>
    </div>
</div>
<!-- END: Main Content end-->
<script>
    $(document).ready(function() {
            //Show modal for add
            $('#add-new').click(function(){
                $('#modal').modal('show');
                $('#edit-submit-button').hide();
                $('#add-submit-button').show();
                $('#modal-title').html('Add a new notice');
                $('#title').val('');
                $('#detail').val('');
            });

            //Submit new category
            $('#add-submit-button').click(function(){
                $(this).val('Loading...');
                var formData = new FormData();
                formData.append('title', $('#title').val())
                formData.append('detail', $('#detail').val())
                $.ajax({
                    method: 'POST',
                    url: '{{ route('controller.notice.store') }}',
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (data) {
                        $("#add-submit-button").val('Add New');
                        $('#modal').modal('hide');
                        $('#title').val('');
                        $('#detail').val('');
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: 'Successfully add '+data.title,
                            showConfirmButton: false,
                            timer: 1500
                        })
                        setTimeout(function() {
                            location.reload();
                        }, 800);//

                    },
                    error: function (xhr) {
                        $("#add-submit-button").val('Add New');
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
            $('.edit-submit-button').click(function(){
                var formData = new FormData();
                formData.append('id', $(".notice-id").val());
                formData.append('title', $(".notice-title").val());
                formData.append('detail', $(".detail").val());
                $.ajax({
                    method: 'POST',
                    url: "{{ route('controller.notice.update') }}",
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (data) {
                        $('#modal').modal('hide');
                        $('#title').val('');
                        $('#detail').val('');
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
