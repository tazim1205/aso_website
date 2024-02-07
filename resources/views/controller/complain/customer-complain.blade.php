@extends('controller.layout.app')
@push('title')
{{ __('Customer complain List') }}
@endpush
@push('head')

@endpush
@section('content')
<div class="app-content content">
    <div class="content-wrapper padding-top5">
        <div class="content-header row">
            <div class="content-body  container-fluid">
                <!-- Zero configuration table -->
                <section id="configuration">
                    <!-- select option row start -->
                    <div class="row mt-1">
                        <div class="col-md-12">
                            <div class="card card-background-blue">
                                <div class="card-content">
                                    <div class="card-body select-card-design">

                                        <h4 class="select-title width_100_percent white">Report Management - Submited
                                        </h4>

                                        <select name="month" class="form-control width-30-percent margin-bottom-5">
                                            <option value=''>--Select Month--</option>
                                            <option selected value='1'>Janaury</option>
                                            <option value='2'>February</option>
                                            <option value='3'>March</option>
                                            <option value='4'>April</option>
                                            <option value='5'>May</option>
                                            <option value='6'>June</option>
                                            <option value='7'>July</option>
                                            <option value='8'>August</option>
                                            <option value='9'>September</option>
                                            <option value='10'>October</option>
                                            <option value='11'>November</option>
                                            <option value='12'>December</option>
                                        </select>
                                        <select name="year" class="form-control width-30-percent margin-bottom-5">
                                            <option value=''>--Select Year--</option>
                                            <option value="2030">2030</option>
                                            <option value="2029">2029</option>
                                            <option value="2028">2028</option>
                                            <option value="2027">2027</option>
                                            <option value="2026">2026</option>
                                            <option value="2025">2025</option>
                                            <option value="2024">2024</option>
                                            <option selected value="2023">2023</option>
                                            <option value="2022">2022</option>
                                            <option value="2021">2021</option>
                                            <option value="2020">2020</option>
                                        </select>
                                        <select name="category" class="form-control width-30-percent margin-bottom-5">
                                            <option selected>Category</option>
                                            <option value="1">One</option>
                                            <option value="2">Two</option>
                                            <option value="3">Three</option>
                                        </select>
                                        <select name="service" class="form-control width-30-percent margin-bottom-5">
                                            <option selected>Service</option>
                                            <option value="1">One</option>
                                            <option value="2">Two</option>
                                            <option value="3">Three</option>
                                        </select>
                                        <select name="pourashava" class="form-control width-30-percent margin-bottom-5">
                                            <option selected>Pourashava/Union/Area</option>
                                            <option value="1">One</option>
                                            <option value="2">Two</option>
                                            <option value="3">Three</option>
                                        </select>
                                        <select name="ward" class="form-control width-30-percent margin-bottom-5">
                                            <option selected>Ward/Road</option>
                                            <option value="1">One</option>
                                            <option value="2">Two</option>
                                            <option value="3">Three</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- select option row end -->

                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-head">
                                    <div class="card-header">
                                        <div class="heading-elements visible">
                                            <ul class="list-inline mb-0">
                                                <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                                <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                                                <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <!-- Task List table -->
                                        <div class="table-responsive">
                                            <table id="users-contacts"
                                                class="table table-white-space table-bordered table-striped row-grouping display no-wrap icheck table-middle">
                                                <thead>
                                                    <tr>
                                                        <th>No.</th>
                                                        <th>Customer Username</th>
                                                        <th>Worker Username</th>
                                                        <th>Order Number</th>
                                                        <th>Order Create Date</th>
                                                        <th>Report Date</th>
                                                        <th>See Report</th>
                                                        <th>See Order</th>
                                                        <th>Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($customers as $customer)
                                                    @foreach($customer->complains as $complain)
                                                    <tr>
                                                        <td> {{ $loop->iteration }}</td>
                                                        <td>
                                                            {{ $complain->user->full_name }}
                                                        </td>
                                                        <td>
                                                            chomokhasan40
                                                        </td>
                                                        <td>
                                                            665566
                                                        </td>
                                                        <td>
                                                            17/03/2023
                                                        </td>
                                                        <td>
                                                            01/04/2023
                                                        </td>
                                                        <td>
                                                            <a href="#" data-toggle="modal" data-target="#reportview"
                                                                class="btn btn-danger view-complain" id="{{ $complain->id }}" data-complain="{!! $complain->complain !!}">
                                                                <i class="ft-eye"></i>
                                                                Report View
                                                            </a>
                                                        </td>
                                                        <td>
                                                            <a href="#" data-toggle="modal" data-target="#orderview"
                                                                class="btn btn-primary">
                                                                <i class="ft-eye"></i>
                                                                Order View
                                                            </a>
                                                        </td>
                                                        <td class="text-center">
                                                            <a href="#" data-toggle="modal" data-target="#edit"
                                                                class="btn btn-info">
                                                                <i class="ft-edit-2"></i>
                                                                Resolved
                                                            </a>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!--/ Zero configuration table -->
                <!-- Edit Model start -->
                <div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">

                            </div>

                            <div class="modal-body">
                                <form action="#" method="POST">

                                    <div class="form-group">
                                        <div class="mb-3">
                                            <label for="info" class="form-label">Information</label>
                                            <textarea class="form-control" name="" id="info" rows="7">
    Lorem ipsum dolor sit amet consectetur adipisicing elit. Temporibus aliquid assumenda explicabo tempore! Nostrum officia iusto enim iste expedita tenetur, quos aliquid eum sunt a deleniti aperiam fuga blanditiis et! </textarea>
                                        </div>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-dismiss="modal">Close</button>

                                        <button type="submit" class="btn btn-primary">Resolved</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Edit Model end -->

                <!-- report view Model start -->
                <div class="modal fade" id="reportview" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">
                                    report view
                                </h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>

                            <div class="modal-body">

                            </div>
                        </div>
                    </div>
                </div>
                <!-- report view Model end -->

                <!-- order view Model start -->
                <div class="modal fade" id="orderview" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header card-background-blue">
                                <h5 class="modal-title" id="exampleModalLabel">
                                    <img src="../assets/images/area_controller/worker/1.png" alt="">
                                    <span>Abu Said Sheikh</span>
                                    <i class="fa fa-star stra-design" aria-hidden="true"></i> 3 (2)
                                </h5>
                                <div class="float-right">
                                    <div class="fa fa-map-marker location-size"></div>
                                </div>
                            </div>

                            <div class="modal-body">

                                <form action="">
                                    <input type="tel" value="01800000000" class="form-contro" readonly name="" id="">

                                    <a href="">
                                        <i class="fa fa-phone card-background-blue phone-design" aria-hidden="true"></i>
                                    </a>
                                </form>


                                <div class="price_code">
                                    <table class="table text-center">
                                        <tr>
                                            <th>Price</th>
                                            <th>Code</th>
                                        </tr>
                                        <tr>
                                            <td>1200</td>
                                            <td>#937839</td>
                                        </tr>
                                    </table>
                                </div>

                                <h3>Title:</h3>
                                <p> I need AC Repair</p>

                                <h3>Details:</h3>
                                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Magni, rem quae ex illum
                                    officia
                                    odit voluptatum quis voluptatibus eum id fugiat? Nostrum sit dolor exercitationem
                                    minus.
                                    Architecto quaerat eligendi officia?</p>

                                <h3>Address</h3>
                                <p>Sagardi, Barishal</p>
                                <hr>

                                <div class="start_message">
                                    <span>অর্ডার ডেলিভারি ডেট:</span>
                                    <h3>৪ ঘন্টা</h3>
                                </div>

                                <div class="start_message">
                                    <span>Probable order start date and time:</span>
                                    <span>04:15 pm, 01 April 23</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- order view Model end -->
            </div>
            <!-- container-fluid end -->
        </div>
    </div>
</div>
<!-- END: Main Content end-->
@endsection
@push('foot')
<script>
    function viewBtn(complain){
            $('.modal-body').html(complain);
            $('#exampleModal').modal('show');
        }

        $(".view-complain").click(function(){
            var text = $(this).attr('data-complain');
            $('.modal-body').html(text);
            $('#reportview').modal('show');
            // viewBtn(text);
        });

        function CompleteBtn(complain_id){
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, complete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        method: 'GET',
                        url: "/controller/complain/customer-complain/update/"+complain_id,
                        processData: false,
                        contentType: false,
                        beforeSend: function (){
                            $(this).prop("disabled",true);
                        },
                        complete: function (){
                            $(this).prop("disabled",false);
                        },
                        success: function (data) {
                            if (data.type == 'success'){
                                Swal.fire({
                                    position: 'top-end',
                                    icon: data.type,
                                    title: data.message,
                                    showConfirmButton: false,
                                    timer: 1500
                                });
                                setTimeout(function() {
                                    location.reload();
                                }, 800);//
                            }else{
                                Swal.fire({
                                    icon: data.type,
                                    title: 'Oops...',
                                    text: data.message,
                                    footer: 'Something went wrong!'
                                });
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
                            });
                        },
                    });
                }
            })
        }
</script>

@endpush
