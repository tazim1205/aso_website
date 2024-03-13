<?php

namespace App\Http\Controllers\Customer;

use App\AdminAds;
use App\Http\Controllers\Controller;
use App\District;
use App\Upazila;
use App\Puroshova;
use App\Word;
use App\ControllerAds;

use Carbon\Carbon;
use App\User;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class JobController extends Controller
{
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $adminAds = AdminAds::where('status', '1')
            ->whereDate('starting', '<', Carbon::today()->addDays(1))
            ->whereDate('ending', '>', Carbon::today()->addDays(-1))
            ->get();

        $controllerAds = ControllerAds::join('users','users.id','controller_ads.controller_id')->where('users.role','controller')->where('upazila_id',$request->upazila_thana_id)
            ->whereDate('starting', '<', Carbon::today()->addDays(1))
            ->whereDate('ending', '>', Carbon::today()->addDays(-1))
            ->get();

        $data = [
            'district' => District::find($request->district_id, ['name']),
            'upazila' => Upazila::find($request->upazila_thana_id, ['name']),
            'puroshova' => Puroshova::find($request->pouroshava_union_id, ['name']),
            'word' => Word::find($request->word_road_id, ['name']),
        ];
        return view('customer.job.index', compact('adminAds','controllerAds'));
    }

}
