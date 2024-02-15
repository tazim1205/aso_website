@extends('controller.layout.app')
@push('title') {{ __('Ads') }} @endpush
@push('head')
<!--Bootstrap Datepicker-->
<link href="{{ asset('assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet"
    type="text/css">
@endpush
@section('content')
<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="row pt-2 pb-2">

                    <div class="col-md-12">
                        <div class="float-right mb-1">
                            <button type="button" class="btn btn-outline-primary" data-toggle="modal"
                                    data-target="#new_create">
                                <i class="fa fa-plus"></i>
                                Add new Ads
                            </button>
                            <!-- Add Model Start -->
                            <div class="modal fade" id="new_create" tabindex="-1" role="dialog"
                                 aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">
                                                Add new Ads
                                            </h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>

                                        <div class="modal-body">
                                            <form>
                                                <input type="hidden" id="ads-id">
                                                <div class="form-group">
                                                    <label for="image" class="col-form-label">Image</label>
                                                    <input type="file" class="form-control"
                                                           onchange="document.getElementById('blah2').src = window.URL.createObjectURL(this.files[0])"
                                                           id="image">
                                                    <img src="../assets/images/portfolio/portfolio-1.jpg" id="blah2" width="200"
                                                         alt="">
                                                </div>
                                                <div class="form-group">
                                                    <label for="s_date" class="col-form-label">Start Date</label>
                                                    <input type="date" class="form-control" id="starting-date">
                                                </div>
                                                <div class="form-group">
                                                    <label for="end_date" class="col-form-label">End Date</label>
                                                    <input type="date" class="form-control" id="ending-date">
                                                </div>
                                                <div class="form-group">
                                                    <label for="url" class="col-form-label">Url</label>
                                                    <input type="url" placeholder="Enter Url"
                                                           class="form-control" id="url">
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value="" id="activation">
                                                    <label class="form-check-label" for="defaultCheck3">
                                                        Active
                                                    </label>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">Close</button>
                                                    <button type="button" class="btn btn-primary" id="add-submit-button">Save</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Add Model End -->
                        </div>
                    </div>

            </div>
            <div class="content-body  container-fluid">
                <!-- Minimal statistics section start -->
                <section id="minimal-statistics">
                    <div class="row">
                        @foreach(auth()->user()->controllerActiveAds as $ads)
                        <div class="col-md-4">
                            <div class="card" style="width: 18rem;">
                                <img class="card-img-top" src="{{ asset($ads->image) }}"
                                    alt="Card image cap">
                                <div class="card-body">
                                    <h5 class="card-title">title</h5>
                                    <p class="card-text">Some quick example text to build on the card title and make up
                                        the bulk of the card's content.</p>
                                </div>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item">
                                        Status
                                        <span class="float-right">
                                            @if($ads->status == 0)
                                            Inactive
                                            @elseif($ads->starting < \Carbon\Carbon::today()->addDays(1) && $ads->ending > \Carbon\Carbon::today()->addDays(-1))
                                            Running
                                            @else
                                            Completed
                                            @endif
                                        </span>
                                    </li>
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
                                    <a @if($ads->url) href="{{ $ads->url }}" target="_blank" @else  href="#" @endif class="">
                                        <span class="fa fa-share-alt"></span>
                                        Ads. Link
                                    </a>
                                    <input type="hidden" class="hidden-url" value="{{ $ads->url }}">
                                    <input type="hidden" class="hidden-id" value="{{ $ads->id }}">
                                    <input type="hidden" class="hidden-start" value="{{ $ads->starting }}">
                                    <input type="hidden" class="hidden-end" value="{{ $ads->ending }}">
                                    <a href="#" class="edit-button mx-1" data-toggle="modal" data-target="#edit">
                                        <span class="fa fa-edit"></span>
                                        Edit
                                    </a>
                                    <a href="{{ route('controller.ads.disabled', $ads->id) }}" class="">
                                        <span class="fa fa-trash"></span>
                                        Delete
                                    </a>
                                </div>
                            </div>
                        </div>
                        @endforeach




                    </div>
                    <h1>Deactive ADS</h1>
                    <hr>
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-head">
                                    <div class="card-header">
                                        <h4 class="card-title">Ads Table</h4>
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
                                                   class="table table-white-space table-bordered table-striped row-grouping display no-wrap icheck table-middle">
                                                <thead>
                                                <tr>
                                                    <th>No.</th>
                                                    <th>Image</th>
                                                    <th>Title</th>
                                                    <th>Starting</th>
                                                    <th>Ending</th>
                                                    <th>Status</th>
                                                    <th>Actions</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach(auth()->user()->controllerInactiveAds as $notice)
                                                    <tr>
                                                        <td> {{ $loop->iteration }}</td>
                                                        <td>
                                                            <img class="card-img-top" src="{{ asset($notice->image) }}"
                                                                 alt="Card image cap">
                                                        </td>
                                                        <td>
                                                            title
                                                        </td>
                                                        <td>
                                                            <span>{{ $notice->starting  }}</span>
                                                        </td>
                                                        <td>
                                                            <span>{{ $notice->ending }}</span>
                                                        </td>

                                                        <td>
                                                            <span>
                                                                @if($notice->status == 0)
                                                                    Inactive
                                                                @elseif($notice->starting < \Carbon\Carbon::today()->addDays(1) && $notice->ending > \Carbon\Carbon::today()->addDays(-1))
                                                                    Running
                                                                @else
                                                                    Completed
                                                                @endif
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <input type="hidden" class="hidden-id" value="{{ $notice->id }}">
                                                            <span class="dropdown">
                                                                <button id="btnSearchDrop12" type="button"
                                                                        class="btn btn-sm btn-icon btn-pure font-medium-2"
                                                                        data-toggle="dropdown" aria-haspopup="true"
                                                                        aria-expanded="false">
                                                                    <i class="ft-more-vertical"></i>
                                                                </button>

                                                                <span aria-labelledby="btnSearchDrop12"
                                                                      class="dropdown-menu dropdown-menu-button">
                                                                    <a href="{{ route('controller.ads.enable', $notice->id) }}" class="dropdown-item">
                                                                        <i class="ft-check-circle"></i>
                                                                        Active
                                                                    </a>
                                                                    <a href="{{ route('controller.ads.delete', $notice->id) }}" class="dropdown-item">
                                                                        <i class="ft-trash"></i>
                                                                        Delete
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
                </section>
                <!-- // Minimal statistics section end -->
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
                                <form>
                                    <input type="hidden" id="ads-id">
                                    <div class="form-group">
                                        <label for="image" class="col-form-label">Image</label>
                                        <input type="file" class="form-control"
                                            onchange="document.getElementById('blah2').src = window.URL.createObjectURL(this.files[0])"
                                            id="image">
                                        <img src="../assets/images/portfolio/portfolio-1.jpg" id="blah2" width="200"
                                            alt="">
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
                                        <input type="url" placeholder="Enter Url"
                                            class="form-control" id="url">
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="activation">
                                        <label class="form-check-label" for="defaultCheck3">
                                            Active
                                        </label>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-dismiss="modal">Close</button>
                                        <button type="button" class="btn btn-primary" id="edit-submit-button">Save</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Edit Model End -->
            </div>
        </div>
    </div>
</div>
<!-- END: Main Content end-->
<!-- Edit Modal -->


@endsection
@push('foot')
<!--Bootstrap Datepicker Js-->
<script src="{{ asset('assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
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
            $('#url').val($('.hidden-url').val());
            $('#s_date').val($('.hidden-start').val());
            $('#end_date').val($('.hidden-end').val());
            $('#ads-id').val($('.hidden-id').val());
            console.log($('.hidden-url').val());
        });

        //Submit edited category
        $('#edit-submit-button').click(function(){
            var formData = new FormData();
            formData.append('id', $('#ads-id').val())
            formData.append('url', $('#url').val())
            formData.append('startingDate', $('#s_date').val())
            formData.append('endingDate', $('#end_date').val())
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

@endpush
