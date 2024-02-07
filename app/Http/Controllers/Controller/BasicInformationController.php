<?php

namespace App\Http\Controllers\Controller;

use App\User;
use App\CustomerWorkerHelplines;
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    // helpline

    public function helpline($status = "customer")
    {
        $user_id = Auth::user()->id;
        if($status == "customer"){
            $notices = CustomerWorkerHelplines::where('controller_id', $user_id)->where('worker_or_customer', 'Customer')->orderBy('id', 'desc')->get();
            return view('controller.basic_option.helpline', compact('notices', 'status'));
        }else if($status == "worker"){
            $notices = CustomerWorkerHelplines::where('controller_id', $user_id)->where('worker_or_customer', 'Worker')->orderBy('id', 'desc')->get();
            return view('controller.basic_option.sp-helpline', compact('notices', 'status'));
        }

    }

    public function helplinestore(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'phone' => 'required',
        ]);

        $notice = new CustomerWorkerHelplines();
        $notice->controller_id = Auth::user()->id;
        $notice->district_id = Auth::user()->district_id;
        $notice->upazila_id = Auth::user()->upazila_id;
        $notice->email = $request->input('email');
        $notice->phone = $request->input('phone');
        $notice->worker_or_customer = $request->worker_or_customer;
        $notice->save();
        return response()->json($notice, 200);
    }

    public function helplineupdate(Request $request)
    {
        $id = $request->input('id');
        $request->validate([
            'email' => 'required',
            'phone' => 'required',
        ]);

        $notice = CustomerWorkerHelplines::find($id);
        $notice->email = $request->input('email');
        $notice->phone = $request->input('phone');
        $notice->worker_or_customer = $request->worker_or_customer;
        $notice->save();
        return response()->json($notice, 200);
    }

    public function helplinedelete(Request $request)
    {
        $id = $request->input('id');
        $notice = CustomerWorkerHelplines::find($id);

        $notice->delete();
        return response()->json($notice, 200);
    }
}
