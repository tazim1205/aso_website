<?php

namespace App\Http\Controllers\Worker;

use App\AdminAds;
use App\AdminNotice;
use App\CustomerGig;
use App\Http\Controllers\Controller;
use App\Job;

use App\MarketerTrainingVideos;
use App\MarketerHelplines;

use App\Faq;
use App\ServiceDetail;
use App\About;
use App\TermsAndCondition;
use App\PrivacyPolicy;
use App\ControllerAds;
use App\ControllerNotice;

use App\District;
use App\Upazila;
use App\Puroshova;
use App\Word;

use App\User;
use App\WorkerService;
use App\WorkerServiceCategory;
use Carbon\Carbon;
use CreateCustomerGigsTable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        

        $categories = WorkerServiceCategory::all();
        $adminNotice = AdminNotice::orderBy('id', 'desc')
            ->take(1)
            ->get();
        $adminAds = AdminAds::where('status', '1')
            ->whereDate('starting', '<', Carbon::today()->addDays(1))
            ->whereDate('ending', '>', Carbon::today()->addDays(-1))
            ->get();
            
        $user_id = Auth::user()->id;
        $controllerAds = ControllerAds::get();
            
        // return $user_id;

        $district = $request->input('district') ?? 'Áll';
        $upazila = $request->input('upazila') ?? 'Áll';

        $notices = ControllerNotice::orderBy('id', 'desc')
            ->district($district)
            ->upazila($upazila)
            ->active()
            ->get();
            
            /*
            $c_gigs =DB::table('customer_gigs')
                ->join('worker_and_services', function ($join) {
                    $join->on('customer_gigs.service_id', '=', 'worker_and_services.service_id')
                        ->where('worker_and_services.worker_id', '=', auth()->user()->id);
                })->get();
            dd($c_gigs);
            */
        return view('worker.home.index', compact('categories', 'adminNotice', 'adminAds','controllerAds','notices'));
    }


    /**
     * showJob
     */
    public function showJob($id){

        $customerGig = CustomerGig::find(Crypt::decryptString($id));
        return view('worker.home.show-job',compact('customerGig'));
    }

    /**
     * showServices
     */
    public function showServices($id){

        $category = WorkerServiceCategory::where('meta_tag',$id)->orwhere('id', $id)->first();
        $adminAds = AdminAds::where('status', '1')
            ->whereDate('starting', '<', Carbon::today()->addDays(1))
            ->whereDate('ending', '>', Carbon::today()->addDays(-1))
            ->get();
        return view('worker.home.show-service',compact('category','adminAds'));
    }

    public function showCustomerGigs($service_id){

        $service = WorkerService::where('meta_tag',$service_id)->orwhere('id', $service_id)->first();
        return view('worker.home.gigs',compact('service'));
    }


    // training video 

    public function trainingVideo()
    {
        $user_id = Auth::user();
        $allVideo = MarketerTrainingVideos::where('status',1)->where('video_for','Worker')->orderBy('id', 'desc')->get();
        return view('worker.others.training-video', compact('allVideo'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    // helpline

    public function helpline()
    {

        return view('worker.others.helpline');
    }

    public function filterHelpline($district,$upazila)
    {
        $helpline = DB::table('marketer_helplines')->where('district_id',$district)->where('upazila_id',$upazila)->get();
        foreach($helpline as $ads){
            echo '
            <div class="col-lg-4 col-12">
                <div class="card " style="border: 1px solid green;">
                    <div class="card-body text-center">
                        <div class="d-flex justify-content-between bd-highlight mb-2">
                            <div class="bd-highlight">'.$ads->phone.'</div>
                            <a class="bg-success p-1 text-light">Call Now</a>
                        </div>
                        <div class="d-flex justify-content-between bd-highlight">
                            <div class="bd-highlight">'.$ads->email.'</div>
                            <a class=" bg-success p-1 text-light">Email Now</a>
                        </div>
                    </div>
                </div>
            </div>';
        }
    }

    public function Faq()
    {   
        $customer_faq = Faq::where('faq_for','service provider')->get();
        return view('worker.others.faq', compact('customer_faq'));
    }

    public function serviceDetails()
    {   
        $customer_service = ServiceDetail::where('faq_for','service provider')->get();
        return view('worker.others.service-details', compact('customer_service'));
    }

    public function about()
    {   
        $about = About::orderByDesc('id')->first();
        return view('worker.others.about', compact('about'));
    }

    public function termsCondition()
    {   
        $customer_terms = TermsAndCondition::where('about_for', 'service provider')->orderByDesc('id')->first();
        return view('worker.others.terms-condition', compact('customer_terms'));
    }

    public function privacyPolicy()
    {   
        $customer_privacy = PrivacyPolicy::where('about_for', 'service provider')->orderByDesc('id')->first();
        return view('worker.others.privacy-policy', compact('customer_privacy'));
    }
    
    public function addWorker()
    {
        $districts = District::all();
        $categories= WorkerServiceCategory::all();
        return view('worker.others.add-worker', compact('districts', 'categories'));
    }

}
