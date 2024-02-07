<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserAccountHistory extends Model
{
    protected $table = 'user_account_history';

    public function user(){
        return $this->belongsTo(User::class,'user_id','id');
    }


    // user account history 
    public static function isertIntoAccountHistory($order_id, $user_type, $user_id, $customer_id, $service_type, $service_id, $budget, $service_date, $service_time,$day, $service_charge, $comission, $earnings, $status){

        $account = new UserAccountHistory();
        $account->order_id = $order_id;
        $account->user_type = $user_type;
        $account->user_id = $user_id;
        $account->customer_id = $customer_id;
        $account->service_type = $service_type;
        $account->service_id = $service_id;
        $account->budget = $budget;
        $account->service_date = $service_date;
        $account->service_time = $service_time;
        $account->day = $day;
        $account->service_charge = $service_charge;
        $account->comission = $comission;
        $account->earnings = $earnings;
        $account->status = $status;

        $account->save();
        if ($account) {
            return true;
        }
    }


    public static function updateBudget($order_id, $budget){
        $account = UserAccountHistory::where('order_id', $order_id)->first();
        $account->budget = $budget;
        $account->save();
        if ($account) {
            return true;
        }
    }

    public static function updateStatus($order_id, $status){
        $account = UserAccountHistory::where('order_id', $order_id)->first();
        $account->status = $status;
        $account->save();
        if ($account) {
            return true;
        }
    }


    public static function updateEarnings($order_id, $service_charge, $comission, $earnings){
        $account = UserAccountHistory::where('order_id', $order_id)->first();
        $account->service_charge = $service_charge;
        $account->comission = $comission;
        $account->earnings = $earnings;
        $account->save();
        if ($account) {
            return true;
        }
    }


    public static function getWorkerEarnings($id){
        return UserAccountHistory::where('user_id' , $id)->where('status', 'completed')->where(function ($query) {
                    $query->where('service_type', 'gig')
                        ->orWhere('service_type', 'customer gig');
                })->sum('earnings');
    }

    public static function getWorkerGivenServiceCharge($id){
        return UserAccountHistory::where('user_id' , $id)->where('status', 'completed')->sum('service_charge');
    }

    public static function getThisMonthWorkerEarnings($id){
        return UserAccountHistory::where('user_id' , $id)->where('status', 'completed')->whereMonth('created_at', date('m'))->where(function ($query) {
                    $query->where('service_type', 'gig')
                        ->orWhere('service_type', 'customer gig');
                })->sum('earnings');
    }

    public static function getWorkerPageEarnings($id){
        return UserAccountHistory::where('user_id' , $id)->where('service_type','page')->where('status', 'completed')->sum('earnings');
    }

    public static function getThisMonthWorkerPageEarnings($id){
        return UserAccountHistory::where('user_id' , $id)->where('service_type','page')->where('status', 'completed')->whereMonth('created_at', date('m'))->sum('earnings');
    }

}
