@extends('guest.layout')
@push('title') {{ __('Home') }} @endpush

@section('content')

<div class="bid-area">
    <div class="sub-input">
        <label for="">কাজের টাইটেল</label>
        <input type="text" placeholder="কাজের টাইটেল">
        <label for="">কাজের বিবরণ...</label>
        <textarea name="" id=""placeholder="কাজের বিবরণ..." class="kajer-bb" ></textarea>
        <label for="">আপনার ঠিকানা</label>
        <input type="text" placeholder="আপনার ঠিকানা">
        <label for="">কত সময়ের মধ্যে কাজ সম্পন্ন করতে চাচ্ছেন
        </label>
        <input type="text" placeholder="সময়(ঘন্টা)">

        <div class="new-flex">
            <div class="new-flex-1">
                <label for="">বুকিং তারিখ</label>
                <input type="date" placeholder="তারিখ">
            </div>
            <div class="new-flex-1">
                <label for=""> বুকিং সময়</label>
                <input type="time" placeholder="সময়">
            </div>
        </div>

        <label for="">ক্যাটেগরি সিলেক্ট</label>
        <select name="catagory" placeholder="ক্যাটেগরি সিলেক্ট">
            <option value="Dhaka">Select catagory</option>
            <option value="Dhaka">Dhaka</option>
            <option value="Dhaka">Dhaka</option>
            <option value="Dhaka">Dhaka</option>
            <option value="Dhaka">Dhaka</option>
            <option value="Dhaka">Dhaka</option>
        </select>
    </div>

    <div class="sub-btn">
    <input id="openModalBtn" type="submit" value="Submit">
    </div>
    
    <!-- The Modal -->
    <div id="myModal" class="modal">
        <div class="modal-content">
            <span id="closeModalBtn" class="close">&times;</span>
            <!-- login buttons -->
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <p>{{ __('সার্ভিস নিতে অথবা সার্ভিস দিতে সাইন ইন করুন। আপনার কোনো অ্যাকাউন্ট নেই? এখনই সাইন আপ করুন।') }}</p>
                        <div class="row">
                        <div class="col-6">
                            <a style="float:right" href="{{ route('login') }}" class="btn btn-default btn-lg btn-rounded bg-success shadow btn-block">{{ __('Sign in') }}</a>
                        </div>
                        <div class="col-6">
                            <a style="float:left" href="{{ route('register') }}" class="btn btn-white bg-white btn-lg btn-rounded shadow btn-outline-success btn-block text-success">{{ __('Sign up') }}</a>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>


<script>
    let openModalBtn = document.getElementById("openModalBtn");
let modal = document.getElementById("myModal");
let closeModalBtn = document.getElementById("closeModalBtn");

openModalBtn.addEventListener("click", function() {
    modal.style.display = "block";
});

closeModalBtn.addEventListener("click", function() {
    modal.style.display = "none";
});

window.addEventListener("click", function(event) {
    if (event.target === modal) {
        modal.style.display = "none";
        backdrop:'static';
    }
});

</script>
@endsection
