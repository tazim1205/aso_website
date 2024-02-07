<?php

namespace App\Http\Controllers\Worker\Membership;

use App\AdminAds;
use App\AdminNotice;
use App\Http\Controllers\Controller;
use App\MembershipPackage;
use App\WorkerServiceCategory;
use App\Membership;
use App\WorkerService;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Crypt;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // return 1;
        $packages = MembershipPackage::all();
        $adminAds = AdminAds::where('status', '1')
            ->whereDate('starting', '<', Carbon::today()->addDays(1))
            ->whereDate('ending', '>', Carbon::today()->addDays(-1))
            ->get();
        $adminNotice = AdminNotice::orderBy('id', 'desc')
            ->take(1)
            ->get();
        $categories = WorkerServiceCategory::orderBy('id', 'desc')->get();
        return view('worker.membership.home.index', compact('packages', 'adminAds', 'adminNotice', 'categories'));
    }


    public function PackageServices($id){
        $packages = MembershipPackage::findOrFail($id);
        $html = '';
        foreach(WorkerServiceCategory::all() as $category){
            $html .= '<optgroup label="'.$category->name.'">';
                        foreach($category->services as $service){
                            foreach (explode(',', $packages->sub_categories) as $service_id){
                                if ($service->id == $service_id){
                                    $html .='<option value="'.$service->id.'">'.$service->name.'</option>';
                                }
                            }
                        }
                    $html .=
                    '</optgroup>';
        }
        return json_encode($html);
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

    function categories(Request $request){
        $categories = WorkerServiceCategory::latest()->get();
        // $services_id = MembershipPackage::find($request->package_id)->sub_categories;
        $services_id = Str::of(MembershipPackage::find($request->package_id)->sub_categories)->explode(',');

        return view('worker.membership.home.load-categories', compact('categories', 'services_id'));
    }
    
    function viewcategories(Request $request){
        $categories = WorkerServiceCategory::latest()->get();
        $services_id = Str::of(MembershipPackage::find($request->package_id)->sub_categories)->explode(',');

        return view('worker.membership.home.view-categories', compact('categories', 'services_id'));
    }

    function amount(Request $request){
        if ($request->package_id) {
            $monthly_price = MembershipPackage::find($request->package_id)->monthly_price;
            if ($request->duration) {
                $monthly_with_month = $monthly_price * $request->duration;
                if ($request->sub_category_id) {
                    $category_count = count($request->sub_category_id) - 1;
                    $extendable_price = MembershipPackage::find($request->package_id)->extendable_price;

                    $total_category_price = ($extendable_price * $category_count) * $request->duration;
                    $total_price = $monthly_with_month + $total_category_price;

                    // echo "<span style='font-weight: bold'>Total Price: </span>".$total_category_price;
                    echo "<span style='font-weight: bold'>Total Price: </span>$total_price";
                }else {
                    echo "<small class='text-danger'>Please Select Service</small>";
                }
            }else {
                echo "<small class='text-danger'>Please Select Month</small>";
            }
        }else {
            echo "<small class='text-danger'>Package ID is Undefined</small>";
        }

    }

    function amountupdate(Request $request){
        $membership_id = Crypt::decryptString($request->membership_id);
        $duration = $request->duration;

        $monthly_price = MembershipPackage::find(Membership::find($membership_id)->membership_package_id )->monthly_price;

        $count = 0;

        foreach (Str::of(Membership::find($membership_id)->sub_categories)->explode(',') as $sub_categories) {
            if ($sub_categories) {
                $count++;
            }
        }

        $count = $count - 1;

        $service_count = count($request->services_id) - 1;

        $monthly_with_month = $monthly_price * ($duration);

        $extendable_price = MembershipPackage::find(Membership::find($membership_id)->membership_package_id)->extendable_price;
        // $total_service_price = ($extendable_price * $count) * ($duration - Membership::find($membership_id)->duration);
        
        if ($duration) {
            // if ($service_count > $count) {
                $extra_service = $service_count - $count;
                $count = $count + $extra_service;

                $total_service_price = ($extendable_price * $count) * ($duration);
                $total_price = $monthly_with_month + $total_service_price;
                echo "<span style='font-weight: bold'>Extended Price: </span>$total_price";
            // }
            // elseif ($service_count == $count) {
            //     // $count = $count;

            //     $total_service_price = ($extendable_price * $service_count) * ($duration);
            //     $total_price = $monthly_with_month + $total_service_price;
            //     echo "<span style='font-weight: bold'>Extended Price: </span>$total_price";
            // }else {
            //     echo "<small class='text-danger'>You can not reduce category item</small>";
            // }
        }
        elseif ($duration == Membership::find($membership_id)->duration) {
            if ($service_count > $count) {
                $extra_service = $service_count - $count;
                $count = $count + $extra_service;

                $total_service_price = ($extendable_price * $count);
                $total_price = $monthly_with_month + $total_service_price;
                echo "<span style='font-weight: bold'>Extended Price: </span>$total_price";
            }
            elseif ($service_count == $count) {
                // $count = $count;

                $total_service_price = ($extendable_price * $service_count) * ($duration);
                $total_price = $monthly_with_month + $total_service_price;
                echo "<span style='font-weight: bold'>Extended Price: </span>$total_price";
            }else {
                echo "<small class='text-danger'>You can not reduce category item</small>";
            }
        }
        else {
            echo "<small class='text-danger'>You can not downgrade the duration</small>";
        }
        
    }



    function amountchange(Request $request){
        // $membership_id = Crypt::decryptString($request->membership_id);
        $total_price = 0;
        
        $package = MembershipPackage::find($request->change_package_id);

        $duration = $request->duration ?? 0;
        $monthly_price = $package->monthly_price ?? 0;
        
        $extendable_price = $package->extendable_price ?? 0;

        $services_id = count($request->services_id) - 1;

        $total_price = ($monthly_price * $duration) + (($extendable_price * $services_id) * $duration);

        echo "<span style='font-weight: bold'>Extended Price: </span>$total_price"; 
        
    }

}
