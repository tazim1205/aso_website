@extends('marketer.layout.app')
@push('title') {{ __('Withdraw History') }} @endpush
@push('head')
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.16/css/jquery.dataTables.css">
@endpush
@section('content')

        @php $isAdsAndNoticeShow = ""; $isCategoryShow = ""; $loopCount = 0; @endphp
        <!--If job offer smaller than 5 show notice and top ads. as last -->
        @if($isAdsAndNoticeShow!='yes')
            <!-- Start top ads. by controller this upazila -->
                <div class="swiper-container offer-slide swiper-container-horizontal swiper-container-android">
                    <div class="swiper-wrapper" style="transform: __3d(0px, 0px, 0px); transition-duration: 0ms;">
                        
                            @foreach($adminAds as $controllerAds)
                                <div class="swiper-slide swiper-slide-active">
                                    <div class="card">
                                        <div class="card-body">
                                            <a  @if($controllerAds->url) href="{{ $controllerAds->url }}" target="_blank" @endif >
                                                <img src="{{ asset($controllerAds->image) }}" height="100%" width="100%" style="border-radius: 5px;">
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                    </div>
                    <span class="swiper-notification" aria-live="assertive" aria-atomic="true"></span>
                </div>
            <!-- End top ads.  by controller this upazila -->
        @endif

        <hr>
        <!--If job offer smaller than 10 show category & bottom ads. as last -->

        <!-- Start income and target bonus -->
        <section class="jumbotron  mt-4 bg-white shadow-sm">
            <div class="container">
                <!-- Start income and target bonus -->
                <div class="row pt-4 border" style="border-radius: 10px;">
                    <div class="col-12">
                        <table class="table table-bordered" id="datatable">
                            <thead>
                                <tr class="" style="background: linear-gradient(45deg, #ffdf40, #ff8359)!important;">
                                    <th colspan="3" class="text-center">
                                        {{__('আপনার আয় এবং টার্গেট পূরণে বোনাস')}}
                                    </th>
                                    <th colspan="2" class="text-right">
                                        <div class="row">
                                            <div class="col-12 col-lg-12 form-group">
                                                <select class=" bg-warning" id="yearForWithdrawHistory" name="yearForWithdrawHistory">
                                                    @for($i = 2021; $i <= 2050; $i++)
                                                        <option value="{{  $i }}" @if($i == date('Y')) selected="" @endif>{{$i}}</option>
                                                    @endfor
                                                </select>
                                            </div>
                                        </div>
                                    </th>
                                </tr>
                                <tr class="" style="background: linear-gradient(45deg, #ffdf40, #ff8359)!important;">
                                    <th scope="col" class="text-center border-0">{{__('উত্তোলনের তারিখ')}}</th>
                                    <th scope="col" class="text-center border-0">{{__('পরিমান')}}</th>
                                    <th scope="col" class="text-center border-0">{{__('মাধ্যম')}}</th>
                                    <th scope="col" class="text-center border-0">{{__('স্ট্যাটাস')}}</th>
                                    <th scope="col" class="text-center border-0">{{__('বিস্তারিত')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>
        <!-- End income and target bonus-->
@endsection
@push('foot')
    <script type="text/javascript" charset="utf8" src="//cdn.datatables.net/1.10.16/js/jquery.dataTables.js"></script>
    <script>
        $(document).ready( function () {
            function showWithdrawHistory(year){
                var dataTable = $('#datatable').DataTable({
                    processing: true,
                    serverSide: true,
                    autoWidth: false,
                    pageLength: 10,
                    // scrollX: true,
                    "order": [[ 0, "desc" ]],
                    ajax: "{{  url('/get/withdraw/history/list/') }}/"+year,
                    columns: [
                        {data: 'date', name: 'date'},
                        {data: 'amount', name: 'amount'},
                        {data: 'via', name: 'via'},
                        {data: 'status', name: 'status',sClass:'text-center'},
                        {data: 'Actions', name: 'Actions',orderable:false,serachable:false,sClass:'text-center'},
                    ]
                });
            }
            showWithdrawHistory(0);
           
            $('#yearForWithdrawHistory').on('change', function(e){
                e.preventDefault();
                var year = $(this).val();
                $('#datatable').DataTable().destroy();
                showWithdrawHistory(year);
            });

            $(document).on('click', '.seeBtn', function(e){ 
                e.preventDefault();
                var id = $(this).attr("id");
                $.ajax({  
                    url: "{{  url('/see/withdraw/history/details/') }}/"+id,
                    type:"GET",
                    dataType : 'html',
                    success:function(data) {
                        var d =$('#seeDivForModal').empty();
                        $('#seeDivForModal').html(data);
                        $('#seeModal').modal('show');
                    },
                });
            });
        });
    </script>
@endpush

