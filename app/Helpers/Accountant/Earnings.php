<?php

namespace App\Helpers\Accountant;

use App\Balance;
use App\Membership;
use App\OthersIncome;
use App\SpecialServiceOrder;

class Earnings
{
    /** Total Earning From Service Provider */
    public static function totalEarningServiceProvider($request)
    {
        $district = $request->district ?? 'All';
        $upazilla = $request->upazilla ?? 'All';
        $month = $request->month ?? 'All';
        $year = $request->year ?? 'All';
        $total = Balance::district($district)
            ->upazila($upazilla)
            ->month($month)
            ->year($year)
            ->sum('job_income');

        return $total;
    }
    /**Total Earning From MemberShip */
    public static function totalEarningByMemberShip($request)
    {
        $district = $request->district ?? 'All';
        $upazilla = $request->upazilla ?? 'All';
        $month = $request->month ?? 'All';
        $year = $request->year ?? 'All';
        $total = [
            'first_time' => Membership::firstTime()
                ->district($district)
                ->upazila($upazilla)
                ->month($month)
                ->year($year)
                ->sum('amount'),
            'renew' => Membership::renew()
                ->district($district)
                ->upazila($upazilla)
                ->month($month)
                ->year($year)
                ->sum('amount'),
            'upgrade' => Membership::upgraded()
                ->district($district)
                ->upazila($upazilla)
                ->month($month)
                ->year($year)
                ->sum('amount'),
        ];

        return $total;
    }

    /** Total Special Service Order */
    public static function totalEarningsBySpecialOrder($request)
    {
        $district = $request->district ?? 'All';
        $upazilla = $request->upazilla ?? 'All';
        $month = $request->month ?? 'All';
        $year = $request->year ?? 'All';
        $totalPaid = SpecialServiceOrder::district($district)
            ->upazila($upazilla)
            ->month($month)
            ->year($year)
            ->sum('fee');

        return $totalPaid;
    }

    /** Total Earnings By Others Service */
    public static function totalEarningsByOthersService($request)
    {
        $month = $request->month ?? 'All';
        $year = $request->year ?? 'All';
        $total = OthersIncome::month($request->month ?? 'All')
            ->year($request->year ?? 'All')
            ->total();

        return $total;
    }

    /** Lifetime Earnings */
    public static function lifeTimeEarnings($request)
    {
        $memberShipEarnings = self::totalEarningByMemberShip($request);
        $totalEarningServiceProvider = self::totalEarningServiceProvider($request);
        $totalEarningByMemberShip = $memberShipEarnings['first_time'] + $memberShipEarnings['renew'] + $memberShipEarnings['upgrade'];
        $totalEarningsBySpecialOrder = self::totalEarningsBySpecialOrder($request);
        $totalEarningsByOthersService = self::totalEarningsByOthersService($request);

        $lifetimeEarnings = $totalEarningServiceProvider + $totalEarningByMemberShip + $totalEarningsBySpecialOrder + $totalEarningsByOthersService;
        return $lifetimeEarnings;
    }
}


