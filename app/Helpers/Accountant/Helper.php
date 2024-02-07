<?php

namespace App\Helpers\Accountant;

use App\AdExpense;
use App\AffiliateUser;
use App\AreaAdExpense;
use App\Balance;
use App\Membership;
use App\OtherExpense;
use App\OthersIncome;
use App\Payment;
use App\Salary;
use App\SpecialServiceOrder;
use Illuminate\Support\Facades\DB;

class Helper
{

    /**Total Aff Marketer */
    public static function totalAffmarketer($request)
    {
        $district = $request->district ?? 'All';
        $upazila = $request->upazila ?? 'All';
        $month = $request->month ?? 'All';
        $year = $request->year ?? 'All';
        $total = AffiliateUser::district($district)
            ->upazila($upazila)
            ->month($month)
            ->year($year)
            ->total();
        return $total;
    }

    /**Totla Income With Upazila */
    public static function totalIncome($request){
        $month = $request->month ?? 'All';
        $year = $request->year ?? 'All';
        $workerBids = DB::table('worker_bids')
            ->select('upazilas.name', DB::raw('SUM(worker_bids.service_charge) as total_service_charge'))
            ->join('users', 'worker_bids.worker_id', '=', 'users.id')
            ->join('upazilas', 'users.upazila_id', '=', 'upazilas.id')
            ->where('users.upazila_id', auth()->user()->upazila_id)
            ->groupBy('users.upazila_id')
            ->get();
        $workerGigs = DB::table('worker_gigs')
            ->select('upazilas.name', DB::raw('SUM(worker_gigs.service_charge) as total_service_charge'))
            ->join('users', 'worker_gigs.worker_id', '=', 'users.id')
            ->join('upazilas', 'users.upazila_id', '=', 'upazilas.id')
            ->where('users.upazila_id', auth()->user()->upazila_id)
            ->groupBy('users.upazila_id')
            ->get();

        $memberShips = DB::table('memberships')
            ->select('upazilas.name', DB::raw('SUM(memberships.amount) as total_income'))
            ->join('users', 'memberships.user_id', '=', 'users.id')
            ->join('upazilas', 'users.upazila_id', '=', 'upazilas.id')
            ->where('users.upazila_id', auth()->user()->upazila_id)
            ->groupBy('users.upazila_id')
            ->get();

        $specialServices = DB::table('special_service_orders')
            ->select('upazilas.name', DB::raw('SUM(special_service_orders.fee) as order_fee'))
            ->join('users', 'special_service_orders.customer_id', '=', 'users.id')
            ->join('upazilas', 'users.upazila_id', '=', 'upazilas.id')
            ->where('users.upazila_id', auth()->user()->upazila_id)
            ->groupBy('users.upazila_id')
            ->get();

        $localAds = AreaAdExpense::sameAreaUser()
            ->month($month)
            ->year($year)
            ->get();

        $data = [];
        foreach($workerBids as $key => $workerBid){
            $data[$key]['upazila_name'] = $workerBid->name;
            $data[$key]['bid_income'] = $workerBid->total_service_charge;
        }

        foreach($workerGigs as $key => $workerGig){
            if($data[$key]['upazila_name'] == $workerGig->name){
                $data[$key]['gig_income'] = $workerGig->total_service_charge;
            }else{
                $data[$key]['upazila_name'] = $workerGig->name;
                $data[$key]['gig_income'] = $workerGig->total_service_charge;
            }
        }
        foreach($memberShips as $key => $memberShip){
            if($data[$key]['upazila_name'] == $memberShip->name){
                $data[$key]['membership_income'] = $memberShip->total_income;
            }else{
                $data[$key]['upazila_name'] = $memberShip->name;
                $data[$key]['membership_income'] = $memberShip->total_income;
            }
        }
        foreach($specialServices as $key => $specialService){
            if($data[$key]['upazila_name'] == $specialService->name){
                $data[$key]['order_income'] = $specialService->order_fee;
            }else{
                $data[$key]['upazila_name'] = $specialService->name;
                $data[$key]['order_income'] = $specialService->order_fee;
            }
        }
        foreach($localAds as $key => $localAd){
            if($data[$key]['upazila_name'] == $localAd->upazila->name){
                $data[$key]['local_ad_income'] = $localAd->amount;
            }else{
                $data[$key]['upazila_name'] = $localAd->upazila->name;
                $data[$key]['local_ad_income'] = $localAd->amount;
            }
        }

        return $data;
    }

    /**Total Income With Month */
    public static function totalIncomeWithMonth($request){
        $month = $request->month ?? 'All';
        $year = $request->year ?? 'All';
        $workerBids = DB::table('worker_bids')
            ->select(
                'upazilas.name',
                DB::raw('SUM(worker_bids.service_charge) as total_service_charge'),
                DB::raw('MONTHNAME(worker_bids.created_at) as month_name')
            )
            ->join('users', 'worker_bids.worker_id', '=', 'users.id')
            ->join('upazilas', 'users.upazila_id', '=', 'upazilas.id')
            ->where('users.upazila_id', auth()->user()->upazila_id)
            ->groupBy('upazilas.name', 'month_name')
            ->get();

        $workerGigs = DB::table('worker_gigs')
            ->select(
                'upazilas.name', 
                DB::raw('SUM(worker_gigs.service_charge) as total_service_charge'),
                DB::raw('MONTHNAME(worker_gigs.created_at) as month_name')
            )
            ->join('users', 'worker_gigs.worker_id', '=', 'users.id')
            ->join('upazilas', 'users.upazila_id', '=', 'upazilas.id')
            ->where('users.upazila_id', auth()->user()->upazila_id)
            ->groupBy('upazilas.name', 'month_name')
            ->get();

        $memberShips = DB::table('memberships')
            ->select(
                'upazilas.name', 
                DB::raw('SUM(memberships.amount) as total_income'),
                DB::raw('MONTHNAME(memberships.created_at) as month_name')
            )
            ->join('users', 'memberships.user_id', '=', 'users.id')
            ->join('upazilas', 'users.upazila_id', '=', 'upazilas.id')
            ->where('users.upazila_id', auth()->user()->upazila_id)
            ->groupBy('upazilas.name', 'month_name')
            ->get();

        $specialServices = DB::table('special_service_orders')
            ->select(
                'upazilas.name', 
                DB::raw('SUM(special_service_orders.fee) as order_fee'),
                DB::raw('MONTHNAME(special_service_orders.created_at) as month_name')
            )
            ->join('users', 'special_service_orders.customer_id', '=', 'users.id')
            ->join('upazilas', 'users.upazila_id', '=', 'upazilas.id')
            ->where('users.upazila_id', auth()->user()->upazila_id)
            ->groupBy('upazilas.name', 'month_name')
            ->get();

        $localAds =DB::table('area_ad_expenses')
            ->select(
                'upazilas.name', 
                DB::raw('SUM(area_ad_expenses.amount) as local_ad_income'),
                DB::raw('MONTHNAME(area_ad_expenses.created_at) as month_name')
            )
            ->join('upazilas', 'area_ad_expenses.upazila_id', '=', 'upazilas.id')
            ->where('area_ad_expenses.upazila_id', auth()->user()->upazila_id)
            ->groupBy('upazilas.name', 'month_name')
            ->get();

        $totalExpenses = DB::table('affiliate_bonuses')
            ->select(
                'upazilas.name', 
                DB::raw('SUM(affiliate_bonuses.amount) as income'),
                DB::raw('MONTHNAME(affiliate_bonuses.created_at) as month_name')
            )
            ->join('users', 'affiliate_bonuses.user_id', '=', 'users.id')
            ->join('upazilas', 'users.upazila_id', '=', 'upazilas.id')
            ->where('users.upazila_id', auth()->user()->upazila_id)
            ->groupBy('upazilas.name', 'month_name')
            ->get();

        // dd($totalExpenses);
        $data = [];
        foreach($workerBids as $key => $workerBid){
            $data[$key]['month_name'] = $workerBid->month_name;
            $data[$key]['upazila_name'] = $workerBid->name;
            $data[$key]['bid_income'] = $workerBid->total_service_charge;
        }
        foreach($workerGigs as $key => $workerGig){
            if($data[$key]['month_name'] == $workerGig->month_name ){
                $data[$key]['gig_income'] = $workerGig->total_service_charge;
                $data[$key]['upazila_name'] = $workerGig->name;
            }else{
                $data[$key]['upazila_name'] = $workerGig->name;
                $data[$key]['gig_income'] = $workerGig->total_service_charge;
                $data[$key]['month_name'] = $workerGig->month_name;
            }
        }
        foreach($memberShips as $key => $memberShip){
            if($data[$key]['month_name'] == $memberShip->month_name){
                $data[$key]['upazila_name'] = $memberShip->name;
                $data[$key]['membership_income'] = $memberShip->total_income;
            }else{
                $data[$key]['upazila_name'] = $memberShip->name;
                $data[$key]['membership_income'] = $memberShip->total_income;
                $data[$key]['month_name'] = $memberShip->month_name;
            }
        }
        foreach($specialServices as $key => $specialService){
            if($data[$key]['month_name'] == $specialService->month_name){
                $data[$key]['upazila_name'] = $specialService->name;
                $data[$key]['order_income'] = $specialService->order_fee;
            }else{
                $data[$key]['upazila_name'] = $specialService->name;
                $data[$key]['order_income'] = $specialService->order_fee;
                $data[$key]['month_name'] = $specialService->month_name;
            }
        }
        foreach($localAds as $key => $localAd){
            if($data[$key]['month_name'] == $localAd->month_name){
                $data[$key]['local_ad_income'] = $localAd->local_ad_income;
                $data[$key]['upazila_name'] = $localAd->name;
            }else{
                $data[$key]['upazila_name'] = $localAd->name;
                $data[$key]['local_ad_income'] = $localAd->local_ad_income;
                $data[$key]['month_name'] = $localAd->month_name;
            }
        }

        foreach($totalExpenses as $key => $totalExpense){
            if($data[$key]['month_name'] == $totalExpense->month_name){
                $data[$key]['aff_expense'] = $totalExpense->income;
                $data[$key]['upazila_name'] = $totalExpense->name;
            }else{
                $data[$key]['upazila_name'] = $totalExpense->name;
                $data[$key]['aff_expense'] = $totalExpense->income;
                $data[$key]['month_name'] = $totalExpense->month_name;
            }
        }

        return $data;

    }


    /** Total Income */
    private static function totalIncomePrivateFunction(array $data)
    {
        $totalIncome = 0;
        $aff_marketer_exp = 0;
        foreach ($data as $key => $val) {
            if (array_key_exists('bid_income', $val)) {
                $totalIncome +=  $val['bid_income'];
            }
            if (array_key_exists('gig_income', $val)) {
                $totalIncome +=  $val['gig_income'];
            }
            if (array_key_exists('membership_income', $val)) {
                $totalIncome +=  $val['membership_income'];
            }
            if (array_key_exists('local_ad_income', $val)) {
                $totalIncome +=  $val['local_ad_income'];
            }
            if (array_key_exists('order_income', $val)) {
                $totalIncome +=  $val['order_income'];
            }
            if (array_key_exists('aff_expense', $val)) {
                $aff_marketer_exp += $val['aff_expense'];
            }
        }

        return [
            'totalIncome' => $totalIncome,
            'aff_marketer_exp' => $aff_marketer_exp,
        ];
    }
    

    /** Total Marketing Fund */
    public static function totalMarketingFund($request){
        $data = self::totalIncomeWithMonth($request);
        $totalIncome = self::totalIncomePrivateFunction($data)['totalIncome'];
        $aff_marketer_exp = self::totalIncomePrivateFunction($data)['aff_marketer_exp'];
        $earningAfterExp = $totalIncome - $aff_marketer_exp;
        $reserve_percentage = get_static_option('marketing_fund_reserve');
        $marketing_fund_reserve = $earningAfterExp * ($reserve_percentage / 100);
        $percentage = get_static_option('area_marketing_fund');
        $area_fund_reserve = $marketing_fund_reserve * ($percentage / 100);
        $company_fund_exp = self::companyFundExp($request)->sum('amount');
        $company_fund_resv = $marketing_fund_reserve - $area_fund_reserve;
        $net_compnay_fund_reserve = $company_fund_resv - $company_fund_exp;
        $area_fund_exp = self::areaFundExp($request)->sum('amount');
        $net_area_fund_reserve = $area_fund_reserve - $area_fund_exp;
        $returnData = [
            'total_marketing_fund' => $marketing_fund_reserve,
            'area_fund_reserve' => $area_fund_reserve,
            'company_fund_reserve' => $company_fund_resv,
            'company_fund_exp' => $company_fund_exp,
            'area_fund_exp' => $area_fund_exp,
            'net_compnay_fund_reserve' => $net_compnay_fund_reserve,
            'net_area_fund_reserve' => $net_area_fund_reserve,
        ];
        return $returnData;
    }



    public static function filterAffMarketerExpArea($district, $upazila, $month, $year)
    {
        if ($district == 0 && $upazila == 0 && $month == 0 && $year == 0) {
            //Upazilla wise affiliate marketer

            $data = DB::table('affiliate_users')
                ->join('users', 'affiliate_users.user_id', 'users.id')
                ->join('upazilas', 'users.upazila_id', 'upazilas.id')
                ->select('upazilas.name',
                    DB::raw('count(*) as total_affiliate_marketer'),
                    DB::raw('sum(affiliate_users.balance) as total_expense'),
                    DB::raw('SUM(CASE WHEN affiliate_bonuses.bonus_purpose = "Worker Signup" THEN affiliate_bonuses.amount ELSE 0 END) as worker_signup_bonus'),
                    DB::raw('SUM(CASE WHEN affiliate_bonuses.bonus_purpose = "Order Commission" THEN affiliate_bonuses.amount ELSE 0 END) as order_bonus'),
                    DB::raw('SUM(CASE WHEN affiliate_bonuses.bonus_purpose = "Customer Signup" THEN affiliate_bonuses.amount ELSE 0 END) as customer_signup_bonus'),
                    DB::raw('SUM(CASE WHEN affiliate_bonuses.bonus_purpose = "Marketer Commismion" THEN affiliate_bonuses.amount ELSE 0 END) as marketer_commison'),
                    DB::raw('SUM(CASE WHEN affiliate_bonuses.bonus_purpose = "Membership" THEN affiliate_bonuses.amount ELSE 0 END) as membership')
                )
                ->leftJoin('affiliate_bonuses', 'affiliate_users.id', 'affiliate_bonuses.affiliate_user_id')
                ->where('affiliate_users.status', 1)
                ->groupBy('upazilas.name')
                ->get();

        }else if ($district == 'All' && $upazila == 'All' && $month == 'All' && $year == 'All') {
            //Upazilla wise affiliate marketer
            $data = DB::table('affiliate_users')
                ->join('users', 'affiliate_users.user_id', 'users.id')
                ->join('upazilas', 'users.upazila_id', 'upazilas.id')
                ->select('upazilas.name',
                    DB::raw('count(*) as total_affiliate_marketer'),
                    DB::raw('sum(affiliate_users.balance) as total_expense'),
                    DB::raw('SUM(CASE WHEN affiliate_bonuses.bonus_purpose = "Worker Signup" THEN affiliate_bonuses.amount ELSE 0 END) as worker_signup_bonus'),
                    DB::raw('SUM(CASE WHEN affiliate_bonuses.bonus_purpose = "Order Commission" THEN affiliate_bonuses.amount ELSE 0 END) as order_bonus'),
                    DB::raw('SUM(CASE WHEN affiliate_bonuses.bonus_purpose = "Customer Signup" THEN affiliate_bonuses.amount ELSE 0 END) as customer_signup_bonus'),
                    DB::raw('SUM(CASE WHEN affiliate_bonuses.bonus_purpose = "Marketer Commismion" THEN affiliate_bonuses.amount ELSE 0 END) as marketer_commison'),
                    DB::raw('SUM(CASE WHEN affiliate_bonuses.bonus_purpose = "Membership" THEN affiliate_bonuses.amount ELSE 0 END) as membership')
                )
                ->leftJoin('affiliate_bonuses', 'affiliate_users.id', 'affiliate_bonuses.affiliate_user_id')
                ->where('affiliate_users.status', 1)
                ->groupBy('upazilas.name')
                ->get();
        }elseif ($district >= 0 && $upazila == 0 && $month == 0 && $year == 0) {
            //Upazilla wise affiliate marketer
            $data = DB::table('affiliate_users')
                ->join('users', 'affiliate_users.user_id', 'users.id')
                ->join('upazilas', 'users.upazila_id', 'upazilas.id')
                ->select('upazilas.name',
                    DB::raw('count(*) as total_affiliate_marketer'),
                    DB::raw('sum(affiliate_users.balance) as total_expense'),
                    DB::raw('SUM(CASE WHEN affiliate_bonuses.bonus_purpose = "Worker Signup" THEN affiliate_bonuses.amount ELSE 0 END) as worker_signup_bonus'),
                    DB::raw('SUM(CASE WHEN affiliate_bonuses.bonus_purpose = "Order Commission" THEN affiliate_bonuses.amount ELSE 0 END) as order_bonus'),
                    DB::raw('SUM(CASE WHEN affiliate_bonuses.bonus_purpose = "Customer Signup" THEN affiliate_bonuses.amount ELSE 0 END) as customer_signup_bonus'),
                    DB::raw('SUM(CASE WHEN affiliate_bonuses.bonus_purpose = "Marketer Commismion" THEN affiliate_bonuses.amount ELSE 0 END) as marketer_commison'),
                    DB::raw('SUM(CASE WHEN affiliate_bonuses.bonus_purpose = "Membership" THEN affiliate_bonuses.amount ELSE 0 END) as membership')
                )
                ->leftJoin('affiliate_bonuses', 'affiliate_users.id', 'affiliate_bonuses.affiliate_user_id')
                ->where('users.district_id', $district)
                ->where('affiliate_users.status', 1)
                ->groupBy('upazilas.name')
                ->get();
        }elseif ($district == 0 && $upazila != 0 && $month == 0 && $year == 0) {
            //Upazilla wise affiliate marketer
            $data = DB::table('affiliate_users')
                ->join('users', 'affiliate_users.user_id', 'users.id')
                ->join('upazilas', 'users.upazila_id', 'upazilas.id')
                ->select('upazilas.name',
                    DB::raw('count(*) as total_affiliate_marketer'),
                    DB::raw('sum(affiliate_users.balance) as total_expense'),
                    DB::raw('SUM(CASE WHEN affiliate_bonuses.bonus_purpose = "Worker Signup" THEN affiliate_bonuses.amount ELSE 0 END) as worker_signup_bonus'),
                    DB::raw('SUM(CASE WHEN affiliate_bonuses.bonus_purpose = "Order Commission" THEN affiliate_bonuses.amount ELSE 0 END) as order_bonus'),
                    DB::raw('SUM(CASE WHEN affiliate_bonuses.bonus_purpose = "Customer Signup" THEN affiliate_bonuses.amount ELSE 0 END) as customer_signup_bonus'),
                    DB::raw('SUM(CASE WHEN affiliate_bonuses.bonus_purpose = "Marketer Commismion" THEN affiliate_bonuses.amount ELSE 0 END) as marketer_commison'),
                    DB::raw('SUM(CASE WHEN affiliate_bonuses.bonus_purpose = "Membership" THEN affiliate_bonuses.amount ELSE 0 END) as membership')
                )
                ->leftJoin('affiliate_bonuses', 'affiliate_users.id', 'affiliate_bonuses.affiliate_user_id')
                ->where('users.upazila_id', $upazila)
                ->where('affiliate_users.status', 1)
                ->groupBy('upazilas.name')
                ->get();
        }else if ($district == 0 && $upazila == 0 && $month != 0 && $year == 0) {
            //Upazilla wise affiliate marketer
            $data = DB::table('affiliate_users')
                ->join('users', 'affiliate_users.user_id', 'users.id')
                ->join('upazilas', 'users.upazila_id', 'upazilas.id')
                ->select('upazilas.name',
                    DB::raw('count(*) as total_affiliate_marketer'),
                    DB::raw('sum(affiliate_users.balance) as total_expense'),
                    DB::raw('SUM(CASE WHEN affiliate_bonuses.bonus_purpose = "Worker Signup" THEN affiliate_bonuses.amount ELSE 0 END) as worker_signup_bonus'),
                    DB::raw('SUM(CASE WHEN affiliate_bonuses.bonus_purpose = "Order Commission" THEN affiliate_bonuses.amount ELSE 0 END) as order_bonus'),
                    DB::raw('SUM(CASE WHEN affiliate_bonuses.bonus_purpose = "Customer Signup" THEN affiliate_bonuses.amount ELSE 0 END) as customer_signup_bonus'),
                    DB::raw('SUM(CASE WHEN affiliate_bonuses.bonus_purpose = "Marketer Commismion" THEN affiliate_bonuses.amount ELSE 0 END) as marketer_commison'),
                    DB::raw('SUM(CASE WHEN affiliate_bonuses.bonus_purpose = "Membership" THEN affiliate_bonuses.amount ELSE 0 END) as membership')
                )
                ->leftJoin('affiliate_bonuses', 'affiliate_users.id', 'affiliate_bonuses.affiliate_user_id')
                ->whereMonth('affiliate_users.created_at', '=', $month)
                ->where('affiliate_users.status', 1)
                ->groupBy('upazilas.name')
                ->get();
        }else if ($district == 0 && $upazila == 0 && $month == 0 && $year != 0) {
            //Upazilla wise affiliate marketer
            $data = DB::table('affiliate_users')
                ->join('users', 'affiliate_users.user_id', 'users.id')
                ->join('upazilas', 'users.upazila_id', 'upazilas.id')
                ->select('upazilas.name',
                    DB::raw('count(*) as total_affiliate_marketer'),
                    DB::raw('sum(affiliate_users.balance) as total_expense'),
                    DB::raw('SUM(CASE WHEN affiliate_bonuses.bonus_purpose = "Worker Signup" THEN affiliate_bonuses.amount ELSE 0 END) as worker_signup_bonus'),
                    DB::raw('SUM(CASE WHEN affiliate_bonuses.bonus_purpose = "Order Commission" THEN affiliate_bonuses.amount ELSE 0 END) as order_bonus'),
                    DB::raw('SUM(CASE WHEN affiliate_bonuses.bonus_purpose = "Customer Signup" THEN affiliate_bonuses.amount ELSE 0 END) as customer_signup_bonus'),
                    DB::raw('SUM(CASE WHEN affiliate_bonuses.bonus_purpose = "Marketer Commismion" THEN affiliate_bonuses.amount ELSE 0 END) as marketer_commison'),
                    DB::raw('SUM(CASE WHEN affiliate_bonuses.bonus_purpose = "Membership" THEN affiliate_bonuses.amount ELSE 0 END) as membership')
                )
                ->leftJoin('affiliate_bonuses', 'affiliate_users.id', 'affiliate_bonuses.affiliate_user_id')
                ->whereYear('affiliate_users.created_at', '=', $year)
                ->where('affiliate_users.status', 1)
                ->groupBy('upazilas.name')
                ->get();
        }

        return $data;
    }

    public static function filterAdGlobal($district, $upazila, $month, $year)
    {
        if ($district == 0 && $upazila == 0 && $month == 0 && $year == 0) {
            $data = AdExpense::take(6)->get();
        }else if ($district == 'All' && $upazila == 'All' && $month == 'All' && $year == 'All') {
            $data = AdExpense::take(6)->get();
        }elseif ($district >= 0 && $upazila == 0 && $month == 0 && $year == 0) {
            $data = DB::table('ad_expenses')
                ->join('users', 'ads.user_id', 'users.id')
                ->join('districts', 'users.district_id', 'districts.id')
                ->where('users.district_id', $district)
                ->get();
        }elseif ($district == 0 && $upazila != 0 && $month == 0 && $year == 0) {
            $data = DB::table('ad_expenses')
                ->join('users', 'ads.user_id', 'users.id')
                ->join('upazilas', 'users.upazila_id', 'upazilas.id')
                ->where('users.upazila_id', $upazila)
                ->get();
        }else if ($district == 0 && $upazila == 0 && $month != 0 && $year == 0) {
            $data = AdExpense::whereMonth('created_at', '=', $month)->take(6)->get();
        }else if ($district == 0 && $upazila == 0 && $month == 0 && $year != 0) {
            $data = AdExpense::whereYear('created_at', '=', $year)->take(6)->get();
        }else if ($district == 0 && $upazila == 0 && $month != 0 && $year != 0) {
            $data = AdExpense::whereMonth('created_at', '=', $month)->whereYear('created_at', '=', $year)->take(6)->get();
        }

        return $data;
    }

    public static function filterAdArea($district, $upazila, $month, $year)
    {
        if ($district == 0 && $upazila == 0 && $month == 0 && $year == 0) {
            $data = AreaAdExpense::all();
        }else if ($district == 'All' && $upazila == 'All' && $month == 'All' && $year == 'All') {
            $data = AreaAdExpense::all();
        }elseif ($district >= 0 && $upazila == 0 && $month == 0 && $year == 0) {
            $data = AreaAdExpense::where('district_id', $district)->get();
        }elseif ($district == 0 && $upazila != 0 && $month == 0 && $year == 0) {
            $data = AreaAdExpense::where('upazila_id', $upazila)->get();
        }else if ($district == 0 && $upazila == 0 && $month != 0 && $year == 0) {
            $data = AreaAdExpense::whereMonth('created_at', '=', $month)->get();
        }else if ($district == 0 && $upazila == 0 && $month == 0 && $year != 0) {
            $data = AreaAdExpense::whereYear('created_at', '=', $year)->get();
        }else if ($district == 0 && $upazila == 0 && $month != 0 && $year != 0) {
            $data = AreaAdExpense::whereMonth('created_at', '=', $month)->whereYear('created_at', '=', $year)->get();
        }

        return $data;
    }

    public static function filterAdHome ($month, $year)
    {
        if ($month == 0 && $year == 0) {
            $data = [
                'total_ad_expense' => AdExpense::sum('amount'),
                'total_area_ad_expense' => AreaAdExpense::sum('amount'),
            ];
        } else if ($month == 'All' && $year == 'All') {
            $data = [
                'total_ad_expense' => AdExpense::sum('amount'),
                'total_area_ad_expense' => AreaAdExpense::sum('amount'),
            ];
        } else if ($month == 0 && $year != 0) {
            $data = [
                'total_ad_expense' => AdExpense::whereYear('created_at', '=', $year)->sum('amount'),
                'total_area_ad_expense' => AreaAdExpense::whereYear('created_at', '=', $year)->sum('amount'),
            ];

        } else if ($month != 0 && $year == 0) {
            $data = [
                'total_ad_expense' => AdExpense::whereMonth('created_at', '=', $month)->sum('amount'),
                'total_area_ad_expense' => AreaAdExpense::whereMonth('created_at', '=', $month)->sum('amount'),
            ];
        } else if ($month != 0 && $year != 0) {
            $data = [
                'total_ad_expense' => AdExpense::whereMonth('created_at', '=', $month)->whereYear('created_at', '=', $year)->sum('amount'),
                'total_area_ad_expense' => AreaAdExpense::whereMonth('created_at', '=', $month)->whereYear('created_at', '=', $year)->sum('amount'),
            ];
        }
        $data['total_expense'] = $data['total_ad_expense'] + $data['total_area_ad_expense'];
        return $data;
    }


    /**Company fund Expense */

    public static function companyFundExp($request)
    {
        $month = $request->month ?? 'All';
        $year = $request->year ?? 'All';

        $companyAdExpense = AdExpense::with('user')
            ->month($month)
            ->year($year);

        return $companyAdExpense;
    }

    public static function areaFundExp($request)
    {
        $district = $request->district ?? 'All';
        $upazila = $request->upazila ?? 'All';
        $month = $request->month ?? 'All';
        $year = $request->year ?? 'All';

        $areaFundExpenses = AreaAdExpense::with(['district', 'upazila'])
            ->district($district)
            ->upazila($upazila)
            ->month($month)
            ->year($year);

        return $areaFundExpenses;
    }


}
