<?php

namespace App\Http\Controllers\Accountant;

use App\AdExpense;
use App\AffiliateBonus;
use App\AffiliateUser;
use App\AreaAdExpense;
use App\AreaControllerPayment;
use App\CustomerBid;
use App\Helpers\Accountant\Expense;
use App\Helpers\Accountant\Helper;
use App\Http\Controllers\Controller;
use App\Membership;
use App\OtherExpense;
use App\Salary;
use App\SpecialServiceOrder;
use App\User;
use App\WorkerBid;
use App\WorkerGig;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class ExpensesController extends Controller
{
    public function affMarketerHome(Request $request)
    {
        $district = $request->district ?? 'All';
        $upazila = $request->upazila ?? 'All';
        $month = $request->month ?? 'All';
        $year = $request->year ?? 'All';
        $total = Helper::totalAffmarketer($request);

        $totalExpense = Expense::totalAffMarketerExpense($request);

        $totalPaid = AffiliateUser::district($district)
            ->upazila($upazila)
            ->month($month)
            ->year($year)
            ->sum('paid_amount');

        $totalPending = $totalExpense - $totalPaid;

        return view('accountant.expenses.aff-marketer.home', compact(
            'total',
            'totalExpense',
            'totalPaid',
            'totalPending'
        ));
    }


    public function affMarketerExpArea()
    {
        return view('accountant.expenses.aff-marketer.exp-area');
    }

    public function affMarketerExpAreaFilter(int $district, int $upazila, int $month, int $year)
    {
        $data = Helper::filterAffMarketerExpArea($district, $upazila, $month, $year);
//        dd($data);
        return DataTables::of($data)
            ->addIndexColumn()
            ->rawColumns(['action'])
            ->make(true);
    }

    public function adHome()
    {
        return view('accountant.expenses.ad.home');
    }

    public function adHomeFilter(int $month, int $year)
    {
        $data = Helper::filterAdHome($month, $year);
        return response()->json($data);
    }

    public function adArea()
    {
        return view('accountant.expenses.ad.ad-area');
    }

    public function adAreaPost(Request $request)
    {
        $request->validate([
            'exp_date' => 'required',
            'amount' => 'required',
            'district' => 'required',
            'upazila' => 'required',
        ]);

        AreaAdExpense::create([
            'exp_date' => $request->exp_date,
            'amount' => $request->amount,
            'details' => $request->details,
            'user_id' => auth()->user()->id,
            'district_id' => $request->district,
            'upazila_id' => $request->upazila,
        ]);

        return redirect()->back()->with('success', 'Expense added successfully');
    }

    public function adAreaFilter(int $district, int $upazila, int $month, int $year)
    {
        $data = Helper::filterAdArea($district, $upazila, $month, $year);
        return DataTables::of($data)
            ->addIndexColumn()
            ->editColumn('district', function ($data) {
                return $data->district->name;
            })
            ->editColumn('upazila', function ($data) {
                return $data->upazila->name;
            })
            ->editColumn('exp_date', function ($data) {
                return date('d-m-Y', strtotime($data->exp_date));
            })
            ->editColumn('amount', function ($data) {
                return number_format($data->amount, 2);
            })
            ->make(true);
    }

    public function adGlobal()
    {
        return view('accountant.expenses.ad.ad-global');
    }

    public function adGlobalPost(Request $request)
    {
        $request->validate([
            'exp_date' => 'required',
            'amount' => 'required',
        ]);

        AdExpense::create([
            'exp_date' => $request->exp_date,
            'amount' => $request->amount,
            'details' => $request->details,
            'user_id' => auth()->user()->id,
        ]);

        return redirect()->back()->with('success', 'Expense added successfully');
    }

    public function adGlobalFilter(int $district, int $upazila, int $month, int $year)
    {
        $data = Helper::filterAdGlobal($district, $upazila, $month, $year);
        return DataTables::of($data)
            ->addIndexColumn()
            ->editColumn('exp_date', function ($data) {
                return date('d-m-Y', strtotime($data->exp_date));
            })
            ->editColumn('amount', function ($data) {
                return number_format($data->amount, 2);
            })
            ->make(true);
    }

    public function areaControllerHome(Request $request)
    {
        $district = $request->district ?? 'All';
        $upazila = $request->upazila ?? 'All';
        $month = $request->month ?? 'All';
        $year = $request->year ?? 'All';
        $total = User::controller()->count();
        $totalExpense = Expense::totalAreaControllerExpense($request);
        
        $totalPaid = AreaControllerPayment::month($month)
                    ->year($year)
                    ->sum('amount');
        $totalPending = $totalExpense - $totalPaid;
        return view('accountant.expenses.area-controller.home', compact('total', 'totalExpense', 'totalPaid', 'totalPending'));
    }

    public function areaControllerTotalIncome(Request $request)
    {

        $data = Helper::totalIncome($request);

        return view('accountant.expenses.area-controller.total-income' , compact('data'));
    }

    public function areaControllerProfitAndPay(Request $request)
    {
        $data = Helper::totalIncomeWithMonth($request);
        // dd($data);
        return view('accountant.expenses.area-controller.profit-and-pay', compact('data'));
    }

    public function areaControllerProfitAndPayStore(Request $request){
        AreaControllerPayment::create([
            'month' => $request->month,
            'upazila' => $request->upazila,
            'amount' => $request->amount,
            'paid_date' => $request->date,
            'controller_ac_number' => $request->controller_ac_number,
            'controller_ac_details' => $request->controller_ac_details,
            'company_ac_number' => $request->company_ac_number,
            'company_ac_details' => $request->company_ac_details,
            'transaction_id' => $request->transaction_id,
            'status' => 'paid',
        ]);


        return redirect()->back()->with('success', 'Payment Paid Successfully');
    }

    public function areaControllerPaymentReport(Request $request)
    {
        $month = $request->month ?? 'All';
        $year = $request->year ?? 'All';

        $reports = AreaControllerPayment::month($month)
            ->year($year)
            ->get();

        return view('accountant.expenses.area-controller.payment-report', compact('reports'));
    }

    public function salaryHome(Request $request)
    {
        $query = Expense::totalSalaryExpense($request);

        $total = $query->total();
        $managerTotal = $query->managerTotal();
        $accountantTotal = $query->accountantTotal();
        $directorTotal = $query->directorTotal();
        $marketingManagerTotal = $query->marketingManagerTotal();
        $marketingPanelTotal = $query->marketingPanelControllerTotal();
        $othersTotal = $query->othersTotal();

        return view('accountant.expenses.salary.home', compact('total', 'managerTotal', 'accountantTotal', 'directorTotal', 'marketingManagerTotal', 'marketingPanelTotal', 'othersTotal'));
    }

    public function salaryNewStore(Request $request)
    {
//        dd($request->all());
        $request->validate([
            'date' => 'required',
            'month' => 'required',
            'amount' => 'required',
            'category' => 'required',
        ]);

        Salary::create([
            'date' => $request->date,
            'month' => $request->month,
            'amount' => $request->amount,
            'category' => $request->category,
            'note' => $request->note,
        ]);

        return redirect()->back()->with('success', 'Salary added successfully');
    }


    public function salaryReport(Request $request)
    {
        if($request->ajax())
        {
            $month = $request->month ?? 'All';
            $year = $request->year ?? 'All';
            $category = $request->category ?? 'All';
            $data = Salary::month($month)
                ->year($year)
                ->category($category)
                ->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('date', function ($data) {
                    return date('d-m-Y', strtotime($data->date));
                })
                ->editColumn('amount', function ($data) {
                    return number_format($data->amount, 2);
                })
                ->editColumn('category', function ($data) {
                    return ucfirst($data->category);
                })
                ->make(true);

        }
        return view('accountant.expenses.salary.salary-report');
    }

    public function othersHome(Request $request)
    {
        $total = Expense::totalOthersExpense($request);
        return view('accountant.expenses.others.home', compact('total'));
    }

    public function othersNewExpenseStore(Request $request)
    {
        $request->validate([
            'date' => 'required',
            'month' => 'required',
            'amount' => 'required',
        ]);

        OtherExpense::create([
            'date' => $request->date,
            'month' => $request->month,
            'amount' => $request->amount,
            'details' => $request->details,
            'user_id' => auth()->user()->id,
        ]);

        return redirect()->back()->with('success', 'Others Expense added successfully');
    }


    public function othersReport(Request $request)
    {
        if($request->ajax()){
            $month = $request->month ?? 'All';
            $year = $request->year ?? 'All';
            $data = OtherExpense::month($month)
                ->year($year)
                ->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('month', function ($data) {
                    return date("F", mktime(0, 0, 0, $data->month, 1));
                })
                ->editColumn('date', function ($data) {
                    return date('d-m-Y', strtotime($data->date));
                })
                ->editColumn('amount', function ($data) {
                    return number_format($data->amount, 2);
                })
                ->make(true);
        }
        return view('accountant.expenses.others.report');
    }

}
