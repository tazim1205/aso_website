<?php

namespace App\Http\Controllers\Accountant;

use App\Balance;
use App\Helpers\Accountant\Earning;
use App\Helpers\Accountant\Earnings;
use App\Helpers\Accountant\Helper;
use App\Http\Controllers\Controller;
use App\Membership;
use App\OthersIncome;
use App\Recharge;
use App\SpecialServiceOrder;
use App\User;
use App\WorkerBid;
use App\WorkerGig;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class EarningController extends Controller
{
    public function serviceProvider(Request $request)
    {
        $district = $request->district ?? 'All';
        $upazilla = $request->upazilla ?? 'All';
        $month = $request->month ?? 'All';
        $year = $request->year ?? 'All';

        $total = Earnings::totalEarningServiceProvider($request);
        $recharge = Recharge::district($district)
            ->upazila($upazilla)
            ->month($month)
            ->year($year)
            ->sum('amount');
        $bidIncome = WorkerBid::district($district)
            ->upazila($upazilla)
            ->month($month)
            ->year($year)
            ->sum('income');
        $gigIncome = WorkerGig::district($district)
            ->upazila($upazilla)
            ->month($month)
            ->year($year)
            ->sum('income');
        $remainBalance = User::worker()
            ->district($district)
            ->upazila($upazilla)
            ->month($month)
            ->year($year)
            ->sum('balances');
        return view('accountant.earnings.service-provider', compact('bidIncome', 'total', 'recharge', 'gigIncome', 'remainBalance'));
    }


    public function memberHome(Request $request)
    {
        $district = $request->district ?? 'All';
        $upazilla = $request->upazilla ?? 'All';
        $month = $request->month ?? 'All';
        $year = $request->year ?? 'All';

        $quantity = [
            'first_time' => Membership::firstTime()
                ->district($district)
                ->upazila($upazilla)
                ->month($month)
                ->year($year)
                ->count(),
            'renew' => Membership::renew()
                ->district($district)
                ->upazila($upazilla)
                ->month($month)
                ->year($year)
                ->count(),
            'upgrade' => Membership::upgraded()
                ->district($district)
                ->upazila($upazilla)
                ->month($month)
                ->year($year)
                ->count(),
        ];

        $total = Earnings::totalEarningByMemberShip($request);
        return view('accountant.earnings.member.home', compact('quantity', 'total'));
    }


    public function totalPaid(Request $request)
    {
        if ($request->ajax()){
            $district = $request->district ?? 'All';
            $upazilla = $request->upazilla ?? 'All';
            $month = $request->month ?? 'All';
            $year = $request->year ?? 'All';
            $data = Membership::with('user')
                ->district($district)
                ->upazila($upazilla)
                ->month($month)
                ->year($year)
                ->grouyByUser()
                ->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('user_id', function ($data) {
                    return $data->user->user_name;
                })
                ->editColumn('email', function ($data) {
                    return $data->user->email;
                })
                ->editColumn('phone', function ($data) {
                    return $data->user->phone;
                })
                ->make(true);
        }
        return view('accountant.earnings.member.total-paid');
    }


    public function paymentReport(Request  $request)
    {
        if($request->ajax()){
            $district = $request->district ?? 'All';
            $upazilla = $request->upazilla ?? 'All';
            $month = $request->month ?? 'All';
            $year = $request->year ?? 'All';
            $data = Membership::with(['user','membershipPackage'])
                ->district($district)
                ->upazila($upazilla)
                ->month($month)
                ->year($year)
                ->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('user_id', function ($data) {
                    return $data->user->user_name;
                })
                ->editColumn('package_name', function ($data) {
                    return $data->membershipPackage->name;
                })
                ->addColumn('via', function ($data) {
                    return $data->via;
                })
                ->addColumn('ac_number', function ($data) {
                    return $data->ac_number;
                })
                ->addColumn('ac_details', function ($data) {
                    return $data->ac_details;
                })
                ->editColumn('created_at', function ($data) {
                    return $data->created_at->format('d M Y');
                })
                ->make(true);
        }
        return view('accountant.earnings.member.payment-report');
    }


    public function serviceHome(Request $request)
    {
        $district = $request->district ?? 'All';
        $upazilla = $request->upazilla ?? 'All';
        $month = $request->month ?? 'All';
        $year = $request->year ?? 'All';
        $totalOrder = SpecialServiceOrder::district($district)
            ->upazila($upazilla)
            ->month($month)
            ->year($year)
            ->count();
        $totalPaid = Earnings::totalEarningsBySpecialOrder($request);
        return view('accountant.earnings.service.home', compact('totalOrder', 'totalPaid'));
    }

    public function serviceTotalPaid(Request $request)
    {
        if ($request->ajax()){
            $district = $request->district ?? 'All';
            $upazilla = $request->upazilla ?? 'All';
            $month = $request->month ?? 'All';
            $year = $request->year ?? 'All';
            $data = SpecialServiceOrder::with('service')
                ->district($district)
                ->upazila($upazilla)
                ->month($month)
                ->year($year)
                ->groupByCustomer()
                ->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('service', function ($data) {
                    return $data->service->name;
                })
                ->make(true);
        }
        return view('accountant.earnings.service.total-paid');
    }


    public function servicePaymentReport(Request $request)
    {
        if($request->ajax()){
            $district = $request->district ?? 'All';
            $upazilla = $request->upazilla ?? 'All';
            $month = $request->month ?? 'All';
            $year = $request->year ?? 'All';
            $data = SpecialServiceOrder::with('customer')
                ->district($district)
                ->upazila($upazilla)
                ->month($month)
                ->year($year)
                ->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('customer_id', function ($data) {
                    return $data->customer->user_name;
                })
                ->editColumn('created_at', function ($data) {
                    return $data->created_at->format('d M Y');
                })
                ->make(true);
        }
        return view('accountant.earnings.service.payment-report');
    }

    public function othersHome(Request $request)
    {
        $total = Earnings::totalEarningsByOthersService($request);
        return view('accountant.earnings.others.home', compact('total'));
    }

    public function othersReportPost(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'amount' => 'required|numeric',
            'description' => 'required|string',
        ]);
        OthersIncome::create([
            'date' => $request->date,
            'amount' => $request->amount,
            'description' => $request->description,
        ]);
        return redirect()->back()->with('success', 'Income added successfully');
    }

    public function othersReport(Request $request)
    {
        if($request->ajax()){
            $month = $request->month ?? 'All';
            $year = $request->year ?? 'All';
            $data = OthersIncome::month($month)
                ->year($year)
                ->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('date', function ($data) {
                    return $data->date;
                })
                ->make(true);
        }
        return view('accountant.earnings.others.report');
    }
}
