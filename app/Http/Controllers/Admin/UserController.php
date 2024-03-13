<?php

namespace App\Http\Controllers\Admin;

use App\District;
use App\Http\Controllers\Controller;
use App\SpecialProfile;
use App\SpecialService;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    public function administrativeIndex(){
        $districts = District::all();
        return view('admin.users.administrative-index',compact('districts'));
    }
    public function controllerIndex(){
        $districts = District::all();
        return view('admin.users.controller-index', compact('districts'));
    }
    public function workerIndex(){
        return view('admin.users.worker-index');
    }
    public function membershipIndex(){
        return view('admin.users.membership-index');
    }
    public function customerIndex(){
        return view('admin.users.customer-index');
    }
    public function specialIndex(){
        return view('admin.users.special-index');
    }
    public function userCreate(){
        $districts = District::all();
        return view('admin.users.create',compact('districts'));
    }
    public function userStore(Request $request){
        $request->validate([
            'full_name' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string', 'min:8'],

            'user_name' => 'required|unique:users,user_name',
            'phone' => 'required|unique:users,phone',
            'gender' => 'required',
            'role' => 'required',
        ]);

        $user = new User();
        $user->full_name = $request->full_name;
        $user->password = Hash::make($request->password);
        $user->user_name = $request->user_name;
        $user->phone = $request->phone;
        $user->gender = $request->gender;
        $user->role = $request->role;
        $user->status = $request->status;
        $user->upazila_id = $request->upazila_id;
        $user->district_id = $request->district_id;

        try {
            $user->save();
            return back()->withToastSuccess('Successfully created');

        } catch (\Exception $exception) {
            return back()->withErrors('Something went wrong '.$exception->getMessage());
        }
    }

    public function administrativeProfile($id){
        $user = User::where('id', $id)->where('role','admin')->firstOrFail();
        $districts = District::all();
        return view('admin.users.administrative-profile',compact('user','districts'));
    }
    public function controllerProfile ($id){
        $user = User::where('id', $id)->where('role','controller')->firstOrFail();
        $districts = District::all();
        return view('admin.users.controller-profile',compact('user','districts'));
    }
    public function workerProfile ($id){
        $user = User::where('id', $id)->where('role','worker')->firstOrFail();
        $districts = District::all();
        return view('admin.users.worker-profile',compact('user','districts'));
    }
    public function membershipProfile ($id){
        $user = User::where('id', $id)->where('role','membership')->firstOrFail();
        $districts = District::all();
        return view('admin.users.membership-profile',compact('user','districts'));
    }
    public function customerProfile ($id){
        $user = User::where('id', $id)->where('role','customer')->firstOrFail();
        $districts = District::all();
        return view('admin.users.customer-profile',compact('user','districts'));
    }
    public function specialProfile ($id){
        $user = SpecialProfile::findOrFail($id);
        $special_service = SpecialService::all();
        $districts = District::all();
        return view('admin.users.special-profile',compact('user','districts','special_service'));
    }
    public function userProfileUpdate(Request $request){
        $request->validate([
            'full_name' => ['required', 'string', 'max:255'],
            'id' => ['required'],
            'user_name' => 'required|unique:users,user_name,'.$request->id,
            'phone' => 'required|unique:users,phone,'.$request->id,
            'password' => 'nullable|min:6',
            'gender' => 'required',
            'upazila_id' => 'integer',
        ]);


        $user = User::findOrFail($request->id);

        $user->full_name = $request->full_name;
        $user->user_name = $request->user_name;
        $user->phone = $request->phone;
        $user->email = $request->email;
        $user->gender = $request->gender;
        $user->role = $request->role;
        if($request->upazila_id){
            $user->upazila_id = $request->upazila_id;
        }
        if($request->district_id){
            $user->district_id = $request->district_id;
        }
        if($request->password){
            $user->password = Hash::make($request->password);
        }
        try {
            $user->save();
            return redirect()->back()->with('success','Successfully updated');

        } catch (\Exception $exception) {
            return response()->json([
                'type' => 'error',
                'message' => 'Something going wrong' . $exception,
            ]);
        }
    }

    public function specialProfileUpdate(Request $request){
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'id' => 'required',
            'phone' => 'required',
            'is_free' => 'required',
            'special_service_id' => 'required',
            'upazila_id' => 'required|integer',
        ]);


        $user = SpecialProfile::findOrFail($request->id);

        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->is_free = $request->is_free;
        $user->special_service_id = $request->special_service_id;

        if($request->upazila_id){
            $user->upazila_id = $request->upazila_id;
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
    public function administrativeIndexAjax(){
        $data =User::where('role', 'admin')->get();
        return DataTables::of($data)
            ->addcolumn('status',function($data){
                if($data->status == '1')
                {
                    $status = 'Active';
                    $class = 'btn btn-sm btn-success';
                }
                else
                {
                    $status = 'Inactive';
                    $class = 'btn btn-sm btn-danger';
                }
                return '<div class="btn-group">
                <a href="'.route('admin.users.status',$data->id).'" class="'.$class.'">'.$status.'</a></div>';
            })
            ->addColumn('Actions', function($data) {
                return '<div class="btn-group"><a
                href="#"
                type="button"
                class="btn btn-success btn-sm editbtn"
                data-id="'.$data->id.'"
                data-name="'.$data->full_name.'"
                data-username="'.$data->user_name.'"
                data-role="'.$data->role.'"
                data-phone="'.$data->phone.'"
                data-email = "'.$data->email.'"
                data-gender = "'.$data->gender.'"
                data-dist = "'.$data->district_id.'"
                data-upazila = "'.$data->upazila_id.'"
                data-toggle="modal"
                data-target="#exampleModal"
                ><i class="fa fa-edit"></i> </a>
                <form action="'.route('admin.users.destroy',$data->id ).'" method="post">
                '.@csrf_field().'
                <button onclick="return Sure()" type="submit" class="btn btn-danger">'.__('<i class="fa fa-trash"></i>').'</button>
                </form>
                </div>';
            })
            ->rawColumns(['Actions','status'])
            ->make(true);
    }
    public function controllerIndexAjax(){
        $data =User::where('role', 'controller')->get();
        return DataTables::of($data)
            ->editColumn('upazila_id', function ($data) {
                return $data->upazila->name ?? '';
            })

            ->editColumn('district_id', function ($data) {
                return $data->district->name ?? '';
            })
            ->editColumn('status',function($data){
                if($data->status == '1')
                {
                    $status = 'Active';
                    $class = 'btn btn-sm btn-success';
                }
                else
                {
                    $status = 'Inactive';
                    $class = 'btn btn-sm btn-danger';
                }
                return '<div class="btn-group">
                <a href="'.route('admin.users.status',$data->id).'" class="'.$class.'">'.$status.'</a></div>';
            })
            ->addColumn('Actions', function($data) {
                return '<div class="btn-group">
                <a
                href="#"
                type="button"
                class="btn btn-success btn-sm editbtn"
                data-id="'.$data->id.'"
                data-name="'.$data->full_name.'"
                data-username="'.$data->user_name.'"
                data-role="'.$data->role.'"
                data-phone="'.$data->phone.'"
                data-email = "'.$data->email.'"
                data-gender = "'.$data->gender.'"
                data-dist = "'.$data->district_id.'"
                data-upazila = "'.$data->upazila_id.'"
                data-toggle="modal"
                data-target="#exampleModal"
                ><i class="fa fa-edit"></i> </a>
                <form action="'.route('admin.users.destroy',$data->id ).'" method="post">
                '.@csrf_field().'
                <button onclick="return Sure()" type="submit" class="btn btn-danger">'.__('<i class="fa fa-trash"></i>').'</button>
                </form>
                </div>';

            })
            ->rawColumns(['Actions','status'])
            ->make(true);
    }
    public function workerIndexAjax(){
        $data =User::where('role', 'worker')->get();
        return DataTables::of($data)
            ->addColumn('Actions', function($data) {
                return '<a href="'. route('admin.worker.profile', $data->id) .'" type="button" class="btn btn-success btn-sm" data-id="'.$data->id.'"><i class="fa fa-edit"></i> </a>';
            })
            ->rawColumns(['Actions'])
            ->make(true);
    }

    public function membershipIndexAjax(){
        $data =User::where('role', 'membership')->get();
        return DataTables::of($data)
            ->addColumn('Actions', function($data) {
                return '<a href="'. route('admin.membership.profile', $data->id) .'" type="button" class="btn btn-success btn-sm" data-id="'.$data->id.'"><i class="fa fa-edit"></i> </a>';
            })
            ->rawColumns(['Actions'])
            ->make(true);
    }

    public function customerIndexAjax(){
        $data =User::where('role', 'customer')->get();
        return DataTables::of($data)
            ->addColumn('Actions', function($data) {
                return '<a href="'. route('admin.customer.profile', $data->id) .'" type="button" class="btn btn-success btn-sm" data-id="'.$data->id.'"><i class="fa fa-edit"></i> </a>';
            })
            ->rawColumns(['Actions'])
            ->make(true);
    }

    public function specialIndexAjax(){
        $data =SpecialProfile::all();
        return DataTables::of($data)
            ->addColumn('Actions', function($data) {
                return '<a href="'. route('admin.special.profile', $data->id) .'" type="button" class="btn btn-success btn-sm" data-id="'.$data->id.'"><i class="fa fa-edit"></i> </a>';
            })
            ->rawColumns(['Actions'])
            ->make(true);
    }
    
    public function destroy(string $id)
    {
        $delete = User::find($id)->delete();

        return redirect()->back()->with('success');
    }

    public function restore($id){
        User::where('id',$id)->withTrashed()->restore();

        return redirect()->back()->with('success');
    }

    public function deletedListIndex($id)
    {
        User::where('id',$id)->withTrashed()->forceDelete();

        return redirect()->back()->with('success');
    }

    public function status($id)
    {
        $check = User::find($id);

       if($check->status == 1)
       {
            User::find($id)->update(['status'=>0]);
       }
       else
       {
            User::find($id)->update(['status'=>1]);
       }

       return redirect()->back()->with('success');
    }
}