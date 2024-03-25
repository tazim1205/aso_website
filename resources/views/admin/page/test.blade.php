@extends('admin.layout.app')
@push('title')
    {{ __('Video Training') }}
@endpush
@section('content')

    <div class="content-wrapper">
        <div class="container-fluid">
            <!-- Breadcrumb-->
            <div class="row pt-2 pb-2">
                <div class="col-sm-9">
                    <h4 class="page-title">{{ __('Training Videos') }} </h4>
                </div>
                <div class="col-md-3">
                    <div class="float-right mb-1">
                        <button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#new_create" id="add-new">
                            <i class="fa fa-plus"></i>
                            Add new Video
                        </button>
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
                                        Customer Training Videos
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="marketer-tab" data-toggle="tab" href="#marketer" role="tab" aria-controls="marketer" aria-selected="false">
                                        Marketer Training Videos
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="service_provider-tab" data-toggle="tab" href="#service_provider" role="tab" aria-controls="service_provider" aria-selected="false">
                                        Service provider Training Videos
                                    </a>
                                </li>
                            </ul>
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active" id="customer" role="tabpanel" aria-labelledby="customer-tab">
                                    <!-- <h5 class="card-title">{{ __('Customer Training Videos Details') }}</h5> -->
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead class="thead-success shadow-success">
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">{{ __('Link') }}</th>
                                                <th scope="col">{{ __('Title') }}</th>
                                                <th scope="col">{{ __('Status') }}</th>
                                                <th scope="col">{{ __('Action') }}</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($customer as $c)
                                                    <tr>
                                                        <td scope="row">{{ $loop->iteration }}</td>
                                                        <td>
                                                            <h5>{!! $c->link !!}</h5>
                                                        </td>
                                                        <td>
                                                            <h5>{{ $c->title }}</h5>
                                                        </td>
                                                        <td>
                                                            @if($c->status == 1)
                                                            <span class="btn btn-success btn-sm">Active</span>
                                                            @else
                                                            <span class="btn btn-danger btn-sm">Inactive</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <input type="hidden" class="hidden-url" value="{{ $c->link }}">
                                                            <input type="hidden" class="hidden-id" value="{{ $c->id }}">
                                                            <input type="hidden" class="hidden-title" value="{{ $c->title }}">
                                                            <input type="hidden" class="hidden-video_for" value="{{ $c->video_for }}">
                                                            <a
                                                                href="javascript:void();"
                                                                class="card-link edit-button"
                                                                data-toggle="modal"
                                                                data-target="#new_create"
                                                            >Edit Now</a>
                                                            <a href="javascript:void();" id="{{ $c->id }}" class="card-link text-danger delete-button">Delete</a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="marketer" role="tabpanel" aria-labelledby="marketer-tab">
                                    <!-- <h5 class="card-title">{{ __('Marketer Service Details') }}</h5> -->
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead class="thead-success shadow-success">
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">{{ __('Link') }}</th>
                                                <th scope="col">{{ __('Title') }}</th>
                                                <th scope="col">{{ __('Status') }}</th>
                                                <th scope="col">{{ __('Action') }}</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($marketer as $m)
                                                    <tr>
                                                        <td scope="row">{{ $loop->iteration }}</td>
                                                        <td>
                                                            <h5>{!! $m->link !!}</h5>
                                                        </td>
                                                        <td>
                                                            <h5>{{ $m->title }}</h5>
                                                        </td>
                                                        <td>
                                                            @if($m->status == 1)
                                                            <span class="btn btn-success btn-sm">Active</span>
                                                            @else
                                                            <span class="btn btn-danger btn-sm">Inactive</span>
                                                            @endif
                                                        </td>
                                                        
                                                        <td>
                                                            <input type="hidden" class="hidden-url" value="{{ $m->link }}">
                                                            <input type="hidden" class="hidden-id" value="{{ $m->id }}">
                                                            <input type="hidden" class="hidden-title" value="{{ $m->title }}">
                                                            <input type="hidden" class="hidden-video_for" value="{{ $m->video_for }}">
                                                            <a
                                                                href="javascript:void();"
                                                                class="card-link edit-button"
                                                                data-toggle="modal"
                                                                data-target="#new_create"
                                                            >Edit Now</a>

                                                            <a href="javascript:void();" id="{{ $m->id }}" class="card-link text-danger delete-button">Delete</a>


                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="service_provider" role="tabpanel" aria-labelledby="service_provider-tab">
                                    <!-- <h5 class="card-title">{{ __('Service provider Service Details') }}</h5> -->
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead class="thead-success shadow-success">
                                                <tr>
                                                    <th scope="col">#</th>
                                                    <th scope="col">{{ __('Link') }}</th>
                                                    <th scope="col">{{ __('Title') }}</th>
                                                    <th scope="col">{{ __('Status') }}</th>
                                                    <th scope="col">{{ __('Action') }}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($service_provider as $worker)
                                                    <tr>
                                                        <td scope="row">{{ $loop->iteration }}</td>
                                                        <td>
                                                            <h5>{!! $worker->link !!}</h5>
                                                        </td>
                                                        <td>
                                                            <h5>{{ $worker->title }}</h5>
                                                        </td>
                                                        <td>
                                                            @if($worker->status == 1)
                                                            <span class="btn btn-success btn-sm">Active</span>
                                                            @else
                                                            <span class="btn btn-danger btn-sm">Inactive</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <input type="hidden" class="hidden-url-{{$worker->id}}" value="{{ $worker->link }}">
                                                            <input type="hidden" class="hidden-id-{{$worker->id}}" value="{{ $worker->id }}">
                                                            <input type="hidden" class="hidden-title-{{$worker->id}}" value="{{ $worker->title }}">
                                                            <input type="hidden" class="hidden-video_fo-{{$worker->id}}r" value="{{ $worker->video_for }}">
                                                            <a
                                                            onclick="editData({{$worker->id}})"
                                                                href="javascript:void();"
                                                                class="card-link "
                                                                data-toggle="modal"
                                                                data-target="#new_create"
                                                            >Edit Now</a>
                                                            <a href="javascript:void();" id="{{ $worker->id }}" class="card-link text-danger delete-button">Delete</a>
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
    <div class="modal fade" id="new_create" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-title">
                        Add a new video
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>

                <div class="modal-body">
                    <form action="#" id="add-new-from">
                        <input type="hidden" id="ads-id">
                        <div class="input-group input-group-lg mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Video For</span>
                            </div>
                            <select class="form-control" name="video_for" id="training_video_for">
                                <option value="Customer" selected="">Customer</option>
                                <option value="Worker">Worker</option>
                                <option value="Marketer">Marketer</option>
                            </select>
                        </div>
                        <div class="input-group input-group-lg mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">title</span>
                            </div>
                            <input type="text" class="form-control" name="title" id="title">
                        </div>
                        <div class="input-group input-group-lg mb-3">
                            <textarea rows="4" class="form-control detail" id="detail" placeholder="youtube embedded code here...."></textarea>
                        </div>
                        <div class="input-group input-group-lg mb-3">
                            <input type="checkbox" id="activation" value="" class="filled-in chk-col-success">
                            <label for="activation" class="btn-round btn-danger waves-effect waves-light">{{ __('Is activated !!!!') }}</label>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" id="add-submit-button"><i class="fa fa-check-square-o"></i>{{ __(' Add new video') }}</button>
                            <button type="button" class="btn btn-primary" id="edit-submit-button"><i class="fa fa-check-square-o"></i>{{ __(' Edit video') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Add Model End -->






@endsection
@push('foot')

<script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>


<script>
    function editData(id)
        {
            // alert($('.hidden-title-'+id).val());
            $('#new_create').modal('show');
            $('#modal-title').html('Edit ads.');
            $('#add-submit-button').hide();
            $('#edit-submit-button').show();
            
            $('#detail').val($('.hidden-url-'+id).val());
            $('#title').val($('.hidden-title-'+id).val());
            $('#ads-id').val($('.hidden-id-'+id).val());
            var option = $('.video_for-'+id).text();
            $('#video_for').attr("selected",true)
            $('#video_for').find('option:contains('+option+')').attr("selected",true);
        }
</script>

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
                $('#new_create').modal('show');
                $('#add-submit-button').show();
                $('#edit-submit-button').hide();
                $('#modal-title').html('Add a new video');
                $('#training_video_for').val('');
                $('#detail').val('');
                $('#title').val('');
            });

            //Submit new category
            $('#add-submit-button').click(function(){
                var formData = new FormData();
                formData.append('title', $('#title').val())
                formData.append('video_for', $('#training_video_for').val())
                formData.append('detail', $('#detail').val())
                formData.append('activation', $('#activation').val())
                $.ajax({
                    method: 'POST',
                    url: '{{ route('admin.page.training-video.store') }}',
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (data) {
                        $('#modal').modal('hide');
                        $('#title').val('');
                        $('#detail').val('');
                        $('#activation').val('');
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: 'Successfully add new video',
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
                // alert($('.hidden-title').val());
                // $('#new_create').modal('show');
                // $('#modal-title').html('Edit ads.');
                // $('#add-submit-button').hide();
                // $('#edit-submit-button').show();
                // let id = $('.hidden-id').val();
                // alert(id);
                // $('#detail').val($('.hidden-url').val());
                // $('#title').val($('.hidden-title').val());
                // $('#ads-id').val($('.hidden-id').val());
                // var option = $('.video_for').text();
                // $('#video_for').attr("selected",true)
                // $('#video_for').find('option:contains('+option+')').attr("selected",true);
            });


            

            //Submit edited category
            $('#edit-submit-button').click(function(){
                var formData = new FormData();
                formData.append('id', $('#ads-id').val())
                formData.append('detail', $('#detail').val())
                formData.append('title', $('#title').val())
                formData.append('video_for', $('#training_video_for').val())
                formData.append('activation', $('#activation').val())
                $.ajax({
                    method: 'POST',
                    url: '{{ route('admin.page.training-video.update') }}',
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (data) {
                        $('#modal').modal('hide');
                        $('#title').val('');
                        $('#detail').val('');
                        $('#activation').val('');
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: 'Successfully edited video',
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
                    url: '{{ route('admin.page.training-video.delete') }}',
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (data) {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'danger',
                            title: 'Successfully deleted video',
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
