
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
        <optgroup label="{{ $category->name }}">
            @foreach($category->services as $service)
                @foreach ($services_id as $service_id)
                    @if ($service_id)
                        @if ($service->id == $service_id)
                            <option value="{{ $service->id }}">{{ $service->name }}</option>
                        @endif
                    @endif
                @endforeach
            @endforeach
        </optgroup>
    @endif

    {{-- <optgroup label="{{ $category->name }}">
        @foreach($category->services as $service)
            @foreach ($services_id as $service_id)
                @if ($service->id == $service_id)
                    <option value="{{ $service->id }}">{{ $service->name }}</option>
                @endif
            @endforeach
        @endforeach
    </optgroup> --}}
@endforeach

