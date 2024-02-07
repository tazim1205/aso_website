<?php

namespace App\Http\Controllers\Guest;

use Image;
use App\User;
use App\Upazila;
use App\Puroshova;
use App\Word;
use App\WorkerService;
use App\MembershipService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Payment;
use Illuminate\Support\Facades\Crypt;


class AjaxController extends Controller
{
    //Get upazila by specific district
    public function getUpazilaOfDistrict(Request $request){
        $request->validate([
            'districtId' => 'required|exists:upazilas,id',
        ]);
        return Upazila::where('district_id', $request->input('districtId'))->get();
    }

    public function getpouroshavaofupazila(Request $request){
        // $request->validate([
        //     'upazila' => 'required|exists:puroshovas,id',
        // ]);

        
        return Puroshova::where('upazila_id', $request->input('upazila'))->with('word')->get();
    }

    public function getpouroshavaofupazilaHtml(Request $request){
        // $request->validate([
        //     'upazila' => 'required|exists:puroshovas,id',
        // ]);

        $html = '';

        foreach (Puroshova::where('upazila_id', $request->input('upazila'))->with('word')->get() as $pouroshova) {
            $html .=
            '<optgroup label="'.$pouroshova->name.'">';
                foreach($pouroshova->word as $word){
                    $html .=
                    '<option value="'.$word->id.'">'.$word->name.'</option>';
                }
            $html .=
            '</optgroup>';
        }

        return json_encode($html);
    }

    public function getwordofpouroshava(Request $request){
        $request->validate([
            'pouroshova' => 'required|exists:words,id',
        ]);
        return Word::where('puroshova_id', $request->input('pouroshova'))->get();
    }

    //Get worker services by specific category
    public function getServicesOfCategory(Request $request){
        $request->validate([
            'categoryId' => 'required|exists:worker_services,id',
        ]);
        return WorkerService::where('category_id', $request->input('categoryId'))->get();
    }

    //Get membership services by specific category
    public function getMembershipServicesOfCategory(Request $request){
        $request->validate([
            'categoryId' => 'required|exists:membership_services,id',
        ]);
        $membershipService =  MembershipService::where('category_id', $request->input('categoryId'))->get();
        return $membershipService;
    }

    public function guestWorkerPayment($worker){
        $user = User::findOrfail(Crypt::decryptString($worker));
        if($user->payments()->where('purpose', 'Resistration')->count() < 1){
            $paymentAmount = get_static_option('worker_activation_price');
        }else{
            $paymentAmount =  $user->balance->due;
        }
        try {
           pay($paymentAmount, route('membership.paymentResponse', [$user]));
        }catch (\Exception $exception){
            return redirect()->back();
        }
    }

    public function guestWorkerPaymentResponse($user, Request $request)
    {
        echo($user);
        dd($request);
        if ($request->all()['status'] == 'Success'){
            $payment = new Payment();
            $payment->user_id = $user;
            $payment->amount = $request->all()['amount'];
            $payment->tx_id = $request->all()['tx_id'];
            $payment->bank_tx_id = $request->all()['bank_tx_id'];
            if($user->payments()->where('purpose', 'Resistration')->count() < 1){
                $payment->purpose = 'Resistration';
                $payment->current_price = get_static_option('worker_activation_price');
            }else{
                $payment->purpose = 'Due';
                $payment->current_price =  get_static_option('admin_percent_on_worker_job');
            }
            $payment->save();


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
