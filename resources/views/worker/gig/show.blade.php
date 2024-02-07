@extends('worker.layout.app')
@push('title') {{ __('Gigs') }} @endpush
@push('head')
  <link href="{{ asset('assets/css/icons.css') }}" rel="stylesheet" type="text/css"/>

@endpush
@section('content')
        <!-- Start title -->
        <div class="">
            <div class="alert alert-primary text-center active-job" role="alert">
                <b id="">{{ __('Gigs') }}</b>
                <input type="hidden" name="" id="gig_id" value="{{ $workerGig->id }}">
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-12 mb-1">
                    <div class="card pt-2 pb-2" {{-- style="background-image: url('{{ asset($workerGig->cover_photo)}}');height: 170px;background-position: center;background-repeat: no-repeat; background-size: cover;" --}}>
                        <img src="{{ asset($workerGig->cover_photo)}}" class="gig-detail-image" id="showImageBtn">
                        <div class="">
                            <div class="d-flex justify-content-between">
                                <div class="">
                                    <span class="badge badge-success">৳ {{ $workerGig->budget }}</span><br>
                                    <span class="badge badge-success"><i class="fa fa-clock"></i> {{ $workerGig->day }} Hours</span>
                                </div>
                                <div class="text-right">
                                    <span class="text-right text-warning"><i class="fa fa-star"></i>
                                    @php
                                    $worker = App\User::find($workerGig->worker_id);
                                    $percent = 100 - (($worker->rating->max_rate - $worker->rating->rate)/$worker->rating->max_rate)*100;
                                    if ($percent>80){
                                        echo $star = 5;
                                    }else if ($percent>60){
                                        echo $star = 4;
                                    }else if ($percent>40){
                                        echo $star = 3;
                                    }else if ($percent>20){
                                        echo $star = 2;
                                    }else if ($percent>1){
                                        echo $star = 1;
                                    }else{
                                        echo $star = 0;
                                    }
                                    @endphp
                                    
                                    ({{ $worker->rating->rateGivenBy }})</span>
                                    <br>
                                    <span class="badge badge-success">
                                      @if($workerGig->status == 1)
                                        Active
                                      @else
                                        In Review
                                      @endif
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-12 col-12 pt-2 pb-2">
                   <b>{{ $workerGig->title }}</b>
                </div>
                <div class="col-12 row">
                   <div class="col-4 text-center">
                       <div class="card shadow border-0">
                           <div class="card-body">
                               <div class="row no-gutters h-100">
                                   <div class="col">
                                       <p>{{ $workerGig->customerBids->where('status','!=', 'cancelled')->count() }}<br><small class="text-secondary">{{ __('Orders') }}</small></p>
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
                                       <p>{{ $workerGig->budget }}<br><small class="text-secondary">{{ __('Price') }}</small></p>
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
                                       <p>{{ $workerGig->customerBids->where('status', '!=', 'cancelled')->count() }}<br><small class="text-secondary">{{ __('Click') }}</small></p>
                                   </div>
                               </div>
                           </div>
                       </div>
                   </div>
               </div>
               <div class="col-12">
                  <div class="btn-group btn-group-lg btn-group w-100 mb-2 mt-2 text-center" role="group" aria-label="Basic example">
                      <button type="button" onclick="window.location.href='{{ route('worker.editWorkerGig', \Illuminate\Support\Facades\Crypt::encryptString($workerGig->id)) }}'" class="btn btn-success edit-btn"><b>{{ __('Edit') }} &nbsp;</b></button>
                      <button type="button" value="{{ $workerGig->id }}" class="btn btn-danger delete-btn"><b>{{ __('Delete') }}</b></button>
                  </div>
                </div>
                <div class="col-lg-12 col-12 pt-2 pb-2">
                    @php
                      $category = DB::TABLE('worker_services')
                                  ->join('worker_service_categories', 'worker_service_categories.id', '=', 'worker_services.category_id')
                                  ->select('worker_service_categories.name as category', 'worker_services.name as subcategory')
                                  ->where('worker_services.id',$workerGig->service_id)
                                  ->first();

                    @endphp
                    <span  class="badge badge-secondary">{{ $category->category }}</span> | <span  class="badge badge-secondary">{{ $category->subcategory }}</span> 
                </div>
                <div class="col-lg-12 col-12 pt-2 pb-2">
                    <div class="show-read-more">{!! $workerGig->description !!}</div>
                </div>
                <style>
                    .show-read-more .more-text{
                        display: none;
                    }
                </style>

                <div class="col-lg-12 col-12 text-center pt-2 pb-2">
                    <button id="question_ans_btn" type="button" class="btn btn-sm btn-success mr-1 mb-1">{{ __('Questions and Answers') }}</button>
                </div>

                <div class="col-lg-12 col-12 pt-2 pb-2" id="question_ans_area">
                    <div class="" id="questionList">
                        
                    </div>
                    <div class="row">
                        <div class="col-12 col-lg-12 text-center ">
                          <a href="#" class="text-success loadmorequestion" id="loadmorequestion"><i class="fa fa-arrow-right"></i> See All Question Anwer</a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-12 col-12 pt-2 pb-2" id="review">
                    <div class="row">
                        <div class="col-12 col-lg-12 text-center">
                            <button class="btn btn-success">Customers Reviews</button>
                        </div>
                        @foreach(App\RattingReview::where('porpuse_id', $workerGig->id)->where('purpose', 'Bid')->get() as $row)
                            <div class="col-12 col-lg-12">
                                <div class="d-flex">
                                    <div class="p-2">
                                        <img src="{{ asset($row->user->image ?? 'uploads/images/defaults/user.png') }}" class="rounded-circle" alt="Cinque Terre" width="50" height="50">
                                    </div>
                                    <div class="">
                                        <h6 class="m-0">{{ $row->user->full_name}}</h6>
                                        <div>
                                            @for ($starCounter = 1; $starCounter <= $row->rate; $starCounter++)
                                                <i class="material-icons btn-outline-warning small">star</i>
                                            @endfor
                                        </div>
                                        <small>{{ $row->user->user_name}}, {{ date("H:i:s a",strtotime($row->created_at))}}, {{ date("d M Y",strtotime($row->created_at)) }}</small>
                                        <p>{{$row->review}}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        <div class="col-12 col-lg-12 text-center ">
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
                    title: 'Delete this gig ?',
                    text: "",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, Delete now!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        var formData = new FormData();
                        formData.append('gig', $(this).val())
                        $.ajax({
                            method: 'POST',
                            url: "{{ route('worker.deleteWorkerGig') }}",
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
                  url: "{{  url('/get/worker/gig-questions/') }}/"+gig_id+"/"+show,
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


            $("#showImageBtn").on("click", function() {
               $('#imagepreview').attr('src', $(this).attr('src')); // here asign the image to the modal when the user click the enlarge link
               $('#imagemodal').modal('show'); // imagemodal is the id attribute assigned to the bootstrap modal, then i use the show function
            });
        });
    </script>
@endsection
