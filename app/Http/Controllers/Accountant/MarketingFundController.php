<?php

namespace App\Http\Controllers\Accountant;

use App\AdExpense;
use App\AreaAdExpense;
use App\Helpers\Accountant\Helper as AccountantHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\AcceptHeader;

class MarketingFundController extends Controller
{
    //overview
    public function overview(Request $request)
    {
        $data = AccountantHelper::totalMarketingFund($request);
        return view('accountant.marketing-fund.overview', compact('data'));
    }

    //company
    public function companyHome(Request $request)
    {
        $data = AccountantHelper::totalMarketingFund($request);
        return view('accountant.marketing-fund.company.home', compact('data'));
    }

    public function companyFundReserve(Request $request)
    {
        $data = AccountantHelper::totalIncomeWithMonth($request);
        return view('accountant.marketing-fund.company.fund-reserve', compact('data'));
    }

    public function companyFundExp(Request $request)
    {
        $companyAdExpense = AccountantHelper::companyFundExp($request)->get();
        return view('accountant.marketing-fund.company.fund-exp', compact('companyAdExpense'));
    }

    public function companyFundExpStore(Request $request)
    {
        AdExpense::create([
            'exp_date' => $request->date,
            'amount' => $request->amount,
            'details' => $request->details,
            'user_id' => auth()->user()->id,            
        ]);

        return redirect()->back()->with('success','Company Ad Expense Added Successfully!');
    }

    //area

    public function areaHome(Request $request)
    {
        $data = AccountantHelper::totalMarketingFund($request);
        return view('accountant.marketing-fund.area.home', compact('data'));
    }

    public function areaFundReserve(Request $request)
    {
        $data = AccountantHelper::totalIncomeWithMonth($request);
        return view('accountant.marketing-fund.area.fund-reserve', compact('data'));
    }

    public function areaFundExp(Request $request)
    {
        $areaFundExpenses = AccountantHelper::areaFundExp($request)->get();
        return view('accountant.marketing-fund.area.fund-exp', compact('areaFundExpenses'));
    }

    public function areaFundExpStore(Request $request)
    {
        AreaAdExpense::create([
            'exp_date' => $request->date,
            'amount' => $request->amount,
            'details' => $request->details,
            'user_id' => auth()->user()->id,
            'district_id' => $request->district,
            'upazila_id' => $request->upazila,
        ]);

        return redirect()->back()->with('success','Area Ad Expense Added Successfully!');
    }


}
