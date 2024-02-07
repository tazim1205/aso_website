<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
    <ol class="carousel-indicators">
        @php
        $adsCount = 1;
        @endphp
        @if(count(auth()->user()->upazila->controllers) > 0)
        @foreach(auth()->user()->upazila->controllers as $controller)
        @if(count((is_countable($controller->controllerAds) ? $controller->controllerAds :[])) > 0)
        @foreach($controller->controllerAds as $key => $controllerAds)        
        <li data-target="#carouselExampleIndicators" data-slide-to="{{$adsCount}}" class="@if($adsCount == 1) active @endif"></li>
        @php
        $adsCount++;
        @endphp
        @endforeach
        @endif
        @endforeach
        @endif
    </ol>
    <div class="carousel-inner">
        @php
        $addImage = 1;
        @endphp
        @if(count(auth()->user()->upazila->controllers) > 0)
        @foreach(auth()->user()->upazila->controllers as $controller)
        @if(count((is_countable($controller->controllerAds) ? $controller->controllerAds :[])) > 0)
        @foreach($controller->controllerAds as $controllerAds)        
        <div class="carousel-item @if($addImage == 1) active @endif">
            <a @if($controllerAds->url) href="{{ $controllerAds->url }}" target="_blank" @endif>
                <img class="d-block w-100" src="{{ asset($controllerAds->image) }}" alt="First slide" />
            </a>
        </div>
        @php
        $addImage++;
        @endphp
        @endforeach
        @endif
        @endforeach
        @endif        
    </div>
    <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
    </a>
</div>