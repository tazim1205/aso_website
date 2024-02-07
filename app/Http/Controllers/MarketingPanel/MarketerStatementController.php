<?php

namespace App\Http\Controllers\MarketingPanel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Yajra\DataTables\Facades\DataTables;
class MarketerStatementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return view('marketing_panel.marketer_statement.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $marketer = User::find($id);
        return view('marketing_panel.marketer_statement.details', compact('marketer'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function filter($district , $upazila){
        if ($district == 0 && $upazila == 0 ) {
            $data =User::where('role','marketer')->get();
        }else if ($district == 'All' && $upazila == 'All') {
            $data =User::where('role','marketer')->get();
        }elseif ($district >= 0 && $upazila == 0) {
            $data =User::where('role','marketer')->where('district_id', $district)->get();
        }elseif ($district == 0 && $upazila != 0) {
            $data =User::where('role','marketer')->where('upazila_id', $upazila)->get();
        }
        return DataTables::of($data)
            ->addColumn('income', function($data) {
                return $data->affiliate_user->balance;
            })
            ->addColumn('paid', function($data) {
                return $data->affiliate_user->paid_amount;
            })
            ->addColumn('pending', function($data) {
                return $data->affiliate_user->balance - $data->affiliate_user->paid_amount;
            })
            ->addColumn('Actions', function($data) {
                return '<a href="'.route('marketing_panel.marketer-statement.show', $data->id).'" class="btn btn-primary">
                           <i class="ft-eye"></i>
                           View
                        </a>';
//                return '<a href="" class="btn btn-success btn-sm">See </a>';
            })
            ->rawColumns(['income','paid','pending','Actions'])
            ->make(true);
    }
}
