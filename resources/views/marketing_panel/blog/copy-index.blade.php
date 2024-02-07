@extends('marketing_panel.layout.app')
@push('title') {{ __('Dashboard') }} @endpush
@push('head')
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.16/css/jquery.dataTables.css">

    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
@endpush
@section('content')
    <div class="content-wrapper">
        <div class="container-fluid">
            <!-- Breadcrumb-->

            <div class="row pt-2 pb-2">
                <div class="col-sm-9">
                    <h4 class="page-title">{{ __('Blogs') }} </h4>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javaScript:void();">{{ __('ashooo') }}</a></li>
                        <li class="breadcrumb-item"><a href="javaScript:void();">{{ __('Blog List') }}</a></li>
                    </ol>
                </div>
                <div class="col-sm-3">
                    <div class="btn-group float-sm-right">
                        <button type="button" id="add-new" class="btn btn-outline-primary waves-effect waves-light"><i class="fa fa-plus"></i> {{ __('Add new Blog') }}</button>
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
                                        <th scope="col">{{ __('Title') }}</th>
                                        <th scope="col">{{ __('Image') }}</th>
                                        <th scope="col">{{ __('Category') }}</th>
                                        <th scope="col">{{ __('Description') }}</th>
                                        <th scope="col">{{ __('Action') }}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($blogs as $blog)
                                    <tr>
                                        <td scope="row">{{ $loop->iteration }}</td>
                                        <td>{{ $blog->title }}</td>
                                        <td><img src="{{ asset($blog->thumbnail_img) }}" height="50px" width="50px" style="border-radius: 15px;"></td>
                                        <td>{{ $blog->category->name }}</td>
                                        <td>{{  Str::limit($blog->description,20, '...') }} </td>
                                        <td>
                                            <input type="hidden" class="hidden-id" value="{{ $blog->id }}">
                                            <a href="{{ route('marketing_panel.blog.edit',$blog->id) }}" class="btn btn-success waves-effect waves-light m-1 update-submit-button" ><i class="fa fa-edit"></i>{{ __(' Update Now') }}</a>

                                            <form action="{{ route('marketing_panel.blog.destroy',$blog->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger waves-effect waves-light m-1 delete-submit-button d-inline" ><i class="fa fa-trash"></i>{{ __('Delete') }}</button>
                                            </form>

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
                                <span class="input-group-text">{{ __('Title') }}</span>
                           </div>
                           <input type="hidden" id="blog-id">
                           <input type="text" class="form-control" name="title" id="title">
                        </div>
                        <div class="input-group input-group-lg mb-3">
                            <input type="file" class="form-control valid" accept="image/*" id="thumbnail_img" name="thumbnail_img" required="" aria-invalid="false">
                        </div>

                        <div class="input-group input-group-lg mb-3">
                            <textarea id="description" rows="4" class="form-control detail" placeholder="Blog detail ...">

                            </textarea>
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

                    </form>
                </div>
                <div class="modal-footer" id="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" ><i class="fa fa-times"></i> {{ __('Close') }}</button>
                    <button type="button" class="btn btn-primary" id="add-submit-button"><i class="fa fa-check-square-o"></i> {{ __('Add new Blog') }}</button>
                    <button type="button" class="btn btn-primary" id="edit-submit-button"><i class="fa fa-check-square-o"></i> {{ __('Edit Blog') }}</button>
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
               $('#modal-title').html('Add a new Blog');
               $('#title').val('');
               $('#category-id').prop('selectedIndex',0); //Reset dropdown after click on edit
           });

           //Submit new
           $('#add-submit-button').click(function(){

               var formData = new FormData();
               formData.append('title', $('#title').val())
               formData.append('category', $('#category-id').val())
               formData.append('description', $('#description').val())
               formData.append('thumbnail_img', $('#thumbnail_img')[0].files[0])

               $.ajax({
                   method: 'POST',
                   url: "{{ route('marketing_panel.blog.store') }}",
                   headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                   data: formData,
                   processData: false,
                   contentType: false,
                   success: function (data) {
                       $('#modal').modal('hide');
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
    <script type="text/javascript" charset="utf8" src="//cdn.datatables.net/1.10.16/js/jquery.dataTables.js"></script>
    <script>
        $(document).ready( function () {
                var dataTable = $('#datatable').DataTable({
                    processing: true,
                    serverSide: true,
                    autoWidth: false,
                    pageLength: 10,
                    // scrollX: true,
                    "order": [[ 0, "desc" ]],
                    ajax: "{{  url('/filter/marketer/list/') }}",
                    columns: [
                        {data: 'user_name', name: 'user_name'},
                        {data: 'date', name: 'date'},
                        {data: 'phone', name: 'phone'},
                        {data: 'email', name: 'email'},
                        {data: 'link', name: 'link',orderable:false,serachable:false,sClass:'text-center'},
                        {data: 'Actions', name: 'Actions',orderable:false,serachable:t,sClass:'text-center'},
                    ]
                });
            }



         );
    </script>
@endpush
