<?php

namespace App\Http\Controllers\MarketingPanel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\AffiliateUser;
use DB;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('marketing_panel.dashboard.index');
    }

    public function filter($district , $upazila, $month, $year){
        if ($district == 0 && $upazila == 0 && $month == 0 && $year == 0) {

            $total_marketer = User::where('role','marketer')->get()->count();
            $total_balance = AffiliateUser::sum('balance');
            $paid_amount = AffiliateUser::sum('paid_amount');
            $total_pending = $total_balance - $paid_amount;

        }else if ($district == 'All' && $upazila == 'All' && $month == 'All' && $year == 'All') {
            $total_marketer = User::where('role','marketer')->get()->count();
            $total_balance = AffiliateUser::sum('balance');
            $paid_amount = AffiliateUser::sum('paid_amount');
            $total_pending = $total_balance - $paid_amount;
        }elseif ($district >= 0 && $upazila == 0 && $month == 0 && $year == 0) {
            $total_marketer = User::where('role','marketer')->where('district_id', $district)->get()->count();
            $total_balance = DB::table('affiliate_users')
                            ->join('users','affiliate_users.user_id','users.id')
                            ->where('users.district_id',$district)
                            ->sum('balance');
            $paid_amount = DB::table('affiliate_users')
                            ->join('users','affiliate_users.user_id','users.id')
                            ->where('users.district_id',$district)
                            ->sum('paid_amount');
            $total_pending = $total_balance - $paid_amount;
        }elseif ($district == 0 && $upazila != 0 && $month == 0 && $year == 0) {
            $total_marketer = User::where('role','marketer')->where('upazila_id', $upazila)->get()->count();
            $total_balance = DB::table('affiliate_users')
                            ->join('users','affiliate_users.user_id','users.id')
                            ->where('users.upazila_id',$upazila)
                            ->sum('balance');
            $paid_amount = DB::table('affiliate_users')
                            ->join('users','affiliate_users.user_id','users.id')
                            ->where('users.upazila_id',$upazila)
                            ->sum('paid_amount');
            $total_pending = $total_balance - $paid_amount;
        }else if ($district == 0 && $upazila == 0 && $month != 0 && $year == 0) {
            $total_marketer = User::where('role','marketer')->whereMonth('created_at', '=', $month)->get()->count();
            $total_balance = AffiliateUser::whereMonth('created_at', '=', $month)->sum('balance');
            $paid_amount = AffiliateUser::whereMonth('created_at', '=', $month)->sum('paid_amount');
            $total_pending = $total_balance - $paid_amount;
        }else if ($district == 0 && $upazila == 0 && $month == 0 && $year != 0) {
            $total_marketer = User::where('role','marketer')->whereYear('created_at', '=', $year)->get()->count();
            $total_balance = AffiliateUser::whereYear('created_at', '=', $year)->sum('balance');
            $paid_amount = AffiliateUser::whereYear('created_at', '=', $year)->sum('paid_amount');
            $total_pending = $total_balance - $paid_amount;
        }

        echo '<div class="col-12 col-sm-6 col-lg-6 col-xl-3 col-md-3">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        <div class="media d-flex">
                            <div class="media-body text-left align-self-bottom">
                                <span class="d-block mb-1 font-medium-1">Total Marketer</span>
                                <h5 class="mb-0 font-weight-bolder">'.$total_marketer.'</h5>
                            </div>
                            <div class="align-self-top">
                                <i class="material-icons dark-blue font-large-3">people_outline</i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--Card 2-->
        <div class="col-12 col-sm-6 col-lg-6 col-xl-3 col-md-3">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        <div class="media d-flex">
                            <div class="media-body text-left align-self-bottom">
                                <span class="d-block mb-1 font-medium-1">Total Income Of Marketer</span>
                                <h5 class="mb-0 font-weight-bolder">BDT '.$total_balance.'</h5>
                            </div>
                            <div class="align-self-top">
                                <i class="material-icons dark-blue font-large-3">account_balance_wallet</i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--Card 3-->
        <div class="col-12 col-sm-6 col-lg-6 col-xl-3 col-md-3">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        <div class="media d-flex">
                            <div class="media-body text-left align-self-bottom">
                                <span class="d-block mb-1 font-medium-1">Total Paid</span>
                                <h5 class="mb-0 font-weight-bolder">BDT '.$paid_amount.'</h5>
                            </div>
                            <div class="align-self-top">
                                <i class="material-icons dark-blue font-large-3">chrome_reader_mode</i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--Card 4 -->
        <div class="col-12 col-sm-6 col-lg-6 col-xl-3 col-md-3">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        <div class="media d-flex">
                            <div class="media-body text-left align-self-bottom">
                                <span class="d-block mb-1 font-medium-1">Total Pending</span>
                                <h5 class="mb-0 font-weight-bolder">BDT '.$total_pending.'</h5>
                            </div>
                            <div class="align-self-top">
                                <i class="material-icons dark-blue font-large-3">account_balance_wallet</i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>';

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
}
