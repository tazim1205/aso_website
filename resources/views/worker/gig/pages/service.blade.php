@extends('worker.gig.index')

@section('gig_content')
    <div class="bid-area">
        <div class="sub-input nbp">
            <label for="">কাজের টাইটেল</label>
            <input type="text" placeholder="কাজের টাইটেল" id="service_title"/>
            <label for="">কাজের বিবরণ...</label>
            <textarea
                name=""
                id="service_description"
                placeholder="কাজের বিবরণ..."
                class="kajer-bb"
            ></textarea>

            <label for="">কত সময়ের মধ্যে কাজ সম্পন্ন করতে চাচ্ছেন </label>
            <input type="text" placeholder="সময়(ঘন্টা)" id="service_day"/>

            <div class="new-flex">
                <div class="new-flex-1">
                    <label for="">আপনার গিগ এর মূল্য দিন</label>
                    <input type="text" placeholder="Price" id="service_price"/>
                </div>
                <div class="new-flex-1">
                    <label for="">ট্যাগস</label>
                    <input type="text" placeholder="Tags" id="service_tags"/>
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
            <a href="javascript:void();" id="service-submit-button"><input type="submit" value="Create Service" /></a>
        </div>
    </div>

    <div class="order-area">
        @foreach(auth()->user()->pageServices as $service)
        <div class="service-area">
            <div class="service-up">
                <div class="service-left">
                    <h2>{{ $service->title }}</h2>
                    <p>Created</p>
                    <p>{{ date('h:i a d/m/y', strtotime($service->created_at)) }}</p>
                </div>
                <div class="service-right">
                    <h4>{{ App\ServiceBid::where('worker_service_id', $service->id)->where('status', '!=', 'cancelled')->count() }}</h4>
                    <h4>Order</h4>
                </div>
            </div>

            <div class="service-foot">
                <a href="{{ route('worker.showWorkerService', \Illuminate\Support\Facades\Crypt::encryptString($service->id)) }}">Veiw Details</a>
            </div>
        </div>
        @endforeach
    </div>
@endsection
