<?php

namespace App\Helpers\Controller;

use App\MembershipPackage;
use Carbon\Carbon;

class Helper
{
    public static function countActiveMembershipsForPackages()
    {
        $packages = MembershipPackage::with('membership')
            ->get()
            ->map(function ($package) {
                $activeMemberships = $package->membership->filter(function ($membership) {
                    return $membership->end_at > Carbon::now();
                });

                return [
                    'package_id' => $package->id,
                    'package_name' => $package->name,
                    'active_memberships_count' => $activeMemberships->count(),
                    'package_price' => $package->monthly_price,
                ];
            });

        return $packages;
    }
}
