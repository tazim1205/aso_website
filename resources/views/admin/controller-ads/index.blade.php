@extends('admin.layout.app')
    @push('head')
        <!--Bootstrap Datepicker-->
        <link href="{{ asset('assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet" type="text/css">
    @endpush
@section('content')
    <div class="content-wrapper">
        <div class="container-fluid">
            <!-- Breadcrumb-->
            <div class="row pt-2 pb-2">
                <div class="col-sm-9">
                    <h4 class="page-title">{{ __('Controller ads. ') }}</h4>

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
                                        Active Ads
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="inactive-tab" data-toggle="tab" href="#inactive" role="tab" aria-controls="inactive" aria-selected="false">
                                        Inactive Ads
                                    </a>
                                </li>
                            </ul>
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active" id="active" role="tabpanel" aria-labelledby="active-tab">

                                    <h5 class="card-title">{{ __('Active Controller Ads') }}</h5>
                                        <div class="table-responsive">
                                            <table  class="table" id="datatable">
                                                <thead class="thead-success shadow-success">
                                                <tr>
                                                    <th scope="col">{{ __('Image') }}</th>
                                                    <th scope="col">{{ __('Status') }}</th>
                                                    <th scope="col">{{ __('Starting') }}</th>
                                                    <th scope="col">{{ __('Ending') }}</th>
                                                    <th scope="col">{{ __('Created At') }}</th>
                                                    <th scope="col">{{ __('Action') }}</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($ads as $ads)
                                                    <tr>
                                                        <td><img src="{{ asset($ads->image) }}" class="card-img-top" alt="" width="128px"></td>
                                                        <td>
                                                            @if($ads->status == 0)
                                                                <span class="badge badge-danger badge-pill"> {{ __('Inactive') }} </span>
                                                            @elseif($ads->starting < \Carbon\Carbon::today()->addDays(1) && $ads->ending > \Carbon\Carbon::today()->addDays(-1))
                                                                <span class="badge badge-success badge-pill"> {{ __('Running') }} </span>
                                                            @else
                                                                <span class="badge badge-info badge-pill"> {{ __('Completed') }} </span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <span class="badge badge-success badge-pill start">{{ $ads->starting  }}</span>
                                                        </td>
                                                        <td>
                                                            <span class="badge badge-danger badge-pill end">{{ $ads->ending }}</span>
                                                        </td>
                                                        <td>
                                                            <span class="badge badge-dark badge-pill">{{ date('d/m/Y h-m-s', strtotime($ads->created_at)) }}</span>
                                                        </td>
                                                        <td>
                                                            <input type="hidden" class="hidden-url" value="{{ $ads->url }}">
                                                            <input type="hidden" class="hidden-id" value="{{ $ads->id }}">
                                                            <a @if($ads->url) href="{{ $ads->url }}" target="_blank" @else  href="#" @endif  class="card-link">{{ __('Ads. Link') }}</a>
                                                            <a href="javascript:void();" class="card-link edit-button">{{ __('Edit Now') }}</a>
                                                            <a href="{{ route('admin.destroyControllerAds', $ads->id) }}" class="card-link">Delete</a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>

                                        </div>
                                </div>
                                <div class="tab-pane fade" id="inactive" role="tabpanel" aria-labelledby="inactive-tab">

                                    <h5 class="card-title">{{ __('In Active Controller Ads') }}</h5>
                                        <div class="table-responsive">
                                            <table  class="table" id="datatable1">
                                                <thead class="thead-success shadow-success">
                                                <tr>
                                                    <th scope="col">{{ __('Image') }}</th>
                                                    <th scope="col">{{ __('Status') }}</th>
                                                    <th scope="col">{{ __('Starting') }}</th>
                                                    <th scope="col">{{ __('Ending') }}</th>
                                                    <th scope="col">{{ __('Created At') }}</th>
                                                    <th scope="col">{{ __('Action') }}</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($inactive as $ads)
                                                    <tr>
                                                        <td><img src="{{ asset($ads->image) }}" class="card-img-top" alt="" width="128px"></td>
                                                        <td>
                                                            @if($ads->status == 0)
                                                                <span class="badge badge-danger badge-pill"> {{ __('Inactive') }} </span>
                                                            @elseif($ads->starting < \Carbon\Carbon::today()->addDays(1) && $ads->ending > \Carbon\Carbon::today()->addDays(-1))
                                                                <span class="badge badge-success badge-pill"> {{ __('Running') }} </span>
                                                            @else
                                                                <span class="badge badge-info badge-pill"> {{ __('Completed') }} </span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <span class="badge badge-success badge-pill start">{{ $ads->starting  }}</span>
                                                        </td>
                                                        <td>
                                                            <span class="badge badge-danger badge-pill end">{{ $ads->ending }}</span>
                                                        </td>
                                                        <td>
                                                            <span class="badge badge-dark badge-pill">{{ date('d/m/Y h-m-s', strtotime($ads->created_at)) }}</span>
                                                        </td>
                                                        <td>
                                                            <input type="hidden" class="hidden-url" value="{{ $ads->url }}">
                                                            <input type="hidden" class="hidden-id" value="{{ $ads->id }}">
                                                            <a @if($ads->url) href="{{ $ads->url }}" target="_blank" @else  href="#" @endif  class="card-link">{{ __('Ads. Link') }}</a>
                                                            <a href="javascript:void();" class="card-link edit-button">{{ __('Edit Now') }}</a>
                                                            <a href="{{ route('admin.destroyControllerAds', $ads->id) }}" class="card-link">Delete</a>
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
                        <input type="hidden" id="ads-id">
                        <div class="input-group input-group-lg mb-3">
                           <div class="input-group-prepend">
                           <span class="input-group-text">URL</span>
                           </div>
                           <input type="text" class="form-control" name="url" id="url">
                         </div>
                        <div class="input-group input-group-lg mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">{{ __('Start at') }}</span>
                            </div>
                            <input type="text" id="starting-date" class="form-control" data-date-format='yyyy/mm/dd' autocomplete="false" placeholder="Starting Date">
                        </div>
                        <div class="input-group input-group-lg mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">{{ __('Ending at') }}</span>
                            </div>
                            <input type="text" id="ending-date" class="form-control" data-date-format='yyyy/mm/dd' autocomplete="false" placeholder="Ending Date">
                        </div>
                        <div class="input-group input-group-lg mb-3">
                            <input type="file" class="form-control valid" accept="image/*" id="image" name="image" required="" aria-invalid="false">
                        </div>
                        <div class="input-group input-group-lg mb-3">
                            <input type="checkbox" id="activation" value="" class="filled-in chk-col-success">
                            <label for="activation" class="btn-round btn-danger waves-effect waves-light">{{ __('Is activated !!!!') }}</label>
                        </div>
                    </form>
                </div>
                <div class="modal-footer" id="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" ><i class="fa fa-times"></i> {{ __('Close') }}</button>
                    <button type="button" class="btn btn-primary" id="add-submit-button"><i class="fa fa-check-square-o"></i>{{ __(' Add new ads.') }}</button>
                    <button type="button" class="btn btn-primary" id="edit-submit-button"><i class="fa fa-check-square-o"></i>{{ __(' Edit ads.') }}</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Edit Modal -->


@endsection
@push('foot')
    <script type="text/javascript" charset="utf8" src="//cdn.datatables.net/1.10.16/js/jquery.dataTables.js"></script>
    <script>
        $(document).ready(function() {

            $('#datatable').DataTable({
                responsive: true,
            });
            $('#datatable1').DataTable({
                responsive: true,
            });

            //Assign checkbox box value
            $('#activation').change(function (){
                if($('#activation').prop('checked')) {
                    $('#activation').val('1')
                } else {
                    $('#activation').val('0')
                }
            })

            //Show modal for edit and set data
            $(".edit-button").click(function(){
                $('#modal').modal('show');
                $('#modal-title').html('Edit ads.');
                $('#add-submit-button').hide();
                $('#edit-submit-button').show();
                $('#url').val($(this).parent().parent().find('.hidden-url').val());
                $('#starting-date').val($(this).parent().parent().find('.start').text());
                $('#ending-date').val($(this).parent().parent().find('.end').text());
                $('#ads-id').val($(this).parent().parent().find('.hidden-id').val());
            });

            //Submit edited category
            $('#edit-submit-button').click(function(){
                var formData = new FormData();
                formData.append('id', $('#ads-id').val())
                formData.append('url', $('#url').val())
                formData.append('startingDate', $('#starting-date').val())
                formData.append('endingDate', $('#ending-date').val())
                formData.append('activation', $('#activation').val())
                formData.append('image', $('#image')[0].files[0])
                $.ajax({
                    method: 'POST',
                    url: '/admin/controller-ads/update',
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (data) {
                        $('#modal').modal('hide');
                        $('#url').val('');
                        $('#startingDate').val('');
                        $('#endingDate').val('');
                        $('#activation').val('');
                        $('#image').val('');
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: 'Successfully edited ads',
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
    <!--Bootstrap Datepicker Js-->
    <script src="{{ asset('assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
    <script>
        //Date
        $('#starting-date').datepicker({
            todayHighlight: true,
        });
        $('#ending-date').datepicker({
            todayHighlight: true,
        });


    </script>
@endpush
