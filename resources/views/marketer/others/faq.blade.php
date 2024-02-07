@extends('marketer.layout.app')
@push('title') {{ __('FAQ') }} @endpush
@push('head')

@endpush
@section('content')
     <style>

    #accordion .card{
        margin: 10px 0px;
        border: none;
    }

    #accordion .card .card-header{
        background-color: rgb(255,255,255);
        border-bottom: none;
    }

    #accordion .card .card-header .card-link{
        color: #000;
        font-weight: bold;
        margin-right: 25px;
    }

    #accordion .card .card-header .card-link::before{
        content: "\2192";
        font-size: 1.2rem;
    }

    #accordion .card .card-header .sign{

        float: right;
        color: #000;
    }

    #accordion .card .card-header .sign:hover{
        text-decoration: none;
    }

    #accordion .card .card-header .sign::after{
        content: "\271A";
        color: #000;
    }

    #accordion .card .card-body{
        font-weight: 500;
        color: gray;
        padding-left: 40px;
    }

</style>

    <section class="before-footer section-bg ">
        <div class="container d-flex h-100">
            <div class="row" style="padding-top: 3.5em; ">
                <div class="col-md-8 offset-md-2 text-center">
                    <img src="assets/img/faq.png" style="width: 100%; max-width: 450px; display: none">
                    <h1 style=" margin: 40px 0px">FREQUENTLY ASK QUESTION</h1>
                </div>
                <div class="col-md-8 offset-md-2">
                    <div id="accordion">
                        @foreach ($customer_faq as $faq)
                            <div class="card">
                                <div class="card-header">
                                    <a class="card-link collapsed" data-toggle="collapse" href="#collapse{{ $faq->id }}" aria-expanded="false">
                                       {{ $faq->question }}
                                    </a>
                                    <a data-toggle="collapse" href="#collapse{{ $faq->id }}" class="sign collapsed" aria-expanded="false"></a>
                                </div>
                                <div id="collapse{{ $faq->id }}" class="collapse" data-parent="#accordion" style="">
                                    <div class="card-body">
                                       {!! $faq->answer !!}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div> 
                </div>
            </div>
        </div>
    </section>
    <script type="text/javascript">
    </script>
@endsection

