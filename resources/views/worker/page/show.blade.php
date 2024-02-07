@extends('worker.layout.app')
@push('title') {{ __('Pages') }} @endpush
@push('head')
  <link href="{{ asset('assets/css/icons.css') }}" rel="stylesheet" type="text/css"/>

@endpush
@section('content')
        <!-- Start title -->
        <div class="">
            <div class="alert alert-primary text-center active-job" role="alert">
                <b id="">{{ __('View Page') }}</b>
                <input type="hidden" name="" id="gig_id" value="{{ $workerpage->id }}">
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-12 mb-1">
                    <div class="card pt-2 pb-2 d-flex align-items-end" style="background-image: url('{{ asset($workerpage->image)}}');height: 170px;background-position: center;background-repeat: no-repeat; background-size: cover;">
                        <div class="w-100" style="padding-top: 130px">
                            <div class="row justify-content-between px-2">
                                <div class="col">
                                    <span class="badge badge-success">{{ (auth()->user()->membership->id == $workerpage->membership_id) ? "Membership Running":"Page Expired, Page Hidden by Default" }}</span>

                                    @if(auth()->user()->membership && !auth()->user()->membershipActive)
                                        <span class="badge badge-success">Inactive</span>
                                    @else
                                        <span class="badge badge-success">
                                            @if ($workerpage->status == 'pending')
                                                {{ "Pending, Under Review" }}
                                            @elseif($workerpage->status == 'active')
                                                {{ "Active" }}
                                            @else
                                                {{ "Disabled" }}
                                            @endif
                                        </span>
                                    @endif
                                    <span class="badge badge-success"><i class="fa fa-clock"></i>{{ ($workerpage->visibility == "show")?"Visible":"Invisible" }}</span>
                                </div>
                                <div class="col-auto text-right">
                                    {{-- <br> --}}
                                    <span class="text-right text-warning"><i class="fa fa-star"></i>
                                    @php
                                        $sum = App\ServiceReview::where('worker_id', $workerpage->worker_id)->sum('rating');
                                        $count = App\ServiceReview::where('worker_id', $workerpage->worker_id)->count();
                                        if (App\ServiceReview::where('worker_id', $workerpage->worker_id)->exists()) {
                                            $total_review = $sum/$count;
                                        }else {
                                            $total_review = 0;
                                        }
                                        echo number_format((float)$total_review, 1, '.', '');
                                    @endphp
                                    
                                    ({{ $count }})</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-12 col-12 pt-2 pb-2">
                   <b>{{ $workerpage->name }}</b>
                </div>
                <div class="col-lg-12 col-12 pt-2 pb-2">
                   <b>{{ $workerpage->title }}</b>
                </div>
                
               <div class="col-12">
                  <div class="btn-group btn-group-lg btn-group w-100 mb-2 mt-2 text-center" role="group" aria-label="Basic example">
                      <button type="button" onclick="window.location.href='{{ route('worker.editworkerpage', \Illuminate\Support\Facades\Crypt::encryptString($workerpage->id)) }}'" class="btn btn-success edit-btn"><b>{{ __('Edit') }} &nbsp;</b></button>
                      {{-- <button type="button" value="{{ $workerpage->id }}" class="btn btn-danger delete-btn"><b>{{ __('Delete') }}</b></button> --}}
                      <button type="button" onclick="window.location.href='{{ route('worker.gig.index', session(['page_click' => 'Page cancel'])) }}'" class="btn btn-warning"><b>{{ __('Back') }}</b></button>
                  </div>
                </div>
               <div class="col-12">
                  <div class="btn-group btn-group-lg btn-group w-100 mb-2 mt-2 text-center" role="group" aria-label="Basic example">
                      <button type="button" value="{{ $workerpage->id }}" class="btn btn-danger delete-btn"><b>{{ __('Delete') }}</b></button>
                      @if ($workerpage->visibility == 'show')
                      <button type="button" value="{{ $workerpage->id }}" class="btn btn-warning visibility-btn"><b>{{ __('Hide') }}</b></button>
                      @else 
                      <button type="button" value="{{ $workerpage->id }}" class="btn btn-success visibility-btn"><b>{{ __('Show') }}</b></button>
                      @endif
                  </div>
                </div>
                @if ($workerpage->description)
                <div class="col-lg-12 col-12 pt-2 pb-2">
                    <div class="show-read-more"><strong>Description: </strong>{!! $workerpage->description !!}</div>
                </div>
                @endif
                @if ($workerpage->address)
                <div class="col-lg-12 col-12 pt-2 pb-2">
                    <div class="show-read-more"><strong>Address: </strong>{!! $workerpage->address !!}</div>
                </div>
                @endif
                <div class="col-md-12 pt-2 pb-2">
                    <div class="show-read-more pb-2"><strong>Services Where page will show: </strong></div>
                    {{-- @foreach ($categories as $category)
                        @foreach ($category->services as $service)
                            @foreach (Str::of($workerpage->services)->explode(',') as $service_id)
                                @if ($service_id == $service->id)
                                    <span class="btn btn-sm btn-info mt-1 mb-1">{{ $category->name }} : {{ $service->name }}</span>
                                @endif
                            @endforeach
                        @endforeach
                    @endforeach --}}


                    <div class="row">
                        @foreach($categories as $category)
                        @php
                            $visible = 0;
                        @endphp

                        @foreach($category->services as $service)
                            @foreach (Str::of($workerpage->services)->explode(',') as $service_id)
                                @if ($service_id)
                                    @if ($service->id == $service_id)
                                        @php
                                            $visible += 1;
                                        @endphp
                                    @endif
                                @endif
                            @endforeach
                        @endforeach

                        @if ($visible != 0)
                            <div class="pb-2 col-md-3">
                                <div class="btn btn-sm w-100" style="border:1px solid #2BB34B">{{ $category->name }}</div>
                                @foreach($category->services as $service)
                                    @foreach (Str::of($workerpage->services)->explode(',') as $service_id)
                                        @if ($service_id)
                                            @if ($service->id == $service_id)
                                                <ul class="m-0">
                                                    <li class="m-0">{{ $service->name }}</li>
                                                </ul>
                                            @endif
                                        @endif
                                    @endforeach
                                @endforeach
                            </div>
                        @endif

                    @endforeach
                    </div>

                </div>
                <div class="col-md-12 pt-2 pb-2">
                    <div class="show-read-more"><strong>Your Services to show in page: </strong></div>
                    @foreach (Str::of($workerpage->worker_services)->explode(',') as $service)
                        @if (App\PageService::find($service))
                        <span class="btn btn-sm btn-success my-1">{{ App\PageService::find($service)->title }}</span>
                        @endif
                    @endforeach
                </div>
                @if ($workerpage->phone)
                <div class="col-md-6 pt-2 pb-2">
                    <div class=""><strong class="fw-bold">Phone: </strong>{!! $workerpage->phone !!}</div>
                </div>
                @endif
                <div class="col-md-6 pt-2 pb-2">
                    <div class="">
                        <strong class="fw-bold">Location: </strong>
                        {{-- <a href="{{ $workerpage->locaton }}" target="_blank">See Location</a> --}}
                        {{-- <a class="venobox btn btn-sm btn-success" data-vbtype="iframe" href="{{ $workerpage->location }}">See Locaton</a> --}}
                        <a href="{{ $workerpage->location }}" target="_blank" class="btn btn-sm btn-success">location</a>
                    </div>
                </div>
                <style>
                    .show-read-more .more-text{
                        display: none;
                    }
                </style>

                
            </div> 
        </div>

    <script>
        $(document).ready(function() {
        
          var gig_id = $('#gig_id').val();
          // $('#question_ans_area').show();
          // $('#your_question_area').hide();
          // $('#ask_question_area').hide();
            //Delete
            $('.delete-btn').click(function(){
                Swal.fire({
                    title: 'Delete this Page ?',
                    text: "",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, Delete now!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        var formData = new FormData();
                        formData.append('page', $(this).val())
                        $.ajax({
                            method: 'POST',
                            url: "{{ route('worker.deleteworkerpage') }}",
                            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                            data: formData,
                            processData: false,
                            contentType: false,
                            success: function (data) {
                                Swal.fire({
                                    position: 'top-end',
                                    icon: data.type,
                                    title: data.message,
                                    showConfirmButton: false,
                                    timer: 1500
                                })
                                setTimeout(function() {
                                    location.replace("{{ route('worker.gig.index') }}")
                                }, 1000); //1 second
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
                    }
                })
            });

            $('.visibility-btn').click(function(){
                var formData = new FormData();
                formData.append('page', $(this).val())
                $.ajax({
                    method: 'POST',
                    url: "{{ route('worker.workerpagevisibility') }}",
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (data) {
                        Swal.fire({
                            position: 'top-end',
                            icon: data.type,
                            title: data.message,
                            showConfirmButton: false,
                            timer: 1500
                        })
                        setTimeout(function() {
                            location.reload();
                        }, 1000);//
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

            function getAllQuestions(gig_id,show){
              $.ajax({  
                  url: "{{  url('/get/gig-questions/') }}/"+gig_id+"/"+show,
                  type:"GET",
                  dataType : 'html',
                  success:function(data) {
                      var d =$('#questionList').empty();
                      $('#questionList').html(data);
                  },
              });
            }
            getAllQuestions(gig_id,'0');
            $("#loadmorequestion").click(function(e){
                e.preventDefault();
                getAllQuestions(gig_id,'all');
            });

            $('.replayBtn').on('click', function(e){
                e.preventDefault();
                alert('test');
                $('#replayModal').modal('show');
            });
        });
    </script>
@endsection
