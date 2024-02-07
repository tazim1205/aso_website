@foreach($categories as $category)
    <optgroup label="{{ $category->name }}">
        @foreach($category->services as $service)
            <option value="{{ $service->id }}"
                @foreach ($services_id as $service_id)
                    @if ($service->id == $service_id)
                        {{ "selected" }}
                    @else 
                        {{ "" }}
                    @endif
                @endforeach
            >{{ $service->name }}</option>
        @endforeach
    </optgroup>
@endforeach