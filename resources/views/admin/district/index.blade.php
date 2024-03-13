@extends('admin.layout.app')
    @push('head')

    @endpush
@section('content')
    <div class="content-wrapper">
        <div class="container-fluid">
            <!-- Breadcrumb-->
            <div class="row pt-2 pb-2">
                <div class="col-sm-9">
                    <h4 class="page-title">{{ __('District List') }}</h4>
                </div>
                <div class="col-sm-3">
                    <div class="btn-group float-sm-right">
                        <button type="button" id="add-new" class="btn btn-outline-primary waves-effect waves-light"><i class="fa fa-plus"></i> {{ __('Add new district') }}</button>
                    </div>
                </div>
            </div>
            <!-- End Breadcrumb-->
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="active-tab" data-toggle="tab" href="#active" role="tab" aria-controls="active" aria-selected="true">
                                        Active District List
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="deleted-data" data-toggle="tab" href="#deleted" role="tab" aria-controls="inactive" aria-selected="false">
                                        Deleted District List
                                    </a>
                                </li>
                            </ul>
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active" id="active" role="tabpanel" aria-labelledby="active-tab">
                                    <div class="row">
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead class="thead-success shadow-success">
                                                    <tr>
                                                        <th scope="col">#</th>
                                                        <th scope="col">{{ __('Name') }}</th>
                                                        <th scope="col">{{ __('Action') }}</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($districts as $district)
                                                <tr>
                                                    <td scope="row">{{ $loop->iteration }}</td>
                                                    <td>{{ $district->name }}</td>
                                                    <td>
                                                        <input type="hidden" class="hidden-id" value="{{ $district->id }}">
                                                        <button type="button" id="edit" class="edit-button btn btn-outline-warning waves-effect waves-light m-1"> <i class="fa fa-edit"></i> </button>
                                                        <form method="post" action="{{route('admin.district.destroy',$district->id)}}">
                                                            @csrf
                                                            <button onclick="return Sure()" class="btn btn-danger" type="submit" style="margin-left: 17px;"><i class="fa fa-trash"></i></button>
                                                        </form>
                                                    </td>
                                                </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="deleted" role="tabpanel" aria-labelledby="deleted-data">
                                @php
                                use App\District;
                                $deleted=  District::onlyTrashed()->get();
                                $sl = 1;
                                @endphp
                                <div class="row">
                                    <div class="table-responsive">
                                        <table  class="table" id="datatable">
                                            <thead class="thead-success shadow-success">
                                                <tr>
                                                    <th scope="col">#</th>
                                                    <th scope="col">{{ __('Name') }}</th>
                                                    <th scope="col">{{ __('Action') }}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if($deleted)
                                                @foreach ($deleted as $v)
                                                <tr>
                                                    <td>{{$sl++}}</td>
                                                    <td>{{$v->name}}</td>
                                                    <td>
                                                    <a href="{{ route('admin.district.district_restore', $v->id) }}" class="btn btn-sm btn-info">Restore</a>
                                                    <a href="{{ route('admin.district.district_delete', $v->id) }}" onclick="return Sure()" class="btn btn-sm btn-danger">Permenantly Delete</a>
                                                    </td>
                                                </tr>
                                                @endforeach
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
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
                           <span class="input-group-text">{{ __('Name') }}</span>
                           </div>
                            <input type="hidden" id="district-id">
                           <input type="text" class="form-control" name="district-name" id="district-name">
                         </div>
                    </form>
                </div>
                <div class="modal-footer" id="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" ><i class="fa fa-times"></i> {{ __('Close') }}</button>
                    <button type="button" class="btn btn-primary" id="add-submit-button"><i class="fa fa-check-square-o"></i> {{ __('Add new district') }}</button>
                    <button type="button" class="btn btn-primary" id="edit-submit-button"><i class="fa fa-check-square-o"></i> {{ __('Edit district') }}</button>
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
               $('#modal-title').html('Add a new district');
               $('#district-name').val('');
           });

           //Submit new
           $('#add-submit-button').click(function(){
               var districtName = $('#district-name').val();
               $.ajax({
                   method: 'POST',
                   url: '/admin/district',
                   headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                   data: { name: districtName},
                   dataType: 'JSON',
                   success: function (data) {
                       $('#modal').modal('hide');
                       $('#district-name').val('');
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
                $('#modal').modal('show');
                $('#modal-title').html('Edit district');
                $('#add-submit-button').hide();
                $('#edit-submit-button').show();
                $('#district-name').val($(this).parent().parent().find('td').eq(1).text());
                $('#district-id').val($(this).parent().parent().find('.hidden-id').val());
            });

            //Submit edited
            $('#edit-submit-button').click(function(){
                var districtName = $('#district-name').val();
                var districtId = $('#district-id').val();
                $.ajax({
                    method: 'PATCH',
                    url: '/admin/district/'+districtId,
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    data: { name: districtName},
                    dataType: 'JSON',
                    success: function (data) {
                        $('#modal').modal('hide');
                        $('#district-name').val('');
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
        });
    </script>

<script>
    function Sure()
    {
        if(confirm("Are Your Sure To Delete?"))
        {
            return ture;
        }
        else
        {
            return false;
        }
    }
</script>

@endsection
@push('foot')

@endpush
