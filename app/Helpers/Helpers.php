<?php

use App\Page;
use App\StaticOption;
use App\User;
use App\RattingReview;
use App\Rating;
use App\UserAccountHistory;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use smasif\ShurjopayLaravelPackage\ShurjopayService;
use Stichoza\GoogleTranslate\GoogleTranslate;
use App\AffiliateBonus;
use App\CustomerBid;
use App\CustomerGig;
use App\ServiceBid;

if (!function_exists('random_code')){
    function current_language(){
        return App::getLocale();
    }

    function send_sms($to, $message){
        //$to = "01304734623";
        $token = get_static_option('sms_key');
        //"ab5821e83a99eb9ec4774c962cb768a0";
        //$message = "Test SMS From Using API";

        $url = "http://api.greenweb.com.bd/api.php";

        $data= array(
            'to'=>"$to",
            'message'=>"$message",
            'token'=>"$token"
        ); // Add parameters in key value
        $ch = curl_init(); // Initialize cURL
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_ENCODING, '');
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $smsresult = curl_exec($ch);

        //Result
        return $smsresult;
        //Error Display
        //echo curl_error($ch);
    }

    function set_static_option($key, $value)
    {
        if (!StaticOption::where('option_name', $key)->first()) {
            StaticOption::create([
                'option_name' => $key,
                'option_value' => $value
            ]);
            return true;
        }
        return false;
    }

    function get_static_option($key)
    {
        if (StaticOption::where('option_name', $key)->first()) {
            $return_val = StaticOption::where('option_name', $key)->first();
            return $return_val->option_value;
        }
        return null;
    }



    function update_static_option($key, $value)
    {
        if (!StaticOption::where('option_name', $key)->first()) {
            StaticOption::create([
                'option_name' => $key,
                'option_value' => $value
            ]);
            return true;
        } else {
            StaticOption::where('option_name', $key)->update([
                'option_name' => $key,
                'option_value' => $value
            ]);
            return true;
        }
    }

    function delete_static_option($key)
    {
        StaticOption::where('option_name', $key)->delete();
        return true;
    }

    function setEnvValue(array $values)
    {
        $envFile = app()->environmentFilePath();
        $str = file_get_contents($envFile);

        if (count($values) > 0) {
            foreach ($values as $envKey => $envValue) {
                $str .= "\n"; // In case the searched variable is in the last line without \n
                $keyPosition = strpos($str, "{$envKey}=");
                $endOfLinePosition = strpos($str, "\n", $keyPosition);
                $oldLine = substr($str, $keyPosition, $endOfLinePosition - $keyPosition);

                // If key does not exist, add it
                if (!$keyPosition || !$endOfLinePosition || !$oldLine) {
                    $str .= "{$envKey}={$envValue}\n";
                } else {
                    $str = str_replace($oldLine, "{$envKey}={$envValue}", $str);
                }
            }
        }

        $str = substr($str, 0, -1);
        if (!file_put_contents($envFile, $str)) return false;
        return true;
    }


    function sendSmtpTest($to)
    {
        $subject= 'SMTP Test';
        $message= 'SMTP working fine';
        $name = get_static_option('smtp_email_from_name');
        $from = get_static_option('smtp_email_from_email');
        $headers = "From: " . $name . " \r\n";
        $headers .= "Reply-To: <$from> \r\n";
        $headers .= "Return-Path: " . ($from) . "\r\n";;
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
        $headers .= "X-Priority: 2\nX-MSmail-Priority: high";;
        $headers .= "X-Mailer: PHP" . phpversion() . "\r\n";

        if (mail($to, $subject, $message, $headers)) {
            return true;
        }else{
            return false;
        }

    }

    function get_all_static_pages(){
        return Page::all();
    }

    function pay($amount, $response_route){
        $shurjopay_service = new ShurjopayService(); //Initiate the object
        $shurjopay_service->generateTxId(); // Get transaction id. You can use custom id like: $shurjopay_service->generateTxId('123456');
        $shurjopay_service->sendPayment($amount, $response_route); // You can call simply $shurjopay_service->sendPayment(2) without success route
    }

    function payNow($amount, $success_route){
        $shurjopay_service = new ShurjopayService(); //Initiate the object
        $shurjopay_service->generateTxId(); // Get transaction id. You can use custom id like: $shurjopay_service->generateTxId('123456');
        $shurjopay_service->sendPayment($amount, $success_route); // You can call simply $shurjopay_service->sendPayment(2) without success route
    }


    function worker_payment_check($worker_id){
        $worker = User::findOrfail($worker_id);
        // if(get_static_option('worker_activation_price') > 0 || $worker->balance->due > get_static_option('worker_maximum_due_permission')){
        //     if($worker->payments()->where('purpose', 'Registration-Fee')->count() < 1){
        //         return 'Registration-Fee'; // Do not change this return value
        //     }else if($worker->balance->due > get_static_option('worker_maximum_due_permission')){
        //         return 'Due-Fee'; // Do not change this return value
        //     }
        // }
        return 'Payment-Clear';// Do not change this return value
    }

    function getWorkerRatting($id){
        // $ratting = count(RattingReview::where('user_id',$id)->get());
        $ratting = Rating::where('user_id',$id)->First();

        return $ratting->rateGivenBy;
    }


}

if(!function_exists('affiliate_save')){
    function affiliate_save($user_id, $customer_id, $amount, $bonus_purpose = '', $order_id = null, $budget = 0){
        $current_month = date("F");
        $current_year = date("Y");
        $affiliate_bonus = new AffiliateBonus;
        $affiliate_bonus->affiliate_user_id = $user_id;
        $affiliate_bonus->user_id = $customer_id;
        $affiliate_bonus->amount = $amount;
        $affiliate_bonus->month = $current_month;
        $affiliate_bonus->year = $current_year;
        $affiliate_bonus->bonus_purpose = $bonus_purpose;
        $affiliate_bonus->order_id = $order_id;
        $affiliate_bonus->budget = $budget;
        $affiliate_bonus->save();
    }
}


function countBids($status, $customer_id)
{
    // Use the Eloquent ORM to count bids with the specified status
    $count = CustomerBid::where('customer_id', $customer_id)->where('status', $status)->count();

    return $count;
}

function countGig($status, $customer_id)
{
    // Use the Eloquent ORM to count bids with the specified status
    $count = CustomerGig::where('customer_id', $customer_id)->where('status', $status)->count();

    return $count;
}

function countService($status, $customer_id)
{
    // Use the Eloquent ORM to count bids with the specified status
    $count = ServiceBid::where('customer_id', $customer_id)->where('status', $status)->count();

    return $count;
}

function affMarkCost($status = "total"){
    if($status == "order_commission"){
        $cost = AffiliateBonus::where('bonus_purpose', 'Order Commission')->sum('amount');
    }else if($status == "worker_signup_commission"){
        $cost = AffiliateBonus::where('bonus_purpose', 'Worker Signup')->sum('amount');
    }else if($status == "membership_commission"){
        $cost = AffiliateBonus::where('bonus_purpose', 'Membership')->sum('amount');
    }else if($status == "bonus"){
        $cost = AffiliateBonus::where('bonus_purpose', 'Bonus')->sum('amount');
    }else if($status == "marketer_commission"){
        $cost = AffiliateBonus::where('bonus_purpose', 'Marketer Commismion')->sum('amount');
    }else if($status == "customer_signup"){
        $cost = AffiliateBonus::where('bonus_purpose', 'Customer Signup')->sum('amount');
    }else if($status == "total"){
        $cost = AffiliateBonus::sum('amount');
    }

    return $cost;
}

if (!function_exists('active')) {
    function active($routeName, $parameters = [], $class = 'active')
    {
        if (!Route::has($routeName)) {
            return '';
        }

        return '/' . request()->path() === route($routeName, $parameters, false) ? $class : '';
    }
}

if(!function_exists('menu_badge')){
    function menu_badge($model, $status, $field = 'status'){
        return $model::where($field, $status)->count();
    }
}


?>
