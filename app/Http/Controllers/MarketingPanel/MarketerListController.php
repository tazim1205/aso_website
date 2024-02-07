<?php

namespace App\Http\Controllers\MarketingPanel;

use App\District;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Yajra\DataTables\Facades\DataTables;
class MarketerListController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return view('marketing_panel.marketer_list.index');
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
        //
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


    /*
    *---------------Marketer Deactive
    */
    public function deactive(Request $request,$id){
        // dd($id);
        $user = User::find($id);
        $user->affiliate_user->status = 0;
        $user->affiliate_user->save();
        return back()->with('success','Marketer Deactivated Successfull');
    }


    /*
    *---------------Marketer Active
    */
    public function active(Request $request,$id){
        $user = User::find($id);
        $user->affiliate_user->status = 1;
        $user->affiliate_user->save();
        return back()->with('success','Marketer Activated Successfull');
    }


    /*
    *---------------Marketer Details
    */
    public function details($id){
        $user = User::where('id', $id)->where('role','marketer')->firstOrFail();
        $districts = District::all();
        $user = User::find($id);
        return view('marketing_panel.marketer_list.details',compact('user','districts'));
    }


    public function marketerProfileUpdate(Request $request){
        $request->validate([
            'full_name' => ['required', 'string', 'max:255'],
            'id' => ['required'],
            'user_name' => 'required|unique:users,user_name,'.$request->id,
            'phone' => 'required|unique:users,phone,'.$request->id,
            'password' => 'nullable|min:6',
            'gender' => 'required',
            'role' => 'required',
            'upazila_id' => 'required|integer',
        ]);


        $user = User::findOrFail($request->id);

        $user->full_name = $request->full_name;
        $user->user_name = $request->user_name;
        $user->phone = $request->phone;
        $user->gender = $request->gender;
        $user->role = $request->role;
        if($request->upazila_id){
            $user->upazila_id = $request->upazila_id;
        }
        if($request->password){
            $user->password = Hash::make($request->password);
        }
        try {
            $user->save();
            return response()->json([
                'type' => 'success',
                'message' => 'Successfully updated',
            ]);

        } catch (\Exception $exception) {
            return response()->json([
                'type' => 'error',
                'message' => 'Something going wrong' . $exception,
            ]);
        }
    }

    public function filter($district , $upazila, $month, $year){
        if ($district == 0 && $upazila == 0 && $month == 0 && $year == 0) {
            $data =User::where('role','marketer')->get();
        }else if ($district == 'All' && $upazila == 'All' && $month == 'All' && $year == 'All') {
            $data =User::where('role','marketer')->get();
        }elseif ($district >= 0 && $upazila == 0 && $month == 0 && $year == 0) {
            $data =User::where('role','marketer')->where('district_id', $district)->get();
        }elseif ($district == 0 && $upazila != 0 && $month == 0 && $year == 0) {
            $data =User::where('role','marketer')->where('upazila_id', $upazila)->get();
        }else if ($district == 0 && $upazila == 0 && $month != 0 && $year == 0) {
            $data =User::where('role','marketer')->whereMonth('created_at', '=', $month)->get();
        }else if ($district == 0 && $upazila == 0 && $month == 0 && $year != 0) {
            $data =User::where('role','marketer')->whereYear('created_at', '=', $year)->get();
        }
        return DataTables::of($data)
            ->addColumn('date', function($data) {
                $mydate = strtotime($data->created_at);
                $newformat = date('d-m-Y',$mydate);
                return $newformat;
            })
            ->addColumn('link', function($data) {
                if (!empty($data->affiliate_user->status) && $data->affiliate_user->status == 1){
                    return '<a href="'.route('marketing_panel.marketer.deactive',$data->id).'" id="deactive" title="Click To Deactive">
                                <div class="custom-control custom-switch">
                                      <input type="checkbox" class="custom-control-input" id="customSwitch1" checked="">

                                      <label class="custom-control-label" for="customSwitch1">Active</label>
                                 </div>
                             </a>';
                }else{
                    return '<a href="'.route('marketing_panel.marketer.active',$data->id).'" id="deactive" title="Click To Deactive">
                                <div class="custom-control custom-switch">
                                      <input type="checkbox" class="custom-control-input" id="customSwitch1">

                                      <label class="custom-control-label" for="customSwitch1">Deactivate</label>
                                 </div>
                             </a>';

                }
            })
            ->addColumn('Actions', function($data) {
                return '<a href="'. route('marketing_panel.marketer.details', $data->id) .'" class="btn btn-primary">
                           <i class="ft-eye"></i>
                           View
                        </a>';
            })
            ->rawColumns(['link','Actions'])
            ->make(true);
    }


}
