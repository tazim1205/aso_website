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
                        <li class="breadcrumb-item active" aria-current="page">{{ __('complete') }}</li>
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
                                        <label>{{ __('Paid Date') }}</label>
                                        <input value="" type="datetime-local" name="paid_date" class="form-control paid_date" required="">
                                        <br>
                                        <label>{{ __('Paid Via') }}</label>
                                        <input value="" type="text" name="paid_via" class="form-control paid_via" required="">
                                        <br>
                                        <label>{{ __('Company A/C') }}</label>
                                        <input value="" type="text" name="c_ac" class="form-control c_ac" required="">
                                        <br>
                                        <label>{{ __('Company A/C Details') }}</label>
                                        <input value="" type="text" name="c_ac_details" class="form-control c_ac_details" required="">
                                        <br>
                                        <label>{{ __('Transaction Info') }}</label>
                                        <input value="" type="text" name="transaction_id" class="form-control transaction_id" required="">
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

            formData.append('transaction_id', $('#main-form').find('.transaction_id').val());
            formData.append('c_ac_details', $('#main-form').find('.c_ac_details').val());
            formData.append('paid_via', $('#main-form').find('.paid_via').val());
            formData.append('paid_date', $('#main-form').find('.paid_date').val());
            formData.append('transaction_id', $('#main-form').find('.transaction_id').val()); 
            formData.append('id', id);

            var this_button = $(this);
            $.ajax({
                method: 'POST',
                url: "{{ route('marketing_panel.witdraw.complete.submit') }}",
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
