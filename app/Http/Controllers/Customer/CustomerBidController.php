<?php

namespace App\Http\Controllers\Customer;

use App\Complain;
use App\CustomerBid;
use App\Http\Controllers\Controller;
use App\Notifications\CustomerBidNotification;
use App\Notifications\CustomerWorkComplete;
use App\Notifications\CustomerWorkCancel;
use App\Notifications\CustomerPriceIncrease;
use App\Referral;
use App\User;
use App\AffiliateBonus;
use App\WorkerGig;
use App\ServiceBid;
use App\PageService;
use App\ServiceReview;
use App\ServiceComplain;
use App\RattingReview;
use App\UserAccountHistory;
use App\WorkerPage;
use App\WorkerService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;
use Intervention\Image\ImageManagerStatic as Image;
use Cookie;
use App\AffiliateOption;

use Helper;

class CustomerBidController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'gig'               => 'required|string|exists:worker_gigs,id',
            'description'       => 'required|string|min:15|max:5000',
            'address'           => 'required|string|min:3|max:200',
            'date'           => 'required',
            'time'           => 'required',
        ]);

        $customerBid = new CustomerBid();
        $customerBid->customer_id = auth()->user()->id;
        
        //:::::::: Save Gig Refferral Code
        if(Cookie::has('referred_gig_id') && Cookie::get('referred_gig_id') == $request->input('gig')) { 
            $customerBid->gig_refferral_code = Cookie::get('gig_referral_code');
        }
        //::::::: Save Gig Refferral Code

        $customerBid->worker_gig_id = $request->input('gig');
        $customerBid->budget = WorkerGig::find($request->input('gig'))->budget;
        $customerBid->date = $request->input('date');
        $customerBid->time = $request->input('time');
        $customerBid->description = $request->input('description');
        $customerBid->address = $request->input('address');
        $customerBid->save();

        $customerBid->workerGig->worker->notify(new CustomerBidNotification($customerBid)); //Notification send to worker

        $gig = WorkerGig::find($request->input('gig'));
        // store account history 
        UserAccountHistory::isertIntoAccountHistory($customerBid->id, 'worker', $gig->worker_id, auth()->user()->id, 'gig', $gig->id, $gig->budget, $request->input('date'), $request->input('time'),$gig->day, 0.00, 0.00, 0.00, 'pending');

        return $customerBid;

    }

    public function servicestore(Request $request){
        $request->validate([
            'service'               => 'required|int|exists:page_services,id',
            'description'       => 'required|string|min:15|max:5000',
            'address'           => 'required|string|min:3|max:200',
            'date'           => 'required',
            'time'           => 'required',
        ]);
        $serviceBid = new ServiceBid();
        $serviceBid->customer_id = auth()->user()->id;

        $serviceBid->worker_service_id = $request->input('service');
        $serviceBid->worker_id = PageService::find($request->input('service'))->worker_id;
        $serviceBid->budget = PageService::find($request->input('service'))->budget;
        $serviceBid->description = $request->input('description');
        $serviceBid->address = $request->input('address');
        $serviceBid->date = $request->input('date');
        $serviceBid->time = $request->input('time');
        $serviceBid->save();

        // $pageBid->workerGig->worker->notify(new CustomerBidNotification($customerBid)); //Notification send to worker
        $service = PageService::find($request->input('service'));

        $date = date('Y-m-d', strtotime('+'.$service->day.' days'));

        UserAccountHistory::isertIntoAccountHistory($serviceBid->id, 'worker', $serviceBid->worker_id, auth()->user()->id, 'page', $service->id, $service->budget, $date, '', $service->day, 0.00, 0.00, 0.00, 'pending');


        session(['service_click' => TRUE, 'pending_service_click' => TRUE]);

        return $serviceBid;
    }
    
    public function otpCheck(Request $request){
        $bid_id = $request->bid_id;
        $otp = $request->otp;
        $customerBid = CustomerBid::find($bid_id);
        if($otp ==  $customerBid->otp_code){
            return response()->json([
                'type' => 'success',
                'message' => 'OTP Verified',
            ]);
        }else{
            return response()->json([
                'type' => 'error',
                'message' => 'Wrong OTP',
            ]);
        }
    }

    public function show($id){

        $customerBid = CustomerBid::find(Crypt::decryptString($id));
        if ($customerBid->customer->id == Auth::user()->id){
            return view('customer.job.show-customer-bid', compact('customerBid'));
        }else{
            return redirect()->back();
        }
    }

    public function showservice($id){
        $serviceBid = ServiceBid::find(Crypt::decryptString($id));
        if ($serviceBid->customer_id == Auth::user()->id){
            return view('customer.job.show-customer-service-bid', compact('serviceBid'));
        }else{
            return redirect()->back();
        }
    }

    public function cancel(Request $request){
        $request->validate([
            'bid'    => 'required|exists:customer_bids,id',
        ]);
        $customerBid = CustomerBid::find($request->input('bid'));
        if ($customerBid->customer->id == Auth::user()->id){
            $customerBid->status = 'cancelled';
            $customerBid->save();

            UserAccountHistory::updateStatus($customerBid->id, 'cancelled');

            $customerBid->workerGig->worker->notify(new CustomerBidNotification($customerBid)); //Notification send to worker
            //Add in canceller list
            $cancelJob = new \App\CancelJob();
            $cancelJob->type = 'customer-bid';
            $cancelJob->canceller_id = Auth::user()->id;
            $cancelJob->job_id = $customerBid->id;
            $cancelJob->save();

            return response()->json([
                'type' => 'success',
                'message' => 'Successfully bid cancelled',
            ]);
        }else{
            return response()->json([
                'type' => 'danger',
                'message' => 'operation denied',
            ]);
        }
    }

    public function cancelserviceBid(Request $request){
        $request->validate([
            'service'    => 'required|exists:service_bids,id',
        ]);
        $serviceBid = ServiceBid::find($request->input('service'));
        if ($serviceBid->customer_id == Auth::user()->id){
            $serviceBid->status = 'cancelled';
            $serviceBid->save();

            // $pageBid->workerGig->worker->notify(new CustomerBidNotification($customerBid)); //Notification send to worker
            //Add in canceller list
            $cancelservice = new \App\CancelService();
            $cancelservice->type = 'service-bid';
            $cancelservice->canceller_id = Auth::user()->id;
            $cancelservice->service_id = $serviceBid->id;
            $cancelservice->save();
            
            UserAccountHistory::updateStatus($serviceBid->id, 'cancelled');

            return response()->json([
                'type' => 'success',
                'message' => 'Successfully service cancelled',
            ]);
        }else{
            return response()->json([
                'type' => 'danger',
                'message' => 'operation denied',
            ]);
        }
    }

    public function updateBudget (Request $request){
        $request->validate([
            'bid'    => 'required|exists:customer_bids,id',
            'budget' => 'required|numeric|min:1',
        ]);
        $bid = CustomerBid::find($request->input('bid'));
        if ($bid->customer->id == Auth::user()->id){
            if ($bid->budget > $request->input('budget')){
                return response()->json([
                    'type' => 'warning',
                    'message' => 'This price is not acceptable',
                ]);
            }else{
                $bid->budget = $request->input('budget');
                $bid->save();

                UserAccountHistory::updateBudget($bid->id, $request->input('budget'));

                $bid->workerGig->worker->notify(new CustomerPriceIncrease($bid)); //Notification send to worker

                return response()->json([
                    'type' => 'success',
                    'message' => 'Successfully price updated',
                ]);
            }
        }else{
            return response()->json([
                'type' => 'danger',
                'message' => 'Not permitted',
            ]);
        }
    }

    public function updateserviceBidBudget(Request $request){
        $request->validate([
            'service' => 'required|exists:service_bids,id',
            'budget' => 'required|numeric'
        ]);

        $service = ServiceBid::find($request->input('service'));
        if ($service->customer_id == Auth::user()->id){
            if ($service->budget > $request->input('budget')){
                return response()->json([
                    'type' => 'warning',
                    'message' => 'This price is not acceptable',
                ]);
            }else{
                $service->budget = $request->input('budget');
                $service->save();

                UserAccountHistory::updateBudget($service->id, $request->input('budget'));

                return response()->json([
                    'type' => 'success',
                    'message' => 'Successfully Price Updated',
                ]);
            }
        }else{
            return response()->json([
                'type' => 'danger',
                'message' => 'Not permitted',
            ]);
        }
    }
    public function acceptServiceBidBudget(Request $request){
        $request->validate([
            'service' => 'required|exists:service_bids,id',
            'budget' => 'required|numeric'
        ]);

        $service = ServiceBid::find($request->input('service'));
        if ($service->customer_id == Auth::user()->id){
            if ($service->budget > $request->input('budget')){
                return response()->json([
                    'type' => 'warning',
                    'message' => 'This price is not acceptable',
                ]);
            }else{
                $service->budget = $request->input('budget');
                $service->proposed_budget = NULL;
                $service->save();

                UserAccountHistory::updateBudget($service->id, $request->input('budget'));
                return response()->json([
                    'type' => 'success',
                    'message' => 'Successfully Budget Accepted',
                ]);
            }
        }else{
            return response()->json([
                'type' => 'danger',
                'message' => 'Not permitted',
            ]);
        }
    }
    public function cancelServiceBidBudget(Request $request){
        $request->validate([
            'service' => 'required|exists:service_bids,id',
            'budget' => 'required|numeric'
        ]);

        $service = ServiceBid::find($request->input('service'));
        if ($service->customer_id == Auth::user()->id){
            
            $service->proposed_budget = NULL;
            $service->save();
            return response()->json([
                'type' => 'success',
                'message' => 'Budget Cancelled Successfully',
            ]);

        }else{
            return response()->json([
                'type' => 'danger',
                'message' => 'Not permitted',
            ]);
        }
    }

    public function acceptGigBidBudget(Request $request){
        $request->validate([
            'bid' => 'required|exists:customer_bids,id',
            'budget' => 'required|numeric'
        ]);

        $bid = CustomerBid::find($request->input('bid'));
        if ($bid->customer_id == Auth::user()->id){
            if ($bid->budget > $request->input('budget')){
                return response()->json([
                    'type' => 'warning',
                    'message' => 'This price is not acceptable',
                ]);
            }else{
                $bid->budget = $request->input('budget');
                $bid->proposed_budget = NULL;
                $bid->save();

                UserAccountHistory::updateBudget($bid->id, $request->input('budget'));

                return response()->json([
                    'type' => 'success',
                    'message' => 'Successfully Budget Accepted',
                ]);
            }
        }else{
            return response()->json([
                'type' => 'danger',
                'message' => 'Not permitted',
            ]);
        }
    }
    public function cancelGigBidBudget(Request $request){
        $request->validate([
            'bid' => 'required|exists:customer_bids,id',
            'budget' => 'required|numeric'
        ]);

        $bid = CustomerBid::find($request->input('bid'));
        if ($bid->customer_id == Auth::user()->id){
            $bid->proposed_budget = NULL;
            $bid->save();
            return response()->json([
                'type' => 'success',
                'message' => 'Budget Cancelled Successfully',
            ]);

        }else{
            return response()->json([
                'type' => 'danger',
                'message' => 'Not permitted',
            ]);
        }
    }

    public function imageUploadToJob(Request $request){
        $request->validate([
            'bid' => 'required|exists:customer_bids,id',
            'image' => 'required|image'
        ]);
        $bid = CustomerBid::find($request->input('bid'));
        if ($bid->image){
            return response()->json([
                'type' => 'warning',
                'message' => 'Image already exist.',
            ]);
        }else{
            if($request->hasFile('image')){
                $image             = $request->file('image');
                $folder_path       = 'uploads/images/jobs/';
                $image_new_name    = Str::random(8).'-jobs-'.'-'.Carbon::now()->format('d-m-Y H-i-s') .'.'. $image->getClientOriginalExtension();
                //resize and save to server
                Image::make($image->getRealPath())->save($folder_path.$image_new_name);
                $bid->image    = $folder_path.$image_new_name;
            }
            $bid->save();
            return response()->json([
                'type' => 'success',
                'message' => 'Image successfully uploaded.',
            ]);
        }
    }


    public function imageUploadToServiceBid(Request $request){
        $request->validate([
            'bid' => 'required|exists:service_bids,id',
            'image' => 'required|image'
        ]);
        $bid = ServiceBid::find($request->input('bid'));
        if ($bid->image){
            return response()->json([
                'type' => 'warning',
                'message' => 'Image already exist.',
            ]);
        }else{
            if($request->hasFile('image')){
                $image             = $request->file('image');
                $folder_path       = 'uploads/images/jobs/';
                $image_new_name    = Str::random(8).'-jobs-'.'-'.Carbon::now()->format('d-m-Y H-i-s') .'.'. $image->getClientOriginalExtension();
                //resize and save to server
                Image::make($image->getRealPath())->save($folder_path.$image_new_name);
                $bid->image    = $folder_path.$image_new_name;
            }
            $bid->save();
            return response()->json([
                'type' => 'success',
                'message' => 'Image successfully uploaded.',
            ]);
        }
    }

    public function completedJobAndRating(Request $request){

        $request->validate([
            'bid' => 'required|exists:customer_bids,id',
        ]);
        $bid = CustomerBid::find($request->input('bid'));
        // dd($bid->workerGig->worker->referred_by);
        if ($bid->customer_id == Auth::user()->id){
            $bid->status = 'completed';
            $bid->save(); //Job status updated
            
            $bid->workerGig->worker->notify(new CustomerWorkComplete($bid)); //Notification send to worker



            //Rating 
            $bid->workerGig->worker->rating->max_rate +=  5;
            $bid->workerGig->worker->rating->save();

            // // get categorywise comission 
            $commission = $bid->customerGig->service->comission_rate ?? 0;
            $marketer_commison = $bid->customerGig->service->marketer_comission ?? 0;
    
            //dd($commission);
            
            
            // //Worker balance update
            $bid->workerGig->worker->balance->job_income += $bid->budget - ($bid->budget * $commission) /100  ;
            
            $after_comision = $bid->budget - ($bid->budget * $commission) /100;
            $bid->workerGig->worker->balance->due +=  $after_comision;



            $service_change = $bid->budget - $after_comision;
            $bid->workerGig->worker->balance->service_change += $service_change;

            // var_dump($bid->workerGig->worker->balance->service_change);
            // exit();

            $bid->workerGig->worker->balance->save();


            $user = User::find($bid->workerGig->worker->id);
            $user->recharge_amount -= $service_change;
            $user->save();

            $earning = $bid->budget - $service_change;
            UserAccountHistory::updateEarnings($bid->id, $service_change, $after_comision, $earning);
            UserAccountHistory::updateStatus($bid->id, 'completed');

            // // :::::::: Save Refferral bonus amount for marketer
            // $bid->workerGig->service->comission_rate;
            // Order Comission
            $amount = 0;
            
            // First Number Order Commison Save
            if ($user->referred_by != null && $bid->gig_refferral_code == null) {
                $customer_first_number_order = get_static_option('customer_first_number_order');
                $customer_bid = CustomerBid::where('customer_id', auth()->user()->id)->count();
                if ($customer_bid <= $customer_first_number_order) {
                    $referred_by_user = User::where('referral_code', $user->referred_by)->first();
                    if ($referred_by_user != null) {
                        $amount = $bid->workerGig->service->marketer_comission * $bid->budget / 100;

                        $affiliate_user = $referred_by_user->affiliate_user;
                        if ($affiliate_user != null) {
                            $affiliate_user->balance += $amount;
                            $affiliate_user->save();

                            //save bonus details
                            affiliate_save($referred_by_user->id, $bid->customer_id, $amount, 'Customer Signup', $bid->id, $bid->budget);
                            /*$current_month = date("F");
                            $current_year = date("Y");
                            $affiliate_bonus = new AffiliateBonus;
                            $affiliate_bonus->affiliate_user_id = ;
                            $affiliate_bonus->user_id = $bid->customer_id;
                            $affiliate_bonus->amount = $amount;
                            $affiliate_bonus->month = $current_month;
                            $affiliate_bonus->year = $current_year;
                            $affiliate_bonus->bonus_purpose = 'Customer Signup';
                            $affiliate_bonus->order_id = $bid->id;
                            $affiliate_bonus->save();*/
                        }
                    }
                }
            }
            /*Order Commision*/
            if($bid->gig_refferral_code != null)
            {
                $referred_by_user = User::where('referral_code', $bid->gig_refferral_code)->first();

                if($referred_by_user != null){ 
                    $amount = $bid->workerGig->service->marketer_comission * $bid->budget/100;
                    
                    $affiliate_user = $referred_by_user->affiliate_user;
                        if($affiliate_user != null){
                            $affiliate_user->balance += $amount;
                            $affiliate_user->save();

                            //save bonus details
                            affiliate_save($referred_by_user->id, $bid->customer_id, $amount, 'Order Commission', $bid->id, $bid->budget);
                            /*$current_month = date("F");
                            $current_year = date("Y");
                            $affiliate_bonus = new AffiliateBonus;
                            $affiliate_bonus->affiliate_user_id = $referred_by_user->id;
                            $affiliate_bonus->user_id = $bid->customer_id;
                            $affiliate_bonus->amount = $amount;
                            $affiliate_bonus->month = $current_month;
                            $affiliate_bonus->year = $current_year;
                            $affiliate_bonus->bonus_purpose = 'Order Commission';
                            $affiliate_bonus->order_id = $bid->id;
                            $affiliate_bonus->save();*/
                            
                        }
                }
            }

            //Worker Registration Or refferral
            if ($bid->workerGig->worker->referred_by != null && $bid->workerGig->worker->balance->job_income >= get_static_option('job_complete_amount') &&$bid->workerGig->worker->balance->is_registration_comission == 0) {
 
                    $user = User::where('referral_code',$bid->workerGig->worker->referred_by)->first();
                    $_has_already = AffiliateBonus::where('affiliate_user_id',$user->id)->where('bonus_purpose', 'Worker Signup')->count();
                    if ($user != null && $_has_already < 1) {
                        $reffer_amount = get_static_option('worker_registration_commission_amount');
                        $affiliate_user = $user->affiliate_user;
                        if($affiliate_user != null){
                            $bid->workerGig->worker->balance->is_registration_comission = 1;
                            $affiliate_user->balance += $reffer_amount;
                            $affiliate_user->save();

                            //save bonus details
                            affiliate_save($user->id, $bid->customer_id, $reffer_amount, 'Worker Signup', $bid->id);
                            /*$current_month = date("F");
                            $current_year = date("Y");
                            $affiliate_bonus = new AffiliateBonus;
                            $affiliate_bonus->affiliate_user_id = $user->id;
                            $affiliate_bonus->user_id = $bid->customer_id;
                            $affiliate_bonus->amount = $reffer_amount;
                            $affiliate_bonus->month = $current_month;
                            $affiliate_bonus->year = $current_year;
                            $affiliate_bonus->bonus_purpose = 'Worker Signup';
                            $affiliate_bonus->order_id = $bid->id;
                            $affiliate_bonus->save();*/

                        }
                    }
                
            }
            //Worker Registration Or refferral

            // :::::::: Save Refferral bonus amount for marketer

            //Worker balance update
            // $bid->workerGig->worker->balance->job_income += $bid->budget;
            

            /*
            //Balance updated of referral owner
            if (\auth()->user()->referral->by){
                $selectedReferralOwnerBalance = Referral::where('own', auth()->user()->referral->by)->first()->user->balance;
            }
            */

            

            if ($request->input('rate') > 0){
                $bid->workerGig->worker->rating->rate +=  $request->input('rate');
                $bid->workerGig->worker->rating->rateGivenBy +=  1;
                $bid->workerGig->worker->rating->save();

                $review = new RattingReview();
                $review->user_id = $bid->workerGig->worker->id;
                $review->purpose = 'Bid';
                $review->porpuse_id = $bid->worker_gig_id;
                $review->givenBy = Auth::user()->id;
                $review->rate = $request->input('rate');
                $review->review = $request->input('complete_review');
                $review->save();

                return response()->json([
                    'type' => 'success',
                    'message' => 'Successfully job completed with star-'.$request->input('rate'),
                ]);
            }else{
                return response()->json([
                    'type' => 'success',
                    'message' => 'Successfully job completed',
                ]);
            }

        }else{
            return redirect()->back();
        }
    }

    public function completedServiceAndRating(Request $request){
        $request->validate([
            'service' => 'required|exists:service_bids,id',
            'rate' => 'required|int',
            'review' => 'required',
        ]);
        // id, service_bid_id, worker_service_id, worker_d, customet_id, rating, review
        
        $bid = ServiceBid::find($request->input('service'));
        // dd($bid->workerGig->worker->referred_by);
        if ($bid->customer_id == Auth::user()->id){

            $bid->status = 'completed';
            $bid->save(); //Job status updated


            // // get categorywise comission 
            // $pages = WorkerPage::where('worker_id', $bid->worker_id)->where('status', 1)->get();

            // foreach ($pages as $page) {
            //     if (in_array($bid->worker_service_id, explode(',', $page->worker_services))) {
            //         $page_category = explode(',', $page->services);
            //     }
            // }
            
            // $worker_service = WorkerService::find($page_category[0]);
            // $commission = $worker_service->comission_rate;
            
            // //Worker balance update
            // $worker = User::find($bid->worker_id);
            // $worker->balance->job_income += $bid->budget - ($bid->budget * $commission) /100  ;
            
            // $after_comision = $bid->budget - ($bid->budget * $commission) /100;
            // $worker->balance->due +=  $after_comision;

            // $service_change = $bid->budget - $after_comision;
            // $worker->balance->service_change += $service_change;

            // var_dump($bid->workerGig->worker->balance->service_change);
            // exit();

            // $worker->balance->save();


            // $user = User::find($bid->workerGig->worker->id);
            // $worker->recharge_amount -= $service_change;
            // $worker->save();

            $earning = $bid->budget;
            
            UserAccountHistory::updateEarnings($bid->id, 0, 0, $earning);
            UserAccountHistory::updateStatus($bid->id, 'completed');


            // $bid->workerGig->worker->notify(new CustomerWorkComplete($bid)); //Notification send to worker

            if ($request->input('rate') > 0){
                $review = new ServiceReview();

                $review->service_bid_id = $bid->id;
                $review->worker_service_id = $bid->worker_service_id;
                $review->worker_id = $bid->worker_id;
                $review->customer_id = $bid->customer_id;
                $review->rating = $request->input('rate');
                $review->review = $request->input('review');
                $review->save();

                return response()->json([
                    'type' => 'success',
                    'message' => 'Successfully job completed with star-'.$request->input('rate'),
                ]);
            }else{
                return response()->json([
                    'type' => 'success',
                    'message' => 'Successfully job completed',
                ]);
            }

        }else{
            return redirect()->back();
        }
    }

    public function completedServiceAndComplain(Request $request){
        $request->validate([
            'serviceBid' => 'required|exists:service_bids,id',
            'complain' => 'required|string',
        ]);
        // id, service_bid_id, worker_service_id, worker_d, customet_id, rating, review
        
        $bid = ServiceBid::find($request->input('serviceBid'));
        // dd($bid->workerGig->worker->referred_by);
        if ($bid->customer_id == Auth::user()->id){
            // $bid->status = 'completed';
            // $bid->proposed_budget = NULL;
            // $bid->save(); //Job status updated

            // $bid->workerGig->worker->notify(new CustomerWorkComplete($bid)); //Notification send to worker

            //Complain
            $complain = new ServiceComplain();
            $complain->complainer_id = Auth::user()->id;
            $complain->service_bid_id = $request->input('serviceBid');
            $complain->complain = $request->input('complain');
            $complain->is_completed = 1;
            $complain->completed_by_id = Auth::user()->id;
            $complain->save();

            return response()->json([
                'type' => 'success',
                'message' => 'Your complain successfully submited!',
            ]);

        }else{
            return redirect()->back();
        }
    }

    public function updateServiceRating(Request $request){
        $request->validate([
            'review_id' => 'required|exists:service_reviews,id',
            'rate' => 'required|int',
            'review' => 'required',
        ]);
        // id, service_bid_id, worker_service_id, worker_d, customet_id, rating, review
        
        $review = ServiceReview::find($request->input('review_id'));
        // dd($bid->workerGig->worker->referred_by);
        if ($review->customer_id == Auth::user()->id){
            $review->rating = $request->input('rate');
            $review->review = $request->input('review');
            $review->save(); //Job status updated

            // $bid->workerGig->worker->notify(new CustomerWorkComplete($bid)); //Notification send to worker
            return response()->json([
                'type' => 'success',
                'message' => 'Successfully rating updated with star-'.$request->input('rate'),
            ]);

        }else{
            return redirect()->back();
        }
    }

    // customer bid complain
    public function completedJobAndComplain(Request $request){

        $request->validate([
            'bid' => 'required|exists:customer_bids,id',
            'complain' => 'required|string',
        ]);

        $bid = CustomerBid::find($request->input('bid'));

        if ($bid->customer_id == Auth::user()->id){
            // $bid->status = 'completed';
            // $bid->save(); //Job status updated

            $bid->workerGig->worker->notify(new CustomerWorkCancel($bid)); //Notification send to worker

            //Rating
            // $bid->workerGig->worker->rating->max_rate +=  5;
            // $bid->workerGig->worker->rating->save();

            //Worker balance update
            // $bid->workerGig->worker->balance->job_income += $bid->budget;
            // $bid->workerGig->worker->balance->due += (get_static_option('admin_percent_on_worker_job')/100) * $bid->budget;
            // $bid->workerGig->worker->balance->save();

            //Complain
            $complain = new Complain();
            $complain->complainer_id = Auth::user()->id;
            $complain->purpose_id = $request->input('bid');
            $complain->complain = $request->input('complain');
            $complain->save();

            /*
            //Balance updated of referral owner
            if (\auth()->user()->referral->by){
                $selectedReferralOwnerBalance = Referral::where('own', auth()->user()->referral->by)->first()->user->balance;
            }
            */
            return response()->json([
                'type' => 'success',
                'message' => 'Successfully job comlpained',
            ]);
        }else{
            return redirect()->back();
        }

    }
}
