<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\MembershipPackage;
use App\MembershipServiceProfile;
use Illuminate\Http\Request;
use App\WorkerServiceCategory;
use App\MembershipTrial;
use Illuminate\Support\Str;

class MembershipPackageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = WorkerServiceCategory::orderBy('id', 'desc')->get();
        $packages = MembershipPackage::all(); //orderBy('id', 'desc')->get()
        $trial_period = MembershipTrial::where('name', 'trial_period')->first();
        return view('admin.membership.index', compact('packages','categories', 'trial_period'));
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
    //   return  $request;
    
 
    
        $request->validate([
            'package_name' => 'required|string|unique:membership_packages,name' ,
            'position_number' => 'required|numeric|unique:membership_packages,position' ,
            'maximum_service' => 'required|numeric' ,
            'monthly_price' => 'required|numeric' ,
            'extendable_price' => 'required|numeric' , 
            'sub_categories' => 'required', 
            'is_available_phone_number' => 'required|boolean' ,
            'is_available_description' => 'required|boolean' ,
        ]);

 
        //Encode categories
        $sub_categoriesData = $request->sub_categories;
        // $categories = json_encode($categoriesData); 
        // dd($sub_categoriesData); 

        $sub_categories = "";
        foreach ($sub_categoriesData as $sub_categories) {
            $sub_categories = $sub_categories.",";
        }
        $sub_categories;
        
        $package = new MembershipPackage();
        $package->name =  $request->input('package_name');
        $package->monthly_price = $request->input('monthly_price');
        $package->extendable_price = $request->input('extendable_price');
        $package->sub_categories = $sub_categories;
        $package->mobile_availability = $request->input('is_available_phone_number');
        $package->description_availability = $request->input('is_available_description');
        $package->service_count = $request->input('maximum_service');
        $package->position = $request->input('position_number');
        $package->save();
        return $package;
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
        $request->validate([
            'package' => 'required|string|exists:membership_packages,id' ,
            'package_name' => 'required|string|unique:membership_packages,name,'.$request->input('package'),
            'position_number' => 'required|numeric|unique:membership_packages,position,'.$request->input('package'),
            'maximum_service' => 'required|numeric' ,
            'monthly_price' => 'required|numeric' ,
            'extendable_price' => 'required|numeric',
            'sub_categories' => 'required', 
            'is_available_phone_number' => 'required|boolean' ,
            'is_available_description' => 'required|boolean' ,
        ]);
        $package = MembershipPackage::find($request->input('package'));
        if (MembershipServiceProfile::where('position', $package->position)->count() > 0){
            MembershipServiceProfile::where('position', $package->position)->update(['position' => $request->input('position_number')]);
        }
         //Encode categories
        $sub_categoriesData = $request->sub_categories;
        // $categories = json_encode($categoriesData); 
        // dd($sub_categoriesData); 

        $sub_categories = "";
        foreach ($sub_categoriesData as $sub_categories) {
            $sub_categories = $sub_categories.",";
        }
        $sub_categories;

        $package->name =  $request->input('package_name');
        $package->monthly_price = $request->input('monthly_price');
        $package->extendable_price = $request->input('extendable_price');
        $package->sub_categories = $sub_categories;
        $package->mobile_availability = $request->input('is_available_phone_number');
        $package->description_availability = $request->input('is_available_description');
        $package->service_count = $request->input('maximum_service');
        $package->position = $request->input('position_number');
        $package->save();

        return $package;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $item_id = $request->item_id;
        // $item_name = MembershipPackage::find($item_id)->name;
        MembershipPackage::find($item_id)->delete();
    }

    function trial_update(Request $request){
        $request->validate([
            'trial_id' => 'required|int|exists:membership_trials,id' ,
            'trial_days' => 'required|numeric|max:30|min:1' ,
        ]);

        $trial_period = MembershipTrial::find($request->input('trial_id'));

        $trial_period->days = $request->input('trial_days');
        $trial_period->save();

        return $trial_period;
    }

    function categories(Request $request){
        $categories = WorkerServiceCategory::latest()->get();
        $services_id = Str::of(MembershipPackage::find($request->package_id)->sub_categories)->explode(',');

        return view('admin.membership.load-categories', compact('categories', 'services_id'));
    }
}
