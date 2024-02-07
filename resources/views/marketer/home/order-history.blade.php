@extends('marketer.layout.app')
@push('title') {{ __('Order Under Me') }} @endpush
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
                                        {{__('অর্ডার কমিশন বিস্তারিত')}}
                                    </th>
                                    <th colspan="2" class="text-right">
                                        <div class="row">
                                            <div class="col-6 col-lg-6 form-group">
                                                <select class=" bg-warning" id="monthForOrderList" name="monthForOrderList">
                                                    @for($i = 1; $i <= 12; $i++)
                                                    @php $monthNum  = $i; $dateObj= DateTime::createFromFormat('!m', $monthNum); $monthName = $dateObj->format('F'); @endphp
                                                    <option value="{{__($i) }}" @if($monthName == date('F')) selected="" @endif>{{__($monthName) }}</option>
                                                    @endfor
                                                </select>
                                            </div>
                                            <div class="col-6 col-lg-6 form-group">
                                                <select class=" bg-warning" id="yearForOrderList" name="yearForOrderList">
                                                    @for($i = 2021; $i <= 2050; $i++)
                                                        <option value="{{  $i }}" @if($i == date('Y')) selected="" @endif>{{$i}}</option>
                                                    @endfor
                                                </select>
                                            </div>
                                        </div>
                                    </th>
                                </tr>
                                <tr class="" style="background: linear-gradient(45deg, #ffdf40, #ff8359)!important;">
                                    <th scope="col" class="text-center border-0">{{__('অর্ডার দেওযার তারিখ')}}</th>
                                    <th scope="col" class="text-center border-0">{{__('অর্ডার কমপ্লিট  তারিখ / বাতিল')}}</th>
                                    <th scope="col" class="text-center border-0">{{__('অর্ডার বাজেট')}}</th>
                                    <th scope="col" class="text-center border-0">{{__('প্রাপ্ত আয়')}}</th>
                                    <th scope="col" class="text-center border-0">{{__('বিস্তারিত')}}</th>
                                </tr>
                            </thead>
                            <tbody >
                                
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
             function showOrderList(year, month){
                var dataTable = $('#datatable').DataTable({
                    processing: true,
                    serverSide: true,
                    autoWidth: false,
                    pageLength: 10,
                    // scrollX: true,
                    "order": [[ 0, "desc" ]],
                    ajax: "{{  url('/get/order/under/me/') }}/"+year+"/"+month,
                    columns: [
                        {data: 'date', name: 'date'},
                        {data: 'status', name: 'status'},
                        {data: 'budget', name: 'budget'},
                        {data: 'income', name: 'income',sClass:'text-center'},
                        {data: 'Actions', name: 'Actions',orderable:false,serachable:false,sClass:'text-center'},
                    ]
                });
            }
            showOrderList(0,0);
           
            $('#yearForOrderList').on('change', function(e){
                e.preventDefault();

                var year = $(this).val();
                var month = $('#monthForOrderList').val();
                $('#datatable').DataTable().destroy();
                showOrderList(year,month);
            });

            $('#monthForOrderList').on('change', function(e){
                e.preventDefault()

                var year = $('#yearForOrderList').val();
                var month = $(this).val();
                $('#datatable').DataTable().destroy();
                showOrderList(year,month);
            });

            $(document).on('click', '.seeBtn', function(e){ 
                e.preventDefault();
                var id = $(this).attr("id");
                //console.log(id);
                $.ajax({  
                    url: "{{  url('/see/order/details') }}/"+id,
                    type:"GET",
                    dataType : 'html',
                    success:function(data) {
                        var d =$('#seeDivForModal').empty();
                        $('#seeDivForModal').html(data);
                        $('#seeModal').modal('show');
                        console.log(data);
                    },
                });
            });
        });
    </script>
@endpush

