@extends('customer.layout.master')
@push('title') {{ __('Create Job Post') }} @endpush
@push('head')
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
@endpush
@section('content')
<div class="bid-area">
    <form action="" id="job-form">
        <div class="sub-input">
            <label for="">কাজের টাইটেল</label>
            <input type="text" id="title" placeholder="কাজের টাইটেল">
            <label for="">কাজের বিবরণ...</label>
            <textarea name="" id="description" placeholder="কাজের বিবরণ..." class="kajer-bb"></textarea>
            <label for="">আপনার ঠিকানা</label>
            <input type="text" id="address" placeholder="আপনার ঠিকানা">
            <label for="">কত সময়ের মধ্যে কাজ সম্পন্ন করতে চাচ্ছেন
            </label>
            <input type="text" placeholder="সময়(ঘন্টা)" id="day">

            <div class="new-flex">
                <div class="new-flex-1">
                    <label for="">বুকিং তারিখ</label>
                    <input type="date" id="date" placeholder="তারিখ">
                </div>
                <div class="new-flex-1">
                    <label for=""> বুকিং সময়</label>
                    <input type="time" id="time" placeholder="সময়">
                </div>
            </div>

            <label for="">ক্যাটেগরি সিলেক্ট</label>
            <select name="catagory" id="service" placeholder="ক্যাটেগরি সিলেক্ট">
                @foreach($categories as $category)
                @php
                $visible = 0;
                @endphp
                @foreach($category->services as $service)
                @if ($service->job_post == 1)
                @php
                $visible += 1;
                @endphp
                @endif
                @endforeach

                @if ($visible != 0)
                <optgroup label="{{ $category->name }}">
                    @foreach($category->services as $service)
                    @if($service->job_post == 1)
                    <option value="{{ $service->id }}">{{ $service->name }}</option>
                    @endif
                    @endforeach
                </optgroup>
                @endif
                @endforeach
            </select>
        </div>

        <div class="sub-btn ">
            <input type="submit" value="Submit" id="job-submit-button">
        </div>
    </form>
</div>
@endsection

@push('foot')
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
    <script>
        $(document).ready(function () {
            //Submit new Job
            $('#job-submit-button').click(function(){
                $("#job-submit-button").prop("disabled", true);
                var formData = new FormData();
                formData.append('title', $('#title').val())
                formData.append('description', $('#description').val())
                formData.append('address', $('#address').val())
                formData.append('service', $('#service').val())
                formData.append('day', $('#day').val())
                formData.append('date', $('#date').val())
                formData.append('time', $('#time').val())
                // formData.append('budget', $('#budget').val())

                $.ajax({
                    method: 'POST',
                    url: "{{ route('customer.storeCustomerGig') }}",
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (data) {
                        $("#job-submit-button").prop("disabled", false);
                        $.toast({
                            heading: 'Success!',
                            position: 'top-right',
                            text: 'Service Created Successfully',
                            showHideTransition: 'slide',
                            icon: 'success'
                        })
                        setTimeout(function() {
                            window.location.href = '/customer'
                        }, 200);//
                    },
                    error: function (xhr) {
                        $("#job-submit-button").prop("disabled", false);
                        $.each(xhr.responseJSON.errors, function(key,value) {
                            console.log(value)
                        });
                        $.toast({
                            heading: 'Opps!',
                            position: 'top-right',
                            text: 'Something Went Wrong',
                            showHideTransition: 'slide',
                            icon: 'error'
                        })
                    },
                })
            });
        });
    </script>

    <script>
        $('#description').summernote({
                toolbar: [
                  ['style', ['style']],
                  ['font', ['bold', 'underline', 'clear']],
                  ['fontname', ['fontname']],
                  ['color', ['color']],
                  ['para', ['ul', 'ol', 'paragraph']],
                  ['table', ['table']],
                ],
                placeholder: 'কাজের বিবরণ...',
                tabsize: 2,
                height: 120,

            });
    </script>
@endpush
