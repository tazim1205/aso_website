@extends('marketing_panel.layout.app')
    @push('head')
        <!--Bootstrap Datepicker-->
        <link href="{{ asset('assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet" type="text/css">
    @endpush
@section('content')
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
        @foreach($allads as $ads)
        <div class="col-md-4">
            <div class="card" style="width: 18rem;">
                <img class="card-img-top" src="{{ asset($ads->image) }}" alt="Card image cap">
                <div class="card-body">
                    <h5 class="card-title">{{ $ads->title }}</h5>
                    <p class="card-text">{{ $ads->description }}</p>
                </div>
                <ul class="list-group list-group-flush">
                    @if($ads->status == 0)
                    <li class="list-group-item">
                        Status
                        <span class="float-right">InActive</span>
                    </li>
                    @elseif($ads->starting < \Carbon\Carbon::today()->addDays(1) && $ads->ending > \Carbon\Carbon::today()->addDays(-1))
                    <li class="list-group-item">
                        Status
                        <span class="float-right">Running</span>
                    </li>
                    @else
                        <li class="list-group-item">
                            Status
                            <span class="float-right">Complete</span>
                        </li>
                    @endif
                    <li class="list-group-item">
                        Starting
                        <span class="float-right">{{ $ads->starting  }}</span>
                    </li>
                    <li class="list-group-item">
                        Ending
                        <span class="float-right">{{ $ads->ending }}</span>
                    </li>
                    <li class="list-group-item">
                        Create at
                        <span class="float-right">{{ date('d/m/Y h-m-s', strtotime($ads->created_at)) }}</span>
                    </li>
                </ul>
                <div class="card-body">
                    <input type="hidden" class="hidden-url" value="{{ $ads->url }}">
                    <input type="hidden" class="hidden-id" value="{{ $ads->id }}">
                    <div class="d-flex justify-content-between">
                        <a @if($ads->url) href="{{ $ads->url }}" target="_blank" @else  href="#" @endif class="">
                            <span class="fa fa-share-alt"></span>
                            Ads. Link
                        </a>

                        <a
                            href="#"
                            class="float-right edit-button"
                            data-toggle="modal"
                            data-target="#edit"
                            data-title="{{ $ads->title }}"
                            data-description="{{ $ads->description }}"
                            data-id="{{ $ads->id }}"
                            data-url="{{ $ads->url }}"
                            data-start="{{ $ads->starting  }}"
                            data-end="{{ $ads->ending }}"
                            data-status="{{ $ads->status }}"
                        >
                            <span class="fa fa-edit"></span>
                            Edit
                        </a>
                        <a href="javascript:void();" id="{{ $ads->id }}" class="card-link text-danger delete-button">{{ __('Delete') }}</a>
                    </div>
                </div>
            </div>
        </div>
        @endforeach


    </div>
    <!-- Modal -->
    <!-- Edit Model -->
    <div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                        Edit new ads.
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <form action="#" method="POST">
                        <div class="form-group">
                            <label for="image" class="col-form-label">Image</label>
                            <input type="file" class="form-control"
                                   onchange="document.getElementById('blah2').src = window.URL.createObjectURL(this.files[0])"
                                   id="image">
                            <img src="../assets/images/portfolio/portfolio-1.jpg" id="blah2" width="200" alt="">
                        </div>
                        <div class="form-group">
                            <label for="title" class="col-form-label">Title</label>
                            <input type="text"  placeholder="Enter title" class="form-control" id="title">
                        </div>
                        <div class="form-group">
                            <label for="description" class="col-form-label">Description</label>
                            <textarea name="description" id="description" cols="30" rows="10" placeholder="Enter Description" class="form-control"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="s_date" class="col-form-label">Start Date</label>
                            <input type="date" class="form-control" id="s_date">
                        </div>
                        <div class="form-group">
                            <label for="end_date" class="col-form-label">End Date</label>
                            <input type="date" class="form-control" id="end_date">
                        </div>
                        <div class="form-group">
                            <label for="url" class="col-form-label">Url</label>
                            <input type="url" value="https://www.shwapno.com" placeholder="Enter Url" class="form-control" id="url">
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="status"
                                   checked="">
                            <label class="form-check-label" for="status">
                                Active
                            </label>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary"
                                    data-dismiss="modal">Close</button>
                            <input type="hidden" name="ads-id" id="ads-id">
                            <button type="button" class="btn btn-primary" id="add-submit-button"><i class="fa fa-check-square-o"></i>{{ __(' Add new ads.') }}</button>
                            <button type="button" class="btn btn-primary" id="edit-submit-button"><i class="fa fa-check-square-o"></i>{{ __(' Edit ads.') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Edit Model End -->
    <!-- Edit Modal -->


@endsection
@push('foot')
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
                $('#edit').modal('show');
                $('#edit-submit-button').hide();
                $('#add-submit-button').show();
                $('.modal-title').html('Add a new ads.');
                $('#url').val('');
                $('#title').val('');
                $('#description').val('');
                $('#s_date').val('');
                $('#end_date').val('');
                $('#activation').val('');
                $('#image').val('');
            });

            //Submit new category
            $('#add-submit-button').click(function(){
                var formData = new FormData();
                formData.append('url', $('#url').val())
                formData.append('title', $('#title').val())
                formData.append('description', $('#description').val())
                formData.append('startingDate', $('#s_date').val())
                formData.append('endingDate', $('#end_date').val())
                formData.append('activation', $('#activation').val())
                formData.append('image', $('#image')[0].files[0])
                $.ajax({
                    method: 'POST',
                    url: '{{ route('marketing_panel.ads.store') }}',
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
                        console.log(data);
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
                $('#edit').modal('show');
                $('.modal-title').html('Edit ads.');
                $('#add-submit-button').hide();
                $('#edit-submit-button').show();
                $('#url').val($(this).data("url"));
                $('#s_date').val($(this).data("start"));
                $('#end_date').val($(this).data("end"));
                $('#ads-id').val($(this).data("id"));
                $('#status').val($(this).data("status"));
                $('#title').val($(this).data("title"));
                $('#description').val($(this).data("description"));
            });

            //Submit edited category
            $('#edit-submit-button').click(function(){
                var formData = new FormData();
                formData.append('id', $('#ads-id').val())
                formData.append('url', $('#url').val())
                formData.append('title', $('#title').val())
                formData.append('description', $('#description').val())
                formData.append('startingDate', $('#s_date').val())
                formData.append('endingDate', $('#end_date').val())
                formData.append('activation', $('#status').val())
                formData.append('image', $('#image')[0].files[0])
                $.ajax({
                    method: 'POST',
                    url: '{{ route('marketing_panel.ads.update') }}',
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (data) {
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

            $('.delete-button').click(function(){
                var formData = new FormData();
                formData.append('id', $(this).attr("id"))
                $.ajax({
                    method: 'POST',
                    url: '{{ route('marketing_panel.ads.delete') }}',
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
