@extends('marketing_panel.layout.app')
@push('title') {{ __('Blog List') }} @endpush
@push('head')
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.16/css/jquery.dataTables.css">

    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
@endpush
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="float-right mb-1 mt-1">
                <button type="button" class="btn btn-outline-primary" data-toggle="modal"
                        data-target="#new_create" id="add-new">
                    <i class="fa fa-plus"></i>
                    Add New Blog
                </button>
            </div>
        </div>
    </div>
    <!-- select option row end -->

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-head">
                    <div class="card-header">
                        <h4 class="card-title">Blog</h4>
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
                                   class="table table-white-space table-bordered table-striped table-sm row-grouping display no-wrap icheck table-middle">
                                <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Image</th>
                                    <th>Title</th>
                                    <th>Category</th>
                                    <th>Description</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($blogs as $blog)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <img src="{{ asset($blog->thumbnail_img) }}" width="60"
                                             alt="">
                                    </td>
                                    <td>
                                        {{ $blog->title }}
                                    </td>
                                    <td>
                                        {{ $blog->category->name }}
                                    </td>
                                    <td>
                                        <p>
                                            {{  Str::limit($blog->description,20, '...') }}
                                        </p>
                                    </td>
                                    <td>
                                                <span class="dropdown">
                                                   <a
                                                       href="#"
                                                       class="btn btn-info edit-button"
                                                       data-id="{{$blog->id}}"
                                                       data-title="{{$blog->title}}"
                                                       data-category="{{$blog->category}}"
                                                       data-description="{{$blog->description}}"
                                                   >
                                                      <i class="ft-edit-2"></i>
                                                      Edit Blog
                                                   </a>
                                                   <button id="btnSearchDrop12" type="button"
                                                           class="btn btn-sm btn-icon btn-pure font-medium-2 "
                                                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                      <i class="ft-more-vertical"></i>
                                                   </button>

                                                   <span aria-labelledby="btnSearchDrop12"
                                                         class="dropdown-menu dropdown-menu-button">
{{--                                                      <a href="#" class="dropdown-item btn btn-primary">--}}
{{--                                                         <i class="ft-check-circle"></i>--}}
{{--                                                         Active--}}
{{--                                                      </a>--}}
{{--                                                      <a href="#" class="dropdown-item">--}}
{{--                                                         <i class="ft-disc"></i>--}}
{{--                                                         Disable--}}
{{--                                                      </a>--}}
                                                      <a href="{{route('marketing_panel.blog.destroy', $blog->id)}}" class="dropdown-item delete-button" data-id="{{$blog->id}}">
                                                         <i class="ft-trash-2"></i>
                                                         Soft Delete
                                                      </a>
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
    <!-- Edit Modal -->
    <!-- Add Model Start -->
    <div class="modal fade" id="new_create" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                        Add a new blog
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>

                <div class="modal-body">
                    <form action="#" method="POST">
                        <div class="form-group">
                            <input type="hidden" name="id" id="edit_id" >
                            <img src="../assets/images/marketing_panel/blog/1.jpg" width="100" alt="" id="blah">
                            <input type="file" name="image" class="form-control" value="04" id="image"
                                   onchange="document.getElementById('blah').src = window.URL.createObjectURL(this.files[0])">
                        </div>
                        <div class="form-group">
                            <label for="title" class="col-form-label">Title</label>
                            <input type="text" name="title" class="form-control" value="smith455" id="title">
                        </div>
                        <div class="form-group">
                            <select name="category" class="form-control" id="category">
                                <option selected="">Select Category</option>
                                @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="title" class="col-form-label">Description</label>
                            <textarea name="" id="description" cols="30" rows="10" name="description" class="form-control"></textarea>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" id="add-submit-button"><i class="fa fa-check-square-o"></i> {{ __('Add new Blog') }}</button>
                            <button type="button" class="btn btn-primary" id="edit-submit-button"><i class="fa fa-check-square-o"></i> {{ __('Edit Blog') }}</button>
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
                $('#edit-submit-button').hide();
                $('#add-submit-button').show();
                $('#modal-title').html('Add a new Blog');
                $('#title').val('');
                $('#description').val('');
                $('#category-id').prop('selectedIndex',0); //Reset dropdown after click on edit
            });

            //Submit new
            $('#add-submit-button').click(function(){

                var formData = new FormData();
                formData.append('title', $('#title').val())
                formData.append('category', $('#category').val())
                formData.append('description', $('#description').val())
                formData.append('thumbnail_img', $('#image')[0].files[0])

                $.ajax({
                    method: 'POST',
                    url: "{{ route('marketing_panel.blog.store') }}",
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (data) {
                        $('#new_create').modal('hide');
                        $('#title').val('');
                        $('#category').val('');
                        $('#description').val('');

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
                $('#new_create').modal('show');
                $('.modal-title').html('Edit Blogs.');
                $('#add-submit-button').hide();
                $('#edit-submit-button').show();
                $('#title').val($(this).data("title"));
                $('#description').val($(this).data("description"));
                // $('#category-id').val($(this).data("category"));
                $('#category-id').prop('selectedIndex',$(this).data("category"));
                $('#edit_id').val($(this).data("id"));
            });

            //Submit edited category
            $('#edit-submit-button').click(function(){
                var formData = new FormData();
                formData.append('id', $('#edit_id').val())
                formData.append('title', $('#title').val())
                formData.append('description', $('#description').val())
                formData.append('category', $('#category-id').val())
                formData.append('thumbnail_img', $('#image')[0].files[0])
                console.log(formData);
                $.ajax({
                    method: 'PUT',
                    url: '/MarketingPanel/blog/'+$('#edit_id').val(),
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (data) {
                        console.log(data);
                        $('#modal').modal('hide');
                        $('#url').val('');
                        $('#s_date').val('');
                        $('#end_date').val('');
                        $('#status').val('');
                        $('#image').val('');
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: 'Successfully edited ads',
                            showConfirmButton: false,
                            timer: 1500
                        })
                        // setTimeout(function() {
                        //     location.reload();
                        // }, 800);//

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


            $('.delete-button').click(function(e){
                e.preventDefault();
                var id = $(this).attr("data-id");
                var formData = new FormData();
                formData.append('id', id)
                $.ajax({
                    method: 'POST',
                    url: '#,
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (data) {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'danger',
                            title: 'Successfully deleted ads',
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

{{--    <script>--}}
{{--        $('.detail').summernote({--}}

{{--            tabsize: 2,--}}
{{--            height: 120,--}}
{{--            toolbar: [--}}
{{--                ['style', ['style']],--}}
{{--                ['font', ['bold', 'underline', 'clear']],--}}
{{--                ['color', ['color']],--}}
{{--                ['para', ['ul', 'ol', 'paragraph']],--}}
{{--                ['view', ['fullscreen', 'codeview']]--}}
{{--            ]--}}
{{--        });--}}
{{--    </script>--}}

@endpush
