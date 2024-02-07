<?php

namespace App\Http\Controllers\Controller;

use App\CustomerBid;
use App\CustomerGig;
use App\Http\Controllers\Controller;
use App\ServiceBid;
use App\Worker;
use App\WorkerBid;
use Illuminate\Http\Request;

class OrderManagementController extends Controller
{
    public function bidOrder($status = "pending")
    {
        if($status == "pending"){
            $bidOrder = CustomerBid::where('status', 'active')->orderBy('id', 'desc')->get();
        }else if($status == "running"){
            $bidOrder = CustomerBid::where('status', 'running')->orderBy('id', 'desc')->get();
        }else if($status == "complete"){
            $bidOrder = CustomerBid::where('status', 'completed')->orderBy('id', 'desc')->get();
        }else if($status == "canceled"){
            $bidOrder = CustomerBid::where('status', 'cancelled')->orderBy('id', 'desc')->get();
        }

        return view('controller.order-management.bid.index', compact('bidOrder', 'status'));
    }

    public function bidOrderById($id)
    {
        $bidOrder = CustomerBid::with(['customer','worker','workerGig','cancelInfo'])->find($id);
        return response()->json($bidOrder);
    }

    public function bidCancel($id)
    {
        $bidOrder = CustomerBid::find($id);
        $bidOrder->status = 'cancelled';
        $bidOrder->save();

        return response()->json($bidOrder);
    }

    public function bidComplete($id)
    {
        $bidOrder = CustomerBid::find($id);
        $bidOrder->status = 'complete';
        $bidOrder->save();

        return back()->with('success','Bid Completed Successfully');
    }
    public function gigOrder($status = "pending")
    {
        if($status == "pending"){
            $gigOrder = WorkerBid::where('status', 'active')->orderBy('id', 'desc')->get();
        }else if($status == "running"){
            $gigOrder = WorkerBid::where('status', 'running')->orderBy('id', 'desc')->get();
        }else if($status == "complete"){
            $gigOrder = WorkerBid::where('status', 'completed')->orderBy('id', 'desc')->get();
        }else if($status == "canceled"){
            $gigOrder = WorkerBid::where('status', 'cancelled')->orderBy('id', 'desc')->get();
        }
        return view('controller.order-management.gig.index', compact('gigOrder','status'));
    }

    public function gigOrderById($id)
    {
        $gigOrder = WorkerBid::with(['customerGig','worker','customer'])->find($id);
        return response()->json($gigOrder);
    }

    public function gigCancel($id)
    {
        $gigOrder = WorkerBid::find($id);
        $gigOrder->status = 'cancelled';
        $gigOrder->save();
        return response()->json($gigOrder);
    }
    public function gigComplete($id)
    {
        $gigOrder = WorkerBid::find($id);
        $gigOrder->status = 'complete';
        $gigOrder->save();
        return response()->json($gigOrder);
    }


    public function serviceOrder($status = "pending")
    {
        if($status == "pending"){
            $serviceOrder = ServiceBid::where('status', 'active')->orderBy('id', 'desc')->get();
        }else if($status == "running"){
            $serviceOrder = ServiceBid::where('status', 'running')->orderBy('id', 'desc')->get();
        }else if($status == "complete"){
            $serviceOrder = ServiceBid::where('status', 'completed')->orderBy('id', 'desc')->get();
        }else if($status == "canceled"){
            $serviceOrder = ServiceBid::where('status', 'cancelled')->orderBy('id', 'desc')->get();
        }
        return view('controller.order-management.service.index', compact('serviceOrder', 'status'));
    }

    public function serviceOrderById($id)
    {
        $serviceOrder = ServiceBid::with(['service','customer'])->find($id);
        return response()->json($serviceOrder);
    }

    public function serviceCancel($id)
    {
        $serviceOrder = ServiceBid::find($id);
        $serviceOrder->status = 'cancelled';
        $serviceOrder->save();
        return response()->json($serviceOrder);
    }
    public function serviceComplete($id)
    {
        $serviceOrder = ServiceBid::find($id);
        $serviceOrder->status = 'completed';
        $serviceOrder->save();
        return response()->json($serviceOrder);
    }
}
