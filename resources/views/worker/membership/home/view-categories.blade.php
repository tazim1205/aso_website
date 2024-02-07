
@foreach($categories as $category)
    @php
        $visible = 0;
    @endphp

    @foreach($category->services as $service)
        @foreach ($services_id as $service_id)
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
        <div class="pb-2">
            <div class="btn btn-info w-100" style="background: #2BB34B">{{ $category->name }}</div>
            @foreach($category->services as $service)
                @foreach ($services_id as $service_id)
                    @if ($service_id)
                        @if ($service->id == $service_id)
                            {{-- <div class="">{{ $service->name }}</div> --}}
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

