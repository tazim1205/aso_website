@extends('controller.layout.app')
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
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javaScript:void();">{{ __('ashooo') }}</a></li>
                        <li class="breadcrumb-item"><a href="javaScript:void();">{{ __('Controller') }}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ __('ads.') }}</li>
                    </ol>
                </div>
                <div class="col-sm-3">
                    <div class="btn-group float-sm-right">
                        <button type="button" id="add-new" class="btn btn-outline-primary waves-effect waves-light"><i class="fa fa-plus"></i>{{ __(' Add new ads.') }}</button>
                    </div>
                </div>
            </div>
            <!-- End Breadcrumb-->
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                @foreach(auth()->user()->controllerAds as $ads)
                                    <div class="col-lg-4">
                                        <div class="card">
                                            <img src="{{ asset($ads->image) }}" class="card-img-top" alt="">
                                            <div class="card-body">
                                                <h5 class="card-title text-dark"></h5>
                                            </div>
                                            <ul class="list-group list-group-flush list shadow-none">
                                                @if($ads->status == 0)
                                                    <li class="list-group-item d-flex justify-content-between align-items-center">{{ __('Status') }} <span class="badge badge-danger badge-pill"> {{ __('Inactive') }} </span></li>
                                                @elseif($ads->starting < \Carbon\Carbon::today()->addDays(1) && $ads->ending > \Carbon\Carbon::today()->addDays(-1))
                                                    <li class="list-group-item d-flex justify-content-between align-items-center">{{ __('Status') }} <span class="badge badge-success badge-pill"> {{ __('Running') }} </span></li>
                                                @else
                                                    <li class="list-group-item d-flex justify-content-between align-items-center">{{ __('Status') }} <span class="badge badge-info badge-pill"> {{ __('Completed') }} </span></li>
                                                @endif
                                                <li class="list-group-item d-flex justify-content-between align-items-center">{{ __('Starting') }} <span class="badge badge-success badge-pill start">{{ $ads->starting  }}</span></li>
                                                <li class="list-group-item d-flex justify-content-between align-items-center">{{ __('Ending') }} <span class="badge badge-danger badge-pill end">{{ $ads->ending }}</span></li>
                                                <li class="list-group-item d-flex justify-content-between align-items-center">{{ __('Created at') }} <span class="badge badge-dark badge-pill">{{ date('d/m/Y h-m-s', strtotime($ads->created_at)) }}</span></li>
                                            </ul>
                                            <div class="card-body">
                                                <input type="hidden" class="hidden-url" value="{{ $ads->url }}">
                                                <input type="hidden" class="hidden-id" value="{{ $ads->id }}">
                                                <a @if($ads->url) href="{{ $ads->url }}" target="_blank" @else  href="#" @endif  class="card-link">{{ __('Ads. Link') }}</a>
                                                <a href="javascript:void();" class="card-link edit-button">{{ __('Edit Now') }}</a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
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
                           <span class="input-group-text">{{ __('URL') }}</span>
                           </div>
                           <input type="text" class="form-control" name="url" id="url">
                         </div>
                        <div class="input-group input-group-lg mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">{{ __('Start at') }}</span>
                            </div>
                            <input type="text" id="starting-date" class="form-control" data-date-format='yyyy/mm/dd' autocomplete="false" placeholder="{{ __('Starting Date') }}">
                        </div>
                        <div class="input-group input-group-lg mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">{{ __('Ending at') }}</span>
                            </div>
                            <input type="text" id="ending-date" class="form-control" data-date-format='yyyy/mm/dd' autocomplete="false" placeholder="{{ __('Ending Date') }}">
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
    <script>
        $(document).ready(function() {

            //Assign checkbox box value
            $('#activation').change(function (){
                if($('#activation').prop('checked')) {
                    $('#activation').val('1')
                } else {
                    $('#activation').val('0')
                }
            })

           //Show modal for add
           $('#add-new').click(function(){
               $('#modal').modal('show');
               $('#edit-submit-button').hide();
               $('#add-submit-button').show();
               $('#modal-title').html('Add a new ads.');
               $('#url').val('');
               $('#starting-date').val('');
               $('#ending-date').val('');
               $('#activation').val('');
               $('#image').val('');
           });

           //Submit new category
           $('#add-submit-button').click(function(){
               var formData = new FormData();
               formData.append('url', $('#url').val())
               formData.append('startingDate', $('#starting-date').val())
               formData.append('endingDate', $('#ending-date').val())
               formData.append('activation', $('#activation').val())
               formData.append('image', $('#image')[0].files[0])
               $.ajax({
                   method: 'POST',
                   url: '{{ route('controller.ads.store') }}',
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
                           title: 'Successfully add new Ads.',
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
                    url: '{{ route('controller.ads.update') }}',
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

@endsection
@push('foot')
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
