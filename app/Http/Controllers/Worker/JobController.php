<?php

namespace App\Http\Controllers\Worker;

use App\AdminAds;
use App\GigOrder;
use App\Http\Controllers\Controller;
use App\Job;
use App\PageService;
use App\District;
use App\Upazila;
use App\Puroshova;
use App\Word;
use App\ControllerAds;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class JobController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {


        $adminAds = AdminAds::where('status', '1')
            ->whereDate('starting', '<', Carbon::today()->addDays(1))
            ->whereDate('ending', '>', Carbon::today()->addDays(-1))
            ->get();
        $your_services = PageService::where('worker_id', Auth::id())->get();

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

        return view('worker.job.index', compact('adminAds', 'your_services','controllerAds','data'));
    }
}
