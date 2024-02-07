<?php

namespace App\Http\Controllers\Worker;

use App\Http\Controllers\Controller;
use App\Payment;

use Illuminate\Http\Request;
use smasif\ShurjopayLaravelPackage\ShurjopayService;

class PaymentController extends Controller
{
    public function pay(){
        if (auth()->user()->balance->due > 0){
            $shurjopay_service = new ShurjopayService(); //Initiate the object
            $tx_id = $shurjopay_service->generateTxId(); // Get transaction id. You can use custom id like: $shurjopay_service->generateTxId('123456');
            $success_route = route('worker.paymentResponse'); // optional.
            $shurjopay_service->sendPayment(auth()->user()->balance->due, $success_route); // You can call simply $shurjopay_service->sendPayment(2) without success route
        }else{
            return redirect()->back();
        }
    }

    public function response(Request $request)
    {
        if ($request->all()['status'] == 'Success'){
            $payment = new Payment();
            $payment->user_id = auth()->user()->id;
            $payment->amount = $request->all()['amount'];
            $payment->tx_id = $request->all()['tx_id'];
            $payment->bank_tx_id = $request->all()['bank_tx_id'];
            $payment->purpose = 'Worker due clearance';
            $payment->save();

            $balance = auth()->user()->balance;
            $balance->due -= $request->all()['amount'];
            $balance->save();
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

    // register Or Activation Request
    public function registerOrActivationRequest(Request $request){
        $request->validate([
            'user' =>  'required|exists:users,id',
            'purpose'    =>  'required|string'
        ]);

        $amount = get_static_option('worker_activation_price');

        try {
            
            pay($request->input('amount'), route('activationPayment', [$request->input('user'), $request->input('purpose')]));
        }catch (\Exception $exception){
            return redirect()->back();
        }

    }
    // register Or Activation Request
    public function activationPayment($worker, $purpose, Request $request){
        if ($request->all()['status'] == 'Success'){
            $payment = new Payment();
            $payment->user_id = $worker;
            $payment->amount = $request->all()['amount'];
            $payment->tx_id = $request->all()['tx_id'];
            $payment->bank_tx_id = $request->all()['bank_tx_id'];
            $payment->purpose = $purpose;
            $payment->current_price = get_static_option('worker_activation_price');
            $payment->save();

        }
        return view('payment-response')->with('status', $request->all()['status']);

    }


}
