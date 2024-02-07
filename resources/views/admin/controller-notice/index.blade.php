@extends('admin.layout.app')
    @push('head')

    @endpush
@section('content')
    <div class="content-wrapper">
        <div class="container-fluid">
            <!-- Breadcrumb-->
            <div class="row pt-2 pb-2">
                <div class="col-sm-9">
                    <h4 class="page-title">{{ __('Controller notices ') }}</h4>
                </div>
            </div>
            <!-- End Breadcrumb-->
{{--            Filter Option--}}
            <div class="row mt-1">
                <div class="col-md-12">
                    <div class="card card-background-blue margin-bottom-10">
                        <div class="card-content">
                            <form action="{{ request()->url() }}">
                            <div class="card-body d-flex justify-content-center">
                                <select name="district" id="district" class="form-control mx-2">
                                    <option selected>Select District</option>
                                    <option value="All">All</option>
                                    @foreach(App\District::all() as $district)
                                        <option value="{{$district->id}}" @if(request()->get('district') == $district->id) selected @endif>{{$district->name}}</option>
                                    @endforeach
                                </select>
                                <select name="upazila" id="upazila" class="form-control mx-2">
                                    <option selected>Upazila</option>
                                    <option value="All">All</option>
                                    @foreach(App\Upazila::all() as $upazila)
                                        <option value="{{$upazila->id}}" @if(request()->get('upazila') == $upazila->id) selected @endif>{{$upazila->name}}</option>
                                    @endforeach
                                </select>
                                <button type="submit" class="btn btn-secondary mx-2">
                                    Apply
                                </button>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
{{--            Filter Option--}}
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                @foreach($notices as $notice)
                                    <div class="col-lg-6">
                                        <div class="card border border-success">
                                            <div class="card-body">
                                                <h5 class="card-title text-success notice-title">{{ $notice->title }}</h5>
                                                <h5 class="card-title text-danger btn btn-inverse-success waves-effect waves-light m-1 controller-name">{{ $notice->controller->full_name }}</h5>
                                                <h5 class="card-title text-danger btn btn-inverse-success waves-effect waves-light m-1 upazila-name">{{ $notice->controller->upazila->name }}</h5>
                                                <div>{!! $notice->detail !!}</div>
                                                <hr>
                                                <input type="hidden" class="hidden-id" value="{{ $notice->id }}">
                                                <a href="javascript:void();" class="btn btn-inverse-success waves-effect waves-light btn-sm"><i class="fa fa-globe mr-1"></i> {{ $notice->created_at->format('d/m/Y h-m-s') }}</a>
                                                <a href="{{ route('admin.statusControllerNotice', $notice->id) }}" class="btn btn-primary waves-effect waves-light btn-sm" ><i class="fa fa-times-circle"></i> {{ __('Deactive') }}</a>
                                                <a href="javascript:void();" class="btn btn-success waves-effect waves-light btn-sm edit-button" ><i class="fa fa-edit"></i> {{ __('Update') }}</a>
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
                                    @foreach($inactive_notices as $notice)
                                        <tr>
                                            <td>{{ $notice->title }}</td>
                                            <td>{!! Str::limit($notice->detail, 30) !!}</td>
                                            <td>{{ $notice->created_at->format('d/m/Y h-m-s') }}</td>
                                            <td>
                                                <a href="{{ route('admin.statusControllerNotice', $notice->id) }}" class="btn btn-inverse-success waves-effect waves-light btn-sm">
                                                    <i class="fa fa-globe mr-1"></i> {{ __('Active Now') }}
                                                </a>
                                                <a href="{{ route('admin.destroyControllerNotice', $notice->id) }}" class="btn btn-inverse-danger waves-effect waves-light btn-sm">
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
                           <span class="input-group-text">Title</span>
                           </div>
                            <input type="hidden" id="notice-id">
                           <input type="text" class="form-control" name="title" id="title">
                         </div>
                        <div class="input-group input-group-lg mb-3">
                           <textarea rows="4" class="form-control" id="detail" placeholder="Notice detail ..."></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer" id="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" ><i class="fa fa-times"></i> {{ __('Close') }}</button>
                    <button type="button" class="btn btn-primary" id="add-submit-button"><i class="fa fa-check-square-o"></i> {{ __('Add new notice') }}</button>
                    <button type="button" class="btn btn-primary" id="edit-submit-button"><i class="fa fa-check-square-o"></i> {{ __('Edit notice') }}</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Edit Modal -->
    <script>
        $(document).ready(function() {

            //Show modal for edit and set data
            $(".edit-button").click(function(){
                $('#modal').modal('show');
                $('#modal-title').html('Edit notice');
                $('#add-submit-button').hide();
                $('#edit-submit-button').show();
                $('#title').val($(this).parent().find('.notice-title').text());
                $('#detail').val($(this).parent().find('.notice-detail').text());
                $('#notice-id').val($(this).parent().find('.hidden-id').val());
            });

            //Submit edited category
            $('#edit-submit-button').click(function(){

                var formData = new FormData();
                formData.append('id', $('#notice-id').val())
                formData.append('title', $('#title').val())
                formData.append('detail', $('#detail').val())
                $.ajax({
                    method: 'POST',
                    url: "{{ route('admin.updateControllerNotice') }}",
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (data) {
                        $('#modal').modal('hide');
                        $('#category-name').val('');
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

@endsection
@push('foot')

@endpush
