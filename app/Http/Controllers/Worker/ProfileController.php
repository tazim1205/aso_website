<?php

namespace App\Http\Controllers\Worker;

use App\Http\Controllers\Controller;
use DB;
use App\User;
use App\UserUsefulFile;
use App\ServiceProviderStorie;
use App\WorkerServiceCategory;
use App\WorkerService;
use Illuminate\Support\Facades\Auth;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Intervention\Image\ImageManagerStatic as Image;

class ProfileController extends Controller
{
    public function index(){
        
    	$bids = DB::table('customer_bids')
                ->join('worker_gigs','worker_gigs.id','customer_bids.worker_gig_id')
                ->join('users','worker_gigs.worker_id','users.id')
                ->select('customer_bids.*', 'worker_gigs.service_id')
                ->where('worker_gigs.worker_id',auth()->user()->id)
                ->where('customer_bids.status','completed')
                ->get();

        $currentMonth = date('F');

        $thismonthIncome = 0;
        $total_complete = 0;

        foreach ($bids as $row) {
            $total_complete++;
        	$month = Carbon::parse($row->created_at)->format('F');
        	if ($currentMonth == $month) {
                $after_comision = ($row->budget * WorkerService::find($row->service_id)->comission_rate) / 100;
        		$thismonthIncome = $thismonthIncome +  $row->budget - $after_comision;
        	}
        }

        $totalPageErnings = 0;
        $thisMonthTotalPageErnings = 0;

        foreach (DB::TABLE('service_bids')->WHERE('worker_id',auth()->user()->id)->where('status','completed')->get() as $row) {
            $totalPageErnings += $row->budget;
            
            $month = Carbon::parse($row->created_at)->format('F');
            if ($currentMonth == $month) {
                $thisMonthTotalPageErnings = $thisMonthTotalPageErnings + $row->budget;
            }
        }
        
        $parentsUsers = User::where('parent_worker_id', Auth::user()->id)->latest()->get();

        return view('worker.profile.index',compact('thismonthIncome','totalPageErnings','thisMonthTotalPageErnings','total_complete', 'parentsUsers'));
    }
    
    public function service_view(){

        return view('worker.profile.service_view');
    }
    
    public function upload_document(){

        return view('worker.profile.upload_document');
    }

    public function uploadFile(Request $request){
    	$request->validate([
            'file'         => 'required|max:30000',
        ]);
        $ext = $request->file->extension();
    	if ($ext == 'jpg' || $ext == 'png' || $ext == 'jpeg' || $ext == 'doc' || $ext == 'docx' || $ext == 'pdf') {
    		$file = new UserUsefulFile();

    		$list = UserUsefulFile::where('user_id', Auth::user()->id)->get();

    		if ($list->count() < 11) {
    			$file->user_id = Auth::user()->id;
		        $file->title = $request->title;

		        if($request->hasFile('file')){
		            $image             = $request->file('file');
		            $folder_path       = 'uploads/images/usefullfile/';
		            $image_new_name    = Str::random(8).'-usefull-file--'.Carbon::now()->format('d-m-Y H-i-s') .'.'. $image->getClientOriginalExtension();
		            //resize and save to server
		            // Image::make($image->getRealPath())->resize(500, 300, function($constraint){
		            //     $constraint->aspectRatio();
		            // })->save($folder_path.$image_new_name);
		            $file->file    = $folder_path.$image_new_name;
		            $image->move(public_path($folder_path), $image_new_name);
		        }

		        $file->save();
		        return back()->with('success','File has been uploaded.');
    		}else{
    			return back()->with('errors','You can upload only 10 files.');
    		}
	        
    	}else{
    		return back()->with('errors','File must be jpg,jpeg,png,doc,docx,pdf formate.');
    	}
    }

    public function addStories(Request $request){
        $request->validate([
            'file'         => 'required|max:30000',
        ]);
        $ext = $request->file->extension();
        if ($ext == 'jpg' || $ext == 'png' || $ext == 'jpeg') {
            $story = new ServiceProviderStorie();

            $story->user_id = Auth::user()->id;
            $story->gig_id = $request->gig_id;
            $story->page_id = $request->page_id;

            if($request->hasFile('file')){
                $image             = $request->file('file');
                $folder_path       = 'uploads/images/worker/';
                $image_new_name    = Str::random(8).'-story-file--'.Carbon::now()->format('d-m-Y H-i-s') .'.'. $image->getClientOriginalExtension();
                //resize and save to server
                // Image::make($image->getRealPath())->resize(500, 300, function($constraint){
                //     $constraint->aspectRatio();
                // })->save($folder_path.$image_new_name);
                $story->image    = $folder_path.$image_new_name;
                $image->move(public_path($folder_path), $image_new_name);
            }
            $story->text = $request->text;
            $story->save();
            return back()->with('success','New Stories Added.');
            
        }else{
            return back()->with('errors','File must be jpg,jpeg,png formate.');
        }
    }

    public function outOfWork(){
        $user = User::find(Auth::user()->id);
        $user->out_of_work = 1;
        $user->save();

        return back()->with('success','You are out of work');
    }

    public function inWork(){
        $user = User::find(Auth::user()->id);
        $user->out_of_work = 0;
        $user->save();

        return back()->with('success','You are in work');
    }

    public function edit()
    {
        $categories= WorkerServiceCategory::all();
        return view('worker.profile.edit-profile', compact('categories'));
    }
}
