<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Intervention\Image\ImageManagerStatic as Image;

use App\StaticOption;

class SettingController extends Controller
{
    public function showGeneralInformation(){
        return view('admin.setting.general-information');
    }



    public function updateGeneralInformation(Request $request){

        update_static_option('name', $request->input('name'));

        if($request->hasFile('logo')){
            $image             = $request->file('logo');
            $folder_path       = 'uploads/images/';
            $image_new_name    = Str::random(8).'-logo-'.Carbon::now()->format('d-m-Y H-i-s') .'.'. $image->getClientOriginalExtension();
            //resize and save to server
            Image::make($image->getRealPath())->fit(280, 84, function($constraint){
                $constraint->aspectRatio();
            })->save($folder_path.$image_new_name);
            update_static_option('logo', $folder_path.$image_new_name);
        }

        if($request->hasFile('logo_white')){
            $image             = $request->file('logo_white');
            $folder_path       = 'uploads/images/';
            $image_new_name    = Str::random(8).'-logo_white-'.Carbon::now()->format('d-m-Y H-i-s') .'.'. $image->getClientOriginalExtension();
            //resize and save to server
            Image::make($image->getRealPath())->fit(280, 84, function($constraint){
                $constraint->aspectRatio();
            })->save($folder_path.$image_new_name);
            update_static_option('logo_white', $folder_path.$image_new_name);
        }

        if($request->hasFile('header_logo')){
            $image             = $request->file('header_logo');
            $folder_path       = 'uploads/images/';
            $image_new_name    = Str::random(8).'-header_logo-'.Carbon::now()->format('d-m-Y H-i-s') .'.'. $image->getClientOriginalExtension();
            //resize and save to server
            Image::make($image->getRealPath())->fit(133, 51, function($constraint){
                $constraint->aspectRatio();
            })->save($folder_path.$image_new_name);
            update_static_option('header_logo', $folder_path.$image_new_name);
        }

        if($request->hasFile('header_logo_white')){
            $image             = $request->file('header_logo_white');
            $folder_path       = 'uploads/images/';
            $image_new_name    = Str::random(8).'-header_logo_white-'.Carbon::now()->format('d-m-Y H-i-s') .'.'. $image->getClientOriginalExtension();
            //resize and save to server
            Image::make($image->getRealPath())->fit(133, 51, function($constraint){
                $constraint->aspectRatio();
            })->save($folder_path.$image_new_name);
            update_static_option('header_logo_white', $folder_path.$image_new_name);
        }

        if($request->hasFile('fav')){
            $image             = $request->file('fav');
            $folder_path       = 'uploads/images/';
            $image_new_name    = Str::random(8).'-fav-'.Carbon::now()->format('d-m-Y H-i-s') .'.'. $image->getClientOriginalExtension();
            //resize and save to server
            Image::make($image->getRealPath())->fit(68, 68, function($constraint){
                $constraint->aspectRatio();
            })->save($folder_path.$image_new_name);
            update_static_option('fav', $folder_path.$image_new_name);
        }
        //motto update
        if($request->has('motto')){
            update_static_option('motto', $request->input('motto'));
        }
        if($request->has('worker_maximum_due_permission')){
            update_static_option('worker_maximum_due_permission', $request->input('worker_maximum_due_permission'));
        }
        if($request->has('sms_username')){
            update_static_option('sms_username', $request->input('sms_username'));
        }
        if($request->has('sms_key')){
           update_static_option('sms_key', $request->input('sms_key'));
        }
        if($request->has('reset_sms_count')){
           update_static_option('reset_sms_count', $request->input('reset_sms_count'));
        }
        if($request->has('reset_sms_template')){
           update_static_option('reset_sms_template', $request->input('reset_sms_template'));
        }
        if($request->has('welcome_sms_template')){
           update_static_option('welcome_sms_template', $request->input('welcome_sms_template'));
        }
        if($request->has('worker_activation_price')){
           update_static_option('worker_activation_price', $request->input('worker_activation_price'));
        }

        if($request->has('per_customer_referral_price')){
           update_static_option('per_customer_referral_price', $request->input('per_customer_referral_price'));
        }
        if($request->has('per_worker_referral_price')){
           update_static_option('per_worker_referral_price', $request->input('per_worker_referral_price'));
        }
        if($request->has('per_membership_referral_price')){
           update_static_option('per_membership_referral_price', $request->input('per_membership_referral_price'));
        }
        if($request->has('admin_percent_on_worker_job')){
           update_static_option('admin_percent_on_worker_job', $request->input('admin_percent_on_worker_job'));
        }
        if($request->has('static_available_survice')){
           update_static_option('static_available_survice', $request->input('static_available_survice'));
        }
        if($request->has('static_customer_survice')){
            update_static_option('static_customer_survice', $request->input('static_customer_survice'));
        }
        if($request->has('static_worker_survice')){
            update_static_option('static_worker_survice', $request->input('static_worker_survice'));
        }
        if($request->has('static_provider_survice')){
            update_static_option('static_provider_survice', $request->input('static_provider_survice'));
        }
        if($request->has('order_commission_time')){
            update_static_option('order_commission_time', $request->input('order_commission_time'));
        }
        if($request->has('order_commission_percent')){
            update_static_option('order_commission_percent', $request->input('order_commission_percent'));
        }
        if($request->has('job_complete_amount')){
            update_static_option('job_complete_amount', $request->input('job_complete_amount'));
        }
        if($request->has('worker_registration_commission_amount')){
            update_static_option('worker_registration_commission_amount', $request->input('worker_registration_commission_amount'));
        }
        if($request->has('worker_job_request_accept_hour')){
            update_static_option('worker_job_request_accept_hour', $request->input('worker_job_request_accept_hour'));
        }
        if($request->has('order_bid_limit_amount')){
            update_static_option('order_bid_limit_amount', $request->input('order_bid_limit_amount'));
        }
        if($request->has('free_balance_amount_for_worker')){
            update_static_option('free_balance_amount_for_worker', $request->input('free_balance_amount_for_worker'));
        }
        if($request->has('membership_commission_percent')){
            update_static_option('membership_commission_percent', $request->input('membership_commission_percent'));
        }
        if($request->has('monthly_income_for_target_filup')){
           update_static_option('monthly_income_for_target_filup', $request->input('monthly_income_for_target_filup'));
        }
        if($request->has('monthly_bonust_amount')){
           update_static_option('monthly_bonust_amount', $request->input('monthly_bonust_amount'));
        }
        if($request->has('marketer_monthly_income')){
           update_static_option('marketer_monthly_income', $request->input('marketer_monthly_income'));
        }
        if($request->has('marketer_commission_percent')){
           update_static_option('marketer_commission_percent', $request->input('marketer_commission_percent'));
        }
        if($request->has('customer_first_number_order')){
           update_static_option('customer_first_number_order', $request->input('customer_first_number_order'));
        }
        if($request->has('withdraw_times')){
           update_static_option('withdraw_times', $request->input('withdraw_times'));
        }
        if($request->has('withdraw_limit')){
           update_static_option('withdraw_limit', $request->input('withdraw_limit'));
        }

        if($request->has('area_controller_percent')){
            update_static_option('area_controller_percent', $request->input('area_controller_percent'));
        }
        if($request->has('marketing_fund_reserve')){
            update_static_option('marketing_fund_reserve', $request->input('marketing_fund_reserve'));
        }


        return redirect()->back();
       // return redirect('admin.setting.general-information');
    }
      public function showGeneralMarketerCommission(){
        return view('admin.setting.general-marketer-comm');
    }



    public function addWithdrawBy(Request $request){
        $StaticOption = new StaticOption();
        $StaticOption->option_name = 'withdraw by';
        $StaticOption->option_value = $request->option_name;
        $StaticOption->save();
        return redirect()->back();
    }

    public function deleteWithdrawBy($id){
        $StaticOption = StaticOption::find($id);
        $StaticOption->delete();
        return redirect()->back();
    }
}
