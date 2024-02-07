<?php

namespace App\Http\Controllers\Worker;

use App\AdminAds;
use App\GigOrder;
use App\Http\Controllers\Controller;
use App\Job;
use App\PageService;

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
    public function index()
    {


        $adminAds = AdminAds::where('status', '1')
            ->whereDate('starting', '<', Carbon::today()->addDays(1))
            ->whereDate('ending', '>', Carbon::today()->addDays(-1))
            ->get();
        $your_services = PageService::where('worker_id', Auth::id())->get();
        return view('worker.job.index', compact('adminAds', 'your_services'));
    }
}
