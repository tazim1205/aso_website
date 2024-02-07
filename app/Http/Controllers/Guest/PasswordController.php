<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;

use App\SmsSender;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class PasswordController extends Controller
{
    public function resetPassword(Request $request){
        $request->validate([
            'phone' => 'required|exists:users,phone'
        ]);
/*
        $smsSender = new SmsSender();
        $messageResponse = $smsSender->smsSender($request->input('phone'),'Message');
        return $messageResponse;
*/
        $user = User::where('phone', $request->input('phone'))->first();

        if ($user->reset_date != Carbon::today() || $user->reset_count < get_static_option('reset_sms_count')){
            //under available reset sms
            $user->reset_count++; // reset sms counting
            $otp = Str::random(4);
            $user->reset_date = Carbon::today();
            $user->temp_otp = $otp;
            $smsSender = new SmsSender();
            $readySms = get_static_option('reset_sms_template').$otp.' লগিন করুনঃ '.route('otp.check');
            $messageResponse = $smsSender->smsSender($user->phone, $readySms);

            if ($messageResponse){
                $user->save();
                return response()->json([
                    'message'=>'আপনার নাম্বারে Otp পাঠানো হয়েছে। লগইন করুণ !',
                    'type'=>'success',
                    'url'=>route('otp.check')
                ]);
            }else{
                return response()->json(['message'=>'আপনার নাম্বারে Otp পাঠানো সম্ভব হচ্ছে না', 'type'=> 'danger','url'=>route('login')]);
            }
        }else{
            //Over available reset sms
            return response()->json(['message'=>'আপনি আজকে সর্বাধিক সংখ্যক চেষ্টা করেছেন।', 'type','danger']);
        }
    }
    public function otpCheck(){
        return view('auth.otp-check');
    }
    public function otpCheckPost(Request $request){
        $this->validate($request, [
            'phone' => 'required|exists:users,phone',
            'otp' => 'required|exists:users,temp_otp',
            'password' => 'min:6|required_with:confirm_password|same:confirm_password',
            'confirm_password' => 'min:6'
        ]);
        $user = User::where('phone',$request->phone)->first();
        $hashedPassword = $user->password;
        if (!Hash::check($request->password, $hashedPassword)) {
            $user->password = bcrypt($request->password);
            $user->temp_otp = null;
            $user->save();
            return redirect()->route('login')->withToastSuccess( 'Password updated successfully');
        } else {
            return back()->withErrors( 'New password can not be the old password !');
        }
    }
}
