<?php

namespace App\Http\Controllers\Worker;

use App\CustomerBid;
use App\Http\Controllers\Controller;
use App\Notifications\WorkerWorkComplete;
use App\UserAccountHistory;
use App\WorkerBid;
use App\CustomerGig;
use App\WorkerGig;
use App\User;
use App\AffiliateBonus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use DB;

class CustomerBidController extends Controller
{
    /**
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id){

        $customerBid = CustomerBid::find(Crypt::decryptString($id));
        return view('worker.job.show-customer-bid',compact('customerBid'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateCustomerBidBudget(Request $request){
        $request->validate([
            'bid' => 'required|exists:customer_bids,id',
            'budget' => 'required|numeric'
        ]);

        $bid = CustomerBid::find($request->input('bid'));
        if ($bid->workerGig->worker->id == Auth::user()->id){
            if ($bid->budget > $request->input('budget')){
                return response()->json([
                    'type' => 'warning',
                    'message' => 'This price is not acceptable',
                ]);
            }else{
                $bid->proposed_budget = $request->input('budget');
                $bid->save();

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

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function acceptCustomerBid(Request $request){
        $request->validate([
            'bid' => 'required|exists:customer_bids,id',
        ]);
        $otp = str_pad(random_int(0,9999), 2 , '0', STR_PAD_LEFT);
        $bid = CustomerBid::find($request->input('bid'));
        if ($bid->workerGig->worker->id == Auth::user()->id){
            $bid->status = 'running';
            $bid->otp_code = $otp;
            $bid->worker_id = $request->input('worker_id');
            $bid->save();

            UserAccountHistory::updateStatus($bid->id, 'running');

            return response()->json([
                'type' => 'success',
                'message' => 'Successfully accepted',
            ]);

        }else{
            return response()->json([
                'type' => 'danger',
                'message' => 'Not permitted',
            ]);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function rejectCustomerBid(Request $request){
        $request->validate([
            'bid' => 'required|exists:customer_bids,id',
        ]);

        $bid = CustomerBid::find($request->input('bid'));
        if ($bid->workerGig->worker->id == Auth::user()->id){
            $bid->status = 'cancelled';
            $bid->save();

            UserAccountHistory::updateStatus($bid->id, 'cancelled');

            return response()->json([
                'type' => 'success',
                'message' => 'Successfully cancelled',
            ]);

        }else{
            return response()->json([
                'type' => 'danger',
                'message' => 'Not permitted',
            ]);
        }
    }


    public function completedJob(Request $request){

            $bid = WorkerBid::find($request->input('bid'));

            $bid->status = 'running';
            $bid->save(); //Job status updated

            $gig = CustomerGig::find($bid->customer_gig_id);
            $gig->status = 'running';
            $gig->save();
            
            $bid->customerGig->customer->notify(new WorkerWorkComplete($bid)); //Notification send to worker



            // //Rating 
            // $bid->workerGig->worker->rating->max_rate +=  5;
            // $bid->workerGig->worker->rating->save();
            //Worker balance update
            // $bid->worker->balance->job_income += $bid->budget;

            // :::::::: Save Refferral bonus amount for marketer
            // $bid->customerGig->service->comission_rate;


             // // get categorywise comission 
            $commission = $bid->customerGig->service->comission_rate;
            $marketer_commison = $bid->customerGig->service->marketer_comission;
            
            
            // //Worker balance update
            $bid->worker->balance->job_income += $bid->budget - ($bid->budget * $commission) /100  ;
            
            $after_comision = $bid->budget - ($bid->budget * $commission) /100;
            $bid->worker->balance->due +=  $after_comision;



            $service_change = $bid->budget - $after_comision;
            $bid->worker->balance->service_change += $service_change;

            // var_dump($bid->workerGig->worker->balance->service_change);
            // exit();

            $bid->worker->balance->save();


            $user = User::find($bid->worker->id);
            $user->recharge_amount -= $service_change;
            $user->save();

            $earning = $bid->budget - $service_change;
            // UserAccountHistory::updateEarnings($bid->id, $service_change, $after_comision, $earning);
            // UserAccountHistory::updateStatus($bid->id, 'completed');
            $account = DB::table('user_account_history')->where('order_id', $bid->id)->update([
                'service_charge' => $service_change,
                'comission' => $after_comision,
                'earnings' => $earning,
                'status' => 'completed',
            ]);
            // First Number Order Commison Save
            if ($user->referred_by != null && $bid->gig_refferral_code == null) {
                $customer_first_number_order = get_static_option('customer_first_number_order');
                $customer_bid = CustomerBid::where('customer_id', auth()->user()->id)->count();
                if ($customer_bid <= $customer_first_number_order) {
                    $referred_by_user = User::where('referral_code', $user->referred_by)->first();
                    if ($referred_by_user != null) {
                        $amount = $marketer_commison * $bid->budget / 100;

                        $affiliate_user = $referred_by_user->affiliate_user;
                        if ($affiliate_user != null) {
                            $affiliate_user->balance += $amount;
                            $affiliate_user->save();

                            //save bonus details
                            affiliate_save($referred_by_user->id, $bid->customer_id, $amount, 'Customer Signup', $bid->id, $bid->budget);
                            /*$current_month = date("F");
                            $current_year = date("Y");
                            $affiliate_bonus = new AffiliateBonus;
                            $affiliate_bonus->affiliate_user_id = $referred_by_user->id;
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
            // Order Comission
            $amount = 0;
            if($bid->gig_refferral_code != null)
            {
                $referred_by_user = User::where('referral_code', $bid->gig_refferral_code)->first();

                if($referred_by_user != null){ 
                    $amount = $bid->customerGig->service->marketer_comission * $bid->budget/100;
                    
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
                            $affiliate_bonus->bonus_purpose = 'Order Commission';
                            $affiliate_bonus->order_id = $bid->id;
                            $affiliate_bonus->year = $current_year;
                            $affiliate_bonus->save();*/
                            
                        }
                }
            }

            //Worker Registration Or refferral
            if ($bid->worker->referred_by != null && $bid->worker->balance->job_income >= get_static_option('job_complete_amount') &&$bid->worker->balance->is_registration_comission == 0) {
 
                    $user = User::where('referral_code',$bid->worker->referred_by)->first();
                    
                    if ($user != null) {
                        $reffer_amount = get_static_option('worker_registration_commission_amount');
                        $affiliate_user = $user->affiliate_user;
                        if($affiliate_user != null){
                            $bid->worker->balance->is_registration_comission = 1;
                            $affiliate_user->balance += $reffer_amount;
                            $affiliate_user->save();

                            //save bonus details
                            affiliate_save($user->id, $bid->worker_id, $reffer_amount, 'Worker Signup', $bid->id);
                            /*$current_month = date("F");
                            $current_year = date("Y");
                            $affiliate_bonus = new AffiliateBonus;
                            $affiliate_bonus->affiliate_user_id = $user->id;
                            $affiliate_bonus->user_id = $bid->worker_id;
                            $affiliate_bonus->amount = $reffer_amount;
                            $affiliate_bonus->month = $current_month;
                            $affiliate_bonus->bonus_purpose = 'Worker Signup';
                            $affiliate_bonus->order_id = $bid->id;
                            $affiliate_bonus->year = $current_year;
                            $affiliate_bonus->save();*/

                        }
                    }
                
            }
            //Worker Registration Or refferral

            // :::::::: Save Refferral bonus amount for marketer

            //Worker balance update
            // $bid->worker->balance->job_income += $bid->budget;
            // $bid->worker->balance->due += ($bid->customerGig->service->comission_rate/100) * $bid->budget + $amount;
            // $bid->worker->balance->save();

            /*
            //Balance updated of referral owner
            if (\auth()->user()->referral->by){
                $selectedReferralOwnerBalance = Referral::where('own', auth()->user()->referral->by)->first()->user->balance;
            }
            */

            

            if ($request->input('rate') > 0){
                $bid->worker->rating->rate +=  $request->input('rate');
                $bid->worker->rating->rateGivenBy +=  1;
                $bid->worker->rating->save();
                return response()->json([
                    'type' => 'success',
                    'message' => 'Successfully rated-'.$request->input('rate'),
                ]);
            }else{
                return response()->json([
                    'type' => 'success',
                    'message' => 'Successfully rated with test',
                ]);
            }

    }

    public function completedCustomerGigJob(Request $request){

            $bid = CustomerBid::find($request->input('bid'));

            $bid->status = 'completed';
            $bid->save(); //Job status updated

            $gig = WorkerGig::find($bid->worker_gig_id);
            $gig->status = 1;
            $gig->save();
            
            // $bid->workerGig->customer->notify(new WorkerWorkComplete($bid)); //Notification send to worker



            // //Rating 
            // $bid->workerGig->worker->rating->max_rate +=  5;
            // $bid->workerGig->worker->rating->save();
            //Worker balance update
            $commission = $bid->workerGig->service->comission_rate;

            
            
            // // //Worker balance update
            $bid->workerGig->worker->balance->job_income += $bid->budget - ($bid->budget * $commission) /100  ;
            
            $after_comision = $bid->budget - ($bid->budget * $commission) /100;
            $bid->workerGig->worker->balance->due +=  $after_comision;



            $service_change = $bid->budget - $after_comision;
            $bid->workerGig->worker->balance->service_change += $service_change;

            // // var_dump($bid->workerGig->worker->balance->service_change);
            // // exit();

            $bid->workerGig->worker->balance->save();


            $user = User::find($bid->workerGig->worker->id);
            $user->recharge_amount -= $service_change;
            $user->save();

            // // :::::::: Save Refferral bonus amount for marketer
            $bid->workerGig->service->comission_rate;
            // Order Comission
            $amount = 0;
            // First Number Order Commison Save
            if ($user->referred_by != null && $bid->gig_refferral_code == null) {
                $customer_first_number_order = get_static_option('customer_first_number_order');
                $customer_bid = CustomerBid::where('customer_id', auth()->user()->id)->count();
                if ($customer_bid <= $customer_first_number_order) {
                    $referred_by_user = User::where('referral_code', $user->referred_by)->first();
                    if ($referred_by_user != null) {
                        $amount = $commission * $bid->budget / 100;

                        $affiliate_user = $referred_by_user->affiliate_user;
                        if ($affiliate_user != null) {
                            $affiliate_user->balance += $amount;
                            $affiliate_user->save();

                            //save bonus details
                            affiliate_save($referred_by_user->id, $bid->customer_id, $amount, 'Customer Signup', $bid->id, $bid->budget);
                            /*$current_month = date("F");
                            $current_year = date("Y");
                            $affiliate_bonus = new AffiliateBonus;
                            $affiliate_bonus->affiliate_user_id = $referred_by_user->id;
                            $affiliate_bonus->user_id = $bid->customer_id;
                            $affiliate_bonus->amount = $amount;
                            $affiliate_bonus->month = $current_month;
                            $affiliate_bonus->year = $current_year;
                            $affiliate_bonus->bonus_purpose = 'Order Commission';
                            $affiliate_bonus->save();*/
                        }
                    }
                }
            }

            
            
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
                            affiliate_save($user->id, $bid->worker_id, $reffer_amount, 'Worker Signup', $bid->id);
                            /*$current_month = date("F");
                            $current_year = date("Y");
                            $affiliate_bonus = new AffiliateBonus;
                            $affiliate_bonus->affiliate_user_id = $user->id;
                            $affiliate_bonus->user_id = $bid->customer_id;
                            $affiliate_bonus->amount = $reffer_amount;
                            $affiliate_bonus->month = $current_month;
                            $affiliate_bonus->year = $current_year;
                            $affiliate_bonus->bonus_purpose = 'Worker Signup';
                            $affiliate_bonus->save();*/

                        }
                    }
                
            }
            // //Worker Registration Or refferral

            // // :::::::: Save Refferral bonus amount for marketer

            // //Worker balance update
            // $bid->workerGig->worker->balance->job_income += $bid->budget;
            // $bid->workerGig->worker->balance->due += ($bid->workerGig->service->comission_rate/100) * $bid->budget + $amount;
            // $bid->workerGig->worker->balance->save();

            // /*
            // //Balance updated of referral owner
            // if (\auth()->user()->referral->by){
            //     $selectedReferralOwnerBalance = Referral::where('own', auth()->user()->referral->by)->first()->user->balance;
            // }
            // */

            $earning = $bid->budget - $service_change;
            UserAccountHistory::updateEarnings($bid->id, $service_change, $after_comision, $earning);
            UserAccountHistory::updateStatus($bid->id, 'completed');

            if ($request->input('rate') > 0){
                $bid->worker->rating->rate +=  $request->input('rate');
                $bid->worker->rating->rateGivenBy +=  1;
                $bid->worker->rating->save();
                return response()->json([
                    'type' => 'success',
                    'message' => 'Successfully rated-'.$request->input('rate'),
                ]);
            }else{
                return response()->json([
                    'type' => 'success',
                    'message' => 'Successfully rated',
                ]);
            }
    }

}
