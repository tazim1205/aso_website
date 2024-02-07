<?php

namespace App\Http\Controllers\Membership;

use App\Http\Controllers\Controller;
use App\Membership;
use App\MembershipPackage;
use App\AffiliateBonus;
use App\Payment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use smasif\ShurjopayLaravelPackage\ShurjopayService;
use App\User;
use Auth;

class MembershipController extends Controller
{
    public function purchaseRequest(Request $request){
        $request->validate([
           'membership' =>  'required|exists:membership_packages,id',
           'duration'    =>  'required|numeric'
        ]);
        $membership = MembershipPackage::find($request->input('membership'));

        if ($request->input('duration') == 3){
            $paymentAmount = $membership->three_month_price;
        }else if ($request->input('duration') == 6){
            $paymentAmount = $membership->six_month_price;
        }else if ($request->input('duration') == 12){
            $paymentAmount = $membership->twelve_month_price;
        }else{
            return redirect()->back();
        }
        try {
            pay($paymentAmount, route('membership.paymentResponse', [$request->input('membership'), $request->input('duration')]));
        }catch (\Exception $exception){
            return redirect()->back();
        }
    }


    public function purchaseResponse($membership, $duration, Request $request)
    {
        if ($request->all()['status'] == 'Success'){
            $payment = new Payment();
            $payment->user_id = auth()->user()->id;
            $payment->amount = $request->all()['amount'];
            $payment->tx_id = $request->all()['tx_id'];
            $payment->bank_tx_id = $request->all()['bank_tx_id'];
            $payment->purpose = 'Membership';
            $payment->save();

            

            $membershipObj = new Membership();
            $membershipObj->user_id = auth()->user()->id;
            $membershipObj->membership_package_id = $membership;
            $membershipObj->duration = $duration;
            $membershipObj->ending_at = Carbon::now()->addMonth($duration);
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
