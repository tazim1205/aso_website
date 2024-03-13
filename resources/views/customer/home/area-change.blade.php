@extends('customer.layout.app')
@push('title')  {{ __('My Area') }} @endpush
@push('head')

@endpush
@section('content')

    <!-- Start title -->
    <div class="container text-center">
        <button type="button" class="mb-2 btn btn-success mt-4">{{ __('Service Area') }}</button>
    </div>


    <!-- Start worker's bid of this area-->
    <div class="container">
        <div class="row">
            <div class="col-12 px-0 text-center">
                <form action="{{ route('customer.changeArea') }}" method="POST" class="row">
                    @csrf
                    <div class="col-lg-4"></div>
                    <div class="col-lg-4 form-group mt-3">
                        <select class="form-control" name="district_id" id="district_id" required="">
                            <option value="">{{ __('জেলা নির্বাচন') }}</option>
                            @foreach($district as $row)
                            <option value="{{ $row->id }}" <?php if ($row->id == $user->district_id) {
                                echo "selected";
                            } ?> >{{ __($row->name) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-4"></div>
                    <div class="col-lg-4"></div>
                    <div class="col-lg-4 form-group mt-3">
                        <select class="form-control" name="upazila_thana_id" id="upazila_thana_id" required="">
                            <option value="">{{ __('Select Upazila / Thana') }}</option>
                            @foreach($upazila as $row)
                            <option value="{{ $row->id }}" <?php if ($row->id == $user->upazila_id) {
                                echo "selected";
                            } ?> >{{ __($row->name) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-4"></div>
                    <div class="col-lg-4"></div>
                    <div class="col-lg-4 form-group mt-3">
                        <select class="form-control" name="pouroshava_union_id" id="pouroshava_union_id" required="">
                            <option value="">{{ __('Select Pouroshava / Union') }}</option>
                            @foreach($puroshova as $row)
                            <option value="{{ $row->id }}" <?php if ($row->id == $user->pouroshova_union_id) {
                                echo "selected";
                            } ?> >{{ __($row->name) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-4"></div>
                    <div class="col-lg-4"></div>
                    <div class="col-lg-4 form-group mt-3">
                        <select class="form-control" name="word_road_id" id="word_road_id" required="">
                            <option value="">{{ __('Select Ward / Road') }}</option>
                            @foreach($word as $row)
                            <option value="{{ $row->id }}" <?php if ($row->id == $user->word_road_id) {
                                echo "selected";
                            } ?> >{{ __($row->name) }}</option>
                            @endforeach
                        </select>

                        <div class="form-group mt-3">
                            <textarea name="location" placeholder="Your Location Link" id="" class="form-control form-control-lg" rows="2">{{ auth()->user()->location }}</textarea>
                        </div>
                    </div>

                    <div class="col-lg-4"></div>
                    <div class="col-lg-4"></div>
                    <div class="col-lg-4 form-group mt-3">
                        <button type="submit" class="btn btn-success">Save Change</button>
                    </div>
                    <div class="col-lg-4"></div>
                </form>
            </div>
        </div>
    </div>
    <!-- End worker's bid of this area-->

    <div class="modal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Modal title</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p>Modal body text goes here.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>

    <script>
        const myModal = document.getElementById('myModal')
const myInput = document.getElementById('myInput')

myModal.addEventListener('shown.bs.modal', () => {
  myInput.focus()
})
    </script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('select[name="district_id"]').on('change', function(){
                var district_id = $(this).val();
                if(district_id) {
                    $.ajax({
                        url: "{{  url('/get/district/upazila/') }}/"+district_id,
                        type:"GET",
                        dataType:"json",
                        success:function(data) {
                            var d =$('select[name="upazila_thana_id"]').empty();
                            $.each(data, function(key, value){
                               $('select[name="upazila_thana_id"]').append('<option value="'+ value.id +'">' + value.name + '</option>');
                            });
                        },

                    });
                } else {
                    alert('danger');
                }
            });

            $('select[name="upazila_thana_id"]').on('change', function(){
                var upazila_thana_id = $(this).val();
                if(upazila_thana_id) {
                    $.ajax({
                        url: "{{  url('/get/upazila/pouroshava-union/') }}/"+upazila_thana_id,
                        type:"GET",
                        dataType:"json",
                        success:function(data) {
                            var d =$('select[name="pouroshava_union_id"]').empty();
                            $.each(data, function(key, value){
                               $('select[name="pouroshava_union_id"]').append('<option value="'+ value.id +'">' + value.name + '</option>');
                            });
                        },

                    });
                } else {
                    alert('danger');
                }
            });

            $('select[name="pouroshava_union_id"]').on('change', function(){
                var pouroshava_union_id = $(this).val();
                if(pouroshava_union_id) {
                    $.ajax({
                        url: "{{  url('/get/pouroshava-union/word-road/') }}/"+pouroshava_union_id,
                        type:"GET",
                        dataType:"json",
                        success:function(data) {
                            var d =$('select[name="word_road_id"]').empty();
                            $.each(data, function(key, value){
                               $('select[name="word_road_id"]').append('<option value="'+ value.id +'">' + value.name + '</option>');
                            });
                        },

                    });
                } else {
                    alert('danger');
                }
            });
        });

    </script>
@endsection
