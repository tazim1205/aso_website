@extends('customer.layout.master')
@push('title') {{ __('Help Line Number') }} @endpush
@push('head')

@endpush
@section('content')
    {{-- New Code --}}

<div class="my-container">

    <div class="video-trai-1 vt">
        <div class="center">
            <h3>HELP LINE NUMBER</h3>
        </div>
        <div>
            <div class="login-form help-line">
                <form>

                    <select name="district_id_for_helpline" id="district_id_for_helpline">
                        <option disabled selected>Select জেলা</option>
                        @foreach(App\District::all() as $row)
                        <option value="{{ $row->id }}">{{ __($row->name) }}</option>
                        @endforeach                       
                    </select>


                    <select name="upazila_id_for_helpline" id="upazila_id_for_helpline">
                        <option disabled selected>Select উপজেলা /মেট্রোপলিটন থানা</option>
                        @foreach(App\Upazila::all() as $row)
                        <option value="{{ $row->id }}">{{ __($row->name) }}</option>
                        @endforeach
                    </select>
                </form>

            </div>

            <div class="help-1" id="filterDiv">
                
            </div>

        </div>




    </div>
    {{-- New code --}}
    
@endsection

@push('foot')
    <script type="text/javascript">
        $(document).ready(function() {
    
                function filter(district,upazila,filterFor = 'Customer'){
                    $.ajax({
                        url: "{{  url('/customer/filter/helpline/') }}/"+filterFor+"/"+district+"/"+upazila,
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
    
                    var district_id = $(this).val();
                    if(district_id) {
                        $.ajax({
                            url: "{{  url('/get/district/upazila/') }}/"+district_id,
                            type:"GET",
                            dataType:"json",
                            success:function(data) {
                                var d =$('#upazila_id_for_helpline').empty();
                                $.each(data, function(key, value){
                                   $('#upazila_id_for_helpline').append('<option value="'+ value.id +'">' + value.name + '</option>');
                                });
                            },
                            
                        });
                    }
                });
    
                $('#upazila_id_for_helpline').on('change', function(e){
                    e.preventDefault();
    
                    var district = $('#district_id_for_helpline').val();
                    var upazila = $(this).val();
                    filter(district,upazila);
                });
    
            });
    
    </script>
@endpush
