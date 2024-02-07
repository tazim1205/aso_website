<?php

namespace App\Helpers\Accountant;

use App\AffiliateBonus;
use App\AreaAdExpense;
use App\Membership;
use App\OtherExpense;
use App\Salary;
use App\SpecialServiceOrder;
use App\WorkerBid;
use App\WorkerGig;

class Expense
{
    /**Total Affiliate Marketer Expense */
    public static function totalAffMarketerExpense($request)
    {
        $district = $request->district ?? 'All';
        $upazila = $request->upazila ?? 'All';
        $month = $request->month ?? 'All';
        $year = $request->year ?? 'All';

        $totalExpense = AffiliateBonus::district($district)
            ->upazila($upazila)
            ->month($month)
            ->year($year)
            ->sameAreaUser()
            ->sum('amount');

        return $totalExpense;
    }

    /** Total Ad Expense */
    public static function totalAdExpense($request)
    {
        return 0;
    }

    /**Total Area Controller Expense */
    public static function totalAreaControllerExpense($request){
        $district = $request->district ?? 'All';
        $upazila = $request->upazila ?? 'All';
        $month = $request->month ?? 'All';
        $year = $request->year ?? 'All';

        $workerBid = WorkerBid::sameAreaUser()
            ->district($district)
            ->upazila($upazila)
            ->month($month)
            ->year($year)
            ->sum('service_charge');

        $workerGig = WorkerGig::sameAreaUser()
            ->district($district)
            ->upazila($upazila)
            ->month($month)
            ->year($year)
            ->sum('service_charge');

        $memberShip = Membership::sameAreaUser()
            ->district($district)
            ->upazila($upazila)
            ->month($month)
            ->year($year)
            ->sum('amount');

        $specialService = SpecialServiceOrder::sameAreaUser()
            ->district($district)
            ->upazila($upazila)
            ->month($month)
            ->year($year)
            ->sum('fee');

        $localAd = AreaAdExpense::sameAreaUser()
            ->district($district)
            ->upazila($upazila)
            ->month($month)
            ->year($year)
            ->sum('amount');


        $totalExpense = ($workerBid + $workerGig + $memberShip + $specialService + $localAd) * (get_static_option('area_controller_percent') / 100);
        return $totalExpense;
    }

    /** Total Salary Expense */
    public static function totalSalaryExpense($request)
    {
        $month = $request->month ?? 'All';
        $year = $request->year ?? 'All';
        $query = Salary::month($month)
            ->year($year);
        return $query;
    }

    /** Total Others Expense */
    public static function totalOthersExpense($request)
    {
        $month = $request->month ?? 'All';
        $year = $request->year ?? 'All';
        $total = OtherExpense::month($month)
            ->year($year)
            ->total();
        return $total;
    }

    public static function totalLifeTimeExpense($request)
    {
        $total =self::totalAffMarketerExpense($request) + 
                self::totalAdExpense($request) +
                self::totalAreaControllerExpense($request)+
                self::totalSalaryExpense($request)->total()+
                self::totalOthersExpense($request);

        return $total;
    }

}