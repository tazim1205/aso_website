<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\SpecialProfile;
use App\SpecialService;
use App\SpecialServiceOrder;
use Illuminate\Http\Request;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Intervention\Image\ImageManagerStatic as Image;

class SpecialServiceController extends Controller
{
    public function showSpecialProfiles($special_service_id){
        $special_service_name = SpecialProfile::find($special_service_id);
        if ($special_service_name != null){
            $special_profiles = auth()->user()->upazila->special_profiles
                ->where('id', $special_service_id)->first();
            return view('customer.others.special-profiles',compact('special_profiles'))
                ->with('service', $special_service_name);
        }else{
            return redirect()->back();
        }

    }

    public function showOrderForm($special_service_id){
        $service = SpecialProfile::find($special_service_id);
        return view('customer.others.service-order',compact('service'));
    }

    public function store(Request $request){
        $request->validate([
           'details' => 'required',
           'address' => 'required',
           'transaction_id' => 'required',
           'fee' => 'required',
           'image' => 'nullable|max:500',
        ]);

        $order = new SpecialServiceOrder();
        $order->customer_id   = auth()->user()->id;
        $order->upazila_id   = auth()->user()->upazila->id;
        $order->service_id  = $request->input('id');
        $order->description   = $request->input('details');
        $order->address   = $request->input('address');
        $order->transaction_no   = $request->input('transaction_id');
        $order->fee   = $request->input('fee');
        if($request->hasFile('image')){
            $image             = $request->file('image');
            $folder_path       = 'uploads/images/special/profile/';
            $image_new_name    = Str::random(8).'-special-service-'.Carbon::now()->format('d-m-Y H-i-s') .'.'. $image->getClientOriginalExtension();
            //resize and save to server
            Image::make($image->getRealPath())->resize(500, 300, function($constraint){
                $constraint->aspectRatio();
            })->save($folder_path.$image_new_name);
            $order->image    = $folder_path.$image_new_name;
        }
        $order->save();

        return redirect()->back();
    }
}
