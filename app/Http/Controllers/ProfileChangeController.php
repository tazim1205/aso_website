<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class ProfileChangeController extends Controller
{
    // update Users Self Profile Info
    public function updateUsersSelfProfileInfo(Request $request){
        $request->validate([
            'full_name'  => 'required|string',
            'gender'    => 'required',
            'user_name'    =>  'required|string|unique:users,user_name,'.auth()->user()->id,
            'profile_image'    => 'nullable|image',
            // 'location'    => 'required|string',
        ]);

        

        $user = User::findOrFail(auth()->user()->id);

        $user->full_name =$request->full_name;
        // $user->phone   =  $request->phone;
        $user->email  =   $request->email;
        $user->gender =   $request->gender;
        $user->user_name =$request->user_name;

        if (isset($request->worker_service)) {
            $service = '';
            for ($i=0; $i < count($request->worker_service); $i++) { 
                $service .= $request->worker_service[$i];
                $service .= ',';
            }

            $user->worker_service   =  $service;

            // var_dump($service);
            // exit();
        }


        // $user->location =$request->location;

        if($request->hasFile('profile_image')){
            $image             = $request->file('profile_image');
            $folder_path       = 'uploads/images/users';
            $image_new_name    = Str::random(20).'-'.now()->timestamp.'.'.$image->getClientOriginalExtension();
            //resize and save to server
            Image::make($image->getRealPath())->save($folder_path.$image_new_name);
            $user->image   = $folder_path . $image_new_name;
        }

        $user->save();
        return back()->withSuccess('Successfully updated');


    }
}
