<?php

namespace App\Http\Controllers\Worker\Membership;

use App\Http\Controllers\Controller;
use App\Membership;
use App\MembershipTrial;
use App\MembershipPackage;
use App\AffiliateBonus;
use App\Payment;
use App\WorkerPage;
use Carbon\Carbon;
use Illuminate\Http\Request;
use smasif\ShurjopayLaravelPackage\ShurjopayService;
use App\User;
use Auth, Crypt;
use Illuminate\Support\Str;

class MembershipController extends Controller
{
    public function purchaseRequest(Request $request){
        
        if (!Membership::where('user_id', Auth::id())->where('payment_status', 'trial')->exists()) {
            $request->validate([
               'package_id' =>  'required|exists:membership_packages,id',
               'duration'    =>  'required|numeric',
               'sub_categories'    =>  'required',
               'payment_status'    =>  'required',
            ]);
        }else{
            $request->validate([
               'package_id' =>  'required|exists:membership_packages,id',
               'duration'    =>  'required|numeric',
               'sub_categories'    =>  'required',
               'payment_status'    =>  'required',
            ], [
                'payment_status.max' => 'Sorry! You trialed already',
            ]);
        }
        // $membership = MembershipPackage::find($request->input('package_id'));

        // if (!empty($request->input('duration'))){
        //     $paymentAmount = $membership->monthly_price * $request->input('duration');
        // }
        $payment_status = Crypt::decryptString($request->payment_status);
        
        if ($payment_status == 1) {
            $payment_status = "completed";
            $ending_at = Carbon::now()->addMonth($request->duration);
        }elseif ($payment_status == 2) {
            $payment_status = "trial";
            $ending_at = Carbon::now()->addDays(MembershipTrial::where('name', 'trial_period')->first()->days);
        }
        
        //submitted categories
        $sub_categoriesData = $request->sub_categories;
        $sub_categories = " ";
        foreach ($sub_categoriesData as $sub_category) {
            $sub_categories = $sub_categories.$sub_category.",";
        }
        $sub_categories;

        // payment amount calculating 
        $monthly_price = MembershipPackage::find($request->package_id)->monthly_price;
        $monthly_with_duration = $monthly_price * $request->duration;

        $category_count = count($request->sub_categories) - 1;
        $extended_price = MembershipPackage::find($request->package_id)->extendable_price;
        $total_category_price = ($extended_price * $category_count) * $request->duration;

        $paymentAmount = $monthly_with_duration + $total_category_price;

        /**this portion moved here for temporary from purchaseresponse**/
        //Payment
        $payment = new Payment();
        $payment->user_id = auth()->user()->id;
        $payment->amount = $paymentAmount;
        $payment->tx_id = 'ABCDFDD';
        $payment->bank_tx_id = 'AHFGREHRH';
        $payment->purpose = 'Membership';
        $payment->save();
        //Member Ship
        $membershipObj = new Membership();
        $membershipObj->user_id = auth()->user()->id;
        $membershipObj->membership_package_id = $request->package_id;
        $membershipObj->duration = $request->duration;
        $membershipObj->sub_categories = $sub_categories;
        $membershipObj->payment_status = $payment_status;
        $membershipObj->ending_at = $ending_at;
        $membershipObj->save();
        
        
        //Affiliate Marketer Balance Update  
        $membership = Membership::where('user_id', auth()->user()->id)->count();
        // dd($membership);
        if (Auth::check() && $membership <= 1) {
            
            if(Auth::user()->referred_by != null){
                $marketer = User::where('referral_code',auth()->user()->referred_by)->first();
                if ($marketer != null) {
                    $amount = get_static_option('membership_commission_percent') * $payment->amount / 100;
                    $affiliate_user = $marketer->affiliate_user;
                    if($affiliate_user != null){
                        $affiliate_user->balance += $amount;
                        $affiliate_user->save();

                        //save bonus details
                        $current_month = date("F");
                        $current_year = date("Y");
                        $affiliate_bonus = new AffiliateBonus;
                        $affiliate_bonus->affiliate_user_id = $marketer->id;
                        $affiliate_bonus->user_id = $membershipObj->user_id;
                        $affiliate_bonus->amount = $amount;
                        $affiliate_bonus->month = $current_month;
                        $affiliate_bonus->bonus_purpose = "Membership Signup";
                        $affiliate_bonus->year = $current_year;
                        $affiliate_bonus->save();

                    }
                }
            }
        }
        /** temporary portion end **/
        
        // try {
        //     pay($paymentAmount, route('worker.paymentResponse', [$request->input('package_id'), $request->input('duration'), $sub_categories, $payment_status]));
        // }catch (\Exception $exception){
        //     return redirect()->back();
        // }

        return back()->with('success_buy_package', 'Membership Package '.Str::title(MembershipPackage::find($request->package_id)->name).' Bought Successfully');
    }

    function updateRequest(Request $request){
        $request->validate([
            'membership_id' =>  'required',
            'duration'    =>  'required|numeric',
        ]);

        $membership_id = Crypt::decryptString($request->membership_id);
        $duration = $request->duration;
        $sub_category = '';
        foreach ($request->sub_categories as $key => $value) {
            $sub_category .= $value.',';
        }
        // var_dump($sub_category);exit();

        // $monthly_price = MembershipPackage::find(Membership::find($membership_id)->membership_package_id )->monthly_price;

        // $count = 0;

        // foreach (Str::of(Membership::find($membership_id)->sub_categories)->explode(',') as $sub_categories) {
        //     if ($sub_categories) {
        //         $count++;
        //     }
        // }

        // $count = $count - 1;
        // $extendable_price = MembershipPackage::find(Membership::find($membership_id)->membership_package_id)->extendable_price;

        // $monthly_with_month = $monthly_price * ($duration - Membership::find($membership_id)->duration);
        // $total_service_price = ($extendable_price * $count) * ($duration - Membership::find($membership_id)->duration);

        if ($duration = $request->duration) {
            // $total_price = $monthly_with_month + $total_service_price;
            // Membership::findOrFail($membership_id)->update([
            //     'duration' => $request->duration,
            //     'ending_at' => Carbon::now()->addMonth($request->duration),
            //     'sub_categories' => $sub_category,
            // ]);

            $membership = Membership::find($membership_id);
            $membership->duration = $request->duration;
            $membership->ending_at = Carbon::now()->addMonth($request->duration);
            $membership->sub_categories = $sub_category;
            $membership->save();


            $worker_page = WorkerPage::where('membership_id', $membership_id)->where('worker_id',auth()->user()->id)->get();
            foreach ($worker_page as $row) {
                $page = WorkerPage::find($row->id);
                $page->services = $sub_category;
                $page->save();
            }


            // return Carbon::now()->addMonth($request->duration);
            return back()->with('success_update_package', 'Membership Package '.Str::title(MembershipPackage::find(Membership::find($membership_id)->membership_package_id)->name).' Updated Successfully');
        }
        // elseif ($duration = $request->duration == Membership::find($membership_id)->duration) {
        //     return back()->with('danger_update_package', 'Please! Upgrade Duration');
        // }
        // else {
        //     return back()->with('danger_update_package', 'You can not downgrade the duration');
        // }
    }


    public function changeMembership(Request $request){

        $request->validate([
            'membership_id' =>  'required',
            'duration'    =>  'required|numeric',
        ]);

        $membership_id = Crypt::decryptString($request->membership_id);

        $duration = $request->duration;

        $sub_category = '';
        foreach ($request->sub_categories as $key => $value) {
            $sub_category .= $value.',';
        }

        $membership = Membership::find($membership_id);
        $membership->duration = $request->duration;
        $membership->membership_package_id = $request->package_id;
        $membership->ending_at = Carbon::now()->addMonth($request->duration);
        $membership->sub_categories = $sub_category;
        $membership->save();


        $worker_page = WorkerPage::where('membership_id', $membership_id)->where('worker_id',auth()->user()->id)->get();
        foreach ($worker_page as $row) {
            $page = WorkerPage::find($row->id);
            $page->services = $sub_category;
            $page->save();
        }

        // Membership::findOrFail($membership_id)->update([
        //         'membership_package_id' => $request->package_id,
        //     ]);
            // return Carbon::now()->addMonth($request->duration);
        return back()->with('success_update_package', 'Membership Package '.Str::title(MembershipPackage::find(Membership::find($membership_id)->membership_package_id)->name).' Updated Successfully');
    }


    public function purchaseResponse($package_id, $duration, $sub_categories, $payment_status, $ending_at, Request $request)
    {
        if ($request->all()['status'] == 'Success'){
            $payment = new Payment();
            $payment->user_id = auth()->user()->id;
            $payment->amount = $request->all()['amount'];
            $payment->tx_id = $request->all()['tx_id'];
            $payment->bank_tx_id = $request->all()['bank_tx_id'];
            $payment->purpose = 'Membership';
            $payment->save();

            
            //this portion done in purchase request method for temporary
            $membershipObj = new Membership();
            $membershipObj->user_id = auth()->user()->id;
            $membershipObj->membership_package_id = $package_id;
            $membershipObj->duration = $duration;
            $membershipObj->sub_categories = $sub_categories;
            $membershipObj->payment_status = $payment_status;
            $membershipObj->ending_at = $ending_at;
            $membershipObj->save();



            //Affiliate Marketer Balance Update  
            if (Auth::check() && Auth::user()->membership->count() == 1) {
                if(Auth::user()->referred_by != null){
                    $marketer = User::where('referral_code',auth()->user()->referred_by)->first();
                    if ($marketer != null) {
                        $amount = get_static_option('membership_commission_percent') * $payment->amount/100;
                        $affiliate_user = $marketer->affiliate_user;
                        if($affiliate_user != null){
                            $affiliate_user->balance += $amount;
                            $affiliate_user->save();

                            //save bonus details
                            $current_month = date("F");
                            $current_year = date("Y");
                            $affiliate_bonus = new AffiliateBonus;
                            $affiliate_bonus->affiliate_user_id = $marketer->id;
                            $affiliate_bonus->user_id = $membershipObj->user_id;
                            $affiliate_bonus->amount = $amount;
                            $affiliate_bonus->month = $current_month;
                            $affiliate_bonus->year = $current_year;
                            $affiliate_bonus->save();

                        }
                    }
                }
            }
              


        }
        return view('payment-response')->with('status', $request->all()['status']);

        //dd($request->all());
        /**
        "status" => "Failed"
        "msg" => "Action Failed"
        "tx_id" => "NOK5f8a6ade40f21"
        "bank_tx_id" => null
        "amount" => "1200"
        "bank_status" => "CANCEL"
        "sp_code" => "001"
        "sp_code_des" => "Cancel"
        "sp_payment_option" => null
         */
    }
}
