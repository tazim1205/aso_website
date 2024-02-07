@extends('worker.gig.index')

@section('gig_content')
    <div class="bid-area">
        <div class="sub-input nbp">
            <label for="">কাজের টাইটেল</label>
            <input type="text" placeholder="কাজের টাইটেল" id="title"/>
            <label for="">কাজের বিবরণ...</label>
            <textarea
                name=""
                placeholder="কাজের বিবরণ..."
                class="kajer-bb"
                id="description"
            ></textarea>
            <label for="">ক্যাটেগরি সিলেক্ট</label>
            <select name="catagory" placeholder="ক্যাটেগরি সিলেক্ট" id="gig_category">
                <option disabled selected>Select catagory</option>
                @foreach($categories as $category)
                    @php
                        $visible = 0;
                    @endphp
                    @foreach($category->services as $service)
                        @if ($service->gig_post == 1)
                            @php
                                $visible += 1;
                            @endphp
                        @endif
                    @endforeach

                    @if ($visible != 0)
                        <optgroup label="{{ $category->name }}">
                            @foreach($category->services as $service)
                                @if($service->gig_post == 1)
                                    <option value="{{ $service->id }}">{{ $service->name }}</option>
                                @endif
                            @endforeach
                        </optgroup>
                    @endif
                @endforeach
            </select>

            <label for="">কত সময়ের মধ্যে কাজ সম্পন্ন করতে চাচ্ছেন </label>
            <input type="text" placeholder="সময়(ঘন্টা)" id="day"/>

            <div class="new-flex">
                <div class="new-flex-1">
                    <label for="">আপনার গিগ এর মূল্য দিন</label>
                    <input type="text" placeholder="Price" id="price"/>
                </div>
                <div class="new-flex-1">
                    <label for="">ট্যাগস</label>
                    <input type="text" placeholder="Tags" id="tags"/>
                </div>
            </div>
            <div class="photo-upload" id="photoUpload">
                <h2><i class="fa-regular fa-image"></i></h2>
                <p>Drop your image here, or <a href="javascript:void();" onclick="browseImage()"> browse</a></p>
                <input type="file" id="fileInput" style="display: none" />
            </div>
            <div class="preview" id="imagePreview">
                <img src="#" alt="Image Preview">
            </div>
        </div>

        <div class="login-form l-1">
            <a href="javascript:void();" id="gig-submit-button"><input type="submit" value="Post Gig" /></a>
        </div>
    </div>

    <div class="order-area">
        @foreach(auth()->user()->workerGigs as $gig)
        <div class="service-area">
            <div class="service-up">
                <div class="service-left">
                    <h2>{{ $gig->title }}</h2>
                    <p>Created</p>
                    <p>{{ date('h:i a d/m/y', strtotime($gig->created_at)) }}</p>
                </div>
                <div class="service-right">
                    <h4>{{ $gig->customerBids->where('status', '!=', 'cancelled')->count() }}</h4>
                    <h4>Order</h4>
                </div>

                <div class="service-right">
                    <h4>{{ $gig->click }}</h4>
                    <h4>Click</h4>
                </div>
            </div>

            <div class="service-foot">
                <a href="{{ route('worker.showWorkerGig', \Illuminate\Support\Facades\Crypt::encryptString($gig->id)) }}">Veiw Details</a>
            </div>
        </div>
        @endforeach
    </div>
@endsection
