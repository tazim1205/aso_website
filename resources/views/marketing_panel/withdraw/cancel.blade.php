@extends('marketing_panel.layout.app')
@push('title') {{ __('Dashboard') }} @endpush
@push('head')
    <!-- notifications css -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/notifications/css/lobibox.min.css') }}"/>
    <!-- Vector CSS -->
    <link href="{{ asset('assets/plugins/vectormap/jquery-jvectormap-2.0.2.css') }}" rel="stylesheet"/>
@endpush
@section('content')
    <div class="content-wrapper">
        <div class="container-fluid">
            <!-- Breadcrumb-->
            <div class="row pt-2 pb-2">
                <div class="col-sm-9"> 
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javaScript:void();">{{ __('ashooo') }}</a></li>
                        <li class="breadcrumb-item"><a href="javaScript:void();">{{ __('Witdraw Request') }}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ __('Cancel') }}</li>
                    </ol>
                </div>
            </div>
            <!-- End Breadcrumb-->
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            @include('includes.message')
                        </div>
                        <div class="card-body">
                            <form id="main-form" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-md-6 col-xl-6">
                                        <input class="user_id" type="hidden" value="{{ $witdraw_request->id }}">
                                        <label>{{ __('Cancel Date') }}</label>
                                        <input value="" required type="datetime-local" name="cancel_date" class="form-control cancel_date" >
                                        <br>
                                        <label>{{ __('Cancel Reason') }}</label> 
                                        <textarea class="form-control cancel_reason" name="cancel_reason" cols="30" rows="10"></textarea>
                                        <br>
                                         
                                    </div>
                                     
                                    <br>
                                    <input type="hidden" name="page">
                                    <button  type="submit" class="btn btn-success btn-block waves-effect waves-light mb-1 update-btn">{{ __('Update') }}</button>
                                </div>
                            </form>
                            <br>
                            <br>
                        </div>
                    </div>
                </div>
            </div><!--End Row-->
        </div>
        <!-- End container-fluid-->
    </div>
    <script>
          
        $('.update-btn').click(function(){

            var formData = new FormData();
            var id = $('#main-form').find('.user_id').val();

            formData.append('cancel_reason', $('#main-form').find('.cancel_reason').val());
            formData.append('cancel_date', $('#main-form').find('.cancel_date').val()); 
            formData.append('id', id);

            var this_button = $(this);
            $.ajax({
                method: 'POST',
                url: "{{ route('marketing_panel.cancel.req.submit') }}",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                data: formData,
                processData: false,
                contentType: false,
                beforeSend: function (){
                    this_button.prop("disabled", true)
                },
                complete: function (){
                    this_button.prop("disabled", false)
                },
                success: function (response_data) {
                    if (response_data.type == 'success'){
                        Swal.fire({
                            position: 'top-end',
                            icon: response_data.type,
                            title: response_data.message,
                            showConfirmButton: false,
                            timer: 1500
                        })
                        window.location = "{{ route('marketing_panel.withdraw-request.index') }}"
                    }else{
                        Swal.fire({
                            icon: response_data.type,
                            title: 'Oops...',
                            text: response_data.message,
                        })
                    }
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
    </script> 
@endsection
@push('foot')
    <!-- Vector map JavaScript -->
    <script src="{{ asset('assets/plugins/vectormap/jquery-jvectormap-2.0.2.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/vectormap/jquery-jvectormap-world-mill-en.js') }}"></script>
    <!-- Sparkline JS -->
    <script src="{{ asset('assets/plugins/sparkline-charts/jquery.sparkline.min.js') }}"></script>
    <!-- Chart js -->
    <script src="{{ asset('assets/plugins/Chart.js/Chart.min.js') }}"></script>
    <!--notification js -->
    <script src="{{ asset('assets/plugins/notifications/js/lobibox.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/notifications/js/notifications.min.js') }}"></script>

 


    <!-- Index js -->
    <script src="{{ asset('assets/js/index.js') }}"></script>



    {{-- Datatable init --}}
    <script>
        $(document).ready(function() {
            $('#example').DataTable();
        } ); 
    </script>

    
@endpush
