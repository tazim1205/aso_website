<?php

namespace App\Http\Controllers\Worker;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\MembershipPackage;
use App\WorkerPage;
use App\WorkerPageImage;
use App\WorkerServiceCategory;
use App\PageService;

use Auth, Image;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Crypt;
use Carbon\Carbon;

class WorkerPageController extends Controller
{
    function store(Request $request){
        if (membershipPackage::withTrashed()->find($request->package_id)->description_availability == 1 && membershipPackage::withTrashed()->find($request->package_id)->mobile_availability == 1) {
            $request->validate([
                'package_id'        => 'required|int',
                'name'             => 'required|string|min:5|max:40',
                'title'             => 'required|string|min:5|max:80',
                'service'           => 'required',
                'worker_service'    => 'required',
                'location'          => 'required',

                'description'       => 'required|string|min:15|max:3000',
                'address'           => 'required|string|min:15|max:300',

                'phone'             => 'required|numeric',
                // 'image'             => 'required|image|mimes:jpeg,png,jpg,gif',
            ]);
        }elseif (membershipPackage::withTrashed()->find($request->package_id)->description_availability == 1) {
            $request->validate([
                'package_id'        => 'required|int',
                'name'             => 'required|string|min:5|max:40',
                'title'             => 'required|string|min:3|max:80',
                'service'           => 'required',
                'worker_service'    => 'required',
                'location'          => 'required',

                'description'       => 'required|string|min:15|max:3000',
                'address'           => 'required|string|min:15|max:300',
                // 'image'             => 'required|image|mimes:jpeg,png,jpg,gif',
            ]);
        }elseif (membershipPackage::withTrashed()->find($request->package_id)->mobile_availability == 1) {
            $request->validate([
                'package_id'        => 'required|int',
                'name'             => 'required|string|min:5|max:40',
                'title'             => 'required|string|min:3|max:80',
                'service'           => 'required',
                'worker_service'    => 'required',
                'location'          => 'required',

                'phone' => 'required|numeric',
                // 'image'             => 'required|image|mimes:jpeg,png,jpg,gif',
            ]);
        }else {
            $request->validate([
                'package_id'        => 'required|int',
                'name'             => 'required|string|min:5|max:40',
                'title'             => 'required|string|min:3|max:80',
                'service'           => 'required',
                'worker_service'    => 'required',
                'location'          => 'required',
                // 'image'             => 'required|image|mimes:jpeg,png,jpg,gif',
            ]);
        }

        if (membershipPackage::withTrashed()->find($request->package_id)->description_availability == 1) {
            $description = $request->description;
            $address = $request->address;
        }else {
            $description = NULL;
            $address = NULL;
        }
        
        if (membershipPackage::withTrashed()->find($request->package_id)->mobile_availability == 1) {
            $phone = $request->phone;
        }else {
            $phone = NULL;
        }

        // $services = $request->service;
        // $service = "";
        // foreach ($services as $service) {
        //     $service = $service.",";
        // }
        // $service;

        // $workerservices = $request->worker_service;
        // $worker_service = "";
        // foreach ($workerservices as $worker_service) {
        //     $worker_service = $worker_service.",";
        // }
        // $worker_service;
        $image_path = '';
        if($request->hasFile('image')){
            $image             = $request->file('image');
            $folder_path       = 'uploads/images/worker/pages/';
            $image_new_name    = Str::random(8).'-worker-page--'.Carbon::now()->format('d-m-Y H-i-s') .'.'. $image->getClientOriginalExtension();
            //resize and save to server
            Image::make($image->getRealPath())->resize(500, 300, function($constraint){
                $constraint->aspectRatio();
            })->save($folder_path.$image_new_name);
            $image_path .= $folder_path.$image_new_name;
        }

        WorkerPage::insert([
            'worker_id' => Auth::id(),
            'membership_id' => auth()->user()->membership->id,
            'name' => $request->name,
            'title' => $request->title,
            'description' => $description,
            'address' => $address,
            'services' => $request->service,
            'worker_services' => $request->worker_service,
            'phone' => $phone,
            'image' => $image_path,
            'location' => $request->location,
            'created_at' => Carbon::now()
        ]);
        session(['page_click' => 'load page']);
    }
    

    public function show($id){

        $workerpage = WorkerPage::find(Crypt::decryptString($id));
        $categories = WorkerServiceCategory::orderBy('id', 'desc')->get();
        if ($workerpage->worker_id == Auth::user()->id){
            return view('worker.page.show', compact('workerpage', 'categories'));
        }else{
            return redirect()->back();
        }
    }

     public function edit($id){

        $workerpage = WorkerPage::find(Crypt::decryptString($id));
        $categories = WorkerServiceCategory::all();
        $page_service = PageService::where('worker_id', Auth::id())->get();
        if ($workerpage->worker_id == Auth::user()->id){
            return view('worker.page.edit', compact('workerpage','categories', 'page_service'));
        }else{
            return redirect()->back();
        }
    }

    function update(Request $request){
        
        if (membershipPackage::withTrashed()->find($request->package_id)->description_availability == 1 && membershipPackage::withTrashed()->find($request->package_id)->mobile_availability == 1) {
            $request->validate([
                'package_id'        => 'required|int',
                'name'             => 'required|string|min:5|max:40',
                'title'             => 'required|string|min:3|max:80',
                // 'service'           => 'required',
                // 'worker_service'    => ["required","array","min:1","max:2"],
                'location'          => 'required',

                'description'       => 'required|string|min:15|max:2000',
                'address'           => 'required|string|min:15|max:80',

                'phone'             => 'required|numeric',
            ]);
        }elseif (membershipPackage::withTrashed()->find($request->package_id)->description_availability == 1) {
            $request->validate([
                'package_id'        => 'required|int',
                'name'             => 'required|string|min:5|max:40',
                'title'             => 'required|string|min:3|max:80',
                // 'service'           => 'required',
                // 'worker_service'    => ["required","array","min:1","max:2"],
                'location'          => 'required',

                'description'       => 'required|string|min:15|max:2000',
                'address'           => 'required|string|min:15|max:80',
            ]);
        }elseif (membershipPackage::withTrashed()->find($request->package_id)->mobile_availability == 1) {
            $request->validate([
                'package_id'        => 'required|int',
                'name'             => 'required|string|min:5|max:40',
                'title'             => 'required|string|min:3|max:80',
                // 'service'           => 'required',
                // 'worker_service'    => ["required","array","min:1","max:2"],
                'location'          => 'required',

                'phone' => 'required|numeric',
            ]);
        }else {
            $request->validate([
                'package_id'        => 'required|int',
                'name'             => 'required|string|min:5|max:80',
                'title'             => 'required|string|min:3|max:300',
                // 'service'           => 'required',
                // 'worker_service'    => ["required","array","min:1","max:2"],
                'location'          => 'required',
            ]);
        }

        if (membershipPackage::withTrashed()->find($request->package_id)->description_availability == 1) {
            $description = $request->description;
            $address = $request->address;
        }else {
            $description = NULL;
            $address = NULL;
        }
        
        if (membershipPackage::withTrashed()->find($request->package_id)->mobile_availability == 1) {
            $phone = $request->phone;
        }else {
            $phone = NULL;
        }

        if ($request->service) {
            $service = $request->service;
        }else{
            $service = NULL;
        }

        $page = WorkerPage::findOrFail(Crypt::decryptString($request->page_id));

        $image_path = '';
        if($request->hasFile('image')){
            if (file_exists($page->image)){
                unlink($page->image);
            }
            $image             = $request->file('image');
            $folder_path       = 'uploads/images/worker/pages/';
            $image_new_name    = Str::random(8).'-worker-page--'.Carbon::now()->format('d-m-Y H-i-s') .'.'. $image->getClientOriginalExtension();
            //resize and save to server
            Image::make($image->getRealPath())->resize(500, 300, function($constraint){
                $constraint->aspectRatio();
            })->save($folder_path.$image_new_name);
            $image_path = $folder_path.$image_new_name;
        }



        WorkerPage::findOrFail(Crypt::decryptString($request->page_id))->update([
            'membership_id' => auth()->user()->membership->id,
            'name' => $request->name,
            'title' => $request->title,
            'description' => $description,
            'address' => $address,
            'services' => $request->service,
            'worker_services' => $request->worker_service,
            'phone' => $phone,
            'image' => ($image_path != '') ? $image_path : $page->image,
            'location' => $request->location,
            'status' => 'active',
            'updated_at' => Carbon::now()
        ]);
    }

    public function delete(Request $request){
        $request->validate([
           'page' => 'required|exists:worker_pages,id'
        ]);
        $page = WorkerPage::find($request->input('page'));
        if ($page->worker_id == Auth::user()->id){
            $page->delete();
            return response()->json([
                'type' => 'success',
                'message' => 'Successfully gig deleted',
            ]);
        }else{
            return response()->json([
                'type' => 'danger',
                'message' => 'Permission denied',
            ]);
        }

    }

    public function visibility(Request $request){
        $request->validate([
           'page' => 'required|exists:worker_pages,id'
        ]);
        $page = WorkerPage::find($request->input('page'));
        if ($page->worker_id == Auth::user()->id){
            if ($page->visibility == 'show') {
                WorkerPage::find($page->id)->update([
                    'visibility' => 'hide',
                    'updated_at' => Carbon::now()
                ]);
                return response()->json([
                    'type' => 'success',
                    'message' => 'Successfully Page Hidden',
                ]);
            }else {
                WorkerPage::find($page->id)->update([
                    'visibility' => 'show',
                    'updated_at' => Carbon::now()
                ]);
                return response()->json([
                    'type' => 'success',
                    'message' => 'Successfully Page Showed',
                ]);
            }
        }else{
            return response()->json([
                'type' => 'danger',
                'message' => 'Permission denied',
            ]);
        }

    }
}
