@extends('marketer.layout.app')
@push('title') {{ __('About') }} @endpush
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
        <div class="container">
            <div class="row" style="padding-top: 3.5em; ">
                <div class="col-md-12 text-center">
                    <h1 style=" margin: 40px 0px">ABOUT US</h1>
                    <hr>
                </div>
                <div class="col-md-8 offset-md-2">
                    <div id="accordion">
                        {!! $about->about !!}
                    </div> 
                </div>
            </div>
        </div>
    </section>
    <script type="text/javascript">
    </script>
@endsection

