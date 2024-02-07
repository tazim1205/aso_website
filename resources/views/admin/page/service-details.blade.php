@extends('admin.layout.app')
@push('title')
    {{ __('Service Details') }}
@endpush
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
                    <h4 class="page-title"> {{ __('Service Details') }}</h4>
                </div>
                <div class="col-sm-3">
                    <div class="btn-group float-sm-right">
                        <button type="button" id="add-new" class="btn btn-outline-primary waves-effect waves-light"><i class="fa fa-plus"></i> {{ __('Add new Service Details') }}</button>
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
                                    <a class="nav-link active" id="customer-tab" data-toggle="tab" href="#customer" role="tab" aria-controls="customer" aria-selected="true">
                                        Customer Service Details
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="marketer-tab" data-toggle="tab" href="#marketer" role="tab" aria-controls="marketer" aria-selected="false">
                                        Marketer Service Details
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="service_provider-tab" data-toggle="tab" href="#service_provider" role="tab" aria-controls="service_provider" aria-selected="false">
                                        Service provider Service Details
                                    </a>
                                </li>
                            </ul>
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active" id="customer" role="tabpanel" aria-labelledby="customer-tab">
                                    <h5 class="card-title">{{ __('Customers Service Details') }}</h5>
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead class="thead-success shadow-success">
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">{{ __('Details') }}</th>
                                                <th scope="col">{{ __('Action') }}</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach ($customer_faq as $faq)
                                                <tr>
                                                    <td scope="row">{{ $loop->iteration }}</td>
                                                    <td>
                                                        <h5>{{ $faq->question }}</h5>
                                                        {{ Str::limit($faq->answer, 100) }}
                                                    </td>
                                                    <td>
                                                        <button
                                                            type="button"
                                                            id="edit"
                                                            class="edit-button btn btn-outline-warning waves-effect waves-light btn-sm"
                                                            data-id="{{ $faq->id }}"
                                                            data-for="{{ $faq->faq_for }}"
                                                            data-question="{{ $faq->question }}"
                                                            data-ans="{{ $faq->answer }}"
                                                        > <i class="fa fa-edit"></i> </button>
                                                        <button
                                                            data-question="{{ $faq->question }}"
                                                            data-ans="{{ $faq->answer }}"
                                                            class="dlt-btn btn btn-outline-danger waves-effect waves-light btn-sm"
                                                        >
                                                            <i class="fa fa-eye"></i>
                                                        </button>
                                                        <a href="{{ route('admin.servicedetails.destroy', $faq->id) }}" class="btn btn-danger waves-effect waves-light  delete-submit-button btn-sm" ><i class="fa fa-trash"></i></a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="marketer" role="tabpanel" aria-labelledby="marketer-tab">
                                    <h5 class="card-title">{{ __('Marketer Service Details') }}</h5>
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead class="thead-success shadow-success">
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">{{ __('Details') }}</th>
                                                <th scope="col">{{ __('Action') }}</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach ($marketer_faq as $faq)
                                                <tr>
                                                    <td scope="row">{{ $loop->iteration }}</td>
                                                    <td>
                                                        <h5>{{ $faq->question }}</h5>
                                                        {{ Str::limit($faq->answer, 100) }}
                                                    </td>
                                                    <td>

                                                        <button
                                                            type="button"
                                                            id="edit"
                                                            class="edit-button btn btn-outline-warning waves-effect waves-light btn-sm"
                                                            data-id="{{ $faq->id }}"
                                                            data-for="{{ $faq->faq_for }}"
                                                            data-question="{{ $faq->question }}"
                                                            data-ans="{{ $faq->answer }}"
                                                        > <i class="fa fa-edit"></i> </button>
                                                        <button
                                                            data-question="{{ $faq->question }}"
                                                            data-ans="{{ $faq->answer }}"
                                                            class="dlt-btn btn btn-outline-danger waves-effect waves-light btn-sm"
                                                        >
                                                            <i class="fa fa-eye"></i>
                                                        </button>
                                                        <a href="{{ route('admin.servicedetails.destroy', $faq->id) }}" class="btn btn-danger waves-effect waves-light  delete-submit-button btn-sm" ><i class="fa fa-trash"></i></a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="service_provider" role="tabpanel" aria-labelledby="service_provider-tab">
                                    <h5 class="card-title">{{ __('Service provider Service Details') }}</h5>
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead class="thead-success shadow-success">
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">{{ __('Details') }}</th>
                                                <th scope="col">{{ __('Action') }}</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach ($serviceprovider_faq as $faq)
                                                <tr>
                                                    <td scope="row">{{ $loop->iteration }}</td>
                                                    <td>
                                                        <h5>{{ $faq->question }}</h5>
                                                        {{ Str::limit($faq->answer, 100) }}
                                                    </td>
                                                    <td>
                                                        <button
                                                            type="button"
                                                            id="edit"
                                                            class="edit-button btn btn-outline-warning waves-effect waves-light btn-sm"
                                                            data-id="{{ $faq->id }}"
                                                            data-for="{{ $faq->faq_for }}"
                                                            data-question="{{ $faq->question }}"
                                                            data-ans="{{ $faq->answer }}"
                                                        > <i class="fa fa-edit"></i> </button>
                                                        <button
                                                            data-question="{{ $faq->question }}"
                                                            data-ans="{{ $faq->answer }}"
                                                            class="dlt-btn btn btn-outline-danger waves-effect waves-light btn-sm"
                                                        >
                                                            <i class="fa fa-eye"></i>
                                                        </button>
                                                        <a href="{{ route('admin.servicedetails.destroy', $faq->id) }}" class="btn btn-danger waves-effect waves-light  btn-sm" ><i class="fa fa-trash"></i></a>
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
{{--    Edit Modal--}}
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
                            <label class="">{{ __('Service Details for') }}</label>
                            <select class="form-control" name="faq-for" id="faq-for" required="">
                                <option value="">Select</option>
                                <option value="customer">Customer</option>
                                <option value="marketer">Marketer</option>
                                <option value="service provider">Service Provider</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="">{{ __('Title') }}</label>
                            <input type="text" class="form-control" name="faq-question" id="faq-question" required="">
                        </div>
                        <div class="form-group">
                            <label class="">{{ __('Description') }}</label>
                            <input type="hidden" id="faq-id">
                            <textarea class="form-control" name="faq-answer" id="faq-answer" required=""></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer" id="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" ><i class="fa fa-times"></i> {{ __('Close') }}</button>
                    <button type="button" class="btn btn-primary" id="add-submit-button"><i class="fa fa-check-square-o"></i> {{ __('Add new Service Details') }}</button>
                    <button type="button" class="btn btn-primary" id="edit-submit-button"><i class="fa fa-check-square-o"></i> {{ __('Edit Service Details') }}</button>
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
                    <h5 id="question_view"></h5>
                    <hr>
                    <p id="ans_view"></p>
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
               $('#modal-title').html('Add a new Service Details');
               $('#faq-for').val('');
               $('#faq-question').val('');
               $('#faq-answer').val('');
           });

           //Submit new
           $('#add-submit-button').click(function(){
               var faq_for = $('#faq-for').val();
               var faq_question = $('#faq-question').val();
               var faq_answer = $('#faq-answer').val();
               $.ajax({
                   method: 'POST',
                   url: '/admin/page/service/details/store',
                   headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                   data: { faq_for: faq_for, faq_question: faq_question, faq_answer: faq_answer},
                   dataType: 'JSON',
                   success: function (data) {
                       $('#modal').modal('hide');
                       $('#faq-for').val('');
                       $('#faq-question').val('');
                       $('#faq-answer').val('');
                       Swal.fire({
                           position: 'top-end',
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
                $('#modal-title').html('Edit Service Details');
                $('#add-submit-button').hide();
                $('#edit-submit-button').show();
                $( "#faq-for option:selected" ).text($(this).data('for'));
                $('#faq-question').val($(this).data('question'));
                $('#faq-answer').val($(this).data('ans'));
                $('#faq-id').val($(this).data('id'));
            });

            //Submit edited
            $('#edit-submit-button').click(function(){
                var faq_id = $('#faq-id').val();
                var faq_for = $('#faq-for').val();
                var faq_question = $('#faq-question').val();
                var faq_answer = $('#faq-answer').val();
                $.ajax({
                    method: 'POST',
                    url: '/admin/page/service/details/update',
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    data: { faq_id: faq_id,faq_for: faq_for, faq_question: faq_question, faq_answer: faq_answer},
                    dataType: 'JSON',
                    success: function (data) {
                        $('#modal').modal('hide');
                        $('#faq-for').val('');
                        $('#faq-question').val('');
                        $('#faq-answer').val('');
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: 'Successfully edited '+data.question,
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
            $(".dlt-btn").click(function(){
                $('#view').modal('show');
                $('#view-modal-title').html('View Service Details');
                var question = $(this).data("question");
                var ans = $(this).data("ans");

                $("#question_view").html(question);
                $("#ans_view").html(ans);
            })
        });
    </script>
@endsection
@push('foot')

@endpush
