<?php

namespace App\Http\Controllers\Accountant;

use App\Helpers\Accountant\Earnings;
use App\Helpers\Accountant\Expense;
use App\Helpers\Accountant\Helper;
use App\Http\Controllers\Controller;
use App\Membership;
use App\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $district = $request->district ?? 'All';
        $upazilla = $request->upazilla ?? 'All';
        $month = $request->month ?? 'All';
        $year = $request->year ?? 'All';
        
        $totalEarnings = Earnings::lifeTimeEarnings($request);
        $totalExpense = Expense::totalLifeTimeExpense($request);
        $totalNetIncome = $totalEarnings - $totalExpense;
        $totalAreaController = User::controller()->count();
        $totalCustomer = User::customer()->count();
        $totalWorker = User::worker()->count();
        $totalAffMarketer = Helper::totalAffmarketer($request);
        $totalMembership = Membership::active()
            ->district($district)
            ->upazila($upazilla)
            ->month($month)
            ->year($year)
            ->count();



        /**Earning Table Data */    
        $workerIncome = Earnings::totalEarningServiceProvider($request);
        $memberShipEarnings = Earnings::totalEarningByMemberShip($request);
        $membershipIncome = $memberShipEarnings['first_time'] + $memberShipEarnings['renew'] + $memberShipEarnings['upgrade'];
        $specilaServiceIncome = Earnings::totalEarningsBySpecialOrder($request);
        $areaControllerEarnings = $workerIncome + $membershipIncome + $specilaServiceIncome;
        $othersIncome = Earnings::totalEarningsByOthersService($request);
        $totalEarnings = $areaControllerEarnings + $othersIncome;

        /**Expense Table Data */
        $areaControllerProfit = Expense::totalAreaControllerExpense($request);
        $reserve_percentage = get_static_option('marketing_fund_reserve');
        $marketingFundReserve = $areaControllerProfit * ($reserve_percentage / 100);
        $affMarketingCost = Expense::totalAffMarketerExpense($request);
        $salaryExpense = Expense::totalSalaryExpense($request)->total();
        $othersExpense = Expense::totalOthersExpense($request);
        $adExpense = 0;

        $areaControllerExpense = $areaControllerProfit + $marketingFundReserve + $affMarketingCost;
        $totalExpense = $areaControllerExpense + $salaryExpense + $othersExpense + $adExpense;

        $netIncome = $totalEarnings - $totalExpense;
        return view('accountant.dashboard', 
            compact(
                'totalEarnings', 
                'totalExpense', 
                'totalNetIncome', 
                'totalAreaController',
                'totalCustomer',
                'totalWorker',
                'totalAffMarketer',
                'totalMembership',
                'workerIncome',
                'membershipIncome',
                'specilaServiceIncome',
                'areaControllerEarnings',
                'othersIncome',
                'totalEarnings',
                'salaryExpense',
                'othersExpense',
                'adExpense',
                'areaControllerProfit',
                'marketingFundReserve',
                'affMarketingCost',
                'areaControllerExpense',
                'totalExpense',
                'netIncome'
            ));
    }
}
