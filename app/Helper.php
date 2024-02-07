<?php 
use App\UserAccountHistory;

class Helper{
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
        $account->service_tim = $service_tim;
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
}

?>