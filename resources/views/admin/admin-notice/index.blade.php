@extends('admin.layout.app')
    @push('head')
        <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
        <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
    @endpush
@section('content')
    <div class="content-wrapper">
        <div class="container-fluid">
            <!-- Breadcrumb-->
            <div class="row pt-2 pb-2">
                <div class="col-sm-9">
                    <h4 class="page-title">{{ __('Admin notices ') }}</h4>
                </div>
                <div class="col-sm-3">
                    <div class="btn-group float-sm-right">
                        <button type="button" id="add-new" class="btn btn-outline-primary waves-effect waves-light"><i class="fa fa-plus"></i>{{ __(' Add admin notices') }}</button>
                    </div>
                </div>
            </div>
            <!-- End Breadcrumb-->
            <div class="row">


                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                           <div class="row">
                               @foreach($notices as $notice)
                                   <div class="col-lg-6">
                                       <div class="card border @if($loop->iteration == 1) border-success @else border-danger @endif">
                                           <div class="card-body">
                                               <form action="#" id="add-new-from">
                                                   <div class="input-group input-group-lg mb-3">
                                                       <div class="input-group-prepend">
                                                           <span class="input-group-text">{{ __('Title') }}</span>
                                                       </div>
                                                       <input value="{{ $notice->id }}" type="hidden" class="notice-id" >
                                                       <input type="text" class="form-control notice-title" name="title" value="{{ $notice->title }}">
                                                   </div>
                                                   <div class="input-group input-group-lg mb-3">
                                                       <textarea rows="4" class="form-control detail" placeholder="Notice detail ...">
                                                           {!! $notice->detail !!}
                                                       </textarea>
                                                   </div>
                                               <input type="hidden" class="hidden-id" value="{{ $notice->id }}">
                                               <a href="javascript:0" class="btn btn-inverse-success waves-effect waves-light btn-sm">
                                                   <i class="fa fa-globe mr-1"></i> {{ $notice->created_at->format('d/m/Y h-m-s') }}
                                               </a>
                                                  <a href="{{ route('admin.statusAdminNotice', $notice->id) }}" class="btn btn-inverse-primary waves-effect waves-light btn-sm">
                                                    <i class="fa fa-times-circle"></i>{{ __('Deactive') }}
                                               <a href="javascript:void(0);" class="btn btn-success waves-effect waves-light btn-sm update-submit-button mx-1" ><i class="fa fa-edit"></i>{{ __(' Update') }}</a>
                                               </form>
                                           </div>
                                       </div>
                                   </div>
                               @endforeach
                           </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Deactivate Notice</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table  class="table" id="datatable">
                                    <thead class="thead-success shadow-success">
                                    <tr>
                                        <th scope="col">{{ __('Title') }}</th>
                                        <th scope="col">{{ __('Description') }}</th>
                                        <th scope="col">{{ __('Created At') }}</th>
                                        <th scope="col">{{ __('Action') }}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($inactiveNotice as $notice)
                                        <tr>
                                            <td>{{ $notice->title }}</td>
                                            <td>{!! Str::limit($notice->detail, 30) !!}</td>
                                            <td>{{ $notice->created_at->format('d/m/Y h-m-s') }}</td>
                                            <td>
                                                <a href="{{ route('admin.statusAdminNotice', $notice->id) }}" class="btn btn-inverse-success waves-effect waves-light btn-sm">
                                                    <i class="fa fa-globe mr-1"></i> {{ __('Active Now') }}
                                                </a>
                                                <a href="{{ route('admin.destroyAdminNotice', $notice->id) }}" class="btn btn-inverse-danger waves-effect waves-light btn-sm">
                                                    <i class="fa fa-trash-o"></i>{{ __(' Delete') }}
                                                </a>
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
                    <form action="#" id="add-new-from">
                        <div class="input-group input-group-lg mb-3">
                           <div class="input-group-prepend">
                           <span class="input-group-text">{{ __('Title') }}</span>
                           </div>
                            <input type="hidden" id="notice-id">
                           <input type="text" class="form-control" name="title" id="title">
                         </div>
                        <div class="input-group input-group-lg mb-3">
                           <textarea rows="4" class="form-control detail"  id="detail" placeholder="Notice detail ..."></textarea>

                        </div>
                    </form>
                </div>
                <div class="modal-footer" id="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" ><i class="fa fa-times"></i> Close</button>
                    <button type="button" class="btn btn-primary" id="add-submit-button"><i class="fa fa-check-square-o"></i>{{ __(' Add new notice') }}</button>
                    <button type="button" class="btn btn-primary" id="edit-submit-button"><i class="fa fa-check-square-o"></i>{{ __(' Update notice') }}</button>
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
               $('#modal-title').html('Add a new notice');
               $('#title').val('');
               $('#detail').val('');
           });

           //Submit new category
           $('#add-submit-button').click(function(){
               var formData = new FormData();
               formData.append('title', $('#title').val())
               formData.append('detail', $('#detail').val())
               $.ajax({
                   method: 'POST',
                   url: '/admin/admin-notice',
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

            //Submit edited category
            $('.update-submit-button').click(function(){
                var formData = new FormData();
                formData.append('id', $(this).parent().find('.notice-id').val());
                formData.append('title', $(this).parent().find('.notice-title').val());
                formData.append('detail', $(this).parent().find('.detail').val());
                console.log( $(this).parentsUntil('.card-body').find('.title').text())
                console.log( $(this).parentsUntil('.card-body').find('.detail').text())
                console.log( $(this).parentsUntil('.card-body').find('.notice-id').val())
                $.ajax({
                    method: 'POST',
                    url: "{{ route('admin.updateAdminNotice') }}",
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
    <!-- summernote config -->

@endpush

