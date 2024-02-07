<?php

namespace App\Http\Controllers\Controller;

use App\Http\Controllers\Controller;
use App\SpecialProfile;
use App\SpecialService;
use App\SpecialServiceOrder;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\DB;

class SpecialProfileController extends Controller
{
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $special_services = SpecialService::all();
        return view('controller.special-profile.index', compact('special_services'));
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
        $request->validate([
           'name' => 'required',
           'phone' => 'required',
           'description' => 'required',
           'image' => 'nullable|max:500',
        ]);

        $special_profile = new SpecialProfile();
        $special_profile->controller_id   = auth()->user()->id;
        $special_profile->upazila_id   = auth()->user()->upazila->id;
        $special_profile->name  = $request->input('name');
        $special_profile->phone = $request->input('phone');
        $special_profile->description   = $request->input('description');
        if($request->hasFile('image')){
            $image             = $request->file('image');
            $folder_path       = 'uploads/images/special/profile/';
            $image_new_name    = Str::random(8).'-special-profile-'.Carbon::now()->format('d-m-Y H-i-s') .'.'. $image->getClientOriginalExtension();
            //resize and save to server
            Image::make($image->getRealPath())->resize(500, 300, function($constraint){
                $constraint->aspectRatio();
            })->save($folder_path.$image_new_name);
            $special_profile->image    = $folder_path.$image_new_name;
        }
        $special_profile->save();
        return $special_profile;

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
    public function update(Request $request)
    {
        $id = $request->input('id');
        $request->validate([
           'name' => 'required',
           'phone' => 'required',
           'description' => 'required',
           'image' => 'nullable|max:500',
        ]);

        $special_profile = SpecialProfile::find($id);
        $special_profile->name  = $request->input('name');
        $special_profile->phone = $request->input('phone');
        $special_profile->description   = $request->input('description');
        if($request->hasFile('image')){
            $image             = $request->file('image');
            $folder_path       = 'uploads/images/special/profile/';
            $image_new_name    = Str::random(8).'-special-profile-'.Carbon::now()->format('d-m-Y H-i-s') .'.'. $image->getClientOriginalExtension();
            //resize and save to server
            Image::make($image->getRealPath())->resize(500, 300, function($constraint){
                $constraint->aspectRatio();
            })->save($folder_path.$image_new_name);
            $special_profile->image    = $folder_path.$image_new_name;
        }
        $special_profile->save();
        return $special_profile;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */

    public function destroy(Request $request)
    {
        $request->validate([
            'profile' => 'required|exists:special_profiles,id'
        ]);
        $special_profile = SpecialProfile::find($request->input('profile'));
        if ($special_profile->upazila_id == auth()->user()->upazila->id){
            try {
                $special_profile->delete();
                return response()->json([
                    'type' => 'success',
                    'message' => 'Successfully deleted.',
                ]);
            }catch (\Exception $exception){
                return response()->json([
                    'type' => 'danger',
                    'message' => 'Sorry we are unable for this action.',
                ]);
            }
        }else{
            return response()->json([
                'type' => 'danger',
                'message' => 'You have not permission to delete this special profile.',
            ]);
        }
        //
    }


    public function specialServiceOrder($status = "pending"){
        if($status == "pending"){
            $data = DB::table('special_service_orders')
                ->where('status',"pending")
                ->where('special_service_orders.upazila_id',auth()->user()->upazila_id)
                ->orderByDesc('id')
                ->get();
        }else if($status == "running"){
            $data = DB::table('special_service_orders')
            ->where('status',"running")
            ->where('special_service_orders.upazila_id',auth()->user()->upazila_id)
            ->orderByDesc('id')
            ->get();
        }else if($status == "complete"){
            $data = DB::table('special_service_orders')
            ->where('status',"complete")
            ->where('special_service_orders.upazila_id',auth()->user()->upazila_id)
            ->orderByDesc('id')
            ->get();
        }else if($status == "cancel"){
            $data = DB::table('special_service_orders')
            ->where('status',"cancel")
            ->where('special_service_orders.upazila_id',auth()->user()->upazila_id)
            ->orderByDesc('id')
            ->get();
        }
        return view('controller.special-profile.special-service-order',compact('data','status'));
    }

    public function specialOrderList(){
        $data = DB::table('special_service_orders')
                ->where('special_service_orders.upazila_id',auth()->user()->upazila_id)
                ->orderByDesc('id')
                ->get();

        return DataTables::of($data)
            ->addColumn('date', function($data) {
                $mydate = strtotime($data->created_at);
                $newformat = date('d-m-Y',$mydate);
                return $newformat;
            })
            ->addColumn('customer_name', function($data) {
                $customer = DB::table('users')->where('id',$data->customer_id)->first();
                return $customer->user_name;
            })
            ->addColumn('service', function($data) {
                $service = DB::table('special_profiles')->where('id',$data->service_id)->first();
                return $service->name;
            })
            ->addColumn('upazila', function($data) {
                $upazila = DB::table('upazilas')->where('id',$data->upazila_id)->first();
                return $upazila->name;
            })
            ->addColumn('status', function($data) {
                if (!empty($data->status) && $data->status == 1){
                    return '<span class="badge badge-success">Confirmed</span>';
                }else{
                    return '<span class="badge badge-danger">Pending</span>';
                }
            })
            ->addColumn('link', function($data) {
                if (!empty($data->status) && $data->status == 1){
                    return '<a href="'.route('controller.specialorder.deactive',$data->id).'" id="deactive" title="Click To Deactive" class="btn btn-lg btn-warning"> <i class="fa fa-toggle-on text-white"></i></a>';
                }else{
                    return '<a href="'.route('controller.specialorder.active',$data->id).'" id="active" title="Click To Active" class="btn btn-lg btn-danger"> <i class="fa fa-toggle-off text-white"></i></a>';
                }
            })
            ->addColumn('Actions', function($data) {
                return '<a href="" id="'.$data->id.'" class="seeBtn btn btn-success btn-sm">Details </a>';
            })
            ->rawColumns(['customer_name','service','status','link','Actions'])
            ->make(true);
    }

    public function cancel($id){
        // dd($id);
        $order = SpecialServiceOrder::find($id);
        $order->status = 'cancel';
        $order->save();
        return back()->with('success','Order Cancel');
    }


    /*
    *---------------Marketer Active
    */
    public function running($id){
        $order = SpecialServiceOrder::find($id);
        $order->status = 'running';
        $order->save();
        return back()->with('success','Order Confirmed');
    }
    public function pending($id){
        $order = SpecialServiceOrder::find($id);
        $order->status = 'pending';
        $order->save();
        return back()->with('success','Order Confirmed');
    }
    public function complete($id){
        $order = SpecialServiceOrder::find($id);
        $order->status = 'complete';
        $order->save();
        return back()->with('success','Order Confirmed');
    }


    public function details($id){
        $order = SpecialServiceOrder::where('id', $id)->firstOrFail();

        $mydate = strtotime($order->created_at);
        $newformat = date('d-m-Y',$mydate);

        $customer = DB::table('users')->where('id',$order->customer_id)->first();
        $service = DB::table('special_profiles')->where('id',$order->service_id)->first();
        $upazila = DB::table('upazilas')->where('id',$order->upazila_id)->first();
        $districts = DB::table('districts')->where('id',$customer->district_id)->first();
        $puroshovas = DB::table('puroshovas')->where('id',$customer->pouroshova_union_id)->first();
        $words = DB::table('words')->where('id',$customer->word_road_id)->first();

            echo '
            <div class="modal-header">
                <h5 class="modal-title" id="modal-title"><i class="fa fa-star"></i>'.$order->order_no.' </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-header">
                <i class="fa ">Price: ৳'.$order->fee.'</i>
                <i class="fa ">Date: '.$newformat.'</i> ';
                if (!empty($data->status) && $data->status == 1){
                echo '<span class="badge badge-success">Confirmed</span>';
                }else{
                    echo '<span class="badge badge-success">Pending</span>';
                }
            echo '
            </div>
            <div class="modal-header">
                <i class="fa fa-user"> '.$customer->user_name.'</i>
                <i class="fa ">Service: '.$service->name.'</i>
                <i class="fa ">Upazila: '.$upazila->name.'</i>
            </div>
            <div class="modal-header">
                <i class="fa "> '.$districts->name.'</i>
                <i class="fa ">'.$puroshovas->name.'</i>
                <i class="fa ">'.$words->name.'</i>
            </div>
            <div class="modal-body" id="modal-body">
                '.$order->description.'
                <a href="'.asset($order->image).'" data-fancybox="images">
                    <img src="'.asset($order->image).'" class="lightbox-thumb img-thumbnail">
                </a>
                <i class="fa ">Address: ৳'.$order->address.'</i>
            </div>
            <div class="modal-footer" id="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" ><i class="fa fa-times"></i> Close</button>
            </div>';

    }
}
