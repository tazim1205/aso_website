<?php

namespace App\Http\Controllers\Guest;

use App\AffiliateUser;
use App\Balance;
use App\District;
use App\Http\Controllers\Controller;
use App\MembershipAndService;
use App\MembershipService;
use App\MembershipServiceCategory;
use App\Nid;
use App\Rating;
use App\Referral;
use App\Word;

use App\UserUsefulFile;
use App\User;
use App\WorkerAndService;
use App\WorkerService;
use App\WorkerServiceCategory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Intervention\Image\ImageManagerStatic as Image;
use Cookie;
use Session;
use App\AffiliatePayment;
 
class RegisterController extends Controller
{
    //Customer register get from by default register

    //Submit customer register
    public function submitCustomerRegister(Request $request){
        $request->validate([
            // 'profilePicture'     => 'required|image|max:5000',
            'userName'  => 'required|string|max:20|unique:users,user_name',
            'fullName'  => 'required|string|max:50',
            'phone'     => 'required|string|max:16|min:11|unique:users',
            'gender'    => 'required|string|max:10',
            'password'  => 'required|min:6|max:50|confirmed',
            'district'   => 'required|exists:districts,id',
            'upazila'   => 'required|integer|exists:upazilas,id',
             
        ]);

        if ($request->input('password') != $request->input('password_confirmation')){
            return response()->json([
                'type' => 'warning',
                'message' => 'Password not match',
            ]);
        }


        $customer = new User();
        $customer->role         =   'customer';
        $customer->status       =   '1';
        $customer->full_name    =   $request->input('fullName');
        $customer->user_name    =   $request->input('userName');
        $customer->phone        =   $request->input('phone');
        $customer->gender       =   $request->input('gender');
        $customer->district_id  =   $request->input('district');
        $customer->upazila_id   =   $request->input('upazila');
        $customer->pouroshova_union_id   =   $request->input('pouroshova');
        $customer->word_road_id   =   $request->input('word');
        $customer->password     =   Hash::make($request->input('password'));


        //Refferral Code Insert
        if(Cookie::has('referral_code')){
            $referral_code = Cookie::get('referral_code');
            $referred_by_user = User::where('referral_code', $referral_code)->first();
            if($referred_by_user != null){
                $customer->referred_by = $referred_by_user->id;
                $customer->save();
            }
        }else{
            $referred_by_user = User::where('referral_code', $request->input('referralCode'))->first();
            if($referred_by_user != null){
                $customer->referred_by   =   $request->input('referralCode');
                $customer->save();
            }
        }

        if($request->hasFile('profilePicture')){
            $image             = $request->file('profilePicture');
            $folder_path       = 'uploads/images/users/';
            $image_new_name    = Str::random(8).'-profile-'.Carbon::now()->format('d-m-Y H-i-s') .'.'. $image->getClientOriginalExtension();
            //resize and save to server
            Image::make($image->getRealPath())->save($folder_path.$image_new_name);
            $customer->image    = $folder_path.$image_new_name;
        }

        $customer->save();

        

        //Rating
        $rating = new Rating();
        $rating->user_id  = $customer->id;
        $rating->save();

        //Balance
        $rating = new Balance();
        $rating->user_id  = $customer->id;
        $rating->save();

        //Balance updated of referral owner
        if ($request->input('referralCode')){
            if (Referral::where('own', $request->input('referralCode'))->first()) {
                $selectedReferralOwnerBalance = Referral::where('own', $request->input('referralCode'))->first()->user->balance;
                $selectedReferralOwnerBalance->referral_income +=  get_static_option('per_customer_referral_price') ?? 0;
                $selectedReferralOwnerBalance->save();
            }
        }

        if (Cookie::has('referral_code')){
            if (Referral::where('own', Cookie::get('referral_code'))->first()) {
                $selectedReferralOwnerBalance = Referral::where('own', Cookie::get('referral_code'))->first()->user->balance;
                $selectedReferralOwnerBalance->referral_income +=  get_static_option('per_customer_referral_price') ?? 0;
                $selectedReferralOwnerBalance->save();
            }
        }

        if(Auth::attempt(['phone' => $customer->phone, 'password' => $request->input('password'), 'status' => 1])) {
            Auth::user()->last_login_at = Carbon::now();
            Auth::user()->save();
            return response()->json([
                'type' => 'success',
                'message' => 'Successfully created',
            ]);
        }else{
            return response()->json([
                'type' => 'warning',
                'message' => 'Successfully created',
            ]);
        }
    }

    //getCustomerRegisterForm
    public function customerFinalRegistration(){

        $districts = District::all();
        $categories= WorkerServiceCategory::all();
        return view('auth.final-register',compact('districts', 'categories'));
    }

    public function workerFinalRegistration(){

        $districts = District::all();
        $categories= WorkerServiceCategory::all();
        return view('auth.worker-final-registration',compact('districts', 'categories'));
    }

    public function marketerFinalRegistration(){

        $districts = District::all();
        $categories= WorkerServiceCategory::all();
        return view('auth.marketer-final-registration',compact('districts', 'categories'));
    }

    public function SendOtp($phone){
        if(User::where('phone',$phone)->exists()){
            return response()->json(['error' => 'This number already used']);
        }elseif(Cookie::get('otp_phone') !== null && Cookie::get('otp') !== null){
            return response()->json(['error' => 'OTP already sended']);
        }else{

            $fourRandomDigit = mt_rand(1000,9999);
            $url = "http://gsms.putulhost.com/smsapi";
            $data = [
                "api_key" => "C200049960e72e0d0d2272.47267153",
                "type" => "{text}",
                "contacts" => "$phone",
                "senderid" => "8809601001384",
                "msg" => "{Your OTP: $fourRandomDigit}",
            ];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            $response = curl_exec($ch);
            curl_close($ch);

            Cookie::queue('otp_phone', $phone, 600);
            // Cookie::queue('otp', $fourRandomDigit, 600);
            Cookie::queue('otp', 123456, 600);

            return response()->json(['success' => 'OTP Sended Successfully']);
        }
    }

    public function CheckOtp($phone,$otp){
        if (Cookie::get('otp_phone') == $phone) {
            if(Cookie::get('otp') == $otp){
                return response()->json(['success' => 'Verified']);
            }else{
                return response()->json(['error' => 'OTP not match']);
            }
        }else{
            return response()->json(['error' => 'Phone number not match']);
        }
    }

    //getWorkerRegisterForm
    public function getWorkerRegisterForm(){

        $districts = District::all();
        $categories= WorkerServiceCategory::all();
        return view('auth.worker-register',compact('districts', 'categories'));
    }

    //Submit worker register
    public function submitWorkerRegister(Request $request){
        // var_dump($request->all());
        // exit();
        
        //return response(['status' => true, 'message' => 'Success']);
        
        if(User::where('number',$request->nidNumber)->exists()){
            return response()->json([
                'type' => 'warning',
                'message' => 'এই এন.আই.ডি দিয়ে একটি একাউন্ট আছে, অন্য এন.আই.ডি দিয়ে চেষ্টা করুন অথবা অফিসে যোগাযোগ করুন।',
            ]);
        }
        $request->validate([
            'userName'      => 'required|string|max:20|unique:users,user_name',
            'fullName'      => 'required|string|max:50',
            'phone'         => 'required|string|max:16|min:11|unique:users',
            'gender'        => 'required|string|max:10',
            'password'      => 'required|min:6|max:50|confirmed',
            'district'      => 'required|exists:districts,id',
            'upazila'       => 'required|exists:upazilas,id',

            'nidNumber'     => 'required|unique:nids,number',
            'nidFrontImage' => 'required|image',
            'nidBackImage'  => 'required|image',
            'services'      => 'required',
        ]);


        /*
         * Custom password check
         */
        if ($request->input('password') != $request->input('password_confirmation')){
            return response()->json([
                'type' => 'warning',
                'message' => 'Password not match',
            ]);
        }
        $parent_id = 0;
        if($request->has('parent_id')){
            $parent_id = $request->input('parent_id');
        }
        /**
         * Custom service id check
         */
        // foreach(explode(",",$request->input('services')) as $service_id){
        //     if(!WorkerService::where('id', $service_id)->exists()) {
        //         return response()->json([
        //             'type' => 'warning',
        //             'message' => 'Invalid services',
        //         ]);
        //     }
        // }

        /**
         * Worker store with basic information
         * */
// die();
        $worker = new User();
        $worker->status       =   '0';
        $worker->role         =   'worker';
        $worker->full_name    =   $request->input('fullName');
        $worker->user_name    =   $request->input('userName');
        $worker->phone        =   $request->input('phone');
        $worker->worker_service   =   $request->input('services');
        $worker->gender       =   $request->input('gender');
        $worker->district_id  =   $request->input('district');
        $worker->upazila_id   =   $request->input('upazila');
        $worker->parent_worker_id   =   $parent_id;
        $pouroshava = [];
        $pouroshava_string = '';
        foreach (explode(',', $request->pouroshova) as $key => $value) {
            $words = Word::findOrFail($value);

            if (!in_array($words->puroshova_id, $pouroshava)){
                array_push($pouroshava, $words->puroshova_id);
            }
        }

        array_unique($pouroshava);
        $pouroshava_string = implode(",", $pouroshava);

        $worker->pouroshova_union_id   =   $pouroshava_string.',';
        $worker->word_road_id   =   $request->pouroshova.',';

        $worker->password     =   Hash::make($request->input('password'));
        $worker->number    = $request->input('nidNumber');
        $worker->balances    = get_static_option('free_balance_amount_for_worker');
        $worker->recharge_amount    = get_static_option('free_balance_amount_for_worker');

        //Refferral Code Insert
        if(Cookie::has('referral_code')){
            $referral_code = Cookie::get('referral_code');
            $referred_by_user = User::where('referral_code', $referral_code)->first();
            if($referred_by_user != null){
                $worker->referred_by = $referred_by_user->id;
                // $worker->save();
            }
        }else{
            $referred_by_user = User::where('referral_code', $request->input('referralCode'))->first();
            if($referred_by_user != null){
                $worker->referred_by   =   $request->input('referralCode');
                // $worker->save();
            }
        }

        //NID Front
        if($request->hasFile('nidFrontImage')){
            $image             = $request->file('nidFrontImage');
            $folder_path       = 'uploads/images/nid/';
            $image_new_name    = Str::random(8).'-nid-front-'.Carbon::now()->format('d-m-Y H-i-s') .'.'. $image->getClientOriginalExtension();
            //resize and save to server
            Image::make($image->getRealPath())->save($folder_path.$image_new_name);
            $worker->front_image    = $folder_path.$image_new_name;
        }

        //NID Back
        if($request->hasFile('nidBackImage')){
            $image             = $request->file('nidBackImage');
            $folder_path       = 'uploads/images/nid/';
            $image_new_name    = Str::random(8).'-nid-back-'.Carbon::now()->format('d-m-Y H-i-s') .'.'. $image->getClientOriginalExtension();
            //resize and save to server
            Image::make($image->getRealPath())->save($folder_path.$image_new_name);
            $worker->back_image    = $folder_path.$image_new_name;
        }


        if($request->hasFile('profilePicture')){
            $image             = $request->file('profilePicture');
            $folder_path       = 'uploads/images/users/';
            $image_new_name    = Str::random(8).'-profile-'.Carbon::now()->format('d-m-Y H-i-s') .'.'. $image->getClientOriginalExtension();
            //resize and save to server
            Image::make($image->getRealPath())->save($folder_path.$image_new_name);
            $worker->image    = $folder_path.$image_new_name;
        }
        $worker->save();


        //License Document 
        if($request->hasFile('licenseDocuments')){
            $file = new UserUsefulFile();

            $file->user_id = $worker->id;
            $file->title = 'License Document';
            $image             = $request->file('licenseDocuments');
            $folder_path       = 'uploads/images/usefullfile/';
            $image_new_name    = Str::random(8).'-usefull-file--'.Carbon::now()->format('d-m-Y H-i-s') .'.'. $image->getClientOriginalExtension();
            //resize and save to server
            $file->file    = $folder_path.$image_new_name;
            $image->move(public_path($folder_path), $image_new_name);

            $file->save();

        }
        

        /**
         * +Services
         * Worker ID & Service ID linked store in WorkerAndService Table
         * */

        // foreach(explode(",",$request->input('services')) as $service_id){
        //     $service = new WorkerAndService();
        //     $service->worker_id    = $worker->id;
        //     $service->service_id   = $service_id;
        //     $service->save();
        // }

        //Rating
        $rating = new Rating();
        $rating->user_id  = $worker->id;
        $rating->save();

        //Balance
        $rating = new Balance();
        $rating->user_id  = $worker->id;
        $rating->save();

        //Balance updated of referral owner
        if ($request->input('referralCode')){
            $selectedReferralOwnerBalance = Referral::where('own', $request->input('referralCode'))->first();
            if ($selectedReferralOwnerBalance) {
                if ($selectedReferralOwnerBalance->user->balance) {
                    $selectedReferralOwnerBalance->referral_income +=  get_static_option('per_worker_referral_price') ?? 0;
                    $selectedReferralOwnerBalance->save();
                }
            }
        }
        
        if($request->has('parent_id')){
            return response()->json([
                'type' => 'warning',
                'message' => 'আপনার একাউন্ট সফলভাবে তৈরি হয়েছে। আপনার সব ডকুমেন্ট চেক করে ২৪ ঘন্টার মধ্যে আপনার একাউন্ট এক্টিভ করা হবে। কাস্টমারদের নিরাপত্তার স্বার্থে আপনার মূল ডকুমেন্ট "aso" কর্তৃপক্ষ সংরক্ষণ করবে। আমাদেরকে পর্যাপ্ত সময় দিয়ে সহযোগিতা করার জন্য ধন্যবাদ। একাউন্ট এক্টিভ হলে তারপর "aso" তে আপনার সার্ভিস দিতে পারবেন। ২৪ ঘন্টার মধ্যে একাউন্ট এক্টিভ না হলে তারপরে আপনার উপজেলা / মেট্রোপলিটন থানার এরিয়া কন্ট্রোলার অফিসে মোবাইলে / ইমেলে / সরাসরি যোগাযোগ করুন। ',
                'url' => route('worker.profile.index'),
            ]);
        }

        /**
         * After all success auto login
         * */
        return response()->json([
            'type' => 'warning',
            'message' => 'আপনার একাউন্ট সফলভাবে তৈরি হয়েছে। আপনার সব ডকুমেন্ট চেক করে ২৪ ঘন্টার মধ্যে আপনার একাউন্ট এক্টিভ করা হবে। কাস্টমারদের নিরাপত্তার স্বার্থে আপনার মূল ডকুমেন্ট "aso" কর্তৃপক্ষ সংরক্ষণ করবে। আমাদেরকে পর্যাপ্ত সময় দিয়ে সহযোগিতা করার জন্য ধন্যবাদ। একাউন্ট এক্টিভ হলে তারপর "aso" তে আপনার সার্ভিস দিতে পারবেন। ২৪ ঘন্টার মধ্যে একাউন্ট এক্টিভ না হলে তারপরে আপনার উপজেলা / মেট্রোপলিটন থানার এরিয়া কন্ট্রোলার অফিসে মোবাইলে / ইমেলে / সরাসরি যোগাযোগ করুন। ',
            'url' => route('controller-list', $worker->upazila_id),
        ]);
    }


    //getMembershipRegisterForm
    public function getMembershipRegisterForm(){

        $districts = District::all();
        $categories= MembershipServiceCategory::all();
        return view('auth.membership-register',compact('districts', 'categories'));
    }

    //Submit membership register
    public function submitMembershipRegister(Request $request){
        if(User::where('number',$request->nidNumber)->exists()){
            return response()->json([
                'type' => 'warning',
                'message' => 'এই এন.আই.ডি দিয়ে একটি একাউন্ট আছে, অন্য এন.আই.ডি দিয়ে চেষ্টা করুন অথবা অফিসে যোগাযোগ করুন।',
            ]);
        }
        $request->validate([
            'profilePicture'=> 'required|image|max:5000',
            'userName'      => 'required|string|max:20|unique:users,user_name',
            'fullName'      => 'required|string|max:50',
            'phone'         => 'required|string|max:16|min:11|unique:users',
            'gender'        => 'required|string|max:10',
            'password'      => 'required|min:6|max:50|confirmed',
            'district'      => 'required|exists:districts,id',
            'upazila'       => 'required|integer|exists:upazilas,id',

            'nidNumber'     => 'required|unique:nids,number',
            'nidFrontImage' => 'required|image',
            'nidBackImage'  => 'required|image',
            'services'      => 'required',

     
        ]);

        /*
         * Custom password check
         */
        if ($request->input('password') != $request->input('password_confirmation')){
            return response()->json([
                'type' => 'warning',
                'message' => 'Password not match',
            ]);
        }
        /**
         * Custom service id check
         */
        foreach(explode(",",$request->input('services')) as $service_id){
            if(!MembershipService::where('id', $service_id)->exists()) {
                return response()->json([
                    'type' => 'warning',
                    'message' => 'Invalid services',
                ]);
            }
        }

        /**
         * membership store with basic information
         * */

        $membership = new User();
        $membership->role         =   'membership';
        $membership->full_name    =   $request->input('fullName');
        $membership->user_name    =   $request->input('userName');
        $membership->phone        =   $request->input('phone');
        $membership->gender       =   $request->input('gender');
        $membership->upazila_id   =   $request->input('upazila');
        $membership->password     =   Hash::make($request->input('password'));


        if($request->hasFile('profilePicture')){
            $image             = $request->file('profilePicture');
            $folder_path       = 'uploads/images/users/';
            $image_new_name    = Str::random(8).'-profile-'.Carbon::now()->format('d-m-Y H-i-s') .'.'. $image->getClientOriginalExtension();
            //resize and save to server
            Image::make($image->getRealPath())->save($folder_path.$image_new_name);
            $membership->image    = $folder_path.$image_new_name;
        }
        $membership->save();

        //Refferral Code Insert
        if(Cookie::has('referral_code')){
            $referral_code = Cookie::get('referral_code');
            $referred_by_user = User::where('referral_code', $referral_code)->first();
            if($referred_by_user != null){
                $membership->referred_by = $referred_by_user->id;
                $membership->save();
            }
        }else{
            $referred_by_user = User::where('referral_code', $request->input('referralCode'))->first();
            if($referred_by_user != null){
                $membership->referred_by =  $request->input('referralCode');
                $membership->save();
            }
          
        }

        /**
         * +NID
         * NID number, front image, back image store in NID table
         * */
        //NID store
        $nid = new Nid();
        $nid->user_id   = $membership->id;
        $nid->number    = $request->input('nidNumber');
        //NID Front
        if($request->hasFile('nidFrontImage')){
            $image             = $request->file('nidFrontImage');
            $folder_path       = 'uploads/images/nid/';
            $image_new_name    = Str::random(8).'-nid-front-'.Carbon::now()->format('d-m-Y H-i-s') .'.'. $image->getClientOriginalExtension();
            //resize and save to server
            Image::make($image->getRealPath())->save($folder_path.$image_new_name);
            $membership->front_image    = $folder_path.$image_new_name;
        }

        //NID Back
        if($request->hasFile('nidBackImage')){
            $image             = $request->file('nidBackImage');
            $folder_path       = 'uploads/images/nid/';
            $image_new_name    = Str::random(8).'-nid-back-'.Carbon::now()->format('d-m-Y H-i-s') .'.'. $image->getClientOriginalExtension();
            //resize and save to server
            Image::make($image->getRealPath())->save($folder_path.$image_new_name);
            $membership->back_image    = $folder_path.$image_new_name;
        }
        $nid->save();

        /**
         * +Services
         * Worker ID & Service ID linked store in WorkerAndService Table
         * */
        foreach(explode(",",$request->input('services')) as $service_id){
            $service = new MembershipAndService();
            $service->membership_id    = $membership->id;
            $service->service_id   = $service_id;
            $service->save();
        }

        //Rating
        $rating = new Rating();
        $rating->user_id  = $membership->id;
        $rating->save();

        //Balance
        $rating = new Balance();
        $rating->user_id  = $membership->id;
        $rating->save();

        //Balance updated of referral owner
        if ($request->input('referralCode')){
            $selectedReferralOwnerBalance = Referral::where('own', $request->input('referralCode'))->first()->user->balance;
            $selectedReferralOwnerBalance->referral_income += get_static_option('per_membership_referral_price') ?? 0;
            $selectedReferralOwnerBalance->save();
        }

        /**
         * After all success auto login
         * */
        if(Auth::attempt(['phone' => $membership->phone, 'password' => $request->input('password'), 'status' => 1])) {
            Auth::user()->last_login_at = Carbon::now();
            Auth::user()->save();
            return response()->json([
                'type' => 'success',
                'message' => 'Successfully created',
            ]);
        }else{
            return response()->json([
                'type' => 'warning',
                'message' => 'Successfully created',
            ]);
        }
    }

    // :::::::::::::::: Get Marketer Registration Form
    public function getMarketerRegisterForm(Request $request){

        //dd($request->referral_code);
        if($request->has('referral_code')){
            Cookie::queue('referral_code', $request->referral_code, 43200);
        }
        $districts = District::all(); 
        return view('auth.marketer-register',compact('districts'));
    }


    // :::::::::::::::: Submit Marketer Registration Form
    
    public function submitMarketerRegister(Request $request){
        
      
        $request->validate([
            'userName'      => 'required|string|max:20|unique:users,user_name',
            'fullName'      => 'required|string|max:50',
            'phone'         => 'required|string|max:16|min:11|unique:users', 
            'email'         => 'email', 
            'password'      => 'required|min:6|max:50|confirmed',
            'district'      => 'required|exists:districts,id',
            'upazila'       => 'required|integer|exists:upazilas,id',
            'address'       => 'string',
 
        ]);

        /*
         * Custom password check
         */
        if ($request->input('password') != $request->input('password_confirmation')){
            return response()->json([
                'type' => 'warning',
                'message' => 'Password not match',
            ]);
        }
     

        /**
         * membership store with basic information
         * */ 
        $marketer = new User();
        $marketer->role         =   'marketer';
        $marketer->full_name    =   $request->input('fullName');
        $marketer->user_name    =   $request->input('userName');
        $marketer->phone        =   $request->input('phone');
        $marketer->email        =   $request->input('email'); 
        $marketer->district_id  =   $request->input('district');
        $marketer->upazila_id   =   $request->input('upazila');
        $marketer->pouroshova_union_id   =   $request->input('pouroshova');
        $marketer->word_road_id   =   $request->input('word');
        $marketer->address   =   $request->input('address'); 
        $marketer->password     =   Hash::make($request->input('password'));


        if($request->hasFile('profilePicture')){
            $image             = $request->file('profilePicture');
            $folder_path       = 'uploads/images/users/';
            $image_new_name    = Str::random(8).'-profile-'.Carbon::now()->format('d-m-Y H-i-s') .'.'. $image->getClientOriginalExtension();
            //resize and save to server
            Image::make($image->getRealPath())->save($folder_path.$image_new_name);
            $marketer->image    = $folder_path.$image_new_name;
        }
        $marketer->save();

        //Rating
        $rating = new Rating();
        $rating->user_id  = $marketer->id;
        $rating->save();


        //Refferral Code Insert
        if(Cookie::has('referral_code')){
            $referral_code = Cookie::get('referral_code');
            $referred_by_user = User::where('referral_code', $referral_code)->first();
            if($referred_by_user != null){
                $marketer->referred_by = $referred_by_user->id;
                $marketer->save();
            }
        }else{
            $referred_by_user = User::where('referral_code', $request->input('referralCode'))->first();
            if($referred_by_user != null){
                $marketer->referred_by   =   $request->input('referralCode');
                $marketer->save();
            }
        }
      
        //Affiliate User Create
        if ($marketer->id != null) {
            $affiliate_user = new AffiliateUser();
            $affiliate_user->user_id = $marketer->id;
            $affiliate_user->status = 1;
            $affiliate_user->save();
        }

        /**
         * After all success auto login
         * */
        if(Auth::attempt(['phone' => $marketer->phone, 'password' => $request->input('password'), 'status' => 1])) {
            Auth::user()->last_login_at = Carbon::now();
            Auth::user()->save();
            return response()->json([
                'type' => 'success',
                'message' => 'Successfully created',
            ]);
        }else{
            return response()->json([
                'type' => 'warning',
                'message' => 'Successfully created',
            ]);
        }
    }

}
