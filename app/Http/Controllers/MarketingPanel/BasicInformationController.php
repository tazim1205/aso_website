<?php

namespace App\Http\Controllers\MarketingPanel;

use App\AdminAds;
use App\MarketerTrainingVideos;
use App\MarketerHelplines;
use App\User;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Intervention\Image\ImageManagerStatic as Image;


class BasicInformationController extends Controller
{
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */

    // training video

    public function trainingVideo()
    {
        $user_id = Auth::user()->id;
        $allads = MarketerTrainingVideos::where('controller_id', $user_id)->orderBy('id', 'desc')->get();
        return view('marketing_panel.basic_options.video-training', compact('allads'));
    }

    public function trainingVideostore(Request $request)
    {
        $request->validate([
            'title'           => 'required',
        ]);

        $user = User::where('id',Auth::user()->id)->first();
        $ads = new MarketerTrainingVideos();
        $ads->controller_id = Auth::user()->id;
        $ads->link = $request->input('detail');
        $ads->district_id = $user->district_id;
        $ads->upazila_id = $user->upazila_id;
        $ads->video_for = $request->video_for;
        $ads->title = $request->input('title');

        if ($request->has('activation') && $request->input('activation') ==1){
            $ads->status = 1;
        }else{
            $ads->status = 0;
        }
        $ads->save();
        return $ads;
    }

    public function trainingVideoupdate(Request $request)
    {

        // return var_dump($request->video_for);
        // exit();

        $id = $request->input('id');
        $request->validate([
            'title'           => 'required',
            'video_for'           => 'required',
        ]);

        $ads = MarketerTrainingVideos::find($id);
        $ads->link = $request->input('detail');
        $ads->title = $request->input('title');
        $ads->video_for = $request->video_for;

        if ($request->has('activation') && $request->input('activation') ==1){
            $ads->status = 1;
        }else{
            $ads->status = 0;
        }
        $ads->save();

        return $ads;
    }

    public function trainingVideodelete(Request $request)
    {
        $id = $request->input('id');
        $ads = MarketerTrainingVideos::find($id);

        $ads->delete();
        return $ads;
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    // helpline

    public function helpline()
    {
        $user_id = Auth::user()->id;
        $notices = MarketerHelplines::where('controller_id', $user_id)->orderBy('id', 'desc')->get();
        return view('marketing_panel.basic_options.helpline', compact('notices'));
    }

    public function helplinestore(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'phone' => 'required',
        ]);
        $user = User::where('id',Auth::user()->id)->first();
        $notice = new MarketerHelplines();
        $notice->controller_id = Auth::user()->id;
        $notice->district_id = $user->district_id;
        $notice->upazila_id = $user->upazila_id;
        $notice->email = $request->input('email');
        $notice->phone = $request->input('phone');
        $notice->save();
        return $notice;
    }

    public function helplineupdate(Request $request)
    {
        $id = $request->input('id');
        $request->validate([
            'email' => 'required',
            'phone' => 'required',
        ]);

        $notice = MarketerHelplines::find($id);
        $notice->email = $request->input('email');
        $notice->phone = $request->input('phone');
        $notice->save();
        return $notice;
    }

    public function helplinedelete(Request $request)
    {
        $id = $request->input('id');
        $notice = MarketerHelplines::find($id);

        $notice->delete();
        return $notice;
    }

    /**
     * @param Request $request
     * @return TrainingVideos
     */
    public function store(Request $request)
    {
        $request->validate([
            'url'           => 'nullable',
            'startingDate'  => 'required',
            'endingDate'    => 'required',
            'image'         => 'required|image',
        ]);

        $ads = new MarketerControllerAds();
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
            $folder_path       = 'uploads/images/marketerpanel/';
            $image_new_name    = Str::random(8).'-marketerpanel-ads--'.Carbon::now()->format('d-m-Y H-i-s') .'.'. $image->getClientOriginalExtension();
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
        $ads = MarketerControllerAds::find($id);
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
            $folder_path       = 'uploads/images/marketerpanel/';
            $image_new_name    = Str::random(8).'-marketerpanel-ads--'.Carbon::now()->format('d-m-Y H-i-s') .'.'. $image->getClientOriginalExtension();
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
    public function destroy(Request $request)
    {
        $id = $request->input('id');
        $ads = MarketerControllerAds::find($id);
        if ($ads->image) {
            unlink($ads->image);
        }
        $ads->delete();
        return $ads;
    }
}
