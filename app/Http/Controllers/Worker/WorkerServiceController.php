<?php

namespace App\Http\Controllers\Worker;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;

use App\PageService;
use App\ServiceBid;
use App\WorkerServiceCategory;
use App\ServiceComplain;
use App\UserAccountHistory;

use Carbon\Carbon;

use Intervention\Image\ImageManagerStatic as Image;

class WorkerServiceController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'title'             => 'required|string|min:3|max:100',
            'description'       => 'required|string|min:15|max:5000',
            // 'service'           => 'required|exists:worker_services,id',
            'day'               => 'required|numeric|min:1|max:30',
            'tags'              => 'nullable|string|min:3|max:200',
            'price'             => 'required|numeric|min:10',
            'thambline_photo'             => 'required|image',
        ]);

        $service = new PageService();

        $service->worker_id         =   auth()->user()->id;
        $service->title             =   $request->input('title');
        $service->description       =   $request->input('description');
        // $service->service_id        =   $request->input('service');
        $service->day               =   $request->input('day');
        $service->tags              =   $request->input('tags');
        $service->budget            =   $request->input('price');

        if($request->hasFile('thambline_photo')){
            $image             = $request->file('thambline_photo');
            $folder_path       = 'uploads/images/worker/service/';
            $image_new_name    = Str::random(8).'-worker-service--'.Carbon::now()->format('d-m-Y H-i-s') .'.'. $image->getClientOriginalExtension();
            //resize and save to server
            Image::make($image->getRealPath())->save($folder_path.$image_new_name);
            $service->cover_photo    = $folder_path.$image_new_name;
        }

        $service->save();
        session(['service_click' => 'Load_service']);
        return  $service;


    }

    public function show($id){

        $pageService = PageService::find(Crypt::decryptString($id));
        if ($pageService->worker_id == Auth::user()->id){
            return view('worker.service.show', compact('pageService'));
        }else{
            return redirect()->back();
        }
    }

    public function edit($id){

        $pageService = PageService::find(Crypt::decryptString($id));
        $categories = WorkerServiceCategory::all();
        if ($pageService->worker_id == Auth::user()->id){
            return view('worker.service.edit', compact('pageService','categories'));
        }else{
            return redirect()->back();
        }
    }

    public function update(Request $request)
    {
        $request->validate([
            'pageService'       => 'required|exists:page_services,id',
            'title'             => 'required|string|min:3|max:100',
            'description'       => 'required|string|min:15|max:5000',
            // 'service'           => 'required|exists:worker_services,id',
            'day'               => 'required|numeric|min:1|max:30',
            'tags'              => 'nullable|string|min:3|max:200',
            'price'             => 'required|numeric|min:10',
        ]);

        $service = PageService::find($request->input('pageService'));
        if ($service->worker_id == Auth::user()->id){
            $service->title             =   $request->input('title');
            $service->description       =   $request->input('description');
            // $service->service_id        =   $request->input('service');
            $service->day               =   $request->input('day');
            $service->tags              =   $request->input('tags');
            $service->budget            =   $request->input('price');
            $service->status            =   0;

            if($request->hasFile('thambline_photo')){
                $image             = $request->file('thambline_photo');
                $folder_path       = 'uploads/images/worker/service/';
                $image_new_name    = Str::random(8).'-worker-service--'.Carbon::now()->format('d-m-Y H-i-s') .'.'. $image->getClientOriginalExtension();
                //resize and save to server
                Image::make($image->getRealPath())->save($folder_path.$image_new_name);
                $service->cover_photo    = $folder_path.$image_new_name;
            }
            
            $service->save();
            return response()->json([
                'type' => 'success',
                'message' => 'Successfully service updated',
            ]);
        }else{
            return response()->json([
                'type' => 'danger',
                'message' => 'Permission denied',
            ]);
        }
    }

    public function delete(Request $request){
        $request->validate([
           'pageService'       => 'required|exists:page_services,id',
        ]);
        $service = PageService::find($request->input('pageService'));
        if ($service->worker_id == Auth::user()->id){
            if (!ServiceBid::where('worker_service_id', $service->id)->exists()) {
                $service->forceDelete();
            } else {
                $service->delete();
            }
            return response()->json([
                'type' => 'success',
                'message' => 'Successfully service deleted',
            ]);
        }else{
            return response()->json([
                'type' => 'danger',
                'message' => 'Permission denied',
            ]);
        }

    }

    public function showservice($id){
        $serviceBid = ServiceBid::find(Crypt::decryptString($id));
        if ($serviceBid->worker_id == Auth::user()->id){
            return view('worker.service.order', compact('serviceBid'));
        }else{
            return redirect()->back();
        }
    }

    public function cancelserviceBid(Request $request){
        $request->validate([
            'service'    => 'required|exists:service_bids,id',
        ]);
        $serviceBid = ServiceBid::find($request->input('service'));
        if ($serviceBid->worker_id == Auth::user()->id){
            $serviceBid->status = 'cancelled';
            $serviceBid->save();

            // $pageBid->workerGig->worker->notify(new CustomerBidNotification($customerBid)); //Notification send to worker
            //Add in canceller list
            $cancelservice = new \App\CancelService();
            $cancelservice->type = 'service-bid';
            $cancelservice->canceller_id = Auth::user()->id;
            $cancelservice->service_id = $serviceBid->id;
            $cancelservice->save();
            
            UserAccountHistory::updateStatus($serviceBid->id, 'cancelled');

            return response()->json([
                'type' => 'success',
                'message' => 'Successfully service cancelled',
            ]);
        }else{
            return response()->json([
                'type' => 'danger',
                'message' => 'operation denied',
            ]);
        }
    }
    public function acceptserviceBid(Request $request){
        $request->validate([
            'service'    => 'required|exists:service_bids,id',
        ]);
        $serviceBid = ServiceBid::find($request->input('service'));
        if ($serviceBid->worker_id == Auth::user()->id){
            $deadline = PageService::find($serviceBid->worker_service_id)->day;
            // $deadline = 10;
            $date = Carbon::now();
            $completed_at = Carbon::parse($date);
            $completed_at->addHours($deadline);

            // Carbon::now()

            $serviceBid->completed_at = $completed_at;
            $serviceBid->status = 'running';
            $serviceBid->save();

            // $pageBid->workerGig->worker->notify(new CustomerBidNotification($customerBid)); //Notification send to worker
            //Add in canceller list
            // $cancelservice = new \App\CancelService();
            // $cancelservice->type = 'service-bid';
            // $cancelservice->canceller_id = Auth::user()->id;
            // $cancelservice->service_id = $serviceBid->id;
            // $cancelservice->save();
            UserAccountHistory::updateStatus($serviceBid->id, 'running');

            return response()->json([
                'type' => 'success',
                'message' => 'Successfully Service Accepted',
            ]);
        }else{
            return response()->json([
                'type' => 'danger',
                'message' => 'operation denied',
            ]);
        }
    }

    public function completedServiceBid(Request $request){


       
        $request->validate([
            'service' => 'required|exists:service_bids,id',
        ]);
        // id, service_bid_id, worker_service_id, worker_d, customet_id, rating, review
        
        $bid = ServiceBid::find($request->input('service'));
        // dd($bid->workerGig->worker->referred_by);
        if ($bid->worker_id == Auth::user()->id){
            $bid->status = 'completed';
            $bid->save(); //Job status updated

            // $bid->workerGig->worker->notify(new CustomerWorkComplete($bid)); //Notification send to worker

            // // get categorywise comission 
            // $pages = WorkerPage::where('worker_id', $bid->worker_id)->where('status', 1)->get();

            // foreach ($pages as $page) {
            //     if (in_array($bid->worker_service_id, explode(',', $page->worker_services))) {
            //         $page_category = explode(',', $page->services);
            //     }
            // }
            
            // $worker_service = WorkerService::find($page_category[0]);
            // $commission = $worker_service->comission_rate;
            
            // //Worker balance update
            // $worker = User::find($bid->worker_id);
            // $worker->balance->job_income += $bid->budget - ($bid->budget * $commission) /100  ;
            
            // $after_comision = $bid->budget - ($bid->budget * $commission) /100;
            // $worker->balance->due +=  $after_comision;

            // $service_change = $bid->budget - $after_comision;
            // $worker->balance->service_change += $service_change;

            // var_dump($bid->workerGig->worker->balance->service_change);
            // exit();

            // $worker->balance->save();


            // $user = User::find($bid->workerGig->worker->id);
            // $worker->recharge_amount -= $service_change;
            // $worker->save();

            $earning = $bid->budget;
            
            UserAccountHistory::updateEarnings($bid->id, 0, 0, $earning);
            UserAccountHistory::updateStatus($bid->id, 'completed');

            return response()->json([
                'type' => 'success',
                'message' => 'Successfully job completed',
            ]);

        }else{
            return redirect()->back();
        }
    }

    public function updateServiceBidBudget(Request $request){
        $request->validate([
            'service' => 'required|exists:service_bids,id',
            'budget' => 'required|numeric'
        ]);

        $service = ServiceBid::find($request->input('service'));
        if ($service->worker_id == Auth::user()->id){
            if ($service->budget > $request->input('budget')){
                return response()->json([
                    'type' => 'warning',
                    'message' => 'This price is not acceptable',
                ]);
            }else{
                $service->proposed_budget = $request->input('budget');
                $service->save();
                return response()->json([
                    'type' => 'success',
                    'message' => 'Successfully New Price Proposed',
                ]);
            }
        }else{
            return response()->json([
                'type' => 'danger',
                'message' => 'Not permitted',
            ]);
        }
    }

    public function completedserviceBidComplain(Request $request){
        // die();
        $request->validate([
            'serviceBid' => 'required|exists:service_bids,id',
            'complain' => 'required|string',
        ]);
        // id, service_bid_id, worker_service_id, worker_d, customet_id, rating, review
        
        $bid = ServiceBid::find($request->input('serviceBid'));
        // dd($bid->workerGig->worker->referred_by);
        if ($bid->worker_id == Auth::user()->id){
            $bid->status = 'completed';
            $bid->proposed_budget = NULL;
            $bid->save(); //Job status updated

            // $bid->workerGig->worker->notify(new CustomerWorkComplete($bid)); //Notification send to worker

            //Complain
            $complain = new ServiceComplain();
            $complain->complainer_id = Auth::user()->id;
            $complain->service_bid_id = $request->input('serviceBid');
            $complain->complain = $request->input('complain');
            $complain->is_completed = 1;
            $complain->completed_by_id = Auth::user()->id;
            $complain->save();

            return response()->json([
                'type' => 'success',
                'message' => 'Successfully job completed with complain',
            ]);

        }else{
            return redirect()->back();
        }
    }

}
