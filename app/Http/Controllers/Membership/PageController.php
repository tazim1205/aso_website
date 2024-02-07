<?php

namespace App\Http\Controllers\Membership;

use App\District;
use App\Http\Controllers\Controller;
use App\MembershipServiceCategory;
use App\MembershipServiceProfile;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Intervention\Image\ImageManagerStatic as Image;

class PageController extends Controller
{
    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function index()
    {
        if (auth()->user()->membership()->count() > 0){
            if (auth()->user()->membershipPages->count() > 0){
                return redirect()->route('membership.page.edit', auth()->user()->membershipPages->first()->id);
            }else{
                return redirect()->route('membership.page.create');
            }
        }else{
            return redirect()->route('membership.home.index');
        }
        //return view('membership.page.index');
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function create()
    {
        if (auth()->user()->membership()->count() > 0){

            if (auth()->user()->membershipPages->count() > 0){
                return redirect()->route('membership.page.edit', auth()->user()->membershipPages->first()->id);
            }else{
                $categories= MembershipServiceCategory::all();
                return view('membership.page.create',compact('categories'));
            }

        }else{
            return redirect()->route('membership.home.index');
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {

        $request->validate([
           'name' => 'required|min:1',
           'service' => 'required|exists:membership_services,id',
        ]);

        $membership_page = new MembershipServiceProfile();

        $membership_page->member_id =   auth()->user()->id;
        $membership_page->upazila_id =   auth()->user()->upazila->id;
        $membership_page->position  =   auth()->user()->membership->membershipPackage->position;
        $membership_page->membership_service_id =   $request->input('service');

        if($request->hasFile('logo')){
            $image             = $request->file('logo');
            $folder_path       = 'uploads/images/membership/profile/';
            $image_new_name    = Str::random(8).'-logo-'.Carbon::now()->format('d-m-Y H-i-s') .'.'. $image->getClientOriginalExtension();
            //resize and save to server
            Image::make($image->getRealPath())->fit(500, 500, function($constraint){
                $constraint->aspectRatio();
            })->save($folder_path.$image_new_name);
            $membership_page->logo    = $folder_path.$image_new_name;
        }

        $membership_page->name  =   $request->input('name');
        $membership_page->mobile    =   $request->input('mobile');
        $membership_page->title =   $request->input('title');
        $membership_page->description   =   $request->input('description');
        $membership_page->address   =   $request->input('address');

        for ($image_amount=1; $image_amount <= auth()->user()->membership->membershipPackage->image_count; $image_amount++){
            if($request->hasFile('image-'.$image_amount)){
                $image             = $request->file('image-'.$image_amount);
                $folder_path       = 'uploads/images/membership/profile/';
                $image_new_name    = Str::random(8).'-image-'.$image_amount.'-'.Carbon::now()->format('d-m-Y H-i-s') .'.'. $image->getClientOriginalExtension();
                //resize and save to server
                Image::make($image->getRealPath())->fit(500, 500, function($constraint){
                    $constraint->aspectRatio();
                })->save($folder_path.$image_new_name);
                $ready_image = 'image'.$image_amount;
                $membership_page->$ready_image    = $folder_path.$image_new_name;
            }
        }

        try {
            $membership_page->save();
            return response()->json([
                'type' => 'success',
                'message' => 'Success',
                'url' => route('membership.page.edit', $membership_page->id) ,
            ]);
        }catch (\Exception $exception){
            return response()->json([
                'type' => 'danger',
                'message' => 'Something going wrong.  Error:'.$exception->getMessage(),
            ]);
        }

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
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function edit($id)
    {
        if (auth()->user()->membershipPages->first()->id != $id){
            return redirect()->back();
        }
        $myPage = MembershipServiceProfile::find($id);
        return view('membership.page.edit', compact('myPage'));
       ///echo $memberPage;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|min:1',
            'service' => 'required|exists:membership_services,id',
        ]);

        $membership_page = auth()->user()->membershipPages->first();

        //$membership_page->member_id =   auth()->user()->id;
        $membership_page->membership_service_id =   $request->input('service');
        if($request->hasFile('logo')){
            $image             = $request->file('logo');
            $folder_path       = 'uploads/images/membership/profile/';
            $image_new_name    = Str::random(8).'-logo-'.Carbon::now()->format('d-m-Y H-i-s') .'.'. $image->getClientOriginalExtension();
            //resize and save to server
            Image::make($image->getRealPath())->fit(500, 500, function($constraint){
                $constraint->aspectRatio();
            })->save($folder_path.$image_new_name);
            $membership_page->logo    = $folder_path.$image_new_name;
        }

        $membership_page->name  =   $request->input('name');
        $membership_page->mobile    =   $request->input('mobile');
        $membership_page->title =   $request->input('title');
        $membership_page->description   =   $request->input('description');
        $membership_page->address   =   $request->input('address');

        for ($image_amount=1; $image_amount <= auth()->user()->membership->membershipPackage->image_count; $image_amount++){
            if($request->hasFile('image-'.$image_amount)){
                $image             = $request->file('image-'.$image_amount);
                $folder_path       = 'uploads/images/membership/profile/';
                $image_new_name    = Str::random(8).'-image-'.$image_amount.'-'.Carbon::now()->format('d-m-Y H-i-s') .'.'. $image->getClientOriginalExtension();
                //resize and save to server
                Image::make($image->getRealPath())->fit(500, 500, function($constraint){
                    $constraint->aspectRatio();
                })->save($folder_path.$image_new_name);
                $ready_image = 'image'.$image_amount;
                $membership_page->$ready_image    = $folder_path.$image_new_name;
            }
        }

        try {
            $membership_page->save();
            return response()->json([
                'type' => 'success',
                'message' => 'Success',
                'url' => route('membership.page.edit', $membership_page->id) ,
            ]);
        }catch (\Exception $exception){
            return response()->json([
                'type' => 'danger',
                'message' => 'Something going wrong.  Error:'.$exception->getMessage(),
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
