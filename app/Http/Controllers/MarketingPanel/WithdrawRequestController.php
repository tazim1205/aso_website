<?php

namespace App\Http\Controllers\MarketingPanel;

use App\Http\Controllers\Controller;
use App\User;
use App\WithdrawRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use DB;

class WithdrawRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $withdraw_requests = WithdrawRequest::all();
        return view('marketing_panel.withdraw.index',compact('withdraw_requests'));
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
    public function update(Request $request, $id)
    {
        //
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

    /*
    *-----------Complete Report
    */
    public function complete_report(){

        $completes = WithdrawRequest::where('status','complete')->get();
        return view('marketing_panel.withdraw_report.complete',compact('completes'));
    }

    /*
    *-----------Complete Report
    */
    public function cancel_report(){

        $canceles = WithdrawRequest::where('status','cancel')->get();
        return view('marketing_panel.withdraw_report.cancel',compact('canceles'));
    }

    /*
    *-----------Complete Withdraw Request
    */
    public function complete($id){
        $witdraw_request = WithdrawRequest::findOrFail($id);
        return view('marketing_panel.withdraw.complete',compact('witdraw_request'));
    }

    public function filterComplete($district , $upazila, $month, $year){
        if ($district == 0 && $upazila == 0 && $month == 0 && $year == 0) {
            $data = WithdrawRequest::where('status', 'complete')->get();
        }else if ($district == 'All' && $upazila == 'All' && $month == 'All' && $year == 'All') {
            $data = WithdrawRequest::where('status', 'complete')->get();
        }else if ($district > 0 && $upazila == 0 && $month == 0 && $year == 0) {
            $data=DB::table('withdraw_requests')
            ->join('users','withdraw_requests.user_id','users.id')
            ->where('withdraw_requests.status', 'complete')
            ->where('users.district_id', $district)
            ->get();
        }else if ($district == 0 && $upazila > 0 && $month == 0 && $year == 0) {
            $data=DB::table('withdraw_requests')
            ->join('users','withdraw_requests.user_id','users.id')
            ->where('withdraw_requests.status', 'complete')
            ->where('users.upazila_id', $upazila)
            ->get();
        }else if ($district == 0 && $upazila == 0 && $month != 0 && $year == 0) {
            $data=DB::table('withdraw_requests')
            ->join('users','withdraw_requests.user_id','users.id')
            ->where('withdraw_requests.status', 'complete')
            ->whereMonth('withdraw_requests.created_at', $month)
            ->get();
        }else if ($district == 0 && $upazila == 0 && $month == 0 && $year != 0) {
            $data=DB::table('withdraw_requests')
            ->join('users','withdraw_requests.user_id','users.id')
            ->where('withdraw_requests.status', 'complete')
            ->whereYear('withdraw_requests.paid_date', $year)
            ->get();
        }
        return DataTables::of($data)
        ->addColumn('date', function($data) {
            $mydate = strtotime($data->paid_date);
            $newformat = date('d-m-Y',$mydate);
            return $newformat;
        })
        ->addColumn('name', function($data) {
            if (isset($data->user->user_name)) {
                return $data->user->user_name;
            }else{
                return $data->user_name;
            }

        })
        ->rawColumns(['date','name'])
        ->make(true);
    }

    /*
    *-----------Complete Save
    */
    public function completeSave(Request $request){

        $withdraw_request = WithdrawRequest::findOrFail($request->id);
        $withdraw_request->paid_amount = $withdraw_request->amount;
        $withdraw_request->paid_via = $request->paid_via;
        $withdraw_request->transaction_id = $request->transaction_id;
        $withdraw_request->cac_details = $request->c_ac_details;
        $withdraw_request->paid_date =  Carbon::parse($request->paid_date);
        $withdraw_request->cac_number = $request->c_ac;
        $withdraw_request->status = "complete";

        //Save affiliate user paid amount
        $user = User::find($withdraw_request->user_id);
        $user->affiliate_user->paid_amount += $withdraw_request->paid_amount;
        $user->affiliate_user->balance -= $withdraw_request->paid_amount;
        try {
            $withdraw_request->save();
            $user->affiliate_user->save();
            return response()->json([
                'type' => 'success',
                'message' => 'Successfully updated',
            ]);

        } catch (\Exception $exception) {
            return response()->json([
                'type' => 'error',
                'message' => 'Something going wrong' . $exception,
            ]);
        }
    }



    /*
    *-----------Cancel Withdraw Request
    */
    public function cancel($id){
        $witdraw_request = WithdrawRequest::findOrFail($id); ;
        return view('marketing_panel.withdraw.cancel',compact('witdraw_request'));
    }

    public function filterCancel($district , $upazila, $month, $year){
        if ($district == 0 && $upazila == 0 && $month == 0 && $year == 0) {
            $data = WithdrawRequest::where('status', 'cancel')->get();
        }else if ($district == 'All' && $upazila == 'All' && $month == 'All' && $year == 'All') {
            $data = WithdrawRequest::where('status', 'cancel')->get();
        }else if ($district > 0 && $upazila == 0 && $month == 0 && $year == 0) {
            $data=DB::table('withdraw_requests')
            ->join('users','withdraw_requests.user_id','users.id')
            ->where('withdraw_requests.status', 'cancel')
            ->where('users.district_id', $district)
            ->get();
        }else if ($district == 0 && $upazila > 0 && $month == 0 && $year == 0) {
            $data=DB::table('withdraw_requests')
            ->join('users','withdraw_requests.user_id','users.id')
            ->where('withdraw_requests.status', 'cancel')
            ->where('users.upazila_id', $upazila)
            ->get();
        }else if ($district == 0 && $upazila == 0 && $month != 0 && $year == 0) {
            $data=DB::table('withdraw_requests')
            ->join('users','withdraw_requests.user_id','users.id')
            ->where('withdraw_requests.status', 'cancel')
            ->whereMonth('withdraw_requests.created_at', $month)
            ->get();
        }else if ($district == 0 && $upazila == 0 && $month == 0 && $year != 0) {
            $data=DB::table('withdraw_requests')
            ->join('users','withdraw_requests.user_id','users.id')
            ->where('withdraw_requests.status', 'cancel')
            ->whereYear('withdraw_requests.cancel_date', $year)
            ->get();
        }
        return DataTables::of($data)
        ->addColumn('date', function($data) {
            $mydate = strtotime($data->cancel_date);
            $newformat = date('d-m-Y',$mydate);
            return $newformat;
        })
        ->addColumn('name', function($data) {
            if (isset($data->user->user_name)) {
                return $data->user->user_name;
            }else{
                return $data->user_name;
            }

        })
        ->rawColumns(['date','name'])
        ->make(true);
    }
    /*
    *-----------Cancel Save
    */
    public function cancelSave(Request $request){

        $withdraw_request = WithdrawRequest::findOrFail($request->id);
        $withdraw_request->cancel_date =  Carbon::parse($request->cancel_date);
        $withdraw_request->cancel_reason = $request->cancel_reason;
        $withdraw_request->status = "cancel";
        $user = User::find($withdraw_request->user_id);
        $user->affiliate_user->balance += $withdraw_request->paid_amount;

        try {
            $withdraw_request->save();
            $user->affiliate_user->save();
            return response()->json([
                'type' => 'success',
                'message' => 'Successfully updated',
            ]);

        } catch (\Exception $exception) {
            return response()->json([
                'type' => 'error',
                'message' => 'Something going wrong' . $exception,
            ]);
        }
    }

    public function filter($district , $upazila, $month, $year){
        if ($district == 0 && $upazila == 0 && $month == 0 && $year == 0) {
            $data = WithdrawRequest::where('status', 'pending')->get();
        }else if ($district == 'All' && $upazila == 'All' && $month == 'All' && $year == 'All') {
            $data = WithdrawRequest::where('status', 'pending')->get();
        }else if ($district > 0 && $upazila == 0 && $month == 0 && $year == 0) {
            $data=DB::table('withdraw_requests')
            ->join('users','withdraw_requests.user_id','users.id')
            ->where('withdraw_requests.status', 'pending')
            ->where('users.district_id', $district)
            ->get();
        }else if ($district == 0 && $upazila > 0 && $month == 0 && $year == 0) {
            $data=DB::table('withdraw_requests')
            ->join('users','withdraw_requests.user_id','users.id')
            ->where('withdraw_requests.status', 'pending')
            ->where('users.upazila_id', $upazila)
            ->get();
        }else if ($district == 0 && $upazila == 0 && $month != 0 && $year == 0) {
            $data=DB::table('withdraw_requests')
            ->join('users','withdraw_requests.user_id','users.id')
            ->where('withdraw_requests.status', 'pending')
            ->whereMonth('withdraw_requests.created_at', $month)
            ->get();
        }else if ($district == 0 && $upazila == 0 && $month == 0 && $year != 0) {
            $data=DB::table('withdraw_requests')
            ->join('users','withdraw_requests.user_id','users.id')
            ->where('withdraw_requests.status', 'pending')
            ->whereYear('withdraw_requests.created_at', $year)
            ->get();
        }
        return DataTables::of($data)
            ->addColumn('date', function($data) {
                $mydate = strtotime($data->created_at);
                $newformat = date('d-m-Y',$mydate);
                return $newformat;
            })
            ->addColumn('name', function($data) {
                if (isset($data->user->user_name)) {
                    return $data->user->user_name;
                }else{
                    return $data->user_name;
                }

            })
            ->addColumn('link', function($data) {

                    return '
                        <a href="'.route('marketing_panel.witdraw.complete',$data->id).'" class="btn btn-primary">Complete</a>
                        <a href="'.route('marketing_panel.cancel.req',$data->id).'" class="btn btn-danger">Cancel</a>
                    ';


            })
            ->rawColumns(['date','name','link'])
            ->make(true);
    }





}
