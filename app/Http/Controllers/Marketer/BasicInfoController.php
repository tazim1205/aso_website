<?php

namespace App\Http\Controllers\Marketer;

use App\AdminAds;
use App\MarketerTrainingVideos;
use App\MarketerHelplines;
use App\User;

use App\Faq;
use App\ServiceDetail;
use App\About;
use App\TermsAndCondition;
use App\PrivacyPolicy;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Intervention\Image\ImageManagerStatic as Image;
use DB;


class BasicInfoController extends Controller
{
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */

    // training video 

    public function trainingVideo()
    {
        $user_id = Auth::user();
        $allVideo = MarketerTrainingVideos::where('district_id', $user_id->district_id)->where('upazila_id', $user_id->upazila_id)->where('status',1)->where('video_for','Marketer')->orderBy('id', 'desc')->get();
        return view('marketer.others.training-video', compact('allVideo'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    // helpline

    public function helpline()
    {

        return view('marketer.others.helpline');
    }

    public function filterHelpline($district,$upazila)
    {
        $helpline = DB::table('marketer_helplines')->where('district_id',$district)->where('upazila_id',$upazila)->get();
        foreach($helpline as $ads){
            echo '
            <div class="col-lg-4 col-12">
                <div class="card " style="border: 1px solid green;">
                    <div class="card-body text-center">
                        <div class="d-flex justify-content-between bd-highlight mb-2">
                            <div class="bd-highlight">'.$ads->phone.'</div>
                            <a class="bg-success p-1 text-light" href="tel:'.$ads->phone.'">Call Now</a>
                        </div>
                        <div class="d-flex justify-content-between bd-highlight">
                            <div class="bd-highlight">'.$ads->email.'</div>
                            <a class=" bg-success p-1 text-light" href="mailto:'.$ads->email.'">Email Now</a>
                        </div>
                    </div>
                </div>
            </div>';
        }
    }

    public function Faq()
    {   
        $customer_faq = Faq::where('faq_for','marketer')->get();
        return view('marketer.others.faq', compact('customer_faq'));
    }

    public function serviceDetails()
    {   
        $customer_service = ServiceDetail::where('faq_for','marketer')->get();
        return view('marketer.others.service-details', compact('customer_service'));
    }

    public function about()
    {   
        $about = About::orderByDesc('id')->first();
        return view('marketer.others.about', compact('about'));
    }

    public function termsCondition()
    {   
        $customer_terms = TermsAndCondition::where('about_for', 'marketer')->orderByDesc('id')->first();
        return view('marketer.others.terms-condition', compact('customer_terms'));
    }

    public function privacyPolicy()
    {   
        $customer_privacy = PrivacyPolicy::where('about_for', 'marketer')->orderByDesc('id')->first();
        return view('marketer.others.privacy-policy', compact('customer_privacy'));
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
