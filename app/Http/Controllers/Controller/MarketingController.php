<?php

namespace App\Http\Controllers\Controller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MarketingController extends Controller
{
    public function marketingCost()
    {
        return view('controller.marketing.marketing-cost');
    }

    public function home()
    {
        return view('controller.marketing.home');
    }
    public function reserved()
    {
        return view('controller.marketing.reserved');
    }
    public function export()
    {
        return view('controller.marketing.export');
    }
}
