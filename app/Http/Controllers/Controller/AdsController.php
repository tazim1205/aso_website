<?php

namespace App\Http\Controllers\Controller;

use App\AdminAds;
use App\ControllerAds;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Intervention\Image\ImageManagerStatic as Image;


class AdsController extends Controller
{
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {

        return view('controller.ads.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * @param Request $request
     * @return ControllerAds
     */
    public function store(Request $request)
    {
        $request->validate([
            'url'           => 'nullable',
            'startingDate'  => 'required',
            'endingDate'    => 'required',
            'image'         => 'required|image',
        ]);

        $ads = new ControllerAds();
        $ads->controller_id = Auth::user()->id;
        $ads->url = $request->input('url');

        $ads->starting = $request->input('startingDate');
        $ads->ending = $request->input('endingDate');

        if ($request->input('activation') ==1){
            $ads->status = 1;
        }else{
            $ads->status = 0;
        }
        if($request->hasFile('image')){
            $image             = $request->file('image');
            $folder_path       = 'uploads/images/controller/';
            $image_new_name    = Str::random(8).'-controller-ads--'.Carbon::now()->format('d-m-Y H-i-s') .'.'. $image->getClientOriginalExtension();
            //resize and save to server
            Image::make($image->getRealPath())->resize(500, 300, function($constraint){
                $constraint->aspectRatio();
            })->save($folder_path.$image_new_name);
            $ads->image    = $folder_path.$image_new_name;
        }

        $ads->save();
        return $ads;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $id = $request->input('id');
        $request->validate([
            'url'           => 'nullable',
            'startingDate'  => 'required',
            'endingDate'    => 'required',
            //'image'         => 'required|image',
        ]);
        $ads = ControllerAds::find($id);
        $ads->url = $request->input('url');
        $ads->starting = $request->input('startingDate');
        $ads->ending = $request->input('endingDate');

        if ($request->input('activation') == 1){
            $ads->status = 1;
        }else{
            $ads->status = 0;
        }
        if($request->hasFile('image')){
            $image             = $request->file('image');
            $folder_path       = 'uploads/images/controller/';
            $image_new_name    = Str::random(8).'-controller-ads--'.Carbon::now()->format('d-m-Y H-i-s') .'.'. $image->getClientOriginalExtension();
            //resize and save to server
            Image::make($image->getRealPath())->resize(500, 300, function($constraint){
                $constraint->aspectRatio();
            })->save($folder_path.$image_new_name);
            $ads->image    = $folder_path.$image_new_name;
        }
        $ads->save();
        return $ads;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $ads = ControllerAds::find($id);
        $ads->delete();
        return redirect()->back()->with('success', 'Ads deleted successfully');
    }

    public function enable($id)
    {
        $ads = ControllerAds::find($id);
        $ads->status = 1;
        $ads->save();
        return redirect()->back()->with('success', 'Ads enabled successfully');
    }

    public function disabled($id)
    {
        $ads = ControllerAds::find($id);
        $ads->status = 0;
        $ads->save();
        return redirect()->back()->with('success', 'Ads disabled successfully');
    }
}
