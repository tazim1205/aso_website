@extends('worker.layout.app')
@push('title') {{ __('Services') }} @endpush
@push('head')
  <link href="{{ asset('assets/css/icons.css') }}" rel="stylesheet" type="text/css"/>

@endpush
@section('content')
        <!-- Start title -->
        <div class="">
            <div class="alert alert-primary text-center active-job" role="alert">
                <b id="">{{ __('Services') }}</b>
                <input type="hidden" name="" id="gig_id" value="{{ $pageService->id }}">
            </div>
        </div>

        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-12 mb-1">
                    <div class="card pt-2 pb-2" style="background-image: url('{{ asset($pageService->cover_photo)}}');height: 170px; background-size: cover; background-position: center;">
                        <div class="" style="margin-top: 113px;">
                            <div class="d-flex justify-content-between">
                                <div class="">
                                    <span class="badge badge-success">৳ {{ $pageService->budget }}</span><br>
                                    <span class="badge badge-success"><i class="fa fa-clock"></i> {{ $pageService->day }} Hours</span>
                                    @if($pageService->status == 'pending')
                                        <span class="badge badge-warning">Pending</span>
                                    @elseif($pageService->status == 'active')
                                      <span class="badge badge-success">Active</span>
                                    @else
                                      <span class="badge badge-danger">Inactive</span>
                                    @endif
                                </div>
                                <div class="text-right">
                                    <span class="text-right text-warning"><i class="fa fa-star"></i>
                                    @php
                                        $sum = App\ServiceReview::where('worker_id', $pageService->worker_id)->sum('rating');
                                        $count = App\ServiceReview::where('worker_id', $pageService->worker_id)->count();
                                        if (App\ServiceReview::where('worker_id', $pageService->worker_id)->exists()) {
                                            $total_review = $sum/$count;
                                        }else {
                                            $total_review = 0;
                                        }
                                        if ($total_review != 0) {
                                            echo number_format((float)$total_review, 1, '.', '');
                                        }
                                    @endphp
                                    ({{$count}})</span><br>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-12 col-12 pt-2 pb-2">
                   <b>{{ $pageService->title }}</b>
                </div>
                <div class="col-12 row">
                   <div class="col-4 text-center">
                       <div class="card shadow border-0">
                           <div class="card-body">
                               <div class="row no-gutters h-100">
                                   <div class="col">
                                       <p>{{ App\ServiceBid::where('worker_service_id', $pageService->id)->where('status', '!=', 'cancelled')->count() }}<br><small class="text-secondary">{{ __('Orders') }}</small></p>
                                   </div>
                               </div>
                           </div>
                       </div>
                   </div>
                   <div class="col-4 text-center">
                       <div class="card shadow border-0">
                           <div class="card-body">
                               <div class="row no-gutters h-100">
                                   <div class="col">
                                       <p>{{ $pageService->budget }}<br><small class="text-secondary">{{ __('Price') }}</small></p>
                                   </div>
                               </div>
                           </div>
                       </div>
                   </div>
                    <div class="col-4 text-center">
                       <div class="card shadow border-0">
                           <div class="card-body">
                               <div class="row no-gutters h-100">
                                   <div class="col">
                                       <p>{{ $pageService->click }}<br><small class="text-secondary">{{ __('Click') }}</small></p>
                                   </div>
                               </div>
                           </div>
                       </div>
                   </div>
               </div>
               <div class="col-12">
                  <div class="btn-group btn-group-lg btn-group w-100 mb-2 mt-2 text-center" role="group" aria-label="Basic example">
                    <button type="button" onclick="window.location.href='{{ route('worker.editWorkerService', \Illuminate\Support\Facades\Crypt::encryptString($pageService->id)) }}'" class="btn btn-success edit-btn"><b>{{ __('Edit') }} &nbsp;</b></button>
                    <button type="button" value="{{ $pageService->id }}" class="btn btn-danger delete-btn"><b>{{ __('Delete') }}</b></button>
                    <button type="button" onclick="window.location.href='{{ route('worker.gig.index', session(['service_click' => 'Load_service'])) }}'" class="btn btn-warning"><b>{{ __('Back') }}</b></button>
                  </div>
                </div>
                <div class="col-lg-12 col-12 pt-2 pb-2">
                    <div class="show-read-more">{!! $pageService->description !!}</div>
                </div>
                <style>
                    .show-read-more .more-text{
                        display: none;
                    }
                </style>

                <div class="col-lg-12 col-12 pt-2 pb-2" id="review">
                    <div class="row">
                        <div class="col-12 col-lg-12 text-center">
                            <button class="btn btn-success">Customers Reviews</button>
                        </div>
                        @forelse (App\ServiceReview::where('worker_service_id', $pageService->id)->get() as $review)
                        <div class="col-12 col-lg-12 mb-3">
                            <div class="d-flex">
                                <div class="p-2">
                                    <img src="{{ asset('uploads/images/product1.jpg')}}" class="rounded-circle" alt="Cinque Terre" width="50" height="50">
                                </div>
                                <div class="">
                                    <h6 class="m-0">{{ App\User::find($review->customer_id)->full_name }}</h6>
                                    <div>
                                        @for ($starCounter = 1; $starCounter <= $review->rating; $starCounter++)
                                            <i class="material-icons btn-outline-warning small">star</i>
                                        @endfor
                                    </div>
                                    <small>{{ App\User::find($review->customer_id)->user_name }}, {{ date('h:i a, d M y', strtotime($review->created_at)) }}</small>
                                    <p>{{ $review->review }}</p>
                                </div>
                            </div>
                        </div>
                        @empty
                            <div class="col-12 col-lg-12 mt-3">
                                <div class="alert alert-info">There is no review for this service</div>
                            </div>
                        @endforelse
                        <div class="col-12 col-lg-12 text-center">
                            <a href="" class="text-success"><i class="fa fa-arrow-right"></i> See All Reviews</a>
                        </div>
                    </div>
                </div>
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
                    title: 'Delete this service ?',
                    text: "",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, Delete now!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        var formData = new FormData();
                        formData.append('pageService', $(this).val())
                        $.ajax({
                            method: 'POST',
                            url: "{{ route('worker.deleteWorkerService') }}",
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
