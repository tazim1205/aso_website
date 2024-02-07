@extends('marketer.layout.app')
@push('title') {{ __('Help Line Number') }} @endpush
@push('head')

@endpush
@section('content')
    <div class="container">
        <div class="card shadow mt-4 h-190">
            <div class="card-body">
                <div class="row">
                    <div class="col-12 pl-0 text-center">
                        <button  class="btn btn-success">{{ __('Help Line Number') }}</button>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container top-100">
        <div class="card mb-4 shadow">
            <div class="card-body border-bottom">
                <div class="row">
                    <div class="col-lg-4 col-12"></div>
                    <div class="col-lg-4 mb-2">
                        <select class="form-control" name="district_id_for_helpline" id="district_id_for_helpline" >
                            <option value="">{{ __('Select District') }}</option>
                            @foreach(App\District::all() as $row)
                            <option value="{{ $row->id }}">{{ __($row->name) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-4 col-12"></div>
                    <div class="col-lg-4 col-12"></div>
                    <div class="col-lg-4 mb-2">
                        <select class="form-control" name="upazila_id_for_helpline" id="upazila_id_for_helpline" >
                            <option value="">{{ __('Select Upazila') }}</option>
                            @foreach(App\Upazila::all() as $row)
                            <option value="{{ $row->id }}" >{{ __($row->name) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-4 col-12"></div>
                </div>
                <div class="row" id="filterDiv">
                    
                </div>
            </div>
           
        </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function() {

            function filter(district,upazila){
                $.ajax({
                    url: "{{  url('/filter/helpline/') }}/"+district+"/"+upazila,
                    type:"GET",
                    dataType : 'html',
                    success:function(data) {
                        var d =$('#filterDiv').empty();
                        $('#filterDiv').html(data);
                    },
                });
            }
            

            $('#district_id_for_helpline').on('change', function(e){
                e.preventDefault();

                var district = $(this).val();
                var upazila = $('#upazila_id_for_helpline').val();
                filter(district,upazila);
            });

            $('#upazila_id_for_helpline').on('change', function(e){
                e.preventDefault();

                var district = $('#district_id_for_helpline').val();
                var upazila = $(this).val();
                filter(district,upazila);
            });

        });

    </script>
@endsection

