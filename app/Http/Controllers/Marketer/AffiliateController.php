<?php

namespace App\Http\Controllers\Marketer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\AffiliateOption; 
use App\AffiliateUser;
use App\AffiliatePayment; 
use App\AffiliateBonus;
use App\User; 
use Session;
use Cookie;
use Auth;
use Hash;

class AffiliateController extends Controller
{
    public function processAffiliatePoints(){
       
            if(AffiliateOption::where('type', 'user_registration_first_purchase')->first()->status){
                if ($order->user != null && $order->user->orders->count() == 1) {
                    if($order->user->referred_by != null){
                        $user = User::find($order->user->referred_by);
                        if ($user != null) {
                            $amount = (AffiliateOption::where('type', 'user_registration_first_purchase')->first()->percentage * $order->grand_total)/100;
                            $affiliate_user = $user->affiliate_user;
                            if($affiliate_user != null){
                                $affiliate_user->balance += $amount;
                                $affiliate_user->save();

                                //save bonus details
                                $current_month = date("F");
                                $current_year = date("Y");
                                $affiliate_bonus = new AffiliateBonus;
                                $affiliate_bonus->affiliate_user_id = $affiliate_user->id;
                                $affiliate_bonus->user_id = 1;
                                $affiliate_bonus->amount = $amount;
                                $affiliate_bonus->month = $current_month;
                                $affiliate_bonus->year = $current_year;
                            }
                        }
                    }
                }
            }
            if(AffiliateOption::where('type', 'product_sharing')->first()->status){
                foreach ($order->orderDetails as $key => $orderDetail) {
                    $amount = 0;
                    if($orderDetail->product_referral_code != null){
                        $referred_by_user = User::where('referral_code', $orderDetail->product_referral_code)->first();
                        if($referred_by_user != null) {
                            if(AffiliateOption::where('type', 'product_sharing')->first()->details != null && json_decode(AffiliateOption::where('type', 'product_sharing')->first()->details)->commission_type == 'amount'){
                                $amount = json_decode(AffiliateOption::where('type', 'product_sharing')->first()->details)->commission;
                            }
                            elseif(AffiliateOption::where('type', 'product_sharing')->first()->details != null && json_decode(AffiliateOption::where('type', 'product_sharing')->first()->details)->commission_type == 'percent') {
                                $amount = (json_decode(AffiliateOption::where('type', 'product_sharing')->first()->details)->commission * $orderDetail->price)/100;
                            }
                            $affiliate_user = $referred_by_user->affiliate_user;
                            if($affiliate_user != null){
                                $affiliate_user->balance += $amount;
                                $affiliate_user->save();
                            }
                        }
                    }
                }
            }
            elseif (AffiliateOption::where('type', 'category_wise_affiliate')->first()->status) {
                foreach ($order->orderDetails as $key => $orderDetail) {
                    $amount = 0;
                    if($orderDetail->product_referral_code != null) {
                        $referred_by_user = User::where('referral_code', $orderDetail->product_referral_code)->first();
                        if($referred_by_user != null) {
                            if(AffiliateOption::where('type', 'category_wise_affiliate')->first()->details != null){
                                foreach (json_decode(AffiliateOption::where('type', 'category_wise_affiliate')->first()->details) as $key => $value) {
                                    if($value->category_id == $orderDetail->product->category->id){
                                        if($value->commission_type == 'amount'){
                                            $amount = $value->commission;
                                        }
                                        else {
                                            $amount = ($value->commission * $orderDetail->price)/100;
                                        }
                                    }
                                }
                            }
                            $affiliate_user = $referred_by_user->affiliate_user;
                            if($affiliate_user != null){
                                $affiliate_user->balance += $amount;
                                $affiliate_user->save();
                            }
                        }
                    }
                }
            }
        
    }
}
