<?php

namespace App\Http\Controllers\PaymentGateway;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use smasif\ShurjopayLaravelPackage\ShurjopayService;

class ShurjoPayController extends Controller
{
    public function getPaymentView($amount){
        $shurjopay_service = new ShurjopayService(); //Initiate the object

        $tx_id = $shurjopay_service->generateTxId(); // Get transaction id. You can use custom id like: $shurjopay_service->generateTxId('123456');

        //$success_route = route('shurjopay.response'); // optional.
        $shurjopay_service->sendPayment(2);
        // $shurjopay_service->sendPayment($amount); // You can call simply $shurjopay_service->sendPayment(2) without success route
    }

    public function getPaymentSuccessView(){

       return view('payment-response');
    }

    public function response(Request $request)
    {

        return view('payment-response')->with('status', $request->all()['status']);

        // dd($request->all());

        $server_url = config('shurjopay.server_url');
        $response_encrypted = $request->spdata;
        $response_decrypted = file_get_contents($server_url . "/merchant/decrypt.php?data=" . $response_encrypted);
        $data = simplexml_load_string($response_decrypted) or die("Error: Cannot create object");
        $tx_id = $data->txID;
        $bank_tx_id = $data->bankTxID;
        $amount = $data->txnAmount;
        $bank_status = $data->bankTxStatus;
        $sp_code = $data->spCode;
        $sp_code_des = $data->spCodeDes;
        $sp_payment_option = $data->paymentOption;
        $status = "";
        switch ($sp_code) {
            case '000':
                $res = array('status' => false, 'msg' => 'Action Successful');
                $status = "Success";
                break;
            case '001':
                $status = "Failed";
                $res = array('status' => false, 'msg' => 'Action Failed');
                break;
        }


        return view('payment-response')->with('status', $status);;

        
        $success_url = $request->get('success_url');

        if ($success_url) {
            header("location:" . $success_url . "?status={$status}&msg={$res['msg']}&tx_id={$tx_id}&bank_tx_id={$bank_tx_id}"
                . "&amount={$amount}&bank_status={$bank_status}&sp_code={$sp_code}" .
                "&sp_code_des={$sp_code_des}&sp_payment_option={$sp_payment_option}");
        }
        if ($res['status']) {
            echo "Success";
            die();
        } else {
            echo "Fail";
            die();
        }
    }
}
